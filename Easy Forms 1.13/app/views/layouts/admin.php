<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\sidenav\SideNav;
use app\helpers\Language;
use app\bundles\AppBundle;
use app\components\widgets\Alert;
use app\components\widgets\SessionTimeout;

/* @var $this \yii\web\View */
/* @var $content string */

AppBundle::register($this);

/** @var \Da\User\Model\User $user */
$module = Yii::$app->getModule('user');
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

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
<body class="admin-page <?= $this->context->action->id ?>">

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
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo SideNav::widget([
                            'type' => SideNav::TYPE_DEFAULT,
                            'params' => [
                                'id' => 'sidenav-account',
                                'moduleId' => $moduleID,
                                'controllerId' => $controllerID,
                                'actionId' => $actionID,
                            ],
                            'indItem' => '',
                            'heading' => '<i class="glyphicon glyphicon-cogwheel"></i> '.
                                Yii::t('app', 'Manage account'),
                            'iconPrefix' => 'glyphicon glyphicon-',
                            'items' => [
                                [
                                    'url' => Url::to(['/user/settings/profile']),
                                    'label' => Yii::t("app", "Profile settings"),
                                    'icon' => 'user',
                                    'active' => ($actionID == 'profile'),
                                ],
                                [
                                    'url' => Url::to(['/user/settings/account']),
                                    'label' => Yii::t("app", "Account settings"),
                                    'icon' => 'user-key',
                                    'active' => ($actionID == 'account'),
                                ],
                                [
                                    'url' => Url::to(['/user/settings/preferences']),
                                    'label' => Yii::t("app", "Preferences"),
                                    'icon' => 'adjust',
                                    'active' => ($actionID == 'preferences'),
                                ],
                                [
                                    'url' => Url::to(['/user/settings/api']),
                                    'label' => Yii::t("app", "API"),
                                    'icon' => 'keys',
                                    'active' => ($actionID == 'api'),
                                    'visible' => Yii::$app->settings->get("app.restApiKey") === 1,
                                ],
                                [
                                    'url' => Url::to(['/user/settings/privacy']),
                                    'label' => Yii::t("app", "Privacy"),
                                    'icon' => 'adjust',
                                    'active' => ($actionID == 'privacy'),
                                    'visible' => $module->enableGdprCompliance
                                ],
                                [
                                    'url' => Url::to(['/user/settings/networks']),
                                    'label' => Yii::t("app", "Networks"),
                                    'icon' => 'adjust',
                                    'active' => ($actionID == 'networks'),
                                    'visible' => $module->enableGdprCompliance
                                ],
                            ],
                        ]);
                        ?>
                        <?php if (Yii::$app->user->can("configureSite")) : ?>
                            <?php echo SideNav::widget([
                                'type' => SideNav::TYPE_DEFAULT,
                                'params' => [
                                    'id' => 'sidenav-settings',
                                    'moduleId' => $moduleID,
                                    'controllerId' => $controllerID,
                                    'actionId' => $actionID,
                                ],
                                'indItem' => '',
                                'heading' => '<i class="glyphicon glyphicon-cogwheel"></i> '.Yii::t('app', 'Settings & Tools'),
                                'iconPrefix' => 'glyphicon glyphicon-',
                                'items' => [
                                    [
                                        'url' => Url::to(['/settings/site']),
                                        'label' => Yii::t("app", "Site Settings"),
                                        'icon' => 'cogwheels',
                                        'active' => ($actionID == 'site'),
                                        'visible' => Yii::$app->user->can("configureSite"),
                                    ],
                                    [
                                        'url' => Url::to(['/settings/mail']),
                                        'label' => Yii::t("app", "Mail Settings"),
                                        'icon' => 'inbox-out',
                                        'active' => ($actionID == 'mail'),
                                        'visible' => Yii::$app->user->can("configureMailServer"),
                                    ],
                                    [
                                        'url' => Url::to(['/settings/form']),
                                        'label' => Yii::t("app", "Form Tools"),
                                        'icon' => 'check',
                                        'active' => ($actionID == 'form'),
                                        'visible' => Yii::$app->user->can("configureSite"),
                                    ],
                                    [
                                        'url' => Url::to(['/settings/import-export']),
                                        'label' => Yii::t("app", "Import / Export"),
                                        'icon' => 'sorting',
                                        'active' => ($actionID == 'import-export'),
                                        'visible' => Yii::$app->user->can("migrateData"),
                                    ],
                                    [
                                        'url' => Url::to(['/settings/tools']),
                                        'label' => Yii::t("app", "System Tools"),
                                        'icon' => 'settings',
                                        'active' => ($actionID == 'tools'),
                                        'visible' => Yii::$app->user->can("accessPerformanceTools"),
                                    ],
                                ],
                            ]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-9">
                        <?= $content ?>
                    </div>
                </div>
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