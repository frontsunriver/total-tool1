<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

$this->title = Yii::t('setup', 'Congratulations, you installed Easy Forms');

/* @var $cronUrl string */

?>

<div class="row">
    <div class="col-sm-4">
        <ul class="list-group">
            <li class="list-group-item">
                <?= Yii::t('setup', 'Choose language') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('setup', 'Verify requirements') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('setup', 'Set up database') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('setup', 'Install app') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('setup', 'Create admin account') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item list-group-item-current">
                <?= Yii::t('setup', 'Finished') ?>
            </li>
        </ul>
    </div>
    <div class="col-sm-8 form-wrapper">
        <?= Html::tag('h4', Yii::t('setup', 'Congratulations, you installed Easy Forms'), ['class' => 'step-title']) ?>
        <p class="text-success"><span class="glyphicon glyphicon-ok"> </span>
            <?= Yii::t('setup', 'Installation was completed successfully.') ?>
        </p>
        <?= Html::tag('h5', Yii::t('setup', 'Next Steps'), ['class' => 'step-title']) ?>
        <ul>
            <li><?= Yii::t('setup', 'Add the following cron job to your server') ?>: <br>
                <strong><?= Yii::t('setup', 'Frequency') ?>:</strong> Every minute (* * * * *) <br>
                <strong><?= Yii::t('setup', 'Command') ?>:</strong> <code>wget -O /dev/null -q -t 1 "<?= $cronUrl ?>"</code>
            </li>
            <?php if (file_exists(Yii::getAlias('@app/easy_forms.sql'))): ?>
            <li><?= Yii::t('setup', "Remove the '/install.php' file and '/easy_forms.sql' file from your application.") ?></li>
            <?php else: ?>
            <li><?= Yii::t('setup', "Remove the '/install.php' file from your application.") ?></li>
            <?php endif; ?>
        </ul>
        <p class="text-muted">
            <?= Yii::t('setup', 'Note: If you have problems in running the cron jobs, get in touch with our support team and we will be more than happy to help you.') ?>
        </p>
        <a href="<?= Url::to(Url::home(true)) ?>" class="btn btn-primary">
            <?= Yii::t('setup', 'Go to Easy Forms') ?>
        </a>
    </div>
</div>
