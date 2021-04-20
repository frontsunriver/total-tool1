<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $users array [id => username] of user models */
/* @var $addonUsers array [id => username] of user models */
/* @var $roles array [name => description] of user roles */
/* @var $addonRoles array [name => description] of user roles with access to addon model */

$this->title = Yii::t('app', 'Configure Add-on') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('addon', 'Add-ons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add-on Settings');
?>
<div class="addon-update box box-big box-light">

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Add-on Settings') ?>
            <span class="box-subtitle"><?= Html::encode($model->name) ?></span>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'roles' => $roles,
        'addonUsers' => $addonUsers,
        'addonRoles' => $addonRoles,
    ]) ?>

</div>
