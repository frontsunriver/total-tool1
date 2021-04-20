<?php

namespace app\components\behaviors;

use Carbon\Carbon;
use Yii;

/**
 * Trait DateTrait
 * @package app\components\behaviors
 *
 * @property string $created
 * @property string $updated
 */
trait DateTrait
{
    /**
     * @return \yii\base\Module|null
     */
    public function getDateControlModule()
    {
        return Yii::$app->getModule('datecontrol');
    }
    public function hasHumanReadableFormat()
    {
        $humanTimeDiff = Yii::$app->settings->get('humanTimeDiff', 'app', null);
        return is_null($humanTimeDiff) || $humanTimeDiff === 1;
    }

    public function getDateFormat()
    {
        $dateControlModule = $this->getDateControlModule();
        return $dateControlModule->displaySettings['date'];
    }

    public function getTimeFormat()
    {
        $dateControlModule = $this->getDateControlModule();
        return $dateControlModule->displaySettings['time'];
    }

    public function getDateTimeFormat()
    {
        $dateControlModule = $this->getDateControlModule();
        return $dateControlModule->displaySettings['datetime'];
    }

    /**
     * Get Formatted Creation Time
     *
     * @return string|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreated()
    {
        $value = null;

        if (!empty($this->created_at) && is_integer($this->created_at)) {

            if ($this->hasHumanReadableFormat()) {
                $value = Carbon::createFromTimestampUTC($this->created_at)->diffForHumans();
                // $value = Yii::$app->formatter->asRelativeTime($this->created_at);
            } else {
                $format = $this->getDateTimeFormat();
                $value = Yii::$app->formatter->asDatetime($this->created_at, $format);
            }
        }

        return $value;
    }

    /**
     * Get Formatted Update Time
     *
     * @return string|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getUpdated()
    {
        $value = null;

        if (!empty($this->updated_at) && is_integer($this->updated_at)) {

            if ($this->hasHumanReadableFormat()) {
                $value = Carbon::createFromTimestampUTC($this->updated_at)->diffForHumans();
                // $value = Yii::$app->formatter->asRelativeTime($this->updated_at);
            } else {
                $format = $this->getDateTimeFormat();
                $value = Yii::$app->formatter->asDatetime($this->updated_at, $format);
            }
        }

        return $value;
    }

}