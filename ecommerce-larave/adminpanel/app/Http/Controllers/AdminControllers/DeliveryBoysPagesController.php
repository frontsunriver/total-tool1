<?php

namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\DeliveryboyPages;
use Illuminate\Http\Request;
use Lang;
use App\Models\Core\Setting;
class DeliveryBoysPagesController extends Controller
{
    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    public function pages(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Pages"));
        $result = DeliveryboyPages::pages(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.deliveryboys.index", $title)->with('result', $result);

    }

    public function addpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        $result = DeliveryboyPages::addpage(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.deliveryboys.add", $title)->with('result', $result);

    }

    //addNewPage
    public function addnewpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        DeliveryboyPages::addnewpage($request);
        $message = Lang::get("labels.PageAddedMessage");
        return redirect()->back()->withErrors([$message]);

    }

    //editnew
    public function editpage(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditPage"));
        $result = DeliveryboyPages::editpage($request); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.deliveryboys.edit", $title)->with('result', $result);
    }

    //updatePage
    public function updatepage(Request $request)
    {
        DeliveryboyPages::updatepage($request);
        $message = Lang::get("labels.PageUpdateMessage");
        return redirect()->back()->withErrors([$message]);
    }

    //pageStatus
    public function pageStatus(Request $request)
    {
        DeliveryboyPages::pageStatus($request);
        return redirect()->back()->withErrors([Lang::get("labels.PageStatusMessage")]);
    }

}
