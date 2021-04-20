<?php

use app\bundles\WysiwygBundle;
use app\components\widgets\ConditionsBuilder;
use app\helpers\Html;
use app\helpers\Language;
use Carbon\Carbon;
use dosamigos\selectize\SelectizeDropDownList;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form \kartik\form\ActiveForm */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */
/* @var $formConfirmationModel app\models\FormConfirmation */
/* @var $formEmailModel app\models\FormEmail */
/* @var $formUIModel app\models\FormUI */
/* @var $formConfirmationRuleModel app\models\FormConfirmationRule */
/* @var $rules app\models\FormConfirmationRule[] */
/* @var $themes array [id => name] of theme models */
/* @var $users array [id => name] of user models */
/* @var $formUsers array [id => name] of user models with access to form model */

WysiwygBundle::register($this);

$this->title = $formModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $formModel->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Settings');

/*
 * Data For From
 * If email fields, add to emails data for fill from field (of Form Email)
 */

// Emails of the application
$adminEmail = Yii::$app->settings->get("app.adminEmail");
$supportEmail = Yii::$app->settings->get("app.supportEmail");
$noreplyEmail = Yii::$app->settings->get("app.noreplyEmail");

// Emails to show in the form
$emails = array(
    '' => '', // Allow empty value to display placeholder
    Yii::t('app', 'Emails') => [
        $adminEmail => $adminEmail,
        $supportEmail => $supportEmail,
        $noreplyEmail => $noreplyEmail,
    ]
);

// Email fields of the form
$emailLabels = $formDataModel->getEmailLabels();

$emailFields = array(
    Yii::t('app', 'Email Fields') => $emailLabels,
);

// If the form has email fields, add to config form
if (sizeof($emailLabels) > 0) {
    $emails = array_merge($emails, $emailFields);
}

// Default user limit type
if (empty($formModel->user_limit_type)) {
    $formModel->user_limit_type = $formModel::USER_LIMIT_BY_IP;
}

// Submission editable is OFF by default
if (empty($formModel->submission_editable)) {
    $formModel->submission_editable = $formModel::OFF;
}

// Add saved value to list
if (!$formEmailModel->isNewRecord) {
    // Reply To
    if (!empty($formEmailModel->from)) {
        if (!in_array($formEmailModel->from, array_keys($emailLabels))
            && isset($emails[Yii::t('app', 'Emails')])) {
            $emails[Yii::t('app', 'Emails')][$formEmailModel->from] = $formEmailModel->from;
        }
    }
    // CC
    if (!empty($formEmailModel->cc)) {
        if (!in_array($formEmailModel->cc, array_keys($emailLabels))
            && isset($emails[Yii::t('app', 'Emails')])) {
            $emails[Yii::t('app', 'Emails')][$formEmailModel->cc] = $formEmailModel->cc;
        }
    }
    // BCC
    if (!empty($formEmailModel->bcc)) {
        if (!in_array($formEmailModel->bcc, array_keys($emailLabels))
            && isset($emails[Yii::t('app', 'Emails')])) {
            $emails[Yii::t('app', 'Emails')][$formEmailModel->bcc] = $formEmailModel->bcc;
        }
    }
}

/*
 * Name or Company
 */
$names = ['' => '']; // Allow empty value to display placeholder

if (isset($formModel->formData)) {
    $nameLabels = $formModel->formData->getLabelsWithoutFilesAndButtons();

    $nameFields = array(
        Yii::t('app', 'Fields') => $nameLabels,
    );

    // If form has fields, add to config form
    if (sizeof($nameLabels) > 0) {
        $names = array_merge($names, $nameFields);
    }

    // Add saved value to list
    if (!$formEmailModel->isNewRecord) {
        if (!empty($formEmailModel->from_name)) {
            if (!in_array($formEmailModel->from_name, array_keys($nameLabels))) {
                $names = array_merge($names, array(
                    Yii::t('app', 'Name or Company') => [$formEmailModel->from_name => $formEmailModel->from_name],
                ));
            }
        }
    }
}

/*
 * Data for Autocomplete
 */
$fields = $formDataModel->getFieldsForEmail(false, true);
$fieldList = [];
foreach ($fields as $name => $label) {
    array_push($fieldList, [
        "text" => $label,
        "value" => $name
    ]);
}

// PHP options required by form.settings.js
$options = array(
    "ruleBuilderURL" => Url::to(['/form/rule-builder', 'id' => $formModel->id]),
    "previewURL" => Url::to(['app/preview']),
    "fieldListUrl" => Url::to(['ajax/field-list']),
    "formID" => $formModel->id,
    "iframe" => "formI",
    "iHeight" => 250,
    "fieldList" => $fieldList,
    "language" => Carbon::setLocale(substr(Yii::$app->language, 0, 2)), // eg. en-US to en
);

// Pass php options to javascript, and load before form.settings.js
$this->registerJs("var FormSettings = ".json_encode($options).";", $this::POS_BEGIN, 'editor-options');

// Load autocomplete library
$this->registerJsFile('@web/static_files/js/libs/jquery.textcomplete.min.js', ['depends' => WysiwygBundle::className()]);

// Load form.settings.js after WysiwygBundle
$this->registerJsFile('@web/static_files/js/form.settings.min.js', ['depends' => WysiwygBundle::className()]);

?>
<div class="form-config-page">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?> <small><?= Yii::t('app', 'Settings') ?></small></h1>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'form-settings', 'type' => ActiveForm::TYPE_VERTICAL]); ?>

    <div class="panel">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="active">
                    <a href="#form_settings" aria-controls="form_settings" role="tab" data-toggle="tab">
                        <?= Yii::t('app', 'Form Settings') ?></a></li>
                <li role="presentation">
                    <a href="#form_confirmation_settings" aria-controls="form_confirmation_settings"
                       role="tab" data-toggle="tab"><?= Yii::t('app', 'Confirmation Settings') ?></a></li>
                <li role="presentation">
                    <a href="#form_notification_settings" aria-controls="form_notification_settings" role="tab"
                       data-toggle="tab">
                        <?= Yii::t('app', 'Notification Settings') ?></a></li>
                <li role="presentation">
                    <a href="#form_theme_settings" aria-controls="form_theme_settings" role="tab" data-toggle="tab">
                        <?= Yii::t('app', 'UI Settings') ?></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="form_settings">
                    <?php echo FormGrid::widget([
                        'model' => $formModel,
                        'form' => $form,
                        'autoGenerateColumns' => true,
                        'columnSize' => Form::SIZE_SMALL,
                        'rows' => [
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Form Settings'),
                                    ['class' => 'text-primary']
                                ),
                                'attributes' => [
                                    'name' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>['placeholder'=>Yii::t("app", "Enter name..."),]],
                                ],
                            ],
                            [
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'status' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Disable it at any time."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'created_by'=> Yii::$app->user->can('changeFormsOwner', ['model' => $formModel]) ? [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'options'=>[
                                            'data'=> $users
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ] : ['type'=>Form::INPUT_RAW,'columnOptions'=>['colspan'=>3]],
                                    'language'=>[
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'hint'=> Yii::t("app", "Used to display validation messages."),
                                        'options'=>[
                                            'data'=> Language::supportedLanguages()
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'text_direction'=>[
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'hint'=> null,
                                        'options'=>[
                                            'data'=> Language::textDirections(),
                                            'hideSearch' => true,
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ]
                            ],
                            [
                                'attributes' => [
                                    'is_private' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Will require sign in to access the form."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'message' => [
                                        'type'=>Form::INPUT_TEXTAREA,
                                        'hint'=> Yii::t(
                                            "app",
                                            "Message displayed when form has been disabled."
                                        ),
                                        'options'=>['placeholder'=> Yii::t("app", "Enter message...")]],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'shared' => Yii::$app->user->can('shareForms', ['model' => $formModel]) ? [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formModel, 'shared')->radioButtonGroup(
                                            \app\models\Form::sharedOptions(),
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                    ] : ['type'=>Form::INPUT_RAW],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'users' => Yii::$app->user->can('shareForms', ['model' => $formModel]) ? [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'label' => Yii::t('app', 'Users'),
                                        'hint'=> Yii::t("app", "These users will have access to this form."),
                                        'options'=>[
                                            'data' => array_diff_key($users, [$formModel->created_by => $formModel->created_by]),
                                            'value' => !empty($formUsers) ? $formUsers : null,
                                            'pluginOptions' => [
                                                'placeholder' => Yii::t('app', 'Select users...'),
                                                'allowClear' => true,
                                                'multiple' => true,
                                            ],
                                        ],
                                    ] : ['type'=>Form::INPUT_RAW],
                                ],
                            ],
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Submission Settings'),
                                    ['class' => 'text-primary']
                                ),
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'submission_number' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'hint'=> Yii::t(
                                            "app",
                                            "The start number."
                                        ),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'submission_number_width' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'hint'=> Yii::t(
                                            "app",
                                            "Adds leading zeros until filling it."
                                        ),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'submission_number_prefix' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'submission_number_suffix' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ]
                            ],
                            [
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'save' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Store submitted form data."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'submission_scope' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Manage own submissions only."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'protected_files' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Disable anonymous user access."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ],
                            ],
                            [
                                'columns' => 12,
                                'autoGenerateColumns' => false, // override columns setting
                                'attributes' => [
                                    'submission_editable' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formModel, 'submission_editable')->radioButtonGroup(
                                            [
                                                $formModel::ON => Yii::t('app', 'Yes'),
                                                $formModel::OFF => Yii::t('app', 'No'),
                                            ],
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; overflow:hidden',
                                            ]
                                        )->hint(Yii::t("app", "Respondents can edit after submit.")),
                                    ],
                                ],
                            ],
                            [
                                'columns' => 12,
                                'autoGenerateColumns' => false, // override columns setting
                                'rowOptions' => [
                                        'class' => 'submission-editable-settings'
                                ],
                                'attributes' => [
                                    'submission_editable_time_length' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>[
                                            'type' => 'number',
                                            'min' => '1',
                                            'step' => '1',
                                            'placeholder'=>Yii::t("app", "Enter time length..."),
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'submission_editable_time_unit' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => '\kartik\select2\Select2',
                                        'options' => [
                                            'data' => $formModel->getTimePeriods(['all' => false]),
                                            'pluginOptions' => [
                                                'placeholder' => Yii::t('app', 'Select unit of time'),
                                                'allowClear' => true
                                            ],
                                        ],
                                        'columnOptions' => ['colspan' => 3],
                                    ],
                                ],
                            ],
                            [
                                'columns'=>12,
                                'attributes' => [
                                    'submission_editable_conditions' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' =>
                                            '<div class="submission-editable-settings">' .
                                                ConditionsBuilder::widget([
                                                    'id' => 'submission-editable-conditions-builder',
                                                    'label' => Yii::t('app', 'If the Submission meets'),
                                                ]) .
                                                $form
                                                    ->field($formModel, "submission_editable_conditions", ['options' => ['class' => 'hidden']])
                                                    ->hiddenInput() .
                                            '</div>',
                                    ],
                                ],
                            ],
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Form Activity & Limits'),
                                    ['class' => 'text-primary']
                                ),
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'total_limit' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formModel, 'total_limit')->radioButtonGroup(
                                            [
                                                $formModel::ON => Yii::t('app', 'Yes'),
                                                $formModel::OFF => Yii::t('app', 'No'),
                                            ],
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                        'columnOptions'=>['colspan'=>6],
                                    ],
                                    'user_limit' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formModel, 'user_limit')->radioButtonGroup(
                                            [
                                                $formModel::ON => Yii::t('app', 'Yes'),
                                                $formModel::OFF => Yii::t('app', 'No'),
                                            ],
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'user_limit_type' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'hideSearch' => true,
                                        'options'=>[
                                            'data'=> $formModel::userLimitOptions(),
                                            'hideSearch' => true,
                                            'pluginOptions' => [
                                                'placeholder' => Yii::t('app', 'Select type')
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ]
                            ],
                            [
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'total_limit_number' => ['type'=>Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>Yii::t("app", "Enter the total number..."),
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'total_limit_time_unit' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'options'=>[
                                            'data'=> $formModel->getTimePeriods(),
                                            'pluginOptions' => [
                                                'placeholder' => Yii::t('app', 'Select time period'),
                                                'allowClear' => true
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'user_limit_number' => ['type'=>Form::INPUT_TEXT,
                                        'options'=>[
                                            'placeholder'=>Yii::t("app", "Enter the max number..."),
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'user_limit_time_unit' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'options'=>[
                                            'data'=> $formModel->getTimePeriods(),
                                            'pluginOptions' => [
                                                'placeholder' => Yii::t('app', 'Select time period'),
                                                'allowClear' => true
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'schedule' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formModel, 'schedule')->radioButtonGroup(
                                            [
                                                $formModel::ON => Yii::t('app', 'Yes'),
                                                $formModel::OFF => Yii::t('app', 'No'),
                                            ],
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                    ],
                                ]
                            ],
                            [
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'schedule_start_date' => ['type'=>Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\datecontrol\DateControl::className(),
                                        'options' => [
                                            'type'=>\kartik\datecontrol\DateControl::FORMAT_DATETIME,
                                            'displayTimezone'=> Yii::$app->timeZone,
                                            'options' => [
                                                'options' => [
                                                    'placeholder' => 'Select start date...',
                                                ],
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'schedule_end_date' => ['type'=>Form::INPUT_WIDGET,
                                        'widgetClass' => \kartik\datecontrol\DateControl::className(),
                                        'options' => [
                                            'type'=>\kartik\datecontrol\DateControl::FORMAT_DATETIME,
                                            'displayTimezone'=> Yii::$app->timeZone,
                                            'options' => [
                                                'options' => [
                                                    'placeholder' => 'Select end date...',
                                                ],
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ]
                            ],
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Form Security'),
                                    ['class' => 'text-primary']
                                ),
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'use_password' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Enable password protection."),
                                        'options' => [
                                            'pluginEvents' => [
                                                "switchChange.bootstrapSwitch" => "function(event, state) {
                                                        if (state) {
                                                            $('.field-form-password').show()
                                                        } else {
                                                            $('.field-form-password').hide()
                                                        }
                                                    }",
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'honeypot' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Adds honeypot field to filter spam."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'authorized_urls' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Restrict access to authorized websites."),
                                        'options' => [
                                            'pluginEvents' => [
                                                "switchChange.bootstrapSwitch" => "function(event, state) {
                                                        if (state) {
                                                            $('.field-form-urls').show()
                                                        } else {
                                                            $('.field-form-urls').hide()
                                                        }
                                                    }",
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                    'novalidate' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Disable client side validation."),
                                        'columnOptions'=>['colspan'=>3],
                                    ],
                                ],
                            ],
                            [
                                'columns'=>12,
                                'autoGenerateColumns'=>false, // override columns setting
                                'attributes' => [
                                    'password' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>['placeholder'=>Yii::t("app", "Enter password...")],
                                        'columnOptions'=>['colspan'=>6],
                                        'hint'=> Yii::t("app", "Only those who know the password can see your form."),
                                    ],
                                    'urls' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>['placeholder'=>Yii::t("app", "example.com, example.net")],
                                        'columnOptions'=>['colspan'=>6],
                                        'hint'=> Yii::t("app", "Please, enter a comma separated list of valid domain names."),
                                    ],
                                ],
                            ],
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Other Options'),
                                    ['class' => 'text-primary']
                                ),
                                'attributes' => [
                                    'ip_tracking' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Collect IP addresses."),
                                    ],
                                    'analytics' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Enable Form Tracking."),
                                    ],
                                    'autocomplete' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Enable the browser's autocomplete."),
                                    ],
                                    'resume' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=> Yii::t("app", "Autosave and continue filling later."),
                                    ],
                                ],
                            ],
                        ]]);
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="form_confirmation_settings">
                    <?php echo FormGrid::widget([
                        'model' => $formConfirmationModel,
                        'form' => $form,
                        'autoGenerateColumns' => true,
                        'rows' => [
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Confirmation Message Settings'),
                                    ['class' => 'text-primary']
                                ),
                                'attributes' => [
                                    'type' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formConfirmationModel, 'type')->radioButtonGroup(
                                            $formConfirmationModel->getTypes(),
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'message' => [
                                        'type' => Form::INPUT_TEXTAREA,
                                        'hint'=> Yii::t('app', 'Enter a curly bracket "{" to merge fields.'),
                                        'options' => [
                                            'class' => 'placeholder-autocomplete',
                                            'placeholder'=> Yii::t("app", "Your Confirmation Message..."),
                                        ]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'url' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options' => [
                                            'class' => 'placeholder-autocomplete',
                                            'placeholder'=> Yii::t("app", "Enter URL...")
                                        ]
                                    ],
                                    'seconds' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formConfirmationModel, "seconds", [
                                                'addon' => ['append' => ['content'=> Yii::t('app', 'seconds')]],
                                            ])->textInput([
                                                'maxlength' => true,
                                                'placeholder' => '3',
                                            ]),
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'append' => [
                                        'type'=>Form::INPUT_CHECKBOX,
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'alias' => [
                                        'type'=>Form::INPUT_CHECKBOX,
                                    ],
                                ],
                            ],
                        ]]);
                    ?>

                    <div class="row" style="padding-top: 10px">
                        <div class="col-sm-12">
                            <label class="control-label">
                                <?= Yii::t('app', 'Show different messages with conditional logic') ?>
                            </label>
                        </div>
                        <div class="col-sm-12">
                            <div id="formconfirmation-rules" class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="glyphicon glyphicon-flowchart"></i> <?= Yii::t('app', 'Conditional Logic') ?>
                                </div>
                                <div class="panel-body">
                                    <div class="container-items">
                                        <?php foreach ($rules as $i => $rule): ?>
                                        <fieldset class="item">
                                            <div class="panel panel-default" style="border: 1px solid #d5d8dc; box-shadow: none">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="pull-right" style="margin-top: 5px">
                                                                <button type="button" class="copy-item btn btn-primary">
                                                                    <i class="glyphicon glyphicon-duplicate"></i></button>
                                                                <button type="button" class="remove-item btn btn-danger">
                                                                    <i class="glyphicon glyphicon-bin"></i></button>
                                                            </div>
                                                            <?= $form->field($rule, "[{$i}]action")->radioButtonGroup(
                                                                $formConfirmationModel->getTypes(),
                                                                [
                                                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                                    'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                                                ]
                                                            ) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row message">
                                                        <div class="col-sm-12">
                                                            <?= $form->field($rule, "[{$i}]message")->textarea([
                                                                'maxlength' => true,
                                                                'class' => 'placeholder-autocomplete',
                                                                'placeholder' => Yii::t('app', 'Your Confirmation Message...'),

                                                            ])->hint(Yii::t('app', 'Enter a curly bracket "{" to merge fields.')) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row url">
                                                        <div class="col-sm-6">
                                                            <?= $form->field($rule, "[{$i}]url")->textInput([
                                                                'maxlength' => true,
                                                                'class' => 'placeholder-autocomplete',
                                                                'placeholder' => Yii::t('app', 'Enter URL...'),
                                                            ]) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= $form->field($rule, "[{$i}]seconds", [
                                                                'addon' => ['append' => ['content'=> Yii::t('app', 'seconds')]],
                                                            ])->textInput([
                                                                'maxlength' => true,
                                                                'placeholder' => '3',
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row url">
                                                        <div class="col-sm-12">
                                                            <?= $form->field($rule, "[{$i}]append")->checkbox(['uncheck' => null]) ?>
                                                            <?= $form->field($rule, "[{$i}]alias")->checkbox(['uncheck' => null]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <?= ConditionsBuilder::widget([
                                                                'label' => Yii::t('app', 'If the Form meets'),
                                                            ]) ?>
                                                            <?= $form->field($rule, "[{$i}]conditions", ['options' => ['class' => 'hidden']])->hiddenInput() ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php endforeach; ?>
                                        <fieldset id="itemTemplate" class="hide">
                                            <div class="panel panel-default" style="border: 1px solid #d5d8dc; box-shadow: none">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="pull-right" style="margin-top: 5px">
                                                                <button type="button" class="copy-item btn btn-primary">
                                                                    <i class="glyphicon glyphicon-duplicate"></i></button>
                                                                <button type="button" class="remove-item btn btn-danger">
                                                                    <i class="glyphicon glyphicon-bin"></i></button>
                                                            </div>
                                                            <?php // $formConfirmationRuleModel->action = FormConfirmationRule::CONFIRM_WITH_MESSAGE; ?>
                                                            <?= $form->field($formConfirmationRuleModel, "action")->radioButtonGroup(
                                                                $formConfirmationModel->getTypes(),
                                                                [
                                                                    'unselect' => null,
                                                                    'itemOptions' => [
                                                                        'disabled' => true,
                                                                        'labelOptions' => ['class' => 'btn btn-primary'],
                                                                    ],
                                                                    'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                                                ]
                                                            ) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row message">
                                                        <div class="col-sm-12">
                                                            <?= $form->field($formConfirmationRuleModel, "message")->textarea([
                                                                'maxlength' => true,
                                                                'disabled' => true,
                                                                'class' => 'placeholder-autocomplete',
                                                                'placeholder' => Yii::t('app', 'Your Confirmation Message...'),
                                                            ]) ?>
                                                        </div>
                                                    </div>
                                                    <div class="row url" style="display: none">
                                                        <div class="col-sm-6">
                                                            <?= $form->field($formConfirmationRuleModel, "url")->textInput([
                                                                'maxlength' => true,
                                                                'disabled' => true,
                                                                'class' => 'placeholder-autocomplete',
                                                                'placeholder' => Yii::t('app', 'Enter URL...'),
                                                            ]) ?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <?= $form->field($formConfirmationRuleModel, "seconds", [
                                                                'addon' => ['append' => ['content'=> Yii::t('app', 'seconds')]],
                                                            ])->textInput([
                                                                'maxlength' => true,
                                                                'disabled' => true,
                                                                'placeholder' => '3',
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row url" style="display: none">
                                                        <div class="col-sm-12">
                                                            <?= $form->field($formConfirmationRuleModel, "append")->checkbox(['disabled' => true, 'uncheck' => null]) ?>
                                                            <?= $form->field($formConfirmationRuleModel, "alias")->checkbox(['disabled' => true, 'uncheck' => null]); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <?= ConditionsBuilder::widget([
                                                                'label' => Yii::t('app', 'If the Form meets'),
                                                            ]) ?>
                                                            <?= $form->field($formConfirmationRuleModel, "conditions", ['options' => ['class' => 'hidden']])->textInput(['disabled' => true]) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <button type="button" class="add-item btn btn-primary pull-right">
                                        <i class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Add Rule') ?>
                                    </button>
                                </div>
                            </div><!-- .panel -->
                        </div>
                    </div>

                    <?php echo FormGrid::widget([
                        'model' => $formConfirmationModel,
                        'form' => $form,
                        'autoGenerateColumns' => true,
                        'rows' => [
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Confirmation Email Settings'),
                                    ['class' => 'text-primary']
                                ),
                                'attributes' => [
                                    'send_email' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formConfirmationModel, 'send_email')->radioButtonGroup(
                                            [
                                                $formConfirmationModel::CONFIRM_BY_EMAIL_ENABLE => Yii::t('app', 'Yes'),
                                                $formConfirmationModel::CONFIRM_BY_EMAIL_DISABLE => Yii::t('app', 'No'),
                                            ],
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                    ],
                                ]
                            ],
                            [
                                'attributes' => [
                                    'mail_to' => ['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\select2\Select2',
                                        'hint' => Yii::t(
                                            "app",
                                            "Your form must have an email field to use this feature."
                                        ),
                                        'options'=>[
                                            'data'=> $emailFields,
                                            'options' => [
                                                'placeholder' => Yii::t("app", "Select an e-mail field..."),
                                                'multiple' => true,
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]],
                                    'mail_from' => ['type'=>Form::INPUT_TEXT, 'options'=>[
                                        'placeholder' => Yii::t("app", "Enter your e-mail address...")]],
                                    'mail_from_name' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>['placeholder' => Yii::t("app", "Enter your name or company...")]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'mail_cc' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>['placeholder'=> Yii::t("app", "Enter your e-mail address...")]
                                    ],
                                    'mail_bcc' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>['placeholder'=> Yii::t("app", "Enter your e-mail address...")]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'mail_subject' => [
                                        'type' => Form::INPUT_TEXT,
                                        'options' => [
                                            'class' => 'placeholder-autocomplete',
                                            'placeholder' => Yii::t("app", "Enter subject...")
                                        ]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'mail_message' => [
                                        'type'=>Form::INPUT_TEXTAREA,
                                        'hint'=> Html::tag('small', Yii::t("app", "Allowed HTML Tags:") . ' '
                                            . Html::encode(implode(' ', Html::allowedHtml5Tags()))
                                            . '<br />'
                                            . Yii::t('app', 'Enter a curly bracket "{" to merge fields.')),
                                        'options'=>[
                                            'placeholder'=> Yii::t("app", "Your Confirmation Message by E-Mail...")
                                        ]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'mail_receipt_copy' => [
                                        'type'=>Form::INPUT_CHECKBOX,
                                        'hint'=>''
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'mail_attach' => [
                                        'type'=>Form::INPUT_CHECKBOX,
                                        'hint'=>''
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'opt_in' => [
                                        'type'=>Form::INPUT_CHECKBOX,
                                        'hint'=> Html::tag('small', Yii::t("app", "You can display the Opt-In link in your E-Mail Message by using the {placeholder} placeholder.", [
                                            'placeholder' => '<code>{{optin_link}}</code>'
                                        ])),
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'opt_in_type' => [
                                        'type'  => Form::INPUT_RAW,
                                        'value' => $form->field($formConfirmationModel, 'opt_in_type')->radioButtonGroup(
                                            $formConfirmationModel->getOptInTypes(),
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
                                            ]
                                        ),
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'opt_in_message' => [
                                        'type' => Form::INPUT_TEXTAREA,
                                        'hint'=> Html::tag('small', Yii::t("app", "You can display the Edit link in your Thank You Message by using the {placeholder} placeholder.", [
                                            'placeholder' => '<code>{{edit_link}}</code>'
                                        ])),
                                        'options' => [
                                            'placeholder' => Yii::t("app", "Enter message...")
                                        ]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'opt_in_url' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options' => [
                                            'placeholder'=> Yii::t("app", "Enter URL...")
                                        ]
                                    ],
                                ],
                            ],
                        ]]);
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="form_notification_settings">
                    <?php echo FormGrid::widget([
                        'model' => $formEmailModel,
                        'form' => $form,
                        'autoGenerateColumns' => true,
                        'rows' => [
                            [
                                'contentBefore'=> Html::tag(
                                    'legend',
                                    Yii::t('app', 'Email Notification Settings'),
                                    ['class' => 'text-primary']
                                ),
                                'attributes' => [
                                    'subject' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'options'=>[
                                            'class' => 'placeholder-autocomplete',
                                            'placeholder'=> Yii::t("app", "Enter subject..."),
                                        ]
                                    ],
                                ],
                            ],
                            [
                                'autoGenerateColumns'=>false, // override columns setting
                                'columns'=>12,
                                'attributes' => [
                                    'to' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'hint'=> Yii::t(
                                            "app",
                                            "Notifications will be e-mailed to this address, e.g. 'admin@example.com'."
                                        ),
                                        'options'=> ['placeholder'=> Yii::t("app", "Enter e-mail address...")],
                                        'columnOptions'=>['colspan'=>6]
                                    ],
//                                    'from' => [
//                                        'type'=>Form::INPUT_WIDGET,
//                                        'widgetClass'=>'\kartik\select2\Select2',
//                                        'options'=>['data'=> $emails],
//                                        'columnOptions'=>['colspan'=>3],
//                                    ],
//                                    'from_name' => [
//                                        'type'=>Form::INPUT_TEXT,
//                                        'options'=>['placeholder' => Yii::t("app", "Enter your name or company...")],
//                                        'columnOptions'=>['colspan'=>3]
//                                    ],
                                    'from' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => SelectizeDropDownList::className(),
                                        'options' => [
                                            'items' => $emails,
                                            'options' => [
                                                'placeholder' => Yii::t('app', "Enter an email or select a field..."),
                                            ],
                                            'clientOptions' => [
                                                'create' => true,
                                                'sortField' => 'text',
                                            ]
                                        ],
                                        'columnOptions' => ['colspan'=>3]
                                    ],
                                    'from_name' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => SelectizeDropDownList::className(),
                                        'options' => [
                                            'items' => $names,
                                            'options' => [
                                                'placeholder' => Yii::t('app', "Enter name or select a field..."),
                                            ],
                                            'clientOptions' => [
                                                'create' => true,
                                                'sortField' => 'text',
                                            ]
                                        ],
                                        'columnOptions' => ['colspan'=>3]
                                    ],
                                ],
                            ],
                            [
                                'autoGenerateColumns'=>false, // override columns setting
                                'columns'=>12,
                                'attributes' => [
                                    'field_to' => ['type'=>Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\select2\Select2',
                                        'hint' => Yii::t(
                                            "app",
                                            "Your form must have an email field to use this feature."
                                        ),
                                        'options'=>[
                                            'data'=> $emailFields,
                                            'options' => [
                                                'placeholder' => Yii::t("app", "Select an e-mail field..."),
                                                'multiple' => true,
                                            ],
                                            'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ],
                                        'columnOptions'=>['colspan'=>6],
                                    ],
                                    'cc' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => SelectizeDropDownList::class,
                                        'options' => [
                                            'items' => $emails,
                                            'options' => [
                                                'placeholder' => Yii::t('app', "Enter an email or select a field..."),
                                            ],
                                            'clientOptions' => [
                                                'create' => true,
                                                'sortField' => 'text',
                                            ]
                                        ],
                                        'columnOptions' => ['colspan'=>3]
                                    ],
                                    'bcc' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => SelectizeDropDownList::class,
                                        'options' => [
                                            'items' => $emails,
                                            'options' => [
                                                'placeholder' => Yii::t('app', "Enter an email or select a field..."),
                                            ],
                                            'clientOptions' => [
                                                'create' => true,
                                                'sortField' => 'text',
                                            ]
                                        ],
                                        'columnOptions' => ['colspan'=>3]
                                    ],
                                ],
                            ],
                            [
                                'autoGenerateColumns'=>false, // override columns setting
                                'columns'=>12,
                                'attributes' => [
                                    'event' => [
                                        'columnOptions'=>['colspan'=>6],
                                        'type'=>Form::INPUT_DROPDOWN_LIST,
                                        'items' => \app\helpers\EventHelper::supportedFormEvents(),
                                    ],
                                    'attach' => [
                                        'columnOptions'=>['colspan'=>3],
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=>''
                                    ],
                                    'plain_text' => [
                                        'columnOptions'=>['colspan'=>3],
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\switchinput\SwitchInput',
                                        'hint'=>''
                                    ],
                                ],
                            ],
                            [
                                'autoGenerateColumns'=>false, // override columns setting
                                'columns'=>12,
                                'attributes' => [
                                    'type' => [
                                        'columnOptions'=>['colspan'=>6],
                                        'type'=>Form::INPUT_RAW,
                                        'value'=>$form->field($formEmailModel, 'type')->radioButtonGroup(
                                            [
                                                $formEmailModel::TYPE_ALL => Yii::t("app", "All Data"),
                                                $formEmailModel::TYPE_LINK => Yii::t("app", "Only Link"),
                                                $formEmailModel::TYPE_MESSAGE => Yii::t("app", "Custom Message"),
                                            ],
                                            [
                                                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                                                'style' => 'display:block; margin-bottom:15px; overflow:hidden',]
                                        )->hint(Yii::t(
                                            "app",
                                            "This email may contain all submitted data, a link to saved data or a custom message."
                                        )),
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'message' => [
                                        'type'=>Form::INPUT_TEXTAREA,
                                        'hint'=> Html::tag('small', Yii::t("app", "Allowed HTML Tags:") . ' '
                                            . Html::encode(implode(' ', Html::allowedHtml5Tags()))
                                            . '<br />'
                                            . Yii::t('app', 'Enter a curly bracket "{" to merge fields.')),
                                        'options'=>[
                                            'placeholder'=> Yii::t("app", "Enter your custom message...")
                                        ]
                                    ],
                                ],
                            ],
                        ]
                    ]);
                    ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="form_theme_settings">
                    <?php echo FormGrid::widget([
                        'model' => $formUIModel,
                        'form' => $form,
                        'autoGenerateColumns' => true,
                        'columnSize' => Form::SIZE_TINY,
                        'rows' => [[
                            'contentBefore'=>
                                Html::tag('legend', Yii::t('app', 'UI Settings'), ['class' => 'text-primary']),
                                'attributes' => [
                                    'js_file' => [
                                        'type'=>Form::INPUT_TEXT,
                                        'hint'=> Yii::t(
                                            "app",
                                            "This custom javascript file will be loaded each time the form is being displayed."
                                        ),
                                        'options'=>[
                                            'placeholder'=> Yii::t("app", "Enter URL...")
                                        ]
                                    ],
                                ],
                            ],
                            [
                                'attributes' => [
                                    'theme_id' => [
                                        'type'=>Form::INPUT_WIDGET,
                                        'widgetClass'=>'\kartik\select2\Select2',
                                        'label' => Yii::t('app', 'Select a Theme'),
                                        'hint' => Yii::t("app", "Select the theme that fits best to your form."),
                                        'options'=>[
                                            'data'=> $themes,
                                            'pluginOptions' => [
                                                'placeholder' => Yii::t('app', 'Select a Theme'),
                                                'allowClear' => true
                                            ],
                                            'pluginEvents' => [
                                                "select2:select" => "previewSelected",
                                                "select2:unselect" => "previewUnselected"
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                        ]]);
                    ?>

                    <!-- Preview panel -->
                    <div class="panel panel-default" id="preview-container" style="display:none;">
                        <div class="panel-heading clearfix">
                            <div class="summary pull-left"><strong><?= Yii::t("app", "Preview") ?></strong></div>
                            <div class="pull-right">
                                <a id="resizeFull" class="toogleButton" href="javascript:void(0)">
                                    <i class="glyphicon glyphicon-resize-full"></i>
                                </a>
                                <a id="resizeSmall" class="toogleButton" style="display: none"
                                   href="javascript:void(0)">
                                    <i class="glyphicon glyphicon-resize-small"></i>
                                </a>
                            </div>
                        </div>
                        <div class="panel-body" id="preview">
                        </div>
                    </div>

                </div>
                <div class="form-group" style="text-align: right; margin-top: 30px">
                    <?= Html::submitButton(Yii::t('app', 'Save and continue'), ['name' => 'continue', 'class' => 'btn btn-default', 'style' => 'margin-right: 5px']) ?>
                    <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
