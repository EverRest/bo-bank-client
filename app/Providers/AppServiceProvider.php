<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\Currency\CurrencyRepository;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Wallet\WalletRepository;
use App\Services\Currency\CurrencyService;
use App\Services\Currency\CurrencyServiceInterface;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use App\Services\Wallet\WalletService;
use App\Services\Wallet\WalletServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        $this->app->singleton(
            CurrencyServiceInterface::class,
            fn ($app) => new CurrencyService(new CurrencyRepository())
        );
        $this->app->singleton(
            TransactionServiceInterface::class,
            fn ($app) => new TransactionService(new TransactionRepository())
        );
        $this->app->singleton(
            UserServiceInterface::class,
            fn ($app) => new UserService(new UserRepository())
        );
        $this->app->singleton(
            WalletServiceInterface::class,
            fn ($app) => new WalletService(new WalletRepository())
        );
    }
}
