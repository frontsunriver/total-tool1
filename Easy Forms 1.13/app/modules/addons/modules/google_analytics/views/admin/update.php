<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\google_analytics\models\Account */
/* @var $forms array [id => name] of Form models */

$this->title = Yii::t('google_analytics', 'Update Form Tracking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Add-ons'), 'url' => ['/addons']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Google Analytics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Form Tracking') .' '.
    $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('google_analytics', 'Update');
?>
<div class="google-analytics-update box box-big box-light">

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