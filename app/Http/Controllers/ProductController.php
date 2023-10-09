<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\Interfaces\ProductServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
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
        $products = $this->productService->getProductsList();

        return Inertia::render('Products', [
            'products' => $products
        ]);
    }

    /**
     * @param ProductRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $this->productService->create($request->all());

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('Product successfully added.'));
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            $this->productService->delete($id);

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('Product successfully deleted.'));
    }
}
