<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use App\Models\Core\Manufacturers;
use App\Models\Core\Categories;
use App\Models\Core\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\AdminControllers\AlertController;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;

class Products extends Model
{

    use Sortable;
    public $sortable =['products_id','updated_at'];
    public $sortableAs =['categories_name','products_name'];

	public function paginator($request){
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $commonsetting = $myVarsetting->commonsetting();
        $myVaralter = new AlertController($setting);

        $language_id = '1';
        $categories_id = $request->categories_id;
        $product  = $request->product;
        $results = array();
        $data = $this->sortable(['products_id'=>'DESC'])
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('manufacturers', function ($join) {
                $join->on('manufacturers.manufacturers_id', '=', 'products.manufacturers_id');
            })

            ->LeftJoin('specials', function ($join) {
                $join->on('specials.products_id', '=', 'products.products_id')->where('specials.status', '=', '1');
            })
            ->LeftJoin('image_categories', function ($join) {
                $join->on('image_categories.image_id', '=', 'products.products_image')
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    });
            });


            $data->leftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
                ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
                ->leftJoin('categories_description', 'categories.categories_id', '=', 'categories_description.categories_id');



        $data->select('products.*', 'products_description.*', 'specials.specials_id', 'manufacturers.*',
        'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price',
        'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified',
        'specials.expires_date', 'image_categories.path as path', 'products.updated_at as productupdate', 'categories_description.categories_id',
        'categories_description.categories_name')
            ->where('products_description.language_id', '=', $language_id)
            ->where('categories_description.language_id', '=', $language_id);

        if (isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id'])) {
            if (!empty(session('categories_id'))) {
                $cat_array = explode(',', session('categories_id'));
                $data->whereIn('products_to_categories.categories_id', '=', $cat_array);
            }

            $data->where('products_to_categories.categories_id', '=', $_REQUEST['categories_id']);

            if (isset($_REQUEST['product']) and !empty($_REQUEST['product'])) {
                $data->where('products_name', 'like', '%' . $_REQUEST['product'] . '%');
            }

            $products = $data->orderBy('products.products_id', 'DESC')
            ->where('categories_status', '1')->paginate($commonsetting['pagination']);

        } else {

            if (!empty(session('categories_id'))) {
                $cat_array = explode(',', session('categories_id'));
                $data->whereIn('products_to_categories.categories_id', $cat_array);
            }
            $products = $data->orderBy('products.products_id', 'DESC')
            ->where('categories_status', '1')
            ->where('is_current', '1')
            ->groupBy('products.products_id')->paginate($commonsetting['pagination']);
        }

        return $products;
    }

  public function getter(){
              $setting = new Setting();
              $myVarsetting = new SiteSettingController($setting);
              $commonsetting = $myVarsetting->commonsetting();
              $myVaralter = new AlertController($setting);

              $language_id = '1';
              $categories_id = '';
              $product  = '';
              $results = array();
              $data = $this->sortable(['products_id'=>'ASC'])
                  ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                  ->LeftJoin('manufacturers', function ($join) {
                      $join->on('manufacturers.manufacturers_id', '=', 'products.manufacturers_id');
                  })
                  ->LeftJoin('specials', function ($join) {
                      $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
                  })
                  ->LeftJoin('image_categories', function ($join) {
                      $join->on('image_categories.image_id', '=', 'products.products_image')
                          ->where(function ($query) {
                              $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                                  ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                                  ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                          });
                  });

            //  if (isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id']) or !empty(session('categories_id'))) {

                  $data->leftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
                      ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
                      ->leftJoin('categories_description', 'categories.categories_id', '=', 'categories_description.categories_id');

            //  }

              $data->select('products.*', 'products_description.*', 'specials.specials_id', 'manufacturers.*', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date', 'image_categories.path as path',
              'products.updated_at as productupdate', 'categories_description.categories_id', 'categories_description.categories_name')
                  ->where('products_description.language_id', '=', $language_id)
                  ->where('categories_description.language_id', '=', $language_id);

              if (isset($_REQUEST['categories_id']) and !empty($_REQUEST['categories_id'])) {
                  if (!empty(session('categories_id'))) {
                      $cat_array = explode(',', session('categories_id'));
                      $data->whereIn('products_to_categories.categories_id', '=', $cat_array);
                  }

                  $data->where('products_to_categories.categories_id', '=', $_REQUEST['categories_id']);

                  if (isset($_REQUEST['product']) and !empty($_REQUEST['product'])) {
                      $data->where('products_name', 'like', '%' . $_REQUEST['product'] . '%');
                  }

                  $products = $data->orderBy('products.products_id', 'DESC')->paginate($commonsetting['pagination']);

              } else {

                  if (!empty(session('categories_id'))) {
                      $cat_array = explode(',', session('categories_id'));
                      $data->whereIn('products_to_categories.categories_id', $cat_array);
                  }
                  $products = $data->orderBy('products.products_id', 'DESC')
                  ->groupBy('products.products_id')->paginate($commonsetting['pagination']);
              }

              return $products;
          }

  public function insert($request){
    $language_id      =   '1';
    $date_added	= date('Y-m-d h:i:s');

    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $languages = $myVarsetting->getLanguages();

    $expiryDate = str_replace('/', '-', $request->expires_date);
    $expiryDateFormate = strtotime($expiryDate);

    if($request->image_id !== null){
      $uploadImage = $request->image_id;
    }else{
        $uploadImage = '';
    }
    if ($request->tax_class_id == "Select Tax Class"){
        $tax_Class_id = 0;
    }else{
        $tax_Class_id = $request->tax_class_id;
    }
    $products_id = DB::table('products')->insertGetId([
        'products_image' => $uploadImage,
        'manufacturers_id' => $request->manufacturers_id,
        'products_quantity' => 0,
        'products_model' => $request->products_model,
        'products_price' => $request->products_price,
        'created_at' => $date_added,
        'products_weight' => $request->products_weight,
        'products_status' => $request->products_status,
        'products_tax_class_id' => $tax_Class_id,
        'products_weight_unit' => $request->products_weight_unit,
        'low_limit' => 0,
        'products_slug' => 0,
        'products_type' => $request->products_type,
        'is_feature' => $request->is_feature,
        'products_min_order' => $request->products_min_order,
        'products_max_stock' => $request->products_max_stock,
        'products_video_link' => $request->products_video_link,
        'is_current'         => 1
    ]);

    $slug_flag = false;
    foreach($languages as $languages_data){
        $products_name = 'products_name_'.$languages_data->languages_id;
        $products_url = 'products_url_'.$languages_data->languages_id;
        $products_description = 'products_description_'.$languages_data->languages_id;
        //left banner
        $products_left_banner = 'products_left_banner_'.$languages_data->languages_id;
        $products_left_banner_start_date = 'products_left_banner_start_date_'.$languages_data->languages_id;
        if(!empty($request->$products_left_banner_start_date)){
          $leftStartDate = str_replace('/', '-', $request->$products_left_banner_start_date);
          $leftStartDateFormat = strtotime($leftStartDate);
        }else{
            $leftStartDateFormat = null;
        }
        //expire date
        $products_left_banner_expire_date = 'products_left_banner_expire_date_'.$languages_data->languages_id;
        if(!empty($request->$products_left_banner_expire_date)){
          $leftExpiretDate = str_replace('/', '-', $request->$products_left_banner_expire_date);
          $leftExpireDateFormat = strtotime($leftExpiretDate);
        }else{
            $leftExpireDateFormat = null;
        }
        //right banner
        $products_right_banner = 'products_right_banner_'.$languages_data->languages_id;
        $products_right_banner_start_date = 'products_right_banner_start_date_'.$languages_data->languages_id;
        if(!empty($request->$products_right_banner_start_date)){
            $rightStartDate = str_replace('/', '-', $request->$products_right_banner_start_date);
            $rightStartDateFormat = strtotime($rightStartDate);
        }else{
            $rightStartDateFormat = null;
        }
        //expire date
        $products_right_banner_expire_date = 'products_right_banner_expire_date_'.$languages_data->languages_id;
        if(!empty($request->$products_right_banner_expire_date)){
            $rightExpiretDate = str_replace('/', '-', $request->$products_right_banner_expire_date);
            $rightExpireDateFormat = strtotime($rightExpiretDate);
        }else{
            $rightExpireDateFormat = null;
        }
        //slug
        if($slug_flag==false){
            $slug_flag=true;
            $slug = $request->$products_name;
            $old_slug = $request->$products_name;
            $slug_count = 0;
            do{
                if($slug_count==0){
                    $currentSlug = $myVarsetting->slugify($slug);
                }else{
                    $currentSlug = $myVarsetting->slugify($old_slug.'-'.$slug_count);
                }
                $slug = $currentSlug;
                $checkSlug = DB::table('products')->where('products_slug', $currentSlug)->get();
                $slug_count++;
            }
            while(count($checkSlug)>0);
            DB::table('products')
              ->where('products_id', $products_id)
              ->update([
                'products_slug' => $slug
            ]);
        }

        if($request->$products_left_banner !== null){
            $leftBanner = $request->$products_left_banner;
        }else{
            $leftBanner = '';
        }
        if($request->$products_right_banner !== null){
            $rightBanner = $request->$products_right_banner;
        }else{
            $rightBanner = '';
        }
        $req_products_name = $request->$products_name ;
        $req_products_url = $request->$products_url;
        $req_products_description = $request->$products_description;
        DB::table('products_description')->insert([
            'products_name' => $req_products_name,
            'language_id' => $languages_data->languages_id,
            'products_id' => $products_id,
            'products_url' => $req_products_url,
            'products_left_banner' => $leftBanner,
            'products_left_banner_start_date' => $leftStartDateFormat,
            'products_left_banner_expire_date' => $leftExpireDateFormat,
            'products_right_banner' => $rightBanner,
            'products_right_banner_start_date' => $rightStartDateFormat,
            'products_right_banner_expire_date' => $rightExpireDateFormat,
            'products_description' => addslashes($req_products_description)

        ]);
    }

    //flash sale product
    if($request->isFlash == 'yes'){
        $startdate = $request->flash_start_date;
        $starttime = $request->flash_start_time;
        $start_date = str_replace('/','-',$startdate.' '.$starttime);
        $flash_start_date = strtotime($start_date);
        $expiredate = $request->flash_expires_date;
        $expiretime = $request->flash_end_time;
        $expire_date = str_replace('/','-',$expiredate.' '.$expiretime);
        $flash_expires_date = strtotime($expire_date);
        DB::table('flash_sale')->insert([
            'products_id' => $products_id,
            'flash_sale_products_price' => $request->flash_sale_products_price,
            'created_at' => $date_added,
            'flash_start_date' => $flash_start_date,
            'flash_expires_date' => $flash_expires_date,
            'flash_status' => $request->flash_status
        ]);
    }

    //special product
    if($request->isSpecial == 'yes'){
      DB::table('specials')
      ->where('products_id', '=', $products_id)
      ->update([
          'specials_last_modified' => $date_added,
          'date_status_change' => $date_added,
          'status' => 0,
      ]);
      DB::table('specials')
      ->insert([
          'products_id' => $products_id,
          'specials_new_products_price' => $request->specials_new_products_price,
          'specials_date_added' => time(),
          'expires_date' => $expiryDateFormate,
          'status' => $request->status,
      ]);

    }
    foreach($request->categories as $categories){
      DB::table('products_to_categories')
        ->insert([
          'products_id' => $products_id,
          'categories_id' => $categories
      ]);
    }
    $options = DB::table('products_options')
        ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
        ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
        ->where('products_options_descriptions.language_id', $language_id)
        ->get();

    if(!empty($options) and count($options)>0){
      $result['options'] = $options;
    }else{
        $result['options'] = '';
    }

    $options_value = DB::table('products_options_values')
    ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
    ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
    ->where('products_options_values_descriptions.language_id', '=', $language_id)
    ->get();
    if(!empty($options_value) and count($options_value)>0){
       $result['options_value'] = $options_value;
   }else{
       $result['options_value'] = '';
   }
    return $products_id;
  }

  public function edit($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id      =   '1';
    $products_id      =   $request->id;
    $category_id	  =	  '0';
    $result = array();

    //get function from other controller
    $result['languages'] = $myVarsetting->getLanguages();
    $result['units'] = $myVarsetting->getUnits();

    //tax class
    $taxClass = DB::table('tax_class')->get();
    $result['taxClass'] = $taxClass;

    //get function from ManufacturerController controller
    $getManufacturers = DB::table('manufacturers')
        ->leftJoin('manufacturers_info','manufacturers_info.manufacturers_id', '=', 'manufacturers.manufacturers_id')
        ->select('manufacturers.manufacturers_id as id', 'manufacturers.manufacturer_image as image',  'manufacturers.manufacturer_name as name', 'manufacturers_info.manufacturers_url as url', 'manufacturers_info.url_clicked', 'manufacturers_info.date_last_click as clik_date')
        ->where('manufacturers_info.languages_id', $language_id)->get();
    $result['manufacturer'] = $getManufacturers;
    $product = DB::table('products')
        ->LeftJoin('image_categories', function ($join) {

            $join->on('image_categories.image_id', '=', 'products.products_image')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });

        })
        ->where('products.products_id', '=', $products_id)
        ->get();

    $description_data = array();

    foreach($result['languages'] as $languages_data){
      $description = DB::table('products_description')
          ->LeftJoin('image_categories as imgleftbannert', function ($join) {

              $join->on('imgleftbannert.image_id', '=', 'products_description.products_left_banner')
                  ->where(function ($query) {
                      $query->where('imgleftbannert.image_type', '=', 'THUMBNAIL')
                          ->where('imgleftbannert.image_type', '!=', 'THUMBNAIL')
                          ->orWhere('imgleftbannert.image_type', '=', 'ACTUAL');
                  });

          })
          ->LeftJoin('image_categories as imgrightbannert', function ($join) {

              $join->on('imgrightbannert.image_id', '=', 'products_description.products_right_banner')
                  ->where(function ($query) {
                      $query->where('imgrightbannert.image_type', '=', 'THUMBNAIL')
                          ->where('imgrightbannert.image_type', '!=', 'THUMBNAIL')
                          ->orWhere('imgrightbannert.image_type', '=', 'ACTUAL');
                  });

          })
          ->where([
              ['language_id', '=', $languages_data->languages_id],
              ['products_id', '=', $products_id],

          ])->select('products_description.*', 'imgrightbannert.path as imgright', 'imgleftbannert.path as imgleft')->get();



        if(count($description)>0){
            $description_data[$languages_data->languages_id]['products_name'] = $description[0]->products_name;
            $description_data[$languages_data->languages_id]['products_url'] = $description[0]->products_url;
            $description_data[$languages_data->languages_id]['products_description'] = $description[0]->products_description;
            $description_data[$languages_data->languages_id]['products_left_banner'] =  $description[0]->products_left_banner;
            $description_data[$languages_data->languages_id]['products_left_banner_start_date'] = $description[0]->products_left_banner_start_date;
            $description_data[$languages_data->languages_id]['products_left_banner_expire_date'] = $description[0]->products_left_banner_expire_date;
            $description_data[$languages_data->languages_id]['products_right_banner'] = $description[0]->products_right_banner;
            $description_data[$languages_data->languages_id]['products_right_banner_start_date'] = $description[0]->products_right_banner_start_date;
            $description_data[$languages_data->languages_id]['products_right_banner_expire_date'] = $description[0]->products_right_banner_expire_date;
            $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
            $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            $description_data[$languages_data->languages_id]['imgright'] = $description[0]->imgright;
            $description_data[$languages_data->languages_id]['imgleft'] = $description[0]->imgleft;

        }else{
            $description_data[$languages_data->languages_id]['products_name'] = '';
            $description_data[$languages_data->languages_id]['products_url'] = '';
            $description_data[$languages_data->languages_id]['products_description'] = '';
            $description_data[$languages_data->languages_id]['products_left_banner'] =  '';
            $description_data[$languages_data->languages_id]['products_left_banner_start_date'] = '';
            $description_data[$languages_data->languages_id]['products_left_banner_expire_date'] = '';
            $description_data[$languages_data->languages_id]['products_right_banner'] =  '';
            $description_data[$languages_data->languages_id]['products_right_banner_start_date'] = '';
            $description_data[$languages_data->languages_id]['products_right_banner_expire_date'] = '';
            $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
            $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            $description_data[$languages_data->languages_id]['imgright'] =  '';
            $description_data[$languages_data->languages_id]['imgleft'] =  '';

        }

    }
    $result['description'] = $description_data;
    $result['product'] = $product;
    $categories = DB::table('products_to_categories')
        ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
        ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
        ->where('products_id', '=', $products_id)->where('categories_description.language_id', '=', $language_id)
        ->where('categories_status', '1')
        ->get();

    $categories_array = array();
    foreach($categories as $category){
        $categories_array[] = $category->categories_id;
    }

    $result['categories_array'] = $categories_array;
    $getSpecialProduct = DB::table('specials')->where('products_id', $products_id)->orderby('specials_id', 'desc')->limit(1)->get();
    if(count($getSpecialProduct)>0){
        $specialProduct = $getSpecialProduct;
    }else{
        $specialProduct[0] = (object) array('specials_id'=>'', 'products_id'=>'', 'specials_new_products_price'=>'', 'status'=>'', 'expires_date' => '');
    }
    $result['specialProduct'] = $specialProduct;

    $getflashProduct = DB::table('flash_sale')->where('products_id', $products_id)->orderby('flash_sale_id', 'desc')->limit(1)->get();
    if(count($getflashProduct)>0){
        $flashProduct = $getflashProduct;
    }else{
        $flashProduct[0] = (object) array('products_id'=>'', 'flash_sale_products_price'=>'', 'flash_status'=>'', 'flash_start_date' => '', 'flash_expires_date' => '');
    }
    $result['flashProduct'] = $flashProduct;

    return $result;
  }

  public function updaterecord($request){
          $setting = new Setting();
          $myVarsetting = new SiteSettingController($setting);
          $myVaralter = new AlertController($setting);
          $language_id      =   '1';
          $products_id      =   $request->id;
          $products_last_modified	= date('Y-m-d h:i:s');
          $expiryDate = str_replace('/', '-', $request->expires_date);
          $expiryDateFormate = strtotime($expiryDate);
          $languages = $myVarsetting->getLanguages();

          //check slug
          if($request->old_slug!=$request->slug ){
              $slug = $request->slug;
              $slug_count = 0;
              do{
                  if($slug_count==0){
                      $currentSlug = $myVarsetting->slugify($request->slug);
                  }else{
                      $currentSlug = $myVarsetting->slugify($request->slug.'-'.$slug_count);
                  }
                  $slug = $currentSlug;
                  $checkSlug = DB::table('products')->where('products_slug', $currentSlug)->where('products_id', '!=', $products_id)->get();
                  $slug_count++;
              }
              while(count($checkSlug)>0);
          }else{
              $slug = $request->slug;
          }
          if($request->image_id !== null){
              $uploadImage = $request->image_id;
          }else{
              $uploadImage = $request->oldImage;
          }

          DB::table('products')->where('products_id', '=', $products_id)->update([
              'products_image' => $uploadImage,
              'manufacturers_id' => $request->manufacturers_id,
              'products_quantity' => 0,
              'products_model' => $request->products_model,
              'products_price' => $request->products_price,
              'updated_at' => $products_last_modified,
              'products_weight' => $request->products_weight,
              'products_status' => $request->products_status,
              'products_tax_class_id' => $request->tax_class_id,
              'products_weight_unit' => $request->products_weight_unit,
              'low_limit' => 0,
              'products_slug' => $slug,
              'products_type' => $request->products_type,
              'is_feature' => $request->is_feature,
              'products_min_order' => $request->products_min_order,
              'products_max_stock' => $request->products_max_stock,
              'products_video_link' => $request->products_video_link,

          ]);
          foreach($languages as $languages_data){
              $products_name = 'products_name_'.$languages_data->languages_id;
              $products_url = 'products_url_'.$languages_data->languages_id;
              $products_description = 'products_description_'.$languages_data->languages_id;
              //left banner
              $products_left_banner = 'products_left_banner_'.$languages_data->languages_id;
              $products_left_banner_start_date = 'products_left_banner_start_date_'.$languages_data->languages_id;
              if(!empty($request->$products_left_banner_start_date)){
                  $leftStartDate = str_replace('/', '-', $request->$products_left_banner_start_date);
                  $leftStartDateFormat = strtotime($leftStartDate);
              }else{
                  $leftStartDateFormat = '';
              }
              //expire date
              $products_left_banner_expire_date = 'products_left_banner_expire_date_'.$languages_data->languages_id;
              if(!empty($request->$products_left_banner_expire_date)){
                  $leftExpiretDate = str_replace('/', '-', $request->$products_left_banner_expire_date);
                  $leftExpireDateFormat = strtotime($leftExpiretDate);
              }else{
                  $leftExpireDateFormat = '';
              }
              //right banner
              $products_right_banner = 'products_right_banner_'.$languages_data->languages_id;
              $products_right_banner_start_date = 'products_right_banner_start_date_'.$languages_data->languages_id;
              if(!empty($request->$products_right_banner_start_date)){
                  $rightStartDate = str_replace('/', '-', $request->$products_right_banner_start_date);
                  $rightStartDateFormat = strtotime($rightStartDate);
              }else{
                  $rightStartDateFormat = '';
              }
              //expire date
              $products_right_banner_expire_date = 'products_right_banner_expire_date_'.$languages_data->languages_id;
              if(!empty($request->$products_right_banner_expire_date)){
                  $rightExpiretDate = str_replace('/', '-', $request->$products_right_banner_expire_date);
                  $rightExpireDateFormat = strtotime($rightExpiretDate);
              }else{
                  $rightExpireDateFormat = '';
              }
              $old_left_banner = 'old_left_banner_'.$languages_data->languages_id;
              $old_right_banner = 'old_right_banner_'.$languages_data->languages_id;
              if($request->$products_left_banner !== null){
                  $leftBanner = $request->$products_left_banner;
              }else{
                  $leftBanner = $request->$old_left_banner;
              }
              if($request->$products_right_banner !== null){
                  $rightBanner = $request->$products_right_banner;
              }else{
                  $rightBanner = $request->$old_right_banner;
              }
              $checkExist = DB::table('products_description')->where('products_id', '=', $products_id)->where('language_id', '=', $languages_data->languages_id)->get();
              if(count($checkExist)>0){
                  $req_products_name = $request->$products_name;
                  $req_products_url = $request->$products_url;
                  $req_products_description = $request->$products_description;

                  DB::table('products_description')->where('products_id', '=', $products_id)
                  ->where('language_id', '=', $languages_data->languages_id)->update([
                      'products_name' => $req_products_name,
                      'products_url' => $req_products_url,
                      'products_left_banner' => $leftBanner,
                      'products_right_banner' => $rightBanner,
                      'products_left_banner_start_date' => $leftStartDateFormat,
                      'products_left_banner_expire_date' => $leftExpireDateFormat,
                      'products_right_banner_start_date' => $rightStartDateFormat,
                      'products_right_banner_expire_date' => $rightExpireDateFormat,
                      'products_description' => addslashes($req_products_description)

                  ]);
              }else{
                  $req_products_name = $request->$products_name;
                  $req_products_url = $request->$products_url;
                  $req_products_description = $request->$products_description;
                  DB::table('products_description')->insert([
                      'products_name' => $req_products_name,
                      'language_id' => $languages_data->languages_id,
                      'products_id' => $products_id,
                      'products_url' => $req_products_url,
                      'products_left_banner' => $leftBanner,
                      'products_right_banner' => $rightBanner,
                      'products_left_banner_start_date' => $leftStartDateFormat,
                      'products_left_banner_expire_date' => $leftExpireDateFormat,
                      'products_right_banner_start_date' => $rightStartDateFormat,
                      'products_right_banner_expire_date' => $rightExpireDateFormat,
                      'products_description' => addslashes($req_products_description)
                  ]);
              }
          }
          //delete categories
          DB::table('products_to_categories')->where([
              'products_id' => $products_id,
          ])->delete();
          foreach($request->categories as $categories){
            DB::table('products_to_categories')->insert([
                'products_id' => $products_id,
                'categories_id' => $categories
            ]);
          }

          //special product
          if($request->isSpecial == 'yes'){
            DB::table('specials')->where('products_id', '=', $products_id)->update([
                'specials_last_modified' => $products_last_modified,
                'date_status_change' => $products_last_modified,
                'status' => 0,
            ]);
            DB::table('specials')->insert([
                'products_id' => $products_id,
                'specials_new_products_price' => $request->specials_new_products_price,
                'specials_date_added' => time(),
                'expires_date' => $expiryDateFormate,
                'status' => $request->status,
            ]);
            }else if($request->isSpecial == 'no'){
              DB::table('specials')->where('products_id', '=', $products_id)->delete();
            }

          //flash sale product
          if($request->isFlash == 'yes'){
            DB::table('flash_sale')->where('products_id', '=', $products_id)->update([
                'updated_at' => $products_last_modified,
                'flash_status' => 0,
            ]);
              $startdate = $request->flash_start_date;
              $starttime = $request->flash_start_time;
              $start_date = str_replace('/','-',$startdate.' '.$starttime);
              $flash_start_date = strtotime($start_date);
              $expiredate = $request->flash_expires_date;
              $expiretime = $request->flash_end_time;
              $expire_date = str_replace('/','-',$expiredate.' '.$expiretime);
              $flash_expires_date = strtotime($expire_date);
              DB::table('flash_sale')->insert([
                  'products_id' => $products_id,
                  'flash_sale_products_price' => $request->flash_sale_products_price,
                  'created_at' => $products_last_modified,
                  'flash_start_date' => $flash_start_date,
                  'flash_expires_date' => $flash_expires_date,
                  'flash_status' => $request->flash_status
              ]);
           }else if($request->isFlash == 'no'){
             DB::table('flash_sale')->where('products_id', '=', $products_id)->delete();                
            }
          $options = DB::table('products_options')
             ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
             ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('products_options_descriptions.language_id', '1')->get();

          $result['options'] = $options;
          $options_value = DB::table('products_options_values')
              ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
              ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
              ->where('products_options_values_descriptions.language_id', '=', $language_id)
              ->get();                $result['options_value'] = $options_value;
          $result['data'] = array('products_id'=>$products_id, 'language_id'=>$language_id);
          return $result;
  }

  public function deleterecord($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $products_id = $request->products_id;
    $categories = DB::table('products_to_categories')->where('products_id', $products_id)->delete();
    $categories = DB::table('products')->where('products_id', $products_id)->delete();
    $categories = DB::table('specials')->where('products_id', $products_id)->delete();
    $categories = DB::table('products_description')->where('products_id', $products_id)->delete();
    $categories = DB::table('products_attributes')->where('products_id', $products_id)->delete();
  }

  public function addinventory($id){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id      =   '1';
    $products_id      =   $id;
    $result = array();
    $message = array();
    $errorMessage = array();
    $result['currency'] = $myVarsetting->getSetting();
    $product = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
                ->LeftJoin('specials', function ($join) {

                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');

                })
                ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);


            if ($products_id != null) {

                $product->where('products.products_id', '=', $products_id);

            } else {

                $product->orderBy('products.products_id', 'DESC');

            }

            $product =  $product->get();
    $result['products'] = $product;
    $products = $product;
    $result['message'] = $message;
    $result['errorMessage'] = $errorMessage;
    $result2 = array();
    $index = 0;
    $stocks = 0;
    $min_level = 0;
    $max_level = 0;
    $purchase_price  = 0;
    if($result['products'][0]->products_type!=1){

      $currentStocks = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->get();
      $purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');

        if(count($currentStocks)>0){
            foreach($currentStocks as $currentStock){
                $stocks += $currentStock->stock;
            }
        }

          $manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
        if(count($manageLevel)>0){
            $min_level = $manageLevel[0]->min_level;
            $max_level = $manageLevel[0]->max_level;
        }

    }

    $result['purchase_price'] = $purchase_price;
    $result['stocks'] = $stocks;
    $result['min_level'] = $min_level;
    $result['max_level'] = $max_level;
    $products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->get();
    $products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    if(count($products_attribute)>0){
        $index2 = 0;
        foreach($products_attribute as $attribute_data){
          $option_name = DB::table('products_options')
              ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
              ->where('products_options_descriptions.language_id', $language_id)
              ->where('products_options.products_options_id', $attribute_data->options_id)
              ->get();
            if(count($option_name)>0){

                $temp = array();
                $temp_option['id'] = $attribute_data->options_id;
                $temp_option['name'] = $option_name[0]->products_options_name;
                $attr[$index2]['option'] = $temp_option;
                // fetch all attributes add join from products_options_values table for option value name
                $attributes_value_query = DB::table('products_attributes')
                ->where('products_id', '=', $products_id)
                ->where('options_id', '=', $attribute_data->options_id)
                ->get();
                foreach($attributes_value_query as $products_option_value){
                    $option_value = DB::table('products_options_values')
                    ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                    ->where('products_options_values_descriptions.language_id', '=', $language_id)
                    ->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
                    ->get();
                    if(count($option_value)>0){
                        $attributes = DB::table('products_attributes')
                        ->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
                        ->get();
                        $temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
                        $temp_i['id'] = $products_option_value->options_values_id;
                        $temp_i['value'] = $option_value[0]->products_options_values_name;
                        $temp_i['price'] = $products_option_value->options_values_price;
                        $temp_i['price_prefix'] = $products_option_value->price_prefix;
                        array_push($temp,$temp_i);
                    }

                }

                $attr[$index2]['values'] = $temp;
                $result['attributes'] = 	$attr;
                $index2++;

            }
        }

    }else{

        $result['attributes'] = 	array();

    }
      return $result;
  }

  public function ajax_attr($id){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id      =   '1';
    $products_id      =   $id;
    $result = array();
    $message = array();
    $errorMessage = array();
    $result['currency'] = $myVarsetting->getSetting();
    $product = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
                ->LeftJoin('specials', function ($join) {
                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
                })
                ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);

            if ($products_id != null) {
                $product->where('products.products_id', '=', $products_id);
            } else {
                $product->orderBy('products.products_id', 'DESC');
            }

            $product =  $product->get();
    $result['products'] = $product;
    $products = $product;
    $result['message'] = $message;
    $result['errorMessage'] = $errorMessage;
    $result2 = array();
    $index = 0;
    $stocks = 0;
    $min_level = 0;
    $max_level = 0;
    $purchase_price  = 0;
    if($result['products'][0]->products_type!=1){

      $stocksin = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'in')->sum('stock');
      $stockOut = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'out')->sum('stock');
      $stocks = $stocksin - $stockOut;

          $manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
        if(count($manageLevel)>0){
            $min_level = $manageLevel[0]->min_level;
            $max_level = $manageLevel[0]->max_level;
        }

    }

    $result['purchase_price'] = $purchase_price;
    $result['stocks'] = $stocks;
    $result['min_level'] = $min_level;
    $result['max_level'] = $max_level;
    $products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->get();
    $products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    if(count($products_attribute)>0){
        $index2 = 0;
        foreach($products_attribute as $attribute_data){
          $option_name = DB::table('products_options')
              ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
              ->where('products_options_descriptions.language_id', $language_id)
              ->where('products_options.products_options_id', $attribute_data->options_id)
              ->get();
            if(count($option_name)>0){

                $temp = array();
                $temp_option['id'] = $attribute_data->options_id;
                $temp_option['name'] = $option_name[0]->products_options_name;
                $attr[$index2]['option'] = $temp_option;
                // fetch all attributes add join from products_options_values table for option value name
                $attributes_value_query = DB::table('products_attributes')
                ->where('products_id', '=', $products_id)
                ->where('options_id', '=', $attribute_data->options_id)
                ->get();
                foreach($attributes_value_query as $products_option_value){
                    $option_value = DB::table('products_options_values')
                    ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                    ->where('products_options_values_descriptions.language_id', '=', $language_id)
                    ->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
                    ->get();
                    if(count($option_value)>0){
                        $attributes = DB::table('products_attributes')
                        ->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
                        ->get();
                        $temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
                        $temp_i['id'] = $products_option_value->options_values_id;
                        $temp_i['value'] = $option_value[0]->products_options_values_name;
                        $temp_i['price'] = $products_option_value->options_values_price;
                        $temp_i['price_prefix'] = $products_option_value->price_prefix;
                        array_push($temp,$temp_i);
                    }

                }

                $attr[$index2]['values'] = $temp;
                $result['attributes'] = 	$attr;
                $index2++;

            }
        }

    }else{

        $result['attributes'] = 	array();

    }
      return $result;
  }

  public function ajax_min_max($id){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id      =   '1';
    $products_id      =   $id;
    $result = array();
    $message = array();
    $errorMessage = array();
    $result['currency'] = $myVarsetting->getSetting();
    $product = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
                ->LeftJoin('specials', function ($join) {

                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');

                })
                ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);


            if ($products_id != null) {

                $product->where('products.products_id', '=', $products_id);

            } else {

                $product->orderBy('products.products_id', 'DESC');

            }

            $product =  $product->get();
    $result['products'] = $product;
    $products = $product;
    $result['message'] = $message;
    $result['errorMessage'] = $errorMessage;
    $result2 = array();
    $index = 0;
    $stocks = 0;
    $min_level = 0;
    $max_level = 0;
    $purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');

    if($result['products'][0]->products_type!=1){

      $stocksin = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'in')->sum('stock');
      $stockOut = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->where('stock_type', 'out')->sum('stock');
      $stocks = $stocksin - $stockOut;

        $manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
        if(count($manageLevel)>0){
            $min_level = $manageLevel[0]->min_level;
            $max_level = $manageLevel[0]->max_level;
        }

    }

    $result['purchase_price'] = $purchase_price;
    $result['stocks'] = $stocks;
    $result['min_level'] = $min_level;
    $result['max_level'] = $max_level;
    $products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->get();
    $products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    if(count($products_attribute)>0){
        $index2 = 0;
        foreach($products_attribute as $attribute_data){
          $option_name = DB::table('products_options')
              ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
              ->where('products_options_descriptions.language_id', $language_id)
              ->where('products_options.products_options_id', $attribute_data->options_id)
              ->get();
            if(count($option_name)>0){

                $temp = array();
                $temp_option['id'] = $attribute_data->options_id;
                $temp_option['name'] = $option_name[0]->products_options_name;
                $attr[$index2]['option'] = $temp_option;
                // fetch all attributes add join from products_options_values table for option value name
                $attributes_value_query = DB::table('products_attributes')
                ->where('products_id', '=', $products_id)
                ->where('options_id', '=', $attribute_data->options_id)
                ->get();
                foreach($attributes_value_query as $products_option_value){
                    $option_value = DB::table('products_options_values')
                    ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                    ->where('products_options_values_descriptions.language_id', '=', $language_id)
                    ->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
                    ->get();
                    if(count($option_value)>0){
                        $attributes = DB::table('products_attributes')
                        ->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
                        ->get();
                        $temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
                        $temp_i['id'] = $products_option_value->options_values_id;
                        $temp_i['value'] = $option_value[0]->products_options_values_name;
                        $temp_i['price'] = $products_option_value->options_values_price;
                        $temp_i['price_prefix'] = $products_option_value->price_prefix;
                        array_push($temp,$temp_i);
                    }

                }

                $attr[$index2]['values'] = $temp;
                $result['attributes'] = 	$attr;
                $index2++;

            }
        }

    }else{

        $result['attributes'] = 	array();

    }
      return $result;
  }

  public function addinventoryfromsidebar(){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id      =   '1';
    $result = array();
    $message = array();
    $errorMessage = array();
    $result['currency'] = $myVarsetting->getSetting();
    $product = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
                ->LeftJoin('specials', function ($join) {

                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');

                })
                ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);

    $product =  $product->get();
    $result['products'] = $product;
    $products = $product;
    $result['message'] = $message;
    $result['errorMessage'] = $errorMessage;
    $result2 = array();
    $index = 0;
    $stocks = 0;
    $min_level = 0;
    $max_level = 0;
    $purchase_price  = 0;
    if(count($product)>0){
        $products_id = $result['products'][0]->products_id;
    if($result['products'][0]->products_type!=1){

      $currentStocks = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->get();
      $purchase_price = DB::table('inventory')->where('products_id', $result['products'][0]->products_id)->sum('purchase_price');

        if(count($currentStocks)>0){
            foreach($currentStocks as $currentStock){
                $stocks += $currentStock->stock;
            }
        }

          $manageLevel = DB::table('manage_min_max')->where('products_id', $result['products'][0]->products_id)->get();
        if(count($manageLevel)>0){
            $min_level = $manageLevel[0]->min_level;
            $max_level = $manageLevel[0]->max_level;
        }

    }

    $result['purchase_price'] = $purchase_price;
    $result['stocks'] = $stocks;
    $result['min_level'] = $min_level;
    $result['max_level'] = $max_level;
    $products_attribute = DB::table('products_attributes')->where('products_id', '=', 1)->get();
    $products_attribute = $products_attribute->unique('options_id')->keyBy('options_id');
    if(count($products_attribute)>0){
        $index2 = 0;
        foreach($products_attribute as $attribute_data){
          $option_name = DB::table('products_options')
              ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
              ->where('products_options_descriptions.language_id', $language_id)
              ->where('products_options.products_options_id', $attribute_data->options_id)
              ->get();
            if(count($option_name)>0){

                $temp = array();
                $temp_option['id'] = $attribute_data->options_id;
                $temp_option['name'] = $option_name[0]->products_options_name;
                $attr[$index2]['option'] = $temp_option;
                // fetch all attributes add join from products_options_values table for option value name
                $attributes_value_query = DB::table('products_attributes')
                ->where('products_id', '=', $products_id)
                ->where('options_id', '=', $attribute_data->options_id)
                ->get();
                foreach($attributes_value_query as $products_option_value){
                    $option_value = DB::table('products_options_values')
                    ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                    ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                    ->where('products_options_values_descriptions.language_id', '=', $language_id)
                    ->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)
                    ->get();
                    if(count($option_value)>0){
                        $attributes = DB::table('products_attributes')
                        ->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])
                        ->get();
                        $temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
                        $temp_i['id'] = $products_option_value->options_values_id;
                        $temp_i['value'] = $option_value[0]->products_options_values_name;
                        $temp_i['price'] = $products_option_value->options_values_price;
                        $temp_i['price_prefix'] = $products_option_value->price_prefix;
                        array_push($temp,$temp_i);
                    }

                }

                $attr[$index2]['values'] = $temp;
                $result['attributes'] = 	$attr;
                $index2++;

            }
        }

    }else{
        $result['attributes'] = 	array();
    }

    }else{
        $result['attributes'] = 	array();
    }

      return $result;
  }

  public function addnewstock($request){
    $products_id = $request->products_id;
    if($request->stock_type === "out"){
        if(($request->current_stocks_input - $request->stock ) < 0 ){
            // dd($request->current_stocks_input - $request->stock);
            return false;
        }
    }
    $language_id     =   1;
    $product = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
                ->LeftJoin('specials', function ($join) {

                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');

                })
                ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);


            if ($products_id != null) {

                $product->where('products.products_id', '=', $products_id);

            } else {

                $product->orderBy('products.products_id', 'DESC');

            }

            $product =  $product->get();
            $products = $product;
            $date_added	= date('Y-m-d h:i:s');
            $inventory_ref_id = DB::table('inventory')->insertGetId([
                'products_id' => $products_id,
                'reference_code' => $request->reference_code != "" ? $request->reference_code :"no  refrence",
                'stock' => $request->stock,
                'admin_id' => auth()->user()->id,
                'created_at' => $date_added,
                'purchase_price' => $request->purchase_price,
                'stock_type'  	=>  $request->stock_type

            ]);
            if($products[0]->products_type==1){
                foreach($request->attributeid as $attribute){
                    if(!empty($attribute)){
                    DB::table('inventory_detail')->insert([
                        'inventory_ref_id' => $inventory_ref_id,
                        'products_id' => $products_id,
                        'attribute_id' => $attribute,
                    ]);
                    }
                }
            }
            return true;
  }

  public function addminmax($request){

    $products_id = $request->products_id;
    $language_id     =   1;
    $product = DB::table('products')
                ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
                ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
                ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
                ->LeftJoin('specials', function ($join) {
                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');
                })
                ->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_id', 'specials.products_id as special_products_id', 'specials.specials_new_products_price as specials_products_price', 'specials.specials_date_added as specials_date_added', 'specials.specials_last_modified as specials_last_modified', 'specials.expires_date')
                ->where('products_description.language_id', '=', $language_id);
            if ($products_id != null) {
                $product->where('products.products_id', '=', $products_id);
            } else {
                $product->orderBy('products.products_id', 'DESC');
            }
            $product =  $product->get();

            $products = $product;
    if($products[0]->products_type==1){
        $inventory_ref_id = $request->inventory_ref_id;
    }else{
        $inventory_ref_id = 0;
    }



    $checkExist = DB::table('manage_min_max')
                    ->where('products_id', $products_id)
                    ->where('inventory_ref_id', $inventory_ref_id)
                    ->get();
    if(count($checkExist)==0){
      $manageMaxandMin = DB::table('manage_min_max')->insertGetId([
          'products_id' => $products_id,
          'min_level' => $request->min_level,
          'max_level' => $request->max_level,
          'inventory_ref_id' => $inventory_ref_id,
      ]);
    }else{
      $minandmax = DB::table('manage_min_max')->where('products_id', $products_id)->update([
          'min_level' => $request->min_level,
          'max_level' => $request->max_level,
          'inventory_ref_id' => $inventory_ref_id,
      ]);
    }

  }

  public function displayProductImages($request){
    $products_id = $request->id;
    $result['data'] = array('products_id'=>$products_id);
    $products_images = DB::table('products_images')
        ->LeftJoin('image_categories', function ($join) {
            $join->on('image_categories.image_id', '=', 'products_images.image')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });

        })
        ->where('products_id', '=', $products_id)
        ->select('products_images.*', 'image_categories.path')
        ->orderBy('sort_order', 'asc')
        ->get();
    $result['products_images'] = $products_images;
    return $result;
  }

  public function addProductImages($products_id){
    $result['data'] = array('products_id'=>$products_id);
    $products_images = DB::table('products_images')
        ->where('products_id','=', $products_id)
        ->orderBy('sort_order', 'ASC')
        ->get();
    $result['products_images'] = $products_images;
    return $result;
  }

  public function insertProductImages($request){
    $product_id = $request->products_id;
         if($request->image_id !== null){
             $image = $request->image_id;
         }else{
             $image = '';
         }
         $sort_id = DB::table('products_images')
                       ->where('products_id',$product_id)
                       ->select('sort_order')
                       ->orderBy('id', 'desc')
                       ->first();

         if($sort_id == null){
             $sort_order = 1;
         }else{
         $sort_order = $sort_id->sort_order+1;
         }
         DB::table('products_images')->insert([
             'products_id' => $product_id,
             'image' => $image,
             'htmlcontent' => $request->htmlcontent,
             'sort_order' => $sort_order,
         ]);

       return $product_id;
  }

  public function editProductImages($id){

    $products_images = DB::table('products_images')
        ->LeftJoin('image_categories', function ($join) {

            $join->on('image_categories.image_id', '=', 'products_images.image')
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                });

        })
        ->where('products_images.id', '=', $id)
        ->select('products_images.*', 'image_categories.path')
        ->get();

        return $products_images;
  }

  public function updateproductimage($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);


        if($request->image_id !== null){
          $uploadImage = $request->image_id;
        }else{
            $uploadImage = $request->oldImage;
        }
      $product_id = $request->products_id;
      DB::table('products_images')->where('products_id', '=', $request->products_id)->where('id', '=', $request->id)
          ->update([
              'image' => $uploadImage,
              'htmlcontent' => $request->htmlcontent,
              'sort_order' => $request->sort_order,
          ]);
          $products_images = DB::table('products_images')
              ->LeftJoin('image_categories', function ($join) {

                  $join->on('image_categories.image_id', '=', 'products_images.image')
                      ->where(function ($query) {
                          $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                              ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                              ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                      });

              })
              ->where('products_id', '=', $request->products_id)
              ->select('products_images.*', 'image_categories.path')
              ->orderBy('sort_order', 'ASC')
              ->get();
      $result['products_images'] = $products_images;
      return $result;
  }

  public function deleteproductimage($request){
        DB::table('products_images')
        ->where([
            'products_id' => $request->products_id,
            'id' => $request->id
        ])
        ->delete();
  }

  public function addproductattribute($request){
    $language_id = 1;
    $products_id      =   $request->id;
    $subcategory_id   =   $request->subcategory_id;
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $result['languages'] = $myVarsetting->getLanguages();
    $options = DB::table('products_options')
    ->leftjoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
    ->where('products_options_descriptions.language_id', '=', $language_id)
    ->get();
    $result['options'] = $options;
    $result['subcategory_id'] = $subcategory_id;
    $options_value = DB::table('products_options_values')->get();
    $result['options_value'] = $options_value;
    $result['data'] = array('products_id'=>$products_id);
    $products_attributes = DB::table('products_attributes')
        ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
        ->join('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_attributes.options_id')
        ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
        ->join('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_attributes.options_values_id')
        ->select('products_attributes.*', 'products_options_descriptions.options_name', 'products_options_values_descriptions.options_values_name')
        ->where('products_attributes.products_id', '=', $products_id)
        ->where('products_options_descriptions.language_id', '=', $language_id)
        ->where('products_options_values_descriptions.language_id', '=', $language_id)
        ->orderBy('products_attributes_id', 'DESC')
        ->get();
    $result['products_attributes'] = $products_attributes;

    return $result;
  }

  public function addnewdefaultattribute($request){
    $language_id = 1;
    $products_attributes = '';
    if(!empty($request->products_options_id) and !empty($request->products_id) and !empty($request->products_options_values_id)){
      $checkRecord = DB::table('products_attributes')->where([
          'options_id' => $request->products_options_id,
          'products_id' => $request->products_id,
          'options_values_id' => $request->products_options_values_id,
      ])->get();
        if(count($checkRecord)>0){
            $products_attributes = 'already';
        }else{
          $products_attributes_id = DB::table('products_attributes')->insertGetId([
              'products_id' => $request->products_id,
              'options_id' => $request->products_options_id,
              'options_values_id' => $request->products_options_values_id,
              'options_values_price' => '0',
              'price_prefix' => '+',
              'is_default' => $request->is_default
          ]);
          $products_attributes = DB::table('products_attributes')
              ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
              ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
              ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
              ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
              ->where('products_options_descriptions.language_id', '=', $language_id)
              ->where('products_options_values_descriptions.language_id', '=', $language_id)
              ->where('products_attributes.products_id', '=', $request->products_id)
              ->where('products_attributes.is_default', '=', '1')
              ->orderBy('products_attributes_id', 'DESC')
              ->get();
        }
    }else{
        $products_attributes = 'empty';
    }

    return $products_attributes;
  }

  public function editdefaultattribute($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $languages = $myVarsetting->getLanguages();

    $products_id = $request->products_id;
    $products_attributes_id = $request->products_attributes_id;
    $language_id = 1;
    $options_id = $request->options_id;
    $options = DB::table('products_options')
        ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
        ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
        ->where('products_options_descriptions.language_id', '=', $language_id)
        ->get();
    $result['options'] = $options;
    $options_value = DB::table('products_options_values')
        ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
        ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
        ->where('products_options_values_descriptions.language_id', '=', $language_id)
        ->where('products_options_values.products_options_id', '=', $options_id)
        ->get();
    $result['options_value'] = $options_value;
    $result['data'] = array('products_id'=>$request->products_id, 'products_attributes_id'=>$products_attributes_id, 'language_id'=>$language_id);
    $products_attributes = DB::table('products_attributes')
        ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
        ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
        ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
        ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
        ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
        ->where('products_options_descriptions.language_id', '=', $language_id)
        ->where('products_options_values_descriptions.language_id', '=', $language_id)
        ->where('products_attributes.products_attributes_id', '=', $products_attributes_id)
        ->get();
    $result['products_attributes'] = $products_attributes;
    $result['languages'] = $languages;
    return $result;
  }

  public function updatedefaultattribute($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    if(!empty($request->products_options_id) and !empty($request->products_id) and !empty($request->products_options_values_id)){
        $language_id = 1;
        $checkRecord = DB::table('products_attributes')->where([
            'options_id' => $request->products_options_id,
            'options_values_id' => $request->products_options_values_id,
            'products_id' => $request->products_id
        ])->get();
        $productsattri = DB::table('products_attributes')->where('products_attributes_id', '=', $request->products_attributes_id)->update([
            'options_id' => $request->products_options_id,
            'options_values_id' => $request->products_options_values_id,            
            'options_values_price' => 0,
            'price_prefix' => '+',

        ]);
        $products_attributes = DB::table('products_attributes')
            ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
            ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
            ->where('products_options_descriptions.language_id', '=', $language_id)
            ->where('products_options_values_descriptions.language_id', '=', $language_id)
            ->where('products_attributes.products_id', '=', $request->products_id)
            ->where('products_attributes.is_default', '=', '1')
            ->orderBy('products_attributes_id', 'DESC')
            ->get();
    }else{
        $products_attributes = 'empty';
    }
    return $products_attributes;
  }

  public function deletedefaultattribute($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);

              $language_id      =   '1';
              $checkRecord = DB::table('products_attributes')->where([
                  'products_attributes_id' => $request->products_attributes_id,
                  'products_id' => $request->products_id
              ])->delete();
              $products_attributes = DB::table('products_attributes')
                  ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                  ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
                  ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                  ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                  ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                  ->where('products_options_descriptions.language_id', '=', $language_id)
                  ->where('products_options_values_descriptions.language_id', '=', $language_id)
                  ->where('products_attributes.products_id', '=', $request->products_id)
                  ->where('products_attributes.is_default', '=', '1')
                  ->orderBy('products_attributes_id', 'DESC')
                  ->get();
                  return $products_attributes;
  }

  public function showoptions($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);

            if(!empty($request->products_options_id) and !empty($request->products_id) and !empty($request->products_options_values_id) and isset($request->options_values_price)){
              $checkRecord = DB::table('products_attributes')->where([
                  'options_id' => $request->products_options_id,
                  'options_values_id' => $request->products_options_values_id,
                  'products_id' => $request->products_id
              ])->get();
                if(count($checkRecord)>0){
                    $products_attributes = '';
                }else{
                    $language_id = 1;
                    $products_attributes_id = DB::table('products_attributes')->insertGetId([
                        'products_id' => $request->products_id,
                        'options_id' => $request->products_options_id,
                        'options_values_id' => $request->products_options_values_id,
                        'options_values_price' => $request->options_values_price,
                        'price_prefix' => $request->price_prefix,
                        'is_default' => $request->is_default
                    ]);
                    $products_attributes = DB::table('products_attributes')
                        ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                        ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
                        ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                        ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                        ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
                        ->where('products_options_descriptions.language_id', '=', $language_id)
                        ->where('products_options_values_descriptions.language_id', '=', $language_id)
                        ->where('products_attributes.products_id', '=', $request->products_id)
                        ->where('products_attributes.is_default', '=', '0')
                        ->orderBy('products_attributes_id', 'DESC')
                        ->get();
                }
            }else{
                $products_attributes = 'empty';
            }

            return $products_attributes;
  }

  public function editoptionform($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
          $languages = $myVarsetting->getLanguages();
          $products_id = $request->products_id;
          $products_attributes_id = $request->products_attributes_id;
          $language_id = $request->language_id;
          $options_id = $request->options_id;
          $languages = $myVarsetting->getLanguages();

          $products_id = $request->products_id;
          $products_attributes_id = $request->products_attributes_id;
          $language_id = 1;
          $options_id = $request->options_id;
          $options = DB::table('products_options')
              ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')
              ->where('products_options_descriptions.language_id', '=', $language_id)
              ->get();
          $result['options'] = $options;
          $options_value = DB::table('products_options_values')
              ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
              ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
              ->where('products_options_values_descriptions.language_id', '=', $language_id)
              ->where('products_options_values.products_options_id', '=', $options_id)
              ->get();
          $result['options_value'] = $options_value;
          $result['data'] = array('products_id'=>$request->products_id, 'products_attributes_id'=>$products_attributes_id, 'language_id'=>$language_id);
          $products_attributes = DB::table('products_attributes')
              ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
              ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
              ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
              ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
              ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
              ->where('products_options_descriptions.language_id', '=', $language_id)
              ->where('products_options_values_descriptions.language_id', '=', $language_id)
              ->where('products_attributes.products_attributes_id', '=', $products_attributes_id)
              ->get();
          $result['products_attributes'] = $products_attributes;
          $result['languages'] = $languages;
          return $result;
  }

  public function updateoption($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id = 1;
    $checkRecord = DB::table('products_attributes')->where([
        'options_id' => $request->products_options_id,
        'options_values_id' => $request->products_options_values_id,
        'products_id' => $request->products_id
    ])->get();
    DB::table('products_attributes')->where('products_attributes_id', '=', $request->products_attributes_id)->update([
        'options_id' => $request->products_options_id,
        'options_values_id' => $request->products_options_values_id,
        'options_values_price' => $request->options_values_price,
        'price_prefix' => $request->price_prefix,
    ]);
    $products_attributes = DB::table('products_attributes')
        ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
        ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
        ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
        ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
        ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
        ->where('products_options_descriptions.language_id', '=', $language_id)
        ->where('products_options_values_descriptions.language_id', '=', $language_id)
        ->where('products_attributes.products_id', '=', $request->products_id)
        ->where('products_attributes.is_default', '=', '0')
        ->orderBy('products_attributes_id', 'DESC')
        ->get();
        return $products_attributes;
  }

  public function deleteoption($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $language_id      =   '1';
    $checkRecord = DB::table('products_attributes')->where([
        'products_attributes_id' => $request->products_attributes_id,
        'products_id' => $request->products_id
    ])->delete();
    $products_attributes = DB::table('products_attributes')
        ->join('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
        ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')
        ->join('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
        ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
        ->select('products_attributes.*', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')
        ->where('products_options_descriptions.language_id', '=', $language_id)
        ->where('products_options_values_descriptions.language_id', '=', $language_id)
        ->where('products_attributes.products_id', '=', $request->products_id)
        ->where('products_attributes.is_default', '=', '0')
        ->orderBy('products_attributes_id', 'DESC')
        ->get();

        return $products_attributes;
  }

  public function getOptionsValue($request){
    $language_id = 1;
    $value = DB::table('products_options_values')
        ->leftjoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
        ->select('products_options_values_descriptions.*')
        ->where('products_options_values_descriptions.language_id', '=', $language_id)
        ->where('products_options_values.products_options_id', '=', $request->option_id)
        ->get();

    return $value;
  }

  public function currentstock($request){
    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $myVaralter = new AlertController($setting);
    $inventory_ref_id = array();
    $products_id = $request->products_id;
    $attributes = array_filter($request->attributeid);
    $attributeid = implode(',',$attributes);
    $postAttributes = count($attributes);

    // $inventory = DB::table('inventory')->where('products_id', $products_id)->where('stock_type', 'in')->get();
    $inventory = DB::table('inventory')->where('products_id', $products_id)->get();

    $reference_ids =array();
    $stockIn = 0;
    $purchasePrice = 0;
    $stockOut = 0;
    // dd($attributeid);
    foreach($inventory as $inventory){
        $totalAttribute = DB::table('inventory_detail')->where('inventory_detail.inventory_ref_id', '=', $inventory->inventory_ref_id)->get();
        $totalAttributes = count($totalAttribute);

        if($postAttributes>$totalAttributes){
            $count = $postAttributes;
        }elseif($postAttributes<$totalAttributes or $postAttributes==$totalAttributes){
            $count = $totalAttributes;
        }

        $individualStock = DB::table('inventory')->leftjoin('inventory_detail', 'inventory_detail.inventory_ref_id', '=', 'inventory.inventory_ref_id')
            ->selectRaw('inventory.*')
            ->whereIn('inventory_detail.attribute_id', [$attributeid])
            ->where(DB::raw('(select count(*) from `inventory_detail` where `inventory_detail`.`attribute_id` in (' . $attributeid . ') and `inventory_ref_id`= "' . $inventory->inventory_ref_id . '")'), '=', $count)
            ->where('inventory.inventory_ref_id', '=', $inventory->inventory_ref_id)
            ->get();

        if(count($individualStock) > 0 ){
            if($individualStock[0]->stock_type == 'in'){
                $inventory_ref_id[] = $individualStock[0]->inventory_ref_id;
                $stockIn += $individualStock[0]->stock;
                $purchasePrice += $individualStock[0]->purchase_price;
            }
            if($individualStock[0]->stock_type == 'out'){
                $stockOut += $individualStock[0]->stock;
            }

        }
    }

    $options_names  = array();
    $options_values = array();
    foreach($attributes as $attribute){
      $productsAttributes = DB::table('products_attributes')
          ->leftJoin('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
          ->leftJoin('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
          ->select('products_attributes.*', 'products_options.products_options_name as options_name', 'products_options_values.products_options_values_name as options_values')
          ->where('products_attributes_id', $attribute)->get();
        $options_names[] = $productsAttributes[0]->options_name;
        $options_values[] = $productsAttributes[0]->options_values;
    }

    $options_names_count = count($options_names);
    $options_names = implode ( "','", $options_names);
    $options_names = "'" . $options_names . "'";
    $options_values = "'" . implode ( "','", $options_values ) . "'";
    $orders_products = DB::table('orders_products')->where('products_id', $products_id)->get();
    
    
    foreach($orders_products as $orders_product){
        $totalAttribute = DB::table('orders_products_attributes')->where('orders_products_id', '=', $orders_product->orders_products_id)->get();
        $totalAttributes = count($totalAttribute);
        if($postAttributes>$totalAttributes){
            $count = $postAttributes;
        }elseif($postAttributes<$totalAttributes or $postAttributes==$totalAttributes){
            $count = $totalAttributes;
        }
        $products = DB::select("select orders_products.* from `orders_products` left join `orders_products_attributes` on `orders_products_attributes`.`orders_products_id` = `orders_products`.`orders_products_id` where `orders_products`.`products_id`='".$products_id."' and `orders_products_attributes`.`products_options` in (".$options_names.") and `orders_products_attributes`.`products_options_values` in (".$options_values.") and (select count(*) from `orders_products_attributes` where `orders_products_attributes`.`products_id` = '".$products_id."' and `orders_products_attributes`.`products_options` in (".$options_names.") and `orders_products_attributes`.`products_options_values` in (".$options_values.") and `orders_products_attributes`.`orders_products_id`= '".$orders_product->orders_products_id."') = ".$count." and `orders_products`.`orders_products_id` = '".$orders_product->orders_products_id."' group by `orders_products_attributes`.`orders_products_id`");
        if(count($products)>0){
            $stockOut += $products[0]->products_quantity;
        }
    }
    
    $result = array();
    $result['purchasePrice'] = $purchasePrice;
    $result['remainingStock'] = $stockIn - $stockOut;

    if(count($inventory_ref_id) > 0){
        $inventory_ref_id = $inventory_ref_id;

        
        $minMax = DB::table('manage_min_max')->whereIn('inventory_ref_id', $inventory_ref_id)->where('products_id', $products_id)->get();
       
        if(count($minMax) > 0){
            $lastMinMax[]= $minMax[count($minMax) - 1];
            $minMax = $lastMinMax;
        }
           
       
        $inventory_ref_id = $inventory_ref_id[count($inventory_ref_id)-1];
        
        
    }else{
        $minMax = '';
    }
    // return $minMax;
    $result['inventory_ref_id'] = $inventory_ref_id;
    $result['products_id'] = $products_id;
    $result['minMax'] = $minMax;
    return $result;
  }




}
