<?php
namespace App\Http\Controllers\AdminControllers;
use App\Models\Core\Languages;
use App\Models\Core\Setting;
use App\Models\Admin\Admin;
use App\Models\Core\Order;
use App\Models\Core\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Exception;
use App\Models\Core\Images;
use Validator;
use Hash;
use Auth;
use ZipArchive;
use File;
use App\Models\Core\User;

class AdminController extends Controller
{
	private $domain;
    public function __construct(Admin $admin, Setting $setting, Order $order, Customers $customers)
    {
        $this->Setting = $setting;
        $this->Admin = $admin;
        $this->Order = $order;
		$this->Customers = $customers;
    }

	public function dashboard(Request $request){
		$title 			  = 	array('pageTitle' => Lang::get("labels.title_dashboard"));
		$language_id      = 	'1';

		$result 		  =		array();

		$reportBase		  = 	$request->reportBase;

        $orders = DB::table('orders')->orderBy('created_at', 'DESC')
            ->where('customers_id', '!=', '')->paginate(40);

		$pending_orders = array();
		$cancelled_orders = array();
		$completed_orders = array();
		$refunded_orders = array();
		$inprocess = array();
		$total_orders = array();
		foreach ($orders as $orders_data) {

            $orders_status_history = DB::table('orders_status_history')
                ->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
                ->select('orders_status_history.orders_id','orders_status_history.orders_status_id')
                ->where('orders_id', '=', $orders_data->orders_id)
                ->where('orders_status.role_id', '<=', 2)
                ->orderby('orders_status_history.date_added', 'DESC')->limit(1)->first();

				$total_orders[] = $orders_status_history->orders_id;
				if($orders_status_history->orders_status_id == '1')
					$pending_orders [] = $orders_status_history->orders_id;
				elseif($orders_status_history->orders_status_id == '2')
					$completed_orders [] = $orders_status_history->orders_id;
				elseif($orders_status_history->orders_status_id == '3')
					$cancelled_orders [] = $orders_status_history->orders_id;
				elseif($orders_status_history->orders_status_id == '4')
					$refunded_orders [] = $orders_status_history->orders_id;
				else
				$inprocess[] = $orders_status_history->orders_id;

		}
		
		$result['pending_orders'] = $pending_orders  ? $pending_orders : [];
		$result['completed_orders'] = $completed_orders ? $completed_orders : [];
		$result['cancelled_orders'] = $cancelled_orders ? $cancelled_orders : [];
		$result['refunded_orders'] = $refunded_orders ? $refunded_orders : [];
		$result['inprocess'] = $inprocess ? $inprocess : [];
		$result['total_orders'] = $total_orders ? $total_orders : [];


		// dd($pending_orders,'-',$cancelled_orders,'-',$completed_orders,'-',$refunded_orders);
		//recently order placed
		$orders = DB::table('orders')
			->LeftJoin('currencies', 'currencies.code', '=', 'orders.currency')
			->where('customers_id','!=','')
			->orderBy('date_purchased','DESC')
			->get();
		$total_sales_currency_wise = Order::select(DB::raw('SUM(order_price) as sale,currency'))->whereIn('orders_id',$completed_orders)->get();
		$result['total_sales_currency_wise'] = $total_sales_currency_wise;
		// $index = 0;
		$purchased_price = 0;
		$sold_cost = 0;
		
		foreach($orders as $key =>  $orders_data){

				$orders_status_history = DB::table('orders_status_history')
					->LeftJoin('orders_status', 'orders_status.orders_status_id', '=', 'orders_status_history.orders_status_id')
					->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
					->select('orders_status_description.orders_status_name', 'orders_status_description.orders_status_id')
					->where('orders_id', '=', $orders_data->orders_id)
					->where('orders_status_description.language_id', '=', $language_id)
					->where('orders_status.role_id','=',2)->orderby('orders_status_history.date_added', 'DESC')->first();
					if($orders_status_history){
						
						$orders[$key]->orders_status_id = $orders_status_history->orders_status_id;
						$orders[$key]->orders_status = $orders_status_history->orders_status_name;
						$orders_products = DB::table('orders_products')
						->select('final_price', DB::raw('SUM(final_price) as total_price') ,'products_id','products_quantity' )
						->where('orders_id', '=' ,$orders_data->orders_id)
						->groupBy('final_price')
						->get();

					
						if(count($orders_products)>0 and !empty($orders_products[0]->total_price)){
							$orders[$key]->total_price = $orders_products[0]->total_price;
						}else{
							$orders[$key]->total_price = 0;
						}

						if($orders_status_history->orders_status_id != 3 and $orders_status_history->orders_status_id != 4){
							foreach($orders_products as $orders_product){
								$sold_cost += $orders_product->total_price;
								$single_stock = DB::table('inventory')->where('products_id',$orders_product->products_id)->where('stock_type','in')->sum('stock');
								if($single_stock>0){
									$single_product_purchase_price = $single_stock;
								}else{
									$single_product_purchase_price = 0;
								}
				
							}	
						}	
				} else {
					$orders[$key]->orders_status_id = "";
					$orders[$key]->orders_status = "";
					$orders[$key]->total_price = 0;
				}
		}
		  

  		$result['profit'] = number_format($sold_cost,2);
		$result['orders'] = $orders->chunk(10);

  		//add to cart orders
  		$cart = DB::table('customers_basket')->get();

  		$result['cart'] = count($cart);
		  
  		//Rencently added products
		$recentProducts = DB::table('products')
			->LeftJoin('image_categories', function ($join) {
				$join->on('image_categories.image_id', '=', 'products.products_image')
					->where(function ($query) {
						$query->where('image_categories.image_type', '=', 'THUMBNAIL')
							->where('image_categories.image_type', '!=', 'THUMBNAIL')
							->orWhere('image_categories.image_type', '=', 'ACTUAL');
					});
			})
			->leftJoin('products_description','products_description.products_id','=','products.products_id')
			->select('products.*', 'products_description.*', 'image_categories.path as products_image')
			->where('products_description.language_id','=', $language_id)
			->orderBy('products.products_id', 'DESC')
			->paginate(8);

  		$result['recentProducts'] = $recentProducts;
		  
  		//products
  		$products = DB::table('products')
  			->leftJoin('products_description','products_description.products_id','=','products.products_id')
  			->where('products_description.language_id','=', $language_id)
  			->orderBy('products.products_id', 'DESC')
  			->get();

			
  		//low products & out of stock
  		$lowLimit = 0;
  		$outOfStock = 0;
  		//$total_money = 0;
  		$products_ids = array();
		$products_ids = DB::table('inventory')
                    ->leftjoin('products_description', 'products_description.products_id' ,'=' ,'inventory.products_id')
                    ->leftjoin('products', 'products.products_id' ,'=' ,'inventory.products_id')
                    ->select('products.products_type','products_description.products_id', 'products_description.products_name')
                    ->where('products_description.language_id', 1)
                    ->where('products.products_type','!=', 1)
                    ->groupby('inventory.products_id')
                    ->havingRaw("SUM(IF(stock_type = 'in', stock, 0)) - SUM(IF(stock_type = 'out', stock, 0)) <= 0")->pluck('products_id');

		$variableProduct = DB::select(DB::raw("SELECT inventory_detail.*,products_description.products_name , products_attributes.options_id,products_options_values_descriptions.options_values_name, SUM(CASE WHEN stock_type = 'in' THEN stock ELSE 0 END) AS instocksum,SUM(CASE WHEN stock_type = 'out' THEN stock ELSE 0 END) AS outstocksum,(SUM(CASE WHEN stock_type = 'in' THEN stock ELSE 0 END)-SUM(CASE WHEN stock_type = 'out' THEN stock ELSE 0 END)) as finalstock FROM `inventory` LEFT JOIN inventory_detail on inventory.inventory_ref_id = inventory_detail.inventory_ref_id LEFT JOIN products_attributes ON products_attributes.products_attributes_id = inventory_detail.attribute_id LEFT JOIN products_options_values_descriptions ON products_options_values_descriptions.products_options_values_descriptions_id = products_attributes.options_values_id LEFT JOIN products_description ON products_description.products_id = inventory_detail.products_id GROUP by attribute_id DESC"));
		$out_of_stock_variable_product = array();
		foreach($variableProduct as $vproduct){
			if($vproduct->finalstock <= 0){
				$products_ids[] =$vproduct->products_id;

			}
		}

		$notInsertedinInentory = DB::select(DB::raw('SELECT products.products_id,products_description.products_name FROM `products` LEFT JOIN products_description ON products_description.products_id = products.products_id WHERE products_description.language_id = 1 AND products.products_id NOT IN (SELECT products_id FROM inventory GROUP BY products_id)'));
		foreach($notInsertedinInentory as $vproduct){
			$products_ids[] =$vproduct->products_id;
		}
  		$result['lowLimit'] = $lowLimit;
  		$result['outOfStock'] = count($products_ids);
  		$result['totalProducts'] = count($products);
		
      	$users = array();		  
		 
  		$result['customers'] = User::where('role_id','=',2)->get();//->chunk(21);
		$result['totalCustomers'] = count(User::where('role_id','=',2)->get());
		$result['reportBase'] = $reportBase; 


		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.dashboard",$title)->with('result', $result);
	}



	public function login(){

		if (Auth::check()) {
		  return redirect('/admin/dashboard/this_month');
		}else{
			$title = array('pageTitle' => Lang::get("labels.login_page_name"));
			return view("admin.login",$title);
		}
	}

	public function admininfo(){
		$administor = administrators::all();
		return view("admin.login",$title);
	}

	//login function
  public function checkLogin(Request $request){
		$validator = Validator::make(
			array(
					'email'    => $request->email,
					'password' => $request->password
				),
			array(
					'email'    => 'required | email',
					'password' => 'required',
				)
		);
		//check validation
		if($validator->fails()){
			return redirect('admin/login')->withErrors($validator)->withInput();
		}else{
			//check authentication of email and password
			$adminInfo = array("email" => $request->email, "password" => $request->password);

			if(auth()->attempt($adminInfo)) {
				$admin = auth()->user();

				$administrators = DB::table('users')->where('id', $admin->myid)->get();



				$categories_id = '';
				//admin category role
				if(auth()->user()->adminType != '1'){
					$categories_role = DB::table('categories_role')->where('admin_id', auth()->user()->myid)->get();
					if(!empty($categories_role) and count($categories_role)>0){
						$categories_id = $categories_role[0]->categories_ids;
					}else{
						$categories_id = '';
					}
				}

				session(['categories_id' => $categories_id]);
				return redirect()->intended('admin/dashboard/this_month')->with('administrators', $administrators);
			}else{
				return redirect('admin/login')->with('loginError',Lang::get("labels.EmailPasswordIncorrectText"));
			}

		}

	}

	//logout
	public function logout(){
		Auth::guard('admin')->logout();
		return redirect()->intended('admin/login');
	}

	//admin profile
	public function adminProfile(Request $request){
		//check permission

		$title = array('pageTitle' => Lang::get("labels.Profile"));

		$result = array();

		$countries = DB::table('countries')->get();
		$zones = DB::table('zones')->where('zone_country_id', '=', auth()->user()->country)->get();

		$result['countries'] = $countries;
		$result['zones'] = $zones;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.profile",$title)->with('result', $result);

	}
  //updateProfile
	public function updateProfile(Request $request){
		$updated_at	= date('y-m-d h:i:s');
		$myVar = new SiteSettingController();
		$languages = $myVar->getLanguages();
		$extensions = $myVar->imageType();

		$uploadImage = $request->oldImage;
		$orders_status = DB::table('users')->where('id','=', Auth()->user()->id)->update([
				'user_name'		=>	$request->user_name,
				'first_name'	=>	$request->first_name,
				'last_name'		=>	$request->last_name,
				'country'		=>	$request->country,
				'phone'			=>	$request->phone,
				'avatar'		=>	$uploadImage,
				'updated_at'	=>	$updated_at
				]);

		$message = Lang::get("labels.ProfileUpdateMessage");
		return redirect()->back()->withErrors([$message]);

	}

  //updateProfile
	public function updateAdminPassword(Request $request){

		$orders_status = DB::table('users')->where('id','=', auth()->user()->myid)->update([
				'password'		=>	Hash::make($request->password)
				]);

		$message = Lang::get("labels.PasswordUpdateMessage");
		return redirect()->back()->withErrors([$message]);

	}

  //admins
	public function admins(Request $request){

		$title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
		$language_id            				=   '1';

		$result = array();
		$message = array();
		$errorMessage = array();

		$admins = DB::table('users')
			->leftJoin('user_types','user_types.user_types_id','=','users.role_id')
			->select('users.*','user_types.*')
			->where('users.role_id','>','10')
			->paginate(50);


		$result['message'] = $message;
		$result['errorMessage'] = $errorMessage;
		$result['admins'] = $admins;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.index",$title)->with('result', $result);

	}

	//add admins
	public function addadmins(Request $request){

		$title = array('pageTitle' => Lang::get("labels.addadmin"));

		$result = array();
		$message = array();
		$errorMessage = array();

		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();

		$adminTypes = DB::table('user_types')->where('isActive', 1)->where('user_types_id','>','10')->get();
		$result['adminTypes'] = $adminTypes;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.add",$title)->with('result', $result);

	}

  //addnewadmin
	public function addnewadmin(Request $request){

		//get function from other controller
		$myVar = new SiteSettingController();
		$extensions = $myVar->imageType();

		$result = array();
		$message = array();
		$errorMessage = array();

		//check email already exists
		$existEmail = DB::table('users')->where('email', '=', $request->email)->get();
		if(count($existEmail)>0){
			$errorMessage = Lang::get("labels.Email address already exist");
			return redirect()->back()->with('errorMessage', $errorMessage);
		}else{

			$uploadImage = '';

			$customers_id = DB::table('users')->insertGetId([
						'user_name'		 		    =>   $request->first_name.'_'.$request->last_name.time(),
						'first_name'		 		=>   $request->first_name,
						'last_name'			 		=>   $request->last_name,
						'phone'	 					=>	 $request->phone,
						'email'	 					=>   $request->email,
						'password'		 			=>   Hash::make($request->password),
						'status'		 	 		=>   $request->isActive,
						'avatar'	 				=>	 $uploadImage,
						'role_id'					=>	 $request->adminType
						]);


			$message = Lang::get("labels.New admin has been added successfully");
			return redirect()->back()->with('message', $message);

		}
	}
  //editadmin
	public function editadmin(Request $request){

		$title = array('pageTitle' => Lang::get("labels.EditAdmin"));
		$myid        	 =   $request->id;

		$result = array();
		$message = array();
		$errorMessage = array();

		//get function from other controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();

		$adminTypes = DB::table('user_types')->where('isActive', 1)->where('user_types_id','>','10')->get();

		$result['adminTypes'] = $adminTypes;

		$result['myid'] = $myid;

		$admins = DB::table('users')->where('id','=', $myid)->get();
		$zones = 0;

		if($zones>0){
			$result['zones'] = $zones;
		}else{
			$zones = new \stdClass;
			$zones->zone_id = "others";
			$zones->zone_name = "Others";
			$result['zones'][0] = $zones;
		}


		$result['admins'] = $admins;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.edit",$title)->with('result', $result);
	}

  //update admin
	public function updateadmin(Request $request){

		//get function from other controller
		$myVar = new SiteSettingController();
		$extensions = $myVar->imageType();
		$myid = $request->myid;
		$result = array();
		$message = array();
		$errorMessage = array();

		//check email already exists
		$existEmail = DB::table('users')->where([['email','=',$request->email],['id','!=',$myid]])->get();
		if(count($existEmail)>0){
			$errorMessage = Lang::get("labels.Email address already exist");
			return redirect()->back()->with('errorMessage', $errorMessage);
		}else{

			$uploadImage = '';

			$admin_data = array(
				'first_name'		 		=>   $request->first_name,
				'last_name'			 		=>   $request->last_name,
				'phone'	 					=>	 $request->phone,
				'email'	 					=>   $request->email,
				'status'		 	 		=>   $request->isActive,
				'avatar'	 				=>	 $uploadImage,
				'role_id'	 				=>	 $request->adminType,
			);

			if($request->changePassword == 'yes'){
				$admin_data['password'] = Hash::make($request->password);
			}

			$customers_id = DB::table('users')->where('id', '=', $myid)->update($admin_data);


			$message = Lang::get("labels.Admin has been updated successfully");
			return redirect()->back()->with('message', $message);
		}

	}

   public function profile(Request $request){

        $title = array('pageTitle' => Lang::get("labels.Profile"));
        $result = array();
        $images = new Images;
        $allimage = $images->getimages();
        $result['admin'] = $this->Admin->edit(auth()->user()->id);
        $countries = DB::table('countries')->get();
        $zones = DB::table('zones')->where('zone_country_id', '=', $result['admin']->entry_country_id)->get();
        $result['countries'] = $countries;
        $result['zones'] = $zones;
		$result['commonContent'] = $this->Setting->commonContent();
        return view("admin.admin.profile",$title)->with('result', $result)->with('allimage', $allimage);
    }

    public function update(Request $request){
     $validator = Validator::make(
        array(
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'address' => $request->address,
          'phone' => $request->phone,
          'city' => $request->city,
          'country' => $request->first_name,
          'zip' => $request->zip
          ),
        array(
          'first_name' => 'required',
          'last_name' => 'required',
          'address' => 'required',
          'phone' => 'required',
          'city' => 'required',
          'country' => 'required',
          'zip' => 'required'
          )
      );
      if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
      }

       $update = $this->Admin->updaterecord($request);
        $message = Lang::get("labels.ProfileUpdateMessage");
       return redirect()->back()->with(['success' => $message]);
     }

     public function updatepassword(Request $request){
        $update = $this->Admin->updatepassword($request);
        $message = Lang::get("labels.PasswordUpdateMessage");
        return redirect()->back()->withErrors([$message]);
      }

      //deleteProduct
    	public function deleteadmin(Request $request){

    		$myid = $request->myid;

    		DB::table('users')->where('id','=', $myid)->delete();

    		return redirect()->back()->withErrors([Lang::get("labels.DeleteAdminMessage")]);

    	}

	//manageroles
	public function manageroles(Request $request){

		$title = array('pageTitle' => Lang::get("labels.manageroles"));
		$language_id            				=   '1';

		$result = array();
		$message = array();
		$errorMessage = array();

		$adminTypes = DB::table('user_types')->where('user_types_id','>','10')->paginate(50);

		$result['message'] = $message;
		$result['errorMessage'] = $errorMessage;
		$result['adminTypes'] = $adminTypes;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.roles.manageroles",$title)->with('result', $result);

	}


	//add admins type
	public function addadmintype(Request $request){
		$title = array('pageTitle' => Lang::get("labels.addadmintype"));

		$result = array();
		$message = array();
		$errorMessage = array();

		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();

		$adminTypes = DB::table('user_types')->where('isActive', 1)->get();
		$result['adminTypes'] = $adminTypes;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.roles.addadmintype",$title)->with('result', $result);
	}

	//addnewtype
	public function addnewtype(Request $request){

		$result = array();
		$message = array();
		$errorMessage = array();

		$customers_id = DB::table('user_types')->insertGetId([
						'user_types_name'	 		=>   $request->user_types_name,
						'created_at'			 	=>   time(),
						'isActive'		 	 		=>   $request->isActive,
						]);

		$message = Lang::get("labels.Admin type has been added successfully");
		return redirect()->back()->with('message', $message);

	}


	//editadmintype
	public function editadmintype(Request $request){
		$title = array('pageTitle' => Lang::get("labels.EditAdminType"));
		$user_types_id        	 =   $request->id;

		$result = array();

		$result['user_types_id'] = $user_types_id;

		$user_types = DB::table('user_types')->where('user_types_id','=', $user_types_id)->get();

		$result['user_types'] = $user_types;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.editadmintype",$title)->with('result', $result);
	}

	//updatetype
	public function updatetype(Request $request){

		$result = array();
		$message = array();
		$errorMessage = array();

		$customers_id = DB::table('user_types')->where('user_types_id',$request->user_types_id)->update([
						'user_types_name'	 		=>   $request->user_types_name,
						'updated_at'			 	=>   time(),
						'isActive'		 	 		=>   $request->isActive,
						]);


		$message = Lang::get("labels.Admin type has been updated successfully");
		return redirect()->back()->with('message', $message);

	}


	//deleteProduct
	public function deleteadmintype(Request $request){

		$user_types_id = $request->user_types_id;

		DB::table('user_types')->where('user_types_id','=', $user_types_id)->delete();

		return redirect()->back()->withErrors([Lang::get("labels.DeleteAdminTypeMessage")]);

	}

	//managerole
	public function addrole(Request $request){


		$title = array('pageTitle' => Lang::get("labels.EditAdminType"));
		$result = array();
		$user_types_id = $request->id;
		$result['user_types_id'] = $user_types_id;

		$adminType = DB::table('user_types')->where('user_types_id',$user_types_id)->get();
		$result['adminType'] = $adminType;

		$roles = DB::table('manage_role')->where('user_types_id','=', $user_types_id)->get();

		if(count($roles)>0){
			$dashboard_view = $roles[0]->dashboard_view;

			$manufacturer_view = $roles[0]->manufacturer_view;
			$manufacturer_create = $roles[0]->manufacturer_create;
			$manufacturer_update = $roles[0]->manufacturer_update;
			$manufacturer_delete = $roles[0]->manufacturer_delete;

			$categories_view   = $roles[0]->categories_view;
			$categories_create = $roles[0]->categories_create;
			$categories_update = $roles[0]->categories_update;
			$categories_delete = $roles[0]->categories_delete;

			$products_view = $roles[0]->products_view;
			$products_create = $roles[0]->products_create;
			$products_update = $roles[0]->products_update;
			$products_delete = $roles[0]->products_delete;

			$news_view   = $roles[0]->news_view;
			$news_create = $roles[0]->news_create;
			$news_update = $roles[0]->news_update;
			$news_delete = $roles[0]->news_delete;

			$media_view   = $roles[0]->view_media;
			$media_create = $roles[0]->add_media;
			$media_update = $roles[0]->edit_media;
			$media_delete = $roles[0]->delete_media;

			$customers_view = $roles[0]->customers_view;
			$customers_create = $roles[0]->customers_create;
			$customers_update = $roles[0]->customers_update;
			$customers_delete = $roles[0]->customers_delete;

			$tax_location_view = $roles[0]->tax_location_view;
			$tax_location_create = $roles[0]->tax_location_create;
			$tax_location_update = $roles[0]->tax_location_update;
			$tax_location_delete = $roles[0]->tax_location_delete;

			$coupons_view = $roles[0]->coupons_view;
			$coupons_create = $roles[0]->coupons_create;
			$coupons_update = $roles[0]->coupons_update;
			$coupons_delete = $roles[0]->coupons_delete;

			$notifications_view = $roles[0]->notifications_view;
			$notifications_send = $roles[0]->notifications_send;

			$orders_view = $roles[0]->orders_view;
			$orders_confirm = $roles[0]->orders_confirm;

			$shipping_methods_view = $roles[0]->shipping_methods_view;
			$shipping_methods_update = $roles[0]->shipping_methods_update;

			$payment_methods_view = $roles[0]->payment_methods_view;
			$payment_methods_update = $roles[0]->payment_methods_update;

			$reports_view = $roles[0]->reports_view;

			$website_setting_view = $roles[0]->website_setting_view;
			$website_setting_update = $roles[0]->website_setting_update;

			$application_setting_view = $roles[0]->application_setting_view;
			$application_setting_update = $roles[0]->application_setting_update;


			$general_setting_view = $roles[0]->general_setting_view;
			$general_setting_update = $roles[0]->general_setting_update;

			$manage_admins_view   = $roles[0]->manage_admins_view;
			$manage_admins_create = $roles[0]->manage_admins_create;
			$manage_admins_update = $roles[0]->manage_admins_update;
			$manage_admins_delete = $roles[0]->manage_admins_delete;


			$language_view = $roles[0]->language_view;
			$language_create = $roles[0]->language_create;
			$language_update = $roles[0]->language_update;
			$language_delete = $roles[0]->language_delete;

			$profile_view = $roles[0]->profile_view;
			$profile_update = $roles[0]->profile_update;

			$admintype_view = $roles[0]->admintype_view;
			$admintype_create = $roles[0]->admintype_create;
			$admintype_update = $roles[0]->admintype_update;
			$admintype_delete = $roles[0]->language_delete;
			$manage_admins_role = $roles[0]->manage_admins_role;
			
			$reviews_view = $roles[0]->reviews_view;
			$reviews_update = $roles[0]->reviews_update;

			$deliveryboy_view = $roles[0]->deliveryboy_view;
            $deliveryboy_create = $roles[0]->deliveryboy_create;
            $deliveryboy_update = $roles[0]->deliveryboy_update;
            $deliveryboy_delete = $roles[0]->deliveryboy_delete;

		}else{

			$deliveryboy_view = 0;
            $deliveryboy_create = 0;
            $deliveryboy_update = 0;
			$deliveryboy_delete = 0;

			$dashboard_view = '0';

			$manufacturer_view = '0';
			$manufacturer_create = '0';
			$manufacturer_update = '0';
			$manufacturer_delete = '0';

			$categories_view = '0';
			$categories_create = '0';
			$categories_update = '0';
			$categories_delete = '0';

			$products_view   = '0';
			$products_create = '0';
			$products_update = '0';
			$products_delete = '0';

			$media_view   = '0';
			$media_create = '0';
			$media_update = '0';
			$media_delete = '0';

			$news_view = '0';
			$news_create = '0';
			$news_update = '0';
			$news_delete = '0';

			$customers_view   = '0';
			$customers_create = '0';
			$customers_update = '0';
			$customers_delete = '0';

			$tax_location_view = '0';
			$tax_location_create = '0';
			$tax_location_update = '0';
			$tax_location_delete = '0';


			$coupons_view = '0';
			$coupons_create = '0';
			$coupons_update = '0';
			$coupons_delete = '0';

			$notifications_view = '0';
			$notifications_send = '0';

			$orders_view = '0';
			$orders_confirm = '0';

			$shipping_methods_view = '0';
			$shipping_methods_update = '0';

			$payment_methods_view = '0';
			$payment_methods_update = '0';

			$reports_view = '0';

			$website_setting_view = '0';
			$website_setting_update = '0';

			$application_setting_view = '0';
			$application_setting_update = '0';

			$general_setting_view = '0';
			$general_setting_update = '0';

			$manage_admins_view = '0';
			$manage_admins_create = '0';
			$manage_admins_update = '0';
			$manage_admins_delete = '0';

			$language_view = '0';
			$language_create = '0';
			$language_update = '0';
			$language_delete = '0';

			$profile_view = '0';
			$profile_update = '0';

			$admintype_view = '0';
			$admintype_create = '0';
			$admintype_update = '0';
			$admintype_delete = '0';
			$manage_admins_role = '0';

			$reviews_view = 0;
			$reviews_update = 0;
		}


		$result2[0]['link_name'] = 'dashboard';
		$result2[0]['permissions'] = array('0'=>array('name'=>'dashboard_view','value'=>$dashboard_view));

		$result2[1]['link_name'] = 'manufacturer';
		$result2[1]['permissions'] = array(
					'0'=>array('name'=>'manufacturer_view','value'=>$manufacturer_view),
					'1'=>array('name'=>'manufacturer_create','value'=>$manufacturer_create),
					'2'=>array('name'=>'manufacturer_update','value'=>$manufacturer_update),
					'3'=>array('name'=>'manufacturer_delete','value'=>$manufacturer_delete)
					);

		$result2[2]['link_name'] = 'categories';
		$result2[2]['permissions'] = array(
					'0'=>array('name'=>'categories_view','value'=>$categories_view),
					'1'=>array('name'=>'categories_create','value'=>$categories_create),
					'2'=>array('name'=>'categories_update','value'=>$categories_update),
					'3'=>array('name'=>'categories_delete','value'=>$categories_delete)
					);

		$result2[3]['link_name'] = 'products';
		$result2[3]['permissions'] = array(
					'0'=>array('name'=>'products_view','value'=>$products_view),
					'1'=>array('name'=>'products_create','value'=>$products_create),
					'2'=>array('name'=>'products_update','value'=>$products_update),
					'3'=>array('name'=>'products_delete','value'=>$products_delete)
					);

		$result2[4]['link_name'] = 'news';
		$result2[4]['permissions'] = array(
					'0'=>array('name'=>'news_view','value'=>$news_view),
					'1'=>array('name'=>'news_create','value'=>$news_create),
					'2'=>array('name'=>'news_update','value'=>$news_update),
					'3'=>array('name'=>'news_delete','value'=>$news_delete)
					);

		$result2[5]['link_name'] = 'customers';
		$result2[5]['permissions'] = array(
					'0'=>array('name'=>'customers_view','value'=>$customers_view),
					'1'=>array('name'=>'customers_create','value'=>$customers_create),
					'2'=>array('name'=>'customers_update','value'=>$customers_update),
					'3'=>array('name'=>'customers_delete','value'=>$customers_delete)
					);

		$result2[6]['link_name'] = 'tax_location';
		$result2[6]['permissions'] = array(
					'0'=>array('name'=>'tax_location_view','value'=>$tax_location_view),
					'1'=>array('name'=>'tax_location_create','value'=>$tax_location_create),
					'2'=>array('name'=>'tax_location_update','value'=>$tax_location_update),
					'3'=>array('name'=>'tax_location_delete','value'=>$tax_location_delete)
					);

		$result2[7]['link_name'] = 'coupons';
		$result2[7]['permissions'] = array(
					'0'=>array('name'=>'coupons_view','value'=>$coupons_view),
					'1'=>array('name'=>'coupons_create','value'=>$coupons_create),
					'2'=>array('name'=>'coupons_update','value'=>$coupons_update),
					'3'=>array('name'=>'coupons_delete','value'=>$coupons_delete)
					);

		$result2[8]['link_name'] = 'notifications';
		$result2[8]['permissions'] = array(
					'0'=>array('name'=>'notifications_view','value'=>$notifications_view),
					'1'=>array('name'=>'notifications_send','value'=>$notifications_send)
					);

		$result2[9]['link_name'] = 'orders';
		$result2[9]['permissions'] = array(
					'0'=>array('name'=>'orders_view','value'=>$orders_view),
					'1'=>array('name'=>'orders_confirm','value'=>$orders_confirm)
					);

		$result2[10]['link_name'] = 'shipping_methods';
		$result2[10]['permissions'] = array(
					'0'=>array('name'=>'shipping_methods_view','value'=>$shipping_methods_view),
					'1'=>array('name'=>'shipping_methods_update','value'=>$shipping_methods_update)
					);

		$result2[11]['link_name'] = 'payment_methods';
		$result2[11]['permissions'] = array(
					'0'=>array('name'=>'payment_methods_view','value'=>$payment_methods_view),
					'1'=>array('name'=>'payment_methods_update','value'=>$payment_methods_update)
					);

		$result2[12]['link_name'] = 'reports';
		$result2[12]['permissions'] = array('0'=>array('name'=>'reports_view','value'=>$reports_view));

		$result2[13]['link_name'] = 'website_setting';
		$result2[13]['permissions'] = array(
					'0'=>array('name'=>'website_setting_view','value'=>$website_setting_view),
					'1'=>array('name'=>'website_setting_update','value'=>$website_setting_update)
					);

		$result2[14]['link_name'] = 'application_setting';
		$result2[14]['permissions'] = array(
					'0'=>array('name'=>'application_setting_view','value'=>$application_setting_view),
					'1'=>array('name'=>'application_setting_update','value'=>$application_setting_update)
					);

		$result2[15]['link_name'] = 'general_setting';
		$result2[15]['permissions'] = array(
					'0'=>array('name'=>'general_setting_view','value'=>$general_setting_view),
					'1'=>array('name'=>'general_setting_update','value'=>$general_setting_update)
					);

		$result2[16]['link_name'] = 'manage_admins';
		$result2[16]['permissions'] = array(
					'0'=>array('name'=>'manage_admins_view','value'=>$manage_admins_view),
					'1'=>array('name'=>'manage_admins_create','value'=>$manage_admins_create),
					'2'=>array('name'=>'manage_admins_update','value'=>$manage_admins_update),
					'3'=>array('name'=>'manage_admins_delete','value'=>$manage_admins_delete)
					);

		$result2[17]['link_name'] = 'language';
		$result2[17]['permissions'] = array(
					'0'=>array('name'=>'language_view','value'=>$language_view),
					'1'=>array('name'=>'language_create','value'=>$language_create),
					'2'=>array('name'=>'language_update','value'=>$language_update),
					'3'=>array('name'=>'language_delete','value'=>$language_delete)
					);

		$result2[18]['link_name'] = 'profile';
		$result2[18]['permissions'] = array(
					'0'=>array('name'=>'profile_view','value'=>$profile_view),
					'1'=>array('name'=>'profile_update','value'=>$profile_update)
					);


		$result2[19]['link_name'] = 'Admin Types';
		$result2[19]['permissions'] = array(
					'0'=>array('name'=>'admintype_view','value'=>$admintype_view),
					'1'=>array('name'=>'admintype_create','value'=>$admintype_create),
					'2'=>array('name'=>'admintype_update','value'=>$admintype_update),
					'3'=>array('name'=>'admintype_delete','value'=>$admintype_delete),
					'4'=>array('name'=>'manage_admins_role','value'=>$manage_admins_role)
					);

		$result2[20]['link_name'] = 'Media';
		$result2[20]['permissions'] = array(
					'0'=>array('name'=>'media_view','value'=>$media_view),
					'1'=>array('name'=>'media_create','value'=>$media_create),
					'2'=>array('name'=>'media_update','value'=>$media_update),
					'3'=>array('name'=>'media_delete','value'=>$media_delete),
					);

		$result2[21]['link_name'] = 'Reviews';
		$result2[21]['permissions'] = array(
					'0'=>array('name'=>'reviews_view','value'=>$reviews_view),
					'1'=>array('name'=>'reviews_update','value'=>$reviews_update),
					);

		$result2[22]['link_name'] = 'Delivery Boy';
        $result2[22]['permissions'] = array(
            '0' => array('name' => 'deliveryboy_view', 'value' => $deliveryboy_view),
            '1' => array('name' => 'deliveryboy_create', 'value' => $deliveryboy_create),
            '2' => array('name' => 'deliveryboy_update', 'value' => $deliveryboy_update),
            '3' => array('name' => 'deliveryboy_delete', 'value' => $deliveryboy_delete),
        );

		$result['data'] = $result2;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.addrole",$title)->with('result', $result);

	}

	//addnewroles
	public function addnewroles(Request $request){

		$user_types_id = $request->user_types_id;
		DB::table('manage_role')->where('user_types_id',$user_types_id)->delete();

		$roles = DB::table('manage_role')->where('user_types_id',$request->user_types_id)->insert([
						'user_types_id'			=>	 $request->user_types_id,
						'dashboard_view'=>$request->dashboard_view,

						'manufacturer_view' => $request->manufacturer_view,
						'manufacturer_create' => $request->manufacturer_create,
						'manufacturer_update' => $request->manufacturer_update,
						'manufacturer_delete' => $request->manufacturer_delete,

						'view_media' => $request->media_view,
						'add_media' => $request->media_create,
						'edit_media' => $request->media_update,
						'delete_media' => $request->media_delete,

						'categories_view' => $request->categories_view,
						'categories_create' => $request->categories_create,
						'categories_update' => $request->categories_update,
						'categories_delete' => $request->categories_delete,

						'products_view' => $request->products_view,
						'products_create' => $request->products_create,
						'products_update' => $request->products_update,
						'products_delete' => $request->products_delete,

						'news_view' => $request->news_view,
						'news_create' => $request->news_create,
						'news_update' => $request->news_update,
						'news_delete' => $request->news_delete,

						'customers_view' => $request->customers_view,
						'customers_create' => $request->customers_create,
						'customers_update' => $request->customers_update,
						'customers_delete' => $request->customers_delete,

						'tax_location_view' => $request->tax_location_view,
						'tax_location_create' => $request->tax_location_create,
						'tax_location_update' => $request->tax_location_update,
						'tax_location_delete' => $request->tax_location_delete,

						'coupons_view' => $request->coupons_view,
						'coupons_create' => $request->coupons_create,
						'coupons_update' => $request->coupons_update,
						'coupons_delete' => $request->coupons_delete,

						'notifications_view' => $request->notifications_view,
						'notifications_send' => $request->notifications_send,

						'orders_view' => $request->orders_view,
						'orders_confirm' => $request->orders_confirm,

						'shipping_methods_view' => $request->shipping_methods_view,
						'shipping_methods_update' => $request->shipping_methods_update,

						'payment_methods_view' => $request->payment_methods_view,
						'payment_methods_update' => $request->payment_methods_update,

						'reports_view' => $request->reports_view,

						'website_setting_view' => $request->website_setting_view,
						'website_setting_update' => $request->website_setting_update,

						'application_setting_view' => $request->application_setting_view,
						'application_setting_update' => $request->application_setting_update,

						'general_setting_view' => $request->general_setting_view,
						'general_setting_update' => $request->general_setting_update,

						'manage_admins_view' => $request->manage_admins_view,
						'manage_admins_create' => $request->manage_admins_create,
						'manage_admins_update' => $request->manage_admins_update,
						'manage_admins_delete' => $request->manage_admins_delete,

						'language_view' => $request->language_view,
						'language_create' => $request->language_create,
						'language_update' => $request->language_update,
						'language_delete' => $request->language_delete,

						'profile_view' => $request->profile_view,
						'profile_update' => $request->profile_update,

						'admintype_view' => $request->admintype_view,
						'admintype_create' => $request->admintype_create,
						'admintype_update' => $request->admintype_update,
						'admintype_delete' => $request->admintype_delete,
						'manage_admins_role' => $request->manage_admins_role,
						
						'reviews_view' => $request->reviews_view,
						'reviews_update' => $request->reviews_update,

						'deliveryboy_view' => $request->deliveryboy_view,
						'deliveryboy_create' => $request->deliveryboy_create,
						'deliveryboy_update' => $request->deliveryboy_update,
						'deliveryboy_delete' => $request->deliveryboy_delete,
						
						]);

		$message = Lang::get("labels.Roles has been added successfully");
		return redirect()->back()->with('message', $message);

	}


   //managerole
	public function categoriesroles(Request $request){
		$title = array('pageTitle' => Lang::get("labels.CategoriesRoles"));
		$result = array();
		$language_id = 1;

		$categories_role = DB::table('users')->join('categories_role','categories_role.admin_id','=','users.role_id')->where('users.role_id','!=','1')->get();

		$data = array();
		$index = 0;
		foreach($categories_role as $categories){
			array_push($data,$categories);
			$cat_array = explode(',',$categories->categories_ids);
			$categories_descrtiption = DB::table('categories_description')->whereIn('categories_id', $cat_array)->where('language_id',$language_id)->get();
			$data[$index++]->description = $categories_descrtiption;
		}

		$result['data'] = $data;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.category.index",$title)->with('result', $result);
	}

  	//addCategoriesRoles
  	public function addCategoriesRoles(Request $request){

  			$title = array('pageTitle' => Lang::get("labels.AddCategoriesRoles"));
  			$result = array();
  			$language_id = 1;
  			$categories_role = DB::table('categories_role')->get();

  			//get function from other controller
  			$myVar = new AdminCategoriesController();
  			$result['categories'] = $myVar->allCategories($language_id);

  			$result['admins'] = DB::table('users')->where('role_id','!=','1')->get();

  			$result['data'] = $categories_role;
			  $result['commonContent'] = $this->Setting->commonContent();
  			return view("admin.admins.roles.category.add",$title)->with('result', $result);

  	}

	//addCategoriesRoles
	public function addNewCategoriesRoles(Request $request){


		$title = array('pageTitle' => Lang::get("labels.AddCategoriesRoles"));
		$result = array();

		$language_id = 1;

		$exist = DB::table('categories_role')->where('admin_id',$request->admin_id)->get();

		if(count($exist)>0){
			return redirect()->back()->with('error', Lang::get("labels.AlreadyCategoryAssignToadmin"));
		}else{

			$categories = array();
			foreach($request->categories as $category){
				$categories[] = $category;
			}

			$categories = implode(',',$categories);

			$roles = DB::table('categories_role')->insert([
						'categories_ids'	=>	$categories,
						'admin_id'			=>	$request->admin_id,
						]);

			return redirect()->back()->with('success', Lang::get("labels.CategoryRolesAddedSucceccfully"));
		}

	}

  //editCategoriesRoles
	public function editCategoriesRoles(Request $request){

		$title = array('pageTitle' => Lang::get("labels.AddCategoriesRoles"));
		$result = array();
		$language_id = 1;

		//get function from other controller
		$myVar = new AdminCategoriesController();
		$result['categories'] = $myVar->allCategories($language_id);

		$categories_role = DB::table('categories_role')->where('categories_role_id',$request->id)->get();

		$result['admins'] = DB::table('users')->where('role_id','!=','1')->get();

		$result['data'] = $categories_role;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.roles.category.edit",$title)->with('result', $result);


	}

	//updatecategoriesroles
	public function updatecategoriesroles(Request $request){
		$result = array();

		$categories = array();
		foreach($request->categories as $category){
			$categories[] = $category;
		}
		print_r($request->admin_id);
		$categories = implode(',',$categories);

		$roles = DB::table('categories_role')->where('categories_role_id',$request->categories_role_id)->update([
					'categories_ids'	=>	$categories,
					]);

		return redirect()->back()->with('success', Lang::get("labels.CategoryRolesUpdatedSucceccfully"));
	}

	//deleteCountry
	public function deletecategoriesroles(Request $request){
		DB::table('categories_role')->where('categories_role_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.AdminRemoveCategoryMessage")]);
	}


}
