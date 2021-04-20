<?php

use Illuminate\Database\Seeder;

class OrdersStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders_status')->delete();
        
        \DB::table('orders_status')->insert(array (
            0 => 
            array (
                'orders_status_id' => 1,
                'public_flag' => 1,
                'downloads_flag' => 1,
                'role_id' => 2,
            ),
            1 => 
            array (
                'orders_status_id' => 2,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 2,
            ),
            2 => 
            array (
                'orders_status_id' => 3,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 2,
            ),
            3 => 
            array (
                'orders_status_id' => 4,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 2,
            ),
            4 => 
            array (
                'orders_status_id' => 5,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 2,
            ),
            5 => 
            array (
                'orders_status_id' => 6,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 2,
            ),
            6 => 
            array (
                'orders_status_id' => 7,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 2,
            ),
            7 => 
            array (
                'orders_status_id' => 8,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 3,
            ),
            8 => 
            array (
                'orders_status_id' => 9,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 3,
            ),
            9 => 
            array (
                'orders_status_id' => 10,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 3,
            ),
            10 => 
            array (
                'orders_status_id' => 11,
                'public_flag' => 0,
                'downloads_flag' => 0,
                'role_id' => 3,
            ),
        ));
        
        
    }
}