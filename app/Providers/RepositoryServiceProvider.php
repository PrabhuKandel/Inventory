<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
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

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
