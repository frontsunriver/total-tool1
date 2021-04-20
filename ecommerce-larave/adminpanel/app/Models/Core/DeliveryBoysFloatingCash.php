<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class DeliveryBoysFloatingCash extends Model
{
    //
    use Sortable;
    protected $table = 'floating_cash';
    public function address_book()
    {
        return $this->belongsTo('App\address_book');
    }

    public function vendors_info()
    {
        return $this->belongsTo('App\vendors_info');
    }

    public function countryrelation()
    {
        return $this->belongsTo('App\Country');
    }

    public function zone()
    {
        return $this->belongsTo('App\Zone');
    }

    public function images()
    {
        return $this->belongsTo('App\Images');
    }

    public $sortableAs = ['first_name'];
    public $sortable = ['floating_cash_id', 'created_at', 'amount'];

    public function getter()
    {
        $data = DeliveryBoysFloatingCash::sortable(['floating_cash_id' => 'DESC'])
            ->join('users', 'users.id', '=', 'floating_cash.deliveryboy_id')
            ->select(
                'floating_cash.*',
                'users.first_name',
                'users.last_name'
            )
            ->where('role_id', '4')
            ->get();

        return $data;
    }

    public function floatingCashAmountById($id)
    {
        $cash = DB::table('floating_cash')->where('floating_cash.deliveryboy_id', $id)
            ->where('status', '0')->sum('amount');                
        
        return $cash;
    }

    public function recievedpayment($request)
    {
        $floating_cash = DB::table('floating_cash')->where('orders_id', '=', $request->orders_id)->first();

        DB::table('floating_cash')->where('orders_id', '=', $request->orders_id)->update([
            'status' => 1,
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
    }

}
