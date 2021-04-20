<?php

use Illuminate\Database\Seeder;

class OrdersStatusDescriptionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders_status_description')->delete();
        
        \DB::table('orders_status_description')->insert(array (
            0 => 
            array (
                'orders_status_description_id' => 1,
                'orders_status_id' => 1,
                'orders_status_name' => 'Pending',
                'language_id' => 1,
            ),
            1 => 
            array (
                'orders_status_description_id' => 2,
                'orders_status_id' => 2,
                'orders_status_name' => 'Completed',
                'language_id' => 1,
            ),
            2 => 
            array (
                'orders_status_description_id' => 3,
                'orders_status_id' => 3,
                'orders_status_name' => 'Cancel',
                'language_id' => 1,
            ),
            3 => 
            array (
                'orders_status_description_id' => 4,
                'orders_status_id' => 4,
                'orders_status_name' => 'Return',
                'language_id' => 1,
            ),
            4 => 
            array (
                'orders_status_description_id' => 5,
                'orders_status_id' => 5,
                'orders_status_name' => 'Inprocess',
                'language_id' => 1,
            ),
            5 => 
            array (
                'orders_status_description_id' => 6,
                'orders_status_id' => 8,
                'orders_status_name' => 'Online',
                'language_id' => 1,
            ),
            6 => 
            array (
                'orders_status_description_id' => 7,
                'orders_status_id' => 9,
                'orders_status_name' => 'Free for Delivery',
                'language_id' => 1,
            ),
            7 => 
            array (
                'orders_status_description_id' => 8,
                'orders_status_id' => 10,
                'orders_status_name' => 'Online Busy With Delivery',
                'language_id' => 1,
            ),
            8 => 
            array (
                'orders_status_description_id' => 9,
                'orders_status_id' => 11,
                'orders_status_name' => 'Offline',
                'language_id' => 1,
            ),
            9 => 
            array (
                'orders_status_description_id' => 10,
                'orders_status_id' => 6,
                'orders_status_name' => 'Delivered',
                'language_id' => 1,
            ),
            10 => 
            array (
                'orders_status_description_id' => 11,
                'orders_status_id' => 7,
                'orders_status_name' => 'Dispatched',
                'language_id' => 1,
            ),
        ));
        
        
    }
}