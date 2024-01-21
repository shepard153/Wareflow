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

        if ($productCategoryParent->getAttribute('children')->count() > 0) {
            $fail(__('Category with child elements cannot be a subcategory.'));
        }
    }
}
