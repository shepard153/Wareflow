<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProductCategory;
use App\Services\Interfaces\ProductCategoryServiceInterface;
use Exception;
use Illuminate\Support\Collection;

class ProductCategoryService implements ProductCategoryServiceInterface
{
    /**
     * @param int $id
     *
     * @return ProductCategory
     */
    public function getProductCategory(int $id): ProductCategory
    {
        return ProductCategory::find($id);
    }

    /**
     * @return Collection
     */
    public function getProductCategories(): Collection
    {
        return ProductCategory::all();
    }

    /**
     * @return Collection
     */
    public function getProductCategoryTree(): Collection
    {
        $productCategories = ProductCategory::all();

        return $productCategories->map(function (ProductCategory $productCategory) use ($productCategories) {
            return $this->mapProductCategoryChildrenRecursive($productCategories, $productCategory);
        })->filter(function (Collection $productCategory) {
            return $productCategory->get('parent_id') === null;
        });
    }

    /**
     * @param Collection $productCategories
     * @param ProductCategory $productCategory
     *
     * @return Collection
     */
    private function mapProductCategoryChildrenRecursive(Collection $productCategories, ProductCategory $productCategory): Collection
    {
        $productCategoryChildren = $productCategories->where('parent_id', $productCategory->getAttribute('id'));

        return collect([
            'id'        => $productCategory->getAttribute('id'),
            'name'      => $productCategory->getAttribute('name'),
            'parent_id' => $productCategory->getAttribute('parent_id'),
            'children'  => $productCategoryChildren->map(function (ProductCategory $productCategoryChild) use ($productCategories) {
                return $this->mapProductCategoryChildrenRecursive($productCategories, $productCategoryChild);
            }),
        ]);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function create(array $data): void
    {
        ProductCategory::create([
            'name'      => $data['name'],
            'parent_id' => $data['parent_id'],
        ]);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function update(array $data): void
    {
        ProductCategory::where(['id' => $data['id']])->update([
            'name'      => $data['name'],
            'parent_id' => $data['parent_id'],
        ]);
    }

    /**
     * @param int $id
     *
     * @return void
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $productCategory = ProductCategory::where(['id' => $id])->first();

        if ($productCategory->children()->count() > 0) {
            throw new Exception(__('Cannot delete category with child elements. Please delete child elements first.'));
        }

        ProductCategory::where(['id' => $id])->delete();
    }
}