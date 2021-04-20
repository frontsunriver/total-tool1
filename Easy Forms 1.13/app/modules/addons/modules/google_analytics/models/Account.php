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

namespace app\modules\addons\modules\google_analytics\models;

use app\components\behaviors\DateTrait;
use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\Form;

/**
 * This is the model class for table "addon_google_analytics".
 *
 * @property integer $id
 * @property integer $form_id
 * @property string $tracking_id
 * @property string $tracking_domain
 * @property integer $status
 * @property integer $anonymize_ip
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Form $form
 * @property User $author
 * @property User $lastEditor
 */
class Account extends ActiveRecord
{
    use DateTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%addon_google_analytics}}';
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
    public function rules()
    {
        return [
            [['form_id', 'status', 'anonymize_ip', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['form_id', 'tracking_id', 'tracking_domain'], 'required'],
            [['tracking_id', 'tracking_domain'], 'string', 'max' => 255],
            ['tracking_id', 'match', 'pattern' => '/(UA|YT|MO)-\d+-\d+/i'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('google_analytics', 'ID'),
            'form_id' => Yii::t('google_analytics', 'Form'),
            'status' => Yii::t('google_analytics', 'Status'),
            'tracking_id' => Yii::t('google_analytics', 'Tracking ID'),
            'tracking_domain' => Yii::t('google_analytics', 'Tracking Domain'),
            'anonymize_ip' => Yii::t('google_analytics', 'Anonymize Ip'),
            'created_by' => Yii::t('google_analytics', 'Created by'),
            'updated_by' => Yii::t('google_analytics', 'Updated by'),
            'created_at' => Yii::t('google_analytics', 'Created at'),
            'updated_at' => Yii::t('google_analytics', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::className(), ['id' => 'form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditor()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (empty($this->created_by)) {
            $this->created_by = Yii::$app->user->id;
        }
        $this->updated_by = Yii::$app->user->id;

        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }
}
