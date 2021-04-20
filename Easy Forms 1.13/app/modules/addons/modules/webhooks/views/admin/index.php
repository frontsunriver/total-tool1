<?php

use app\components\widgets\ActionBar;
use app\components\widgets\GridView;
use app\components\widgets\PageSizeDropDownList;
use app\helpers\Html;
use kartik\switchinput\SwitchInput;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\addons\modules\webhooks\models\WebhookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('webhooks', 'Webhooks');
$this->params['breadcrumbs'][] = ['label' => Yii::t('webhooks', 'Add-ons'), 'url' => ['/addons']];
$this->params['breadcrumbs'][] = $this->title;

// User Preferences
$showFilters = Yii::$app->user->preferences->get('GridView.filters.state') === '1';

$options = array(
    'currentPage' => Url::toRoute(['index']), // Used by filters
    'gridViewSettingsEndPoint' => Url::to(['/ajax/grid-view-settings']),
);

// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'form-options');

$gridColumns = [
    [
        'class' => '\kartik\grid\CheckboxColumn',
        'headerOptions' => ['class'=>'kartik-sheet-style'],
        'rowSelectedClass' => GridView::TYPE_WARNING,
    ],
    [
        'attribute'=> 'form',
        'format' => 'raw',
        'value' => function ($model) {
            return isset($model->form, $model->form->name) ?
                Html::a(Html::encode($model->form->name), ['view', 'id' => $model->id ]) :
                null;
        },
    ],
    [
        'attribute' => 'url',
        'value' => function ($model) {
            if (isset($model->url)) {
                return StringHelper::truncate(Html::encode($model->url), 90);
            }
            return null;
        }
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'status',
        'trueIcon'=>'<span class="glyphicon glyphicon-ok text-success"></span>',
        'falseIcon'=>'<span class="glyphicon glyphicon-remove text-danger"></span>',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'json',
        'trueIcon'=>'<span class="glyphicon glyphicon-ok text-success"></span>',
        'falseIcon'=>'<span class="glyphicon glyphicon-remove text-danger"></span>',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'alias',
        'trueIcon'=>'<span class="glyphicon glyphicon-ok text-success"></span>',
        'falseIcon'=>'<span class="glyphicon glyphicon-remove text-danger"></span>',
        'vAlign'=>'middle',
    ],
    [
        'attribute' => 'lastEditor',
        'value' => function ($model) {
            return isset($model->lastEditor, $model->lastEditor->username) ? Html::encode($model->lastEditor->username) : null;
        },
        'label' => Yii::t("webhooks", "Updated by"),
        'noWrap'=>true,
    ],
    [
        'attribute'=> 'updated_at',
        'value' => function ($model) {
            return $model->updated;
        },
        'label' => Yii::t('webhooks', 'Updated'),
        'noWrap'=>true,
        'filterType'=> \kartik\grid\GridView::FILTER_DATE_RANGE,
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
    ],
    ['class' => 'kartik\grid\ActionColumn',
        'dropdown'=>true,
        'dropdownButton' => ['class'=>'btn btn-primary'],
        'dropdownOptions' => ['class' => 'pull-right'],
        'buttons' => [
            //view button
            'view' => function ($url) {
                $options = array_merge([
                    'title' => Yii::t('webhooks', 'View Record'),
                    'aria-label' => Yii::t('webhooks', 'View Record'),
                    'data-pjax' => '0',
                ], []);
                return '<li>'.Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' .
                    Yii::t('webhooks', 'View Record'), $url, $options).'</li>';
            },
            //update button
            'update' => function ($url) {
                $options = array_merge([
                    'title' => Yii::t('webhooks', 'Update'),
                    'aria-label' => Yii::t('webhooks', 'Update'),
                    'data-pjax' => '0',
                ], []);
                return '<li>'.Html::a('<span class="glyphicon glyphicon-pencil"></span> ' .
                    Yii::t('webhooks', 'Update'), $url, $options).'</li>';
            },
            //delete button
            'delete' => function ($url) {
                $options = array_merge([
                    'title' => Yii::t('webhooks', 'Delete'),
                    'aria-label' => Yii::t('webhooks', 'Delete'),
                    'data-confirm' => Yii::t(
                        'webhooks',
                        'Are you sure you want to delete this webhook? All data related to this item will be deleted. This action cannot be undone.'
                    ),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], []);
                return '<li>'.Html::a('<span class="glyphicon glyphicon-bin"></span> ' .
                    Yii::t('webhooks', 'Delete'), $url, $options).'</li>';
            },
        ],
    ],
];

?>
    <div class="webhooks-index">
        <div class="row">
            <div class="col-md-12">
                <?= GridView::widget([
                    'id' => 'webhooks-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                    'resizableColumns' => false,
                    'pjax' => false,
                    'export' => false,
                    'responsive' => true,
                    'bordered' => false,
                    'striped' => true,
                    'containerOptions' => [
                        'class' => $showFilters ? 'table-with-filters' : '',
                    ],
                    'panelTemplate' => Html::tag('div', '{panelHeading}{panelBefore}{items}{panelFooter}', ['class' => 'panel {type}']),
                    'panel' => [
                        'type' => GridView::TYPE_INFO,
                        'heading'=> Yii::t('webhooks', 'Webhooks') . ' <small class="panel-subtitle hidden-xs">'.
                            Yii::t('webhooks', 'Send notifications to another server').'</small>',
                        'before' => ActionBar::widget([
                            'grid' => 'webhooks-grid',
                            'templates' => Yii::$app->user->can('viewBulkActionsInAddons') ? [
                                '{create}' => ['class' => 'col-xs-6 col-sm-6'],
                                '{filters}' => ['class' => 'col-xs-6 col-sm-3 col-lg-4'],
                                '{bulk-actions}' => ['class' => 'col-sm-3 col-lg-2 hidden-xs'],
                            ] : [
                                '{create}' => ['class' => 'col-xs-6 col-sm-6'],
                                '{filters}' => ['class' => 'col-xs-6 col-sm-6'],
                            ],
                            'elements' => [
                                'create' =>
                                    Html::a(
                                        '<span class="glyphicon glyphicon-plus"></span> ' .
                                        Yii::t('webhooks', 'Create a WebHook'),
                                        ['create'],
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
                                                'webhooks',
                                                "A WebHook is just a push notification from us to another server every time someone submits a form."
                                            ),
                                            'class' => 'text hidden-xs hidden-sm'
                                        ]
                                    ),
                                'filters' => SwitchInput::widget(
                                    [
                                        'name'=>'filters',
                                        'type' => SwitchInput::CHECKBOX,
                                        'value' => $showFilters,
                                        'pluginOptions' => [
                                            'size' => 'mini',
                                            'animate' => false,
                                            'labelText' => Yii::t('webhooks', 'Filter'),
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
                            'bulkActionsItems' => [
                                Yii::t('webhooks', 'Update Status') => [
                                    'status-active' => Yii::t('webhooks', 'Active'),
                                    'status-inactive' => Yii::t('webhooks', 'Inactive'),
                                ],
                                'General' => ['general-delete' => 'Delete'],
                            ],
                            'bulkActionsOptions' => [
                                'options' => [
                                    'status-active' => [
                                        'url' => Url::toRoute(['update-status', 'status' => 1]),
                                    ],
                                    'status-inactive' => [
                                        'url' => Url::toRoute(['update-status', 'status' => 0]),
                                    ],
                                    'general-delete' => [
                                        'url' => Url::toRoute('delete-multiple'),
                                        'data-confirm' => Yii::t(
                                            'webhooks',
                                            'Are you sure you want to delete these webhooks? All data related to each item will be deleted. This action cannot be undone.'
                                        ),
                                    ],
                                ],
                                'class' => 'form-control',
                            ],
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