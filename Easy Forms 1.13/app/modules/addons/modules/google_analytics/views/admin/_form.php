<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\addons\modules\google_analytics\models\Account */
/* @var $forms array [id => name] of Form models */

?>

<div class="ga-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // Normal select with ActiveForm & model
    echo $form->field($model, 'form_id')->widget(Select2::classname(), [
        'data' => $forms,
        'options' => ['placeholder' => Yii::t('google_analytics', 'Select a form...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(Yii::t('google_analytics', 'Form')); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'tracking_id')->textInput([
                'maxlength' => true,
                'placeholder' => 'UA-000000-01'
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'tracking_domain')->textInput([
                'maxlength' => true,
                'placeholder' => 'example.com'
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->widget(SwitchInput::className()) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'anonymize_ip')->widget(SwitchInput::className()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?
            Yii::t('google_analytics', 'Create') :
            Yii::t('google_analytics', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>