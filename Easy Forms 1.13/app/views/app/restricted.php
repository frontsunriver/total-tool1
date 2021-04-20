<?php

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\bootstrap\Button;

/* @var $this yii\web\View */
/* @var app\models\forms\RestrictedForm $model */
/* @var app\models\Form $formModel */

// PHP options required by embed.js
$options = array(
    "id" => $formModel->id,
);
// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'form-options');

?>
<div class="container app-restricted" style="padding-top: 10px; padding-bottom: 10px">
    <div class="row">
        <div class="col-xs-12">
            <h3 class="legend text-danger"><?= Yii::t('app', 'Access to this form is restricted.') ?></h3>
            <?php $form = ActiveForm::begin([
                'id' => 'password-form',
                'enableClientValidation' => false,
                'options' => [
                    'autocomplete' => 'off'
                ]
            ]); ?>
            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app', 'Please enter your password.')
                ]
            ])->passwordInput()->label(Yii::t('app', 'Password')) ?>
            <?= Button::widget([
                'label' => Yii::t('app', 'Submit'),
                'options' => ['class' => 'btn-primary'],
            ]); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
// Utilities required for javascript
$this->registerJsFile('@web/static_files/js/form.utils.min.js', ['depends' => \yii\web\JqueryAsset::className()]);

$js = <<<JS
    jQuery(document).ready(function(){

        // Send the new height to the parent window
        Utils.postMessage({
            height: $("body").outerHeight(true)
        });

    });
JS;

$this->registerJs($js, $this::POS_END, 'password');

?>