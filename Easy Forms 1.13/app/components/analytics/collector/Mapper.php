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

namespace app\components\analytics\collector;

use Yii;
use yii\base\BaseObject;

/**
 * Class Mapper
 * @package app\components\analytics\collector
 */
class Mapper extends BaseObject
{

    /**
     * @var array
     */
    public $data;

    /**
     * @var array
     */
    private $properties;

    /**
     * Initializes Hit.
     */
    public function init()
    {
        /**
         * Tracker protocol: individual parameters
         */

        $this->properties = array(

            /***************************************
             * Easy Forms parameters
             ***************************************/
            "r" => "route", // Collector endPoint (not implemented)

            /***************************************
             * Application parameters
             ***************************************/

            "tna" => "name_tracker", // The tracker namespace
            "evn" => "event_vendor", // The company who developed the event model  (not implemented)
            "aid" => "app_id", // Unique identifier for website / application
            "p" => "platform", // The platform the app runs on (not implemented)

            /***************************************
             * Date / time parameters
             ***************************************/

            "dtm" => "dvce_tstamp", // Timestamp when event occurred, as recorded by client device
            "stm" => "dvce_sent_tstamp", // Timestamp when event was sent to collector by client's device
            "tz" => "os_timezone", // Timezone of client�s device OS

            /***************************************
             * Event / transaction parameters
             ***************************************/

            "e" => "event", // Event type
            "tid" => "txn_id", // Transaction ID (deprecated)
            "eid" => "event_id", // Event UUID (future)

            /***************************************
             * Tracker Version
             ***************************************/

            "tv" => "v_tracker", // Form tracker identifier

            /***************************************
             * User related parameters
             ***************************************/

            "duid" => "domain_userid", // Unique identifier per user, based on a first party cookie (specific domain)
            "nuid" => "network_userid", // Unique identifier per user, based on a third party cookie
            "tnuid" => "network_userid", // Can be used as a tracker to overwrite the nuid
            "uid" => "user_id", // Unique identifier per user, set by the business using setUserId
            "vid" => "domain_sessionidx", // Index of number of visits that this user_id has made to this domain
            "sid" => "domain_sessionid", // Unique identifier (UUID) for this visit of this user_id to this domain
            "ip" => "user_ipaddress", // IP address

            /***************************************
             * Device related properties
             ***************************************/

            "res" => "dvce_resolution", // Screen / monitor resolution

            /***************************************
             * Web-specific parameters
             ***************************************/

            "url" => "page_url", // Page URL
            "ua" => "useragent", // Useragent (a.k.a. browser string)
            "page" => "page_title", // Page title
            "refr" => "page_referrer", // Referrer URL
            "fp" => "user_fingerprint", // User identifier based on (hopefully unique) browser features
            "ctype" => "connection_type", // Type of connection
            "cookie" => "br_cookies", // Does the browser permit cookies?
            "lang" => "br_lang", // Language the browser is set to
            "f_pdf" => "br_features_pdf", // Adobe PDF plugin installed?
            "f_qt" => "br_features_quicktime", // Quicktime plugin installed?
            "f_realp" => "br_features_realplayer", // Realplayer plugin installed?
            "f_wma" => "br_features_windowsmedia", // Windows media plugin instlaled?
            "f_dir" => "br_features_director", // Director plugin installed?
            "f_fla" => "br_features_flash", // Flash plugin installed?
            "f_java" => "br_features_java", // Java plugin installed?
            "f_gears" => "br_features_gears", // Google gears installed?
            "f_ag" => "br_features_silverlight", // Silverlight plugin installed?
            "cd" => "br_colordepth", // Browser color depth
            "ds" => "doc_size", // Web page width and height
            "cs" => "doc_charset", // Web page's character encoding
            "vp" => "br_viewport", // Browser viewport width and height

            /***************************************
             * Things-specific Internet parameters
             ***************************************/

            "mac" => "mac_address", // MAC address for the device running the tracker

            /***************************************
             * Page pings
             ***************************************/

            "pp_mix" => "pp_xoffset_min", // Minimum page x offset seen in the last ping period
            "pp_max" => "pp_xoffset_max", // Maximum page x offset seen in the last ping period
            "pp_miy" => "pp_yoffset_min", // Minimum page y offset seen in the last ping period
            "pp_may" => "pp_yoffset_max", // Maximum page y offset seen in the last ping period

            /***************************************
             * Ad impression tracking
             ***************************************/

            "ad_ba" => "adi_bannerid", // Banner ID
            "ad_ca" => "adi_campaignid", // Campaign ID
            "ad_ad" => "adi_advertiserid", // Advertiser ID
            "ad_uid" => "adi_userid", // User (viewer) ID

            /***************************************
             * Ecommerce tracking / Transaction
             ***************************************/

            "tr_id" => "tr_orderid", // Order ID
            "tr_af" => "tr_affiliation", // Transaction affiliation (e.g. channel)
            "tr_tt" => "tr_total", // Transaction total value
            "tr_tx" => "tr_tax", // Transaction tax value (i.e. amount of VAT included)
            "tr_sh" => "tr_shipping", // Delivery cost charged
            "tr_ci" => "tr_city", // Delivery address: city
            "tr_st" => "tr_state", // Delivery address: state
            "tr_co" => "tr_country", // Delivery address: country
            "tr_cu" => "tr_currency", // Transaction Currency

            /***************************************
             * Ecommerce tracking / Transaction item
             ***************************************/

            "ti_id" => "ti_orderid", // Order ID
            "ti_sk" => "ti_sku", // Item SKU
            "ti_na" => "ti_name", // Item name
            "ti_ca" => "ti_category", // Item category
            "ti_pr" => "ti_price", // Item price
            "ti_qu" => "ti_quantity", // Item quantity
            "ti_cu" => "ti_currency", // Currency

            /***************************************
             * Social tracking
             ***************************************/

            "sa" => "social_action", // Social action performed
            "sn" => "social_network", // Social network involved
            "st" => "social_target", // Social action target e.g. object liked, article tweeted
            "sp" => "social_pagepath", // Page path action was performed on
            
            /***************************************
             * Custom structured event tracking
             ***************************************/

            "se_ca" => "se_category", // Category of event
            "se_ac" => "se_action", // Action / event itself
            "se_la" => "se_label", // Label often used to refer to the 'object' in which the action is performed
            "se_pr" => "se_property", // Property associated either with the action or the object
            "se_va" => "se_value", // Value associated with the user action

            /***************************************
             * Custom unstructured event tracking
             ***************************************/

            "ue_pr" => "unstruct_event", // JSON - Event properties
            "ue_px" => "unstruct_event", // JSON - Event properties

            /***************************************
             * Custom contexts
             ***************************************/

            "cv" => "context_vendor", // Vendor for the custom contexts
            "co" => "context", // An array of custom contexts
            "cx" => "context", // An array of custom contexts

        );
    }

    /**
     * Map tracker params to model properties
     *
     * @param Event $event
     */
    public function map(Event $event)
    {
        $data = $event->getData();

        $newData = array();

        foreach ($data as $key => $value) {
            $newData[$this->properties[$key]] = $value;
        }

        $this->data = $newData;

    }

    public function getData()
    {
        return $this->data;
    }
}
