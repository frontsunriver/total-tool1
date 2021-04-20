<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Countries extends Model
{

    use Sortable;
    public $sortable = ['countries_id','countries_name','countries_iso_code_2','countries_iso_code_3'];

    public function getter(){
      $countries = Countries::sortable(['countries_id'=>'ASC'])->get();
        return $countries;
    }

    public function paginator(){
      $countries = Countries::sortable(['countries_id'=>'ASC'])->paginate(30);
        return $countries;
    }

    public function filter($data){

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        $countryData = array();
        $message = array();
        $errorMessage = array();

        switch ( $name ) {
            case 'CountryName':
                 $countries = Countries::sortable(['countries_id'=>'ASC'])->where('countries_name', 'LIKE', '%' . $param . '%')
                    ->orderBy('countries_id','ASC')
                    ->paginate(30);
                break;
            case 'ISOCode2':
                $countries = Countries::sortable(['countries_id'=>'ASC'])->where('countries_iso_code_2', 'LIKE', '%' . $param . '%')
                    ->paginate(30);
                break;
            case 'ISOCode3':

                $countries = Countries::sortable(['countries_id'=>'ASC'])->where('countries_iso_code_3', 'LIKE', '%' . $param . '%')
                    ->paginate(30);
                break;
           default :
             $countries = Countries::sortable(['countries_id'=>'ASC'])->paginate(30);
              break;
        }
        return $countries;
    }

    public function insert($request){
        $country_id = DB::table('countries')->insertGetId([
            'countries_name'  		 =>   $request->countries_name,
            'countries_iso_code_2'	 =>   $request->countries_iso_code_2,
            'countries_iso_code_3'	 =>   $request->countries_iso_code_3,
            'address_format_id'	 =>   1
        ]);
        return $country_id;
    }

    public function edit($id){
      $country = Countries::where('countries_id', $id)->first();
      return $country;
    }

    public function updaterecord($request){
        $countryUpdate = DB::table('countries')->where('countries_id', $request->id)->update([
            'countries_name'  		 =>   $request->countries_name,
            'countries_iso_code_2'	 =>   $request->countries_iso_code_2,
            'countries_iso_code_3'	 =>   $request->countries_iso_code_3
        ]);
        return $countryUpdate;
    }

    public function deleterecord($request){
      $deletecountry = DB::table('countries')->where('countries_id', $request->id)->delete();
    }

    public function getcountry($request){
      $country = DB::table('countries')->where('countries_id', $request->id)->get();
      return $country;
    }





}
