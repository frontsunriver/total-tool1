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

namespace app\components\sendinblue;

use yii\mail\BaseMailer;
use app\components\sendinblue\services\SendinBlueService;

/**
 * Class Mailer
 * @package app\components\sendinblue
 */
class Mailer extends BaseMailer
{
    /**
     * @var string message default class name.
     */
    public $messageClass = 'app\components\sendinblue\Message';

    /**
     * @var string Sendinblue api key
     */
    public $apiKey;

     /**
     * @var SendinBlueService instance.
     */
    private $_service;

    /**
     * @return SendinBlueService
     * @throws \Exception
     */
    public function getService()
    {
        if (!is_object($this->_service)) {
            $this->_service = new SendinBlueService($this->apiKey);
        }

        return $this->_service;
    }

    /**
     * Sends the specified message.
     * This method should be implemented by child classes with the actual email sending logic.
     *
     * @param Message $message
     * @return bool
     * @throws \Exception
     */
    protected function sendMessage($message)
    {
        $email = $this->parseMessage($message);
        $response = $this->getService()->send($email);
        return isset($response['messageId']);
    }

    /**
     * Parse the specified message.
     * According to the Sendinblue requirements
     *
     * @param Message $message
     * @return array
     * @throws \Exception
     */
    private function parseMessage($message)
    {

        $email = [];

        $from = $message->getFrom();
        if ($from && is_string($from)) {
            $email['sender'] = [
                'name' => $from,
                'email' => $from, // Required
            ];
        } elseif ($from && is_array($from)) {
            $email['sender'] = [
                'name' => $from[key($from)],
                'email' => key($from), // Required
            ];
        }

        $to = $message->getTo();
        if ($to && is_string($to)) {
            $email['to'] = [
                [
                    'name' => $to,
                    'email' => $to, // Required
                ]
            ];
        } elseif ($to && is_array($to)) {
            foreach ($to as $k => $t) {
                $email['to'][] = [
                    'name' => $t,
                    'email' => $t, // Required
                ];
            }
        }

        $cc = $message->getCC();
        if ($cc && is_string($cc)) {
            $email['cc'] = [
                [
                    'name' => $cc,
                    'email' => $cc, // Required
                ]
            ];
        } elseif ($cc && is_array($cc)) {
            foreach ($cc as $k => $c) {
                $email['cc'][] = [
                    'name' => $c,
                    'email' => $c, // Required
                ];
            }
        }

        $bcc = $message->getBcc();
        if ($bcc && is_string($bcc)) {
            $email['bcc'] = [
                [
                    'name' => $bcc,
                    'email' => $bcc, // Required
                ]
            ];
        } elseif ($bcc && is_array($bcc)) {
            foreach ($bcc as $k => $b) {
                $email['bcc'][] = [
                    'name' => $b,
                    'email' => $b, // Required
                ];
            }
        }

        $replyTo = $message->getReplyTo();
        if ($replyTo && is_string($replyTo)) {
            $email['replyTo'] = [
                'name' => $replyTo,
                'email' => $replyTo, // Required
            ];
        } elseif ($replyTo && is_array($replyTo)) {
            $email['replyTo'] = [
                'name' => $replyTo[key($replyTo)],
                'email' => key($replyTo), // Required
            ];
        }

        $email['subject'] = $message->getSubject();
        $email['htmlContent'] = $message->getHtmlBody();
        $email['textContent'] = $message->getTextBody();

        $attachments = $message->getAttachments();
        if (is_array($attachments) && !empty($attachments)) {
            $email['attachment'] = [];
            foreach ($attachments as $attachment) {
                array_push($email['attachment'], [
                    'content' => base64_encode(file_get_contents($attachment)), // Required
                    'name' => basename($attachment), // Required
                ]);
            }
        }

        return $email;
    }

}