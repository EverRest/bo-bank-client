<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = Config::get('admin.email');
        if(User::where(['email' => $email])->count() === 0) {
            $user = User::firstOrCreate(
                [
                    'name' => Config::get('admin.name'),
                    'email' => $email,
                    'password' => Hash::make(Config::get('admin.password'))
                ]
            );
            $this->command->info('  Admin user seeded successfully.');
        } else {
            $this->command->error('  I can\'t find or generate admin user. Please check maybe user is already exists.');
        }
    }
}
