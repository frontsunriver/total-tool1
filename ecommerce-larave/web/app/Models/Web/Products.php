<?php

namespace App\Models\Web;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Session;

class Products extends Model
{

    public function likedProducts()
    {

        $products = DB::table('liked_products')->where('liked_customers_id', '=', session('customers_id'))->get();
        $result = array();
        $index = 0;
        foreach ($products as $products_data) {
            $result[$index++] = $products_data->liked_products_id;
        }
        return ($result);

    }

    public function productCategories()
    {
        $categories = $this->recursivecategories();
        if ($categories) {
            $parent_id = 0;
            $option = '<option value="0">' . Lang::get("website.Choose Any Category") . '</option>';

            foreach ($categories as $parents) {
                if ($parents->slug == app('request')->input('category')) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }

                $option .= '<option value="' . $parents->slug . '">' . $parents->categories_name . '</option>';

                if (isset($parents->childs)) {
                    $i = 1;
                    $option .= $this->childcat($parents->childs, $i, $parent_id);
                }

            }

            return $option;
        }
    }

    private function childcat($childs, $i, $parent_id)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            $dash = '';
            for ($j = 1; $j <= $i; $j++) {
                $dash .= '-';
            }
            if ($child->categories_id == $parent_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            $contents .= '<option value="' . $child->slug . '" ' . $selected . '>' . $dash . $child->categories_name . '</option>';
            if (isset($child->childs)) {

                $k = $i + 1;
                $contents .= $this->childcat($child->childs, $k, $parent_id);
            } elseif ($i > 0) {
                $i = 1;
            }

        }
        return $contents;
    }

    public function categories()
    {
        $items = DB::table('categories')
            ->leftJoin('image_categories', 'categories.categories_icon', '=', 'image_categories.image_id')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories.categories_id', 'image_categories.path as image_path', 'categories.categories_slug as slug', 'categories_description.categories_name', 'categories.parent_id')
            ->where('categories_description.language_id', '=', Session::get('language_id'))
            ->where('categories.categories_status', 1)
            ->groupBy('categories.categories_id')
            ->get();
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

            $tree = $childs[0];
            return $tree;
        }
    }

    private function recursivecategories()
    {
        $items = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories.categories_id', 'categories.categories_slug as slug', 'categories_description.categories_name', 'categories.parent_id')
            ->where('categories_description.language_id', '=', Session::get('language_id'))
            ->where('categories.categories_status', 1)
            ->get();
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

            $tree = $childs[0];
            return $tree;
        }
    }

///////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    
    public function productCategories1()
    {
        $categories = $this->recursivecategories1();
        if ($categories) {
            $parent_id = 0;
            $ul = '<ul class="navbar-nav flex-column mt-md-0 mt-4 pt-md-0 pt-4">';
            $div = 0;
            foreach ($categories as $parents) {
                if (isset($parents->childs)) {
                    $dropright = 'dropright';
                    $right_arrow = '<i class="fas fa-chevron-right"></i>';
                } else {
                    $dropright = '';
                    $right_arrow = '';
                }
                if(strlen ($parents->categories_name)>18){
                    $dots = '...';
                }else{
                    $dots = '';
                }
                $cat = 'shop?category=' . $parents->categories_slug;
                $ul .= '<li class="nav-item dropdown ' . $dropright . '"><a class="nav-link dropdown-item" href="' . $cat . '" >
                <img class="img-fuild" src="' . $parents->icon . '">
                ' . substr($parents->categories_name, 0, 18) .$dots . '
                </a>
                '
                .$right_arrow;

                if (isset($parents->childs)) {
                    $i = 1;
                    $ul .= '<div class="dropdown-menu pull-right" > <div class="dropdown-submenu submenu1">';
                    $ul .= $this->childcat1($parents->childs, $i, $parent_id, $div);
                    $ul .= '</div></div>';
                    $ul .= '</li>';
                } else {
                    $ul .= '</li>';
                }

            }
            $ul .= '</ul>';
            return $ul;

        }
    }

    private function childcat1($childs, $i, $parent_id, $div)
    {
        $contents = '';
        foreach ($childs as $key => $child) {
            $dash = '';
            for ($j = 1; $j <= $i; $j++) {
                $dash .= '';
            }
            $cat = 'shop?category=' . $child->categories_slug;

            $contents .= '
                <a class="dropdown-item" href="' . $cat . '">
                    <img class="img-fuild" src="' . $dash . $child->icon . '">
                    ' . $dash . $child->categories_name . '
                </a>
            ';
            if (isset($child->childs)) {
                $contents .= '
                <i class="fas fa-chevron-right"></i>
                <div class="dropdown-menu pull-right">';
                $contents .= '
                <div class="dropdown-submenu submenu1">';
                
                $k = $i + 1;
                $contents .= $this->childcat1($child->childs, $k, $parent_id, 1);
                $cat = 'shop?category=' . $child->categories_slug;
                $contents .= '</div></div>';
            } elseif ($i > 0) {
            }

        }
        return $contents;
    }
    

    private function recursivecategories1()
    {
        $items = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->leftJoin('image_categories', 'categories.categories_icon', '=', 'image_categories.image_id')
            ->select('image_categories.path as icon', 'categories.categories_id', 'categories_description.categories_name', 'categories.categories_slug', 'categories.parent_id')
            ->where('categories_description.language_id', '=', Session::get('language_id'))
            ->where('categories.categories_status', 1)
            ->groupBy('categories.categories_id')
            ->get();
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

            $tree = $childs[0];
            return $tree;
        }
    }

    //products
    public function products($data)
    {

        if (empty($data['page_number']) or $data['page_number'] == 0) {
            $skip = $data['page_number'] . '0';
        } else {
            $skip = $data['limit'] * $data['page_number'];
        }

        $min_price = $data['min_price'];
        $max_price = $data['max_price'];
        $take = $data['limit'];
        $currentDate = time();
        $type = $data['type'];

        if ($type == "atoz") {
            $sortby = "products_name";
            $order = "ASC";
        } elseif ($type == "ztoa") {
            $sortby = "products_name";
            $order = "DESC";
        } elseif ($type == "hightolow") {
            $sortby = "products_price";
            $order = "DESC";
        } elseif ($type == "lowtohigh") {
            $sortby = "products_price";
            $order = "ASC";
        } elseif ($type == "topseller") {
            $sortby = "products_ordered";
            $order = "DESC";
        } elseif ($type == "mostliked") {
            $sortby = "products_liked";
            $order = "DESC";

        } elseif ($type == "special") {
            $sortby = "specials.products_id";
            $order = "desc";
        } elseif ($type == "flashsale") { //flashsale products
            $sortby = "flash_sale.flash_start_date";
            $order = "asc";
        } else {
            $sortby = "products.products_id";
            $order = "desc";
        }

        $filterProducts = array();
        $eliminateRecord = array();

        $categories = DB::table('products')
            ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
            ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->LeftJoin('image_categories', 'products.products_image', '=', 'image_categories.image_id');

        if (!empty($data['categories_id'])) {
            $categories->LeftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')
                ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id')
                ->LeftJoin('categories_description', 'categories_description.categories_id', '=', 'products_to_categories.categories_id');
        }

        if (!empty($data['filters']) and empty($data['search'])) {
            $categories->leftJoin('products_attributes', 'products_attributes.products_id', '=', 'products.products_id');
        }

        if (!empty($data['search'])) {
            $categories->leftJoin('products_attributes', 'products_attributes.products_id', '=', 'products.products_id')
                ->leftJoin('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                ->leftJoin('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id');
        }
        //wishlist customer id
        if ($type == "wishlist") {
            $categories->LeftJoin('liked_products', 'liked_products.liked_products_id', '=', 'products.products_id')
                ->select('products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url');
                $categories->LeftJoin('specials', function ($join) use ($currentDate) {
                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
                })->select('products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price');
        }
        //parameter special
        elseif ($type == "special") {
            $categories->LeftJoin('specials', 'specials.products_id', '=', 'products.products_id')
                ->select('products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price', 'specials.specials_new_products_price as discount_price');
        } elseif ($type == "flashsale") {
            //flash sale
            $categories->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
                ->select(DB::raw(time() . ' as server_time'), 'products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'flash_sale.flash_start_date', 'flash_sale.flash_expires_date', 'flash_sale.flash_sale_products_price as flash_price');

        } elseif ($type == "compare") {
            //flash sale
            $categories->LeftJoin('flash_sale', 'flash_sale.products_id', '=', 'products.products_id')
                ->select(DB::raw(time() . ' as server_time'), 'products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'flash_sale.flash_start_date', 'flash_sale.flash_expires_date', 'flash_sale.flash_sale_products_price as discount_price');
                $categories->LeftJoin('specials', function ($join) use ($currentDate) {
                    $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
                })->select('products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price');

        } else {
            $categories->LeftJoin('specials', function ($join) use ($currentDate) {
                $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
            })->select('products.*', 'image_categories.path as image_path', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price');
        }

        if ($type == "special") { //deals special products
            $categories->where('specials.status', '=', '1')->where('expires_date', '>', $currentDate);
        }

        if ($type == "flashsale") { //flashsale
            $categories->where('flash_sale.flash_status', '=', '1')->where('flash_expires_date', '>', $currentDate);

        } elseif ($type != "flashsale" && $type != "compare"){
            $nonflashsale = DB::table('flash_sale')->where('flash_sale.flash_status', '=', '1')->where('flash_expires_date', '>', $currentDate)->pluck('products_id');
            if(count($nonflashsale) > 0)
                $categories->whereNotIn('products.products_id', $nonflashsale);
        }
        // elseif ($type != "compare") {
        //     $categories->whereNotIn('products.products_id', function ($query) use ($currentDate) {
        //         $query->select('flash_sale.products_id')->from('flash_sale')->where('flash_sale.flash_status', '=', '1');
        //     });

        // }

        //get single products
        if (!empty($data['products_id']) && $data['products_id'] != "") {
            $categories->where('products.products_id', '=', $data['products_id']);
        }

        //for min and maximum price
        if (!empty($max_price)) {

            if (!empty($max_price)) {
                //check session contain default currency
                $current_currency = DB::table('currencies')->where('id', session('currency_id'))->first();
                if($current_currency->is_default == 0){
                    $max_price = $max_price / session('currency_value');
                    $min_price = $min_price / session('currency_value');
                }
    
            }

            $categories->whereBetween('products.products_price', [$min_price, $max_price]);
        }

        if (!empty($data['search'])) {

            $searchValue = $data['search'];
            
            $categories->where('products_options.products_options_name', 'LIKE', '%' . $searchValue . '%')->where('products_status', '=', 1);

            if (!empty($data['categories_id'])) {
                $categories->where('products_to_categories.categories_id', '=', $data['categories_id']);
            }

            if (!empty($data['filters'])) {
                $temp_key = 0;
                foreach ($data['filters']['filter_attribute']['option_values'] as $option_id_temp) {

                    if ($temp_key == 0) {

                        $categories->whereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);
                        if (count($data['filters']['filter_attribute']['options']) > 1) {

                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    } else {
                        $categories->orwhereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);

                        if (count($data['filters']['filter_attribute']['options']) > 1) {
                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    }
                    $temp_key++;
                }

            }

            if (!empty($max_price)) {
                $categories->whereBetween('products.products_price', [$min_price, $max_price]);
            }
            $categories->whereNotIn('products.products_id', function ($query) use ($currentDate) {
                $query->select('flash_sale.products_id')->from('flash_sale')->where('flash_sale.flash_status', '=', '1');
            });
            $categories->orWhere('products_options_values.products_options_values_name', 'LIKE', '%' . $searchValue . '%')->where('products_status', '=', 1);
            if (!empty($data['categories_id'])) {
                $categories->where('products_to_categories.categories_id', '=', $data['categories_id']);
            }

            if (!empty($data['filters'])) {
                $temp_key = 0;
                foreach ($data['filters']['filter_attribute']['option_values'] as $option_id_temp) {

                    if ($temp_key == 0) {

                        $categories->whereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);
                        if (count($data['filters']['filter_attribute']['options']) > 1) {

                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    } else {
                        $categories->orwhereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);

                        if (count($data['filters']['filter_attribute']['options']) > 1) {
                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    }
                    $temp_key++;
                }

            }

            if (!empty($max_price)) {
                $categories->whereBetween('products.products_price', [$min_price, $max_price]);
            }

            $categories->whereNotIn('products.products_id', function ($query) use ($currentDate) {
                $query->select('flash_sale.products_id')->from('flash_sale')->where('flash_sale.flash_status', '=', '1');
            });

            $categories->orWhere('products_name', 'LIKE', '%' . $searchValue . '%')->where('products_status', '=', 1);

            if (!empty($data['categories_id'])) {
                $categories->where('products_to_categories.categories_id', '=', $data['categories_id']);
            }

            if (!empty($data['filters'])) {
                $temp_key = 0;
                foreach ($data['filters']['filter_attribute']['option_values'] as $option_id_temp) {

                    if ($temp_key == 0) {

                        $categories->whereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);
                        if (count($data['filters']['filter_attribute']['options']) > 1) {

                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    } else {
                        $categories->orwhereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);

                        if (count($data['filters']['filter_attribute']['options']) > 1) {
                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    }
                    $temp_key++;
                }

            }

            if (!empty($max_price)) {
                $categories->whereBetween('products.products_price', [$min_price, $max_price]);
            }

            $categories->whereNotIn('products.products_id', function ($query) use ($currentDate) {
                $query->select('flash_sale.products_id')->from('flash_sale')->where('flash_sale.flash_status', '=', '1');
            });

            $categories->orWhere('products_model', 'LIKE', '%' . $searchValue . '%')->where('products_status', '=', 1);

            if (!empty($data['categories_id'])) {
                $categories->where('products_to_categories.categories_id', '=', $data['categories_id']);
            }

            if (!empty($data['filters'])) {
                $temp_key = 0;
                foreach ($data['filters']['filter_attribute']['option_values'] as $option_id_temp) {

                    if ($temp_key == 0) {

                        $categories->whereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);
                        if (count($data['filters']['filter_attribute']['options']) > 1) {

                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    } else {
                        $categories->orwhereIn('products_attributes.options_id', [$data['filters']['options']])
                            ->where('products_attributes.options_values_id', $option_id_temp);

                        if (count($data['filters']['filter_attribute']['options']) > 1) {
                            $categories->where(DB::raw('(select count(*) from `products_attributes` where `products_attributes`.`products_id` = `products`.`products_id` and `products_attributes`.`options_id` in (' . $data['filters']['options'] . ') and `products_attributes`.`options_values_id` in (' . $data['filters']['option_value'] . '))'), '>=', $data['filters']['options_count']);
                        }

                    }
                    $temp_key++;
                }

            }
            $categories->whereNotIn('products.products_id', function ($query) use ($currentDate) {
                $query->select('flash_sale.products_id')->from('flash_sale')->where('flash_sale.flash_status', '=', '1');
            });
        }

        if (!empty($data['filters'])) {
            $temp_key = 0;
            
            $categories->whereIn('products_attributes.options_id', [$data['filters']['options']])
                ->whereIn('products_attributes.options_values_id',[$data['filters']['option_value']]);
        }

        //wishlist customer id
        if ($type == "wishlist") {
            $categories->where('liked_customers_id', '=', session('customers_id'));
        }

        //wishlist customer id
        if ($type == "is_feature") {
            $categories->where('products.is_feature', '=', 1);
        }
        if(!empty($data['brand'])){
            $brand = $data['brand'];
            $brand = DB::table('manufacturers')->where('manufacturer_name',$brand)->first();
            if($brand)
                $categories->where('products.manufacturers_id', '=', $brand->manufacturers_id);
        }
        $categories->where('products_description.language_id', '=', Session::get('language_id'))->where('products_status', '=', 1);

        //get single category products
        if (!empty($data['categories_id'])) {
            $categories->where('products_to_categories.categories_id', '=', $data['categories_id']);
            $categories->where('categories.categories_status', '=', 1);
            $categories->where('categories_description.language_id', '=', Session::get('language_id'));
        }else{
            $categories->LeftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id');
                // ->leftJoin('categories', 'categories.categories_id', '=', 'products_to_categories.categories_id');
            $categories->whereIn('products_to_categories.categories_id', function ($query) use ($currentDate) {
                $query->select('categories_id')->from('categories')->where('categories.categories_status',1);
            });
        }

        if ($type == "topseller") {
            $categories->where('products.products_ordered', '>', 0);
        }
        if ($type == "mostliked") {
            $categories->where('products.products_liked', '>', 0);
        }

        $categories->orderBy($sortby, $order)->groupBy('products.products_id');

        //count
        $total_record = $categories->get();
        $products = $categories->skip($skip)->take($take)->get();

        $result = array();
        $result2 = array();

        //check if record exist
        if (count($products) > 0) {

            $index = 0;
            foreach ($products as $products_data) {

                $reviews = DB::table('reviews')
                    ->leftjoin('users', 'users.id', '=', 'reviews.customers_id')
                    ->leftjoin('reviews_description', 'reviews.reviews_id', '=', 'reviews_description.review_id')
                    ->select('reviews.*', 'reviews_description.reviews_text')
                    ->where('products_id', $products_data->products_id)
                    ->where('reviews_status', '1')
                    ->where('reviews_read', '1')
                    ->get();

                $avarage_rate = 0;
                $total_user_rated = 0;

                if (count($reviews) > 0) {
                    $five_star = 0;
                    $five_count = 0;

                    $four_star = 0;
                    $four_count = 0;

                    $three_star = 0;
                    $three_count = 0;

                    $two_star = 0;
                    $two_count = 0;

                    $one_star = 0;
                    $one_count = 0;

                    foreach ($reviews as $review) {

                        //five star ratting
                        if ($review->reviews_rating == '5') {
                            $five_star += $review->reviews_rating;
                            $five_count++;
                        }

                        //four star ratting
                        if ($review->reviews_rating == '4') {
                            $four_star += $review->reviews_rating;
                            $four_count++;
                        }
                        //three star ratting
                        if ($review->reviews_rating == '3') {
                            $three_star += $review->reviews_rating;
                            $three_count++;
                        }
                        //two star ratting
                        if ($review->reviews_rating == '2') {
                            $two_star += $review->reviews_rating;
                            $two_count++;
                        }

                        //one star ratting
                        if ($review->reviews_rating == '1') {
                            $one_star += $review->reviews_rating;
                            $one_count++;
                        }
                    }

                    $five_ratio = round($five_count / count($reviews) * 100);
                    $four_ratio = round($four_count / count($reviews) * 100);
                    $three_ratio = round($three_count / count($reviews) * 100);
                    $two_ratio = round($two_count / count($reviews) * 100);
                    $one_ratio = round($one_count / count($reviews) * 100);
                    if(($five_star + $four_star + $three_star + $two_star + $one_star) > 0){
                        $avarage_rate = (5 * $five_star + 4 * $four_star + 3 * $three_star + 2 * $two_star + 1 * $one_star) / ($five_star + $four_star + $three_star + $two_star + $one_star);
                    }else{
                        $avarage_rate = 0;
                    }
                    $total_user_rated = count($reviews);
                    $reviewed_customers = $reviews;
                } else {
                    $reviewed_customers = array();
                    $avarage_rate = 0;
                    $total_user_rated = 0;

                    $five_ratio = 0;
                    $four_ratio = 0;
                    $three_ratio = 0;
                    $two_ratio = 0;
                    $one_ratio = 0;
                }

                $products_data->rating = number_format($avarage_rate, 2);
                $products_data->total_user_rated = $total_user_rated;

                $products_data->five_ratio = $five_ratio;
                $products_data->four_ratio = $four_ratio;
                $products_data->three_ratio = $three_ratio;
                $products_data->two_ratio = $two_ratio;
                $products_data->one_ratio = $one_ratio;

                //review by users
                $products_data->reviewed_customers = $reviewed_customers;
                $products_id = $products_data->products_id;

                //products_image
                $default_images = DB::table('image_categories')
                    ->where('image_id', '=', $products_data->products_image)
                    ->where('image_type', 'MEDIUM')
                    ->first();

                if ($default_images) {
                    $products_data->image_path = $default_images->path;
                } else {
                    $default_images = DB::table('image_categories')
                        ->where('image_id', '=', $products_data->products_image)
                        ->where('image_type', 'LARGE')
                        ->first();

                    if ($default_images) {
                        $products_data->image_path = $default_images->path;
                    } else {
                        $default_images = DB::table('image_categories')
                            ->where('image_id', '=', $products_data->products_image)
                            ->where('image_type', 'ACTUAL')
                            ->first();
                        $products_data->image_path = $default_images->path;
                    }

                }

                $default_images = DB::table('image_categories')
                    ->where('image_id', '=', $products_data->products_image)
                    ->where('image_type', 'LARGE')
                    ->first();
                if ($default_images) {
                    $products_data->default_images = $default_images->path;
                } else {
                    $default_images = DB::table('image_categories')
                        ->where('image_type', 'ACTUAL')
                        ->where('image_id', '=', $products_data->products_image)
                        ->first();
                    if ($default_images) {
                        $products_data->default_images = $default_images->path;
                    }
                }

                //multiple images
                $products_images = DB::table('products_images')
                    ->LeftJoin('image_categories', 'products_images.image', '=', 'image_categories.image_id')
                    ->select('image_categories.path as image_path', 'image_categories.image_type')
                    ->where('products_id', '=', $products_id)
                    ->orderBy('sort_order', 'ASC')
                    ->get();

                $products_data->images = $products_images;

                $default_image_thumb = DB::table('products')
                    ->LeftJoin('image_categories', 'products.products_image', '=', 'image_categories.image_id')
                    ->select('image_categories.path as image_path', 'image_categories.image_type')
                    ->where('products_id', '=', $products_id)
                    ->where('image_type', '=', 'THUMBNAIL')
                    ->first();
                if ($default_image_thumb) {
                    $products_data->default_thumb = $default_image_thumb->image_path;
                } else {
                    $products_data->default_thumb = $products_data->default_images;
                }

                //categories
                $categories = DB::table('products_to_categories')
                    ->leftjoin('categories', 'categories.categories_id', 'products_to_categories.categories_id')
                    ->leftjoin('categories_description', 'categories_description.categories_id', 'products_to_categories.categories_id')
                    ->select('categories.categories_id', 'categories_description.categories_name', 'categories.categories_image', 'categories.categories_icon', 'categories.parent_id', 'categories.categories_slug', 'categories.categories_status')
                    ->where('products_id', '=', $products_id)
                    ->where('categories_description.language_id', '=', Session::get('language_id'))
                    ->where('categories.categories_status', 1)
                    ->orderby('parent_id', 'ASC')->get();

                $products_data->categories = $categories;
                array_push($result, $products_data);

                $options = array();
                $attr = array();

                $stocks = 0;
                $stockOut = 0;
                if ($products_data->products_type == '0') {
                    $stocks = DB::table('inventory')->where('products_id', $products_data->products_id)->where('stock_type', 'in')->sum('stock');
                    $stockOut = DB::table('inventory')->where('products_id', $products_data->products_id)->where('stock_type', 'out')->sum('stock');
                }

                $result[$index]->defaultStock = $stocks - $stockOut;

                //like product
                if (!empty(session('customers_id'))) {
                    $liked_customers_id = session('customers_id');
                    $categories = DB::table('liked_products')->where('liked_products_id', '=', $products_id)->where('liked_customers_id', '=', $liked_customers_id)->get();

                    if (count($categories) > 0) {
                        $result[$index]->isLiked = '1';
                    } else {
                        $result[$index]->isLiked = '0';
                    }
                } else {
                    $result[$index]->isLiked = '0';
                }

                // fetch all options add join from products_options table for option name
                $products_attribute = DB::table('products_attributes')->where('products_id', '=', $products_id)->groupBy('options_id')->get();
                if (count($products_attribute)) {
                    $index2 = 0;
                    foreach ($products_attribute as $attribute_data) {

                        $option_name = DB::table('products_options')
                            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('language_id', '=', Session::get('language_id'))->where('products_options.products_options_id', '=', $attribute_data->options_id)->get();

                        if (count($option_name) > 0) {

                            $temp = array();
                            $temp_option['id'] = $attribute_data->options_id;
                            $temp_option['name'] = $option_name[0]->products_options_name;
                            $temp_option['is_default'] = $attribute_data->is_default;
                            $attr[$index2]['option'] = $temp_option;

                            // fetch all attributes add join from products_options_values table for option value name
                            $attributes_value_query = DB::table('products_attributes')->where('products_id', '=', $products_id)->where('options_id', '=', $attribute_data->options_id)->get();
                            $k = 0;
                            foreach ($attributes_value_query as $products_option_value) {

                                $option_value = DB::table('products_options_values')->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name')->where('products_options_values_descriptions.language_id', '=', Session::get('language_id'))->where('products_options_values.products_options_values_id', '=', $products_option_value->options_values_id)->get();

                                $attributes = DB::table('products_attributes')->where([['products_id', '=', $products_id], ['options_id', '=', $attribute_data->options_id], ['options_values_id', '=', $products_option_value->options_values_id]])->get();

                                $temp_i['products_attributes_id'] = $attributes[0]->products_attributes_id;
                                $temp_i['id'] = $products_option_value->options_values_id;
                                $temp_i['value'] = $option_value[0]->products_options_values_name;
                                $temp_i['price'] = $products_option_value->options_values_price;
                                $temp_i['price_prefix'] = $products_option_value->price_prefix;
                                $temp_i['is_default'] = $products_option_value->is_default;
                                array_push($temp, $temp_i);

                            }
                            $attr[$index2]['values'] = $temp;
                            $result[$index]->attributes = $attr;
                            $index2++;
                        }
                    }
                } else {
                    $result[$index]->attributes = array();
                }
                $index++;
            }
            $responseData = array('success' => '1', 'product_data' => $result, 'message' => Lang::get('website.Returned all products'), 'total_record' => count($total_record));

        } else {
            $responseData = array('success' => '0', 'product_data' => $result, 'message' => Lang::get('website.Empty record'), 'total_record' => count($total_record));
        }

        return ($responseData);
    }

    public function cartIdArray($requestt)
    {

        $cart = DB::table('customers_basket')->where('customers_basket.is_order', '=', '0');

        if (empty(session('customers_id'))) {
            $cart->where('customers_basket.session_id', '=', Session::getId());
        } else {
            $cart->where('customers_basket.customers_id', '=', session('customers_id'));
        }

        $baskit = $cart->get();

        $result = array();
        $index = 0;
        foreach ($baskit as $baskit_data) {
            $result[$index++] = $baskit_data->products_id;
        }

        return ($result);

    }
    //currentstock
    public function productQuantity($data)
    {
        if (!empty($data['attributes'])) {
            $inventory_ref_id = '';
            $products_id = $data['products_id'];
            $attributes = array_filter($data['attributes']);
            $attributeid = implode(',', $attributes);
            $postAttributes = count($attributes);

            $inventories = DB::table('inventory')->where('products_id', $products_id)->get();
            $reference_ids = array();
            $stockIn = 0;
            $stockOut = 0;
            $inventory_ref_id = array();
            foreach ($inventories as $inventory) {

                $totalAttribute = DB::table('inventory_detail')->where('inventory_detail.inventory_ref_id', '=', $inventory->inventory_ref_id)->get();
                $totalAttributes = count($totalAttribute);

                if ($postAttributes > $totalAttributes) {
                    $count = $postAttributes;
                } elseif ($postAttributes < $totalAttributes or $postAttributes == $totalAttributes) {
                    $count = $totalAttributes;
                }

                $individualStock = DB::table('inventory')->leftjoin('inventory_detail', 'inventory_detail.inventory_ref_id', '=', 'inventory.inventory_ref_id')
                    ->selectRaw('inventory.*')
                    ->whereIn('inventory_detail.attribute_id', [$attributeid])
                    ->where(DB::raw('(select count(*) from `inventory_detail` where `inventory_detail`.`attribute_id` in (' . $attributeid . ') and `inventory_ref_id`= "' . $inventory->inventory_ref_id . '")'), '=', $count)
                    ->where('inventory.inventory_ref_id', '=', $inventory->inventory_ref_id)
                    ->groupBy('inventory_detail.inventory_ref_id')
                    ->get();
                if (count($individualStock) > 0) {

                    if ($individualStock[0]->stock_type == 'in') {
                        $stockIn += $individualStock[0]->stock;
                    }

                    if ($individualStock[0]->stock_type == 'out') {
                        $stockOut += $individualStock[0]->stock;
                    }

                    $inventory_ref_id[] = $individualStock[0]->inventory_ref_id;
                }

            }

            //get option name and value
            $options_names = array();
            $options_values = array();
            foreach ($attributes as $attribute) {
                $productsAttributes = DB::table('products_attributes')
                    ->leftJoin('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                    ->leftJoin('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                    ->select('products_attributes.*', 'products_options.products_options_name as options_name', 'products_options_values.products_options_values_name as options_values')
                    ->where('products_attributes_id', $attribute)->get();

                $options_names[] = $productsAttributes[0]->options_name;
                $options_values[] = $productsAttributes[0]->options_values;
            }

            $options_names_count = count($options_names);
            $options_names = implode("','", $options_names);
            $options_names = "'" . $options_names . "'";
            $options_values = "'" . implode("','", $options_values) . "'";

            //orders products
            $orders_products = DB::table('orders_products')->where('products_id', $products_id)->get();

            $result = array();
            $result['remainingStock'] = $stockIn - $stockOut;

            if (!empty($inventory_ref_id) && isset($inventory_ref_id[0])) {
                $minMax = DB::table('manage_min_max')->where([['inventory_ref_id', $inventory_ref_id[0]], ['products_id', $products_id]])->get();
            } else {
                $minMax = '';
            }
            $result['inventory_ref_id'] = $inventory_ref_id;
            $result['minMax'] = $minMax;
            $result['minMaxLevel'] = $minMax;

        } else {
            $result['inventory_ref_id'] = 0;
            $result['minMax'] = 0;
            $result['remainingStock'] = 0;
        }

        return $result;
    }

    public static function getquantity($request)
    {
        $inventory_ref_id = '';
        $result = array();
        $products_id = $request['products_id'];
        $productsType = DB::table('products')->where('products_id', $products_id)->get();
        //check products type
        //dd($request['attributes']);
        if ($productsType[0]->products_type == 1) {

            $attributes = array_filter($request['attributes']);
            $attributeid = implode(',', $attributes);

            $postAttributes = count($attributes);

            $inventories = DB::table('inventory')->where('products_id', $products_id)->get();
            $reference_ids = array();
            $stocks = 0;
            $stockIn = 0;
            foreach ($inventories as $inventory) {

                $totalAttribute = DB::table('inventory_detail')->where('inventory_detail.inventory_ref_id', '=', $inventory->inventory_ref_id)->get();
                $totalAttributes = count($totalAttribute);

                if ($postAttributes > $totalAttributes) {
                    $count = $postAttributes;
                } elseif ($postAttributes < $totalAttributes or $postAttributes == $totalAttributes) {
                    $count = $totalAttributes;
                }

                $individualStock = DB::table('inventory')->leftjoin('inventory_detail', 'inventory_detail.inventory_ref_id', '=', 'inventory.inventory_ref_id')
                    ->selectRaw('inventory.*')
                    ->whereIn('inventory_detail.attribute_id', [$attributeid])
                    ->where(DB::raw('(select count(*) from `inventory_detail` where `inventory_detail`.`attribute_id` in (' . $attributeid . ') and `inventory_ref_id`= "' . $inventory->inventory_ref_id . '")'), '=', $count)
                    ->where('inventory.inventory_ref_id', '=', $inventory->inventory_ref_id)
                    ->groupBy('inventory_detail.inventory_ref_id')
                    ->get();

                if (count($individualStock) > 0) {
                    $inventory_ref_id = $individualStock[0]->inventory_ref_id;
                    $stockIn += $individualStock[0]->stock;
                }

            }

            //get option name and value
            $options_names = array();
            $options_values = array();
            foreach ($attributes as $attribute) {
                $productsAttributes = DB::table('products_attributes')
                    ->leftJoin('products_options', 'products_options.products_options_id', '=', 'products_attributes.options_id')
                    ->leftJoin('products_options_values', 'products_options_values.products_options_values_id', '=', 'products_attributes.options_values_id')
                    ->select('products_attributes.*', 'products_options.products_options_name as options_name', 'products_options_values.products_options_values_name as options_values')
                    ->where('products_attributes_id', $attribute)->get();

                $options_names[] = $productsAttributes[0]->options_name;
                $options_values[] = $productsAttributes[0]->options_values;
            }

            $options_names_count = count($options_names);
            $options_names = implode("','", $options_names);
            $options_names = "'" . $options_names . "'";
            $options_values = "'" . implode("','", $options_values) . "'";

            //orders products
            $orders_products = DB::table('orders_products')->where('products_id', $products_id)->get();
            $stockOut = 0;
            foreach ($orders_products as $orders_product) {
                $totalAttribute = DB::table('orders_products_attributes')->where('orders_products_id', '=', $orders_product->orders_products_id)->get();
                $totalAttributes = count($totalAttribute);

                if ($postAttributes > $totalAttributes) {
                    $count = $postAttributes;
                } elseif ($postAttributes < $totalAttributes or $postAttributes == $totalAttributes) {
                    $count = $totalAttributes;
                }

                $products = DB::select("select orders_products.* from `orders_products` left join `orders_products_attributes` on `orders_products_attributes`.`orders_products_id` = `orders_products`.`orders_products_id` where `orders_products`.`products_id`='" . $products_id . "' and `orders_products_attributes`.`products_options` in (" . $options_names . ") and `orders_products_attributes`.`products_options_values` in (" . $options_values . ") and (select count(*) from `orders_products_attributes` where `orders_products_attributes`.`products_id` = '" . $products_id . "' and `orders_products_attributes`.`products_options` in (" . $options_names . ") and `orders_products_attributes`.`products_options_values` in (" . $options_values . ") and `orders_products_attributes`.`orders_products_id`= '" . $orders_product->orders_products_id . "') = " . $count . " and `orders_products`.`orders_products_id` = '" . $orders_product->orders_products_id . "' group by `orders_products_attributes`.`orders_products_id`");

                if (count($products) > 0) {
                    $stockOut += $products[0]->products_quantity;
                }
            }
            $stocks = $stockIn - $stockOut;

        } else {

            $stocks = 0;

            $stocksin = DB::table('inventory')->where('products_id', $products_id)->where('stock_type', 'in')->sum('stock');
            $stockOut = DB::table('inventory')->where('products_id', $products_id)->where('stock_type', 'out')->sum('stock');
            $stocks = $stocksin - $stockOut;
        }

        $responseData = array('success' => '1', 'stock' => $stocks, 'message' => "Attributes are returned successfull!");
        $response = $responseData;

        return $response;
    }

    public function getCategories($request)
    {
        $category = DB::table('categories')
        ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
        //->where('categories.categories_status', 1)
        ->where('categories_slug', $request->category)->where('language_id', Session::get('language_id'))
        ->get();
        return $category;
    }

    

    public function getCategoriesByslug($slug)
    {
        $category = DB::table('categories')
        ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
        //->where('categories.categories_status', 1)
        ->where('categories_slug', $slug)->where('language_id', Session::get('language_id'))
        ->get();
        return $category;
    }

    public function getMainCategories($category)
    {
        $main_category = DB::table('categories')->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
        //->where('categories.categories_status', 1)
        ->where('categories.categories_id', $category)->where('language_id', Session::get('language_id'))->get();
        return $main_category;
    }

    public function getCategorybyId($category)
    {
        $main_category = DB::table('categories')->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
        //->where('categories.categories_status', 1)
        ->where('categories.categories_id', $category)->where('language_id', Session::get('language_id'))->first();
        return $main_category;
    }

    public function getOptions()
    {
        $option = DB::table('products_options')
            ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('language_id', '=', Session::get('language_id'))->get();
        return $option;
    }

    public function getOptionsValues($value)
    {
        $value = DB::table('products_options_values')
            ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
            ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name', 'products_options_values_descriptions.language_id')
            ->where('products_options_values_descriptions.options_values_name', $value)->where('language_id', Session::get('language_id'))->get();
        return $value;
    }

    public function getProduct($request)
    {
        $products = DB::table('products')->where('products_id', $request->products_id)->get();
        return $products;
    }

    public function getCategoriesByProductId($products_id)
    {
        $category = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->leftJoin('products_to_categories', 'products_to_categories.categories_id', '=', 'categories.categories_id')
            ->where('products_to_categories.products_id', $products_id)
            ->where('categories.parent_id', 0)->where('categories.categories_status', 1)
            ->where('language_id', Session::get('language_id'))->get();
        return $category;
    }

    public function getSubCategoriesByProductId($products_id)
    {
        $sub_category = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->leftJoin('products_to_categories', 'products_to_categories.categories_id', '=', 'categories.categories_id')
            ->where('products_to_categories.products_id', $products_id)
            ->where('categories.parent_id', '>', 0)->where('categories.categories_status', 1)
            ->where('language_id', Session::get('language_id'))
            ->get();
        return $sub_category;
    }

    public function getFlashSale($products_id)
    {
        $isFlash = DB::table('flash_sale')->where('products_id', $products_id)
            ->where('flash_expires_date', '>=', time())->where('flash_status', '=', 1)
            ->get();
        return $isFlash;
    }

    public function getProductsBySlug($slug)
    {
        $products = DB::table('products')->where('products_slug', $slug)->get();
        return $products;
    }
    public function getProductsById($id)
    {
        $products = DB::table('products')->where('products_id', $id)->get();
        return $products;
    }

    public function getCategoryByParent($products_id)
    {
        $category = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->leftJoin('products_to_categories', 'products_to_categories.categories_id', '=', 'categories.categories_id')
            ->where('products_to_categories.products_id', $products_id)
            ->where('categories.parent_id', 0)
            ->where('categories.categories_status', 1)
            ->where('language_id', Session::get('language_id'))->get();
        return $category;
    }

    public function getSubCategoryByParent($products_id)
    {
        $sub_category = DB::table('categories')
            ->leftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->leftJoin('products_to_categories', 'products_to_categories.categories_id', '=', 'categories.categories_id')
            ->where('products_to_categories.products_id', $products_id)
            ->where('categories.parent_id', '>', 0)
            ->where('categories.categories_status', 1)
            ->where('language_id', Session::get('language_id'))
            ->get();
        return $sub_category;
    }

    public function filters($data)
    {

        $categories_id = $data['categories_id'];
        $currentDate = time();

        $price = DB::table('products_to_categories')
            ->join('products', 'products.products_id', '=', 'products_to_categories.products_id');
        if (isset($categories_id) and !empty($categories_id)) {
            $price->where('products_to_categories.categories_id', '=', $categories_id);
        }

        $priceContent = $price->max('products_price');
        if (!empty($priceContent)) {
            $priceContent = $priceContent * session('currency_value');
            $maxPrice = round($priceContent + 1);            
        } else {
            $maxPrice = 1;
        }

        $product = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
            ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
            ->LeftJoin('specials', function ($join) use ($currentDate) {
                $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1')->where('expires_date', '>', $currentDate);
            });

        if (isset($categories_id) and !empty($categories_id)) {
            $product->LeftJoin('products_to_categories', 'products.products_id', '=', 'products_to_categories.products_id')->select('products_to_categories.*', 'products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price');
        } else {
            $product->select('products.*', 'products_description.*', 'manufacturers.*', 'manufacturers_info.manufacturers_url', 'specials.specials_new_products_price as discount_price');
        }
        $product->where('products_description.language_id', '=', Session::get('language_id'));

        if (isset($categories_id) and !empty($categories_id)) {
            $product->where('products_to_categories.categories_id', '=', $categories_id);
        }

        $products = $product->get();

        $index = 0;
        $optionsIdArrays = array();
        $valueIdArray = array();
        foreach ($products as $products_data) {
            $option_name = DB::table('products_attributes')->where('products_id', '=', $products_data->products_id)->get();
            foreach ($option_name as $option_data) {

                if (!in_array($option_data->options_id, $optionsIdArrays)) {
                    $optionsIdArrays[] = $option_data->options_id;
                }

                if (!in_array($option_data->options_values_id, $optionsIdArrays)) {
                    $valueIdArray[] = $option_data->options_values_id;
                }
            }
        }

        if (!empty($optionsIdArrays)) {

            $index3 = 0;
            $result = array();
            foreach ($optionsIdArrays as $optionsIdArray) {
                $option_name = DB::table('products_options')
                    ->leftJoin('products_options_descriptions', 'products_options_descriptions.products_options_id', '=', 'products_options.products_options_id')->select('products_options.products_options_id', 'products_options_descriptions.options_name as products_options_name', 'products_options_descriptions.language_id')->where('language_id', '=', Session::get('language_id'))->where('products_options.products_options_id', '=', $optionsIdArray)->get();

                if (count($option_name) > 0) {
                    $attribute_opt_val = DB::table('products_options_values')->where('products_options_id', $optionsIdArray)->get();
                    if (count($attribute_opt_val) > 0) {
                        $temp = array();
                        $temp_name['name'] = $option_name[0]->products_options_name;
                        $attr[$index3]['option'] = $temp_name;

                        foreach ($attribute_opt_val as $attribute_opt_val_data) {

                            $attribute_value = DB::table('products_options_values')
                                ->leftJoin('products_options_values_descriptions', 'products_options_values_descriptions.products_options_values_id', '=', 'products_options_values.products_options_values_id')
                                ->select('products_options_values.products_options_values_id', 'products_options_values_descriptions.options_values_name as products_options_values_name', 'products_options_values_descriptions.language_id')
                                ->where('products_options_values.products_options_values_id', $attribute_opt_val_data->products_options_values_id)->where('language_id', Session::get('language_id'))->get();

                            foreach ($attribute_value as $attribute_value_data) {

                                //if(in_array($attribute_value_data->products_options_values_id,$valueIdArray)){
                                $temp_value['value'] = $attribute_value_data->products_options_values_name;
                                $temp_value['value_id'] = $attribute_value_data->products_options_values_id;

                                array_push($temp, $temp_value);
                                //}
                            }
                            $attr[$index3]['values'] = $temp;
                        }
                        $index3++;
                    }
                    $response = array('success' => '1', 'attr_data' => $attr, 'message' => Lang::get('website.Returned all filters successfully'), 'maxPrice' => $maxPrice);
                } else {
                    $response = array('success' => '0', 'attr_data' => array(), 'message' => Lang::get('website.Filter is empty for this category'), 'maxPrice' => $maxPrice);
                }

            }

        } else {
            $response = array('success' => '0', 'attr_data' => array(), 'message' => Lang::get('website.Filter is empty for this category'), 'maxPrice' => $maxPrice);
        }

        return ($response);
    }

}
