<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ProductCategoryServiceInterface;
use Inertia\Inertia;
use Inertia\Response;

class ProductCategoryController extends Controller
{
    public function __construct(private readonly ProductCategoryServiceInterface $productCategoryService)
    {
        //
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $productCategories = $this->productCategoryService->getProductCategories();

        return Inertia::render('ProductCategories', [
            'productCategories' => $productCategories
        ]);
    }
}
