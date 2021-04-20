<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.6.4
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\validators;

use Yii;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\validators\Validator;
use yii\validators\EmailValidator;
use yii\validators\ValidationAsset;
use yii\validators\PunycodeAsset;

/**
 * Class MultipleEmailValidator
 * @package app\components\validators
 *
 */
class MultipleEmailValidator extends Validator
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('app', 'This field has an invalid email address.');
        }
    }

    /**
     * Checks a comma separated list of e-mails which should invited.
     * E-Mails needs to be valid
     *
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $emails = explode(',', $value);
        if (count($emails) > 1) {
            foreach ($emails as $email) {
                $validator = new EmailValidator();
                if (!$validator->validate(trim($email))) {
                    $model->addError($attribute, Yii::t('app', '{email} is not a valid email address.', ['email' => $email]));
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return <<<JS
if (value.length > 0) {
    var {$attribute}_emails = value.split(",");
    var {$attribute}_regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if ({$attribute}_emails.length > 1) {
        for (var i = 0; i < {$attribute}_emails.length; i++) {
            if({$attribute}_emails[i] == "" || !{$attribute}_regex.test({$attribute}_emails[i].replace(/\s/g, ""))){
                messages.push($message);
            }
        }
    }
}
JS;
    }

}
