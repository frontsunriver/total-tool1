<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Language;
use App\Models\Core\DeliveryBoysStatus;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;


class DeliveryBoysStatusController extends Controller
{

    public function __construct(DeliveryBoysStatus $deliveryBoysStatus)
    {
        $setting = new Setting();
        $this->Setting = $setting;
        $this->DeliveryBoysStatus = $deliveryBoysStatus;

    }

    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Status"));
        $result = array();
        $orders_status = $this->DeliveryBoysStatus->orderstatuses();
        $result['orders_status'] = $orders_status;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.status.index", $title)->with('result', $result);
    }


    public function edit(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditStatus"));
        $result = array();
        $result = $this->DeliveryBoysStatus->editorderstatus($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.status.edit", $title)->with('result', $result);
    }

    public function update(Request $request)
    {
        $languages = $this->Setting->fetchLanguages();
       
        foreach ($languages as $languages_data) {

            $OrdersStatus = 'OrdersStatus_' . $languages_data->languages_id;
            $language_id = $languages_data->languages_id;
            $req_OrdersStatus = $request->$OrdersStatus;

            //check if exist record
            $check = $this->Setting->existOrderStatus($request->id, $language_id);
            if ($check) {
                $this->Setting->updateorderstatus($request, $language_id, $req_OrdersStatus);
            } else {
                $this->Setting->orderstatusadd($request->id, $req_OrdersStatus, $language_id);
            }
        }

        $message = Lang::get("labels.Record has been updated successfully");
        return redirect()->back()->withErrors([$message]);
    }

    public function delete(Request $request)
    {
        $this->DeliveryBoysStatus->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.Record has been deleted successfully")]);
    }

    public function add(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddStatus"));
        $result = array();

        $languages = $this->Setting->fetchLanguages();
        $result['languages'] = $languages;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.deliveryboys.status.add", $title)->with('result', $result);
    }

    public function addNew(Request $request)
    {
        $languagesdata = $this->Setting->fetchLanguages();

        //total records
        $orders_status = $this->DeliveryBoysStatus->addnew();
        $orders_status_id = $orders_status->orders_status_id + 1;
        $role_id = $request->role_id;

        if ($request->public_flag == 1) {
            $languages = $this->DeliveryBoysStatus->addflagorderstatus();
        }

        $statuse_id = $this->DeliveryBoysStatus->getorderstatusid($orders_status_id, $request);

        foreach ($languagesdata as $languages_data) {
            $OrdersStatus = 'OrdersStatus_' . $languages_data->languages_id;
            $language_id = $languages_data->languages_id;
            $req_OrdersStatus = $request->$OrdersStatus;
            $statusedec_id = $this->DeliveryBoysStatus->statusadd($statuse_id, $req_OrdersStatus, $language_id);
        }

        $message = Lang::get("labels.Record has been added successfully");
        return redirect()->back()->withErrors([$message]);
    }

}
