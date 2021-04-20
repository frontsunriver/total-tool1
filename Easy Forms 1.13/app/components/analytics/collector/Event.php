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

namespace app\components\analytics\collector;

use Yii;
use DeviceDetector\DeviceDetector;
use app\components\analytics\helpers\IPHelper;

/**
 * Class Event
 * @package app\components\analytics\collector
 */
class Event
{

    /**
     * @return array
     */
    public function getData()
    {

        $data = Yii::$app->getRequest()->getQueryParams();
        // Detect user ip
        $data["ip"] = $this->getIp();
        // Detect user agent
        $data["ua"] = $this->getUserAgent();

        return $data;
    }

    /**
     * Check if the request GET has parameter values
     *
     * @return bool
     */
    public function isEmpty()
    {
        $params = Yii::$app->getRequest()->getQueryParams();
        return empty($params);
    }

    /**
     * Return true if the hit must be recorded.
     *
     * Requests built with piwik.js will contain a rec=1 parameter.
     * This is used to indicate that the request is made by a JS enabled device.
     *
     * @return bool
     */
    public function shouldBeRecorded()
    {
        $rec = Yii::$app->getRequest()->getQueryParam("rec");

        if (!$rec) {
            return false;
        }

        return true;
    }

    /**
     * Return the user ip address
     *
     * @param null $ip
     * @return string
     */
    public function getIp($ip = null)
    {
        if ($ip === null) {
            $ip = Yii::$app->getRequest()->getQueryParam("cip");
        }

        if ($ip === null) {
            $ip = Yii::$app->getRequest()->getUserIP();
        }

        if ($ip === "::1" || $ip === "127.0.0.1") {
            // Usefull when app run in localhost
             $ip = '81.2.69.160';
        }

        return $ip;
    }

    /**
     * Return the browser user agent
     *
     * @param null $ua
     * @return null|string
     */
    public function getUserAgent($ua = null)
    {
        if ($ua === null) {
            $ua = Yii::$app->getRequest()->getUserAgent();
        }
        return $ua;
    }

    /**
     * Return the referrer page
     *
     * @param null $referrer
     * @return mixed|null
     */
    public function getReferrer($referrer = null)
    {
        if ($referrer === null) {
            $referrer = Yii::$app->getRequest()->getQueryParam("referrer");
        }
        return $referrer;
    }

    /**
     * Live/Bing/MSN bot and Googlebot are evolving to detect cloaked websites.
     *
     * As a result, these sophisticated bots exhibit browsers characteristics
     * (cookies enabled, executing JavaScript, etc).
     *
     * @see \DeviceDetector\Parser\Bot
     *
     * @return boolean
     */
    public function isBot()
    {
        $allowBots = Yii::$app->getRequest()->getQueryParam("bots");

        $deviceDetector = new DeviceDetector($this->getUserAgent());
        $deviceDetector->discardBotInformation();
        $deviceDetector->parse();

        return !$allowBots && ( $deviceDetector->isBot() || $this->isInBotRanges() );

    }

    /**
     * Determines if the IP address is in a bot IP address range
     *
     * @return bool
     */
    public function isInBotRanges()
    {
        $ip = new IPHelper();
        return $ip->isInRangesOfSearchBots($this->getIp());
    }

    /**
     * Looks for the ignore cookie that users can set.
     *
     * @return bool
     */
    public function hasIgnoreCookie()
    {
        return Yii::$app->getRequest()->getCookies()->has('ignore');
    }

    /**
     * Returns true if the Referrer is a known spammer.
     *
     * @return bool
     */
    public function hasReferrerSpam()
    {
        $file = Yii::getAlias('@app/vendor/piwik/referrer-spam-blacklist/spammers.txt');
        $spammers = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($spammers as $spammer) {
            if (stripos($this->getReferrer(), $spammer) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Detect if browser request is a prefetch or prerender
     *
     * @return bool
     */
    public function hasPrefetchRequest()
    {
        return (isset($_SERVER["HTTP_X_PURPOSE"]) && in_array($_SERVER["HTTP_X_PURPOSE"], array("preview", "instant")))
        || (isset($_SERVER['HTTP_X_MOZ']) && $_SERVER['HTTP_X_MOZ'] == "prefetch");
    }
}
