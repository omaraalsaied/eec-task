<?php

namespace App\Providers;

use App\Repositories\PharmacyRepository;
use App\Repositories\ProductRepository;
use App\Services\PharmacyService;
use App\Services\ProductService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use PharmacyRepositoryInterface;
use ProductRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepository::class));
        });
        $this->app->bind(PharmacyService::class, function ($app) {
            return new PharmacyService($app->make(PharmacyRepository::class));
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

    }
}
