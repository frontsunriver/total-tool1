<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\color\ColorInput;
use kartik\select2\Select2;
use app\bundles\ThemeEditorBundle;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Theme */
/* @var $forms array [id => name] of form models */
/* @var $users array [id => username] of user models */
/* @var $themeUsers array [id => name] of user models with access to theme model */

ThemeEditorBundle::register($this);

$data = array();

// Set data for select2 widget
foreach ($forms as $form) {
    $key = Url::to(['app/preview', 'id' => $form['id']], true);
    $data[$key] = $form['name'];
}

// PHP options required by editor.js
$options = array(
    "css" => "#theme-css",
    "iframe" => "formI"
);

// Pass php options to javascript, and load beofre ThemeEditorBundle
$this->registerJs("var options = ".json_encode($options).";", $this::POS_BEGIN, 'editor-options');

if ($model->isNewRecord) {
// By default, it's shared with no one
    $model->shared = $model::SHARED_NONE;
}

?>

<div class="theme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => Yii::t("app", "Select color ...")],
        'noSupport' => Yii::t('app', 'It is recommended you use an upgraded browser to display the {type} control properly.'),
        'pluginOptions'=> ['preferredFormat' => 'hex']
    ])->hint(Yii::t("app", "Your theme main color. Value must be a 6 character hex value starting with a '#'.")); ?>

    <div class="form-group">
        <label class="control-label"><?= Yii::t("app", "Live Preview") ?></label>
        <?php echo Select2::widget([
                'name' => 'preview',
                'data' => $data,
                'options' => [
                    'placeholder' => Yii::t("app", "Choose a form"),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "select2:select" => "previewSelected",
                    "select2:unselect" => "previewUnselected"
                ]
            ]);
        ?>
    </div>

    <!-- Preview panel -->
    <div class="panel panel-default" id="preview-container" style="display:none;">
        <div class="panel-heading clearfix">
            <div class="summary pull-left"><strong><?= Yii::t("app", "Preview") ?></strong></div>
            <div class="pull-right">
                <a id="resizeFull" class="toogleButton" href="javascript:void(0)">
                    <i class="glyphicon glyphicon-resize-full"></i>
                </a>
                <a id="resizeSmall" class="toogleButton" style="display: none" href="javascript:void(0)">
                    <i class="glyphicon glyphicon-resize-small"></i>
                </a>
            </div>
        </div>
        <div class="panel-body" id="preview">
        </div>
    </div>

    <?= $form->field($model, 'css')->hiddenInput() ?>

    <div class="form-group">
        <div id="editor" class="form-control"></div>
    </div>

    <?php if (Yii::$app->user->can('changeFormsOwner', ['model' => $model])): ?>
        <?= $form->field($model, 'created_by')->widget(Select2::classname(), [
            'data' => $users,
            'options' => ['placeholder' => 'Select a user...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    <?php endif; ?>

    <?php if (Yii::$app->user->can('shareThemes', ['model' => $model])): ?>
        <?= $form->field($model, 'shared')->radioButtonGroup(
            \app\models\Theme::sharedOptions(),
            [
                'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary']],
                'style' => 'display:block; margin-bottom:15px; overflow:hidden',
            ]
        ) ?>

        <?= $form->field($model, 'users')
            ->widget(Select2::classname(), [
                'data' => array_diff_key($users, [$model->created_by => $model->created_by]),
                'value' => !empty($themeUsers) ? $themeUsers : null,
                'options' => ['placeholder' => 'Select users...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true,
                ],
            ])
            ->label(Yii::t('app', 'Users'))
            ->hint(Yii::t("app", "These users will have access to this theme.")) ?>
    <?php endif; ?>

    <div class="form-group" style="text-align: right; margin-top: 20px">
        <?php if (!$model->isNewRecord): ?>
            <?= Html::submitButton(Yii::t('app', 'Save and continue'), [
                'name' => 'continue',
                'class' => 'btn btn-default',
                'style' => 'margin-right: 5px'
            ]) ?>
        <?php endif; ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

    $( document ).ready(function(){
        // Handlers
        toggleShared = function (e) {
            if(e.val() === "0" || e.val() === "1") {
                $('.field-theme-users').hide();
            } else if (e.val() === "2") {
                $('.field-theme-users').show();
            }
        };
        $('#theme-shared').find( ".btn" ).on('click', function(e) {
            toggleShared($(this).children());
        });
        toggleShared($('[name$="Theme[shared]"]:checked'));
    });

JS;

$this->registerJs($script, $this::POS_END);
