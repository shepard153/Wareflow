<?php

namespace App\Rules;

use App\Services\Interfaces\ProductCategoryServiceInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ProductCategoryLevelsLimit implements ValidationRule
{
    private ProductCategoryServiceInterface $productCategoryService;

    public function __construct()
    {
        $this->productCategoryService = resolve(ProductCategoryServiceInterface::class);
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productCategoryParent = $this->productCategoryService->getProductCategory($value);

        $count = $this->getParentCategoriesCount($value);

        if ($count >= 2) {
            $fail(__('Cannot nest more than two levels deep in the category hierarchy.'));
        }
    }

    /**
     * @param int $productCategoryId
     *
     * @return int
     */
    private function getParentCategoriesCount(int $productCategoryId): int
    {
        $productCategory = $this->productCategoryService->getProductCategory($productCategoryId);

        if ($productCategory->getAttribute('parent_id') === null) {
            return 0;
        }

        return 1 + $this->getParentCategoriesCount($productCategory->getAttribute('parent_id'));
    }
}
