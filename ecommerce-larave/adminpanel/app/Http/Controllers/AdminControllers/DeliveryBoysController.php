<?php
namespace App\Http\Controllers\AdminControllers;

use App\Models\Core\DeliveryBoys;
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

class DeliveryBoysController extends Controller
{
    //
    public function __construct(DeliveryBoys $deliveryboy, Setting $setting)
    {
        $this->DeliveryBoys = $deliveryboy;
        $this->Setting = $setting;
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.ListingVendors"));
        $language_id = '1';

        $deliveryboys = $this->DeliveryBoys->paginator();
        $result = array();
        $index = 0;
        foreach($deliveryboys as $deliveryboy_data){
            array_push($result, $deliveryboy_data);

            $devices = DB::table('devices')->where('user_id','=',$deliveryboy_data->id)->orderBy('created_at','DESC')->take(1)->get();
            $result[$index]->devices = $devices;
            $index++;
        }

        $data = array();
        $message = array();
        $errorMessage = array();

        $data['message'] = $message;
        $data['errorMessage'] = $errorMessage;
        $data['deliveryboys'] = $deliveryboys;
        $data['statuses'] = $this->Setting->orderStatusesByDeliveryboys();

        //update new vendors 
        $this->DeliveryBoys->updatenewuser();  
        
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.index", $title)->with('data', $data)->with('result', $result);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddCustomer"));
        $images = new Images;
        $allimage = $images->getimages();
        $language_id = '1';
        $customerData = array();
        $message = array();
        $errorMessage = array();

        $setting = $this->Setting->getSettings();
        $customerData['setting'] = $setting;

        $customerData['countries'] = $this->DeliveryBoys->countries();
        $customerData['message'] = $message;
        $customerData['statuses'] = $this->Setting->orderStatusesByDeliveryboys();
        $customerData['errorMessage'] = $errorMessage;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.add", $title)->with('data', $customerData)->with('allimage',$allimage)->with('result', $result);
    }


    //add addcustomers data and redirect to address
    public function insert(Request $request)
    {
        //get function from other controller
        $images = new Images;
        $allimage = $images->getimages();

        $customerData = array();
        $message = array();
        $errorMessage = array();
        
        //check email already exists
        $existEmail = $this->DeliveryBoys->email($request);
        $pincode = $this->DeliveryBoys->pincode($request);
        if (count($existEmail)> 0 ) {
            $messages = Lang::get("labels.Email address already exist");
            return Redirect::back()->withErrors($messages)->withInput($request->all());
        } else if(count($pincode)> 0){
            $messages = Lang::get("labels.Pincode already exist");
           return Redirect::back()->withErrors($messages)->withInput($request->all());
        }else{
            $deliveryboy_id = $this->DeliveryBoys->insert($request);
            $messages = Lang::get("labels.Delivery boy has been created successfully");
            return redirect()->back()->with('message', $messages);
        }
    }

    public function edit(Request $request){

      $images           =   new Images;
      $allimage         =   $images->getimages();
      $title            =   array('pageTitle' => Lang::get("labels.EditCustomer"));
      $language_id      =   '1';
      $id               =   $request->id;

      $data = array();
      $message = array();
      $errorMessage = array();

      $data['message'] = $message;
      $data['errorMessage'] = $errorMessage;
      $data['countries'] = $this->DeliveryBoys->countries();
      $deliveryboy = $this->DeliveryBoys->edit($id);
      $data['deliveryboy'] = $deliveryboy;

      $zones = $this->DeliveryBoys->zones($deliveryboy);
      $data['zones'] = $zones;

      $setting = $this->Setting->getSettings();
      $data['setting'] = $setting;
      $data['statuses'] = $this->Setting->orderStatusesByDeliveryboys();
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.deliveryboys.edit",$title)->with('data', $data)->with('allimage', $allimage)->with('result', $result);
    }

    //add addcustomers data and redirect to address
    public function update(Request $request){
        $language_id  =   '1';
        $user_id				  =	$request->user_id;

        $customerData = array();
        $message = array();
        $errorMessage = array();

        //get function from other controller
        if($request->image_id!==null){
            $deliveryboy_picture = $request->image_id;
        }	else{
            $deliveryboy_picture = $request->oldImage;
        }

        if($request->image_id){
            $uploadImage = $request->image_id;
            $uploadImage = DB::table('image_categories')->where('image_id',$uploadImage)->select('path')->first();
            $deliveryboy_picture = $uploadImage->path;
        }	else{
            $deliveryboy_picture = $request->oldImage;
        }


        if($request->changePassword == 'yes'){
            $customer_data['password'] = Hash::make($request->password);
        }

        
        $pincodeExist = $this->DeliveryBoys->extendPincode($request);
        
        if($pincodeExist){
            $messages = Lang::get("labels.Pincode already exist");
            return Redirect::back()->withErrors($messages)->withInput($request->all());
        }else{
                    
            //check email already exists
            if($request->old_email_address!=$request->email){
                $existEmail = $this->DeliveryBoys->extendemail($request);
                if(count($existEmail)>0){
                    $messages = Lang::get("labels.Email address already exist");
                    return Redirect::back()->withErrors($messages)->withInput($request->all());
                }else{
                $messages = Lang::get("labels.Deliveryboy has been update successfully");
                $this->DeliveryBoys->updaterecord($request);
                return redirect('admin/deliveryboys/edit/'.$user_id);
                }
            }else{
                $this->DeliveryBoys->updaterecord($request);
                $messages = Lang::get("labels.Deliveryboy has been update successfully");
                return redirect('admin/deliveryboys/edit/'.$user_id)->with('message', $messages);
            }
        }
    }

    public function delete(Request $request){
      $this->DeliveryBoys->destroyrecord($request->users_id);
      return redirect()->back()->withErrors([Lang::get("labels.Record has been deleted successfully")]);
    }

    public function filter(Request $request){
      $filter    = $request->FilterBy;
      $parameter = $request->parameter;

      $title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
      $deliveryboy  = $this->DeliveryBoys->filter($request);

      $result = array();
      $index = 0;
      foreach($deliveryboy as $deliveryboy_data){
          array_push($result, $deliveryboy_data);

          $devices = DB::table('devices')->where('user_id','=',$deliveryboy_data->id)->orderBy('created_at','DESC')->take(1)->get();
          $result[$index]->devices = $devices;
          $index++;
      }

      $data = array();
      $message = array();
      $errorMessage = array();

      $data['message'] = $message;
      $data['errorMessage'] = $errorMessage;
      $data['deliveryboys'] = $deliveryboy;
      $result['commonContent'] = $this->Setting->commonContent();

      return view("admin.deliveryboys.index",$title)->with('data', $data)->with('filter',$filter)->with('parameter',$parameter)->with('result', $result);
    }

    public function ratings(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Rating / Reviews"));
        $result = array();
        $result['averagerating'] = $this->DeliveryBoys->averagerating($request); 
        $result['indvidualratings'] = $this->DeliveryBoys->indvidualratings($request); 
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.deliveryboys.ratings", $title)->with('result', $result);
    }

    public function latlong(Request $request)
    {
        $deliveryboys = $this->DeliveryBoys->eagleviewfilters($request);
        $results = array();
        $index = 0;
        foreach($deliveryboys as $data){
            $results[$index]['lat'] = $data->entry_latitude;
            $results[$index++]['long'] = $data->entry_longitude;
        }

        return $results;
    }

    public function ratingdelete(Request $request)
    {
        $this->DeliveryBoys->ratingdelete($request->id);
        return redirect()->back()->withErrors(['Record has been deleted successfully']);
    }
}
