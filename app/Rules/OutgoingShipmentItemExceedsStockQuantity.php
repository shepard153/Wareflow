<?php

namespace App\Rules;

use App\Models\StockItem;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class OutgoingShipmentItemExceedsStockQuantity implements ValidationRule
{
    public function __construct(protected int $productId)
    {
        //
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $stockQuantity = StockItem::where('product_id', $this->productId)->get()->sum('quantity');

        if ($value > $stockQuantity) {
            $fail(__('Podana wartość wykracza poza stan magazynowy. Aktualny stan magazynowy: :stockQuantity', [
                'stockQuantity' => $stockQuantity,
            ]));
        }
    }
}
