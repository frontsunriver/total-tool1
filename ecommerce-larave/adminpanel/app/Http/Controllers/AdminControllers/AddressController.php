<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{

    public function getzones(Request $request)
    {
        $getZones = array();
        $getZones = DB::table('zones')->where('zone_country_id', $request->country_zone_id)->get();
        if (count($getZones) > 0) {
            $responseData = array('success' => '1', 'data' => $getZones, 'message' => "Returned all states.");
        } else {

            $responseData = array('success' => '0', 'data' => $getZones, 'message' => "Returned all states.");
        }
        $zoneResponse = json_encode($responseData);
        print $zoneResponse;
    }

    public function getAllCountries()
    {
        $allCountries = DB::table('countries')->get();
        return ($allCountries);
    }

}
