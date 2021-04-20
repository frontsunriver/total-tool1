<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use app\bundles\VisualizationBundle;

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */

VisualizationBundle::register($this);

$this->title = $formModel->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $formModel->name, 'url' => ['view', 'id' => $formModel->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Performance Analytics');

// PHP options required by form.analytics.js
$options = array(
    "endPoint" => Url::to(['ajax/analytics', 'id' => $formModel->id]),
    "i18n" => [
        "users" => Yii::t('app', 'Users'),
        "beganFilling" => Yii::t('app', 'Began Filling'),
        "conversions" => Yii::t('app', 'Conversions'),
        "medianPerDay" => Yii::t('app', 'Median per Day'),
        "minutes" => Yii::t('app', 'minutes'),
        "months" => [
            Yii::t('app', 'Jan'),
            Yii::t('app', 'Feb'),
            Yii::t('app', 'Mar'),
            Yii::t('app', 'Apr'),
            Yii::t('app', 'May'),
            Yii::t('app', 'Jun'),
            Yii::t('app', 'Jul'),
            Yii::t('app', 'Aug'),
            Yii::t('app', 'Sep'),
            Yii::t('app', 'Oct'),
            Yii::t('app', 'Nov'),
            Yii::t('app', 'Dec')
        ],
        "days" => [
            Yii::t('app', 'Sun'),
            Yii::t('app', 'Mon'),
            Yii::t('app', 'Tue'),
            Yii::t('app', 'Wed'),
            Yii::t('app', 'Thu'),
            Yii::t('app', 'Fri'),
            Yii::t('app', 'Sat'),
        ],
    ],
);

// Pass php options to javascript before VisualizationBundle
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'analytics-options');

// Load form.analytics.js after VisualizationBundle
$this->registerJsFile('@web/static_files/js/form.analytics.js', ['depends' => VisualizationBundle::className()]);

?>
<div class="analytics-page box box-big box-light">

    <div class="pull-right">
        <small>
            <?= Html::a(
                Yii::t('app', 'Submissions Analytics') . ' <span class="glyphicon glyphicon-arrow-right"> </span> ',
                ['stats', 'id' => $formModel->id],
                ['title' => Yii::t('app', 'Go to Submissions Analytics'), 'class' => 'text-muted hidden-xs']
            ) ?></small>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Html::encode($this->title) ?>
            <span class="box-subtitle"><?= Yii::t('app', 'Performance Analytics') ?></span>
        </h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="data-count" style="float: left;">
                <span>
                    <?= Yii::t(
                        "app",
                        "You're visualizing the form performance of {filterCount} days from a total of {totalCount} days.",
                        [
                            "filterCount" => "<span class='filter-count'></span>",
                            "totalCount" => "<span class='total-count'></span>"]
                    ); ?>
                    <a href="javascript:dc.filterAll(); dc.renderAll();"><?= Yii::t('app', 'Reset All') ?></a>.</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="conversion-rates">
                <ul>
                    <li><div>
                            <span><?= Yii::t('app', 'Users') ?></span>
                            <h2 id="users-number"></h2>
                            <span id="fills-rate" class="percentage"></span>
                        </div></li>
                    <li><div>
                            <span><?= Yii::t('app', 'Began Filling') ?></span>
                            <h2 id="fills-number"></h2>
                            <span id="completition-rate" class="percentage"></span>
                        </div></li>
                    <li><div>
                            <span><?= Yii::t('app', 'Conversions') ?></span>
                            <h2 id="conversions-number"></h2>
                        </div></li>
                    <li><div>
                            <span><?= Yii::t('app', 'Conversion Rate') ?></span>
                            <h2><span id="conversion-rate"></span>%</h2>
                        </div></li>
                </ul>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-md-12">
            <h4><?= Yii::t('app', 'Timeline') ?></h4>
            <div id="overview">
                <div id="overview-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h4><?= Yii::t('app', 'By year') ?></h4>
            <div id="year">
                <div id="year-chart"></div>
            </div>
        </div>
        <div class="col-md-5">
            <h4><?= Yii::t('app', 'By month') ?></h4>
            <div id="month">
                <div id="month-chart"></div>
            </div>
        </div>
        <div class="col-md-3">
            <h4><?= Yii::t('app', 'By day') ?></h4>
            <div id="week">
                <div id="day-of-week-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h4><?= Yii::t('app', 'Conversion Time') ?></h4>
            <div id="conversion-time">
                <div id="conversion-time-chart"></div>
            </div>
        </div>
        <div class="col-md-9">
            <h4><?= Yii::t('app', 'Conversion Time Average') ?></h4>
            <div id="conversion-time-line">
                <div id="conversion-time-line-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <h4><?= Yii::t('app', 'Conversion vs Abandonment') ?></h4>
            <div id="abandonment">
                <div id="abandonment-chart"></div>
            </div>
        </div>
        <div class="col-md-9">
            <h4><?= Yii::t('app', 'Abandonment Rate') ?></h4>
            <div id="abandonment-time">
                <div id="abandonment-time-chart"></div>
            </div>
        </div>
    </div>

</div>