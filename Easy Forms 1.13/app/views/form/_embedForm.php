<?php

use yii\helpers\Url;
use app\helpers\UrlHelper;

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */

?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Embed with design:") ?></h3>
    </div>
    <div class="panel-body">
        <p><strong>
                <?= Yii::t('app', 'Love the theme you have created? Well, now you can share it with all.') ?>
            </strong></p>
        <p><?= Yii::t(
                'app',
                'To place your form with the theme design on your website just copy and paste the following embed code.'
            ) ?></p>
        <form>
        <textarea class="form-control" rows="3" onfocus="this.select();" onmouseup="return false;"><!-- <?= Yii::$app->settings->get('app.name') ?> -->
<div id="c<?= $formModel->id ?>">
    <?= Yii::t('app', 'Fill out my') ?> <a href="<?= Url::to(['app/form', 'id' => $formModel->hashId], true) ?>"><?= Yii::t('app', 'online form') ?></a>.
</div>
<script type="text/javascript">
    (function(d, t) {
        var s = d.createElement(t), options = {
            'id': '<?= $formModel->hashId ?>',
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
<!-- End <?= Yii::$app->settings->get('app.name') ?> --></textarea>
        </form>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t('app', 'Remember always between the opening and closing &lt;body&gt; tag.') ?>
        </p>
    </div>
</div>

<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::t("app", "Embed without design:") ?></h3>
    </div>
    <div class="panel-body">
        <p><strong><?= Yii::t('app', 'Maybe this time you want to share without your theme?') ?></strong></p>
        <p><?= Yii::t('app', 'To place your form without the theme design on your website just copy and paste the following embed code.') ?></p>
        <form>
        <textarea class="form-control" rows="3" onfocus="this.select();" onmouseup="return false;"><!-- <?= Yii::$app->settings->get('app.name') ?> -->
<div id="c<?= $formModel->id ?>">
    <?= Yii::t('app', 'Fill out my') ?> <a href="<?= Url::to(['app/form', 'id' => $formModel->hashId], true) ?>"><?= Yii::t('app', 'online form') ?></a>.
</div>
<script type="text/javascript">
    (function(d, t) {
        var s = d.createElement(t), options = {
            'id': '<?= $formModel->hashId ?>',
            'theme': 0,
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
<!-- End <?= Yii::$app->settings->get('app.name') ?> --></textarea>
        </form>
    </div>
    <div class="panel-footer">
        <p class="hint-block">
            <?= Yii::t('app', 'Remember always between the opening and closing &lt;body&gt; tag.') ?>
        </p>
    </div>
</div>
