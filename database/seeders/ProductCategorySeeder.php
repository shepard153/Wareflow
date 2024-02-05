<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Materiały budowlane'],
            ['name' => 'Elektronarzędzia'],
            ['name' => 'Narzędzia ręczne'],
            ['name' => 'Oświetlenie'],
            ['name' => 'Drzwi i okna'],
            ['name' => 'Podłogi'],
            ['name' => 'Meble'],
            ['name' => 'Technologie budowlane'],
            ['name' => 'Ogrodnictwo'],
            ['name' => 'Chemikalia budowlane'],
            ['name' => 'Instalacje'],
            ['name' => 'Dachy i rynny'],
            ['name' => 'Bezpieczeństwo budowlane'],
            ['name' => 'Hydraulika'],
            ['name' => 'Systemy wentylacyjne'],
            ['name' => 'Elewacje'],
        ];

        foreach ($categories as $category) {
            DB::table('product_categories')->insert($category);
        }
    }
}
