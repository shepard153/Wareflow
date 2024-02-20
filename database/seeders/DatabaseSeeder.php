<?php

namespace Database\Seeders;

use App\Enums\ShipmentStatus;
use App\Enums\ShipmentType;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\StockItem;
use App\Models\Warehouse;
use Closure;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

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
            $this->call([
                ProductCategorySeeder::class,
                ProductSeeder::class
            ]);

            $warehouses = Warehouse::factory(3)->create()->pluck('id');

            $productCategories = ProductCategory::query()->pluck('id');

            $products = Product::query()->pluck('id');

            $contacts = Contact::factory(10)->create()->pluck('id');

            $shipments = Shipment::factory(50)->sequence(fn (Sequence $sequence): array => [
                'contact_id'   => fake()->randomElement($contacts->toArray()),
                'warehouse_id' => fake()->randomElement($warehouses->toArray()),
            ])->create()->each($this->createShipmentItem($products));
        }
    }

    /**
     * @param Collection $products
     * @return Closure
     */
    private function createShipmentItem(Collection $products): Closure
    {
        return function (Shipment $shipment) use ($products): void {
            $shipment->shipmentItems()->createMany(
                ShipmentItem::factory(rand(0, 5))->state([
                    'shipment_id' => $shipment->getAttribute('id'),
                ])->sequence(fn (Sequence $sequence): array => [
                    'product_id'  => fake()->randomElement($products->toArray()),
                ])->make()->toArray()
            )->each($this->createStockItems());

            $this->setShipmentStatus($shipment);
        };
    }

    /**
     * @return Closure
     */
    private function createStockItems(): Closure
    {
        return function (ShipmentItem $shipmentItem): void {
            if ($this->canCreateShipmentItem($shipmentItem->getAttribute('shipment'))) {
                $stockItem = StockItem::query()->create(array_merge(
                    [
                        'warehouse_id' => $shipmentItem->getAttribute('shipment')->getAttribute('warehouse_id'),
                        'shipment_id' => $shipmentItem->getAttribute('shipment')->getAttribute('shipment_type')->value === ShipmentType::Outgoing
                            ? $shipmentItem->getAttribute('shipment')->getAttribute('id')
                            : null,
                    ],
                    $shipmentItem->only(['product_id', 'quantity', 'batch_number', 'barcode', 'expiry_date'])
                ));

                if ($shipmentItem->getAttribute('shipment')->getAttribute('shipment_type')->value === ShipmentType::Outgoing
                    && $shipmentItem->getAttribute('shipment')->getAttribute('status')->value === ShipmentStatus::Delivered
                ) {
                    $stockItem->forceDelete();
                } elseif ($shipmentItem->getAttribute('shipment')->getAttribute('shipment_type')->value === ShipmentType::Outgoing) {
                    $stockItem->delete();
                }
            }
        };
    }

    /**
     * @param Shipment $shipment
     * @return void
     */
    private function setShipmentStatus(Shipment $shipment): void
    {
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
    }

    /**
     *
     */
    private function canCreateShipmentItem(Shipment $shipment): bool
    {
        return $shipment->getAttribute('shipment_type')->value === ShipmentType::Outgoing
            || ($shipment->getAttribute('shipment_type')->value === ShipmentType::Incoming
                && $shipment->getAttribute('status')->value === ShipmentStatus::Delivered
            );
    }
}
