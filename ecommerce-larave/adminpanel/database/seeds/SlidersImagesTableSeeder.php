<?php

use Illuminate\Database\Seeder;

class SlidersImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sliders_images')->delete();
        
        \DB::table('sliders_images')->insert(array (
            0 => 
            array (
                'sliders_id' => 1,
            'sliders_title' => 'Left Slider with Thumbs (770x400)',
                'sliders_url' => '',
                'carousel_id' => 5,
                'sliders_image' => '109',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2035-11-15 00:00:00',
                'date_added' => '2020-04-13 14:36:18',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:36:18',
                'languages_id' => 1,
            ),
            1 => 
            array (
                'sliders_id' => 4,
            'sliders_title' => 'Full Screen Slider (1600x420)',
                'sliders_url' => '',
                'carousel_id' => 1,
                'sliders_image' => '111',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2020-07-15 00:00:00',
                'date_added' => '2020-04-13 14:32:27',
                'status' => 1,
                'type' => 'special',
                'date_status_change' => '2020-04-13 14:32:27',
                'languages_id' => 1,
            ),
            2 => 
            array (
                'sliders_id' => 7,
            'sliders_title' => 'Full Page Slider (1170x420)',
                'sliders_url' => '',
                'carousel_id' => 2,
                'sliders_image' => '108',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2025-11-26 00:00:00',
                'date_added' => '2020-04-13 14:31:54',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:31:54',
                'languages_id' => 1,
            ),
            3 => 
            array (
                'sliders_id' => 10,
            'sliders_title' => 'Right Slider with Thumbs (770x400)',
                'sliders_url' => '',
                'carousel_id' => 3,
                'sliders_image' => '110',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2025-10-20 00:00:00',
                'date_added' => '2020-04-13 14:33:23',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:33:23',
                'languages_id' => 1,
            ),
            4 => 
            array (
                'sliders_id' => 13,
            'sliders_title' => 'Right Slider with Navigation (770x400)',
                'sliders_url' => '',
                'carousel_id' => 4,
                'sliders_image' => '109',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2025-07-24 00:00:00',
                'date_added' => '2020-04-13 14:33:58',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:33:58',
                'languages_id' => 1,
            ),
            5 => 
            array (
                'sliders_id' => 16,
            'sliders_title' => 'Left Slider with Thumbs (770x400)',
                'sliders_url' => '',
                'carousel_id' => 5,
                'sliders_image' => '109',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2026-07-28 00:00:00',
                'date_added' => '2020-04-13 14:35:44',
                'status' => 1,
                'type' => 'special',
                'date_status_change' => '2020-04-13 14:35:44',
                'languages_id' => 2,
            ),
            6 => 
            array (
                'sliders_id' => 19,
            'sliders_title' => 'Full Screen Slider (1600x420)',
                'sliders_url' => '',
                'carousel_id' => 1,
                'sliders_image' => '111',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '1970-01-01 00:00:00',
                'date_added' => '2020-04-13 14:32:19',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:32:19',
                'languages_id' => 2,
            ),
            7 => 
            array (
                'sliders_id' => 22,
            'sliders_title' => 'Full Page Slider (1170x420)',
                'sliders_url' => '',
                'carousel_id' => 2,
                'sliders_image' => '108',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2025-07-17 00:00:00',
                'date_added' => '2020-04-13 14:32:03',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:32:03',
                'languages_id' => 2,
            ),
            8 => 
            array (
                'sliders_id' => 25,
            'sliders_title' => 'Right Slider with Thumbs (770x400)',
                'sliders_url' => '',
                'carousel_id' => 3,
                'sliders_image' => '110',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2025-07-31 00:00:00',
                'date_added' => '2020-04-13 14:33:17',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:33:17',
                'languages_id' => 2,
            ),
            9 => 
            array (
                'sliders_id' => 28,
            'sliders_title' => 'Right Slider with Navigation (770x400)',
                'sliders_url' => '',
                'carousel_id' => 4,
                'sliders_image' => '109',
                'sliders_group' => '',
                'sliders_html_text' => '',
                'expires_date' => '2025-07-31 00:00:00',
                'date_added' => '2020-04-13 14:34:17',
                'status' => 1,
                'type' => 'topseller',
                'date_status_change' => '2020-04-13 14:34:17',
                'languages_id' => 2,
            ),
        ));
        
        
    }
}