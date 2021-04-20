<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\validators;

use Yii;
use app\components\validators\FileValidator;
use app\models\FormData;
use app\models\FormSubmission;
use app\models\FormRule;
use yii\web\UploadedFile;
use yii\validators\RequiredValidator;
use yii\validators\RegularExpressionValidator;
use yii\validators\UrlValidator;
use yii\validators\DateValidator;
use yii\validators\StringValidator;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use app\components\rules\RuleEngine;
use app\components\rules\Finder;
use app\helpers\Pager;
use app\helpers\Html;

/**
 * Class DataValidator
 * @package app\components\validators
 */
class DataValidator
{

    /*
     * Protected properties
     */

    // Arrays
    /** @var array */
    protected $data;                // FormSubmission Model Data property
    /** @var null|FormData @ */
    protected $dataModel;           // FormData Model
    protected $submissionModel;     // FormSubmission Model
    protected $fields;              // All Fields
    protected $radioValues;         // All Radio Buttons Values
    protected $optionValues;        // All Option Values
    protected $checkboxValues;      // All Checkboxes Values
    protected $requiredLabels;      // Labels of Required Fields
    protected $uniqueFields;        // All Unique Fields
    protected $requiredFileLabels;  // All Required File Labels
    protected $rules;               // FormRule Models
    protected $files;               // $_FILES local copy

    /*
     * Private properties
     */
    private $errors;

    /**
     * @param FormSubmission $submissionModel
     * @throws \Exception
     */
    public function __construct(FormSubmission $submissionModel)
    {

        if (!isset($submissionModel->form_id) || !is_array($submissionModel->data)) {
            throw new \Exception(Yii::t("app", "DataValidator needs the Form ID and Data attributes."));
        }

        $this->submissionModel = $submissionModel;
        $this->data = $submissionModel->data;
        $this->files = $_FILES;
        $this->dataModel = $submissionModel->form->formData;
        $this->fields = $this->dataModel->getFieldsForValidation();
        $this->uniqueFields = $this->dataModel->getUniqueFields();
        $this->requiredFileLabels = $this->dataModel->getRequiredFileLabels();
        $this->requiredLabels = $this->dataModel->getRequiredLabels();
        $this->checkboxValues = $this->dataModel->getCheckboxValues();
        $this->radioValues = $this->dataModel->getRadioValues();
        $this->optionValues = $this->dataModel->getOptionValues();

        $formRuleModels = FormRule::findAll(['form_id' => $submissionModel->form_id, 'status' => FormRule::STATUS_ACTIVE]);
        /** @var $rules array Conditions and Actions of active rules */
        $this->rules = [];

        foreach ($formRuleModels as $formRuleModel) {
            $rule = [
                'conditions' => json_decode($formRuleModel['conditions']),
                'actions' => json_decode($formRuleModel['actions']),
                'opposite' => (boolean) $formRuleModel['opposite'],
            ];
            array_push($this->rules, $rule);
        }

    }

    /**
     * Validates a data array.
     */
    public function validate()
    {

        // Unique Fields Validation
        $this->uniqueFieldsValidation();
        // Required Fields Validation
        $this->requiredFieldsValidation();
        // Validation by input types
        $this->fieldTypeValidation();

    }

    /**
     *
     */
    public function uniqueFieldsValidation()
    {

        $message = Yii::t('app', '{attribute} "{value}" has already been taken.');

        foreach ($this->uniqueFields as $field) {
            // Only when the input value is defined and is not empty
            if (isset($field["name"], $this->data[$field["name"]]) &&
                (trim($this->data[$field["name"]]) !== "")) {

                // Strip whitespace from the beginning and end of a string
                $value = trim($this->data[$field["name"]]);

                // Get label
                $label = Yii::t('app', 'the input value');
                if (isset($field["label"])) {
                    $label = $field["label"];
                } elseif (isset($field["data-label"])) {
                    $label = $field["data-label"];
                }

                // Search "fieldName":"fieldValue"
                $query = FormSubmission::find()
                    ->where('form_id=:form_id', [':form_id' => $this->dataModel->form_id])
                    ->andWhere(['like','data','"'.$field["name"].'":"'.$value.'"']);

                if (!empty($this->submissionModel->id)) {
                    $query->andWhere('id=:id', [':id' => $this->submissionModel->id]);
                }

                if ($query->count() > 0) {
                    /** @var \app\models\FormSubmission $submission */
                    $submission = $query->one();
                    // Only when we are not updating the form submission
                    if ($this->submissionModel->id !== $submission->id) {
                        $this->addError($field["name"], $label, $value, $message);
                    }
                }
            }
        }
    }

    /**
     * The required validation works in 3 steps:
     * 1. Get all required fields that are not in the submission (data and files). If there are, at least one,
     *    the validation fail.
     * 2. Get all required files. If a required file if not in the global $_FILES, the validation fail.
     * 3. Get all required fields that pass the last steps, and validates them with a RequiredValidator.
     */
    public function requiredFieldsValidation()
    {
        $conditionsAdapter = [];
        foreach ($this->data as $fieldName => $fieldValue) {
            $componentInfo = explode("_", $fieldName);
            $componentType = $componentInfo[0];
            if ($componentType === "checkbox") {
                // Replace Checkbox name by Checkbox ID
                $checkboxGroup = $this->dataModel->getFieldByName($fieldName);
                foreach ($checkboxGroup as $checkbox) {
                    // Field Value is the array of checked checkboxes
                    foreach ($fieldValue as $value) {
                        // Only add a checkbox if it's checked
                        if ($checkbox['value'] === $value) {
                            // Add Field ID instead of Field Name
                            $conditionsAdapter[$checkbox['id']] = $checkbox['value'];
                        }
                    }
                }
            } else {
                $conditionsAdapter[$fieldName] = $fieldValue;
            }
        }
        $actionsAdapter = [
            'toShow' => function($data) {
            },
            'toHide' => function($data) {
                /**
                 * No validate a required field when it is hidden by a conditional rule
                 */
                /** @var Finder $data */
                if ($data->find("target") == "field") {
                    $field = $data->find(["target", "targetField"]);
                    // Update required fields
                    if (isset($this->requiredLabels[$field])) unset($this->requiredLabels[$field]);
                    if (isset($this->requiredFileLabels[$field])) unset($this->requiredFileLabels[$field]);
                } elseif ($data->find("target") == "element") {
                    $element = $data->find(["target", "targetElement"]);
                    $fields = $this->dataModel->getFieldsByContainerClass($element);
                    foreach ($fields as $field) {
                        // Update required fields
                        if (isset($this->requiredLabels[$field])) unset($this->requiredLabels[$field]);
                        if (isset($this->requiredFileLabels[$field])) unset($this->requiredFileLabels[$field]);
                    }
                }
            },
            'toEnable' => function($data) {
            },
            'toDisable' => function($data) {
            },
            'performArithmeticOperations' => function($data) {
            },
            'resetResult' => function($data) {
            },
            'copy' => function ($data) {
            },
            'skip' => function ($data) {
                /**
                 * Only validate a required field if it's present in the current page
                 */
                // Get the Paginated Form
                $pager = new Pager(Html::decode($this->dataModel->html));
                // Get Fields from previous pages except the current one
                $nextPage = isset($this->data['current_page']) ? $this->data['current_page'] + 1 : 0;
                /** @var Finder $data */
                $fields = Html::getFields(implode($pager->getPreviousPages($data->find("step"), $nextPage)));
                // Update required fields
                foreach ($fields as $field) {
                    if (isset($this->requiredLabels[$field])) unset($this->requiredLabels[$field]);
                    if (isset($this->requiredFileLabels[$field])) unset($this->requiredFileLabels[$field]);
                }
            },
            'resetSkip' => function ($data) {
            },
            'formatNumber' => function ($data) {
            },
            'formatText' => function ($data) {
            }
        ];

        $oppositeAdapter = [
            'toShow' => "toHide",
            'toHide' => "toShow",
            'toEnable' => "toDisable",
            'toDisable' => "toEnable",
            'performArithmeticOperations' => "resetResult",
            'skip' => "resetSkip"
        ];

        /**
         * Rule Engine
         * Executes each conditional rule
         */
        foreach ($this->rules as $rule) {
            $engine = new RuleEngine($rule);
            $engine->run($conditionsAdapter, $actionsAdapter, $oppositeAdapter);
        }

        // Messages
        $requiredMessage = Yii::t('yii', '{attribute} cannot be blank.');

        // Compares requiredLabels keys against data and files keys, and returns the difference
        // All requiredLabel that are not in the submission data and file uploads
        $requiredFields = array_diff_key($this->requiredLabels, $this->data, $this->files);

        // If exist a requiredField, add a required error
        // Useful to validate if a least one checkbox of a group is checked
        if (count($requiredFields) > 0) {
            foreach ($requiredFields as $name => $label) {
                $this->addError($name, $label, '', $requiredMessage);
            }
        }

        // Check all required File Inputs with $_FILES
        // Exclude of step by step validation
        if (Yii::$app->controller->action->id !== "check") {
            foreach ($this->requiredFileLabels as $name => $label) {
                if (!is_array($this->files) || !isset($this->files[$name]) ||
                    !isset($this->files[$name]['name']) || empty($this->files[$name]['name'])) {
                    // If no file was upload
                    $this->addError($name, $label, '', $requiredMessage);
                }
            }
        }

        // Get all submission data, that were not in the last validations
        $data = array_diff_key($this->data, $requiredFields, $this->requiredFileLabels);
        // Filter required data
        $requiredData = array_intersect_key($data, $this->requiredLabels);
        // Check each fields item with requiredValidator
        $requiredValidator = new RequiredValidator();
        // If a field does'nt pass the validator, add a blank error
        if (count($requiredData) > 0) {
            foreach ($requiredData as $name => $value) {
                $value = is_array($value) ? implode(',', $value) : $value;
                if (!$requiredValidator->validate($value, $error)) {
                    $this->addError($name, $this->requiredLabels[$name], '', $error);
                }
            }
        }

    }

    public function fieldTypeValidation()
    {

        // Messages
        $invalidMessage = "the input value has a not valid value.";

        // Validation by Input Type

        foreach ($this->fields as $field) {
            foreach ($field as $key => $value) {
                // Text
                if ($key === "type" && $value === "text") {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // A minlength or maxlength can be used
                        if (isset($field["minlength"]) || isset($field["maxlength"])) {
                            $config = [];
                            // Add Min Length
                            if (isset($field["minlength"])) {
                                $config['min'] = $field["minlength"];
                            }
                            // Add Max Length
                            if (isset($field["maxlength"])) {
                                $config['max'] = $field["maxlength"];
                            }
                            $stringValidator = new StringValidator($config);
                            if (!$stringValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                        // A pattern can be used
                        if (isset($field["pattern"])) {
                            $regexValidator = new RegularExpressionValidator([
                                'pattern' => '/' . $field["pattern"] . '/' // Add regex delimiters
                            ]);
                            if (!$regexValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                    }
                }
                // TextArea
                if ($key === "tagName" && $value === "textarea") {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // A minlength or maxlength can be used
                        if (isset($field["minlength"]) || isset($field["maxlength"])) {
                            $config = [];
                            // Add Min Length
                            if (isset($field["minlength"])) {
                                $config['min'] = $field["minlength"];
                            }
                            // Add Max Length
                            if (isset($field["maxlength"])) {
                                $config['max'] = $field["maxlength"];
                            }
                            $stringValidator = new StringValidator($config);
                            if (!$stringValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                    }
                }
                // Tel
                if ($key === "type" && $value === "tel") {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // A minlength or maxlength can be used
                        if (isset($field["minlength"]) || isset($field["maxlength"])) {
                            $config = [];
                            // Add Min Length
                            if (isset($field["maxlength"])) {
                                $config['min'] = $field["minlength"];
                            }
                            // Add Max Length
                            if (isset($field["maxlength"])) {
                                $config['max'] = $field["maxlength"];
                            }
                            $stringValidator = new StringValidator($config);
                            if (!$stringValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                        // A pattern can be used
                        if (isset($field["pattern"])) {
                            $regexValidator = new RegularExpressionValidator([
                                'pattern' => '/' . $field["pattern"] . '/' // Add regex delimiters
                            ]);
                            if (!$regexValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        } else {
                            // By default, the number must be a international phone number
                            $phoneValidator = new PhoneValidator();
                            if (!$phoneValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error );
                            }
                        }
                    }
                }
                // Url
                if ($key === "type" && $value === "url") {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // A minlength or maxlength can be used
                        if (isset($field["minlength"]) || isset($field["maxlength"])) {
                            $config = [];
                            // Add Min Length
                            if (isset($field["maxlength"])) {
                                $config['min'] = $field["minlength"];
                            }
                            // Add Max Length
                            if (isset($field["maxlength"])) {
                                $config['max'] = $field["maxlength"];
                            }
                            $stringValidator = new StringValidator($config);
                            if (!$stringValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                        // Config validator
                        $config = [];
                        // A pattern can be used
                        if (isset($field["pattern"])) {
                            $config['pattern'] = '/' . $field["pattern"] . '/'; // Add regex delimiters
                        }
                        $urlValidator = new UrlValidator($config);
                        if (!$urlValidator->validate($this->data[$field["name"]], $error)) {
                            $this->addError($field["name"], $field["label"], '', $error);
                        }
                    }
                }
                // Color
                if ($key === "type" && $value === "color") {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // hex color invalid
                        if (!preg_match('/^#[a-f0-9]{6}$/i', $this->data[$field["name"]])) {
                            $this->addError($field["name"], $field["label"], '', $invalidMessage .' '.
                                Yii::t("app", "It must be a hexadecimal color string (e.g. '#FFFFFF')."));
                        }
                    }
                }
                // Password
                if ($key === "type" && $value === "password") {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // A minlength or maxlength can be used
                        if (isset($field["minlength"]) || isset($field["maxlength"])) {
                            $config = [];
                            // Add Min Length
                            if (isset($field["maxlength"])) {
                                $config['min'] = $field["minlength"];
                            }
                            // Add Max Length
                            if (isset($field["maxlength"])) {
                                $config['max'] = $field["maxlength"];
                            }
                            $stringValidator = new StringValidator($config);
                            if (!$stringValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                        // A pattern can be used
                        if (isset($field["pattern"])) {
                            $regexValidator = new RegularExpressionValidator([
                                'pattern' => '/' . $field["pattern"] . '/' // Add regex delimiters
                            ]);
                            if (!$regexValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }
                    }
                }
                // Email
                if ($key === "type" && $value === "email") {

                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {
                        // A minlength or maxlength can be used
                        if (isset($field["minlength"]) || isset($field["maxlength"])) {
                            $config = [];
                            // Add Min Length
                            if (isset($field["maxlength"])) {
                                $config['min'] = $field["minlength"];
                            }
                            // Add Max Length
                            if (isset($field["maxlength"])) {
                                $config['max'] = $field["maxlength"];
                            }
                            $stringValidator = new StringValidator($config);
                            if (!$stringValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                        }

                        // Config email validator
                        $config = [];

                        // A pattern can be used
                        if (isset($field["pattern"])) {
                            $config['pattern'] = '/' . $field["pattern"] . '/'; // Add regex delimiters
                        }

                        // Whether to check if email's domain exists and has either an A or MX record.
                        // Be aware that this check can fail due temporary DNS problems
                        // even if the email address is valid and an email would be deliverable
                        if (isset($field["data-check-dns"])) {
                            $config['checkDNS'] = true;
                        }

                        // Validate multiple emails separated by commas
                        if (isset($field["multiple"])) {
                            // Removes spaces
                            $emails = str_replace(" ", "", $this->data[$field["name"]]);
                            // Array of emails
                            $emails = explode(",", $emails);
                            if (count($emails) > 1) {
                                $config['message'] = Yii::t('app', '{attribute} has a invalid email format: Please use a comma to separate multiple email addresses.');
                            }
                            // Validate only one email address
                            $emailValidator = new EmailValidator($config);
                            foreach ($emails as $email) {
                                if (!$emailValidator->validate($email, $error)) {
                                    $this->addError($field["name"], $field["label"], '', $error);
                                }
                            }
                        } else {
                            // Validate only one email address
                            $emailValidator = new EmailValidator($config);

                            if (!$emailValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }

                        }
                    }
                }
                // Radio
                if ($key === "type" && $value === "radio") {
                    // Only when the input value is defined and not empty
                    if (isset($field["name"], $this->data[$field["name"]]) && !empty($this->data[$field["name"]])) {
                        // If no values or if the received data does not match with the form data
                        if (empty($this->radioValues) || !in_array($this->data[$field["name"]], $this->radioValues)) {
                            $this->addError($field["name"], $field["groupLabel"], '', $invalidMessage);
                        }
                    }
                }
                // Checkbox
                if ($key === "type" && $value === "checkbox") {
                    // Only when the input value is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) && !empty($this->data[$field["name"]])) {
                        // If no values or if the received data does not match with the form data
                        foreach ($this->data[$field["name"]] as $labelChecked) {
                            if (empty($this->checkboxValues) || !in_array($labelChecked, $this->checkboxValues)) {
                                $this->addError($field["name"], $field["groupLabel"], '', $invalidMessage);
                            }
                        }
                    }
                }
                // Select List
                if ($key === "tagName" && $value === "select") {
                    // Only when the input value is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) && is_array($this->data[$field["name"]]) && !empty($this->data[$field["name"]])) {
                        // If no labels or if the received data does not match with the form data
                        foreach ($this->data[$field["name"]] as $optionSelected) {
                            if (empty($this->optionValues) || !in_array($optionSelected, $this->optionValues)) {
                                $this->addError($field["name"], $field["label"], '', $invalidMessage);
                            }
                        }
                    }
                }
                // Number & Range
                if (($key === "type" && $value === "number") || ($key === "type" && $value === "range")) {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {

                        // Config number validator
                        $config = [];
                        // Min Number Validation (Minimum value required)
                        if (isset($field["min"])) {
                            $config['min'] = $field["min"];
                        }

                        // Max Number Validation (Maximum value required)
                        if (isset($field["max"])) {
                            $config['max'] = $field["max"];
                        }

                        // Only Integer Validation (Whether the attribute value can only be an integer)
                        if (isset($field["data-integer-only"])) {
                            $config['integerOnly'] = true;
                        }

                        // Pattern to Validate only Integer Numbers (The regular expression for matching integers)
                        if (isset($field["data-integer-pattern"])) {
                            $config['integerPattern'] = $field["data-integer-pattern"];
                        }

                        // Default Pattern to validate the numbers. Can be overwritten by a data number pattern
                        if (isset($field["pattern"])) {
                            $config['numberPattern'] = $field["pattern"];
                        }

                        // Pattern to Validate the Number (The regular expression for matching numbers)
                        if (isset($field["data-number-pattern"])) {
                            $config['numberPattern'] = $field["data-number-pattern"];
                        }

                        $numberValidator = new NumberValidator($config);

                        if (!$numberValidator->validate($this->data[$field["name"]], $error)) {
                            $this->addError($field["name"], $field["label"], '', $error);
                        }
                    }
                }
                // Date & DateTime & Time & Month & Week
                if (($key === "type" && $value === "date") || ($key === "type" && $value === "datetime-local") ||
                    ($key === "type" && $value === "time") || ($key === "type" && $value === "month") ||
                    ($key === "type" && $value === "week") ) {
                    // Only when the input value is defined and is not empty
                    if (isset($field["name"], $this->data[$field["name"]]) &&
                        (trim($this->data[$field["name"]]) !== "")) {

                        // DateValidator Configuration array
                        $config = [];

                        // Date Format by default
                        $format = "Y-m-d";
                        // Change Format
                        if ($value === "datetime-local") {
                            // DateTime Format
                            $format = "Y-m-d\TH:i"; // "Y-m-d H:i";
                        } elseif ($value === "time") {
                            // Time Format
                            $format = "i:s";
                        } elseif ($value === "month") {
                            // Month Format
                            $format = "Y-m";
                        } elseif ($value === "week") {
                            // First, validate by regular expression
                            $regexValidator = new RegularExpressionValidator([
                                'pattern' =>"/\d{4}-W\d{2}/"
                            ]);
                            if (!$regexValidator->validate($this->data[$field["name"]], $error)) {
                                $this->addError($field["name"], $field["label"], '', $error);
                            }
                            // Next, convert to date, to dateValidator (min / max)
                            if (isset($field["min"])) {
                                $config['tooSmall'] = Yii::t("app", "{attribute} must be no less than {weekMin}.", [
                                    'weekMin' => $field["min"],
                                ]);
                                $field["min"] = date("Y-m-d", strtotime($field["min"]));
                            }
                            if (isset($field["max"])) {
                                $config['tooBig'] = Yii::t("app", "{attribute} must be no greater than {weekMax}.", [
                                    'weekMax' => $field["max"],
                                ]);
                                $field["max"] = date("Y-m-d", strtotime($field["max"]));
                            }
                            $this->data[$field["name"]] = date("Y-m-d", strtotime($this->data[$field["name"]]));
                        }

                        // Add PHP format
                        $config['format'] = "php:".$format;

                        // Add Min Date Validation (The value must be later than this option)
                        if (isset($field["min"])) {
                            $config['min'] = $field["min"];
                        }

                        // Add Max Date Validation (The value must be earlier than this option)
                        if (isset($field["max"])) {
                            $config['max'] = $field["max"];
                        }

                        $dateValidator = new DateValidator($config);

                        if (!$dateValidator->validate($this->data[$field["name"]], $error)) {
                            $this->addError($field["name"], $field["label"], '', $error);
                        }
                    }
                }
                // File
                if ($key === "type" && $value === "file") {
                    // Only when the $_FILES name value is not empty
                    if (isset($field["name"], $this->files[$field["name"]], $this->files[$field["name"]]['name']) &&
                        !empty($this->files[$field["name"]]['name'])) {

                        // Config FileValidator
                        $config = [];

                        // File type validation
                        // Note that you should enable fileinfo PHP extension.
                        if (isset($field["accept"]) && extension_loaded('fileinfo')) {
                            // Removes dots
                            $extensions = str_replace(".", "", $field["accept"]);
                            // Removes spaces
                            $extensions = str_replace(" ", "", $extensions);
                            $config['extensions'] = explode(",", $extensions);
                            // All file name extensions are allowed
                            $config['extensions'] = empty($extensions) ? null : $config['extensions'];
                        }

                        // File Min Size validation
                        if (isset($field["data-min-size"])) {
                            // Removes dots
                            $config['minSize'] = (int) $field["data-min-size"];
                        }

                        // File Max Size validation
                        if (isset($field["data-max-size"])) {
                            // Removes dots
                            $config['maxSize'] = (int) $field["data-max-size"];
                        }

                        // Min Files validation
                        if (isset($field["data-min-files"])) {
                            // Removes dots
                            $config['minFiles'] = (int) $field["data-min-files"];
                        }

                        // Max Files validation
                        if (isset($field["data-max-files"])) {
                            // Removes dots
                            $config['maxFiles'] = (int) $field["data-max-files"];
                        }

                        $file = UploadedFile::getInstancesByName($field["name"]);

                        $fileValidator = new FileValidator($config);

                        if (!$fileValidator->validate($file, $error)) {
                            $this->addError($field["name"], $field["label"], '', $error);
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns a value indicating is there are any validation error.
     * @param string|null $attribute attribute name. Use null to check all attributes.
     * @return boolean is there are any error.
     */
    public function hasErrors($attribute = null)
    {
        return $attribute === null ? !empty($this->errors) : isset($this->errors[$attribute]);
    }

    /**
     * Returns errors for all attribute or single attribute.
     * @param string $attribute attribute name. Use null to retrieve errors for all attributes.
     * @property array An array of errors for all attributes. Empty array is returned if no error.
     * The result is a two-dimensional array. See [[getErrors()]] for detailed description.
     * @return array errors for all attributes or the specified attribute. Empty array is returned if no error.
     * Note that when returning errors for all attributes, the result is a two-dimensional array, like the following:
     *
     * ~~~
     * [
     *     'inputtext-0' => [
     *         'Username is required.',
     *         'Username must contain only word characters.',
     *     ],
     *     'inputtext-1' => [
     *         'Email address is invalid.',
     *     ]
     * ]
     * ~~~
     *
     */
    public function getErrors($attribute = null)
    {
        if ($attribute === null) {
            return $this->errors === null ? [] : $this->getUniqueErrors();
        } else {
            return isset($this->errors[$attribute]) ? $this->errors[$attribute] : [];
        }
    }

    /**
     * Adds a new error to the specified attribute.
     *
     * @param $attribute
     * @param string $label
     * @param string $value
     * @param string $error
     */
    public function addError($attribute, $label = '', $value = '', $error = '')
    {
        if (!empty($label) && !empty($value)) {
            $this->errors[$attribute][] = Yii::t('yii', $error, [
                'attribute' => $label,
                'value' => $value,
            ]);
        } else {
            $errorMessage = str_replace(Yii::t('yii', 'the input value'), $label, $error);
            $errorMessage = str_replace('{attribute}', $label, $errorMessage);
            $this->errors[$attribute][] = $errorMessage;
        }
    }

    public function getUniqueErrors()
    {
        $errors = [];
        foreach ($this->errors as $key => $value) {
            $errors[$key] = array_unique($value);
        }
        return $errors;
    }
}
