<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-8 lg:px-10 space-y-6">
        <div class="w-full p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="text-2xl font-semibold mb-4">Wallet List</h2>

                @foreach ($wallets as $wallet)
                    <div class="mb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl">Name: {{ $wallet->name }}</h3>
                                <p class="text-gray-500 pt-1 pb-1">Currency: {{ $wallet->currency->code }}</p>
                            </div>
                            <div>
                                <p class="text-2xl font-semibold">Balance: {{ number_format($wallet->balance, 2) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('wallets.show', $wallet) }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Enter to wallet</a>
                    </div>
                    <hr class="my-2">
                @endforeach

                @if ($wallets->isEmpty())
                    <p class="text-gray-500">No wallets found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
