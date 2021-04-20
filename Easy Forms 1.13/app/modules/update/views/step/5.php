<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

$this->title = Yii::t('update', 'Congratulations, you have updated Easy Forms!');

?>

<div class="row">
    <div class="col-sm-4">
        <ul class="list-group">
            <li class="list-group-item">
                <?= Yii::t('update', 'Choose language') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('update', 'Requirements') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('update', 'Update app') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item list-group-item-current">
                <?= Yii::t('update', 'Finished') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
        </ul>
    </div>
    <div class="col-sm-8 form-wrapper">
        <?= Html::tag('h4', Yii::t('update', 'Congratulations, you have updated Easy Forms!'), ['class' => 'step-title']) ?>
        <p class="text-success"><span class="glyphicon glyphicon-ok"> </span>
            <?= Yii::t('update', 'You have successfully updated your Easy Forms application.') ?>
        </p>
        <?= Html::tag('h5', Yii::t('update', 'Next Step'), ['class' => 'step-title']) ?>
        <ul>
            <li>
                <?= Yii::t(
                    'update',
                    'For security reasons, you must comment again the uncommented line in the "config/web.php" file.'
                ) ?>
            </li>
        </ul>
        <p class="text-muted">
            <?= Yii::t('update', 'Note: If you have problems running your site, get in touch with our support team and we will be more than happy to help you.') ?>
        </p>
        <a href="<?= Url::to(Url::home(true)) ?>" class="btn btn-primary">
            <?= Yii::t('update', 'Go to Easy Forms') ?>
        </a>
    </div>
</div>
