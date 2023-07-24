<?php

namespace App\Enums;

enum ShipmentStatus
{
    const Created = 'created';
    const Pending = 'pending';
    const OnHold = 'on_hold';
    const InTransit = 'in_transit';
    const Delivered = 'delivered';
    const Canceled = 'canceled';
}