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

namespace app\modules\addons\controllers;

use app\models\User;
use app\modules\addons\models\AddonUser;
use app\modules\addons\models\AddonUserRole;
use Yii;
use Exception;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\helpers\FileHelper;
use app\components\database\Migration;
use app\modules\addons\models\Addon;
use app\modules\addons\models\AddonSearch;
use app\modules\addons\helpers\SetupHelper;

/**
 * DefaultController implements the CRUD actions for Addon model.
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
                    ['actions' => ['index'], 'allow' => true, 'roles' => ['viewAddons'], 'roleParams' => ['listing' => true]],
                    ['actions' => ['refresh'], 'allow' => true, 'roles' => ['refreshAddons'], 'roleParams' => ['listing' => true]],
                    ['actions' => ['settings'], 'allow' => true, 'roles' => ['configureAddons'], 'roleParams' => function() {
                        return ['model' => Addon::findOne(['id' => Yii::$app->request->get('id')])];
                    }],
                    ['actions' => ['update-status'], 'allow' => true, 'roles' => ['configureAddons'], 'roleParams' => function() {
                        return ['modelClass' => Addon::className(), 'ids' => Yii::$app->request->post('ids')];
                    }],
                    ['actions' => ['install'], 'allow' => true, 'roles' => ['installAddons'], 'roleParams' => function() {
                        return ['modelClass' => Addon::className(), 'ids' => Yii::$app->request->post('ids')];
                    }],
                    ['actions' => ['uninstall'], 'allow' => true, 'roles' => ['uninstallAddons'], 'roleParams' => function() {
                        return ['modelClass' => Addon::className(), 'ids' => Yii::$app->request->post('ids')];
                    }],
                ],
            ],
        ];
    }

    /**
     * List of all Add-ons.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AddonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Addon model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionSettings($id)
    {
        $model = $this->findModel($id);

        // Select id & name of all other users
        $users = User::find()->select(['id', 'username'])->asArray()->all();
        $users = ArrayHelper::map($users, 'id', 'username');
        // Select id & name of addon users
        $addonUsers = ArrayHelper::map($model->users, 'id', 'username');

        // Selet name & description of all user roles
        $roles = Yii::$app->authManager->getRoles();
        $roles = ArrayHelper::map($roles, 'name', 'description');
        // Select role_id of addon roles
        $addonRoles = ArrayHelper::getColumn($model->addonRoles, 'role_id');

        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->save()) {

            if (Yii::$app->user->can('shareAddons', ['model' => $model])) {
                // Remove old addon users
                AddonUser::deleteAll(['addon_id' => $model->id]);
                // Save addon users
                if (Addon::SHARED_WITH_USERS === (int) $model->shared
                    && isset($postData['Addon']['users'])) {
                    $users = $postData['Addon']['users'];
                    if (is_array($users)) {
                        foreach ($users as $user_id) {
                            $addonUser = new AddonUser();
                            $addonUser->addon_id = $model->id;
                            $addonUser->user_id = $user_id;
                            $addonUser->save();
                        }
                    }
                }
            }

            // Remove old addon user roles
            AddonUserRole::deleteAll(['addon_id' => $model->id]);
            // Save addon user roles
            if (Addon::SHARED_WITH_USERS === (int) $model->shared
                && isset($postData['Addon']['roles'])) {
                $roles = $postData['Addon']['roles'];
                if (is_array($roles)) {
                    foreach ($roles as $role_id) {
                        $addonUserRole = new AddonUserRole();
                        $addonUserRole->addon_id = $model->id;
                        $addonUserRole->role_id = $role_id;
                        $addonUserRole->save();
                    }
                }
            }

            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'The add-on has been successfully configured.'));

            return $this->redirect(['index']);
        }

        return $this->render('settings', [
            'model' => $model,
            'users' => $users,
            'roles' => $roles,
            'addonUsers' => $addonUsers,
            'addonRoles' => $addonRoles,
        ]);

    }

    /**
     * Reload index action
     *
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionRefresh()
    {
        try {
            $this->refreshAddOnsList();

            // Show success alert
            Yii::$app->getSession()->setFlash('success', Yii::t(
                'addon',
                'The Add-ons list has been refreshed successfully.'
            ));

        } catch (Exception $e) {
            Yii::error($e);
            // Show success alert
            Yii::$app->getSession()->setFlash('danger', Yii::t(
                'addon',
                $e->getMessage()
            ));
        }

        return $this->redirect(['index']);
    }

    /**
     * Add / Remove Add-Ons automatically.
     *
     * @throws InvalidConfigException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    protected function refreshAddOnsList()
    {

        // Absolute path to addOns directory
        $addOnsDirectory = Yii::getAlias('@addons');

        // Each sub-directory name is an addOn id
        $addOns = FileHelper::scandir($addOnsDirectory);

        $installedAddOns = ArrayHelper::map(Addon::find()->select(['id','id'])->asArray()->all(), 'id', 'id');
        $newAddOns = array_diff($addOns, $installedAddOns);
        $removedAddOns = array_diff($installedAddOns, $addOns);

        // Uninstall removed addOns
        SetupHelper::uninstall($removedAddOns);

        // Install new addOns
        SetupHelper::install($newAddOns);

        // Update addOns versions
        SetupHelper::update($installedAddOns);

    }

    /**
     * Enable / Disable multiple Add-ons
     *
     * @param $status
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdateStatus($status)
    {

        $addOns = Addon::findAll(['id' => Yii::$app->getRequest()->post('ids')]);

        if (empty($addOns)) {
            throw new NotFoundHttpException(Yii::t('addon', 'Page not found.'));
        } else {
            foreach ($addOns as $addOn) {
                $addOn->status = $status;
                $addOn->update();
            }
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('addon', 'The selected items have been successfully updated.')
            );
            return $this->redirect(['index']);
        }
    }

    /**
     * Run DB Migration Up
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionInstall()
    {
        $addOns = Addon::findAll(['id' => Yii::$app->getRequest()->post('ids')]);

        if (empty($addOns)) {

            throw new NotFoundHttpException(Yii::t('addon', 'Page not found.'));

        } else {

            // Flag
            $success = true;

            foreach ($addOns as $addOn) {
                try {
                    $migrationPath = Yii::getAlias('@addons') . DIRECTORY_SEPARATOR . $addOn->id . DIRECTORY_SEPARATOR .
                        'migrations';
                    $migrationTable = "{{%migration_{$addOn->id}}}";

                    if (is_dir($migrationPath) && $success) { // Stop next migrations
                        // Flush cache
                        Yii::$app->cache->flush();
                        // Run DB Migration
                        $migration = new Migration();
                        $migration->migrationPath = $migrationPath;
                        $migration->migrationTable = $migrationTable;
                        $migration->compact = true;
                        $r = $migration->up();
                        // Flag
                        $success = ($r === Migration::DONE) || ($r === Migration::NO_NEW_MIGRATION);

                    } else {
                        throw new Exception("There is an error with the migration path:" . $migrationPath);
                    }
                } catch (Exception $e) {
                    // Update flag
                    $success = false;
                    // Log error
                    Yii::error($e, __METHOD__);
                }

                if ($success) {
                    // Update Add-On Status
                    $addOn->status = $addOn::STATUS_ACTIVE;
                    $addOn->installed = $addOn::INSTALLED_ON;
                    $addOn->update();
                }

            }

            if ($success) {
                // Display success message
                Yii::$app->getSession()->setFlash(
                    'success',
                    Yii::t('addon', 'The selected items have been installed successfully.')
                );
            } else {
                // Display error message
                Yii::$app->getSession()->setFlash(
                    'danger',
                    Yii::t('addon', 'An error has occurred while installing your add-ons.')
                );
            }

            return $this->redirect(['index']);
        }
    }

    /**
     * Run DB Migration Down
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUninstall()
    {
        $addOns = Addon::findAll(['id' => Yii::$app->getRequest()->post('ids')]);

        if (empty($addOns)) {
            throw new NotFoundHttpException(Yii::t('addon', 'Page not found.'));
        } else {
            // Flag
            $success = true;
            foreach ($addOns as $addOn) {
                try {
                    $migrationPath = Yii::getAlias('@addons') . DIRECTORY_SEPARATOR . $addOn->id . DIRECTORY_SEPARATOR .
                        'migrations';
                    $migrationTable = "{{%migration_{$addOn->id}}}";

                    if (is_dir($migrationPath) && $success) { // Stop next migration
                        // Flush cache
                        Yii::$app->cache->flush();
                        // Run DB Migration
                        $migration = new Migration();
                        $migration->migrationPath = $migrationPath;
                        $migration->migrationTable = $migrationTable;
                        $migration->compact = true;
                        $r = $migration->down('all');
                        // Flag
                        $success = ($r === Migration::DONE) || ($r === Migration::NO_NEW_MIGRATION);
                    } else {
                        throw new Exception("There is an error with the migration path:" . $migrationPath);
                    }
                } catch (Exception $e) {
                    // Update flag
                    $success = false;
                    // Log error
                    Yii::error($e);
                }

                if ($success) {
                    $addOn->status = $addOn::STATUS_INACTIVE;
                    $addOn->installed = $addOn::INSTALLED_OFF;
                    $addOn->update();
                }

            }
            if ($success) {
                // Display success message
                Yii::$app->getSession()->setFlash(
                    'success',
                    Yii::t('addon', 'The selected items have been uninstalled successfully.')
                );
            } else {
                // Display error message
                Yii::$app->getSession()->setFlash(
                    'danger',
                    Yii::t('addon', 'An error has occurred while uninstalling your add-ons.')
                );
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Addon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Addon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Addon::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t("app", "The requested page does not exist."));
        }
    }
}
