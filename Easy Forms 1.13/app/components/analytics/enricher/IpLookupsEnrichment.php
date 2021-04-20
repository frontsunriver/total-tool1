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
use Exception;
use GeoIp2\Database\Reader;

/**
 * Class IpLookupsEnrichment
 * @package app\components\analytics\enricher
 */
class IpLookupsEnrichment
{

    /** @var \GeoIp2\Model\City GeoIP2 City model */
    private $record;

    public function __construct($ip)
    {

        $geoIpFile = Yii::getAlias('@app/components/analytics/enricher/GeoIP/GeoLite2-City.mmdb');

        // Check if GeoIP file exists and is readable
        if (is_readable($geoIpFile)) {
            try {
                $reader = new Reader($geoIpFile);
                $this->record = $reader->city($ip);
            } catch (Exception $e) {
                $this->record = null;
            }
        }
    }

    public function getData()
    {
        $data = array();

        if (isset($this->record)) {
            // Location fields
            $data["geo_country"] = $this->record->country->name;
            $data["geo_region"] = $this->record->mostSpecificSubdivision->isoCode;
            $data["geo_city"] = $this->record->city->name;
            $data["geo_zipcode"] = $this->record->postal->code;
            $data["geo_latitude"] = $this->record->location->latitude;
            $data["geo_longitude"] = $this->record->location->longitude;
            $data["geo_region_name"] = $this->record->mostSpecificSubdivision->name;
            $data["geo_timezone"] = $this->record->location->timeZone;
            // Aditionals
            $data["geo_continent_name"] = $this->record->continent->name;
            $data["geo_continent"] = $this->record->continent->code;
            $data["geo_country_name"] = $this->record->country->name;
            $data["geo_dmacode"] = $this->record->location->metroCode;
        }

        $data = array_filter($data, function ($v) {
            return !is_null($v);
        });

        return $data;

    }
}
