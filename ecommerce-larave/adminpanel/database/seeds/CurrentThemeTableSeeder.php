<?php

use Illuminate\Database\Seeder;

class CurrentThemeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('current_theme')->delete();
        
        \DB::table('current_theme')->insert(array (
            0 => 
            array (
                'id' => 1,
                'top_offer' => 1,
                'header' => 9,
                'carousel' => 1,
                'banner' => 8,
                'footer' => 6,
                'product_section_order' => '[{"id":1,"name":"Banner Section","order":1,"file_name":"banner_section","status":1,"image":"images\\/prototypes\\/banner_section.jpg","alt":"Banner Section"},{"id":11,"name":"Tab Products View","order":2,"file_name":"tab","status":1,"image":"images\\/prototypes\\/tab.jpg","disabled_image":"images\\/prototypes\\/tab-cross.jpg","alt":"Tab Products View"},{"id":5,"name":"Categories","order":3,"file_name":"categories","status":1,"image":"images\\/prototypes\\/categories.jpg","disabled_image":"images\\/prototypes\\/categories-cross.jpg","alt":"Categories"},{"id":2,"name":"Flash Sale Section","order":4,"file_name":"flash_sale_section","status":1,"image":"images\\/prototypes\\/flash_sale_section.jpg","disabled_image":"images\\/prototypes\\/flash_sale_section-cross.jpg","alt":"Flash Sale Section"},{"id":10,"name":"Second Ad Section","order":5,"file_name":"sec_ad_banner","status":1,"image":"images\\/prototypes\\/sec_ad_section.jpg","disabled_image":"images\\/prototypes\\/sec_ad_section-cross.jpg","alt":"Second Ad Section"},{"id":9,"name":"Top Selling","order":6,"file_name":"top","status":1,"image":"images\\/prototypes\\/top.jpg","disabled_image":"images\\/prototypes\\/top-cross.jpg","alt":"Top Selling"},{"id":4,"name":"Ad Section","order":7,"file_name":"ad_banner_section","status":1,"image":"images\\/prototypes\\/ad_banner_section.jpg","disabled_image":"images\\/prototypes\\/ad_banner_section-cross.jpg","alt":"Ad Section"},{"id":8,"name":"Newest Product Section","order":8,"file_name":"newest_product","status":1,"image":"images\\/prototypes\\/newest_product.jpg","disabled_image":"images\\/prototypes\\/newest_product-cross.jpg","alt":"Newest Product Section"},{"id":3,"name":"Special Products Section","order":9,"file_name":"special","status":1,"image":"images\\/prototypes\\/special_product.jpg","disabled_image":"images\\/prototypes\\/special_product-cross.jpg","alt":"Special Products Section"},{"id":12,"name":"Banner 2 Section","order":10,"file_name":"banner_two_section","status":1,"image":"images\\/prototypes\\/sec_ad_section.jpg","disabled_image":"images\\/prototypes\\/sec_ad_section-cross.jpg","alt":"Banner 2 Section"},{"id":13,"name":"Category","order":11,"file_name":"Category_section","status":1,"image":"images\\/prototypes\\/category_section.jpg","disabled_image":"images\\/prototypes\\/category_section-cross.jpg","alt":"Category 2 Section"},{"id":6,"name":"Blog Section","order":12,"file_name":"blog_section","status":1,"image":"images\\/prototypes\\/blog_section.jpg","disabled_image":"images\\/prototypes\\/blog_section-cross.jpg","alt":"Blog Section"},{"id":7,"name":"Info Boxes","order":13,"file_name":"info_boxes","status":1,"image":"images\\/prototypes\\/info_boxes.jpg","disabled_image":"images\\/prototypes\\/info_boxes-cross.jpg","alt":"Info Boxes"}]',
                'cart' => 2,
                'news' => 1,
                'detail' => 1,
                'shop' => 1,
                'contact' => 2,
                'login' => 1,
                'transitions' => 2,
                'banner_two' => 1,
                'category' => 1,
                'session_id' => NULL,
                'customers_id' => NULL,
            ),
        ));
        
        
    }
}