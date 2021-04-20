<?php

use Illuminate\Database\Seeder;

class CategoriesDescriptionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories_description')->delete();
        
        \DB::table('categories_description')->insert(array (
            0 => 
            array (
                'categories_description_id' => 1,
                'categories_id' => -1,
                'language_id' => 1,
                'categories_name' => 'Uncategorized',
                'categories_description' => 'Uncategorized',
            ),
            1 => 
            array (
                'categories_description_id' => 2,
                'categories_id' => -1,
                'language_id' => 2,
                'categories_name' => 'Uncategorized',
                'categories_description' => 'Uncategorized',
            ),
        ));
        
        
    }
}