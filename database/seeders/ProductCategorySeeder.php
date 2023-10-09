<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Lumber'],
            ['name' => 'Concrete'],
            ['name' => 'Bricks'],
            ['name' => 'Roofing Materials'],
            ['name' => 'Paints and Coatings'],
            ['name' => 'Electrical Supplies'],
            ['name' => 'Plumbing Materials'],
            ['name' => 'Doors and Windows'],
            ['name' => 'Flooring Materials'],
            ['name' => 'Insulation'],
        ];

        DB::table('product_categories')->insert($categories);
    }
}
