<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;



class Banner extends Model
{
    //
    use Sortable;

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function image_category(){
        return $this->belongsTo('App\Image_category');
    }

    public $sortable = ['banners_id','banners_title','created_at'];

    public function fetchbanner($request,$uploadImage,$banners_url,$expiryDateFormate){

        $banner = DB::table('banners')->insert([
            'banners_title'  		 =>   $request->banners_title,
            'created_at'	 		 =>   date('Y-m-d H:i:s'),
            'banners_image'			 =>	  $uploadImage,
            'banners_url'	 		 =>   $banners_url,
            'status'	 			 =>   $request->status,
            'expires_date'			 =>	  $expiryDateFormate,
            'type'					 =>	  $request->type,
            'languages_id'			 =>	  $request->languages_id
        ]);

        return $banner;
    }

    public function editbanners($request){

        $banners = DB::table('banners')
            ->leftJoin('image_categories as categoryTable','categoryTable.image_id', '=', 'banners.banners_image')
            ->select('banners.*','categoryTable.path')
            ->where('banners_id', $request->id)->get();
        return $banners;

    }

    public function updatebanner($request,$uploadImage,$banners_url,$expiryDateFormate){

        $bannersUpdate = DB::table('banners')->where('banners_id', $request->id)->update([
            'updated_at'	 =>   date('Y-m-d H:i:s'),
            'banners_title'  		 =>   $request->banners_title,
            'created_at'	 		 =>   date('Y-m-d H:i:s'),
            'banners_image'			 =>	  $uploadImage,
            'banners_url'	 		 =>   $banners_url,
            'status'	 			 =>   $request->status,
            'expires_date'			 =>	  $expiryDateFormate,
            'type'					 =>	  $request->type,
            'languages_id'			 =>	  $request->languages_id
        ]);

        return $bannersUpdate;
    }

    public function deletebanners($request){
      $deletebanners =  DB::table('banners')->where('banners_id', $request->banners_id)->delete();
      return $deletebanners;
    }

}
