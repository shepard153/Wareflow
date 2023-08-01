<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{
    /**
     * @param int $id
     *
     * @return Product
     */
    public function getProduct(int $id): Product;

    /**
     * @return Collection
     */
    public function getProducts(): Collection;
}