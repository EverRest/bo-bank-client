<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class StorageWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstWhere(['email' => Config::get('admin.email')]);
        $currency = Currency::firstWhere(['code' => Config::get('admin.wallet_currency')]);
        $wallet = Wallet::firstOrCreate([
            'user_id' => $admin->id,
            'currency_id' => $currency->id,
            'balance' => 0.00
        ]);
        DB::table('wallets')
            ->where('id', $wallet->id)
            ->update([
                'is_storage' => 1
            ]);
        if ($wallet) {
            $this->command->info('  Admin wallet seeded successfully.');
        } else {
            $this->command->error('  I can\'t find or generate new storage wallet.');
        }
    }
}
