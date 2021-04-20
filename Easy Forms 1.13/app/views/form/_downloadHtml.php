<?php

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */

use app\helpers\Html;
use yii\helpers\Url; ?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Download Files") ?></h3>
    </div>
    <div class="panel-body">
        <div class="checkbox" style="margin-top: 0">
            <label class="checkbox-inline">
                <input type="checkbox" id="downloadWithoutJS" style="margin-top: 5px">
                <small><?= Yii::t('app', 'Only HTML & CSS code.') ?> <span class="text-muted"><?= Yii::t("app", "Conditional rules, multi-steps, form tracking, and other javascript tools will NOT work with this code.") ?></span></small>
            </label>
        </div>
        <?= Html::a(Yii::t('app', 'Download'),
            ['/form/download-html-code', 'id' => $formModel->id],
            ['id' => 'downloadHtmlCode', 'class' => 'btn btn-info']) ?>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t("app", "Contains the HTML, JS and CSS needed to recreate your form's design.") ?>
        </p>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Form Endpoint: Collect data with external forms") ?></h3>
    </div>
    <div class="panel-body">
        <p><?= Yii::t("app", "Please see the URL endpoint for this form below. It can accept POST and Ajax requests. Field validation, reCAPTCHA, and file uploads are available.") ?></p>
        <form id="formEndpoint">
            <div class="input-group">
                <input type="url" id="formEndpointUrl" class="form-control" value="<?= Url::to([
                    'app/f',
                    'id' => $formModel->id
                ], true); ?>" onfocus="this.select();" onmouseup="return false;">
                <span class="input-group-btn">
                    <input type="submit" class="btn btn-info" value="<?= Yii::t('app', 'Copy') ?>">
                </span>
            </div><!-- /input-group -->
        </form>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t("app", "Don’t forget that name attribute of each field must be equal to the Field Name or Field Alias of your Form.") ?>
        </p>
    </div>
</div>
