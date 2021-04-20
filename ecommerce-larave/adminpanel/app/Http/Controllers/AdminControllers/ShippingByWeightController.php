<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Products_shipping_rate;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ShippingByWeightController extends Controller
{
    //
    public function __construct(Products_shipping_rate $products_shipping_rate, Setting $setting)
    {
        $this->Products_shipping_rate = $products_shipping_rate;
        $this->Setting = $setting;
    }

    public function shppingbyweight(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.shppingbyweight"));
        $products_shipping = $this->Products_shipping_rate->getshpippingRate();
        $result['products_shipping'] = $products_shipping;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.shippingmethods.shppingbyweight", $title)->with('result', $result);
    }

    public function updateShppingWeightPrice(Request $request)
    {
        for ($i = 0; $i <= 4; $i++) {
            $weight_from = 'weight_from_' . $i;
            $weight_to = 'weight_to_' . $i;
            $weight_price = 'weight_price_' . $i;
            print $request->$weight_from;
            $products_shipping_rates_id = $i + 1;
            $re_weight_from = $request->$weight_from;
            $re_weight_to = $request->$weight_to;
            $re_weight_price = $request->$weight_price;
            $this->Products_shipping_rate->updateshippingprice($re_weight_from, $re_weight_to, $re_weight_price, $products_shipping_rates_id);
        }
        
        $message = Lang::get("labels.WeightPriceUpdatedSuccessMessage");
        return redirect()->back()->withErrors([$message]);
    }

}
