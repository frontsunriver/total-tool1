<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\modules\addons\helpers;

use Yii;
use yii\base\InvalidConfigException;
use app\modules\addons\models\Addon;

/**
 * Class SetupHelper
 * @package app\modules\addons\helpers
 */
class SetupHelper
{

    /**
     * Return Absolute path to addOns directory
     *
     * @return bool|string
     */
    public static function getAddOnsDirectory()
    {
        return Yii::getAlias('@addons');
    }

    /**
     * Install new addOns
     *
     * @param $newAddOns
     * @throws InvalidConfigException
     */
    public static function install($newAddOns)
    {

        $addOnsDirectory = static::getAddOnsDirectory();

        foreach ($newAddOns as $newAddOn) {

            // Verify if Module.php file of the new addOn exist
            $file = $addOnsDirectory . DIRECTORY_SEPARATOR . $newAddOn . DIRECTORY_SEPARATOR . 'Module.php';

            if (!is_file($file)) {
                throw new InvalidConfigException(Yii::t(
                    'addon',
                    'An invalid Add-on detected. Please verify your Add-ons directory.'
                ));
            } else {
                $configFile = Yii::getAlias('@addons') . DIRECTORY_SEPARATOR . $newAddOn . DIRECTORY_SEPARATOR .
                    'config' . DIRECTORY_SEPARATOR . 'install.php';

                if (is_file($configFile)) {

                    $config = require($configFile);

                    if (!is_array($config) || !isset($config['id']) || !isset($config['name']) ||
                        !isset($config['class'])) {
                        throw new InvalidConfigException(Yii::t(
                            'addon',
                            'An invalid Add-on detected. Please verify your Add-On configuration.'
                        ));
                    }

                    // Add AddOn to List
                    $addOnModel = new Addon();
                    $addOnModel->id = $config['id'];
                    $addOnModel->name = $config['name'];
                    $addOnModel->class = $config['class'];
                    $addOnModel->description = isset($config['description']) &&
                    isset($config['description'][Yii::$app->language]) ?
                        $config['description'][Yii::$app->language] : null;
                    $addOnModel->version = isset($config['version']) ? $config['version'] : null;
                    $addOnModel->status = isset($config['status']) ? $config['status'] : null;
                    $addOnModel->save();
                }
            }
        }
    }

    /**
     * Update addOns versions
     *
     * @param $installedAddOns
     * @throws InvalidConfigException
     */
    public static function update($installedAddOns)
    {

        $addOnsDirectory = static::getAddOnsDirectory();

        foreach ($installedAddOns as $installedAddOn) {
            // Verify if Module.php file of the installed addOn exist
            $file = $addOnsDirectory . DIRECTORY_SEPARATOR . $installedAddOn . DIRECTORY_SEPARATOR . 'Module.php';

            if (!is_file($file)) {
                Yii::error('Removed or Invalid Add-On: ' . $file);
                throw new InvalidConfigException(Yii::t(
                    'addon',
                    'An add-on was removed or is invalid. Please verify your Add-Ons directory.'
                ));
            } else {
                $configFile = Yii::getAlias('@addons') . DIRECTORY_SEPARATOR . $installedAddOn . DIRECTORY_SEPARATOR .
                    'config' . DIRECTORY_SEPARATOR . 'install.php'; //TODO Change by update.php
                if (is_file($configFile)) {

                    $config = require($configFile);

                    if (!is_array($config) || !isset($config['id']) || !isset($config['name']) ||
                        !isset($config['class'])) {
                        Yii::error('Invalid Add-On Config File: ' . $file);
                        throw new InvalidConfigException(Yii::t(
                            'addon',
                            'An invalid Add-on detected. Please verify the Add-On install file.'
                        ));
                    }

                    /** @var \app\modules\addons\models\Addon $addOnModel */
                    $addOnModel = Addon::find()->where(['id' => $installedAddOn])->one();

                    // If they have same ids and different versions
                    if ($addOnModel->id === $config['id']) {
                        // Update AddOn information
                        $addOnModel->name = $config['name'];
                        $addOnModel->class = $config['class'];
                        $addOnModel->description = isset($config['description']) &&
                        isset($config['description'][Yii::$app->language]) ?
                            $config['description'][Yii::$app->language] : null;
                        if (version_compare($addOnModel->version, $config['version'], '<')) {
                            // Force new installation
                            $addOnModel->version = isset($config['version']) ? $config['version'] : null;
                            $addOnModel->installed = false;
                            $addOnModel->status = false;
                        }
                        $addOnModel->save();
                    }
                }
            }
        }
    }

    /**
     * Uninstall removed addOns
     *
     * @param $removedAddOns
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function uninstall($removedAddOns)
    {
        foreach ($removedAddOns as $removedAddOn) {
            $addOnModel = Addon::find()->where(['id' => $removedAddOn])->one();
            $addOnModel->delete();
        }
    }
}