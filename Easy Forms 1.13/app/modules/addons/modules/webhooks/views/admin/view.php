<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\webhooks\models\Webhook */

$this->title = Yii::t('webhooks', 'Webhook') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('webhooks', 'Add-ons'), 'url' => ['/addons']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('webhooks', 'Webhooks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webhooks-view box box-big box-light">


    <div class="pull-right" style="margin-top: -5px">
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $model->id], [
            'title' => Yii::t('webhooks', 'Update'),
            'class' => 'btn btn-sm btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ', ['delete', 'id' => $model->id], [
            'title' => Yii::t('webhooks', 'Delete'),
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => Yii::t(
                    'webhooks',
                    'Are you sure you want to delete this webhook? All data related to this item will be deleted. This action cannot be undone.'
                ),
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('webhooks', 'Webhook') ?>
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
            'url',
            'handshake_key',
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=> ($model->status === 1) ? '<span class="label label-success"> '.
                    Yii::t('webhooks', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('webhooks', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('webhooks', 'ON'),
                        'offText' => Yii::t('webhooks', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'json',
                'format'=>'raw',
                'value'=> ($model->json === 1) ? '<span class="label label-success"> '.
                    Yii::t('webhooks', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('webhooks', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('webhooks', 'ON'),
                        'offText' => Yii::t('webhooks', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'alias',
                'format'=>'raw',
                'value'=> ($model->alias === 1) ? '<span class="label label-success"> '.
                    Yii::t('webhooks', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('webhooks', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('webhooks', 'ON'),
                        'offText' => Yii::t('webhooks', 'OFF'),
                    ]
                ],
            ],
        ],
    ]) ?>
</div>