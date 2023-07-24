<?php

namespace App\Enums;

enum StockMoveStatus
{
    const Draft = 'draft';
    const Pending = 'pending';
    const Completed = 'completed';
    const Canceled = 'canceled';
}