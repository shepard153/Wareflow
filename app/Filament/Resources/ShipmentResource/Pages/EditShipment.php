<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Enums\ShipmentStatus;
use App\Enums\ShipmentType;
use App\Filament\Resources\ShipmentResource;
use App\Models\ShipmentItem;
use App\Models\StockItem;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShipment extends EditRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('Dostawa :reference', ['reference' => $this->record->getAttribute('reference')]);
    }

    protected function afterSave(): void
    {
        if ($this->record->getAttribute('lastStatus')->getAttribute('status') !== $this->data['status']) {
            $this->record->statusHistories()->create([
                'status' => $this->data['status'],
            ]);
        }

        if ($this->record->getAttribute('status')->value === ShipmentStatus::Delivered) {
            if ($this->record->getAttribute('shipment_type')->value === ShipmentType::Incoming) {
                $this->record->getAttribute('shipmentItems')->each(function (ShipmentItem $shipmentItem): void {
                    StockItem::query()->create(array_merge(
                        [
                            'warehouse_id' => $this->record->getAttribute('warehouse_id'),
                        ],
                        $shipmentItem->only(['product_id', 'quantity', 'batch_number', 'barcode', 'expiry_date'])
                    ));
                });
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}