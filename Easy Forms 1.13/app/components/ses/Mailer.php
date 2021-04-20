<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.8
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
namespace app\components\ses;

use yii\mail\BaseMailer;
use app\components\ses\services\SimpleEmailService;

/**
 * Class Mailer
 * @package app\components\ses
 */
class Mailer extends BaseMailer
{
    /**
     * @var string message default class name.
     */
    public $messageClass = 'app\components\ses\Message';

    /**
     * @var string Amazon ses api access key
     */
    public $access_key;

    /**
     * @var string Amazon ses api secret key
     */
    public $secret_key;

    /**
     * @var string Amazon ses region
     */
    public $region = 'us-east-1';

    /**
     * @var SimpleEmailService SimpleEmailService instance.
     */
    private $_service;

    /**
     * @return SimpleEmailService SimpleEmailService instance.
     */
    public function getService()
    {
        if (!is_object($this->_service)) {
            if(!empty($this->region)) {
                $this->_service = new SimpleEmailService($this->access_key, $this->secret_key, 'email.'.$this->region.'.amazonaws.com');
            } else {
                $this->_service = new SimpleEmailService($this->access_key, $this->secret_key);
            }
        }

        return $this->_service;
    }

    /**
     * Sends the specified message.
     * @param Message $message the message to be sent
     * @return bool whether the message is sent successfully
     */
    protected function sendMessage($message)
    {
        $res = $this->getService()->sendEmail($message->getSesMessage());

        $message->setDate(time());

        return count($res) > 0;
    }

}