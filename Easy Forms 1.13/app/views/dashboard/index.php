<?php

use Carbon\Carbon;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $users int */
/* @var $submissions int */
/* @var $submissionRate int */
/* @var $totalUsers int */
/* @var $totalSubmissions int */
/* @var $totalSubmissionRate int */
/* @var $formsByUsers array */
/* @var $formsBySubmissions array */
/* @var $lastUpdatedForms array */
/* @var $unreadSubmissions \app\models\FormSubmission[] */

$this->title = Yii::t("app", "Dashboard");
$this->params['breadcrumbs'][] = Yii::t('app', 'Summary');

Carbon::setLocale(substr(Yii::$app->language, 0, 2)); // eg. en-US to en

?>
<?php if (@file_exists(Yii::getAlias('@app/install.php'))): ?>
<div class="alert-danger alert fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <span class="glyphicon glyphicon-remove-sign"> </span> <?= Yii::t(
        'app',
        "For security reasons you must remove the 'install.php' file from your application directory."
    ) ?>
</div>
<?php endif; ?>
<?php if (@file_exists(Yii::getAlias('@app/easy_forms.sql'))): ?>
<div class="alert-danger alert fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <span class="glyphicon glyphicon-remove-sign"> </span> <?= Yii::t(
        'app',
        "For security reasons you must remove the 'easy_forms.sql' file from your application directory."
    ) ?>
</div>
<?php endif; ?>
<?php if (Yii::$app->getModule('update')): ?>
<div class="alert-danger alert fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <span class="glyphicon glyphicon-remove-sign"> </span> <?= Yii::t(
        'app',
        "For security reasons you must disable the application updates. Add-ons features are disabled to avoid unexpected behaviour in the meantime."
    ) ?>
</div>
<?php endif; ?>
<div class="dashboard-page">
    <div class="page-header">
        <h1><?= Yii::t('app', 'Dashboard') ?>
            <small><?= Yii::t('app', 'Today Summary') ?></small>
        </h1>
    </div>

    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-counter today-views">
                <div class="panel-counter-info">
                    <div class="panel-counter-icon"><i class="glyphicon glyphicon-parents"></i></div>
                    <div class="panel-counter-title">
                        <div class="counter"><?= $users ?></div>
                        <div class="counter-title"><?= Yii::t('app', 'Unique Users') ?></div>
                    </div>
                </div>
                <div class="panel-counter-sub">
                    <h5>
                        <?= Yii::t('app', 'All time Users') ?> <span class="total-counter"><?= $totalUsers ?></span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-counter today-submissions">
                <div class="panel-counter-info">
                    <div class="panel-counter-icon"><i class="glyphicon glyphicon-send"></i></div>
                    <div class="panel-counter-title">
                        <div class="counter"><?= $submissions ?></div>
                        <div class="counter-title"><?= Yii::t('app', 'Submissions') ?></div>
                    </div>
                </div>
                <div class="panel-counter-sub">
                    <h5><?= Yii::t('app', 'All time Submissions') ?>
                        <span class="total-counter"><?= $totalSubmissions ?></span>
                    </h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-counter today-submission-rate">
                <div class="panel-counter-info">
                    <div class="panel-counter-icon"><i class="glyphicon glyphicon-charts"></i></div>
                    <div class="panel-counter-title">
                        <div class="counter"><?= $submissionRate ?>%</div>
                        <div class="counter-title"><?= Yii::t('app', 'Submission rate') ?></div>
                    </div>
                </div>
                <div class="panel-counter-sub">
                    <h5><?= Yii::t('app', 'All time Rate') ?>
                        <span class="total-counter"><?= $totalSubmissionRate ?>%</span></h5>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="panel panel-counter create-form">
                <?php if (Yii::$app->user->can('createForms')) : ?>
                    <h1>
                        <a href="<?= Url::to(['form/create']) ?>"><span class="glyphicon glyphicon-plus"></span></a>
                    </h1>
                    <h5>
                        <a href="<?= Url::to(['form/create']) ?>"><?= Yii::t('app', 'Create form') ?></a>
                    </h5>
                <?php elseif (Yii::$app->user->can('viewForms', ['listing' => true])) : ?>
                    <h1><a href="<?= Url::to(['/form']) ?>"><span class="glyphicon glyphicon-list-alt"></span></a></h1>
                    <h5><a href="<?= Url::to(['/form']) ?>"><?= Yii::t('app', 'View forms') ?></a></h5>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('app', 'Most viewed') ?></div>
                <div class="list-group">
                    <?php foreach ($formsByUsers as $form) : ?>
                        <a href="<?= Url::to(['form/analytics', 'id' => $form['id']]) ?>" class="list-group-item">
                            <span class="badge"><?= $form['users'] ?></span> <?= Html::encode($form['name']) ?>
                        </a>
                    <?php endforeach; ?>
                    <?php if (count($formsByUsers) == 0) : ?>
                        <div class="list-group-item"><?= Yii::t('app', 'No views today ') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('app', 'Most submitted') ?></div>
                <div class="list-group">
                    <?php foreach ($formsBySubmissions as $form) : ?>
                        <a href="<?= Url::to(['form/submissions', 'id' => $form['id']]) ?>" class="list-group-item">
                            <span class="badge"><?= $form['submissions'] ?></span> <?= Html::encode($form['name']) ?>
                        </a>
                    <?php endforeach; ?>
                    <?php if (count($formsBySubmissions) == 0) : ?>
                        <div class="list-group-item"><?= Yii::t('app', 'No submits today') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><?= Yii::t('app', 'Unread submissions') ?></div>
                <div class="list-group">
                    <?php foreach ($unreadSubmissions as $unread) : ?>
                        <a href="<?= Url::to(['/form/submissions', 'id' => $unread->form->id, '#' => 'view/' . $unread->id]) ?>"
                           class="list-group-item" title="<?= Html::encode($unread->form->name) ?> #<?= $unread->id ?>">
                            <?= StringHelper::truncateWords(Html::encode($unread->form->name), 5) ?> #<?= $unread->id ?>
                            <span class="label label-info">
                                <?= Carbon::createFromTimestampUTC($unread->created_at)->diffForHumans() ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                    <?php if (count($unreadSubmissions) == 0) : ?>
                        <div class="list-group-item"><?= Yii::t('app', 'No data') ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
