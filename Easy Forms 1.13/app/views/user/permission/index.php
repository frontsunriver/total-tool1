<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this         yii\web\View
 * @var $searchModel  \Da\User\Search\PermissionSearch
 */
use app\components\widgets\ActionBar;
use app\components\widgets\GridView;
use app\components\widgets\PageSizeDropDownList;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\switchinput\SwitchInput;
use yii\web\View;

$this->title = Yii::t('app', 'Permissions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/admin/index']];
$this->params['breadcrumbs'][] = $this->title;

// User Preferences
$showFilters = Yii::$app->user->preferences->get('GridView.filters.state') === '1';

$options = array(
    'currentPage' => Url::toRoute(['index']), // Used by filters
    'gridViewSettingsEndPoint' => Url::to(['/ajax/grid-view-settings']),
);

// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'form-options');
?>

<?= GridView::widget(
    [
        'id' => 'permission-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
            'type' => GridView::TYPE_INFO,
            'heading' => Yii::t('app', 'Permissions') .' <small class="panel-subtitle hidden-xs">'.
                Yii::t('app', 'Authenticate and authorize users in seconds').'</small>',
            'before'=>
                ActionBar::widget([
                    'grid' => 'permission-grid',
                    'templates' => [
                        '{create}' => ['class' => 'col-xs-9 col-sm-6'],
                        '{filters}' => ['class' => 'col-xs-3 col-sm-6'],
                    ],
                    'elements' => [
                        'create' => $this->render('/shared/_menu'),
                        'filters' => SwitchInput::widget(
                            [
                                'name'=>'filters',
                                'type' => SwitchInput::CHECKBOX,
                                'value' => $showFilters,
                                'pluginOptions' => [
                                    'size' => 'mini',
                                    'animate' => false,
                                    'labelText' => Yii::t('app', 'Filter'),
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
                    'bulkActionsItems' => [],
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
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete these forms? All stats, submissions, conditional rules and reports data related to each item will be deleted. This action cannot be undone.'),
                            ],
                        ],
                        'class' => 'form-control',
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
        'toolbar' => false,
        'columns' => [
            [
                'class' => '\kartik\grid\SerialColumn',
                'width' => '80px',
            ],
            [
                'attribute' => 'name',
                'header' => Yii::t('app', 'Name'),
                'options' => [
                    'style' => 'width: 20%',
                ],
            ],
            [
                'attribute' => 'description',
                'header' => Yii::t('app', 'Description'),
                'options' => [
                    'style' => 'width: 55%',
                ],
            ],
            [
                'attribute' => 'rule_name',
                'header' => Yii::t('app', 'Rule name'),
                'options' => [
                    'style' => 'width: 20%',
                ],
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown'=>true,
                'dropdownButton' => ['class'=>'btn btn-primary'],
                'dropdownOptions' => ['class' => 'pull-right'],
                'buttons' => [
                    'update' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'Update'),
                            'aria-label' => Yii::t('app', 'Update'),
                            'data-pjax' => '0',
                        ], []);
                        return '<li>'.Html::a('<span class="glyphicon glyphicon-pencil"></span> '.
                                Yii::t('app', 'Update'), $url, $options).'</li>';
                    },
                    'delete' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'Delete'),
                            'aria-label' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this permission? All data related to this item will be deleted. This action cannot be undone.'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ], []);
                        return '<li>'.Html::a(
                                '<span class="glyphicon glyphicon-bin"></span> ' . Yii::t('app', 'Delete'),
                                $url,
                                $options
                            ).'</li>';
                    },
                ],
                'urlCreator' => function ($action, $model) {
                    return Url::to(['/user/permission/' . $action, 'name' => $model['name']]);
                },
                'template' => '{update} {delete}',
            ],
        ],
    ]
) ?>

<?php
$js = <<< 'SCRIPT'

$(function () {
    // Tooltips
    $("[data-toggle='tooltip']").tooltip();
});

SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);