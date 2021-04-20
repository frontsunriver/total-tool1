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

namespace app\components\validators;

use Yii;
use yii\validators\Validator;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Exception;

/**
 * Class PhoneValidator
 * @package app\components\validators
 *
 * Validates phone numbers for given country and formats.
 * Country code should be ISO 3166-1 alpha-2 codes
 *
 */
class PhoneValidator extends Validator
{

    /**
     * @var null|string The country code
     */
    public $countryCode = null; // (e.g. 'US')

    public $format = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('app', '{attribute} is not a valid phone number.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        // Make sure string length is limited to avoid DOS attacks
        if (!is_string($value) || strlen($value) >= 320) {
            $valid = false;
        } else {
            $phoneUtil = PhoneNumberUtil::getInstance();
            try {
                // If countryCode is null, the value must be a International Phone Number (e.g. "+1 650-555-5555")
                $phoneNumber = $phoneUtil->parse($value, $this->countryCode);
                // Use isPossibleNumber, for better performance
                $valid = $phoneUtil->isPossibleNumber($phoneNumber);
            } catch (NumberParseException $e) {
                $valid = false;
            } catch (Exception $e) {
                $this->message = Yii::t('app', '{attribute} is not a valid phone number or country code is invalid.');
                $valid = false;
            }
        }
        return $valid ? null : [$this->message, []];
    }
}
