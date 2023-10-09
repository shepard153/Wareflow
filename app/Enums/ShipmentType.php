<?php

namespace App\Enums;

enum ShipmentType
{
    const Incoming = 'incoming';
    const Outgoing = 'outgoing';
    const WarehouseTransfer = 'warehouse_transfer';
}