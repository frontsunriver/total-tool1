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

use yii\mail\BaseMessage;

/**
 * Class Message
 * @package app\components\sendinblue
 */
class Message extends BaseMessage
{
    /**
     * The charset placeholder
     *
     * @var   string
     */
    public $charset = null;

    /**
     * The from placeholder
     *
     * @var   string|array
     */
    public $from = null;

    /**
     * The to placeholder
     *
     * @var   string|array
     */
    public $to = null;

    /**
     * The reply-to placeholder
     *
     * @var   string|array
     */
    public $replyTo = null;

    /**
     * The CC placeholder
     *
     * @var   string|array
     */
    public $cc = null;

    /**
     * The bCC placeholder
     *
     * @var   string|array
     */
    public $bcc = null;

    /**
     * The Subject placeholder
     *
     * @var   string
     */
    public $subject = null;

    /**
     * The Text Body placeholder
     *
     * @var   string
     */
    public $textBody = null;

    /**
     * The HTML Body placeholder
     *
     * @var   string
     */
    public $htmlBody = null;

    /**
     * The E-mail attachments
     *
     * @var array
     */
    public $attachments = array();

    /**
     * Returns the character set of this message.
     * @return string the character set of this message.
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Sets the character set of this message.
     * @param string $charset character set name.
     * @return $this self reference.
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }

    /**
     * Returns the message sender.
     * @return string|array the sender
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sets the message sender.
     * @param string|array $from sender email address.
     * You may pass an array of addresses if this message is from multiple people.
     * You may also specify sender name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Returns the message recipient(s).
     * @return string|array the message recipients
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Sets the message recipient(s).
     * @param string|array $to receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Returns the reply-to address of this message.
     * @return string|array the reply-to address of this message.
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * Sets the reply-to address of this message.
     * @param string|array $replyTo the reply-to address.
     * You may pass an array of addresses if this message should be replied to multiple people.
     * You may also specify reply-to name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * Returns the Cc (additional copy receiver) addresses of this message.
     * @return string|array the Cc (additional copy receiver) addresses of this message.
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * Sets the Cc (additional copy receiver) addresses of this message.
     * @param string|array $cc copy receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * Returns the Bcc (hidden copy receiver) addresses of this message.
     * @return string|array the Bcc (hidden copy receiver) addresses of this message.
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * Sets the Bcc (hidden copy receiver) addresses of this message.
     * @param string|array $bcc hidden copy receiver email address.
     * You may pass an array of addresses if multiple recipients should receive this message.
     * You may also specify receiver name in addition to email address using format:
     * `[email => name]`.
     * @return $this self reference.
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * Returns the message subject.
     * @return string the message subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the message subject.
     * @param string $subject message subject
     * @return $this self reference.
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Returns the message plain text content.
     * @return string the message body
     */
    public function getTextBody()
    {
        return $this->textBody;
    }

    /**
     * Sets message plain text content.
     * @param string $text message plain text content.
     * @return $this self reference.
     */
    public function setTextBody($text)
    {
        $this->textBody = $text;
        return $this;
    }

    /**
     * Returns the message HTML content.
     * @return string the message subject
     */
    public function getHtmlBody()
    {
        return $this->htmlBody;
    }

    /**
     * Sets message HTML content.
     * @param string $html message HTML content.
     * @return $this self reference.
     */
    public function setHtmlBody($html)
    {
        $this->htmlBody = $html;
        return $this;
    }

    /**
     * Returns the message HTML content.
     * @return array the message attachments
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Attaches existing file to the email message.
     * @param string $fileName full file name
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return $this self reference.
     */
    public function attach($fileName, array $options = [])
    {
        array_push($this->attachments, $fileName);
        return $this;
    }

    /**
     * Attach specified content as file for the email message.
     * @param string $content attachment file content.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return $this self reference.
     */
    public function attachContent($content, array $options = [])
    {
        // TODO: Implement attachContent() method.
    }

    /**
     * Attach a file and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     * @param string $fileName file name.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return string attachment CID.
     */
    public function embed($fileName, array $options = [])
    {
        // TODO: Implement embed() method.
    }

    /**
     * Attach a content as file and return it's CID source.
     * This method should be used when embedding images or other data in a message.
     * @param string $content attachment file content.
     * @param array $options options for embed file. Valid options are:
     *
     * - fileName: name, which should be used to attach file.
     * - contentType: attached file MIME type.
     *
     * @return string attachment CID.
     */
    public function embedContent($content, array $options = [])
    {
        // TODO: Implement embedContent() method.
    }

    /**
     * Returns string representation of this message.
     * @return string the string representation of this message.
     */
    public function toString()
    {
        // TODO: Implement toString() method.
    }
}