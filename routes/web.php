<?php
declare(strict_types=1);

use App\Livewire\Forms\CreateTransactionForm;
use App\Livewire\Forms\CreateWalletForm;
use App\Livewire\Pages\ShowWallet;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::get('/wallets/create', CreateWalletForm::class)->name('wallets.create');
    Route::get('/wallets/{wallet}', ShowWallet::class)->name('wallets.show');
    Route::get('/transactions/create', CreateTransactionForm::class)->name('transactions.create');
});

require __DIR__.'/auth.php';
