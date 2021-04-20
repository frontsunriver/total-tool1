<?php

use app\components\widgets\ActionBar;
use app\components\widgets\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $categoryModel app\models\TemplateCategory */
/* @var $searchModel app\models\search\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $categoryModel->name . ' ' . Yii::t('app', 'Templates');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['/categories']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="template-index">

    <?= GridView::widget([
        'id' => 'template-grid',
        'dataProvider' => $dataProvider,
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
            'heading'=> Html::encode($categoryModel->name).
                ' <small class="panel-subtitle hidden-xs">'.Yii::t('app', 'Templates').'</small>',
            'before'=>
                ActionBar::widget([
                    'grid' => 'template-grid',
                    'templates' => [
                        '{create}' => ['class' => 'col-xs-6 col-md-8'],
                        '{bulk-actions}' => ['class' => 'col-xs-6 col-md-2 col-md-offset-2'],
                    ],
                    'elements' => [
                        'create' =>
                            Html::a(
                                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Create Template'),
                                ['create'],
                                ['class' => 'btn btn-primary']
                            ) . ' ' .
                            Html::a(Yii::t('app', 'Why to promote a Template?'), ['/categories'], [
                                'data-toggle' => 'tooltip',
                                'data-placement'=> 'top',
                                'title' => Yii::t(
                                    'app',
                                    'The promoted templates will appear next "Create Form" button in the Form Manager. You can create forms based on these templates with one click!'
                                ),
                                'class' => 'text hidden-xs hidden-sm']),
                    ],
                    'bulkActionsItems' => [
                        Yii::t('app', 'Update Promotion') => [
                            'promoted' => Yii::t('app', 'Promoted'),
                            'non-promoted' => Yii::t('app', 'Non-Promoted'),
                        ],
                        Yii::t('app', 'General') => ['general-delete' => Yii::t('app', 'Delete')],
                    ],
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
                    return Html::a(Html::encode($model->name), ['templates/view', 'id' => $model->id]);
                },
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'promoted',
                'trueIcon'=>'<span class="glyphicon glyphicon-star text-success"></span>',
                'falseIcon'=>'<span class="glyphicon glyphicon-star-empty text-default"></span>',
                'vAlign'=>'middle',
            ],
            [
                'attribute' => 'author',
                'value' => 'author.username',
                'label' => Yii::t('app', 'Created by'),
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
                'template' => '{update} {settings} {createForm} {view} {delete}',
            ],
        ],
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