<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Core\Setting;
use App\Models\Core\Images;
use App\Http\Controllers\AdminControllers\SiteSettingController;


class Deliveryrates extends Model
{

    use Sortable;
    protected $table = 'delievery_time_slot_with_zone';

    public function zone(){
        return $this->belongsTo('App\Zone');
    }

    public $sortable = ['delievery_time_slot_with_zone_id','time_from', 'time_to', 'status', 'expired_at', 'updated_at'];
    public $sortableAs = ['zone_name'];


  public function paginator(){

    $setting = new Setting();
    $myVarsetting = new SiteSettingController($setting);
    $commonsetting = $myVarsetting->commonsetting();

    $deliveryrates =   $this->sortable('delievery_time_slot_with_zone_id','ASC')
        ->LeftJoin('zones','zones.zone_id','=', 'delievery_time_slot_with_zone.zone_id')
        ->paginate($commonsetting['pagination']);
        return $deliveryrates;
  }

  public function getter(){

    $deliveryrates =   $this->sortable('delievery_time_slot_with_zone_id','ASC')
        ->LeftJoin('zones','zones.zone_id','=', 'delievery_time_slot_with_zone.zone_id')
        ->get();
    return $deliveryrates;

  }

  public function zones(){
    $zones = DB::table('zones')->get();
    return $zones;
  }

  public function insert($request){

    $date = date('m/d/Y', time());
		$len = strlen($request->time_duration);
		$timeFrom = substr($request->time_duration, 0, 7);
		$timeFrom = strtotime($date.' '.$timeFrom);

		$timeTo = substr($request->time_duration, 8, $len);
		$timeTo = strtotime($date.' '.$timeTo);

		DB::table('delievery_time_slot_with_zone')->insert([
				'time_from'  	 	 =>   $timeFrom,
				'time_to'		 	 =>   $timeTo,
				'zone_id'			 =>   $request->zone_id,
				'delivery_price'	 =>   $request->delivery_price,
				]);
  }

    public function edit($request){
      $deliveryrates =   DB::table('delievery_time_slot_with_zone')
          ->LeftJoin('zones','zones.zone_id','=', 'delievery_time_slot_with_zone.zone_id')
          ->where('delievery_time_slot_with_zone_id',$request->id)
          ->first();

      $time_from = date('h:iA',$deliveryrates->time_from);
      $time_to = date('h:iA',$deliveryrates->time_to);
      $deliveryrates->time_duration = strtoupper($time_from .'-'. $time_to);
      //dd($deliveryrates->time_duration);
      return $deliveryrates;
    }

    public function updaterecord($request){

      $date = date('m/d/Y', time());
  		$len = strlen($request->time_duration);
  		$timeFrom = substr($request->time_duration, 0, 7);
  		$timeFrom = strtotime($date.' '.$timeFrom);

  		$timeTo = substr($request->time_duration, 8, $len);
  		$timeTo = strtotime($date.' '.$timeTo);

      DB::table('delievery_time_slot_with_zone')->where('delievery_time_slot_with_zone_id','=',$request->id)->update([
        'time_from'  	 	 =>   $timeFrom,
        'time_to'		 	 =>   $timeTo,
        'zone_id'			 =>   $request->zone_id,
        'delivery_price'	 =>   $request->delivery_price,
      ]);

    }

    public function destroyrecord($request){
      DB::table('delievery_time_slot_with_zone')->where('delievery_time_slot_with_zone_id', $request->id)->delete();
    }

    public function filter($name,$param){

        $setting = new Setting();
        $myVarsetting = new SiteSettingController($setting);
        $commonsetting = $myVarsetting->commonsetting();

          if($name=="Zones"){
            $deliveryrates =   $this->sortable('delievery_time_slot_with_zone_id','ASC')
                ->LeftJoin('zones','zones.zone_id','=', 'delievery_time_slot_with_zone.zone_id')
                ->where('zones.zone_name', 'LIKE', '%' . $param . '%')
                ->paginate($commonsetting['pagination']);

          }else{
              $deliveryrates =   $this->sortable('delievery_time_slot_with_zone_id','ASC')
                ->LeftJoin('zones','zones.zone_id','=', 'delievery_time_slot_with_zone.zone_id')
                ->paginate($commonsetting['pagination']);
          }

          return $deliveryrates;

    }


}
