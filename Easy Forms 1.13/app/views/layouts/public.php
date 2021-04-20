<?php
use yii\helpers\Html;
use app\helpers\Language;
use app\bundles\PublicBundle;
use app\components\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

PublicBundle::register($this);

// Controller + Action
$controllerID = $this->context->id;
$actionID = $this->context->action->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" dir="<?php echo Language::dir(); ?>">
<head>
    <!-- Meta Tags -->
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="robots" content="noindex, noarchive">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="generator" content="<?= Yii::$app->name ?> <?= Yii::$app->version ?>" />
    <link rel="shortcut icon" href="<?= Yii::$app->getHomeUrl() ?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_32.png" sizes="32x32">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_48.png" sizes="48x48">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_96.png" sizes="96x96">
    <link rel="icon" href="<?= Yii::$app->getHomeUrl() ?>favicon_144.png" sizes="144x144">

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="public <?= $controllerID ?> <?= $controllerID ?>-<?= $actionID ?>"
      onorientationchange="window.scrollTo(0, 1)">
<?php $this->beginBody() ?>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
