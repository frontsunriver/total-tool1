<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('banners')->delete();
        
        \DB::table('banners')->insert(array (
            0 => 
            array (
                'banners_id' => 1,
                'banners_title' => 'Banner1',
                'banners_url' => '-1',
                'banners_image' => '110',
                'banners_group' => '',
                'banners_html_text' => NULL,
                'expires_impressions' => 0,
                'expires_date' => '2030-12-31 00:00:00',
                'date_scheduled' => NULL,
                'date_added' => '0000-00-00 00:00:00',
                'date_status_change' => NULL,
                'status' => 1,
                'type' => 'category',
                'banners_slug' => '',
                'created_at' => '2020-11-18 19:44:28',
                'updated_at' => NULL,
                'languages_id' => 1,
            ),
            1 => 
            array (
                'banners_id' => 2,
                'banners_title' => 'Banner1Ar',
                'banners_url' => '-1',
                'banners_image' => '110',
                'banners_group' => '',
                'banners_html_text' => NULL,
                'expires_impressions' => 0,
                'expires_date' => '2030-12-31 00:00:00',
                'date_scheduled' => NULL,
                'date_added' => '0000-00-00 00:00:00',
                'date_status_change' => NULL,
                'status' => 1,
                'type' => 'category',
                'banners_slug' => '',
                'created_at' => '2020-11-18 19:45:34',
                'updated_at' => NULL,
                'languages_id' => 2,
            ),
        ));
        
        
    }
}