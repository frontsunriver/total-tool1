<?php
/**
 * @copyright Copyright (c) 2014 HimikLab
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @link https://github.com/himiklab/yii2-recaptcha-widget
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace app\components\validators;

use Yii;
use yii\validators\Validator;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

class RecaptchaValidator extends Validator
{
    const SITE_VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const CAPTCHA_RESPONSE_FIELD = 'g-recaptcha-response';

    /** @inheritdoc */
    public $skipOnEmpty = false;
    /** @var string */
    public $emptyMessage;
    /** @inheritdoc */
    public $message;
    /** @var string The shared key between your site and ReCAPTCHA. */
    public $secret;

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->emptyMessage = Yii::t('app', 'The captcha is a required field.');
        $this->message = Yii::t('app', 'The captcha code you entered was incorrect.');

        if (empty($this->secret)) {
            $this->secret = Yii::$app->settings->get("app.reCaptchaSecret");
            if (empty($this->secret)) {
                throw new InvalidConfigException(Yii::t('app', 'ReCaptcha Secret Key is empty.'));
            }
        }
    }

    /**
     * @param string $value
     * @return array|null
     * @throws \Exception
     */
    protected function validateValue($value)
    {
        if (empty($value)) {
            return [$this->emptyMessage, []];
        }
        $response = $this->getResponse([
            'secret' => $this->secret,
            'response' => $value,
            'remoteip' => Yii::$app->request->userIP
        ]);
        if (!isset($response['success'])) {
            throw new \Exception(Yii::t('app', 'Invalid reCAPTCHA verification response.'));
        }

        // Save reCaptcha response in session
        Yii::$app->session['reCaptcha'] = $response['success'];

        return $response['success'] ? null : [$this->message, []];
    }

    /**
     * @param string $request
     * @return mixed
     */
    protected function getResponse($data)
    {
        if (function_exists('curl_version')) {
            $verify = curl_init();
            curl_setopt($verify, CURLOPT_URL, self::SITE_VERIFY_URL);
            curl_setopt($verify, CURLOPT_POST, true);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
            defined('CURLOPT_SSL_VERIFYPEER') or define('CURLOPT_SSL_VERIFYPEER', 64);
            curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($verify);
        } else {
            $response = file_get_contents(self::SITE_VERIFY_URL . '?' . http_build_query($data, '', '&'));
        }

        return Json::decode($response, true);
    }
}
