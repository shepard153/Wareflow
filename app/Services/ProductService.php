<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Services\Interfaces\ProductServiceInterface;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    /**
     * @param int $id
     *
     * @return Product
     */
    public function getProduct(int $id): Product
    {
        return Product::find($id);
    }

    /**
     * @return Collection
     */
    public function getProducts(): Collection
    {
        return Product::all();
    }
}