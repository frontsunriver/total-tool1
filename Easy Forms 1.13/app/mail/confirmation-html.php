<?php

use app\helpers\Html;
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
<div style="margin-bottom: 20px; font-size:14px; color: #222;">
    <?= strip_tags($message, implode('', Html::allowedHtml5Tags())) ?>
</div>
<?php if ($mail_receipt_copy && count($fieldData) > 0) : ?>
    <?= SubmissionHelper::getSubmissionTable($fieldData) ?>
<?php endif; ?>
