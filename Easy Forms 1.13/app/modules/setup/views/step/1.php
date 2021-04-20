<?php

use yii\bootstrap\Html;
use app\helpers\Language;

$this->title = Yii::t('setup', 'Choose language');

// Languages array
$languages = Language::supportedLanguages();

?>

<div class="row">
    <div class="col-sm-4">
        <ul class="list-group">
            <li class="list-group-item list-group-item-current"><?= Yii::t('setup', 'Choose language') ?></li>
            <li class="list-group-item"><?= Yii::t('setup', 'Verify requirements') ?></li>
            <li class="list-group-item"><?= Yii::t('setup', 'Set up database') ?></li>
            <li class="list-group-item"><?= Yii::t('setup', 'Install app') ?></li>
            <li class="list-group-item"><?= Yii::t('setup', 'Create admin account') ?></li>
            <li class="list-group-item"><?= Yii::t('setup', 'Finished') ?></li>
        </ul>
    </div>
    <div class="col-sm-8 form-wrapper">
        <?= Html::tag('h4', Yii::t('setup', 'Choose language'), ['class' => 'step-title']) ?>
        <?= Html::beginForm('', 'post', ['class' => 'form-vertical']) ?>
        <div class="form-group">
            <?php // Html::label(Yii::t('setup', 'Choose language'), 'language', ['class' => 'form-label']) ?>
            <?= Html::dropDownList('language', Yii::$app->language, $languages, ['class'=>'form-control']) ?>
        </div>
        <div class="form-group required-control">
            <?= Html::tag('label', Yii::t('setup', 'Purchase Code'), ['class' => 'control-label']) ?>
            <?= Html::textInput('purchase_code', null, ['class'=>'form-control']) ?>
            <span class="hint-block">
                <a href="https://help.market.envato.com/hc/en-us/articles/202822600" target="_blank">
                    <?= Yii::t('setup', 'Where Is My Purchase Code?') ?>
                </a>
            </span>
        </div>
        <div class="form-action">
            <?= Html::submitButton(Yii::t('setup', 'Save and continue'), ['class'=>'btn btn-primary']) ?>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>