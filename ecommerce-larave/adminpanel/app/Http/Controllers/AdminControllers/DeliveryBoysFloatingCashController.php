<?php
namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\DeliveryBoys;
use App\Models\Core\DeliveryBoysFloatingCash;
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

class DeliveryBoysFloatingCashController extends Controller
{
    //
    public function __construct(DeliveryBoys $deliveryboys, Setting $setting, DeliveryBoysFloatingCash $DeliveryBoysFloatingCash)
    {
        $this->DeliveryBoys = $deliveryboys;
        $this->Setting = $setting;
        $this->DeliveryBoysFloatingCash = $DeliveryBoysFloatingCash;
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.Floating Cash"));
        $language_id = '1';
        $data = array();
        $deliveryboys = $this->DeliveryBoys->getter();
        $floatingCash = $this->DeliveryBoysFloatingCash->getter();
        $setting = $this->Setting->getSettings();
        $data['setting'] = $setting;
        $data['deliveryboys'] = $deliveryboys;
        $data['floatingcash'] = $floatingCash;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.deliveryboys.floatingcash.index", $title)->with('data', $data)->with('result', $result);
    }

    public function recieved(Request $request)
    {
        $this->DeliveryBoysFloatingCash->recievedpayment($request);
        $messages = Lang::get("labels.Payment has been recieved successfully");
        return redirect()->back()->with('message', $messages);
    }
   
}
