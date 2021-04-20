<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Http\Controllers\Controller;
use App\Models\Core\Images;
use App\Models\Core\News;
use App\Models\Core\NewsCategory;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Lang;

class NewsController extends Controller
{

    public function __construct(News $news, NewsCategory $news_category, Images $images, Setting $setting)
    {
        $this->News = $news;
        $this->NewsCategory = $news_category;
        $this->images = $images;
        $this->myVarsetting = new SiteSettingController($setting);
        $this->myalertsetting = new AlertController($setting);
        $this->Setting = $setting;

    }

    public function display(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.News"));
        $news = $this->News->paginator();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.news.index", $title)->with('news', $news)->with('result', $result);
    }

    public function add(Request $request)
    {

        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.AddNews"));
        $language_id = '1';
        $result = array();
        $result['newsCategories'] = $this->NewsCategory->getter($language_id);
        $result['languages'] = $this->myVarsetting->getLanguages();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.news.add", $title)->with('result', $result)->with('allimage', $allimage);

    }

    //addNewNews
    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddNews"));
        $news_id = $this->News->insert($request);
        $alertSetting = $this->myalertsetting->newsNotification($news_id);
        $message = Lang::get("labels.Newshasbeenaddedsuccessfully");
        return redirect()->back()->withErrors([$message]);
    }

    //editnew
    public function edit(Request $request)
    {
        $allimage = $this->images->getimages();
        $title = array('pageTitle' => Lang::get("labels.EditNews"));
        $result = $this->News->edit($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.news.edit", $title)->with('result', $result)->with('allimage', $allimage);
    }

    //updatenew
    public function update(Request $request)
    {
        $this->News->updaterecord($request);
        $message = Lang::get("labels.Newshasbeenupdatedsuccessfully");
        return redirect()->back()->withErrors([$message]);
    }

    //deleteNews
    public function delete(Request $request)
    {
        $this->News->destroyrecord($request);
        return redirect()->back()->withErrors(['News has been deleted successfully!']);
    }

    public function filter(Request $request)
    {
        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.News"));
        $news = $this->News->filter($request);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.news.index", $title)->with('news', $news)->with('result', $result)->with('name', $name)->with('param', $param);
    }

}
