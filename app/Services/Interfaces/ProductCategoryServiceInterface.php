<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;

interface ProductCategoryServiceInterface
{
    /**
     * @param int $id
     *
     * @return ProductCategory
     */
    public function getProductCategory(int $id): ProductCategory;

    /**
     * @return Collection
     */
    public function getProductCategories(): Collection;

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;
}