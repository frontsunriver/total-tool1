<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\Core\Setting;

class DeliveryBoysStatus extends Model
{

    public function orderstatuses()
    {
        $orders_status = DB::table('orders_status')
            ->LeftJoin('orders_status_description', 'orders_status_description.orders_status_id', '=', 'orders_status.orders_status_id')
            ->LeftJoin('languages', 'languages.languages_id', '=', 'orders_status_description.language_id')
            ->where('orders_status_description.language_id', '=', '1')
            ->where('orders_status.role_id', '=', 3)
            ->paginate(60);
        return $orders_status;
    }

    public function addnew()
    {
        $orders_status = DB::table('orders_status')->select('orders_status_id')->orderBy('orders_status_id', 'desc')->first();
        return $orders_status;
    }

    public function getorderstatusid($orders_status_id, $request)
    {

        $statuse_id = DB::table('orders_status')->insertGetId([
            'orders_status_id' => $orders_status_id,
            'public_flag' => $request->public_flag,
            'role_id' => 3,
            'downloads_flag' => 0,
        ]);

        return $statuse_id;

    }

    public function statusadd($statuse_id, $req_OrdersStatus, $language_id)
    {
        $statusedec_id = DB::table('orders_status_description')->insert([
            'orders_status_id' => $statuse_id,
            'orders_status_name' => $req_OrdersStatus,
            'language_id' => $language_id,
        ]);
        return $statusedec_id;
    }

    public function existOrderStatus($status_id, $language_id)
    {
        $exist = DB::table('orders_status_description')
            ->where('language_id', '=', $language_id)
            ->where('orders_status_id', '=', $status_id)
            ->first();
        return $exist;
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

        $setting = new Setting();

        $result['languages'] = $setting->fetchLanguages();
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
        return $result;

    }
    
    public function deleterecord($request)
    {
        $data = DB::table('orders_status')->where('orders_status_id', $request->id)->delete();
        return $data;
    }

}
