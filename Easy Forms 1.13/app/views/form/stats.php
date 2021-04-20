<?php

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
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Submissions"),
    'url' => ['submissions', 'id' => $formModel->id]];
$this->params['breadcrumbs'][] = Yii::t("app", "Submissions Analytics");

// PHP options required by submissions.stats.js
$options = array(
    "form_id" => $formModel->id,
    "endPoint" => Url::to(['ajax/stats', 'id' => $formModel->id]),
    "countriesJSON" => Yii::getAlias('@web') . '/static_files/json/world-countries.json',
    "i18n" => [
        "yes" => Yii::t('app', 'Yes'),
        "no" => Yii::t('app', 'No'),
        "noData" => Yii::t('app', 'No data'),
    ]
);

// Pass php options to javascript before VisualizationBundle
$this->registerJs("var options = ".json_encode($options).";", $this::POS_BEGIN, 'stats-options');

// Load submissions.stats.js after VisualizationBundle
$this->registerJsFile('@web/static_files/js/submissions.stats.js', ['depends' => VisualizationBundle::className()]);

?>
<div class="analytics-page box box-big box-light">

    <div class="pull-right">
        <small><?= Html::a(Yii::t('app', 'Performance Analytics') .
                ' <span class="glyphicon glyphicon-arrow-right"> </span> ', ['analytics', 'id' => $formModel->id], [
            'title' => Yii::t('app', 'Go to Performance Analytics'),
            'class' => 'text-muted hidden-xs']) ?></small>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Html::encode($this->title) ?>
            <span class="box-subtitle"><?= Yii::t('app', 'Submissions Analytics') ?></span>
        </h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="data-count" style="float: left;">
                <span><?= Yii::t("app", "You're visualizing the data of {filterCount} submissions from a total of {totalCount} submissions.", [
                            "filterCount" => "<span class='filter-count'></span>",
                            "totalCount" => "<span class='total-count'></span>"
                    ]); ?> <a href="javascript:dc.filterAll(); dc.renderAll();">
                        <?= Yii::t('app', 'Reset All') ?></a>.</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h4><?= Yii::t('app', 'Timeline') ?></h4>
            <div id="date">
                <div id="date-chart"></div>
            </div>
        </div>
        <div class="col-md-4">
            <h4><?= Yii::t("app", "Sessions before submission") ?></h4>
            <div id="sessions">
                <div id="sessions-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h4><?= Yii::t("app", "By country") ?></h4>
            <div id="world">
                <div id="world-chart"></div>
            </div>
        </div>
        <div class="col-md-4">
            <h4><?= Yii::t("app", "Top cities") ?></h4>
            <div id="city">
                <div id="city-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h4><?= Yii::t("app", "Submissions by hour") ?></h4>
            <div id="hour">
                <div id="hour-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h4><?= Yii::t("app", "Is mobile?") ?></h4>
            <div id="ismobile">
                <div id="ismobile-chart"></div>
            </div>
        </div>
        <div class="col-md-4">
            <h4><?= Yii::t("app", "By referrer type") ?></h4>
            <div id="referrer">
                <div id="referrer-chart"></div>
            </div>
        </div>
        <div class="col-md-4">
            <h4><?= Yii::t("app", "Top referrers") ?></h4>
            <div id="domain">
                <div id="domain-chart"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h4><?= Yii::t("app", "By device category") ?></h4>
            <div id="device">
                <div id="device-chart"></div>
            </div>
        </div>
        <div class="col-md-4">
            <h4><?= Yii::t("app", "By Operating System") ?></h4>
            <div id="os">
                <div id="os-chart"></div>
            </div>
        </div>
        <div class="col-md-4">
            <h4><?= Yii::t("app", "By browser") ?></h4>
            <div id="browser">
                <div id="browser-chart"></div>
            </div>
        </div>
    </div>

</div>