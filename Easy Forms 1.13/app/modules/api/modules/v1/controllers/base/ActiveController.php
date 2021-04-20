<?php

namespace app\modules\api\modules\v1\controllers\base;

use app\modules\api\Module;
use yii\rest\ActiveController as BaseActiveController;
use yii\web\BadRequestHttpException;

/**
 * Base active controller for the `api` module
 */
class ActiveController extends BaseActiveController
{
    /**
     * @inheritdoc
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        /** @var Module $apiModule */
        $apiModule = Module::getInstance();
        if (!$apiModule->isEnabled) {
            return false;
        }

        return true;
    }
}
