<?php

namespace App\Models\Core;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Core\NewsCategory;
use App\Models\Core\Categories;
use DB;
use Illuminate\Database\Eloquent\Model;
use Lang;

class Menus extends Model
{

    public static function menus()
    {
        return Menus::recursiveMenu();
    }

    public static function recursiveMenu()
    {
        $items = DB::table('menus')
            ->leftJoin('menu_translation', 'menus.id', '=', 'menu_translation.menu_id')
            ->select('menus.*', 'menu_translation.menu_name as name', 'menus.parent_id')
            ->where('menu_translation.language_id', '=', 1)
            ->orderBy('menus.sort_order', 'ASC')
            ->get();
        $ul = '';
        if ($items->isNotEmpty()) {
            $childs = array();
            foreach ($items as $item) {
                $childs[$item->parent_id][] = $item;
            }

            foreach ($items as $item) {
                if (isset($childs[$item->id])) {
                    $item->childs = $childs[$item->id];
                }
            }

            if (!empty($childs[0])) {
                $menus = $childs[0];
            } else {
                $menus = $childs;
            }

            $parent_id = 0;
            $ul = '<ul id="easymm" class="ui-sortable">';
            foreach ($menus as $parents) {

                if ($parents->status == 0) {
                    $status = '<span class="label label-warning">' . Lang::get("labels.InActive") . '</span>';
                } else {
                    $status = '<span class="label label-success">' . Lang::get("labels.Active") . '</span>';
                }

                $ul .= '<li id="menu-' . $parents->id . '" class="sortable">
                <div class="ns-row">
                <div class="ns-title">' . $parents->name . '</div>
                <div class="ns-url">' . $parents->link . '</div>
                <div class="ns-class">' . $status . '</div>
                <div class="ns-actions">
                <a href="editmenu/' . $parents->id . '" class="badge bg-light-blue edit-menu">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <button id="deleteProductId" products_id="' . $parents->id . '" class="badge bg-red delete-menu">
                <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <input type="hidden" name="menu_id" value="' . $parents->id . '">
                </div>
                </div>';

                if (isset($parents->childs)) {
                    $ul .= '<ul>';
                    $ul .= Menus::childcat($parents->childs, $parent_id);
                    $ul .= '</ul>';
                } else {
                    $ul .= '</li>';
                }
            }
            $ul .= '</ul>';

        }
        return $ul;
    }

    public static function childcat($childs, $parent_id)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            if ($child->status == 0) {
                $status = '<span class="label label-warning">' . Lang::get("labels.InActive") . '</span>';
            } else {
                $status = '<span class="label label-success">' . Lang::get("labels.Active") . '</span>';
            }
            $contents .= '
            <li id="menu-' . $child->id . '" class="sortable">
            <div class="ns-row">
            <div class="ns-title">' . $child->name . '</div>
            <div class="ns-url">' . $child->link . '</div>
            <div class="ns-class">' . $status . '</div>
            <div class="ns-actions">
            <a href="editmenu/' . $child->id . '" class="badge bg-light-blue edit-menu">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </a>
            <button id="deleteProductId" products_id="' . $child->id . '" class="badge bg-red delete-menu">
            <i class="fa fa-trash" aria-hidden="true" ></i>
            </button>
            <input type="hidden" name="menu_id" value="' . $child->id . '">
            </div>
            </div>
            ';
            if (isset($child->childs)) {
                $contents .= '
                <ul>';
                $contents .= Menus::childcat($child->childs, $parent_id);
                $contents .= '</li></ul>';
            } else {
                $contents .= '</li>';
            }

        }
        return $contents;
    }

    public static function addmenus()
    {
        $language_id = '1';

        $result = array();

        //get function from other controller
        $myVar = new NewsCategory();
        $result['newsCategories'] = $myVar->getter($language_id);

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['languages'] = $myVar->getLanguages();

        $menus = DB::table('menus')
            ->leftJoin('menu_translation', 'menu_translation.menu_id', '=', 'menus.id')
            ->where([
                ['menu_translation.language_id', '=', $language_id],
                ['menus.parent_id', '=', 0],
            ])
            ->select('menus.*', 'menu_translation.menu_name as name')
            ->orderBy('menus.sort_order', 'ASC')
            ->get();

        $result["menus"] = $menus;

        $pages = DB::table('pages')
            ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
            ->where([
                ['pages_description.language_id', '=', $language_id],
                ['pages.type', '=', 2],
            ])
            ->orderBy('pages.page_id', 'ASC')
            ->get();

        $result["pages"] = $pages;
        return $result;
    }

    

    public static function addnewmenu($request)
    {
        $order = DB::table('menus')->max('sort_order');
        $order = $order + 1;

        $page_id = '';
        if ($request->type == 2) {
            $page_id = $request->page_id;
        }

        $link = '';
        if ($request->type == 0) {
            $link = $request->external_link;
        } elseif ($request->type == 1) {
            $link = $request->link;
        } elseif ($request->type == 2) {
            $link = $request->page_id;
        } elseif ($request->type == 3) {
            $link = $request->category_slug;
        } elseif ($request->type == 4) {
            $link = $request->product_slug;
        }elseif ($request->type == 5) {
            $link = $request->pages2;
        }

        $menu_id = DB::table('menus')->insertGetId([
            'parent_id' => $request->parent_id,
            'type' => $request->type,
            'status' => $request->status,
            'external_link' => $request->external_link,
            'link' => $link,
            'sort_order' => $order,
            'page_id' => $request->page_id,
        ]);

        $myVar = new SiteSettingController();
        $languages = $myVar->getLanguages();
        foreach ($languages as $languages_data) {
            $menu_name = 'menuName_' . $languages_data->languages_id;
            $menu_name = $request->$menu_name;
            DB::table('menu_translation')->insert([
                'menu_id' => $menu_id,
                'language_id' => $languages_data->languages_id,
                'menu_name' => $menu_name,
            ]);
        }

    }

    public static function editmenu($id)
    {
        $language_id = '1';
        $menu_id = $id;

        $result = array();

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['languages'] = $myVar->getLanguages();

        $menus = DB::table('menus')
            ->leftJoin('menu_translation', 'menu_translation.menu_id', '=', 'menus.id')
            ->where([
                ['menu_translation.language_id', '=', $language_id],
                ['menus.id', '=', $menu_id],
            ])
            ->select('menus.*', 'menu_translation.menu_name as name')
            ->orderBy('menus.id', 'ASC')
            ->get();

        $result["menus"] = $menus;

        $allmenus = DB::table('menus')
            ->leftJoin('menu_translation', 'menu_translation.menu_id', '=', 'menus.id')
            ->where([
                ['menu_translation.language_id', '=', $language_id],
            ])
            ->select('menus.*', 'menu_translation.menu_name as name')
            ->orderBy('menus.id', 'ASC')
            ->get();
        $result["allmenus"] = $allmenus;

        $pages = DB::table('pages')
            ->leftJoin('pages_description', 'pages_description.page_id', '=', 'pages.page_id')
            ->where([
                ['pages_description.language_id', '=', $language_id],
                ['pages.type', '=', 2],
            ])
            ->orderBy('pages.page_id', 'ASC')
            ->get();

        $result["pages"] = $pages;

        $description_data = array();
        foreach ($result['languages'] as $languages_data) {

            $description = DB::table('menu_translation')->where([
                ['language_id', '=', $languages_data->languages_id],
                ['menu_id', '=', $menu_id],
            ])->get();

            if (count($description) > 0) {
                $description_data[$languages_data->languages_id]['name'] = $description[0]->menu_name;
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['name'] = '';
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }
        $result["description"] = $description_data;

        return $result;
    }

    public static function updatemenu($request)
    {

        $menu_id = $request->id;

        $page_id = '';
        if ($request->type == 2) {
            $page_id = $request->page_id;
        }

        $link = '';
        if ($request->type == 0) {
            $link = $request->external_link;
        } elseif ($request->type == 1) {
            $link = $request->link;
        } elseif ($request->type == 2) {
            $link = $request->page_id;
        } elseif ($request->type == 3) {
            $link = $request->category_slug;
        } elseif ($request->type == 4) {
            $link = $request->product_slug;
        }elseif ($request->type == 5) {
            $link = $request->pages2;
        }

        DB::table('menus')
            ->where('id', $menu_id)
            ->update([
                'type' => $request->type,
                'status' => $request->status,
                'external_link' => $request->external_link,
                'link' => $link,
                'page_id' => $request->page_id,

            ]);

        $myVar = new SiteSettingController();
        $languages = $myVar->getLanguages();
        foreach ($languages as $languages_data) {
            $menu_name = 'menuName_' . $languages_data->languages_id;

            $checkExist = DB::table('menu_translation')->where('menu_id', $menu_id)->where('language_id', $languages_data->languages_id)->first();
            $menu_namee = $request->$menu_name;
            if ($checkExist) {
                DB::table('menu_translation')
                    ->where('menu_id', $menu_id)
                    ->where('language_id', $languages_data->languages_id)
                    ->update([
                        'menu_name' => $menu_namee,
                    ]);
            } else {
                DB::table('menu_translation')->insert([
                    'menu_id' => $menu_id,
                    'language_id' => $languages_data->languages_id,
                    'menu_name' => $menu_namee,
                ]);
            }
        }

    }

    public static function deletemenu($id)
    {
        DB::table('menus')->where('id', $id)->delete();
        DB::table('menu_translation')->where('menu_id', $id)->delete();

        $order = DB::table('menus')->max('sort_order');
        $order = $order + 1;

        DB::table('menus')->where('parent_id', '=', $id)->update([
            'parent_id' => 0,
            'sort_order' => $order,
        ]);
    }

    public static function savePosition($request)
    {
        $sort_order = 1;
        foreach ($request->menu as $key => $value) {
            $menu_id = $key;
            if ($value == null) {
                $parent_id = 0;
            } else {
                $parent_id = $value;
            }

            if ($parent_id > 0) {
                $sort_order2 = 0;
            }

            DB::table('menus')->where('id', '=', $menu_id)->update([
                'parent_id' => $parent_id,
                'sort_order' => $sort_order,
            ]);

            $sort_order++;

        }
    }

    public static function catalogmenu(){
        $language = new SiteSettingController();
        $languages = $language->getLanguages();
        $items = DB::table('categories')
            ->leftJoin('image_categories', 'categories.categories_icon', '=', 'image_categories.image_id')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories.categories_id', 'image_categories.path as image_path', 'categories.categories_slug as slug', 'categories_description.categories_name', 'categories.parent_id')
            ->where('categories_description.language_id', '=', 1)
            ->groupBy('categories.categories_id')
            ->get();
        $contents = '';
        
        if ($items->isNotEmpty()) {
            $childs = array();
            foreach ($items as $item) {
                $childs[$item->parent_id][] = $item;
            }

            foreach ($items as $item) {
                if (isset($childs[$item->categories_id])) {
                    $item->childs = $childs[$item->categories_id];
                }
            }

            $categories = $childs[0];
            
                // insert menu named as catalog                
                $order = DB::table('menus')->max('sort_order');
                $order = $order + 1;
                
                $parent_menu_id = DB::table('menus')->insertGetId([
                    'parent_id' => 0,
                    'type' => '3',
                    'status' => 1,
                    'external_link' => '',
                    'link' => '#',
                    'sort_order' => $order,
                    'page_id' => '',
                ]);
        
                
                
                foreach ($languages as $languages_data) {
                    DB::table('menu_translation')->insert([
                        'menu_id' => $parent_menu_id,
                        'language_id' => $languages_data->languages_id,
                        'menu_name' => 'Catalog',
                    ]);
                }
            
    
                foreach ($categories as $parents) {
                    //insert parent record
                            
                    $order = DB::table('menus')->max('sort_order');
                    $order = $order + 1;

                    $menu_id = DB::table('menus')->insertGetId([
                        'parent_id' => $parent_menu_id,
                        'type' => '3',
                        'status' => 1,
                        'external_link' => '',
                        'link' => $parents->slug,
                        'sort_order' => $order,
                        'page_id' => '',
                    ]);

                    foreach ($languages as $languages_data) {

                        //get detail of categories
                        $description = DB::table('categories_description')
                            ->where('categories_description.language_id','=', $languages_data->languages_id )
                            ->where('categories_id','=', $parents->categories_id )
                            ->first();

                        if($description){
                            DB::table('menu_translation')->insert([
                                'menu_id' => $menu_id,
                                'language_id' => $languages_data->languages_id,
                                'menu_name' => $description->categories_name,
                            ]);   
                        }
                                                        
                    }

                        


    
                    if (isset($parents->childs)) {
                         Menus::childInsert($parents->childs, $menu_id);
                    }
    
                }
    
                return '';
            
        }
        return $contents;
    }


    public static function childInsert($childs, $parent_id)
    {
        $language = new SiteSettingController();
        $languages = $language->getLanguages();
        $contents = '';
        foreach ($childs as $key => $child) {


                //dd($child);
            $order = DB::table('menus')->max('sort_order');
            $order = $order + 1;

            $menu_id = DB::table('menus')->insertGetId([
                'parent_id' => $parent_id,
                'type' => '3',
                'status' => 1,
                'external_link' => '',
                'link' => $child->slug,
                'sort_order' => $order,
                'page_id' => '',
            ]);

            foreach ($languages as $languages_data) {

                //get detail of categories
                $description = DB::table('categories_description')
                    ->where('categories_description.language_id','=', $languages_data->languages_id )
                    ->where('categories_id','=', $child->categories_id )
                    ->first();

                if($description){
                    DB::table('menu_translation')->insert([
                        'menu_id' => $menu_id,
                        'language_id' => $languages_data->languages_id,
                        'menu_name' => $description->categories_name,
                    ]);   
                }
                                                
            }

                      


            if (isset($child->childs)) {
                $contents .= Menus::childInsert($child->childs, $menu_id);
            } 

        }
        return $contents;
    }


    

    public static function catalogmenuold()
    {
        $language_id = 1;
        $language = new SiteSettingController();
        $languages = $language->getLanguages();
        $myVar = new Categories();
        $categories = $myVar->getter($language_id);
        if(!empty($categories)  and count($categories)>0){
            //check catalog exist
            $menus = DB::table('menus')
                        ->leftJoin('menu_translation', 'menu_translation.menu_id', '=', 'menus.id')
                        ->where([
                            ['menu_translation.language_id', '=', 1],
                            ['menus.type', '=', 3],
                            ['menu_translation.menu_name', '=', 'Catalog']
                        ])
                        ->first();

            if($menus){
                $parent_menu_id = $menus->id;
            }else{
            
                // insert menu named as catalog
                
                $order = DB::table('menus')->max('sort_order');
                $order = $order + 1;
                
                $parent_menu_id = DB::table('menus')->insertGetId([
                    'parent_id' => 0,
                    'type' => '3',
                    'status' => 1,
                    'external_link' => '',
                    'link' => '#',
                    'sort_order' => $order,
                    'page_id' => '',
                ]);
        
                
                
                foreach ($languages as $languages_data) {
                    DB::table('menu_translation')->insert([
                        'menu_id' => $parent_menu_id,
                        'language_id' => $languages_data->languages_id,
                        'menu_name' => 'Catalog',
                    ]);
                }
            }

            foreach ($languages as $languages_data) {
                foreach($categories as $category){

                    //check exist 
                    $menus = DB::table('menus')
                        ->where([
                            ['menus.type', '=', 3],
                            ['menus.link', '=', $category->slug],
                        ])
                        ->first();

                        if(!$menus){

                            if($category->parent_id == 0){
                                $parent_id =  $parent_menu_id;
                            }else{
                                $parent_id =  $menu_id;
                            }

                            $order = DB::table('menus')->max('sort_order');
                            $order = $order + 1;

                            $menu_id = DB::table('menus')->insertGetId([
                                'parent_id' => $menu_id,
                                'type' => '3',
                                'status' => 1,
                                'external_link' => '',
                                'link' => $category->slug,
                                'sort_order' => $order,
                                'page_id' => '',
                            ]);

                            foreach ($languages as $languages_data) {

                                //get detail of categories
                                $description = DB::table('categories_description')
                                    ->where('categories_description.language_id','=', $languages_data->languages_id )
                                    ->where('categories_id','=', $category->id )
                                    ->first();

                                if($description){
                                    DB::table('menu_translation')->insert([
                                        'menu_id' => $menu_id,
                                        'language_id' => $languages_data->languages_id,
                                        'menu_name' => $description->categories_name,
                                    ]);   
                                }
                                                             
                            }

                        }

                }
            }
        }
    }

}
