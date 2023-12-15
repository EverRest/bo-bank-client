<div>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div
                class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-700 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-lg"></div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-lg sm:p-20">
                <h1 class="text-3xl font-extrabold leading-tight text-gray-900 mt-0.5 pt-1 pb-1">Create a New
                    Transaction</h1>
                <form wire:submit.prevent="createTransaction" class="mt-6 pt-2 pb-2">
                    <div class="mt-4">
                        <label for="sender_wallet_id" class="block text-sm font-medium leading-5 text-gray-700">Select
                            Sender's Wallet:</label>
                        <select wire:model.lazy="senderWalletId" id="sender_wallet_id" class="mt-1 p-2 block w-full border-none rounded-md bg-gray-100 focus:ring focus:ring-indigo-400" required>
                            <option value="">Select Wallet</option>
                            @foreach ($senderWallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->currency->name }} ({{ $wallet->balance }})</option>
                            @endforeach
                        </select>
                        @error('senderWalletId') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="receiver_id" class="block text-sm font-medium leading-5 text-gray-700">Select
                            Receiver:</label>
                        <select wire:model.lazy="receiverId" id="receiver_id" required
                                class="mt-1 p-2 block w-full border-none rounded-md bg-gray-100 focus:ring focus:ring-indigo-400">
                            <option value="" selected>Select Receiver</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('receiverId') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="receiver_wallet_id" class="block text-sm font-medium leading-5 text-gray-700">Select
                            Receiver's Wallet:</label>
                        <select wire:model.lazy="receiverWalletId" id="receiver_wallet_id"
                                class="mt-1 p-2 block w-full border-none rounded-md bg-gray-100 focus:ring focus:ring-indigo-400">
                            @if ($receiverId)
                                <option value="">Select Wallet</option>
                                @foreach ($receiverWallets as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->currency->name }}
                                        ({{ $wallet->balance }})
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Select Receiver First</option>
                            @endif
                        </select>
                        @error('receiverWalletId') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="amount" class="block text-sm font-medium leading-5 text-gray-700">Amount</label>
                        <input wire:model="amount" id="amount" type="number" required
                               class="mt-1 p-2 block w-full border-none rounded-md bg-gray-100 focus:ring focus:ring-indigo-400">
                        @error('amount') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
                            CREATE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
