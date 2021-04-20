<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Core\Languages;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class HomeBanners extends Model
{
    //
    use Sortable;
    public function images(){
        return $this->belongsTo('App\Images');
    }


    public function index(){
      $setting = new Setting();
      $myVarsetting = new SiteSettingController($setting);
      $commonsetting = $myVarsetting->commonsetting();

    $languages = $myVarsetting->getLanguages();

    $banners_types = array('banners_1','banners_2','banners_3');

    $description_data = array();
    foreach($languages as $language){

        $banners = HomeBanners::LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'home_banners.image')
                ->where(function ($query) {
                    $query->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });
            })
           
            ->select('home_banners.home_banners_id', 'home_banners.image', 'home_banners.created_at',
            'home_banners.updated_at', 'home_banners.banner_name', 'home_banners.text',
            'home_banners.language_id', 'image_categories.path')   
            ->where('language_id', $language->languages_id)          
            ->groupby('home_banners.banner_name')
            ->get();       
            $index = 0;
            if(count($banners)>0){
                foreach( $banners as $banner){   
                    $description_data[$language->languages_id][$index]['home_banners_id'] = $banner->home_banners_id;
                    $description_data[$language->languages_id][$index]['image'] = $banner->image;
                    $description_data[$language->languages_id][$index]['banner_name'] = $banner->banner_name;
                    $description_data[$language->languages_id][$index]['text'] = $banner->text;
                    $description_data[$language->languages_id][$index]['path'] = $banner->path;
                    $description_data[$language->languages_id][$index]['language_id'] = $language->languages_id;       
                    $index++;
                }
            }else{

                $index = 1;
                
                foreach($banners_types as $banners_type){
                    if($index==1){
                        $banner_name =  'banners_1';
                    }elseif($index==2){
                        $banner_name =  'banners_2';
                    }else{
                        $banner_name =  'banners_3';
                    }                    
                    
                    $description_data[$language->languages_id][$index]['home_banners_id'] = '';
                    $description_data[$language->languages_id][$index]['image'] = '';
                    $description_data[$language->languages_id][$index]['banner_name'] = $banner_name;
                    $description_data[$language->languages_id][$index]['path'] = '';
                    $description_data[$language->languages_id][$index]['text'] = '';
                    $description_data[$language->languages_id][$index]['language_id'] = $language->languages_id;
                    $index++;

                }
            }   
          
  
      }


            return $description_data;
    }
    

    public function insertrecord($banner_name, $language_id, $banners_text, $banners_image_id){
        if($banners_image_id!=''){
            $categories = DB::table('home_banners')->insertGetId([
                'banner_name'   =>   $banner_name,
                'language_id'	=>   $language_id,
                'text'          =>   addslashes($banners_text),
                'image'          =>   $banners_image_id,
                'created_at'     => date('y-m-d h:i:s'),
                'updated_at'     => date('y-m-d h:i:s')
            ]);
    
        }else{
            $categories = DB::table('home_banners')->insertGetId([
                'banner_name'   =>   $banner_name,
                'language_id'		 =>   $language_id,
                'text'   =>   addslashes($banners_text),
                'created_at'     => date('y-m-d h:i:s'),
                'updated_at'     => date('y-m-d h:i:s')
            ]);
        }
        return $categories;
    }   

    public function updaterecord($banner_name, $language_id, $banners_text, $banners_image_id){
      if($banners_image_id!=''){
        DB::table('home_banners')->where('banner_name', $banner_name)->where('language_id', $language_id)->update(
        [
            'text'   =>   addslashes($banners_text),
            'image'          =>   $banners_image_id,
            'created_at'     => date('y-m-d h:i:s'),
            'updated_at'     => date('y-m-d h:i:s')
        ]);
      }else{
        DB::table('home_banners')->where('banner_name', $banner_name)->where('language_id', $language_id)->update(
            [
                'text'   =>   addslashes($banners_text),
                'created_at'     => date('y-m-d h:i:s'),
                'updated_at'     => date('y-m-d h:i:s')
            ]);
      }
    }

    public function checkExit($banner_name,$language_id){
        $checkExist = HomeBanners::where('banner_name','=',$banner_name)->where('language_id','=',$language_id)->first();
        return $checkExist;
    }
}