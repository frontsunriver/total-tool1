<?php


namespace app\helpers;


use DateTime;

class DateHelper
{
    /**
     * Validate Format
     *
     * @param string $format Eg.'Y-m-d H:i:s'
     * @return bool
     */
    public static function validateFormat($format)
    {
        return date($format, time());
    }
}