<?php

namespace App\Models\Core;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Core\Zones;
use App\Models\Core\Countries;
use App\Models\Core\Setting;
use App\Models\Core\DeliveryBoysFloatingCash;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class DeliveryBoys extends Model
{
    //
    use Sortable;
    protected $table = 'users';
    public function address_book()
    {
        return $this->belongsTo('App\address_book');
    }

    public function deliveryboy_info()
    {
        return $this->belongsTo('App\deliveryboy_info');
    }

    public function countryrelation()
    {
        return $this->belongsTo('App\Country');
    }

    public function zone()
    {
        return $this->belongsTo('App\Zone');
    }

    public function images()
    {
        return $this->belongsTo('App\Images');
    }

    public $sortableAs = ['entry_street_address','entry_firstname','entry_company'];
    public $sortable = ['id', 'gender', 'first_name','last_name','dob','email','phone','status','created_at','updated_at','entry_street_address'];

    public function getter()
    {
        $user = DeliveryBoys::sortable(['id'=>'ASC'])
            ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
            ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
            ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
            ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
            ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
            ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')
            ->select(
                'users.*',
                'deliveryboy_info.*',
                'deliveryboy_info.users_id as deliveryboy_id',
                'address_book.entry_gender as entry_gender',
                'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname',
                'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address',
                'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode',
                'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state',
                'countries.*',
                'zones.*',
                'bank_detail.*'
            )
            ->where('role_id', '4')
            ->where('is_default', '1')
            ->where('is_current', 1)
            ->get();

            
        return $user;
    }


    public function paginator()
    {
        $users = DeliveryBoys::sortable(['id'=>'ASC'])
            ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
            ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
            ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
            ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
            ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
            ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')
            ->select(
                'users.*',
                'deliveryboy_info.*',
                'deliveryboy_info.users_id as deliveryboy_id',
                'address_book.entry_gender as entry_gender',
                'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname',
                'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address',
                'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode',
                'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state',
                'countries.*',
                'zones.*',
                'bank_detail.*'
            )
            ->where('role_id', '4')
            ->where('is_current', 1)
            ->paginate(10);

            $setting = new Setting();
            $commonsetting = $setting->commonContent();
            
            $floating_cash = new DeliveryBoysFloatingCash();
            $wallet = new DeliveryBoysWithdraw();

            if(!empty($users) and count($users) > 0){

                $index = 0;
                $cash = 0;
                $wallet_amount = 0;
                foreach($users as $user){                    
                    $cash = $floating_cash->floatingCashAmountById($user->id);   
                    $wallet_amount = $wallet->withdrawAmountById($user->id);   

                    $users[$index]->floating_cash = $commonsetting['currency']->symbol_left.$cash.$commonsetting['currency']->symbol_right; 
                    $users[$index]->wallet_amount = $commonsetting['currency']->symbol_left.$wallet_amount.$commonsetting['currency']->symbol_right; 
                    $index++;
                }        
            }

        return $users;
    }

    public function deliveryBoyById($request)
    {
        //dd($request->all());
        $user = DeliveryBoys::sortable(['id'=>'ASC'])
            ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
            ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
            ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
            ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
            ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
            ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')
            ->select(
                'users.*',
                'deliveryboy_info.*',
                'deliveryboy_info.users_id as deliveryboy_id',
                'address_book.entry_gender as entry_gender',
                'address_book.entry_company as entry_company',
                'address_book.entry_firstname as entry_firstname',
                'address_book.entry_lastname as entry_lastname',
                'address_book.entry_street_address as entry_street_address',
                'address_book.entry_suburb as entry_suburb',
                'address_book.entry_postcode as entry_postcode',
                'address_book.entry_city as entry_city',
                'address_book.entry_state as entry_state',
                'countries.*',
                'zones.*',
                'bank_detail.*'
            )
            ->where('role_id', '4')
            ->where('users.id', $request->deliveryboys_id)            
            ->where('is_current', 1)
            ->groupby('users.id')
            ->first();
        
       
        return $user;
    }

    public function email($request)
    {
        $existEmail = DB::table('users')->where('email', '=', $request->email)->where('role_id', '=', 4)->get();
        return $existEmail;
    }

    public function pincode($request)
    {
        $exist = DB::table('users')->where('password', '=', $request->password)->where('role_id', '=', 4)->get();
        return $exist;
    }

    public function extendPincode($request)
    {
        $exist = DB::table('users')
                    ->where('password', '=', $request->password)
                    ->where('id', '!=', $request->user_id)->first();
        return $exist;
    }

    

    public function updatenewuser()
    {
        DB::table('users')->where('role_id', '=', 4)->update([
            'is_seen'		 	=>   1
        ]);
    }
    public function insert($request)
    {
        if ($request['image_id']) {
            $uploadImage = $request['image_id'];
            $uploadImage = DB::table('image_categories')->where('image_id', $uploadImage)->select('path')->first();
            $uploadImage = $uploadImage->path;
        } else {
            $uploadImage = $request['oldImage'];
        }

        $date = str_replace('/', '-', $request->dob);
        $dob_date = date("Y-m-d", strtotime($date) );
        

        $user_id = DB::table('users')->insertGetId([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $dob_date,
            'gender' => 0,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'password' => $request->password,
            'status' => $request->status,
            'avatar' => $uploadImage,
            'created_at' => date('Y-m-d H:i:s'),
            'role_id'    => '4'
        ]);



        if ($request->driving_license_image !== null) {
            $driving_license_image = $request->driving_license_image;
        } else {
            $driving_license_image = '';
        }

        if ($request->vehicle_rc_book_image !== null) {
            $vehicle_rc_book_image = $request->vehicle_rc_book_image;
        } else {
            $vehicle_rc_book_image = '';
        }


        DB::table('deliveryboy_info')->insertGetId([
              'users_id'              =>   $user_id,
              'blood_group'		        =>   $request->blood_group,
              'bike_name'           	=>   $request->bike_name,
              'bike_details'	 		  	=>	 addslashes($request->bike_details),
              'bike_color'	 	      =>   $request->bike_color,
              'owner_name'	 		    =>	 $request->owner_name,

              'vehicle_registration_number'  =>   $request->vehicle_registration_number,

              'driving_license_image'   =>  $driving_license_image,

              'vehicle_rc_book_image'   =>  $vehicle_rc_book_image,
              'availability_status' => $request->availability_status,
              'commission'=>$request->commission
        ]);
            
        ///////// To get longitude and latitude //////////////
        $zones =  DB::table('zones')->where('zone_id', $request->state_id)->first();
        $countries =  DB::table('countries')->where('countries_id', $request->country_id)->first();
        $state = $zones->zone_name;
        $country = $countries->countries_name;
            
        $cordinates_address = urlencode($request->address.' '.$request->city.' '.$state. ' '. $request->zip. ' '.$country);
            
        $setting = new Setting();
        $getSettings = $setting->getSettings();
    
        $latitude = '';
        $longitude = '';
        // if ($getSettings[125]->value = 1 and !empty($getSettings[103]->value)) {
        //     $google_map_api	  =  $getSettings[103]->value;
        //     $cordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key='.$google_map_api.'&address='.$cordinates_address);
                
        //     $cordinates = json_decode($cordinates);
                
        //     if ($cordinates->status=="OK") {
        //         $latitude = $cordinates->results[0]->geometry->location->lat;
        //         $longitude = $cordinates->results[0]->geometry->location->lng;
        //     }
        // }

        $address_book_id = DB::table('address_book')->insertGetId([
                'entry_gender'		  	    =>   1,
                'entry_company'		 	    =>   '',
                'entry_firstname'	 	    =>	 $request->first_name,
                'entry_lastname'   	  	    =>   $request->last_name,
                'entry_street_address'	    =>   $request->address,
                'entry_suburb' 			    =>   '',
                'entry_postcode'	   	    =>	 $request->zip,
                'entry_city'   		        =>   $request->city,
                'entry_state'		 	    =>   $request->state_id,
                'entry_country_id'		    =>   $request->country_id,
                'entry_zone_id'	 		    =>	 $request->state_id,
                'entry_latitude'            =>   $latitude,
                'entry_longitude'           =>   $longitude,
            ]);

        $address_id = DB::table('user_to_address')->insertGetId([
                'user_id'   		    =>   $user_id,
                'address_book_id'		=>   $address_book_id,
                'is_default'		 	  =>   1,
            ]);

        DB::table('bank_detail')
                ->insert([
                'bank_name'=>$request->bank_name,
                'bank_account_number'=>$request->bank_account_number,
                'bank_routing_number'=>$request->bank_routing_number,
                'bank_address'=>$request->bank_address,
                'bank_iban'=>$request->bank_iban,
                'bank_swift'=>$request->bank_swift,
                'is_current'=>1,
                'users_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

        return $user_id;
    }

    public function addresses($id)
    {
        $addresses = DB::table('user_to_address')
            ->leftjoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
            ->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
            ->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
            ->where('user_to_address.user_id', '=', $id)->get();
        return $addresses;
    }

    public function country()
    {
        $countries = DB::table('countries')->get();
        return $countries;
    }

    public function addressBook($address_book_id)
    {
        $customer_addresses = DB::table('address_book')
            ->leftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
            ->leftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
            ->where('address_book_id', '=', $address_book_id)->get();
        return $customer_addresses;
    }

    public function countries()
    {
        $countries = DB::table('countries')->get();
        return $countries;
    }

    public function zones($zones)
    {
        $zones = DB::table('zones')->where('zone_country_id', '=', $zones->countries_id)->get();
        return $zones;
    }


    public function edit($id)
    {
        DB::table('users')->where('id', '=', $id)->update(['is_seen' => 1 ]);

        $deliveryboy = DB::table('users')
              ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
              ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
              ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
              ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
              ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
              ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')

              ->leftJoin('image_categories as license_image_table', 'license_image_table.image_id', '=', 'deliveryboy_info.driving_license_image')
              ->leftJoin('image_categories as vehicle_rc_book_image_table', 'vehicle_rc_book_image_table.image_id', '=', 'deliveryboy_info.vehicle_rc_book_image')

     
              ->leftJoin('images', 'images.id', '=', 'users.avatar')
              ->leftJoin('image_categories', 'image_categories.image_id', '=', 'users.avatar')
              ->select(
                  'users.*',
                  'deliveryboy_info.*',
                  'deliveryboy_info.users_id as deliveryboy_id',
                  'address_book.entry_street_address as entry_street_address',
                  'address_book.entry_suburb as entry_suburb',
                  'address_book.entry_postcode as entry_postcode',
                  'address_book.entry_city as entry_city',
                  'address_book.entry_state as entry_state',
                  'countries.*',
                  'zones.*',
                  'license_image_table.path as driving_license_image',
                  'license_image_table.image_id as driving_license_image_id',
                  'vehicle_rc_book_image_table.path as vehicle_rc_book_image',
                  'vehicle_rc_book_image_table.image_id as vehicle_rc_book_image_id',
                  'bank_detail.*'
              )
              ->where('users.role_id', '=', '4')
              ->where(function ($query) {
                  $query->where('license_image_table.image_type', '=', 'THUMBNAIL')
                      ->where('license_image_table.image_type', '!=', 'THUMBNAIL')
                      ->orWhere('license_image_table.image_type', '=', 'ACTUAL');
              })
                ->where(function ($query) {
                    $query->where('vehicle_rc_book_image_table.image_type', '=', 'THUMBNAIL')
                        ->where('vehicle_rc_book_image_table.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('vehicle_rc_book_image_table.image_type', '=', 'ACTUAL');
                })
               
               
              ->where('is_default', '1')
              ->where('users.id', '=', $id)
              ->groupby('users.id')->first();

        if($deliveryboy->dob){
          $date = $deliveryboy->dob;
          $date = date("d/m/Y", strtotime($date) );

          $deliveryboy->dob = $date;
        }


        return $deliveryboy;
    }

    public function updaterecord($request)
    {
        if ($request['image_id']) {
            $uploadImage = $request['image_id'];
            $uploadImage = DB::table('image_categories')->where('image_id', $uploadImage)->select('path')->first();
            $uploadImage = $uploadImage->path;
        } else {
            $uploadImage = $request['old_avatar'];
        }
        $user_id = $request['user_id'];

        $date = str_replace('/', '-', $request->dob);
        $dob_date = date("Y-m-d", strtotime($date) );

        DB::table('users')->where('id', $user_id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $dob_date,
            'gender' => 0,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'phone' => $request->phone,
            'password' => $request->password,
            'status' => $request->status,
            'avatar' => $uploadImage,
            'created_at' => date('Y-m-d H:i:s'),
            'role_id'    => '4'
        ]);

        if ($request->driving_license_image !== null) {
            $driving_license_image = $request->driving_license_image;
        } else {
            $driving_license_image = $request->old_driving_license_image;
        }

        if ($request->vehicle_rc_book_image !== null) {
            $vehicle_rc_book_image = $request->vehicle_rc_book_image;
        } else {
            $vehicle_rc_book_image = $request->old_vehicle_rc_book_image;
        }

        DB::table('deliveryboy_info')->where('users_id', $user_id)->update([
              'blood_group'		        =>   $request->blood_group,
              'bike_name'           	=>   $request->bike_name,
              'bike_details'	 		  	=>	 addslashes($request->bike_details),
              'bike_color'	 	      =>   $request->bike_color,
              'owner_name'	 		    =>	 $request->owner_name,
              'vehicle_registration_number'  =>   $request->vehicle_registration_number,
              'driving_license_image'   =>  $driving_license_image,
              'vehicle_rc_book_image'   =>  $vehicle_rc_book_image,
              'availability_status' => $request->availability_status,
              'commission'=>$request->commission
            ]);

        $address_id = DB::table('user_to_address')->where([
                ['user_id'   		    =>   $user_id],
                ['is_default'		 	  =>   1],
            ]);


        ///////// To get longitude and latitude //////////////
        $zones =  DB::table('zones')->where('zone_id', $request->state_id)->first();
        $countries =  DB::table('countries')->where('countries_id', $request->country_id)->first();
        $state = $zones->zone_name;
        $country = $countries->countries_name;
            
        $cordinates_address = urlencode($request->address.' '.$request->city.' '.$state. ' '. $request->zip. ' '.$country);
            
        $setting = new Setting();
        $getSettings = $setting->getSettings();
    
        $latitude = '';
        $longitude = '';
        if ($getSettings[125]->value = 1 and !empty($getSettings[103]->value)) {
            $google_map_api	  =  $getSettings[103]->value;
            $cordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key='.$google_map_api.'&address='.$cordinates_address);
                
            $cordinates = json_decode($cordinates);
                
            if ($cordinates->status=="OK") {
                $latitude = $cordinates->results[0]->geometry->location->lat;
                $longitude = $cordinates->results[0]->geometry->location->lng;
            }
        }

        $address_book_id = DB::table('address_book')->insertGetId([
                'entry_gender'		  	   =>   1,
                'entry_company'		 	     =>   '',
                'entry_firstname'	 	     =>	  $request->first_name,
                'entry_lastname'   	  	 =>   $request->last_name,
                'entry_street_address'	 =>   $request->address,
                'entry_suburb' 			     =>   '',
                'entry_postcode'	   	   =>	  $request->zip,
                'entry_city'   		       =>   $request->city,
                'entry_state'		 	       =>   $request->state_id,
                'entry_country_id'		   =>   $request->country_id,
                'entry_zone_id'	 		     =>	  $request->state_id,
                'entry_latitude'            =>   $latitude,
                'entry_longitude'           =>   $longitude,
            ]);

        //bank information
        DB::table('bank_detail')->where('users_id', $user_id)->update([
            'is_current' => 0,
        ]);
        DB::table('bank_detail')
            ->insert([
                'bank_name'=>$request->bank_name,
                'bank_account_number'=>$request->bank_account_number,
                'bank_routing_number'=>$request->bank_routing_number,
                'bank_address'=>$request->bank_address,
                'bank_iban'=>$request->bank_iban,
                'bank_swift'=>$request->bank_swift,
                'is_current'=>1,
                'users_id' => $user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);


        return $user_id;
    }

    public function extendemail($request)
    {
        $existEmail = DB::table('users')->where('email', '=', $request->email)
                    ->where('role_id', '=', 4)->get();
        return $existEmail;
    }

    public function destroyrecord($user_id)
    {
        DB::table('users')->where('id', '=', $user_id)->delete();
        $addresses = DB::table('user_to_address')->where('user_to_address.user_id', '=', $user_id)->get();
        foreach ($addresses as $address) {
            DB::table('address_book')->where('address_book_id', '=', $address->address_book_id)->delete();
        }
        DB::table('user_to_address')->where('user_to_address.user_id', '=', $user_id)->delete();
        DB::table('deliveryboy_info')->where('users_id', '=', $user_id)->delete();
    }

    public function filter($request)
    {
        $filter = $request->FilterBy;
        $parameter = $request->parameter;
        switch ($filter) {
            case 'Name':
            $user = DeliveryBoys::sortable(['id'=>'ASC'])
                ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
                ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                ->select(
                    'users.*',
                    'deliveryboy_info.*',
                    'deliveryboy_info.users_id as deliveryboy_id',
                    'address_book.entry_gender as entry_gender',
                    'address_book.entry_company as entry_company',
                    'address_book.entry_firstname as entry_firstname',
                    'address_book.entry_lastname as entry_lastname',
                    'address_book.entry_street_address as entry_street_address',
                    'address_book.entry_suburb as entry_suburb',
                    'address_book.entry_postcode as entry_postcode',
                    'address_book.entry_city as entry_city',
                    'address_book.entry_state as entry_state',
                    'countries.*',
                    'zones.*'
                )
                ->where('role_id', '4')

                ->where('first_name', 'LIKE', '%' .  $parameter . '%')
                ->orwhere('last_name', 'LIKE', '%' .  $parameter . '%')
                ->orWhereRaw("concat(first_name, ' ', last_name) like '%$parameter%' ")
                ->where('role_id', '4')
                ->paginate(10);

            break;
            case 'E-mail':
          //  dd($parameter);
              $user =  DeliveryBoys::sortable()
                   ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
                   ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                   ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                   ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                   ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                   ->select(
                       'users.*',
                       'deliveryboy_info.*',
                       'deliveryboy_info.users_id as deliveryboy_id',
                       'address_book.entry_gender as entry_gender',
                       'address_book.entry_company as entry_company',
                       'address_book.entry_firstname as entry_firstname',
                       'address_book.entry_lastname as entry_lastname',
                       'address_book.entry_street_address as entry_street_address',
                       'address_book.entry_suburb as entry_suburb',
                       'address_book.entry_postcode as entry_postcode',
                       'address_book.entry_city as entry_city',
                       'address_book.entry_state as entry_state',
                       'countries.*',
                       'zones.*'
                   )
                   ->where('role_id', '4')
                   ->where('email', 'LIKE', '%' .  $parameter . '%')

                   ->paginate(10);
            break;

            case 'Phone':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                ->leftJoin('images', 'images.id', '=', 'users.avatar')
                ->leftJoin('image_categories', 'image_categories.image_id', '=', 'users.avatar')
                ->select(
                    'users.*',
                    'address_book.entry_gender as entry_gender',
                    'address_book.entry_company as entry_company',
                    'address_book.entry_firstname as entry_firstname',
                    'address_book.entry_lastname as entry_lastname',
                    'address_book.entry_street_address as entry_street_address',
                    'address_book.entry_suburb as entry_suburb',
                    'address_book.entry_postcode as entry_postcode',
                    'address_book.entry_city as entry_city',
                    'address_book.entry_state as entry_state',
                    'countries.*',
                    'zones.*',
                    'image_categories.path as path'
                )
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                })
                ->where('phone', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id', '=', '4')
                ->orderBy('users.id', 'ASC')
                ->where('role_id', '4')
                ->groupby('users.id')
                ->paginate(10);
            break;

            case 'Address':
                $user =  DeliveryBoys::sortable()
                     ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
                     ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                     ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                     ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                     ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                     ->select(
                         'users.*',
                         'deliveryboy_info.*',
                         'deliveryboy_info.users_id as deliveryboy_id',
                         'address_book.entry_gender as entry_gender',
                         'address_book.entry_company as entry_company',
                         'address_book.entry_firstname as entry_firstname',
                         'address_book.entry_lastname as entry_lastname',
                         'address_book.entry_street_address as entry_street_address',
                         'address_book.entry_suburb as entry_suburb',
                         'address_book.entry_postcode as entry_postcode',
                         'address_book.entry_city as entry_city',
                         'address_book.entry_state as entry_state',
                         'countries.*',
                         'zones.*'
                     )
                     ->where('role_id', '4')
                     ->where('address_book.entry_street_address', 'LIKE', '%' .  $parameter . '%')
                     ->orWhere('address_book.entry_city', 'LIKE', '%' .  $parameter . '%')
                     ->orWhere('address_book.entry_state', 'LIKE', '%' .  $parameter . '%')
                     ->paginate(10);

            break;

            case 'Postcode':
                $user =  DeliveryBoys::sortable()
                     ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
                     ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                     ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                     ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                     ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                     ->select(
                         'users.*',
                         'deliveryboy_info.*',
                         'deliveryboy_info.users_id as deliveryboy_id',
                         'address_book.entry_gender as entry_gender',
                         'address_book.entry_company as entry_company',
                         'address_book.entry_firstname as entry_firstname',
                         'address_book.entry_lastname as entry_lastname',
                         'address_book.entry_street_address as entry_street_address',
                         'address_book.entry_suburb as entry_suburb',
                         'address_book.entry_postcode as entry_postcode',
                         'address_book.entry_city as entry_city',
                         'address_book.entry_state as entry_state',
                         'countries.*',
                         'zones.*'
                     )
                     ->where('role_id', '4')
                     ->where('address_book.entry_postcode', 'LIKE', '%' .  $parameter . '%')
                     ->paginate(10);
            break;

            case 'City':

                $user =  DeliveryBoys::sortable()
                     ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
                     ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                     ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                     ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                     ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                     ->select(
                         'users.*',
                         'deliveryboy_info.*',
                         'deliveryboy_info.users_id as deliveryboy_id',
                         'address_book.entry_gender as entry_gender',
                         'address_book.entry_company as entry_company',
                         'address_book.entry_firstname as entry_firstname',
                         'address_book.entry_lastname as entry_lastname',
                         'address_book.entry_street_address as entry_street_address',
                         'address_book.entry_suburb as entry_suburb',
                         'address_book.entry_postcode as entry_postcode',
                         'address_book.entry_city as entry_city',
                         'address_book.entry_state as entry_state',
                         'countries.*',
                         'zones.*'
                     )
                     ->where('role_id', '4')
                     ->where('address_book.entry_postcode', 'LIKE', '%' .  $parameter . '%')

                     ->paginate(10);
            break;

            case 'State':
            $user = DB::table('users')
                ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                ->leftJoin('images', 'images.id', '=', 'users.avatar')
                ->leftJoin('image_categories', 'image_categories.image_id', '=', 'users.avatar')
                ->select(
                    'users.*',
                    'address_book.entry_gender as entry_gender',
                    'address_book.entry_company as entry_company',
                    'address_book.entry_firstname as entry_firstname',
                    'address_book.entry_lastname as entry_lastname',
                    'address_book.entry_street_address as entry_street_address',
                    'address_book.entry_suburb as entry_suburb',
                    'address_book.entry_postcode as entry_postcode',
                    'address_book.entry_city as entry_city',
                    'address_book.entry_state as entry_state',
                    'countries.*',
                    'zones.*',
                    'image_categories.path as path'
                )
                ->where(function ($query) {
                    $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                        ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                        ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                })
                ->where('address_book.entry_city', 'LIKE', '%' .  $parameter . '%')
                ->where('users.role_id', '=', '4')
                ->orderBy('users.id', 'ASC')
                ->groupby('users.id')
                ->paginate(10);

            break;

            case 'Country':

                $user = DB::table('users')
                    ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
                    ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
                    ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
                    ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
                    ->leftJoin('images', 'images.id', '=', 'users.avatar')
                    ->leftJoin('image_categories', 'image_categories.image_id', '=', 'users.avatar')
                    ->select(
                        'users.*',
                        'address_book.entry_gender as entry_gender',
                        'address_book.entry_company as entry_company',
                        'address_book.entry_firstname as entry_firstname',
                        'address_book.entry_lastname as entry_lastname',
                        'address_book.entry_street_address as entry_street_address',
                        'address_book.entry_suburb as entry_suburb',
                        'address_book.entry_postcode as entry_postcode',
                        'address_book.entry_city as entry_city',
                        'address_book.entry_state as entry_state',
                        'countries.*',
                        'zones.*',
                        'image_categories.path as path'
                    )
                    ->where(function ($query) {
                        $query->where('image_categories.image_type', '=', 'THUMBNAIL')
                            ->where('image_categories.image_type', '!=', 'THUMBNAIL')
                            ->orWhere('image_categories.image_type', '=', 'ACTUAL');
                    })
                    ->where('countries.countries_name', 'LIKE', '%' .  $parameter . '%')
                    ->where('users.role_id', '=', '4')
                    ->orderBy('users.id', 'ASC')
                    ->groupby('users.id')
                    ->paginate(10);
            break;
            default: $user = $this->paginator();
        }
        return $user;
    }


    //eagleview filters
    public function eagleviewfilters($request)
    {
        //dd($request->status_id);
        $user = DeliveryBoys::sortable(['id'=>'ASC'])
        ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')
        ->LeftJoin('user_to_address', 'user_to_address.user_id', '=', 'users.id')
        ->LeftJoin('address_book', 'address_book.address_book_id', '=', 'user_to_address.address_book_id')
        ->LeftJoin('countries', 'countries.countries_id', '=', 'address_book.entry_country_id')
        ->LeftJoin('zones', 'zones.zone_id', '=', 'address_book.entry_zone_id')
        ->select(
            'users.*',
            'deliveryboy_info.*',
            'deliveryboy_info.users_id as deliveryboy_id',
            'address_book.entry_gender as entry_gender',
            'address_book.entry_company as entry_company',
            'address_book.entry_firstname as entry_firstname',
            'address_book.entry_lastname as entry_lastname',
            'address_book.entry_street_address as entry_street_address',
            'address_book.entry_suburb as entry_suburb',
            'address_book.entry_postcode as entry_postcode',
            'address_book.entry_city as entry_city',
            'address_book.entry_state as entry_state',
            'address_book.entry_latitude',
            'address_book.entry_longitude',
            'countries.*',
            'zones.*'
        )
        ->where('role_id', '4');

        if (isset($request->countries_id) && $request->countries_id!='all') {
            $user->where('address_book.entry_country_id', $request->countries_id);
        }

        if (isset($request->state_id) && $request->state_id!='all') {
            $user->where('address_book.entry_zone_id', $request->state_id);
        }

        if (isset($request->status_id) && $request->status_id!='all') {
            $user->where('deliveryboy_info.availability_status', $request->status_id);
        }

        if ($request->user_id) {
            $user->where('users.id', $request->user_id);
        }

        $user->where('role_id', '4')
            ->where('is_default', '1');

        $users = $user->where('role_id', '4')->get();

        return $users;
    }

    public function averagerating($request)
    {
        $language_id = 1;
        $users = DB::table('users')  
            ->LeftJoin('deliveryboy_info', 'deliveryboy_info.users_id', '=', 'users.id')         
            ->select(
                'users.*',
                'deliveryboy_info.*',
                'users.id as deliveryboy_id'            
            );

        
        $users_lists = $users
            ->where('users.id', $request->id)
            ->where('role_id', '4')->get();
        
        $data = array();
        $index = 0;
        if (count($users_lists) > 0) {
            foreach ($users_lists as $users_list) {

                //users with rating
                $reviews = DB::table('reviews')
                    ->where('deliveryboy_id', $users_list->deliveryboy_id)
                    ->get();

                $avarage_rate = 0;
                $total_user_rated = 0;
                $customers = array();
                if (count($reviews) > 0) {
                    $five_star = 0;
                    $four_star = 0;
                    $three_star = 0;
                    $two_star = 0;
                    $one_star = 0;
                    foreach ($reviews as $review) {

                        //five star ratting
                        if ($review->reviews_rating == '5') {
                            $five_star += $review->reviews_rating;
                        }

                        //four star ratting
                        if ($review->reviews_rating == '4') {
                            $four_star += $review->reviews_rating;
                        }

                        //three star ratting
                        if ($review->reviews_rating == '3') {
                            $three_star += $review->reviews_rating;
                        }

                        //two star ratting
                        if ($review->reviews_rating == '2') {
                            $two_star += $review->reviews_rating;
                        }

                        //one star ratting
                        if ($review->reviews_rating == '1') {
                            $one_star += $review->reviews_rating;
                        }

                        $customers[] = $review->customers_name;
                    }
                        
                    if (($five_star + $four_star + $three_star + $two_star + $one_star) > 0) {
                        $avarage_rate = (5 * $five_star + 4 * $four_star + 3 * $three_star + 2 * $two_star + 1 * $one_star) / ($five_star + $four_star + $three_star + $two_star + $one_star);
                        $total_user_rated = count($reviews);
                    } else {
                        $avarage_rate = 0;
                        $total_user_rated = 0;
                    }
                } else {
                    $avarage_rate = 0;
                    $total_user_rated = 0;
                }
                $customers = implode($customers,',');
                $users_list->customers = $customers;
                $users_list->rating = number_format($avarage_rate, 2);
                $users_list->total_user_rated = $total_user_rated;

                //total products
                // $products = DB::table('products')->where('deliveryboy_id', $users_list->deliveryboy_id)->get();
                // $users_list->total_products = count($products);

                array_push($data, $users_list);
            }
        } 
    
        return $data;
    }

    public function indvidualratings($request)
    {
        //dd($request);
        $reviews = DB::table('reviews')
            ->leftjoin('reviews_description', 'reviews_description.review_id', '=', 'reviews.reviews_id')
            ->where('deliveryboy_id', $request->id)
            ->where('reviews_status', '1')
            ->where('reviews_description.language_id', 1)
            ->get();  
    
        return $reviews;
    }

    public function ratingdelete($user_id)
    {
        DB::table('reviews')->where('reviews_id', '=', $user_id)->delete(); 
        DB::table('reviews_description')->where('reviews_id', '=', $user_id)->delete();       
    }

}
