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

use Exception;
use Yii;
use yii\helpers\VarDumper;
use app\components\database\Migration;

class SetupHelper
{

    /**
     * @var string
     */
    public static $purchaseCode = 'aHR0cHM6Ly9hY3RpdmF0aW9uLmVhc3lmb3Jtcy5kZXYv';

    /**
     * Write license key content in a file
     *
     * @param $config
     * @return bool
     */
    public static function createLicenseKeyConfigFile($config)
    {
        $content = VarDumper::export($config);
        $content = preg_replace('~\\\\+~', '\\', $content); // Fix class backslash
        $content = "<?php\nreturn " . $content . ";\n";

        return file_put_contents(Yii::getAlias('@app/config/license.php'), $content) > 0;
    }

    /**
     * Verify access to database config file
     *
     * @return bool
     */
    public static function checkDatabaseConfigFilePermissions()
    {
        $file = Yii::getAlias('@app/config/db.php');

        $result = touch($file); // Check access file

        return $result;
    }

    /**
     * Create database configuration content
     * that will be saved in a file
     *
     * @param $config
     * @return array
     */
    public static function createDatabaseConfig($config)
    {
        $config['class'] = 'yii\db\Connection';
        $config['dsn'] = 'mysql:host='.$config['db_host'].';port='.$config['db_port'].';dbname='.$config['db_name'];
        $config['username'] = $config['db_user'];
        $config['password'] = $config['db_pass'];
        unset(
            $config['db_name'],
            $config['db_host'],
            $config['db_port'],
            $config['db_user'],
            $config['db_pass'],
            $config['connectionOk']
        );
        return $config;
    }

    /**
     * Write database configuration content in a file
     *
     * @param $config
     * @return bool
     */
    public static function createDatabaseConfigFile($config)
    {
        $content = VarDumper::export($config);
        $content = preg_replace('~\\\\+~', '\\', $content); // Fix class backslash
        $content = "<?php\nreturn " . $content . ";\n";

        return file_put_contents(Yii::getAlias('@app/config/db.php'), $content) > 0;
    }

    /**
     * Execute SQL commands
     *
     * @return array
     * @throws \Throwable
     */
    public static function executeSqlCommands()
    {
        $sqlFile = Yii::getAlias('@app/easy_forms.sql');

        // Check if SQL file exists and is readable
        if (is_readable($sqlFile)) {
            try {
                // Performing Transactions
                Yii::$app->db->transaction(function () use ($sqlFile) {

                    // Access to DB configuration
                    $db = Yii::$app->db;

                    // Get SQL
                    $sql = file_get_contents($sqlFile);

                    // Performance queries
                    $db->createCommand($sql)->execute();

                });

                // Check if "user" table was successfully created
                $created = Yii::$app->db->getTableSchema('user', true) !== null;
                if ($created) {
                    return ['success' => 1, 'message' => 'SQL commands successfully executed.'];
                } else {
                    return ['success' => 0, 'message' => 'We can\'t execute the SQL commands.'];
                }

            } catch (Exception $e) {
                // Log error
                Yii::error($e, __METHOD__);
                return ['success' => 0, 'message' => $e->getMessage()];
            }
        }

        return ['success' => 0, 'message' => 'SQL file doesn\'t exist or is not readable.'];

    }

    /**
     * Runs migrations
     *
     * @param null $numberOfMigrations
     * @return array
     */
    public static function runMigrations($numberOfMigrations = null)
    {
        try {

            $migrationPath = Yii::getAlias('@app/migrations');

            if (is_dir($migrationPath)) {

                // Run DB Migration
                $migration = new Migration();
                $migration->migrationPath = $migrationPath;
                $migration->compact = true;
                $r = $migration->up($numberOfMigrations);

                // Verify response
                if ($r === Migration::DONE) {
                    return ['success' => 1, 'message' => 'Migrated up successfully.'];
                } elseif ($r === Migration::NO_NEW_MIGRATION) {
                    return ['success' => 1, 'message' => 'No new migration found. Your system is up-to-date.'];
                } else {
                    return ['success' => 0, 'message' => 'An error occurred during the migration process.'];
                }
            }

            return ['success' => 0, 'message' => 'No such the Migrations directory.'];

        } catch (Exception $e) {
            // Log error
            Yii::error($e, __METHOD__);
            return ['success' => 0, 'message' => $e->getMessage()];
        }
    }
}
