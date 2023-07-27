<?php

namespace App\Providers;

use App\Services\Interfaces\ProductCategoryServiceInterface;
use App\Services\ProductCategoryServiceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All the container singletons that should be registered.
     *
     * @var array
     */
    public array $singletons = [
        ProductCategoryServiceInterface::class => ProductCategoryServiceService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
