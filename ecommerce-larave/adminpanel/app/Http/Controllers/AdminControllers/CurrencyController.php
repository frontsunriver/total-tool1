<?php

namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\Languages;
use App\Models\Core\Currency;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;


class CurrencyController extends Controller
{
  public function __construct(Currency $currencies, Setting $setting)
  {
    $this->currencies = $currencies;
    $this->Setting = $setting;
  }

  public function display(){
    $title = array('pageTitle' => Lang::get("labels.Currency"));
    $currencies = $this->currencies->paginator();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.currencies.index",$title)->with('result', $result)->with('currencies', $currencies);
  }


  public function filter(Request $request){
    $title = array('pageTitle' => Lang::get("labels.SubCategories"));
    $categories = $this->Categories->filter($request);
    return view("admin.categories.index", $title)->with(['categories'=> $categories, 'name'=> $request->FilterBy, 'param'=> $request->parameter]);
  }

  public function add(Request $request){
    $title = array('pageTitle' => Lang::get("labels.Add Currency"));
    $currencies = DB::table('currency_record')->get();
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.currencies.add",['title' => $title, 'currencies' => $currencies, 'result' => $result]);
  }

  public function insert(Request $request){
    //check already has
    $exist = $this->currencies->checkexist($request);
    if($exist){
      $message = Lang::get("labels.Currency already exist");
      return redirect()->back()->withErrors([$message]);
    }else{
      $this->currencies->insert($request);
      $message = Lang::get("labels.Currency Addded Successfully");
      return redirect()->back()->with('success',$message);
    }
  }

  public function edit($currency_id){
    $title = array('pageTitle' => Lang::get("labels.Edit Currency"));
    $result = array();
    $currencies = DB::table('currency_record')->get();
    $currency = $this->currencies->recordToUpdate($currency_id);
    $result['currency'] = $currency;
    $result['warning'] = 0;
    $result['commonContent'] = $this->Setting->commonContent();
    return view("admin.currencies.edit",['title' => $title,'currencies' => $currencies])->with('result', $result);
   }

   public function warningedit($currency_id){
     $title = array('pageTitle' => Lang::get("labels.Edit Currency"));
     $result = array();
     $currencies = DB::table('currency_record')->get();
     $currency = $this->currencies->recordToUpdate($currency_id);
     $result['currency'] = $currency;
     $result['warning'] = 1;
     $result['commonContent'] = $this->Setting->commonContent();
     return view("admin.currencies.edit",['title' => $title,'currencies' => $currencies])->with('result', $result);
    }

   public function update(Request $request){

    $exist = $this->currencies->checkexistupdate($request);
    if($exist){
      $message = Lang::get("labels.Currency already exist");
      return redirect()->back()->withErrors([$message]);
    }else{
      $id = $this->currencies->updaterecord($request);
      if($id == 0){
        $message = Lang::get("labels.You have orders in your databse with current currency. Are you sure you want to change this currency. If yes then submit form again. This act is tatally your own responsabilty.");
        return redirect('/admin/currencies/edit/warning/'.$request->id)->with('error', $message);
      }
      $message = Lang::get("labels.Currency Edit Successfully");
      return redirect('/admin/currencies/edit/'.$id)->with('success', $message);
    }


    }

    public function delete(Request $request){
      $deletecategory = $this->currencies->deleterecord($request);
      $message = Lang::get("labels.Currency Deleted Successfully");
      return redirect()->back()->withErrors([$message]);
    }
}
