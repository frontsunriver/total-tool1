<?php
use yii\helpers\Html;
use app\helpers\UrlHelper;
use yii\helpers\Url;

/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */
/* @var $popupForm app\models\forms\PopupForm */
?>
<!-- <?= Yii::$app->settings->get('app.name') ?> -->
<link href="<?= Url::to('@web/static_files/css/form.popup.min.css', true) ?>" rel="stylesheet" type="text/css">
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
<div class="ef-btn-wrapper ef-btn-wrapper-<?= $formModel->id ?>">
    <button id="ef-button-<?= $formModel->id ?>" class="ef-button ef-button-<?= $formModel->id ?> ef-button-<?= $popupForm->button_color ?> ef-button-<?= $popupForm->button_placement ?>-placement"><?= $popupForm->button_text ?></button>
</div>
<div id="ef-content-<?= $formModel->id ?>" class="ef-content-wrapper">
    <div id="c<?= $formModel->id ?>" class="ef-content">
        <?= Yii::t('app', 'Fill out my') ?> <a href="<?= Url::to(['app/form', 'id' => $formModel->hashId], true) ?>"><?= Yii::t('app', 'online form') ?></a>.
    </div>
    <script type="text/javascript">
        (function(d, t) {
            var s = d.createElement(t), options = {
                'id': <?= $formModel->hashId ?>,
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
</div>
<script src="<?= UrlHelper::removeScheme(Url::to('@web/static_files/js/form.popup.min.js', true)) ?>"></script>
<script type="text/javascript">
    var modal<?= $formModel->id ?> = new EasyForms.Modal({
        autoOpen: false,
        cssClass: ['ef-effect-<?= $popupForm->animation_effect ?>']
    });
    var btn<?= $formModel->id ?> = document.querySelector('.ef-button-<?= $formModel->id ?>');
    btn<?= $formModel->id ?>.addEventListener('click', function(){
        modal<?= $formModel->id ?>.open();
    });
    modal<?= $formModel->id ?>.setContent(document.getElementById('ef-content-<?= $formModel->id ?>'));
</script>
<!-- End <?= Yii::$app->settings->get('app.name') ?> -->