<?php
declare(strict_types=1);

namespace Database\Factories;

use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'balance' => $this->faker->randomFloat(2, 1, 100000),
            'user_id' => User::all()->shuffle()->first(),
            'currency_id' => Currency::all()->shuffle()->first(),
        ];
    }
}
