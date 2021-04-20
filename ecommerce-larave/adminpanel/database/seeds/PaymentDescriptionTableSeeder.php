<?php

use Illuminate\Database\Seeder;

class PaymentDescriptionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_description')->delete();
        
        \DB::table('payment_description')->insert(array (
            0 => 
            array (
                'id' => 8,
                'payment_methods_id' => 0,
                'name' => 'Cybersoure',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            1 => 
            array (
                'id' => 7,
                'payment_methods_id' => 5,
                'name' => 'Instamojo',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            2 => 
            array (
                'id' => 6,
                'payment_methods_id' => 4,
                'name' => 'Cash on Delivery',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            3 => 
            array (
                'id' => 4,
                'payment_methods_id' => 2,
                'name' => 'Stripe',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            4 => 
            array (
                'id' => 1,
                'payment_methods_id' => 1,
                'name' => 'Braintree',
                'language_id' => 1,
                'sub_name_1' => 'Credit Card',
                'sub_name_2' => 'Paypal',
            ),
            5 => 
            array (
                'id' => 9,
                'payment_methods_id' => 6,
                'name' => 'Hyperpay',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            6 => 
            array (
                'id' => 10,
                'payment_methods_id' => 7,
                'name' => 'Razor Pay',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            7 => 
            array (
                'id' => 11,
                'payment_methods_id' => 8,
                'name' => 'PayTm',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            8 => 
            array (
                'id' => 12,
                'payment_methods_id' => 9,
                'name' => 'Direct Bank Transfer',
                'language_id' => 1,
                'sub_name_1' => 'Make your payment directly into our bank account. Please use your Order ID as the payment reference.',
                'sub_name_2' => '',
            ),
            9 => 
            array (
                'id' => 13,
                'payment_methods_id' => 10,
                'name' => 'Paystack',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
            10 => 
            array (
                'id' => 14,
                'payment_methods_id' => 11,
                'name' => 'Midtrans',
                'language_id' => 1,
                'sub_name_1' => '',
                'sub_name_2' => '',
            ),
        ));
        
        
    }
}