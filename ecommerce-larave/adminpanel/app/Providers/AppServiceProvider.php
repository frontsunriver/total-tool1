<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if(file_exists(storage_path('installed'))){
            $result = array();
            $orders = DB::table('orders')
            ->leftJoin('customers','customers.customers_id','=','orders.customers_id')
            ->where('orders.is_seen','=', 0)
            ->orderBy('orders_id','desc')
            ->get();

            $index = 0;
            foreach($orders as $orders_data){

              array_push($result,$orders_data);
              $orders_products = DB::table('orders_products')
                ->where('orders_id', '=' ,$orders_data->orders_id)
                ->get();

              $result[$index]->price = $orders_products;
              $result[$index]->total_products = count($orders_products);
              $index++;
            }

            //new customers
            $newCustomers = DB::table('users')
                ->where('is_seen','=', 0)
                ->where('role_id','=', 2)
                ->orderBy('id','desc')
                ->get();

            //products low in quantity
            $lowInQunatity = DB::select(DB::raw('SELECT image_categories.path as image,products_description.products_name,inventory.products_id , inventory.stock , manage_min_max.min_level FROM `inventory` 
            LEFT JOIN products on products.products_id = inventory.products_id
            LEFT JOIN images on products.products_image = images.id
            LEFT JOIN image_categories on image_categories.image_id = images.id
            LEFT JOIN manage_min_max on inventory.products_id = manage_min_max.products_id 
            LEFT JOIN products_description ON products_description.products_id = inventory.products_id 
            WHERE inventory.stock < manage_min_max.min_level AND products_description.language_id = 1  
            GROUP BY inventory.products_id ORDER BY manage_min_max.min_max_id DESC'));

            $languages = DB::table('languages')->get();
            view()->share('languages', $languages);
            $images = '';
            $web_setting = DB::table('settings')->get();
            view()->share('web_setting', $web_setting);
            view()->share('images', $images);
            view()->share('unseenOrders', $result);
            view()->share('newCustomers', $newCustomers);
            view()->share('lowInQunatity', $lowInQunatity);
        }
    }
}
