<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Template */
/* @var $form yii\widgets\ActiveForm */
/* @var $categories app\models\TemplateCategory[] */
/* @var $users array [id => username] of user models */
/* @var $templateUsers array [id => username] of user models */

?>

<div class="template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => $categories,
        'options' => ['placeholder' => Yii::t('app', 'Select a category...')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(Yii::t('app', 'Category')); ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?php if (Yii::$app->user->can('changeFormsOwner', ['model' => $model]) && !$model->isNewRecord): ?>
        <?= $form->field($model, 'created_by')->widget(Select2::classname(), [
            'data' => $users,
            'options' => ['placeholder' => 'Select a user...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    <?php endif; ?>

    <?php if (Yii::$app->user->can('shareTemplates', ['model' => $model])): ?>
        <?= $form->field($model, 'shared')->radioButtonGroup(
            \app\models\Template::sharedOptions(),
            [
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
            ]
        ) ?>
        <?= $form->field($model, 'users')->widget(Select2::classname(), [
            'data' => array_diff_key($users, [$model->created_by => $model->created_by]),
            'value' => !empty($templateUsers) ? $templateUsers : null,
            'options' => ['placeholder' => 'Select users...'],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
            ],
        ])
            ->label(Yii::t('app', 'Users'))
            ->hint(Yii::t("app", "These users will have access to this template.")) ?>
    <?php endif; ?>

    <?= $form->field($model, 'promoted')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS

    $( document ).ready(function(){
        // Handlers
        toggleShared = function (e) {
            if(e.val() === "0" || e.val() === "1") {
                $('.field-template-users').hide();
            } else if (e.val() === "2") {
                $('.field-template-users').show();
            }
        };
        $('#template-shared').find( ".btn" ).on('click', function(e) {
            toggleShared($(this).children());
        });
        toggleShared($('[name$="Template[shared]"]:checked'));
    });

JS;

$this->registerJs($script, $this::POS_END);
