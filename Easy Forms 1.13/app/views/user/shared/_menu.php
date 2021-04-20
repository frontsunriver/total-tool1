<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap\Nav;

$controllerID = $this->context->id;
?>

<?= Nav::widget(
    [
        'options' => [
            'class' => 'nav-pills nav-fill',
        ],
        'items' => [
            [
                'label' => Yii::t('app', 'Users'),
                'url' => ['/user/admin/index'],
                'active' => $controllerID === 'admin',
                'visible' => Yii::$app->user->can('viewUsers'),
            ],
            [
                'label' => Yii::t('app', 'Roles'),
                'url' => ['/user/role/index'],
                'active' => $controllerID === 'role',
                'visible' => Yii::$app->user->can('manageRoles'),
            ],
            [
                'label' => Yii::t('app', 'Permissions'),
                'url' => ['/user/permission/index'],
                'active' => $controllerID === 'permission',
                'visible' => Yii::$app->user->can('managePermissions'),
            ],
            [
                'label' => Yii::t('app', 'Rules'),
                'url' => ['/user/rule/index'],
                'active' => $controllerID === 'rule',
                'visible' => Yii::$app->user->can('manageRules'),
            ],
            [
                'label' => Yii::t('app', 'Create'),
                'visible' => Yii::$app->user->can('createUsers')
                || Yii::$app->user->can('manageRoles')
                || Yii::$app->user->can('managePermissions')
                || Yii::$app->user->can('manageRules')
                ,
                'items' => [
                    [
                        'label' => Yii::t('app', 'New user'),
                        'url' => ['/user/admin/create'],
                        'visible' => Yii::$app->user->can('createUsers'),
                    ],
                    [
                        'label' => Yii::t('app', 'New role'),
                        'url' => ['/user/role/create'],
                        'visible' => Yii::$app->user->can('manageRoles'),
                    ],
                    [
                        'label' => Yii::t('app', 'New permission'),
                        'url' => ['/user/permission/create'],
                        'visible' => Yii::$app->user->can('managePermissions'),
                    ],
                    [
                        'label' => Yii::t('app', 'New rule'),
                        'url' => ['/user/rule/create'],
                        'visible' => Yii::$app->user->can('manageRules'),
                    ],
                ],
            ],
        ],
    ]
) ?>
