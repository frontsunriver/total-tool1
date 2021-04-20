<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use app\helpers\Language;

$this->title = Yii::t('update', 'Choose language');

// Languages array
$languages = Language::supportedLanguages();

?>

<div class="row">
    <div class="col-sm-4">
        <ul class="list-group">
            <li class="list-group-item">
                <?= Yii::t('update', 'Choose language') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item list-group-item-current"><?= Yii::t('update', 'Requirements') ?></li>
            <li class="list-group-item"><?= Yii::t('update', 'Update app') ?></li>
            <li class="list-group-item"><?= Yii::t('update', 'Finished') ?></li>
        </ul>
    </div>
    <div class="col-sm-8 form-wrapper">
        <?= Html::tag('h4', Yii::t('update', 'Requirements'), ['class' => 'step-title']) ?>
        <?= Html::tag('p', Yii::t('update', 'If you have performed the next steps, you may proceed to update Easy Forms.')) ?>
        <?= Html::ol(
            [
                Yii::t('update', 'Back up your database.'),
                Yii::t('update', 'Backup your files.'),
                Yii::t(
                    'update',
                    'Install your new files in the right location, as described in the documentation.'
                ),
            ],
            [
                'item' => function ($item) {
                    return Html::tag('li', $item, ['class' => 'post']);
                }
            ]
        ) ?>

        <div class="form-action">
            <a id="continue" href="<?= Url::to(['3']) ?>" class="btn btn-primary">
                <?= Yii::t('update', 'Update to Easy Forms {version}', ['version' => Yii::$app->version]) ?>
            </a>
        </div>
    </div>
</div>