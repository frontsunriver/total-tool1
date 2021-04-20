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

namespace app\components\analytics\enricher;

use Yii;

/**
 * Class Enricher
 * @package app\components\analytics\enricher
 */
class Enricher
{

    public $rawData;
    public $enrichedData;
    public $data;

    public function setData(array $rawData)
    {
        $this->data = $rawData;
    }

    public function getData()
    {
        return $this->data;
    }

    public function process()
    {

        if (!isset($this->data)) {
            throw new \Exception(Yii::t("app", "No data processing."));
        };

        // Add data
        if (isset($this->data["useragent"])) {
            $enricher = new UserAgentEnrichment($this->data["useragent"]);
            $this->data = $this->data + $enricher->getData();
        }
        if (isset($this->data["user_ipaddress"])) {
            $enricher = new IpLookupsEnrichment($this->data["user_ipaddress"]);
            $this->data = $this->data + $enricher->getData();
        }
        if (isset($this->data["page_url"])) {
            if (isset($this->data["page_referrer"])) {
                $enricher = new UrlEnrichment($this->data["page_url"], $this->data["page_referrer"]);
            } else {
                $enricher = new UrlEnrichment($this->data["page_url"], null);
            }
            $this->data = $this->data + $enricher->getData();
        }

        // Manipulate data
        if (isset($this->data["dvce_tstamp"])) {
            // Device and operating system fields
            $this->data["dvce_tstamp"] = $this->convertMicrotimeToUnixTimestamp($this->data["dvce_tstamp"]);
        }
        if (isset($this->data["dvce_sent_tstamp"])) {
            // Device and operating system fields
            $this->data["dvce_sent_tstamp"] = $this->convertMicrotimeToUnixTimestamp($this->data["dvce_sent_tstamp"]);
        }
        if (isset($this->data["dvce_resolution"])) {
            $resolution = explode("x", $this->data["dvce_resolution"]);
            // Device and operating system fields
            $this->data["dvce_screenwidth"] = isset($resolution[0]) ? $resolution[0] : null ;
            $this->data["dvce_screenheight"] = isset($resolution[1]) ? $resolution[1] : null;
        }
        if (isset($this->data["br_viewport"])) {
            $viewport = explode("x", $this->data["br_viewport"]);
            // Browser
            $this->data["br_viewwidth"] = isset($viewport[0]) ? $viewport[0] : null ;
            $this->data["br_viewheight"] = isset($viewport[1]) ? $viewport[1] : null;
        }
        if (isset($this->data["doc_size"])) {
            $size = explode("x", $this->data["doc_size"]);
            // Document
            $this->data["doc_width"] = isset($size[0]) ? $size[0] : null ;
            $this->data["doc_height"] = isset($size[1]) ? $size[1] : null;
        }

        return $this->data;

    }

    /**
     * Convert microtime to Unix timestamp
     *
     * Note: Convert Javascript new Date().getTime() to Unic timestamp (remove microseconds)
     *
     * @param $microtime
     * @return int
     */
    public function convertMicrotimeToUnixTimestamp($microtime)
    {
        return $microtime;
        // Removed by errors when a milisecond ends in 000
        // $time = $microtime / 1000;
        // list($seconds, $numeric_after_point) = explode(".", $time);
        // return $seconds;
    }
}
