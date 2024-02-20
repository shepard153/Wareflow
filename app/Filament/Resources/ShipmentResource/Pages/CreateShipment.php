<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Enums\ShipmentType;
use App\Filament\Resources\ShipmentResource;
use App\Models\ShipmentItem;
use App\Models\StockItem;
use Filament\Resources\Pages\CreateRecord;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    public function getTitle(): string
    {
        return __('Nowa dostawa');
    }

    protected function afterCreate(): void
    {
        match ($this->record->getAttribute('shipment_type')->value) {
            ShipmentType::Outgoing => $this->record->getAttribute('shipmentItems')->each(function (ShipmentItem $shipmentItem): void {
                $quantity = $shipmentItem->getAttribute('quantity');

                StockItem::query()
                    ->where('product_id', $shipmentItem->getAttribute('product_id'))
                    ->orderBy('expiry_date')
                    ->orderBy('created_at')
                    ->get()
                    ->each(function (StockItem $stockItem) use (&$quantity): void {
                        if ($quantity > 0) {
                            if ($stockItem->getAttribute('quantity') > $quantity) {
                                $stockItem->update([
                                    'quantity' => $stockItem->getAttribute('quantity') - $quantity,
                                ]);

                                $copy = $stockItem->replicate(['shipment_id', 'quantity'])->update([
                                    'quantity'    => $quantity,
                                    'shipment_id' => $this->record->getAttribute('id'),
                                    'deleted_at'  => now(),
                                ]);

                                $quantity = 0;
                            } else {
                                $quantity -= $stockItem->getAttribute('quantity');

                                $stockItem->update([
                                    'shipment_id' => $this->record->getAttribute('id')
                                ]);

                                $stockItem->delete();
                            }
                        }
                    });
            }),
            default => null,
        };

        $this->record->statusHistories()->create([
            'status' => $this->data['status'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
