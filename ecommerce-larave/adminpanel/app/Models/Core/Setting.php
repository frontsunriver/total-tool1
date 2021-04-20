<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    public static function imageType()
    {
        $extensions = array('gif', 'jpg', 'jpeg', 'png');
        return $extensions;
    }

    //
    public function getSettings()
    {
        $setting = DB::table('settings')->orderby('id', 'ASC')->get();
        return $setting;
    }
    public function fetchLanguages()
    {
        $language = DB::table('languages')->get();
        return $language;
    }
    public function Units()
    {

        $units = DB::table('units')
            ->leftJoin('units_descriptions', 'units_descriptions.unit_id', '=', 'units.unit_id')
            ->where('is_active', '1')
            ->where('languages_id', '1')
            ->get();
        return $units;
    }

    public function getunits($language_id)
    {

        $units = DB::table('units')
            ->leftJoin('units_descriptions', 'units_descriptions.unit_id', '=', 'units.unit_id')
            ->where('is_active', '1')
            ->where('languages_id', $language_id)
            ->get();
        return $units;
    }

    public function settingmedia($requeest)
    {
        $mediasetting_Th = DB::table('settings')->where('name', 'Thumbnail_height')
            ->update(['value' => $requeest->ThumbnailHeight]);

        $mediasetting_Tw = DB::table('settings')
            ->where('name', 'Thumbnail_width')
            ->update(['value' => $requeest->ThumbnailWidth]);
        $mediasetting_Mh = DB::table('settings')
            ->where('name', 'Medium_height')
            ->update(['value' => $requeest->MediumHeight]);
        $mediasetting_Mt = DB::table('settings')
            ->where('name', 'Medium_width')
            ->update(['value' => $requeest->MediumWidth]);
        $mediasetting_Lh = DB::table('settings')
            ->where('name', 'Large_height')
            ->update(['value' => $requeest->LargeHeight]);
        $mediasetting_Lw = DB::table('settings')
            ->where('name', 'Large_width')
            ->update(['value' => $requeest->LargeWidth]);
        return "success";

    }

    public function alterSetting()
    {

        $setting = DB::table('alert_settings')->get();

        return $setting;

    }

    public function settingUpdate($key, $value)
    {
        if ($key == 'environmentt') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('.env');
            $file = base_path('.env');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $env = app()->environment();
            $file_contents = str_replace(
                "APP_ENV=$env", "APP_ENV=$value", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
            Artisan::call('cache:clear');
        }
        if ($key == 'facebook_app_id') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('config/services.php');
            $file = base_path('config/services.php');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $file_contents = str_replace(
                "'client_id' => '$qurey->value',", "'client_id' => '$value',", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
        }
        if ($key == 'facebook_secret_id') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('config/services.php');
            $file = base_path('config/services.php');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $file_contents = str_replace(
                "'client_secret' => '$qurey->value',", "'client_secret' => '$value',", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
        }
        if ($key == 'fb_redirect_url') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('config/services.php');
            $file = base_path('config/services.php');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $file_contents = str_replace(
                "'redirect' => '$qurey->value',", "'redirect' => '$value',", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
        }
        if ($key == 'google_client_id') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('config/services.php');
            $file = base_path('config/services.php');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $file_contents = str_replace(
                "'client_id' => '$qurey->value',", "'client_id' => '$value',", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
        }
        if ($key == 'google_client_secret') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('config/services.php');
            $file = base_path('config/services.php');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $file_contents = str_replace(
                "'client_secret' => '$qurey->value',", "'client_secret' => '$value',", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
        }
        if ($key == 'google_redirect_url') {
            $qurey = DB::table('settings')->where('name', $key)->first();
            $servicePath = base_path('config/services.php');
            $file = base_path('config/services.php');
            $file_contents = file_get_contents($file);
            $fh = fopen($file, "w");
            $file_contents = str_replace(
                "'redirect' => '$qurey->value',", "'redirect' => '$value',", $file_contents);
            fwrite($fh, $file_contents);
            fclose($fh);
        }

        $updateSetting = DB::table('settings')->where('name', '=', $key)->update([
            'value' => addslashes($value),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
        return $updateSetting;

    }

    public function websetting()
    {

        $settings = DB::table('settings')
            ->leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'settings.value')
            ->select('settings.*', 'categoryTable.path')
            ->orderBy('id')->get();

        return $settings;
    }

    public function getallsetting()
    {
        $settings = DB::table('settings')
            ->leftJoin('image_categories as categoryTable', 'categoryTable.image_id', '=', 'settings.value')
            ->select('settings.*', 'categoryTable.path')
            ->orderBy('id')->get();
        return $settings;
    }

    public function chkalreadyApplied($request)
    {

        $chkAlreadyApplied = DB::table('settings')->where([['name', 'website_themes'], ['value', $request->theme_id]])->get();

        return $chkAlreadyApplied;

    }

    public function appliedsetting($request)
    {

        $setting = DB::table('settings')->where('name', 'website_themes')->update(['value' => $request->theme_id]);

        return $setting;

    }

    public function appkey($result)
    {

        $consumerKey = DB::table('settings')->where('name', '=', 'consumer_key')->update([
            'value' => $result['consumerKey'],
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

        return $consumerKey;

    }

    public function consumersecret($result)
    {

        $consumersecrect = DB::table('settings')->where('name', '=', 'consumer_secret')->update([
            'value' => $result['consumerSecret'],
            'updated_at' => date('Y-m-d h:i:s'),
        ]);

        return $consumersecrect;

    }

    public function orderstatus($request)
    {

        $orders_status = DB::table('alert_settings')->where('alert_id', '=', $request->alert_id)->update([
            'create_customer_email' => $request->create_customer_email,
            'create_customer_notification' => $request->create_customer_notification,
            'order_status_email' => $request->order_status_email,
            'order_status_notification' => $request->order_status_notification,
            'new_product_email' => $request->new_product_email,
            'new_product_notification' => $request->new_product_notification,
            'forgot_email' => $request->forgot_email,
            'forgot_notification' => $request->forgot_notification,
            'contact_us_email' => $request->email_contact_us,
            'news_email' => $request->news_email,
            'news_notification' => $request->news_notification,
            'order_email' => $request->order_email,
            'order_notification' => $request->order_notification,
        ]);

        return $orders_status;

    }

    public function orderstatuses()
    {
        $orders_status = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
            ->where('orders_status.role_id', '=', 2)
            ->orderby('role_id')
            ->paginate(60);
        return $orders_status;
    }

    public function existOrderStatus($status_id, $language_id)
    {
        $exist = DB::table('orders_status_description')
            ->where('language_id', '=', $language_id)
            ->where('orders_status_id', '=', $status_id)
            ->first();
        return $exist;
    }
    public function existUnit($id, $language_id)
    {
        $exist = DB::table('units_descriptions')
            ->where('languages_id', '=', $language_id)
            ->where('unit_id', '=', $id)
            ->first();
        return $exist;
    }

    public function orderStatusesByCustomers()
    {
        $orders_status = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
            ->where('role_id', '=', '1')
            ->get();
        return $orders_status;
    }

    public function orderStatusesByVendors()
    {
        $orders_status = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
            ->where('role_id', '=', '2')
            ->get();
        return $orders_status;
    }

    public function orderStatusesByDeliveryboys()
    {
        $orders_status = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
            ->where('role_id', '=', '3')
            ->get();
        return $orders_status;
    }

    public function editorderstatus($request)
    {

        $language_id = '1';
        $result = array();

        $result['languages'] = $this->fetchLanguages();
        $orders_status = DB::table('orders_status')->where('orders_status_id', $request->id)->first();
        $result['orders_status'] = $orders_status;
        $description_data = array();
        foreach ($result['languages'] as $languages_data) {
            $description = DB::table('orders_status_description')->where([
                ['language_id', '=', $languages_data->languages_id],
                ['orders_status_id', '=', $orders_status->orders_status_id],
            ])->get();

            if (count($description) > 0) {
                $description_data[$languages_data->languages_id]['orders_status_name'] = $description[0]->orders_status_name;
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['orders_status_name'] = '';
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }

        $result['description'] = $description_data;
        // dd($result);
        return $result;

    }

    public function updateflagestatus($request)
    {
        $orders_status = DB::table('orders_status')->where('public_flag', '=', 1)->where('orders_status_id', '=', $request->id)
            ->update([
                'public_flag' => 0,
            ]);
        return $orders_status;
    }

    public function updateflag($request)
    {
        $orders_status = DB::table('orders_status')->where('orders_status_id', '=', $request->id)->update([
            'public_flag' => $request->public_flag,
            'role_id' => $request->role_id,
        ]);
        return $orders_status;
    }

    public function updateorderstatus($request, $language_id, $req_OrdersStatus)
    {
        $orders_status = DB::table('orders_status_description')
            ->where('orders_status_id', '=', $request->id)
            ->where('language_id', '=', $language_id)
            ->update([
                'orders_status_name' => $req_OrdersStatus,
            ]);
        return $orders_status;
    }

    public function deleteorderstatus($request)
    {
        $deleteorderstatus = DB::table('orders_status')->where('orders_status_id', $request->id)->delete();
        return $deleteorderstatus;
    }

    public function addneworder()
    {
        $orders_status = DB::table('orders_status')->select('orders_status_id')->orderBy('orders_status_id', 'desc')->first();
        return $orders_status;
    }

    public function addflagorderstatus()
    {

        $orders_status = DB::table('orders_status')->where('public_flag', 1)->update([
            'public_flag' => 0,
        ]);

        return $orders_status;

    }

    public function getorderstatusid($orders_status_id, $request)
    {

        $statuse_id = DB::table('orders_status')->insertGetId([
            'orders_status_id' => $orders_status_id,
            'public_flag' => $request->public_flag,
            'role_id' => $request->role_id,
            'downloads_flag' => 0,
        ]);

        return $statuse_id;

    }

    public function orderstatusadd($statuse_id, $req_OrdersStatus, $language_id)
    {
        $statusedec_id = DB::table('orders_status_description')->insert([
            'orders_status_id' => $statuse_id,
            'orders_status_name' => $req_OrdersStatus,
            'language_id' => $language_id,
        ]);
        return $statusedec_id;
    }

    public function fetchunit()
    {

        $units = DB::table('units')
            ->LeftJoin('units_descriptions', 'units_descriptions.unit_id', '=', 'units.unit_id')
            ->where('units_descriptions.languages_id', '=', '1')
            ->paginate(60);

        return $units;

    }

    public function fetchUnitid($request)
    {

        $unitId = DB::table('units')->insertGetId([

            'is_active' => $request->is_active,
        ]);

        return $unitId;

    }

    public function insetunit_desc($req_OrdersStatus, $unitId, $language_id)
    {

        $statusedec_id = DB::table('units_descriptions')->insert([
            'units_name' => $req_OrdersStatus,
            'unit_id' => $unitId,
            'languages_id' => $language_id,

        ]);

        return $statusedec_id;

    }

    public function editunit($request)
    {

        $result = array();

        $result['languages'] = $this->fetchLanguages();
        $units = DB::table('units')->where('unit_id', $request->id)->first();
        $result['units'] = $units;
        $description_data = array();
        foreach ($result['languages'] as $languages_data) {
            $description = DB::table('units_descriptions')->where([
                ['languages_id', '=', $languages_data->languages_id],
                ['unit_id', '=', $request->id],
            ])->get();

            if (count($description) > 0) {
                $description_data[$languages_data->languages_id]['units_name'] = $description[0]->units_name;
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            } else {
                $description_data[$languages_data->languages_id]['units_name'] = '';
                $description_data[$languages_data->languages_id]['language_name'] = $languages_data->name;
                $description_data[$languages_data->languages_id]['languages_id'] = $languages_data->languages_id;
            }
        }

        $result['description'] = $description_data;
        return $result;

    }

    public function updateunit($request)
    {

        $orders_status = DB::table('units')->where('unit_id', '=', $request->id)->update([

            'is_active' => $request->is_active,
        ]);

        return $orders_status;

    }

    public function updateunit_des($req_OrdersStatus, $request, $language_id)
    {

        $statusedec_id = DB::table('units_descriptions')->where('unit_id', '=', $request->id)->where('languages_id', '=', $language_id)->update([
            'units_name' => $req_OrdersStatus,
            'unit_id' => $request->id,
            'languages_id' => $language_id,

        ]);

        return $statusedec_id;

    }

    public function deleteunits($request)
    {

        DB::table('units')->where('unit_id', $request->id)->delete();
        DB::table('units_descriptions')->where('unit_id', $request->id)->delete();

        return "success";

    }

    public function commonContent()
    {
        $result = array();
        $roles = DB::table('manage_role')
                   ->where('user_types_id',Auth()->user()->role_id)
                   ->first();

        $result['roles'] = $roles;        

        $settings = DB::table('settings')->get();
        $setting = array();
        
        foreach($settings as $key=>$value){
          $setting[$value->name]=$value->value;
        }

        $result['setting'] = $setting;
        $result['new_reviews'] = DB::table('reviews')->where('reviews_read',0)->count();    

        $result['currency'] = DB::table('currencies')->where('is_default', '1')->first();

        return $result;
    }

}
