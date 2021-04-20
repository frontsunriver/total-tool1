<?php

use Illuminate\Database\Seeder;

class LabelValueTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('label_value')->delete();
        
        \DB::table('label_value')->insert(array (
            0 => 
            array (
                'label_value_id' => 1297,
                'label_value' => 'Home',
                'language_id' => 1,
                'label_id' => 1031,
            ),
            1 => 
            array (
                'label_value_id' => 1298,
                'label_value' => 'Menu',
                'language_id' => 1,
                'label_id' => 1030,
            ),
            2 => 
            array (
                'label_value_id' => 1299,
                'label_value' => 'Clear',
                'language_id' => 1,
                'label_id' => 1029,
            ),
            3 => 
            array (
                'label_value_id' => 1300,
                'label_value' => 'Apply',
                'language_id' => 1,
                'label_id' => 1028,
            ),
            4 => 
            array (
                'label_value_id' => 1301,
                'label_value' => 'Close',
                'language_id' => 1,
                'label_id' => 1027,
            ),
            5 => 
            array (
                'label_value_id' => 1302,
                'label_value' => 'Price Range',
                'language_id' => 1,
                'label_id' => 1026,
            ),
            6 => 
            array (
                'label_value_id' => 1303,
                'label_value' => 'Filters',
                'language_id' => 1,
                'label_id' => 1025,
            ),
            7 => 
            array (
                'label_value_id' => 1304,
                'label_value' => 'My Wish List',
                'language_id' => 1,
                'label_id' => 1024,
            ),
            8 => 
            array (
                'label_value_id' => 1305,
                'label_value' => 'Log Out',
                'language_id' => 1,
                'label_id' => 1023,
            ),
            9 => 
            array (
                'label_value_id' => 1306,
                'label_value' => 'Please login or create an account for free',
                'language_id' => 1,
                'label_id' => 1022,
            ),
            10 => 
            array (
                'label_value_id' => 1307,
                'label_value' => 'login & Register',
                'language_id' => 1,
                'label_id' => 1021,
            ),
            11 => 
            array (
                'label_value_id' => 1308,
                'label_value' => 'Save Address',
                'language_id' => 1,
                'label_id' => 1020,
            ),
            12 => 
            array (
                'label_value_id' => 1309,
                'label_value' => 'State',
                'language_id' => 1,
                'label_id' => 1018,
            ),
            13 => 
            array (
                'label_value_id' => 1310,
                'label_value' => 'Update Address',
                'language_id' => 1,
                'label_id' => 1019,
            ),
            14 => 
            array (
                'label_value_id' => 1311,
                'label_value' => 'Post code',
                'language_id' => 1,
                'label_id' => 1017,
            ),
            15 => 
            array (
                'label_value_id' => 1312,
                'label_value' => 'City',
                'language_id' => 1,
                'label_id' => 1016,
            ),
            16 => 
            array (
                'label_value_id' => 1313,
                'label_value' => 'Zone',
                'language_id' => 1,
                'label_id' => 1015,
            ),
            17 => 
            array (
                'label_value_id' => 1314,
                'label_value' => 'other',
                'language_id' => 1,
                'label_id' => 1014,
            ),
            18 => 
            array (
                'label_value_id' => 1315,
                'label_value' => 'Country',
                'language_id' => 1,
                'label_id' => 1013,
            ),
            19 => 
            array (
                'label_value_id' => 1316,
                'label_value' => 'Shipping Address',
                'language_id' => 1,
                'label_id' => 1012,
            ),
            20 => 
            array (
                'label_value_id' => 1317,
                'label_value' => 'Proceed',
                'language_id' => 1,
                'label_id' => 1011,
            ),
            21 => 
            array (
                'label_value_id' => 1318,
                'label_value' => 'Remove',
                'language_id' => 1,
                'label_id' => 1010,
            ),
            22 => 
            array (
                'label_value_id' => 1319,
                'label_value' => 'by',
                'language_id' => 1,
                'label_id' => 1008,
            ),
            23 => 
            array (
                'label_value_id' => 1320,
                'label_value' => 'View',
                'language_id' => 1,
                'label_id' => 1009,
            ),
            24 => 
            array (
                'label_value_id' => 1321,
                'label_value' => 'Quantity',
                'language_id' => 1,
                'label_id' => 1007,
            ),
            25 => 
            array (
                'label_value_id' => 1322,
                'label_value' => 'Price',
                'language_id' => 1,
                'label_id' => 1006,
            ),
            26 => 
            array (
                'label_value_id' => 1323,
                'label_value' => 'continue shopping',
                'language_id' => 1,
                'label_id' => 1005,
            ),
            27 => 
            array (
                'label_value_id' => 1324,
                'label_value' => 'Your cart is empty',
                'language_id' => 1,
                'label_id' => 1004,
            ),
            28 => 
            array (
                'label_value_id' => 1325,
                'label_value' => 'My Cart',
                'language_id' => 1,
                'label_id' => 1003,
            ),
            29 => 
            array (
                'label_value_id' => 1326,
                'label_value' => 'Continue',
                'language_id' => 1,
                'label_id' => 1002,
            ),
            30 => 
            array (
                'label_value_id' => 1327,
                'label_value' => 'Error: invalid cvc number!',
                'language_id' => 1,
                'label_id' => 1001,
            ),
            31 => 
            array (
                'label_value_id' => 1328,
                'label_value' => 'Error: invalid expiry date!',
                'language_id' => 1,
                'label_id' => 1000,
            ),
            32 => 
            array (
                'label_value_id' => 1329,
                'label_value' => 'Error: invalid card number!',
                'language_id' => 1,
                'label_id' => 999,
            ),
            33 => 
            array (
                'label_value_id' => 1330,
                'label_value' => 'Expiration',
                'language_id' => 1,
                'label_id' => 998,
            ),
            34 => 
            array (
                'label_value_id' => 1331,
                'label_value' => 'Expiration Date',
                'language_id' => 1,
                'label_id' => 997,
            ),
            35 => 
            array (
                'label_value_id' => 1332,
                'label_value' => 'Card Number',
                'language_id' => 1,
                'label_id' => 996,
            ),
            36 => 
            array (
                'label_value_id' => 1333,
                'label_value' => 'Payment',
                'language_id' => 1,
                'label_id' => 995,
            ),
            37 => 
            array (
                'label_value_id' => 1334,
                'label_value' => 'Order Notes',
                'language_id' => 1,
                'label_id' => 994,
            ),
            38 => 
            array (
                'label_value_id' => 1335,
                'label_value' => 'Shipping Cost',
                'language_id' => 1,
                'label_id' => 993,
            ),
            39 => 
            array (
                'label_value_id' => 1336,
                'label_value' => 'Tax',
                'language_id' => 1,
                'label_id' => 992,
            ),
            40 => 
            array (
                'label_value_id' => 1337,
                'label_value' => 'Products Price',
                'language_id' => 1,
                'label_id' => 991,
            ),
            41 => 
            array (
                'label_value_id' => 1338,
                'label_value' => 'SubTotal',
                'language_id' => 1,
                'label_id' => 990,
            ),
            42 => 
            array (
                'label_value_id' => 1339,
                'label_value' => 'Products',
                'language_id' => 1,
                'label_id' => 989,
            ),
            43 => 
            array (
                'label_value_id' => 1340,
                'label_value' => 'Shipping Method',
                'language_id' => 1,
                'label_id' => 988,
            ),
            44 => 
            array (
                'label_value_id' => 1341,
                'label_value' => 'Billing Address',
                'language_id' => 1,
                'label_id' => 987,
            ),
            45 => 
            array (
                'label_value_id' => 1342,
                'label_value' => 'Order',
                'language_id' => 1,
                'label_id' => 986,
            ),
            46 => 
            array (
                'label_value_id' => 1343,
                'label_value' => 'Next',
                'language_id' => 1,
                'label_id' => 985,
            ),
            47 => 
            array (
                'label_value_id' => 1344,
                'label_value' => 'Same as Shipping Address',
                'language_id' => 1,
                'label_id' => 984,
            ),
            48 => 
            array (
                'label_value_id' => 1345,
                'label_value' => 'Billing Info',
                'language_id' => 1,
                'label_id' => 981,
            ),
            49 => 
            array (
                'label_value_id' => 1346,
                'label_value' => 'Address',
                'language_id' => 1,
                'label_id' => 982,
            ),
            50 => 
            array (
                'label_value_id' => 1347,
                'label_value' => 'Phone',
                'language_id' => 1,
                'label_id' => 983,
            ),
            51 => 
            array (
                'label_value_id' => 1348,
                'label_value' => 'Already Memeber?',
                'language_id' => 1,
                'label_id' => 980,
            ),
            52 => 
            array (
                'label_value_id' => 1349,
                'label_value' => 'Last Name',
                'language_id' => 1,
                'label_id' => 979,
            ),
            53 => 
            array (
                'label_value_id' => 1350,
                'label_value' => 'First Name',
                'language_id' => 1,
                'label_id' => 978,
            ),
            54 => 
            array (
                'label_value_id' => 1351,
                'label_value' => 'Create an Account',
                'language_id' => 1,
                'label_id' => 977,
            ),
            55 => 
            array (
                'label_value_id' => 1352,
                'label_value' => 'Add new Address',
                'language_id' => 1,
                'label_id' => 976,
            ),
            56 => 
            array (
                'label_value_id' => 1353,
                'label_value' => 'Please add your new shipping address for the futher processing of the your order',
                'language_id' => 1,
                'label_id' => 975,
            ),
            57 => 
            array (
                'label_value_id' => 1354,
                'label_value' => 'Order Status',
                'language_id' => 1,
                'label_id' => 969,
            ),
            58 => 
            array (
                'label_value_id' => 1355,
                'label_value' => 'Orders ID',
                'language_id' => 1,
                'label_id' => 970,
            ),
            59 => 
            array (
                'label_value_id' => 1356,
                'label_value' => 'Product Price',
                'language_id' => 1,
                'label_id' => 971,
            ),
            60 => 
            array (
                'label_value_id' => 1357,
                'label_value' => 'No. of Products',
                'language_id' => 1,
                'label_id' => 972,
            ),
            61 => 
            array (
                'label_value_id' => 1358,
                'label_value' => 'Date',
                'language_id' => 1,
                'label_id' => 973,
            ),
            62 => 
            array (
                'label_value_id' => 1359,
                'label_value' => 'Customer Address',
                'language_id' => 1,
                'label_id' => 974,
            ),
            63 => 
            array (
                'label_value_id' => 1360,
                'label_value' => 'Customer Orders',
                'language_id' => 1,
                'label_id' => 968,
            ),
            64 => 
            array (
                'label_value_id' => 1361,
                'label_value' => 'Change Password',
                'language_id' => 1,
                'label_id' => 967,
            ),
            65 => 
            array (
                'label_value_id' => 1362,
                'label_value' => 'New Password',
                'language_id' => 1,
                'label_id' => 966,
            ),
            66 => 
            array (
                'label_value_id' => 1363,
                'label_value' => 'Current Password',
                'language_id' => 1,
                'label_id' => 965,
            ),
            67 => 
            array (
                'label_value_id' => 1364,
                'label_value' => 'Update',
                'language_id' => 1,
                'label_id' => 964,
            ),
            68 => 
            array (
                'label_value_id' => 1365,
                'label_value' => 'Date of Birth',
                'language_id' => 1,
                'label_id' => 963,
            ),
            69 => 
            array (
                'label_value_id' => 1366,
                'label_value' => 'Mobile',
                'language_id' => 1,
                'label_id' => 962,
            ),
            70 => 
            array (
                'label_value_id' => 1367,
                'label_value' => 'My Account',
                'language_id' => 1,
                'label_id' => 961,
            ),
            71 => 
            array (
                'label_value_id' => 1368,
                'label_value' => 'Likes',
                'language_id' => 1,
                'label_id' => 960,
            ),
            72 => 
            array (
                'label_value_id' => 1369,
                'label_value' => 'Newest',
                'language_id' => 1,
                'label_id' => 959,
            ),
            73 => 
            array (
                'label_value_id' => 1370,
                'label_value' => 'Top Seller',
                'language_id' => 1,
                'label_id' => 958,
            ),
            74 => 
            array (
                'label_value_id' => 1371,
                'label_value' => 'Special',
                'language_id' => 1,
                'label_id' => 957,
            ),
            75 => 
            array (
                'label_value_id' => 1372,
                'label_value' => 'Most Liked',
                'language_id' => 1,
                'label_id' => 956,
            ),
            76 => 
            array (
                'label_value_id' => 1373,
                'label_value' => 'Cancel',
                'language_id' => 1,
                'label_id' => 955,
            ),
            77 => 
            array (
                'label_value_id' => 1374,
                'label_value' => 'Sort Products',
                'language_id' => 1,
                'label_id' => 954,
            ),
            78 => 
            array (
                'label_value_id' => 1375,
                'label_value' => 'Special Products',
                'language_id' => 1,
                'label_id' => 953,
            ),
            79 => 
            array (
                'label_value_id' => 1376,
                'label_value' => 'Price : low - high',
                'language_id' => 1,
                'label_id' => 952,
            ),
            80 => 
            array (
                'label_value_id' => 1377,
                'label_value' => 'Price : high - low',
                'language_id' => 1,
                'label_id' => 951,
            ),
            81 => 
            array (
                'label_value_id' => 1378,
                'label_value' => 'Z - A',
                'language_id' => 1,
                'label_id' => 950,
            ),
            82 => 
            array (
                'label_value_id' => 1379,
                'label_value' => 'A - Z',
                'language_id' => 1,
                'label_id' => 949,
            ),
            83 => 
            array (
                'label_value_id' => 1380,
                'label_value' => 'All',
                'language_id' => 1,
                'label_id' => 948,
            ),
            84 => 
            array (
                'label_value_id' => 1381,
                'label_value' => 'Explore More',
                'language_id' => 1,
                'label_id' => 947,
            ),
            85 => 
            array (
                'label_value_id' => 1382,
                'label_value' => 'Note to the buyer',
                'language_id' => 1,
                'label_id' => 946,
            ),
            86 => 
            array (
                'label_value_id' => 1383,
                'label_value' => 'Coupon',
                'language_id' => 1,
                'label_id' => 945,
            ),
            87 => 
            array (
                'label_value_id' => 1384,
                'label_value' => 'coupon code',
                'language_id' => 1,
                'label_id' => 944,
            ),
            88 => 
            array (
                'label_value_id' => 1385,
                'label_value' => 'Coupon Amount',
                'language_id' => 1,
                'label_id' => 943,
            ),
            89 => 
            array (
                'label_value_id' => 1386,
                'label_value' => 'Coupon Code',
                'language_id' => 1,
                'label_id' => 942,
            ),
            90 => 
            array (
                'label_value_id' => 1387,
                'label_value' => 'Food Categories',
                'language_id' => 1,
                'label_id' => 941,
            ),
            91 => 
            array (
                'label_value_id' => 1388,
                'label_value' => 'Recipe of Day',
                'language_id' => 1,
                'label_id' => 940,
            ),
            92 => 
            array (
                'label_value_id' => 1389,
                'label_value' => 'Top Dishes',
                'language_id' => 1,
                'label_id' => 939,
            ),
            93 => 
            array (
                'label_value_id' => 1390,
                'label_value' => 'Skip',
                'language_id' => 1,
                'label_id' => 938,
            ),
            94 => 
            array (
                'label_value_id' => 1391,
                'label_value' => 'Term and Services',
                'language_id' => 1,
                'label_id' => 937,
            ),
            95 => 
            array (
                'label_value_id' => 1392,
                'label_value' => 'Privacy Policy',
                'language_id' => 1,
                'label_id' => 936,
            ),
            96 => 
            array (
                'label_value_id' => 1393,
                'label_value' => 'Refund Policy',
                'language_id' => 1,
                'label_id' => 935,
            ),
            97 => 
            array (
                'label_value_id' => 1394,
                'label_value' => 'Newest',
                'language_id' => 1,
                'label_id' => 934,
            ),
            98 => 
            array (
                'label_value_id' => 1395,
                'label_value' => 'OUT OF STOCK',
                'language_id' => 1,
                'label_id' => 933,
            ),
            99 => 
            array (
                'label_value_id' => 1396,
                'label_value' => 'Select Language',
                'language_id' => 1,
                'label_id' => 932,
            ),
            100 => 
            array (
                'label_value_id' => 1397,
                'label_value' => 'Reset',
                'language_id' => 1,
                'label_id' => 931,
            ),
            101 => 
            array (
                'label_value_id' => 1398,
                'label_value' => 'Shop',
                'language_id' => 1,
                'label_id' => 930,
            ),
            102 => 
            array (
                'label_value_id' => 1399,
                'label_value' => 'Settings',
                'language_id' => 1,
                'label_id' => 929,
            ),
            103 => 
            array (
                'label_value_id' => 1400,
                'label_value' => 'Enter keyword',
                'language_id' => 1,
                'label_id' => 928,
            ),
            104 => 
            array (
                'label_value_id' => 1401,
                'label_value' => 'News',
                'language_id' => 1,
                'label_id' => 927,
            ),
            105 => 
            array (
                'label_value_id' => 1402,
                'label_value' => 'Top Sellers',
                'language_id' => 1,
                'label_id' => 926,
            ),
            106 => 
            array (
                'label_value_id' => 1403,
                'label_value' => 'Go Back',
                'language_id' => 1,
                'label_id' => 925,
            ),
            107 => 
            array (
                'label_value_id' => 1404,
                'label_value' => 'Word Press Post Detail',
                'language_id' => 1,
                'label_id' => 924,
            ),
            108 => 
            array (
                'label_value_id' => 1405,
                'label_value' => 'Explore',
                'language_id' => 1,
                'label_id' => 923,
            ),
            109 => 
            array (
                'label_value_id' => 1406,
                'label_value' => 'Continue Adding',
                'language_id' => 1,
                'label_id' => 922,
            ),
            110 => 
            array (
                'label_value_id' => 1407,
                'label_value' => 'Your wish List is empty',
                'language_id' => 1,
                'label_id' => 921,
            ),
            111 => 
            array (
                'label_value_id' => 1408,
                'label_value' => 'Favourite',
                'language_id' => 1,
                'label_id' => 920,
            ),
            112 => 
            array (
                'label_value_id' => 1409,
                'label_value' => 'Continue Shopping',
                'language_id' => 1,
                'label_id' => 919,
            ),
            113 => 
            array (
                'label_value_id' => 1410,
                'label_value' => 'My Orders',
                'language_id' => 1,
                'label_id' => 918,
            ),
            114 => 
            array (
                'label_value_id' => 1411,
                'label_value' => 'Thank you for shopping with us.',
                'language_id' => 1,
                'label_id' => 917,
            ),
            115 => 
            array (
                'label_value_id' => 1412,
                'label_value' => 'Thank You',
                'language_id' => 1,
                'label_id' => 916,
            ),
            116 => 
            array (
                'label_value_id' => 1413,
                'label_value' => 'Shipping method',
                'language_id' => 1,
                'label_id' => 915,
            ),
            117 => 
            array (
                'label_value_id' => 1414,
                'label_value' => 'Sub Categories',
                'language_id' => 1,
                'label_id' => 914,
            ),
            118 => 
            array (
                'label_value_id' => 1415,
                'label_value' => 'Main Categories',
                'language_id' => 1,
                'label_id' => 913,
            ),
            119 => 
            array (
                'label_value_id' => 1416,
                'label_value' => 'Search',
                'language_id' => 1,
                'label_id' => 912,
            ),
            120 => 
            array (
                'label_value_id' => 1417,
                'label_value' => 'Reset Filters',
                'language_id' => 1,
                'label_id' => 911,
            ),
            121 => 
            array (
                'label_value_id' => 1418,
                'label_value' => 'No Products Found',
                'language_id' => 1,
                'label_id' => 910,
            ),
            122 => 
            array (
                'label_value_id' => 1419,
                'label_value' => 'OFF',
                'language_id' => 1,
                'label_id' => 909,
            ),
            123 => 
            array (
                'label_value_id' => 1420,
                'label_value' => 'Techincal details',
                'language_id' => 1,
                'label_id' => 908,
            ),
            124 => 
            array (
                'label_value_id' => 1421,
                'label_value' => 'Product Description',
                'language_id' => 1,
                'label_id' => 907,
            ),
            125 => 
            array (
                'label_value_id' => 1422,
                'label_value' => 'ADD TO CART',
                'language_id' => 1,
                'label_id' => 906,
            ),
            126 => 
            array (
                'label_value_id' => 1423,
                'label_value' => 'Add to Cart',
                'language_id' => 1,
                'label_id' => 905,
            ),
            127 => 
            array (
                'label_value_id' => 1424,
                'label_value' => 'In Stock',
                'language_id' => 1,
                'label_id' => 904,
            ),
            128 => 
            array (
                'label_value_id' => 1425,
                'label_value' => 'Out of Stock',
                'language_id' => 1,
                'label_id' => 903,
            ),
            129 => 
            array (
                'label_value_id' => 1426,
                'label_value' => 'New',
                'language_id' => 1,
                'label_id' => 902,
            ),
            130 => 
            array (
                'label_value_id' => 1427,
                'label_value' => 'Product Details',
                'language_id' => 1,
                'label_id' => 901,
            ),
            131 => 
            array (
                'label_value_id' => 1428,
                'label_value' => 'Shipping',
                'language_id' => 1,
                'label_id' => 900,
            ),
            132 => 
            array (
                'label_value_id' => 1429,
                'label_value' => 'Sub Total',
                'language_id' => 1,
                'label_id' => 899,
            ),
            133 => 
            array (
                'label_value_id' => 1430,
                'label_value' => 'Total',
                'language_id' => 1,
                'label_id' => 898,
            ),
            134 => 
            array (
                'label_value_id' => 1431,
                'label_value' => 'Price Detail',
                'language_id' => 1,
                'label_id' => 897,
            ),
            135 => 
            array (
                'label_value_id' => 1432,
                'label_value' => 'Order Detail',
                'language_id' => 1,
                'label_id' => 896,
            ),
            136 => 
            array (
                'label_value_id' => 1433,
                'label_value' => 'Got It!',
                'language_id' => 1,
                'label_id' => 895,
            ),
            137 => 
            array (
                'label_value_id' => 1434,
                'label_value' => 'Skip Intro',
                'language_id' => 1,
                'label_id' => 894,
            ),
            138 => 
            array (
                'label_value_id' => 1435,
                'label_value' => 'Intro',
                'language_id' => 1,
                'label_id' => 893,
            ),
            139 => 
            array (
                'label_value_id' => 1436,
                'label_value' => 'REMOVE',
                'language_id' => 1,
                'label_id' => 892,
            ),
            140 => 
            array (
                'label_value_id' => 1437,
                'label_value' => 'Deals',
                'language_id' => 1,
                'label_id' => 891,
            ),
            141 => 
            array (
                'label_value_id' => 1438,
                'label_value' => 'All Categories',
                'language_id' => 1,
                'label_id' => 890,
            ),
            142 => 
            array (
                'label_value_id' => 1439,
                'label_value' => 'Most Liked',
                'language_id' => 1,
                'label_id' => 889,
            ),
            143 => 
            array (
                'label_value_id' => 1440,
                'label_value' => 'Special Deals',
                'language_id' => 1,
                'label_id' => 888,
            ),
            144 => 
            array (
                'label_value_id' => 1441,
                'label_value' => 'Top Seller',
                'language_id' => 1,
                'label_id' => 887,
            ),
            145 => 
            array (
                'label_value_id' => 1442,
                'label_value' => 'Products are available.',
                'language_id' => 1,
                'label_id' => 886,
            ),
            146 => 
            array (
                'label_value_id' => 1443,
                'label_value' => 'Recently Viewed',
                'language_id' => 1,
                'label_id' => 885,
            ),
            147 => 
            array (
                'label_value_id' => 1444,
                'label_value' => 'Please connect to the internet',
                'language_id' => 1,
                'label_id' => 884,
            ),
            148 => 
            array (
                'label_value_id' => 1445,
                'label_value' => 'Contact Us',
                'language_id' => 1,
                'label_id' => 881,
            ),
            149 => 
            array (
                'label_value_id' => 1446,
                'label_value' => 'Name',
                'language_id' => 1,
                'label_id' => 882,
            ),
            150 => 
            array (
                'label_value_id' => 1447,
                'label_value' => 'Your Message',
                'language_id' => 1,
                'label_id' => 883,
            ),
            151 => 
            array (
                'label_value_id' => 1448,
                'label_value' => 'Categories',
                'language_id' => 1,
                'label_id' => 880,
            ),
            152 => 
            array (
                'label_value_id' => 1449,
                'label_value' => 'About Us',
                'language_id' => 1,
                'label_id' => 879,
            ),
            153 => 
            array (
                'label_value_id' => 1450,
                'label_value' => 'Send',
                'language_id' => 1,
                'label_id' => 878,
            ),
            154 => 
            array (
                'label_value_id' => 1451,
                'label_value' => 'Forgot Password',
                'language_id' => 1,
                'label_id' => 877,
            ),
            155 => 
            array (
                'label_value_id' => 1452,
                'label_value' => 'Register',
                'language_id' => 1,
                'label_id' => 876,
            ),
            156 => 
            array (
                'label_value_id' => 1453,
                'label_value' => 'Password',
                'language_id' => 1,
                'label_id' => 875,
            ),
            157 => 
            array (
                'label_value_id' => 1454,
                'label_value' => 'Email',
                'language_id' => 1,
                'label_id' => 874,
            ),
            158 => 
            array (
                'label_value_id' => 1455,
                'label_value' => 'or',
                'language_id' => 1,
                'label_id' => 873,
            ),
            159 => 
            array (
                'label_value_id' => 1456,
                'label_value' => 'Login with',
                'language_id' => 1,
                'label_id' => 872,
            ),
            160 => 
            array (
                'label_value_id' => 1457,
                'label_value' => 'Creating an account means you\'re okay with shopify\'s Terms of Service, Privacy Policy',
                'language_id' => 1,
                'label_id' => 2,
            ),
            161 => 
            array (
                'label_value_id' => 1458,
                'label_value' => 'I\'ve forgotten my password?',
                'language_id' => 1,
                'label_id' => 1,
            ),
            163 => 
            array (
                'label_value_id' => 1462,
                'label_value' => 'Creating an account means you’re okay with our',
                'language_id' => 1,
                'label_id' => 1033,
            ),
            164 => 
            array (
                'label_value_id' => 1465,
                'label_value' => 'Login',
                'language_id' => 1,
                'label_id' => 1034,
            ),
            165 => 
            array (
                'label_value_id' => 1468,
                'label_value' => 'Turn on/off Local Notifications',
                'language_id' => 1,
                'label_id' => 1035,
            ),
            166 => 
            array (
                'label_value_id' => 1471,
                'label_value' => 'Turn on/off Notifications',
                'language_id' => 1,
                'label_id' => 1036,
            ),
            167 => 
            array (
                'label_value_id' => 1474,
                'label_value' => 'Change Language',
                'language_id' => 1,
                'label_id' => 1037,
            ),
            168 => 
            array (
                'label_value_id' => 1477,
                'label_value' => 'Official Website',
                'language_id' => 1,
                'label_id' => 1038,
            ),
            169 => 
            array (
                'label_value_id' => 1480,
                'label_value' => 'Rate Us',
                'language_id' => 1,
                'label_id' => 1039,
            ),
            170 => 
            array (
                'label_value_id' => 1483,
                'label_value' => 'Share',
                'language_id' => 1,
                'label_id' => 1040,
            ),
            171 => 
            array (
                'label_value_id' => 1486,
                'label_value' => 'Edit Profile',
                'language_id' => 1,
                'label_id' => 1041,
            ),
            172 => 
            array (
                'label_value_id' => 1489,
                'label_value' => 'A percentage discount for the entire cart',
                'language_id' => 1,
                'label_id' => 1042,
            ),
            173 => 
            array (
                'label_value_id' => 1492,
                'label_value' => 'A fixed total discount for the entire cart',
                'language_id' => 1,
                'label_id' => 1043,
            ),
            174 => 
            array (
                'label_value_id' => 1495,
                'label_value' => 'A fixed total discount for selected products only',
                'language_id' => 1,
                'label_id' => 1044,
            ),
            175 => 
            array (
                'label_value_id' => 1498,
                'label_value' => 'A percentage discount for selected products only',
                'language_id' => 1,
                'label_id' => 1045,
            ),
            176 => 
            array (
                'label_value_id' => 1501,
                'label_value' => 'Network Connected Reloading Data',
                'language_id' => 1,
                'label_id' => 1047,
            ),
            177 => 
            array (
                'label_value_id' => 1503,
                'label_value' => 'Sort by',
                'language_id' => 1,
                'label_id' => 1048,
            ),
            178 => 
            array (
                'label_value_id' => 1505,
                'label_value' => 'Flash Sale',
                'language_id' => 1,
                'label_id' => 1049,
            ),
            179 => 
            array (
                'label_value_id' => 1507,
                'label_value' => 'ok',
                'language_id' => 1,
                'label_id' => 1050,
            ),
            180 => 
            array (
                'label_value_id' => 1509,
                'label_value' => 'Number',
                'language_id' => 1,
                'label_id' => 1051,
            ),
            181 => 
            array (
                'label_value_id' => 1511,
                'label_value' => 'Expire Month',
                'language_id' => 1,
                'label_id' => 1052,
            ),
            182 => 
            array (
                'label_value_id' => 1513,
                'label_value' => 'Expire Year',
                'language_id' => 1,
                'label_id' => 1053,
            ),
            183 => 
            array (
                'label_value_id' => 1515,
                'label_value' => 'Payment Method',
                'language_id' => 1,
                'label_id' => 1054,
            ),
            184 => 
            array (
                'label_value_id' => 1517,
                'label_value' => 'Status',
                'language_id' => 1,
                'label_id' => 1055,
            ),
            185 => 
            array (
                'label_value_id' => 1519,
                'label_value' => 'And',
                'language_id' => 1,
                'label_id' => 1056,
            ),
            186 => 
            array (
                'label_value_id' => 1520,
                'label_value' => 'نسيت كلمة المرور الخاصة بي؟',
                'language_id' => 2,
                'label_id' => 1,
            ),
            187 => 
            array (
                'label_value_id' => 1521,
                'label_value' => 'إن إنشاء حساب يعني موافقتك على شروط الخدمة وسياسة الخصوصية',
                'language_id' => 2,
                'label_id' => 2,
            ),
            188 => 
            array (
                'label_value_id' => 1522,
                'label_value' => 'تسجيل الدخول مع',
                'language_id' => 2,
                'label_id' => 872,
            ),
            189 => 
            array (
                'label_value_id' => 1523,
                'label_value' => 'أو',
                'language_id' => 2,
                'label_id' => 873,
            ),
            190 => 
            array (
                'label_value_id' => 1524,
                'label_value' => 'البريد الإلكتروني',
                'language_id' => 2,
                'label_id' => 874,
            ),
            191 => 
            array (
                'label_value_id' => 1525,
                'label_value' => 'كلمه السر',
                'language_id' => 2,
                'label_id' => 875,
            ),
            192 => 
            array (
                'label_value_id' => 1526,
                'label_value' => 'تسجيل',
                'language_id' => 2,
                'label_id' => 876,
            ),
            193 => 
            array (
                'label_value_id' => 1527,
                'label_value' => 'هل نسيت كلمة المرور',
                'language_id' => 2,
                'label_id' => 877,
            ),
            194 => 
            array (
                'label_value_id' => 1528,
                'label_value' => 'إرسال',
                'language_id' => 2,
                'label_id' => 878,
            ),
            195 => 
            array (
                'label_value_id' => 1529,
                'label_value' => 'معلومات عنا',
                'language_id' => 2,
                'label_id' => 879,
            ),
            196 => 
            array (
                'label_value_id' => 1530,
                'label_value' => 'التصنيفات',
                'language_id' => 2,
                'label_id' => 880,
            ),
            197 => 
            array (
                'label_value_id' => 1531,
                'label_value' => 'اتصل بنا',
                'language_id' => 2,
                'label_id' => 881,
            ),
            198 => 
            array (
                'label_value_id' => 1532,
                'label_value' => 'اسم',
                'language_id' => 2,
                'label_id' => 882,
            ),
            199 => 
            array (
                'label_value_id' => 1533,
                'label_value' => 'رسالتك',
                'language_id' => 2,
                'label_id' => 883,
            ),
            200 => 
            array (
                'label_value_id' => 1534,
                'label_value' => 'يرجى الاتصال بالإنترنت',
                'language_id' => 2,
                'label_id' => 884,
            ),
            201 => 
            array (
                'label_value_id' => 1535,
                'label_value' => 'شوهدت مؤخرا',
                'language_id' => 2,
                'label_id' => 885,
            ),
            202 => 
            array (
                'label_value_id' => 1536,
                'label_value' => 'المنتجات المتاحة.',
                'language_id' => 2,
                'label_id' => 886,
            ),
            203 => 
            array (
                'label_value_id' => 1537,
                'label_value' => 'أعلى بائع',
                'language_id' => 2,
                'label_id' => 887,
            ),
            204 => 
            array (
                'label_value_id' => 1538,
                'label_value' => 'صفقة خاصة',
                'language_id' => 2,
                'label_id' => 888,
            ),
            205 => 
            array (
                'label_value_id' => 1539,
                'label_value' => 'الأكثر إعجابا',
                'language_id' => 2,
                'label_id' => 889,
            ),
            206 => 
            array (
                'label_value_id' => 1540,
                'label_value' => 'جميع الفئات',
                'language_id' => 2,
                'label_id' => 890,
            ),
            207 => 
            array (
                'label_value_id' => 1541,
                'label_value' => 'صفقات',
                'language_id' => 2,
                'label_id' => 891,
            ),
            208 => 
            array (
                'label_value_id' => 1542,
                'label_value' => 'إزالة',
                'language_id' => 2,
                'label_id' => 892,
            ),
            209 => 
            array (
                'label_value_id' => 1543,
                'label_value' => 'مقدمة',
                'language_id' => 2,
                'label_id' => 893,
            ),
            210 => 
            array (
                'label_value_id' => 1544,
                'label_value' => 'تخطي المقدمة',
                'language_id' => 2,
                'label_id' => 894,
            ),
            211 => 
            array (
                'label_value_id' => 1545,
                'label_value' => 'فهمتك!',
                'language_id' => 2,
                'label_id' => 895,
            ),
            212 => 
            array (
                'label_value_id' => 1546,
                'label_value' => 'تفاصيل الطلب',
                'language_id' => 2,
                'label_id' => 896,
            ),
            213 => 
            array (
                'label_value_id' => 1547,
                'label_value' => 'سعر التفاصيل',
                'language_id' => 2,
                'label_id' => 897,
            ),
            214 => 
            array (
                'label_value_id' => 1548,
                'label_value' => 'مجموع',
                'language_id' => 2,
                'label_id' => 898,
            ),
            215 => 
            array (
                'label_value_id' => 1549,
                'label_value' => 'المجموع الفرعي',
                'language_id' => 2,
                'label_id' => 899,
            ),
            216 => 
            array (
                'label_value_id' => 1550,
                'label_value' => 'الشحن',
                'language_id' => 2,
                'label_id' => 900,
            ),
            217 => 
            array (
                'label_value_id' => 1551,
                'label_value' => 'تفاصيل المنتج',
                'language_id' => 2,
                'label_id' => 901,
            ),
            218 => 
            array (
                'label_value_id' => 1552,
                'label_value' => 'جديد',
                'language_id' => 2,
                'label_id' => 902,
            ),
            219 => 
            array (
                'label_value_id' => 1553,
                'label_value' => 'إنتهى من المخزن',
                'language_id' => 2,
                'label_id' => 903,
            ),
            220 => 
            array (
                'label_value_id' => 1554,
                'label_value' => 'في المخزن',
                'language_id' => 2,
                'label_id' => 904,
            ),
            221 => 
            array (
                'label_value_id' => 1555,
                'label_value' => 'أضف إلى السلة',
                'language_id' => 2,
                'label_id' => 905,
            ),
            222 => 
            array (
                'label_value_id' => 1556,
                'label_value' => 'أضف إلى السلة',
                'language_id' => 2,
                'label_id' => 906,
            ),
            223 => 
            array (
                'label_value_id' => 1557,
                'label_value' => 'وصف المنتج',
                'language_id' => 2,
                'label_id' => 907,
            ),
            224 => 
            array (
                'label_value_id' => 1558,
                'label_value' => 'تفاصيل تقنية',
                'language_id' => 2,
                'label_id' => 908,
            ),
            225 => 
            array (
                'label_value_id' => 1559,
                'label_value' => 'إيقاف',
                'language_id' => 2,
                'label_id' => 909,
            ),
            226 => 
            array (
                'label_value_id' => 1560,
                'label_value' => 'لا توجد منتجات',
                'language_id' => 2,
                'label_id' => 910,
            ),
            227 => 
            array (
                'label_value_id' => 1561,
                'label_value' => 'إعادة تعيين المرشحات',
                'language_id' => 2,
                'label_id' => 911,
            ),
            228 => 
            array (
                'label_value_id' => 1562,
                'label_value' => 'بحث',
                'language_id' => 2,
                'label_id' => 912,
            ),
            229 => 
            array (
                'label_value_id' => 1563,
                'label_value' => 'الفئات الرئيسية',
                'language_id' => 2,
                'label_id' => 913,
            ),
            230 => 
            array (
                'label_value_id' => 1564,
                'label_value' => 'الفئات الفرعية',
                'language_id' => 2,
                'label_id' => 914,
            ),
            231 => 
            array (
                'label_value_id' => 1565,
                'label_value' => 'طريقة الشحن',
                'language_id' => 2,
                'label_id' => 915,
            ),
            232 => 
            array (
                'label_value_id' => 1566,
                'label_value' => 'شكرا جزيلا',
                'language_id' => 2,
                'label_id' => 916,
            ),
            233 => 
            array (
                'label_value_id' => 1567,
                'label_value' => 'شكرا للتسوق معنا.',
                'language_id' => 2,
                'label_id' => 917,
            ),
            234 => 
            array (
                'label_value_id' => 1568,
                'label_value' => 'طلباتي',
                'language_id' => 2,
                'label_id' => 918,
            ),
            235 => 
            array (
                'label_value_id' => 1569,
                'label_value' => 'مواصلة التسوق',
                'language_id' => 2,
                'label_id' => 919,
            ),
            237 => 
            array (
                'label_value_id' => 1571,
                'label_value' => 'مفضل',
                'language_id' => 2,
                'label_id' => 920,
            ),
            238 => 
            array (
                'label_value_id' => 1572,
                'label_value' => 'قائمة رغباتك فارغة',
                'language_id' => 2,
                'label_id' => 921,
            ),
            239 => 
            array (
                'label_value_id' => 1573,
                'label_value' => 'متابعة الإضافة',
                'language_id' => 2,
                'label_id' => 922,
            ),
            240 => 
            array (
                'label_value_id' => 1574,
                'label_value' => 'يكتشف',
                'language_id' => 2,
                'label_id' => 923,
            ),
            241 => 
            array (
                'label_value_id' => 1575,
                'label_value' => 'وورد بوست التفاصيل',
                'language_id' => 2,
                'label_id' => 924,
            ),
            242 => 
            array (
                'label_value_id' => 1576,
                'label_value' => 'عد',
                'language_id' => 2,
                'label_id' => 925,
            ),
            243 => 
            array (
                'label_value_id' => 1577,
                'label_value' => 'أفضل البائعين',
                'language_id' => 2,
                'label_id' => 926,
            ),
            244 => 
            array (
                'label_value_id' => 1578,
                'label_value' => 'أخبار',
                'language_id' => 2,
                'label_id' => 927,
            ),
            245 => 
            array (
                'label_value_id' => 1579,
                'label_value' => 'أدخل الكلمة المفتاحية',
                'language_id' => 2,
                'label_id' => 928,
            ),
            246 => 
            array (
                'label_value_id' => 1580,
                'label_value' => 'الإعدادات',
                'language_id' => 2,
                'label_id' => 929,
            ),
            247 => 
            array (
                'label_value_id' => 1581,
                'label_value' => 'متجر',
                'language_id' => 2,
                'label_id' => 930,
            ),
            248 => 
            array (
                'label_value_id' => 1582,
                'label_value' => 'إعادة تعيين',
                'language_id' => 2,
                'label_id' => 931,
            ),
            249 => 
            array (
                'label_value_id' => 1583,
                'label_value' => 'اختار اللغة',
                'language_id' => 2,
                'label_id' => 932,
            ),
            250 => 
            array (
                'label_value_id' => 1584,
                'label_value' => 'إنتهى من المخزن',
                'language_id' => 2,
                'label_id' => 933,
            ),
            251 => 
            array (
                'label_value_id' => 1585,
                'label_value' => 'الأحدث',
                'language_id' => 2,
                'label_id' => 934,
            ),
            252 => 
            array (
                'label_value_id' => 1586,
                'label_value' => 'سياسة الاسترجاع',
                'language_id' => 2,
                'label_id' => 935,
            ),
            253 => 
            array (
                'label_value_id' => 1587,
                'label_value' => 'سياسة خاصة',
                'language_id' => 2,
                'label_id' => 936,
            ),
            254 => 
            array (
                'label_value_id' => 1588,
                'label_value' => 'مصطلح والخدمات',
                'language_id' => 2,
                'label_id' => 937,
            ),
            255 => 
            array (
                'label_value_id' => 1589,
                'label_value' => 'تخطى',
                'language_id' => 2,
                'label_id' => 938,
            ),
            256 => 
            array (
                'label_value_id' => 1590,
                'label_value' => 'أطباق الأعلى',
                'language_id' => 2,
                'label_id' => 939,
            ),
            257 => 
            array (
                'label_value_id' => 1591,
                'label_value' => 'وصفة اليوم',
                'language_id' => 2,
                'label_id' => 940,
            ),
            258 => 
            array (
                'label_value_id' => 1592,
                'label_value' => 'فئات الغذاء',
                'language_id' => 2,
                'label_id' => 941,
            ),
            259 => 
            array (
                'label_value_id' => 1593,
                'label_value' => 'رمز الكوبون',
                'language_id' => 2,
                'label_id' => 942,
            ),
            260 => 
            array (
                'label_value_id' => 1594,
                'label_value' => 'مبلغ القسيمة',
                'language_id' => 2,
                'label_id' => 943,
            ),
            261 => 
            array (
                'label_value_id' => 1595,
                'label_value' => 'رمز الكوبون',
                'language_id' => 2,
                'label_id' => 944,
            ),
            262 => 
            array (
                'label_value_id' => 1596,
                'label_value' => 'كوبون',
                'language_id' => 2,
                'label_id' => 945,
            ),
            263 => 
            array (
                'label_value_id' => 1597,
                'label_value' => 'ملاحظة للمشتري',
                'language_id' => 2,
                'label_id' => 946,
            ),
            264 => 
            array (
                'label_value_id' => 1598,
                'label_value' => 'استكشاف المزيد',
                'language_id' => 2,
                'label_id' => 947,
            ),
            265 => 
            array (
                'label_value_id' => 1599,
                'label_value' => 'الكل',
                'language_id' => 2,
                'label_id' => 948,
            ),
            266 => 
            array (
                'label_value_id' => 1600,
                'label_value' => 'أ - ي',
                'language_id' => 2,
                'label_id' => 949,
            ),
            267 => 
            array (
                'label_value_id' => 1601,
                'label_value' => 'ي - أ',
                'language_id' => 2,
                'label_id' => 950,
            ),
            268 => 
            array (
                'label_value_id' => 1602,
                'label_value' => 'السعر مرتفع منخفض',
                'language_id' => 2,
                'label_id' => 951,
            ),
            269 => 
            array (
                'label_value_id' => 1603,
                'label_value' => 'سعر منخفض مرتفع',
                'language_id' => 2,
                'label_id' => 952,
            ),
            270 => 
            array (
                'label_value_id' => 1604,
                'label_value' => 'المنتجات الخاصة',
                'language_id' => 2,
                'label_id' => 953,
            ),
            271 => 
            array (
                'label_value_id' => 1605,
                'label_value' => 'فرز المنتجات',
                'language_id' => 2,
                'label_id' => 954,
            ),
            272 => 
            array (
                'label_value_id' => 1606,
                'label_value' => 'إلغاء',
                'language_id' => 2,
                'label_id' => 955,
            ),
            273 => 
            array (
                'label_value_id' => 1607,
                'label_value' => 'الأكثر إعجابا',
                'language_id' => 2,
                'label_id' => 956,
            ),
            274 => 
            array (
                'label_value_id' => 1608,
                'label_value' => 'خاص',
                'language_id' => 2,
                'label_id' => 957,
            ),
            275 => 
            array (
                'label_value_id' => 1609,
                'label_value' => 'أعلى بائع',
                'language_id' => 2,
                'label_id' => 958,
            ),
            276 => 
            array (
                'label_value_id' => 1610,
                'label_value' => 'الأحدث',
                'language_id' => 2,
                'label_id' => 959,
            ),
            277 => 
            array (
                'label_value_id' => 1611,
                'label_value' => 'الإعجابات',
                'language_id' => 2,
                'label_id' => 960,
            ),
            278 => 
            array (
                'label_value_id' => 1612,
                'label_value' => 'حسابي',
                'language_id' => 2,
                'label_id' => 961,
            ),
            279 => 
            array (
                'label_value_id' => 1613,
                'label_value' => 'التليفون المحمول',
                'language_id' => 2,
                'label_id' => 962,
            ),
            280 => 
            array (
                'label_value_id' => 1614,
                'label_value' => 'تاريخ الولادة',
                'language_id' => 2,
                'label_id' => 963,
            ),
            281 => 
            array (
                'label_value_id' => 1615,
                'label_value' => 'تحديث',
                'language_id' => 2,
                'label_id' => 964,
            ),
            282 => 
            array (
                'label_value_id' => 1616,
                'label_value' => 'كلمة المرور الحالية',
                'language_id' => 2,
                'label_id' => 965,
            ),
            283 => 
            array (
                'label_value_id' => 1617,
                'label_value' => 'كلمة سر جديدة',
                'language_id' => 2,
                'label_id' => 966,
            ),
            284 => 
            array (
                'label_value_id' => 1618,
                'label_value' => 'تغيير كلمة المرور',
                'language_id' => 2,
                'label_id' => 967,
            ),
            285 => 
            array (
                'label_value_id' => 1619,
                'label_value' => 'طلبات العملاء',
                'language_id' => 2,
                'label_id' => 968,
            ),
            286 => 
            array (
                'label_value_id' => 1620,
                'label_value' => 'حالة الطلب',
                'language_id' => 2,
                'label_id' => 969,
            ),
            287 => 
            array (
                'label_value_id' => 1621,
                'label_value' => 'معرف الطلبات',
                'language_id' => 2,
                'label_id' => 970,
            ),
            288 => 
            array (
                'label_value_id' => 1622,
                'label_value' => 'سعر المنتج',
                'language_id' => 2,
                'label_id' => 971,
            ),
            289 => 
            array (
                'label_value_id' => 1623,
                'label_value' => 'عدد المنتجات',
                'language_id' => 2,
                'label_id' => 972,
            ),
            290 => 
            array (
                'label_value_id' => 1624,
                'label_value' => 'تاريخ',
                'language_id' => 2,
                'label_id' => 973,
            ),
            291 => 
            array (
                'label_value_id' => 1625,
                'label_value' => 'عنوان العميل',
                'language_id' => 2,
                'label_id' => 974,
            ),
            292 => 
            array (
                'label_value_id' => 1626,
                'label_value' => 'يرجى إضافة عنوان الشحن الجديد لمزيد من المعالجة لطلبك',
                'language_id' => 2,
                'label_id' => 975,
            ),
            293 => 
            array (
                'label_value_id' => 1627,
                'label_value' => 'إضافة عنوان جديد',
                'language_id' => 2,
                'label_id' => 976,
            ),
            294 => 
            array (
                'label_value_id' => 1628,
                'label_value' => 'انشئ حساب',
                'language_id' => 2,
                'label_id' => 977,
            ),
            295 => 
            array (
                'label_value_id' => 1629,
                'label_value' => 'الاسم الاول',
                'language_id' => 2,
                'label_id' => 978,
            ),
            296 => 
            array (
                'label_value_id' => 1630,
                'label_value' => 'الكنية',
                'language_id' => 2,
                'label_id' => 979,
            ),
            297 => 
            array (
                'label_value_id' => 1631,
                'label_value' => 'هل أنت عضو بالفعل؟',
                'language_id' => 2,
                'label_id' => 980,
            ),
            298 => 
            array (
                'label_value_id' => 1632,
                'label_value' => 'معلومات الفواتير',
                'language_id' => 2,
                'label_id' => 981,
            ),
            299 => 
            array (
                'label_value_id' => 1633,
                'label_value' => 'عنوان',
                'language_id' => 2,
                'label_id' => 982,
            ),
            300 => 
            array (
                'label_value_id' => 1634,
                'label_value' => 'هاتف',
                'language_id' => 2,
                'label_id' => 983,
            ),
            301 => 
            array (
                'label_value_id' => 1635,
                'label_value' => 'نفس عنوان الشحن',
                'language_id' => 2,
                'label_id' => 984,
            ),
            302 => 
            array (
                'label_value_id' => 1636,
                'label_value' => 'التالى',
                'language_id' => 2,
                'label_id' => 985,
            ),
            303 => 
            array (
                'label_value_id' => 1637,
                'label_value' => 'طلب',
                'language_id' => 2,
                'label_id' => 986,
            ),
            304 => 
            array (
                'label_value_id' => 1638,
                'label_value' => 'عنوان وصول الفواتير',
                'language_id' => 2,
                'label_id' => 987,
            ),
            305 => 
            array (
                'label_value_id' => 1639,
                'label_value' => 'طريقة الشحن',
                'language_id' => 2,
                'label_id' => 988,
            ),
            306 => 
            array (
                'label_value_id' => 1640,
                'label_value' => 'منتجات',
                'language_id' => 2,
                'label_id' => 989,
            ),
            307 => 
            array (
                'label_value_id' => 1641,
                'label_value' => 'حاصل الجمع',
                'language_id' => 2,
                'label_id' => 990,
            ),
            308 => 
            array (
                'label_value_id' => 1642,
                'label_value' => 'سعر المنتجات',
                'language_id' => 2,
                'label_id' => 991,
            ),
            309 => 
            array (
                'label_value_id' => 1643,
                'label_value' => 'ضريبة',
                'language_id' => 2,
                'label_id' => 992,
            ),
            310 => 
            array (
                'label_value_id' => 1644,
                'label_value' => 'تكلفة الشحن',
                'language_id' => 2,
                'label_id' => 993,
            ),
            311 => 
            array (
                'label_value_id' => 1645,
                'label_value' => 'ترتيب ملاحظات',
                'language_id' => 2,
                'label_id' => 994,
            ),
            312 => 
            array (
                'label_value_id' => 1646,
                'label_value' => 'دفع',
                'language_id' => 2,
                'label_id' => 995,
            ),
            313 => 
            array (
                'label_value_id' => 1647,
                'label_value' => 'رقم البطاقة',
                'language_id' => 2,
                'label_id' => 996,
            ),
            314 => 
            array (
                'label_value_id' => 1648,
                'label_value' => 'تاريخ الإنتهاء',
                'language_id' => 2,
                'label_id' => 997,
            ),
            315 => 
            array (
                'label_value_id' => 1649,
                'label_value' => 'انتهاء الصلاحية',
                'language_id' => 2,
                'label_id' => 998,
            ),
            316 => 
            array (
                'label_value_id' => 1650,
                'label_value' => 'خطأ: رقم البطاقة غير صالح!',
                'language_id' => 2,
                'label_id' => 999,
            ),
            317 => 
            array (
                'label_value_id' => 1651,
                'label_value' => 'خطأ: تاريخ انتهاء الصلاحية غير صحيح!',
                'language_id' => 2,
                'label_id' => 1000,
            ),
            318 => 
            array (
                'label_value_id' => 1652,
                'label_value' => 'خطأ: رقم cvc غير صالح!',
                'language_id' => 2,
                'label_id' => 1001,
            ),
            319 => 
            array (
                'label_value_id' => 1653,
                'label_value' => 'استمر',
                'language_id' => 2,
                'label_id' => 1002,
            ),
            320 => 
            array (
                'label_value_id' => 1654,
                'label_value' => 'سلتي',
                'language_id' => 2,
                'label_id' => 1003,
            ),
            321 => 
            array (
                'label_value_id' => 1655,
                'label_value' => 'عربة التسوق فارغة',
                'language_id' => 2,
                'label_id' => 1004,
            ),
            322 => 
            array (
                'label_value_id' => 1656,
                'label_value' => 'مواصلة التسوق',
                'language_id' => 2,
                'label_id' => 1005,
            ),
            323 => 
            array (
                'label_value_id' => 1657,
                'label_value' => 'السعر',
                'language_id' => 2,
                'label_id' => 1006,
            ),
            324 => 
            array (
                'label_value_id' => 1658,
                'label_value' => 'كمية',
                'language_id' => 2,
                'label_id' => 1007,
            ),
            325 => 
            array (
                'label_value_id' => 1659,
                'label_value' => 'بواسطة',
                'language_id' => 2,
                'label_id' => 1008,
            ),
            326 => 
            array (
                'label_value_id' => 1660,
                'label_value' => 'رأي',
                'language_id' => 2,
                'label_id' => 1009,
            ),
            327 => 
            array (
                'label_value_id' => 1661,
                'label_value' => 'إزالة',
                'language_id' => 2,
                'label_id' => 1010,
            ),
            328 => 
            array (
                'label_value_id' => 1662,
                'label_value' => 'تقدم',
                'language_id' => 2,
                'label_id' => 1011,
            ),
            329 => 
            array (
                'label_value_id' => 1663,
                'label_value' => 'عنوان الشحن',
                'language_id' => 2,
                'label_id' => 1012,
            ),
            330 => 
            array (
                'label_value_id' => 1664,
                'label_value' => 'بلد',
                'language_id' => 2,
                'label_id' => 1013,
            ),
            331 => 
            array (
                'label_value_id' => 1665,
                'label_value' => 'آخر',
                'language_id' => 2,
                'label_id' => 1014,
            ),
            332 => 
            array (
                'label_value_id' => 1666,
                'label_value' => 'منطقة',
                'language_id' => 2,
                'label_id' => 1015,
            ),
            333 => 
            array (
                'label_value_id' => 1667,
                'label_value' => 'مدينة',
                'language_id' => 2,
                'label_id' => 1016,
            ),
            334 => 
            array (
                'label_value_id' => 1668,
                'label_value' => 'الرمز البريدي',
                'language_id' => 2,
                'label_id' => 1017,
            ),
            335 => 
            array (
                'label_value_id' => 1669,
                'label_value' => 'حالة',
                'language_id' => 2,
                'label_id' => 1018,
            ),
            336 => 
            array (
                'label_value_id' => 1670,
                'label_value' => 'تحديث العنوان',
                'language_id' => 2,
                'label_id' => 1019,
            ),
            337 => 
            array (
                'label_value_id' => 1671,
                'label_value' => 'حفظ العنوان',
                'language_id' => 2,
                'label_id' => 1020,
            ),
            338 => 
            array (
                'label_value_id' => 1672,
                'label_value' => 'دخولتسجيل',
                'language_id' => 2,
                'label_id' => 1021,
            ),
            339 => 
            array (
                'label_value_id' => 1673,
                'label_value' => 'يرجى تسجيل الدخول أو إنشاء حساب مجانا',
                'language_id' => 2,
                'label_id' => 1022,
            ),
            340 => 
            array (
                'label_value_id' => 1674,
                'label_value' => 'تسجيل خروج',
                'language_id' => 2,
                'label_id' => 1023,
            ),
            341 => 
            array (
                'label_value_id' => 1675,
                'label_value' => 'قائمة امنياتي',
                'language_id' => 2,
                'label_id' => 1024,
            ),
            342 => 
            array (
                'label_value_id' => 1676,
                'label_value' => 'مرشحات',
                'language_id' => 2,
                'label_id' => 1025,
            ),
            343 => 
            array (
                'label_value_id' => 1677,
                'label_value' => 'نطاق السعر',
                'language_id' => 2,
                'label_id' => 1026,
            ),
            344 => 
            array (
                'label_value_id' => 1678,
                'label_value' => 'قريب',
                'language_id' => 2,
                'label_id' => 1027,
            ),
            345 => 
            array (
                'label_value_id' => 1679,
                'label_value' => 'تطبيق',
                'language_id' => 2,
                'label_id' => 1028,
            ),
            346 => 
            array (
                'label_value_id' => 1680,
                'label_value' => 'واضح',
                'language_id' => 2,
                'label_id' => 1029,
            ),
            347 => 
            array (
                'label_value_id' => 1681,
                'label_value' => 'قائمة طعام',
                'language_id' => 2,
                'label_id' => 1030,
            ),
            348 => 
            array (
                'label_value_id' => 1682,
                'label_value' => 'الصفحة الرئيسية',
                'language_id' => 2,
                'label_id' => 1031,
            ),
            349 => 
            array (
                'label_value_id' => 1683,
                'label_value' => 'إن إنشاء حساب يعني أنك بخير من خلال موقعنا',
                'language_id' => 2,
                'label_id' => 1033,
            ),
            350 => 
            array (
                'label_value_id' => 1684,
                'label_value' => 'تسجيل الدخول',
                'language_id' => 2,
                'label_id' => 1034,
            ),
            351 => 
            array (
                'label_value_id' => 1685,
                'label_value' => 'تشغيل / إيقاف الإشعارات',
                'language_id' => 2,
                'label_id' => 1035,
            ),
            352 => 
            array (
                'label_value_id' => 1686,
                'label_value' => 'تشغيل / إيقاف الإشعارات',
                'language_id' => 2,
                'label_id' => 1036,
            ),
            353 => 
            array (
                'label_value_id' => 1687,
                'label_value' => 'تغيير اللغة',
                'language_id' => 2,
                'label_id' => 1037,
            ),
            354 => 
            array (
                'label_value_id' => 1688,
                'label_value' => 'الموقع الرسمي',
                'language_id' => 2,
                'label_id' => 1038,
            ),
            355 => 
            array (
                'label_value_id' => 1689,
                'label_value' => 'قيمنا',
                'language_id' => 2,
                'label_id' => 1039,
            ),
            356 => 
            array (
                'label_value_id' => 1690,
                'label_value' => 'شارك',
                'language_id' => 2,
                'label_id' => 1040,
            ),
            357 => 
            array (
                'label_value_id' => 1691,
                'label_value' => 'تعديل الملف الشخصي',
                'language_id' => 2,
                'label_id' => 1041,
            ),
            358 => 
            array (
                'label_value_id' => 1692,
                'label_value' => 'خصم النسبة المئوية للسلة بأكملها',
                'language_id' => 2,
                'label_id' => 1042,
            ),
            359 => 
            array (
                'label_value_id' => 1693,
                'label_value' => 'خصم إجمالي ثابت للعربة بأكملها',
                'language_id' => 2,
                'label_id' => 1043,
            ),
            360 => 
            array (
                'label_value_id' => 1694,
                'label_value' => 'خصم إجمالي ثابت للمنتجات المحددة فقط',
                'language_id' => 2,
                'label_id' => 1044,
            ),
            361 => 
            array (
                'label_value_id' => 1695,
                'label_value' => 'خصم النسبة المئوية للمنتجات المختارة فقط',
                'language_id' => 2,
                'label_id' => 1045,
            ),
            362 => 
            array (
                'label_value_id' => 1696,
                'label_value' => 'شبكة متصلة إعادة تحميل البيانات',
                'language_id' => 2,
                'label_id' => 1047,
            ),
            363 => 
            array (
                'label_value_id' => 1697,
                'label_value' => 'صنف حسب',
                'language_id' => 2,
                'label_id' => 1048,
            ),
            364 => 
            array (
                'label_value_id' => 1698,
                'label_value' => 'بيع مفاجئ',
                'language_id' => 2,
                'label_id' => 1049,
            ),
            365 => 
            array (
                'label_value_id' => 1699,
                'label_value' => 'حسنا',
                'language_id' => 2,
                'label_id' => 1050,
            ),
            366 => 
            array (
                'label_value_id' => 1700,
                'label_value' => 'رقم',
                'language_id' => 2,
                'label_id' => 1051,
            ),
            367 => 
            array (
                'label_value_id' => 1701,
                'label_value' => 'انتهاء الشهر',
                'language_id' => 2,
                'label_id' => 1052,
            ),
            368 => 
            array (
                'label_value_id' => 1702,
                'label_value' => 'انتهاء السنة',
                'language_id' => 2,
                'label_id' => 1053,
            ),
            369 => 
            array (
                'label_value_id' => 1703,
                'label_value' => 'طريقة الدفع او السداد',
                'language_id' => 2,
                'label_id' => 1054,
            ),
            370 => 
            array (
                'label_value_id' => 1704,
                'label_value' => 'الحالة',
                'language_id' => 2,
                'label_id' => 1055,
            ),
            371 => 
            array (
                'label_value_id' => 1705,
                'label_value' => 'و',
                'language_id' => 2,
                'label_id' => 1056,
            ),
            372 => 
            array (
                'label_value_id' => 1706,
                'label_value' => 'cccc',
                'language_id' => 1,
                'label_id' => 1057,
            ),
            373 => 
            array (
                'label_value_id' => 1707,
                'label_value' => 'cccc',
                'language_id' => 2,
                'label_id' => 1057,
            ),
            374 => 
            array (
                'label_value_id' => 1708,
                'label_value' => 'Shop More',
                'language_id' => 1,
                'label_id' => 1058,
            ),
            375 => 
            array (
                'label_value_id' => 1709,
                'label_value' => 'عربي',
                'language_id' => 2,
                'label_id' => 1058,
            ),
            376 => 
            array (
                'label_value_id' => 1710,
                'label_value' => 'Discount',
                'language_id' => 1,
                'label_id' => 1072,
            ),
            377 => 
            array (
                'label_value_id' => 1711,
                'label_value' => 'خصم',
                'language_id' => 2,
                'label_id' => 1072,
            ),
            378 => 
            array (
                'label_value_id' => 1712,
                'label_value' => 'Error in initialization, maybe PayPal isnt supported or something else',
                'language_id' => 1,
                'label_id' => 1073,
            ),
            379 => 
            array (
                'label_value_id' => 1713,
                'label_value' => 'خطأ في التهيئة ، ربما لا يتم دعم PayPal أو أي شيء آخر',
                'language_id' => 2,
                'label_id' => 1073,
            ),
            380 => 
            array (
                'label_value_id' => 1714,
                'label_value' => 'Alert',
                'language_id' => 1,
                'label_id' => 1074,
            ),
            381 => 
            array (
                'label_value_id' => 1715,
                'label_value' => 'إنذار',
                'language_id' => 2,
                'label_id' => 1074,
            ),
            382 => 
            array (
                'label_value_id' => 1716,
                'label_value' => 'Your Wishlist is Empty',
                'language_id' => 1,
                'label_id' => 1075,
            ),
            383 => 
            array (
                'label_value_id' => 1717,
                'label_value' => 'قائمة رغباتك فارغة',
                'language_id' => 2,
                'label_id' => 1075,
            ),
            384 => 
            array (
                'label_value_id' => 1718,
                'label_value' => 'Press heart icon on products to add them in wishlist',
                'language_id' => 1,
                'label_id' => 1076,
            ),
            385 => 
            array (
                'label_value_id' => 1719,
                'label_value' => 'اضغط على أيقونة القلب على المنتجات لإضافتها إلى قائمة الرغبات',
                'language_id' => 2,
                'label_id' => 1076,
            ),
            386 => 
            array (
                'label_value_id' => 1720,
                'label_value' => 'Wishlist',
                'language_id' => 1,
                'label_id' => 1077,
            ),
            387 => 
            array (
                'label_value_id' => 1721,
                'label_value' => 'قائمة الرغبات',
                'language_id' => 2,
                'label_id' => 1077,
            ),
            388 => 
            array (
                'label_value_id' => 1722,
                'label_value' => 'All Items',
                'language_id' => 1,
                'label_id' => 1078,
            ),
            389 => 
            array (
                'label_value_id' => 1723,
                'label_value' => 'كل الاشياء',
                'language_id' => 2,
                'label_id' => 1078,
            ),
            390 => 
            array (
                'label_value_id' => 1724,
                'label_value' => 'Account Info',
                'language_id' => 1,
                'label_id' => 1079,
            ),
            391 => 
            array (
                'label_value_id' => 1725,
                'label_value' => 'معلومات الحساب',
                'language_id' => 2,
                'label_id' => 1079,
            ),
            392 => 
            array (
                'label_value_id' => 1726,
                'label_value' => 'You Must Be Logged in to use this Feature!',
                'language_id' => 1,
                'label_id' => 1080,
            ),
            393 => 
            array (
                'label_value_id' => 1727,
                'label_value' => 'يجب عليك تسجيل الدخول لاستخدام هذه الميزة!',
                'language_id' => 2,
                'label_id' => 1080,
            ),
            394 => 
            array (
                'label_value_id' => 1728,
                'label_value' => 'Remove from Wishlist',
                'language_id' => 1,
                'label_id' => 1081,
            ),
            395 => 
            array (
                'label_value_id' => 1729,
                'label_value' => 'إزالة من قائمة الرغبات',
                'language_id' => 2,
                'label_id' => 1081,
            ),
            396 => 
            array (
                'label_value_id' => 1730,
                'label_value' => 'Sign Up',
                'language_id' => 1,
                'label_id' => 1082,
            ),
            397 => 
            array (
                'label_value_id' => 1731,
                'label_value' => 'سجل',
                'language_id' => 2,
                'label_id' => 1082,
            ),
            398 => 
            array (
                'label_value_id' => 1732,
                'label_value' => 'Reset Password',
                'language_id' => 1,
                'label_id' => 1083,
            ),
            399 => 
            array (
                'label_value_id' => 1733,
                'label_value' => 'إعادة تعيين كلمة المرور',
                'language_id' => 2,
                'label_id' => 1083,
            ),
            400 => 
            array (
                'label_value_id' => 1734,
                'label_value' => 'Invalid email or password',
                'language_id' => 1,
                'label_id' => 1084,
            ),
            401 => 
            array (
                'label_value_id' => 1735,
                'label_value' => 'البريد الإلكتروني أو كلمة السر خاطئة',
                'language_id' => 2,
                'label_id' => 1084,
            ),
            402 => 
            array (
                'label_value_id' => 1736,
                'label_value' => 'Recent Searches',
                'language_id' => 1,
                'label_id' => 1085,
            ),
            403 => 
            array (
                'label_value_id' => 1737,
                'label_value' => 'عمليات البحث الأخيرة',
                'language_id' => 2,
                'label_id' => 1085,
            ),
            404 => 
            array (
                'label_value_id' => 1738,
                'label_value' => 'Add to Wishlist',
                'language_id' => 1,
                'label_id' => 1086,
            ),
            405 => 
            array (
                'label_value_id' => 1739,
                'label_value' => 'أضف إلى قائمة الامنيات',
                'language_id' => 2,
                'label_id' => 1086,
            ),
            406 => 
            array (
                'label_value_id' => 1740,
                'label_value' => 'Discover Latest Trends',
                'language_id' => 1,
                'label_id' => 1087,
            ),
            407 => 
            array (
                'label_value_id' => 1741,
                'label_value' => 'اكتشف أحدث الاتجاهات',
                'language_id' => 2,
                'label_id' => 1087,
            ),
            408 => 
            array (
                'label_value_id' => 1742,
                'label_value' => 'Add To My Wishlist',
                'language_id' => 1,
                'label_id' => 1088,
            ),
            409 => 
            array (
                'label_value_id' => 1743,
                'label_value' => 'أضف إلى قائمة أمنياتي',
                'language_id' => 2,
                'label_id' => 1088,
            ),
            410 => 
            array (
                'label_value_id' => 1744,
                'label_value' => 'Start Shoping',
                'language_id' => 1,
                'label_id' => 1089,
            ),
            411 => 
            array (
                'label_value_id' => 1745,
                'label_value' => 'ابدأ التسوق',
                'language_id' => 2,
                'label_id' => 1089,
            ),
            412 => 
            array (
                'label_value_id' => 1746,
                'label_value' => 'A Smart Shopping Experience',
                'language_id' => 1,
                'label_id' => 1090,
            ),
            413 => 
            array (
                'label_value_id' => 1747,
                'label_value' => 'تجربة تسوق ذكية',
                'language_id' => 2,
                'label_id' => 1090,
            ),
            414 => 
            array (
                'label_value_id' => 1748,
                'label_value' => 'Addresses',
                'language_id' => 1,
                'label_id' => 1091,
            ),
            415 => 
            array (
                'label_value_id' => 1749,
                'label_value' => 'عناوين',
                'language_id' => 2,
                'label_id' => 1091,
            ),
            416 => 
            array (
                'label_value_id' => 1750,
                'label_value' => 'Account',
                'language_id' => 1,
                'label_id' => 1092,
            ),
            417 => 
            array (
                'label_value_id' => 1751,
                'label_value' => 'الحساب',
                'language_id' => 2,
                'label_id' => 1092,
            ),
            418 => 
            array (
                'label_value_id' => 1752,
                'label_value' => 'DETAILS',
                'language_id' => 1,
                'label_id' => 1093,
            ),
            419 => 
            array (
                'label_value_id' => 1753,
                'label_value' => 'تفاصيل',
                'language_id' => 2,
                'label_id' => 1093,
            ),
            420 => 
            array (
                'label_value_id' => 1754,
                'label_value' => 'Dark Mode',
                'language_id' => 1,
                'label_id' => 1094,
            ),
            421 => 
            array (
                'label_value_id' => 1755,
                'label_value' => 'الوضع الداكن',
                'language_id' => 2,
                'label_id' => 1094,
            ),
            422 => 
            array (
                'label_value_id' => 1756,
                'label_value' => 'Enter a description',
                'language_id' => 1,
                'label_id' => 1095,
            ),
            423 => 
            array (
                'label_value_id' => 1757,
                'label_value' => 'أدخل وصفًا',
                'language_id' => 2,
                'label_id' => 1095,
            ),
            424 => 
            array (
                'label_value_id' => 1758,
                'label_value' => 'Grocery Store',
                'language_id' => 1,
                'label_id' => 1096,
            ),
            425 => 
            array (
                'label_value_id' => 1759,
                'label_value' => 'بقالة',
                'language_id' => 2,
                'label_id' => 1096,
            ),
            426 => 
            array (
                'label_value_id' => 1760,
                'label_value' => 'Post Comment',
                'language_id' => 1,
                'label_id' => 1097,
            ),
            427 => 
            array (
                'label_value_id' => 1761,
                'label_value' => 'أضف تعليقا',
                'language_id' => 2,
                'label_id' => 1097,
            ),
            428 => 
            array (
                'label_value_id' => 1762,
                'label_value' => 'Rate and write a review',
                'language_id' => 1,
                'label_id' => 1098,
            ),
            429 => 
            array (
                'label_value_id' => 1763,
                'label_value' => 'تقييم وكتابة مراجعة',
                'language_id' => 2,
                'label_id' => 1098,
            ),
            430 => 
            array (
                'label_value_id' => 1764,
                'label_value' => 'Ratings & Reviews',
                'language_id' => 1,
                'label_id' => 1099,
            ),
            431 => 
            array (
                'label_value_id' => 1765,
                'label_value' => 'التقييمات والمراجعات',
                'language_id' => 2,
                'label_id' => 1099,
            ),
            432 => 
            array (
                'label_value_id' => 1766,
                'label_value' => 'Write a review',
                'language_id' => 1,
                'label_id' => 1100,
            ),
            433 => 
            array (
                'label_value_id' => 1767,
                'label_value' => 'أكتب مراجعة',
                'language_id' => 2,
                'label_id' => 1100,
            ),
            434 => 
            array (
                'label_value_id' => 1768,
                'label_value' => 'Your Rating',
                'language_id' => 1,
                'label_id' => 1101,
            ),
            435 => 
            array (
                'label_value_id' => 1769,
                'label_value' => 'تقييمك',
                'language_id' => 2,
                'label_id' => 1101,
            ),
            436 => 
            array (
                'label_value_id' => 1770,
                'label_value' => 'rating',
                'language_id' => 1,
                'label_id' => 1102,
            ),
            437 => 
            array (
                'label_value_id' => 1771,
                'label_value' => 'تقييم',
                'language_id' => 2,
                'label_id' => 1102,
            ),
            438 => 
            array (
                'label_value_id' => 1772,
                'label_value' => 'rating and review',
                'language_id' => 1,
                'label_id' => 1103,
            ),
            439 => 
            array (
                'label_value_id' => 1773,
                'label_value' => 'تصنيف ومراجعة',
                'language_id' => 2,
                'label_id' => 1103,
            ),
            440 => 
            array (
                'label_value_id' => 1774,
                'label_value' => 'Coupon Codes List',
                'language_id' => 1,
                'label_id' => 1104,
            ),
            441 => 
            array (
                'label_value_id' => 1775,
                'label_value' => 'قائمة رموز القسيمة',
                'language_id' => 2,
                'label_id' => 1104,
            ),
            442 => 
            array (
                'label_value_id' => 1776,
                'label_value' => 'Custom Orders',
                'language_id' => 1,
                'label_id' => 1105,
            ),
            443 => 
            array (
                'label_value_id' => 1777,
                'label_value' => 'أوامر مخصصة',
                'language_id' => 2,
                'label_id' => 1105,
            ),
            444 => 
            array (
                'label_value_id' => 1778,
                'label_value' => 'Ecommerce',
                'language_id' => 1,
                'label_id' => 1106,
            ),
            445 => 
            array (
                'label_value_id' => 1779,
                'label_value' => 'التجارة الإلكترونية',
                'language_id' => 2,
                'label_id' => 1106,
            ),
            446 => 
            array (
                'label_value_id' => 1780,
                'label_value' => 'Featured Products',
                'language_id' => 1,
                'label_id' => 1107,
            ),
            447 => 
            array (
                'label_value_id' => 1781,
                'label_value' => 'منتجات مميزة',
                'language_id' => 2,
                'label_id' => 1107,
            ),
            448 => 
            array (
                'label_value_id' => 1782,
                'label_value' => 'House Hold 1',
                'language_id' => 1,
                'label_id' => 1108,
            ),
            449 => 
            array (
                'label_value_id' => 1783,
                'label_value' => 'المنزل عقد 1',
                'language_id' => 2,
                'label_id' => 1108,
            ),
            450 => 
            array (
                'label_value_id' => 1784,
                'label_value' => 'Newest Products',
                'language_id' => 1,
                'label_id' => 1109,
            ),
            451 => 
            array (
                'label_value_id' => 1785,
                'label_value' => 'أحدث المنتجات',
                'language_id' => 2,
                'label_id' => 1109,
            ),
            452 => 
            array (
                'label_value_id' => 1786,
                'label_value' => 'On Sale Products',
                'language_id' => 1,
                'label_id' => 1110,
            ),
            453 => 
            array (
                'label_value_id' => 1787,
                'label_value' => 'المنتجات المعروضة للبيع',
                'language_id' => 2,
                'label_id' => 1110,
            ),
            454 => 
            array (
                'label_value_id' => 1788,
                'label_value' => 'Braintree',
                'language_id' => 1,
                'label_id' => 1111,
            ),
            455 => 
            array (
                'label_value_id' => 1789,
                'label_value' => 'برينتري',
                'language_id' => 2,
                'label_id' => 1111,
            ),
            456 => 
            array (
                'label_value_id' => 1790,
                'label_value' => 'Hyperpay',
                'language_id' => 1,
                'label_id' => 1112,
            ),
            457 => 
            array (
                'label_value_id' => 1791,
                'label_value' => 'Hyperpay',
                'language_id' => 2,
                'label_id' => 1112,
            ),
            458 => 
            array (
                'label_value_id' => 1792,
                'label_value' => 'Instamojo',
                'language_id' => 1,
                'label_id' => 1113,
            ),
            459 => 
            array (
                'label_value_id' => 1793,
                'label_value' => 'Instamojo',
                'language_id' => 2,
                'label_id' => 1113,
            ),
            460 => 
            array (
                'label_value_id' => 1794,
                'label_value' => 'PayTm',
                'language_id' => 1,
                'label_id' => 1114,
            ),
            461 => 
            array (
                'label_value_id' => 1795,
                'label_value' => 'PayTm',
                'language_id' => 2,
                'label_id' => 1114,
            ),
            462 => 
            array (
                'label_value_id' => 1796,
                'label_value' => 'Paypal',
                'language_id' => 1,
                'label_id' => 1115,
            ),
            463 => 
            array (
                'label_value_id' => 1797,
                'label_value' => 'باي بال',
                'language_id' => 2,
                'label_id' => 1115,
            ),
            464 => 
            array (
                'label_value_id' => 1798,
                'label_value' => 'Razor Pay',
                'language_id' => 1,
                'label_id' => 1116,
            ),
            465 => 
            array (
                'label_value_id' => 1799,
                'label_value' => 'الحلاقة الدفع',
                'language_id' => 2,
                'label_id' => 1116,
            ),
            466 => 
            array (
                'label_value_id' => 1800,
                'label_value' => 'Stripe',
                'language_id' => 1,
                'label_id' => 1117,
            ),
            467 => 
            array (
                'label_value_id' => 1801,
                'label_value' => 'شريط',
                'language_id' => 2,
                'label_id' => 1117,
            ),
            468 => 
            array (
                'label_value_id' => 1802,
                'label_value' => 'Me',
                'language_id' => 1,
                'label_id' => 1059,
            ),
            469 => 
            array (
                'label_value_id' => 1803,
                'label_value' => 'أنا',
                'language_id' => 2,
                'label_id' => 1059,
            ),
            470 => 
            array (
                'label_value_id' => 1804,
                'label_value' => 'View All',
                'language_id' => 1,
                'label_id' => 1060,
            ),
            471 => 
            array (
                'label_value_id' => 1805,
                'label_value' => 'عرض الكل',
                'language_id' => 2,
                'label_id' => 1060,
            ),
            472 => 
            array (
                'label_value_id' => 1806,
                'label_value' => 'Featured',
                'language_id' => 1,
                'label_id' => 1061,
            ),
            473 => 
            array (
                'label_value_id' => 1807,
                'label_value' => 'متميز',
                'language_id' => 2,
                'label_id' => 1061,
            ),
            474 => 
            array (
                'label_value_id' => 1808,
                'label_value' => 'Shop Now',
                'language_id' => 1,
                'label_id' => 1062,
            ),
            475 => 
            array (
                'label_value_id' => 1809,
                'label_value' => 'تسوق الآن',
                'language_id' => 2,
                'label_id' => 1062,
            ),
            476 => 
            array (
                'label_value_id' => 1810,
                'label_value' => 'New Arrivals',
                'language_id' => 1,
                'label_id' => 1063,
            ),
            477 => 
            array (
                'label_value_id' => 1811,
                'label_value' => 'الوافدون الجدد',
                'language_id' => 2,
                'label_id' => 1063,
            ),
            478 => 
            array (
                'label_value_id' => 1812,
                'label_value' => 'Sort',
                'language_id' => 1,
                'label_id' => 1064,
            ),
            479 => 
            array (
                'label_value_id' => 1813,
                'label_value' => 'فرز',
                'language_id' => 2,
                'label_id' => 1064,
            ),
            480 => 
            array (
                'label_value_id' => 1814,
                'label_value' => 'Help & Support',
                'language_id' => 1,
                'label_id' => 1065,
            ),
            481 => 
            array (
                'label_value_id' => 1815,
                'label_value' => 'ساعد لدعم',
                'language_id' => 2,
                'label_id' => 1065,
            ),
            482 => 
            array (
                'label_value_id' => 1816,
                'label_value' => 'Select Currency',
                'language_id' => 1,
                'label_id' => 1066,
            ),
            483 => 
            array (
                'label_value_id' => 1817,
                'label_value' => 'اختر العملة',
                'language_id' => 2,
                'label_id' => 1066,
            ),
            484 => 
            array (
                'label_value_id' => 1818,
                'label_value' => 'Your Price',
                'language_id' => 1,
                'label_id' => 1067,
            ),
            485 => 
            array (
                'label_value_id' => 1819,
                'label_value' => 'السعر الخاص',
                'language_id' => 2,
                'label_id' => 1067,
            ),
            486 => 
            array (
                'label_value_id' => 1820,
                'label_value' => 'Billing',
                'language_id' => 1,
                'label_id' => 1068,
            ),
            487 => 
            array (
                'label_value_id' => 1821,
                'label_value' => 'الفواتير',
                'language_id' => 2,
                'label_id' => 1068,
            ),
            488 => 
            array (
                'label_value_id' => 1822,
                'label_value' => 'Ship to a different address?',
                'language_id' => 1,
                'label_id' => 1069,
            ),
            489 => 
            array (
                'label_value_id' => 1823,
                'label_value' => 'هل تريد الشحن إلى عنوان مختلف؟',
                'language_id' => 2,
                'label_id' => 1069,
            ),
            490 => 
            array (
                'label_value_id' => 1824,
                'label_value' => 'Method',
                'language_id' => 1,
                'label_id' => 1070,
            ),
            491 => 
            array (
                'label_value_id' => 1825,
                'label_value' => 'طريقة',
                'language_id' => 2,
                'label_id' => 1070,
            ),
            492 => 
            array (
                'label_value_id' => 1826,
                'label_value' => 'Summary',
                'language_id' => 1,
                'label_id' => 1071,
            ),
            493 => 
            array (
                'label_value_id' => 1827,
                'label_value' => 'ملخص',
                'language_id' => 2,
                'label_id' => 1071,
            ),
        ));
        
        
    }
}