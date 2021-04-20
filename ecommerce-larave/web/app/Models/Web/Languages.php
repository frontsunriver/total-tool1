<?php

namespace App\Models\Web;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Core\Categories;
use Illuminate\Support\Facades\Lang;



class Languages extends Model
{

  public function languages(){
    $data = DB::table('languages')
              ->leftJoin('image_categories','languages.image','image_categories.image_id')
              ->select('languages.*','image_categories.path as image_path')
              ->where('languages.status',1)
              ->where(function($query) {
                  $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                      ->where('image_categories.image_type','!=',   'THUMBNAIL')
                      ->orWhere('image_categories.image_type','=',   'ACTUAL');
              })->get();
              
    return $data;
  }

}
