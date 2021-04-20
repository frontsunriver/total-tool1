<?php

use app\helpers\Liquid;
use app\helpers\SubmissionHelper;
use yii\web\View;

/* @var $this View view component instance */
/* @var $message string Custom Message */
/* @var $fieldValues array Submission data for replacement token */
/* @var $fieldData array Submission data for print details */
/* @var $mail_receipt_copy boolean Includes a Form Submission Copy */

$message = SubmissionHelper::replaceTokens($message, $fieldValues);
$message = Liquid::render($message, $fieldValues);
?>
<?= strip_tags($message); ?>

<?php if ($mail_receipt_copy && count($fieldData) > 0) : ?>
    <?= SubmissionHelper::getSubmissionTable($fieldData, true) ?>
<?php endif; ?>
