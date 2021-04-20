<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Zones extends Model
{
    //

    use Sortable;
    public function country(){
        return $this->belongsTo('App\Country');
    }

    public $sortable = ['zone_id','zone_code','zone_name'];
    public $sortableAs = ['countries_name'];

    public function getter(){
      $zones = Zones::sortable(['zone_id'=>'ASC'])
        ->LeftJoin('countries','zones.zone_country_id','=','countries.countries_id')
        ->get();
      return $zones;
    }

    public function paginator(){
      $zones = Zones::sortable(['zone_id'=>'ASC'])
        ->LeftJoin('countries','zones.zone_country_id','=','countries.countries_id')
        ->paginate(30);
      return $zones;
    }

    public function filter($data){
        $name = $data['FilterBy'];
        $param = $data['parameter'];

        $result = array();
        $message = array();
        $errorMessage = array();

        switch ( $name ) {
            case 'Zone':
                $zones = Zones::sortable(['zone_id'=>'ASC'])->where('zone_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('countries','zones.zone_country_id','=','countries.countries_id')
                    ->paginate(30);
                break;
            case 'Code':
                $zones = Zones::sortable(['zone_id'=>'ASC'])->where('zone_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('countries','zones.zone_country_id','=','countries.countries_id')
                    ->paginate(30);
                break;
            case 'Country':
                $zones = Zones::sortable(['zone_id'=>'ASC'])
                    ->LeftJoin('countries','zones.zone_country_id','=','countries.countries_id')
                    ->where('countries_name', 'LIKE', '%' . $param . '%')
                    ->paginate(30);
                break;
            default:
                $zones = Zones::sortable(['zone_id'=>'ASC'])
                    ->LeftJoin('countries','zones.zone_country_id','=','countries.countries_id')
                    ->paginate(30);
                break;
        }

        return $zones;
    }

    public function getcountries(){
        $countries = DB::table('countries')->get();
        return $countries;
    }


    public function insert($request){
        $zone_id = DB::table('zones')->insertGetId([
            'zone_country_id'  	=>   $request->zone_country_id,
            'zone_code'	 		=>   $request->zone_code,
            'zone_name'			=>   $request->zone_name
        ]);
        return $zone_id;
    }

    public function edit($request){
        $zones =  DB::table('zones')->where('zone_id', $request->id)->first();
        return $zones;
    }


    public function updaterecord($request){
        DB::table('zones')->where('zone_id', $request->zone_id)->update([
            'zone_name'  		 =>   $request->zone_name,
            'zone_code'			 =>   $request->zone_code,
            'zone_country_id'	 =>   $request->zone_country_id
        ]);
    }
    public function getcountry($request){
        $country = DB::table('countries')->where('countries_id', $request->id)->get();
        return $country;
    }

    public function deleterecord($request){
      DB::table('zones')->where('zone_id', $request->id)->delete();
    }



}
