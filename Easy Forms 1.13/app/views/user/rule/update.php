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
 * @var \Da\User\Model\Rule $model
 * @var $this               yii\web\View
 * @var $unassignedItems    string[]
 */
$this->title = Yii::t('app', 'Update rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['/user/rule/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@Da/User/resources/views/shared/admin_layout.php', [
    'mainTitle' => Yii::t('app', 'Rules')]) ?>

<div style="padding: 25px 15px">
    <?= $this->render(
        '/rule/_form',
        [
            'model' => $model,
        ]
    ) ?>
</div>

<?php $this->endContent() ?>
