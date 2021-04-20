<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = Yii::t('app', 'System Tools');

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>
<div class="settings-performance">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="glyphicon glyphicon-settings" style="margin-right: 5px;"></i>
                <?= Html::encode($this->title) ?>
            </h3>
        </div>
        <div class="panel-body">
            <p><?= Yii::t('app', 'If you have any problem with your site settings or you want to improve the application performance, you can use the following tools.') ?></p>
            <p><strong><?= Yii::t('app', 'Try the following tools.')?></strong></p>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t("app", "Run cron") ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="" style="">
                        <?php $urlParams = [
                            '/cron',
                            'cron_key' => Yii::$app->params['App.Cron.cronKey'],
                        ]; ?>
                        <p><?= Yii::t('app', 'To configure your Cron Job on cPanel, please use the following details') ?>:</p>
                        <ul>
                            <li><small><strong><?= Yii::t('app', 'Common Settings') ?>:</strong> <?= Yii::t('app', 'Once Per Minute') ?> (* * * * *)</small></li>
                            <li><small><strong><?= Yii::t('app', 'Command') ?>:</strong> wget -O /dev/null -q -t 1 "<?= Url::to($urlParams, true) ?>"</small></li>
                        </ul>
                        <p style="margin-bottom: 0">
                            <?= Yii::t('app', 'You can run cron with third-party applications by using the following url:') ?>
                            <?= Html::a(Url::to($urlParams, true), $urlParams, ['target' => '_blank']) ?>
                        </p>
                    </div>
                    <?= Html::hiddenInput('action', 'cron'); ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <p class="hint-block">
                        <?= Yii::t('app', 'Cron takes care of running periodic tasks in order to flush mail queue and update stats.') ?>
                    </p>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Yii::t("app", "Refresh cache & assets") ?></h3>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-sm-12" style="padding: 0;">
                        <p><?= Yii::t('app', 'Caching is just one part on making a faster application. Assets are javascript and css files also used by the site.') ?></p>
                        <div class="form-group" style="margin-top: 10px; margin-bottom: 0">
                            <?= Html::submitButton(Html::tag('i', ' ', [
                                    'class' => 'glyphicon glyphicon-refresh',
                                    'style' => 'margin-right: 2px;'
                                ]) . ' ' . Yii::t('app', 'Refresh'), ['class' => 'btn btn-info']) ?>
                        </div>
                    </div>
                    <?= Html::hiddenInput('action', 'cache'); ?>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="panel-footer">
                    <p class="hint-block">
                        <?= Yii::t('app', 'The database schema is stored in the cache to optimize the application performance.') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
