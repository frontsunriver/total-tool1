<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
namespace app\components\behaviors;

use Yii;
use yii\helpers\Json;
use app\models\User;
use app\helpers\ArrayHelper;

class UserPreferences
{
    /**
     * The preferences cache.
     *
     * @var array
     */
    protected $preferences = array();

    /**
     * Whether any preferences have been modified since being loaded.
     * We use an array so different constraints can be flagged as dirty separately.
     *
     * @var bool
     */
    protected $dirty = array();

    /**
     * Whether preferences have been loaded from the database (this session).
     * We use an array so different constraints can be loaded separately.
     *
     * @var array
     */
    protected $loaded = array();

    /**
     * Get preferences for external management
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * Get the value of a specific setting.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->check();
        $value = ArrayHelper::getValue($this->preferences, $key);
        if (is_null($value) && isset(Yii::$app->params[$key])) {
            $value = Yii::$app->params[$key];
        }
        return empty($value) ? $default : $value;
    }

    /**
     * Set the value of a specific setting.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value = null)
    {
        $this->check();
        $this->dirty = true;
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                ArrayHelper::setValue($this->preferences, $k, $v);
            }
        } else {
            ArrayHelper::setValue($this->preferences, $key, $value);
        }
    }

    /**
     * Unset a specific setting.
     *
     * @param string $key
     * @return void
     */
    public function forget($key)
    {
        $this->check();
        if (array_key_exists($key, $this->preferences)) {
            unset($this->preferences[$key]);
            $this->dirty = true;
        }
    }

    /**
     * Check for the existence of a specific setting.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $this->check();
        return array_key_exists($key, $this->preferences);
    }

    /**
     * Return the entire preferences array.
     *
     * @return array
     */
    public function all()
    {
        $this->check();
        return $this->preferences;
    }

    /**
     * Save all changes back to the database.
     *
     * @return bool
     */
    public function save()
    {
        $this->check();
        if ($this->dirty) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            $user->preferences = Json::encode($this->preferences);
            $result = $user->save(false);
            $this->dirty = !$result;
            return $result;
        }
        $this->loaded = true;
        return false;
    }

    /**
     * Load preferences from the database.
     *
     * @return void
     */
    public function load()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $json = $user ? $user->preferences : '';
        $this->preferences = Json::decode($json, true);
        $this->dirty = false;
        $this->loaded = true;
    }

    /**
     * Check if preferences have been loaded, load if not.
     *
     * @return void
     */
    protected function check()
    {
        if (empty($this->loaded)) {
            $this->load();
        }
    }
}