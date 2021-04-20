<?php
namespace App\Http\Controllers\AdminControllers;

use App;
use App\Http\Controllers\Controller;
use App\Models\Core\Categories;
use App\Models\Core\Images;
//for password encryption or hash protected
use App\Models\Core\Languages;
use App\Models\Core\Products;
use App\Models\Core\Setting;
use DB;
use Illuminate\Http\Request;

//for authenitcate login data
use Lang;

//for requesting a value

class AdminSlidersController extends Controller
{

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    //listingTaxClass
    public function sliders(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingSliders"));

        $result = array();
        $message = array();

        

        $banner = DB::table('sliders_images')
            ->leftJoin('languages', 'languages.languages_id', '=', 'sliders_images.languages_id')
            ->leftJoin('image_categories', 'sliders_images.sliders_image', '=', 'image_categories.image_id')
            ->select('sliders_images.*', 'image_categories.path', 'languages.name as language_name');
            
            if($request->sliderType){
                $banner->where('carousel_id', $request->sliderType);
            }

            
            $banner->orderBy('sliders_images.sliders_id', 'ASC')
            ->groupBy('sliders_images.sliders_id');

        $banners = $banner->get();

        $result['message'] = $message;
        $result['sliders'] = $banners;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.settings.web.sliders.index", $title)->with('result', $result);
    }

    //addTaxClass
    public function addsliderimage(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddSliderImage"));

        $result = array();
        $message = array();

        //get function from other controller
        $myVar = new Categories();
        $categories = $myVar->getter(1);

        $images = new Images();
        $allimage = $images->getimages();

        $myVar = new Products();
        $products = $myVar->getter();

        //get function from other controller
        $myVar = new Languages();
        $result['languages'] = $myVar->getter();
        

        $result['message'] = $message;
        $result['categories'] = $categories;
        $result['products'] = $products;
        $result['commonContent'] = $this->Setting->commonContent();

        return view("admin.settings.web.sliders.add", $title)->with(['result' => $result, 'allimage' => $allimage]);
    }

    //addNewZone
    public function addNewSlide(Request $request)
    {

        $images = new Images();
        $allimage = $images->getimages();

        //get function from other controller
        $myVar = new Languages();
        $result['languages'] = $myVar->getter();

        $expiryDate = str_replace('/', '-', $request->expires_date);
        $expiryDateFormate = date('Y-m-d H:i:s', strtotime($expiryDate));
        $type = $request->type;

        if ($request->image_id) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = '';
        }

        if ($type == 'category') {
            $sliders_url = $request->categories_id;
        } else if ($type == 'product') {
            $sliders_url = $request->products_id;
        } else {
            $sliders_url = '';
        }
        if($request->carousel_id == 1){
            $title = 'Full Screen Slider (1600x420)';
        }elseif($request->carousel_id == 2){
            $title = 'Full Page Slider (1170x420)';
        }elseif($request->carousel_id == 3){
            $title = 'Right Slider with Thumbs (770x400)';
        }elseif($request->carousel_id == 4){
            $title = 'Right Slider with Navigation (770x400)';
        }elseif($request->carousel_id == 5){
            $title = 'Left Slider with Thumbs (770x400)';
        }

        DB::table('sliders_images')->insert([
            'sliders_title' => $title,
            'date_added' => date('Y-m-d H:i:s'),
            'sliders_image' => $uploadImage,
            'carousel_id' => $request->carousel_id,
            'sliders_url' => $sliders_url,
            'status' => $request->status,
            'expires_date' => $expiryDateFormate,
            'type' => $request->type,
            'languages_id' => $request->languages_id,
        ]);

        $message = Lang::get("labels.SliderAddedMessage");
        return redirect()->back()->withErrors([$message]);
    }

    //editTaxClass
    public function editslide(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditSliderImage"));
        $result = array();
        $result['message'] = array();

        $banners = DB::table('sliders_images')
            ->leftJoin('image_categories', 'sliders_images.sliders_image', '=', 'image_categories.image_id')
            ->select('sliders_images.*', 'image_categories.path')
            ->where('sliders_id', $request->id)
            ->groupBy('sliders_images.sliders_id')
            ->first();
        $result['sliders'] = $banners;

        //get function from other controller
        $myVar = new Categories();
        $categories = $myVar->getter(1);

        $images = new Images();
        $allimage = $images->getimages();

        //get function from other controller
        $myVar = new Products();
        $products = $myVar->getter();

        //get function from other controller
        $myVar = new Languages();
        $result['languages'] = $myVar->getter();

        $result['categories'] = $categories;
        $result['products'] = $products;
        $result['commonContent'] = $this->Setting->commonContent();

        return view('admin.settings.web.sliders.edit', $title)->with(['result' => $result, 'allimage' => $allimage]);
    }

    public function updateSlide(Request $request)
    {
        $myVar = new Languages();
        $languages = $myVar->getter();
        $expiryDate = str_replace('/', '-', $request->expires_date);
        $expiryDateFormate = date('Y-m-d H:i:s', strtotime($expiryDate));
        $type = $request->type;

        if ($type == 'category') {
            $sliders_url = $request->categories_id;
        } else if ($type == 'product') {
            $sliders_url = $request->products_id;
        } else {
            $sliders_url = '';
        }

        if($request->carousel_id == 1){
            $title = 'Full Screen Slider (1600x420)';
        }elseif($request->carousel_id == 2){
            $title = 'Full Page Slider (1170x420)';
        }elseif($request->carousel_id == 3){
            $title = 'Right Slider with Thumbs (770x400)';
        }elseif($request->carousel_id == 4){
            $title = 'Right Slider with Navigation (770x400)';
        }elseif($request->carousel_id == 5){
            $title = 'Left Slider with Thumbs (770x400)';
        }

        if ($request->image_id) {
            $uploadImage = $request->image_id;
            $countryUpdate = DB::table('sliders_images')->where('sliders_id', $request->id)->update([
                'date_status_change' => date('Y-m-d H:i:s'),
                'sliders_title' => $title,
                'date_added' => date('Y-m-d H:i:s'),
                'sliders_image' => $uploadImage,
                'sliders_url' => $sliders_url,
                'status' => $request->status,
                'expires_date' => $expiryDateFormate,
                'type' => $request->type,
                'languages_id' => $request->languages_id,
            ]);
        } else {
            $countryUpdate = DB::table('sliders_images')->where('sliders_id', $request->id)->update([
                'date_status_change' => date('Y-m-d H:i:s'),
                'sliders_title' => $title,
                'date_added' => date('Y-m-d H:i:s'),
                'sliders_url' => $sliders_url,
                'status' => $request->status,
                'expires_date' => $expiryDateFormate,
                'type' => $request->type,
                'languages_id' => $request->languages_id,
            ]);
        }

        $message = Lang::get("labels.SliderUpdatedMessage");
        return redirect()->back()->withErrors([$message]);
    }

    //deleteCountry
    public function deleteSlider(Request $request)
    {
        DB::table('sliders_images')->where('sliders_id', $request->sliders_id)->delete();
        return redirect()->back()->withErrors([Lang::get("labels.SliderDeletedMessage")]);
    }
}
