<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShipment extends ViewRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->hidden(fn () => $this->record->getAttribute('status')->value === 'delivered'
                    || $this->record->getAttribute('status')->value === 'canceled'
                ),
        ];
    }

    public function getTitle(): string
    {
        return __('Dostawa :id (:contact)', [
            'id'      => $this->record->getAttribute('reference'),
            'contact' => $this->record->getAttribute('contact')->getAttribute('name'),
        ]);
    }
}
