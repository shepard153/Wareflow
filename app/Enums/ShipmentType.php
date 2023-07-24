<?php

namespace App\Enums;

enum ShipmentType
{
    const Incoming = 'in';
    const Outgoing = 'outgoing';
    const WarehouseTransfer = 'warehouse_transfer';
}