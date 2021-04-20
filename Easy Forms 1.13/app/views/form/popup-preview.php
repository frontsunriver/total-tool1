<?php
use yii\helpers\Html;
use app\helpers\UrlHelper;
use yii\helpers\Url;

/* @var $popupForm app\models\forms\PopupForm */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::t('app', 'Pop-Up Preview') . ' | ' . Yii::$app->settings->get('app.name') ?></title>
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href="<?= Yii::$app->getHomeUrl() ?>static_files/css/form.popup.css" rel="stylesheet" type="text/css">
    <style>
        .ef-modal {
            background: <?= $popupForm->overlay_color ?> !important; /* Overlay color */
        }
        .ef-modal-box {
            margin: <?= $popupForm->popup_margin ?>px auto !important; /* Pop-Up margin */
            padding: <?= $popupForm->popup_padding ?>px !important; /* Pop-Up pading */
            width: <?= $popupForm->popup_width ?>% !important; /* Pop-Up width */
            border-radius: <?= $popupForm->popup_radius ?>px !important; /* Pop-Up radius */
            background: <?= $popupForm->popup_color ?> !important; /* Pop-Up background */

            /** Animation duration **/
            -webkit-transition: all <?= $popupForm->animation_duration ?>s !important;
            -moz-transition: all <?= $popupForm->animation_duration ?>s !important;
            -o-transition: all <?= $popupForm->animation_duration ?>s !important;
            transition: all <?= $popupForm->animation_duration ?>s !important;
        }
    </style>
</head>
<body>
<div class="ef-btn-wrapper">
    <button class="ef-button ef-button-<?= $popupForm->button_color ?> ef-button-<?= $popupForm->button_placement ?>-placement"><?= $popupForm->button_text ?></button>
</div>
<div id="ef-content">
    <!-- <?= Yii::$app->settings->get('app.name') ?> -->
    <div id="c<?= $formModel->id ?>" class="ef-content">
        <?= Yii::t('app', 'Fill out my') ?> <a href="<?= Url::to(['app/form', 'id' => $formModel->id], true) ?>"><?= Yii::t('app', 'online form') ?></a>.
    </div>
    <script type="text/javascript">
        (function(d, t) {
            var s = d.createElement(t), options = {
                'id': <?= $formModel->id ?>,
                'container': 'c<?= $formModel->id ?>',
                'height': '<?= $formDataModel->height ?>px',
                'form': '<?= UrlHelper::removeScheme(Url::to(['/app/embed'], true)) ?>'
            };
            s.type= 'text/javascript';
            s.src = '<?= Url::to('@web/static_files/js/form.widget.js', true) ?>';
            s.onload = s.onreadystatechange = function() {
                var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
                try { (new EasyForms()).initialize(options).display() } catch (e) { }
            };
            var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
        })(document, 'script');
    </script>
    <!-- End <?= Yii::$app->settings->get('app.name') ?> -->
</div>
<script src="<?= Yii::$app->getHomeUrl() ?>static_files/js/form.popup.js"></script>
<script type="text/javascript">
    var modal = new EasyForms.Modal({
        autoOpen: false,
        cssClass: ['ef-effect-<?= $popupForm->animation_effect ?>']
    });
    var btn = document.querySelector('.ef-button');
    btn.addEventListener('click', function(){
        modal.open();
    });
    modal.setContent(document.getElementById('ef-content'));
</script>
</body>
</html>