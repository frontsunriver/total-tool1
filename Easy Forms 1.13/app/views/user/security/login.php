<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Da\User\Widget\ConnectWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View            $this
 * @var \Da\User\Form\LoginForm $model
 * @var \Da\User\Module         $module
 */

$this->title = Yii::t('app', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-security-login">
    <div class="row">
        <div class="col-xs-12 col-xs-offset-0 col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-2"
             style="padding-top: 20px">
            <div class="description-wrapper">
                <h3 class="app-slogan">
                    <?= Yii::$app->settings->get('app.description'); ?>
                </h3>
                <div class="hidden-xs">
                    <p><?= Yii::t("app", "Forgot Password?") ?></p>
                    <p><?= Html::a(Yii::t("app", "Reset it"), ["/user/recovery/request"], [
                            'class' => 'btn btn-default',
                        ]) ?></p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4" style="border-left: 1px solid #404b55; padding-top: 20px">
            <div class="form-wrapper">
                <?php $form = ActiveForm::begin(
                    [
                        'id' => $model->formName(),
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                    ]
                ) ?>

                <?= $form->field(
                    $model,
                    'login',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                ) ?>

                <?= $form
                    ->field(
                        $model,
                        'password',
                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']]
                    )
                    ->passwordInput()
                    ->label(Yii::t('app', 'Password')) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>

                <?= Html::submitButton(
                    Yii::t('app', 'Sign in'),
                    ['class' => 'btn btn-primary btn-block', 'tabindex' => '3']
                ) ?>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="sub">
                <?php if ($module->enableEmailConfirmation): ?>
                    <p class="text-center">
                        <?= Html::a(
                            Yii::t('app', 'Didn\'t receive confirmation message?'),
                            ['/user/registration/resend']
                        ) ?>
                    </p>
                <?php endif ?>
                <?php if ($module->enableRegistration && Yii::$app->settings->get('app.anyoneCanRegister')): ?>
                    <p class="text-center">
                        <?= Html::a(Yii::t('app', 'Don\'t have an account? Sign up!'), ['/user/registration/register']) ?>
                    </p>
                <?php endif ?>
                <?= ConnectWidget::widget(
                    [
                        'baseAuthUrl' => ['/user/security/auth'],
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>
