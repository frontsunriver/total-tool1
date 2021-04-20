<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\addons\modules\google_analytics\models\Account */
/* @var $forms array [id => name] of Form models */

$this->title = Yii::t('google_analytics', 'Create Form Tracking');
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Add-ons'), 'url' => ['/addons']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('google_analytics', 'Google Analytics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="google-analytics-create box box-big box-light">

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('google_analytics', 'Create Form Tracking') ?>
            <span class="box-subtitle"><?= Html::encode($model->id) ?></span>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'forms' => $forms,
    ]) ?>

</div>