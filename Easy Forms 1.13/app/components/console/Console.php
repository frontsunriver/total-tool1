<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\console;

use Yii;
use yii\console\Application;
use yii\web\ServerErrorHttpException;

/**
 * Class Console
 * @package app\components\console
 */
class Console
{
    /** @var Application $console Console Application */
    private static $console;

    /**
     * Run console command on background and return output
     *
     * @param string $cmd Argument that will be passed to console application
     * @return array [status, output]
     */
    public static function run($cmd)
    {
        if (self::isWindows() === true) {
            $cmd = self::phpExecutable() . ' -f ' . self::yiiPath() . ' ' . $cmd;
            $handler = popen('start /b ' . $cmd . ' 2>&1', 'r');
        } else {
            $cmd = self::phpExecutable() . ' ' . self::yiiPath() . ' ' . $cmd;
            $handler = popen($cmd, 'r');
        }
        $output = '';
        while (!feof($handler)) {
            $output .= fgets($handler);
        }
        $output = trim($output);
        $status = pclose($handler);
        return [$status, $output]; // In Windows, print using die or exit
    }

    /**
     * Run console command on background
     *
     * @param string $cmd Argument that will be passed to console application
     * @return int
     */
    public static function runOnBackground($cmd)
    {
        if (self::isWindows() === true) {
		        $cmd = self::phpExecutable() . ' -f ' . self::yiiPath() . ' ' . $cmd;
						return pclose(popen('start /b ' . $cmd . ' 2>&1', 'r'));
        } else {
		        $cmd = self::phpExecutable() . ' ' . self::yiiPath() . ' ' . $cmd;
            return pclose(popen($cmd . ' > /dev/null &', 'r'));
        }
    }

    /**
     * Run console command on background and save output on log file
     *
     * @param string $cmd
     * @param string $logPath
     * @param bool $update
     * @return int
     */
    public static function runAndLog($cmd, $logPath = '', $update = true)
    {
        $concat = $update ? '>>' : '>';
        $logPath = !empty($logPath) ? $logPath : Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'runtime' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'console.log';
        if (self::isWindows() === true) {
		        $cmd = self::phpExecutable() . ' -f ' . self::yiiPath() . ' ' . $cmd . ' '. $concat . escapeshellarg($logPath) .' 2>&1';
            return pclose(popen('start /b ' . $cmd, 'r'));
        } else {
		        $cmd = self::phpExecutable() . ' ' . self::yiiPath() . ' ' . $cmd . ' '. $concat . escapeshellarg($logPath) .' 2>&1';
            return pclose(popen($cmd . ' &', 'r'));
        }
    }

    /**
     * Return console application
     *
     * @return Application
     * @throws ServerErrorHttpException
     */
    public static function console()
    {
        if (!self::$console) {

            $oldApp = Yii::$app;

            // fcgi doesn't have STDIN and STDOUT defined by default
            defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
            defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));

            $consoleConfigFile = Yii::getAlias('@app/config/console.php');

            if (!file_exists($consoleConfigFile) || !is_array(($consoleConfig = require($consoleConfigFile)))) {
                throw new ServerErrorHttpException('Cannot find `'.
                    Yii::getAlias('@app/config/console.php').'`. Please create and configure console config.');
            }

            self::$console = new Application($consoleConfig);

            Yii::$app = $oldApp;
        }

        return self::$console;
    }

    /**
     * Runs a controller action specified by a route.
     * This method parses the specified route and creates the corresponding child module(s), controller and action
     * instances. It then calls [[Controller::runAction()]] to run the action with the given parameters.
     * If the route is empty, the method will use [[defaultRoute]].
     * @param string $route the route that specifies the action.
     * @param array $params the parameters to be passed to the action
     * @param string $controllerNamespace the namespace ot the controller&action
     * @return string the complet result of the migration command
     */
    public static function runAction($route, $params = [], $controllerNamespace = null)
    {
        $console = self::console();
        if (!is_null($controllerNamespace)) {
            $console->controllerNamespace = $controllerNamespace;
        }
        ob_start();
        $console->runAction($route, $params);
        $result = ob_get_clean();

        return $result;
    }

    /**
     * Run up migrations in background
     *
     * @param $migrationPath
     * @param $migrationTable
     * @return int
     */
    public static function migrate($migrationPath, $migrationTable)
    {
        return self::runOnBackground('migrate --migrationPath=' . $migrationPath .
            ' --migrationTable=' . $migrationTable . ' --interactive=0');
    }

    /**
     * Run down migrations in background
     *
     * @param $migrationPath
     * @param $migrationTable
     * @return int
     */
    public static function migrateDown($migrationPath, $migrationTable)
    {
        return self::runOnBackground('migrate/down --migrationPath=' . $migrationPath .
            ' --migrationTable=' . $migrationTable . ' --interactive=0');
    }

    /**
     * Check if currently running under MS Windows
     *
     * @see http://stackoverflow.com/questions/738823/possible-values-for-php-os
     * @return bool
     */
    public static function isWindows()
    {
        return
            (defined('PHP_OS') && (substr_compare(PHP_OS, 'win', 0, 3, true) === 0)) ||
            (getenv('OS') != false && substr_compare(getenv('OS'), 'windows', 0, 7, true))
            ;
    }

    /**
     * Return absolute path to PHP Binary
     *
     * @return false|string
     */
    public static function yiiPath()
    {
        return Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'yii';
    }

    /**
     * Return absolute path to PHP Binary
     *
     * @return string|boolean
     */
    public static function phpExecutable()
    {
        $phpExecutable = isset(Yii::$app, Yii::$app->params, Yii::$app->params['App.Console.phpPath']) &&
            !empty(Yii::$app->params['App.Console.phpPath']) ? Yii::$app->params['App.Console.phpPath'] : '';
        if (!$phpExecutable) {
            $phpExecutable = (new PhpExecutableFinder())->find();
        }
        return $phpExecutable;
    }

    /**
     * Check if popen and pclose are enabled
     *
     * @return bool
     */
    public static function popenEnabled()
    {
        // Check if function exists
        if (!function_exists('popen')) {
            return false;
        }

        // Are we in Safe Mode
        if (ini_get('safe_mode') && strtolower(ini_get('safe_mode')) != 'off') {
            return false;
        }

        // Is popen or pclose disabled?
        $disabledFunctions = array_map('trim', explode(',', ini_get('disable_functions')));
        if (in_array('popen', $disabledFunctions) || in_array('pclose', $disabledFunctions)) {
            return false;
        }

        return true;
    }

    /**
     * Check if PHP CLI version is 5.4 or above
     *
     * @return mixed
     */
    public static function validPhpCliVersion()
    {

        if (!self::popenEnabled()) {
            return false;
        }

        if (!version_compare(PHP_VERSION, '5.4', '>=')) {
            return false;
        }

        if (self::isWindows()) {

            if (self::phpExecutable()) {
                try {
                    $command = 'start /b ' . self::phpExecutable() . ' -v';
                    $manager = popen($command, 'r');
                    $result = fread($manager, 2096);
                    pclose($manager);
                    return strpos($result, PHP_VERSION) !== false;
                } catch (\Exception $e) {
                    // Log Error
                    Yii::error($e);
                }
            }

            return false;

        } else {

            return function_exists('popen') && function_exists('pclose');

        }

    }
}
