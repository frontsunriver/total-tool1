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

namespace app\modules\update;

use Yii;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'step/1';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function () {
                            // For DB versions lower than 1.10
                            Yii::$app->settings->clearCache();
                            if (!Yii::$app->settings->get('version', 'app', false)) {
                                return true;
                            } else {
                                // Permission required: Perform application updates
                                if (Yii::$app->user->can("performUpdates")) {
                                    return true;
                                }
                            }

                            // By Default, Denied Access
                            return false;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set up i8n
        if (empty(Yii::$app->i18n->translations['update'])) {
            Yii::$app->i18n->translations['update'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@app/modules/update/messages',
                //'forceTranslation' => true,
            ];
        }

    }
}
