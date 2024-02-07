<?php

namespace App\Enums;

use App\Models\Shipment;
use BenSampo\Enum\Enum;
use Filament\Forms\Set;

final class ShipmentType extends Enum
{
    const Incoming = 'incoming';
    const Outgoing = 'outgoing';
    const WarehouseTransfer = 'warehouse_transfer';

    public static function getOptions(): array
    {
        return [
            self::Incoming          => __('Przychodząca'),
            self::Outgoing          => __('Wychodząca'),
            self::WarehouseTransfer => __('Przesunięcie magazynowe'),
        ];
    }

    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::Incoming          => __('Przychodząca'),
            self::Outgoing          => __('Wychodząca'),
            self::WarehouseTransfer => __('Przesunięcie magazynowe'),
            default                 => __('Nieznany typ'),
        };
    }

    public static function getColor(string $value): string
    {
        return match ($value) {
            self::Incoming          => 'success',
            self::Outgoing          => 'warning',
            self::WarehouseTransfer => 'info',
            default                 => 'gray',
        };
    }

    public static function getIcon(string $value): string
    {
        return match ($value) {
            self::Incoming          => 'heroicon-o-arrow-down',
            self::Outgoing          => 'heroicon-o-arrow-up',
            self::WarehouseTransfer => 'heroicon-o-arrows-up-down',
            default                 => 'heroicon-o-question-mark-circle',
        };
    }

    public static function getReferenceNumber(string $value, Set $set): ?string
    {
        return match ($value) {
            self::Incoming          => $set('reference', 'I' . date('Ymd') . '-' . Shipment::query()->count()),
            self::Outgoing          => $set('reference','O' . date('Ymd') . '-' . Shipment::query()->count()),
            self::WarehouseTransfer => $set('reference','WT' . date('Ymd') . '-' . Shipment::query()->count()),
            default                 => null,
        };
    }
}