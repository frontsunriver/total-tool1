<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use Carbon\Carbon;

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */

$this->title = isset($formModel->name) ? $formModel->name : $formModel->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

Carbon::setLocale(substr(Yii::$app->language, 0, 2)); // eg. en-US to en
?>
<div class="form-view box box-big box-light">

    <div class="pull-right hidden-xs" style="margin-top: -5px">
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('updateForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ', ['update', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Update'),
                    'class' => 'btn btn-sm btn-info'
                ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('configureForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-cogwheel"></span> ', ['settings', 'id' => $formModel->id],
                    [
                        'title' => Yii::t('app', 'Settings'),
                        'class' => 'btn btn-sm btn-info'
                    ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('configureForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-flowchart"></span> ', ['rules', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Conditional Rules'),
                    'class' => 'btn btn-sm btn-info'
                ]) ?>
            <?php endif; ?>
        </div>
        <?php if (Yii::$app->user->can('viewFormSubmissions', ['model' => $formModel])) : ?>
            <?= Html::a('<span class="glyphicon glyphicon-send"></span> ', ['submissions', 'id' => $formModel->id], [
                'title' => Yii::t('app', 'Submissions'),
                'class' => 'btn btn-sm btn-warning'
            ]) ?>
        <?php endif; ?>
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('accessFormReports', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-pie-chart"></span> ', ['report', 'id' => $formModel->id],
                    [
                        'title' => Yii::t('app', 'Submissions Report'),
                        'class' => 'btn btn-sm btn-default'
                    ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('accessFormStats', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-stats"></span> ', ['analytics', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Performance Analytics'),
                    'class' => 'btn btn-sm btn-default'
                ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('accessFormStats', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-charts"></span> ', ['stats', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Submissions Analytics'),
                    'class' => 'btn btn-sm btn-default'
                ]) ?>
            <?php endif; ?>
        </div>
        <?php if (Yii::$app->user->can('shareForms', ['model' => $formModel])) : ?>
            <?= Html::a('<span class="glyphicon glyphicon-share"></span> ', ['share', 'id' => $formModel->id], [
                'title' => Yii::t('app', 'Publish & Share'),
                'class' => 'btn btn-sm btn-success'
            ]) ?>
        <?php endif; ?>
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('resetFormStats', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> ',
                    ['reset-stats', 'id' => $formModel->id], [
                        'title' => Yii::t('app', 'Reset Stats'),
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to delete these stats? All stats related to this item will be deleted. This action cannot be undone.'),
                            'method' => 'post',
                        ],
                    ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('deleteForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ', ['delete', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Delete'),
                    'class' => 'btn btn-sm btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to delete this form? All stats, submissions, conditional rules and reports data related to this item will be deleted. This action cannot be undone.'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('app', 'Form') ?>
            <span class="box-subtitle"><?= Html::encode($this->title) ?></span>
        </h3>
    </div>

    <div class="buttons visible-xs-block">
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('updateForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' .
                    Yii::t('app', 'Update'), ['update', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Update'),
                    'class' => 'btn btn-sm btn-info'
                ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('configureForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-cogwheel"></span> ' .
                    Yii::t('app', 'Settings'), ['settings', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Settings'),
                    'class' => 'btn btn-sm btn-info'
                ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('configureForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-flowchart"></span> ' .
                    Yii::t('app', 'Rules'), ['rules', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Conditional Rules'),
                    'class' => 'btn btn-sm btn-info'
                ]) ?>
            <?php endif; ?>
        </div>
        <?php if (Yii::$app->user->can('viewFormSubmissions', ['model' => $formModel])) : ?>
            <?= Html::a('<span class="glyphicon glyphicon-send"></span> ' .
                Yii::t('app', 'Submissions'), ['submissions', 'id' => $formModel->id], [
                'title' => Yii::t('app', 'Submissions'),
                'class' => 'btn btn-sm btn-warning'
            ]) ?>
        <?php endif; ?>
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('accessFormReports', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-pie-chart"></span> ' .
                    Yii::t('app', 'Report'), ['report', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Submissions Report'),
                    'class' => 'btn btn-sm btn-default'
                ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('accessFormStats', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-stats"></span> ' .
                    Yii::t('app', 'Performance'), ['analytics', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Performance Analytics'),
                    'class' => 'btn btn-sm btn-default'
                ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('accessFormStats', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-charts"></span> ' .
                    Yii::t('app', 'Analytics'), ['stats', 'id' => $formModel->id], [
                    'title' => Yii::t('app', 'Submissions Analytics'),
                    'class' => 'btn btn-sm btn-default'
                ]) ?>
            <?php endif; ?>
        </div>
        <?php if (Yii::$app->user->can('shareForms', ['model' => $formModel])) : ?>
            <?= Html::a('<span class="glyphicon glyphicon-share"></span> ' .
                Yii::t('app', 'Publish & Share'), ['share', 'id' => $formModel->id], [
                'title' => Yii::t('app', 'Publish & Share'),
                'class' => 'btn btn-sm btn-success'
            ]) ?>
        <?php endif; ?>
        <div class="btn-group" role="group">
            <?php if (Yii::$app->user->can('resetFormStats', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> ' . Yii::t('app', 'Reset Stats'),
                    ['reset-stats', 'id' => $formModel->id],
                    [
                        'title' => Yii::t('app', 'Reset Stats'),
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to delete these stats? All stats related to this item will be deleted. This action cannot be undone.'),
                            'method' => 'post',
                        ],
                    ]
                ) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('deleteForms', ['model' => $formModel])) : ?>
                <?= Html::a('<span class="glyphicon glyphicon-bin"></span> ' . Yii::t('app', 'Delete'),
                    ['delete', 'id' => $formModel->id],
                    [
                        'title' => Yii::t('app', 'Delete'),
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app',
                                'Are you sure you want to delete this form? All stats, submissions, conditional rules and reports data related to this item will be deleted. This action cannot be undone.'),
                            'method' => 'post',
                        ],
                    ]
                ) ?>
            <?php endif; ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $formModel,
        'condensed'=>false,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'hideIfEmpty'=>true,
        'enableEditMode' => false,
        'options' => [
            'class' => 'kv-view-mode', // Fix hideIfEmpty if enableEditMode is false
        ],
        'attributes' => [
            [
                'group'=>true,
                'label'=>Yii::t('app', 'Form Info'),
                'rowOptions'=>['class'=>'info']
            ],
            'id',
            'name',
            [
                'attribute'=>'language',
                'value'=> $formModel->languageLabel,

            ],
            [
                'attribute'=>'status',
                'format'=>'raw',
                'value'=> ($formModel->status === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'save',
                'format'=>'raw',
                'value'=> ($formModel->save === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'analytics',
                'format'=>'raw',
                'value'=> ($formModel->analytics === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'use_password',
                'format'=>'raw',
                'value'=> ($formModel->use_password === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'novalidate',
                'format'=>'raw',
                'value'=> ($formModel->novalidate === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'autocomplete',
                'format'=>'raw',
                'value'=> ($formModel->autocomplete === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'resume',
                'format'=>'raw',
                'value'=> ($formModel->resume === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'honeypot',
                'format'=>'raw',
                'value'=> ($formModel->honeypot === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'recaptcha',
                'format'=>'raw',
                'value'=> ($formModel->recaptcha === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'total_limit',
                'format'=>'raw',
                'value'=> ($formModel->total_limit === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'user_limit',
                'format'=>'raw',
                'value'=> ($formModel->user_limit === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute'=>'schedule',
                'format'=>'raw',
                'value'=> ($formModel->schedule === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
            ],
            [
                'attribute' => 'author',
                'value' => $formModel->author->username,
                'label' => Yii::t('app', 'Created by'),
            ],
            [
                'attribute' => 'created_at',
                'value' => $formModel->created,
                'label' => Yii::t('app', 'Created'),
            ],
            [
                'attribute' => 'lastEditor',
                'value' => isset($formModel->lastEditor, $formModel->lastEditor->username) ? $formModel->lastEditor->username : null,
                'label' => Yii::t('app', 'Last Editor'),
            ],
            [
                'attribute' => 'updated_at',
                'value' => $formModel->updated,
                'label' => Yii::t('app', 'Last updated'),
            ],
            [
                'group'=>true,
                'label'=>Yii::t('app', 'Confirmation Info'),
                'rowOptions'=>['class'=>'info']
            ],
            [
                'attribute' => 'formConfirmation',
                'value' => $formModel->formConfirmation->getTypeLabel(),
                'label' => Yii::t('app', 'How to'),
            ],
            [
                'attribute' => 'formConfirmation',
                'value' => Html::encode($formModel->formConfirmation->message),
                'label' => Yii::t('app', 'Message'),
            ],
            [
                'attribute' => 'formConfirmation',
                'value' => Html::encode($formModel->formConfirmation->url),
                'label' => Yii::t('app', 'Url'),
            ],
            [
                'attribute' => 'formConfirmation',
                'format'=>'raw',
                'value'=> ($formModel->formConfirmation->send_email === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
                'label' => Yii::t('app', 'Send Email'),
            ],
            [
                'attribute' => 'formConfirmation',
                'value' => Html::encode($formModel->formConfirmation->mail_from),
                'label' => Yii::t('app', 'Reply To'),
            ],
            [
                'attribute' => 'formConfirmation',
                'value' => Html::encode($formModel->formConfirmation->mail_subject),
                'label' => Yii::t('app', 'Subject'),
            ],
            [
                'attribute' => 'formConfirmation',
                'value' => Html::encode($formModel->formConfirmation->mail_from_name),
                'label' => Yii::t('app', 'Name or Company'),
            ],
            [
                'attribute' => 'formConfirmation',
                'format'=>'raw',
                'value'=> ($formModel->formConfirmation->mail_receipt_copy === 1) ?
                    '<span class="label label-success"> '.Yii::t('app', 'ON').' </span>' :
                    '<span class="label label-danger"> '.Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
                'label' => Yii::t('app', 'Includes a Submission Copy'),
            ],
            [
                'group'=>true,
                'label'=>Yii::t('app', 'Notification Info'),
                'rowOptions'=>['class'=>'info']
            ],
            [
                'attribute' => 'formEmail',
                'format'=>'raw',
                'value'=> (!empty($formModel->formEmail->to)) ?
                    '<span class="label label-success"> '.Yii::t('app', 'ON').' </span>' :
                    '<span class="label label-danger"> '.Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
                'label' => Yii::t('app', 'Send Email'),
            ],
            [
                'attribute' => 'formEmail',
                'value' => Html::encode($formModel->formEmail->subject),
                'label' => Yii::t('app', 'Subject'),
            ],
            [
                'attribute' => 'formEmail',
                'value' => Html::encode($formModel->formEmail->to),
                'label' => Yii::t('app', 'Recipient'),
            ],
            [
                'attribute' => 'formEmail',
                'value' => Html::encode($formModel->formEmail->cc),
                'label' => Yii::t('app', 'Cc'),
            ],
            [
                'attribute' => 'formEmail',
                'value' => Html::encode($formModel->formEmail->bcc),
                'label' => Yii::t('app', 'Bcc'),
            ],
            [
                'attribute' => 'formEmail',
                'value' => $formModel->formEmail->typeLabel,
                'label' => Yii::t('app', 'Contents'),
            ],
            [
                'attribute' => 'formEmail',
                'format'=>'raw',
                'value'=> ($formModel->formEmail->attach === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
                'label' => Yii::t('app', 'Attach'),
            ],
            [
                'attribute' => 'formEmail',
                'format'=>'raw',
                'value'=> ($formModel->formEmail->plain_text === 1) ? '<span class="label label-success"> '.
                    Yii::t('app', 'ON').' </span>' : '<span class="label label-danger"> '.
                    Yii::t('app', 'OFF').' </span>',
                'type'=>DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => Yii::t('app', 'ON'),
                        'offText' => Yii::t('app', 'OFF'),
                    ]
                ],
                'label' => Yii::t('app', 'Only Plain Text'),
            ],
        ],
    ]) ?>

</div>
