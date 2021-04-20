<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 *
 * Based on Yii2 Settings (MIT license)
 * Copyright (c) 2014 Pheme
 * @see http://phe.me
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\caching\Cache;
use app\models\Setting;

/**
 * Class Settings
 * @package app\components
 */
class Settings extends Component
{
    /**
     * Model to for storing and retrieving settings
     * @var Setting
     */
    protected $model;

    /**
     * Holds a cached copy of the data for the current request
     *
     * @var mixed
     */
    private $data = null;

    /**
     * @var Cache|string the cache object or the application component ID of the cache object.
     * Settings will be cached through this cache object, if it is available.
     *
     * After the Settings object is created, if you want to change this property,
     * you should only assign it with a cache object.
     * Set this property to null if you do not want to cache the settings.
     */
    public $cache = 'cache';

    /**
     * @var Cache|string the front cache object or the application component ID of the front cache object.
     * Front cache will be cleared through this cache object, if it is available.
     *
     * After the Settings object is created, if you want to change this property,
     * you should only assign it with a cache object.
     * Set this property to null if you do not want to clear the front cache.
     */
    public $frontCache;

    /**
     * To be used by the cache component.
     *
     * @var string cache key
     */
    public $cacheKey = 'app/settings';

    /**
     * Initialize the component
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->model = new Setting();

        if (is_string($this->cache)) {
            $this->cache = Yii::$app->get($this->cache, false);
        }

        if (is_string($this->frontCache)) {
            $this->frontCache = Yii::$app->get($this->frontCache, false);
        }
    }

    /**
     * Get's the value for the given key and category.
     * You can use dot notation to separate the section from the key:
     * $value = $settings->get('section.key');
     * and
     * $value = $settings->get('key', 'section');
     * are equivalent
     *
     * @param $key
     * @param null $category
     * @param null $default
     * @return mixed
     */
    public function get($key, $category = null, $default = null)
    {
        if (is_null($category)) {
            $pieces = explode('.', $key, 2);
            if (count($pieces) > 1) {
                $category = $pieces[0];
                $key = $pieces[1];
            } else {
                $category = '';
            }
        }
        $data = $this->getRawConfig();
        if (isset($data[$category][$key][0])) {
            settype($data[$category][$key][0], $data[$category][$key][1]);
        } else {
            $data[$category][$key][0] = $default;
        }
        return $data[$category][$key][0];
    }

    /**
     * @param $key
     * @param $value
     * @param null $category
     * @param null $type
     * @return boolean
     */
    public function set($key, $value, $category = null, $type = null)
    {
        if (is_null($category)) {
            $pieces = explode('.', $key);
            $category = $pieces[0];
            $key = $pieces[1];
        }
        if ($this->model->setSetting($category, $key, $value, $type)) {
            if ($this->clearCache()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Deletes a setting
     *
     * @param $key
     * @param null|string $category
     * @return bool
     */
    public function delete($key, $category = null)
    {
        if (is_null($category)) {
            $pieces = explode('.', $key);
            $category = $pieces[0];
            $key = $pieces[1];
        }
        return $this->model->deleteSetting($category, $key);
    }

    /**
     * Deletes all setting. Be careful!
     *
     * @return bool
     */
    public function deleteAll()
    {
        return $this->model->deleteAllSettings();
    }

    /**
     * Activates a setting
     *
     * @param $key
     * @param null|string $category
     * @return bool
     */
    public function activate($key, $category = null)
    {
        if (is_null($category)) {
            $pieces = explode('.', $key);
            $category = $pieces[0];
            $key = $pieces[1];
        }
        return $this->model->activateSetting($category, $key);
    }

    /**
     * Deactivates a setting
     *
     * @param $key
     * @param null|string $category
     * @return bool
     */
    public function deactivate($key, $category = null)
    {
        if (is_null($category)) {
            $pieces = explode('.', $key);
            $category = $pieces[0];
            $key = $pieces[1];
        }
        return $this->model->deactivateSetting($category, $key);
    }

    /**
     * Clears the settings cache on demand.
     * If you haven't configured cache this does nothing.
     *
     * @return boolean True if the cache key was deleted and false otherwise
     */
    public function clearCache()
    {
        $this->data = null;
        if ($this->frontCache instanceof Cache) {
            $this->frontCache->delete($this->cacheKey);
        }
        if ($this->cache instanceof Cache) {
            return $this->cache->delete($this->cacheKey);
        }
        return true;
    }

    /**
     * Returns the raw configuration array
     *
     * @return array
     */
    public function getRawConfig()
    {
        if ($this->data === null) {
            if ($this->cache instanceof Cache) {
                $data = $this->cache->get($this->cacheKey);
                if ($data === false) {
                    $data = $this->model->getSettings();
                    $this->cache->set($this->cacheKey, $data);
                }
            } else {
                $data = $this->model->getSettings();
            }
            $this->data = $data;
        }
        return $this->data;
    }
}
