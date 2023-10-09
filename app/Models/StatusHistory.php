<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];

    /**
     * @return MorphTo
     */
    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }
}
