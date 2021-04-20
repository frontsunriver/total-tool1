<?php

namespace app\modules\api\modules\v1\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `api` module
 */
class DefaultController extends Controller
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        throw new NotFoundHttpException();
    }
}
