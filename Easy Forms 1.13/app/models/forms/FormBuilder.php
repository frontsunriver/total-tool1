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

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\helpers\ArrayHelper;

/**
 * FormBuilder is the form behind FormData Model.
 */
class FormBuilder extends Model
{
    public $data;
    public $html;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['data', 'required'],
            ['html', 'required'],
        ];
    }

    /**
     * Check if an email field is in the fields array
     * @param array $emailField Email field or Array of Email Fields
     * @param array $fields
     * @return bool
     */
    public function hasSameEmailField($emailField, $fields)
    {
        if (!empty($emailField) && !empty($fields)) {
            $emailFields = ArrayHelper::filter($fields, 'email', 'type');
            $emailsArray = ArrayHelper::column($emailFields, 'label', 'name');

            // TODO Keeps compatibility with versions previous to v1.3.6
            if (is_string($emailField)) {
                return array_key_exists($emailField, $emailsArray);
            }

            // If an email field was deleted, return false
            if (is_array($emailField)) {
                foreach ($emailField as $email) {
                    $exist = array_key_exists($email, $emailsArray);
                    if (!$exist) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
