<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManageRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manage_role', function(Blueprint $table)
		{
			$table->integer('manage_role_id', true);
			$table->boolean('user_types_id')->default(0);
			$table->boolean('dashboard_view')->default(0);
			$table->boolean('manufacturer_view')->default(0);
			$table->boolean('manufacturer_create')->default(0);
			$table->boolean('manufacturer_update')->default(0);
			$table->boolean('manufacturer_delete')->default(0);
			$table->boolean('categories_view')->default(0);
			$table->boolean('categories_create')->default(0);
			$table->boolean('categories_update')->default(0);
			$table->boolean('categories_delete')->default(0);
			$table->boolean('products_view')->default(0);
			$table->boolean('products_create')->default(0);
			$table->boolean('products_update')->default(0);
			$table->boolean('products_delete')->default(0);
			$table->boolean('news_view')->default(0);
			$table->boolean('news_create')->default(0);
			$table->boolean('news_update')->default(0);
			$table->boolean('news_delete')->default(0);
			$table->boolean('customers_view')->default(0);
			$table->boolean('customers_create')->default(0);
			$table->boolean('customers_update')->default(0);
			$table->boolean('customers_delete')->default(0);
			$table->boolean('tax_location_view')->default(0);
			$table->boolean('tax_location_create')->default(0);
			$table->boolean('tax_location_update')->default(0);
			$table->boolean('tax_location_delete')->default(0);
			$table->boolean('coupons_view')->default(0);
			$table->boolean('coupons_create')->default(0);
			$table->boolean('coupons_update')->default(0);
			$table->boolean('coupons_delete')->default(0);
			$table->boolean('notifications_view')->default(0);
			$table->boolean('notifications_send')->default(0);
			$table->boolean('orders_view')->default(0);
			$table->boolean('orders_confirm')->default(0);
			$table->boolean('shipping_methods_view')->default(0);
			$table->boolean('shipping_methods_update')->default(0);
			$table->boolean('payment_methods_view')->default(0);
			$table->boolean('payment_methods_update')->default(0);
			$table->boolean('reports_view')->default(0);
			$table->boolean('website_setting_view')->default(0);
			$table->boolean('website_setting_update')->default(0);
			$table->boolean('application_setting_view')->default(0);
			$table->boolean('application_setting_update')->default(0);
			$table->boolean('general_setting_view')->default(0);
			$table->boolean('general_setting_update')->default(0);
			$table->boolean('manage_admins_view')->default(0);
			$table->boolean('manage_admins_create')->default(0);
			$table->boolean('manage_admins_update')->default(0);
			$table->boolean('manage_admins_delete')->default(0);
			$table->boolean('language_view')->default(0);
			$table->boolean('language_create')->default(0);
			$table->boolean('language_update')->default(0);
			$table->boolean('language_delete')->default(0);
			$table->boolean('profile_view')->default(0);
			$table->boolean('profile_update')->default(0);
			$table->boolean('admintype_view')->default(0);
			$table->boolean('admintype_create')->default(0);
			$table->boolean('admintype_update')->default(0);
			$table->boolean('admintype_delete')->default(0);
			$table->boolean('manage_admins_role')->default(0);
			$table->boolean('add_media')->default(0);
			$table->boolean('edit_media')->default(0);
			$table->boolean('view_media')->default(0);
			$table->boolean('delete_media')->default(0);
			$table->boolean('edit_management')->default(0);
			$table->boolean('reviews_view')->default(0);
			$table->boolean('reviews_update')->default(0);
			$table->boolean('deliveryboy_view')->default(0);
			$table->boolean('deliveryboy_create')->default(0);
			$table->boolean('deliveryboy_update')->default(0);
			$table->boolean('deliveryboy_delete')->default(0);
			$table->boolean('finance_view')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manage_role');
	}

}
