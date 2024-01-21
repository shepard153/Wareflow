<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name'     => 'Admin',
            'email'    => 'test@example.com',
            'password' => bcrypt('test'),
        ]);

        if (! app()->environment('production')) {
            \App\Models\Warehouse::factory(3)->create();
            \App\Models\ProductCategory::factory(10)->create();
        #    \App\Models\Product::factory(10)->create();
        #    \App\Models\Contact::factory(10)->create();
        }
    }
}
