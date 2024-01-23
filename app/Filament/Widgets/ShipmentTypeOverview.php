<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShipmentTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $shipments = Shipment::query()->whereNotIn('status', ['cancelled', 'delivered'])->get();

        return [
            Stat::make(__('Przychodzące'), $shipments->where('shipment_type', 'incoming')->count()),
            Stat::make(__('Wychodzące'), $shipments->where('shipment_type', 'outgoing')->count()),
            Stat::make(__('Transfery międzymagaznowe'), $shipments->where('shipment_type', 'warehouse_transfer')->count()),
        ];
    }
}
