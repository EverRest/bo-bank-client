<div>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-700 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-lg"></div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-lg sm:p-20">
                <h1 class="text-3xl font-extrabold leading-tight text-gray-900 mt-0.5 pt-1 pb-1">Create a New Wallet</h1>
                <form wire:submit.prevent="createWallet" class="mt-6 pt-2 pb2">
                    <div class="mt-4">
                        <label for="selectedCurrencyId" class="block text-sm font-medium leading-5 text-gray-700">Currency</label>
                        <select wire:model.lazy="selectedCurrencyId" id="selectedCurrencyId" required class="mt-1 p-2 block w-full border-none rounded-md bg-gray-100 focus:ring focus:ring-indigo-400">
                            <option value="" selected>Select a currency</option>
                            @foreach ($currencies as $currency)
                                <option {{$currency->code}} value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->code }})</option>
                            @endforeach
                        </select>
                        @error('selectedCurrencyId') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="balance" class="block text-sm font-medium leading-5 text-gray-700">Balance</label>
                        <input wire:model="balance" id="balance" type="text" required class="mt-1 p-2 block w-full border-none rounded-md bg-gray-100 focus:ring focus:ring-indigo-400">
                        @error('balance') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
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

