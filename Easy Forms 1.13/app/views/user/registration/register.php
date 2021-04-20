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
use yii\captcha\Captcha;

/**
 * @var yii\web\View                   $this
 * @var \Da\User\Form\RegistrationForm $model
 * @var \Da\User\Model\User            $user
 * @var \Da\User\Module                $module
 */

$this->title = Yii::t('app', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-registration-register">
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="form-wrapper">
                <?php $form = ActiveForm::begin(
                    [
                        'id' => $model->formName(),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => false,
                    ]
                ); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->generatePasswords == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <?php if (Yii::$app->settings->get('app.useCaptcha')): ?>
                    <?= $form->field($model, 'captcha')
                        ->widget(Captcha::className(), ['captchaAction' => ['/user/registration/captcha']]) ?>
                <?php endif; ?>

                <?php if ($module->enableGdprCompliance): ?>
                    <?= $form->field($model, 'gdpr_consent')->checkbox(['value' => 1]) ?>
                <?php endif ?>

                <?= Html::submitButton(Yii::t('app', 'Sign up'), ['class' => 'btn btn-primary btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="sub">
                <?= Yii::t('app', 'Already have an account?') ?>
                <?= Html::a(Yii::t('app', 'Log In'), ["/user/login"]) ?>
            </div>
        </div>
    </div>
</div>
