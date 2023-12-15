<div>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-700 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-lg"></div>
            <div class="relative px-4 py-12 bg-white shadow-lg sm:rounded-lg sm:p-20">
                <p class="mt-4 text-lg text-gray-500">Owner: {{ $wallet->user->name }}</p>
                <p class="mt-4 text-lg text-gray-500">Wallet: {{ $wallet->name }}</p>
                <p class="mt-4 text-lg text-gray-500">Currency: {{ $wallet->currency->name }}</p>
                <p class="mt-4 text-lg text-gray-500">Balance: {{ $wallet->balance }}</p>
                <div class="mt-6">
                    <a href="{{ route('wallets.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">
                        ADD NEW WALLET
                    </a>
                    <a href="{{ route('transactions.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 ml-2">
                        SEND
                    </a>
                </div>
                <h3 class="text-xl font-semibold mt-6 mb-3">Transaction History</h3>
                <table class="w-full">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($wallet->transactions as $transaction)
                        <tr class="{{ $transaction->to_wallet_id === $wallet->id ? 'text-green-500' : 'text-red-500' }}">
                            <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $transaction->to_wallet_id === $wallet->id ? 'Income' : 'Outcome' }}</td>
                            <td>
                                @if ($transaction->to_wallet_id === $wallet->id)
                                    +{{ number_format($transaction->amount, 2) }} {{$transaction->walletTo->currency->code}}
                                @else
                                    -{{ number_format(abs($transaction->amount), 2) }} {{$transaction->walletFrom->currency->code}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
