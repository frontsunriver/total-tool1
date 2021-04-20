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
 * This is the model class for table "event".
 *
 * @property string $app_id
 * @property string $platform
 * @property integer $etl_tstamp
 * @property integer $collector_tstamp
 * @property integer $dvce_tstamp
 * @property string $event
 * @property string $event_id
 * @property integer $txn_id
 * @property string $name_tracker
 * @property string $v_tracker
 * @property string $v_collector
 * @property string $v_etl
 * @property string $user_id
 * @property string $user_ipaddress
 * @property string $user_fingerprint
 * @property string $domain_userid
 * @property integer $domain_sessionidx
 * @property string $network_userid
 * @property string $geo_country
 * @property string $geo_region
 * @property string $geo_city
 * @property string $geo_zipcode
 * @property double $geo_latitude
 * @property double $geo_longitude
 * @property string $geo_region_name
 * @property string $page_url
 * @property string $page_title
 * @property string $page_referrer
 * @property string $page_urlscheme
 * @property string $page_urlhost
 * @property integer $page_urlport
 * @property string $page_urlpath
 * @property string $page_urlquery
 * @property string $page_urlfragment
 * @property string $refr_urlscheme
 * @property string $refr_urlhost
 * @property integer $refr_urlport
 * @property string $refr_urlpath
 * @property string $refr_urlquery
 * @property string $refr_urlfragment
 * @property string $refr_medium
 * @property string $refr_source
 * @property string $refr_term
 * @property string $mkt_medium
 * @property string $mkt_source
 * @property string $mkt_term
 * @property string $mkt_content
 * @property string $mkt_campaign
 * @property string $contexts
 * @property string $se_category
 * @property string $se_action
 * @property string $se_label
 * @property string $se_property
 * @property double $se_value
 * @property string $unstruct_event
 * @property string $tr_orderid
 * @property string $tr_affiliation
 * @property string $tr_total
 * @property string $tr_tax
 * @property string $tr_shipping
 * @property string $tr_city
 * @property string $tr_state
 * @property string $tr_country
 * @property string $ti_orderid
 * @property string $ti_sku
 * @property string $ti_name
 * @property string $ti_category
 * @property string $ti_price
 * @property integer $ti_quantity
 * @property integer $pp_xoffset_min
 * @property integer $pp_xoffset_max
 * @property integer $pp_yoffset_min
 * @property integer $pp_yoffset_max
 * @property string $useragent
 * @property string $br_name
 * @property string $br_family
 * @property string $br_version
 * @property string $br_type
 * @property string $br_renderengine
 * @property string $br_lang
 * @property integer $br_features_pdf
 * @property integer $br_features_flash
 * @property integer $br_features_java
 * @property integer $br_features_director
 * @property integer $br_features_quicktime
 * @property integer $br_features_realplayer
 * @property integer $br_features_windowsmedia
 * @property integer $br_features_gears
 * @property integer $br_features_silverlight
 * @property integer $br_cookies
 * @property string $br_colordepth
 * @property integer $br_viewwidth
 * @property integer $br_viewheight
 * @property string $os_name
 * @property string $os_family
 * @property string $os_manufacturer
 * @property string $os_timezone
 * @property string $dvce_type
 * @property integer $dvce_ismobile
 * @property integer $dvce_screenwidth
 * @property integer $dvce_screenheight
 * @property string $doc_charset
 * @property integer $doc_width
 * @property integer $doc_height
 * @property string $geo_timezone
 * @property string $mkt_clickid
 * @property string $mkt_network
 * @property string $etl_tags
 * @property integer $dvce_sent_tstamp
 * @property string $domain_sessionid
 */
class Event extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'collector_tstamp', 'v_collector'], 'required'],
            [['etl_tstamp', 'collector_tstamp', 'dvce_tstamp', 'txn_id', 'domain_sessionidx',
                'page_urlport', 'refr_urlport', 'ti_quantity', 'pp_xoffset_min', 'pp_xoffset_max',
                'pp_yoffset_min', 'pp_yoffset_max', 'br_features_pdf', 'br_features_flash',
                'br_features_java', 'br_features_director', 'br_features_quicktime', 'br_features_realplayer',
                'br_features_windowsmedia', 'br_features_gears', 'br_features_silverlight', 'br_cookies',
                'br_viewwidth', 'br_viewheight', 'dvce_ismobile', 'dvce_screenwidth', 'dvce_screenheight',
                'doc_width', 'doc_height', 'dvce_sent_tstamp'], 'integer'],
            [['geo_latitude', 'geo_longitude', 'se_value', 'tr_total', 'tr_tax', 'tr_shipping', 'ti_price'], 'number'],
            [['page_url', 'page_referrer', 'contexts', 'unstruct_event'], 'string'],
            [['app_id', 'platform', 'user_id', 'page_urlhost', 'refr_urlhost', 'refr_term',
                'mkt_medium', 'mkt_source', 'mkt_term', 'mkt_content', 'mkt_campaign', 'tr_orderid',
                'tr_affiliation', 'tr_city', 'tr_state', 'tr_country', 'ti_orderid', 'ti_sku', 'ti_name',
                'ti_category', 'br_lang', 'br_colordepth'], 'string', 'max' => 255],
            [['event', 'name_tracker', 'doc_charset', 'mkt_clickid', 'mkt_network'], 'string', 'max' => 128],
            [['event_id', 'domain_userid', 'domain_sessionid'], 'string', 'max' => 36],
            [['v_tracker', 'v_collector', 'v_etl', 'geo_region_name', 'page_urlfragment', 'refr_urlquery'],
                'string', 'max' => 100],
            [['user_ipaddress'], 'string', 'max' => 45],
            [['user_fingerprint', 'refr_source', 'br_name', 'br_family', 'br_version', 'br_type',
                'br_renderengine', 'os_name', 'os_family', 'os_manufacturer', 'os_timezone', 'dvce_type'],
                'string', 'max' => 50],
            [['network_userid'], 'string', 'max' => 38],
            [['geo_country'], 'string', 'max' => 255],
            [['geo_region'], 'string', 'max' => 3],
            [['geo_city'], 'string', 'max' => 75],
            [['geo_zipcode'], 'string', 'max' => 15],
            [['page_title'], 'string', 'max' => 2000],
            [['page_urlscheme', 'refr_urlscheme'], 'string', 'max' => 16],
            [['page_urlpath', 'page_urlquery', 'refr_urlpath', 'refr_urlfragment',
                'se_category', 'se_action', 'se_label', 'se_property', 'useragent'], 'string', 'max' => 1000],
            [['refr_medium'], 'string', 'max' => 25],
            [['geo_timezone'], 'string', 'max' => 64],
            [['etl_tags'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'app_id' => Yii::t('app', 'App ID'),
            'platform' => Yii::t('app', 'Platform'),
            'etl_tstamp' => Yii::t('app', 'ETL Timestamp'),
            'collector_tstamp' => Yii::t('app', 'Collector Timestamp'),
            'dvce_tstamp' => Yii::t('app', 'Device Timestamp'),
            'event' => Yii::t('app', 'Event'),
            'event_id' => Yii::t('app', 'Event ID'),
            'txn_id' => Yii::t('app', 'Txn ID'),
            'name_tracker' => Yii::t('app', 'Name Tracker'),
            'v_tracker' => Yii::t('app', 'V Tracker'),
            'v_collector' => Yii::t('app', 'V Collector'),
            'v_etl' => Yii::t('app', 'V ETL'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_ipaddress' => Yii::t('app', 'User Ip Address'),
            'user_fingerprint' => Yii::t('app', 'User Fingerprint'),
            'domain_userid' => Yii::t('app', 'Domain User ID'),
            'domain_sessionidx' => Yii::t('app', 'Domain Session Index'),
            'network_userid' => Yii::t('app', 'Network User ID'),
            'geo_country' => Yii::t('app', 'Country'),
            'geo_region' => Yii::t('app', 'Region'),
            'geo_city' => Yii::t('app', 'City'),
            'geo_zipcode' => Yii::t('app', 'Zip Code'),
            'geo_latitude' => Yii::t('app', 'Latitude'),
            'geo_longitude' => Yii::t('app', 'Longitude'),
            'geo_region_name' => Yii::t('app', 'Region Name'),
            'page_url' => Yii::t('app', 'Page Url'),
            'page_title' => Yii::t('app', 'Page Title'),
            'page_referrer' => Yii::t('app', 'Page Referrer'),
            'page_urlscheme' => Yii::t('app', 'Page Url Scheme'),
            'page_urlhost' => Yii::t('app', 'Page Url Host'),
            'page_urlport' => Yii::t('app', 'Page Url Port'),
            'page_urlpath' => Yii::t('app', 'Page Url Path'),
            'page_urlquery' => Yii::t('app', 'Page Url Query'),
            'page_urlfragment' => Yii::t('app', 'Page Url Fragment'),
            'refr_urlscheme' => Yii::t('app', 'Referrer Url Scheme'),
            'refr_urlhost' => Yii::t('app', 'Referrer Url Host'),
            'refr_urlport' => Yii::t('app', 'Referrer Url Port'),
            'refr_urlpath' => Yii::t('app', 'Referrer Url Path'),
            'refr_urlquery' => Yii::t('app', 'Referrer Url Query'),
            'refr_urlfragment' => Yii::t('app', 'Referrer Url Fragment'),
            'refr_medium' => Yii::t('app', 'Referrer Medium'),
            'refr_source' => Yii::t('app', 'Referrer Source'),
            'refr_term' => Yii::t('app', 'Referrer Term'),
            'mkt_medium' => Yii::t('app', 'Marketing Medium'),
            'mkt_source' => Yii::t('app', 'Marketing Source'),
            'mkt_term' => Yii::t('app', 'Marketing Term'),
            'mkt_content' => Yii::t('app', 'Marketing Content'),
            'mkt_campaign' => Yii::t('app', 'Marketing Campaign'),
            'contexts' => Yii::t('app', 'Contexts'),
            'se_category' => Yii::t('app', 'Structured Event Category'),
            'se_action' => Yii::t('app', 'Structured Event Action'),
            'se_label' => Yii::t('app', 'Structured Event Label'),
            'se_property' => Yii::t('app', 'Structured Event Property'),
            'se_value' => Yii::t('app', 'Structured Event Value'),
            'unstruct_event' => Yii::t('app', 'Unstructured Event'),
            'tr_orderid' => Yii::t('app', 'Transaction Order ID'),
            'tr_affiliation' => Yii::t('app', 'Transaction Affiliation'),
            'tr_total' => Yii::t('app', 'Transaction Total'),
            'tr_tax' => Yii::t('app', 'Transaction Tax'),
            'tr_shipping' => Yii::t('app', 'Transaction Shipping'),
            'tr_city' => Yii::t('app', 'Transaction City'),
            'tr_state' => Yii::t('app', 'Transaction State'),
            'tr_country' => Yii::t('app', 'Transaction Country'),
            'ti_orderid' => Yii::t('app', 'Transaction Item Orderid'),
            'ti_sku' => Yii::t('app', 'Transaction Item Sku'),
            'ti_name' => Yii::t('app', 'Transaction Item Name'),
            'ti_category' => Yii::t('app', 'Transaction Item Category'),
            'ti_price' => Yii::t('app', 'Transaction Item Price'),
            'ti_quantity' => Yii::t('app', 'Transaction Item Quantity'),
            'pp_xoffset_min' => Yii::t('app', 'Page Ping Xoffset Min'),
            'pp_xoffset_max' => Yii::t('app', 'Page Ping Xoffset Max'),
            'pp_yoffset_min' => Yii::t('app', 'Page Ping Yoffset Min'),
            'pp_yoffset_max' => Yii::t('app', 'Page Ping Yoffset Max'),
            'useragent' => Yii::t('app', 'User Agent'),
            'br_name' => Yii::t('app', 'Browser Name'),
            'br_family' => Yii::t('app', 'Browser Family'),
            'br_version' => Yii::t('app', 'Browser Version'),
            'br_type' => Yii::t('app', 'Browser Type'),
            'br_renderengine' => Yii::t('app', 'Browser Render Engine'),
            'br_lang' => Yii::t('app', 'Browser Language'),
            'br_features_pdf' => Yii::t('app', 'Browser Features Pdf'),
            'br_features_flash' => Yii::t('app', 'Browser Features Flash'),
            'br_features_java' => Yii::t('app', 'Browser Features Java'),
            'br_features_director' => Yii::t('app', 'Browser Features Director'),
            'br_features_quicktime' => Yii::t('app', 'Browser Features Quicktime'),
            'br_features_realplayer' => Yii::t('app', 'Browser Features Realplayer'),
            'br_features_windowsmedia' => Yii::t('app', 'Browser Features Windowsmedia'),
            'br_features_gears' => Yii::t('app', 'Browser Features Gears'),
            'br_features_silverlight' => Yii::t('app', 'Browser Features Silverlight'),
            'br_cookies' => Yii::t('app', 'Browser Cookies'),
            'br_colordepth' => Yii::t('app', 'Browser Colordepth'),
            'br_viewwidth' => Yii::t('app', 'Browser Viewwidth'),
            'br_viewheight' => Yii::t('app', 'Browser Viewheight'),
            'os_name' => Yii::t('app', 'OS Name'),
            'os_family' => Yii::t('app', 'OS Family'),
            'os_manufacturer' => Yii::t('app', 'OS Manufacturer'),
            'os_timezone' => Yii::t('app', 'OS Timezone'),
            'dvce_type' => Yii::t('app', 'Device Type'),
            'dvce_ismobile' => Yii::t('app', 'Device Ismobile'),
            'dvce_screenwidth' => Yii::t('app', 'Device Screenwidth'),
            'dvce_screenheight' => Yii::t('app', 'Device Screenheight'),
            'doc_charset' => Yii::t('app', 'Document Charset'),
            'doc_width' => Yii::t('app', 'Document Width'),
            'doc_height' => Yii::t('app', 'Document Height'),
            'geo_timezone' => Yii::t('app', 'Timezone'),
            'mkt_clickid' => Yii::t('app', 'Marketing Click ID'),
            'mkt_network' => Yii::t('app', 'Marketing Network'),
            'etl_tags' => Yii::t('app', 'ETL Tags'),
            'dvce_sent_tstamp' => Yii::t('app', 'Device Sent Timestamp'),
            'domain_sessionid' => Yii::t('app', 'Domain Session ID'),
        ];
    }
}
