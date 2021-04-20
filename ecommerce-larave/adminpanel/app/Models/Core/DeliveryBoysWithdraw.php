<?php

namespace App\Models\Core;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;
use Kyslik\ColumnSortable\Sortable;
use App\Http\Controllers\AdminControllers\SiteSettingController;

class DeliveryBoysWithdraw extends Model
{
    //
    use Sortable;
    protected $table = 'payment_withdraw';
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
    public $sortable = ['payment_withdraw_id', 'created_at', 'amount'];

    public function getter()
    {
        $data = DeliveryBoysWithdraw::sortable(['payment_withdraw_id'=>'DESC'])
            ->join('users', 'users.id', '=', 'payment_withdraw.user_id')            
            ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')
            ->select(
                'payment_withdraw.*',
                'users.first_name',
                'users.last_name',
                'bank_detail.bank_name',
                'bank_detail.bank_account_number',
                'bank_detail.bank_routing_number',
                'bank_detail.bank_address',
                'bank_detail.bank_iban',
                'bank_detail.bank_swift'
            )
            ->where('role_id', '4')
            // ->where('is_current', 1)
            ->groupby('users.id')
            ->get();      
       
        return $data;
    }

    public function withdrawbyid($id)
    {
        $user = DeliveryBoysWithdraw::sortable(['payment_withdraw_id'=>'DESC'])
            ->join('orders_to_delivery_boy', 'orders_to_delivery_boy.deliveryboy_id', '=', 'payment_withdraw.user_id')
            ->join('orders', 'orders.orders_id', '=', 'orders.orders_id')
            ->join('users', 'users.id', '=', 'payment_withdraw.user_id')            
            ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')
            ->select(
                'orders.*',
                'users.first_name',
                'users.last_name',
                'bank_detail.bank_name',
                'bank_detail.bank_account_number',
                'bank_detail.bank_routing_number',
                'bank_detail.bank_address',
                'bank_detail.bank_iban',
                'bank_detail.bank_swift',
                'payment_withdraw.*'
            )
            ->where('role_id', '4')
            ->where('users.id', $id)
            ->where('orders_to_delivery_boy.is_current', 1)
            ->where('bank_detail.is_current', 1)
            ->groupby('users.id')
            ->get();                   
       
        return $user;
    }

    public function updatenewuser()
    {
        DB::table('users')->where('role_id', '=', 4)->update([
            'is_seen'		 	=>   1
        ]);
    }

    public function paginator()
    {
        $user = DeliveryBoysWithdraw::sortable(['payment_withdraw_id'=>'DESC'])
            ->join('users', 'users.id', '=', 'payment_withdraw.user_id')            
            ->LeftJoin('bank_detail', 'bank_detail.users_id', '=', 'users.id')
            ->select(
                'payment_withdraw.*',
                'users.first_name',
                'users.last_name',
                'bank_detail.bank_name',
                'bank_detail.bank_account_number',
                'bank_detail.bank_routing_number',
                'bank_detail.bank_address',
                'bank_detail.bank_iban',
                'bank_detail.bank_swift'
            )
            ->where('users.role_id', '4')
            ->where('is_current', 1)
          //  ->where('orders_id', '!=', 0)    
            ->paginate(10);  

        return $user;
    }

    public function withdrawAmountById($id)
    {
        $cash = DB::table('payment_withdraw')->where('user_id', $id)
            ->where('status', '0')->sum('amount');                
        
        return $cash;
    }

    public function bankdetail($request)
    {
        $detail = DB::table('bank_detail')->where('users_id', '=', $request->deliveryboy_id)
                      ->where('is_current', '=', 1)->first();
        return $detail;
    }

    public function withdrawdetail($request)
    {
        $detail = DB::table('payment_withdraw')->where('payment_withdraw_id', '=', $request->payment_id)->first();
        return $detail;
    }
    

    public function pay($request)
    {        
        DB::table('payment_withdraw')->where('payment_withdraw_id', '=', $request->payment_withdraw_id)->update(['status' => 1, 'updated_at'=> date('Y-m-d H:i:s')]);
        $detail = DB::table('payment_withdraw')->where('payment_withdraw_id', '=', $request->payment_withdraw_id)->first();

        DB::table('users_balance')->insertGetId(
            [	'orders_id'   => 0,
                'users_id'    => $detail->user_id,
                'products_id' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
                'transaction_type' =>'out',
                'amount'  =>  $detail->amount,
                'status'  =>  'Withdraw',
                'admin_id'=> Auth()->user()->id
            ]
        );

    }   

    
}
