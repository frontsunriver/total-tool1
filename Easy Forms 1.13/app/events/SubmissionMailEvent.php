<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.7.2
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\events;

use yii\mail\MailEvent;
use app\models\FormSubmission;

/**
 * Class SubmissionMailEvent
 * @package app\events
 */
class SubmissionMailEvent extends MailEvent
{
    const EVENT_NAME = 'app.form.submission.mail';
    const EVENT_TYPE_CONFIRMATION = 1;
    const EVENT_TYPE_NOTIFICATION = 2;
    const EVENT_TYPE_CONDITIONAL = 3;

    /** @var string $type It can be 'confirmation' or 'notification' */
    public $type;
    /** @var boolean $async */
    public $async;
    /** @var array $tokens */
    public $tokens;
    /** @var FormSubmission */
    public $submission;
}