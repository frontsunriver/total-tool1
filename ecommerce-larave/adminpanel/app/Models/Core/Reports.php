<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Reports extends Model
{
    use Sortable;
    public $sortable = ['reviews_id', 'products_id', 'customers_id', 'customers_name', 'reviews_rating', 'reviews_status', 'reviews_read', 'created_at', 'updated_at'];
    public function customersReport($request)
    {
       

        $language_id = '1';
        $report = DB::table('orders');
        if (isset($request->orderid)) {
            $report->where('orders_id', $request->orderid);
        }

        if (isset($request->customers_id)) {
            
            if (isset($request->dateRange)) {
                $range = explode('-', $request->dateRange);

                $startdate = trim($range[0]);
                $enddate = trim($range[1]);

                $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
                $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
                $report->whereBetween('date_purchased', [$dateFrom, $dateTo]);
            }

        
            if (isset($request->orders_status_id)) {

                $orders_status_id = $request->orders_status_id;
                $report->LeftJoin('orders_status_history', function ($join) use ($orders_status_id) {
                    $join->on('orders_status_history.orders_id', '=', 'orders.orders_id')
                        ->orderby('orders_status_history.date_added', 'DESC')->limit(1);
                });

            }
        
            $report->where('customers_id', $request->customers_id);
        }
        $report->orderBy('orders_id','desc');
        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        $total_orders_price = $report->sum('order_price');
        // dd($total_orders_price);
        $index = 0;
        $total_price = 0;
        
        foreach ($orders as $orders_data) {
            $orders_status = DB::table('orders_status_history')
                ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
                ->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
                ->where('orders_status_description.language_id', '=', $language_id)
                ->where('orders_id', '=', $orders_data->orders_id)
                ->where('orders_status.role_id', '<=', 2);
            
            if (isset($request->orders_status_id)) {
                $orders_status->where('orders_status_history.orders_status_id', $request->orders_status_id);
            }

            $orders_status_history = $orders_status->orderby('orders_status_history.orders_status_history_id', 'DESC')->limit(1)->get();

            // $current_boy = DB::table('users')
            //     ->leftjoin('deliveryboy_info', 'users.id', '=', 'deliveryboy_info.users_id')
            //     ->leftjoin('orders_to_delivery_boy', 'orders_to_delivery_boy.deliveryboy_id', '=', 'users.id')
            // ->select('users.id', 'users.first_name', 'users.last_name', 'deliveryboy_info.availability_status')
            //     ->where('orders_to_delivery_boy.orders_id', '=', $orders_data->orders_id)
            //     ->where('users.role_id', 4)
            //     ->where('is_current', 1)
            //     ->first();

            // if ($current_boy) {
            //     $orders[$index]->deliveryboy_name = $current_boy->first_name . ' ' . $current_boy->last_name;
            // } else {
            //     $orders[$index]->deliveryboy_name = '';
            // }
            if(count($orders_status_history) > 0){
                $orders[$index]->orders_status_id = $orders_status_history[0]->orders_status_id;
                $orders[$index]->orders_status = $orders_status_history[0]->orders_status_name;
            }else{
                unset($orders[$index]);
            }
           
            
            $index++;

        }
        $result = array('orders' => $orders, 'total_price' => $total_orders_price);
        return $result;
    }

    public function couponReport($request)
    {
        $report = DB::table('orders');

        if (isset($request->couponcode)) {
            $report->where('coupon_code', $request->couponcode);
        }

        if (isset($request->dateRange)) {
            $range = explode('-', $request->dateRange);

            $startdate = trim($range[0]);
            $enddate = trim($range[1]);

            $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
            $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
            $report->whereBetween('date_purchased', [$dateFrom, $dateTo]);
        }

        $report->select('orders.*')->where('customers_id', '!=', '')->where('coupon_code', '!=', '')->orderby('orders.orders_id', 'ASC')->groupby('orders.orders_id');
        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }

        $total_orders_price = $report->sum('order_price');

        $index = 0;
        $total_price = 0;

        $result = array('orders' => $orders);
        return $result;
    }

    public function customersReportTotal($request)
    {
        $report = DB::table('orders');

        if (isset($request->orderid)) {
            $report->where('orders_id', $request->orderid);
        }

        if (isset($request->customers_id)) {
            $report->where('customers_id', $request->customers_id);
        }
        if (isset($request->currency)) {
            $report->where('orders.currency', $request->currency);
        }
        if (isset($request->dateRange)) {

            $range = explode('-', $request->dateRange);

            $startdate = trim($range[0]);
            $enddate = trim($range[1]);

            $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
            $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
            $report->whereBetween('date_purchased', [$dateFrom, $dateTo]);
        }
        $orders = $report->get();
        $prices = 0;

        foreach($orders as $order){
            $data = DB::select(DB::raw('SELECT * FROM `orders_status_history` WHERE orders_id = '.$order->orders_id.' ORDER BY `orders_status_history`.`orders_status_history_id` DESC LIMIT 1'));
            foreach($data as $d){
                if($d->orders_status_id == 1 || $d->orders_status_id == 2){
                        $prices = $prices + $order->order_price;
                }
            }
           
        }
        return ($prices);
    }

    public function allorderstatuses()
    {
        $statuses = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
        // ->where('orders_status.role_id', '=', 2)
            ->orderby('role_id')
            ->get();

        return $statuses;
    }

    public function salesreport($request)
    {


        $report = DB::table('orders')
                    ->selectRaw("date_purchased,orders_id,count('orders.orders_id') as total_orders,sum(order_price) as total_price");
                    if (isset($request->dateRange)) {
                        $range = explode('-', $request->dateRange);
            
                        $startdate = trim($range[0]);
                        $enddate = trim($range[1]);
            
                        $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
                        $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
                        $report->whereBetween('date_purchased', [$dateFrom, $dateTo])->groupby(DB::raw('Date(date_purchased)'));
                    }
                    else{
                        $report->whereRaw("date_purchased between (CURDATE() - INTERVAL (select count(orders_id) from orders) DAY)
                        and (CURDATE() - INTERVAL 1 DAY) group by DATE(date_purchased)");
                    }

        if ($request->page and $request->page == 'invioce') {
            $orders = $report->get();
        } else {
            $orders = $report->paginate(50);
        }


        $total_orders_price = DB::table('orders')
                    ->sum('order_price');
        
        $result = array('orders' => $orders, 'total_price' => $total_orders_price);
        return $result;
    }

    public function inventoryreport($request)
    {
        $report = DB::table('inventory');
        if(isset($request->value) && isset($request->products_id)){
            $inventory_ref_id  = DB::table('inventory_detail')->where('products_id',$request->products_id)->where('attribute_id',$request->value)->pluck('inventory_ref_id');
            $report->whereIn('inventory.inventory_ref_id', $inventory_ref_id);
            if (isset($request->dateRange)) {
                $range = explode('-', $request->dateRange);

                $startdate = trim($range[0]);
                $enddate = trim($range[1]);

                $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
                $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
                $report->whereBetween('created_at', [$dateFrom, $dateTo]);
            }
        }
        elseif (isset($request->products_id)) {
            $report->where('inventory.products_id', $request->products_id);

            if (isset($request->dateRange)) {
                $range = explode('-', $request->dateRange);

                $startdate = trim($range[0]);
                $enddate = trim($range[1]);

                $dateFrom = date('Y-m-d ' . '00:00:00', strtotime($startdate));
                $dateTo = date('Y-m-d ' . '23:59:59', strtotime($enddate));
                $report->whereBetween('created_at', [$dateFrom, $dateTo]);
                
            }

        } else {
            $report->where('inventory.inventory_ref_id', '');
        }
        $report->orderBy('inventory.inventory_ref_id','desc');
        if ($request->page and $request->page == 'invioce') {
            
            $reports = $report->get();
        } else {
            $reports = $report->paginate(50);
        }

        return $reports;

    }

    public function minstock($request)
    {
        $product = DB::table('products')
        ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
        ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
        ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
        ->LeftJoin('specials', function ($join) {

            $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');

        })
        ->select('products.products_id','products.products_type', 'products_description.products_name')
        ->where('products_description.language_id', '=', 1);
        $product->orderBy('products.products_id', 'DESC');

        $product =  $product->get();
        $stocks = 0;
        $min_level = 0;
        $max_level = 0;
        $result = array();
        foreach($product as $key => $product){
            if($product->products_type!=1){
                
                $stocksin = DB::table('inventory')->where('products_id', $product->products_id)->where('stock_type', 'in')->sum('stock');
                $stockOut = DB::table('inventory')->where('products_id', $product->products_id)->where('stock_type', 'out')->sum('stock');
                $stocks = $stocksin - $stockOut;
                $manageLevel = DB::table('manage_min_max')->where('products_id', $product->products_id)->get();
                if(count($manageLevel)>0){
                    $min_level = $manageLevel[0]->min_level;
                    $max_level = $manageLevel[0]->max_level;
                }
                if((int)$stocks < (int)$min_level){
                    $result[] = json_decode(json_encode(
                        [
                            'products_name' => $product->products_name,
                            'products_id' => $product->products_id,
                            'stocks' => $stocks,
                            'min_level' => $min_level 
                            ]
                    ));
                }
                ;
            }
            else{
                
            }

        }
        // dd($result);
        if ($request->page and $request->page == 'invioce') {
            $orders = $result;
        } else {
            $orders = $this->paginate($result);
        }

        return $orders;

    }

    public function maxstock($request)
    {
        $product = DB::table('products')
        ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
        ->leftJoin('manufacturers', 'manufacturers.manufacturers_id', '=', 'products.manufacturers_id')
        ->leftJoin('manufacturers_info', 'manufacturers.manufacturers_id', '=', 'manufacturers_info.manufacturers_id')
        ->LeftJoin('specials', function ($join) {

            $join->on('specials.products_id', '=', 'products.products_id')->where('status', '=', '1');

        })
        ->select('products.products_id','products.products_type', 'products_description.products_name')
        ->where('products_description.language_id', '=', 1);
        $product->orderBy('products.products_id', 'DESC');

        $product =  $product->get();
        $stocks = 0;
        $min_level = 0;
        $max_level = 0;
        $result = array();
        foreach($product as $key => $product){
            if($product->products_type!=1){
                
                $stocksin = DB::table('inventory')->where('products_id', $product->products_id)->where('stock_type', 'in')->sum('stock');
                $stockOut = DB::table('inventory')->where('products_id', $product->products_id)->where('stock_type', 'out')->sum('stock');
                $stocks = $stocksin - $stockOut;
                $manageLevel = DB::table('manage_min_max')->where('products_id', $product->products_id)->get();
                if(count($manageLevel)>0){
                    $min_level = $manageLevel[0]->min_level;
                    $max_level = $manageLevel[0]->max_level;
                }
                if((int)$stocks > (int)$max_level){
                    $result[] = json_decode(json_encode(
                        [
                            'products_name' => $product->products_name,
                            'products_id' => $product->products_id,
                            'stocks' => $stocks,
                            'max_level' => $max_level 
                            ]
                    ));
                }
                ;
            }
            else{
                
            }

        }
        // dd($result);
        if ($request->page and $request->page == 'invioce') {
            $orders = $result;
        } else {
            $orders = $this->paginate($result);
        }
        return $orders;
    }

    public function outofstock($request)
    {
        $report = DB::table('inventory')
                    ->leftjoin('products_description', 'products_description.products_id' ,'=' ,'inventory.products_id')
                    ->leftjoin('products', 'products.products_id' ,'=' ,'inventory.products_id')
                    ->select('products.products_type','products_description.products_id', 'products_description.products_name')
                    ->where('products_description.language_id', 1)
                    ->where('products.products_type','!=', 1)
                    ->groupby('inventory.products_id')
                    ->havingRaw("SUM(IF(stock_type = 'in', stock, 0)) - SUM(IF(stock_type = 'out', stock, 0)) = 0")->get();

                // $variableProduct = DB::select(DB::raw("SELECT inventory_detail.*,products_description.products_name , products_attributes.options_id,products_options_values_descriptions.options_values_name, SUM(CASE WHEN stock_type = 'in' THEN stock ELSE 0 END) AS instocksum,SUM(CASE WHEN stock_type = 'out' THEN stock ELSE 0 END) AS outstocksum,(SUM(CASE WHEN stock_type = 'in' THEN stock ELSE 0 END)-SUM(CASE WHEN stock_type = 'out' THEN stock ELSE 0 END)) as finalstock FROM `inventory` LEFT JOIN inventory_detail on inventory.inventory_ref_id = inventory_detail.inventory_ref_id LEFT JOIN products_attributes ON products_attributes.products_attributes_id = inventory_detail.attribute_id LEFT JOIN products_options_values_descriptions ON products_options_values_descriptions.products_options_values_descriptions_id = products_attributes.options_values_id LEFT JOIN products_description ON products_description.products_id = inventory_detail.products_id GROUP by attribute_id DESC"));
                // $out_of_stock_variable_product = array();
                // foreach($variableProduct as $vproduct){
                //     if($vproduct->finalstock == 0){
                //         $report->push( json_decode(json_encode(array("products_type" => 0,"products_name" => $vproduct->products_name.'('.$vproduct->options_values_name.')', "products_id" => $vproduct->products_id))) );

                //     }
                // }

                $notInsertedinInentory = DB::select(DB::raw('SELECT products.products_id,products_description.products_name FROM `products` LEFT JOIN products_description ON products_description.products_id = products.products_id WHERE products_description.language_id = 1 AND products.products_id NOT IN (SELECT products_id FROM inventory GROUP BY products_id)'));
                foreach($notInsertedinInentory as $vproduct){
                        $report->push( json_decode(json_encode(array("products_type" => 0,"products_name" => $vproduct->products_name, "products_id" => $vproduct->products_id))) );
                }
        // dd($report);
        if ($request->page and $request->page == 'invioce') {
            $orders = $report;
        } else {
            $orders = $this->paginate($report);
        }

        return $orders;

    }


    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
