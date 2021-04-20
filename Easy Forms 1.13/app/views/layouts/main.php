<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\helpers\Language;
use app\bundles\AppBundle;
use app\components\widgets\Alert;
use app\components\widgets\SessionTimeout;

/* @var $this \yii\web\View */
/* @var $content string */

AppBundle::register($this);

$moduleID = $this->context->module->id;
$controllerID = $this->context->id;
$actionID = $this->context->action->id;
$userModule = Yii::$app->getModule('user');

// Brand
$appName = Yii::$app->settings->get("app.name");
$brandLabel = Html::tag("span", $appName, ["class" => "app-name"]);
$brandStyle = 'padding: 15px';
if ($logo = Yii::$app->settings->get("logo", "app", null)) {
    $brandLabel = Html::img(Url::to('@web/static_files/uploads' . '/' . $logo, true), [
        'height' => '40px',
        'alt' => $appName,
        'title' => $appName,
    ]);
    $brandStyle = 'padding: 5px 15px';
}

// Session Timeout
$timeoutValue = (int) Yii::$app->user->preferences->get('App.User.SessionTimeout.value');
$timeoutWarning = empty(Yii::$app->params['App.User.SessionTimeout.warning']) ? $timeoutValue : ($timeoutValue - (int) Yii::$app->params['App.User.SessionTimeout.warning']);
// Disable with Form Builder
$disabledTimeout = in_array($controllerID, ['form', 'template']) && in_array($actionID, ['create', 'update'])
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" dir="<?php echo Language::dir(); ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="generator" content="<?= Yii::$app->name ?> <?= Yii::$app->version ?>" />
    <link rel="shortcut icon" href="<?= Yii::$app->getHomeUrl() ?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_32.png" sizes="32x32">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_48.png" sizes="48x48">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_96.png" sizes="96x96">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_144.png" sizes="144x144">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) . ' | ' . Yii::$app->settings->get('app.name') ?></title>
    <?php $this->head() ?>

</head>
<body class="main <?= $controllerID ?> <?= $controllerID ?>-<?= $actionID ?>">

<?php $this->beginBody() ?>
<div class="wrap">

    <?php if (!Yii::$app->user->isGuest) : ?>

        <?php NavBar::begin([
            'brandLabel' => $brandLabel,
            'brandOptions' => [
                'title' => strip_tags(Yii::$app->settings->get("app.description")),
                'style' => $brandStyle,
            ],
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]); ?>

        <?php echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'items' => [
                ['label' => Yii::t("app", "Dashboard"), 'url' => ['/dashboard'],
                    'active' => 'app' === $moduleID && 'dashboard' === $controllerID],
                ['label' => Yii::t("app", "Forms"), 'url' => ['/form'],
                    'active' => 'app' === $moduleID && 'form' === $controllerID,
                    'visible' => Yii::$app->user->can("viewForms", ['listing' => true])],
                ['label' => Yii::t("app", "Themes"), 'url' => ['/theme'],
                    'active' => 'app' === $moduleID && 'theme' === $controllerID,
                    'visible' => Yii::$app->user->can("viewThemes", ['listing' => true])],
                ['label' => Yii::t("app", "Add-ons"), 'url' => ['/addons'],
                    'active' => !in_array($moduleID, ['app', 'user', 'subscription']),
                    'visible' => Yii::$app->user->can("viewAddons", ['listing' => true])],
                ['label' => Yii::t("app", "Users"), 'url' => ['/user/admin/index'],
                    'active' => 'user' === $moduleID && 'settings' !== $controllerID,
                    'visible' => Yii::$app->user->can("viewUsers")],
                ['label' => Html::img(Yii::$app->user->identity->profile->getAvatarUrl(), ['class' => 'avatar']) .
                    ' ' . Yii::$app->user->identity->username,
                    'url' => ['/user'],
                    'options'=>['class'=>'dropdown hasAvatar'],
                    'template' => '<a href="{url}" class="href_class">{label}</a>',
                    'items' => [
                        ['label' => Yii::t("app", "Manage account"), 'url' => ['/user/settings/profile'],
                            'active' => 'user' === $moduleID && 'settings' === $controllerID, ],
                        ['label' => Yii::t("app", "Settings"), 'url' => ['/settings/site'],
                            'active' => 'app' === $moduleID && 'settings' === $controllerID,
                            'visible' => Yii::$app->user->can("configureSite")],
                        '<li class="divider"></li>',
                        ['label' => Yii::t("app", "Switch back"),
                            'url' => ['/user/admin/switch-identity'],
                            'linkOptions' => [
                                'data-method' => 'post',
                                'style' => 'margin-bottom: 5px',
                                'title' => Yii::t('app', 'Switch back to your account')],
                            'visible' => Yii::$app->session->has($userModule->switchIdentitySessionKey)],
                        ['label' => Yii::t("app", "Logout"), 'url' => ['/user/security/logout'],
                            'linkOptions' => ['data-method' => 'post', 'class' => 'highlighted']],
                    ]
                ],
            ],
        ]); ?>

        <?php NavBar::end(); ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'options' => ['class' => 'breadcrumb breadcrumb-arrow'],
                'itemTemplate' => "<li>{link}</li>\n", // template for all links
                'activeItemTemplate' => "<li class='active'><span>{link}</span></li>\n",
                'homeLink' => [
                    'label' => Yii::t('app', 'Dashboard'),
                    'url' => ['/dashboard'],
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-right">&copy; <?= Yii::$app->settings->get("app.name") ?> <?= date('Y') ?></p>
            </div>
        </footer>
    <?php endif; ?>
</div>

<?php $this->endBody() ?>

<?php if (!$disabledTimeout && $timeoutValue > 0): ?>
    <?= SessionTimeout::widget([
        'warnAfter' => $timeoutWarning,
        'redirAfter' => $timeoutValue,
    ]) ?>
<?php endif; ?>

</body>
</html>
<?php $this->endPage() ?>
