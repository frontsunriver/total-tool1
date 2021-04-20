<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = Yii::t('app', 'Mail Settings');

$this->params['breadcrumbs'][] = ['label' => $this->title];

$mailerTransport = Yii::$app->settings->get('app.mailerTransport');

if (empty($mailerTransport) && !empty(Yii::$app->params['App.Mailer.transport'])) {
    $mailerTransport = Yii::$app->params['App.Mailer.transport'];
}
?>
<div class="mail-settings">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-inbox-out" style="margin-right: 5px;"></i>
                <?= Html::encode($this->title) ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'options' => ['autocomplete' => 'off']
            ]); ?>
            <input type="text" name="username" autocomplete="off" disabled style="display: none" />

            <div class="row">
                <div class='col-sm-12'>
                    <div class="form-group">
                        <div class="inline-control inline-control-radio">
                            <label class="control-label"><?= Yii::t("app", "Transport") ?></label>
                            <input type="radio" name="app_mailerTransport" id="app_mailerTransport_php" value="php"
                                <?= ($mailerTransport === 'php') ? 'checked':'' ?>
                            >
                            <label for="app_mailerTransport_php" class="radio-inline">PHP</label>
                            <input type="radio" name="app_mailerTransport" id="app_mailerTransport_smtp" value="smtp"
                                <?= ($mailerTransport === 'smtp') ? 'checked':'' ?>
                            >
                            <label for="app_mailerTransport_smtp" class="radio-inline">SMTP</label>
                            <input type="radio" name="app_mailerTransport" id="app_mailerTransport_sendinblue" value="sendinblue"
                                <?= ($mailerTransport === 'sendinblue') ? 'checked':'' ?>
                            >
                            <label for="app_mailerTransport_sendinblue" class="radio-inline">Sendinblue</label>
                            <input type="radio" name="app_mailerTransport" id="app_mailerTransport_ses" value="ses"
                                <?= ($mailerTransport === 'ses') ? 'checked':'' ?>
                            >
                            <label for="app_mailerTransport_ses" class="radio-inline">Amazon SES</label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="php-mail-settings" class="well" <?php if ($mailerTransport === 'smtp'): ?>style="display: none" <?php endif; ?>>
                <?= Yii::t('app', 'This mailer transport relies on the PHP native mail() function. Please select any other Transport option above to continue the setup.') ?>
            </div>

            <div id="smtp-settings" class="row" style="display: none">
                <div class="col-sm-12">
                    <div class="well">
                        <?= Yii::t('app', 'Use the SMTP details provided by your hosting provider or email service.') ?>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "SMTP Host"), 'smtp_host', ['class' => 'control-label']) ?>
                        <?= Html::textInput('smtp_host', Yii::$app->settings->get('smtp.host'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Port"), 'smtp_port', ['class' => 'control-label']) ?>
                        <?= Html::textInput('smtp_port', Yii::$app->settings->get('smtp.port'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Encryption"), 'smtp_encryption', ['class' => 'control-label']) ?>
                        <?= Html::dropDownList('smtp_encryption', Yii::$app->settings->get('smtp.encryption'), ['tls'=>'tls', 'ssl'=>'ssl', 'none'=>'none'], ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Username"), 'smtp_username', ['class' => 'control-label']) ?>
                        <?= Html::input('text', 'smtp_username', Yii::$app->settings->get('smtp.username'), ['class' => 'form-control', 'spellcheck' => 'false', 'autocomplete' => "off" , 'autocorrect' => "off", 'autocapitalize' => "off"]) ?>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Password"), 'smtp_password', ['class' => 'control-label']) ?>
                        <?= Html::textInput('smtp_password', '', ['class' => 'form-control']) ?>
                        <span class="help-block">
                            <?= Yii::t('app', 'Please re-enter your password before submit this form.') ?>
                        </span>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Async"), 'app_async', ['class' => 'control-label']) ?>
                        <?= SwitchInput::widget([
                                'name'=>'app_async',
                                'value' => (boolean) Yii::$app->settings->get('app.async'),
                                'containerOptions' => ['class' => ''],
                            ]) ?>
                        <span class="hint-block"><?= Yii::t('app', 'Send email notifications in background. Cron job is required.') ?></span>
                    </div>
                </div>
            </div>

            <div id="sendinblue-settings" class="row" style="display: none">
                <div class="col-sm-12">
                    <div class="well">
                        <p><?= Yii::t('app', 'Send your emails with confidence and improve your email deliverability! Sendinblue enable you to send up to 300 emails/day free of charge (for as long as you like), making it a good platform for startups to start on.') ?></p>
                        <p><?= Html::a('Get Sendinblue Now (Free)', 'https://easyforms.dev/sendinblue', [
                            'class' => 'btn btn-primary',
                            'target' => '_blank',
                        ]) ?></p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Api Key"), 'sendinblue_key', ['class' => 'control-label']) ?>
                        <?= Html::input('text', 'sendinblue_key', Yii::$app->settings->get('sendinblue.key'), ['class' => 'form-control']) ?>
                        <span class="help-block"><?= Yii::t('app', 'If you already have an account') ?>, <a href="https://account.sendinblue.com/advanced/api" target="_blank"><?= Yii::t('app', 'get your v3 Api Key') ?></a>.</span>
                    </div>
                </div>
            </div>
            <div id="ses-settings" class="row" style="display: none">
                <div class="col-sm-12">
                    <div class="well">
                        <p><?= Yii::t('app', 'With Amazon SES you can send 62,000 messages per month at no charge.') ?></p>
                        <p><?= Html::a('Get Amazon SES Now (Free)', 'https://easyforms.dev/ses', [
                                'class' => 'btn btn-primary',
                                'target' => '_blank',
                            ]) ?></p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Access Key ID"), 'aws_sesAccessKeyId', ['class' => 'control-label']) ?>
                        <?= Html::input('text', 'aws_sesAccessKeyId', Yii::$app->settings->get('aws.sesAccessKeyId'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Secret Access Key"), 'aws_sesSecretAccessKey', ['class' => 'control-label']) ?>
                        <?= Html::input('text', 'aws_sesSecretAccessKey', Yii::$app->settings->get('aws.sesSecretAccessKey'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Region"), 'aws_sesRegion', ['class' => 'control-label']) ?>
                        <?= Html::dropDownList('aws_sesRegion', Yii::$app->settings->get('aws.sesRegion'), \app\helpers\MailHelper::awsSesRegions(), ['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::submitButton(Html::tag('i', '', [
                                'class' => 'glyphicon glyphicon-ok',
                                'style' => 'margin-right: 3px;',
                            ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?= Html::hiddenInput('action', 'email-settings'); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-envelope" style="margin-right: 5px;"></i>
                <?= Yii::t('app', 'Site Emails') ?>
            </div>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => [
                    'autocomplete' => 'off',
                ]
            ]); ?>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-muted">
                        <?= Yii::t('app', 'Site email addresses for administrative use. They should be compatible with the Mail Settings.') ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Admin e-mail"), 'app_adminEmail', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_adminEmail', Yii::$app->settings->get('app.adminEmail'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Support e-mail"), 'app_supportEmail', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_supportEmail', Yii::$app->settings->get('app.supportEmail'), ['class' => 'form-control']) ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "No-Reply e-mail"), 'app_noreplyEmail', ['class' => 'control-label']) ?>
                        <?= Html::textInput('app_noreplyEmail', Yii::$app->settings->get('app.noreplyEmail'), ['class' => 'form-control']) ?>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::submitButton(Html::tag('i', '', [
                                'class' => 'glyphicon glyphicon-ok',
                                'style' => 'margin-right: 3px;',
                            ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'name' => 'site_emails']) ?>
                    </div>
                </div>
            </div>
            <?= Html::hiddenInput('action', 'site-emails'); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-user-conversation" style="margin-right: 5px;"></i>
                <?= Yii::t('app', 'From Name') ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => [
                    'autocomplete' => 'off',
                ]
            ]); ?>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-muted">
                        <?= Yii::t('app', 'By default, the From Name will be set to the site name. However, you can change this here.') ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "From Name"), 'app_defaultFromName', ['class' => 'control-label']) ?>
                        <?= Html::input('text', 'app_defaultFromName', Yii::$app->settings->get('app.defaultFromName'), [
                            'placeholder' => Yii::t('app', 'Enter a name...'),
                            'class' => 'form-control',
                            'spellcheck' => 'false',
                            'autocomplete' => "off" ,
                            'autocorrect' => "off",
                            'autocapitalize' => "off"
                        ]) ?>
                        <?= Html::tag('span', Yii::t('app', 'The name which emails are sent from.'), [
                            'class' => 'help-block'
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::submitButton(Html::tag('i', '', [
                                'class' => 'glyphicon glyphicon-ok',
                                'style' => 'margin-right: 2px',
                            ]) . ' ' . Yii::t('app', 'Save'), ['class' => 'btn btn-primary', 'name' => 'name']) ?>
                    </div>
                </div>
            </div>
            <?= Html::hiddenInput('action', 'from-name'); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-message-flag" style="margin-right: 5px;"></i>
                <?= Yii::t('app', 'Send Test Email') ?>
            </h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => [
                    'autocomplete' => 'off',
                ]
            ]); ?>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-muted">
                        <?= Yii::t('app', 'After entering your email settings, it is good to check if Easy Forms is able to send emails.') ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::label(Yii::t("app", "Send To"), 'email', ['class' => 'control-label']) ?>
                        <?= Html::input('email', 'email', '', [
                                'placeholder' => Yii::t('app', 'Your E-mail address'),
                            'class' => 'form-control',
                            'spellcheck' => 'false',
                            'autocomplete' => "off" ,
                            'autocorrect' => "off",
                            'autocapitalize' => "off"
                        ]) ?>
                        <?= Html::tag('span', 'Enter email address where test email will be sent.', [
                            'class' => 'help-block'
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?= Html::submitButton(Html::tag('i', '', [
                                'class' => 'glyphicon glyphicon-send',
                                'style' => 'margin-right: 3px',
                            ]) . ' ' . Yii::t('app', 'Send Email'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
            <?= Html::hiddenInput('action', 'test-email'); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php

$script = <<< JS

$( document ).ready(function(){
    // Handlers
    var toggleSettings = function () {
        if ($("#app_mailerTransport_ses").is(":checked") === true) {
            $("#php-mail-settings").hide();
            $("#smtp-settings").hide();
            $("#sendinblue-settings").hide();
            $("#ses-settings").show();
        } else if ($("#app_mailerTransport_sendinblue").is(":checked") === true) {
            $("#php-mail-settings").hide();
            $("#smtp-settings").hide();
            $("#sendinblue-settings").show();
            $("#ses-settings").hide();
        } else if ($("#app_mailerTransport_smtp").is(":checked") === true) {
            $("#php-mail-settings").hide();
            $("#smtp-settings").show();
            $("#sendinblue-settings").hide();
            $("#ses-settings").hide();
        } else {
            $("#php-mail-settings").show();
            $("#smtp-settings").hide();
            $("#sendinblue-settings").hide();
            $("#ses-settings").hide();
        }
    };
    $('input[type="radio"]').click(function(e){
        toggleSettings()
    });
    toggleSettings();
});

JS;

$this->registerJs($script, $this::POS_END);
?>