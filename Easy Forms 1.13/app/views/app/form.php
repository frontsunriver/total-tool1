<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\UrlHelper;

/* @var $this yii\web\View */
/* @var $formModel app\models\Form */
/* @var $formDataModel app\models\FormData */
/* @var $submissionModel app\models\FormSubmission */
/* @var $showTheme boolean */
/* @var $showBox boolean */
/* @var $customJS boolean */

// Home URL
$homeUrl = Url::home(true);

// Base URL without schema
$baseUrl = UrlHelper::removeScheme($homeUrl);

$this->title = $formModel->name;

// Add body background to show box design
if ($showBox) {
    $this->registerCss("body { background-color: #EFF3F6; } iframe { border-radius: 0 0 4px 4px; } ");
} else {
    // Add theme
    if ($showTheme && isset($formModel->theme, $formModel->theme->css) && !empty($formModel->theme->css)) {
        $this->registerCss($formModel->theme->css);
    }
}

// Allow / Disallow Edit a Form Submission
$sid = !empty($submissionModel->id) ? $submissionModel->id : 0;

// Brand
$appName = Yii::$app->settings->get("app.name");
$brandLabel = Html::tag("span", $appName, ["class" => "app-name"]);
if ($logo = Yii::$app->settings->get("logo", "app", null)) {
    $brandLabel = Html::img(Url::to('@web/static_files/uploads' . '/' . $logo, true), [
        'height' => '26px',
        'alt' => $appName,
        'title' => $appName,
    ]);
}

?>
    <?php if ($showBox) : ?>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                    <div class="form-view">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <?= Html::a(
                                        $brandLabel,
                                        $homeUrl,
                                        [
                                            "title" => Yii::$app->settings->get("app.description"),
                                            "style" => 'text-decoration:none',
                                        ]
                                    ) ?>
                                </h3>
                            </div>
                            <div class="panel-body" style="padding: 5px; line-height: 0;">
                                <!-- Easy Forms -->
                                <div id="c<?= $formModel->hashId ?>">
                                    <?= Yii::t('app', 'Fill out my') ?> <a href="<?= Url::to(['app/form', 'id' => $formModel->hashId], true) ?>"><?= Yii::t('app', 'online form') ?></a>.
                                </div>
                                <script type="text/javascript">
                                    (function(d, t) {
                                        var s = d.createElement(t), options = {
                                            'id': '<?= $formModel->hashId ?>',
                                            'sid': <?= $sid ?>,
                                            'theme': <?= $showTheme ?>,
                                            'customJS': <?= $customJS ?>,
                                            'container': 'c<?= $formModel->hashId ?>',
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
                                <!-- End Easy Forms -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
    <div class="container-fluid">
        <div class="row row-no-gutters">
            <div class="col-xs-12">
                <!-- Easy Forms -->
                <div id="c<?= $formModel->hashId ?>">
                    <?= Yii::t('app', 'Fill out my') ?> <a href="<?= Url::to(['app/form', 'id' => $formModel->hashId], true) ?>"><?= Yii::t('app', 'online form') ?></a>.
                </div>
                <script type="text/javascript">
                    (function(d, t) {
                        var s = d.createElement(t), options = {
                            'id': '<?= $formModel->hashId ?>',
                            'sid': <?= $sid ?>,
                            'theme': <?= $showTheme ?>,
                            'customJS': <?= $customJS ?>,
                            'container': 'c<?= $formModel->hashId ?>',
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
                <!-- End Easy Forms -->
            </div>
        </div>
    </div>
    <?php endif; ?>

