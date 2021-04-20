<?php

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */

?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Link to your Form") ?></h3>
    </div>
    <div class="panel-body">
        <p><?= Yii::t("app", "The following permanent URL will link to the form you have created immediately. It's a one step way to share everywhere.") ?></p>
        <form id="showForm">
            <div class="checkbox">
                <label class="checkbox-inline">
                    <input type="checkbox" id="withoutDesign"> <small><?= Yii::t('app', 'Without design') ?></small>
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="withoutBox">  <small><?= Yii::t('app', 'Without box') ?></small>
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" id="withoutCustomJS">
                    <small><?= Yii::t('app', 'Without custom JS') ?></small>
                </label>
            </div>
            <div class="input-group">
                <input type="url" id="formUrl" class="form-control" value="<?= \yii\helpers\Url::to([
                    'app/form',
                    'id' => $formModel->hashId
                ], true); ?>" onfocus="this.select();" onmouseup="return false;">
                <span class="input-group-btn">
                    <input type="submit" class="btn btn-info" value="<?= Yii::t('app', 'Go!') ?>">
                </span>
            </div><!-- /input-group -->
        </form>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t("app", "Share your form with others through email, social media or blog.") ?>
        </p>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Friendly Link to your Form") ?></h3>
    </div>
    <div class="panel-body">
        <p><?= Yii::t("app", "This is the friendly URL that references your form and will change if you edit your form's name.") ?></p>
        <form id="showFormAlt">
            <div class="checkbox">
                <label class="checkbox-inline">
                    <input type="checkbox" id="withoutBoxAlt">  <small><?= Yii::t('app', 'Without box') ?></small>
                </label>
            </div>
            <div class="input-group">
                <input type="url" id="formUrlAlt" class="form-control" value="<?= \yii\helpers\Url::to([
                    'app/forms',
                    'slug' => $formModel->slug
                ], true); ?>" onfocus="this.select();" onmouseup="return false;">
                <span class="input-group-btn">
                    <input type="submit" class="btn btn-info" value="<?= Yii::t('app', 'Go!') ?>">
                </span>
            </div><!-- /input-group -->
        </form>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t("app", "If you edit your form's name, all previously shared friendly link URL's will no longer work.") ?>
        </p>
    </div>
</div>
