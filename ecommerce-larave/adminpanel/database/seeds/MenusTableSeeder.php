<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sort_order' => 1,
                'sub_sort_order' => NULL,
                'parent_id' => 0,
                'type' => 1,
                'external_link' => '/',
                'link' => '/',
                'page_id' => 0,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 27,
                'sort_order' => 2,
                'sub_sort_order' => NULL,
                'parent_id' => 0,
                'type' => 5,
                'external_link' => NULL,
                'link' => '/shop',
                'page_id' => NULL,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 22,
                'sort_order' => 3,
                'sub_sort_order' => NULL,
                'parent_id' => 0,
                'type' => 5,
                'external_link' => '/contact',
                'link' => '/contact',
                'page_id' => 0,
                'status' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}