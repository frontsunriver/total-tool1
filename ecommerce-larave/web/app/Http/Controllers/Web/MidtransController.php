<?php
namespace App\Http\Controllers\Web;

// namespace Midtrans;

//use Mail;
//validator is builtin class in laravel
use App\Http\Controllers\Web\CartController;
//for password encryption or hash protected
use App\Http\Controllers\Web\ShippingAddressController;

//for authenitcate login data
use App\Models\Web\Cart;
use App\Models\Web\Currency;

//for requesting a value
use App\Models\Web\Index;
use App\Models\Web\Languages;
use App\Models\Web\Order;
use App\Models\Web\Products;
use App\Models\Web\Shipping;

//for Carbon a value
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Lang;
use Session;
use DB;

//email
class MidtransController extends Controller
{

    public function __construct(
        Order $order
    ) {
        $this->order = $order;
    }

    //midtransTransaction
    public function midtransTransaction(REQUEST $request){
        try{

            $payments_setting = $this->order->payments_setting_for_midtrans(); 
            
            $payments_setting['server_key']->value;

            $file = require_once app_path('midtrans/autoload.php');

            \Midtrans\Config::$serverKey = $payments_setting['client_key']->value;
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            //Set Your server key
            //Config::$serverKey = "SB-Mid-server-PS1pCA6YyvbMjnxCcIEVnkOj";
            // $serverKey = "SB-Mid-server-PS1pCA6YyvbMjnxCcIEVnkOj";

            // Uncomment for production environment
            // Config::$isProduction = true;

            // Enable sanitization
            // Config::$isSanitized = true;
            $isSanitized = true;

            // Enable 3D-Secure
            // Config::$is3ds = true;
            $is3ds = true;

            // Required
            $transaction_details = array(
                'order_id' => rand(),
                'gross_amount' => session('total_price'), // no decimal allowed for creditcard
            );

            $country = DB::table('countries')->where('countries_id', '=', session('billing_address')->billing_countries_id)->get();
            $billing_country = $country[0]->countries_iso_code_3;

            // Optional
            $billing_address = array(
                'first_name'    => session('billing_address')->billing_firstname,
                'last_name'     => session('billing_address')->billing_lastname,
                'address'       => session('billing_address')->billing_street,
                'city'          => session('billing_address')->billing_city,
                'postal_code'   => session('billing_address')->billing_zip,
                'phone'         => session('billing_address')->billing_phone,
                'country_code'  => $billing_country
            );

            $country = DB::table('countries')->where('countries_id', '=', session('shipping_address')->countries_id)->get();
            $country = $country[0]->countries_iso_code_3;

            // Optional
            $shipping_address = array(
                'first_name'    => session('shipping_address')->firstname,
                'last_name'     => session('shipping_address')->lastname,
                'address'       => session('shipping_address')->street,
                'city'          => session('shipping_address')->city,
                'postal_code'   => session('shipping_address')->postcode,
                'phone'         => session('shipping_address')->delivery_phone,
                'country_code'  => $country
            );

            if(Auth::guard('customer')->check()){
                $email = auth()->guard('customer')->user()->email;
            }else{
                $email = session('shipping_address')->email;          
            }

            // Optional
            $customer_details = array(
                'first_name'    => session('shipping_address')->firstname,
                'last_name'     => session('shipping_address')->lastname,
                'email'         => $email,
                'phone'         => session('shipping_address')->delivery_phone,
                'billing_address'  => $billing_address,
                'shipping_address' => $shipping_address
            );

            // Optional, remove this to display all available payment methods
            $enable_payments = array('credit_card','cimb_clicks','mandiri_clickpay','echannel');

            // Fill transaction details
            $transaction = array(
            // 'enabled_payments' => $enable_payments,
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
            );

            $snapToken = \Midtrans\Snap::getSnapToken($transaction);

            $reponse = json_encode(array('status'=>1, 'message'=>'', 'token'=>$snapToken));
            print $reponse;

        }catch (Exception $e) {
           $reponse = json_encode(array('status'=>0, 'message'=>$e->getMessage(), 'token'=>''));
           print $reponse;
        }
    }
    

    


}
