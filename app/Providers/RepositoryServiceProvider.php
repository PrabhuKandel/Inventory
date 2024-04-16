<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\BranchRepositoryInterface;
use  App\Repositories\BranchRepository;
use App\Interfaces\ContactRepositoryInterface;
use  App\Repositories\ContactRepository;
use App\Repositories\CategoryRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\UnitRepository;
use App\Interfaces\UnitRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use  App\Repositories\ProductRepository;
use App\Interfaces\WarehouseRepositoryInterface;
use  App\Repositories\WarehouseRepository;
use App\Interfaces\PurchaseRepositoryInterface;
use  App\Repositories\PurchaseRepository;
use App\Interfaces\SaleRepositoryInterface;
use  App\Repositories\SaleRepository;
use App\Interfaces\UserRepositoryInterface;
use  App\Repositories\UserRepository;
use App\Interfaces\RepositoryInterface;
use  App\Repositories\CommonRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(RepositoryInterface::class, CommonRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(WarehouseRepositoryInterface::class, WarehouseRepository::class);
        $this->app->bind(PurchaseRepositoryInterface::class, PurchaseRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
