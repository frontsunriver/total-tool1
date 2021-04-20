<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.0
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\bundles;

use Yii;
use yii\web\AssetBundle;

/**
 * Class SubmissionsBundle
 *
 * @package app\bundles
 */
class SubmissionsBundle extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/static_files';
    public $css = [
        'css/daterangepicker.min.css',
        'css/daterangepicker-kv.min.css',
    ];
    public $js = [
        'js/libs/underscore.js',
        'js/libs/backbone.js',
        'js/libs/jquery.cookie.js',
        'js/libs/moment.min.js',
        'js/libs/daterangepicker.min.js',
        'js/libs/backbone-model-file-upload.js',
        'js/libs/signature_pad.umd.js',
        'js/submissions.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset', // Load jquery.js and bootstrap.js first
    ];
    public function init()
    {
        if (isset(Yii::$app->params['Google.Maps.apiKey']) && !empty(Yii::$app->params['Google.Maps.apiKey'])) {
            $key = Yii::$app->params['Google.Maps.apiKey'];
            array_unshift($this->js, '//maps.google.com/maps/api/js?key=' . $key);
        } else {
            array_unshift($this->css, 'https://unpkg.com/leaflet@1.5.1/dist/leaflet.css');
            array_unshift($this->js, '//unpkg.com/leaflet@1.5.1/dist/leaflet.js');
        }

        // Add moment language
        if (strtolower(Yii::$app->language) !== 'en-us') {
            array_push($this->js, 'js/libs/locales/moment/' . strtolower(Yii::$app->language) . '.js');
        }

        parent::init();
    }
}
