<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.9.2
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
namespace app\controllers\user;

use Da\User\Controller\SecurityController as BaseSecurityController;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class SecurityController
 * @package app\controllers\user
 */
class SecurityController extends BaseSecurityController
{

    public $layout = "public";

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if ($action->id === 'login') {
            // Validate IP Address
            $ip = Yii::$app->getRequest()->getUserIP();
            $validIps = isset(Yii::$app->params['App.User.validIps']) ? Yii::$app->params['App.User.validIps'] : false;
            if ($validIps && is_array($validIps) && count($validIps) > 0 && !in_array($ip, $validIps)) {
                throw new NotFoundHttpException("The requested page does not exist.");
            }
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        // other custom code here

        return true; // or false to not run the action
    }
}