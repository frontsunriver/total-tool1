<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Tax_rate extends Model
{
    //

    use Sortable;
    public function tax_class(){
        return $this->belongsTo('App\Mdodels\Core\Tax_class');
    }

    public function zone(){
        return $this->belongsTo('App\Models\Core\Zone');
    }

    public $sortable = ['tax_rate','tax_rates_id','created_at' ];
    public $sortableAs = ['tax_class_title','zone_name' ];

    public function getZone(){
        $zones = DB::table('zones')->get();
        return $zones;
    }

    public function gettaxclass(){
        $tax_class = DB::table('tax_class')->get();
        return $tax_class;
    }

    public function pagitnator(){
        $tax_rates = Tax_rate::sortable(['tax_rates_id'=>'ASC'])
            ->LeftJoin('zones','zones.zone_id', '=', 'tax_rates.tax_zone_id')
            ->LeftJoin('tax_class','tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
            ->select('tax_rates.tax_rates_id','tax_rates.tax_zone_id','tax_rates.tax_class_id','tax_rates.tax_priority','tax_rates.tax_rate','tax_description',
                'tax_rates.created_at','tax_rates.updated_at','zones.zone_id','zones.zone_country_id','zones.zone_code','zones.zone_name','tax_class.tax_class_title','tax_class.tax_class_description')
            ->paginate(20);
        return $tax_rates;
    }

    public function getter(){
        $tax_rates = Tax_rate::sortable(['tax_rates_id'=>'ASC'])
            ->LeftJoin('zones','zones.zone_id', '=', 'tax_rates.tax_zone_id')
            ->LeftJoin('tax_class','tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
            ->select('tax_rates.tax_rates_id','tax_rates.tax_zone_id','tax_rates.tax_class_id','tax_rates.tax_priority','tax_rates.tax_rate','tax_description',
                'tax_rates.created_at','tax_rates.updated_at','zones.zone_id','zones.zone_country_id','zones.zone_code','zones.zone_name','tax_class.tax_class_title','tax_class.tax_class_description')
            ->get();
        return $tax_rates;
    }

    public function filter($request){

        $name = $request->FilterBy;
        $param = $request->parameter;

        switch ( $name ) {
            case 'Zone':
                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones','zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class','tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id','tax_rates.tax_zone_id','tax_rates.tax_class_id','tax_rates.tax_priority','tax_rates.tax_rate','tax_description',
                        'tax_rates.created_at','tax_rates.updated_at','zones.zone_id','zones.zone_country_id','zones.zone_code','zones.zone_name','tax_class.tax_class_title','tax_class.tax_class_description')
                    ->where('zones.zone_name', 'LIKE', '%' . $param . '%')
                    ->paginate(20);
                break;
            case 'TaxRates':
                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones','zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class','tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id','tax_rates.tax_zone_id','tax_rates.tax_class_id','tax_rates.tax_priority','tax_rates.tax_rate','tax_description',
                        'tax_rates.created_at','tax_rates.updated_at','zones.zone_id','zones.zone_country_id','zones.zone_code','zones.zone_name','tax_class.tax_class_title','tax_class.tax_class_description')
                    ->where('tax_rates.tax_rate', 'LIKE', '%' . $param . '%')
                    ->paginate(20);
                break;

            case 'TaxClass':
                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones','zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class','tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id','tax_rates.tax_zone_id','tax_rates.tax_class_id','tax_rates.tax_priority','tax_rates.tax_rate','tax_description',
                        'tax_rates.created_at','tax_rates.updated_at','zones.zone_id','zones.zone_country_id','zones.zone_code','zones.zone_name','tax_class.tax_class_title','tax_class.tax_class_description')
                    ->where('tax_class.tax_class_title', 'LIKE', '%' . $param . '%')
                    ->paginate(20);
                break;
            default :

                $tax_rates = Tax_rate::sortable()
                    ->LeftJoin('zones','zones.zone_id', '=', 'tax_rates.tax_zone_id')
                    ->LeftJoin('tax_class','tax_class.tax_class_id', '=', 'tax_rates.tax_class_id')
                    ->select('tax_rates.tax_rates_id','tax_rates.tax_zone_id','tax_rates.tax_class_id','tax_rates.tax_priority','tax_rates.tax_rate','tax_description',
                        'tax_rates.created_at','tax_rates.updated_at','zones.zone_id','zones.zone_country_id','zones.zone_code','zones.zone_name','tax_class.tax_class_title','tax_class.tax_class_description')
                    ->paginate(20);
                break;
        }
        return $tax_rates;
    }

    public function insert($request){
        $taxrate = DB::table('tax_rates')->insert([
            'tax_class_id'  	 =>   $request->tax_class_id,
            'tax_zone_id'		 =>   $request->tax_zone_id,
            'tax_description'	 =>   $request->tax_description,
            'tax_rate'	 		 =>   $request->tax_rate,
            'created_at'	 	 =>   date('Y-m-d H:i:s')
        ]);
        return $taxrate;
    }

    public function edit($request){
        $taxClass = DB::table('tax_rates')->where('tax_rates_id', $request->id)->first();
        return $taxClass ;
    }

    public function updaterecord($request){
        DB::table('tax_rates')->where('tax_rates_id', '=', $request->id)->update([
            'tax_class_id'  	 =>   $request->tax_class_id,
            'tax_zone_id'		 =>   $request->tax_zone_id,
            'tax_description'	 =>   $request->tax_description,
            'tax_rate'	 		 =>   $request->tax_rate,
            'updated_at'	 	 =>   date('Y-m-d H:i:s')
        ]);
    }

    public function deletetaxrate($request){
        DB::table('tax_rates')->where('tax_rates_id', $request->id)->delete();
    }


}
