<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.10
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * Based on MailQueue.php (MIT license)
 * Copyright Saranga Abeykoon http://nterms.com
 */

namespace app\components\queue;

use Yii;
use Exception;
use yii\db\Expression;
use yii\swiftmailer\Mailer;
use app\models\Queue;

/**
 * Class MailQueue
 * MailQueue is a sub class of yii\switmailer\Mailer
 * which intends to replace it.
 *
 * Configuration is the same as in `yii\switmailer\Mailer` with some additional properties to control the mail queue
 *
 * @see http://www.yiiframework.com/doc-2.0/yii-swiftmailer-mailer.html
 * @see http://www.yiiframework.com/doc-2.0/ext-swiftmailer-index.html
 *
 * This extension replaces `yii\switmailer\Message` with `app\components\queue\Message'
 * to enable queuing right from the message.
 * @package app\components\queue
 */
class MailQueue extends Mailer
{
    const NAME = 'mailQueue';
    
    /**
     * @var string message default class name.
     */
    public $messageClass = 'app\components\queue\Message';

    /**
     * @var integer the default value for the number of mails to be sent out per processing round.
     */
    public $mailsPerRound = 10;
    
    /**
     * @var integer maximum number of attempts to try sending an email out.
     */
    public $maxAttempts = 3;

    /**
     * Sends out the messages in email queue and update the database.
     *
     * @return boolean true if all messages are successfully sent out
     */
    public function process()
    {
        $success = true;

        $items = Queue::find()
            ->where(['and', ['sent_time' => null], ['<', 'attempts', $this->maxAttempts]])
            ->orderBy(['created_at' => SORT_ASC])
            ->limit($this->mailsPerRound)
            ->all();

        if (!empty($items)) {
            $attributes = ['attempts', 'last_attempt_time'];
            foreach ($items as $item) {
                try{
                    /** @var \app\models\Queue $item */
                    if ($message = $item->toMessage()) {
                        if ($this->sendMessage($message)) {
                            $item->delete();
                        } else {
                            throw new Exception('An error occurred while sending the message');
                        }
                    }
                } catch (Exception $e) {
                    $success = false;
                    $item->attempts++;
                    $item->last_attempt_time = new Expression('NOW()');
                    $item->updateAttributes($attributes);
                }
            }
        }

        return $success;
    }
}
