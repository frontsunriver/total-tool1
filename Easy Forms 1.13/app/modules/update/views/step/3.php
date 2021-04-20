<?php

use yii\helpers\Url;
use yii\bootstrap\Html;

$this->title = Yii::t('update', 'Updating Easy Forms');

$this->registerJsFile('@web/static_files/js/libs/jquery.progresstimer.min.js', [
        'depends' => \yii\web\JqueryAsset::class,
    ]);
?>

<div class="row">
    <div class="col-sm-4">
        <ul class="list-group">
            <li class="list-group-item">
                <?= Yii::t('update', 'Choose language') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item">
                <?= Yii::t('update', 'Requirements') ?> <?= Html::icon('ok', ['class' => 'text-success']) ?>
            </li>
            <li class="list-group-item list-group-item-current"><?= Yii::t('update', 'Update app') ?></li>
            <li class="list-group-item"><?= Yii::t('update', 'Finished') ?></li>
        </ul>
    </div>
    <div class="col-sm-8 form-wrapper">
        <?= Html::tag('h4', Yii::t('update', 'Updating Easy Forms'), ['class' => 'step-title']) ?>
        <div class="loading-progress"></div>
        <div class="form-action">
            <a id="continue" href="<?= Url::to(['5']) ?>" class="btn btn-primary" style="display: none;">
                <?= Yii::t('update', 'Continue') ?>
            </a>
        </div>
    </div>
</div>

<?php

$url = Url::to(['4']);
$errorText = Yii::t('update', 'There was an error updating your database, please contact us.');
$successText = Yii::t('update', 'Your application was successfully updated!');

$js = <<<JS
var progress = $(".loading-progress").progressTimer({
        timeLimit: 240,
        warningThreshold: 210,
        baseStyle: "",
        warningStyle: "progress-bar-danger",
        completeStyle: "",
        onFinish: function () {
            $('#continue').show();
        }
    });

    var successHandler = function () {
        var successText = '$successText';
        var glyph = $('<span></span>').addClass('glyphicon glyphicon-ok');
        $(".loading-progress")
        .append($('<p></p>').addClass('text-success').append(glyph).append(' ' + successText));
        $('#continue').show();
    };

    var errorHandler = function() {
        var errorText = '$errorText';
        var glyph = $('<span></span>').addClass('glyphicon glyphicon-remove-circle');
        $(".loading-progress").append($('<div></div>').addClass(' alert alert-danger').append(glyph).append(' ' + errorText));
    };

    $.ajax({
       url: '$url',
       cache: false
    }).error(function(){
        progress.progressTimer('error', {
            errorText: 'ERROR!',
            onFinish: errorHandler
        });
    }).done(function(response){
        if (response.success == 1) {
            progress.progressTimer('complete', {
                onFinish: successHandler
            });
        } else {
            progress.progressTimer('error', {
                errorText: 'ERROR!',
                onFinish: errorHandler
            });
        }
    });
JS;

$this->registerJs($js, $this::POS_END, 'progress-bar');
