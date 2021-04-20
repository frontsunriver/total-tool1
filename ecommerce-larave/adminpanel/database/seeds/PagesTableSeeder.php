<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pages')->delete();
        
        \DB::table('pages')->insert(array (
            0 => 
            array (
                'page_id' => 1,
                'slug' => 'privacy-policy',
                'status' => 1,
                'type' => 1,
            ),
            1 => 
            array (
                'page_id' => 2,
                'slug' => 'term-services',
                'status' => 1,
                'type' => 1,
            ),
            2 => 
            array (
                'page_id' => 3,
                'slug' => 'refund-policy',
                'status' => 1,
                'type' => 1,
            ),
            3 => 
            array (
                'page_id' => 4,
                'slug' => 'about-us',
                'status' => 1,
                'type' => 1,
            ),
            4 => 
            array (
                'page_id' => 5,
                'slug' => 'privacy-policy',
                'status' => 1,
                'type' => 2,
            ),
            5 => 
            array (
                'page_id' => 6,
                'slug' => 'term-services',
                'status' => 1,
                'type' => 2,
            ),
            6 => 
            array (
                'page_id' => 7,
                'slug' => 'refund-policy',
                'status' => 1,
                'type' => 2,
            ),
            7 => 
            array (
                'page_id' => 8,
                'slug' => 'about-us',
                'status' => 1,
                'type' => 2,
            ),
        ));
        
        
    }
}