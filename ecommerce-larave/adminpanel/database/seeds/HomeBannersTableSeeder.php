<?php

use Illuminate\Database\Seeder;

class HomeBannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('home_banners')->delete();
        
        \DB::table('home_banners')->insert(array (
            0 => 
            array (
                'home_banners_id' => 1,
                'banner_name' => 'banners_1',
                'language_id' => 1,
                'text' => '<div class=\\"parallax-banner-text\\">
<h2> Food Festival</h2>
<h4>Ramadan Special</h4>
<div class=\\"hover-link\\">
<a href=\\"/shop\\" class=\\"btn btn-secondary swipe-to-top\\" data-toggle=\\"tooltip\\" data-placement=\\"bottom\\" title=\\"\\" data-original-title=\\"View All Range\\">Shop Now</a>
</div>  
</div>',
                'image' => 125,
                'created_at' => '2020-11-18 06:06:25',
                'updated_at' => '2020-11-18 06:06:25',
            ),
            1 => 
            array (
                'home_banners_id' => 2,
                'banner_name' => 'banners_2',
                'language_id' => 1,
                'text' => '<div class=\\"parallax-banner-text\\">
<h2> Fresh Fruits & Vegetables</h2>
<h4>Farm Fresh</h4>
<div class=\\"hover-link\\">
<a href=\\"/shop\\" class=\\"btn btn-secondary swipe-to-top\\" data-toggle=\\"tooltip\\" data-placement=\\"bottom\\" title=\\"\\" data-original-title=\\"View All Range\\">View All Range</a>
</div>  
</div>',
                'image' => 125,
                'created_at' => '2020-11-18 06:06:25',
                'updated_at' => '2020-11-18 06:06:25',
            ),
            2 => 
            array (
                'home_banners_id' => 3,
                'banner_name' => 'banners_3',
                'language_id' => 1,
                'text' => '<div class=\\"parallax-banner-text\\">
<h2> Grocery Zone</h2>
<h4>Your Favorite</h4>
<div class=\\"hover-link\\">
<a href=\\"/shop\\" class=\\"btn btn-secondary swipe-to-top\\" data-toggle=\\"tooltip\\" data-placement=\\"bottom\\" title=\\"\\" data-original-title=\\"View All Range\\">Buy Now</a>
</div>  
</div>',
                'image' => 125,
                'created_at' => '2020-11-18 06:06:25',
                'updated_at' => '2020-11-18 06:06:25',
            ),
            3 => 
            array (
                'home_banners_id' => 4,
                'banner_name' => 'banners_1',
                'language_id' => 2,
                'text' => '<div class=\\"parallax-banner-text\\">
<h2> مهرجان طعام</h2>
<h4>رمضان خاص</h4>
<div class=\\"hover-link\\">
<a href=\\"/shop\\" class=\\"btn btn-secondary swipe-to-top\\" data-toggle=\\"tooltip\\" data-placement=\\"bottom\\" title=\\"\\" data-original-title=\\"\\">تسوق الآن</a>
</div>  
</div>',
                'image' => 125,
                'created_at' => '2020-11-18 06:06:25',
                'updated_at' => '2020-11-18 06:06:25',
            ),
            4 => 
            array (
                'home_banners_id' => 5,
                'banner_name' => 'banners_2',
                'language_id' => 2,
                'text' => '<div class=\\"parallax-banner-text\\">
<h2>فواكه وخضروات طازجة</h2>
<h4>الزراعية الطازجة</h4>
<div class=\\"hover-link\\">
<a href=\\"/shop\\" class=\\"btn btn-secondary swipe-to-top\\" data-toggle=\\"tooltip\\" data-placement=\\"bottom\\" title=\\"\\" data-original-title=\\"\\">عرض كل المدى</a>
</div>  
</div>',
                'image' => 125,
                'created_at' => '2020-11-18 06:06:25',
                'updated_at' => '2020-11-18 06:06:25',
            ),
            5 => 
            array (
                'home_banners_id' => 6,
                'banner_name' => 'banners_3',
                'language_id' => 2,
                'text' => '<div class=\\"parallax-banner-text\\">
<h2>منطقة البقالة</h2>
<h4>المفضلة لديك</h4>
<div class=\\"hover-link\\">
<a href=\\"/shop\\" class=\\"btn btn-secondary swipe-to-top\\" data-toggle=\\"tooltip\\" data-placement=\\"bottom\\" title=\\"\\" data-original-title=\\"\\">اشتري الآن</a>
</div>  
</div>',
                'image' => 125,
                'created_at' => '2020-11-18 06:06:25',
                'updated_at' => '2020-11-18 06:06:25',
            ),
        ));
        
        
    }
}