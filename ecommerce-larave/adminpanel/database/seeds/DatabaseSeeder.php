<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call(AlertSettingsTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoriesDescriptionTableSeeder::class);
        $this->call(ConstantBannersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CurrencyRecordTableSeeder::class);
        $this->call(CurrentThemeTableSeeder::class);
        $this->call(FlateRateTableSeeder::class);
        $this->call(FrontEndThemeContentTableSeeder::class);
        $this->call(HomeBannersTableSeeder::class);
        $this->call(ImageCategoriesTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(LabelValueTableSeeder::class);
        $this->call(LabelsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(ManageRoleTableSeeder::class);
        $this->call(MenuTranslationTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(OrdersStatusTableSeeder::class);
        $this->call(OrdersStatusDescriptionTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PagesDescriptionTableSeeder::class);
        $this->call(PaymentDescriptionTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(PaymentMethodsDetailTableSeeder::class);
        $this->call(ProductsShippingRatesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ShippingDescriptionTableSeeder::class);
        $this->call(ShippingMethodsTableSeeder::class);
        $this->call(SlidersImagesTableSeeder::class);
        $this->call(TopOffersTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(UnitsDescriptionsTableSeeder::class);
        $this->call(UserTypesTableSeeder::class);
        $this->call(ZonesTableSeeder::class);
    }
}
