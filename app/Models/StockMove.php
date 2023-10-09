<?php

namespace App\Models;

use App\Enums\StockMoveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StockMove extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'from_location_id',
        'to_location_id',
        'movement_type',
        'quantity',
        'reason',
        'reference',
        'status',
        'move_date',
    ];

    protected $casts = [
        'status' => StockMoveStatus::class,
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(ProductLocation::class, 'from_location_id');
    }

    /**
     * @return BelongsTo
     */
    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(ProductLocation::class, 'to_location_id');
    }

    /**
     * @return MorphMany
     */
    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }

    /**
     * @return MorphOne
     */
    public function lastStatus(): MorphOne
    {
        return $this->morphOne(StatusHistory::class, 'statusable')->latestOfMany();
    }
}
