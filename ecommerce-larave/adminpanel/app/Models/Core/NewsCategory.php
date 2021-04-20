<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Core\Setting;
use App\Models\Core\Images;
use App\Http\Controllers\AdminControllers\SiteSettingController;


class NewsCategory extends Model
{
  public function __construct()
  {
      $setting = new Setting();
      $this->myVarsetting = new SiteSettingController($setting);

  }
    use Sortable;

    public function images(){
        return $this->belongsTo('App\Images');
    }

    public function news_categories_description(){
        return $this->belongsTo('App\News_categories_description');
    }

    public $sortable = ['categories_id','created_at'];
    public $sortableAs = ['categories_name'];


  public function paginator(){
    $listingCategories =   $this->sortable('categories_id','ASC')
        ->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
        ->leftJoin('images','images.id', '=', 'news_categories.categories_image')
        ->leftJoin('image_categories','image_categories.image_id', '=', 'news_categories.categories_image')
        ->select('news_categories.categories_id as id','image_categories.path as path',  'news_categories.created_at as date_added', 'news_categories.updated_at as last_modified', 'news_categories_description.categories_name as name')
        ->where('news_categories_description.language_id', '1')->where('parent_id', '0')
        ->where('image_categories.image_type','=','THUMBNAIL' )
        ->orWhere('image_categories.image_type','=','ACTUAL')->orderBy('id' , 'asc')
        ->paginate(10);
        return $listingCategories;

  }

  public function getter($language_id){
    if($language_id == null){
      $language_id = '1';
    }
    $getCategories = DB::table('news_categories')
        ->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
        ->select('news_categories.categories_id as id', 'news_categories.categories_image as image',  'news_categories.categories_icon as icon',  'news_categories.created_at as date_added', 'news_categories.updated_at as last_modified', 'news_categories_description.categories_name as name', 'news_categories_description.language_id')
        ->where('parent_id', '0')->where('categories_status',1)
        ->where('news_categories_description.language_id', $language_id)->get();
    return $getCategories;

  }

  public function insert($request){
            $result = array();
            $date_added	= date('y-m-d h:i:s');
            $languages = $this->myVarsetting->getLanguages();

            if($request->image_id){
            $uploadImage = $request->image_id;
            }	else{
                $uploadImage = '';
            }

        $idSort = $this->sortID();

        if ($idSort==null){
          $sortId =  $idSort+1;
         }else{
               $sortId = $idSort->categories_id+1;
         }

        $uploadIcon ="";
        $categories_status = $request->categories_status;
            $categories_id = $this->insertcategory($uploadImage,$date_added,$sortId,$uploadIcon, $categories_status);
            $slug_flag = false;
            //multiple lanugauge with record
            foreach($languages as $languages_data){
                $categoryName= 'categoryName_'.$languages_data->languages_id;
                //slug
                if($slug_flag==false){
                    $slug_flag=true;
                    $slug = $request->$categoryName;
                    $old_slug = $request->$categoryName;
                    $slug_count = 0;
                    do{
                        if($slug_count==0){
                            $currentSlug = $this->myVarsetting->slugify($slug);
                        }else{
                            $currentSlug = $this->myVarsetting->slugify($old_slug.'-'.$slug_count);
                        }
                        $slug = $currentSlug;
                        //$checkSlug = DB::table('news_categories')->where('news_categories_slug',$currentSlug)->where('categories_id','!=',$request->id)->get();
                        $checkSlug = $this->checkslug($currentSlug);
                        $slug_count++;
                    }
                    while(count($checkSlug)>0);
                    $this->updateslug($categories_id,$slug);
                }

                $categoryname =$request->$categoryName;
               $this->categoryName($categoryname,$categories_id,$languages_data);
            }

  }

    public function edit($request){
      $result = array();
      $description_data = array();
      $result['message'] = array();
      $result['languages'] = $this->myVarsetting->getLanguages();

      $editCategory = DB::table('news_categories')
          ->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
          ->leftJoin('images','images.id', '=', 'news_categories.categories_image')
          ->leftJoin('image_categories','image_categories.image_id', '=', 'news_categories.categories_image')
          ->select('news_categories.categories_id as id', 'news_categories.categories_status', 'news_categories.categories_image as image', 'news_categories.categories_icon as icon',  'news_categories.created_at as date_added', 'news_categories.updated_at as last_modified', 'news_categories.news_categories_slug as slug','image_categories.path as path')
          ->where('news_categories.categories_id', $request->id)->get();

      foreach($result['languages'] as $languages_data){
          $languages_data_id =  $languages_data->languages_id;
          $description = $this->description($languages_data_id,$request);
          if(count($description)>0){
              $description_data[$languages_data->languages_id]['name'] = $description[0]->categories_name;
              $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
              $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
          }else{
              $description_data[$languages_data->languages_id]['name'] = '';
              $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
              $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
          }
      }
      $result['description'] = $description_data;
      $result['editCategory'] = $editCategory;
      return $result;

    }

    public function destroyrecord($request){
        DB::table('news_categories')->where('categories_id', $request->id)->delete();
        DB::table('news_categories_description')->where('categories_id', $request->id)->delete();
        DB::table('news_to_news_categories')->where('categories_id', $request->id)->delete();
        return 'success';
    }

    public function filter($name,$param){

              if($name=="Name"){

                  $listingCategories =   $this->sortable('categories_id','ASC')
                      ->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
                      ->leftJoin('images','images.id', '=', 'news_categories.categories_image')
                      ->leftJoin('image_categories','image_categories.image_id', '=', 'news_categories.categories_image')
                      ->select('news_categories.categories_id as id','image_categories.path as path',  'news_categories.created_at as date_added', 'news_categories.updated_at as last_modified', 'news_categories_description.categories_name as name','news_categories_description.language_id as language_id')
                      ->where('news_categories_description.language_id', '1')->where('parent_id', '0')->where('news_categories_description.categories_name', 'LIKE', '%' . $param . '%')->orderBy('id' , 'asc')
                      ->paginate(10);

              }else{
                  $listingCategories =   $this->sortable('categories_id','ASC')
                      ->leftJoin('news_categories_description','news_categories_description.categories_id', '=', 'news_categories.categories_id')
                      ->leftJoin('images','images.id', '=', 'news_categories.categories_image')
                      ->leftJoin('image_categories','image_categories.image_id', '=', 'news_categories.categories_image')
                      ->select('news_categories.categories_id as id','image_categories.path as path',  'news_categories.created_at as date_added', 'news_categories.updated_at as last_modified', 'news_categories_description.categories_name as name')
                       ->where('news_categories_description.language_id', '1')->where('parent_id', '0')->where('image_categories.image_type','=','THUMBNAIL' )->orWhere('image_categories.image_type','=','ACTUAL')->orderBy('id' , 'asc')
                      ->paginate(10);
              }

              return $listingCategories;

    }

    public function description($languages_data,$request){

        $description = DB::table('news_categories_description')->where([
            ['language_id', '=', $languages_data],
            ['categories_id', '=', $request->id],
        ])->get();
        return $description;

    }

    public function sortID(){

        $idSort = DB::table('news_categories')->select('categories_id')->get()->last();
        return $idSort;

    }

    public function checkslug($currentSlug){

        $checkSlug = DB::table('news_categories')->where('news_categories_slug',$currentSlug)->get();
        return $checkSlug;

    }

    public function updateslug($categories_id,$slug){

       $updateslug = DB::table('news_categories')->where('categories_id',$categories_id)->update([
            'news_categories_slug'	 =>   $slug
        ]);
        return $updateslug;
    }

    public function categoryName($categoryname,$categories_id,$languages_data){

       $insternewsdes = DB::table('news_categories_description')->insert([
            'categories_name'   =>   $categoryname,
            'categories_id'     =>   $categories_id,
            'language_id'       =>   $languages_data->languages_id
        ]);
       return $insternewsdes;

    }

    public function insertcategory($uploadImage,$date_added,$sortId,$uploadIcon, $categories_status){


        $categories_id = DB::table('news_categories')->insertGetId([
            'categories_image'   =>   $uploadImage,
            'created_at'		 =>   $date_added,
            'sort_order'		 =>   $sortId,
            'parent_id'		 	 =>   '0',
            'categories_icon'	 =>	  $uploadIcon,
            'news_categories_slug'	 =>	  '0',
            'categories_status'  =>  $categories_status
        ]);
       return $categories_id;

    }

}
