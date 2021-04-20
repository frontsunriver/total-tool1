<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\Theme;
use DB;
use Illuminate\Http\Request;
use Lang;
use View;
use App\Models\Core\Setting;

class ThemeController extends Controller
{
    //

    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    public function moveToBanners($banner_id)
    {
        $result = array();
        $images = new Images();
        $theme = new Theme();
        $allimage = $images->getimages();
        $result['images'] = $allimage;
        $homeBanners = $theme->getBanners($banner_id);
        $result['languages'] = $homeBanners;
        if ($banner_id == 1) {
            $banner = (string) View::make('admin.banners_views.banner1', ['result' => $result])->render();
        } elseif ($banner_id == 2) {
            $banner = (string) View::make('admin.banners_views.banner2', ['result' => $result])->render();
        } elseif ($banner_id == 3) {
            $banner = (string) View::make('admin.banners_views.banner3', ['result' => $result])->render();
        } elseif ($banner_id == 4) {
            $banner = (string) View::make('admin.banners_views.banner4', ['result' => $result])->render();
        } elseif ($banner_id == 5) {
            $banner = (string) View::make('admin.banners_views.banner5', ['result' => $result])->render();
        } elseif ($banner_id == 6) {
            $banner = (string) View::make('admin.banners_views.banner6', ['result' => $result])->render();
        } elseif ($banner_id == 7) {
            $banner = (string) View::make('admin.banners_views.banner7', ['result' => $result])->render();
        } elseif ($banner_id == 8) {
            $banner = (string) View::make('admin.banners_views.banner8', ['result' => $result])->render();
        } elseif ($banner_id == 9) {
            $banner = (string) View::make('admin.banners_views.banner9', ['result' => $result])->render();
        } elseif ($banner_id == 10) {
            $banner = (string) View::make('admin.banners_views.banner10', ['result' => $result])->render();
        } elseif ($banner_id == 11) {
            $banner = (string) View::make('admin.banners_views.banner11', ['result' => $result])->render();
        } elseif ($banner_id == 12) {
            $banner = (string) View::make('admin.banners_views.banner12', ['result' => $result])->render();
        } elseif ($banner_id == 13) {
            $banner = (string) View::make('admin.banners_views.banner13', ['result' => $result])->render();
        } elseif ($banner_id == 14) {
            $banner = (string) View::make('admin.banners_views.banner14', ['result' => $result])->render();
        } elseif ($banner_id == 15) {
            $banner = (string) View::make('admin.banners_views.banner15', ['result' => $result])->render();
        } elseif ($banner_id == 16) {
            $banner = (string) View::make('admin.banners_views.banner16', ['result' => $result])->render();
        } elseif ($banner_id == 17) {
            $banner = (string) View::make('admin.banners_views.banner17', ['result' => $result])->render();
        } elseif ($banner_id == 18) {
            $banner = (string) View::make('admin.banners_views.banner18', ['result' => $result])->render();
        } elseif ($banner_id == 19) {
            $banner = (string) View::make('admin.banners_views.banner19', ['result' => $result])->render();
        } elseif ($banner_id == 20) {
            $banner = (string) View::make('admin.banners_views.carousal_banner1', ['result' => $result])->render();
        } elseif ($banner_id == 21) {
            $banner = (string) View::make('admin.banners_views.ad_banner1', ['result' => $result])->render();        
        } elseif ($banner_id == 41) {
            $banner = (string) View::make('admin.banners_views.ad_banner3', ['result' => $result])->render();
        }
        else {
            $banner = (string) View::make('admin.banners_views.ad_banner2', ['result' => $result])->render();
        }

        $result['commonContent'] = $this->Setting->commonContent();
        return view('admin.theme.banner_images')->with('banner', $banner)->with('result', $result);
    }

    public function moveToSliders($carousal_id)
    {
        $result = array();
        $images = new Images();
        $theme = new Theme();
        $allimage = $images->getimages();
        $result['images'] = $allimage;
        $sliders = $theme->getSliders($carousal_id);
        $result['languages'] = $sliders;
        if ($carousal_id == 1) {
            $slider = (string) View::make('admin.sliders_view.carousal1', ['result' => $result])->render();
        } elseif ($carousal_id == 2) {
            $slider = (string) View::make('admin.sliders_view.carousal2', ['result' => $result])->render();
        } elseif ($carousal_id == 3) {
            $slider = (string) View::make('admin.sliders_view.carousal3', ['result' => $result])->render();
        } elseif ($carousal_id == 4) {
            $slider = (string) View::make('admin.sliders_view.carousal4', ['result' => $result])->render();
        } else {
            $slider = (string) View::make('admin.sliders_view.carousal5', ['result' => $result])->render();
        }
        $result['commonContent'] = $this->Setting->commonContent();
        return view('admin.theme.slider_images')->with('slider', $slider)->with('result', $result);
    }

    public function updatebanner(Request $request)
    {
        $theme = new Theme();
        $theme->updateBanners($request);
        $homeBanners = $theme->getBannersForUpdate($request->style);
        return $homeBanners;
    }

    public function updateslider(Request $request)
    {
        $theme = new Theme();
        $theme->updateSliders($request);
        $sliders = $theme->getSlidersForUpdate($request->carousel_id);
        return $sliders;
    }
    public function index2($id)
    {
        $current_theme = DB::table('current_theme')->first();
        $data = DB::table('front_end_theme_content')->first();
        //dd($data);
        $settings = DB::table('settings')->get();
        $top_offers = json_decode($data->top_offers, true);
        $headers = json_decode($data->headers, true);
        $carousels = json_decode($data->carousels, true);
        $banners = json_decode($data->banners, true);
        $banners_two = json_decode($data->banners_two, true);
        $category = json_decode($data->category, true);
        $footers = json_decode($data->footers, true);
        $cart = json_decode($data->cart, true);
        $news = json_decode($data->news, true);
        $detail = json_decode($data->detail, true);
        $shop = json_decode($data->shop, true);
        $contact = json_decode($data->contact, true);
        $login = json_decode($data->login, true);
        $news = json_decode($data->news, true);
        //$news = json_decode($data->news, true);
        $transitions = json_decode($data->transitions, true);

        $product_section_order = json_decode($data->product_section_order, true);
        $data = array();
        $data['top_offers'] = $top_offers;
        $data['headers'] = $headers;
        $data['carousels'] = $carousels;
        $data['banners'] = $banners;
        $data['banners_two'] = $banners_two;
        $data['category'] = $category;
        $data['footers'] = $footers;
        $data['product_section_order'] = $product_section_order;
        $data['cart'] = $cart;
        //$data['blog'] = $news;
        $data['detail'] = $detail;
        $data['shop'] = $shop;
        $data['contact'] = $contact;
        $data['section_id'] = $id;
        $data['settings'] = $settings;
        $data['login'] = $login;
        $data['news'] = $news;
        $data['transitions'] = $transitions;
        $categories = DB::table('categories')
            ->leftJoin('categories_description','categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories.categories_id as id', 'categories.categories_image as image',  'categories.created_at as date_added', 
            'categories.updated_at as last_modified', 'categories_description.categories_name as name', 'categories.categories_slug as slug'
            , 'categories.parent_id')
            ->where('categories_description.language_id','=', 1 )
            //->where('parent_id', '0')
            ->where('categories_status', '1')
            ->get();
      
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.theme.index")->with(['data' => $data, 'result' => $result, 'current_theme' => $current_theme, 'categories'=>$categories]);
    }

    public function index()
    {
        $current_theme = DB::table('current_theme')->first();
        $data = DB::table('front_end_theme_content')->first();
        $headers = json_decode($data->headers, true);
        $carousels = json_decode($data->carousels, true);
        $banners = json_decode($data->banners, true);
        $footers = json_decode($data->footers, true);
        $cart = json_decode($data->cart, true);
        $news = json_decode($data->news, true);
        $detail = json_decode($data->detail, true);
        $shop = json_decode($data->shop, true);
        $contact = json_decode($data->contact, true);
        $login = json_decode($data->login, true);
        $banners_two = json_decode($data->banners_two, true);
        $category = json_decode($data->category, true);

        $product_section_order = json_decode($data->product_section_order, true);
        $data = array();
        $data['headers'] = $headers;
        $data['carousels'] = $carousels;
        $data['banners'] = $banners;
        $data['footers'] = $footers;
        $data['product_section_order'] = $product_section_order;
        $data['cart'] = $cart;
        $data['blog'] = $news;
        $data['detail'] = $detail;
        $data['shop'] = $shop;
        $data['contact'] = $contact;
        $data['login'] = $login;
        $data['banners_two'] = $banners_two;
        $data['category'] = $category;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.theme.index")->with(['data' => $data, 'result' => $result, 'current_theme' => $current_theme]);
    }

    public function set(Request $request)
    {
        $header_id = $request['request']['header_id'];
        $carousel_id = $request['request']['carousel_id'];
        $banner_id = $request['request']['banner_id'];
        $footer_id = $request['request']['footer_id'];
        $cart = $request['request']['cart_id'];
        $news = $request['request']['news_id'];
        $detail = $request['request']['detail_id'];
        $shop = $request['request']['shop_id'];
        $contact = $request['request']['contact_id'];

        $product_section_order = DB::table('front_end_theme_content')->select('product_section_order')->first();
        $product_section_order = $product_section_order->product_section_order;

        $response = DB::table('current_theme')
            ->where('id', 1)
            ->update([
                'header' => $header_id,
                'carousel' => $carousel_id,
                'banner' => $banner_id,
                'footer' => $footer_id,
                'cart' => $cart,
                'news' => $news,
                'detail' => $detail,
                'shop' => $shop,
                'contact' => $contact,
                'product_section_order' => $product_section_order,
            ]);

        return $response;
    }

    public function setPages(Request $request)
    {
        if ($request->page == 2) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'cart' => $request->cart_id,
                ]);
           // return redirect('viewcart');
        }
        if ($request->page == 3) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'news' => $request->news_id,
                ]);
         //   return redirect('news');
        }
        if ($request->page == 4) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'detail' => $request->detail_id,
                ]);
          //  return redirect('/');
        }
        if ($request->page == 5) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'shop' => $request->shop_id,
                ]);
          //  return redirect('shop');
        }
        if ($request->page == 6) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'contact' => $request->contact_id,
                ]);
         //   return redirect('contact');
        }
        if ($request->page == 7) {
            DB::table('settings')->where('name', '=', 'web_color_style')->update([
                'value' => $request->web_color_style,
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
          //  return redirect()->back();
        }

        if ($request->page == 8) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'login' => $request->login_id,
                ]);
           // return redirect('login');
        }

        if ($request->page == 9) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'news' => $request->news_id,
                ]);
           // return redirect('news');
        }
        
        if ($request->page == 10) {
            DB::table('current_theme')
                ->where('id', 1)
                ->update([
                    'transitions' => $request->transitions_id,
                ]);
            //    return redirect('/');
        }

        if ($request->page == 11) {
            DB::table('settings')->where('name', '=', 'web_card_style')->update([
                'value' => $request->web_card_style,
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
           // return redirect()->back();
        }
        if ($request->page == 12) {
            DB::table('settings')->where('name', '=', 'home_categories_img_icn')->update([
                'value' => $request->home_categories_img_icn,
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
            DB::table('settings')->where('name', '=', 'home_categories_records')->update([
                'value' => $request->home_categories_records,
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
            //return redirect()->back();
        }

        if ($request->page == 13) {
            $home_category = array_filter($request->home_category);
            $home_category = implode(',',$home_category);
            DB::table('settings')->where('name', '=', 'home_category')->update([
                'value' => $home_category,
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
            //return redirect()->back();
        }
            return redirect()->back();
    }

    public function reorder(Request $request)
    {
        $product_section_orders = json_encode($request->product_section_orders, true);
        DB::table('front_end_theme_content')
            ->where('id', 1)
            ->update([
                'product_section_order' => $product_section_orders,
            ]);
    }

    public function changestatus(Request $request)
    {
        $json = $request->product_section_orders;
        foreach ($json as $key => $var) {
            if ($var['id'] == $request->id) {
                if ($var['status'] == 1) {
                    $json[$key]['status'] = 0;
                } else {
                    $json[$key]['status'] = 1;
                }
            }
        }
        $json1 = json_encode($json, true);
        DB::table('front_end_theme_content')
            ->where('id', 1)
            ->update([
                'product_section_order' => $json1,
            ]);
        return $json;
    }

    public function topoffer(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingTaxClasses"));

        $theme = new Theme();
        $result['offer'] = $theme->topoffer();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.theme.topoffer", $title)->with('result', $result);
    }

    public function updateTopOffer(Request $request)
    {
        $theme = new Theme();
        $result = $theme->updateTopOffer($request);
        $message = Lang::get("labels.Top offer has been updated successfully");
        return redirect()->back()->withErrors([$message]);

    }

}
