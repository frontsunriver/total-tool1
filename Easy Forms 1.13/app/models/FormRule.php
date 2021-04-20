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
 * This is the model class for table "form_rule".
 *
 * @property integer $id
 * @property integer $form_id
 * @property integer $status
 * @property string $name
 * @property string $conditions
 * @property string $actions
 * @property integer $ordinal
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Form $form
 */
class FormRule extends ActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%form_rule}}';
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
            [['form_id'], 'required'],
            [['form_id', 'status', 'opposite', 'ordinal', 'created_at', 'updated_at'], 'integer'],
            [['conditions', 'actions'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'form_id' => Yii::t('app', 'Form ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'opposite' => Yii::t('app', 'Opposite actions'),
            'conditions' => Yii::t('app', 'Conditions'),
            'ordinal' => Yii::t('app', 'Ordinal'),
            'actions' => Yii::t('app', 'Actions'),
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

    /**
     * Show label instead of value for boolean Status property
     * @return string
     */
    public function getStatusLabel()
    {
        return $this->status ? Yii::t('app', 'Active') : Yii::t('app', 'Inactive');
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // If Form has required fields
        $requiredFieldsCount = $this->form->formData->getRequiredLabels();
        if (count($requiredFieldsCount) > 0) {
            $ruleActions = $this->actions;
            // And Conditional Rule has hiding/showing, disabling/enabling or skipping actions
            foreach(['toShow', 'toHide', 'toEnable', 'toDisable', 'skip'] as $action)
            {
                if(strpos($ruleActions, $action) !== false)
                {
                    // Disable client side validation
                    $this->form->novalidate = 1;
                    $this->form->save();
                    break;
                }
            }
        }
    }
}
