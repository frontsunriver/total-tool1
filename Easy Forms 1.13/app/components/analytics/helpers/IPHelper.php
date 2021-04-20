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

namespace app\components\analytics\helpers;

use Piwik\Network\IP;

/**
 * Class IPHelper
 * @package app\components\analytics\helpers
 */
class IPHelper
{

    /**
     * Determines if the IP address is in a search engine bot IP address range
     *
     * @param $ip
     * @return bool
     */
    public static function isInRangesOfSearchBots($ip)
    {

        $ip  = IP::fromBinaryIP($ip);
        $isInRanges = $ip->isInRanges(self::getBotIpRanges());

        return $isInRanges;
    }

    /**
     * Robots IP Address Ranges - Googlebot, Yahoo Slurp, MSNBot
     *
     * @return array
     */
    public static function getBotIpRanges()
    {
        return array(
            // Google
            '216.239.32.0/19',
            '64.233.160.0/19',
            '66.249.80.0/20',
            '72.14.192.0/18',
            '209.85.128.0/17',
            '66.102.0.0/20',
            '74.125.0.0/16',
            '64.18.0.0/20',
            '207.126.144.0/20',
            '173.194.0.0/16',

            // Live/Bing/MSN
            '64.4.0.0/18',
            '65.52.0.0/14',
            '157.54.0.0/15',
            '157.56.0.0/14',
            '157.60.0.0/16',
            '207.46.0.0/16',
            '207.68.128.0/18',
            '207.68.192.0/20',
            '131.253.26.0/20',
            '131.253.24.0/20',

            // Yahoo
            '72.30.198.0/20',
            '72.30.196.0/20',
            '98.137.207.0/20',

            // Chinese bot hammering websites
            '1.202.218.8'
        );
    }
}
