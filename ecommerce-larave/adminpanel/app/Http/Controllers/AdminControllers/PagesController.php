<?php

namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\Pages;
use Illuminate\Http\Request;
use Lang;
use App\Models\Core\Setting;
class PagesController extends Controller
{
    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    public function pages(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Pages"));
        $result = Pages::pages(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.index", $title)->with('result', $result);

    }

    public function addpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        $result = Pages::addpage(); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.add", $title)->with('result', $result);

    }

    //addNewPage
    public function addnewpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        Pages::addnewpage($request);
        $message = Lang::get("labels.PageAddedMessage");
        return redirect()->back()->withErrors([$message]);

    }

    //editnew
    public function editpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditPage"));
        $result = Pages::editpage($request); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.edit", $title)->with('result', $result);

    }

    //updatePage
    public function updatepage(Request $request)
    {

        Pages::updatepage($request);
        $message = Lang::get("labels.PageUpdateMessage");
        return redirect()->back()->withErrors([$message]);

    }

    //pageStatus
    public function pageStatus(Request $request)
    {

        Pages::pageStatus($request);
        return redirect()->back()->withErrors([Lang::get("labels.PageStatusMessage")]);

    }

    //listing web pages
    public function webpages(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.Pages"));
        $result = Pages::webpages($request); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.webpages.index", $title)->with('result', $result);

    }

    public function addwebpage(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        $result = Pages::addwebpage($request); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.webpages.add", $title)->with('result', $result);

    }

    //addNewPage
    public function addnewwebpage(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddPage"));
        Pages::addnewwebpage($request);
        $message = Lang::get("labels.PageAddedMessage");
        return redirect()->back()->withErrors([$message]);
    }

    //editnew
    public function editwebpage(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditPage"));
        $result = Pages::editwebpage($request); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.pages.webpages.edit", $title)->with('result', $result);
    }

    //updatePage
    public function updatewebpage(Request $request)
    {
        Pages::updatewebpage($request);
        $message = Lang::get("labels.PageUpdateMessage");
        return redirect()->back()->withErrors([$message]);
    }

    //pageStatus
    public function pageWebStatus(Request $request)
    {
        Pages::pageWebStatus($request);
        return redirect()->back()->withErrors([Lang::get("labels.PageStatusMessage")]);
    }

}
