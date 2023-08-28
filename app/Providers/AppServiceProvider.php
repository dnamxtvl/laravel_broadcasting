<?php

namespace App\Providers;

use App\Data\Repository\ChatRepository;
use App\Data\Repository\UserRepository;
use App\Domains\User\Repository\ChatRepositoryInterface;
use App\Domains\User\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(ChatRepositoryInterface::class, ChatRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
