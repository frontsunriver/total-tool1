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
use app\models\Form;
use app\models\search\ThemeSearch;
use app\models\Theme;
use app\models\ThemeUser;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ThemeController
 * @package app\controllers
 */
class ThemeController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-multiple' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['index'], 'allow' => true, 'roles' => ['viewThemes'], 'roleParams' => ['listing' => true]],
                    ['actions' => ['view'], 'allow' => true, 'roles' => ['viewThemes'], 'roleParams' => function() {
                        return ['model' => Theme::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createThemes']],
                    ['actions' => ['update'], 'allow' => true, 'roles' => ['updateThemes'], 'roleParams' => function() {
                        return ['model' => Theme::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['copy'], 'allow' => true, 'roles' => ['copyThemes'], 'roleParams' => function() {
                        return ['model' => Theme::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['delete'], 'allow' => true, 'roles' => ['deleteThemes'], 'roleParams' => function() {
                        return ['model' => Theme::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['delete-multiple'], 'allow' => true, 'roles' => ['deleteThemes'], 'roleParams' => function() {
                        return ['modelClass' => Theme::className(), 'ids' => Yii::$app->request->post('ids')];
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
                'modelClass' => 'app\models\Theme',
                'afterDeleteCallback' => function () {
                    Yii::$app->getSession()->setFlash(
                        'success',
                        Yii::t('app', 'The selected items have been successfully deleted.')
                    );
                },
            ],
        ];
    }

    /**
     * Lists all Theme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Theme model.
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
     * Creates a new Theme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Theme();
        /** @var \app\components\User $currentUser */
        $currentUser = Yii::$app->user;
        $forms = $currentUser->forms()->asArray()->all();

        // Select id & name of all users
        $users = User::find()->select(['id', 'username'])->asArray()->all();
        $users = ArrayHelper::map($users, 'id', 'username');
        // Select id & name of theme users
        $themeUsers = ArrayHelper::map($model->users, 'id', 'username');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // Save theme users
            if (Theme::SHARED_WITH_USERS === (int) $model->shared
                && isset($postData['Theme']['users'])) {
                $users = $postData['Theme']['users'];
                if (is_array($users)) {
                    foreach ($users as $user_id) {
                        $themeUser = new ThemeUser();
                        $themeUser->theme_id = $model->id;
                        $themeUser->user_id = $user_id;
                        $themeUser->save();
                    }
                }
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The theme has been successfully created.'));

            return $this->redirect(['index']);

        }

        return $this->render('create', [
            'model' => $model,
            'forms' => $forms,
            'users' => $users,
            'themeUsers' => $themeUsers,
        ]);
    }

    /**
     * Updates an existing Theme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        /** @var \app\components\User $currentUser */
        $currentUser = Yii::$app->user;
        $forms = $currentUser->forms()->asArray()->all();

        // Select id & name of all other users
        $users = User::find()->select(['id', 'username'])->asArray()->all();
        $users = ArrayHelper::map($users, 'id', 'username');
        // Select id & name of form users
        $themeUsers = ArrayHelper::map($model->users, 'id', 'username');

        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->save()) {

            if (Yii::$app->user->can('shareThemes', ['model' => $model])) {
                // Remove old theme users
                ThemeUser::deleteAll(['theme_id' => $model->id]);
                // Save theme users
                if (Theme::SHARED_WITH_USERS === (int) $model->shared
                    && isset($postData['Theme']['users'])) {
                    $users = $postData['Theme']['users'];
                    if (is_array($users)) {
                        foreach ($users as $user_id) {
                            $themeUser = new ThemeUser();
                            $themeUser->theme_id = $model->id;
                            $themeUser->user_id = $user_id;
                            $themeUser->save();
                        }
                    }
                }
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The theme has been successfully updated.'));

            if (isset($postData['continue'])) {
                return $this->refresh();
            }

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'forms' => $forms,
            'users' => $users,
            'themeUsers' => $themeUsers,
        ]);

    }

    /**
     * Copy an existing Theme model
     * If the copy is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionCopy($id)
    {
        // Source
        $model = $this->findModel($id);

        $transaction = Form::getDb()->beginTransaction();

        try {

            // Form
            $theme = new Theme();
            $theme->attributes = $model->attributes;
            $theme->name = $model->name . ' Copy';
            $theme->id = null;
            $theme->isNewRecord = true;
            $theme->save();

            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The theme has been successfully copied'));

            $transaction->commit();

        } catch(\Exception $e) {

            $transaction->rollBack();
            Yii::$app->getSession()->setFlash('danger', Yii::t('app', 'There was an error copying your theme.'));

        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Theme model.
     * If the delete is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The theme has been successfully deleted.'));

        return $this->redirect(['index']);
    }

    /**
     * Finds the Theme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Theme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Theme::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t("app", "The requested page does not exist."));
        }
    }
}
