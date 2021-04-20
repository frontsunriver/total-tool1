<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Languages;
use App\Models\Core\Manufacturers;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class ManufacturerController extends Controller
{

    public function __construct(Manufacturers $manufacturer, Languages $language, Images $images, Setting $setting)
    {
        $this->manufacturers = $manufacturer;
        $this->language = $language;
        $this->images = $images;
        $this->Setting = $setting;
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.Manufacturers"));
        $manufacturers = $this->manufacturers->paginator(20);        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.manufacturers.index")->with('manufacturers', $manufacturers)->with('result', $result);
    }

    public function add(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.AddManufacturer"));
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.manufacturers.add", $title)->with('allimage', $allimage)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddManufacturer"));
        $this->manufacturers->insert($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');
    }

    public function edit(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditManufacturers"));
        $manufacturers_id = $request->id;
        $editManufacturer = $this->manufacturers->edit($manufacturers_id);
        $allimage = $this->images->getimages();        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.manufacturers.edit", $title)->with('result', $result)->with('editManufacturer', $editManufacturer)->with('allimage', $allimage);
    }

    public function update(Request $request)
    {
        $messages = 'update is not successfull';
        $title = array('pageTitle' => Lang::get("labels.EditManufacturers"));
        $this->validate($request, [
            'id' => 'required',
            //'oldImage' => 'required',
            'old_slug' => 'required',
            'slug' => 'required',
            'name' => 'required',
           // 'manufacturers_url' => 'required',

        ]);
        $this->manufacturers->updaterecord($request);
        return redirect()->back()->with('update', 'Content has been created successfully!');

    }

    //delete Manufacturers
    public function delete(Request $request)
    {

        $this->manufacturers->destroyrecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.manufacturersDeletedMessage")]);
    }

    public function filter(Request $request)
    {

        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.Manufacturers"));
        $manufacturers = $this->manufacturers->filter($name, $param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.manufacturers.index", $title)->with('result', $result)->with('manufacturers', $manufacturers)->with('name', $name)->with('param', $param);
    }

}
