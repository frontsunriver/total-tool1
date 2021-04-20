<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\addons\modules\google_analytics\models\AccountSearch */
?>

<div class="ga-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'form_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'tracking_id') ?>

    <?= $form->field($model, 'tracking_domain') ?>

    <?php // echo $form->field($model, 'anonymize_ip') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('google_analytics', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('google_analytics', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>