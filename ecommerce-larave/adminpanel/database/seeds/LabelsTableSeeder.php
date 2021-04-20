<?php

use Illuminate\Database\Seeder;

class LabelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('labels')->delete();
        
        \DB::table('labels')->insert(array (
            0 => 
            array (
                'label_id' => 1,
                'label_name' => 'I\'ve forgotten my password?',
            ),
            1 => 
            array (
                'label_id' => 2,
                'label_name' => 'Creating an account means you’re okay with shopify\'s Terms of Service, Privacy Policy',
            ),
            2 => 
            array (
                'label_id' => 872,
                'label_name' => 'Login with',
            ),
            3 => 
            array (
                'label_id' => 873,
                'label_name' => 'or',
            ),
            4 => 
            array (
                'label_id' => 874,
                'label_name' => 'Email',
            ),
            5 => 
            array (
                'label_id' => 875,
                'label_name' => 'Password',
            ),
            6 => 
            array (
                'label_id' => 876,
                'label_name' => 'Register',
            ),
            7 => 
            array (
                'label_id' => 877,
                'label_name' => 'Forgot Password',
            ),
            8 => 
            array (
                'label_id' => 878,
                'label_name' => 'Send',
            ),
            9 => 
            array (
                'label_id' => 879,
                'label_name' => 'About Us',
            ),
            10 => 
            array (
                'label_id' => 880,
                'label_name' => 'Categories',
            ),
            11 => 
            array (
                'label_id' => 881,
                'label_name' => 'Contact Us',
            ),
            12 => 
            array (
                'label_id' => 882,
                'label_name' => 'Name',
            ),
            13 => 
            array (
                'label_id' => 883,
                'label_name' => 'Your Messsage',
            ),
            14 => 
            array (
                'label_id' => 884,
                'label_name' => 'Please connect to the internet',
            ),
            15 => 
            array (
                'label_id' => 885,
                'label_name' => 'Recently Viewed',
            ),
            16 => 
            array (
                'label_id' => 886,
                'label_name' => 'Products are available.',
            ),
            17 => 
            array (
                'label_id' => 887,
                'label_name' => 'Top Seller',
            ),
            18 => 
            array (
                'label_id' => 888,
                'label_name' => 'Special Deals',
            ),
            19 => 
            array (
                'label_id' => 889,
                'label_name' => 'Most Liked',
            ),
            20 => 
            array (
                'label_id' => 890,
                'label_name' => 'All Categories',
            ),
            21 => 
            array (
                'label_id' => 891,
                'label_name' => 'Deals',
            ),
            22 => 
            array (
                'label_id' => 892,
                'label_name' => 'REMOVE',
            ),
            23 => 
            array (
                'label_id' => 893,
                'label_name' => 'Intro',
            ),
            24 => 
            array (
                'label_id' => 894,
                'label_name' => 'Skip Intro',
            ),
            25 => 
            array (
                'label_id' => 895,
                'label_name' => 'Got It!',
            ),
            26 => 
            array (
                'label_id' => 896,
                'label_name' => 'Order Detail',
            ),
            27 => 
            array (
                'label_id' => 897,
                'label_name' => 'Price Detail',
            ),
            28 => 
            array (
                'label_id' => 898,
                'label_name' => 'Total',
            ),
            29 => 
            array (
                'label_id' => 899,
                'label_name' => 'Sub Total',
            ),
            30 => 
            array (
                'label_id' => 900,
                'label_name' => 'Shipping',
            ),
            31 => 
            array (
                'label_id' => 901,
                'label_name' => 'Product Details',
            ),
            32 => 
            array (
                'label_id' => 902,
                'label_name' => 'New',
            ),
            33 => 
            array (
                'label_id' => 903,
                'label_name' => 'Out of Stock',
            ),
            34 => 
            array (
                'label_id' => 904,
                'label_name' => 'In Stock',
            ),
            35 => 
            array (
                'label_id' => 905,
                'label_name' => 'Add to Cart',
            ),
            36 => 
            array (
                'label_id' => 906,
                'label_name' => 'ADD TO CART',
            ),
            37 => 
            array (
                'label_id' => 907,
                'label_name' => 'Product Description',
            ),
            38 => 
            array (
                'label_id' => 908,
                'label_name' => 'Techincal details',
            ),
            39 => 
            array (
                'label_id' => 909,
                'label_name' => 'OFF',
            ),
            40 => 
            array (
                'label_id' => 910,
                'label_name' => 'No Products Found',
            ),
            41 => 
            array (
                'label_id' => 911,
                'label_name' => 'Reset Filters',
            ),
            42 => 
            array (
                'label_id' => 912,
                'label_name' => 'Search',
            ),
            43 => 
            array (
                'label_id' => 913,
                'label_name' => 'Main Categories',
            ),
            44 => 
            array (
                'label_id' => 914,
                'label_name' => 'Sub Categories',
            ),
            45 => 
            array (
                'label_id' => 915,
                'label_name' => 'Shipping method',
            ),
            46 => 
            array (
                'label_id' => 916,
                'label_name' => 'Thank You',
            ),
            47 => 
            array (
                'label_id' => 917,
                'label_name' => 'Thank you for shopping with us.',
            ),
            48 => 
            array (
                'label_id' => 918,
                'label_name' => 'My Orders',
            ),
            49 => 
            array (
                'label_id' => 919,
                'label_name' => 'Continue Shopping',
            ),
            50 => 
            array (
                'label_id' => 920,
                'label_name' => 'Favourite',
            ),
            51 => 
            array (
                'label_id' => 921,
                'label_name' => 'Your wish List is empty',
            ),
            52 => 
            array (
                'label_id' => 922,
                'label_name' => 'Continue Adding',
            ),
            53 => 
            array (
                'label_id' => 923,
                'label_name' => 'Explore',
            ),
            54 => 
            array (
                'label_id' => 924,
                'label_name' => 'Word Press Post Detail',
            ),
            55 => 
            array (
                'label_id' => 925,
                'label_name' => 'Go Back',
            ),
            56 => 
            array (
                'label_id' => 926,
                'label_name' => 'Top Sellers',
            ),
            57 => 
            array (
                'label_id' => 927,
                'label_name' => 'News',
            ),
            58 => 
            array (
                'label_id' => 928,
                'label_name' => 'Enter keyword',
            ),
            59 => 
            array (
                'label_id' => 929,
                'label_name' => 'Settings',
            ),
            60 => 
            array (
                'label_id' => 930,
                'label_name' => 'Shop',
            ),
            61 => 
            array (
                'label_id' => 931,
                'label_name' => 'Reset',
            ),
            62 => 
            array (
                'label_id' => 932,
                'label_name' => 'Select Language',
            ),
            63 => 
            array (
                'label_id' => 933,
                'label_name' => 'OUT OF STOCK',
            ),
            64 => 
            array (
                'label_id' => 934,
                'label_name' => 'Newest',
            ),
            65 => 
            array (
                'label_id' => 935,
                'label_name' => 'Refund Policy',
            ),
            66 => 
            array (
                'label_id' => 936,
                'label_name' => 'Privacy Policy',
            ),
            67 => 
            array (
                'label_id' => 937,
                'label_name' => 'Term and Services',
            ),
            68 => 
            array (
                'label_id' => 938,
                'label_name' => 'Skip',
            ),
            69 => 
            array (
                'label_id' => 939,
                'label_name' => 'Top Dishes',
            ),
            70 => 
            array (
                'label_id' => 940,
                'label_name' => 'Recipe of Day',
            ),
            71 => 
            array (
                'label_id' => 941,
                'label_name' => 'Food Categories',
            ),
            72 => 
            array (
                'label_id' => 942,
                'label_name' => 'Coupon Code',
            ),
            73 => 
            array (
                'label_id' => 943,
                'label_name' => 'Coupon Amount',
            ),
            74 => 
            array (
                'label_id' => 944,
                'label_name' => 'coupon code',
            ),
            75 => 
            array (
                'label_id' => 945,
                'label_name' => 'Coupon',
            ),
            76 => 
            array (
                'label_id' => 946,
                'label_name' => 'Note to the buyer',
            ),
            77 => 
            array (
                'label_id' => 947,
                'label_name' => 'Explore More',
            ),
            78 => 
            array (
                'label_id' => 948,
                'label_name' => 'All',
            ),
            79 => 
            array (
                'label_id' => 949,
                'label_name' => 'A - Z',
            ),
            80 => 
            array (
                'label_id' => 950,
                'label_name' => 'Z - A',
            ),
            81 => 
            array (
                'label_id' => 951,
                'label_name' => 'Price : high - low',
            ),
            82 => 
            array (
                'label_id' => 952,
                'label_name' => 'Price : low - high',
            ),
            83 => 
            array (
                'label_id' => 953,
                'label_name' => 'Special Products',
            ),
            84 => 
            array (
                'label_id' => 954,
                'label_name' => 'Sort Products',
            ),
            85 => 
            array (
                'label_id' => 955,
                'label_name' => 'Cancel',
            ),
            86 => 
            array (
                'label_id' => 956,
                'label_name' => 'most liked',
            ),
            87 => 
            array (
                'label_id' => 957,
                'label_name' => 'special',
            ),
            88 => 
            array (
                'label_id' => 958,
                'label_name' => 'top seller',
            ),
            89 => 
            array (
                'label_id' => 959,
                'label_name' => 'newest',
            ),
            90 => 
            array (
                'label_id' => 960,
                'label_name' => 'Likes',
            ),
            91 => 
            array (
                'label_id' => 961,
                'label_name' => 'My Account',
            ),
            92 => 
            array (
                'label_id' => 962,
                'label_name' => 'Mobile',
            ),
            93 => 
            array (
                'label_id' => 963,
                'label_name' => 'Date of Birth',
            ),
            94 => 
            array (
                'label_id' => 964,
                'label_name' => 'Update',
            ),
            95 => 
            array (
                'label_id' => 965,
                'label_name' => 'Current Password',
            ),
            96 => 
            array (
                'label_id' => 966,
                'label_name' => 'New Password',
            ),
            97 => 
            array (
                'label_id' => 967,
                'label_name' => 'Change Password',
            ),
            98 => 
            array (
                'label_id' => 968,
                'label_name' => 'Customer Orders',
            ),
            99 => 
            array (
                'label_id' => 969,
                'label_name' => 'Order Status',
            ),
            100 => 
            array (
                'label_id' => 970,
                'label_name' => 'Orders ID',
            ),
            101 => 
            array (
                'label_id' => 971,
                'label_name' => 'Product Price',
            ),
            102 => 
            array (
                'label_id' => 972,
                'label_name' => 'No. of Products',
            ),
            103 => 
            array (
                'label_id' => 973,
                'label_name' => 'Date',
            ),
            104 => 
            array (
                'label_id' => 974,
                'label_name' => 'Customer Address',
            ),
            105 => 
            array (
                'label_id' => 975,
                'label_name' => 'Please add your new shipping address for the futher processing of the your order',
            ),
            106 => 
            array (
                'label_id' => 976,
                'label_name' => 'Add new Address',
            ),
            107 => 
            array (
                'label_id' => 977,
                'label_name' => 'Create an Account',
            ),
            108 => 
            array (
                'label_id' => 978,
                'label_name' => 'First Name',
            ),
            109 => 
            array (
                'label_id' => 979,
                'label_name' => 'Last Name',
            ),
            110 => 
            array (
                'label_id' => 980,
                'label_name' => 'Already Memeber?',
            ),
            111 => 
            array (
                'label_id' => 981,
                'label_name' => 'Billing Info',
            ),
            112 => 
            array (
                'label_id' => 982,
                'label_name' => 'Address',
            ),
            113 => 
            array (
                'label_id' => 983,
                'label_name' => 'Phone',
            ),
            114 => 
            array (
                'label_id' => 984,
                'label_name' => 'Same as Shipping Address',
            ),
            115 => 
            array (
                'label_id' => 985,
                'label_name' => 'Next',
            ),
            116 => 
            array (
                'label_id' => 986,
                'label_name' => 'Order',
            ),
            117 => 
            array (
                'label_id' => 987,
                'label_name' => 'Billing Address',
            ),
            118 => 
            array (
                'label_id' => 988,
                'label_name' => 'Shipping Method',
            ),
            119 => 
            array (
                'label_id' => 989,
                'label_name' => 'Products',
            ),
            120 => 
            array (
                'label_id' => 990,
                'label_name' => 'SubTotal',
            ),
            121 => 
            array (
                'label_id' => 991,
                'label_name' => 'Products Price',
            ),
            122 => 
            array (
                'label_id' => 992,
                'label_name' => 'Tax',
            ),
            123 => 
            array (
                'label_id' => 993,
                'label_name' => 'Shipping Cost',
            ),
            124 => 
            array (
                'label_id' => 994,
                'label_name' => 'Order Notes',
            ),
            125 => 
            array (
                'label_id' => 995,
                'label_name' => 'Payment',
            ),
            126 => 
            array (
                'label_id' => 996,
                'label_name' => 'Card Number',
            ),
            127 => 
            array (
                'label_id' => 997,
                'label_name' => 'Expiration Date',
            ),
            128 => 
            array (
                'label_id' => 998,
                'label_name' => 'Expiration',
            ),
            129 => 
            array (
                'label_id' => 999,
                'label_name' => 'Error: invalid card number!',
            ),
            130 => 
            array (
                'label_id' => 1000,
                'label_name' => 'Error: invalid expiry date!',
            ),
            131 => 
            array (
                'label_id' => 1001,
                'label_name' => 'Error: invalid cvc number!',
            ),
            132 => 
            array (
                'label_id' => 1002,
                'label_name' => 'Continue',
            ),
            133 => 
            array (
                'label_id' => 1003,
                'label_name' => 'My Cart',
            ),
            134 => 
            array (
                'label_id' => 1004,
                'label_name' => 'Your cart is empty',
            ),
            135 => 
            array (
                'label_id' => 1005,
                'label_name' => 'continue shopping',
            ),
            136 => 
            array (
                'label_id' => 1006,
                'label_name' => 'Price',
            ),
            137 => 
            array (
                'label_id' => 1007,
                'label_name' => 'Quantity',
            ),
            138 => 
            array (
                'label_id' => 1008,
                'label_name' => 'by',
            ),
            139 => 
            array (
                'label_id' => 1009,
                'label_name' => 'View',
            ),
            140 => 
            array (
                'label_id' => 1010,
                'label_name' => 'Remove',
            ),
            141 => 
            array (
                'label_id' => 1011,
                'label_name' => 'Proceed',
            ),
            142 => 
            array (
                'label_id' => 1012,
                'label_name' => 'Shipping Address',
            ),
            143 => 
            array (
                'label_id' => 1013,
                'label_name' => 'Country',
            ),
            144 => 
            array (
                'label_id' => 1014,
                'label_name' => 'other',
            ),
            145 => 
            array (
                'label_id' => 1015,
                'label_name' => 'Zone',
            ),
            146 => 
            array (
                'label_id' => 1016,
                'label_name' => 'City',
            ),
            147 => 
            array (
                'label_id' => 1017,
                'label_name' => 'Post code',
            ),
            148 => 
            array (
                'label_id' => 1018,
                'label_name' => 'State',
            ),
            149 => 
            array (
                'label_id' => 1019,
                'label_name' => 'Update Address',
            ),
            150 => 
            array (
                'label_id' => 1020,
                'label_name' => 'Save Address',
            ),
            151 => 
            array (
                'label_id' => 1021,
                'label_name' => 'Login & Register',
            ),
            152 => 
            array (
                'label_id' => 1022,
                'label_name' => 'Please login or create an account for free',
            ),
            153 => 
            array (
                'label_id' => 1023,
                'label_name' => 'Log Out',
            ),
            154 => 
            array (
                'label_id' => 1024,
                'label_name' => 'My Wish List',
            ),
            155 => 
            array (
                'label_id' => 1025,
                'label_name' => 'Filters',
            ),
            156 => 
            array (
                'label_id' => 1026,
                'label_name' => 'Price Range',
            ),
            157 => 
            array (
                'label_id' => 1027,
                'label_name' => 'Close',
            ),
            158 => 
            array (
                'label_id' => 1028,
                'label_name' => 'Apply',
            ),
            159 => 
            array (
                'label_id' => 1029,
                'label_name' => 'Clear',
            ),
            160 => 
            array (
                'label_id' => 1030,
                'label_name' => 'Menu',
            ),
            161 => 
            array (
                'label_id' => 1031,
                'label_name' => 'Home',
            ),
            162 => 
            array (
                'label_id' => 1033,
                'label_name' => 'Creating an account means you’re okay with our',
            ),
            163 => 
            array (
                'label_id' => 1034,
                'label_name' => 'Login',
            ),
            164 => 
            array (
                'label_id' => 1035,
                'label_name' => 'Turn on/off Local Notifications',
            ),
            165 => 
            array (
                'label_id' => 1036,
                'label_name' => 'Turn on/off Notifications',
            ),
            166 => 
            array (
                'label_id' => 1037,
                'label_name' => 'Change Language',
            ),
            167 => 
            array (
                'label_id' => 1038,
                'label_name' => 'Official Website',
            ),
            168 => 
            array (
                'label_id' => 1039,
                'label_name' => 'Rate Us',
            ),
            169 => 
            array (
                'label_id' => 1040,
                'label_name' => 'Share',
            ),
            170 => 
            array (
                'label_id' => 1041,
                'label_name' => 'Edit Profile',
            ),
            171 => 
            array (
                'label_id' => 1042,
                'label_name' => 'A percentage discount for the entire cart',
            ),
            172 => 
            array (
                'label_id' => 1043,
                'label_name' => 'A fixed total discount for the entire cart',
            ),
            173 => 
            array (
                'label_id' => 1044,
                'label_name' => 'A fixed total discount for selected products only',
            ),
            174 => 
            array (
                'label_id' => 1045,
                'label_name' => 'A percentage discount for selected products only',
            ),
            175 => 
            array (
                'label_id' => 1047,
                'label_name' => 'Network Connected Reloading Data',
            ),
            176 => 
            array (
                'label_id' => 1048,
                'label_name' => 'Sort by',
            ),
            177 => 
            array (
                'label_id' => 1049,
                'label_name' => 'Flash Sale',
            ),
            178 => 
            array (
                'label_id' => 1050,
                'label_name' => 'ok',
            ),
            179 => 
            array (
                'label_id' => 1051,
                'label_name' => 'Number',
            ),
            180 => 
            array (
                'label_id' => 1052,
                'label_name' => 'Expire Month',
            ),
            181 => 
            array (
                'label_id' => 1053,
                'label_name' => 'Expire Year',
            ),
            182 => 
            array (
                'label_id' => 1054,
                'label_name' => 'Payment Method',
            ),
            183 => 
            array (
                'label_id' => 1055,
                'label_name' => 'Status',
            ),
            184 => 
            array (
                'label_id' => 1056,
                'label_name' => 'And',
            ),
            185 => 
            array (
                'label_id' => 1057,
                'label_name' => 'cccc',
            ),
            186 => 
            array (
                'label_id' => 1058,
                'label_name' => 'Shop More',
            ),
            187 => 
            array (
                'label_id' => 1059,
                'label_name' => 'Me',
            ),
            188 => 
            array (
                'label_id' => 1060,
                'label_name' => 'View All',
            ),
            189 => 
            array (
                'label_id' => 1061,
                'label_name' => 'Featured',
            ),
            190 => 
            array (
                'label_id' => 1062,
                'label_name' => 'Shop Now',
            ),
            191 => 
            array (
                'label_id' => 1063,
                'label_name' => 'New Arrivals',
            ),
            192 => 
            array (
                'label_id' => 1064,
                'label_name' => 'Sort',
            ),
            193 => 
            array (
                'label_id' => 1065,
                'label_name' => 'Help & Support',
            ),
            194 => 
            array (
                'label_id' => 1066,
                'label_name' => 'Select Currency',
            ),
            195 => 
            array (
                'label_id' => 1067,
                'label_name' => 'Your Price',
            ),
            196 => 
            array (
                'label_id' => 1068,
                'label_name' => 'Billing',
            ),
            197 => 
            array (
                'label_id' => 1069,
                'label_name' => 'Ship to a different address?',
            ),
            198 => 
            array (
                'label_id' => 1070,
                'label_name' => 'Method',
            ),
            199 => 
            array (
                'label_id' => 1071,
                'label_name' => 'Summary',
            ),
            200 => 
            array (
                'label_id' => 1072,
                'label_name' => 'Discount',
            ),
            201 => 
            array (
                'label_id' => 1073,
                'label_name' => 'Error in initialization, maybe PayPal isnt supported or something else',
            ),
            202 => 
            array (
                'label_id' => 1074,
                'label_name' => 'Alert',
            ),
            203 => 
            array (
                'label_id' => 1075,
                'label_name' => 'Your Wishlist is Empty',
            ),
            204 => 
            array (
                'label_id' => 1076,
                'label_name' => 'Press heart icon on products to add them in wishlist',
            ),
            205 => 
            array (
                'label_id' => 1077,
                'label_name' => 'Wishlist',
            ),
            206 => 
            array (
                'label_id' => 1078,
                'label_name' => 'All Items',
            ),
            207 => 
            array (
                'label_id' => 1079,
                'label_name' => 'Account Info',
            ),
            208 => 
            array (
                'label_id' => 1080,
                'label_name' => 'You Must Be Logged in to use this Feature!',
            ),
            209 => 
            array (
                'label_id' => 1081,
                'label_name' => 'Remove from Wishlist',
            ),
            210 => 
            array (
                'label_id' => 1082,
                'label_name' => 'Sign Up',
            ),
            211 => 
            array (
                'label_id' => 1083,
                'label_name' => 'Reset Password',
            ),
            212 => 
            array (
                'label_id' => 1084,
                'label_name' => 'Invalid email or password',
            ),
            213 => 
            array (
                'label_id' => 1085,
                'label_name' => 'Recent Searches',
            ),
            214 => 
            array (
                'label_id' => 1086,
                'label_name' => 'Add to Wishlist',
            ),
            215 => 
            array (
                'label_id' => 1087,
                'label_name' => 'Discover Latest Trends',
            ),
            216 => 
            array (
                'label_id' => 1088,
                'label_name' => 'Add To My Wishlist',
            ),
            217 => 
            array (
                'label_id' => 1089,
                'label_name' => 'Start Shoping',
            ),
            218 => 
            array (
                'label_id' => 1090,
                'label_name' => 'A Smart Shopping Experience',
            ),
            219 => 
            array (
                'label_id' => 1091,
                'label_name' => 'Addresses',
            ),
            220 => 
            array (
                'label_id' => 1092,
                'label_name' => 'Account',
            ),
            221 => 
            array (
                'label_id' => 1093,
                'label_name' => 'DETAILS',
            ),
            222 => 
            array (
                'label_id' => 1094,
                'label_name' => 'Dark Mode',
            ),
            223 => 
            array (
                'label_id' => 1095,
                'label_name' => 'Enter a description',
            ),
            224 => 
            array (
                'label_id' => 1096,
                'label_name' => 'Grocery Store',
            ),
            225 => 
            array (
                'label_id' => 1097,
                'label_name' => 'Post Comment',
            ),
            226 => 
            array (
                'label_id' => 1098,
                'label_name' => 'Rate and write a review',
            ),
            227 => 
            array (
                'label_id' => 1099,
                'label_name' => 'Ratings & Reviews',
            ),
            228 => 
            array (
                'label_id' => 1100,
                'label_name' => 'Write a review',
            ),
            229 => 
            array (
                'label_id' => 1101,
                'label_name' => 'Your Rating',
            ),
            230 => 
            array (
                'label_id' => 1102,
                'label_name' => 'rating',
            ),
            231 => 
            array (
                'label_id' => 1103,
                'label_name' => 'rating and review',
            ),
            232 => 
            array (
                'label_id' => 1104,
                'label_name' => 'Coupon Codes List',
            ),
            233 => 
            array (
                'label_id' => 1105,
                'label_name' => 'Custom Orders',
            ),
            234 => 
            array (
                'label_id' => 1106,
                'label_name' => 'Ecommerce',
            ),
            235 => 
            array (
                'label_id' => 1107,
                'label_name' => 'Featured Products',
            ),
            236 => 
            array (
                'label_id' => 1108,
                'label_name' => 'House Hold 1',
            ),
            237 => 
            array (
                'label_id' => 1109,
                'label_name' => 'Newest Products',
            ),
            238 => 
            array (
                'label_id' => 1110,
                'label_name' => 'On Sale Products',
            ),
            239 => 
            array (
                'label_id' => 1111,
                'label_name' => 'Braintree',
            ),
            240 => 
            array (
                'label_id' => 1112,
                'label_name' => 'Hyperpay',
            ),
            241 => 
            array (
                'label_id' => 1113,
                'label_name' => 'Instamojo',
            ),
            242 => 
            array (
                'label_id' => 1114,
                'label_name' => 'PayTm',
            ),
            243 => 
            array (
                'label_id' => 1115,
                'label_name' => 'Paypal',
            ),
            244 => 
            array (
                'label_id' => 1116,
                'label_name' => 'Razor Pay',
            ),
            245 => 
            array (
                'label_id' => 1117,
                'label_name' => 'Stripe',
            ),
        ));
        
        
    }
}