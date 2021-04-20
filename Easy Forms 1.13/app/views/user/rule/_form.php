<?php

/**
 * @var $this  yii\web\View
 * @var $model \Da\User\Model\Rule
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php $form = ActiveForm::begin(
    [
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]
) ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'className') ?>

<div class="form-action">
    <?= Html::submitButton(
        '<i class="glyphicon glyphicon-ok" style="margin-right: 3px"></i> ' .
        Yii::t('app', 'Save'), ['class' => 'btn btn-primary']
    ) ?>
</div>

<?php ActiveForm::end() ?>
