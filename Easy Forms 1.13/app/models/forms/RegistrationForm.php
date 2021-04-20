<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\models\forms;

use Da\User\Form\RegistrationForm as BaseForm;
use Yii;

class RegistrationForm extends BaseForm
{
    /**
     * @var string
     */
    public $captcha;

    /**
     * @var integer
     */
    public $subscription_plan;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // Compatibility with Subscription module
        $this->subscription_plan = Yii::$app->request->get('p');
    }

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = parent::rules();

        // Compatibility with Subscription module
        $rules[] = ['subscription_plan', 'integer'];

        if (Yii::$app->settings->get('app.useCaptcha')) {
            $rules[] = ['captcha', 'required'];
            $rules[] = ['captcha', 'captcha', 'captchaAction'=>'user/registration/captcha'];
        }

        return $rules;
    }
}