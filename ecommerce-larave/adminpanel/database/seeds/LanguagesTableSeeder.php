<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'languages_id' => 1,
                'name' => 'English',
                'code' => 'en',
                'image' => '118',
                'directory' => NULL,
                'sort_order' => 1,
                'direction' => 'ltr',
                'status' => 1,
                'is_default' => 1,
            ),
            1 => 
            array (
                'languages_id' => 2,
                'name' => 'Arabic',
                'code' => 'ar',
                'image' => '119',
                'directory' => NULL,
                'sort_order' => 2,
                'direction' => 'rtl',
                'status' => 1,
                'is_default' => 0,
            ),
        ));
        
        
    }
}