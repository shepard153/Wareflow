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

    /**
     * @param array $data
     *
     * @return Product
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return Product
     */
    public function update(int $id, array $data): Product
    {
        $product = Product::find($id);
        $product->update($data);

        return $product;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        Product::destroy($id);
    }
}