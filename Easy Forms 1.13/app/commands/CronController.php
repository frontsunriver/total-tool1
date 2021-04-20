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
use app\components\cron\CronExpression;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Class CronController
 *
 * @package app\commands
 */
class CronController extends Controller
{

    /**
     * @var string the default command action.
     */
    public $defaultAction = 'run';

    /**
     * Run cron commands
     *
     * @return int
     */
    public function actionRun()
    {
        // NOTE: Linux Cron must be configured to every minute, no less

        // By default, update analytics every day
        $cron = CronExpression::factory(Yii::$app->params['App.Analytics.cronExpression']);

        if ($cron->isDue()) {
            // Update analytics
            Analytics::aggregate();
            $this->stdout(gmdate('Y-m-d H:i:s') . ' : ' .
                Yii::t('app', "Analytics has successfully updated the stats tables.") . "\n", Console::FG_GREEN);
        }

        // By default, process mail queue every minute
        $cron = CronExpression::factory(Yii::$app->params['App.Mailer.cronExpression']);
        if ($cron->isDue()) {
            // Process queue
            /** @var \app\components\queue\MailQueue $mailer */
            $mailer = Yii::$app->mailer;
            $success = $mailer->process();
            if ($success) {
                // if all messages are successfully sent out
                $this->stdout(gmdate('Y-m-d H:i:s') . ' : ' .
                    Yii::t('app', "All e-mails are successfully sent out.") . "\n", Console::FG_GREEN);
            } else {
                $this->stdout(gmdate('Y-m-d H:i:s') . ' : ' .
                    Yii::t('app', "Error sending e-mails.") . "\n", Console::FG_RED);
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }

        return ExitCode::OK;
    }
}
