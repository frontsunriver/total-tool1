<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var $content string
 */

$mainTitle = isset($mainTitle) ? $mainTitle : '';

?>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="grid-view">
            <div class="panel panel-default">
                <div class="panel-heading panel-big-heading">
                    <h3 class="panel-title">
                        <?= Html::encode($mainTitle) ?>
                        <small class="panel-subtitle hidden-xs">
                            <?= Html::encode($this->title) ?>
                        </small>
                    </h3>
                </div>
                <div class="panel-body">
                    <?= $this->render('/shared/_menu') ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
