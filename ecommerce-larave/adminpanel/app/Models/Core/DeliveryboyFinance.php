<?php

namespace App\Models\Core;

use DB;
use Illuminate\Database\Eloquent\Model;

class DeliveryboyFinance extends Model
{
    public function monthlyearnings()
    {
        $saleData = array();
        $dateLimit = date("Y");

        $datePrevStart = date("Y-n-j", strtotime("first day of previous month"));
        $datePrevEnd = date("Y-n-j", time());

        $current_month = date("n", time());

        //for current year
        for ($j = $current_month; $j >= 1; $j--) {
            $dateFrom = date($dateLimit . '-' . $j . '-1 00:00:00', strtotime($datePrevStart));
            $dateTo = date($dateLimit . '-' . $j . '-31 23:59:59', strtotime($datePrevEnd));
           
            $orders = DB::table('orders')
                ->join('orders_products', 'orders_products.orders_id', '=', 'orders.orders_id')
                ->join('orders_status_history', function ($join) {
                    $join->on('orders_status_history.orders_id', '=', 'orders_products.orders_id')
                        ->where(function ($query) {
                            $query->where('orders_status_history.orders_status_id', '=', 2)
                                ->orderby('orders_status_history.date_added', 'DESC')->groupby('orders_status_history.orders_id');
                        });
                })
                ->select('orders.*', 'orders_products.*', 'orders_products.*')
                ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                ->groupby('products_id')
                ->get();

            $index2 = 0;
            $totalsale = 0;
            $admin_commision = 0;
            $vendor_balance = 0;
            $item_price = 0;
            //ordertable data
            $shipping_cost = 0;
            $coupon_amount = 0;
            $orders_ids = array();
            foreach ($orders as $orders_data) {
                
                $item_price += $orders_data->final_price * $orders_data->products_quantity;
                
                if (!in_array($orders_data->orders_id, $orders_ids)) {
                    $shipping_cost += $orders_data->shipping_cost;
                    $coupon_amount += $orders_data->coupon_amount;
                    $orders_ids[] = $orders_data->orders_id;
                }                
            }

            $total_amount = number_format(($item_price + $shipping_cost + $coupon_amount), 2);
            
            $saleData[$j - 1]['admin_commision'] = number_format($admin_commision, 2);
            $saleData[$j - 1]['vendor_balance'] = number_format($vendor_balance, 2);
            $saleData[$j - 1]['item_price'] = number_format($item_price, 2);
            $saleData[$j - 1]['shipping_cost'] = number_format($shipping_cost, 2);
            $saleData[$j - 1]['coupon_amount'] = number_format($coupon_amount, 2);
            $saleData[$j - 1]['total_amount'] = $total_amount;
            $saleData[$j - 1]['month'] = date('F Y', strtotime($dateFrom));

            $currentmonth = '';
            $lastmonth = '';
            if ($current_month == $j) {
                $currentmonth = $total_amount;
            }

            if (($current_month - 1) == $j) {
                $lastmonth = $total_amount;
            }

            $saleData[$j - 1]['currentmonth'] = $currentmonth;
            $saleData[$j - 1]['lastmonth'] = $lastmonth;

        }

        return $saleData;
    }

    public function sevendaysearnings()
    {
        $dateFrom = date("Y-n-j 00:00:00", strtotime("-7 days"));
        $dateTo = date("Y-n-j 23:59:59", time());

        $orders = DB::table('orders')
            ->join('orders_products', 'orders_products.orders_id', '=', 'orders.orders_id')
            ->join('orders_status_history', function ($join) {
                $join->on('orders_status_history.orders_id', '=', 'orders_products.orders_id')
                    ->where(function ($query) {
                        $query->where('orders_status_history.orders_status_id', '=', 2)
                            ->orderby('orders_status_history.date_added', 'DESC')->groupby('orders_status_history.orders_id');
                    });
            })
            ->select('orders.*', 'orders_products.*', 'orders_status_history.*', DB::raw('sum(final_price * products_quantity) as final_price '))
            ->whereBetween('date_purchased', [$dateFrom, $dateTo])
            ->groupby('products_id')
            ->orderby('orders.date_purchased', 'DESC')
            ->get();
        //section
        $admin_commision = 0;
        $vendor_balance = 0;
        $item_price = 0;
        
        //ordertable data
        $shipping_cost = 0;
        $coupon_amount = 0;
        $orders_ids = array();
        foreach ($orders as $orders_data) {

            if (!in_array($orders_data, $orders_ids)) {
                $shipping_cost += $orders_data->shipping_cost;
                $coupon_amount += $orders_data->coupon_amount;
            }

            $item_price += $orders_data->final_price;
           
        }

        $total_amount = number_format(($item_price + $shipping_cost + $coupon_amount), 2);

        return $total_amount;
    }

    public function todaysearnings()
    {
        $dateFrom = date("Y-n-j 00:00:00", time());
        $dateTo = date("Y-n-j 23:59:59", time());

        $orders = DB::table('orders')
            ->join('orders_products', 'orders_products.orders_id', '=', 'orders.orders_id')
            ->join('orders_status_history', function ($join) {
                $join->on('orders_status_history.orders_id', '=', 'orders_products.orders_id')
                    ->where(function ($query) {
                        $query->where('orders_status_history.orders_status_id', '=', 2)
                            ->orderby('orders_status_history.date_added', 'DESC')->groupby('orders_status_history.orders_id');
                    });
            })
            ->select('orders.*', 'orders_products.*', 'orders_status_history.*', DB::raw('sum(final_price * products_quantity) as final_price '))
            ->whereBetween('date_purchased', [$dateFrom, $dateTo])
            ->groupby('products_id')
            ->orderby('orders.date_purchased', 'DESC')
            ->get();
            
        $admin_commision = 0;
        $vendor_balance = 0;
        $item_price = 0;
        //ordertable data
        $shipping_cost = 0;
        $coupon_amount = 0;
        $orders_ids = array();
        foreach ($orders as $orders_data) {

            if (!in_array($orders_data, $orders_ids)) {
                $shipping_cost += $orders_data->shipping_cost;
                $coupon_amount += $orders_data->coupon_amount;
            }

            $item_price += $orders_data->final_price;
            
        }

        $total_amount = number_format(($item_price + $shipping_cost + $coupon_amount), 2);

        return $total_amount;
    }

    public function earningsbymonth($request)
    {
        $deliveryboys_id = $request->deliveryboys_id; 
        $result = array();
        $requestedmonth = date('Y-n-j', strtotime($request->month));
        $datePrevStart = date("Y-n-" . "1", strtotime($requestedmonth));
        $datePrevEnd = date("Y-n-t", strtotime($requestedmonth));      

        $dateFrom = date($datePrevStart . ' 00:00:00', strtotime($datePrevStart));
        $dateTo = date($datePrevEnd . ' 23:59:59', strtotime($datePrevEnd));
        
        //sold products
        $shipping_cost = DB::table('orders')
            ->join('orders_to_delivery_boy', 'orders_to_delivery_boy.orders_id', '=', 'orders.orders_id')
            ->join('users', 'users.id', '=', 'orders_to_delivery_boy.deliveryboy_id')
            ->select('orders.*')            
            ->whereBetween('date_purchased', [$dateFrom, $dateTo])
            ->where('is_current', 1)
            ->where('shipping_method', 'Cash on Delivery')
            ->sum('shipping_cost');
            
         
        return $shipping_cost;        
    }


    public function deliveryboyweekearnings($request)
    {
        $result = array();
        $deliveryboys_id = $request->deliveryboys_id;

        $dateFrom = date("Y-n-j 00:00:00", strtotime("-7 days"));
        $dateTo = date("Y-n-j 23:59:59", time());
        
        //sold products
        $total_amount = DB::table('orders')
            ->join('orders_to_delivery_boy', 'orders_to_delivery_boy.orders_id', '=', 'orders.orders_id')
            ->join('users', 'users.id', '=', 'orders_to_delivery_boy.deliveryboy_id')
            ->select('orders.*')            
            ->whereBetween('date_purchased', [$dateFrom, $dateTo])
            ->where('is_current', 1)
            ->where('users.id', $deliveryboys_id)
            ->where('shipping_method', 'Cash on Delivery')
            ->sum('shipping_cost');
        
        $sale_data = DB::table('orders')
            ->join('orders_to_delivery_boy', 'orders_to_delivery_boy.orders_id', '=', 'orders.orders_id')
            ->join('users', 'users.id', '=', 'orders_to_delivery_boy.deliveryboy_id')
            ->select('orders.*')            
            //->whereBetween('date_purchased', [$dateFrom, $dateTo])
            ->where('is_current', 1)
            //->where('users.id', $deliveryboys_id)
            //->where('shipping_method', 'Cash on Delivery')
            ->get();

        $result['total_amount'] = $total_amount;
        $result['sale_data'] = $sale_data;
         
        return $result;
    }

    public function deliveryboytodayearnings($request)
    {
        $result = array();
        $deliveryboys_id = $request->deliveryboys_id;

        $dateFrom = date("Y-n-j 00:00:00", time());
        $dateTo = date("Y-n-j 23:59:59", time());
        
        //sold products
        $shipping_cost = DB::table('orders')
            ->join('orders_to_delivery_boy', 'orders_to_delivery_boy.orders_id', '=', 'orders.orders_id')
            ->join('users', 'users.id', '=', 'orders_to_delivery_boy.deliveryboy_id')
            ->select('orders.*')            
            ->whereBetween('date_purchased', [$dateFrom, $dateTo])
            ->where('is_current', 1)
            ->where('shipping_method', 'Cash on Delivery')
            ->sum('shipping_cost');
         
        return $shipping_cost;
        
    }
       

}
