<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.8
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\sendinblue\services;

use InvalidArgumentException;
use yii\helpers\Json;

/**
 * Class SendinBlueService
 * @package app\components\sendinblue\services
 */
class SendinBlueService
{

    /** @var string Api Key */
    protected $apiKey;

    /** @var string Base Url */
    protected $baseUrl = "https://api.sendinblue.com/v3";

    /** @var string Response Format */
    protected $returnFormat = "json";

    /** @var bool Check Header */
    protected $checkHeader = true;

    /** @var bool Throw Exceptions */
    protected $throwExceptions = true;

    /** @var bool Header */
    protected $header = false;

    /** @var bool Error */
    protected $error = false;

    /**
     * SendinBlueService constructor.
     * @param $apiKey
     * @throws InvalidArgumentException
     */
    public function __construct($apiKey)
    {
        if (empty($apiKey)) {
            throw new InvalidArgumentException('The Sendinblue Api Key is empty.');
        }
        $this->apiKey = $apiKey;
    }

    /**
     * Send a transactional email
     *
     * @param $message
     * @return array
     * @throws SendinBlueException
     */
    public function send($message)
    {
        $message = is_array($message) ? Json::encode($message) : $message;
        $options = [
            CURLOPT_URL => $this->baseUrl . "/smtp/email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => array(
                "api-key: $this->apiKey",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $message,
            CURLINFO_HEADER_OUT => true,
        ];
        return (array) $this->request($options);
    }

    /**
     * Return formatted response according to settings
     *
     * @param $in
     * @param bool $header
     * @return mixed|null
     * @throws SendinBlueException
     */
    protected function response($in, $header = false)
    {
        $this->header = $header;

        if ($this->checkHeader && isset($header["http_code"])) {
            if ($header["http_code"] < 200 || $header["http_code"] >= 300) {
                //error!?
                $this->error = $in;
                $message = var_export($in, true);
                if ($tmp = json_decode($in)) {
                    if (isset($tmp->message)) {
                        $message = $tmp->message;
                    }
                }
                if ($this->throwExceptions) {
                    throw new SendinBlueException($header["http_code"], sprintf("Sendinblue: %s", $message));
                }
                $in = null;

            }

        }

        switch ($this->returnFormat) {
            case 'json':
                return json_decode($in);
                break;

            default:
                return $in;
                break;
        }

        return $in;
    }

    /**
     * @param $options
     * @return mixed|null
     * @throws SendinBlueException
     */
    protected function request($options)
    {
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $info =  curl_getinfo($curl);
        curl_close($curl);

        return $this->response($response, $info);
    }

}