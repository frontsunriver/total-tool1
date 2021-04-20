<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.7.1
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\components\filters;

use Yii;
use yii\base\InvalidConfigException;
use yii\filters\Cors;

class DynamicCors extends Cors
{
    /**
     * @inheritDoc
     */
    public function prepareHeaders($requestHeaders)
    {
        $responseHeaders = [];
        // handle Origin
        $origin = $this->cors['Origin'];

        if (is_callable($origin)) {
            $this->cors['Origin'] = call_user_func($origin);
        }

        if (isset($requestHeaders['Origin'], $this->cors['Origin'])) {
            if (in_array($requestHeaders['Origin'], $this->cors['Origin'], true)) {
                $responseHeaders['Access-Control-Allow-Origin'] = $requestHeaders['Origin'];
            }

            if (in_array('*', $this->cors['Origin'], true)) {
                // Per CORS standard (https://fetch.spec.whatwg.org), wildcard origins shouldn't be used together with credentials
                if (isset($this->cors['Access-Control-Allow-Credentials']) && $this->cors['Access-Control-Allow-Credentials']) {
                    if (YII_DEBUG) {
                        throw new InvalidConfigException("Allowing credentials for wildcard origins is insecure. Please specify more restrictive origins or set 'credentials' to false in your CORS configuration.");
                    } else {
                        Yii::error("Allowing credentials for wildcard origins is insecure. Please specify more restrictive origins or set 'credentials' to false in your CORS configuration.", __METHOD__);
                    }
                } else {
                    $responseHeaders['Access-Control-Allow-Origin'] = '*';
                }
            }
        }

        $this->prepareAllowHeaders('Headers', $requestHeaders, $responseHeaders);

        if (isset($requestHeaders['Access-Control-Request-Method'])) {
            $responseHeaders['Access-Control-Allow-Methods'] = implode(', ', $this->cors['Access-Control-Request-Method']);
        }

        if (isset($this->cors['Access-Control-Allow-Credentials'])) {
            $responseHeaders['Access-Control-Allow-Credentials'] = $this->cors['Access-Control-Allow-Credentials'] ? 'true' : 'false';
        }

        if (isset($this->cors['Access-Control-Max-Age']) && $this->request->getIsOptions()) {
            $responseHeaders['Access-Control-Max-Age'] = $this->cors['Access-Control-Max-Age'];
        }

        if (isset($this->cors['Access-Control-Expose-Headers'])) {
            $responseHeaders['Access-Control-Expose-Headers'] = implode(', ', $this->cors['Access-Control-Expose-Headers']);
        }

        if (isset($this->cors['Access-Control-Allow-Headers'])) {
            $responseHeaders['Access-Control-Allow-Headers'] = implode(', ', $this->cors['Access-Control-Allow-Headers']);
        }

        return $responseHeaders;
    }
}