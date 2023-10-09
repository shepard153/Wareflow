<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'aisle',
        'shelf',
        'bin'
    ];

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * @return string
     */
    public function getFullLocationAttribute(): string
    {
        return "{$this->aisle}-{$this->shelf}-{$this->bin}";
    }
}
