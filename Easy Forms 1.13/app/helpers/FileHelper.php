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

namespace app\helpers;

use app\components\flysystem\LocalFilesystem;
use Exception;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Yii;
use yii\base\InvalidArgumentException;

/**
 * Class FileHelper
 * @package app\helpers
 */
class FileHelper extends \yii\helpers\FileHelper
{

    /**
     * List files and directories inside the specified path without dots
     *
     * @param $dir
     * @param bool $dots
     * @return array
     */
    public static function scandir($dir, $dots = false)
    {
        if (!is_dir($dir)) {
            throw new InvalidArgumentException("The dir argument must be a directory: $dir");
        }
        if (!$dots) {
            return array_diff(scandir($dir), array('..', '.'));
        }
        return scandir($dir);
    }

    /**
     * Save file by using Flysystem
     *
     * @param $filePath
     * @param $tempName
     * @return boolean
     * @throws Exception
     */
    public static function save($filePath, $tempName)
    {
        /** @var FilesystemInterface $filesystem */
        $filesystem = Yii::$app->fs;
        $stream = fopen($tempName, 'r+');
        $result = $filesystem->writeStream($filePath, $stream);
        fclose($stream);
        return $result;
    }
}
