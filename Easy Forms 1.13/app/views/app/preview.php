<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */
/* @var $themeModel app\models\Theme */

$this->title = $formModel->name;

?>
<?php if (isset($themeModel) && !empty($themeModel->css)) : ?>
    <style type="text/css">
        <?= $themeModel->css ?>
    </style>
<?php endif; ?>

    <style type="text/css" id="liveCSS">
    </style>

    <div class="form-preview">
        <?= Html::decode($formDataModel->html) ?>
    </div>
<?php
$js =
    '$(document).ready(function(){
        $("#form-app").attr("role", "form");
        $("#form-app").attr("novalidate", "true");
        $( "#form-app" ).submit(function( event ) {
          event.preventDefault();
        });
    });';

$this->registerJs($js);