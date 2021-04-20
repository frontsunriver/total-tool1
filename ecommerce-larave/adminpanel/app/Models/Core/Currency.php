<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class Currency extends Model
{
    //
    use Sortable;

    public $sortable =['id','created_at'];
    public $sortableAs =['title'];

    public function paginator(){
      $setting = new Setting();
      $myVarsetting = new SiteSettingController($setting);
      $commonsetting = $myVarsetting->commonsetting();
      $currencies = Currency::sortable(['id'=>'ASC'])->where('is_current', 1)->paginate($commonsetting['pagination']);
      return $currencies;
    }

    public function getter(){
      $currencies = DB::table('currencies')->get();
       return $currencies;
    }

    public function getDefaultCurrency(){
      $currencies = DB::table('currencies')
                      ->where('is_default', 1)
                      ->first();

       return $currencies;
    }

    public function checkexist($request){
      $currencies = DB::table('currencies')
                      ->where('is_current', 1)
                      ->where('code', $request->code)
                      ->first();

       return $currencies;
    }

    public function checkexistupdate($request){
      $currencies = DB::table('currencies')
                      ->where('is_current', 1)
                      ->where('id', '!=', $request->id)
                      ->where('code', $request->code)
                      ->first();

       return $currencies;
    }

    public function filter($data){

      $name = $data['FilterBy'];
      $param = $data['parameter'];
      $currencies = Currency::sortable(['id'=>'ASC'])
          ->where('title', 'LIKE', '%' . $param . '%')
          ->groupby('id')
          ->paginate(10);

        return $currencies;
    }

    public function insert($request){
       $date_added	= date('y-m-d h:i:s');
      
      if($request->position == 'left'){
        $symbol_left = $request->symbol;
        $symbol_right = '';
      }else{
        $symbol_left = '';
        $symbol_right = $request->symbol;
      }


       DB::table('currencies')->insertGetId([
            'title'   =>   $request->title,
            'code'   =>   $request->code,
            'symbol_left'   =>   $symbol_left,
            'symbol_right'   =>   $symbol_right,
            'decimal_point'   =>   $request->decimal_point,
            'thousands_point'   =>   $request->thousands_point,
            'decimal_places'   =>   $request->decimal_places,
            'value'   =>   $request->value,
            'is_default' => 0,
            'created_at'   =>   $date_added,
            'updated_at'   =>   $date_added,
            'is_current'   => 1
        ]);
    }


    public function recordToUpdate($currency_id){
        $currency = DB::table('currencies')
                      ->where('id', $currency_id)
                      ->first();
        return $currency;
    }

    public function updaterecord($request){
      $last_modified 	=   date('y-m-d h:i:s');

      if($request->position == 'left'){
        $symbol_left = $request->symbol;
        $symbol_right = '';
      }else{
        $symbol_left = '';
        $symbol_right = $request->symbol;
      }
      
      if($request->warning == 1){
        $check = DB::table('currencies')->where('id', $request->id)->where('is_default',1)->first();
        //update
        
        if($check != null){

          DB::table('currencies')->where('id', $request->id)->update(
          [
            'title'   =>   $request->title,
            'code'   =>   $request->code,
            'symbol_left'   =>   $symbol_left,
            'symbol_right'   =>   $symbol_right,
            'decimal_point'   =>   $request->decimal_point,
            'thousands_point'   =>   $request->thousands_point,
            'decimal_places'   =>   $request->decimal_places,
            'value'   =>   $request->value,
            'created_at'   =>   $last_modified,
            'updated_at'   =>   $last_modified,
          ]);

          DB::table('settings')->where('name', 'currency_symbol')->update(
          [
            'value'   =>  $request->symbol, 
          ]);
          
          return $request->id;
        }else{
          DB::table('currencies')->where('id', $request->id)->update(
          [
            'title'   =>   $request->title,
            'code'   =>   $request->code,
            'symbol_left'   =>   $symbol_left,
            'symbol_right'   =>   $symbol_right,
            'decimal_point'   =>   $request->decimal_point,
            'thousands_point'   =>   $request->thousands_point,
            'decimal_places'   =>   $request->decimal_places,
            'value'   =>   $request->value,
            'created_at'   =>   $last_modified,
            'updated_at'   =>   $last_modified,
          ]);
        }
        return $request->id;


      }else{
      $orders = DB::table('orders')
          ->where('customers_id', '!=', '')->get();
          if($orders != null){
            return 0;
          }

      return $request->id;
    }
    }

    public function deleterecord($request){

        $currency_id = $request->id;
        $check = DB::table('currencies')->where('id', $currency_id)->where('is_default',1)->first();
        if($check){
          $var = DB::table('currencies')->where('id','!=', $currency_id)->first();
           DB::table('currencies')->where('id','=', $var->id)->update(['is_default' => 1]);
        }
    		DB::table('currencies')->where('id', $currency_id)->delete();
        return "success";
    }

}
