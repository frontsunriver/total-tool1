<?php

use app\helpers\ArrayHelper;
use kartik\file\FileInput;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use app\bundles\WysiwygBundle;
use Da\User\Helper\TimezoneHelper;
use app\helpers\Language;

/**
 * @var TimezoneHelper         $timezoneHelper
 */

WysiwygBundle::register($this);

$logo = Yii::$app->settings->get('app.logo');
$roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
$languages = Language::supportedLanguages();
$timezones = TimezoneHelper::getAll();

$this->title = Yii::t('app', 'Site Settings');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>
<div class="account-management">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-cogwheels" style="margin-right: 5px;"></i>
                <?= Html::encode($this->title) ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class='row'>
                <div class='col-sm-6'>
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Name"), 'app.name', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_name', Yii::$app->settings->get('app.name'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class='col-sm-6'>
                    <div class="form-group">
                        <div class="form-group">
                            <?= Html::label(Yii::t("app", "Logo"), 'app.name', ['class' => 'control-label']) ?>
                            <?php $removeLink = !empty($logo) ? '<a href="#" class="file-caption-remove text-muted pull-right"><span class="glyphicon glyphicon-remove"></span></a>' : ''; ?>
                            <?= FileInput::widget([
                                'name' => 'logo',
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'showPreview' => false,
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'showCancel' => true,
                                    'initialCaption' => basename($logo),
                                    'layoutTemplates' => [
                                        'caption' => "<div class='file-caption form-control {class}' tabindex='500'>
                                                        <span class='file-caption-icon'></span>
                                                        <input class='file-caption-name' style='width: 85%'>
                                                        {$removeLink}
                                                      </div>",
                                    ],
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-sm-12'>
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Description"), 'app_description', ['class' => 'control-label']) ?>
                        <?= Html::textarea('app_description', Yii::$app->settings->get('app.description'), ['class' => 'form-control', 'id' => 'app_description']) ?>
                    </div>
                </div>
            </div>
            <?= Html::tag('legend', Yii::t('app', 'Date / Time Formats'), [
                'class' => 'text-primary',
                'style' => 'font-size: 18px; margin-top: 20px'
            ]); ?>
            <div class="row">
                <div class='col-sm-4'>
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Time Format"), 'app_timeFormat', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_timeFormat', Yii::$app->settings->get('app.timeFormat'), [
                            'placeholder' => 'php:h:i:s A',
                            'class' => 'form-control',
                        ]) ?>
                        <?php if (!empty(Yii::$app->settings->get('app.timeFormat'))): ?>
                        <div class="hint-block">
                            <?= Yii::$app->formatter->asTime(time(), Yii::$app->settings->get('app.timeFormat')) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class='col-sm-4'>
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Date Format"), 'app_dateFormat', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_dateFormat', Yii::$app->settings->get('app.dateFormat'), [
                            'placeholder' => 'php:Y-m-d',
                            'class' => 'form-control',
                        ]) ?>
                        <?php if (!empty(Yii::$app->settings->get('app.dateFormat'))): ?>
                            <div class="hint-block">
                                <?= Yii::$app->formatter->asDate(time(), Yii::$app->settings->get('app.dateFormat')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class='col-sm-4'>
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Date / Time Format"), 'app_dateTimeFormat', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_dateTimeFormat', Yii::$app->settings->get('app.dateTimeFormat'), [
                            'placeholder' => 'php:Y-m-d h:i:s A',
                            'class' => 'form-control',
                        ]) ?>
                        <?php if (!empty(Yii::$app->settings->get('app.dateTimeFormat'))): ?>
                            <div class="hint-block">
                                <?= Yii::$app->formatter->asDatetime(time(), Yii::$app->settings->get('app.dateTimeFormat')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?php
                        $humanTimeDiff = Yii::$app->settings->get('humanTimeDiff', 'app', null);;
                        $humanTimeDiff = is_null($humanTimeDiff) || $humanTimeDiff === 1;
                        ?>
                        <?= Html::label(Yii::t("app", "Diff For Humans"), 'app_humanTimeDiff', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                            'name'=>'app_humanTimeDiff',
                            'value' => $humanTimeDiff,
                            'containerOptions' => ['class' => ''],
                            'pluginOptions' => [
                                'onColor' => 'primary',
                            ],
                        ]) ?>
                        <div class="hint-block"><?= Yii::t("app", "Diff time in human readable format.") ?></div>
                    </div>
                </div>
            </div>
            <?= Html::tag('legend', Yii::t('app', 'Membership'), [
                'class' => 'text-primary',
                'style' => 'font-size: 18px; margin-top: 20px'
            ]); ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Anyone can register"), 'app_anyoneCanRegister', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                            'name'=>'app_anyoneCanRegister',
                            'value' => (boolean) Yii::$app->settings->get('app.anyoneCanRegister'),
                            'pluginOptions' => [
                                'onColor' => 'primary',
                            ],
                        ]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Enable user registration."
                            ) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Use captcha"), 'app_useCaptcha', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget(['name'=>'app_useCaptcha', 'value' => (boolean) Yii::$app->settings->get('app.useCaptcha')]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Show captcha in registration form."
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Default user role"), 'app_defaultUserRole', ['class' => 'control-label']) ?>
                        <?= Select2::widget([
                            'name' => 'app_defaultUserRole',
                            'data' => $roles, // Show user role by default,
                            'value' => Yii::$app->settings->get('app.defaultUserRole'),
                            'options' => ['placeholder' => Yii::t('app', 'Select a role')],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <?= Html::label(Yii::t("app", "Default User Timezone"), 'app_defaultUserTimezone', ['class' => 'control-label']) ?>
                    <?= Select2::widget([
                        'name' => 'app_defaultUserTimezone',
                        'data' => ArrayHelper::map($timezones, 'timezone', 'name'), // Show user timezones by default,
                        'value' => Yii::$app->settings->get('app.defaultUserTimezone'),
                        'options' => ['placeholder' => Yii::t('app', 'Select a timezone')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-sm-4">
                    <?= Html::label(Yii::t("app", "Default User Language"), 'app_defaultUserLanguage', ['class' => 'control-label']) ?>
                    <?= Select2::widget([
                        'name' => 'app_defaultUserLanguage',
                        'data' => $languages, // Show user timezones by default,
                        'value' => Yii::$app->settings->get('app.defaultUserLanguage'),
                        'options' => ['placeholder' => Yii::t('app', 'Select a language')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>
            <?= Html::tag('legend', Yii::t('app', 'Log In'), [
                'class' => 'text-primary',
                'style' => 'font-size: 18px; margin-top: 20px'
            ]); ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Unconfirmed Email"), 'app_unconfirmedEmailLogin', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                            'name'=>'app_unconfirmedEmailLogin',
                            'value' => (boolean) Yii::$app->settings->get('app.unconfirmedEmailLogin'),
                            'pluginOptions' => [
                                'onColor' => 'primary',
                            ],
                        ]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Allow users to login with unconfirmed emails."
                            ) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Two Factor Authentication"), 'app_twoFactorAuthentication', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                            'name'=>'app_twoFactorAuthentication',
                            'value' => (boolean) Yii::$app->settings->get('app.twoFactorAuthentication'),
                            'pluginOptions' => [
                                'onColor' => 'primary',
                            ],
                        ]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Allow users to configure their login process with 2FA."
                            ) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Max Password Age"), 'app_maxPasswordAge', ['class' => 'control-label']) ?>
                        <?= Html::input('number', 'app_maxPasswordAge', Yii::$app->settings->get('app.maxPasswordAge'), [
                            'class' => 'form-control',
                            'min' => '0',
                            'step' => '1'
                        ]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Days since last password change. User will be forced to change it."
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= Html::tag('legend', Yii::t('app', 'API'), [
                'class' => 'text-primary',
                'style' => 'font-size: 18px; margin-top: 20px'
            ]); ?>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "REST API"), 'app_restApi', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                            'name'=>'app_restApi',
                            'value' => (boolean) Yii::$app->settings->get('app.restApi'),
                            'pluginOptions' => [
                                'onColor' => 'primary',
                            ],
                        ]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Access to REST API."
                            ) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "API Key"), 'app_restApiKey', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                            'name'=>'app_restApiKey',
                            'value' => (boolean) Yii::$app->settings->get('app.restApiKey'),
                            'pluginOptions' => [
                                'onColor' => 'primary',
                            ],
                        ]) ?>
                        <div class="hint-block"><?= Yii::t(
                                "app",
                                "Allow users to generate an API Key."
                            ) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-top: 20px">
                        <?= Html::submitButton(Html::tag('i', '', [
                            'class' => 'glyphicon glyphicon-ok',
                            'style' => 'margin-right: 2px;',
                        ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
ActiveForm::end();

$url = \yii\helpers\Url::to(['/settings/logo-delete'], true);

$script = <<< JS

$( document ).ready(function(){
    // Handlers
    $('body').on('click', '.file-caption-remove', function(e){
        e.preventDefault();
        $.ajax({
            url: "{$url}",
            type: "POST",
            dataType: "json",
            contentType: "multipart/form-data",
            processData: false,
            contentType: false,
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json"
            }
        }).done(function(response) {
            window.location.replace(window.location.href);
        });
    });
    /**
     * Show Wysiwyg editor
     */
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#app_description',
            height: 120,
            valid_elements : '*[*]',
            entity_encoding : "raw",
            menubar: false,
            plugins: 'wordcount code paste',
            toolbar: 'styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | preview code',
            convert_urls: false,
        });
    }
});

JS;

$this->registerJs($script, $this::POS_END);
?>