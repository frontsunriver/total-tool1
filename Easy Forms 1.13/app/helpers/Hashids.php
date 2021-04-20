<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.12
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\helpers;

/**
 * Class Hashids
 * @package app\helpers
 */
class Hashids
{

    /**
     * @var int Secret integer key.
     * Change it to re-build all the ids
     * Note: External links will stop working
     */
    const KEY = 0x36D92609;

    /**
     * Encode ID
     *
     * @param $id
     * @return int|string
     */
    public static function encode($id)
    {
        $encoder = new OpaqueEncoder(static::KEY, OpaqueEncoder::ENCODING_BASE64);
        return $encoder->encode($id);
    }

    /**
     * Decode ID
     *
     * @param $id
     * @return int
     */
    public static function decode($id)
    {
        $encoder = new OpaqueEncoder(static::KEY, OpaqueEncoder::ENCODING_BASE64);
        return $encoder->decode($id);
    }
}