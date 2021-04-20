<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.3.5
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */
namespace app\helpers;

use Yii;

class SubmissionHelper
{
    /**
     * Replace tokens by field values in a text message
     *
     * @param string $text Custom Text Message
     * @param array $data Form Submission Data
     * @return mixed
     */
    public static function replaceTokens($text, array $data)
    {
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $value = is_array($value) ? implode(', ', $value) : $value;
                 $text = str_replace("{{" . $key . "}}", $value, $text);
                 $text = str_replace("{{ " . $key . " }}", $value, $text);
            } else {
                $text = str_replace("{{" . $key . "}}", '', $text);
                $text = str_replace("{{ ". $key . " }}", '', $text);
            }
        }

        return $text;
    }

    /**
     * Prepare Data To Be Parsed by the Rule Engine
     *
     * @param array|string $submittedData Submitted data by the end user
     * @param array $fields
     * @return array $data
     */
    public static function prepareDataForRuleEngine($submittedData, $fields)
    {
        $data = is_string($submittedData) ? json_decode($submittedData, true) : $submittedData;
        $fieldNames = array_keys($data);
        foreach ($fieldNames as $fieldName) {
            $componentType = current(explode('_', $fieldName));
            if ($componentType === "checkbox") {
                $values = $data[$fieldName];
                foreach ($values as $value) {
                    $checkedFieldByName = ArrayHelper::filter($fields, $fieldName, 'name');
                    $checkedFieldByNameAndValue = current(ArrayHelper::filter($checkedFieldByName, $value, 'value'));
                    if (isset($checkedFieldByNameAndValue['id']) && !isset($data[$checkedFieldByNameAndValue['id']])) {
                        $data[$checkedFieldByNameAndValue['id']] = $value;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Merge array of Submission Data and Field Values
     *
     * @param array $submissionData [name => value]
     * @param array $fields Fields for email [name => labels]
     * @return array $data ['label' => 'value', 'name' => 'value']
     */
    public static function prepareDataForReplacementToken($submissionData, $fields)
    {
        $data = array();
        foreach ($submissionData as $key => $value) {
            if (isset($fields[$key])) {
                // Signature Field
                if (substr($key, 0, 16) === 'hidden_signature') {
                    $data[$fields[$key]] = self::getSignatureImage($value);
                } else {
                    $data[$fields[$key]] = $value;
                }
            }
        }
        $data = array_merge($submissionData, $data);
        // Disabled fields with conditional rules should be blank
        foreach ($fields as $key => $label) {
            if (!isset($data[$key])) {
                $data[$key] = '';
                $data[$label] = '';
            }
        }
        return $data;
    }

    /**
     * Prepare submission data for print the detail table on email messages
     *
     * @param array $submissionData [name => value]
     * @param array $fields Fields for email [name => label]
     * @return array $data [['label' => 'value'], ['label' => 'value']]
     */
    public static function prepareDataForSubmissionTable($submissionData, $fields)
    {
        $data = array();
        foreach ($submissionData as $key => $value) {
            // Exclude Signature Field
            if (isset($fields[$key]) && substr($key, 0, 16) !== 'hidden_signature') {
                array_push($data, [
                    'label' => $fields[$key],
                    'value' => $value,
                ]);
            }
        }
        return $data;
    }

    /**
     * Replace Field Names With Field Alias on Submission Data
     *
     * @param array $submissionData Submission Data
     * @param array $aliases Array of aliases [name => alias]
     * @return array Submission Data with field alias instead of field names
     */
    public static function replaceFieldNameWithFieldAlias($submissionData, $aliases)
    {
        $data = $submissionData;
        foreach ($data as $key => $value) {
            if (isset($aliases[$key]) && trim($aliases[$key]) !== '') {
                ArrayHelper::replaceKey($data, $key, $aliases[$key]);
            }
        }
        return $data;
    }

    /**
     * Replace token by the submission table in a text message
     *
     * @param string $text Custom Text Message
     * @param array $data Form Submission Data
     * @param boolean $plainText Plain Text
     * @return string
     */
    public static function replaceSubmissionTableToken($text, array $data, $plainText = false)
    {
        $submissionTable = self::getsubmissionTable($data, $plainText);
        $text = str_replace("{{submission_table}}", $submissionTable, $text);
        $text = str_replace("{{ submission_table }}", $submissionTable, $text);
        return $text;
    }

    /**
     * Get Submission Table
     *
     * @param array $fields Form Fields for print [name => label]
     * @param boolean $plainText Plain Text
     * @return string HTML Code of Submission Table
     */
    public static function getSubmissionTable($fields, $plainText = false)
    {

        $table = '';

        $title = Yii::t('app', 'Submission Details');

        if ($plainText) {
            $title = $title . " \r\n";

            $table = <<<EOT

$title

EOT;

            foreach ($fields as $field) {
                if (!empty($field['value']) && (!is_array($field['value']) || !empty($field['value'][0]))) {
                    $label  = isset($field['label']) ? strip_tags($field['label']) : '';
                    $value  = is_array($field['value']) ? implode(', ', $field['value']) : $field['value'];
                    $value  = strip_tags($value);
                    $item   = sprintf("- %s: %s \r\n", $label, $value);
                    $table .= <<<EOT
$item

EOT;
                }
            }
            return $table;
        }

        $table .= <<<HTML
<table cellspacing="0" cellpadding="0">
    <tr style="background-color: #6e8292;">
        <th colspan="2" style="color: #ffffff; text-align: left; padding: 10px;">
            $title
        </th>
    </tr>
HTML;

        $i = 0;
        foreach ($fields as $field) {

            if (!empty($field['value']) && (!is_array($field['value']) || !empty($field['value'][0]))) {

                $label = $field['label'];
                $value = is_array($field['value']) ? implode(', ', $field['value']) : $field['value'];
                $bgColor = ($i++%2==1) ? '#f3f5f7' : '#FFFFFF';

                $table .= <<<HTML
<tr style="background-color: $bgColor">
    <th style="text-align: left; padding-left: 10px">
        $label
    </th>
    <td style="vertical-align: top; text-align: left; padding: 7px 9px 7px 9px; border-top: 1px solid #eee;">
        <div style="color: #222;"> $value </div>
    </td>
</tr>
HTML;

            }
        }

        $table .= <<<HTML
</table>
HTML;

        return $table;
    }

    /**
     * Return Signature image (base64 encoded)
     *
     * @param string|array $signature Signature Field value
     * @param bool $html Indicates if the signature should be embedded in an img tag.
     * @return string
     */
    public static function getSignatureImage($signature, $html = true)
    {
        $image = '';

        $signature = is_string($signature) ? json_decode($signature, true) : $signature;

        if (!empty($signature['dataURL'])) {

            $image = $signature['dataURL'];

            if ($html) {
                $image = Html::img($image, [
                    'style' =>  'display:block;',
                ]);
            }
        }

        return $image;
    }
}