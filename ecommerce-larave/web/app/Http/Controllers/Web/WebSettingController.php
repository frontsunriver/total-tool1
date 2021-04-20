<?php
namespace App\Http\Controllers\Web;
//use Mail;
//validator is builtin class in laravel
use Validator;

use DB;
//for password encryption or hash protected
use Hash;

//for authenitcate login data
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;

//for requesting a value
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Web\WebSetting;

//for Carbon a value
use Carbon;
use Lang;
use Config;
use App;
//email
use Illuminate\Support\Facades\Mail;
use Session;

class WebSettingController extends Controller
{

	public function changeLanguage(Request $request){
		$settings = new WebSetting();
		if($request->ajax()){
		   $request->session()->put('locale', $request->locale);
		   //set language

				$language =	 $settings->getLanguage($request->languages_id);
			 $request->session()->put('language_id', $language->languages_id);
		   $request->session()->put('direction', $language->direction);
			 $request->session()->put('locale', $language->code);
			 $request->session()->put('language_name', $language->name);
			 $request->session()->put('language_image', $language->image_path);
			 $request->session()->put('custom_locale',  $language->code);

			 if(Session::has('locale')){
				 $locale = Session::get('locale', Config::get('app.locale'));
			 }else{
					$request->session()->put('direction', $language->direction);
					$locale = $language->code;
			 }

			 App::setLocale($locale);

       echo 'success';
		}

 }

		public function changeCurrency(Request $request){
			$settings = new WebSetting();
			$currency = $settings->getCurrency($request->currency_id);
			session(['currency_id' => $currency->id]);
			session(['currency_title' => $currency->code]);
			session(['symbol_right' => $currency->symbol_right]);
			session(['symbol_left' => $currency->symbol_left]);
			session(['currency_code' => $currency->code]);
			session(['currency_value' => $currency->value]);

			echo 'success';

	}


}
