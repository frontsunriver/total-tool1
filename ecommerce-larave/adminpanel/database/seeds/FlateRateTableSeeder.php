<?php

use Illuminate\Database\Seeder;

class FlateRateTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('flate_rate')->delete();
        
        \DB::table('flate_rate')->insert(array (
            0 => 
            array (
                'id' => 1,
                'flate_rate' => '11',
                'currency' => 'USD',
            ),
        ));
        
        
    }
}