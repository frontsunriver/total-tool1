<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'U.S. Dollar',
                'code' => 'USD',
                'symbol_left' => '$',
                'symbol_right' => '',
                'decimal_point' => NULL,
                'thousands_point' => NULL,
                'decimal_places' => '2',
                'created_at' => '2020-11-16 01:41:07',
                'updated_at' => '2020-11-16 01:41:07',
                'value' => 1.0,
                'is_default' => 1,
                'status' => 1,
                'is_current' => 1,
            ),
        ));
        
        
    }
}