<?php

namespace Database\Seeders;

use App\Enums\ShipmentStatus;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\StockQuantity;
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

            $productCategories = ProductCategory::factory(10)->create()->pluck('id');

            $products = Product::factory(100)->sequence(fn (Sequence $sequence): array => [
                'category_id' => fake()->randomElement($productCategories->toArray()),
            ])->create()->pluck('id');

            $contacts = Contact::factory(10)->create()->pluck('id');

            $shipments = Shipment::factory(50)->sequence(fn (Sequence $sequence): array => [
                'contact_id'   => fake()->randomElement($contacts->toArray()),
                'warehouse_id' => fake()->randomElement($warehouses->toArray()),
            ])->create()->each(function (Shipment $shipment) use ($products): void {
                $shipment->shipmentItems()->createMany(
                    ShipmentItem::factory(rand(0, 5))->state([
                        'shipment_id' => $shipment->getAttribute('id'),
                    ])->sequence(fn (Sequence $sequence): array => [
                        'product_id'  => fake()->randomElement($products->toArray()),
                    ])->make()->toArray()
                )->each(function (ShipmentItem $shipmentItem): void {
                    StockQuantity::query()->create([
                        'product_id'   => $shipmentItem->getAttribute('product_id'),
                        'warehouse_id' => $shipmentItem->getAttribute('shipment')->getAttribute('warehouse_id'),
                        'quantity'     => $shipmentItem->getAttribute('quantity'),
                    ]);
                });

                if ($shipment->getAttribute('status')->value !== ShipmentStatus::Created) {
                    $shipment->statusHistories()->createMany([
                        [
                            'status' => ShipmentStatus::Created,
                        ],
                        [
                            'status' => $shipment->getAttribute('status'),
                        ],
                    ]);
                } else {
                    $shipment->statusHistories()->create([
                        'status' => $shipment->getAttribute('status'),
                    ]);
                }
            });
        }
    }
}
