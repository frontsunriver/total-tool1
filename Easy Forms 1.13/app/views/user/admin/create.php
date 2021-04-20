<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View        $this
 * @var \Da\User\Model\User $user
 */

$this->title = Yii::t('app', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="clearfix"></div>
<?= $this->render(
    '/shared/_alert',
    [
        'module' => Yii::$app->getModule('user'),
    ]
) ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading panel-big-heading">
                <h3 class="panel-title">
                    <?= Yii::t('app', 'Users') ?>
                    <small class="panel-subtitle hidden-xs">
                        <?= Html::encode($this->title) ?>
                    </small>
                </h3>
            </div>
            <div class="panel-body">
                <?= $this->render('/shared/_menu') ?>
                <div class="row" style="margin-top: 15px">
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <span class="glyphicon glyphicon-cogwheel"></span>
                                    <?= Yii::t('app', 'Manage account') ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <?= Nav::widget(
                                    [
                                        'options' => [
                                            'class' => 'nav-pills nav-stacked',
                                        ],
                                        'items' => [
                                            [
                                                'label' => Yii::t('app', 'Account details'),
                                                'url' => ['/user/admin/create'],
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Profile details'),
                                                'options' => [
                                                    'class' => 'disabled',
                                                    'onclick' => 'return false;',
                                                ],
                                            ],
                                            [
                                                'label' => Yii::t('app', 'Information'),
                                                'options' => [
                                                    'class' => 'disabled',
                                                    'onclick' => 'return false;',
                                                ],
                                            ],
                                        ],
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="glyphicon glyphicon-user" style="margin-right: 5px;"></i>
                                    <?= Yii::t(
                                        'app',
                                        'Account details'
                                    ) ?>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <?= Yii::t('app', 'Credentials will be sent to the user by email') ?>.
                                    <?= Yii::t(
                                        'app',
                                        'A password will be generated automatically if not provided'
                                    ) ?>.
                                </div>
                                <?php $form = ActiveForm::begin(
                                    [
                                        'enableAjaxValidation' => true,
                                        'enableClientValidation' => false,
                                        'fieldConfig' => [
                                            'horizontalCssClasses' => [
                                                'wrapper' => 'col-sm-9',
                                            ],
                                        ],
                                    ]
                                ); ?>

                                <?= $this->render('/admin/_user', ['form' => $form, 'user' => $user]) ?>

                                <div class="form-action">
                                    <?= Html::submitButton(
                                        '<i class="glyphicon glyphicon-ok" style="margin-right: 3px"></i> ' .
                                        Yii::t('app', 'Save'), ['class' => 'btn btn-primary']
                                    ) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

