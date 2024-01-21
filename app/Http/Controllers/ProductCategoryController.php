<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Services\Interfaces\ProductCategoryServiceInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ProductCategoryController extends Controller
{
    public function __construct(private readonly ProductCategoryServiceInterface $productCategoryService)
    {
        //
    }

    /**
     * @param ProductCategoryRequest $request
     *
     * @return RedirectResponse
     */
    public function store(ProductCategoryRequest $request): RedirectResponse
    {
        try {
            $this->productCategoryService->create($request->all());

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('Product category successfully added.'));
    }

    /**
     * @param ProductCategoryRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(ProductCategoryRequest $request, int $id): RedirectResponse
    {
        try {
            $this->productCategoryService->update($id, ($request->all()));

        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }

        return back()->with('message', __('Product category successfully updated.'));
    }

    /**
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        try {
            $this->productCategoryService->delete($id);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', __('Product category successfully deleted.'));
    }
}
