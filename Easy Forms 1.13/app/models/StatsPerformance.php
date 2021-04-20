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

/**
 * This is the model class for table "stats_performance".
 *
 * @property string $day
 * @property string $app_id
 * @property integer $users
 * @property integer $fills
 * @property integer $conversions
 * @property string $conversionTime
 */
class StatsPerformance extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stats_performance}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'app_id'], 'required'],
            [['day'], 'safe'],
            [['users', 'fills', 'conversions', 'conversionTime'], 'integer'],
            [['app_id'], 'string', 'max' => 255],
            [['day', 'app_id'], 'unique', 'targetAttribute' => ['day', 'app_id'],
                'message' => 'The combination of Day and App ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'day' => Yii::t('app', 'Day'),
            'app_id' => Yii::t('app', 'App ID'),
            'users' => Yii::t('app', 'Users'),
            'fills' => Yii::t('app', 'Fills'),
            'conversions' => Yii::t('app', 'Conversions'),
            'conversionTime' => Yii::t('app', 'Conversion Time'),
        ];
    }
}
