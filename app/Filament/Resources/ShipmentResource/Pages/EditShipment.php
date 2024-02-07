<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
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
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
