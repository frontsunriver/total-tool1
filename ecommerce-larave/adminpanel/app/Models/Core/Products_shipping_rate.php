<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products_shipping_rate extends Model
{
    //

    public function getshpippingRate(){

        $products_shipping = DB::table('products_shipping_rates')->where('products_shipping_status','1')->get();
        return $products_shipping;
    }


    public function updateshippingprice($re_weight_from,$re_weight_to,$re_weight_price,$products_shipping_rates_id){

       $updatePrice = DB::table('products_shipping_rates')->where('products_shipping_rates_id', $products_shipping_rates_id)->update([
            'weight_from'	 =>   $re_weight_from,
            'weight_to'		 =>   $re_weight_to,
            'weight_price'	 =>   $re_weight_price,
        ]);


        return $updatePrice;
    }

}
