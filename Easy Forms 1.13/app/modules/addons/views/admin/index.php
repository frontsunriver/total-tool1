<?php

use app\components\widgets\ActionBar;
use app\components\widgets\GridView;
use app\components\widgets\PageSizeDropDownList;
use app\helpers\Html;
use \app\modules\addons\models\Addon;
use Carbon\Carbon;
use kartik\datecontrol\Module as DateControlModule;
use kartik\switchinput\SwitchInput;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\addons\models\AddonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('addon', 'Add-ons');
$this->params['breadcrumbs'][] = $this->title;

/** @var kartik\datecontrol\Module $dateControlModule */
$dateControlModule = \Yii::$app->getModule('datecontrol');
$dateFormat = $dateControlModule->displaySettings[DateControlModule::FORMAT_DATE];

Carbon::setLocale(substr(Yii::$app->language, 0, 2)); // eg. en-US to en

$gridColumns = [
    [
        'class' => '\kartik\grid\CheckboxColumn',
        'headerOptions' => ['class'=>'kartik-sheet-style'],
        'rowSelectedClass' => GridView::TYPE_WARNING,
    ],
    [
        'attribute'=> 'name',
        'format' => 'raw',
        'value' => function ($model) {
            if ($model->installed && $model->status) {
                return Html::a(Html::encode($model->name), ['/addons/' . $model->id]);
            }
            return $model->name;
        },
    ],
    [
        'attribute'=>'version',
        'value'=> 'version',
        'visible' => Yii::$app->user->can('installAddons', ['listing' => true]),
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'installed',
        'trueIcon'=>'<span class="glyphicon glyphicon-ok text-success"></span>',
        'falseIcon'=>'<span class="glyphicon glyphicon-remove text-danger"></span>',
        'vAlign'=>'middle',
        'visible' => Yii::$app->user->can('installAddons', ['listing' => true]),
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'status',
        'trueIcon'=>'<span class="glyphicon glyphicon-ok text-success"></span>',
        'falseIcon'=>'<span class="glyphicon glyphicon-remove text-danger"></span>',
        'vAlign'=>'middle',
    ],
    [
        'attribute'=>'description',
        'value'=> 'description',
    ],
    [
        'attribute' => 'shared',
        'label' => Yii::t('addon', 'Sharing'),
        'format' => 'raw',
        'hAlign'=>'center',
        'value' => function ($model) {
            $icon = '';
            $currentUser = Yii::$app->user;
            if ($currentUser->id === $model->created_by || $currentUser->can('manageAddons')) {
                $icon = Html::tag('span', ' ', [
                    'title' => $currentUser->id === $model->created_by ? Yii::t('addon', 'Only you can access to this item') : Yii::t('addon', 'Only you and the author can access to this item'),
                    'class' => 'glyphicon glyphicon-lock text-default',
                ]);
                if ((int) $model->shared === \app\modules\addons\models\Addon::SHARED_EVERYONE) {
                    $icon = Html::tag('span', ' ', [
                        'title' => Yii::t('addon', 'Everyone can access to this item'),
                        'class' => 'glyphicon glyphicon-unlock text-danger',
                    ]);
                } elseif ((int) $model->shared === \app\modules\addons\models\Addon::SHARED_WITH_USERS) {
                    $icon = Html::tag('span', ' ', [
                        'title' => Yii::t('addon', 'Specific users can access to this item'),
                        'class' => 'glyphicon glyphicon-group text-default',
                    ]);
                }
            } else if ($currentUser->id !== $model->created_by) {
                $icon = Html::tag('span', ' ', [
                    'title' => Yii::t('addon', 'This item was shared with me'),
                    'class' => 'glyphicon glyphicon-share-alt text-default',
                ]);
            }
            return $icon;
        },
        'filter' => Html::activeDropDownList(
            $searchModel,
            'shared',
            Addon::sharedOptions(),
            ['class'=>'form-control', 'prompt' => '']
        ),
        'visible' => Yii::$app->user->can('shareAddons', ['listing' => true]),
    ],
    [
        'attribute' => 'lastEditor',
        'value' => function ($model) {
            return isset($model->lastEditor, $model->lastEditor->username) ? Html::encode($model->lastEditor->username) : null;
        },
        'label' => Yii::t('addon', 'Updated by'),
        'noWrap'=>true,
        'visible' => Yii::$app->user->can('configureAddons', ['listing' => true]),
    ],
    [
        'attribute'=> 'updated_at',
        'value' => function ($model) {
            return $model->updated;
        },
        'label' => Yii::t('addon', 'Updated'),
        'noWrap'=>true,
        'filterType'=> GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'presetDropdown' => false,
            'convertFormat' => true,
            'containerTemplate' => '
        <div class="form-control kv-drp-dropdown">
            <i class="glyphicon glyphicon-calendar"></i>&nbsp;
            <span class="range-value">{value}</span>
            <span><b class="caret"></b></span>
        </div>
        {input}
',
            'pluginOptions' => [
                'showDropdowns' => true,
                'locale' => [
                    'format' => 'Y-m-d',
                    'separator' => ' - ',
                ],
                'opens' => 'left'
            ]
        ],
        'visible' => Yii::$app->user->can('configureAddons', ['listing' => true]),
    ],
    ['class' => 'kartik\grid\ActionColumn',
        'dropdown'=>true,
        'dropdownButton' => ['class'=>'btn btn-primary'],
        'dropdownOptions' => ['class' => 'pull-right'],
        'template' => '{install}{settings}{uninstall}',
        'buttons' => [
            'settings' => function ($url) {
                $options = array_merge([
                    'title' => Yii::t('addon', 'Settings'),
                    'aria-label' => Yii::t('addon', 'Settings'),
                    'data-pjax' => '0',
                ], []);
                return '<li>'.Html::a('<span class="glyphicon glyphicon-settings"></span> ' .
                        Yii::t('addon', 'Settings'), $url, $options).'</li>';
            },
            'install' => function ($url, $model) {
                $options = array_merge([
                    'title' => Yii::t('app', 'Install'),
                    'aria-label' => Yii::t('app', 'Install'),
                    'data-method' => 'post',
                    'data-params' => [
                        'ids[]' => $model->id,
                    ],
                    'data-pjax' => '0',
                ], []);
                return '<li>'.Html::a(
                        '<span class="glyphicon glyphicon-plus"> </span> '.
                        Yii::t('app', 'Install'),
                        $url,
                        $options
                    ).'</li>';
            },
            'uninstall' => function ($url, $model) {
                $options = array_merge([
                    'title' => Yii::t('app', 'Uninstall'),
                    'aria-label' => Yii::t('app', 'Uninstall'),
                    'data-confirm' => Yii::t('app', 'Are you sure you want to uninstall this add-on? All data related to this item will be deleted. This action cannot be undone.'),
                    'data-method' => 'post',
                    'data-params' => [
                        'ids[]' => $model->id,
                    ],
                    'data-pjax' => '0',
                ], []);
                return '<li>'.Html::a(
                        '<span class="glyphicon glyphicon-bin"> </span> '.
                        Yii::t('app', 'Uninstall'),
                        $url,
                        $options
                    ).'</li>';
            },
        ],
        'urlCreator' => function ($action, $model) {
            if ($action === "settings") {
                $url = Url::to(['/addons/admin/settings', 'id' => $model->id]);
                return $url;
            } elseif ($action === "install") {
                $url = Url::to(['/addons/admin/install']);
                return $url;
            } elseif ($action === "uninstall") {
                $url = Url::to(['/addons/admin/uninstall']);
                return $url;
            }
        },
        'visibleButtons' => [
            'settings' => function ($model, $key, $index) {
                return Yii::$app->user->can('configureAddons', ['model' => $model]);
            },
            'install' => function ($model) {
                return Yii::$app->user->can('configureAddons', ['model' => $model])
                    && $model->installed === Addon::INSTALLED_OFF;
            },
            'uninstall' => function ($model) {
                return Yii::$app->user->can('configureAddons', ['model' => $model])
                    && $model->installed === Addon::INSTALLED_ON;
            },
        ],
        'visible' => Yii::$app->user->can('configureAddons', ['listing' => true]),
    ],
];

// User Preferences
$showFilters = Yii::$app->user->preferences->get('GridView.filters.state') === '1';

$options = array(
    'currentPage' => Url::toRoute(['index']), // Used by filters
    'gridViewSettingsEndPoint' => Url::to(['/ajax/grid-view-settings']),
);

$bulkActionsItems = [];
if (Yii::$app->user->can('configureAddons')) {
    $bulkActionsItems[Yii::t('addon', 'Update Status')] = [
        'status-active' => Yii::t('addon', 'Active'),
        'status-inactive' => Yii::t('addon', 'Inactive'),
    ];
}
if (Yii::$app->user->can('installAddons')) {
    $bulkActionsItems[Yii::t('addon', 'General')]['install'] = Yii::t('addon', 'Install');
}
if (Yii::$app->user->can('uninstallAddons')) {
    $bulkActionsItems[Yii::t('addon', 'General')]['uninstall'] = Yii::t('addon', 'Uninstall');
}
if (empty($bulkActionsItems)) {
    $bulkActionsItems = [
        Yii::t('addon', 'General') => [],
    ];
}

// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'form-options');
?>
<div class="addons-index">
    <div class="row">
        <div class="col-md-12">
            <?= GridView::widget([
                'id' => 'addons-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'resizableColumns' => false,
                'pjax' => false,
                'export' => false,
                'responsive' => true,
                'responsiveWrap' => false,
                'bordered' => false,
                'striped' => true,
                'containerOptions' => [
                    'class' => $showFilters ? 'table-with-filters' : '',
                ],
                'panelTemplate' => Html::tag('div', '{panelHeading}{panelBefore}{items}{panelFooter}', ['class' => 'panel {type}']),
                'panel' => [
                    'type'=>GridView::TYPE_INFO,
                    'heading'=> Yii::t('addon', 'Add-ons') .' <small class="panel-subtitle hidden-xs">'.
                        Yii::t('addon', 'Extend and Expand the functionality of your forms').'</small>',
                    'before'=> ActionBar::widget([
                        'grid' => 'addons-grid',
                        'templates' => Yii::$app->user->can('viewBulkActionsInAddons') ? [
                            '{refresh}' => ['class' => 'col-xs-6 col-sm-6'],
                            '{filters}' => ['class' => 'col-xs-6 col-sm-3 col-lg-4'],
                            '{bulk-actions}' => ['class' => 'col-sm-3 col-lg-2 hidden-xs'],
                        ] : [
                            '{refresh}' => ['class' => 'col-xs-6 col-sm-6'],
                            '{filters}' => ['class' => 'col-xs-6 col-sm-6'],
                        ],
                        'bulkActionsItems' => $bulkActionsItems,
                        'bulkActionsOptions' => [
                            'options' => [
                                'status-active' => [
                                    'url' => Url::toRoute(['update-status', 'status' => 1]),
                                ],
                                'status-inactive' => [
                                    'url' => Url::toRoute(['update-status', 'status' => 0]),
                                ],
                                'install' => [
                                    'url' => Url::toRoute(['install']),
                                ],
                                'uninstall' => [
                                    'url' => Url::toRoute(['uninstall']),
                                    'data-confirm' => Yii::t(
                                        'addon',
                                        'Are you sure you want to uninstall these add-ons? All data related to each item will be deleted. This action cannot be undone.'
                                    ),
                                ],
                            ],
                            'class' => 'form-control',
                        ],
                        'elements' => [
                            'refresh' => Yii::$app->user->can('refreshAddons') ?
                                Html::a(
                                    Html::tag('span', '', ['class' => 'glyphicon glyphicon-refresh']).' '.
                                    Yii::t('addon', 'Refresh'),
                                    ['refresh'],
                                    ['class' => 'btn btn-primary']
                                ) .
                                Html::a(
                                    Html::tag('span', '', [
                                        'class' => 'glyphicon glyphicon-question-sign',
                                        'style' => 'font-size: 18px; color: #6e8292; vertical-align: -3px',
                                    ]),
                                    false,
                                    [
                                        'data-toggle' => 'tooltip',
                                        'data-placement'=> 'top',
                                        'title' => Yii::t(
                                            'addon',
                                            'Use the “Refresh” button to see new Add-ons, after upload or delete add-on’s files.'
                                        ),
                                        'class' => 'text hidden-xs hidden-sm'
                                    ]
                                ) : '',
                            'filters' => SwitchInput::widget(
                                [
                                    'name'=>'filters',
                                    'type' => SwitchInput::CHECKBOX,
                                    'value' => $showFilters,
                                    'pluginOptions' => [
                                        'size' => 'mini',
                                        'animate' => false,
                                        'labelText' => Yii::t('addon', 'Filter'),
                                    ],
                                    'pluginEvents' => [
                                        "switchChange.bootstrapSwitch" => "function(event, state) {
                                            var show = (typeof state !== 'undefined' && state == 1) ? 1 : 0;
                                            $.post(options.gridViewSettingsEndPoint, { 'show-filters': show })
                                                .done(function(response) {
                                                    if (response.success) {
                                                        if (show) {
                                                            $('.filters').fadeIn();
                                                        } else {
                                                            $('.filters').fadeOut();
                                                            window.location = options.currentPage;
                                                        }                   
                                                    }
                                                });
                                        }",
                                    ],
                                    'containerOptions' => ['style' => 'margin-top: 6px; text-align: right'],
                                ]
                            ),
                        ],
                        'class' => 'form-control',
                    ]),
                ],
                'replaceTags' => [
                    '{pageSize}' => function($widget) {
                        $html = '';
                        if ($widget->panelFooterTemplate !== false) {
                            $selectedSize = Yii::$app->user->preferences->get('GridView.pagination.pageSize');
                            return PageSizeDropDownList::widget(['selectedSize' => $selectedSize]);
                        }
                        return $html;
                    },
                ],
                'panelFooterTemplate' => '
                    <div class="kv-panel-pager">
                        {pageSize}
                        {pager}
                    </div>
                ',
                'toolbar' => false
            ]); ?>
        </div>
    </div>
</div>
<?php
$js = <<< 'SCRIPT'

$(function () {
    $("[data-toggle='tooltip']").tooltip();
});;

SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);