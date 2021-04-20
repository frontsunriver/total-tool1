<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.12
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\controllers;

use app\helpers\Hashids;
use app\models\FormSubmissionFile;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;

/**
 * Class SecureController
 * @package app\controllers
 */
class SecureController extends Controller
{
    /**
     * Download Form Submission File
     *
     * @param $id
     * @param string $api_key
     * @return \yii\console\Response|Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws RangeNotSatisfiableHttpException
     * @throws \yii\base\NotSupportedException
     */
    public function actionFile($id, $api_key = '')
    {
        $id = Hashids::decode($id);

        if (($model = FormSubmissionFile::findOne(['id' => $id])) !== null) {

            // Login user with api key
            if (!empty($api_key)) {
                $identity = User::findIdentityByAccessToken($api_key);
                Yii::$app->user->login($identity);
            }

            // Checking user access
            if ($model->form->protected_files && !Yii::$app->user->can('viewFormSubmissionFiles', ['model' => $model->form])) {
                throw new ForbiddenHttpException('You are not allowed to access this resource.');
            }

            // Logout user with api key
            if (!empty($api_key)) {
                Yii::$app->user->logout();
            }

            // Checking file existence
            $filePath = $model->getPath();
            $exists = Yii::$app->fs->has($filePath);

            // Download file
            if ($exists) {
                $stream = Yii::$app->fs->readStream($filePath);
                $contents = stream_get_contents($stream);
                fclose($stream);
                return Yii::$app->response->sendContentAsFile($contents, basename($filePath));
            }
        }

        throw new NotFoundHttpException(Yii::t("app", "The requested page does not exist."));
    }
}
