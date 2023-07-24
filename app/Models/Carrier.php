<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone', 'email'];

    /**
     * @return HasMany
     */
    public function outgoingShipments(): HasMany
    {
        return $this->hasMany(OutgoingShipment::class);
    }
}
