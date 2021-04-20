<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Da\User\Model\User;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View   $this
 * @var User   $user
 * @var string $content
 * @var string $title
 */

$this->title = Yii::t('app', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="">
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
                                                    'url' => ['/user/admin/update', 'id' => $user->id],
                                                    'visible' => Yii::$app->user->can('updateUsers'),
                                                ],
                                                [
                                                    'label' => Yii::t('app', 'Profile details'),
                                                    'url' => ['/user/admin/update-profile', 'id' => $user->id],
                                                    'visible' => Yii::$app->user->can('updateUsers'),
                                                ],
                                                [
                                                    'label' => Yii::t('app', 'Information'),
                                                    'url' => ['/user/admin/info', 'id' => $user->id],
                                                    'visible' => Yii::$app->user->can('viewUsers'),
                                                ],
                                                [
                                                    'label' => Yii::t('app', 'Assignments'),
                                                    'url' => ['/user/admin/assignments', 'id' => $user->id],
                                                    'visible' => Yii::$app->user->can('assignUserPermissions'),
                                                ],
                                                '<hr>',
                                                [
                                                    'label' => Yii::t('app', 'Confirm'),
                                                    'url' => ['/user/admin/confirm', 'id' => $user->id],
                                                    'visible' => !$user->isConfirmed && Yii::$app->user->can('confirmUsers'),
                                                    'linkOptions' => [
                                                        'class' => 'text-success',
                                                        'data-method' => 'post',
                                                        'data-confirm' => Yii::t(
                                                            'app',
                                                            'Are you sure you want to confirm this user?'
                                                        ),
                                                    ],
                                                ],
                                                [
                                                    'label' => Yii::t('app', 'Block'),
                                                    'url' => ['/user/admin/block', 'id' => $user->id],
                                                    'visible' => !$user->isBlocked && Yii::$app->user->can('blockUsers'),
                                                    'linkOptions' => [
                                                        'class' => 'text-danger',
                                                        'data-method' => 'post',
                                                        'data-confirm' => Yii::t(
                                                            'app',
                                                            'Are you sure you want to block this user?'
                                                        ),
                                                    ],
                                                ],
                                                [
                                                    'label' => Yii::t('app', 'Unblock'),
                                                    'url' => ['/user/admin/block', 'id' => $user->id],
                                                    'visible' => $user->isBlocked && Yii::$app->user->can('blockUsers'),
                                                    'linkOptions' => [
                                                        'class' => 'text-success',
                                                        'data-method' => 'post',
                                                        'data-confirm' => Yii::t(
                                                            'app',
                                                            'Are you sure you want to unblock this user?'
                                                        ),
                                                    ],
                                                ],
                                                [
                                                    'label' => Yii::t('app', 'Delete'),
                                                    'url' => ['/user/admin/delete', 'id' => $user->id],
                                                    'visible' => Yii::$app->user->can('deleteUsers'),
                                                    'linkOptions' => [
                                                        'class' => 'text-danger',
                                                        'data-method' => 'post',
                                                        'data-confirm' => Yii::t(
                                                            'app',
                                                            'Are you sure you want to delete this user?'
                                                        ),
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
                                        <?= $title ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <?= $content ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
