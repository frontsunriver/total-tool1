<?php

namespace App\Models\Core;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use DB;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{

    public static function dashboard($request)
    {
        $language_id = '1';
        $result = array();

        $reportBase = $request->reportBase;

        //recently order placed
        $orders = DB::table('orders')
            ->LeftJoin('currencies', 'currencies.code', '=', 'orders.currency')
            ->where('customers_id', '!=', '')
            ->orderBy('date_purchased', 'DESC')
            ->get();

        $index = 0;
        $total_price = 0;
        $cost = 0;
        foreach ($orders as $orders_data) {
            $total_price += $orders_data->order_price;
            $orders_products = DB::table('orders_products')
                ->select('final_price', DB::raw('SUM(final_price) as total_price'), 'products_id')
                ->where('orders_id', '=', $orders_data->orders_id)
                ->groupBy('final_price')
                ->get();

            if (count($orders_products) > 0 and !empty($orders_products[0]->total_price)) {
                $orders[$index]->total_price = $orders_products[0]->total_price;
                //$related_product = DB::table('products')->where('products_id',$orders_products[0]->products_id)->get();

                $cost += DB::table('inventory')->where('products_id', $orders_products[0]->products_id)->sum('purchase_price');

            } else {
                $orders[$index]->total_price = 0;
            }

            $orders_status_history = DB::table('orders_status_history')
                ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->select('orders_status.orders_status_name', 'orders_status.orders_status_id')
                ->where('orders_id', '=', $orders_data->orders_id)->orderby('orders_status_history.date_added', 'DESC')->limit(1)->get();

            $orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
            $orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;

            $index++;

        }

        $compeleted_orders = 0;
        $pending_orders = 0;
        foreach ($orders as $orders_data) {

            if ($orders_data->orders_status_id == '2') {
                $compeleted_orders++;
            }
            if ($orders_data->orders_status_id == '1') {
                $pending_orders++;
            }
        }

        $result['orders'] = $orders->chunk(10);
        $result['pending_orders'] = $pending_orders;
        $result['compeleted_orders'] = $compeleted_orders;
        $result['total_orders'] = count($orders);

        $result['inprocess'] = count($orders) - $pending_orders - $compeleted_orders;
        //add to cart orders
        $cart = DB::table('customers_basket')->get();

        $result['cart'] = count($cart);

        //Rencently added products
        $recentProducts = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products_description.language_id', '=', $language_id)
            ->orderBy('products.products_id', 'DESC')
            ->paginate(8);

        $result['recentProducts'] = $recentProducts;

        //products
        $products = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products_description.language_id', '=', $language_id)
            ->orderBy('products.products_id', 'DESC')
            ->get();

        //low products & out of stock
        $lowLimit = 0;
        $outOfStock = 0;
        $total_money = 0;
        $products_ids = array();
        $data = array();
        foreach ($products as $products_data) {
            //$total_money += $products_data->products_price;
            $currentStocks = DB::table('inventory')->where('products_id', $products_data->products_id)->get();
            $total_money += DB::table('inventory')->where('products_id', $products_data->products_id)->sum('purchase_price');

            if (count($currentStocks) > 0) {

                if ($products_data->products_type != 1) {
                    $c_stock_in = DB::table('inventory')->where('products_id', $products_data->products_id)->where('stock_type', 'in')->sum('stock');
                    $c_stock_out = DB::table('inventory')->where('products_id', $products_data->products_id)->where('stock_type', 'out')->sum('stock');

                    if (($c_stock_in - $c_stock_out) == 0) {
                        if (!in_array($products_data->products_id, $products_ids)) {
                            $products_ids[] = $products_data->products_id;

                            array_push($data, $products_data);
                            $outOfStock++;
                        }
                    }
                }

            } else {
                $outOfStock++;
            }
        }

        //products profit
        if ($total_money == 0) {
            $profit = 0;
        } else {
            $profit = abs($total_price - $cost);
        }

        $result['profit'] = $profit;
        //$result['total_money'] = $total_money;
        $result['total_money'] = $cost;
        $result['lowLimit'] = $lowLimit;
        $result['outOfStock'] = $outOfStock;
        $result['totalProducts'] = count($products);

        $customers = DB::table('customers')
            ->LeftJoin('customers_info', 'customers_info.customers_info_id', '=', 'customers.customers_id')
            ->orderBy('customers_info.customers_info_date_account_created', 'DESC')
            ->get();

        $result['customers'] = $customers->chunk(21);
        $result['totalCustomers'] = count($customers);
        $result['reportBase'] = $reportBase;

        //get function from other controller
        $myVar = new SiteSettingController();
        $currency = $myVar->getSetting();
        $result['currency'] = $currency;
        return $result;
    }  

}
