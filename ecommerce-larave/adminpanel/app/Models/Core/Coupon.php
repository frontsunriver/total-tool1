<?php

namespace App\Models\Core;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class Coupon extends Model
{
    //
    use Sortable;

    public $sortable =['coupans_id','code','description','discount_type','amount',
        'expiry_date','usage_count','individual_use','individual_use','exclude_product_ids',
        'usage_limit','usage_limit_per_user','limit_usage_to_x_items','free_shipping',
        'product_categories','excluded_product_categories','excluded_product_categories','minimum_amount',
        'maximum_amount','email_restrictions','used_by','created_at','updated_at'];

    public function email(){


        $emails = DB::table('users')->select('email')->get();

        return $emails;

    }

    public function cutomers(){

        $products = DB::table('products')
            ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
            ->select('products_name', 'products.products_id', 'products.products_model')->get();


        return $products;

    }

    public function categories(){

        $categories = DB::table('categories')
            ->LeftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
            ->select('categories_name', 'categories.categories_id')
            ->where('parent_id', '>', '0')
            ->get();


        return $categories;


    }

    public  function coupon($code){

        $couponInfo = DB::table('coupons')->where('code','=', $code)->get();

    return $couponInfo;
    }

    public function addcoupon($code,$description,
                              $discount_type,$amount,$individual_use,$product_ids,
                              $exclude_product_ids,$usage_limit,$usage_limit_per_user,$usage_count
                              ,$used_by,$limit_usage_to_x_items ,$product_categories,$excluded_product_categories,
                              $exclude_sale_items,$email_restrictions,$minimum_amount,$maximum_amount,$expiry_date,$free_shipping){


        $coupon_id = DB::table('coupons')->insertGetId([
            'code'  	 				 =>   $code,
            'created_at'				 =>   date('Y-m-d H:i:s'),
            'description'				 =>   $description,
            'discount_type'	 			 =>   $discount_type,
            'amount'	 	 			 =>   $amount,
            'individual_use'	 		 =>   $individual_use,
            'product_ids'	 			 =>   $product_ids,
            'exclude_product_ids'		 =>   $exclude_product_ids,
            'usage_limit'	 			 =>   $usage_limit,
            'usage_limit_per_user'	 	 =>   $usage_limit_per_user,
            'usage_count'	 	         =>           $usage_count,
            'used_by'	 	         =>           $used_by,
            'limit_usage_to_x_items'	 =>   $limit_usage_to_x_items ,
            'product_categories'	 	 =>   $product_categories,
            'excluded_product_categories'=>   $excluded_product_categories,
            'exclude_sale_items'		 =>   $exclude_sale_items,
            'email_restrictions'	 	 =>   $email_restrictions,
            'minimum_amount'	 		 =>   $minimum_amount,
            'maximum_amount'	 		 =>   $maximum_amount,
            'expiry_date'				 =>	  $expiry_date,
            'free_shipping'				 =>   $free_shipping
        ]);
        return $coupon_id;
    }
   public function getcoupon($id){

       $coupon = DB::table('coupons')->where('coupans_id', '=', $id)->get();


        return $coupon;
   }

   public function getemail(){

       $emails = DB::table('users')->select('email')->get();

       return $emails;

   }

   public function getproduct(){

       $products = DB::table('products')
           ->LeftJoin('products_description', 'products_description.products_id', '=', 'products.products_id')
           ->select('products_name', 'products.products_id', 'products.products_model')->get();


       return $products;

   }
     public function getcategories(){

         $categories = DB::table('categories')
             ->LeftJoin('categories_description', 'categories_description.categories_id', '=', 'categories.categories_id')
             ->select('categories_name', 'categories.categories_id')
             ->where('parent_id', '>', '0')
             ->get();

         return $categories;


     }

     public function getcode($code){

         $couponInfo = DB::table('coupons')->where('code','=', $code)->get();


         return $couponInfo;


     }

     public function couponupdate($coupans_id,$code,$description,$discount_type, $amount,$individual_use,
                                  $product_ids, $exclude_product_ids, $usage_limit,$usage_limit_per_user, $usage_count,
                                  $limit_usage_to_x_items, $product_categories,$used_by, $excluded_product_categories,
                                  $request,$email_restrictions,$minimum_amount,$maximum_amount,$expiry_date,$free_shipping){

         //insert record
         $coupon_id = DB::table('coupons')->where('coupans_id', '=', $coupans_id)->update([
             'code'  	 				 =>   $code,
             'updated_at'				 =>   date('Y-m-d H:i:s'),
             'description'				 =>   $description,
             'discount_type'	 			 =>   $discount_type,
             'amount'	 	 			 =>   $amount,
             'individual_use'	 		 =>   $individual_use,
             'product_ids'	 			 =>   $product_ids,
             'exclude_product_ids'		 =>   $exclude_product_ids,
             'usage_limit'	 			 =>   $usage_limit,
             'usage_limit_per_user'	 	 =>   $usage_limit_per_user,
             'usage_count'	 	 =>           $usage_count,
             'limit_usage_to_x_items'	 =>   $limit_usage_to_x_items,
             'product_categories'	 	 =>   $product_categories,
             'used_by'	 	 =>   $used_by,
             'excluded_product_categories'=>   $excluded_product_categories,
             'exclude_sale_items'		 =>   $request->exclude_sale_items,
             'email_restrictions'	 	 =>   $email_restrictions,
             'minimum_amount'	 		 =>   $minimum_amount,
             'maximum_amount'	 		 =>   $maximum_amount,
             'expiry_date'				 =>	  $expiry_date,
             'free_shipping'				 =>   $free_shipping
         ]);

         return $coupon_id;

     }

     public function deletecoupon($request){

        $deletecoupon = DB::table('coupons')->where('coupans_id', '=', $request->id)->delete();


        return $deletecoupon;

     }


     public function couponproduct(){

         $coupons = DB::table('products')->get();


         return $coupons;


     }



}
