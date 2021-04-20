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

namespace app\modules\setup\helpers;

use Yii;
use app\components\console\Console;

class Requirements
{
    /**
     * Return all requirements
     *
     * @return array
     */
    public static function all()
    {
        return array(
            // System
            array(
                'name' => Yii::t('setup', 'PHP version'),
                'mandatory' => true,
                'condition' => version_compare(PHP_VERSION, '5.6.0', '>='),
                'by' => Yii::t('setup', 'Core'),
                'memo' => PHP_VERSION . '. '. Yii::t('setup', 'PHP 5.6.0 or higher is required.'),
            ),
            array(
                'name' => Yii::t('setup', 'Reflection extension'),
                'mandatory' => true,
                'condition' => class_exists('Reflection', false),
                'by' => Yii::t('setup', 'Core'),
            ),
            array(
                'name' => Yii::t('setup', 'PCRE extension'),
                'mandatory' => true,
                'condition' => extension_loaded('pcre'),
                'by' => Yii::t('setup', 'Core'),
            ),
            array(
                'name' => Yii::t('setup', 'SPL extension'),
                'mandatory' => true,
                'condition' => extension_loaded('SPL'),
                'by' => Yii::t('setup', 'Core'),
            ),
            array(
                'name' => Yii::t('setup', 'Ctype extension'),
                'mandatory' => true,
                'condition' => extension_loaded('ctype'),
                'by' => Yii::t('setup', 'Core'),
            ),
//            array(
//                'name' => Yii::t('setup', 'PHP CLI'),
//                'mandatory' => false,
//                'condition' => Console::validPhpCliVersion(),
//                'by' => '<a href="http://php.net/manual/en/features.commandline.introduction.php">CLI SAPI</a>',
//            ),
            array(
                'name' => Yii::t('setup', 'MBString extension'),
                'mandatory' => true,
                'condition' => extension_loaded('mbstring'),
                'by' => '<a href="http://www.php.net/manual/en/book.mbstring.php">Multibyte string</a> processing',
                'memo' => Yii::t('setup', 'Required for multibyte encoding string processing.')
            ),
            array(
                'name' => Yii::t('setup', 'Fileinfo extension'),
                'mandatory' => false,
                'condition' => extension_loaded('fileinfo'),
                'by' => '<a href="http://www.php.net/manual/en/book.fileinfo.php">File Information</a>',
                'memo' => Yii::t('setup', 'Required for files upload to detect correct file mime-types.')
            ),
            array(
                'name' => Yii::t('setup', 'DOM extension'),
                'mandatory' => true,
                'condition' => extension_loaded('dom'),
                'by' => '<a href="http://php.net/manual/en/book.dom.php">Document Object Model</a>',
                'memo' => Yii::t('setup', 'Required by Form Builder and REST API.')
            ),
            array(
                'name' => Yii::t('setup', 'JSON extension'),
                'mandatory' => true,
                'condition' => extension_loaded('json'),
                'by' => '<a href="http://php.net/manual/en/book.json.php">JavaScript Object Notation</a>',
                'memo' => Yii::t('setup', 'Required by Form Builder and REST API.')
            ),
            array(
                'name' => Yii::t('setup', 'PDO extension'),
                'mandatory' => true,
                'condition' => extension_loaded('pdo'),
                'by' => Yii::t('setup', 'All DB-related'),
            ),
            array(
                'name' => Yii::t('setup', 'PDO MySQL extension'),
                'mandatory' => true,
                'condition' => extension_loaded('pdo_mysql'),
                'by' => Yii::t('setup', 'All DB-related'),
                'memo' => Yii::t('setup', 'Required for MySQL database.'),
            ),
            array(
                'name' => Yii::t('setup', 'Curl extension'),
                'mandatory' => false,
                'condition' => extension_loaded('curl'),
                'by' => 'Add-ons',
                'memo' => 'Required for Third party application integration services.'
            ),
            array(
                'name' => Yii::t('setup', 'Zip extension'),
                'mandatory' => false,
                'condition' => extension_loaded('ZIP'),
                'by' => Yii::t('setup', 'Core'),
                'memo' => 'Required to download the HTML code of your forms.'
            ),
            // Files
            array(
                'name' => Yii::t('setup', 'Runtime Directory'),
                'mandatory' => true,
                'condition' => is_writable(Yii::getAlias('@app/runtime')),
                'by' => Yii::t('setup', 'File System'),
                'memo' => Yii::t('setup', "The '{directory}' directory must be writable by the web server (chmod -R 0777).", ['directory' => '/runtime']),
            ),
            array(
                'name' => Yii::t('setup', 'Assets Directory'),
                'mandatory' => true,
                'condition' => is_writable(Yii::getAlias('@app/assets')),
                'by' => Yii::t('setup', 'File System'),
                'memo' => Yii::t('setup', "The '{directory}' directory must be writable by the web server (chmod -R 0777).", ['directory' => '/assets']),
            ),
            array(
                'name' => Yii::t('setup', 'Static Files Directory'),
                'mandatory' => true,
                'condition' => is_writable(Yii::getAlias('@app/static_files')),
                'by' => Yii::t('setup', 'File System'),
                'memo' => Yii::t('setup', "The '{directory}' directory must be writable by the web server (chmod -R 0777).", ['directory' => '/static_files']),
            ),
            array(
                'name' => Yii::t('setup', 'Database Config File'),
                'mandatory' => true,
                'condition' => SetupHelper::checkDatabaseConfigFilePermissions(),
                'by' => Yii::t('setup', 'File System'),
                'memo' => Yii::t('setup', "The database config file '/config/db.php' must be writable by the web server (chmod 0777)."),
            ),
        );
    }
}
