<?php

use Illuminate\Database\Seeder;

class UnitsDescriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('units_descriptions')->delete();
        
        \DB::table('units_descriptions')->insert(array (
            0 => 
            array (
                'units_description_id' => 1,
                'units_name' => 'Piece',
                'languages_id' => 1,
                'unit_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'units_description_id' => 2,
            'units_name' => 'Piece(Ar)',
                'languages_id' => 2,
                'unit_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'units_description_id' => 3,
                'units_name' => 'Lot',
                'languages_id' => 1,
                'unit_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'units_description_id' => 4,
            'units_name' => 'Lot(Ar)',
                'languages_id' => 2,
                'unit_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}