<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.12.2
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\liquid\filters;

use app\helpers\Timezone;
use InvalidArgumentException;
use Yii;

/**
 * Class DateFilters
 * @package app\components\liquid\filters
 */
class DateFilters
{
    public $timezone;

    /**
     * Set timezone to be used with date filter
     *
     * @param $input
     * @param $timezone
     * @return mixed
     */
    public function timezone($input, $timezone)
    {
        $timezones = Timezone::all();

        if (!in_array($timezone, array_keys($timezones))) {
            throw new InvalidArgumentException("Timezone parameter is invalid.");
        }

        $this->timezone = $timezone;

        return $input;
    }

    /**
     * Formats a date using timezone
     *
     * @param mixed $input
     * @param string $format
     *
     * @return string
     */
    public function date($input, $format)
    {

        if (!is_numeric($input)) {

            $input = strtotime($input);

        }

        // Change application timezone
        if (!empty($this->timezone)) {
            date_default_timezone_set($this->timezone);
        }

        // Date output
        $output = $format == 'r' ? date($format, $input) : strftime($format, $input);

        // Revert back application timezone
        date_default_timezone_set(Yii::$app->timeZone);

        return $output;
    }

}