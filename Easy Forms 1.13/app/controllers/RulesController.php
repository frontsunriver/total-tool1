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

namespace app\controllers;

use app\models\Form;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use app\models\FormRule;

/**
 * Class RulesController
 * @package app\controllers
 */
class RulesController extends ActiveController
{
    public $modelClass = 'app\models\FormRule';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * Checks the privilege of the current user.
     *
     * @param string $action the ID of the action to be executed
     * @param \yii\base\Model $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        // Form ID
        $request = Yii::$app->request;
        $id = $request->post('form_id') ? $request->post('form_id') : $request->getQueryParam('id');
        if ($request->isDelete || $request->isPut || $request->isPatch) {
            $formRule = FormRule::findOne(['id' => $request->getQueryParam('id')]);
            $id = $formRule->form_id;
        }
        // Check access
        if (!Yii::$app->user->can('configureForms', ['model' => Form::findOne(['id' => $id])])) {
            // Access should be denied
            throw new ForbiddenHttpException(
                Yii::t("app", "You are not allowed to perform this action.")
            );
        }
    }

    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs[ "position" ] = ['POST'];
        return $verbs;
    }

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = function () {
            // Get id param
            $request = \Yii::$app->getRequest();
            $id = $request->get('id');

            $query = FormRule::find()->where('form_id=:form_id', [':form_id' => $id])
                ->orderBy(['ordinal' => 'ASC', 'id' => 'ASC']);

            return new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);
        };

        return $actions;
    }

    /**
     * Update Ordinal Position of Rules
     *
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionPosition()
    {
        // Get ids param
        $request = Yii::$app->getRequest();
        $formID = $request->post('form_id');
        $ids = $request->post('ids');

        // Check Access
        if (!Yii::$app->user->can('configureForms', ['model' => Form::findOne(['id' => $formID])])) {
            // if access should be denied
            throw new ForbiddenHttpException(
                Yii::t("app", "You are not allowed to perform this action.")
            );
        }

        // Response Format
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Default
        $success = false;
        $message = "No items matched the query";
        $i = 0;

        try {

            foreach ($ids as $id) {
                // Update position of each rule
                $ruleModel = FormRule::findOne(['form_id' => $formID, 'id' => $id]);
                $ruleModel->ordinal = $i;
                $ruleModel->save();
                $i++;
            }

            // Set response
            if ($i > 0) {
                $success = true;
                $message = Yii::t("app", "Position updated successfully");
            }

        } catch (\Exception $e) {
            // Rethrow the exception
            // throw $e;
            $message = $e->getMessage();
        }

        // Response to Client
        $res = array(
            'success' => $success,
            'action'  => 'position',
            'items' => $i,
            'ids' => $ids,
            'message' => $message,
        );

        return $res;
    }
}
