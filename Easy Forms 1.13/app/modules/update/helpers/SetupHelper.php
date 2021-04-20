<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\modules\update\helpers;

use Yii;
use Exception;
use app\components\database\Migration;
use yii\base\Component;
use yii\helpers\VarDumper;

class SetupHelper extends Component
{

    const EVENT_BEFORE_MIGRATION = 'beforeMigration';

    public static $purchaseCode = 'aHR0cHM6Ly9hY3RpdmF0aW9uLmVhc3lmb3Jtcy5kZXYv';
    public $migrationPath = [];

    /**
     * Write license key content in a file
     *
     * @param $purchaseCode
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
     * Runs new migrations
     *
     * @param null|int $numberOfMigrations
     * @return array
     */
    public static function runMigrations($numberOfMigrations = null)
    {
        try {

            $migrationPath = [Yii::getAlias('@app/migrations')];

            $setupEvent = new SetupHelper();
            $setupEvent->migrationPath = $migrationPath;
            $setupEvent->trigger(self::EVENT_BEFORE_MIGRATION);

            foreach ($setupEvent->migrationPath as $migrationPath) {
                if (!is_dir($migrationPath)) {
                    throw new Exception('Migration path does not exists. Path: ' . $migrationPath);
                }
            }

            if (is_array($setupEvent->migrationPath)) {

                // Flush cache
                Yii::$app->cache->flush();
                // Run DB Migration
                $migration = new Migration();
                $migration->migrationPath = $setupEvent->migrationPath;
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
