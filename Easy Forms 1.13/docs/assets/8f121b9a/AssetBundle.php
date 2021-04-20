<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\templates\bootstrap\assets;

use yii\web\View;

/**
 * The asset bundle for the offline template.
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @since 2.0
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/templates/bootstrap/assets';
    public $css = [
        'css/fonts.min.css',
        'css/bootstrap.min.css',
        'css/api.css',
        'css/style.css',
    ];
    public $js = [
//        'js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\templates\bootstrap\assets\HighlightBundle',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}
