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

namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use app\helpers\MailHelper;

/**
 * Forgot password form
 */
class ForgotForm extends Model
{
    /**
     * @var string Username and/or email
     */
    public $email;

    /**
     * @var \app\modules\user\models\User
     */
    protected $user = false;

    /**
     * @var \app\modules\user\Module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->module) {
            $this->module = Yii::$app->getModule("user");
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ["email", "required"],
            ["email", "email"],
            ["email", "validateEmail"],
            ["email", "filter", "filter" => "trim"],
        ];
    }

    /**
     * Validate email exists and set user property
     */
    public function validateEmail()
    {
        // check for valid user
        $this->user = $this->getUser();
        if (!$this->user) {
            $this->addError("email", Yii::t("app", "Email not found"));
        }
    }

    /**
     * Get user based on email
     *
     * @return \app\modules\user\models\User|null
     */
    public function getUser()
    {
        // get and store user
        if ($this->user === false) {
            $user = $this->module->model("User");
            $this->user = $user::findOne(["email" => $this->email]);
        }
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            "email" => Yii::t("app", "Email"),
        ];
    }

    /**
     * Send forgot email
     *
     * @return bool
     */
    public function sendForgotEmail()
    {
        /** @var Mailer $mailer */
        /** @var Message $message */
        /** @var \app\modules\user\models\UserToken $userToken */

        // validate
        if ($this->validate()) {

            // get user
            $user = $this->getUser();

            // calculate expireTime (converting via strtotime)
            $expireTime = $this->module->resetExpireTime;
            $expireTime = $expireTime ? gmdate("Y-m-d H:i:s", strtotime($expireTime)) : null;

            // create userToken
            $userToken = $this->module->model("UserToken");
            $userToken = $userToken::generate($user->id, $userToken::TYPE_PASSWORD_RESET, null, $expireTime);

            // modify view path to module views
            $mailer = Yii::$app->mailer;
            $oldViewPath = $mailer->viewPath;
            $mailer->viewPath = $this->module->emailViewPath;

            // send email
            $subject = Yii::$app->settings->get("app.name") . " - " . Yii::t("app", "Forgot Password");
            $message = $mailer->compose('forgotPassword', compact("subject", "user", "userToken"))
                ->setTo($user->email)
                ->setSubject($subject);

            // Sender by default: Support Email
            $fromEmail = MailHelper::from(Yii::$app->settings->get("app.supportEmail"));

            // Sender verification
            if (empty($fromEmail)) {
                return false;
            }

            $message->setFrom($fromEmail);

            $result = $message->send();

            // restore view path and return result
            $mailer->viewPath = $oldViewPath;
            return $result;
        }

        return false;
    }
}
