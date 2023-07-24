<?php

namespace App\Models;

use App\Enums\StockMoveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'contact_id',
        'warehouse_id',
        'shipment_type',
        'quantity',
        'description',
        'reference',
        'status',
        'tracking_number',
        'shipment_date',
        'scheduled_date',
    ];

    protected $casts = [
        'shipment_type' => StockMoveStatus::class,
        'status'        => StockMoveStatus::class,
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
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
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
