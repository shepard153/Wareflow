<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ProductServiceInterface;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct(protected ProductServiceInterface $productService)
    {
        //
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $products = $this->productService->getProducts();

        return Inertia::render('Products', [
            'products' => $products
        ]);
    }
}
