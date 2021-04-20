<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use app\helpers\Language;
use Da\User\Helper\TimezoneHelper;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\helpers\ArrayHelper;

/**
 * @var yii\web\View           $this
 * @var \app\models\User    $user
 * @var \app\models\Profile $profile
 */

$languages = Language::supportedLanguages();
$timezones = TimezoneHelper::getAll();

// Default timezone
$profile->timezone = empty($profile->timezone) ? Yii::$app->settings->get('defaultUserTimezone', 'app', 'UTC') : $profile->timezone;

// Default language
$profile->language = empty($profile->language) ? Yii::$app->settings->get('defaultUserLanguage', 'app', 'en-US') : $profile->language;
?>

<?php $this->beginContent('@Da/User/resources/views/admin/update.php', [
        'user' => $user,
        'title' => Yii::t('app', 'Profile details')]) ?>

<?php $form = ActiveForm::begin(
    [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-9',
            ],
        ],
    ]
); ?>

<?= $form->field($profile, 'name') ?>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($profile, 'timezone')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($timezones, 'timezone', 'name'),
            'options' => ['placeholder' => 'Select a timezone'],
        ]); ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($profile, 'language')->widget(Select2::classname(), [
            'data' => $languages,
            'options' => ['placeholder' => 'Select a language'],
        ]); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($profile, 'public_email') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($profile, 'website') ?>
    </div>
</div>

<?= $form->field($profile, 'location') ?>
<?= $form->field($profile, 'gravatar_email') ?>
<?= $form->field($profile, 'bio')->textarea() ?>

<div class="form-action">
    <?= Html::submitButton(
        '<i class="glyphicon glyphicon-ok" style="margin-right: 3px"></i> ' .
        Yii::t('app', 'Save'), ['class' => 'btn btn-primary']
    ) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
