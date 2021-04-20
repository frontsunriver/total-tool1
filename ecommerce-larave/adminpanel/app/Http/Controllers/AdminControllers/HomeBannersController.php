<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\HomeBanners;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;

class HomeBannersController extends Controller
{
  public function __construct(HomeBanners $HomeBanners, Setting $setting, Images $images)
  {
      $this->HomeBanners = $HomeBanners;
      $this->varseting = new SiteSettingController($setting);
      $this->Setting = $setting;
      $this->images = $images;
  }

  public function display(){
    $title = array('pageTitle' => Lang::get("labels.Home Banners"));
    $result['banners'] = $this->HomeBanners->index();
    $result['languages'] = $this->varseting->getLanguages();
    $allimage = $this->images->getimages();
    //dd($result);
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.settings.web.homebanners.index",$title)->with('result', $result)->with('allimage', $allimage);
  }

 
  public function insert(Request $request){
       // dd($request->all());

        
        $result = array();

        //get function from other controller
        $languages = $this->varseting->getLanguages();
        $banners_types = array('banners_1','banners_2','banners_3');

        //multiple lanugauge with record
        foreach($languages as $languages_data){
          //text_1_banner_1
            $bannerText = 'text_'.$languages_data->languages_id;
            $bannerImageId = 'image_id_'.$languages_data->languages_id;
             
              foreach($banners_types as $key => $banners_type){

                if($key==0){
                  $banner_name =  'banners_1';
                }elseif($key==1){
                    $banner_name =  'banners_2';
                }else{
                    $banner_name =  'banners_3';
                }

                $banner_text = $bannerText.'_'.$banner_name;
                $banner_image_id = $bannerImageId.'_'.$banner_name;
                // print $banner_text.' ';
                // print $request->$banner_text.' ';

                $banners_text = $request->$banner_text;
                $banners_image_id = $request->$banner_image_id;

                $checkExist = $this->HomeBanners->checkExit($banner_name, $languages_data->languages_id);
                
                if($checkExist){
                  $this->HomeBanners->updaterecord($banner_name,$languages_data->languages_id,$banners_text, $banners_image_id);
                }else{
                  $this->HomeBanners->insertrecord($banner_name,$languages_data->languages_id,$banners_text, $banners_image_id);
                }

              }
     }

        $message = Lang::get("labels.Home banner added successfully");
        return redirect()->back()->withErrors([$message]);
  }  

   public function update(Request $request){

     $title = array('pageTitle' => Lang::get("labels.EditSubCategories"));
     $result = array();
     $result['message'] = Lang::get("labels.Category has been updated successfully");
     $last_modified 	=   date('y-m-d h:i:s');
     $parent_id = $request->parent_id;
     $categories_id = $request->id;
     $categories_status  = $request->categories_status;

     //get function from other controller
     $languages = $this->varseting->getLanguages();
     $extensions = $this->varseting->imageType();

     //check slug
     if($request->old_slug!=$request->slug){
         $slug = $request->slug;
         $slug_count = 0;
         do{
             if($slug_count==0){
                 $currentSlug = $this->varseting->slugify($request->slug);
             }else{
                 $currentSlug = $this->varseting->slugify($request->slug.'-'.$slug_count);
             }
             $slug = $currentSlug;
             $checkSlug = DB::table('categories')->where('categories_slug',$currentSlug)->where('categories_id','!=',$request->id)->get();
             $slug_count++;
         }
         while(count($checkSlug)>0);
     }else{
         $slug = $request->slug;
     }
     if($request->image_id!==null){
         $uploadImage = $request->image_id;
     }else{
         $uploadImage = $request->oldImage;
     }

     if($request->image_icone !==null){
         $uploadIcon = $request->image_icone;
     }	else{
         $uploadIcon = $request->oldIcon;
     }

     $updateCategory = $this->Categories->updaterecord($categories_id,$uploadImage,$uploadIcon,$last_modified,$parent_id,$slug,$categories_status);

     foreach($languages as $languages_data){
       $categories_name = 'category_name_'.$languages_data->languages_id;
       $checkExist = $this->Categories->checkExit($categories_id,$languages_data);
         $categories_name = $request->$categories_name;
         if(count($checkExist)>0){
           $category_des_update = $this->Categories->updatedescription($categories_name,$languages_data,$categories_id);
       }else{
           $updat_des = $this->Categories->insertcategorydescription($categories_name,$categories_id, $languages_data->languages_id);
       }
     }

     $message = Lang::get("labels.CategorieUpdateMessage");
     return redirect()->back()->withErrors([$message]);
    }

    public function delete(Request $request){
      $deletecategory = $this->Categories->deleterecord($request);
      $message = Lang::get("labels.CategoriesDeleteMessage");
      return redirect()->back()->withErrors([$message]);
    }
}
