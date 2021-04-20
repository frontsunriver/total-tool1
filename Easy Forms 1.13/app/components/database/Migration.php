<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.6.9
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\database;

use Yii;
use Exception;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

/**
 * Class Migration
 * @package app\components\database
 *
 */
class Migration
{
    /**
     * The name of the dummy migration that marks the beginning of the whole migration history.
     */
    const BASE_MIGRATION = 'm000000_000000_base';
    /**
     * Maximum length of a migration name.
     * @since 2.0.13
     */
    const MAX_NAME_LENGTH = 180;

    const DONE = 0;
    const NO_NEW_MIGRATION = 1;
    const ERROR_DOWN = 5;
    const ERROR_UP = 10;
    const ERROR_MIGRATION_NAME_LIMIT = 20;

    /**
     * @var bool indicates whether the console output should be compacted.
     * Default is false, in other words the output is fully verbose by default.
     * @since 2.0.13
     */
    public $compact = false;

    /**
     * @var string|array the directory containing the migration classes. This can be either
     * a [path alias](guide:concept-aliases) or a directory path.
     *
     * Migration classes located at this path should be declared without a namespace.
     * Use [[migrationNamespaces]] property in case you are using namespaced migrations.
     *
     * If you have set up [[migrationNamespaces]], you may set this field to `null` in order
     * to disable usage of migrations that are not namespaced.
     *
     * Since version 2.0.12 you may also specify an array of migration paths that should be searched for
     * migrations to load. This is mainly useful to support old extensions that provide migrations
     * without namespace and to adopt the new feature of namespaced migrations while keeping existing migrations.
     *
     * In general, to load migrations from different locations, [[migrationNamespaces]] is the preferable solution
     * as the migration name contains the origin of the migration in the history, which is not the case when
     * using multiple migration paths.
     *
     * @see $migrationNamespaces
     */
    public $migrationPath = ['@app/migrations'];

    /**
     * @var array list of namespaces containing the migration classes.
     *
     * Migration namespaces should be resolvable as a [path alias](guide:concept-aliases) if prefixed with `@`, e.g. if you specify
     * the namespace `app\migrations`, the code `Yii::getAlias('@app/migrations')` should be able to return
     * the file path to the directory this namespace refers to.
     * This corresponds with the [autoloading conventions](guide:concept-autoloading) of Yii.
     *
     * @since 2.0.10
     * @see $migrationPath
     */
    public $migrationNamespaces = [];

    /**
     * @var string the name of the table for keeping applied migration information.
     */
    public $migrationTable = '{{%migration}}';

    /**
     * @var Connection|array|string the DB connection object or the application component ID of the DB connection to use
     * when applying migrations. Starting from version 2.0.3, this can also be a configuration array
     * for creating the object.
     */
    public $db = 'db';

    /**
     * @var integer $_migrationNameLimit the maximum name length for a migration
     */
    private $_migrationNameLimit;

    /**
     * Migration constructor.
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct()
    {
        @ini_set('memory_limit', '1024M');
        @set_time_limit(0);
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    /**
     * Apply new migrations.
     *
     * @param int $limit the number of new migrations to be applied. If 0, it means
     * applying all available new migrations.
     * @return int the status of the action execution. 0 means normal, other values mean abnormal.
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function up($limit = 0)
    {
        $migrations = $this->getNewMigrations();
        if (empty($migrations)) {
            return self::NO_NEW_MIGRATION;
        }
        $limit = (int) $limit;
        if ($limit > 0) {
            $migrations = array_slice($migrations, 0, $limit);
        }

        foreach ($migrations as $migration) {
            $nameLimit = $this->getMigrationNameLimit();
            if ($nameLimit !== null && strlen($migration) > $nameLimit) {
                return self::ERROR_MIGRATION_NAME_LIMIT;
            }
        }

        $applied = 0;
        foreach ($migrations as $migration) {
            try {
                if (!$this->migrateUp($migration)) {
                    return self::ERROR_UP;
                }
                $applied++;
            } catch (Exception $e) {
                Yii::error($e);
            }
        }

        return self::DONE;
    }

    /**
     * Revert old migrations.
     *
     * @param int|string $limit the number of migrations to be reverted.
     * @throws Exception if the number of the steps specified is less than 1.
     * @return int the status of the action execution. 0 means normal, other values mean abnormal.
     */
    public function down($limit = 1)
    {
        if ($limit === 'all') {
            $limit = null;
        } else {
            $limit = (int) $limit;
            if ($limit < 1) {
                throw new Exception('The step argument must be greater than 0.');
            }
        }

        $migrations = $this->getMigrationHistory($limit);

        if (empty($migrations)) {
            return self::NO_NEW_MIGRATION;
        }

        $migrations = array_keys($migrations);

        $reverted = 0;
        foreach ($migrations as $migration) {
            try {
                if (!$this->migrateDown($migration)) {
                    return self::ERROR_DOWN;
                }
                $reverted++;
            } catch (Exception $e) {
                Yii::error($e);
            }
        }
        return self::DONE;
    }

    /**
     * Upgrades with the specified migration class.
     *
     * @param string $class the migration class name
     * @return bool whether the migration is successful
     * @throws \yii\base\InvalidConfigException
     * @throws Exception
     */
    protected function migrateUp($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $this->db = Instance::ensure($this->db, Connection::className());

        $migration = $this->createMigration($class);
        $isConsoleRequest = PHP_SAPI === 'cli';

        if (!$isConsoleRequest) {
            ob_start();
        }

        $start = microtime(true);
        $success = $migration->up() !== false;
        $time = microtime(true) - $start;
        $log = ($success ? 'Applied ' : 'Failed to apply ') . $class . ' (time: ' . sprintf('%.3f', $time) . 's).';

        if (!$isConsoleRequest) {
            $output = ob_get_clean();
            $log .= " Output:\n" . $output;
        }

        if ($success) {
            $this->addMigrationHistory($class);
            Yii::info($log, __METHOD__);
        } else {
            Yii::error($log, __METHOD__);
        }

        return $success;
    }

    /**
     * Downgrades with the specified migration class.
     *
     * @param string $class the migration class name
     * @return bool whether the migration is successful
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    protected function migrateDown($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $migration = $this->createMigration($class);
        $isConsoleRequest = PHP_SAPI === 'cli';

        if (!$isConsoleRequest) {
            ob_start();
        }

        $start = microtime(true);
        $success = $migration->down() !== false;
        $time = microtime(true) - $start;
        $log = ($success ? 'Reverted ' : 'Failed to revert ') . $class . ' (time: ' . sprintf('%.3f', $time) . 's).';

        if (!$isConsoleRequest) {
            $output = ob_get_clean();
            $log .= " Output:\n" . $output;
        }

        if ($success) {
            $this->removeMigrationHistory($class);
            Yii::info($log, __METHOD__);
        } else {
            Yii::error($log, __METHOD__);
        }

        return $success;
    }

    /**
     * Creates a new migration instance
     * @param string $class The migration class name
     * @return object The migration instance
     * @throws \yii\base\InvalidConfigException
     */
    protected function createMigration($class)
    {
        $this->includeMigrationFile($class);

        return Yii::createObject([
            'class' => $class,
            'db' => $this->db,
            'compact' => $this->compact,
        ]);
    }

    /**
     * Includes the migration file for a given migration class name.
     *
     * This function will do nothing on namespaced migrations, which are loaded by
     * autoloading automatically. It will include the migration file, by searching
     * [[migrationPath]] for classes without namespace.
     * @param string $class the migration class name.
     */
    protected function includeMigrationFile($class)
    {
        $class = trim($class, '\\');
        if (strpos($class, '\\') === false) {
            if (is_array($this->migrationPath)) {
                foreach ($this->migrationPath as $path) {
                    $file = $path . DIRECTORY_SEPARATOR . $class . '.php';
                    if (is_file($file)) {
                        require_once $file;
                        break;
                    }
                }
            } else {
                $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
                require_once $file;
            }
        }
    }

    /**
     * Adds new migration entry to the history.
     * @param string $version migration version name
     * @throws \yii\db\Exception
     */
    protected function addMigrationHistory($version)
    {
        $command = $this->db->createCommand();
        $command->insert($this->migrationTable, [
            'version' => $version,
            'apply_time' => time(),
        ])->execute();
    }

    /**
     * Returns the migrations that are not applied.
     * @return array list of new migrations
     */
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $class => $time) {
            $applied[trim($class, '\\')] = true;
        }

        $migrationPaths = [];
        if (is_array($this->migrationPath)) {
            foreach ($this->migrationPath as $path) {
                $migrationPaths[] = [$path, ''];
            }
        } elseif (!empty($this->migrationPath)) {
            $migrationPaths[] = [$this->migrationPath, ''];
        }
        foreach ($this->migrationNamespaces as $namespace) {
            $migrationPaths[] = [$this->getNamespacePath($namespace), $namespace];
        }

        $migrations = [];
        foreach ($migrationPaths as $item) {
            list($migrationPath, $namespace) = $item;
            if (!file_exists($migrationPath)) {
                continue;
            }
            $handle = opendir($migrationPath);
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $migrationPath . DIRECTORY_SEPARATOR . $file;
                if (preg_match('/^(m(\d{6}_?\d{6})\D.*?)\.php$/is', $file, $matches) && is_file($path)) {
                    $class = $matches[1];
                    if (!empty($namespace)) {
                        $class = $namespace . '\\' . $class;
                    }
                    $time = str_replace('_', '', $matches[2]);
                    if (!isset($applied[$class])) {
                        $migrations[$time . '\\' . $class] = $class;
                    }
                }
            }
            closedir($handle);
        }
        ksort($migrations);

        return array_values($migrations);
    }

    /**
     * Returns the migration history.
     * @param int $limit the maximum number of records in the history to be returned. `null` for "no limit".
     * @return array the migration history
     */
    protected function getMigrationHistory($limit)
    {
        if ($this->db->schema->getTableSchema($this->migrationTable, true) === null) {
            $this->createMigrationHistoryTable();
        }
        $query = (new Query())
            ->select(['version', 'apply_time'])
            ->from($this->migrationTable)
            ->orderBy(['apply_time' => SORT_DESC, 'version' => SORT_DESC]);

        if (empty($this->migrationNamespaces)) {
            $query->limit($limit);
            $rows = $query->all($this->db);
            $history = ArrayHelper::map($rows, 'version', 'apply_time');
            unset($history[self::BASE_MIGRATION]);
            return $history;
        }

        $rows = $query->all($this->db);

        $history = [];
        foreach ($rows as $key => $row) {
            if ($row['version'] === self::BASE_MIGRATION) {
                continue;
            }
            if (preg_match('/m?(\d{6}_?\d{6})(\D.*)?$/is', $row['version'], $matches)) {
                $time = str_replace('_', '', $matches[1]);
                $row['canonicalVersion'] = $time;
            } else {
                $row['canonicalVersion'] = $row['version'];
            }
            $row['apply_time'] = (int) $row['apply_time'];
            $history[] = $row;
        }

        usort($history, function ($a, $b) {
            if ($a['apply_time'] === $b['apply_time']) {
                if (($compareResult = strcasecmp($b['canonicalVersion'], $a['canonicalVersion'])) !== 0) {
                    return $compareResult;
                }

                return strcasecmp($b['version'], $a['version']);
            }

            return ($a['apply_time'] > $b['apply_time']) ? -1 : +1;
        });

        $history = array_slice($history, 0, $limit);

        $history = ArrayHelper::map($history, 'version', 'apply_time');

        return $history;
    }

    /**
     * Returns the file path matching the give namespace.
     * @param string $namespace namespace.
     * @return string file path.
     * @since 2.0.10
     */
    private function getNamespacePath($namespace)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, Yii::getAlias('@' . str_replace('\\', '/', $namespace)));
    }

    /**
     * Creates the migration history table.
     */
    protected function createMigrationHistoryTable()
    {
        $tableName = $this->db->schema->getRawTableName($this->migrationTable);
        $this->db->createCommand()->createTable($this->migrationTable, [
            'version' => 'varchar(' . static::MAX_NAME_LENGTH . ') NOT NULL PRIMARY KEY',
            'apply_time' => 'integer',
        ])->execute();
        $this->db->createCommand()->insert($this->migrationTable, [
            'version' => self::BASE_MIGRATION,
            'apply_time' => time(),
        ])->execute();
    }

    /**
     * Return the maximum name length for a migration.
     *
     * Subclasses may override this method to define a limit.
     * @return int|null the maximum name length for a migration or `null` if no limit applies.
     * @since 2.0.13
     */
    protected function getMigrationNameLimit()
    {
        if ($this->_migrationNameLimit !== null) {
            return $this->_migrationNameLimit;
        }
        $tableSchema = $this->db->schema ? $this->db->schema->getTableSchema($this->migrationTable, true) : null;
        if ($tableSchema !== null) {
            return $this->_migrationNameLimit = $tableSchema->columns['version']->size;
        }

        return static::MAX_NAME_LENGTH;
    }

    /**
     * Removes existing migration from the history.
     * @param string $version migration version name.
     * @throws \yii\db\Exception
     */
    protected function removeMigrationHistory($version)
    {
        $command = $this->db->createCommand();
        $command->delete($this->migrationTable, [
            'version' => $version,
        ])->execute();
    }
}
