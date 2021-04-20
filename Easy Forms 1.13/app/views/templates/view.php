<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="template-view box box-big box-light">

    <div class="pull-right" style="margin-top: -5px">
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('updateTemplates', ['model' => $model])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $model->id], [
                    'title' => Yii::t('app', 'Update Template'),
                    'class' => 'btn btn-sm btn-info']) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('updateTemplates', ['model' => $model])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-cogwheel"></span> ', ['settings', 'id' => $model->id], [
                    'title' => Yii::t('app', 'Template Settings'),
                    'class' => 'btn btn-sm btn-info']) ?>
            <?php endif; ?>
        </div>
            <?php if (Yii::$app->user->can('createForms', ['model' => $model])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ', ['form/create', 'template' => $model->slug], [
                    'title' => Yii::t('app', 'Create Form'),
                    'class' => 'btn btn-sm btn-success']) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('deleteTemplates', ['model' => $model])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ', ['delete', 'id' => $model->id], [
                    'title' => Yii::t('app', 'Delete Template'),
                    'class' => 'btn btn-sm btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this template? All data related to this item will be deleted. This action cannot be undone.'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Template') ?>
            <span class="box-subtitle"><?= Html::encode($this->title) ?></span>
        </h3>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'hideIfEmpty'=>true,
        'options' => [
            'class' => 'kv-view-mode', // Fix hideIfEmpty if enableEditMode is false
        ],
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'category',
                'value' => isset($model->category) ? Html::encode($model->category->name) : null,
                'label' => Yii::t('app', 'Category'),
            ],
            'description',
            [
                'attribute' => 'html',
                'format'=>'raw',
                'value' => Html::decode($model->html),
                'label' => Yii::t('app', 'Preview'),
            ],
            [
                'attribute'=>'promoted',
                'format'=>'raw',
                'value'=> ($model->promoted === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-default"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute' => 'author',
                'value' => $model->author->username,
                'label' => Yii::t('app', 'Created by'),
            ],
            [
                'attribute' => 'created_at',
                'value' => $model->created,
                'label' => Yii::t('app', 'Created'),
            ],
            [
                'attribute' => 'lastEditor',
                'value' => $model->lastEditor->username,
                'label' => Yii::t('app', 'Last Editor'),
            ],
            [
                'attribute' => 'updated_at',
                'value' => $model->updated,
                'label' => Yii::t('app', 'Updated'),
            ],
        ],
    ]) ?>

</div>
<?php
// Disable form submit
$js = <<<JS
jQuery(document).ready(function(){
    jQuery('form').submit(function() {
        return false;
    });
});
JS;
$this->registerJs($js, $this::POS_END);
