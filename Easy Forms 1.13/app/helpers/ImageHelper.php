<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.4.2
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\helpers;

use Yii;
use yii\base\InvalidParamException;

/**
 * Class ImageHelper
 * @package app\helpers
 */
class ImageHelper
{

    /**
     * Detect if a file is an image (GIF, JPEG or PNG(
     *
     * @param $path
     * @return bool
     */
    public static function isImage($path)
    {
        $a = getimagesize($path);
        $image_type = isset($a[2]) ? $a[2] : '';

        return in_array($image_type , array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG));
    }

    /**
     * Compress an image
     *
     * @param string $path Path to the image file
     * @param integer $quality A number between 0 and 100
     * @return bool
     */
    public static function compress($path, $quality)
    {
        $size = getimagesize($path);
        $mime = $size['mime'];

        if ($mime == 'image/png' || $mime == 3) {
            $picture = imagecreatefrompng($path);
        } else if($mime == 'image/jpeg' || $mime == 2) {
            $picture = imagecreatefromjpeg($path);
        } else if($mime == 'image/gif' || $mime == 1) {
            $picture = imagecreatefromgif($path);
        } else {
            Yii::error("I do not support this format for now. Mime - $mime ");
        }

        if (isset($picture)) {

            $status = imagejpeg($picture, (string) $path, (int) $quality);
            imagedestroy($picture);

            return $status;

        } else{

            Yii::error("Failed to extract picture data");

        }
    }

}
