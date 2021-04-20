<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Categories;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;

class CategoriesController extends Controller
{
  public function __construct(Categories $categories, Setting $setting)
  {
      $this->Categories = $categories;
      $this->varseting = new SiteSettingController($setting);
      $this->Setting = $setting;
  }

  public function display(){
    $title = array('pageTitle' => Lang::get("labels.SubCategories"));
    $categories = $this->Categories->paginator();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.categories.index",$title)->with('categories', $categories)->with('result', $result);
  }


  public function filter(Request $request){
    $title = array('pageTitle' => Lang::get("labels.SubCategories"));
    $categories = $this->Categories->filter($request);
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.categories.index", $title)->with('result', $result)->with(['categories'=> $categories, 'name'=> $request->FilterBy, 'param'=> $request->parameter]);
  }

  public function add(Request $request){
    $title = array('pageTitle' => Lang::get("labels.AddSubCategories"));

    $images = new Images;
    $allimage = $images->getimages();

    $result = array();
    $result['message'] = array();
    //get function from other controller
    $result['languages'] = $this->varseting->getLanguages();
    $categories = $this->Categories->recursivecategories();

    $parent_id = 0;
    $option = '<option value="0">'. Lang::get("labels.Leave As Parent").'</option>';

      foreach($categories as $parents){
        if($parents->categories_id > 0){
        $option .= '<option value="'.$parents->categories_id.'">'.$parents->categories_name.'</option>';

          if(isset($parents->childs)){
            $i = 1;
            $option .= $this->childcat($parents->childs, $i, $parent_id);
          }
        }
      }

    $result['categories'] = $option;
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.categories.add",$title)->with('result', $result)->with('allimage', $allimage);
  }

  public function childcat($childs, $i, $parent_id){
    $contents = '';
    foreach($childs as $key => $child){
      $dash = '';
      for($j=1; $j<=$i; $j++){
          $dash .=  '-';
      }
      //print(" <i>   ".$i." chgild");  echo '<pre>'.print_r($childs, true).'</pre>';
      if($child->categories_id==$parent_id){
        $selected = 'selected';
      }else{
        $selected = '';
      }

      $contents.='<option value="'.$child->categories_id.'" '.$selected.'>'.$dash.$child->categories_name.'</option>';
      if(isset($child->childs)){

        $k = $i+1;
        $contents.= $this->childcat($child->childs,$k,$parent_id);
      }
      elseif($i>0){
        $i=1;
      }

    }
    return $contents;
  }

  public function insert(Request $request){

        $date_added	= date('y-m-d h:i:s');
        $result = array();

        //get function from other controller
        $languages = $this->varseting->getLanguages();

        $categoryName = $request->categoryName;
        $parent_id = $request->parent_id;

        $uploadImage = $request->image_id;
        $uploadIcon  = $request->image_icone;
        $categories_status  = $request->categories_status;

        $categories_id = $this->Categories->insert($uploadImage,$date_added,$parent_id,$uploadIcon,$categories_status);
        $slug_flag = false;

        //multiple lanugauge with record
        foreach($languages as $languages_data){
            $categoryName= 'categoryName_'.$languages_data->languages_id;
            $categoryDescriptions= 'description_'.$languages_data->languages_id;
            //slug
            if($slug_flag==false){
                $slug_flag=true;
                $slug = $request->$categoryName;
                $old_slug = $request->$categoryName;
                $slug_count = 0;
                do{
                    if($slug_count==0){
                        $currentSlug = $this->varseting->slugify($old_slug);
                    }else{
                        $currentSlug = $this->varseting->slugify($old_slug.'-'.$slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = $this->Categories->checkSlug($currentSlug);
                    $slug_count++;
                }
                  while(count($checkSlug)>0);
                  $updateSlug = $this->Categories->updateSlug($categories_id,$slug);
                }
            $categoryNameSub = $request->$categoryName;
            $descriptions = $request->$categoryDescriptions;
            $languages_data_id = $languages_data->languages_id;
            $subcatoger_des = $this->Categories->insertcategorydescription($categoryNameSub,$categories_id,$languages_data_id, $descriptions);
        }

        $categories =  $this->Categories->subcategorydes();
        $result['categories'] = $categories;
        $message = Lang::get("labels.AddCategoryMessage");
        return redirect()->back()->withErrors([$message]);
  }

  public function edit(Request $request){
    $title = array('pageTitle' => Lang::get("labels.EditCategories"));
    $images = new Images;
    $allimage = $images->getimages();

    $result = array();
    $result['message'] = array();

    //get function from other controller
    $result['languages'] = $this->varseting->getLanguages();
    $editSubCategory = $this->Categories->editsubcategory($request);

    $description_data = array();
    foreach($result['languages'] as $languages_data){
        $languages_id = $languages_data->languages_id;
        $id = $request->id;
        $description = $this->Categories->editdescription($languages_id,$id);
        if(count($description)>0){
          $description_data[$languages_data->languages_id]['name'] = $description[0]->categories_name;
          $description_data[$languages_data->languages_id]['descriptions'] = $description[0]->categories_description;
          $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
          $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
      }else{
          $description_data[$languages_data->languages_id]['name'] = '';
          $description_data[$languages_data->languages_id]['descriptions'] = '';
          $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
          $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
      }
    }

    $result['description'] = $description_data;
    $result['editSubCategory'] = $editSubCategory;

    $categories = $this->Categories->editrecursivecategories($request);
  //  dd($editSubCategory[0]->parent_id);
    $parent_id = $editSubCategory[0]->parent_id;
    $option = '<option value="0">'. Lang::get("labels.Leave As Parent").'</option>';
    foreach($categories as $parents){
      $selected = '';
      if(isset($parents->categories_id)){
        if($parents->categories_id > 0){
          if($parents->categories_id==$parent_id){
            $selected = 'selected';
          }

          $option .= '<option value="'.$parents->categories_id.'"  '.$selected.' >'.$parents->categories_name.'</option>';
          $i = 1;
          if(isset($parents->childs)){
            $option .= $this->childcat($parents->childs, $i, $parent_id);
          }
        }
      }
    }

    $result['categories'] = $option;
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.categories.edit",$title)->with('result', $result)->with('allimage', $allimage);
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
      $categoryDescriptions= 'description_'.$languages_data->languages_id;
      
      $descriptions = $request->$categoryDescriptions;

      $checkExist = $this->Categories->checkExit($categories_id,$languages_data);
        $categories_name = $request->$categories_name;
        if(count($checkExist)>0){
          $category_des_update = $this->Categories->updatedescription($categories_name,$languages_data,$categories_id, $descriptions);
      }else{
          $updat_des = $this->Categories->insertcategorydescription($categories_name,$categories_id, $languages_data->languages_id, $descriptions);
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
