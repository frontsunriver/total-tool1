<?php

use Illuminate\Database\Seeder;

class ImageCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('image_categories')->delete();
        
        \DB::table('image_categories')->insert(array (
            0 => 
            array (
                'id' => 84,
                'image_id' => 83,
                'image_type' => 'ACTUAL',
                'height' => 277,
                'width' => 370,
                'path' => 'images/media/2020/11/JqYfZ11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 85,
                'image_id' => 83,
                'image_type' => 'THUMBNAIL',
                'height' => 112,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570778231JqYfZ11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 86,
                'image_id' => 84,
                'image_type' => 'ACTUAL',
                'height' => 301,
                'width' => 770,
                'path' => 'images/media/2020/11/6Q4Qy11507.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 87,
                'image_id' => 85,
                'image_type' => 'ACTUAL',
                'height' => 550,
                'width' => 368,
                'path' => 'images/media/2020/11/jOVnc11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 88,
                'image_id' => 85,
                'image_type' => 'THUMBNAIL',
                'height' => 150,
                'width' => 100,
                'path' => 'images/media/2020/11/thumbnail1570778446jOVnc11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 89,
                'image_id' => 85,
                'image_type' => 'MEDIUM',
                'height' => 400,
                'width' => 268,
                'path' => 'images/media/2020/11/medium1570778446jOVnc11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 90,
                'image_id' => 86,
                'image_type' => 'ACTUAL',
                'height' => 220,
                'width' => 370,
                'path' => 'images/media/2020/11/Ake4A11107.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 91,
                'image_id' => 86,
                'image_type' => 'THUMBNAIL',
                'height' => 89,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570778447Ake4A11107.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 96,
                'image_id' => 89,
                'image_type' => 'ACTUAL',
                'height' => 229,
                'width' => 270,
                'path' => 'images/media/2020/11/nDQtA11407.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 97,
                'image_id' => 89,
                'image_type' => 'THUMBNAIL',
                'height' => 127,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570778680nDQtA11407.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 98,
                'image_id' => 90,
                'image_type' => 'ACTUAL',
                'height' => 298,
                'width' => 568,
                'path' => 'images/media/2020/11/ueyod11407.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 99,
                'image_id' => 90,
                'image_type' => 'THUMBNAIL',
                'height' => 79,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570778749ueyod11407.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 100,
                'image_id' => 90,
                'image_type' => 'MEDIUM',
                'height' => 210,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570778749ueyod11407.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 101,
                'image_id' => 91,
                'image_type' => 'ACTUAL',
                'height' => 490,
                'width' => 570,
                'path' => 'images/media/2020/11/xD6MF11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 102,
                'image_id' => 91,
                'image_type' => 'THUMBNAIL',
                'height' => 129,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570778967xD6MF11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 103,
                'image_id' => 91,
                'image_type' => 'MEDIUM',
                'height' => 344,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570778967xD6MF11207.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 104,
                'image_id' => 92,
                'image_type' => 'ACTUAL',
                'height' => 229,
                'width' => 270,
                'path' => 'images/media/2020/11/YZyoU11507.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 105,
                'image_id' => 92,
                'image_type' => 'THUMBNAIL',
                'height' => 127,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570778968YZyoU11507.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 106,
                'image_id' => 93,
                'image_type' => 'ACTUAL',
                'height' => 301,
                'width' => 770,
                'path' => 'images/media/2020/11/RLshK11309.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 107,
                'image_id' => 93,
                'image_type' => 'THUMBNAIL',
                'height' => 59,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570787475RLshK11309.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 108,
                'image_id' => 93,
                'image_type' => 'MEDIUM',
                'height' => 156,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570787476RLshK11309.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 109,
                'image_id' => 94,
                'image_type' => 'ACTUAL',
                'height' => 211,
                'width' => 570,
                'path' => 'images/media/2020/11/pTZdI11309.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 110,
                'image_id' => 94,
                'image_type' => 'THUMBNAIL',
                'height' => 56,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570787731pTZdI11309.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 111,
                'image_id' => 94,
                'image_type' => 'MEDIUM',
                'height' => 148,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570787731pTZdI11309.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 112,
                'image_id' => 95,
                'image_type' => 'ACTUAL',
                'height' => 451,
                'width' => 570,
                'path' => 'images/media/2020/11/2t7BU11909.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 113,
                'image_id' => 95,
                'image_type' => 'THUMBNAIL',
                'height' => 119,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail15707877532t7BU11909.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 114,
                'image_id' => 95,
                'image_type' => 'MEDIUM',
                'height' => 316,
                'width' => 400,
                'path' => 'images/media/2020/11/medium15707877542t7BU11909.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 115,
                'image_id' => 96,
                'image_type' => 'ACTUAL',
                'height' => 211,
                'width' => 270,
                'path' => 'images/media/2020/11/O0cLp11909.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 116,
                'image_id' => 96,
                'image_type' => 'THUMBNAIL',
                'height' => 117,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570787792O0cLp11909.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 117,
                'image_id' => 97,
                'image_type' => 'ACTUAL',
                'height' => 298,
                'width' => 568,
                'path' => 'images/media/2020/11/ncXhn11709.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 118,
                'image_id' => 97,
                'image_type' => 'THUMBNAIL',
                'height' => 79,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570787936ncXhn11709.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 119,
                'image_id' => 97,
                'image_type' => 'MEDIUM',
                'height' => 210,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570787936ncXhn11709.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 120,
                'image_id' => 98,
                'image_type' => 'ACTUAL',
                'height' => 452,
                'width' => 569,
                'path' => 'images/media/2020/11/3876V11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 121,
                'image_id' => 98,
                'image_type' => 'THUMBNAIL',
                'height' => 119,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail15707880203876V11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 122,
                'image_id' => 98,
                'image_type' => 'MEDIUM',
                'height' => 318,
                'width' => 400,
                'path' => 'images/media/2020/11/medium15707880213876V11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 123,
                'image_id' => 99,
                'image_type' => 'ACTUAL',
                'height' => 451,
                'width' => 271,
                'path' => 'images/media/2020/11/80IGj11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 124,
                'image_id' => 99,
                'image_type' => 'THUMBNAIL',
                'height' => 150,
                'width' => 90,
                'path' => 'images/media/2020/11/thumbnail157078802180IGj11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 125,
                'image_id' => 99,
                'image_type' => 'MEDIUM',
                'height' => 400,
                'width' => 240,
                'path' => 'images/media/2020/11/medium157078802180IGj11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 126,
                'image_id' => 100,
                'image_type' => 'ACTUAL',
                'height' => 493,
                'width' => 370,
                'path' => 'images/media/2020/11/ueeqM11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 127,
                'image_id' => 100,
                'image_type' => 'THUMBNAIL',
                'height' => 150,
                'width' => 113,
                'path' => 'images/media/2020/11/thumbnail1570788170ueeqM11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 128,
                'image_id' => 100,
                'image_type' => 'MEDIUM',
                'height' => 400,
                'width' => 300,
                'path' => 'images/media/2020/11/medium1570788171ueeqM11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 129,
                'image_id' => 101,
                'image_type' => 'ACTUAL',
                'height' => 230,
                'width' => 370,
                'path' => 'images/media/2020/11/UrgVW11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 130,
                'image_id' => 101,
                'image_type' => 'THUMBNAIL',
                'height' => 93,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570788171UrgVW11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 131,
                'image_id' => 102,
                'image_type' => 'ACTUAL',
                'height' => 230,
                'width' => 370,
                'path' => 'images/media/2020/11/a18kN11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 132,
                'image_id' => 102,
                'image_type' => 'THUMBNAIL',
                'height' => 93,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570788301a18kN11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 133,
                'image_id' => 103,
                'image_type' => 'ACTUAL',
                'height' => 493,
                'width' => 370,
                'path' => 'images/media/2020/11/qQM0R11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 134,
                'image_id' => 103,
                'image_type' => 'THUMBNAIL',
                'height' => 150,
                'width' => 113,
                'path' => 'images/media/2020/11/thumbnail1570788302qQM0R11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 135,
                'image_id' => 103,
                'image_type' => 'MEDIUM',
                'height' => 400,
                'width' => 300,
                'path' => 'images/media/2020/11/medium1570788302qQM0R11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 136,
                'image_id' => 104,
                'image_type' => 'ACTUAL',
                'height' => 259,
                'width' => 770,
                'path' => 'images/media/2020/11/VrhhT11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 137,
                'image_id' => 104,
                'image_type' => 'THUMBNAIL',
                'height' => 50,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570788382VrhhT11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 138,
                'image_id' => 104,
                'image_type' => 'MEDIUM',
                'height' => 135,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570788382VrhhT11510.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 139,
                'image_id' => 105,
                'image_type' => 'ACTUAL',
                'height' => 546,
                'width' => 372,
                'path' => 'images/media/2020/11/gSkR011310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 140,
                'image_id' => 105,
                'image_type' => 'THUMBNAIL',
                'height' => 150,
                'width' => 102,
                'path' => 'images/media/2020/11/thumbnail1570788383gSkR011310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 141,
                'image_id' => 105,
                'image_type' => 'MEDIUM',
                'height' => 400,
                'width' => 273,
                'path' => 'images/media/2020/11/medium1570788383gSkR011310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 142,
                'image_id' => 106,
                'image_type' => 'ACTUAL',
                'height' => 430,
                'width' => 1599,
                'path' => 'images/media/2020/11/DXoxt11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 143,
                'image_id' => 106,
                'image_type' => 'THUMBNAIL',
                'height' => 40,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570789393DXoxt11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 144,
                'image_id' => 106,
                'image_type' => 'MEDIUM',
                'height' => 108,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570789394DXoxt11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 145,
                'image_id' => 106,
                'image_type' => 'LARGE',
                'height' => 242,
                'width' => 900,
                'path' => 'images/media/2020/11/large1570789394DXoxt11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 146,
                'image_id' => 107,
                'image_type' => 'ACTUAL',
                'height' => 236,
                'width' => 1169,
                'path' => 'images/media/2020/11/N4WSZ11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 147,
                'image_id' => 107,
                'image_type' => 'THUMBNAIL',
                'height' => 30,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570789395N4WSZ11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 148,
                'image_id' => 107,
                'image_type' => 'MEDIUM',
                'height' => 81,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570789395N4WSZ11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 149,
                'image_id' => 107,
                'image_type' => 'LARGE',
                'height' => 182,
                'width' => 900,
                'path' => 'images/media/2020/11/large1570789395N4WSZ11310.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 150,
                'image_id' => 108,
                'image_type' => 'ACTUAL',
                'height' => 421,
                'width' => 1170,
                'path' => 'images/media/2020/11/z9MLR11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 151,
                'image_id' => 108,
                'image_type' => 'THUMBNAIL',
                'height' => 54,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570789643z9MLR11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 152,
                'image_id' => 108,
                'image_type' => 'MEDIUM',
                'height' => 144,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570789643z9MLR11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 153,
                'image_id' => 108,
                'image_type' => 'LARGE',
                'height' => 324,
                'width' => 900,
                'path' => 'images/media/2020/11/large1570789644z9MLR11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 154,
                'image_id' => 109,
                'image_type' => 'ACTUAL',
                'height' => 418,
                'width' => 885,
                'path' => 'images/media/2020/11/YNVyV11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 155,
                'image_id' => 109,
                'image_type' => 'THUMBNAIL',
                'height' => 71,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570789935YNVyV11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 156,
                'image_id' => 109,
                'image_type' => 'MEDIUM',
                'height' => 189,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570789935YNVyV11410.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 157,
                'image_id' => 110,
                'image_type' => 'ACTUAL',
                'height' => 387,
                'width' => 770,
                'path' => 'images/media/2020/11/YinE411810.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 158,
                'image_id' => 110,
                'image_type' => 'THUMBNAIL',
                'height' => 75,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570790072YinE411810.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 159,
                'image_id' => 110,
                'image_type' => 'MEDIUM',
                'height' => 201,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570790072YinE411810.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 160,
                'image_id' => 111,
                'image_type' => 'ACTUAL',
                'height' => 421,
                'width' => 1600,
                'path' => 'images/media/2020/11/97VNC11210.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 161,
                'image_id' => 111,
                'image_type' => 'THUMBNAIL',
                'height' => 39,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail157079031897VNC11210.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 162,
                'image_id' => 111,
                'image_type' => 'MEDIUM',
                'height' => 105,
                'width' => 400,
                'path' => 'images/media/2020/11/medium157079031997VNC11210.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 163,
                'image_id' => 111,
                'image_type' => 'LARGE',
                'height' => 237,
                'width' => 900,
                'path' => 'images/media/2020/11/large157079031997VNC11210.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 168,
                'image_id' => 114,
                'image_type' => 'ACTUAL',
                'height' => 179,
                'width' => 370,
                'path' => 'images/media/2020/11/zZZ2n11710.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 169,
                'image_id' => 114,
                'image_type' => 'THUMBNAIL',
                'height' => 73,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570790472zZZ2n11710.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 170,
                'image_id' => 115,
                'image_type' => 'ACTUAL',
                'height' => 211,
                'width' => 370,
                'path' => 'images/media/2020/11/vMNsa11710.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 171,
                'image_id' => 115,
                'image_type' => 'THUMBNAIL',
                'height' => 86,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570790553vMNsa11710.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 172,
                'image_id' => 116,
                'image_type' => 'ACTUAL',
                'height' => 208,
                'width' => 465,
                'path' => 'images/media/2020/11/qujIz11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 173,
                'image_id' => 116,
                'image_type' => 'THUMBNAIL',
                'height' => 67,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1570790554qujIz11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 174,
                'image_id' => 116,
                'image_type' => 'MEDIUM',
                'height' => 179,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1570790554qujIz11610.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 176,
                'image_id' => 118,
                'image_type' => 'ACTUAL',
                'height' => 20,
                'width' => 30,
                'path' => 'images/media/2020/11/PJG0C11511.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 177,
                'image_id' => 119,
                'image_type' => 'ACTUAL',
                'height' => 20,
                'width' => 30,
                'path' => 'images/media/2020/11/SKOMJ11512.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 178,
                'image_id' => 120,
                'image_type' => 'ACTUAL',
                'height' => 20,
                'width' => 30,
                'path' => 'images/media/2020/11/newsletter.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 179,
                'image_id' => 121,
                'image_type' => 'ACTUAL',
                'height' => 38,
                'width' => 150,
                'path' => 'images/media/2020/11/OimK016812.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 180,
                'image_id' => 121,
                'image_type' => 'THUMBNAIL',
                'height' => 38,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1605528670OimK016812.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 181,
                'image_id' => 122,
                'image_type' => 'ACTUAL',
                'height' => 16,
                'width' => 16,
                'path' => 'images/media/2020/11/90diN16912.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 190,
                'image_id' => 125,
                'image_type' => 'ACTUAL',
                'height' => 1133,
                'width' => 1700,
                'path' => 'images/media/2020/11/C4mLx18506.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 191,
                'image_id' => 125,
                'image_type' => 'THUMBNAIL',
                'height' => 100,
                'width' => 150,
                'path' => 'images/media/2020/11/thumbnail1605722628C4mLx18506.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 192,
                'image_id' => 125,
                'image_type' => 'MEDIUM',
                'height' => 267,
                'width' => 400,
                'path' => 'images/media/2020/11/medium1605722628C4mLx18506.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 193,
                'image_id' => 125,
                'image_type' => 'LARGE',
                'height' => 600,
                'width' => 900,
                'path' => 'images/media/2020/11/large1605722629C4mLx18506.jpg',
                'created_at' => NULL,
                'updated_at' => '2020-11-24 12:00:41',
            ),
        ));
        
        
    }
}