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

namespace app\modules\addons\modules\google_analytics\controllers;

use app\components\User;
use app\helpers\ArrayHelper;
use app\models\Form;
use app\modules\addons\modules\google_analytics\models\Account;
use app\modules\addons\modules\google_analytics\models\AccountSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for Ga model.
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['index'], 'allow' => true, 'roles' => ['configureFormsWithAddons'], 'roleParams' => function() {
                        return ['listing' => true];
                    }],
                    ['actions' => ['create'], 'allow' => true, 'matchCallback' => function ($rule, $action) {
                        if (Yii::$app->request->isGet && Yii::$app->user->can('configureFormsWithAddons', ['listing' => true])) {
                            return true;
                        } elseif ($postData = Yii::$app->request->post('Account')) {
                            if (!empty($postData['form_id']) ) {
                                return ['model' => Form::findOne(['id' => $postData['form_id']])];
                            }
                        }
                        return false;
                    }],
                    ['actions' => ['view', 'update', 'delete'], 'allow' => true, 'roles' => ['configureFormsWithAddons'], 'roleParams' => function() {
                        $account = $this->findModel(Yii::$app->request->get('id'));
                        return ['model' => $account->form];
                    }],
                    ['actions' => ['update-status', 'delete-multiple'], 'allow' => true, 'roles' => ['configureFormsWithAddons'], 'roleParams' => function() {
                        $accounts = Account::find()
                            ->where(['in', 'id', Yii::$app->request->post('ids')])
                            ->asArray()->all();
                        $ids = ArrayHelper::getColumn($accounts, 'form_id');
                        return ['modelClass' => Form::className(), 'ids' => $ids];
                    }],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'delete-multiple' => [
                'class' => 'app\components\actions\DeleteMultipleAction',
                'modelClass' => 'app\modules\addons\modules\google_analytics\models\Account',
                'afterDeleteCallback' => function () {
                    Yii::$app->getSession()->setFlash(
                        'success',
                        Yii::t('google_analytics', 'The selected items have been successfully deleted.')
                    );
                },
            ],
        ];
    }

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('google_analytics', 'The form tracking has been successfully created.')
            );

            return $this->redirect(['index']);
        }

        /** @var User $currentUser */
        $currentUser = Yii::$app->user;
        $forms = $currentUser->forms()->orderBy('updated_at DESC')->asArray()->all();
        $forms = ArrayHelper::map($forms, 'id', 'name');

        return $this->render('create', [
            'model' => $model,
            'forms' => $forms,
        ]);
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('google_analytics', 'The form tracking has been successfully updated.')
            );
            return $this->redirect(['index']);
        }

        /** @var User $currentUser */
        $currentUser = Yii::$app->user;
        $forms = $currentUser->forms()->orderBy('updated_at DESC')->asArray()->all();
        $forms = ArrayHelper::map($forms, 'id', 'name');

        return $this->render('update', [
            'model' => $model,
            'forms' => $forms,
        ]);
    }

    /**
     * Enable / Disable multiple Google Analytics Accounts
     *
     * @param $status
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdateStatus($status)
    {
        $models = Account::findAll(['id' => Yii::$app->getRequest()->post('ids')]);

        if (empty($models)) {
            throw new NotFoundHttpException(Yii::t('google_analytics', 'Page not found.'));
        } else {
            foreach ($models as $model) {
                $model->status = $status;
                $model->update();
            }
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('google_analytics', 'The selected items have been successfully updated.')
            );
            return $this->redirect(['index']);
        }
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->getSession()->setFlash('success', Yii::t('google_analytics', 'The form tracking has been successfully deleted.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
