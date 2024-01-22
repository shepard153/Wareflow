<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ShipmentType extends Enum
{
    const Incoming = 'incoming';
    const Outgoing = 'outgoing';
    const WarehouseTransfer = 'warehouse_transfer';
}