<?php

// comment out the following two lines when deployed to production
// defined('YII_DEBUG') or define('YII_DEBUG', true);
// defined('YII_ENV') or define('YII_ENV', 'dev');

if (version_compare(PHP_VERSION, '5.6.0') < 0) {
    print 'Your PHP installation is too old. Easy Forms requires at least PHP 5.6.0. See the <a href="https://docs.easyforms.dev/system-requirements.html">system requirements</a> page for more information.';
    exit;
}

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/setup.php');

(new yii\web\Application($config))->run();