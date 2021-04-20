<?php
namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use App\Models\Core\Reports;
use App\Models\Core\Customers;
use App\Models\Core\Currency;
use App\Models\Core\Products;

//for password encryption or hash protected
use DB;
use Hash;

//for authenitcate login data
use Illuminate\Http\Request;
use Lang;

use App\Models\Core\DeliveryBoys;


//for requesting a value

class ReportsController extends Controller
{
    public function __construct(Reports $reports, Setting $setting, Customers $customers, Products $products,Currency $currency) {
        $this->reports = $reports;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myVaralter = new AlertController($setting);
        $this->Setting = $setting;
        //$this->DeliveryBoys = $deliveryBoys;
        $this->Customers = $customers;
        $this->Currency = $currency;
        $this->Products = $products;
    }

    //statsCustomers
    public function statsCustomers(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.CustomerOrdersTotal"));

        
        if(isset($request->customers_id) || isset($request->orderid) ){
            $result['price'] = $this->reports->customersReportTotal($request);
            $result['reports'] = $this->reports->customersReport($request);
        }
        
        else{
            $result['price'] = 0;
            $result['reports'] = array('orders' => [], 'total_price' => 0);
        }
        
        
        $result['customers'] = $this->Customers->getter();
        $result['orderstatus'] = $this->reports->allorderstatuses();
        $result['currency'] = $this->Currency->getter();
       // $result['deliveryboys'] = $this->DeliveryBoys->getter();
        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.statsCustomers", $title)->with('result', $result);

    }

    public function customerOrdersPrint(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.CustomerOrdersTotal"));
        
        $result['reports'] = $this->reports->customersReport($request);
        $result['price'] = $this->reports->customersReportTotal($request);
        
        $result['customers'] = $this->Customers->getter();
        $result['orderstatus'] = $this->reports->allorderstatuses();
        $result['deliveryboys'] = $this->DeliveryBoys->getter();

        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.statsCustomersinvoice", $title)->with('result', $result);

    }
    
    public function couponReport(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.CustomerOrdersTotal"));

        $result['reports'] = $this->reports->couponReport($request);

        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.couponreport", $title)->with('result', $result);

    }

    public function couponReportPrint(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.CustomerOrdersTotal"));

        $result['reports'] = $this->reports->couponReport($request);

        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.couponreportinvoice", $title)->with('result', $result);

    }

    public function salesreport(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Sales Report"));
        $result['reports'] = $this->reports->salesreport($request);
        $result['price'] = $this->reports->customersReportTotal($request);
        
        $result['customers'] = $this->Customers->getter();
        $result['orderstatus'] = $this->reports->allorderstatuses();
        $result['currency'] = $this->Currency->getter();
        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.salesreport", $title)->with('result', $result);
    }

    

    //statsProductsPurchased
    public function inventoryreport(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Inventory Report"));

        $result['reports'] = $this->reports->inventoryreport($request);
        // dd($result['reports']);
        $result['products'] = $this->Products->getter();   
                
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.inventoryreport", $title)->with('result', $result);
        // return view("admin.reports.statsProductsPurchased", $title)->with('result', $result);
    }

    public function inventoryreportprint(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Inventory Report"));

        $result['reports'] = $this->reports->inventoryreport($request);
        $result['products'] = $this->Products->getter();   
                
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.inventoryreportprint", $title)->with('result', $result);
    }

    //minstock
    public function minstock(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Min Stock Report"));

        $result['reports'] = $this->reports->minstock($request);

        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.minstock", $title)->with('result', $result);
    }

    public function minstockprint(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Inventory Report"));

        $result['reports'] = $this->reports->minstock($request);

        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.minstockprint", $title)->with('result', $result);
    }

    //maxstock
    public function maxstock(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Max Stock Report"));

        $result['reports'] = $this->reports->maxstock($request);
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.maxstock", $title)->with('result', $result);
    }
    

    public function maxstockprint(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Inventory Report"));

        $result['reports'] = $this->reports->maxstock($request);

        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();
        
        return view("admin.reports.maxstockprint", $title)->with('result', $result);
    }

    //outofstock
    public function outofstock(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.outOfStock"));
        $result['reports'] = $this->reports->outofstock($request);
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.outofstock", $title)->with('result', $result);
    }

    //outofstock
    public function outofstockprint(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.outOfStock"));
        $result['reports'] = $this->reports->outofstock($request);
        $variableProduct = DB::select(DB::raw("SELECT inventory_detail.*,products_description.products_name , products_attributes.options_id,products_options_values_descriptions.options_values_name, SUM(CASE WHEN stock_type = 'in' THEN stock ELSE 0 END) AS instocksum,SUM(CASE WHEN stock_type = 'out' THEN stock ELSE 0 END) AS outstocksum,(SUM(CASE WHEN stock_type = 'in' THEN stock ELSE 0 END)-SUM(CASE WHEN stock_type = 'out' THEN stock ELSE 0 END)) as finalstock FROM `inventory` LEFT JOIN inventory_detail on inventory.inventory_ref_id = inventory_detail.inventory_ref_id LEFT JOIN products_attributes ON products_attributes.products_attributes_id = inventory_detail.attribute_id LEFT JOIN products_options_values_descriptions ON products_options_values_descriptions.products_options_values_descriptions_id = products_attributes.options_values_id LEFT JOIN products_description ON products_description.products_id = inventory_detail.products_id GROUP by attribute_id DESC"));
        $out_of_stock_variable_product = array();
        foreach($variableProduct as $vproduct){
            if($vproduct->finalstock == 0){
                $out_of_stock_variable_product[] = $vproduct;
            }
        } 
        $result['variable_product_reports'] = $out_of_stock_variable_product;
        
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.outofstockprint", $title)->with('result', $result);
    }


    //statsProductsLiked
    public function statsProductsLiked(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.StatsProductsLiked"));

        $products = DB::table('products')
            ->join('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products.products_liked', '>', '0')
            ->where('products_description.language_id', '=', '1')
            ->orderBy('products_liked', 'DESC')
            ->paginate(20);

        $result['data'] = $products;

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();

        $result['commonContent'] = $myVar->Setting->commonContent();
        return view("admin.reports.statsProductsLiked", $title)->with('result', $result);

    }

    

    //lowinstock
    public function lowinstock(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Low Stock Products"));

        $language_id = 1;

        $products = DB::table('products')
            ->leftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
        //->leftJoin('inventory','inventory.products_id','=','products.products_id')
            ->where('products_description.language_id', '=', $language_id)
            ->orderBy('products.products_id', 'DESC')
            ->get();

        $result2 = array();
        $products_array = array();
        $index = 0;
        $lowLimit = 0;
        $outOfStock = 0;
        foreach ($products as $product) {

            if ($product->products_type == 1) {

            } elseif ($product->products_type == 0 or $product->products_type == 2) {
                $inventories = DB::table('inventory')->where('products_id', $product->products_id)->get();
                $stockIn = 0;
                foreach ($inventories as $inventory) {
                    $stockIn += $inventory->stock;
                }

                $orders_products = DB::table('orders_products')
                    ->select(DB::raw('count(orders_products.products_quantity) as stockout'))
                    ->where('products_id', $product->products_id)->get();

                $stocks = $stockIn - $orders_products[0]->stockout;

                $manageLevel = DB::table('manage_min_max')->where('products_id', $product->products_id)->get();

                $min_level = 0;
                $max_level = 0;

                if (count($manageLevel) > 0) {
                    $min_level = $manageLevel[0]->min_level;
                    $max_level = $manageLevel[0]->max_level;
                }

                if ($stocks <= $min_level) {
                    array_push($products_array, $product);
                }

            }
        }

        $lowQunatity = DB::table('products')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->whereColumn('products.products_quantity', '<=', 'products.low_limit')
            ->where('products_description.language_id', '=', 1)
            ->where('products.low_limit', '>', 0)
            ->paginate(10);

        $result['lowQunatity'] = $products_array;

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.lowinstock", $title)->with('result', $result);
    }
    //productsStock
    public function stockin(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ProductsStocks"));
        $language_id = 1;

        $products = DB::table('products')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->where('products_description.language_id', '=', $language_id)
            ->where('products.products_id', '=', $request->products_id)
            ->get();

        $productsArray = array();
        $index = 0;
        foreach ($products as $product) {
            array_push($productsArray, $product);
            $inventories = DB::table('inventory')->where('products_id', $product->products_id)
                ->leftJoin('users', 'users.id', '=', 'inventory.admin_id')
                ->get();

            $productsArray['history'] = $inventories;
        }
        $result['products'] = $productsArray;

        //echo '<pre>'.print_r($result['products'],true).'<pre>';

        //get function from other controller
        $myVar = new SiteSettingController();
        $result['currency'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.stockin", $title)->with('result', $result);

    }

    public function getFormattedDate($reportBase)
    {
        $dateFrom = date('Y-m-01', $date);
        $dateTo = date('Y-m-t', $date);
    }

    //public function productSaleReport($reportBase){
    public function productSaleReport(Request $request)
    {

        $saleData = array();
        $date = time();
        $reportBase = $request->reportBase;
        //$reportBase = 'last_year';

        if ($reportBase == 'this_month') {
            

            $dateLimit = date('d', $date);

            //for current month
            for ($j = 1; $j <= $dateLimit; $j++) {

                $dateFrom = date('Y-m-' . $j . ' 00:00:00', time());
                $dateTo = date('Y-m-' . $j . ' 23:59:59', time());
                
                $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count(); 
                $producQuantity = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 2)
                    ->count();

                $customers = DB::table('users')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count(); 
                $saleData[$j - 1]['date'] = date('h a', strtotime($dateFrom));
                $saleData[$j - 1]['totalSale'] = $totalSale;
                $saleData[$j - 1]['productQuantity'] = $producQuantity;
                $saleData[$j - 1]['customers'] = $customers;
            }

        } 
        else if ($reportBase == 'last_month') {
            $datePrevStart = date("Y-n-j", strtotime("first day of previous month"));
            $datePrevEnd = date("Y-n-j", strtotime("last day of previous month"));

            $dateLimit = date('d', strtotime($datePrevEnd));

            //for last month
            for ($j = 1; $j <= $dateLimit; $j++) {

                $dateFrom = date('Y-m-' . $j . ' 00:00:00', strtotime($datePrevStart));
                $dateTo = date('Y-m-' . $j . ' 23:59:59', strtotime($datePrevEnd));

                $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count(); 
                $producQuantity = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 2)
                    ->count(); 


                //website orders

                $customers = DB::table('users')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count(); 
                $saleData[$j - 1]['date'] = date('h a', strtotime($dateFrom));
                $saleData[$j - 1]['totalSale'] = $totalSale;
                $saleData[$j - 1]['productQuantity'] = $producQuantity;
                $saleData[$j - 1]['customers'] = $customers;
            }

        } 
        else if ($reportBase == 'last_year') {

            $dateLimit = date("Y", strtotime("-1 year"));

            $datePrevStart = date("Y-n-j", strtotime("first day of previous month"));
            $datePrevEnd = date("Y-n-j", strtotime("last day of previous month"));

            //for last year
            for ($j = 1; $j <= 12; $j++) {
                $dateFrom = date($dateLimit . '-' . $j . '-1 00:00:00', strtotime($datePrevStart));
                $dateTo = date($dateLimit . '-' . $j . '-31 23:59:59', strtotime($datePrevEnd));

                //sold products
                $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count(); 
                $producQuantity = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 2)
                    ->count(); 

                $customers = DB::table('users')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count(); 
                $saleData[$j - 1]['date'] = date('h a', strtotime($dateFrom));
                $saleData[$j - 1]['totalSale'] = $totalSale;
                $saleData[$j - 1]['productQuantity'] = $producQuantity;
                $saleData[$j - 1]['customers'] = $customers;
            }
        } 
        else {
            $reportBase = str_replace('dateRange', '', $reportBase);
            $reportBase = str_replace('=', '', $reportBase);
            $reportBase = str_replace('-', '/', $reportBase);

            $dateFrom = substr($reportBase, 0, 10);
            $dateTo = substr($reportBase, 11, 21);

            $diff = abs(strtotime($dateFrom) - strtotime($dateTo));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $totalDays = floor($diff / (60 * 60 * 24));
            //    print ('day: '.$days.' months: '.$months.' years: '.$years.'<br>');
            $totalMonths = floor($diff / 60 / 60 / 24 / 30);

            if ($diff == 0 && $days == 0 && $years == 0 && $months == 0) {
                //print 'asdsad';

                $dateLimitFrom = date('G', strtotime($dateFrom));
                $dateLimitTo = date('d', strtotime($dateTo));
                $selecteddate = date('m', strtotime($dateFrom));
                $selecteddate = date('Y', strtotime($dateFrom));

                //for current month
                for ($j = 1; $j <= 24; $j++) {

                    $dateFrom = date('Y-m-d' . ' ' . $j . ':00:00', strtotime($dateFrom));
                    $dateTo = date('Y-m-d' . ' ' . $j . ':59:59', strtotime($dateFrom));

                    //sold products
                    $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count(); 
                    $producQuantity = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 2)
                    ->count(); 
                    $customers = DB::table('users')
                        ->whereBetween('created_at', [$dateFrom, $dateTo])
                        ->count(); 
                    $saleData[$j - 1]['date'] = date('h a', strtotime($dateFrom));
                    $saleData[$j - 1]['totalSale'] = $totalSale;
                    $saleData[$j - 1]['productQuantity'] = $producQuantity;
                    $saleData[$j - 1]['customers'] = $customers;
                    //print $dateLimitFrom.'<br>';

                }

            } 
            else if ($days > 1 && $years == 0 && $months == 0) {

                //print 'daily';

                $dateLimitFrom = date('d', strtotime($dateFrom));
                $dateLimitTo = date('d', strtotime($dateTo));
                $selectedMonth = date('m', strtotime($dateFrom));
                $selectedYear = date('Y', strtotime($dateFrom));
                //print $selectedYear;

                //for current month
                for ($j = 1; $j <= $totalDays; $j++) {

                    //print 'dateFrom: '.date('Y-m-'.$j.' 00:00:00', time()).'dateTo: '.date('Y-m-'.$j.' 23:59:59', time());
                    //print '<br>';

                    $dateFrom = date($selectedYear . '-' . $selectedMonth . '-' . $dateLimitFrom, strtotime($dateFrom));
                    //$dateTo     = date('Y-m-'.$j.' 23:59:59', time());
                    //print $dateFrom .'<br>';
                    $lastday = date('t', strtotime($dateFrom));
                    //print 'lastday: '.$lastday .' <br>';

                    //sold products
                    $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count();

                    $producQuantity = DB::table('orders')
                        ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                        ->where('ordered_source', 2)
                        ->count();  
                    $customers = DB::table('users')
                        ->whereBetween('created_at', [$dateFrom, $dateTo])
                        ->count(); 
                    $saleData[$j - 1]['date'] = date('d M', strtotime($dateFrom));
                    $saleData[$j - 1]['totalSale'] = $totalSale;                    
                    $saleData[$j - 1]['productQuantity'] = $producQuantity;
                    $saleData[$j - 1]['customers'] = $customers;
                    
                    //print $dateLimitFrom.'<br>';
                    if ($dateLimitFrom == $lastday) {
                        $dateLimitFrom = '1';
                        $selectedMonth++;

                    } else {
                        $dateLimitFrom++;
                    }

                    if ($selectedMonth > 12) {
                        $selectedMonth = '1';
                        $selectedYear++;
                    }
                }
            } 
            else if ($months >= 1 && $years == 0) {

                //for check if date range enter into another month
                if ($days > 0) {
                    $months += 1;
                }

                $dateLimitFrom = date('d', strtotime($dateFrom));
                $dateLimitTo = date('d', strtotime($dateTo));
                $selectedMonth = date('m', strtotime($dateFrom));
                $selectedYear = date('Y', strtotime($dateFrom));
                //print $selectedMonth;

                $i = 0;
                //for current month
                for ($j = 1; $j <= $months; $j++) {
                    if ($j == $months) {
                        $lastday = $dateLimitTo;
                    } else {
                        $lastday = date('t', strtotime($dateLimitFrom . '-' . $selectedMonth . '-' . $selectedYear));
                    }

                    $dateFrom = date($selectedYear . '-' . $selectedMonth . '-' . $dateLimitFrom, strtotime($dateFrom));
                    $dateTo = date($selectedYear . '-' . $selectedMonth . '-' . $lastday, strtotime($dateTo));
                    //print $dateFrom.' '.$dateTo.'<br>';

                    //sold products
                    $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count(); 
                    $producQuantity = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 2)
                    ->count(); 
                    $customers = DB::table('users')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count(); 

                    $saleData[$i]['date'] = date('M Y', strtotime($dateFrom));
                    $saleData[$i]['totalSale'] = $totalSale;
                    $saleData[$i]['productQuantity'] = $producQuantity;
                    $saleData[$i]['customers'] = $customers;
                    
                    $selectedMonth++;
                    if ($selectedMonth > 12) {
                        $selectedMonth = '1';
                        $selectedYear++;
                    }
                    $i++;
                }

            } 
            else if ($years >= 1) {

                //print $years.'sadsa';
                if ($months > 0) {
                    $years += 1;
                }

                //print $years;

                $dateLimitFrom = date('d', strtotime($dateFrom));
                $dateLimitTo = date('d', strtotime($dateTo));

                $selectedMonthFrom = date('m', strtotime($dateFrom));
                $selectedMonthTo = date('m', strtotime($dateTo));

                $selectedYearFrom = date('Y', strtotime($dateFrom));
                $selectedYearTo = date('Y', strtotime($dateTo));
                //print $selectedYearFrom.' '.$selectedYearTo;

                $i = 0;
                //for current month
                for ($j = $selectedYearFrom; $j <= $selectedYearTo; $j++) {

                    if ($j == $selectedYearTo) {
                        $selectedYearTo = $selectedYearTo;
                        $dateLimitTo = $dateLimitTo;
                    } else {
                        $selectedMonthTo = 12;
                        $dateLimitTo = 31;
                    }

                    if ($selectedYearFrom == $j) {
                        $selectedMonthFrom = $selectedMonthFrom;
                    } else {
                        $selectedMonthFrom = 1;
                    }

                    //    print $j.'-'.$selectedMonthFrom.'-'.$dateLimitFrom.'<br>';
                    //print $j.'-'.$selectedMonthTo.'-'.$dateLimitTo.'<br>';
                    //$lastday  =  date('t',strtotime($dateLimitFrom.'-'.$selectedMonth.'-'.$selectedYear));

                    $dateFrom = date($j . '-' . $selectedMonthFrom . '-' . $dateLimitFrom, strtotime($dateFrom));
                    $dateTo = date($j . '-' . $selectedMonthTo . '-' . $dateLimitTo, strtotime($dateTo));
                    //    print $dateFrom.' '.$dateTo.'<br>';
                    //print $dateFrom.'<br>';

                    //sold products
                    $totalSale = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 1)
                    ->count(); 
                $producQuantity = DB::table('orders')
                    ->whereBetween('date_purchased', [$dateFrom, $dateTo])
                    ->where('ordered_source', 2)
                    ->count();
                $customers = DB::table('users')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count(); 

                    $saleData[$i]['date'] = date('Y', strtotime($dateFrom));
                    $saleData[$i]['totalSale'] = $totalSale;
                    $saleData[$i]['productQuantity'] = $producQuantity;
                    $saleData[$i]['customers'] = $customers;
                    $i++;
                }

            }
        }
        return $saleData;
    }
    
    public function driversreport(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Drivers Report"));

        $result['reportdata'] = DB::table('users')->where('role_id', '4')->get();

        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.driversreport", $title)->with('result', $result);
    }


    public function driverreportsdetail(Request $request)
    {
        
            $title = array('pageTitle' => Lang::get("labels.Drivers Report Detail"));
    
            $data = DB::table('orders')
                ->join('orders_products', 'orders_products.orders_id', '=', 'orders.orders_id')
                ->leftjoin('orders_status_history', 'orders_status_history.orders_id', '=', 'orders_products.orders_id')
                ->leftjoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->select('orders.*', 'orders_status_history.*', 'orders_products.*', 'orders_status_description.orders_status_name')
                ->where('orders_status_history.orders_status_id', '=', 2)
                ->where('orders_status_description.language_id', '=', 1)
                ->orderby('orders_status_history.date_added', 'DESC')->groupby('orders_status_history.orders_id')
                ->orderby('orders.orders_id', 'DESC')
                ->orwhere('orders_status_history.orders_status_id', '=', 3)
                ->where('orders_status_description.language_id', '=', 1)
                ->orderby('orders_status_history.date_added', 'DESC')->groupby('orders_status_history.orders_id')
                ->orderby('orders.orders_id', 'DESC')
                ->get();
            $totalsale = 0;
            $index = 0;
            $totaladmincommision = 0;
            $totalvendorearning = 0;
            $alldata = array();
            foreach ($data as $content) {
                $content->final_price = $content->products_quantity * $content->final_price;
                $deliveryboy = DB::table('orders_to_delivery_boy')
                    ->leftjoin('users', 'users.id', '=', 'orders_to_delivery_boy.deliveryboy_id')
                    ->select('users.*')
                    ->where('orders_id', $content->orders_id)
                    ->where('orders_to_delivery_boy.deliveryboy_id', $request->id)
                    ->where('is_current', 1)
                    ->first();
                if ($deliveryboy) {
                    array_push($alldata, $content);
                    $totalsale += $content->final_price;
                    $product_price = $content->final_price;
                    
                    $alldata[$index]->deliveryboy_name = $deliveryboy->first_name . ' ' . $deliveryboy->last_name;
                    $alldata[$index]->deliveryboy_id = $deliveryboy->id;
                    $index++;
                }
            }
    
    
        $result['reportdata'] = $alldata;
                 

        $myVar = new SiteSettingController();
        $result['setting'] = $myVar->getSetting();
        $result['commonContent'] = $myVar->Setting->commonContent();

        return view("admin.reports.driverreportsdetail", $title)->with('result', $result);
    }
}
