<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_methods')->delete();
        
        \DB::table('payment_methods')->insert(array (
            0 => 
            array (
                'payment_methods_id' => 5,
                'payment_method' => 'instamojo',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:57:23',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'payment_methods_id' => 4,
                'payment_method' => 'cash_on_delivery',
                'status' => 1,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:37',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            2 => 
            array (
                'payment_methods_id' => 2,
                'payment_method' => 'stripe',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:17',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            3 => 
            array (
                'payment_methods_id' => 1,
                'payment_method' => 'braintree',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:40:13',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            4 => 
            array (
                'payment_methods_id' => 6,
                'payment_method' => 'hyperpay',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:44',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            5 => 
            array (
                'payment_methods_id' => 7,
                'payment_method' => 'razor_pay',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:44',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            6 => 
            array (
                'payment_methods_id' => 8,
                'payment_method' => 'pay_tm',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:44',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            7 => 
            array (
                'payment_methods_id' => 9,
                'payment_method' => 'banktransfer',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:44',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            8 => 
            array (
                'payment_methods_id' => 10,
                'payment_method' => 'paystack',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:44',
                'updated_at' => '0000-00-00 00:00:00',
            ),
            9 => 
            array (
                'payment_methods_id' => 11,
                'payment_method' => 'midtrans',
                'status' => 0,
                'environment' => 0,
                'created_at' => '2019-09-18 11:56:44',
                'updated_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}