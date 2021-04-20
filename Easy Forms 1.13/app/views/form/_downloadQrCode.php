<?php

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */

use app\helpers\Html;
use yii\helpers\Url;

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Download QR Code") ?></h3>
    </div>
    <div class="panel-body">
        <div class="text-center">
            <img style="width: 200px; height: 200px" src="<?= Url::to(['/form/qr-code', 'id' => $formModel->id]) ?>" />
        </div>
        <div class="text-center" style="margin: 10px">
            <?= Html::a(Yii::t('app', 'Download'),
                ['/form/qr-code', 'id' => $formModel->id, 'download' => 1],
                ['id' => 'downloadQrCode', 'class' => 'btn btn-info']) ?>
        </div>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t("app", "This special QR Code can be scanned with a smartphone.") ?>
        </p>
    </div>
</div>
