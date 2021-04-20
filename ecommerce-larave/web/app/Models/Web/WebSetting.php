<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WebSetting extends Model
{

    public function getLanguage($language_id){
      $language =	 DB::table('languages')
                    ->leftJoin('image_categories','languages.image','image_categories.image_id')
                    ->select('languages.*','image_categories.path as image_path')
                    ->where('languages_id','=',$language_id)
                    ->first();
        return $language;
    }

    public function getCurrency($currency_id){
      $currency = DB::table('currencies')->where('id',$currency_id)->first();
      return $currency;
    }

}
