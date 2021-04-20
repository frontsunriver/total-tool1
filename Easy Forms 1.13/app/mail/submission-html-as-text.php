<?php

use app\helpers\SubmissionHelper;
use yii\web\View;

/* @var $this View view component instance */
/* @var $message string Custom Message */
/* @var $fieldValues array Submission data for replacement token */
/* @var $fieldData array Submission data for print details */
/* @var $mail_receipt_copy boolean Includes a Form Submission Copy */
/* @var $formID integer Form ID */
/* @var $submissionID integer Submission ID */

?>
<?= SubmissionHelper::getSubmissionTable($fieldData, true) ?>
