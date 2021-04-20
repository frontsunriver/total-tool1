<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Setting;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class Payments_setting extends Model
{
    //
    protected $table = 'payment_methods';

    public function paymentmethods(){
        $shipping_methods = Payments_setting::leftJoin('payment_description', 'payment_description.payment_methods_id', '=', 'payment_methods.payment_methods_id')
        ->where('language_id', 1)->get();
        return $shipping_methods;
    }

    public function brainTree($languages_data,$shipping_methods){

        $braintree = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->braintree_name],
        ])->get();

        return $braintree;

    }

    public function StripeFetch($languages_data,$shipping_methods){

        $stripe = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->stripe_name],
        ])->get();

        return $stripe;
    }

    public function fetchPayPal($languages_data,$shipping_methods){

        $paypal = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->paypal_name],
        ])->get();
        return $paypal;
    }


    public function Code($languages_data,$shipping_methods){

        $cod = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->cod_name],
        ])->get();

        return $cod;
    }

    public function cybersource($languages_data,$shipping_methods){

        $cybersource = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->cybersource_name],
        ])->get();

        return $cybersource;
    }

    public function fetchinstamojo($languages_data,$shipping_methods){

        $instamojo = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->instamojo_name],
        ])->get();

        return $instamojo;

    }

    public function HyperPay($languages_data,$shipping_methods){

        $hyperpay = DB::table('payment_description')->where([
            ['language_id', '=', $languages_data->languages_id],
            ['payment_name', '=', $shipping_methods[0]->hyperpay_name],
        ])->get();

        return $hyperpay;
    }

    public function active($request){
      $check = DB::table('payment_methods')
                  ->where('payment_methods_id',$request->method_id)
                  ->first();

      if($check->status == 1){
        $status = 0;
      }
      else{
        $status = 1;
      }

      DB::table('payment_methods')
          ->where('payment_methods_id',$request->method_id)
          ->update([
            'status' => $status,
          ]);
    }

    public function updaterecord($request){
      $id = $request->id;
      if($id == 8){
        $oldkeyvalue = DB::table('payment_methods_detail')
                    ->where('payment_methods_id',8)
                    ->where('key','current_domain_name')
                    ->first();
        $oldkey = $oldkeyvalue->value.'/paytm-callback';
      }
      $result = DB::table('payment_methods_detail')->where('payment_methods_detail.payment_methods_id',$request->id)->get();
       foreach($result as $res){
            $val = 'field_'.$res->key;
           if($val != 'field_paystack_callback_url'){
            DB::table('payment_methods_detail')
              ->where('payment_methods_id',$id)
              ->where('key',$res->key)
              ->update([
                'value' => $request->$val,
              ]);
           }
        
       }
       if($id == 8){
         $newkeyvalue = DB::table('payment_methods_detail')
                     ->where('payment_methods_id',8)
                     ->where('key','current_domain_name')
                     ->first();
        $newkey = $newkeyvalue->value.'/paytm-callback';
         $servicePath = base_path('app/Http/Middleware/VerifyCsrfToken.php');
         $file = base_path('app/Http/Middleware/VerifyCsrfToken.php');
          $file_contents = file_get_contents($file);
          $fh = fopen($file, "w");
          $file_contents = str_replace(
            "'$oldkey'","'$newkey'",$file_contents);
          fwrite($fh, $file_contents);
          fclose($fh);
       }

       $setting = new Setting();
       $myVarsetting = new SiteSettingController($setting);
       $languages = $myVarsetting->getLanguages();

            foreach($languages as $languages_data){
               $name = 'name_'.$languages_data->languages_id;

               if($id == 9){
                 $sub_name_1 = 'descriptions_'.$languages_data->languages_id;
                 $data = array('sub_name_1'  	      =>   $request->$sub_name_1);
               }              
               

               $checkExist = DB::table('payment_description')->where('payment_methods_id','=',$id)->where('language_id','=',$languages_data->languages_id)->first();
               
                if($checkExist){

                    if($id == 9){
                        $data = array(
                            'name'  	      =>   $request->$name,
                            'language_id'  =>   $languages_data->languages_id,
                            'sub_name_1'  	      =>   $request->$sub_name_1
                         );

                    }else{
                        $data = array(
                            'name'  	      =>   $request->$name,
                            'language_id'  =>   $languages_data->languages_id
                         );
                    }                   
                    
                   DB::table('payment_description')->where('payment_methods_id','=',$id)->where('language_id','=',$languages_data->languages_id)->update($data);
                   
                }else{

                    if($id == 9){
                        $data = array(
                            'name'  	    		     =>   $request->$name,
                        'language_id'			     =>   $languages_data->languages_id,
                        'payment_methods_id'	 =>   $id,
                            'sub_name_1'  	      =>   $request->$sub_name_1
                         );

                    }else{
                        $data = array(
                            'name'  	    		     =>   $request->$name,
                            'language_id'			     =>   $languages_data->languages_id,
                            'payment_methods_id'	 =>   $id,
                         );
                    }                    

                    DB::table('payment_description')->insert($data);
                }
               }
               
        DB::table('payment_methods')->where('payment_methods_id','=',$id)->update([
            'environment'  	    		 =>   $request->environment
            ]);
    }

    public function display($id){
      $result = array();
      $result['payment_methods'] = Payments_setting::where('payment_methods_id', $id)->first();
      $setting = new Setting();
      $myVarsetting = new SiteSettingController($setting);
      $languages = $myVarsetting->getLanguages();
      $result['languages'] = $languages;
      //dd($result['payment_methods']);

      $description_data = array();
      foreach($result['languages'] as $languages_data){

          $description = DB::table('payment_description')->where([
              ['language_id', '=', $languages_data->languages_id],
              ['payment_methods_id', '=', $id],
          ])->first();

          if($description){
              $description_data[$languages_data->languages_id]['name'] = $description->name;
              $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
              if($id == 9){
                $description_data[$languages_data->languages_id]['descritions'] = $description->sub_name_1;
              }
              $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
          }else{
              $description_data[$languages_data->languages_id]['name'] = '';
              $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
              if($id == 9){
                $description_data[$languages_data->languages_id]['descritions'] = '';
              }
              $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
          }

      }

      $result['method_detail'] = $description_data;
      $payment_credentials = DB::table('payment_methods_detail')->where('payment_methods_detail.payment_methods_id',$id)->get();
      $payment_methods_details = array();
      $index = 0;
      foreach($payment_credentials as $payment_credential){
        $payment_credential->keyname =  str_replace('_','',$payment_credential->key);
        array_push($payment_methods_details, $payment_credential);
      }

      $result['method_keys'] = $payment_methods_details;
      return $result;
    }


    public function checkdetailExists($languages_data,$braintree_name){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$braintree_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function ifcheckisset($braintree_name,$languages_data,$re_braintreeName,$req_sub_name_1,$req_sub_name_2){
       $checkisset =  DB::table('payment_description')->where('payment_name','=',$braintree_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $re_braintreeName,
            'sub_name_1'  	     	 =>   $req_sub_name_1,
            'sub_name_2'  	     	 =>   $req_sub_name_2,
        ]);
       return $checkisset;
    }

    public function ifcheckisnotset($re_braintreeName,$req_sub_name_1,$req_sub_name_2,$languages_data,$braintree_name){
       $ifcheckisnotset = DB::table('payment_description')->insert([
            'name'  	     		 =>   $re_braintreeName,
            'sub_name_1'  	     	 =>   $req_sub_name_1,
            'sub_name_2'  	     	 =>   $req_sub_name_2,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $braintree_name,
        ]);
       return $ifcheckisnotset;

    }

    public function checkExitisset($stripe_name,$languages_data){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$stripe_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;

    }

    public function validCheck($stripe_name,$languages_data,$req_stripeName){
       $issetstripe = DB::table('payment_description')->where('payment_name','=',$stripe_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $req_stripeName,
        ]);
       return $issetstripe;
    }

    public function notvalidcheck($req_tripeName,$languages_data,$stripe_name){
       $validcheck = DB::table('payment_description')->insert([
            'name'  	     		 =>   $req_tripeName,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $stripe_name,
        ]);
        return $validcheck;
    }
    public function checkPayPal($paypal_name,$languages_data){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$paypal_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function validpaypalcheck($paypal_name,$languages_data,$req_paypalName){
       $paypalcheck = DB::table('payment_description')->where('payment_name','=',$paypal_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $req_paypalName,
        ]);
        return $paypalcheck;
    }

    public function ifnotvalidpaypal($req_paypalName,$languages_data,$paypal_name){
       $payapcheck = DB::table('payment_description')->insert([
            'name'  	     		 =>   $req_paypalName,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $paypal_name,
        ]);
       return $paypal_name;
    }

    public function checkExitissetcode($cybersource_name,$languages_data){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$cybersource_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function validsybercheck($cybersource_name,$languages_data,$req_cybersourceName){
        $validcheck = DB::table('payment_description')->where('payment_name','=',$cybersource_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $req_cybersourceName,
        ]);
    }

    public function notvalidchekcyber($req_cybersourceName,$languages_data,$cybersource_name){
       $notvalid = DB::table('payment_description')->insert([
            'name'  	     		 =>   $req_cybersourceName,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $cybersource_name,
        ]);
       return $notvalid;
    }

    public function checkCode($cod_name,$languages_data){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$cod_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function validchekCode($cod_name,$languages_data,$req_codName){
        $Codecheck = DB::table('payment_description')->where('payment_name','=',$cod_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $req_codName,
        ]);
        return $Codecheck;
    }

    public function ifnotsetcode($req_codName,$languages_data,$cod_name){
       $notvalidCode = DB::table('payment_description')->insert([
            'name'  	     		 =>   $req_codName,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $cod_name,
        ]);
       return $notvalidCode;
    }

    public function checkinstamojo($instamojo_name,$languages_data){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$instamojo_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function validchekkinstamojo($instamojo_name,$languages_data,$req_instamojoName){
     $intamojo =   DB::table('payment_description')->where('payment_name','=',$instamojo_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $req_instamojoName,
        ]);
     return $intamojo;
    }

    public function notvalidinstalmojo($req_instamojoName,$languages_data,$instamojo_name){
      $notvalidcheckintamojo =  DB::table('payment_description')->insert([
            'name'  	     		 =>   $req_instamojoName,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $instamojo_name,
        ]);
      return $notvalidcheckintamojo;
    }

    public function checkhyperpay($hyperpay_name,$languages_data){
        $checkExist = DB::table('payment_description')->where('payment_name','=',$hyperpay_name)->where('language_id','=',$languages_data->languages_id)->get();
        return $checkExist;
    }

    public function validhypercheck($hyperpay_name,$languages_data,$req_hyperpayName){
        DB::table('payment_description')->where('payment_name','=',$hyperpay_name)->where('language_id','=',$languages_data->languages_id)->update([
            'name'  	    		 =>   $req_hyperpayName,
        ]);
    }

    public function notvalidhypertext($req_hyperpayName,$languages_data,$hyperpay_name){
      $hyperpay =  DB::table('payment_description')->insert([
            'name'  	     		 =>   $req_hyperpayName,
            'language_id'			 =>   $languages_data->languages_id,
            'payment_name'			 =>   $hyperpay_name,
        ]);
        return $hyperpay;
    }


}