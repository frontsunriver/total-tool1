<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Alert extends Model
{

    public function getUserDevices($user_id){
      $device = DB::table('devices')->where('user_id','=', $user_id)->get();
      return $device;
    }

    public function getAlertSetting(){
      $setting = DB::table('alert_settings')->get();
      return $setting;
    }

    public function setting(){
      $setting = DB::table('settings')->get();
      return $setting;
    }

}
