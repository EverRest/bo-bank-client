<?php
declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Wallet;

class ShowWallet extends Component
{
    /**
     * @var Wallet
     */
    public Wallet $wallet;

    /**
     * @param Wallet $wallet
     *
     * @return void
     */
    public function mount(Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }
}
?>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @livewire('wallet.show-wallet', ['wallet' => $wallet])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
