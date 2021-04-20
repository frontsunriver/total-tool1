<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Languages;
use App\Models\Core\Setting;
use App\Models\Core\Shipping_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ShippingMethodsController extends Controller
{
    //
    public function __construct(Shipping_method $shipping_method, Setting $setting, Languages $languages)
    {
        $this->Shipping_method = $shipping_method;
        $this->Setting = $setting;
        $this->Languages = $languages;
    }

    public function display(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ShippingMethods"));

        if (!empty($request->id)) {
            if ($request->active == 'no') {
                $status = '0';
            } elseif ($request->active == 'yes') {
                $status = '1';
            }
            $this->Shipping_method->updateshipingStatus($request, $status);
        }

        $shipping_methods = $this->Shipping_method->shipingMethod();
        $result['shipping_methods'] = $shipping_methods;

        //ups data
        $ups_shipping['ups_shipping'] = $this->Shipping_method->ups_shipping();
        $ups_shipping['ups_description'] = $this->Shipping_method->upsDescription();
        $result['ups_shipping'] = $ups_shipping;

        //flatrate
        $flate_rate['flate_rate'] = $this->Shipping_method->flateRate();
        $flate_rate['flatrate_description'] = $this->Shipping_method->flateRateDescription();

        $result['flate_rate'] = $flate_rate;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.shippingmethods.index", $title)->with('result', $result);

    }

    //upsShipping
    public function upsShipping(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.UPSShipping"));
        $pickupType = '01';

        //ups data
        $ups_shipping['ups_shipping'] = $this->Shipping_method->ups_shipping();
        $ups_shipping['ups_description'] = $this->Shipping_method->upsDescription();
        $result['ups_shipping'] = $ups_shipping;

        $countries = $this->Shipping_method->countriues();
        $result['countries'] = $countries;

        $shipping_methods = $this->Shipping_method->shipingMethopd();
        $result['shipping_methods'] = $shipping_methods;

        //get function from other controller
        $result['languages'] = $this->Languages->getter();

        $description_data = array();
        $description_labels = array();
        foreach ($result['languages'] as $languages_data) {
            $description = $this->Shipping_method->description($languages_data, $shipping_methods);

            if (count($description) > 0) {
                $sub_labels = json_decode($description[0]->sub_labels);
                $description_data[$languages_data->languages_id]['name'] = $description[0]->name;

                $description_data[$languages_data->languages_id]['nextDayAir'] = $sub_labels->nextDayAir;
                $description_data[$languages_data->languages_id]['secondDayAir'] = $sub_labels->secondDayAir;
                $description_data[$languages_data->languages_id]['ground'] = $sub_labels->ground;
                $description_data[$languages_data->languages_id]['threeDaySelect'] = $sub_labels->threeDaySelect;
                $description_data[$languages_data->languages_id]['nextDayAirSaver'] = $sub_labels->nextDayAirSaver;
                $description_data[$languages_data->languages_id]['nextDayAirEarlyAM'] = $sub_labels->nextDayAirEarlyAM;
                $description_data[$languages_data->languages_id]['secondndDayAirAM'] = $sub_labels->secondndDayAirAM;

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['name'] = '';

                $description_data[$languages_data->languages_id]['nextDayAir'] = '';
                $description_data[$languages_data->languages_id]['secondDayAir'] = '';
                $description_data[$languages_data->languages_id]['ground'] = '';
                $description_data[$languages_data->languages_id]['threeDaySelect'] = '';
                $description_data[$languages_data->languages_id]['nextDayAirSaver'] = '';
                $description_data[$languages_data->languages_id]['nextDayAirEarlyAM'] = '';
                $description_data[$languages_data->languages_id]['secondndDayAirAM'] = '';

                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }
        $result['description'] = $description_data;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.shippingmethods.upsshipping", $title)->with('result', $result);
    }

    public function flaterate(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.FlateRate"));
        $shipping_methods = $this->Shipping_method->shipingMethods();
        $result['flate_rate'] = $shipping_methods;

        $shipping_methods = $this->Shipping_method->shipingMethod4();
        $result['shipping_methods'] = $shipping_methods;

        //get function from other controller

        $result['languages'] = $this->Languages->getter();

        $description_data = array();
        foreach ($result['languages'] as $languages_data) {

            $description = $this->Shipping_method->description($languages_data, $shipping_methods);

            if (count($description) > 0) {
                $description_data[$languages_data->languages_id]['name'] = $description[0]->name;
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['name'] = '';
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }

        $result['description'] = $description_data;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.shippingmethods.flateRate", $title)->with('result', $result);

    }

    public function updateflaterate(Request $request)
    {

        $this->Shipping_method->updateflaterate($request);
        $this->Shipping_method->updateShipingMethodStatus($request);
        $table_name = $request->table_name;

        //get function from other controller
        $languages = $this->Languages->getter();
        foreach ($languages as $languages_data) {
            $name = 'name_' . $languages_data->languages_id;
            $content = array();

            $checkExist = $this->Shipping_method->CheckExit($table_name, $languages_data);
            if (count($checkExist) > 0) {
                $languages_data_id = $languages_data->languages_id;
                $request_name = $request->$name;

                $this->Shipping_method->shipingDescription($table_name, $languages_data_id, $request_name);
            } else {
                $languages_data_id = $languages_data->languages_id;
                $request_name = $request->$name;

                $this->Shipping_method->insertDescription($request_name, $languages_data_id, $table_name);
            }
        }
        $message = Lang::get("labels.InformationUpdatedMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public function updateUpsshipping(Request $request)
    {
        $this->Shipping_method->insterUPS($request);
        $this->Shipping_method->updateUPSstatus($request);
        $table_name = $request->table_name;

        //get function from other controller
        $languages = $this->Languages->getter();
        foreach ($languages as $languages_data) {
            $name = 'name_' . $languages_data->languages_id;
            $nextDayAir = 'nextDayAir_' . $languages_data->languages_id;
            $secondDayAir = 'secondDayAir_' . $languages_data->languages_id;
            $ground = 'ground_' . $languages_data->languages_id;
            $threeDaySelect = 'threeDaySelect_' . $languages_data->languages_id;
            $nextDayAirSaver = 'nextDayAirSaver_' . $languages_data->languages_id;
            $nextDayAirEarlyAM = 'nextDayAirEarlyAM_' . $languages_data->languages_id;
            $secondndDayAirAM = 'secondndDayAirAM_' . $languages_data->languages_id;

            $sub_labels = array(
                'nextDayAir' => $request->$nextDayAir,
                'secondDayAir' => $request->$secondDayAir,
                'ground' => $request->$ground,
                'threeDaySelect' => $request->$threeDaySelect,
                'nextDayAirSaver' => $request->$nextDayAirSaver,
                'nextDayAirEarlyAM' => $request->$nextDayAirEarlyAM,
                'secondndDayAirAM' => $request->$secondndDayAirAM,
            );

            $checkExist = $this->Shipping_method->CheckExit($table_name, $languages_data);
            if (count($checkExist) > 0) {
                $languages_data_id = $languages_data->languages_id;
                $request_name = $request->$name;
                $this->Shipping_method->updateUPSshippingDescription($table_name, $languages_data_id, $request_name, $sub_labels);
            } else {
                $request_name = $request->$name;
                $languages_data_id = $languages_data->languages_id;
                $this->Shipping_method->insertUPSinsetDesctription($request_name, $sub_labels, $languages_data_id, $table_name);
            }
        }
        $message = Lang::get("labels.InformationAddedMessage");
        return redirect()->back()->withErrors([$message]);

    }

    //addNewTaxRate
    public function defaultShippingMethod(Request $request)
    {
        $this->Shipping_method->defualtshipingMethod();
        $this->Shipping_method->DefualtshipingMethod1($request);
        $message = 'changed';
        return $message;
    }

    //shipping_detail
    public function detail(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.FlateRate"));
        $result = array();
        $result['message'] = array();

        //get function from other controller

        $result['languages'] = $this->Languages->getter();

        $shppingMethods = $this->Shipping_method->getshippingMethod($request);

        $description_data = array();
        foreach ($result['languages'] as $languages_data) {

            $languages_data_id = $languages_data->languages_id;

            $table_name = $request->table_name;

            $description = $this->Shipping_method->getdescription($languages_data_id, $table_name);

            if (count($description) > 0) {
                $description_data[$languages_data->languages_id]['name'] = $description[0]->name;
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['name'] = '';
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }

        $result['description'] = $description_data;
        $result['shppingMethods'] = $shppingMethods;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.shippingmethods.detail", $title)->with('result', $result);

    }

    public function update(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditMainCategories"));
        $last_modified = date('y-m-d h:i:s');
        $table_name = $request->table_name;
        $result = array();

        //get function from other controller
        $languages = $this->Languages->getter();

        foreach ($languages as $languages_data) {
            $name = 'name_' . $languages_data->languages_id;
            $languages_data_id = $languages_data->languages_id;
            $checkExist = $this->Shipping_method->updatecheckExit($table_name, $languages_data_id);
            if (count($checkExist) > 0) {
                $re_name = $request->$name;
                $languages_data_id = $languages_data->languages_id;
                $this->Shipping_method->ifcheckIsSet($table_name, $languages_data_id, $re_name);
            } else {
                $re_name = $request->$name;
                $languages_data_id = $languages_data->languages_id;
                $this->Shipping_method->ifnotsetcheck($re_name, $languages_data_id, $table_name);
            }
        }

        $message = Lang::get("labels.shippingUpdateMessage");
        return redirect()->back()->withErrors([$message]);

    }

}
