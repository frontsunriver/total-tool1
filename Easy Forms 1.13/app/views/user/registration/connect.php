<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View                        $this
 * @var yii\widgets\ActiveForm              $form
 * @var \Da\User\Model\User                 $model
 * @var \Da\User\Model\SocialNetworkAccount $account
 */

$this->title = Yii::t('app', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-registration-connect">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="form-wrapper">
                <div class="alert alert-info">
                    <p>
                        <?= Yii::t(
                            'app',
                            'In order to finish your registration, we need you to enter following fields'
                        ) ?>:
                    </p>
                </div>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => $model->formName(),
                    ]
                ); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?= Html::submitButton(Yii::t('app', 'Continue'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="sub">
                <?= Html::a(
                    Yii::t(
                        'app',
                        'If you already registered, sign in and connect this account on settings page'
                    ),
                    ['/user/settings/networks']
                ) ?>.
            </div>
        </div>
    </div>
</div>
