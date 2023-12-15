<?php
declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Services\Currency\CurrencyServiceInterface;
use App\Services\Wallet\WalletServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateWalletForm extends Component
{
    private const VALIDATION_RULES = [
        'selectedCurrencyId' => ['required', 'exists:currencies,id',],
        'balance' => ['required', 'numeric', 'min:1', 'max:10000000'],
    ];

    /**
     * @var Collection
     */
    public Collection $currencies;

    /**
     * @var mixed
     */
    public mixed $balance;

    /**
     * @var int
     */
    public int $selectedCurrencyId;

    /**
     * @param CurrencyServiceInterface $currencyService
     *
     * @return void
     */
    public function mount(CurrencyServiceInterface $currencyService): void
    {
        $this->currencies = $currencyService->all(Collection::make());
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('livewire.forms.create-wallet-form');
    }

    /**
     * @param WalletServiceInterface $walletService
     *
     * @return void
     */
    public function createWallet(WalletServiceInterface $walletService): void
    {
        $this->validate(self::VALIDATION_RULES);
        $attributes = Collection::make([
            'user_id' => Auth::id(),
            'currency_id' => $this->selectedCurrencyId,
            'balance' => $this->balance
        ]);
        $wallet = $walletService->create($attributes);
        session()->flash('success', 'Wallet created successfully.');
        $this->reset(['balance', 'selectedCurrencyId']);

        $this->redirectRoute('wallets.show', ['wallet' => $wallet]);
    }
}
