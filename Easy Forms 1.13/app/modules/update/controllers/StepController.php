<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\modules\update\controllers;

use Exception;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Cookie;
use yii\helpers\Url;
use yii\httpclient\Client;
use app\modules\update\helpers\SetupHelper;

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
        Yii::$app->language = isset(Yii::$app->request->cookies['language']) ?
            (string)Yii::$app->request->cookies['language'] : 'en-US';

        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->action->id != '1') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!Yii::$app->session->has('purchase_code')) {
                Yii::$app->session->setFlash('warning', Yii::t('update', 'Please enter a valid purchase code'));
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

    /**
     * Language selector
     *
     * @return string
     */
    public function action1()
    {
        if (Yii::$app->request->post('language')) {

            $language = Yii::$app->request->post('language');
            Yii::$app->language = $language;

            $languageCookie = new Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 60 * 60 * 24, // 1 day
            ]);

            Yii::$app->response->cookies->add($languageCookie);

            $purchaseCode = Yii::$app->request->post('purchase_code', '');

            if (trim($purchaseCode) == '') {
                Yii::$app->session->setFlash('warning', Yii::t('update', 'Please enter a valid purchase code'));
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
                            Yii::$app->session->setFlash('warning', Yii::t('update', 'Your license is activated on another site.'));
                        } else {
                            Yii::$app->session->setFlash('warning', Yii::t('update', 'Please enter a valid purchase code'));
                        }
                        return $this->redirect(['step/1']);
                    }
                }

            } catch (Exception $e) {
                Yii::error($e);
                Yii::$app->session->setFlash('warning', Yii::t('update', 'This server does not meet the minimum requirements for updating the software.'));
                return $this->redirect(['step/1']);
            }

        }

        return $this->render('1');
    }

    /**
     * Requirements
     *
     * @return string
     */
    public function action2()
    {
        return $this->render('2');
    }

    /**
     * Run update
     *
     * @return string
     */
    public function action3()
    {
        return $this->render('3');
    }

    /**
     * Run Migrations vía ajax request
     *
     * @return int|string
     */
    public function action4()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return SetupHelper::runMigrations();
        }

        return '';
    }

    /**
     * Congratulations
     *
     * @return string
     */
    public function action5()
    {
        // Update DB version
        Yii::$app->settings->set('app.version', Yii::$app->version);

        return $this->render('5');
    }
}
