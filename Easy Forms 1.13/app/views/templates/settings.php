<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Template */
/* @var $categories app\models\TemplateCategory[] */
/* @var $users array [id => username] of user models */
/* @var $templateUsers array [id => username] of user models */

$this->title = Yii::t('app', 'Template Settings') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>
<div class="template-update box box-big box-light">

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Template Settings') ?>
            <span class="box-subtitle"><?= Html::encode($model->name) ?></span>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'users' => $users,
        'templateUsers' => $templateUsers,
    ]) ?>

</div>