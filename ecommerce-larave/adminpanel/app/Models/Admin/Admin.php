<?php

namespace App\Models\Admin;

Use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Hash;
class Admin extends Model
{
    //
    use Sortable;
    // public function images(){
    //     return $this->belongsTo('App\Images');
    // }
    //
    // public function categories_description(){
    //     return $this->beliesngsTo('App\Categories_description');
    // }

    // public $sortable =['categories_id','created_at'];
    // public $sortableAs =['categories_name'];

    public function edit($id){
        $admin = User::leftJoin('images','images.id', '=', 'users.avatar')
            ->leftJoin('user_to_address','users.id', '=', 'user_to_address.user_id')
            ->leftJoin('address_book','address_book.address_book_id', '=', 'user_to_address.address_book_id')
            ->select('users.*', 'users.avatar as image','address_book.*')
            ->where('users.id', $id)->first();
        return $admin;
    }
    public function updaterecord($data){

      $date	= date('y-m-d h:i:s');
      if($data['image_id']){
          $uploadImage = $data['image_id'];
          $uploadImage = DB::table('image_categories')
                           ->where('image_id',$uploadImage)
                           ->select('path')
                           ->first();

          $uploadImage = 	$uploadImage->path;
      }	else{
          $uploadImage = $data['oldImage'];
      }

      DB::table('users')->where('id','=', auth()->user()->id)->update([
        'user_name'		=>	$data['user_name'],
        'first_name'	=>	$data['first_name'],
        'last_name'		=>	$data['last_name'],
        'phone'			=>	$data['phone'],
        'avatar'			=>	$uploadImage,
        'updated_at'	=>	$date
      ]);

      //check if record exist
     $exist = DB::table('user_to_address')->where('user_id','=',auth()->user()->id)->first();

     if($exist){
       $address_book_id = $exist->address_book_id;
       DB::table('address_book')->where('user_id','=', auth()->user()->id)->where('user_id','=', auth()->user()->id)->update([
         'entry_firstname'	      =>	$data['first_name'],
         'entry_lastname'		      =>	$data['last_name'],
         'entry_street_address'		=>	$data['address'],
         'entry_city'			        =>	$data['city'],
         'entry_state'			      =>	$data['state'],
         'entry_postcode'		     	=>	$data['zip'],
         'entry_country_id'		    =>	$data['country'],
       ]);

     }else{
      $address_book_id = DB::table('address_book')->where('id','=', auth()->user()->id)->insertGetId([
         'user_id'		            =>	auth()->user()->id,
         'entry_firstname'	      =>	$data['first_name'],
         'entry_lastname'		      =>	$data['last_name'],
         'entry_street_address'		=>	$data['address'],
         'entry_city'			        =>	$data['city'],
         'entry_state'			      =>	$data['state'],
         'entry_postcode'		     	=>	$data['zip'],
         'entry_country_id'		    =>	$data['country'],
       ]);

       if($address_book_id){
         $user_to_address =  DB::table('user_to_address')->insertGetId([
            'user_id'		            =>	auth()->user()->id,
            'address_book_id'	      =>	$address_book_id,
            'is_default'    =>  1
          ]);
       }
     }
   }
   public function updatepassword($data){
     $date	= date('y-m-d h:i:s');
     DB::table('users')->where('id','=', auth()->user()->id)->update([
      'password'			=>	Hash::make($data['password']),
      'email'			    =>	$data['email'],
       'updated_at'	  =>	$date
     ]);

  }

}
