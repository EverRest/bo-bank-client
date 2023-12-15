<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    private const PATH_TO_JSON_FILE = 'data/currencies.json';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = database_path(self::PATH_TO_JSON_FILE);

        if (file_exists($jsonFile)) {
            $jsonContent = file_get_contents($jsonFile);
            $currencies = json_decode($jsonContent, true);
            foreach ($currencies as $currencyData) {
                Currency::firstOrCreate([
                    'name' => $currencyData['name'],
                    'code' => $currencyData['code'],
                    'symbol_native' => $currencyData['symbol']
                ]);
            }

            $this->command->info('  Currencies seeded successfully.');
        } else {
            $this->command->error('  JSON file not found.');
        }
    }
}
