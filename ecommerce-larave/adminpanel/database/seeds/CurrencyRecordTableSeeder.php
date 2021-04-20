<?php

use Illuminate\Database\Seeder;

class CurrencyRecordTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currency_record')->delete();
        
        \DB::table('currency_record')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'AED',
                'currency_name' => 'United Arab Emirates Dirham',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'AFN',
                'currency_name' => 'Afghan Afghani',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'ALL',
                'currency_name' => 'Albanian Lek',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'AMD',
                'currency_name' => 'Armenian Dram',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'ANG',
                'currency_name' => 'Netherlands Antillean Guilder',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'AOA',
                'currency_name' => 'Angolan Kwanza',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'ARS',
                'currency_name' => 'Argentine Peso',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'AUD',
                'currency_name' => 'Australian Dollar',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'AWG',
                'currency_name' => 'Aruban Florin',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'AZN',
                'currency_name' => 'Azerbaijani Manat',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'BAM',
                'currency_name' => 'Bosnia-Herzegovina Convertible Mark',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'BBD',
                'currency_name' => 'Barbadian Dollar',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'BDT',
                'currency_name' => 'Bangladeshi Taka',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'BGN',
                'currency_name' => 'Bulgarian Lev',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'BHD',
                'currency_name' => 'Bahraini Dinar',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'BIF',
                'currency_name' => 'Burundian Franc',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'BMD',
                'currency_name' => 'Bermudan Dollar',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'BND',
                'currency_name' => 'Brunei Dollar',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'BOB',
                'currency_name' => 'Bolivian Boliviano',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'BRL',
                'currency_name' => 'Brazilian Real',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'BSD',
                'currency_name' => 'Bahamian Dollar',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'BTC',
                'currency_name' => 'Bitcoin',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'BTN',
                'currency_name' => 'Bhutanese Ngultrum',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'BWP',
                'currency_name' => 'Botswanan Pula',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'BYN',
                'currency_name' => 'Belarusian Ruble',
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'BZD',
                'currency_name' => 'Belize Dollar',
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'CAD',
                'currency_name' => 'Canadian Dollar',
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'CDF',
                'currency_name' => 'Congolese Franc',
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'CHF',
                'currency_name' => 'Swiss Franc',
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'CLF',
            'currency_name' => 'Chilean Unit of Account (UF)',
            ),
            30 => 
            array (
                'id' => 31,
                'code' => 'CLP',
                'currency_name' => 'Chilean Peso',
            ),
            31 => 
            array (
                'id' => 32,
                'code' => 'CNH',
            'currency_name' => 'Chinese Yuan (Offshore)',
            ),
            32 => 
            array (
                'id' => 33,
                'code' => 'CNY',
                'currency_name' => 'Chinese Yuan',
            ),
            33 => 
            array (
                'id' => 34,
                'code' => 'COP',
                'currency_name' => 'Colombian Peso',
            ),
            34 => 
            array (
                'id' => 35,
                'code' => 'CRC',
                'currency_name' => 'Costa Rican Colón',
            ),
            35 => 
            array (
                'id' => 36,
                'code' => 'CUC',
                'currency_name' => 'Cuban Convertible Peso',
            ),
            36 => 
            array (
                'id' => 37,
                'code' => 'CUP',
                'currency_name' => 'Cuban Peso',
            ),
            37 => 
            array (
                'id' => 38,
                'code' => 'CVE',
                'currency_name' => 'Cape Verdean Escudo',
            ),
            38 => 
            array (
                'id' => 39,
                'code' => 'CZK',
                'currency_name' => 'Czech Republic Koruna',
            ),
            39 => 
            array (
                'id' => 40,
                'code' => 'DJF',
                'currency_name' => 'Djiboutian Franc',
            ),
            40 => 
            array (
                'id' => 41,
                'code' => 'DKK',
                'currency_name' => 'Danish Krone',
            ),
            41 => 
            array (
                'id' => 42,
                'code' => 'DOP',
                'currency_name' => 'Dominican Peso',
            ),
            42 => 
            array (
                'id' => 43,
                'code' => 'DZD',
                'currency_name' => 'Algerian Dinar',
            ),
            43 => 
            array (
                'id' => 44,
                'code' => 'EGP',
                'currency_name' => 'Egyptian Pound',
            ),
            44 => 
            array (
                'id' => 45,
                'code' => 'ERN',
                'currency_name' => 'Eritrean Nakfa',
            ),
            45 => 
            array (
                'id' => 46,
                'code' => 'ETB',
                'currency_name' => 'Ethiopian Birr',
            ),
            46 => 
            array (
                'id' => 47,
                'code' => 'EUR',
                'currency_name' => 'Euro',
            ),
            47 => 
            array (
                'id' => 48,
                'code' => 'FJD',
                'currency_name' => 'Fijian Dollar',
            ),
            48 => 
            array (
                'id' => 49,
                'code' => 'FKP',
                'currency_name' => 'Falkland Islands Pound',
            ),
            49 => 
            array (
                'id' => 50,
                'code' => 'GBP',
                'currency_name' => 'British Pound Sterling',
            ),
            50 => 
            array (
                'id' => 51,
                'code' => 'GEL',
                'currency_name' => 'Georgian Lari',
            ),
            51 => 
            array (
                'id' => 52,
                'code' => 'GGP',
                'currency_name' => 'Guernsey Pound',
            ),
            52 => 
            array (
                'id' => 53,
                'code' => 'GHS',
                'currency_name' => 'Ghanaian Cedi',
            ),
            53 => 
            array (
                'id' => 54,
                'code' => 'GIP',
                'currency_name' => 'Gibraltar Pound',
            ),
            54 => 
            array (
                'id' => 55,
                'code' => 'GMD',
                'currency_name' => 'Gambian Dalasi',
            ),
            55 => 
            array (
                'id' => 56,
                'code' => 'GNF',
                'currency_name' => 'Guinean Franc',
            ),
            56 => 
            array (
                'id' => 57,
                'code' => 'GTQ',
                'currency_name' => 'Guatemalan Quetzal',
            ),
            57 => 
            array (
                'id' => 58,
                'code' => 'GYD',
                'currency_name' => 'Guyanaese Dollar',
            ),
            58 => 
            array (
                'id' => 59,
                'code' => 'HKD',
                'currency_name' => 'Hong Kong Dollar',
            ),
            59 => 
            array (
                'id' => 60,
                'code' => 'HNL',
                'currency_name' => 'Honduran Lempira',
            ),
            60 => 
            array (
                'id' => 61,
                'code' => 'HRK',
                'currency_name' => 'Croatian Kuna',
            ),
            61 => 
            array (
                'id' => 62,
                'code' => 'HTG',
                'currency_name' => 'Haitian Gourde',
            ),
            62 => 
            array (
                'id' => 63,
                'code' => 'HUF',
                'currency_name' => 'Hungarian Forint',
            ),
            63 => 
            array (
                'id' => 64,
                'code' => 'IDR',
                'currency_name' => 'Indonesian Rupiah',
            ),
            64 => 
            array (
                'id' => 65,
                'code' => 'ILS',
                'currency_name' => 'Israeli New Sheqel',
            ),
            65 => 
            array (
                'id' => 66,
                'code' => 'IMP',
                'currency_name' => 'Manx pound',
            ),
            66 => 
            array (
                'id' => 67,
                'code' => 'INR',
                'currency_name' => 'Indian Rupee',
            ),
            67 => 
            array (
                'id' => 68,
                'code' => 'IQD',
                'currency_name' => 'Iraqi Dinar',
            ),
            68 => 
            array (
                'id' => 69,
                'code' => 'IRR',
                'currency_name' => 'Iranian Rial',
            ),
            69 => 
            array (
                'id' => 70,
                'code' => 'ISK',
                'currency_name' => 'Icelandic Króna',
            ),
            70 => 
            array (
                'id' => 71,
                'code' => 'JEP',
                'currency_name' => 'Jersey Pound',
            ),
            71 => 
            array (
                'id' => 72,
                'code' => 'JMD',
                'currency_name' => 'Jamaican Dollar',
            ),
            72 => 
            array (
                'id' => 73,
                'code' => 'JOD',
                'currency_name' => 'Jordanian Dinar',
            ),
            73 => 
            array (
                'id' => 74,
                'code' => 'JPY',
                'currency_name' => 'Japanese Yen',
            ),
            74 => 
            array (
                'id' => 75,
                'code' => 'KES',
                'currency_name' => 'Kenyan Shilling',
            ),
            75 => 
            array (
                'id' => 76,
                'code' => 'KGS',
                'currency_name' => 'Kyrgystani Som',
            ),
            76 => 
            array (
                'id' => 77,
                'code' => 'KHR',
                'currency_name' => 'Cambodian Riel',
            ),
            77 => 
            array (
                'id' => 78,
                'code' => 'KMF',
                'currency_name' => 'Comorian Franc',
            ),
            78 => 
            array (
                'id' => 79,
                'code' => 'KPW',
                'currency_name' => 'North Korean Won',
            ),
            79 => 
            array (
                'id' => 80,
                'code' => 'KRW',
                'currency_name' => 'South Korean Won',
            ),
            80 => 
            array (
                'id' => 81,
                'code' => 'KWD',
                'currency_name' => 'Kuwaiti Dinar',
            ),
            81 => 
            array (
                'id' => 82,
                'code' => 'KYD',
                'currency_name' => 'Cayman Islands Dollar',
            ),
            82 => 
            array (
                'id' => 83,
                'code' => 'KZT',
                'currency_name' => 'Kazakhstani Tenge',
            ),
            83 => 
            array (
                'id' => 84,
                'code' => 'LAK',
                'currency_name' => 'Laotian Kip',
            ),
            84 => 
            array (
                'id' => 85,
                'code' => 'LBP',
                'currency_name' => 'Lebanese Pound',
            ),
            85 => 
            array (
                'id' => 86,
                'code' => 'LKR',
                'currency_name' => 'Sri Lankan Rupee',
            ),
            86 => 
            array (
                'id' => 87,
                'code' => 'LRD',
                'currency_name' => 'Liberian Dollar',
            ),
            87 => 
            array (
                'id' => 88,
                'code' => 'LSL',
                'currency_name' => 'Lesotho Loti',
            ),
            88 => 
            array (
                'id' => 89,
                'code' => 'LYD',
                'currency_name' => 'Libyan Dinar',
            ),
            89 => 
            array (
                'id' => 90,
                'code' => 'MAD',
                'currency_name' => 'Moroccan Dirham',
            ),
            90 => 
            array (
                'id' => 91,
                'code' => 'MDL',
                'currency_name' => 'Moldovan Leu',
            ),
            91 => 
            array (
                'id' => 92,
                'code' => 'MGA',
                'currency_name' => 'Malagasy Ariary',
            ),
            92 => 
            array (
                'id' => 93,
                'code' => 'MKD',
                'currency_name' => 'Macedonian Denar',
            ),
            93 => 
            array (
                'id' => 94,
                'code' => 'MMK',
                'currency_name' => 'Myanma Kyat',
            ),
            94 => 
            array (
                'id' => 95,
                'code' => 'MNT',
                'currency_name' => 'Mongolian Tugrik',
            ),
            95 => 
            array (
                'id' => 96,
                'code' => 'MOP',
                'currency_name' => 'Macanese Pataca',
            ),
            96 => 
            array (
                'id' => 97,
                'code' => 'MRO',
            'currency_name' => 'Mauritanian Ouguiya (pre-2018)',
            ),
            97 => 
            array (
                'id' => 98,
                'code' => 'MRU',
                'currency_name' => 'Mauritanian Ouguiya',
            ),
            98 => 
            array (
                'id' => 99,
                'code' => 'MUR',
                'currency_name' => 'Mauritian Rupee',
            ),
            99 => 
            array (
                'id' => 100,
                'code' => 'MVR',
                'currency_name' => 'Maldivian Rufiyaa',
            ),
            100 => 
            array (
                'id' => 101,
                'code' => 'MWK',
                'currency_name' => 'Malawian Kwacha',
            ),
            101 => 
            array (
                'id' => 102,
                'code' => 'MXN',
                'currency_name' => 'Mexican Peso',
            ),
            102 => 
            array (
                'id' => 103,
                'code' => 'MYR',
                'currency_name' => 'Malaysian Ringgit',
            ),
            103 => 
            array (
                'id' => 104,
                'code' => 'MZN',
                'currency_name' => 'Mozambican Metical',
            ),
            104 => 
            array (
                'id' => 105,
                'code' => 'NAD',
                'currency_name' => 'Namibian Dollar',
            ),
            105 => 
            array (
                'id' => 106,
                'code' => 'NGN',
                'currency_name' => 'Nigerian Naira',
            ),
            106 => 
            array (
                'id' => 107,
                'code' => 'NIO',
                'currency_name' => 'Nicaraguan Córdoba',
            ),
            107 => 
            array (
                'id' => 108,
                'code' => 'NOK',
                'currency_name' => 'Norwegian Krone',
            ),
            108 => 
            array (
                'id' => 109,
                'code' => 'NPR',
                'currency_name' => 'Nepalese Rupee',
            ),
            109 => 
            array (
                'id' => 110,
                'code' => 'NZD',
                'currency_name' => 'New Zealand Dollar',
            ),
            110 => 
            array (
                'id' => 111,
                'code' => 'OMR',
                'currency_name' => 'Omani Rial',
            ),
            111 => 
            array (
                'id' => 112,
                'code' => 'PAB',
                'currency_name' => 'Panamanian Balboa',
            ),
            112 => 
            array (
                'id' => 113,
                'code' => 'PEN',
                'currency_name' => 'Peruvian Nuevo Sol',
            ),
            113 => 
            array (
                'id' => 114,
                'code' => 'PGK',
                'currency_name' => 'Papua New Guinean Kina',
            ),
            114 => 
            array (
                'id' => 115,
                'code' => 'PHP',
                'currency_name' => 'Philippine Peso',
            ),
            115 => 
            array (
                'id' => 116,
                'code' => 'PKR',
                'currency_name' => 'Pakistani Rupee',
            ),
            116 => 
            array (
                'id' => 117,
                'code' => 'PLN',
                'currency_name' => 'Polish Zloty',
            ),
            117 => 
            array (
                'id' => 118,
                'code' => 'PYG',
                'currency_name' => 'Paraguayan Guarani',
            ),
            118 => 
            array (
                'id' => 119,
                'code' => 'QAR',
                'currency_name' => 'Qatari Rial',
            ),
            119 => 
            array (
                'id' => 120,
                'code' => 'RON',
                'currency_name' => 'Romanian Leu',
            ),
            120 => 
            array (
                'id' => 121,
                'code' => 'RSD',
                'currency_name' => 'Serbian Dinar',
            ),
            121 => 
            array (
                'id' => 122,
                'code' => 'RUB',
                'currency_name' => 'Russian Ruble',
            ),
            122 => 
            array (
                'id' => 123,
                'code' => 'RWF',
                'currency_name' => 'Rwandan Franc',
            ),
            123 => 
            array (
                'id' => 124,
                'code' => 'SAR',
                'currency_name' => 'Saudi Riyal',
            ),
            124 => 
            array (
                'id' => 125,
                'code' => 'SBD',
                'currency_name' => 'Solomon Islands Dollar',
            ),
            125 => 
            array (
                'id' => 126,
                'code' => 'SCR',
                'currency_name' => 'Seychellois Rupee',
            ),
            126 => 
            array (
                'id' => 127,
                'code' => 'SDG',
                'currency_name' => 'Sudanese Pound',
            ),
            127 => 
            array (
                'id' => 128,
                'code' => 'SEK',
                'currency_name' => 'Swedish Krona',
            ),
            128 => 
            array (
                'id' => 129,
                'code' => 'SGD',
                'currency_name' => 'Singapore Dollar',
            ),
            129 => 
            array (
                'id' => 130,
                'code' => 'SHP',
                'currency_name' => 'Saint Helena Pound',
            ),
            130 => 
            array (
                'id' => 131,
                'code' => 'SLL',
                'currency_name' => 'Sierra Leonean Leone',
            ),
            131 => 
            array (
                'id' => 132,
                'code' => 'SOS',
                'currency_name' => 'Somali Shilling',
            ),
            132 => 
            array (
                'id' => 133,
                'code' => 'SRD',
                'currency_name' => 'Surinamese Dollar',
            ),
            133 => 
            array (
                'id' => 134,
                'code' => 'SSP',
                'currency_name' => 'South Sudanese Pound',
            ),
            134 => 
            array (
                'id' => 135,
                'code' => 'STD',
            'currency_name' => 'São Tomé and Príncipe Dobra (pre-2018)',
            ),
            135 => 
            array (
                'id' => 136,
                'code' => 'STN',
                'currency_name' => 'São Tomé and Príncipe Dobra',
            ),
            136 => 
            array (
                'id' => 137,
                'code' => 'SVC',
                'currency_name' => 'Salvadoran Colón',
            ),
            137 => 
            array (
                'id' => 138,
                'code' => 'SYP',
                'currency_name' => 'Syrian Pound',
            ),
            138 => 
            array (
                'id' => 139,
                'code' => 'SZL',
                'currency_name' => 'Swazi Lilangeni',
            ),
            139 => 
            array (
                'id' => 140,
                'code' => 'THB',
                'currency_name' => 'Thai Baht',
            ),
            140 => 
            array (
                'id' => 141,
                'code' => 'TJS',
                'currency_name' => 'Tajikistani Somoni',
            ),
            141 => 
            array (
                'id' => 142,
                'code' => 'TMT',
                'currency_name' => 'Turkmenistani Manat',
            ),
            142 => 
            array (
                'id' => 143,
                'code' => 'TND',
                'currency_name' => 'Tunisian Dinar',
            ),
            143 => 
            array (
                'id' => 144,
                'code' => 'TOP',
                'currency_name' => 'Tongan Pa\'anga',
            ),
            144 => 
            array (
                'id' => 145,
                'code' => 'TRY',
                'currency_name' => 'Turkish Lira',
            ),
            145 => 
            array (
                'id' => 146,
                'code' => 'TTD',
                'currency_name' => 'Trinidad and Tobago Dollar',
            ),
            146 => 
            array (
                'id' => 147,
                'code' => 'TWD',
                'currency_name' => 'New Taiwan Dollar',
            ),
            147 => 
            array (
                'id' => 148,
                'code' => 'TZS',
                'currency_name' => 'Tanzanian Shilling',
            ),
            148 => 
            array (
                'id' => 149,
                'code' => 'UAH',
                'currency_name' => 'Ukrainian Hryvnia',
            ),
            149 => 
            array (
                'id' => 150,
                'code' => 'UGX',
                'currency_name' => 'Ugandan Shilling',
            ),
            150 => 
            array (
                'id' => 151,
                'code' => 'USD',
                'currency_name' => 'United States Dollar',
            ),
            151 => 
            array (
                'id' => 152,
                'code' => 'UYU',
                'currency_name' => 'Uruguayan Peso',
            ),
            152 => 
            array (
                'id' => 153,
                'code' => 'UZS',
                'currency_name' => 'Uzbekistan Som',
            ),
            153 => 
            array (
                'id' => 154,
                'code' => 'VEF',
                'currency_name' => 'Venezuelan Bolívar Fuerte',
            ),
            154 => 
            array (
                'id' => 155,
                'code' => 'VND',
                'currency_name' => 'Vietnamese Dong',
            ),
            155 => 
            array (
                'id' => 156,
                'code' => 'VUV',
                'currency_name' => 'Vanuatu Vatu',
            ),
            156 => 
            array (
                'id' => 157,
                'code' => 'WST',
                'currency_name' => 'Samoan Tala',
            ),
            157 => 
            array (
                'id' => 158,
                'code' => 'XAF',
                'currency_name' => 'CFA Franc BEAC',
            ),
            158 => 
            array (
                'id' => 159,
                'code' => 'XAG',
                'currency_name' => 'Silver Ounce',
            ),
            159 => 
            array (
                'id' => 160,
                'code' => 'XAU',
                'currency_name' => 'Gold Ounce',
            ),
            160 => 
            array (
                'id' => 161,
                'code' => 'XCD',
                'currency_name' => 'East Caribbean Dollar',
            ),
            161 => 
            array (
                'id' => 162,
                'code' => 'XDR',
                'currency_name' => 'Special Drawing Rights',
            ),
            162 => 
            array (
                'id' => 163,
                'code' => 'XOF',
                'currency_name' => 'CFA Franc BCEAO',
            ),
            163 => 
            array (
                'id' => 164,
                'code' => 'XPD',
                'currency_name' => 'Palladium Ounce',
            ),
            164 => 
            array (
                'id' => 165,
                'code' => 'XPF',
                'currency_name' => 'CFP Franc',
            ),
            165 => 
            array (
                'id' => 166,
                'code' => 'XPT',
                'currency_name' => 'Platinum Ounce',
            ),
            166 => 
            array (
                'id' => 167,
                'code' => 'YER',
                'currency_name' => 'Yemeni Rial',
            ),
            167 => 
            array (
                'id' => 168,
                'code' => 'ZAR',
                'currency_name' => 'South African Rand',
            ),
            168 => 
            array (
                'id' => 169,
                'code' => 'ZMW',
                'currency_name' => 'Zambian Kwacha',
            ),
            169 => 
            array (
                'id' => 170,
                'code' => 'ZWL',
                'currency_name' => 'Zimbabwean Dollar',
            ),
        ));
        
        
    }
}