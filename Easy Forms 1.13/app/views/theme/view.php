<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */

$this->title = isset($model->name) ? $model->name : $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="theme-view box box-big box-light">

    <div class="pull-right" style="margin-top: -5px">
        <?php if (Yii::$app->user->can('updateThemes', ['model' => $model])) : ?>
            <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $model->id], [
                'title' => Yii::t('app', 'Update Theme'),
                'class' => 'btn btn-sm btn-info']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('deleteThemes', ['model' => $model])) : ?>
            <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ', ['delete', 'id' => $model->id], [
                'title' => Yii::t('app', 'Delete Theme'),
                'class' => 'btn btn-sm btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this theme? All data related to this item will be deleted. This action cannot be undone.'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>

    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Theme') ?>
            <span class="box-subtitle"><?= Html::encode($this->title) ?></span>
        </h3>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode'=> false,
        'hideIfEmpty'=>true,
        'options' => [
            'class' => 'kv-view-mode', // Fix hideIfEmpty if enableEditMode is false
        ],
        'attributes' => [
            'id',
            'name',
            'description',
            [
                'attribute'=>'color',
                'format'=>'raw',
                'value'=>"<span class='badge' style='background-color: {$model->color}'>&nbsp;</span> <code>" .
                    $model->color . '</code>',
                'type'=>DetailView::INPUT_COLOR,
            ],
            //'css:ntext',
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
