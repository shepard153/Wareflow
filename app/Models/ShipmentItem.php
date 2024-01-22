<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ShipmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'product_id',
        'location_id',
        'quantity',
        'batch_number',
        'barcode',
        'expiry_date',
    ];

    /**
     * @return BelongsTo
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    /**
     * @return MorphTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(ProductLocation::class, 'location_id');
    }
}
