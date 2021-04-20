<?php

use Illuminate\Database\Seeder;

class AlertSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('alert_settings')->delete();
        
        \DB::table('alert_settings')->insert(array (
            0 => 
            array (
                'alert_id' => 1,
                'create_customer_email' => 0,
                'create_customer_notification' => 0,
                'order_status_email' => 0,
                'order_status_notification' => 0,
                'new_product_email' => 0,
                'new_product_notification' => 0,
                'forgot_email' => 0,
                'forgot_notification' => 0,
                'news_email' => 0,
                'news_notification' => 0,
                'contact_us_email' => 0,
                'contact_us_notification' => 0,
                'order_email' => 0,
                'order_notification' => 0,
            ),
        ));
        
        
    }
}