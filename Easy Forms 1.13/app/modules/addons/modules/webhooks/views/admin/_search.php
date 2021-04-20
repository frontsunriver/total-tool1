<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\webhooks\models\WebhookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webhook-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'form_id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'handshake_key') ?>

    <?php // echo $form->field($model, 'json') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('webhooks', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('webhooks', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>