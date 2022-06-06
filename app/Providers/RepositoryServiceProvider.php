<?php

namespace App\Providers;

use App\Models\ArticleTag;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleTagRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ArticleTagRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            ArticleRepositoryInterface::class,
            ArticleRepository::class
        );
        $this->app->bind(
            ArticleTagRepositoryInterface::class,
            ArticleTagRepository::class
        );
    }
}
