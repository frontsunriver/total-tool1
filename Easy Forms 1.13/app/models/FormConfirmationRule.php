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

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%form_confirmation_rule}}".
 *
 * @property int $id
 * @property int $form_id
 * @property string $name
 * @property int $status
 * @property string $conditions
 * @property int $action
 * @property string $message
 * @property string $url
 * @property int $append
 * @property int $alias
 * @property int $seconds
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Form $form
 */
class FormConfirmationRule extends \yii\db\ActiveRecord
{

    const OFF = 0;
    const ON = 1;

    const CONFIRM_WITH_MESSAGE = 0;
    const CONFIRM_WITH_ONLY_MESSAGE = 1;
    const CONFIRM_WITH_REDIRECTION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%form_confirmation_rule}}';
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
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'status', 'action', 'append', 'alias', 'seconds', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['conditions', 'message'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 2555],
            [['url'], 'url', 'defaultScheme' => 'http'],
            ['message', 'required', 'when' => function ($model) {
                return $model->action != self::CONFIRM_WITH_REDIRECTION;
            }, 'whenClient' => "function (attribute, value) {
                return false;
            }"],
            ['url', 'required', 'when' => function ($model) {
                return $model->action == self::CONFIRM_WITH_REDIRECTION;
            }, 'whenClient' => "function (attribute, value) {
                return false;
            }"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'form_id' => Yii::t('app', 'Form ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'conditions' => Yii::t('app', 'Conditions'),
            'action' => Yii::t('app', 'Confirms that the submission was successful with:'),
            'message' => Yii::t('app', 'Message'),
            'url' => Yii::t('app', 'Page URL'),
            'append' => Yii::t('app', 'Append Submission Data to URL'),
            'alias' => Yii::t('app', 'Replace Field Name with Field Alias when it\'s available'),
            'seconds' => Yii::t('app', 'Show Message and Redirect After'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

}
