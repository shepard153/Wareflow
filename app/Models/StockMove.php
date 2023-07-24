<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMove extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'from_location_id', 'to_location_id', 'quantity', 'move_date',
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
}
