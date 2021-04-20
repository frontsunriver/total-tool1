<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.4
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\events\handlers;

use Yii;
use Exception;
use yii\helpers\Json;
use yii\base\Component;
use app\models\FormRule;

/**
 * Class FormEvent
 * @package app\events
 */
class FormEventHandler extends Component
{

    /**
     * Executed when a form is updated
     *
     * @param $event
     * @throws Exception
     */
    public static function onFormUpdated($event)
    {

        /** @var \app\models\Form $formModel */
        $formModel = $event->form;
        /** @var \app\helpers\FormDOM $formDOM */
        $formDOM = $event->formDOM;
        /** @var \app\models\forms\FormBuilder $formBuilder */
        $formBuilder = $event->formBuilder;
        /** @var \app\models\FormEmail $formEmailModel */
        $formEmailModel = $formModel->formEmail;
        /** @var \app\models\FormConfirmation $formConfirmationModel */
        $formConfirmationModel = $formModel->formConfirmation;
        /** @var \app\models\FormData $oldFormDataModel */
        $oldFormDataModel = $event->oldFormData;

        /**
         * Check if an email field was deleted
         * that it was used in notifications or confirmations
         */

        if (!empty($formEmailModel->from) || !empty($formConfirmationModel->mail_from)) {
            // Get form fields
            $fields = Json::decode($formDOM->getFieldsAsJSON(), true);
            // FormEmail Model
            if (!$formEmailModel->fromIsEmail()) {
                // If the Email Field was modified
                if (!$formBuilder->hasSameEmailField($formEmailModel->from, $fields)) {
                    // Delete From Field of FormEmail Model
                    $formEmailModel->from = null;
                    if (!$formEmailModel->save()) {
                        throw new Exception(Yii::t('app', 'Error saving data'), 3);
                    }
                }
            }
            // FormConfirmation Model
            if (!empty($formConfirmationModel->mail_to)) {
                // If the Email Field was modified
                if (!$formBuilder->hasSameEmailField($formConfirmationModel->mail_to, $fields)) {
                    // Disable Form Confirmation
                    $formConfirmationModel->send_email = $formConfirmationModel::CONFIRM_BY_EMAIL_DISABLE;
                    // Delete From Field of FormConfirmation Model
                    $formConfirmationModel->mail_to = null;
                    if (!$formConfirmationModel->save()) {
                        throw new Exception(Yii::t('app', 'Error saving data'), 4);
                    }
                }
            }
        }

        /**
         * Update Conditional Rules, if the value of a radio button or select list was updated
         */
        /** @var \app\models\FormData $oldFormDataModel */
        if ($oldFormDataModel) {
            // Old fields
            $oldRadioFields = $oldFormDataModel->getRadioFields();
            $oldSelectListFields = $oldFormDataModel->getSelectListFields();
            $oldFields = $oldRadioFields + $oldSelectListFields;
            // Current fields
            $radioFields = $event->formData->getRadioFields();
            $selectListFields = $event->formData->getSelectListFields();
            $fields = $radioFields + $selectListFields;
            // Replace old values
            foreach ($oldFields as $key => $value) {
                // Update only if new option:
                // 1. Exists
                // 2. Is different
                // 3. Wasn't moved to a different position
                if (isset($fields[$key]) && $value !== $fields[$key] && !in_array($value, array_values($fields))) {
                    $fieldName = strtok($key, '_') . '_' . strtok('_');
                    $rules = FormRule::findAll(['form_id' => $formModel->id]);
                    /** @var \app\models\FormRule $rule */
                    foreach ($rules as $rule) {
                        $string = $rule->conditions;
                        // Conditional Rule Operators
                        $operators = ['equalTo', 'notEqualTo'];
                        foreach ($operators as $operator) {
                            $pattern = '"name":"'.$fieldName.'","operator":"'.$operator.'","value":"'.$value.'"';
                            $pattern = '/' . preg_quote($pattern, "") . '/';
                            $replacement = '"name":"'.$fieldName.'","operator":"'.$operator.'","value":"'.$fields[$key].'"';
                            try {
                                $newConditions = preg_replace($pattern, $replacement, $string);
                            } catch (Exception $e) {
                                // hide this exception to be able to continue
                                $newConditions = null;
                                \Yii::error($e, __METHOD__);
                            }
                            if (is_string($newConditions) && !is_null($newConditions) && $newConditions != $string) {
                                $rule->conditions = $newConditions;
                                if (!$rule->save()) {
                                    throw new Exception(Yii::t('app', 'Error saving data'), 5);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
