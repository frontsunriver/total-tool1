<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components;

use app\controllers\user\RecoveryController;
use app\controllers\user\RegistrationController;
use app\controllers\user\SecurityController;
use app\helpers\ArrayHelper;
use app\helpers\MailHelper;
use app\models\forms\RegistrationForm;
use app\models\User;
use Da\User\Event\FormEvent;
use Da\User\Event\ResetPasswordEvent;
use Da\User\Event\UserEvent;
use Da\User\Form\LoginForm;
use Da\User\Module;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;

/**
 * Class Bootstrap
 * @package app\components
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {

        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {

            try {

                /*******************************
                /* Default Route
                /*******************************/
                if (isset(Yii::$app->user->isGuest) && Yii::$app->user->isGuest) {
                    $app->defaultRoute = 'user/security/login';
                }

                /*******************************
                /* Subscription
                /*******************************/
                if (!$app->hasModule('subscription') && class_exists(\app\modules\subscription\Module::class)) {
                    /** @var \app\modules\subscription\Module $subscription */
                    $app->setModule('subscription', [
                        'class' => \app\modules\subscription\Module::class,
                    ]);
                    $subscription = $app->getModule('subscription');
                    $subscription->bootstrap($app);
                }

                /** @var \kartik\datecontrol\Module $dateControlModule */
                $dateControlModule = $app->getModule('datecontrol');

                // Date / Time formats
                if (isset($dateControlModule->displaySettings)) {
                    $dateFormat = $app->settings->get('app.dateFormat') ? $app->settings->get('app.dateFormat') : $dateControlModule->displaySettings['date'];
                    $timeFormat = $app->settings->get('app.timeFormat') ? $app->settings->get('app.timeFormat') : $dateControlModule->displaySettings['time'];
                    $dateTimeFormat = $app->settings->get('app.dateTimeFormat') ? $app->settings->get('app.dateTimeFormat') : $dateControlModule->displaySettings['datetime'];
                    $dateControlModule->displaySettings = [
                        'date' => $dateFormat,
                        'time' => $timeFormat,
                        'datetime' => $dateTimeFormat,
                    ];
                }

                /*******************************
                /* Mailer
                /*******************************/

                // Change transport class to Sendinblue or SMTP
                $defaultMailerTransport = !empty($app->params['App.Mailer.transport']) ? $app->params['App.Mailer.transport'] : '';

                if ($app->settings->get('mailerTransport', 'app', $defaultMailerTransport) === 'ses') {

                    // Set Amazon SES mail component as mailer
                    $app->set('mailer', [
                        'class' => 'app\components\ses\Mailer',
                        'access_key' => $app->settings->get('aws.sesAccessKeyId'),
                        'secret_key' => $app->settings->get('aws.sesSecretAccessKey'),
                        'region' => $app->settings->get('aws.sesRegion'),
                    ]);

                } elseif ($app->settings->get('mailerTransport', 'app', $defaultMailerTransport) === 'sendinblue') {

                    // Set Sendinblue mail component as mailer
                    $app->set('mailer', [
                        'class' => 'app\components\sendinblue\Mailer',
                        'apiKey' => $app->settings->get('sendinblue.key'),
                    ]);

                } else {

                    // Set default transport class with PHP mail()
                    $transport = [
                        'class' => 'Swift_MailTransport',
                    ];

                    // Set an SMTP account
                    if ($app->settings->get('mailerTransport', 'app', $defaultMailerTransport) === 'smtp') {
                        $transport = [
                            'class' => 'Swift_SmtpTransport',
                            'host' => $app->settings->get("smtp.host"),
                            'username' => $app->settings->get("smtp.username"),
                            'password' => base64_decode($app->settings->get("smtp.password")),
                            'port' => $app->settings->get("smtp.port"),
                            'encryption' => $app->settings->get("smtp.encryption") == 'none'?
                                null :
                                $app->settings->get("smtp.encryption"),
                        ];
                    }

                    // Set mail queue component as mailer
                    $app->set('mailer', [
                        'class' => 'app\components\queue\MailQueue',
                        'mailsPerRound' => 10,
                        'maxAttempts' => 3,
                        'transport' => $transport,
                        'messageConfig' => [
                            'charset' => 'UTF-8',
                        ]
                    ]);
                }

                /*******************************
                /* File System
                /*******************************/
                if (isset($app->fs)) {
                    $app->set('fs', [
                        'class' => \app\components\flysystem\LocalFilesystem::class,
                        'path' => '@webroot/static_files/uploads',
                    ]);
                    Yii::setAlias('uploads', 'static_files/uploads');
                }

                /*******************************
                /* User session
                /*******************************/

                if (isset($app->user) && !$app->user->isGuest) {
                    /** @var \app\models\Profile $profile */
                    $profile = $app->user->identity->profile;

                    // Setting the timezone to the current users timezone
                    if (isset($profile->timezone)) {
                        $app->setTimeZone($profile->timezone);
                    }

                    // Setting the language to the current users language
                    if (isset($profile->language)) {
                        $app->language = $profile->language;
                    }
                }

                /**
                 * User module
                 */
                /** @var Module $userModule */
                $userModule = $app->getModule('user');

                // Mail params
                if (isset($userModule->mailParams)) {
                    $userModule->mailParams = [
                        'fromEmail' => MailHelper::from(Yii::$app->settings->get("app.supportEmail")),
                        'welcomeMailSubject' => Yii::t('app', 'Welcome to {0}', Yii::$app->settings->get("app.name")),
                        'confirmationMailSubject' => Yii::t('app', 'Confirm account on {0}', Yii::$app->settings->get("app.name")),
                        'reconfirmationMailSubject' => Yii::t('app', 'Confirm email change on {0}', Yii::$app->settings->get("app.name")),
                        'recoveryMailSubject' => Yii::t('app', 'Complete password reset on {0}', Yii::$app->settings->get("app.name")),
                    ];
                }

                // Enable Registration
                if ($app->settings->get('anyoneCanRegister', 'app', false)) {
                    $userModule->enableRegistration = true;
                }

                // Enable Unconfirmed Email Login
                if ($app->settings->get('unconfirmedEmailLogin', 'app', true)) {
                    $userModule->allowUnconfirmedEmailLogin = true;
                }

                // Enable Two Factor Authentication
                if ($app->settings->get('twoFactorAuthentication', 'app', false)) {
                    $userModule->enableTwoFactorAuthentication = true;
                }

                // Max Password Age
                if ($maxPasswordAge = (int) $app->settings->get('maxPasswordAge', 'app', null)) {
                    if ($maxPasswordAge > 0) {
                        $userModule->maxPasswordAge = $maxPasswordAge;
                    }
                }

                /**
                 * Fix https issue with reverse proxy when it's needed
                 */
                if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                    if (preg_match('/https/i', $_SERVER['HTTP_X_FORWARDED_PROTO'])) {
                        $_SERVER['HTTPS'] = 'On';
                        $_SERVER['HTTP_X_FORWARDED_PORT'] = 443;
                        $_SERVER['SERVER_PORT'] = 443;
                    }
                }

                /**
                 * Fix https issue with cloudflare when it's needed
                 */
                if (isset($_SERVER['HTTP_CF_VISITOR'])) {
                    if (preg_match('/https/i', $_SERVER['HTTP_CF_VISITOR'])) {
                        $_SERVER['HTTPS'] = 'On';
                        $_SERVER['HTTP_X_FORWARDED_PORT'] = 443;
                        $_SERVER['SERVER_PORT'] = 443;
                    }
                }


                /**
                 * API module
                 */
                /** @var \app\modules\api\Module $apiModule */
                $apiModule = $app->getModule('api');
                if ($restApiStatus = (int) $app->settings->get('restApi', 'app', 0)) {
                    if ($restApiStatus > 0) {
                        $apiModule->isEnabled = (boolean) $restApiStatus;
                    }
                }

            } catch (\Exception $e) {
                // Do nothing
            }

        });

        /*******************************
        /* Event Handlers
        /*******************************/

        $app->on(
            'app.form.updated',
            ['app\events\handlers\FormEventHandler', 'onFormUpdated']
        );

        $app->on(
            'app.form.submission.received',
            ['app\events\handlers\SubmissionEventHandler', 'onSubmissionReceived']
        );

        $app->on(
            'app.form.submission.accepted',
            ['app\events\handlers\SubmissionEventHandler', 'onSubmissionAccepted']
        );

        $app->on(
            'app.form.submission.rejected',
            ['app\events\handlers\SubmissionEventHandler', 'onSubmissionRejected']
        );

        $app->on(
            'app.form.submission.verified',
            ['app\events\handlers\SubmissionEventHandler', 'onSubmissionVerified']
        );

        // After new user registration
        Event::on(RegistrationController::className(), FormEvent::EVENT_AFTER_REGISTER, function (FormEvent $event) {
            /** @var RegistrationForm $form */
            $form = $event->getForm();
            /** @var User $user */
            $user = User::find()->where(['email' => $form->email])->one();
            $profile = $user->profile;
            // Assign default user language to user
            if ($defaultUserLanguage = Yii::$app->settings->get('app.defaultUserLanguage')) {
                $profile->language = $defaultUserLanguage;
            }
            // Assign default user timezone to user
            if ($defaultUserTimezone = Yii::$app->settings->get('app.defaultUserTimezone')) {
                $profile->timezone = $defaultUserTimezone;
            }
            $profile->save(false);
            // Assign default user role to user
            if ($defaultUserRole = Yii::$app->settings->get('app.defaultUserRole')) {
                $auth = Yii::$app->authManager;
                $roles = $auth->getRoles();
                $roles = ArrayHelper::getColumn($roles, 'name');
                if (in_array($defaultUserRole, $roles)) {
                    $authRole = $auth->getRole($defaultUserRole);
                    $auth->assign($authRole, $user->id);
                }
            }
        });

        // Before user login
        Event::on(SecurityController::className(), FormEvent::EVENT_BEFORE_LOGIN, function (FormEvent $event) {
            // Enable identityCookie
            if (isset($event->form, $event->form->rememberMe)) {
                $event->form->rememberMe = true;
            }
        });

        // After reset password
        Event::on(RecoveryController::class,FormEvent::EVENT_AFTER_REQUEST, function (FormEvent $event) {
            // Redirect to login page
            Yii::$app->controller->redirect(['/user/security/login']);
            Yii::$app->end();
        });
    }
}
