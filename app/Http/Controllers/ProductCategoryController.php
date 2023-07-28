<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
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

    public function store(ProductCategoryRequest $request)
    {
       $this->productCategoryService->create($request->all());
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->productCategoryService->delete($id);
    }
}
