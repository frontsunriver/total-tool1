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

namespace app\commands;

use app\components\analytics\Analytics;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Class AnalyticsController
 *
 * @package app\commands
 */
class AnalyticsController extends Controller
{

    /**
     * @var string the default command action.
     */
    public $defaultAction = 'aggregate';

    /**
     * Update the analytics data by applying new aggregations
     *
     * @return int the status of the action execution. 0 means normal, other values mean abnormal.
     * @throws \yii\console\Exception
     */
    public function actionAggregate()
    {

        try {

            Analytics::aggregate();

        } catch (\Exception $e) {

            throw new Exception($e->getMessage());

        }

        $this->stdout(gmdate('Y-m-d H:i:s') . ' : ' .
            Yii::t('app', "Analytics has successfully updated the stats tables.") . "\n", Console::FG_GREEN);

        return ExitCode::OK;

    }
}
