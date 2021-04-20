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

namespace app\components\analytics;

use yii\base\Component;
use app\components\analytics\collector\Collector;
use app\components\analytics\enricher\Enricher;
use app\components\analytics\storage\Storage;
use app\components\analytics\modeler\Modeler;
use app\components\analytics\report\Report;

/**
 * Class Analytics
 * @package app\components\analytics
 */
class Analytics extends Component
{

    public static function collect($options)
    {
        $collector = new Collector();
        $rawData = $collector->getData();
        $enricher = new Enricher();
        $enricher->setData($rawData);
        $enricher->process();
        $enrichedData = $enricher->getData();
        $storage = new Storage($options);
        $storage->save($enrichedData);
    }

    public static function aggregate()
    {
        $modeler = new Modeler();
        $modeler->run();
    }

    public static function report()
    {
        return new Report();
    }
}
