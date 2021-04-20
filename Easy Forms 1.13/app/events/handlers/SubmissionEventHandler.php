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

namespace app\events\handlers;

use app\events\SubmissionEvent;
use app\helpers\MailHelper;
use app\models\Form;
use app\models\FormSubmission;
use yii\base\Component;

/**
 * Class SubmissionEventHandler
 * @package app\events\handlers
 */
class SubmissionEventHandler extends Component
{

    /**
     * Executed when a submission is received
     *
     * @param $event
     */
    public static function onSubmissionReceived($event)
    {
    }

    /**
     * Executed when a submission is accepted
     *
     * @param $event
     * @throws \Exception
     */
    public static function onSubmissionAccepted($event)
    {

        /** @var FormSubmission $submissionModel */
        $submissionModel = $event->submission;
        /** @var Form $formModel */
        $formModel = empty($event->form) ? $submissionModel->form : $event->form;
        /** @var array $filePaths */
        $filePaths = empty($event->filePaths) ? [] : $event->filePaths;

        /*******************************
        /* Send Notification by e-mail
        /*******************************/
        if (isset($formModel->formEmail, $formModel->formEmail->event)
            && $formModel->formEmail->event === FormSubmission::STATUS_ACCEPTED) {
            MailHelper::sendNotificationByEmail($formModel, $submissionModel, $filePaths);
        }

        /*******************************
        /* Send Confirmation by e-mail
        /*******************************/
        MailHelper::sendConfirmationByEmail($formModel, $submissionModel, $filePaths);

    }

    /**
     * Executed when a submission is rejected
     *
     * @param $event
     */
    public static function onSubmissionRejected($event)
    {
    }

    /**
     * Executed when a submission is verified by link click
     *
     * @param SubmissionEvent $event
     * @throws \Exception
     */
    public static function onSubmissionVerified($event)
    {
        $submissionModel = $event->submission;
        $formModel = empty($event->form) ? $submissionModel->form : $event->form;
        $filePaths = empty($event->filePaths) ? [] : $event->filePaths;

        /*******************************
        /* Send Notification by e-mail
        /*******************************/
        if (isset($formModel->formEmail, $formModel->formEmail->event)
            && $formModel->formEmail->event === FormSubmission::STATUS_VERIFIED) {
            MailHelper::sendNotificationByEmail($formModel, $submissionModel, $filePaths);
        }
    }

}
