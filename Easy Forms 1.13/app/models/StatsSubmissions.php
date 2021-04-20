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
 * This is the model class for table "stats_submissions".
 *
 * @property string $app_id
 * @property integer $collector_tstamp
 * @property integer $domain_sessionidx
 * @property string $geo_country
 * @property string $geo_city
 * @property string $refr_urlhost
 * @property string $refr_medium
 * @property string $br_family
 * @property string $os_family
 * @property string $dvce_type
 * @property integer $dvce_ismobile
 */
class StatsSubmissions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%stats_submissions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'collector_tstamp'], 'required'],
            [['collector_tstamp', 'domain_sessionidx', 'dvce_ismobile'], 'integer'],
            [['app_id', 'geo_country', 'refr_urlhost'], 'string', 'max' => 255],
            [['geo_city'], 'string', 'max' => 75],
            [['refr_medium'], 'string', 'max' => 25],
            [['br_family', 'os_family', 'dvce_type'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'app_id' => Yii::t('app', 'App ID'),
            'collector_tstamp' => Yii::t('app', 'Collector Timestamp'),
            'domain_sessionidx' => Yii::t('app', 'Domain Session Index'),
            'geo_country' => Yii::t('app', 'Geo Country'),
            'geo_city' => Yii::t('app', 'Geo City'),
            'refr_urlhost' => Yii::t('app', 'Referrer Url Host'),
            'refr_medium' => Yii::t('app', 'Referrer Medium'),
            'br_family' => Yii::t('app', 'Browser Family'),
            'os_family' => Yii::t('app', 'OS Family'),
            'dvce_type' => Yii::t('app', 'Device Type'),
            'dvce_ismobile' => Yii::t('app', 'Device Is Mobile'),
        ];
    }
}
