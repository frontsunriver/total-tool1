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

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use app\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "form_data".
 *
 * @property integer $id
 * @property integer $form_id
 * @property string $builder
 * @property string $fields
 * @property string $html
 * @property integer $height
 * @property string $version
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Form $form
 */
class FormData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_data}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id', 'height'], 'required'],
            [['form_id', 'height', 'created_at', 'updated_at'], 'integer'],
            [['builder','fields','html', 'version'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'form_id' => Yii::t('app', 'Form ID'),
            'builder' => Yii::t('app', 'Form Builder'),
            'fields' => Yii::t('app', 'Form Fields'),
            'html' => Yii::t('app', 'Form Html'),
            'height' => Yii::t('app', 'Height'),
            'version' => Yii::t('app', 'Version'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->version = Yii::$app->version;
        }

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

    /**
     * Get Form Name
     *
     * @return mixed|string|null
     */
    public function getFormName()
    {
        $builder = Json::decode($this->builder, true);

        return isset($builder['settings']['name']) ? $builder['settings']['name'] : null;
    }

    /**
     * Set Form Name
     *
     * @param $name
     */
    public function setFormName($name)
    {
        $builder = Json::decode($this->builder, true);
        if (isset($builder['settings']['name'])) {
            $builder['settings']['name'] = $name;
            $this->builder = Json::htmlEncode($builder);
        }
    }

    /**
     * Return Form Styles
     *
     * @return array
     * @throws \Exception
     */
    public function getStyles()
    {
        $builder = Json::decode($this->builder, true);
        return ArrayHelper::getValue($builder, 'styles');
    }

    /**
     * Return the label of a field
     *
     * Used only inside this model
     *
     * @param array $field Item saved in fields attribute
     * @param bool|false $withAlias Used to append an alias to identify the field
     * @param bool|false $isGroup Used by radio and checkbox components
     * @param bool|false $isMatrix Used by radio components
     * @return string
     */
    private function getFieldLabel($field, $withAlias = false, $isGroup = false, $isMatrix = false)
    {
        if ($isMatrix) {
            if (isset($field['data-matrix-label'], $field['data-matrix-question'], $field['data-matrix-answer'])) {
                if (isset($field['groupLabel'])) {
                    $label = $field['data-matrix-label'] . " > " . $field['data-matrix-question'];
                } else {
                    $label = $field['data-matrix-label'] . " > " . $field['data-matrix-question'] . " > " . $field['data-matrix-answer'];
                }
            } else {
                $label = Yii::t('app', 'Matrix of') . " " . $field['data-matrix-id'];
            }
        } elseif ($isGroup) {
            if (isset($field['data-matrix-label'], $field['data-matrix-question'])) {
                // For matrix fields, replace label by answer
                $label = $field['data-matrix-label'] . " > " . $field['data-matrix-question'];
            } else if (isset($field['groupLabel'])) {
                $label = $field['groupLabel'];
            } else {
                $label = Yii::t('app', 'Group of') . " " . $field['name'];
            }
        } else {
            if (isset($field['label']) && !empty($field['label'])) {
                $label = $field['label'];
            } elseif (isset($field['data-label']) && !empty($field['data-label'])) {
                $label = $field['data-label'];
            } elseif (isset($field['type'], $field['value']) && in_array($field['type'], ['button'])) {
                // For buttons, replace label by value
                $label = $field['value'];
            } elseif (isset($field['data-matrix-label'], $field['data-matrix-question'], $field['data-matrix-answer'])) {
                // For matrix fields, replace label by answer
                $label = $field['data-matrix-label'] . " > " . $field['data-matrix-question'] . " > " . $field['data-matrix-answer'];
            } else {
                $label = Yii::t('app', 'Field with ID') . ": " . $field['id'];
                $withAlias = true;
            }
        }

        // Append 'alias'
        if ($withAlias && isset($field['alias']) && !empty($field['alias'])) {
            $label .= ' (' . $field['alias'] . ')';
        }

        return $label;
    }

    /**
     * Return the type of a field
     *
     * Used only inside this model
     *
     * @param $field
     * @return string|null
     */
    public function getFieldType($field)
    {
        $type = null;

        if (substr($field['name'], 0, 16) === 'hidden_signature') {
            $type = 'signature';
        } else if (!empty($field['name'])) {
            $parts = explode('_', $field['name']);
            $type = !empty($parts[0]) ? $parts[0] : null;
        }

        return $type;
    }

    /**
     * Get Name and Label of Provided Fields
     * Format: [name => label]
     *
     * @param array $fields
     * @param bool $withAlias
     * @return array
     */
    public function getNameAndLabelOfProvidedFields($fields = array(), $withAlias = false)
    {
        if (empty($fields)) {
            return $fields;
        }

        $options = array();

        foreach ($fields as $field) {

            // For Checkboxes and Radio Buttons
            // We take the name and label of the group
            if (isset($field['type']) && ( $field['type'] === "checkbox" || $field['type'] === "radio")) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'name' => $field['name'],
                    'label' => $this->getFieldLabel($field, $withAlias, true), // Get groupLabel,
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            // Default
            $option = [
                'name' => $field['id'],
                'label' => $this->getFieldLabel($field, $withAlias, false),
            ];
            $options[$option['name']] = $option;
        }

        return array_values($options); // Remove keys
    }

    /**
     * Return Fields in rule variables format.
     * Required for rule builder
     *
     * Note: Radios are grouped by its name and buttons are excluded
     *
     * @param bool $withForm
     * @param bool $withAlias
     * @return array
     */
    public function getRuleVariables($withForm = true, $withAlias = true)
    {
        $allFields = Json::decode($this->fields, true);

        // Exclude submit/image/reset buttons.
        $fields = ArrayHelper::exclude($allFields, ['submit', 'reset', 'image'], 'type');
        // Radios
        $radioFields = ArrayHelper::filter($fields, 'radio', 'type');
        // Group Radios by name
        $radioGroups = ArrayHelper::group($radioFields, 'name');

        $variables = array();

        foreach ($fields as $field) {

            // For Radio Buttons
            // We take the name and label of the group
            // and options item save the value of each radio
            if (isset($field['type']) && $field['type'] === "radio") {

                // Check if the radio group was saved in variables before
                if (isset($field['name']) && isset($variables[$field['name']])) {
                    continue;
                }

                // Get all radios with the same name
                $radios = isset($radioGroups[$field['name']]) ? $radioGroups[$field['name']] : null;

                // Get first radio
                $firstRadio = ArrayHelper::first($radios);

                // Set variable attributes
                $variable = [
                    'name' => $firstRadio['name'],
                    'label' => $this->getFieldLabel($firstRadio, $withAlias, true), // Get groupLabel
                    'fieldType' => 'radio',
                ];

                // Get each radio value, and add to options
                $options = [];
                foreach ($radios as $radio) {
                    $option = [
                        "value" => $radio['value'],
                        "label" => $this->getFieldLabel($radio, $withAlias, false),
                    ];
                    array_push($options, $option);
                }

                if (count($options) > 0) {
                    $variable['options'] = $options;
                }

                // Save the variable, by the name of the radio group
                $variables[$variable['name']] = $variable;

                continue; // Skip the rest of the current loop iteration
            } elseif (isset($field['type']) && $field['type'] === "hidden") {
                // Check if the hidden field stores a signature
                if (!empty($field['name']) && substr($field['name'], 0, 16) === "hidden_signature") {
                    $field['type'] = "signature";
                }
            }

            $variable = [
                'name' => $field['id'], // Because multiple checkbox may have the same name
                'label' => $this->getFieldLabel($field, $withAlias, false),
                'fieldType' => isset($field['type']) ? $field['type'] : $field['tagName'],
            ];

            $options = [];

            if (isset($field['options'])) { // Select List has options
                foreach ($field['options'] as $option) {
                    $option = [
                        "value" => isset($option['value']) ? $option['value'] : "",
                        "label" => isset($option['label']) ? $option['label'] : "",
                    ];
                    array_push($options, $option);
                }
            }

            if (count($options) > 0) {
                $variable['options'] = $options;
            }

            $variables[$variable['name']] = $variable;
        }

        if ($withForm) {
            // Add Form to variables
            $form = [
                'name' => "form",
                'label' => Yii::t('app', "This form"),
                'fieldType' => "form",
            ];

            $variables[$form['name']] = $form;
        }

        return array_values($variables); // Remove keys
    }

    /**
     * Return Fields in rule actions format.
     * Required for rule builder
     *
     * Note: Radios and Checkboxes are grouped by groupLabel and name
     *
     * @param bool $withAlias
     * @return array
     */
    public function getRuleFields($withAlias = true)
    {
        $fields = Json::decode($this->fields, true);

        $options = array();

        foreach ($fields as $field) {

            // For Matrix Fields
            if (!empty($field['data-matrix-id'])) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'name' => !empty($field['data-matrix-id']) ? $field['data-matrix-id'] : $field['name'],
                    'label' => !empty($field['data-matrix-label']) ? $field['data-matrix-label'] : $field['label'],
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            // For Checkboxes and Radio Buttons
            // We take the name and label of the group
            if (isset($field['type']) && ($field['type'] === "checkbox" || $field['type'] === "radio")) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'name' => $field['name'],
                    'label' => $this->getFieldLabel($field, $withAlias, true), // Get groupLabel,
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            $option = [
                'name' => $field['id'],
                'label' => $this->getFieldLabel($field, $withAlias, false),
            ];

            // For buttons, replace label by value
            if (isset($field['type']) && in_array($field['type'], ['submit', 'reset', 'image', 'button'])) {
                $option['label'] = isset($field['value']) ? $field['value'] : $field['id'];
            }

            $options[$option['name']] = $option;
        }

        return array_values($options); // Remove keys
    }

    /**
     * Return Form Steps in rule actions format.
     * Required for rule builder
     *
     * @return array
     */
    public function getRuleSteps()
    {
        $builder = Json::decode($this->builder, true);
        $steps = $builder['settings']['formSteps']['fields']['steps']['value'];

        $options = array();

        if (count($steps) > 1) {
            foreach ($steps as $index => $title) {
                $option = [
                    'name' => $index,
                    'label' => $title,
                ];
                $options[$option['name']] = $option;
            }
        } else {
            $option = [
                'name' => 0,
                'label' => Yii::t('app', 'Same Step'),
            ];
            $options[$option['name']] = $option;
        }

        return $options;
    }

    /**
     * Return field ids as simple array.
     * Required by rules engine
     *
     * @return array List of all input ids
     */
    public function getFieldIds()
    {
        $fields = Json::decode($this->fields, true);
        $fieldIDs = ArrayHelper::column($fields, 'id', 'id');
        return array_values($fieldIDs); // Only simple array
    }

    /**
     * Return All Fields, except buttons.
     * @return array
     */
    public function getFields()
    {
        $fields = Json::decode($this->fields, true);
        return ArrayHelper::exclude($fields, ['submit', 'reset', 'image'], 'type');
    }

    /**
     * Return All Fields, except buttons.
     * Verifies that each field has a valid label
     *
     * Used by DataValidator
     * @return array
     */
    public function getFieldsForValidation()
    {
        // Required Fields
        $allFields = $this->getFields();
        $fields = [];
        foreach ($allFields as $field) {
            if (!isset($field['label'])) {
                $field['label'] = isset($field['data-label']) && !empty($field['data-label']) ? $field['data-label'] : Yii::t('app', 'the input value');
            }
            if (isset($field['type']) && ($field['type'] == "checkbox" || $field['type'] == "radio") &&
                !isset($field['groupLabel'])) {
                $field['groupLabel'] = Yii::t('app', 'the input value');
            }
            array_push($fields, $field);
        }

        return $fields;
    }

    /**
     * Return required fields.
     *
     * Used by this model
     *
     * @return array
     */
    public function getRequiredFields()
    {
        // Required Fields
        $requiredFields = ArrayHelper::filter($this->getFields(), true, 'required');
        $fields = [];
        foreach ($requiredFields as $field) {
            if (!isset($field['label'])) {
                $field['label'] = isset($field['data-label']) && !empty($field['data-label']) ? $field['data-label'] : Yii::t('app', 'the input value');
            }
            if (isset($field['type']) && ($field['type'] == "checkbox" || $field['type'] == "radio") &&
                !isset($field['groupLabel'])) {
                $field['groupLabel'] = Yii::t('app', 'the input value');
            }
            array_push($fields, $field);
        }

        return $fields;
    }

    /**
     * Return unique fields.
     *
     * Used by DataValidator
     *
     * @return array
     */
    public function getUniqueFields()
    {
        // Unique Fields
        return ArrayHelper::filter($this->getFields(), true, 'data-unique');
    }

    /**
     * Return All Fields, except files and buttons.
     * @return array
     */
    public function getFieldsWithoutFilesAndButtons()
    {
        $fields = Json::decode($this->fields, true);
        return ArrayHelper::exclude($fields, ['submit', 'reset', 'image', 'file'], 'type');
    }

    /**
     * Return Fields without disabled attribute, Exclude buttons.
     * @return array
     */
    public function getEnabledFields()
    {
        return ArrayHelper::exclude($this->getFields(), true, 'disabled');
    }

    /**
     * Return File Fields.
     * Format: [name=>label]
     *
     * Used by Submissions App and AppController
     * @return array
     */
    public function getFileFields()
    {
        return ArrayHelper::filter($this->getFields(), 'file', 'type');
    }

    /**
     * Return fields for API
     * Exclude button fields
     *
     * @param bool $withAlias
     * @param bool $withFiles
     * @param bool $withDisabledFields
     * @return array
     */
    public function getFieldsForApi($withAlias = false, $withFiles = false, $withDisabledFields = false)
    {
        // All fields except buttons
        $fields = $this->getFields();
        // Exclude file fields
        if (!$withFiles) {
            $fields = ArrayHelper::exclude($fields, ['file'], 'type');
        }
        // Exclude disabled fields
        if (!$withDisabledFields) {
            $fields = ArrayHelper::exclude($fields, true, 'disabled');
        }

        $options = array();

        foreach ($fields as $field) {

            // For Matrix Fields
            if (!empty($field['data-matrix-id'])) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'type' => $this->getFieldType($field),
                    'name' => !empty($field['name']) ? $field['name'] : null,
                    'alias' => !empty($field['alias']) ? $field['alias'] : null,
                    'label' => $this->getFieldLabel($field, $withAlias, false, true),
                    'answer' => null,
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            // For Checkboxes and Radio Buttons
            // We take the name and label of the group
            if (isset($field['type']) && ($field['type'] === "checkbox" || $field['type'] === "radio")) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'type' => $this->getFieldType($field),
                    'name' => !empty($field['name']) ? $field['name'] : null,
                    'alias' => !empty($field['alias']) ? $field['alias'] : null,
                    'label' => $this->getFieldLabel($field, $withAlias, true), // Get groupLabel,
                    'answer' => null,
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            // Default
            $option = [
                'type' => $this->getFieldType($field),
                'name' => !empty($field['name']) ? $field['name'] : null,
                'alias' => !empty($field['alias']) ? $field['alias'] : null,
                'label' => $this->getFieldLabel($field, $withAlias, false),
                'answer' => null,
            ];

            $options[$option['name']] = $option;
        }

        return array_values($options); // Remove keys
    }

    /**
     * Return fields for Submissions App
     * Exclude file and button fields
     *
     * @param bool $withAlias
     * @param bool $withFiles
     * @return array
     */
    public function getFieldsForSubmissions($withAlias = false, $withFiles = false)
    {
        // All fields except buttons
        $fields = $this->getFields();
        // Exclude file fields
        if (!$withFiles) {
            $fields = ArrayHelper::exclude($fields, ['file'], 'type');
        }
        // Exclude disabled fields
        $fields = ArrayHelper::exclude($fields, true, 'disabled');

        $options = array();

        foreach ($fields as $field) {

            // For Matrix Fields
            if (!empty($field['data-matrix-id'])) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'name' => $field['name'],
                    'label' => $this->getFieldLabel($field, $withAlias, false, true),
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            // For Checkboxes and Radio Buttons
            // We take the name and label of the group
            if (isset($field['type']) && ($field['type'] === "checkbox" || $field['type'] === "radio")) {

                // Check if the field was saved in options before
                if (isset($field['name']) && isset($options[$field['name']])) {
                    continue;
                }

                // Set option attributes
                $option = [
                    'name' => $field['name'],
                    'label' => $this->getFieldLabel($field, $withAlias, true), // Get groupLabel,
                ];

                // Save the option, by the name of the field
                $options[$option['name']] = $option;

                continue; // Skip the rest of the current loop iteration

            }

            // Default
            $option = [
                'name' => $field['id'],
                'label' => $this->getFieldLabel($field, $withAlias, false),
            ];

            $options[$option['name']] = $option;
        }

        return array_values($options); // Remove keys
    }

    /**
     * Return an array of field names and labels
     *
     * Used by SubmissionEventHandler and AppController
     * To prepare the submission data for replacement token
     * That's why the alias feature is disabled by default
     *
     * @param bool $withAlias
     * @param bool $withFiles
     * @return array
     */
    public function getFieldsForEmail($withAlias = false, $withFiles = true)
    {
        $submissionFields = $this->getFieldsForSubmissions($withAlias, $withFiles);
        return ArrayHelper::map($submissionFields, 'name', 'label');
    }

    /**
     * Return All fields labels (name and label as assoc array).
     * Format: [name=>label]
     * In checkbox & radio elements: Replace by [name=>groupLabel]
     *
     * Used by FormController and Form Report view
     *
     * @param bool $withAlias Append alias to label when it's available
     * @return array
     */
    public function getLabels($withAlias = false)
    {
        // Name and Label of Provided Fields
        $fields = $this->getNameAndLabelOfProvidedFields($this->getFields(), $withAlias);
        return ArrayHelper::map($fields, 'name', 'label');
    }

    /**
     * Return labels of required fields (name and label as assoc array).
     * Format: [name=>label]
     * In checkbox & radio elements: Replace by [name=>groupLabel]
     *
     * Used by DataValidator
     *
     * @return array
     */
    public function getRequiredLabels()
    {
        // Required Fields
        $requiredFields = $this->getNameAndLabelOfProvidedFields($this->getRequiredFields());
        return ArrayHelper::column($requiredFields, 'label', 'name');
    }

    /**
     * Return All labels except of files and buttons. (name and label as assoc array).
     * Format: [name=>label]
     * In checkbox & radio elements: Replace by [name=>groupLabel]
     *
     * Used by FormController for export submissions as CSV file
     * @return array
     */
    public function getLabelsWithoutFilesAndButtons()
    {
        // Fields without files and buttons
        $fields = $this->getFieldsWithoutFilesAndButtons();
        // Get its Labels
        $allLabels = ArrayHelper::column($fields, 'label', 'name');
        // Get Checkboxes & Radio Buttons Labels
        $checboxAndRadioLabels = ArrayHelper::column($fields, 'groupLabel', 'name');
        // Replace with Checkboxes & Radio Buttons labels
        $labels = array_merge($allLabels, $checboxAndRadioLabels);
        return $labels;
    }

    /**
     * Return Emails Fields.
     * Format: [name=>label]
     *
     * Used by FormSettings view
     *
     * @param bool $withAlias
     * @return array
     */
    public function getEmailLabels($withAlias = true)
    {
        $emailFields = ArrayHelper::filter($this->getFields(), 'email', 'type');
        $labels = array();
        foreach ($emailFields as $field) {
            $labels[$field['name']] = $this->getFieldLabel($field, $withAlias);
        }
        return $labels;
    }

    /**
     * Return File Field Labels.
     * Format: [name=>label]
     *
     * Used by Submissions App and AppController
     * @return array
     */
    public function getFileLabels()
    {
        $fileFields = $this->getFileFields();
        return ArrayHelper::column($fileFields, 'label', 'name');
    }

    /**
     * Return Required File Labels.
     * Format: [name=>label]
     *
     * Used by DataValidator
     *
     * @return array
     */
    public function getRequiredFileLabels()
    {
        $fileFields = ArrayHelper::filter($this->getFields(), 'file', 'type');
        $requiredFileFields = ArrayHelper::filter($fileFields, true, 'required');
        return ArrayHelper::column($requiredFileFields, 'label', 'name');
    }

    /**
     * Return Values of all options of all Select List of the form.
     * Format: [value1, value2, ...]
     *
     * Used by DataValidator
     *
     * @return array
     */
    public function getOptionValues()
    {
        $selects = ArrayHelper::filter($this->getFields(), 'select', 'tagName');
        $options = [];
        foreach ($selects as $select) {
            if (isset($select['options'])) {
                foreach ($select['options'] as $option) {
                    array_push($options, $option);
                }
            }
        }
        return array_values(ArrayHelper::column($options, 'value', 'value'));
    }

    /**
     * Return Values of all checkboxes of the form.
     * Format: [value1, value2, ...]
     *
     * Used by DataValidator
     *
     * @return array
     */
    public function getCheckboxValues()
    {
        $radios = ArrayHelper::filter($this->getFields(), 'checkbox', 'type');
        return array_values(ArrayHelper::column($radios, 'value', 'id'));
    }

    /**
     * Return Values of all radio buttons of the form.
     * Format: [value1, value2, ...]
     *
     * Used by DataValidator
     *
     * @return array
     */
    public function getRadioValues()
    {
        $radios = ArrayHelper::filter($this->getFields(), 'radio', 'type');
        return array_values(ArrayHelper::column($radios, 'value', 'id'));
    }

    /**
     * Return ID of the first recaptcha component
     *
     * Used by Form model
     *
     * @return null|string
     */
    public function getRecaptchaFieldID()
    {
        // Filter reCaptcha components
        $builder = Json::decode($this->builder, true);
        $recaptchaComponent = ArrayHelper::filter($builder['initForm'], 'recaptcha', 'name');
        // Get the first value of the array
        $component = array_shift($recaptchaComponent);
        return isset($component) && isset($component['fields'])
        && isset($component['fields']['id'])
        && ($component['fields']['id']['value']) ? $component['fields']['id']['value'] : null;
    }

    /**
     * Return Radio Button Fields.
     * Format: [id=>value]
     *
     * Used by FormEventHandler
     * @return array
     */
    public function getRadioFields()
    {
        // Filter radio components
        $radios = ArrayHelper::filter($this->getFields(), 'radio', 'type');

        return ArrayHelper::column($radios, 'value', 'id');
    }

    /**
     * Return Select List Fields.
     * Format: [id=>value]
     *
     * Used by FormEventHandler
     * @return array
     */
    public function getSelectListFields()
    {
        $selects = ArrayHelper::filter($this->getFields(), 'select', 'tagName');
        $options = [];
        foreach ($selects as $select) {
            if (isset($select['options'])) {
                $i = 0;
                foreach ($select['options'] as $option) {
                    // Add field ID to each option
                    $option['id'] = $select['id'] . '_' . $i++;
                    array_push($options, $option);
                }
            }
        }
        return ArrayHelper::column($options, 'value', 'id');
    }

    /**
     * Return Field IDs by container CSS class
     * Format: [id, id]
     *
     * Used by DataValidator
     * @param $cssClass
     * @return array
     */
    public function getFieldsByContainerClass($cssClass = '')
    {
        $fields = [];
        if (is_string($cssClass) && !empty($cssClass)) {
            $builder = Json::decode($this->builder, true);
            foreach ($builder['initForm'] as $field) {
                if (isset($field['fields']['containerClass']['value'])) {
                    $containerClass = $field['fields']['containerClass']['value'];
                    if (count(array_filter(explode('.', $cssClass))) === count(array_intersect(array_filter(explode(' ', $containerClass)), array_filter(explode('.', $cssClass))))) {
                        if (isset($field['fields']['id']['value'])) {
                            array_push($fields, $field['fields']['id']['value']);
                        }
                    }
                }
            }
        }
        return $fields;
    }

    /**
     * Get Field Information by input name
     *
     * Use by DataValidator
     * @param $fieldName
     * @return array
     */
    public function getFieldByName($fieldName) {
        $fields = Json::decode($this->fields, true);
        $field = ArrayHelper::filter($fields, $fieldName, 'name');
        return $field;
    }


    /**
     * Return All fields aliases (name and alias as assoc array).
     * Format: [name=>alias]
     *
     * Use by WebHooks Add-On
     * @return array
     */
    public function getAlias()
    {
        // Fields
        $fields = $this->getFields();
        // Alias
        $alias = ArrayHelper::column($fields, 'alias', 'name');
        return $alias;
    }

}
