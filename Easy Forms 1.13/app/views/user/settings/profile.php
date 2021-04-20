<?php

use Da\User\Helper\TimezoneHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\helpers\Language;

/**
 * @var yii\web\View           $this
 * @var yii\widgets\ActiveForm $form
 * @var \app\models\Profile $model
 * @var TimezoneHelper         $timezoneHelper
 */

$this->title = Yii::t('app', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
$timezoneHelper = $model->make(TimezoneHelper::class);
$languages = Language::supportedLanguages();
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(
            [
                'id' => $model->formName(),
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'fieldConfig' => [
                    'horizontalCssClasses' => [
                        'wrapper' => 'col-sm-9',
                    ],
                ],
            ]
        ); ?>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'public_email') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'website') ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'location') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form
                    ->field($model, 'timezone')
                    ->dropDownList(ArrayHelper::map($timezoneHelper->getAll(), 'timezone', 'name'));
                ?>
            </div>
            <div class="col-sm-6">
                <?= $form
                    ->field($model, 'language')
                    ->dropDownList($languages)->label(Yii::t("app", "Language")) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form
                    ->field($model, 'gravatar_email')
                    ->hint(
                        Html::a(
                            Yii::t('app', 'Change your avatar at Gravatar.com'),
                            'http://gravatar.com',
                            ['target' => '_blank']
                        )
                    ) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'bio')->textarea() ?>
            </div>
        </div>

        <div class="form-action">
            <?= Html::submitButton(
                '<i class="glyphicon glyphicon-ok" style="margin-right: 3px"></i> ' .
                Yii::t('app', 'Save'), ['class' => 'btn btn-primary']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
