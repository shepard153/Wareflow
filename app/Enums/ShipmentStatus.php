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
}