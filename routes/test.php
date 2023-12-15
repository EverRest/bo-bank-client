<?php
declare(strict_types=1);

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/user', fn(Request $request) => $request->user());
Route::post('/log-out', fn(Request $request) => $request->user()->tokens()->delete());
Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::post('/', [TransactionController::class, 'create']);
});
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::put('/{user}', [UserController::class, 'update']);
});
Route::prefix('wallets')->group(function () {
    Route::put('/{wallet}', [WalletController::class, 'update']);
    Route::patch('/{wallet}', [WalletController::class, 'updateBalance']);
});
