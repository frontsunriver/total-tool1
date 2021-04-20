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

use app\helpers\ArrayHelper;
use app\helpers\FileHelper;
use app\helpers\MailHelper;
use app\helpers\SlugHelper;
use app\models\Form;
use app\models\FormSubmission;
use app\models\FormSubmissionComment;
use app\models\FormSubmissionFile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;

/**
 * Class SubmissionsController
 * @package app\controllers
 */
class SubmissionsController extends ActiveController
{
    public $modelClass = 'app\models\FormSubmission';
    public $createScenario = 'administration';
    public $updateScenario = 'administration';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /** @inheritdoc */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['index', 'options'], 'allow' => true, 'roles' => ['viewFormSubmissions'], 'roleParams' => ['listing' => true]],
                    ['actions' => ['view', 'email'], 'allow' => true, 'roles' => ['viewFormSubmissions'], 'roleParams' => function() {
                        $id = Yii::$app->request->get('id', Yii::$app->request->post('id'));
                        $submission = FormSubmission::findOne(['id' => $id]);
                        return ['model' => $submission->form];
                    }],
                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createFormSubmissions']],
                    ['actions' => ['update'], 'allow' => true, 'roles' => ['updateFormSubmissions'], 'roleParams' => function() {
                        $submission = FormSubmission::findOne(['id' => Yii::$app->request->get('id')]);
                        return ['model' => $submission->form];
                    }],
                    ['actions' => ['delete'], 'allow' => true, 'roles' => ['deleteFormSubmissions'], 'roleParams' => function() {
                        $submission = FormSubmission::findOne(['id' => Yii::$app->request->get('id')]);
                        return ['model' => $submission->form];
                    }],
                    ['actions' => ['updateall'], 'allow' => true, 'roles' => ['updateFormSubmissions'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->post('id')])];
                    }],
                    ['actions' => ['deleteall'], 'allow' => true, 'roles' => ['deleteFormSubmissions'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->post('id')])];
                    }],
                    ['actions' => ['upload'], 'allow' => true, 'roles' => ['createFormSubmissions', 'updateFormSubmissions'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['delete-file'], 'allow' => true, 'roles' => ['deleteFormSubmissionFiles'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['add-comment'], 'allow' => true, 'roles' => ['createFormSubmissionComments'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['delete-comment'], 'allow' => true, 'roles' => ['deleteFormSubmissionComments'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                ],
            ],
        ]);
    }

    /** @inheritdoc */
    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = function () {
            // Get id param
            $request = Yii::$app->getRequest();
            $id = $request->get('id');
            $q = $request->get('q');
            $start = $request->get('start');
            $end = $request->get('end');

            $model = Form::findOne(['id' => $id]);
            $query = FormSubmission::find()->where('form_id=:form_id', [':form_id' => $id]);

            if (isset($q)) {
                $escape = [];
                if ($model->language !== 'ar-EG') { // This is incompatible with Arabic language
                    // if there are non-latin characters
                    if (preg_match('/[^\\p{Common}\\p{Latin}]/u', $q)) {
                        $q = substr(json_encode($q), 1, -1);
                    }
                    $escape = ["\\" => "\\\\\\"]; // Escape unicode code point
                }

                $query = FormSubmission::find()
                    ->where('form_id=:form_id', [':form_id' => $id])
                    ->andWhere(['like', 'data', $q, $escape]);

                if (!empty($q)) {
                    if (preg_match('/(id|ID|submission_id|SUBMISSION_ID):(\d+)/', $q, $matches)) { // Filter by Submission ID
                        if (!empty($matches[2])) {
                            $sid = trim($matches[2]);
                            $query = FormSubmission::find()
                                ->where('form_id=:form_id', [':form_id' => $id])
                                ->andWhere('id=:id', [':id' => $sid]);
                        }
                    } elseif (preg_match('/(#|number|NUMBER|submission_number|SUBMISSION_NUMBER):(\d+)/', $q, $matches)) { // Filter by Submission Number
                        if (!empty($matches[2])) {
                            $number = trim($matches[2]);
                            $query = FormSubmission::find()
                                ->where('form_id=:form_id', [':form_id' => $id])
                                ->andWhere('number=:number', [':number' => $number]);
                        }
                    }
                }
            }

            if (!empty($start) && !empty($end)) {
                $startAt = trim($start);
                $endAt = trim($end);
                $query->andFilterWhere(['between', 'created_at', $startAt, $endAt]);
            }

            // Add scopes only if the current user can't configure this form
            if (!Yii::$app->user->can('configureForms', ['model' => $model])) {
                if ($model->submission_scope === Form::SUBMISSION_SCOPE_OWNER) {
                    $query->andWhere('created_by=:created_by', [':created_by' => Yii::$app->user->id]);
                }
            }

            return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => Yii::$app->user->preferences->get('GridView.pagination.pageSize'),
                ],
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                ]
            ]);
        };

        return $actions;
    }

    /**
     * Send Email
     *
     * @param $id Form ID
     * @return array
     */
    public function actionEmail($id)
    {

        // Response format
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = [
            'success' => 0,
            'message' => Yii::t('app', 'Email has not been sent.'),
        ];

        try {
            // POST params
            $request = Yii::$app->getRequest();
            $sid = $request->post('sid');
            $type = $request->post('type');

            $formModel = Form::findOne(['id' => $id]);
            $submissionModel = FormSubmission::findOne(['id' => $sid]);

            $success = false;

            if ($type === 'NOTIFICATION') {

                $success = MailHelper::sendNotificationByEmail($formModel, $submissionModel);

            } elseif ($type === 'CONFIRMATION') {

                $success = MailHelper::sendConfirmationByEmail($formModel, $submissionModel);

            }

            if ($success) {

                $response = [
                    'success' => 1,
                    'message' => Yii::t('app', 'Email sent successfully.'),
                ];

            }

        } catch (\Exception $e) {

            Yii::error($e);

            $response = [
                'success' => 1,
                'message' => $e->getMessage(),
            ];

        }

        return $response;
    }

    public function actionUpdateall()
    {
        // Get ids param
        $request = Yii::$app->getRequest();
        $id = $request->post('id');
        $ids = $request->post('ids');
        $attributes = $request->post('attributes');

        // Default
        $success = false;
        $message = Yii::t("app", "No items matched the query");
        $itemsUpdated = 0;

        try {
            // The number of rows updated
            $itemsUpdated = FormSubmission::updateAll($attributes, ['id' => $ids, 'form_id' => $id]);

            if ($itemsUpdated > 0) {
                $success = true;
                $message = Yii::t("app", "Items updated successfully");
            }

        } catch (\Exception $e) {
            // Rethrow the exception
            // throw $e;
            $message = $e->getMessage();
        }

        // Response fornat
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Response to Client
        $res = array(
            'success' => $success,
            'action'  => 'updateall',
            'itemsUpdated' => $itemsUpdated,
            'ids' => $ids,
            'attributes' => $attributes,
            'message' => $message,
        );

        return $res;

    }

    public function actionDeleteall()
    {
        // Get ids param
        $request = Yii::$app->getRequest();
        $id = $request->post('id');
        $ids = $request->post('ids');

        // Default
        $success = false;
        $message = "No items matched the query";
        $itemsDeleted = 0;

        try {
            // The number of rows deleted
            $itemsDeleted = 0;
            // Delete one to one for trigger events
            foreach (FormSubmission::find()->where(['id' => $ids, 'form_id' => $id])->all() as $submissionModel) {
                $deleted = $submissionModel->delete();
                if ($deleted) {
                    $itemsDeleted++;
                }
            }
            // Set response
            if ($itemsDeleted > 0) {
                $success = true;
                $message = Yii::t("app", "Items deleted successfully");
            }

        } catch (\Exception $e) {
            // Rethrow the exception
            // throw $e;
            $message = $e->getMessage();
        }

        // Response format
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Response to Client
        $res = array(
            'success' => $success,
            'action'  => 'deleteall',
            'itemsDeleted' => $itemsDeleted,
            'ids' => $ids,
            'message' => $message,
        );

        return $res;

    }

    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs[ "upload" ] = ['POST'];
        $verbs[ "delete-file" ] = ['POST'];
        $verbs[ "add-comment" ] = ['POST'];
        $verbs[ "delete-comment" ] = ['POST'];
        return $verbs;
    }

    /**
     * Add Form Submission Comment model
     *
     * @param integer $id Form ID
     * @return array
     */
    public function actionAddComment($id)
    {

        // Response fornat
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Get id params
        $request = Yii::$app->getRequest();
        $submissionID = $request->post('submission_id');
        $comment = $request->post('comment');

        try {
            if (!empty($comment)) {
                $commentModel = new FormSubmissionComment();
                $commentModel->form_id = $id;
                $commentModel->submission_id = $submissionID;
                $commentModel->content = $comment;
                if ($commentModel->save()) {
                    return $commentModel->toArray(['id', 'content', 'authorName', 'submitted']);
                } else {
                    die(var_dump($commentModel->getErrors()));
                }
            }
        } catch (\Exception $e) {
            // Rethrow the exception
            // throw $e;
            $message = $e->getMessage();
        }
    }

    /**
     * Delete Form Submission Comment model
     *
     * @param integer $id Form ID
     * @return array
     */
    public function actionDeleteComment($id)
    {

        // Get id params
        $request = Yii::$app->getRequest();
        $submissionID = $request->post('submission_id');
        $commentID = $request->post('comment_id');

        // Default
        $success = false;
        $message = "No items matched the query";

        try {
            $commentModel = FormSubmissionComment::findOne(['id' => $commentID]);
            // Check Access to File
            if ($commentModel->form_id == $id) {
                // Delete the model
                $itemDeleted = $commentModel->delete();
                // Set response
                if ($itemDeleted) {
                    $success = true;
                    $message = Yii::t("app", "Items deleted successfully");
                }
            }
        } catch (\Exception $e) {
            // Rethrow the exception
            // throw $e;
            $message = $e->getMessage();
        }

        // Response fornat
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Response to Client
        $res = array(
            'success' => $success,
            'action'  => 'deleteFile',
            'submissionID' => $submissionID,
            'commentID' => $commentID,
            'message' => $message,
        );

        return $res;
    }

    /**
     * Delete Form Submission File model
     *
     * @param integer $id Form ID
     * @return array
     */
    public function actionDeleteFile($id)
    {

        // Get id params
        $request = Yii::$app->getRequest();
        $submissionID = $request->post('submission_id');
        $fileID = $request->post('file_id');

        // Default
        $success = false;
        $message = "No items matched the query";

        try {
            $fileModel = FormSubmissionFile::findOne(['id' => $fileID]);
            // Check Access to File
            if ($fileModel->form_id == $id) {
                // Delete
                $itemDeleted = $fileModel->delete();
                // Set response
                if ($itemDeleted) {
                    $success = true;
                    $message = Yii::t("app", "Items deleted successfully");
                }
            }
        } catch (\Exception $e) {
            Yii::error($e);
            $message = $e->getMessage();
        }

        // Response fornat
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Response to Client
        $res = array(
            'success' => $success,
            'action'  => 'deleteFile',
            'submissionID' => $submissionID,
            'fileID' => $fileID,
            'message' => $message,
        );

        return $res;

    }

    /**
     * Overwrite files
     *
     * @param int $id Form Model id
     * @param int $s_id FormSubmission Model id
     * @return array
     */
    public function actionUpload($id, $s_id)
    {

        // Response
        $submissionFiles = array();

        foreach ($_FILES as $fieldID => $files) {

            // Delete old files
            $fileModels = FormSubmissionFile::findAll(['submission_id' => $s_id, 'field' => $fieldID]);
            foreach ($fileModels as $fileModel) {
                // Check Access to File
                if ($fileModel->form_id == $id) {
                    // Delete
                    $fileModel->delete();
                }
            }

            // Get Form Fields
            $form = Form::findOne(['id' => $id]);
            $fileFields = $form->formData->getFileLabels();

            // Check if Field exists
            if (array_key_exists($fieldID, $fileFields)) {
                if ($count = count($files['name'])) {
                    // Looping all files
                    for ($i = 0; $i < $count; $i++) {
                        // Save new files
                        $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                        $filename = basename($files['name'][$i], "." . $extension);

                        // Save New File Model
                        $fileModel = new FormSubmissionFile();
                        $fileModel->form_id = $id;
                        $fileModel->submission_id = $s_id;
                        $fileModel->field = $fieldID;
                        $fileModel->label = $fileFields[$fieldID];
                        $fileModel->name = SlugHelper::slug($filename) . "-" . rand(0, 100000) . "-" . $s_id;
                        $fileModel->extension = $extension;
                        $fileModel->size = $files['size'][$i];
                        $fileModel->save();
                        $submissionFiles[] = $fileModel->toArray(['id', 'field', 'label', 'name', 'originalName','extension', 'sizeWithUnit', 'link']);

                        // Store File on Disk
                        FileHelper::save($fileModel->getPath(), $files['tmp_name'][$i]);
                    }
                }
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $submissionFiles;
    }
}
