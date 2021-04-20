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

namespace app\components\analytics\enricher;

use Yii;
use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Client\Browser;
use DeviceDetector\Parser\Device;
use DeviceDetector\Parser\OperatingSystem;

/**
 * Class UserAgentEnrichment
 * @package app\components\analytics\enricher
 */
class UserAgentEnrichment
{
    /**
     * @var DeviceDetector
     */
    public $deviceDetector;

    public function __construct($ua)
    {
        $this->deviceDetector = new DeviceDetector($ua);
        $this->deviceDetector->parse();
    }

    public function getData()
    {
        $data = array(
            // Browser
            "br_name" => $this->getBrowserName(),
            "br_family" => $this->getBrowserFamily(),
            "br_version" => $this->getBrowserVersion(),
            "br_type" => $this->getBrowserType(),
            "br_renderengine" => $this->getBrowserRenderEngine(),

            // Device and operating system fields
            "dvce_type" => $this->getDeviceType(), // Type of device
            "dvce_brand" => $this->getDeviceBrand(), // Device Brand (os_manufacturer replacement)
            "dvce_ismobile" => $this->isMobileDevice(), // Is the device mobile?
            "os_name" => $this->getOSName(), //
            "os_family" => $this->getOSFamily(), //
            "os_manufacturer" => $this->getOSManufacturer(), // (deprecated, use dvce_brand)
        );

        $data = array_filter($data, function ($v) {
            return !is_null($v);
        });

        return $data;

    }

    public function getBotInformation()
    {
        if (!$this->deviceDetector->isBot()) {
            throw new \Exception(Yii::t("app", "Isn't a Bot."));
        }

        return $this->deviceDetector->getBot();
    }

    public function getBrowserName()
    {
        return $this->deviceDetector->getClient("name");
    }

    public function getBrowserFamily()
    {
        return Browser::getBrowserFamily($this->deviceDetector->getClient('short_name'));
    }

    public function getBrowserVersion()
    {
        return $this->deviceDetector->getClient('version');
    }

    public function getBrowserType()
    {
        return $this->deviceDetector->getClient('type');
    }

    public function getBrowserRenderEngine()
    {
        return $this->deviceDetector->getClient('engine');
    }

    public function getDeviceType()
    {
        return $this->deviceDetector->getDeviceName();
    }

    public function getDeviceBrand()
    {
        return $this->deviceDetector->getBrandName();
    }

    public function getDeviceModel()
    {
        return $this->deviceDetector->getModel();
    }

    public function isMobileDevice()
    {
        return (int)$this->deviceDetector->isMobile();
    }

    public function getOSName()
    {
        return $this->deviceDetector->getOs("name");
    }

    public function getOSFamily()
    {
        return OperatingSystem::getOsFamily($this->deviceDetector->getOs('short_name'));
    }

    public function getOSManufacturer()
    {
        return $this->deviceDetector->getBrandName();
    }
}
