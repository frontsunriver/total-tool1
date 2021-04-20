<?php

namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\Menus;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Categories;
use App\Models\Core\Products;
use Lang;

class MenusController extends Controller
{
	public function __construct(Setting $setting, Categories $categories, Products $products)
    {
        $this->Setting = $setting;
        $this->Categories = $categories;
        $this->Products = $products;
    }

    public function menus(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.menus"));
        $result['menus'] = Menus::menus();  
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.menus.index", $title)->with('result', $result);
    }

    public function addmenus(Request $request)
    {
        $language_id =  1;
        $title = array('pageTitle' => Lang::get("labels.addmenus"));
        $result = Menus::addmenus();          
        $result['categories'] = $this->Categories->getterParent($language_id);
        $result['products'] = $this->Products->getter($language_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.menus.add", $title)->with('result', $result);
    }

    //addNewPage
    public function addnewmenu(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddMenu"));
        Menus::addnewmenu($request);  
        $result['commonContent'] = $this->Setting->commonContent();
        $message = Lang::get("labels.MenuAddedMessage");
        return redirect()->back()->withErrors([$message]);
    }

    //editnew
    public function editmenu(Request $request, $id)
    {
        $language_id =  1;
        $title = array('pageTitle' => Lang::get("labels.EditPage"));
        $result = Menus::editmenu($id);  
        $result['categories'] = $this->Categories->getterParent($language_id);
        $result['products'] = $this->Products->getter($language_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.menus.edit", $title)->with('result', $result);
    }

    //updatePage
    public function updatemenu(Request $request)
    {
        Menus::updatemenu($request);
        $message = Lang::get("labels.MenuUpdateMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public function deletemenu(Request $request)
    {
        Menus::deletemenu($request->id);
        $message = Lang::get("labels.MenuDeleteMessage");
        return redirect()->back()->withErrors([$message]);
    }
    
    public function menuposition(Request $request)
    {
        Menus::savePosition($request);
    }

    public function catalogmenu()
    {
        Menus::catalogmenu();
        $message = Lang::get("labels.Catalogcreatedsuccessfully");
        return redirect()->back()->withErrors([$message]);
    }    
    

}
