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
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "form_chart".
 *
 * @property integer $form_id
 * @property string $name
 * @property string $label
 * @property string $title
 * @property string $type
 * @property integer $width
 * @property integer $height
 * @property integer $gsX
 * @property integer $gsY
 * @property integer $gsW
 * @property integer $gsH
 * @property integer $created_at
 * @property integer $updated_at
 */
class FormChart extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_chart}}';
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
            [['form_id', 'name', 'label', 'title', 'type', 'width', 'height', 'gsX', 'gsY', 'gsW', 'gsH'], 'required'],
            [['form_id', 'width', 'height', 'gsX', 'gsY', 'gsW', 'gsH', 'created_at', 'updated_at'], 'integer'],
            [['name', 'label', 'title', 'type'], 'string', 'max' => 255],
            [['form_id', 'name'], 'unique', 'targetAttribute' => ['form_id', 'name'],
                'message' => 'The combination of Form ID and Name has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'form_id' => Yii::t('app', 'Form ID'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'title' => Yii::t('app', 'Title'),
            'type' => Yii::t('app', 'Type'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'gsX' => Yii::t('app', 'Gs X'),
            'gsY' => Yii::t('app', 'Gs Y'),
            'gsW' => Yii::t('app', 'Gs W'),
            'gsH' => Yii::t('app', 'Gs H'),
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
