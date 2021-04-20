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

namespace app\helpers;

use Yii;

/**
 * Class CacheHelper
 * @package app\helpers
 */
class CacheHelper
{

    public static function cache($key, $duration, $callable)
    {

        $cache = Yii::$app->cache;

        if ($cache->exists($key)) {

            $data = $cache->get($key);

        } else {

            $data = $callable();

            if ($data) {

                $cache->set($key, $data, $duration);

            }
        }

        return $data;
    }

    public static function getLocale()
    {
        return strtolower(substr(Yii::$app->language, 0, 2));
    }
}
