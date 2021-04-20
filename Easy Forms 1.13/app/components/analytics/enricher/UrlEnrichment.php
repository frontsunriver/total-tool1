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

use Snowplow\RefererParser\Parser;

/**
 * Class UrlEnrichment
 * @package app\components\analytics\enricher
 */
class UrlEnrichment
{
    public $url;
    public $referrer;
    public $referrerParsed;

    public function __construct($url, $referrer)
    {
        $this->url = isset($url) ? parse_url($url) : null;
        $this->referrer = isset($referrer) ? parse_url($referrer) : null;

        $refererParser = new Parser();
        $this->referrerParsed = isset($url) && isset($referrer) ? $refererParser->parse($referrer, $url) : null;
    }

    // Web-specific fields
    public function getData()
    {
        $data = array();

        if (isset($this->url)) {
            $data["page_urlscheme"] = isset($this->url["scheme"]) ? $this->url["scheme"] : null;
            $data["page_urlhost"] = isset($this->url["host"]) ? $this->url["host"] : null;
            $data["page_urlport"] = isset($this->url["port"]) ? $this->url["port"] : null;
            $data["page_urlpath"] = isset($this->url["path"]) ? $this->url["path"] : null;
            $data["page_urlquery"] = isset($this->url["query"]) ? $this->url["query"] : null;
            $data["page_urlfragment"] = isset($this->url["fragment"]) ? $this->url["fragment"] : null;
        }

        if (isset($this->referrer)) {
            $data["refr_urlscheme"] = isset($this->referrer["scheme"]) ? $this->referrer["scheme"] : null;
            $data["refr_urlhost"] = isset($this->referrer["host"]) ? $this->referrer["host"] : null;
            $data["refr_urlport"] = isset($this->referrer["port"]) ? $this->referrer["port"] : null;
            $data["refr_urlpath"] = isset($this->referrer["path"]) ? $this->referrer["path"] : null;
            $data["refr_urlquery"] = isset($this->referrer["query"]) ? $this->referrer["query"] : null;
            $data["refr_urlfragment"] = isset($this->referrer["fragment"]) ? $this->referrer["fragment"] : null;
        }

        if (isset($this->referrerParsed)) {
            $data["refr_medium"] = $this->referrerParsed->getMedium();
            $data["refr_source"] = $this->referrerParsed->getSource();
            $data["refr_term"] = $this->referrerParsed->getSearchTerm();
        }

        $data = array_filter($data, function ($v) {
            return !is_null($v);
        });

        return $data;

    }
}
