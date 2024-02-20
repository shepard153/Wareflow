<?php

namespace App\Models;

use App\Enums\ShipmentStatus;
use App\Enums\ShipmentType;
use App\Enums\StockMoveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'shipment_type' => ShipmentType::class,
        'status'        => ShipmentStatus::class,
    ];

    // Set reference number on create
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Shipment $shipment): void {
            $shipment->reference = match ($shipment->shipment_type->value) {
                ShipmentType::Incoming          => 'I' . date('Ym') . '-' . Shipment::query()
                        ->where('shipment_type', ShipmentType::Incoming)
                        ->where('created_at', '>=', now()->startOfYear())
                        ->count(),
                ShipmentType::Outgoing          => 'O' . date('Ym') . '-' . Shipment::query()
                        ->where('shipment_type', ShipmentType::Outgoing)
                        ->where('created_at', '>=', now()->startOfYear())
                        ->count(),
                ShipmentType::WarehouseTransfer => 'WT' . date('Ym') . '-' . Shipment::query()
                        ->where('shipment_type', ShipmentType::WarehouseTransfer)
                        ->where('created_at', '>=', now()->startOfYear())
                        ->count(),
                default                         => null,
            };
        });
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

    /**
     * @return HasMany
     */
    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    /**
     * @return HasMany
     */
    public function stockItems(): HasMany
    {
        return $this->hasMany(StockItem::class, 'shipment_id');
    }
}
