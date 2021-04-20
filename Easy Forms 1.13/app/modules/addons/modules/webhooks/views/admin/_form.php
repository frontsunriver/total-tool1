<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\webhooks\models\Webhook */
/* @var $form yii\widgets\ActiveForm */
/* @var $forms array [id => name] of Form models */
?>

<div class="webhook-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->field($model, 'form_id')->widget(Select2::classname(), [
                'data' => $forms,
                'options' => [
                    'placeholder' => Yii::t('webhooks', 'Select a form...'),
                    'multiple' => $model->isNewRecord
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(Yii::t('webhooks', 'Form')); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'url')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('webhooks', 'Your web hook url'),
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'handshake_key')->textInput([
                'maxlength' => true,
                'placeholder' => Yii::t('webhooks', 'Your handshake key'),
            ]) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'status')->widget(SwitchInput::className()) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'json')->widget(SwitchInput::className()) ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'alias')->widget(SwitchInput::className()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ?
            Yii::t('webhooks', 'Create') :
            Yii::t('webhooks', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>