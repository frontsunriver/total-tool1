<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\NewsCategory;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class NewsCategoriesController extends Controller
{

    public function __construct(NewsCategory $news_category, Setting $setting, Images $images)
    {
        $this->myVarsetting = new SiteSettingController($setting);
        $this->News_category = $news_category;
        $this->images = $images;
        $this->Setting = $setting;

    }

    public function getNewsCategories($language_id)
    {
        $getCategories = $this->News_category->getNewsCategory($language_id);
        return ($getCategories);
    }

    public function display()
    {
        $title = array('pageTitle' => Lang::get("labels.NewsCategories"));
        $listingCategories = $this->News_category->paginator();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.newscategories.index", $title)->with('result', $result)->with('listingCategories', $listingCategories);

    }

    //add category
    public function add(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.AddNewsCategories"));
        $result = array();
        $result['message'] = array();
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.newscategories.add", $title)->with('result', $result)->with('allimage', $allimage);

    }

    //addNewCategory
    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddNewsCategories"));
        $this->News_category->insert($request);
        $message = Lang::get("labels.NewsCategoriesAddedMessage");
        return redirect()->back()->withErrors([$message]);

    }

    public function edit(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditNewsCategories"));
        $allimage = $this->images->getimages();
        $result = $this->News_category->edit($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.newscategories.edit", $title)->with('result', $result)->with('allimage', $allimage);

    }

    //updateCategory
    public function update(Request $request)
    {

        $title = array('pageTitle' => Lang::get("labels.EditNewsCategories"));
        $last_modified = date('y-m-d h:i:s');
        $categories_id = $request->id;
        $result = array();

        //get function from other controller
        $languages = $this->myVarsetting->getLanguages();
        $extensions = $this->myVarsetting->imageType();
        $categories_status = $request->categories_status;
        //check slug
        if ($request->old_slug != $request->slug) {
            $slug = $request->slug;
            $slug_count = 0;
            do {
                if ($slug_count == 0) {
                    $currentSlug = $this->myVarsetting->slugify($request->slug);
                } else {
                    $currentSlug = $this->myVarsetting->slugify($request->slug . '-' . $slug_count);
                }
                $slug = $currentSlug;
                $checkSlug = DB::table('news_categories')
                    ->where('news_categories_slug', $currentSlug)
                    ->where('categories_id', '!=', $request->id)
                    ->get();
                $slug_count++;
            } while (count($checkSlug) > 0);

        } else {
            $slug = $request->slug;
        }

        if ($request->image_id !== null) {

            $uploadImage = $request->image_id;

        } else {
            $uploadImage = $request->oldImage;
        }

        $uploadIcon = "";

        DB::table('news_categories')->where('categories_id', $request->id)->update([
            'categories_image' => $uploadImage,
            'last_modified' => $last_modified,
            'categories_icon' => $uploadIcon,
            'news_categories_slug' => $slug,
            'categories_status' => $categories_status,
        ]);

        foreach ($languages as $languages_data) {
            $categories_name = 'category_name_' . $languages_data->languages_id;

            $checkExist = DB::table('news_categories_description')->where('categories_id', '=', $categories_id)->where('language_id', '=', $languages_data->languages_id)->get();
            if (count($checkExist) > 0) {
                DB::table('news_categories_description')->where('categories_id', '=', $categories_id)->where('language_id', '=', $languages_data->languages_id)->update([
                    'categories_name' => $request->$categories_name,
                ]);
            } else {
                DB::table('news_categories_description')->insert([
                    'categories_name' => $request->$categories_name,
                    'language_id' => $languages_data->languages_id,
                    'categories_id' => $categories_id,
                ]);
            }
        }

        $message = Lang::get("labels.NewsCategoriesUpdatedMessage");
        return redirect()->back()->withErrors([$message]);

    }

    //deleteNewsCategory
    public function delete(Request $request)
    {

        $this->News_category->destroyrecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.NewsCategoriesDeletedMessage")]);

    }

    public function filter(Request $request)
    {
        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.MainCategories"));
        $listingCategories = $this->News_category->filter($name, $param);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.newscategories.index", $title)->with('result', $result)->with('listingCategories', $listingCategories)->with('name', $name)->with('param', $param);

    }

}
