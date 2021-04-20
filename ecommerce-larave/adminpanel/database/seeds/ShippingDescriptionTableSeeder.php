<?php

use Illuminate\Database\Seeder;

class ShippingDescriptionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shipping_description')->delete();
        
        \DB::table('shipping_description')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Free Shipping',
                'language_id' => 1,
                'table_name' => 'free_shipping',
                'sub_labels' => '',
            ),
            1 => 
            array (
                'id' => 4,
                'name' => 'Local Pickup',
                'language_id' => 1,
                'table_name' => 'local_pickup',
                'sub_labels' => '',
            ),
            2 => 
            array (
                'id' => 7,
                'name' => 'Flat Rate',
                'language_id' => 1,
                'table_name' => 'flate_rate',
                'sub_labels' => '',
            ),
            3 => 
            array (
                'id' => 13,
                'name' => 'Shipping Price',
                'language_id' => 1,
                'table_name' => 'shipping_by_weight',
                'sub_labels' => '',
            ),
        ));
        
        
    }
}