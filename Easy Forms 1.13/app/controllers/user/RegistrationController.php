<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9.2
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
namespace app\controllers\user;

use app\models\forms\RegistrationForm;
use Da\User\Controller\RegistrationController as BaseRegistrationController;
use Da\User\Event\FormEvent;
use Da\User\Event\UserEvent;
use Da\User\Factory\MailFactory;
use Da\User\Form\ResendForm;
use Da\User\Model\User;
use Da\User\Service\AccountConfirmationService;
use Da\User\Service\ResendConfirmationService;
use Da\User\Service\UserConfirmationService;
use Da\User\Service\UserRegisterService;
use Da\User\Validator\AjaxRequestModelValidator;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class RegistrationController
 * @package app\controllers\user
 */
class RegistrationController extends BaseRegistrationController
{

    public $layout = "public";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['register', 'connect', 'captcha'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm', 'resend'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0x313941,
                'foreColor' => 0xFFFFFF,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }
        /** @var RegistrationForm $form */
        $form = $this->make(RegistrationForm::class);
        /** @var FormEvent $event */
        $event = $this->make(FormEvent::class, [$form]);

        $this->make(AjaxRequestModelValidator::class, [$form])->validate();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->trigger(FormEvent::EVENT_BEFORE_REGISTER, $event);

            /** @var User $user */

            // Create a temporary $user so we can get the attributes, then get
            // the intersection between the $form fields  and the $user fields.
            $user = $this->make(User::class, [] );
            $fields = array_intersect_key($form->attributes, $user->attributes);

            // Becomes password_hash
            $fields['password'] = $form['password'];

            $user = $this->make(User::class, [], $fields );

            $user->setScenario('register');
            $mailService = MailFactory::makeWelcomeMailerService($user);

            if ($this->make(UserRegisterService::class, [$user, $mailService])->run()) {

                if ($this->module->enableEmailConfirmation) {
                    Yii::$app->session->setFlash(
                        'info',
                        Yii::t(
                            'app',
                            'Your account has been created and a message with further instructions has been sent to your email'
                        )
                    );
                } else {
                    Yii::$app->session->setFlash('info', Yii::t('app', 'Your account has been created'));
                }

                $this->trigger(FormEvent::EVENT_AFTER_REGISTER, $event);

                // Redirect to login page
                return $this->redirect(['/user/security/login']);
            }

            Yii::$app->session->setFlash('danger', Yii::t('app', 'User could not be registered.'));
        }

        return $this->render('register', ['model' => $form, 'module' => $this->module]);
    }

    /**
     * {@inheritdoc}
     */
    public function actionResend()
    {
        if ($this->module->enableEmailConfirmation === false) {
            throw new NotFoundHttpException();
        }
        /** @var ResendForm $form */
        $form = $this->make(ResendForm::class);
        $event = $this->make(FormEvent::class, [$form]);

        $this->make(AjaxRequestModelValidator::class, [$form])->validate();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            /** @var User $user */
            $user = $this->userQuery->whereEmail($form->email)->one();
            $success = true;
            if ($user !== null) {
                $this->trigger(FormEvent::EVENT_BEFORE_RESEND, $event);
                $mailService = MailFactory::makeConfirmationMailerService($user);
                if ($success = $this->make(ResendConfirmationService::class, [$user, $mailService])->run()) {
                    $this->trigger(FormEvent::EVENT_AFTER_RESEND, $event);
                    Yii::$app->session->setFlash(
                        'info',
                        Yii::t(
                            'app',
                            'A message has been sent to your email address. It contains a confirmation link that you must click to complete registration.'
                        )
                    );
                }
            }
            if ($user === null || $success === false) {
                Yii::$app->session->setFlash(
                    'danger',
                    Yii::t(
                        'app',
                        'We couldn\'t re-send the mail to confirm your address. Please, verify is the correct email or if it has been confirmed already.'
                    )
                );
            }

            return $this->redirect(['/user/security/login']);
        }

        return $this->render(
            'resend',
            [
                'model' => $form,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function actionConfirm($id, $code)
    {
        /** @var User $user */
        $user = $this->userQuery->whereId($id)->one();

        if ($user === null || $this->module->enableEmailConfirmation === false) {
            throw new NotFoundHttpException();
        }

        /** @var UserEvent $event */
        $event = $this->make(UserEvent::class, [$user]);
        $userConfirmationService = $this->make(UserConfirmationService::class, [$user]);

        $this->trigger(UserEvent::EVENT_BEFORE_CONFIRMATION, $event);

        if ($this->make(AccountConfirmationService::class, [$code, $user, $userConfirmationService])->run()) {
            Yii::$app->user->login($user, $this->module->rememberLoginLifespan);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you, registration is now complete.'));

            $this->trigger(UserEvent::EVENT_AFTER_CONFIRMATION, $event);
        } else {
            Yii::$app->session->setFlash(
                'danger',
                Yii::t('app', 'The confirmation link is invalid or expired. Please try requesting a new one.')
            );
        }

        return $this->redirect(['/']);
    }
}