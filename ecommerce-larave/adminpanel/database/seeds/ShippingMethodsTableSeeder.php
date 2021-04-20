<?php

use Illuminate\Database\Seeder;

class ShippingMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shipping_methods')->delete();
        
        \DB::table('shipping_methods')->insert(array (
            0 => 
            array (
                'shipping_methods_id' => 2,
                'methods_type_link' => 'freeShipping',
                'isDefault' => 0,
                'status' => 0,
                'table_name' => 'free_shipping',
            ),
            1 => 
            array (
                'shipping_methods_id' => 3,
                'methods_type_link' => 'localPickup',
                'isDefault' => 0,
                'status' => 0,
                'table_name' => 'local_pickup',
            ),
            2 => 
            array (
                'shipping_methods_id' => 4,
                'methods_type_link' => 'flateRate',
                'isDefault' => 1,
                'status' => 1,
                'table_name' => 'flate_rate',
            ),
            3 => 
            array (
                'shipping_methods_id' => 5,
                'methods_type_link' => 'shippingByWeight',
                'isDefault' => 0,
                'status' => 0,
                'table_name' => 'shipping_by_weight',
            ),
        ));
        
        
    }
}