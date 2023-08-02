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

    /**
     * @return Collection
     */
    public function getProductsList(): Collection;

    /**
     * @param array $data
     *
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * @param int $id
     * @param array $data
     *
     * @return Product
     */
    public function update(int $id, array $data): Product;

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;
}