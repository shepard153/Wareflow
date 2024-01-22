<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductLocation;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
            $warehouses = Warehouse::factory(3)->create()->pluck('id');

            $productLocations = ProductLocation::factory(100)->sequence(fn (Sequence $sequence): array => [
                'warehouse_id' => fake()->randomElement($warehouses->toArray()),
            ])->create()->pluck('id');

            $productCategories = ProductCategory::factory(10)->create()->pluck('id');

            $products = Product::factory(100)->sequence(fn (Sequence $sequence): array => [
                'category_id' => fake()->randomElement($productCategories->toArray()),
            ])->create()->pluck('id');

            $contacts = Contact::factory(10)->create()->pluck('id');

            $shipments = Shipment::factory(50)->sequence(fn (Sequence $sequence): array => [
                'contact_id'   => fake()->randomElement($contacts->toArray()),
                'warehouse_id' => fake()->randomElement($warehouses->toArray()),
            ])->create()->each(function (Shipment $shipment) use ($products, $productLocations): void {
                $shipment->shipmentItems()->createMany(
                    ShipmentItem::factory(rand(0, 5))->state([
                        'shipment_id' => $shipment->getAttribute('id'),
                    ])->sequence(fn (Sequence $sequence): array => [
                        'product_id'  => fake()->randomElement($products->toArray()),
                        'location_id' => fake()->randomElement($productLocations->toArray()),
                    ])->make()->toArray()
                );
            });
        }
    }
}
