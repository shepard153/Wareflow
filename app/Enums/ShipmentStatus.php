<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShipmentStatus extends Enum
{
    const Created = 'created';
    const Pending = 'pending';
    const OnHold = 'on_hold';
    const InTransit = 'in_transit';
    const Delivered = 'delivered';
    const Canceled = 'canceled';

    public static function getOptions(): array
    {
        return [
            self::Created   => __('Utworzona'),
            self::Pending   => __('Oczekująca'),
            self::OnHold    => __('Wstrzymana'),
            self::InTransit => __('W transporcie'),
            self::Delivered => __('Dostarczona'),
            self::Canceled  => __('Anulowana'),
        ];
    }

    public static function getLabel(string $value): string
    {
        return match ($value) {
            self::Created   => __('Utworzona'),
            self::Pending   => __('Oczekująca'),
            self::OnHold    => __('Wstrzymana'),
            self::InTransit => __('W transporcie'),
            self::Delivered => __('Dostarczona'),
            self::Canceled  => __('Anulowana'),
            default         => __('Nieznany'),
        };
    }

    public static function getColor(string $value): string
    {
        return match ($value) {
            self::Pending   => 'info',
            self::OnHold    => 'warning',
            self::InTransit => 'indigo',
            self::Delivered => 'success',
            self::Canceled  => 'danger',
            default         => 'gray',
        };
    }

    public static function getIcon(string $value): string
    {
        return match ($value) {
            self::Created   => 'heroicon-o-clipboard',
            self::Pending   => 'heroicon-o-clock',
            self::OnHold    => 'heroicon-o-pause',
            self::InTransit => 'heroicon-o-truck',
            self::Delivered => 'heroicon-o-check-circle',
            self::Canceled  => 'heroicon-o-x-circle',
            default         => 'heroicon-o-question-mark-circle',
        };
    }
}