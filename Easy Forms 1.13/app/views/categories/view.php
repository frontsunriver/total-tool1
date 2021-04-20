<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use Carbon\Carbon;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateCategory */
/* @var $searchModel app\models\search\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['/templates']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Carbon::setLocale(substr(Yii::$app->language, 0, 2)); // eg. en-US to en
?>
<div class="template-category-view box box-big box-light">

    <div class="pull-right" style="margin-top: -5px">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $model->id], [
            'title' => Yii::t('app', 'Update Template'),
            'class' => 'btn btn-sm btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ', ['delete', 'id' => $model->id], [
            'title' => Yii::t('app', 'Delete Template'),
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this template category? All data related to this item will be deleted. This action cannot be undone.'),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Template Category') ?>
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
            'description',
            [
                'attribute' => 'created_at',
                'value' => $model->created,
                'label' => Yii::t('app', 'Created'),
            ],
            [
                'attribute' => 'updated_at',
                'value' => $model->updated,
                'label' => Yii::t('app', 'Updated'),
            ],
        ],
    ]) ?>

</div>