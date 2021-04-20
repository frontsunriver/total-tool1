<?php

use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Form Tools');

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>
<div class="form-settings">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-check" style="margin-right: 5px;"></i>
                <?= Html::encode($this->title) ?>
            </h3>
        </div>
        <div class="panel-body">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t("app", "Google reCAPTCHA") ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "ReCaptcha Version"), 'app_reCaptchaVersion', ['class' => 'control-label']) ?>
                                <?= Select2::widget([
                                    'name' => 'app_reCaptchaVersion',
                                    'data' => [2 => 'reCAPTCHA v2 - Checkbox', 3 => 'reCAPTCHA v3 - Invisible'],
                                    'value' => Yii::$app->settings->get('app.reCaptchaVersion'),
                                ]); ?>
                                <div class="hint-block">
                                    <a href='https://www.google.com/recaptcha' target='_blank'>
                                        <?= Yii::t("app", "Get your reCAPTCHA API keys.") ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "ReCaptcha Site Key"), 'app_reCaptchaSiteKey', ['class' => 'control-label']) ?>
                                <?= Html::textInput('app_reCaptchaSiteKey', Yii::$app->settings->get('app.reCaptchaSiteKey'), ['class' => 'form-control']) ?>
                                <div class="hint-block"><?= Yii::t("app", "Used in the HTML code that displays your forms to your users.") ?></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "ReCaptcha Secret Key"), 'app_reCaptchaSecret', ['class' => 'control-label']) ?>
                                <?= Html::textInput('app_reCaptchaSecret', Yii::$app->settings->get('app.reCaptchaSecret'), ['class' => 'form-control']) ?>
                                <div class="hint-block"><?= Yii::t(
                                        "app",
                                        "Used for communications between your site and Google."
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?= Html::submitButton(Html::tag('i', '', [
                                        'class' => 'glyphicon glyphicon-ok',
                                        'style' => 'margin-right: 2px;'
                                    ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-info']) ?>
                            </div>
                        </div>
                    </div>
                    <?= Html::hiddenInput('action', 'recaptcha'); ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <p class="hint-block">
                        <?= Yii::t('app', 'To start using Google reCAPTCHA in your forms, you need to enter an API key pair for your site.') ?>
                    </p>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t("app", "Browser Geolocation") ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "Browser Geolocation"), 'app_browserGeolocation', ['class' => 'control-label']) ?>
                                <?= SwitchInput::widget([
                                    'name'=>'app_browserGeolocation',
                                    'value' => (boolean) Yii::$app->settings->get('app.browserGeolocation'),
                                    'pluginOptions' => [
                                        'onColor' => 'info',
                                    ],
                                ]) ?>
                                <div class="hint-block" style="margin-top: -10px">
                                    <?= Yii::t(
                                        "app",
                                        "Capture geographic coordinates with consent."
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "Geocoding Provider"), 'app_geocodingProvider', ['class' => 'control-label']) ?>
                                <?= Select2::widget([
                                    'name' => 'app_geocodingProvider',
                                    'data' => ['google_geocoding' => 'Google Geocoding API'],
                                    'options' => ['placeholder' => 'Select a provider and enter its API Key...'],
                                    'value' => Yii::$app->settings->get('app.geocodingProvider'),
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "Google Geocoding API Key"), 'app_googleGeocodingApiKey', ['class' => 'control-label']) ?>
                                <?= Html::textInput('app_googleGeocodingApiKey', Yii::$app->settings->get('app.googleGeocodingApiKey'), ['class' => 'form-control']) ?>
                                <div class="hint-block">
                                    <a href='https://developers.google.com/maps/documentation/geocoding/start' target='_blank'>
                                        <?= Yii::t("app", "Get your Google Geocoding API key.") ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?= Html::submitButton(Html::tag('i', '', [
                                        'class' => 'glyphicon glyphicon-ok',
                                        'style' => 'margin-right: 2px;'
                                    ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-info']) ?>
                            </div>
                        </div>
                    </div>
                    <?= Html::hiddenInput('action', 'browser-geolocation'); ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <div class="hint-block">
                        <?= Yii::t("app", "We use a Geocoding Provider to convert geographic coordinates into a human-readable address.") ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t("app", "Image Compression") ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "Image Compression"), 'app_imageCompression', ['class' => 'control-label']) ?>
                                <?= SwitchInput::widget([
                                    'name'=>'app_imageCompression',
                                    'value' => (boolean) Yii::$app->settings->get('app.imageCompression'),
                                    'pluginOptions' => [
                                        'onColor' => 'info',
                                    ],
                                ]) ?>
                                <div class="hint-block" style="margin-top: -10px">
                                    <?= Yii::t("app", "Compress uploaded images reducing its quality.") ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?= Html::label(Yii::t("app", "Image Quality"), 'app_imageQuality', ['class' => 'control-label']) ?>
                                <?= Html::textInput('app_imageQuality',
                                        Yii::$app->settings->get('app.imageQuality'),
                                        ['type' => 'number', 'class' => 'form-control', 'step' => 1, 'min' => 0, 'max' => 100, 'pattern' => '\d*']) ?>
                                <div class="hint-block">
                                    <?= Yii::t("app", "From 0 (worst quality, smaller file) to 100 (best quality, biggest file).") ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?= Html::submitButton(Html::tag('i', '', [
                                        'class' => 'glyphicon glyphicon-ok',
                                        'style' => 'margin-right: 2px;'
                                    ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-info']) ?>
                            </div>
                        </div>
                    </div>
                    <?= Html::hiddenInput('action', 'image-compression'); ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <div class="hint-block">
                        <?= Yii::t("app", "Use this tool to reduce file server disk space.") ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t("app", "Form Builder") ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-sm-12" style="padding: 0;">
                        <ul>
                            <li><small><?= Yii::t('app', 'Adds "Alias" feature to added fields before v1.6.6') ?></small></li>
                            <li><small><?= Yii::t('app', 'Adds "Minlength" and "Maxlength" settings to added Text fields before v1.11') ?></small></li>
                            <li><small><?= Yii::t('app', 'Adds "Unique" setting to added Hidden fields before v1.11') ?></small></li>
                            <li><small><?= Yii::t('app', 'Adds "Help Text Placement" setting to added fields before v1.11') ?></small></li>
                            <li><small><?= Yii::t('app', 'Adds "Multiple" option to added File fields before v1.11') ?></small></li>
                        </ul>
                        <div class="form-group" style="margin-top: 10px; margin-bottom: 0">
                            <?= Html::submitButton(Html::tag('i', ' ', [
                                    'class' => 'glyphicon glyphicon-refresh',
                                    'style' => 'margin-right: 2px;'
                                ]) . ' ' . Yii::t('app', 'Update Fields'), ['class' => 'btn btn-info']) ?>
                        </div>
                    </div>
                    <?= Html::hiddenInput('action', 'update-form-fields'); ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <p class="hint-block">
                        <?= Yii::t('app', 'Update existing form fields to the get advantages of new features in the Form Builder.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

