<?php

use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_types')->delete();
        
        \DB::table('user_types')->insert(array (
            0 => 
            array (
                'user_types_id' => 1,
                'user_types_name' => 'Super Admin',
                'created_at' => 1534774230,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            1 => 
            array (
                'user_types_id' => 2,
                'user_types_name' => 'Customers',
                'created_at' => 1534777027,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            2 => 
            array (
                'user_types_id' => 3,
                'user_types_name' => 'Vendors',
                'created_at' => 1538390209,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            3 => 
            array (
                'user_types_id' => 4,
                'user_types_name' => 'Delivery Guy',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            4 => 
            array (
                'user_types_id' => 5,
                'user_types_name' => 'Test 1',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            5 => 
            array (
                'user_types_id' => 6,
                'user_types_name' => 'Test 2',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            6 => 
            array (
                'user_types_id' => 7,
                'user_types_name' => 'Test 3',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            7 => 
            array (
                'user_types_id' => 8,
                'user_types_name' => 'Test 4',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            8 => 
            array (
                'user_types_id' => 9,
                'user_types_name' => 'Test 5',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            9 => 
            array (
                'user_types_id' => 10,
                'user_types_name' => 'Test 6',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            10 => 
            array (
                'user_types_id' => 11,
                'user_types_name' => 'Admin',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            11 => 
            array (
                'user_types_id' => 12,
                'user_types_name' => 'Manager',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
            12 => 
            array (
                'user_types_id' => 13,
                'user_types_name' => 'Data Entry',
                'created_at' => 1542965906,
                'updated_at' => NULL,
                'isActive' => 1,
            ),
        ));
        
        
    }
}