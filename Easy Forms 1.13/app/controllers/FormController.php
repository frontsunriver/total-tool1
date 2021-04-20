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

use app\components\database\Model;
use app\components\export\XLSXWriter;
use app\components\qr\QrCode;
use app\components\qr\QrCodeAction;
use app\helpers\ArrayHelper;
use app\helpers\Css;
use app\helpers\Honeypot;
use app\helpers\Html;
use app\helpers\Pager;
use app\helpers\UrlHelper;
use app\models\Form;
use app\models\FormConfirmation;
use app\models\FormConfirmationRule;
use app\models\FormData;
use app\models\FormEmail;
use app\models\FormRule;
use app\models\forms\PopupForm;
use app\models\FormSubmission;
use app\models\FormSubmissionFile;
use app\models\FormUI;
use app\models\FormUser;
use app\models\search\FormSearch;
use app\models\Template;
use app\models\User;
use kartik\datecontrol\Module as DateControlModule;
use SimpleExcel\SimpleExcel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class FormController
 * @package app\controllers
 */
class FormController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'copy' => ['post'],
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['index'], 'allow' => true, 'roles' => ['viewForms'], 'roleParams' => ['listing' => true]],
                    ['actions' => ['view'], 'allow' => true, 'roles' => ['viewForms'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createForms']],
                    ['actions' => ['update'], 'allow' => true, 'roles' => ['updateForms'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['delete'], 'allow' => true, 'roles' => ['deleteForms'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['copy'], 'allow' => true, 'roles' => ['copyForms'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['settings', 'rules'], 'allow' => true, 'roles' => ['configureForms'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['analytics', 'stats'], 'allow' => true, 'roles' => ['accessFormStats'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['reset-stats'], 'allow' => true, 'roles' => ['resetFormStats'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['report'], 'allow' => true, 'roles' => ['accessFormReports'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['update-status'], 'allow' => true, 'roles' => ['configureForms'], 'roleParams' => function() {
                        return ['modelClass' => Form::className(), 'ids' => Yii::$app->request->post('ids')];
                    }],
                    ['actions' => ['delete-multiple'], 'allow' => true, 'roles' => ['deleteForms'], 'roleParams' => function() {
                        return ['modelClass' => Form::className(), 'ids' => Yii::$app->request->post('ids')];
                    }],
                    ['actions' => ['rule-builder'], 'allow' => true, 'roles' => ['configureForms'], 'roleParams' => function() {
                        $id = Yii::$app->request->get('id');
                        if (Yii::$app->request->isPost) {
                            $id = Yii::$app->request->post('id', $id);
                        }
                        return ['model' => Form::findOne(['id' => $id])];
                    }],
                    [
                        'actions' => ['share', 'popup-preview', 'popup-code', 'qr-code', 'download-html-code'],
                        'allow' => true,
                        'roles' => ['publishForms'],
                        'roleParams' => function() {
                            return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                        }
                    ],

                    ['actions' => ['submissions'], 'allow' => true, 'roles' => ['viewFormSubmissions'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['export-submissions'], 'allow' => true, 'roles' => ['exportFormSubmissions'], 'roleParams' => function() {
                        return ['model' => Form::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'delete-multiple' => [
                'class' => '\app\components\actions\DeleteMultipleAction',
                'modelClass' => 'app\models\Form',
                'afterDeleteCallback' => function () {
                    Yii::$app->getSession()->setFlash(
                        'success',
                        Yii::t('app', 'The selected items have been successfully deleted.')
                    );
                },
            ],
            'rule-builder' => [
                'class' => 'app\components\rules\RuleBuilderAction',
                'output' => function ($formID) {
                    $output = [
                        'variables' => [],
                    ];
                    $form = Form::findOne(['id' => $formID]);
                    if ($form) {
                        $formDataModel = $form->formData;
                        if ($formDataModel) {
                            $output['variables'] = $formDataModel->getRuleVariables(false);
                        }
                    }
                    return $output;
                }
            ]
        ];
    }

    /**
     * Lists all Form models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Only for admin users
        if (Yii::$app->user->can("createForms") && ($dataProvider->totalCount == 0)) {
            Yii::$app->getSession()->setFlash(
                'warning',
                Html::tag('strong', Yii::t("app", "You don't have any forms!")) . ' ' .
                Yii::t("app", "Click the blue button on the left to start building your first form.")
            );
        }

        /** @var \app\components\User $currentUser */
        $currentUser = Yii::$app->user;
        $templates = $currentUser->templates()
            ->andWhere(['promoted' => Template::PROMOTED_ON,])
            ->limit(5)
            ->orderBy('updated_at DESC')
            ->asArray()
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'templates' => $templates,
        ]);
    }

    /**
     * Show form builder to create a Form model.
     *
     * @param string $template
     * @return string
     */
    public function actionCreate($template = 'default')
    {

        $this->disableAssets();

        return $this->render('create', [
            'template' => $template
        ]);
    }

    /**
     * Show form builder to update Form model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        $this->disableAssets();

        $model = $this->findFormModel($id);

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Enable / Disable multiple Forms
     *
     * @param $status
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdateStatus($status)
    {

        $forms = Form::findAll(['id' => Yii::$app->getRequest()->post('ids')]);

        if (empty($forms)) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found.'));
        } else {
            foreach ($forms as $form) {
                $form->status = $status;
                $form->update();
            }
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('app', 'The selected items have been successfully updated.')
            );
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Form model (except id).
     * Updates an existing FormData model (only data field).
     * Updates an existing FormConfirmation model (except id & form_id).
     * Updates an existing FormEmail model (except id & form_id).
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param int|null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionSettings($id = null)
    {
        /** @var \app\models\Form $formModel */
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;
        $formConfirmationModel = $formModel->formConfirmation;
        $formEmailModel = $formModel->formEmail;
        $formUIModel = $formModel->ui;
        $formConfirmationRuleModel = new FormConfirmationRule();
        $rules = $formModel->formConfirmationRules;

        $postData = Yii::$app->request->post();

        if ($formModel->load($postData) && $formConfirmationModel->load($postData)
            && $formEmailModel->load($postData) && $formUIModel->load($postData)
            && Model::validateMultiple([$formModel, $formConfirmationModel, $formEmailModel, $formUIModel])) {

            // Save data in single transaction
            $transaction = Form::getDb()->beginTransaction();
            try {
                // Save Form Model
                if (!$formModel->save()) {
                    throw new \Exception(Yii::t("app", "Error saving Form Model"));
                }
                // Save data field in FormData model
                if (isset($postData['Form']['name'])) {
                    $formDataModel->setFormName($formModel->name);
                    $formDataModel->save();
                }
                if (Yii::$app->user->can('shareForms', ['model' => $formModel])) {
                    // Remove old form users
                    FormUser::deleteAll(['form_id' => $formModel->id]);
                    // Save form users
                    if (Form::SHARED_WITH_USERS === (int) $formModel->shared
                        && isset($postData['Form']['users'])) {
                        $users = $postData['Form']['users'];
                        if (is_array($users)) {
                            foreach ($users as $user_id) {
                                $formUser = new FormUser();
                                $formUser->form_id = $formModel->id;
                                $formUser->user_id = $user_id;
                                $formUser->save();
                            }
                        }
                    }
                }

                // Convert data images to stored images in the email messages
                $location = $formModel->getFilesDirectory();
                if (!empty($formConfirmationModel->mail_message)) {
                    // Confirmation email message
                    $html = $formConfirmationModel->mail_message;
                    $formConfirmationModel->mail_message = Html::storeBase64ImagesOnLocation($html, $location);
                }
                if (!empty($formEmailModel->message)) {
                    // Notification email message
                    $html = $formEmailModel->message;
                    $formEmailModel->message = Html::storeBase64ImagesOnLocation($html, $location);
                }

                // Save FormConfirmation Model
                if (!$formConfirmationModel->save()) {
                    throw new \Exception(Yii::t("app", "Error saving Form Confirmation Model"));
                }
                // Save FormEmail Model
                if (!$formEmailModel->save()) {
                    throw new \Exception(Yii::t("app", "Error saving Form Email Model"));
                }
                // Save FormUI Model
                if (!$formUIModel->save()) {
                    throw new \Exception(Yii::t("app", "Error saving Form UI Model"));
                }

                // Save Confirmation Rule Models as New Models
                FormConfirmationRule::deleteAll(['form_id' => $formModel->id]);
                $rules = Model::createMultiple(FormConfirmationRule::classname());
                if (count($rules) > 0) {
                    Model::loadMultiple($rules, $postData);
                    if (Model::validateMultiple($rules)) {
                        foreach ($rules as $action) {
                            $action->form_id = $formModel->id;
                            if (!$action->save()) {
                                throw new \Exception(Yii::t("app", "Error saving Form Confirmation Action"));
                            }
                        }
                    }
                }

                $transaction->commit();

                Yii::$app->getSession()->setFlash(
                    'success',
                    Yii::t('app', 'The form settings have been successfully updated')
                );

                if (isset($postData['continue'])) {
                    return $this->refresh();
                }

                return $this->redirect(['index']);

            } catch (\Exception $e) {
                // Rolls back the transaction
                $transaction->rollBack();
                // Rethrow the exception
                throw $e;
            }

        } else {

            // Select id & name of all users
            $users = User::find()->select(['id', 'username'])->asArray()->all();
            $users = ArrayHelper::map($users, 'id', 'username');
            // Select id & name of form users
            $formUsers = ArrayHelper::map($formModel->users, 'id', 'username');
            /** @var \app\components\User $currentUser */
            $currentUser = Yii::$app->user;
            $themes = $currentUser->themes()->asArray()->all();
            $themes = ArrayHelper::map($themes, 'id', 'name');

            return $this->render('settings', [
                'formModel' => $formModel,
                'formDataModel' => $formDataModel,
                'formConfirmationModel' => $formConfirmationModel,
                'formEmailModel' => $formEmailModel,
                'formUIModel' => $formUIModel,
                'formConfirmationRuleModel' => $formConfirmationRuleModel,
                'themes' => $themes,
                'users' => $users,
                'rules' => $rules,
                'formUsers' => $formUsers,
            ]);
        }

    }

    /**
     * Displays a single Form Data Model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $formModel = $this->findFormModel($id);

        return $this->render('view', [
            'formModel' => $formModel,
        ]);
    }

    /**
     * Displays a single Form Rule Model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionRules($id)
    {
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;

        return $this->render('rule', [
            'formModel' => $formModel,
            'formDataModel' => $formDataModel,
        ]);
    }

    /**
     * Displays share options.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionShare($id)
    {
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;
        $popupForm = new PopupForm();

        return $this->render('share', [
            'formModel' => $formModel,
            'formDataModel' => $formDataModel,
            'popupForm' => $popupForm
        ]);
    }

    /**
     * Preview a PopUp Form.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionPopupPreview($id)
    {
        $this->layout = false;

        $popupForm = new PopupForm();

        if ($popupForm->load(Yii::$app->request->post()) && $popupForm->validate()) {

            $formModel = $this->findFormModel($id);
            $formDataModel = $formModel->formData;

            return $this->render('popup-preview', [
                'formModel' => $formModel,
                'formDataModel' => $formDataModel,
                'popupForm' => $popupForm,
            ]);

        }

        return $this->redirect(['form/share', 'id' => $id]);

    }

    /**
     * Displays the PopUp Form Generated Code.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionPopupCode($id)
    {
        $this->layout = false;

        $popupForm = new PopupForm();

        if ($popupForm->load(Yii::$app->request->post()) && $popupForm->validate()) {

            $formModel = $this->findFormModel($id);
            $formDataModel = $formModel->formData;

            return $this->render('popup-code', [
                'formModel' => $formModel,
                'formDataModel' => $formDataModel,
                'popupForm' => $popupForm,
            ]);

        }

        return $this->redirect(['form/share', 'id' => $id]);

    }

    /**
     * Display form performance analytics page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionAnalytics($id)
    {
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;

        return $this->render('analytics', [
            'formModel' => $formModel,
            'formDataModel' => $formDataModel,
        ]);
    }

    /**
     * Displays form submissions stats page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionStats($id)
    {
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;

        return $this->render('stats', [
            'formModel' => $formModel,
            'formDataModel' => $formDataModel,
        ]);
    }

    /**
     * Reset form submissions stats and performance analytics
     * If the delete is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionResetStats($id)
    {
        // Delete all Stats related to this form
        $rowsDeleted = $this->findFormModel($id)->deleteStats();

        if ($rowsDeleted > 0) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The stats have been successfully deleted.'));
        } else {
            Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'There are no items to delete.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Copy an existing Form model (and relations).
     * If the copy is successful, the browser will be redirected to the 'index' page.
     *
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionCopy($id)
    {
        // Source
        $form = $this->findFormModel($id);

        $transaction = Form::getDb()->beginTransaction();

        try {

            // Form
            $formModel = new Form();
            $formModel->attributes = $form->attributes;
            $formModel->name = $form->name . ' Copy';
            $formModel->id = null;
            $formModel->isNewRecord = true;
            $formModel->save();

            // Form Data
            $formDataModel = new FormData();
            $formDataModel->attributes = $form->formData->attributes;
            $formDataModel->id = null;
            $formDataModel->form_id = $formModel->id;
            $formDataModel->isNewRecord = true;
            $formDataModel->setFormName($formModel->name);
            $formDataModel->save();

            // Confirmation
            $formConfirmationModel = new FormConfirmation();
            $formConfirmationModel->attributes = $form->formConfirmation->attributes;
            $formConfirmationModel->id = null;
            $formConfirmationModel->form_id = $formModel->id;
            $formConfirmationModel->isNewRecord = true;
            $formConfirmationModel->save();

            // Notification
            $formEmailModel = new FormEmail();
            $formEmailModel->attributes = $form->formEmail->attributes;
            $formEmailModel->id = null;
            $formEmailModel->form_id = $formModel->id;
            $formEmailModel->isNewRecord = true;
            $formEmailModel->save();

            // UI
            $formUIModel = new FormUI();
            $formUIModel->attributes = $form->ui->attributes;
            $formUIModel->id = null;
            $formUIModel->form_id = $formModel->id;
            $formUIModel->isNewRecord = true;
            $formUIModel->save();

            // Conditional Rules
            foreach($form->formRules as $rule){
                $formRuleModel = new FormRule();
                $formRuleModel->attributes = $rule->attributes;
                $formRuleModel->id = null;
                $formRuleModel->form_id = $formModel->id;
                $formRuleModel->isNewRecord = true;
                $formRuleModel->save();
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The form has been successfully copied'));

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'There was an error copying your form.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Form model (and relations).
     * If the delete is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // Delete Form model
        $this->findFormModel($id)->delete();

        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The form has been successfully deleted'));

        return $this->redirect(['index']);
    }

    /**
     * Show form submissions.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionSubmissions($id = null)
    {
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;

        return $this->render('submissions', [
            'formModel' => $formModel,
            'formDataModel' => $formDataModel
        ]);
    }

    /**
     * Export form submissions.
     *
     * @param int $id
     * @param string|null $start
     * @param string|null $end
     * @throws \Exception
     */
    public function actionExportSubmissions($id, $start = null, $end = null, $format = 'csv')
    {

        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;

        $query = FormSubmission::find()
            ->select(['id', 'form_id', 'number', 'data', 'sender', 'created_at'])
            ->where('{{%form_submission}}.form_id=:form_id', [':form_id' => $id])
            ->orderBy('created_at DESC')
            ->with('form', 'files');

        if (!empty($start) && !empty($end)) {
            $startAt = trim($start);
            $endAt = trim($end);
            $query->andFilterWhere(['between', 'created_at', $startAt, $endAt]);
        }

        // Insert fields names as the header
        $allLabels = $formDataModel->getFieldsForEmail(false, false);
        $labels = [];
        foreach ($allLabels as $key => $label) {
            // Exclude Signature Field
            if (substr($key, 0, 16) !== 'hidden_signature') {
                $labels[$key] = $label;
            }
        }
        $header = array_values($labels);

        // Add File Fields
        $fileFields = $formDataModel->getFileLabels();
        $header = array_merge($header, array_values($fileFields)); // Add only labels
        array_unshift($header, Yii::t('app', 'Submission Number'));
        array_unshift($header, Yii::t('app', 'Submission ID'));
        array_unshift($header, '#');
        array_push($header, Yii::t('app', 'Submitted'));
        $keys = array_keys($labels);

        // Add Sender Information
	    $senderHeader = array(
		    'country' => Yii::t('app', 'Country'),
            'city' => Yii::t('app', 'City'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'url' => Yii::t('app', 'Url'),
            'referrer' => Yii::t('app', 'Referrer'),
	    );
	    $header = array_merge($header, $senderHeader); // Add only labels

        // File Name To Export
        /** @var DateControlModule $dateControlModule */
        $dateControlModule = Yii::$app->getModule('datecontrol');
        $dateFormat = $dateControlModule->getDisplayFormat(DateControlModule::FORMAT_DATE);
        $fileNameToExport = !is_null($start) && !is_null($end) ? $formModel->name . '_' . Yii::$app->formatter->asDate($start, $dateFormat) . '_' . Yii::$app->formatter->asDate($end, $dateFormat) : $formModel->name;

        // Add data
        $data = array(
            $header
        );

        // To iterate the row one by one
        $i = 1;
        foreach ($query->each() as $submission) {
            // $submission represents one row of data from the form_submission table
            $submissionData = is_array($submission->data) ? $submission->data : json_decode($submission->data, true);
            if (is_array($submissionData) && !empty($submissionData)) {
                // Stringify fields with multiple values
                foreach ($submissionData as $name => &$field) {
                    if (is_array($field)) {
                        $field = implode(', ', $field);
                    }
                }
                // Only take data of current fields
                $fields = [];
                $fields["i"] = $i++;
                $fields["id"] = $submission->id;
                $fields["number"] = $submission->number;
                foreach ($keys as $key) {
                    // Exclude Signature Field
                    if (substr($key, 0, 16) !== 'hidden_signature') {
                        $fields[$key] = isset($submissionData[$key]) ? $submissionData[$key] : '';
                    }
                }
                // Add files
                foreach ($fileFields as $name => $label) {
                    if (isset($submission->files) && is_array($submission->files) && count($submission->files) > 0) {
                        $file = ArrayHelper::first(ArrayHelper::filter($submission->files, $name, 'field'));
                        if (isset($file['name'], $file['extension'])) {
                            $fileName = $file['name'] .'.'.$file['extension'];
                            $fields[$name] = Url::to('@uploads' . '/' . FormSubmissionFile::FILES_FOLDER . '/' . $formModel->id . '/' . $fileName, true);
                        } else {
                            $fields[$name] = '';
                        }
                    } else {
                        $fields[$name] = '';
                    }
                }
                // Add date
                $fields["created_at"] = Yii::$app->formatter->asDatetime($submission->created_at);
                // Add sender information
                $sender = json_decode($submission->sender, true);
                foreach ($senderHeader as $key => $value) {
                    $fields[$key] = isset($sender[$key]) ? $sender[$key] : '';
                }
                array_push($data, $fields);
            }
        }

        if ($format == 'xlsx') {
            $writer = new XLSXWriter();
            $writer->setAuthor(Yii::$app->settings->get('name', 'app', 'Easy Forms'));
            $writer->setTitle($formModel->name);
            $writer->setDescription(sprintf("Spreadsheet document generated by %s", Yii::$app->settings->get('name', 'app', 'Easy Forms')));
            $writer->writeSheet($data, $formModel->name);
            $fileString = $writer->writeToString();
            return Yii::$app->response->sendContentAsFile($fileString, sprintf("%s.%s", $fileNameToExport, $format), [
                'mimeType' => 'application/octet-stream',
                'inline'   => false
            ]);
        } elseif ($format == 'csv') {
            $excel = new SimpleExcel($format);
            $excel->writer->setData($data);
            $fileString = $excel->writer->saveString();
            return Yii::$app->response->sendContentAsFile($fileString, sprintf("%s.%s", $fileNameToExport, $format), [
                'mimeType' => 'application/csv',
                'inline'   => false
            ]);
        }

        throw new NotFoundHttpException("Can't create the requested file.");
    }

    /**
     * View or Download QR Code
     *
     * @param int $id
     * @param int $size
     * @param int $margin
     * @param int $download
     * @throws \Exception
     */
    public function actionQrCode($id, $size = 200, $margin = 5, $download = 0)
    {
        $formModel = $this->findFormModel($id);

        $size = is_int($size) ? $size : 200;
        $margin = is_int($margin) ? $margin : 5;
        $download = $download > 0 ? 1 : 0;


        $text = Url::to(['app/forms', 'slug' => $formModel->slug], true);
        $qrCode = new QrCode($text);
        $qrCode
            ->setSize($size)
            ->setMargin($margin);
        $fileString = $qrCode->writeString();

        if ($download > 0) {
            return Yii::$app->response
                ->sendContentAsFile($fileString, sprintf("%s.%s", "qr-code", "png"), [
                    'inline' => true
                ]);
        }

        return Yii::$app->response
            ->sendContentAsFile($fileString, sprintf("%s.%s", "qr-code", "png"), [
                'mimeType' => 'image/png',
                'inline' => false
            ]);
    }

    /**
     * Download the Html Code.
     *
     * @param $id
     * @param int $js
     * @throws NotFoundHttpException
     */
    public function actionDownloadHtmlCode($id, $js = 1)
    {
        $this->layout = false;

        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;
        $formConfirmationModel = $formModel->formConfirmation;
        $filename  = !empty($formModel->slug) ? $formModel->slug . '.zip' : $formModel->id . '.zip';

        if (class_exists("ZipArchive")) {
            $zip = new \ZipArchive;
            $res = $zip->open($filename, \ZipArchive::CREATE);

            if ($res === TRUE) {

                // Brand
                $appName = Yii::$app->settings->get("app.name");
                $brandLabel = Html::tag("span", $appName, ["class" => "app-name"]);
                if ($logo = Yii::$app->settings->get("logo", "app", null)) {
                    $brandLabel = Html::img(Url::to('@web/'.$logo, true), [
                        'height' => '26px',
                        'alt' => $appName,
                        'title' => $appName,
                    ]);
                }

                $title = Html::a(
                    $brandLabel,
                    Url::home(true),
                    [
                        "title" => Yii::$app->settings->get("app.description"),
                        "style" => 'text-decoration:none',
                    ]
                );

                $form = Html::decode($formDataModel->html);

                // Add pagination
                $pager = new Pager($form);
                $form = $pager->getPaginatedData();

                // Add honeypot
                if ($formModel->honeypot === $formModel::HONEYPOT_ACTIVE) {
                    $honeypot = new Honeypot(Html::decode($form));
                    $form = $honeypot->getData();
                }

                // Add endpoint
                $endpoint = Url::to(['app/f', 'id' => $formModel->id], true);
                $form = str_ireplace(
                    "<form id=\"form-app\"",
                    "<form action=\"{$endpoint}\" method=\"post\" enctype=\"multipart/form-data\" accept-charset=\"UTF-8\" id=\"form-app\"",
                    $form
                );

                // Javascript code
                $scripts = '';
                $options = '';
                if ($js) {
                    /** @var $rules array Conditions and Actions of active rules */
                    $rules = [];
                    foreach ($formModel->formRules as $formRuleModel) {
                        $rule = [
                            'conditions' => $formRuleModel['conditions'],
                            'actions' => $formRuleModel['actions'],
                            'opposite' => (boolean) $formRuleModel['opposite'],
                        ];
                        array_push($rules, $rule);
                    }
                    // jQuery
                    $zip->addFile(Yii::getAlias('@app/static_files/js/libs/jquery.js'), 'js/libs/jquery.js');
                    $scripts .= '<script src="js/libs/jquery.js"></script>';
                    // Signature Pad
                    $zip->addFile(Yii::getAlias('@app/static_files/js/libs/signature_pad.umd.js'), 'js/libs/signature_pad.umd.js');
                    $scripts .= '<script src="js/libs/signature_pad.umd.js"></script>';
                    // reCAPTCHA
                    if ($formModel->recaptcha === Form::RECAPTCHA_ACTIVE && Yii::$app->settings->get('app.reCaptchaVersion') == 3) {
                        $recaptchaSiteKey = Yii::$app->settings->get('app.reCaptchaSiteKey');
                        $recaptchaUrl = sprintf("https://www.google.com/recaptcha/api.js?render=%s", $recaptchaSiteKey);
                        $scripts .= "<script src='{$recaptchaUrl}'></script>";
                        $scripts .= <<<HTML
<script>
$(document).ready(function() {
    var addTokenToForm = function (token) {
        $('#g-recaptcha-response').remove();
        grecaptcha.execute('{$recaptchaSiteKey}', {action: 'easy_forms'}).then(function(token) {
            $('<input>').attr({
                type: 'hidden',
                value: token,
                id: 'g-recaptcha-response',
                name: 'g-recaptcha-response'
            }).appendTo('form');
        });
    };
    grecaptcha.ready(function () {
        addTokenToForm();
    });
    formEl.on('error', function (event) {
        addTokenToForm();
    });
});
</script>
HTML;

                    } elseif ($formModel->recaptcha === Form::RECAPTCHA_ACTIVE) {
                        $scripts .= '<script src="https://www.google.com/recaptcha/api.js"></script>';
                        $scripts .= <<<HTML
<script>
$(document).ready(function() {
    formEl.on('error', function (event) {
    if (typeof grecaptcha !== 'undefined') {
        grecaptcha.reset();
    }
});
});
</script>
HTML;

                    }
                    // jQuery Form
                    $zip->addFile(Yii::getAlias('@app/static_files/js/libs/jquery.form.js'), 'js/libs/jquery.form.js');
                    $scripts .= '<script src="js/libs/jquery.form.js"></script>';
                    // jQuery Easing
                    if ($pager->getNumberOfPages() > 1) {
                        $zip->addFile(Yii::getAlias('@app/static_files/js/libs/jquery.easing.min.js'), 'js/libs/jquery.easing.min.js');
                        $scripts .= '<script src="js/libs/jquery.easing.min.js"></script>';
                    }
                    // Form Utilities
                    $zip->addFile(Yii::getAlias('@app/static_files/js/form.utils.min.js'), 'js/form.utils.min.js');
                    $scripts .= '<script src="js/form.utils.min.js"></script>';
                    // Form Resume
                    if ($formModel->resume) {
                        $zip->addFile(Yii::getAlias('@app/static_files/js/form.resume.min.js'), 'js/form.resume.min.js');
                        $scripts .= '<script src="js/form.resume.min.js"></script>';
                    }
                    if (count($rules) > 0) {
                        // Math.js
                        $zip->addFile(Yii::getAlias('@app/static_files/js/libs/math.min.js'), 'js/libs/math.min.js');
                        $scripts .= '<script src="js/libs/math.min.js"></script>';
                        $zip->addFile(Yii::getAlias('@app/static_files/js/form.evaluate.min.js'), 'js/form.evaluate.min.js');
                        $scripts .= '<script src="js/form.evaluate.min.js"></script>';
                        // Numeral.js
                        $zip->addFile(Yii::getAlias('@app/static_files/js/libs/numeral.min.js'), 'js/libs/numeral.min.js');
                        $scripts .= '<script src="js/libs/numeral.min.js"></script>';
                        $zip->addFile(Yii::getAlias('@app/static_files/js/libs/locales/numeral.min.js'), 'js/libs/locales/numeral.min.js');
                        $scripts .= '<script src="js/libs/locales/numeral.min.js"></script>';
                        // Rules Engine
                        $zip->addFile(Yii::getAlias('@app/static_files/js/rules.engine.min.js'), 'js/rules.engine.min.js');
                        $scripts .= '<script src="js/rules.engine.min.js"></script>';
                        $zip->addFile(Yii::getAlias('@app/static_files/js/rules.engine.run.min.js'), 'js/rules.engine.run.min.js');
                        $scripts .= '<script src="js/rules.engine.run.min.js"></script>';
                    }
                    // Form Tracker
                    $zip->addFile(Yii::getAlias('@app/static_files/js/form.tracker.js'), 'js/form.tracker.js');
                    // Form
                    $zip->addFile(Yii::getAlias('@app/static_files/js/form.embed.min.js'), 'js/form.embed.min.js');
                    $scripts .= '<script src="js/form.embed.min.js"></script>';
                    // Add custom js file after all
                    if (!empty($formModel->ui->js_file)) {
                        $scripts .= '<script src="'.$formModel->ui->js_file.'"></script>';
                    }

                    // PHP options required by embed.js
                    $options = array(
                        "id" => $formModel->id,
                        "app" => UrlHelper::removeScheme(Url::to(['/app'], true)),
                        "tracker" => "js/form.tracker.js",
                        "name" => "#form-app",
                        "actionUrl" => Url::to(['app/f', 'id' => $formModel->id], true),
                        "validationUrl" => Url::to(['app/check', 'id' => $formModel->id], true),
                        "_csrf" => Yii::$app->request->getCsrfToken(),
                        "resume" => $formModel->resume,
                        "text_direction" => $formModel->text_direction,
                        "autocomplete" => $formModel->autocomplete,
                        "novalidate" => $formModel->novalidate,
                        "analytics" => $formModel->analytics,
                        "confirmationType" => $formConfirmationModel->type,
                        "confirmationMessage" => false,
                        "confirmationUrl" => $formConfirmationModel->url,
                        "confirmationSeconds" => $formConfirmationModel->seconds,
                        "confirmationAppend" => $formConfirmationModel->append,
                        "confirmationAlias" => $formConfirmationModel->alias,
                        "showOnlyMessage" => FormConfirmation::CONFIRM_WITH_ONLY_MESSAGE,
                        "redirectToUrl" => FormConfirmation::CONFIRM_WITH_REDIRECTION,
                        "rules" => $rules,
                        "fieldIds" => $formDataModel->getFieldIds(),
                        "submitted" => false,
                        "runOppositeActions" => true,
                        "skips" => [],
                        "reCaptchaVersion" => Yii::$app->settings->get('app.reCaptchaVersion'),
                        "reCaptchaSiteKey" => Yii::$app->settings->get('app.reCaptchaSiteKey'),
                        "defaultValues" => false,
                        "i18n" => [
                            'complete' => Yii::t('app', 'Complete'),
                            'unexpectedError' => Yii::t('app', 'An unexpected error has occurred. Please retry later.'),
                        ]
                    );
                    // Pass php options to javascript
                    $options = "var options = ".json_encode($options).";";
                }

                // Add CSS Theme
                $css = '';
                if (!empty($formModel->theme->css)) {
                    $css .= "/*********** CSS Theme **********/"."\n";
                    $css .= <<<CSS
{$formModel->theme->css}
CSS;
                }

                // Add Form Design
                $stylesheet = Css::convertFormStyles($formDataModel->getStyles());
                $fonts = Css::getUsedGoogleFonts($stylesheet);
                $cssLinks = '';
                if ($formModel->text_direction === "rtl") {
                    $cssLinks .= Html::cssFile("css/bootstrap-rtl.min.css");
                }
                if (!empty($fonts)) {
                    $cssLinks .= Html::cssFile(sprintf('https://fonts.googleapis.com/css?family=%s', implode('|', $fonts)));
                }
                $css .= "/*********** Theme Designer **********/"."\n";
                $css .= Css::toCss($stylesheet, ".form-container");

                $htmlCode = <<<HTML
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{$formModel->name}</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  {$cssLinks}
  <link href="css/public.min.css" rel="stylesheet">
  <style>
  body { background-color: #EFF3F6; padding: 20px; }
  .legend { margin-top: 0 }
  .g-recaptcha { min-height: 78px; }
  .panel-body { padding: 5px; }
  .form-container { padding: 20px; border-radius: 0 0 4px 4px; }
    {$css}
  </style>
  <script>
  {$options}
  </script>
</head>
<body>
<div class="container">
    <div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
            <div class="form-view">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {$title}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-container">
                            <div id="messages"></div>
                            {$form}
                            <div id="progress" class="progress" style="display: none;">
                                <div id="bar" class="progress-bar" role="progressbar" style="width: 0;">
                                    <span id="percent" class="sr-only">0% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{$scripts}
</body>
</html>
HTML;

                $zip->addFromString('index.html', $htmlCode);
                $zip->addFile(Yii::getAlias('@app/static_files/css/bootstrap.min.css'), 'css/bootstrap.min.css');
                if ($formModel->text_direction === 'rtl') {
                    $zip->addFile(Yii::getAlias('@app/static_files/css/bootstrap-rtl.min.css'), 'css/bootstrap-rtl.min.css');
                }
                $zip->addFile(Yii::getAlias('@app/static_files/css/public.min.css'), 'css/public.min.css');
                $zip->close();

            } else {
                throw new NotFoundHttpException("Can't open {$filename}");
            }

            return Yii::$app->response->sendFile($filename)->on(Response::EVENT_AFTER_SEND, function($event) {
                unlink($event->data);
            }, $filename);

        }

        throw new NotFoundHttpException("Can't create {$filename}");
    }

    /**
     * Show form submissions report.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionReport($id = null)
    {
        $formModel = $this->findFormModel($id);
        $formDataModel = $formModel->formData;
        $charts = $formModel->getFormCharts()->asArray()->all();

        return $this->render('report', [
            'formModel' => $formModel,
            'formDataModel' => $formDataModel,
            'charts' => $charts
        ]);
    }

    /**
     * Finds the Form model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * If the user does not have access, a Forbidden Http Exception will be thrown.
     *
     * @param $id
     * @return Form
     * @throws NotFoundHttpException
     */
    protected function findFormModel($id)
    {
        if (($model = Form::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t("app", "The requested page does not exist."));
        }
    }

    /**
     * Disable Assets
     */
    private function disableAssets()
    {
        Yii::$app->assetManager->bundles['app\bundles\AppBundle'] = false;
        Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false;
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapPluginAsset'] = false;
        Yii::$app->assetManager->bundles['yii\web\YiiAsset'] = false;
    }
}
