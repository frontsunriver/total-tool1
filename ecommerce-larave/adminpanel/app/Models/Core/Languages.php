<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Languages extends Model
{

    use Sortable;

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public $sortable = ['languages_id', 'name', 'code','directory','sort_order','direction','is_default','created_at','updated_at'];


        public function paginator(){
          $languages = Languages::sortable(['languages_id'=>'desc'])
              ->select('languages.languages_id','languages.name','languages.code', 'languages.directory','languages.is_default','languages.direction','languages.status','languages.sort_order','image_categories.path')
              ->LeftJoin('image_categories', function ($join) {
                  $join->on('image_categories.image_id', '=', 'languages.image')
                      ->where(function ($query) {
                          $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                              ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                              ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                      });
              })
              ->groupby('languages_id')
              ->paginate(5);
             return $languages;
        }

        public function getter(){
          $languages = Languages::leftJoin('images','images.id', '=', 'languages.image')
              ->leftJoin('image_categories','image_categories.image_id', '=', 'languages.image')
              ->select('languages.languages_id','languages.name','languages.code','languages.status','languages.directory','languages.is_default','languages.direction','languages.sort_order','image_categories.path')
              ->where(function($query) {
                  $query->where('image_categories.image_type', '=',  'THUMBNAIL')
                      ->where('image_categories.image_type','!=',   'THUMBNAIL')
                      ->orWhere('image_categories.image_type','=',   'ACTUAL');
                    })
                    ->groupby('languages_id')->get();
             return $languages;
        }

    public function insert($request){

        $idSort = DB::table('languages')->select('languages_id')->get()->last();
        $sortId = $idSort->languages_id+1;
        $banners = DB::table('constant_banners')->where('languages_id',1)->get();
        $sliders = DB::table('sliders_images')->where('languages_id',1)->get();
        $orders_status_description = DB::table('orders_status_description')->where('language_id',1)->get();

      $language =  DB::table('languages')->insertGetId([
            'name'			=>	$request->name,
            'code'			=>	$request->code,
            'image'			=>	$request->image_id,
            'directory'		=>	$request->directory,
            'direction'		=>	$request->directions,
            'sort_order'		=>	$sortId,
        ]);

        foreach ($banners as $banner) {
          DB::table('constant_banners')->insert([
              'banners_title'  		 =>   $banner->banners_title,
              'banners_image'			 =>	  $banner->banners_image,
              'banners_url'	 		 =>   $banner->banners_url,
              'status'	 			 =>   $banner->status,
              'type'					 =>	  $banner->type,
              'languages_id' => $language
          ]);
        }
        foreach ($sliders as $slider) {
          DB::table('sliders_images')->insert([
      				'sliders_title'  		 =>   $slider->sliders_title,
      				'date_added'	 		 =>   date('Y-m-d H:i:s'),
      				'sliders_image'			 =>	  $slider->sliders_image,
      				'carousel_id'      		 =>   $slider->carousel_id,
      				'sliders_url'	 		 =>   $slider->sliders_url,
      				'status'	 			 =>   $slider->status,
      				'type'					 =>	  $slider->type,
      				'languages_id'			 =>	  $language
      				]);
        }

        foreach ($orders_status_description as $orders_status_desc) {
                    DB::table('orders_status_description')->insert([
                        'orders_status_id'=> $orders_status_desc->orders_status_id,
                        'orders_status_name'=> $orders_status_desc->orders_status_name,
                        'language_id'			 =>	  $language
                ]);
          }

    }

    public function updateRecord($request){
        if($request->image_id !== null){

            $uploadImage = $request->image_id;

        }	else{
            $uploadImage = $request->oldImage;
        }

        $orders_status = DB::table('languages')->where('languages_id','=', $request->id)->update([
            'name'			=>	$request->name,
            'code'			=>	$request->code,
            'image'			=>	$uploadImage,
            'directory'		=>	$request->directory,
            'direction'		=>	$request->directions,
            'status' => $request->status
        ]);
        $orders_status_description = DB::table('orders_status_description')->where('language_id',$request->id)->get();
        if(count($orders_status_description) == 0){
            $orders_status_description = DB::table('orders_status_description')->where('language_id',1)->get();
            foreach ($orders_status_description as $orders_status_desc) {
                DB::table('orders_status_description')->insert([
                        'orders_status_id'=> $orders_status_desc->orders_status_id,
                        'orders_status_name'=> $orders_status_desc->orders_status_name,
                        'language_id'			 =>	  $request->id
                ]);
            }
        }
        

        return 'success';
    }

    public function deleteRecord($request){
      $banners = DB::table('constant_banners')->get();
      $sliders = DB::table('sliders_images')->get();
      foreach ($banners as $banner) {
        DB::table('constant_banners')->where('languages_id',$request->id)->delete();
      }
      foreach ($sliders as $slider) {
        DB::table('sliders_images')->where('languages_id',$request->id)->delete();
      }
        DB::table('languages')->where('languages_id', $request->id)->delete();
        DB::table('categories_description')->where('language_id', $request->id)->delete();
        DB::table('label_value')->where('language_id', $request->id)->delete();
        DB::table('manufacturers_info')->where('languages_id', $request->id)->delete();
        DB::table('products_description')->where('language_id', $request->id)->delete();
        DB::table('pages_description')->where('language_id', $request->id)->delete();
        DB::table('products_options_values_descriptions')->where('language_id', $request->id)->delete();
        DB::table('shipping_description')->where('language_id', $request->id)->delete();
        DB::table('payment_description')->where('language_id', $request->id)->delete();

        return 'success';
    }

     public function edit($request){

         $images = new Images;
         $allimage = $images->getimages();

         $languages = DB::table('languages')
             ->leftJoin('images','images.id', '=', 'languages.image')
             ->leftJoin('image_categories','image_categories.image_id', '=', 'languages.image')
             ->select('languages.languages_id','languages.name','languages.code','languages.status','languages.directory',
             'languages.is_default','languages.image','languages.direction','languages.sort_order',
             'image_categories.path')->where('languages_id','=', $request->id)->get();


         return $languages;

     }

     public function getSingleLan(){

         $languages = DB::table('languages')->get();

         return $languages;

     }


}
