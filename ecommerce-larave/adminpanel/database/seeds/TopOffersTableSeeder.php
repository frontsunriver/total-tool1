<?php

use Illuminate\Database\Seeder;

class TopOffersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('top_offers')->delete();
        
        \DB::table('top_offers')->insert(array (
            0 => 
            array (
                'top_offers_id' => 1,
                'top_offers_text' => '<div class=\\"pro-info\\">
Get<strong> UPTO 40% OFF </strong>on your 1st order
<div class=\\"pro-link-dropdown js-toppanel-link-dropdown\\">
<a href=\\"/shop\\" class=\\"pro-dropdown-toggle\\">
More details
</a>

</div>
</div>',
                'language_id' => 1,
                'created_at' => '2020-02-04 05:14:16',
                'updated_at' => '2020-11-20 05:29:18',
            ),
            1 => 
            array (
                'top_offers_id' => 2,
                'top_offers_text' => '<div class=\\"pro-info\\">
Get<strong> UPTO 40% OFF </strong>on your 1st order
<div class=\\"pro-link-dropdown js-toppanel-link-dropdown\\">
<a href=\\"/shop\\" class=\\"pro-dropdown-toggle\\">
More details
</a>

</div>
</div>',
                'language_id' => 1,
                'created_at' => '2020-02-04 05:14:16',
                'updated_at' => '2020-11-20 05:29:18',
            ),
            2 => 
            array (
                'top_offers_id' => 3,
                'top_offers_text' => 'احصل على <strong> خصم يصل إلى 40٪ </ strong> على طلبك الأول
<div class = \\"pro-link-dropdown js-toppanel-link-dropdown\\">
<a href=\\"/shop\\" class=\\"pro-dropdown-toggle\\">
تسوق الآن
</a>
</div>',
                'language_id' => 2,
                'created_at' => '2020-11-18 07:40:26',
                'updated_at' => '2020-11-20 05:29:18',
            ),
        ));
        
        
    }
}