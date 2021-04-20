<?php

use Illuminate\Database\Seeder;

class FrontEndThemeContentTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('front_end_theme_content')->delete();
        
        \DB::table('front_end_theme_content')->insert(array (
            0 => 
            array (
                'id' => 1,
                'top_offers' => '[{ "id": 1, "name": "Top Offer", "image": "images/prototypes/banner1.jpg", "alt": "Top Offer" }]',
                'headers' => '[
{
"id": 1,
"name": "Header One",
"image": "images/prototypes/header1.jpg",
"alt" : "header One" 
},
{
"id": 2,
"name": "Header Two",
"image": "images/prototypes/header2.jpg",
"alt" : "header Two" 
},
{
"id": 3,
"name": "Header Three",
"image": "images/prototypes/header3.jpg",
"alt" : "header Three" 
},
{
"id": 4,
"name": "Header Four",
"image": "images/prototypes/header4.jpg",
"alt" : "header Four" 
},
{
"id": 5,
"name": "Header Five",
"image": "images/prototypes/header5.jpg",
"alt" : "header Five" 
},
{
"id": 6,
"name": "Header Six",
"image": "images/prototypes/header6.jpg",
"alt" : "header Six" 
},
{
"id": 7,
"name": "Header Seven",
"image": "images/prototypes/header7.jpg",
"alt" : "header Seven" 
},
{
"id": 8,
"name": "Header Eight",
"image": "images/prototypes/header8.jpg",
"alt" : "header Eight" 
},
{
"id": 9,
"name": "Header Nine",
"image": "images/prototypes/header9.jpg",
"alt" : "header Nine" 
},
{
"id": 10,
"name": "Header Ten",
"image": "images/prototypes/header10.jpg",
"alt" : "header Ten" 
}
]',
                'carousels' => '[
{
"id": 1,
"name": "Bootstrap Carousel Content Full Screen",
"image": "images/prototypes/carousal1.jpg",
"alt": "Bootstrap Carousel Content Full Screen"
},
{
"id": 2,
"name": "Bootstrap Carousel Content Full Width",
"image": "images/prototypes/carousal2.jpg",
"alt": "Bootstrap Carousel Content Full Width"
},
{
"id": 3,
"name": "Bootstrap Carousel Content with Left Banner",
"image": "images/prototypes/carousal3.jpg",
"alt": "Bootstrap Carousel Content with Left Banner"
},
{
"id": 4,
"name": "Bootstrap Carousel Content with Navigation",
"image": "images/prototypes/carousal4.jpg",
"alt": "Bootstrap Carousel Content with Navigation"
},
{
"id": 5,
"name": "Bootstrap Carousel Content with Right Banner",
"image": "images/prototypes/carousal5.jpg",
"alt": "Bootstrap Carousel Content with Right Banner"
}
]',
                'banners' => '[
{
"id": 1,
"name": "Banner One",
"image": "images/prototypes/banner1.jpg",
"alt": "Banner One"
},
{
"id": 2,
"name": "Banner Two",
"image": "images/prototypes/banner2.jpg",
"alt": "Banner Two"
},
{
"id": 3,
"name": "Banner Three",
"image": "images/prototypes/banner3.jpg",
"alt": "Banner Three"
},
{
"id": 4,
"name": "Banner Four",
"image": "images/prototypes/banner4.jpg",
"alt": "Banner Four"
},
{
"id": 5,
"name": "Banner Five",
"image": "images/prototypes/banner5.jpg",
"alt": "Banner Five"
},
{
"id": 6,
"name": "Banner Six",
"image": "images/prototypes/banner6.jpg",
"alt": "Banner Six"
},
{
"id": 7,
"name": "Banner Seven",
"image": "images/prototypes/banner7.jpg",
"alt": "Banner Seven"
},
{
"id": 8,
"name": "Banner Eight",
"image": "images/prototypes/banner8.jpg",
"alt": "Banner Eight"
},
{
"id": 9,
"name": "Banner Nine",
"image": "images/prototypes/banner9.jpg",
"alt": "Banner Nine"
},
{
"id": 10,
"name": "Banner Ten",
"image": "images/prototypes/banner10.jpg",
"alt": "Banner Ten"
},
{
"id": 11,
"name": "Banner Eleven",
"image": "images/prototypes/banner11.jpg",
"alt": "Banner Eleven"
},
{
"id": 12,
"name": "Banner Twelve",
"image": "images/prototypes/banner12.jpg",
"alt": "Banner Twelve"
},
{
"id": 13,
"name": "Banner Thirteen",
"image": "images/prototypes/banner13.jpg",
"alt": "Banner Thirteen"
},
{
"id": 14,
"name": "Banner Fourteen",
"image": "images/prototypes/banner14.jpg",
"alt": "Banner Fourteen"
},
{
"id": 15,
"name": "Banner Fifteen",
"image": "images/prototypes/banner15.jpg",
"alt": "Banner Fifteen"
},
{
"id": 16,
"name": "Banner Sixteen",
"image": "images/prototypes/banner16.jpg",
"alt": "Banner Sixteen"
},
{
"id": 17,
"name": "Banner Seventeen",
"image": "images/prototypes/banner17.jpg",
"alt": "Banner Seventeen"
},
{
"id": 18,
"name": "Banner Eighteen",
"image": "images/prototypes/banner18.jpg",
"alt": "Banner Eighteen"
},
{
"id": 19,
"name": "Banner Nineteen",
"image": "images/prototypes/banner19.jpg",
"alt": "Banner Nineteen"
}
]',
                'footers' => '[
{
"id": 1,
"name": "Footer One",
"image": "images/prototypes/footer1.png",
"alt" : "Footer One"
},
{
"id": 2,
"name": "Footer Two",
"image": "images/prototypes/footer2.png",
"alt" : "Footer Two"
},
{
"id": 3,
"name": "Footer Three",
"image": "images/prototypes/footer3.png",
"alt" : "Footer Three"
},
{
"id": 4,
"name": "Footer Four",
"image": "images/prototypes/footer4.png",
"alt" : "Footer Four"
},
{
"id": 5,
"name": "Footer Five",
"image": "images/prototypes/footer5.png",
"alt" : "Footer Five"
},
{
"id": 6,
"name": "Footer Six",
"image": "images/prototypes/footer6.png",
"alt" : "Footer Six"
},
{
"id": 7,
"name": "Footer Seven",
"image": "images/prototypes/footer7.png",
"alt" : "Footer Seven"
},
{
"id": 8,
"name": "Footer Eight",
"image": "images/prototypes/footer8.png",
"alt" : "Footer Eight"
},
{
"id": 9,
"name": "Footer Nine",
"image": "images/prototypes/footer9.png",
"alt" : "Footer Nine"
},
{
"id": 10,
"name": "Footer Ten",
"image": "images/prototypes/footer10.png",
"alt" : "Footer Ten"
}
]',
                'product_section_order' => '[{"id":1,"name":"Banner Section","order":1,"file_name":"banner_section","status":1,"image":"images\\/prototypes\\/banner_section.jpg","alt":"Banner Section"},{"id":11,"name":"Tab Products View","order":2,"file_name":"tab","status":1,"image":"images\\/prototypes\\/tab.jpg","disabled_image":"images\\/prototypes\\/tab-cross.jpg","alt":"Tab Products View"},{"id":5,"name":"Categories","order":3,"file_name":"categories","status":1,"image":"images\\/prototypes\\/categories.jpg","disabled_image":"images\\/prototypes\\/categories-cross.jpg","alt":"Categories"},{"id":2,"name":"Flash Sale Section","order":4,"file_name":"flash_sale_section","status":1,"image":"images\\/prototypes\\/flash_sale_section.jpg","disabled_image":"images\\/prototypes\\/flash_sale_section-cross.jpg","alt":"Flash Sale Section"},{"id":10,"name":"Second Ad Section","order":5,"file_name":"sec_ad_banner","status":1,"image":"images\\/prototypes\\/sec_ad_section.jpg","disabled_image":"images\\/prototypes\\/sec_ad_section-cross.jpg","alt":"Second Ad Section"},{"id":9,"name":"Top Selling","order":6,"file_name":"top","status":1,"image":"images\\/prototypes\\/top.jpg","disabled_image":"images\\/prototypes\\/top-cross.jpg","alt":"Top Selling"},{"id":4,"name":"Ad Section","order":7,"file_name":"ad_banner_section","status":1,"image":"images\\/prototypes\\/ad_banner_section.jpg","disabled_image":"images\\/prototypes\\/ad_banner_section-cross.jpg","alt":"Ad Section"},{"id":8,"name":"Newest Product Section","order":8,"file_name":"newest_product","status":1,"image":"images\\/prototypes\\/newest_product.jpg","disabled_image":"images\\/prototypes\\/newest_product-cross.jpg","alt":"Newest Product Section"},{"id":3,"name":"Special Products Section","order":9,"file_name":"special","status":1,"image":"images\\/prototypes\\/special_product.jpg","disabled_image":"images\\/prototypes\\/special_product-cross.jpg","alt":"Special Products Section"},{"id":12,"name":"Banner 2 Section","order":10,"file_name":"banner_two_section","status":1,"image":"images\\/prototypes\\/sec_ad_section.jpg","disabled_image":"images\\/prototypes\\/sec_ad_section-cross.jpg","alt":"Banner 2 Section"},{"id":13,"name":"Category","order":11,"file_name":"Category_section","status":1,"image":"images\\/prototypes\\/category_section.jpg","disabled_image":"images\\/prototypes\\/category_section-cross.jpg","alt":"Category 2 Section"},{"id":6,"name":"Blog Section","order":12,"file_name":"blog_section","status":1,"image":"images\\/prototypes\\/blog_section.jpg","disabled_image":"images\\/prototypes\\/blog_section-cross.jpg","alt":"Blog Section"},{"id":7,"name":"Info Boxes","order":13,"file_name":"info_boxes","status":1,"image":"images\\/prototypes\\/info_boxes.jpg","disabled_image":"images\\/prototypes\\/info_boxes-cross.jpg","alt":"Info Boxes"}]',
                'cart' => '[      {         "id":1,       "name":"Cart One"    },    {         "id":2,       "name":"Cart Two"    }     ]',
                'news' => '[      {         "id":1,       "name":"News One"    },    {         "id":2,       "name":"News Two"    }     ]',
                'detail' => '[  
{  
"id":1,
"name":"Product Detail Page One"
},
{  
"id":2,
"name":"Product Detail Page Two"
},
{  
"id":3,
"name":"Product Detail Page Three"
},
{  
"id":4,
"name":"Product Detail Page Four"
},
{  
"id":5,
"name":"Product Detail Page Five"
},
{  
"id":6,
"name":"Product Detail Page Six"
}

]',
                'shop' => '[ { "id":1, "name":"Shop Page One" }, { "id":2, "name":"Shop Page Two" }, { "id":3, "name":"Shop Page Three" }, { "id":4, "name":"Shop Page Four" }, { "id":5, "name":"Shop Page Five" } ]',
                'contact' => '[      {         "id":1,       "name":"Contact Page One"    },    {         "id":2,       "name":"Contact Page Two"    } ]',
                'login' => '[      {         "id":1,       "name":"Login Page One"    },    {         "id":2,       "name":"Login Page Two"    } ]',
                'transitions' => '[      {         "id":1,       "name":"Transition Zoomin"    },    {         "id":2,       "name":"Transition Flashing"    },    {         "id":3,       "name":"Transition Shine"    },    {         "id":4,       "name":"Transition Circle"    },    {         "id":5,       "name":"Transition Opacity"    } ]',
                'banners_two' => '[ { "id": 1, "name": "Banner One", "image": "images/prototypes/banner1.jpg", "alt": "Banner One" }, { "id": 2, "name": "Banner Two", "image": "images/prototypes/banner2.jpg", "alt": "Banner Two" }, { "id": 3, "name": "Banner Three", "image": "images/prototypes/banner3.jpg", "alt": "Banner Three" }, { "id": 4, "name": "Banner Four", "image": "images/prototypes/banner4.jpg", "alt": "Banner Four" }, { "id": 5, "name": "Banner Five", "image": "images/prototypes/banner5.jpg", "alt": "Banner Five" }, { "id": 6, "name": "Banner Six", "image": "images/prototypes/banner6.jpg", "alt": "Banner Six" }, { "id": 7, "name": "Banner Seven", "image": "images/prototypes/banner7.jpg", "alt": "Banner Seven" }, { "id": 8, "name": "Banner Eight", "image": "images/prototypes/banner8.jpg", "alt": "Banner Eight" }, { "id": 9, "name": "Banner Nine", "image": "images/prototypes/banner9.jpg", "alt": "Banner Nine" }, { "id": 10, "name": "Banner Ten", "image": "images/prototypes/banner10.jpg", "alt": "Banner Ten" }, { "id": 11, "name": "Banner Eleven", "image": "images/prototypes/banner11.jpg", "alt": "Banner Eleven" }, { "id": 12, "name": "Banner Twelve", "image": "images/prototypes/banner12.jpg", "alt": "Banner Twelve" }, { "id": 13, "name": "Banner Thirteen", "image": "images/prototypes/banner13.jpg", "alt": "Banner Thirteen" }, { "id": 14, "name": "Banner Fourteen", "image": "images/prototypes/banner14.jpg", "alt": "Banner Fourteen" }, { "id": 15, "name": "Banner Fifteen", "image": "images/prototypes/banner15.jpg", "alt": "Banner Fifteen" }, { "id": 16, "name": "Banner Sixteen", "image": "images/prototypes/banner16.jpg", "alt": "Banner Sixteen" }, { "id": 17, "name": "Banner Seventeen", "image": "images/prototypes/banner17.jpg", "alt": "Banner Seventeen" }, { "id": 18, "name": "Banner Eighteen", "image": "images/prototypes/banner18.jpg", "alt": "Banner Eighteen" }, { "id": 19, "name": "Banner Nineteen", "image": "images/prototypes/banner19.jpg", "alt": "Banner Nineteen" } ]',
                'category' => '1',
            ),
        ));
        
        
    }
}