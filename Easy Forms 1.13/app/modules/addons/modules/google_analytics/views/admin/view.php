<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\google_analytics\models\Account */

$this->title = Yii::t('google_analytics', 'Form Tracking') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Add-ons'), 'url' => ['/addons']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Google Analytics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ga-view box box-big box-light">

    <div class="pull-right" style="margin-top: -5px">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $model->id], [
            'title' => Yii::t('google_analytics', 'Update'),
            'class' => 'btn btn-sm btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ', ['delete', 'id' => $model->id], [
            'title' => Yii::t('google_analytics', 'Delete'),
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => Yii::t(
                    'google_analytics',
                    'Are you sure you want to delete this tracking configuration? All data related to this item will be deleted. This action cannot be undone.'
                ),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('google_analytics', 'Form Tracking') ?>
            <span class="box-subtitle"><?= $model->id ?></span>
        </h3>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=>'form',
                'format'=>'raw',
                'value'=> Html::encode($model->form->name),
            ],
            'tracking_id',
            'tracking_domain',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=> ($model->status === 1) ? '<span class="label label-success"> '.
                    Yii::t('google_analytics', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('google_analytics', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('google_analytics', 'ON'),
                        'offText' => Yii::t('google_analytics', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'anonymize_ip',
                'format'=>'raw',
                'value'=> ($model->anonymize_ip === 1) ? '<span class="label label-success"> '.
                    Yii::t('google_analytics', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('google_analytics', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('google_analytics', 'ON'),
                        'offText' => Yii::t('google_analytics', 'OFF'),
                    ]
                ],
            ],
        ],
    ]) ?>

</div>