<?php
/**
 * Copyright (C) Baluart.COM - All Rights Reserved
 *
 * @since 1.4.3
 * @author Baluart E.I.R.L.
 * @copyright Copyright (c) 2015 - 2021 Baluart E.I.R.L.
 * @license http://codecanyon.net/licenses/faq Envato marketplace licenses
 * @link https://easyforms.dev/ Easy Forms
 */

namespace app\modules\setup\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%setting}}".
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

        return $rules;

    }

}
