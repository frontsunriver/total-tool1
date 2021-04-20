<?php

namespace app\modules\api\modules\v1\controllers;

use app\modules\api\modules\v1\controllers\base\Controller;
use app\modules\api\modules\v1\resources\MeResource;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\ForbiddenHttpException;

class MeController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpHeaderAuth::class,
                [
                    'class' => QueryParamAuth::class,
                    'tokenParam' => 'api_key',
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        return MeResource::findOne(['id' => Yii::$app->user->identity->getId()]);
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
//        if (!Yii::$app->user->can('manageUsers')) {
//            throw new ForbiddenHttpException('You are not allowed to access this resource.');
//        }
    }
}
