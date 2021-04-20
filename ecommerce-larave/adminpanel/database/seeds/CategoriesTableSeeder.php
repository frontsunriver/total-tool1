<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'categories_id' => -1,
                'categories_image' => '120',
                'categories_icon' => '120',
                'parent_id' => 0,
                'sort_order' => 0,
                'date_added' => NULL,
                'last_modified' => NULL,
                'categories_slug' => 'uncategorized',
                'categories_status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}