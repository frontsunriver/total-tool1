<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $default boolean */
/* @var $message string */
/* @var app\models\Form $formModel */

if ($default) {
    $icon = Html::tag('span', ' ', [
        'class' => 'glyphicon glyphicon-ok-circle text-success',
        'style' => 'font-size: 72px; margin-bottom: 15px;'
    ]);
    $message = Html::tag('h3', $message, ['class' => 'text-center']);
} else {
    $icon = Html::tag('span', ' ', [
        'class' => 'glyphicon glyphicon-ok-circle text-success',
        'style' => 'font-size: 72px; margin-bottom: 15px;'
    ]);
}
?>
<div class="app-valid text-center" style="margin-top: 120px">
    <?= Html::decode($icon) ?>
    <?= Html::decode($message) ?>
</div>
