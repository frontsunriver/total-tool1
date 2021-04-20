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

namespace app\components\analytics\collector;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidParamException;

/**
 * Class Collector
 * At data collection time,
 * we aim to capture all the data required to accurately represent a particular event that has just occurred.
 *
 * @package app\components\analytics\collector
 */
class Collector extends BaseObject
{

    /**
     * @var array
     */
    public $data;

    /**
     * Capture all the data required to accurately represent a particular event
     */
    public function init()
    {
        parent::init();

        if (!$this->shouldCollectEvents()) {
            throw new \Exception(Yii::t("app", "Collect events is disabled."));
        }

        $event = new Event();
        $this->collect($event);
    }

    /**
     * Return mapped event data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * On / Off event capture
     *
     * @return bool
     */
    protected function shouldCollectEvents()
    {
        return true;
    }

    /**
     * Collect data from an Event
     *
     * @param Event $event
     */
    protected function collect(Event $event)
    {
        // if event doesn't have data
        if ($event->isEmpty()) {
            throw new InvalidParamException(Yii::t("app", "The event has no data. There is nothing to collect."));
        }

        // Map tracker params to model properties
        $mapper = new Mapper();
        $mapper->map($event);

        // Mapped data
        $data = $mapper->getData();

        // Add collector data
        $data["collector_tstamp"] = time(); // Unix Timestamp for the event recorded by the collector
        $data["v_collector"] = "1.0"; // Collector version

        $this->data = $data;
    }
}
