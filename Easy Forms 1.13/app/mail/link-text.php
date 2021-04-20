<?php

use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message string Custom Message */
/* @var $fields array Submission Fields */
/* @var $formID integer Form ID */
/* @var $submissionID integer Submission ID */
/* @var $message string Custom Message */

?>
<?= Yii::t('app', 'Your form has received a new submission') ?>.
<?= Yii::t('app', 'For more details') ?>, <?= Yii::t('app', 'please go here') ?>:
<?= Url::to(['form/submissions', 'id' => $formID, '#' => 'view/' . $submissionID ], true) ?>
