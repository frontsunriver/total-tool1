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

namespace app\models;

use app\helpers\Hashids;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Schema;
use yii\helpers\Url;

/**
 * This is the model class for table "form_submission_file".
 *
 * @property integer $id
 * @property integer $submission_id
 * @property integer $form_id
 * @property integer $field
 * @property integer $label
 * @property string $name
 * @property string $extension
 * @property integer $size
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Form $form
 * @property FormSubmission $submission
 */
class FormSubmissionFile extends ActiveRecord
{

    const FILES_FOLDER = "forms";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_submission_file}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ['id', 'field', 'label', 'name', 'originalName','extension', 'sizeWithUnit', 'link'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['submission_id', 'form_id', 'name', 'size'], 'required'],
            [['field', 'label', 'name', 'extension'], 'string'],
            [['id', 'submission_id', 'form_id', 'size', 'status', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'submission_id' => Yii::t('app', 'Submission ID'),
            'form_id' => Yii::t('app', 'Form ID'),
            'field' => Yii::t('app', 'Field'),
            'label' => Yii::t('app', 'Label'),
            'name' => Yii::t('app', 'Name'),
            'extension' => Yii::t('app', 'Extension'),
            'size' => Yii::t('app', 'Size'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {

            // Delete file if exists
            $filePath = $this->getPath();
            Yii::$app->fs->delete($filePath);
            return true;

        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmission()
    {
        return $this->hasOne(FormSubmission::class, ['id' => 'submission_id']);
    }

    /**
     * Name of the file
     * (name with extension)
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->name . "." . $this->extension;
    }

    /**
     * File path
     *
     * @param bool|string $scheme the URI scheme to use in the returned base URL:
     * @return string
     */
    public function getPath()
    {
        return self::FILES_FOLDER . '/' . $this->form_id . '/' . $this->getFilename();
    }

    /**
     * Returns the url to the file
     *
     * @param bool|string $scheme the URI scheme to use in the returned base URL:
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::to('@uploads' . '/' . $this->getPath(), $scheme);
    }

    /**
     * Returns the absolute url to access the file
     *
     * @return string
     */
    public function getLink()
    {
        return Url::to(['/secure/file', 'id' => Hashids::encode($this->id)], true);
    }

    /**
     * Returns the size of the file with unit
     *
     * @return string
     */
    public function getSizeWithUnit()
    {
        return $this->formatBytes($this->size);
    }

    /**
     * Returns the original filename
     * Removes submission id to filename
     *
     * @return mixed
     */
    public function getOriginalName()
    {
        return preg_replace('/-[^-]*$/', '', $this->name);
    }

    /**
     * Format the size for the given number of bytes
     *
     * @param int $bytes Number of bytes (eg. 25907)
     * @param int $precision [optional] Number of digits after the decimal point (eg. 1)
     * @return string Value converted with unit (eg. 25.3KB)
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
