<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Core\NewsCategory;
use App\Http\Controllers\AdminControllers\AlertController;
use DB;
use Lang;

class Pages extends Model
{

 public static function pages()
 {
   $language_id    =   '1';

   $pages = DB::table('pages')
     ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
     ->where([
           ['pages_description.language_id','=',$language_id],
           ['pages.type','=','1']
         ])
     ->orderBy('pages.page_id', 'ASC')
     ->paginate(20);

   $result["pages"] = $pages;

   return $result;
 }

 public static function addpage()
{
  $language_id      =   '1';

  $result = array();

  //get function from other controller
  $myVar = new NewsCategory();
  $result['newsCategories'] = $myVar->getter($language_id);

  //get function from other controller
  $myVar = new SiteSettingController();
  $result['languages'] = $myVar->getLanguages();

  return $result;
}

public static function addnewpage($request)
{

  		//get function from other controller
  		$myVar = new SiteSettingController();
  		$languages = $myVar->getLanguages();

  		$slug = str_replace(' ','-' ,trim($request->slug));
  		$slug = str_replace('_','-' ,$slug);

  		$page_id = DB::table('pages')->insertGetId([
  					'slug'		 			 =>   $slug,
  					'type'		 			 =>   1,
  					'status'		 		 =>   $request->status,
  					]);

  		foreach($languages as $languages_data){
  			$name = 'name_'.$languages_data->languages_id;
  			$description = 'description_'.$languages_data->languages_id;

  			DB::table('pages_description')->insert([
  					'name'  	    		 =>   $request->$name,
  					'language_id'			 =>   $languages_data->languages_id,
  					'page_id'				 =>   $page_id,
  					'description'			 =>   addslashes($request->$description)
  					]);
  		}

}

public static function editpage($request)
{
  $language_id      =   '1';
  $page_id     	  =   $request->id;

  $result = array();

  //get function from other controller
  $myVar = new SiteSettingController();
  $result['languages'] = $myVar->getLanguages();


  $pages = DB::table('pages')
    ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
    ->select('pages.*','pages_description.description','pages_description.language_id','pages_description.name' ,'pages_description.page_description_id')
    ->where('pages.page_id','=', $page_id)
    ->get();

  $description_data = array();
  foreach($result['languages'] as $languages_data){

    $description = DB::table('pages_description')->where([
        ['language_id', '=', $languages_data->languages_id],
        ['page_id', '=', $page_id],
      ])->get();

    if(count($description)>0){
      $description_data[$languages_data->languages_id]['name'] = $description[0]->name;
      $description_data[$languages_data->languages_id]['description'] = $description[0]->description;
      $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
      $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
    }else{
      $description_data[$languages_data->languages_id]['name'] = '';
      $description_data[$languages_data->languages_id]['description'] = '';
      $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
      $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
    }
  }

  $result['description'] = $description_data;
  $result['editPage'] = $pages;

  return $result;
}

public static function updatepage($request)
{

  		$page_id      =   $request->id;

  		//get function from other controller
  		$myVar = new SiteSettingController();
  		$languages = $myVar->getLanguages();

  		$slug = str_replace(' ','-' ,trim($request->slug));
  		$slug = str_replace('_','-' ,$slug);

  		DB::table('pages')->where('page_id','=',$page_id)->update([
  					'slug'		 			 =>   $slug,
  					'type'		 			 =>   1,
  					'status'		 		 =>   $request->status,
  					]);


  		foreach($languages as $languages_data){
  			$name = 'name_'.$languages_data->languages_id;
  			$description = 'description_'.$languages_data->languages_id;

  			$checkExist = DB::table('pages_description')->where('page_id','=',$page_id)->where('language_id','=',$languages_data->languages_id)->get();

  			if(count($checkExist)>0){
  				DB::table('pages_description')->where('page_id','=',$page_id)->where('language_id','=',$languages_data->languages_id)->update([
  					'name'  	    		 =>   $request->$name,
  					'language_id'			 =>   $languages_data->languages_id,
  					'description'			 =>   addslashes($request->$description)
  					]);
  			}else{
  				DB::table('pages_description')->insert([
  					'name'  	    		 =>   $request->$name,
  					'language_id'			 =>   $languages_data->languages_id,
  					'page_id'				 =>   $page_id,
  					'description'			 =>   addslashes($request->$description)
  					]);
  			}
  		}
}

public static function pageStatus($request)
{
  if(!empty($request->id)){
    if($request->active=='no'){
      $status = '0';
    }elseif($request->active=='yes'){
      $status = '1';
    }
    DB::table('pages')->where('page_id', '=', $request->id)->update([
      'status'		 =>	  $status
      ]);
    }

}

public static function webpages($request)
{
  $language_id    =   '1';

  $pages = DB::table('pages')
    ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
    ->where([
          ['pages_description.language_id','=',$language_id],
          ['pages.type','=','2']
        ])
    ->orderBy('pages.page_id', 'ASC')
    ->paginate(20);

  $result["pages"] = $pages;
  return $result;
}

public static function addwebpage($request)
{
  $language_id      =   '1';

  $result = array();

  //get function from other controller
  $myVar = new NewsCategory();
  $result['newsCategories'] = $myVar->getter($language_id);

  //get function from other controller
  $myVar = new SiteSettingController();
  $result['languages'] = $myVar->getLanguages();

  return $result;
}

public static function addnewwebpage($request)
{

  		//get function from other controller
  		$myVar = new SiteSettingController();
  		$languages = $myVar->getLanguages();

  		$slug = str_replace(' ','-' ,trim($request->slug));
  		$slug = str_replace('_','-' ,$slug);

  		$page_id = DB::table('pages')->insertGetId([
  					'slug'		 			 =>   $slug,
  					'type'		 			 =>   2,
  					'status'		 		 =>   $request->status,
  					]);

  		foreach($languages as $languages_data){
  			$name = 'name_'.$languages_data->languages_id;
  			$description = 'description_'.$languages_data->languages_id;

  			DB::table('pages_description')->insert([
  					'name'  	    		 =>   $request->$name,
  					'language_id'			 =>   $languages_data->languages_id,
  					'page_id'				 =>   $page_id,
  					'description'			 =>   addslashes($request->$description)
  					]);
  		}

}

public static function editwebpage($request)
{
  $language_id      =   '1';
  $page_id     	  =   $request->id;

  $result = array();

  //get function from other controller
  $myVar = new SiteSettingController();
  $result['languages'] = $myVar->getLanguages();


  $pages = DB::table('pages')
    ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
    ->select('pages.*','pages_description.description','pages_description.language_id','pages_description.name' ,'pages_description.page_description_id')
    ->where('pages.page_id','=', $page_id)
    ->get();

  $description_data = array();
  foreach($result['languages'] as $languages_data){

    $description = DB::table('pages_description')->where([
        ['language_id', '=', $languages_data->languages_id],
        ['page_id', '=', $page_id],
      ])->get();

    if(count($description)>0){
      $description_data[$languages_data->languages_id]['name'] = $description[0]->name;
      $description_data[$languages_data->languages_id]['description'] = $description[0]->description;
      $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
      $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
    }else{
      $description_data[$languages_data->languages_id]['name'] = '';
      $description_data[$languages_data->languages_id]['description'] = '';
      $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
      $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
    }
  }

  $result['description'] = $description_data;
  $result['editPage'] = $pages;

  return $result;
}

public static function updatewebpage($request)
{
  $page_id      =   $request->id;

  //get function from other controller
  $myVar = new SiteSettingController();
  $languages = $myVar->getLanguages();

  $slug = str_replace(' ','-' ,trim($request->slug));
  $slug = str_replace('_','-' ,$slug);

  DB::table('pages')->where('page_id','=',$page_id)->update([
        'slug'		 			 =>   $slug,
        'type'		 			 =>   2,
        'status'		 		 =>   $request->status,
        ]);


  foreach($languages as $languages_data){
    $name = 'name_'.$languages_data->languages_id;
    $description = 'description_'.$languages_data->languages_id;

    $checkExist = DB::table('pages_description')->where('page_id','=',$page_id)->where('language_id','=',$languages_data->languages_id)->get();

    if(count($checkExist)>0){
      DB::table('pages_description')->where('page_id','=',$page_id)->where('language_id','=',$languages_data->languages_id)->update([
        'name'  	    		 =>   $request->$name,
        'language_id'			 =>   $languages_data->languages_id,
        'description'			 =>   addslashes($request->$description)
        ]);
    }else{
      DB::table('pages_description')->insert([
        'name'  	    		 =>   $request->$name,
        'language_id'			 =>   $languages_data->languages_id,
        'page_id'				 =>   $page_id,
        'description'			 =>   addslashes($request->$description)
        ]);
    }
  }


}

public static function pageWebStatus($request)
{
  if(!empty($request->id)){
    if($request->active=='no'){
      $status = '0';
    }elseif($request->active=='yes'){
      $status = '1';
    }
    DB::table('pages')->where('page_id', '=', $request->id)->update([
      'status'		 =>	  $status
      ]);
    }

}


}
