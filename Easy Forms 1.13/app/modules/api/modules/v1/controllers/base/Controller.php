<?php

namespace app\modules\api\modules\v1\controllers\base;

use app\modules\api\Module;
use yii\rest\Controller as BaseController;
use yii\web\BadRequestHttpException;

/**
 * Base controller for the `api` module
 */
class Controller extends BaseController
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
