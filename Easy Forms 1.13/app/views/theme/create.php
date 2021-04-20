<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Theme */
/* @var $forms array [id => name] of form models */
/* @var $users array [id => username] of user models */
/* @var $themeUsers array [id => username] of user models */

$this->title = Yii::t('app', 'Create Theme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Themes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="theme-create box box-big box-light">

    <div class="box-header">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'forms' => $forms,
        'users' => $users,
        'themeUsers' => $themeUsers,
    ]) ?>

</div>
