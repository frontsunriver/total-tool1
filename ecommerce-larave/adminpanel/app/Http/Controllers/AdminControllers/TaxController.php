<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Countries;
use App\Models\Core\Tax_class;
use App\Models\Core\Tax_rate;
use App\Models\Core\Zones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use App\Models\Core\Setting;

class TaxController extends Controller
{
    public function __construct(Countries $countries,Zones $zones,Tax_class $tax_class,Tax_rate $tax_rate, Setting $setting)
    {
        $this->Countries = $countries;
        $this->Zones = $zones;
        $this->Tax_class = $tax_class;
        $this->Tax_rate = $tax_rate;
        $this->Setting = $setting;
    }

    public function taxindex(Request $request){
        $title = array('pageTitle' => Lang::get("labels.ListingTaxClasses"));
        $tax_class = $this->Tax_class->paginator();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxclass.index", $title)->with('result', $result)->with('tax_class', $tax_class);
    }

    public function addtaxclass(Request $request){
        $title = array('pageTitle' => Lang::get("labels.AddTaxClass"));
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxclass.add", $title)->with('result', $result);
    }

    public function inserttaxclass(Request $request){
       $this->Tax_class->insert($request);
       $message = Lang::get("labels.TaxClassAddedTax");
       return redirect()->back()->withErrors([$message]);
    }

    public function edittaxclass(Request $request){
        $title = array('pageTitle' => Lang::get("labels.EditCountry"));
        $taxClass = $this->Tax_class->edit($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxclass.edit",$title)->with('result', $result)->with('taxClass', $taxClass);
    }

    public function updatetaxclass(Request $request){
        $this->Tax_class->updatetrecord($request);
        $message = Lang::get("labels.TaxClassUpdatedTax");
        return redirect()->back()->withErrors([$message]);
    }

    public function deletetaxclass(Request $request){
        $this->Tax_class->deletetaxclass($request);
        return redirect()->back()->withErrors([Lang::get("labels.TaxClassDeletedTax")]);
    }

    public function filtertaxclass(Request $request){
        $title = array('pageTitle' => Lang::get("labels.ListingTaxClasses"));
        $name = $request->FilterBy;
        $param = $request->parameter;
        $tax_class = $this->Tax_class->filter($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxclass.index", $title)->with('result', $result)->with('tax_class', $tax_class)->with('name', $name)->with('param', $param);
    }


    public function displaytaxrates(Request $request){
        $title = array('pageTitle' => Lang::get("labels.ListingTaxRates"));
        $result['tax_rates'] = $this->Tax_rate->pagitnator();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxrate.index", $title)->with('result', $result);
    }

    public function addtaxrate(Request $request){
        $title = array('pageTitle' => Lang::get("labels.AddTaxClass"));

        $result = array();
        $message = array();
        $result['message'] = $message;

        $zones = $this->Zones->getter();
        $tax_class = $this->Tax_class->getter();

        $result['zones'] = $zones;
        $result['tax_class'] = $tax_class;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxrate.add", $title)->with('result', $result);
    }

    public function inserttaxrate(Request $request){
       $this->Tax_rate->insert($request);
        $message = Lang::get("labels.TaxRateAddededTax");
        return redirect()->back()->withErrors([$message]);
    }

    public function edittaxrate(Request $request){
        $title = array('pageTitle' => Lang::get("labels.EditTaxRate"));
        $result = array();
        $result['message'] = array();

        $taxrate = $this->Tax_rate->edit($request);
        $result['taxrate'] = $taxrate;

        $zones = $this->Tax_rate->getZone();
        $tax_class = $this->Tax_class->getter();
        $result['zones'] = $zones;
        $result['tax_class'] = $tax_class;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxrate.edit",$title)->with('result', $result);
    }

    public function updatetaxrate(Request $request){
        $this->Tax_rate->updaterecord($request);
        $message = Lang::get("labels.TaxRateUpdatedTax");
        return redirect()->back()->withErrors([$message]);
    }

    public function deletetaxrate(Request $request){
        $this->Tax_rate->deletetaxrate($request);
        return redirect()->back()->withErrors([Lang::get("labels.TaxRateDeletedTax")]);
    }

    public function filtertaxrates(Request $request){
        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.ListingTaxRates"));
        $result = array();
        $result['tax_rates'] = $this->Tax_rate->filter($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.tax.taxrate.index", $title)->with('result', $result)->with('name', $name)->with('param', $param);

    }

}
