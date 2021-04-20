<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Categories;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Manufacturers;
use App\Models\Core\Products;
use App\Models\Core\ProductsAttribute;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ProductAttributesController extends Controller
{

    public function __construct(Products $products, ProductsAttribute $productsattribute, Languages $language, Images $images, Categories $category, Setting $setting, Manufacturers $manufacturer)
    {
        $this->category = $category;
        $this->language = $language;
        $this->images = $images;
        $this->manufacturer = $manufacturer;
        $this->products = $products;
        $this->productsattribute = $productsattribute;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myVaralter = new AlertController($setting);
        $this->Setting = $setting;

    }

    public function display(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.attributes"));
        $result = array();
        $result['attributes'] = $this->productsattribute->display($request);
        $result['commonContent'] = $this->Setting->commonContent();        
        return view("admin.products_attributes.index", $title)->with('result', $result);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddOptions"));
        $result = array();
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products_attributes.add", $title)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $this->productsattribute->insert($request);
        return redirect()->back()->withErrors([Lang::get("labels.OptionsAddedMessage")]);
    }

    public function edit(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Manage Options"));
        $result = $this->productsattribute->edit($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products_attributes.edit", $title)->with('result', $result);

    }

    public function update(Request $request)
    {

        $this->productsattribute->updaterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.optionhasbeenupdatedMessage")]);

    }

    public function delete(Request $request)
    {
        $this->productsattribute->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.OptionhasbeendeletedMessage")]);
    }

    public function displayoptionsvalues(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.Manage Values"));
        $data = $this->productsattribute->displayoptionsvalues($request);
        $data['commonContent'] = $this->Setting->commonContent();
        return view("admin.products_attributes.options.index", $title)->with('result', $data);

    }

    public function insertoptionsvalues(Request $request)
    {

        $this->productsattribute->insertoptionsvalues($request);
        return redirect()->back()->withErrors([Lang::get("labels.ValuesAddedMessage")]);
    }

    public function editoptionsvalues(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.Manage Options"));
        $result = $this->productsattribute->editoptionsvalues($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products_attributes.options.edit", $title)->with('result', $result);
    }

    public function updateoptionsvalues(Request $request)
    {

        $this->productsattribute->updateoptionsvalues($request);
        return redirect()->back()->withErrors([Lang::get("labels.valueshasbeenupdatedMessage")]);
    }

    public function deleteoptionsvalues(Request $request)
    {

        $this->productsattribute->deleteoptionsvalues($request);
        return redirect()->back()->withErrors([Lang::get("labels.ValueshasbeendeletedMessage")]);
    }

    public function addattributevalue(Request $request)
    {

        $attributes = $this->productsattribute->addattributevalue($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.products_attributes.options.attributesTable")->with('attributes', $attributes)->with('result', $result);
    }

    public function updateattributevalue(Request $request)
    {

        $attributes = $this->productsattribute->updateattributevalue($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.attributesTable")->with('attributes', $attributes)->with('result', $result);
    }

    public function checkattributeassociate(Request $request)
    {
        $this->productsattribute->checkattributeassociate($request);
    }

    public function checkvalueassociate(Request $request)
    {
        $this->productsattribute->checkvalueassociate($request);
    }

}
