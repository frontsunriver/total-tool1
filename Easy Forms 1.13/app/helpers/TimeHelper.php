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
 * Class TimeHelper
 * @package app\helpers
 */
class TimeHelper
{

    /**
     * Return Time Periods
     *
     * @param array $options
     * @return array
     */
    public static function timePeriods($options = [])
    {
        $timePeriods = [
            'h' => Yii::t('app', 'Hour'),
            'd' => Yii::t('app', 'Day'),
            'w' => Yii::t('app', 'Week'),
            'm' => Yii::t('app', 'Month'),
            'y' => Yii::t('app', 'Year'),
            'a' => Yii::t('app', 'All Time'),
        ];

        if (isset($options['all']) && $options['all'] === false) {
            unset($timePeriods['a']);
        }

        return $timePeriods;
    }

    /**
     * Return the name of Time Period by its code
     *
     * @param $code
     * @return mixed
     */
    public static function getPeriodByCode($code)
    {
        $periods = self::timePeriods();
        return $periods[$code];
    }

    /**
     * Return the timestamp of the beginning of a period
     *
     * @param $period
     * @return int
     */
    public static function startTime($period)
    {
        switch ($period) {
            case "h":
                // Now modulus 3600 will return the seconds after the start of the hour,
                // then just subtract from the current time.
                $ts = strtotime("now");
                return $ts - ($ts % 3600);
                break;
            case "d":
                // The time is set to 00:00:00
                return strtotime('today');
                break;
            case "w":
                // The code below assumes that the first day of the week is Monday.
                // Period from Monday morning at 00:00:00 to now:
                return mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N')-1)*3600*24);
                break;
            case "m":
                // Period from the first of the current to now:
                return mktime(0, 0, 0, date('m'), 1, date('Y'));
                break;
            case "y":
                // Period from January 1st to 00:00:00 today:
                return mktime(0, 0, 0, 1, 1, date('Y'));
                break;
            case "a":
                return 0;
                break;
        }
        return 0;
    }

    /**
     * Automatically convert the date format from PHP DateTime to Moment.js DateTime format as required by the
     * `bootstrap-daterangepicker` plugin.
     *
     * @see http://php.net/manual/en/function.date.php
     * @see http://momentjs.com/docs/#/parsing/string-format/
     *
     * @param string $format the PHP date format string
     *
     * @return string
     */
    public static function convertDateFormat($format)
    {
        $conversions = [
            // meridian lowercase remains same
            // 'a' => 'a',
            // meridian uppercase remains same
            // 'A' => 'A',
            // second (with leading zeros)
            's' => 'ss',
            // minute (with leading zeros)
            'i' => 'mm',
            // hour in 12-hour format (no leading zeros)
            'g' => 'h',
            // hour in 12-hour format (with leading zeros)
            'h' => 'hh',
            // hour in 24-hour format (no leading zeros)
            'G' => 'H',
            // hour in 24-hour format (with leading zeros)
            'H' => 'HH',
            //  day of the week locale
            'w' => 'e',
            //  day of the week ISO
            'W' => 'E',
            // day of month (no leading zero)
            'j' => 'D',
            // day of month (two digit)
            'd' => 'DD',
            // day name short
            'D' => 'DDD',
            // day name long
            'l' => 'DDDD',
            // month of year (no leading zero)
            'n' => 'M',
            // month of year (two digit)
            'm' => 'MM',
            // month name short
            'M' => 'MMM',
            // month name long
            'F' => 'MMMM',
            // year (two digit)
            'y' => 'YY',
            // year (four digit)
            'Y' => 'YYYY',
            // unix timestamp
            'U' => 'X',
        ];
        return strtr($format, $conversions);
    }

    /**
     * Calculate Unix Timestamp of a time period from now
     *
     * @param int $timeLength
     * @param string $timeUnit
     * @since 1.12
     * @return int
     */
    public static function startTimeFromNow($timeLength, $timeUnit)
    {

        if (empty($timeLength) || empty($timeUnit)) {
            throw new \InvalidArgumentException("Time length and Time Unit are required.");
        }

        if (!(filter_var($timeLength, FILTER_VALIDATE_INT) !== FALSE)) {
            throw new \InvalidArgumentException("Time length should be a numeric character.");
        }

        switch ($timeUnit) {
            case "h":
                return strtotime("-$timeLength hour");
                break;
            case "d":
                return strtotime("-$timeLength day");
                break;
            case "w":
                return strtotime("-$timeLength week");
                break;
            case "m":
                return strtotime("-$timeLength month");
                break;
            case "y":
                return strtotime("-$timeLength year");
                break;
            case "a":
                return 0;
                break;
        }

        return 0;
    }
}
