<?php
namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\DeliveryboyFinance;
use App\Models\Core\DeliveryBoys;
use App\Models\Core\DeliveryBoysWithdraw;

//for password encryption or hash protected
use App\Models\Core\Setting;
use Auth;

//for authenitcate login data
use Illuminate\Http\Request;

//for requesting a value
use Lang;

class DeliveryboyFinanceController extends Controller
{
    public function __construct(DeliveryboyFinance $deliveryboyFinance, Setting $setting, DeliveryBoys $deliveryboys, DeliveryboysWithdraw $deliveryboysWithdraw)
    {
        $this->DeliveryboyFinance = $deliveryboyFinance;
        $this->Setting = $setting;
        $this->DeliveryBoys = $deliveryboys;
        $this->DeliveryBoysWithdraw = $deliveryboysWithdraw;
    }

    // public function display(Request $request)
    // {
    //     $title = array('pageTitle' => Lang::get("labels.Earnings Report"));
        
    //     $monthlyearnings = $this->DeliveryboyFinance->monthlyearnings();
    //     $result['monthlyearnings'] = $monthlyearnings;
        
    //     $sevendaysearnings = $this->DeliveryboyFinance->sevendaysearnings();
    //     $result['sevendaysearnings'] = $sevendaysearnings;       
        
    //     $todaysearnings = $this->DeliveryboyFinance->todaysearnings();
    //     $result['todaysearnings'] = $todaysearnings;

    //     $setting = $this->Setting->getSettings();
    //     $result['setting'] = $setting;

    //     return view("admin.finance.display", $title)->with('result', $result);
    // }

    // public function earningsbymonth(Request $request)
    // {
    //     $title = array('pageTitle' => Lang::get("labels.Earnings Report"));
    //     $result['month'] = $request->month;   
        
    //     $earningsbymonth = $this->DeliveryboyFinance->earningsbymonth($request);
    //     $result['earningsbymonth'] = $earningsbymonth;    

    //     $setting = $this->Setting->getSettings();
    //     $result['setting'] = $setting;

    //     return view("admin.deliveryboys.finance.month", $title)->with('result', $result);
    // }

    // public function earningsbymonthvendor(Request $request)
    // {
    //     $title = array('pageTitle' => Lang::get("labels.Earnings Report"));
    //     $result['month'] = $request->month;   
        
    //     $earningsbymonthvendor = $this->DeliveryboyFinance->earningsbymonthvendor($request);
    //     $result['earningsbymonthvendor'] = $earningsbymonthvendor;      

    //     $setting = $this->Setting->getSettings();
    //     $result['setting'] = $setting;

    //     return view("admin.finance.month", $title)->with('result', $result);
    // }

    // public function earningsbymonthvendor(Request $request)
    // {
    //     $title = array('pageTitle' => Lang::get("labels.Earnings Report"));
    //     $result['month'] = $request->month;   
        
    //     $earningsbymonth = $this->DeliveryboyFinance->earningsbymonthvendor($request);
    //     $result['earningsbymonth'] = $earningsbymonth;    

    //     $setting = $this->Setting->getSettings();
    //     $result['setting'] = $setting;

    //     return view("admin.finance.vendorbymonth", $title)->with('result', $result);
    // }
    
    public function deliveryboysattlement(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Earnings Report"));
        $result['month'] = $request->month;   
        
        $deliveryboy = $this->DeliveryBoys->deliveryBoyById($request);
       //dd($deliveryboy);
        $result['deliveryboy'] = $deliveryboy;  

        $rating = $this->DeliveryBoys->indvidualratings($deliveryboy);
        $result['rating'] = $rating;  

        $earningsbyweek = $this->DeliveryboyFinance->deliveryboyweekearnings($request);
        $result['earningsbyweek'] = $earningsbyweek;   
        
        $deliveryboytodayearnings = $this->DeliveryboyFinance->deliveryboytodayearnings($request);
        $result['todayearnings'] = $deliveryboytodayearnings;   
        
        $earningsbymonth = $this->DeliveryboyFinance->earningsbymonth($request);
        $result['earningsbymonth'] = $earningsbymonth;      
        
        // $setting = $this->Setting->getSettings();
        // $result['setting'] = $setting;

        $withdraw = $this->DeliveryBoysWithdraw->withdrawbyid($deliveryboy->id);
        $result['withdraw'] = $withdraw; 

       // dd($result['earningsbyweek']);
        $result['commonContent'] = $this->Setting->commonContent();
        
        return view("admin.deliveryboys.finance.deliveryboysattlement", $title)->with('result', $result);
    }

    
    public function orders(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Earnings Report"));
        $result['month'] = $request->month;   
        
        $earningsbymonth = $this->DeliveryboyFinance->orders($request);
        $result['earningsbymonth'] = $earningsbymonth;    

        $setting = $this->Setting->getSettings();
        $result['setting'] = $setting;
        //dd($result['earningsbymonth']);

        return view("admin.finance.orders", $title)->with('result', $result);
    }

    

}
