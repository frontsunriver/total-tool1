<?php

use app\bundles\PublicBundle;
use app\helpers\Css;
use app\helpers\Honeypot;
use app\helpers\Pager;
use app\helpers\UrlHelper;
use app\models\Form;
use app\models\FormConfirmation;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */
/* @var $formConfirmationModel app\models\FormConfirmation */
/* @var $formRuleModels app\models\FormRule[] */
/* @var $submissionModel app\models\FormSubmission */
/* @var $fields array Form Fields */
/* @var $showTheme boolean Show or hide theme css */
/* @var $customJS boolean Load or Not Custom Javascript File */
/* @var $record boolean Enable / Disable record stats dynamically */

$this->title = $formModel->name;

/** @var $rules array Conditions and Actions of active rules */
$rules = [];

foreach ($formRuleModels as $formRuleModel) {
    $rule = [
        'conditions' => $formRuleModel['conditions'],
        'actions' => $formRuleModel['actions'],
        'opposite' => (boolean) $formRuleModel['opposite'],
    ];
    array_push($rules, $rule);
}

// Base URL without schema
$baseUrl = UrlHelper::removeScheme(Url::home(true));

// Get default values in order to pre-populate the form
$defaultValues = Yii::$app->request->getQueryParam('defaultValues');

// Browser Fingerprint
$fingerprint = $formModel->getUseFingerprint();

// PHP options required by form.embed.js
$options = array(
    "id" => $formModel->id,
    "hashId" => $formModel->hashId,
    "app" => UrlHelper::removeScheme(Url::to(['/app'], true)),
    "tracker" => $baseUrl . "static_files/js/form.tracker.js",
    "name" => "#form-app",
    "actionUrl" => Url::to(['app/f', 'id' => $formModel->hashId], true),
    "validationUrl" => Url::to(['app/check', 'id' => $formModel->hashId], true),
    "_csrf" => Yii::$app->request->getCsrfToken(),
    "resume" => $formModel->resume,
    "text_direction" => $formModel->text_direction,
    "fingerprint" => $fingerprint,
    "autocomplete" => $formModel->autocomplete,
    "novalidate" => $formModel->novalidate,
    "analytics" => $formModel->analytics && $record,
    "confirmationType" => $formConfirmationModel->type,
    "confirmationMessage" => false,
    "confirmationUrl" => $formConfirmationModel->url,
    "confirmationSeconds" => $formConfirmationModel->seconds,
    "confirmationAppend" => $formConfirmationModel->append,
    "confirmationAlias" => $formConfirmationModel->alias,
    "showOnlyMessage" => FormConfirmation::CONFIRM_WITH_ONLY_MESSAGE,
    "redirectToUrl" => FormConfirmation::CONFIRM_WITH_REDIRECTION,
    "rules" => $rules,
    "fieldIds" => $formDataModel->getFieldIds(),
    "submitted" => false,
    "runOppositeActions" => true,
    "skips" => [],
    "reCaptchaVersion" => Yii::$app->settings->get('app.reCaptchaVersion'),
    "reCaptchaSiteKey" => Yii::$app->settings->get('app.reCaptchaSiteKey'),
    "geolocation" => Yii::$app->settings->get('browserGeolocation', 'app', 0),
    "defaultValues" => !empty($defaultValues) ? Json::decode(Json::htmlEncode($defaultValues)) : false,
    "i18n" => [
        'complete' => Yii::t('app', 'Complete'),
        'unexpectedError' => Yii::t('app', 'An unexpected error has occurred. Please retry later.'),
    ]
);

if ($submissionModel) {
    $options["actionUrl"] = Url::to(['app/f', 'id' => $formModel->hashId, 'sid' => $submissionModel->id], true);
    $options["submissionData"] = json_encode($submissionModel->data, true);
    $options["fields"] = $fields;
}

// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'form-options');

// Load Signature Pad
$this->registerJsFile('@web/static_files/js/libs/signature_pad.umd.js', ['position' => View::POS_HEAD]);

// Pager
$pager = new Pager(Html::decode($formDataModel->html));

// Utilities required for javascript files
$this->registerJsFile('@web/static_files/js/form.utils.min.js', ['depends' => JqueryAsset::className()]);

// If form has multiple pages
if ($pager->getNumberOfPages() > 1) {
    // Animations
    $this->registerJsFile('@web/static_files/js/libs/jquery.easing.min.js', ['depends' => JqueryAsset::className()]);
}

// If form requires browser fingerprint
if ($fingerprint) {
    $this->registerJsFile('@web/static_files/js/libs/fingerprint2.min.js', ['depends' => JqueryAsset::className()]);
}

// If resume later is enabled
if ($formModel->resume) {
    $this->registerJsFile('@web/static_files/js/form.resume.min.js', ['depends' => JqueryAsset::className()]);
}

// If form has rules
if (count($rules) > 0) {
    // Load date-fns library
    $this->registerJsFile('@web/static_files/js/libs/date_fns.min.js', ['depends' => JqueryAsset::className()]);
    // Load math library
    $this->registerJsFile('@web/static_files/js/libs/math.min.js', ['depends' => JqueryAsset::className()]);
    $this->registerJsFile('@web/static_files/js/form.evaluate.min.js', ['depends' => JqueryAsset::className()]);
    // Load numeral library
    $this->registerJsFile('@web/static_files/js/libs/numeral.min.js', ['depends' => JqueryAsset::className()]);
    $this->registerJsFile('@web/static_files/js/libs/locales/numeral.min.js', ['depends' => JqueryAsset::className()]);
    // Load rules engine and run
    $this->registerJsFile('@web/static_files/js/rules.engine.min.js', ['depends' => JqueryAsset::className()]);
    $this->registerJsFile('@web/static_files/js/rules.engine.run.min.js', ['depends' => JqueryAsset::className()]);
}

$this->registerJsFile('@web/static_files/js/libs/jquery.form.js', ['depends' => JqueryAsset::className()]);
// Load embed.js after all
$this->registerJsFile('@web/static_files/js/form.embed.js', ['depends' => JqueryAsset::className()]);

// Get form paginated
$formHtml = $pager->getPaginatedData();

// Load reCAPTCHA JS Api
// Only if Form has reCaptcha component and was not passed in this session
if ($formModel->recaptcha === Form::RECAPTCHA_ACTIVE && Yii::$app->settings->get('app.reCaptchaVersion') == 3) {
    $recaptchaSiteKey = Yii::$app->settings->get('app.reCaptchaSiteKey');
    $recaptchaUrl = sprintf("https://www.google.com/recaptcha/api.js?render=%s", $recaptchaSiteKey);
    $this->registerJsFile($recaptchaUrl, ['position' => View::POS_HEAD]);
    $this->registerJs("
        var addTokenToForm = function (token) {
            $('#g-recaptcha-response').remove();
            grecaptcha.execute('{$recaptchaSiteKey}', {action: 'easy_forms'}).then(function(token) {
                $('<input>').attr({
                    type: 'hidden',
                    value: token,
                    id: 'g-recaptcha-response',
                    name: 'g-recaptcha-response'
                }).appendTo('form');
            });
        };
        grecaptcha.ready(function () {
            addTokenToForm();
        });
        setInterval(function () {
           addTokenToForm();
        }, 90 * 1000);
        formEl.on('error', function (event) {
            addTokenToForm();
        });
    ");
    // Removes the g-recaptcha class, to prevent it from displaying reCAPTCHA v2 (checkbox)
    $formHtml = str_replace('g-recaptcha', '', $formHtml);
} elseif ($formModel->recaptcha === Form::RECAPTCHA_ACTIVE && !Yii::$app->session['reCaptcha']) {
    $this->registerJsFile('https://www.google.com/recaptcha/api.js', ['position' => View::POS_HEAD]);
    $this->registerCss("body {min-height: 600px} .g-recaptcha { min-height: 78px; }");
    $this->registerJs("
        formEl.on('error', function (event) {
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
            }
        });
    ");
}

if ($formModel->text_direction === "rtl") {
    $this->registerCssFile('@web/static_files/css/bootstrap-rtl.min.css', ['depends' => PublicBundle::class]);
}

// Add honeypot
if ($formModel->honeypot === Form::HONEYPOT_ACTIVE) {
    $honeypot = new Honeypot(Html::decode($formHtml));
    $formHtml = $honeypot->getData();
}

// Add default body padding
$this->registerCss("
body { padding: 20px }
@media (min-width: 768px) {
    body {
        padding: 25px;
    }
}
");

// Add theme
if ($showTheme && isset($formModel->theme) && isset($formModel->theme->css) && !empty($formModel->theme->css)) {
    $this->registerCss($formModel->theme->css);
}

// Add Form Design
if ($showTheme) {

    $stylesheet = Css::convertFormStyles($formDataModel->getStyles());
    $fonts = Css::getUsedGoogleFonts($stylesheet);
    if (!empty($fonts)) {
        echo Html::cssFile(sprintf('https://fonts.googleapis.com/css?family=%s', implode('|', $fonts)));
    }

    $this->registerCss(Css::toCss($stylesheet));
}

// Add custom js file after all
if ($customJS && isset($formModel->ui) && isset($formModel->ui->js_file) && !empty($formModel->ui->js_file)) {
    $this->registerJsFile($formModel->ui->js_file, ['depends' => JqueryAsset::className()]);
}
?>

<div id="form-embed" class="form-embed <?= isset($submissionModel, $submissionModel->id) ? 'edit-submission edit-submission-' . $submissionModel->id : 'add-submission' ?>">

    <div id="messages"></div>

    <?= Html::decode($formHtml) ?>

    <div id="progress" class="progress" style="display: none;">
        <div id="bar" class="progress-bar" role="progressbar" style="width: 0;">
            <span id="percent" class="sr-only">0% Complete</span>
        </div>
    </div>
</div>
