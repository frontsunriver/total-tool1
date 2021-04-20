<?php

use app\components\widgets\ActionBar;
use app\components\widgets\GridView;
use app\components\widgets\PageSizeDropDownList;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TemplateCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Templates By Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['/templates']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-category-index">

    <?= GridView::widget([
        'id' => 'template-category-grid',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'resizableColumns' => false,
        'pjax' => false,
        'export' => false,
        'responsive' => true,
        'bordered' => false,
        'striped' => true,
        'panelTemplate' => Html::tag('div', '{panelHeading}{panelBefore}{items}{panelFooter}', [
            'class' => 'panel {type}']),
        'panel'=>[
            'type'=>GridView::TYPE_INFO,
            'heading'=> Yii::t('app', 'Templates').' <small class="panel-subtitle hidden-xs">'.
                Yii::t('app', 'By Categories').'</small>',
            'before'=>
                ActionBar::widget([
                    'grid' => 'template-category-grid',
                    'templates' => [
                        '{create}' => ['class' => 'col-xs-6 col-md-8'],
                        '{bulk-actions}' => ['class' => 'col-xs-6 col-md-2 col-md-offset-2'],
                    ],
                    'bulkActionsItems' => [
                        Yii::t('app', 'General') => ['general-delete' => Yii::t('app', 'Delete')],
                    ],
                    'bulkActionsOptions' => [
                        'options' => [
                            'general-delete' => [
                                'url' => Url::toRoute('delete-multiple'),
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete these template categories? All data related to each item will be deleted. This action cannot be undone.'),
                            ],
                        ],
                        'class' => 'form-control',
                    ],
                    'elements' => [
                        'create' =>
                            Html::a(
                                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create Category'),
                                ['create'],
                                ['class' => 'btn btn-primary']
                            ) . ' ' .
                            Html::a(Yii::t('app', 'Need to extend the app functionality?'), ['/addons'], [
                                'data-toggle' => 'tooltip',
                                'data-placement'=> 'top',
                                'title' => Yii::t(
                                    'app',
                                    'With our add-ons you can add great features and integrations to your forms. Try them now!'
                                ),
                                'class' => 'text hidden-xs hidden-sm']),
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
                    return Html::a(Html::encode($model->name), ['templates/category', 'id' => $model->id]);
                },
            ],
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    if (isset($model->description)) {
                        return StringHelper::truncateWords(Html::encode($model->description), 15);
                    }
                    return null;
                }
            ],
            [
                'attribute'=> 'updated_at',
                'value' => function ($model) {
                    return $model->updated;
                },
                'label' => Yii::t('app', 'Updated'),
            ],

            ['class' => 'kartik\grid\ActionColumn',
                'dropdown'=>true,
                'dropdownButton' => ['class'=>'btn btn-primary'],
                'dropdownOptions' => ['class' => 'pull-right'],
                'buttons' => [
                    //view button
                    'view' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'View'),
                            'aria-label' => Yii::t('app', 'View'),
                            'data-pjax' => '0',
                        ], []);
                        return '<li>'.Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('app', 'View Record'),
                            $url,
                            $options
                        ).'</li>';
                    },
                    //update button
                    'update' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'Update'),
                            'aria-label' => Yii::t('app', 'Update'),
                            'data-pjax' => '0',
                        ], []);
                        return '<li>'.Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('app', 'Update'),
                            $url,
                            $options
                        ).'</li>';
                    },
                    //delete button
                    'delete' => function ($url) {
                        $options = array_merge([
                            'title' => Yii::t('app', 'Delete'),
                            'aria-label' => Yii::t('app', 'Delete'),
                            'data-confirm' => Yii::t('app', 'Are you sure you want to delete this template category? All data related to this item will be deleted. This action cannot be undone.'),
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
    $("[data-toggle='tooltip']").tooltip();
});

SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);