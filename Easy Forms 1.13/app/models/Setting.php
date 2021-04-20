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
use app\helpers\ArrayHelper;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $type
 * @property string $category
 * @property string $key
 * @property string $value
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Setting extends ActiveRecord
{
    /**
     * Define status constants
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
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
        $rules = [
            [['type', 'category', 'key'], 'required'],
            [['value'], 'string'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['type', 'category'], 'string', 'max' => 64],
            [['key'], 'string', 'max' => 255],
            [['category', 'key'], 'unique', 'targetAttribute' => ['category', 'key'],
                'message' => 'The combination of Category and Key has already been taken.'],
            [['type', 'created_at', 'updated_at'], 'safe'],
        ];

        // Applies only for email setting
        if ($this->key == "adminEmail" || $this->key == "supportEmail" || $this->key == "noreplyEmail") {
            array_push($rules, [['value'], 'email']);
        }

        return $rules;

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'category' => Yii::t('app', 'Category'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Enable'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {

        if ($this->key == "password") {
            $this->value = base64_encode($this->value);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->settings->clearCache();
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        parent::afterDelete();
        Yii::$app->settings->clearCache();
    }

    /**
     * Gets all a combined map of all the settings.
     *
     * @return array
     */
    public function getSettings()
    {
        $settings = static::find()->where(['status' => true])->asArray()->all();
        return array_merge_recursive(
            ArrayHelper::map($settings, 'key', 'value', 'category'),
            ArrayHelper::map($settings, 'key', 'type', 'category')
        );
    }

    /**
     * Save a setting
     *
     * @param $category
     * @param $key
     * @param $value
     * @param $type
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function setSetting($category, $key, $value, $type = null)
    {
        $model = static::findOne(['category' => $category, 'key' => $key]);
        if ($model === null) {
            $model = new static();
            $model->status = static::STATUS_ACTIVE;
        }
        $model->category = $category;
        $model->key = $key;
        $model->value = strval($value);
        if ($type !== null) {
            $model->type = $type;
        } else {
            $model->type = gettype($value);
        }
        return $model->save();
    }

    /**
     * Activates a setting
     *
     * @param $key
     * @param $category
     * @return boolean True on success, false on error
     */
    public function activateSetting($category, $key)
    {
        $model = static::findOne(['category' => $category, 'key' => $key]);
        if ($model && $model->status == static::STATUS_INACTIVE) {
            $model->status = static::STATUS_ACTIVE;
            return $model->save();
        }
        return false;
    }

    /**
     * Deactivates a setting
     *
     * @param $key
     * @param $category
     * @return boolean True on success, false on error
     */
    public function deactivateSetting($category, $key)
    {
        $model = static::findOne(['category' => $category, 'key' => $key]);
        if ($model && $model->status == static::STATUS_ACTIVE) {
            $model->status = static::STATUS_INACTIVE;
            return $model->save();
        }
        return false;
    }

    /**
     * Deletes a settings
     *
     * @param $key
     * @param $category
     * @return boolean True on success, false on error
     */
    public function deleteSetting($category, $key)
    {
        $model = static::findOne(['category' => $category, 'key' => $key]);
        if ($model) {
            return $model->delete();
        }
        return true;
    }

    /**
     * Deletes all settings! Be careful!
     *
     * @return boolean True on success, false on error
     */
    public function deleteAllSettings()
    {
        return static::deleteAll();
    }
}
