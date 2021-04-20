<?php

namespace App\Models\Core;

use App\Http\Controllers\AdminControllers\AlertController;
use App\Http\Controllers\AdminControllers\SiteSettingController;
use App\Models\Core\NewsCategory;
use App\Models\Core\NewsToNewsCategory;
use App\Models\Core\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Lang;

class News extends Model
{

    public $sortable = ['news_id', 'is_feature', 'created_at'];
    public $sortableAs = ['news_name'];
    protected $table = "news";
    use Sortable;

    public function images()
    {
        return $this->belongsTo('App\Images');
    }

    public function news_categories_description()
    {
        return $this->belongsTo('App\News_categories_description');
    }

    public function paginator()
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $commonsetting = $myVarsetting->commonsetting();

        $language_id = '1';

        $news = $this->sortable(['news_id' => 'ASC'])
            ->leftJoin('news_description', 'news_description.news_id', '=', 'news.news_id')
            ->leftJoin('image_categories', 'image_categories.image_id', '=', 'news.news_image')
            ->select('image_categories.path as path', 'news.*', 'news_description.*')
            ->where('news_description.language_id', '=', $language_id)
            ->orderBy('news.news_id', 'ASC')
            ->paginate($commonsetting['pagination']);

        return $news;
    }

    public function getter($language_id)
    {
        if ($language_id == null) {
            $language_id = '1';
        }
        $news = DB::table('news_to_news_categories')
            ->leftJoin('news_categories', 'news_categories.categories_id', '=', 'news_to_news_categories.categories_id')
            ->leftJoin('news', 'news.news_id', '=', 'news_to_news_categories.news_id')
            ->leftJoin('news_description', 'news_description.news_id', '=', 'news.news_id')
            ->leftJoin('news_categories_description', 'news_categories_description.categories_id', '=', 'news_to_news_categories.categories_id')
            ->select('news_to_news_categories.*', 'news_categories_description.categories_name', 'news_categories.*', 'news.*', 'news_description.*')
            ->where('news_description.language_id', '=', $language_id)
            ->where('news_categories_description.language_id', '=', $language_id)
            ->orderBy('news.news_id', 'ASC')
            ->get();
        return $news;
    }

    public function insert($request)
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $myVaralter = new AlertController($setting);
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        $date_added = date('Y-m-d h:i:s');
        if ($request->image_id !== null) {
            $uploadImage = $request->image_id;
        } else {
            $uploadImage = '';
        }

        $news_id = DB::table('news')->insertGetId([
            'news_image' => $uploadImage,
            'created_at' => $date_added,
            'news_status' => $request->news_status,
            'news_slug' => '0',
            'is_feature' => $request->is_feature,
        ]);
        $slug_flag = false;
        foreach ($languages as $languages_data) {
            $news_name = 'news_name_' . $languages_data->languages_id;
            $news_description = 'news_description_' . $languages_data->languages_id;
            if ($slug_flag == false) {
                $slug_flag = true;
                $slug = $request->$news_name;
                $old_slug = $request->$news_name;
                $slug_count = 0;
                do {
                    if ($slug_count == 0) {
                        $currentSlug = $myVarsetting->slugify($slug);
                    } else {
                        $currentSlug = $myVarsetting->slugify($old_slug . '-' . $slug_count);
                    }
                    $slug = $currentSlug;
                    $checkSlug = DB::table('news')->where('news_slug', $currentSlug)->get();
                    $slug_count++;
                } while (count($checkSlug) > 0);
                DB::table('news')->where('news_id', $news_id)->update([
                    'news_slug' => $slug,
                ]);
            }

            $requestnewsname = $request->$news_name;
            $languages_data_id = $languages_data->languages_id;
            $requestnews_description = $request->$news_description;
            $insertnews_des = DB::table('news_description')->insert([
                'news_name' => $requestnewsname,
                'language_id' => $languages_data_id,
                'news_id' => $news_id,
                'news_url' => '0',
                'news_viewed' => '0',
                'news_description' => addslashes($requestnews_description),
            ]);

        }

        DB::table('news_to_news_categories')->insert([
            'news_id' => $news_id,
            'categories_id' => $request->category_id,
            'created_at' => $date_added,
        ]);
        return $news_id;
    }

    public function edit($request)
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $myVaralter = new AlertController($setting);
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        $language_id = '1';
        $news_id = $request->id;
        $category_id = '0';
        $result = array();
        $newsCategory = new NewsCategory();
        $result['categories'] = $newsCategory->getter($language_id);
        $result['languages'] = $myVarsetting->getLanguages();
        $news = $this->GetNewsById($news_id);
        $description_data = array();
        foreach ($result['languages'] as $languages_data) {

            $description = DB::table('news_description')->where([
                ['language_id', '=', $languages_data->languages_id],
                ['news_id', '=', $news_id],
            ])->get();

            if (count($description) > 0) {
                $description_data[$languages_data->languages_id]['news_name'] = $description[0]->news_name;
                $description_data[$languages_data->languages_id]['news_description'] = $description[0]->news_description;
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['news_name'] = '';
                $description_data[$languages_data->languages_id]['news_description'] = '';
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }
        $result['description'] = $description_data;
        $result['news'] = $news;
        $newsCategory = DB::table('news_to_news_categories')->where('news_id', '=', $news_id)->get();
        $result['categoryId'] = $newsCategory;
        $categories = DB::table('news_categories')
            ->leftJoin('news_categories_description', 'news_categories_description.categories_id', '=', 'news_categories.categories_id')
            ->select('news_categories.categories_id as id', 'news_categories_description.categories_name as name', 'news_categories.categories_id')
            ->where('news_categories.categories_id', '=', $result['categoryId'][0]->categories_id)->get();

        $result['editCategory'] = $categories;
        return $result;
    }

    public function updaterecord($request)
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $myVaralter = new AlertController($setting);
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        $language_id = '1';
        $news_id = $request->id;
        $news_last_modified = date('Y-m-d h:i:s');
        $languages = $myVarsetting->getLanguages();
        $extensions = $myVarsetting->imageType();

        if ($request->old_slug != $request->slug) {
            $slug = $request->slug;
            $slug_count = 0;
            do {
                if ($slug_count == 0) {
                    $currentSlug = $myVarsetting->slugify($request->slug);
                } else {
                    $currentSlug = $myVarsetting->slugify($request->slug . '-' . $slug_count);
                }
                $slug = $currentSlug;
                $checkSlug = DB::table('news')->where('news_slug', $currentSlug)->where('news_id', '!=', $news_id)->get();
                $slug_count++;
            } while (count($checkSlug) > 0);

        } else {
            $slug = $request->slug;
        }

        if ($request->image_id) {
            $uploadImage = $request->image_id;

        } else {
            $uploadImage = $request->oldImage;
        }

        DB::table('news')->where('news_id', '=', $news_id)->update([
            'news_image' => $uploadImage,
            'updated_at' => $news_last_modified,
            'news_status' => $request->news_status,
            'is_feature' => $request->is_feature,
            'news_slug' => $slug,
        ]);

        foreach ($languages as $languages_data) {
            $news_name = 'news_name_' . $languages_data->languages_id;
            $news_description = 'news_description_' . $languages_data->languages_id;
            $languages_data_id = $languages_data->languages_id;
            $checkExist = DB::table('news_description')->where('news_id', '=', $news_id)->where('language_id', '=', $languages_data_id)->get();

            if (count($checkExist) > 0) {

                $languages_data__id = $languages_data->languages_id;
                $req_news_description = $request->$news_description;
                $request_name = $request->$news_name;
                DB::table('news_description')->where('news_id', '=', $news_id)->where('language_id', '=', $languages_data__id)->update([
                    'news_name' => $request_name,
                    'news_url' => '0',
                    'news_description' => addslashes($req_news_description),
                ]);

            } else {
                $languages_data__id = $languages_data->languages_id;
                $req_news_description = $request->$news_description;
                $request_name = $request->$news_name;
                DB::table('news_description')->insert([
                    'news_name' => $request_name,
                    'language_id' => $languages_data__id,
                    'news_id' => $news_id,
                    'news_url' => '0',
                    'news_description' => addslashes($req_news_description),
                ]);
            }
        }

        DB::table('news_to_news_categories')->where('news_id', '=', $news_id)->update([
            'updated_at' => $news_last_modified,
            'categories_id' => $request->category_id,
        ]);
    }

    public function filter($request)
    {
        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $commonsetting = $myVarsetting->commonsetting();

        $name = $request->FilterBy;
        $param = $request->parameter;
        $title = array('pageTitle' => Lang::get("labels.MainCategories"));
        $language_id = '1';

        if ($name == "Name") {

            $news = $this->sortable(['news_id' => 'ASC'])
            ->leftJoin('news_description', 'news_description.news_id', '=', 'news.news_id')
            ->leftJoin('image_categories', 'image_categories.image_id', '=', 'news.news_image')
            ->select('image_categories.path as path', 'news.*', 'news_description.*')
            ->where('news_description.language_id', '=', $language_id)
            ->where('news_description.news_name', 'LIKE', '%' . $param . '%')
            ->orderBy('news.news_id', 'ASC')
            ->paginate($commonsetting['pagination']);
        } else {
            $news =  $this->paginator();

        }

        return $news;
    }

    public function GetNewsById($news_id)
    {

        $news = DB::table('news')
            ->leftJoin('images', 'images.id', '=', 'news.news_image')
            ->leftJoin('image_categories', 'image_categories.image_id', '=', 'news.news_image')
            ->select('news.*', 'image_categories.path as path')
            ->where('news.news_id', '=', $news_id)
            ->get();
        return $news;
    }

    public function destroyrecord($request)
    {
        DB::table('news')->where('news_id', $request->id)->delete();
        DB::table('news_description')->where('news_id', $request->id)->delete();
        DB::table('news_to_news_categories')->where('news_id', $request->id)->delete();
        return 'success';
    }

}
