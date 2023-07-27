<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProductCategory;
use App\Services\Interfaces\ProductCategoryServiceInterface;
use Illuminate\Support\Collection;

class ProductCategoryServiceService implements ProductCategoryServiceInterface
{
    /**
     * @param int $id
     *
     * @return ProductCategory
     */
    public function getProductCategory(int $id): ProductCategory
    {
        return ProductCategory::find($id)->first();
    }

    /**
     * @return Collection
     */
    public function getProductCategories(): Collection
    {
        return ProductCategory::all();
    }
}