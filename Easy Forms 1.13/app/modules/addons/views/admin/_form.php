<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \app\modules\addons\models\Addon */
/* @var $users array [id => username] of user models */
/* @var $addonUsers array [id => name] of user models with access to addon model */
/* @var $roles array [name => description] of user roles */
/* @var $addonRoles array [name] of user roles with access to addon model */

?>

<div class="addon-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'status')->widget(SwitchInput::className()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <?php if (Yii::$app->user->can('changeAddonsOwner', ['model' => $model])): ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'created_by')->widget(Select2::classname(), [
                    'data' => $users,
                    'options' => ['placeholder' => 'Select a user...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->user->can('shareAddons', ['model' => $model])): ?>
        <?= $form->field($model, 'shared')->radioButtonGroup(
            \app\modules\addons\models\Addon::sharedOptions(),
            [
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
            ]
        ) ?>

        <?= $form->field($model, 'users')
            ->widget(Select2::classname(), [
                'data' => array_diff_key($users, [$model->created_by => $model->created_by]),
                'value' => !empty($addonUsers) ? $addonUsers : null,
                'options' => ['placeholder' => 'Select users...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true,
                ],
            ])
            ->label(Yii::t('app', 'Users'))
            ->hint(Yii::t("app", "These users will have access to this add-on.")) ?>

        <?php $model->roles = $addonRoles; // initial value ?>
        <?= $form->field($model, 'roles')
            ->widget(Select2::classname(), [
                'data' => $roles,
                'options' => ['placeholder' => 'Select roles...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true,
                ],
            ])
            ->label(Yii::t('app', 'Roles'))
            ->hint(Yii::t("app", "These user roles will have access to this add-on.")) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

    $( document ).ready(function(){
        // Handlers
        toggleShared = function (e) {
            if(e.val() === "0" || e.val() === "1") {
                $('.field-addon-users').hide();
                $('.field-addon-roles').hide();
            } else if (e.val() === "2") {
                $('.field-addon-users').show();
                $('.field-addon-roles').show();
            }
        };
        $('#addon-shared').find( ".btn" ).on('click', function(e) {
            toggleShared($(this).children());
        });
        toggleShared($('[name$="Addon[shared]"]:checked'));
    });

JS;

$this->registerJs($script, $this::POS_END);
