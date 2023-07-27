<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_name',
        'attribute_value',
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'attribute_product_variations', 'attribute_id', 'product_id');
    }

    /**
     * @return BelongsToMany
     */
    public function productVariations(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariation::class, 'attribute_product_variations', 'attribute_id', 'product_variation_id');
    }
}
