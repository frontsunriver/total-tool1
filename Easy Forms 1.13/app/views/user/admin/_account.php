<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var yii\web\View $this */
/* @var Da\User\Model\User $user */

?>

<?php $this->beginContent('@Da/User/resources/views/admin/update.php', [
    'user' => $user,
    'title' => Yii::t('app', 'Account details')]) ?>

<?php $form = ActiveForm::begin(
    [
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-9',
            ],
        ],
    ]
); ?>

<?= $this->render('/admin/_user', ['form' => $form, 'user' => $user]) ?>

<div class="form-action">
    <?= Html::submitButton(
        '<i class="glyphicon glyphicon-ok" style="margin-right: 3px"></i> ' .
        Yii::t('app', 'Save'), ['class' => 'btn btn-primary']
    ) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
