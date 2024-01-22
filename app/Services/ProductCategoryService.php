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
     * @param int $id
     * @param array $data
     *
     * @return void
     * @throws Exception
     */
    public function update(int $id, array $data): void
    {
        if($data['is_subcategory']) {
            $parentId = (int) $data['parent_id'];

            $this->isParentAssignedToChild($id, $parentId)
                ?? throw new Exception(__('Cannot assign category to its child.'));

            if ($this->categoryChildrenHaveChildren($id)
                || ($this->getProductCategory($id)->children()->count() >= 1
                && $this->getProductCategory($parentId)->getAttribute('parent_id') !== null)) {

                throw new Exception(__('Cannot move category as it would create too deeply nested hierarchy.'));
            }
        }

        ProductCategory::where(['id' => $id])->update([
            'name'      => $data['name'],
            'parent_id' => $data['is_subcategory'] ? $data['parent_id'] : null,
        ]);
    }

    /**
     * @param int $id
     * @param int $parentId
     *
     * @return bool
     */
    private function isParentAssignedToChild(int $id, int $parentId): bool
    {
        $productCategory = $this->getProductCategory($parentId);

        if ($productCategory->getAttribute('parent_id') === $id) {
            return true;
        }

        if ($productCategory->getAttribute('parent_id') === null) {
            return false;
        }

        return $this->isParentAssignedToChild($id, $productCategory->getAttribute('parent_id'));
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    private function categoryChildrenHaveChildren(int $id): bool
    {
        $productCategory = $this->getProductCategory($id);

        if ($productCategory->children()->count() === 0) {
            return false;
        }

        foreach ($productCategory->children() as $child) {
            if ($child->children()->count() > 0) {
                return true;
            }
        }

        return false;
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

        $productCategory->delete();
    }
}