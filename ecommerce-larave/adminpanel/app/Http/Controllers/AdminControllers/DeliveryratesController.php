<?php

namespace App\Http\Controllers\AdminControllers;


use App\Models\Core\Deliveryrates;
use App\Models\Core\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class DeliveryratesController extends Controller
{
    public function __construct(Deliveryrates $deliveryrates,Setting $setting)
    {
        $this->myVarsetting = new SiteSettingController($setting);
        $this->Deliveryrates = $deliveryrates;
        $this->Setting = $setting;
    }

    public function display(){
      $title = array('pageTitle' => Lang::get("labels.Deliveryrates"));
      $deliveryrates = $this->Deliveryrates->paginator();
      $result['commonContent'] = $this->Setting->commonContent();
      return view("admin.deliveryrates.index",$title)->with('data', $deliveryrates)->with('result', $result);
    }

    public function add(Request $request){
      $title = array('pageTitle' => Lang::get("labels.AddDeliveryrates"));
      $result = array();
      $result['message'] = array();
      $result['languages'] = $this->myVarsetting->getLanguages();
      $result['zones'] = $this->Deliveryrates->Zones();
      $result['commonContent'] = $this->Setting->commonContent();
      return view("admin.deliveryrates.add",$title)->with('result', $result);
    }

    public function insert(Request $request){
      $this->Deliveryrates->insert($request);
      $message = Lang::get("labels.Record has been added successfully`");
      return redirect()->back()->withErrors([$message]);
    }

    public function edit(Request $request){
      $title = array('pageTitle' => Lang::get("labels.EdiDeliveryrates"));

      $result = array();
      $result['message'] = array();
      $result['languages'] = $this->myVarsetting->getLanguages();
      $result['deliveryrates'] = $this->Deliveryrates->edit($request);
      $result['zones'] = $this->Deliveryrates->Zones();
      $result['commonContent'] = $this->Setting->commonContent();
      return view("admin.deliveryrates.edit",$title)->with('result', $result);
    }

    public function update(Request $request){
      $this->Deliveryrates->updaterecord($request);
      $message = Lang::get("labels.Record has been updated successfully");
      return redirect()->back()->withErrors([$message]);
    }


    public function delete(Request $request){
      $this->Deliveryrates->destroyrecord($request);
      return redirect()->back()->withErrors([Lang::get("labels.Record has been deleted successfully")]);
    }

    public function filter(Request $request){
        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.Deliveryrates"));
        $deliveryrates = $this->Deliveryrates->filter($name,$param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryrates.index",$title)->with('result', $result)->with('data', $deliveryrates)->with('name', $name)->with('parameter', $param);

    }

}
