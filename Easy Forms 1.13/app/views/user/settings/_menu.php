<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\Menu;
use kartik\sidenav\SideNav;
use yii\helpers\Url;

/** @var \Da\User\Model\User $user */
$user = Yii::$app->user->identity;
$module = Yii::$app->getModule('user');
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

$moduleID = $this->context->module->id;
$controllerID = $this->context->id;
$actionID = $this->context->action->id;

?>

<?php echo SideNav::widget([
    'type' => SideNav::TYPE_DEFAULT,
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
            'icon' => 'keys',
            'active' => ($actionID == 'account'),
        ],
        [
            'url' => Url::to(['/user/preferences']),
            'label' => Yii::t("app", "Preferences"),
            'icon' => 'adjust',
            'active' => ($actionID == 'preferences'),
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
        'heading' => '<i class="glyphicon glyphicon-cogwheel"></i> '.Yii::t('app', 'Settings & Tools'),
        'iconPrefix' => 'glyphicon glyphicon-',
        'items' => [
            [
                'url' => Url::to(['/settings/site']),
                'label' => Yii::t("app", "Site settings"),
                'icon' => 'cogwheels',
                'active' => ($actionID == 'site'),
                'visible' => Yii::$app->user->can("configureSite"),
            ],
            [
                'url' => Url::to(['/settings/mail']),
                'label' => Yii::t("app", "Mail Server"),
                'icon' => 'inbox-out',
                'active' => ($actionID == 'mail'),
                'visible' => Yii::$app->user->can("configureMailServer"),
            ],
            [
                'url' => Url::to(['/settings/import-export']),
                'label' => Yii::t("app", "Import / Export"),
                'icon' => 'sorting',
                'active' => ($actionID == 'import-export'),
                'visible' => Yii::$app->user->can("migrateData"),
            ],
            [
                'url' => Url::to(['/settings/performance']),
                'label' => Yii::t("app", "Performance"),
                'icon' => 'settings',
                'active' => ($actionID == 'performance'),
                'visible' => Yii::$app->user->can("accessPerformanceTools"),
            ],
        ],
    ]); ?>
<?php endif; ?>
