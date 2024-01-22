<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;

interface ProductCategoryServiceInterface
{
    public function getProductCategory(int $id): ProductCategory;
    public function getProductCategories(): Collection;
    public function update(int $id, array $data): void;
    public function delete(int $id): void;
}