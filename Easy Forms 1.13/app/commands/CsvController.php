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

namespace app\commands;

use app\helpers\ArrayHelper;
use app\models\Form;
use app\models\FormSubmission;
use app\models\FormSubmissionFile;
use SimpleExcel\SimpleExcel;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Url;

/**
 * Class CsvController
 * @package app\commands
 */
class CsvController extends Controller
{

    /**
     * @var string the default command action.
     */
    public $defaultAction = 'export-submissions';

    /**
     * Export Form Submissions as CSV
     *
     * Eg. php yii csv/export-submissions 1
     *
     * @param $id
     * @throws Exception
     */
    public function actionExportSubmissions($id)
    {

        try {

            $formModel = $this->findFormModel($id);
            $formDataModel = $formModel->formData;

            $query = FormSubmission::find()
                ->select(['id', 'data', 'created_at'])
                ->where('{{%form_submission}}.form_id=:form_id', [':form_id' => $id])
                ->orderBy('created_at DESC')
                ->asArray();

            // Insert fields names as the header
            $allLabels = $formDataModel->getFieldsForEmail(false, false);
            $labels = [];
            foreach ($allLabels as $key => $label) {
                // Exclude Signature Field
                if (substr($key, 0, 16) !== 'hidden_signature') {
                    $labels[$key] = $label;
                }
            }
            $header = array_values($labels);

            array_unshift($header, '#');
            array_push($header, Yii::t('app', 'Submitted'));
            $keys = array_keys($labels);

            // File Name To Export
            $fileNameToExport = $formModel->name;

            // Add data
            $data = array(
                $header
            );

            // To iterate the row one by one
            $i = 1;
            foreach ($query->each() as $submission) {
                // $submission represents one row of data from the form_submission table
                $submissionData = json_decode($submission['data'], true);
                if (is_array($submissionData) && !empty($submissionData)) {
                    // Stringify fields with multiple values
                    foreach ($submissionData as $name => &$field) {
                        if (is_array($field)) {
                            $field = implode(', ', $field);
                        }
                    }
                    // Only take data of current fields
                    $fields = [];
                    $fields["id"] = $i++;
                    foreach ($keys as $key) {
                        // Exclude Signature Field
                        if (substr($key, 0, 16) !== 'hidden_signature') {
                            $fields[$key] = isset($submissionData[$key]) ? $submissionData[$key] : '';
                        }
                    }
                    // Add date
                    $fields["created_at"] = Yii::$app->formatter->asDatetime($submission['created_at']);
                    array_push($data, $fields);
                }
            }

            $excel = new SimpleExcel("csv");
            $excel->writer->setData($data);
            $excel->writer->saveFile($fileNameToExport);
            exit;

        } catch (\Exception $e) {

            throw new Exception($e->getMessage());

        }

    }

    /**
     * Finds the Form model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * If the user does not have access, a Forbidden Http Exception will be thrown.
     *
     * @param $id
     * @return Form
     * @throws Exception
     */
    protected function findFormModel($id)
    {
        if (($model = Form::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new Exception("The requested Form ID does not exist.");
        }
    }
}