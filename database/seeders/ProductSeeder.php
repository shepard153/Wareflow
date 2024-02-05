<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categoryIds = DB::table('product_categories')->pluck('id');

        $products = [
            // Materiały budowlane
            [
                'category_id'     => $categoryIds[0],
                'name'            => 'Farba lateksowa',
                'description'     => 'Farba do malowania ścian',
                'sku'             => 'FBL123',
                'unit_of_measure' => 'litr',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[0],
                'name'            => 'Gwóźdź budowlany',
                'description'     => 'Gwóźdź o długości 10 cm',
                'sku'             => 'GBD456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[0],
                'name'            => 'Gwóźdź wykończeniowy',
                'description'     => 'Gwóźdź do wykończeń',
                'sku'             => 'GW456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[0],
                'name'            => 'Farba akrylowa',
                'description'     => 'Farba do malowania ścian',
                'sku'             => 'FA123',
                'unit_of_measure' => 'litr',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[0],
                'name'            => 'Farba olejna',
                'description'     => 'Farba do malowania drewna',
                'sku'             => 'FO456',
                'unit_of_measure' => 'litr',
                'has_variants'    => false
            ],

            // Elektronarzędzia
            [
                'category_id'     => $categoryIds[1],
                'name'            => 'Wiertarka udarowa',
                'description'     => 'Wiertarka do prac budowlanych',
                'sku'             => 'WUD789',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false]
            ,
            [
                'category_id'     => $categoryIds[1],
                'name'            => 'Młotek elektryczny',
                'description'     => 'Młotek do prac remontowych',
                'sku'             => 'ME123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[1],
                'name'            => 'Wiertarka stołowa',
                'description'     => 'Wiertarka do prac stolarskich',
                'sku'             => 'WS456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Narzędzia ręczne
            [
                'category_id'     => $categoryIds[2],
                'name'            => 'Klucz francuski',
                'description'     => 'Klucz do śrub',
                'sku'             => 'KF456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[2],
                'name'            => 'Piła ręczna',
                'description'     => 'Piła do cięcia drewna',
                'sku'             => 'PR789',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[2],
                'name'            => 'Młotek stolarski',
                'description'     => 'Młotek do prac stolarskich',
                'sku'             => 'MS123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Oświetlenie
            [
                'category_id'     => $categoryIds[3],
                'name'            => 'Żarówka LED',
                'description'     => 'Żarówka energooszczędna',
                'sku'             => 'ZLED456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[3],
                'name'            => 'Lampa wisząca',
                'description'     => 'Lampa do salonu',
                'sku'             => 'LW123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[3],
                'name'            => 'Lampa sufitowa',
                'description'     => 'Lampa do kuchni',
                'sku'             => 'LS456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Drzwi i okna
            [
                'category_id'     => $categoryIds[4],
                'name'            => 'Drzwi zewnętrzne',
                'description'     => 'Drzwi do domu',
                'sku'             => 'DZ123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[4],
                'name'            => 'Okno PCV',
                'description'     => 'Okno do domu',
                'sku'             => 'OPCV123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[4],
                'name'            => 'Okno aluminiowe',
                'description'     => 'Okno do biura',
                'sku'             => 'OA456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Podłogi
            [
                'category_id'     => $categoryIds[5],
                'name'            => 'Panele podłogowe',
                'description'     => 'Panele do salonu',
                'sku'             => 'PP123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[5],
                'name'            => 'Deska podłogowa',
                'description'     => 'Deska do salonu',
                'sku'             => 'DP456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Meble
            [
                'category_id'     => $categoryIds[6],
                'name'            => 'Stół drewniany',
                'description'     => 'Stół do jadalni',
                'sku'             => 'SD123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[6],
                'name'            => 'Krzesło drewniane',
                'description'     => 'Krzesło do jadalni',
                'sku'             => 'KD456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Technologie budowlane
            [
                'category_id'     => $categoryIds[7],
                'name'            => 'Kamera IP',
                'description'     => 'Kamera do monitoringu',
                'sku'             => 'KIP123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[7],
                'name'            => 'Czujnik ruchu',
                'description'     => 'Czujnik do alarmu',
                'sku'             => 'CR456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Ogrodnictwo
            [
                'category_id'     => $categoryIds[8],
                'name'            => 'Nawóz do trawnika',
                'description'     => 'Nawóz do trawy',
                'sku'             => 'NDT123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[8],
                'name'            => 'Donica ceramiczna',
                'description'     => 'Donica do kwiatów',
                'sku'             => 'DC456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Chemikalia budowlane
            [
                'category_id'     => $categoryIds[9],
                'name'            => 'Klej do glazury',
                'description'     => 'Klej do kafli',
                'sku'             => 'KDG123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[9],
                'name'            => 'Gładź szpachlowa',
                'description'     => 'Gładź do ścian',
                'sku'             => 'GS456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[9],
                'name'            => 'Wełna mineralna',
                'description'     => 'Wełna do izolacji',
                'sku'             => 'WM123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[9],
                'name'            => 'Pianka poliuretanowa',
                'description'     => 'Pianka do izolacji',
                'sku'             => 'PP456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Instalacje
            [
                'category_id'     => $categoryIds[10],
                'name'            => 'Kotłownia gazowa',
                'description'     => 'Kotłownia do domu',
                'sku'             => 'KG123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[10],
                'name'            => 'Kotłownia olejowa',
                'description'     => 'Kotłownia do domu',
                'sku'             => 'KO456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Dachy i rynny
            [
                'category_id'     => $categoryIds[11],
                'name'            => 'Rynna stalowa',
                'description'     => 'Rynna do domu',
                'sku'             => 'RS456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[11],
                'name'            => 'Dachówka ceramiczna',
                'description'     => 'Dachówka do domu',
                'sku'             => 'DC123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[11],
                'name'            => 'Blacha dachowa',
                'description'     => 'Blacha do domu',
                'sku'             => 'BD456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Bezpieczeństwo budowlane
            [
                'category_id'     => $categoryIds[12],
                'name'            => 'Kask ochronny',
                'description'     => 'Kask do prac budowlanych',
                'sku'             => 'KO123',
                'unit_of_measure' => 'sztuka',
                'has_variants' => false
            ],
            [
                'category_id'     => $categoryIds[12],
                'name'            => 'Rękawice robocze',
                'description'     => 'Rękawice do prac budowlanych',
                'sku'             => 'RR456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Hydraulika
            [
                'category_id'     => $categoryIds[13],
                'name'            => 'Zawór kulowy',
                'description'     => 'Zawór do instalacji wodnej',
                'sku'             => 'ZK123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[13],
                'name'            => 'Wąż ogrodowy',
                'description'     => 'Wąż do podlewania ogrodu',
                'sku'             => 'WO456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[13],
                'name'            => 'Rura PCV',
                'description'     => 'Rura kanalizacyjna',
                'sku'             => 'RPCV123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[13],
                'name'            => 'Złączka mufowa',
                'description'     => 'Złączka do rur',
                'sku'             => 'ZM456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Systemy wentylacyjne
            [
                'category_id'     => $categoryIds[14],
                'name'            => 'Wentylator kanałowy',
                'description'     => 'Wentylator do kanałów wentylacyjnych',
                'sku'             => 'WK123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[14],
                'name'            => 'Kratka wentylacyjna',
                'description'     => 'Kratka do wentylacji',
                'sku'             => 'KW456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[14],
                'name'            => 'Wentylator okienny',
                'description'     => 'Wentylator do okna',
                'sku'             => 'WO457',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],

            // Elewacje
            [
                'category_id'     => $categoryIds[15],
                'name'            => 'Tynk silikonowy',
                'description'     => 'Tynk do elewacji',
                'sku'             => 'TS123',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[15],
                'name'            => 'Płyta elewacyjna',
                'description'     => 'Płyta do elewacji',
                'sku'             => 'PE456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
            [
                'category_id'     => $categoryIds[15],
                'name'            => 'Tynk akrylowy',
                'description'     => 'Tynk do elewacji',
                'sku'             => 'TA456',
                'unit_of_measure' => 'sztuka',
                'has_variants'    => false
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert($product);
        }
    }
}
