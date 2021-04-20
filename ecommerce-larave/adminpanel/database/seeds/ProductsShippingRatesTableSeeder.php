<?php

use Illuminate\Database\Seeder;

class ProductsShippingRatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products_shipping_rates')->delete();
        
        \DB::table('products_shipping_rates')->insert(array (
            0 => 
            array (
                'products_shipping_rates_id' => 1,
                'weight_from' => '0',
                'weight_to' => '10',
                'weight_price' => 10,
                'unit_id' => 1,
                'products_shipping_status' => 1,
            ),
            1 => 
            array (
                'products_shipping_rates_id' => 2,
                'weight_from' => '10',
                'weight_to' => '20',
                'weight_price' => 10,
                'unit_id' => 1,
                'products_shipping_status' => 1,
            ),
            2 => 
            array (
                'products_shipping_rates_id' => 3,
                'weight_from' => '20',
                'weight_to' => '30',
                'weight_price' => 10,
                'unit_id' => 1,
                'products_shipping_status' => 1,
            ),
            3 => 
            array (
                'products_shipping_rates_id' => 4,
                'weight_from' => '30',
                'weight_to' => '50',
                'weight_price' => 50,
                'unit_id' => 1,
                'products_shipping_status' => 1,
            ),
            4 => 
            array (
                'products_shipping_rates_id' => 5,
                'weight_from' => '50',
                'weight_to' => '100000',
                'weight_price' => 70,
                'unit_id' => 1,
                'products_shipping_status' => 1,
            ),
        ));
        
        
    }
}