<?php

use app\components\widgets\ActionBar;
use app\components\widgets\GridView;
use app\components\widgets\PageSizeDropDownList;
use app\helpers\ArrayHelper;
use app\models\TemplateCategory;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Templates');
$this->params['breadcrumbs'][] = $this->title;

// User Preferences
$showFilters = Yii::$app->user->preferences->get('GridView.filters.state') === '1';

$options = array(
    'currentPage' => Url::toRoute(['index']), // Used by filters
    'gridViewSettingsEndPoint' => Url::to(['/ajax/grid-view-settings']),
);

$bulkActionsItems = [];
if (Yii::$app->user->can('updateTemplates', ['listing' => true])) {
    $bulkActionsItems[Yii::t('app', 'Update Promotion')] = [
        'promoted' => Yii::t('app', 'Promoted'),
        'non-promoted' => Yii::t('app', 'Non-Promoted'),
    ];
}
if (Yii::$app->user->can('deleteTemplates', ['listing' => true])) {
    $bulkActionsItems[Yii::t('app', 'General')] = [
        'general-delete' => Yii::t('app', 'Delete')
    ];
}
if (empty($bulkActionsItems)) {
    $bulkActionsItems = [
        Yii::t('app', 'General') => [],
    ];
}

$templatesByCategoriesLink = '';
if (Yii::$app->user->can('manageTemplateCategories')) {
    $templateByCategoriesLink = Html::a(Yii::t('app', 'Templates by Categories'), ['/categories'],
        [
            'data-toggle' => 'tooltip',
            'data-placement'=> 'top',
            'title' => Yii::t('app', 'Templates organized by Categories'),
            'class' => 'text hidden-xs hidden-sm'
        ]
    );
}

// Pass php options to javascript
$this->registerJs("var options = ".json_encode($options).";", View::POS_BEGIN, 'form-options');
?>
<div class="template-index">

    <?= GridView::widget([
        'id' => 'template-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns' => false,
        'pjax' => false,
        'export' => false,
        'responsive' => true,
        'bordered' => false,
        'striped' => true,
        'containerOptions' => [
            'class' => $showFilters ? 'table-with-filters' : '',
        ],
        'panelTemplate' => Html::tag('div', '{panelHeading}{panelBefore}{items}{panelFooter}', [
            'class' => 'panel {type}'
        ]),
        'panel' => [
            'type'=>GridView::TYPE_INFO,
            'heading'=> Yii::t('app', 'Templates').' <small class="panel-subtitle hidden-xs">'.
                Yii::t('app', 'Looks & feels amazing on any device').'</small>',
            'before'=> ActionBar::widget([
                'grid' => 'template-grid',
                'templates' => Yii::$app->user->can('viewBulkActionsInTemplates') ? [
                    '{create}' => ['class' => 'col-xs-6 col-sm-6'],
                    '{filters}' => ['class' => 'col-xs-6 col-sm-3 col-lg-4'],
                    '{bulk-actions}' => ['class' => 'col-sm-3 col-lg-2 hidden-xs'],
                ] : [
                    '{create}' => ['class' => 'col-xs-6 col-sm-6'],
                    '{filters}' => ['class' => 'col-xs-6 col-sm-6'],
                ],
                'elements' => [
                    'create' => Yii::$app->user->can('createTemplates') ?
                        Html::a(
                            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create Template'),
                            ['create'],
                            ['class' => 'btn btn-primary']
                        ) . ' ' .
                        $templatesByCategoriesLink : $templatesByCategoriesLink,
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
                'bulkActionsItems' => $bulkActionsItems,
                'bulkActionsOptions' => [
                    'options' => [
                        'promoted' => [
                            'url' => Url::toRoute(['update-promotion', 'promoted' => 1]),
                        ],
                        'non-promoted' => [
                            'url' => Url::toRoute(['update-promotion', 'promoted' => 0]),
                        ],
                        'general-delete' => [
                            'url' => Url::toRoute('delete-multiple'),
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete these templates? All data related to each item will be deleted. This action cannot be undone.'),
                        ],
                    ],
                    'class' => 'form-control',
                ],
                'class' => 'form-control',
            ]),
        ],
        'toolbar' => false,
        'columns' => [
            [
                'class' => '\kartik\grid\CheckboxColumn',
                'headerOptions' => ['class'=>'kartik-sheet-style'],
                'rowSelectedClass' => GridView::TYPE_WARNING,
            ],
            [
                'attribute'=> 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    $name = Html::encode($model->name);
                    if (Yii::$app->user->can('viewTemplates', ['model' => $model])) {
                        return Html::a($name, ['templates/view', 'id' => $model->id]);
                    }
                    return $name;
                },
            ],
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'value' => function ($model) {
                    if (isset($model->category, $model->category->name)) {
                        return Html::encode($model->category->name);
                    }
                    return null;
                },
                'label' => Yii::t('app', 'Category'),
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    ArrayHelper::map(
                        TemplateCategory::find()->asArray()->all(),
                        'id',
                        'name'
                    ),
                    ['class'=>'form-control', 'prompt' => '']
                ),
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'promoted',
                'trueIcon'=>'<span class="glyphicon glyphicon-star text-success"></span>',
                'falseIcon'=>'<span class="glyphicon glyphicon-star-empty text-default"></span>',
                'vAlign'=>'middle',
            ],
            [
                'attribute' => 'shared',
                'label' => Yii::t('app', 'Sharing'),
                'format' => 'raw',
                'hAlign'=>'center',
                'value' => function ($model) {
                    $icon = '';
                    $currentUser = Yii::$app->user;
                    if ($currentUser->id === $model->created_by || $currentUser->can('manageTemplates')) {
                        $icon = Html::tag('span', ' ', [
                            'title' => $currentUser->id === $model->created_by ? Yii::t('app', 'Only you can access to this item') : Yii::t('app', 'Only you and the author can access to this item'),
                            'class' => 'glyphicon glyphicon-lock text-default',
                        ]);
                        if ((int) $model->shared === \app\models\Template::SHARED_EVERYONE) {
                            $icon = Html::tag('span', ' ', [
                                'title' => Yii::t('app', 'Everyone can access to this item'),
                                'class' => 'glyphicon glyphicon-unlock text-danger',
                            ]);
                        } elseif ((int) $model->shared === \app\models\Template::SHARED_WITH_USERS) {
                            $icon = Html::tag('span', ' ', [
                                'title' => Yii::t('app', 'Specific users can access to this item'),
                                'class' => 'glyphicon glyphicon-group text-default',
                            ]);
                        }
                    } else if ($currentUser->id !== $model->created_by) {
                        $icon = Html::tag('span', ' ', [
                            'title' => Yii::t('app', 'This item was shared with me'),
                            'class' => 'glyphicon glyphicon-share-alt text-default',
                        ]);
                    }
                    return $icon;
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'shared',
                    \app\models\Template::sharedOptions(),
                    ['class'=>'form-control', 'prompt' => '']
                ),
                'visible' => Yii::$app->user->can('shareTemplates', ['listing' => true]),
            ],
            [
                'attribute' => 'lastEditor',
                'value' => function ($model) {
                    return isset($model->lastEditor, $model->lastEditor->username) ? Html::encode($model->lastEditor->username) : null;
                },
                'label' => Yii::t("app", "Updated by"),
                'noWrap'=>true,
            ],
            [
                'attribute'=> 'updated_at',
                'value' => function ($model) {
                    return $model->updated;
                },
                'label' => Yii::t('app', 'Updated'),
                'width' => '150px',
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
                            'dateFormat' => 'Y-m-d',
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
                    //update button
                    'update' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'Update'),
                            'aria-label' => Yii::t('app', 'Update'),
                            'data-pjax' => '0',
                        ], []);
                        return '<li>'.Html::a('<span class="glyphicon glyphicon-pencil"></span> '.
                            Yii::t('app', 'Update'), $url, $options).'</li>';
                    },
                    //settings button
                    'settings' => function ($url) {
                        return '<li>'.Html::a(
                            '<span class="glyphicon glyphicon-cogwheel"> </span> '. Yii::t('app', 'Settings'),
                            $url,
                            ['title' => Yii::t('app', 'Settings')]
                        ) .'</li>';
                    },
                    //create form button
                    'createForm' => function ($url) {
                        return '<li>'.Html::a(
                            '<span class="glyphicon glyphicon-plus"> </span> '. Yii::t('app', 'Create Form'),
                            $url,
                            ['title' => Yii::t('app', 'Create Form')]
                        ) .'</li>';
                    },
                    //view button
                    'view' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'View Record'),
                            'aria-label' => Yii::t('app', 'View Record'),
                            'data-pjax' => '0',
                        ], []);
                        return '<li>'.Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('app', 'View Record'),
                            $url,
                            $options
                        ).'</li>';
                    },
                    //delete button
                    'delete' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'Delete'),
                            'aria-label' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this template? All data related to this item will be deleted. This action cannot be undone.'),
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
                    if ($action === 'update') {
                        $url = Url::to(['update', 'id' => $model->id]);
                        return $url;
                    } elseif ($action === "settings") {
                        $url = Url::to(['settings', 'id' => $model->id]);
                        return $url;
                    } elseif ($action === "createForm") {
                        $url = Url::to(['form/create', 'template' => $model->slug]);
                        return $url;
                    } elseif ($action === "view") {
                        $url = Url::to(['view', 'id' => $model->id]);
                        return $url;
                    } elseif ($action === "delete") {
                        $url = Url::to(['delete', 'id' => $model->id]);
                        return $url;
                    }
                    return '';
                },
                'visibleButtons' => [
                    //update button
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateTemplates', ['model' => $model]);
                    },
                    //settings button
                    'settings' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateTemplates', ['model' => $model]);
                    },
                    //create form button
                    'createForm' => function ($model, $key, $index) {
                        return Yii::$app->user->can('createForms');
                    },
                    //view button
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewTemplates', ['model' => $model]);
                    },
                    //delete button
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteTemplates', ['model' => $model]);
                    },
                ],
                'template' => '{update} {settings} {createForm} {view} {delete}',
            ],
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
    ]); ?>

</div>
<?php
$js = <<< 'SCRIPT'

$(function () {
    // Tooltips
    $("[data-toggle='tooltip']").tooltip();
});

SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);