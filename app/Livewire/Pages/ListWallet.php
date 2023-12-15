<?php
declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Services\Wallet\WalletServiceInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListWallet extends Component
{
    /**
     * @param WalletServiceInterface $walletService
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(WalletServiceInterface $walletService): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $filters = Collection::make(['user_id' => Auth::id()]);
        $wallets = $walletService->all($filters);

        return view('livewire.pages.list-wallet', compact('wallets'));
    }
}
