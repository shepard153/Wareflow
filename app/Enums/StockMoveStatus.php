<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StockMoveStatus extends Enum
{
    const Draft = 'draft';
    const Pending = 'pending';
    const Completed = 'completed';
    const Canceled = 'canceled';
}