<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CurrencySeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(StorageWalletSeeder::class);

        if(User::all()->count() < 10) {
            User::factory(5)->create();
        }
        if(Wallet::all()->count() < 10) {
            Wallet::factory(10)->create();
        }

    }
}
