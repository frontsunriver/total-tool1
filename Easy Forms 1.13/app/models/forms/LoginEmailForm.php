<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * @deprecated
 */


namespace app\models\forms;

use Yii;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use app\helpers\MailHelper;

/**
 * Login Email Form
 */
class LoginEmailForm extends \app\modules\user\models\forms\LoginEmailForm
{
    /**
     * Send forgot email
     * @return bool
     */
    public function sendEmail()
    {
        /** @var Mailer $mailer */
        /** @var Message $message */
        /** @var \app\modules\user\models\UserToken $userToken */

        if (!$this->validate()) {
            return false;
        }

        // get user and calculate userToken info
        $user = $this->getUser();
        $userId = $user ? $user->id : null;
        $data = $user ? null : $this->email;

        // calculate expireTime
        $expireTime = $this->module->loginExpireTime;
        $expireTime = $expireTime ? gmdate("Y-m-d H:i:s", strtotime($expireTime)) : null;

        // create userToken
        $userToken = $this->module->model("UserToken");
        $userToken = $userToken::generate($userId, $userToken::TYPE_EMAIL_LOGIN, $data, $expireTime);

        // modify view path to module views
        $mailer = Yii::$app->mailer;
        $oldViewPath = $mailer->viewPath;
        $mailer->viewPath = $this->module->emailViewPath;

        // send email
        $subject  = Yii::$app->settings->get("app.name") . " - ";
        $subject .= $user ? Yii::t('app', 'Log In') : Yii::t('app', 'Sign Up');
        $message = $mailer->compose('loginToken', compact("subject", "user", "userToken"))
            ->setTo($this->email)
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
}