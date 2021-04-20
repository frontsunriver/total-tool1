<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\webhooks\models\Webhook */
/* @var $forms array [id => name] of Form models */

$this->title = Yii::t('webhooks', 'Update Webhook');
$this->params['breadcrumbs'][] = ['label' => Yii::t('webhooks', 'Add-ons'), 'url' => ['/addons']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('webhooks', 'Webhooks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('webhooks', 'Webhook') .' '.
    $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('webhooks', 'Update');

?>
<div class="webhook-update box box-big box-light">

    <div class="box-header">
        <h3 class="box-title"><?= $this->title ?>
            <span class="box-subtitle"><?= Html::encode($model->id) ?></span>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'forms' => $forms,
    ]) ?>

</div>
