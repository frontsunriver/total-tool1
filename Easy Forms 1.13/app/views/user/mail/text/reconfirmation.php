<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

/**
 * @var \Da\User\Model\Token $token
 */
?>
<?= Yii::t('app', 'Hello') ?>,

<?= Yii::t(
    'app',
    'We have received a request to change the email address for your account on {0}',
    Yii::$app->settings->get("app.name")
) ?>.
<?= Yii::t('app', 'In order to complete your request, please click the link below') ?>.

<?= $token->url ?>

<?= Yii::t('app', 'If you cannot click the link, please try pasting the text into your browser') ?>.

<?= Yii::t('app', 'If you did not make this request you can ignore this email') ?>.
