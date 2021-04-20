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

namespace app\modules\setup\controllers;

use app\modules\setup\helpers\SetupHelper;
use app\modules\setup\models\forms\DbForm;
use app\modules\setup\models\forms\UserForm;
use Exception;
use Yii;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Response;

class StepController extends Controller
{
    public $layout = 'setup';

    private $activatePurchaseCode;

    private $activateDomain;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        Yii::$app->language = isset(Yii::$app->request->cookies['language']) ? (string)Yii::$app->request->cookies['language'] : 'en-US';

        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->action->id != '1') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if (!Yii::$app->session->has('purchase_code')) {
                Yii::$app->session->setFlash('warning', Yii::t('setup', 'Please enter a valid purchase code'));
                $this->redirect(['step/1']);
                return false;
            }
        }

        $this->activateDomain = Url::home(true);
        $this->activatePurchaseCode = base64_decode(SetupHelper::$purchaseCode);

        return true; // or false to not run the action
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function action1()
    {
        if ($language = Yii::$app->request->post('language')) {

            Yii::$app->language = $language;

            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24, // 1 day
            ]);

            Yii::$app->response->cookies->add($languageCookie);

            $purchaseCode = Yii::$app->request->post('purchase_code', '');

            if (trim($purchaseCode) == '') {
                Yii::$app->session->setFlash('warning', Yii::t('setup', 'Please enter a valid purchase code'));
                return $this->redirect(['step/1']);
            }

            try {

                $client = new Client([
                    'transport' => 'yii\httpclient\CurlTransport'
                ]);

                // Send HTTP POST request
                $response = $client->createRequest()
                    ->setMethod('POST')
                    ->setUrl($this->activatePurchaseCode)
                    ->addHeaders(['User-Agent' => Yii::$app->name])
                    ->setData([
                        'purchase_code' => $purchaseCode,
                        'home_url' => $this->activateDomain,
                    ])
                    ->setOptions([
                        CURLOPT_SSL_VERIFYHOST => 0,
                        CURLOPT_SSL_VERIFYPEER => 0
                    ])
                    ->send();

                // Process response
                if ($response->isOk) {
                    $status = $response->data['status'];
                    $message = !empty($response->data['message']) ? $response->data['message'] : '';
                    $homeUrl = !empty($response->data['home_url']) ? $response->data['home_url'] : '';
                    if ($status == 1) {
                        SetupHelper::createLicenseKeyConfigFile([
                            'license_key' => base64_encode($purchaseCode),
                        ]);
                        Yii::$app->session->set('purchase_code', $purchaseCode);
                        if (!empty($message)) {
                            Yii::$app->session->setFlash('success', $message);
                        }
                        return $this->redirect(['step/2']);
                    } elseif ($status == 0) {
                        if (Yii::$app->session->has('purchase_code')) {
                            Yii::$app->session->remove('purchase_code');
                        }
                        if (!empty($message)) {
                            Yii::$app->session->setFlash('warning', $message);
                        } elseif (!empty($homeUrl) && $homeUrl != Url::home(true)) {
                            Yii::$app->session->setFlash('warning', Yii::t('setup', 'Your license is activated on another site.'));
                        } else {
                            Yii::$app->session->setFlash('warning', Yii::t('setup', 'Please enter a valid purchase code'));
                        }
                        return $this->redirect(['step/1']);
                    }
                }

            } catch (Exception $e) {
                Yii::error($e);
                Yii::$app->session->setFlash('warning', Yii::t('setup', 'This server does not meet the minimum requirements for installing the software. Please contact us.'));
                return $this->redirect(['step/1']);
            }

        }

        return $this->render('1');
    }

    public function action2()
    {
        return $this->render('2');
    }

    public function action3()
    {
        $dbForm = new DbForm();
        $connectionOk = false;

        if ($dbForm->load(Yii::$app->request->post()) && $dbForm->validate()) {
            if ($dbForm->test()) {
                if (isset($_POST['test'])) {
                    $config = SetupHelper::createDatabaseConfig($dbForm->getAttributes());
                    if (SetupHelper::createDatabaseConfigFile($config) === true) {
                        $connectionOk = true;
                        Yii::$app->session->setFlash('success', Yii::t('setup', 'Database connection - ok'));
                    }
                }
                if (isset($_POST['save'])) {
                    $config = SetupHelper::createDatabaseConfig($dbForm->getAttributes());
                    if (SetupHelper::createDatabaseConfigFile($config) === true) {
                        Yii::$app->db->schema->refresh();
                        $tableNames = Yii::$app->db->schema->getTableNames();
                        if (count($tableNames) > 35) {
                            $tableName = Yii::$app->db->tablePrefix . 'auth_assignment'; // Check auth table
                            if (Yii::$app->db->getTableSchema($tableName, true) === null) {
                                Yii::$app->session->setFlash('danger', Yii::t('setup', 'Database is not properly installed. Drop all the tables and run this script again.'));
                            } else {
                                Yii::$app->session->setFlash('success', Yii::t('setup', 'Database was manually installed.'));
                                return $this->redirect(['step/5']);
                            }
                        } else {
                            return $this->render('4');
                        }
                    } else {
                        Yii::$app->session->setFlash('warning', Yii::t('setup', 'Unable to create db config file'));
                    }
                }
            }
        }

        return $this->render('3', ['model' => $dbForm, 'connectionOk' => $connectionOk]);
    }

    public function action4()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $result = [
                'success' => 0,
            ];

            // Run SQL file when MySQL is +5.7 and table prefix is empty
            if (version_compare(Yii::$app->db->getServerVersion(),5.7) > -1
                && empty(Yii::$app->db->tablePrefix)) {
                $result = SetupHelper::executeSqlCommands();
            }

            // Check if database was successfully installed
            if (isset($result['success']) && $result['success'] === 0) {
                $result = SetupHelper::runMigrations();
            }

            return $result;
        }

        return '';
    }

    public function action5()
    {
        $userForm = new UserForm();

        if ($userForm->load(Yii::$app->request->post()) && $userForm->save()) {
            return $this->redirect(['step/6']);
        }

        return $this->render('5', [
            'model' => $userForm,
        ]);
    }

    public function action6()
    {
        // With Friendly Urls
        $cronUrl = Url::home(true) . 'cron?cron_key='.Yii::$app->params['App.Cron.cronKey'];

        try {
            $client = new Client();
            $response = $client->get($cronUrl)->send();

            if ($response->getContent() !== '') {
                // Without Friendly Urls
                $url = Url::to([
                    '/cron',
                    'cron_key' => Yii::$app->params['App.Cron.cronKey'],
                ], true);
                $cronUrl = str_replace("install","index", $url);
            }
        } catch (Exception $e) {
            if (defined('YII_DEBUG') && YII_DEBUG) {
                throw $e;
            }
        }

        return $this->render('6', [
            'cronUrl' => $cronUrl
        ]);
    }
}
