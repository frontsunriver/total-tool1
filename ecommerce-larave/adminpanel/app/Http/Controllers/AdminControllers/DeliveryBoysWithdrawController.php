<?php
namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\DeliveryBoys;
use App\Models\Core\DeliveryBoysWithdraw;
use App\Models\Core\Images;
use App\Models\Core\Setting;
use App\Models\Core\Languages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Kyslik\ColumnSortable\Sortable;

class DeliveryBoysWithdrawController extends Controller
{
    //
    public function __construct(DeliveryBoys $deliveryboys, Setting $setting, DeliveryBoysWithdraw $deliveryboyswithdraw)
    {
        $this->DeliveryBoys = $deliveryboys;
        $this->Setting = $setting;
        $this->DeliveryBoysWithdraw = $deliveryboyswithdraw;
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.Withdraw"));
        $language_id = '1';
        $data = array();
        $deliveryboys = $this->DeliveryBoys->getter();
        $withdraw = $this->DeliveryBoysWithdraw->paginator();
        $setting = $this->Setting->getSettings();
        $data['setting'] = $setting;
        $data['deliveryboys'] = $deliveryboys;
        $data['withdraw'] = $withdraw;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.deliveryboys.withdraw.index", $title)->with('data', $data)->with('result', $result);
    }

    public function paidpopupdetail(Request $request)
    {
        $data = array();
        $data['deliveryboys'] = $this->DeliveryBoysWithdraw->bankdetail($request);
        $data['withdraw'] = $this->DeliveryBoysWithdraw->withdrawdetail($request);
        $data['setting']  = $this->Setting->getSettings();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.withdraw.paidpopupdetail")->with('data', $data)->with('result', $result);
    }

    public function popupdetail(Request $request)
    {
        $data = array();
        $data['deliveryboys'] = $this->DeliveryBoysWithdraw->bankdetail($request);
        $data['withdraw'] = $this->DeliveryBoysWithdraw->withdrawdetail($request);
        $data['setting']  = $this->Setting->getSettings();
        //dd($data['deliveryboys']);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.withdraw.popupdetail")->with('data', $data)->with('result', $result);
    }

    public function pay(Request $request)
    {
        $this->DeliveryBoysWithdraw->pay($request);
        $messages = Lang::get("labels.Payment Status has been changed.");
        return redirect()->back()->with('message', $messages);
    }
   
}
