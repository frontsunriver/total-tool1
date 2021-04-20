<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $forms array [id => name] of form models */
/* @var $users array [id => username] of user models */
/* @var $themeUsers array [id => username] of user models */

$this->title = Yii::t('app', 'Update Theme') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="theme-update box box-big box-light">

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Update Theme') ?>
            <span class="box-subtitle"><?= Html::encode($model->name) ?></span>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'forms' => $forms,
        'users' => $users,
        'themeUsers' => $themeUsers,
    ]) ?>

</div>
