<?php

use yii\db\Schema;
use yii\db\Migration;

class m150420_183546_init_stats extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        /**
         * Event and Logs tables
         */
        $eventScheme = [
            // App
            'app_id'                    => Schema::TYPE_STRING . '(255) NOT NULL',
            'platform'                  => Schema::TYPE_STRING . '(255)',

            // Date/time
            'etl_tstamp'                => Schema::TYPE_INTEGER . '(11)',
            'collector_tstamp'          => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'dvce_tstamp'               => Schema::TYPE_BIGINT,

            // Event
            'event'                     => Schema::TYPE_STRING . '(128)',
            'event_id'                  => Schema::TYPE_STRING . '(36)',
            'txn_id'                    => Schema::TYPE_INTEGER,

            // Versioning
            'name_tracker'              => Schema::TYPE_STRING . '(128)',
            'v_tracker'                 => Schema::TYPE_STRING . '(100)',
            'v_collector'               => Schema::TYPE_STRING . '(100) NOT NULL',
            'v_etl'                     => Schema::TYPE_STRING . '(100)',

            // User and visit
            'user_id'                   => Schema::TYPE_STRING . '(255)',
            'user_ipaddress'            => Schema::TYPE_STRING . '(45)',
            'user_fingerprint'          => Schema::TYPE_STRING . '(50)',
            'domain_userid'             => Schema::TYPE_STRING . '(36)',
            'domain_sessionidx'         => Schema::TYPE_SMALLINT,
            'network_userid'            => Schema::TYPE_STRING . '(38)',

            // Location
            'geo_country'               => Schema::TYPE_STRING . '(255)',
            'geo_region'                => Schema::TYPE_STRING . '(3)',
            'geo_city'                  => Schema::TYPE_STRING . '(75)',
            'geo_zipcode'               => Schema::TYPE_STRING . '(15)',
            'geo_latitude'              => Schema::TYPE_DOUBLE,
            'geo_longitude'             => Schema::TYPE_DOUBLE,
            'geo_region_name'           => Schema::TYPE_STRING . '(100)',

            // Page
            'page_url'                  => Schema::TYPE_TEXT,
            'page_title'                => Schema::TYPE_STRING . '(2000)',
            'page_referrer'             => Schema::TYPE_TEXT,

            // Page URL components
            'page_urlscheme'            => Schema::TYPE_STRING . '(16)',
            'page_urlhost'              => Schema::TYPE_STRING . '(255)',
            'page_urlport'              => Schema::TYPE_INTEGER,
            'page_urlpath'              => Schema::TYPE_STRING . '(1000)',
            'page_urlquery'             => Schema::TYPE_STRING . '(1000)',
            'page_urlfragment'          => Schema::TYPE_STRING . '(100)',

            // Referrer URL components
            'refr_urlscheme'            => Schema::TYPE_STRING . '(16)',
            'refr_urlhost'              => Schema::TYPE_STRING . '(255)',
            'refr_urlport'              => Schema::TYPE_INTEGER,
            'refr_urlpath'              => Schema::TYPE_STRING . '(1000)',
            'refr_urlquery'             => Schema::TYPE_STRING . '(100)',
            'refr_urlfragment'          => Schema::TYPE_STRING . '(1000)',

            // Referrer details
            'refr_medium'               => Schema::TYPE_STRING . '(25)',
            'refr_source'               => Schema::TYPE_STRING . '(50)',
            'refr_term'                 => Schema::TYPE_STRING . '(255)',

            // Marketing
            'mkt_medium'                => Schema::TYPE_STRING . '(255)',
            'mkt_source'                => Schema::TYPE_STRING . '(255)',
            'mkt_term'                  => Schema::TYPE_STRING . '(255)',
            'mkt_content'               => Schema::TYPE_STRING . '(255)',
            'mkt_campaign'              => Schema::TYPE_STRING . '(255)',

            // Custom context
            "contexts"                  => Schema::TYPE_TEXT,

            // Custom structured event
            "se_category"               => Schema::TYPE_STRING . '(1000)',
            "se_action"                 => Schema::TYPE_STRING . '(1000)',
            "se_label"                  => Schema::TYPE_STRING . '(1000)',
            "se_property"               => Schema::TYPE_STRING . '(1000)',
            "se_value"                  => Schema::TYPE_DOUBLE,

            // Custom unstructured event
            "unstruct_event"            => Schema::TYPE_TEXT,

            // Ecommerce
            "tr_orderid"                => Schema::TYPE_STRING . '(255)',
            "tr_affiliation"            => Schema::TYPE_STRING . '(255)',
            "tr_total"                  => Schema::TYPE_DECIMAL. '(18,2)',
            "tr_tax"                    => Schema::TYPE_DECIMAL. '(18,2)',
            "tr_shipping"               => Schema::TYPE_DECIMAL. '(18,2)',
            "tr_city"                   => Schema::TYPE_STRING . '(255)',
            "tr_state"                  => Schema::TYPE_STRING . '(255)',
            "tr_country"                => Schema::TYPE_STRING . '(255)',
            "ti_orderid"                => Schema::TYPE_STRING . '(255)',
            "ti_sku"                    => Schema::TYPE_STRING . '(255)',
            "ti_name"                   => Schema::TYPE_STRING . '(255)',
            "ti_category"               => Schema::TYPE_STRING . '(255)',
            "ti_price"                  => Schema::TYPE_DECIMAL. '(18,2)',
            "ti_quantity"               => Schema::TYPE_INTEGER,

            // Page ping
            "pp_xoffset_min"            => Schema::TYPE_INTEGER,
            "pp_xoffset_max"            => Schema::TYPE_INTEGER,
            "pp_yoffset_min"            => Schema::TYPE_INTEGER,
            "pp_yoffset_max"            => Schema::TYPE_INTEGER,

            // User Agent
            'useragent'                 => Schema::TYPE_STRING . '(1000)',

            // Browser
            'br_name'                   => Schema::TYPE_STRING . '(50)',
            'br_family'                 => Schema::TYPE_STRING . '(50)',
            'br_version'                => Schema::TYPE_STRING . '(50)',
            'br_type'                   => Schema::TYPE_STRING . '(50)',
            'br_renderengine'           => Schema::TYPE_STRING . '(50)',
            'br_lang'                   => Schema::TYPE_STRING . '(255)',
            'br_features_pdf'           => Schema::TYPE_BOOLEAN,
            'br_features_flash'         => Schema::TYPE_BOOLEAN,
            'br_features_java'          => Schema::TYPE_BOOLEAN,
            'br_features_director'      => Schema::TYPE_BOOLEAN,
            'br_features_quicktime'     => Schema::TYPE_BOOLEAN,
            'br_features_realplayer'    => Schema::TYPE_BOOLEAN,
            'br_features_windowsmedia'  => Schema::TYPE_BOOLEAN,
            'br_features_gears'         => Schema::TYPE_BOOLEAN,
            'br_features_silverlight'   => Schema::TYPE_BOOLEAN,
            'br_cookies'                => Schema::TYPE_BOOLEAN,
            'br_colordepth'             => Schema::TYPE_STRING,
            'br_viewwidth'              => Schema::TYPE_INTEGER,
            'br_viewheight'             => Schema::TYPE_INTEGER,

            // Operating System
            'os_name'                   => Schema::TYPE_STRING . '(50)',
            'os_family'                 => Schema::TYPE_STRING . '(50)',
            'os_manufacturer'           => Schema::TYPE_STRING . '(50)',
            'os_timezone'               => Schema::TYPE_STRING . '(50)',

            // Device/Hardware
            'dvce_type'                 => Schema::TYPE_STRING . '(50)',
            'dvce_ismobile'             => Schema::TYPE_BOOLEAN,
            'dvce_screenwidth'          => Schema::TYPE_INTEGER,
            'dvce_screenheight'         => Schema::TYPE_INTEGER,

            // Document
            'doc_charset'               => Schema::TYPE_STRING . '(128)',
            'doc_width'                 => Schema::TYPE_INTEGER,
            'doc_height'                => Schema::TYPE_INTEGER,

            // Geolocation
            'geo_timezone'              => Schema::TYPE_STRING . '(64)',

            // Click ID
            'mkt_clickid'               => Schema::TYPE_STRING . '(128)',
            'mkt_network'               => Schema::TYPE_STRING . '(128)',

            // ETL tags
            'etl_tags'                  => Schema::TYPE_STRING . '(500)',

            // Time event was sent
            'dvce_sent_tstamp'          => Schema::TYPE_BIGINT,

            // Session ID
            'domain_sessionid'          => Schema::TYPE_STRING . '(36)'

        ];
        $this->createTable('{{%event}}', $eventScheme, $tableOptions);
        $this->createTable('{{%log_event}}', $eventScheme, $tableOptions);

        $this->createTable('{{%stats_submissions}}', [
            // App
            'app_id'                    => Schema::TYPE_STRING . '(255) NOT NULL',

            // Date/time
            'collector_tstamp'          => Schema::TYPE_INTEGER . '(11) NOT NULL',

            // User and sessions
            'domain_sessionidx'         => Schema::TYPE_SMALLINT,

            // Location
            'geo_country'               => Schema::TYPE_STRING . '(255)',
            'geo_city'                  => Schema::TYPE_STRING . '(75)',

            // Referrer URL components
            'refr_urlhost'              => Schema::TYPE_STRING . '(255)',

            // Referrer details
            'refr_medium'               => Schema::TYPE_STRING . '(25)',

            // Browser
            'br_family'                 => Schema::TYPE_STRING . '(50)',

            // Operating System
            'os_family'                 => Schema::TYPE_STRING . '(50)',

            // Device/Hardware
            'dvce_type'                 => Schema::TYPE_STRING . '(50)',
            'dvce_ismobile'             => Schema::TYPE_BOOLEAN,

        ], $tableOptions);

        $this->createTable('{{%stats_performance}}', [
            'day'                       => Schema::TYPE_DATE . ' NOT NULL',
            'app_id'                    => Schema::TYPE_STRING . '(255) NOT NULL',
            'users'                     => Schema::TYPE_INTEGER,
            'fills'                     => Schema::TYPE_INTEGER,
            'conversions'               => Schema::TYPE_INTEGER,
            'conversionTime'            => Schema::TYPE_BIGINT . ' UNSIGNED',
        ], $tableOptions);

        $this->createIndex("{{%stats_performance_day_app_id}}", "{{%stats_performance}}", ["day", "app_id"], true);

    }

    public function safeDown()
    {

        // Builds and executes a SQL statement for dropping a DB table.
        $this->dropTable('{{%stats_performance}}');
        $this->dropTable('{{%stats_submissions}}');
        $this->dropTable('{{%log_event}}');
        $this->dropTable('{{%event}}');

    }
}
