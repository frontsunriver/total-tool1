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

namespace app\modules\addons\modules\webhooks;

use app\helpers\ArrayHelper;
use app\helpers\SlugHelper;
use app\models\Form;
use app\models\FormData;
use app\modules\addons\EventManagerInterface;
use app\modules\addons\modules\webhooks\models\Webhook;
use Exception;
use Yii;
use yii\httpclient\Client;

class Module extends \yii\base\Module implements EventManagerInterface
{

    public $id = "webhooks";
    public $defaultRoute = 'admin/index';
    public $controllerLayout = '@app/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Set up i8n of this add-on
        if (empty(Yii::$app->i18n->translations['webhooks'])) {
            Yii::$app->i18n->translations['webhooks'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@addons/webhooks/messages',
                //'forceTranslation' => true,
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function attachGlobalEvents()
    {
        return [
            'app.form.submission.accepted' => function ($event) {
                $this->sendSubmissionData($event);
            }
        ];
    }

    /**
     * @inheritdoc
     */
    public function attachClassEvents()
    {
        return [];
    }

    /**
     * Send the form submission data through an HTTP POST request
     * either as URL encoded form data or as a JSON string
     * depending on the format selected in the Webhook configuration
     *
     * @param $event
     */
    public function sendSubmissionData($event)
    {

        if (isset($event, $event->form, $event->form->id, $event->submission, $event->filePaths)) {

            try {
                /** @var Form $formModel */
                $formModel = $event->form;
                /** @var FormData $formDataModel */
                $formDataModel = $formModel->formData;

                $webhooks = Webhook::findAll(['form_id' => $formModel->id, 'status' => 1]);

                $client = new Client([
                    'transport' => 'yii\httpclient\CurlTransport'
                ]);
                $body = $event->submission->getSubmissionData();

                foreach ($webhooks as $webhook) {
                    // Replace field ID by field alias
                    if ($webhook->alias === 1) {
                        $aliases = $formDataModel->getAlias();
                        foreach ($aliases as $key => $alias) {
                            if (!empty($alias)) {
                                ArrayHelper::replaceKey($body, $key, SlugHelper::slug($alias, [
                                    'delimiter' => '_',
                                ]));
                            }
                        }
                    }

                    // Add Handshake Key
                    if (!empty($webhook->handshake_key)) {
                        $body = $body + ['handshake_key' => $webhook->handshake_key];
                    }

                    // Header
                    $headers = ['User-Agent' => Yii::$app->name];
                    // Format
                    $format = Client::FORMAT_URLENCODED;

                    // Add Json Format
                    if ($webhook->json === 1) {
                        $headers['content-type'] = 'application/json';
                        $format = Client::FORMAT_JSON;
                    }

                    // Send HTTP POST request
                    $client->createRequest()
                        ->setMethod('POST')
                        ->setFormat($format)
                        ->setUrl($webhook->url)
                        ->addHeaders($headers)
                        ->setData($body)
                        ->setOptions([
                            CURLOPT_SSL_VERIFYHOST => 0,
                            CURLOPT_SSL_VERIFYPEER => 0
                        ])
                        ->send();
                }

            } catch (Exception $e) {
                // Log error
                Yii::error($e);
            }
        }
    }
}
