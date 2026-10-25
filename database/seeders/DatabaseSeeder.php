<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'full_name' => 'Test User',
                'student_id' => 'TEST-ACCOUNT',
                'password' => 'password',
            ]
        );

        User::query()->firstOrCreate(
            ['email' => config('services.internal_api.user_email')],
            [
                'full_name' => 'Service Account',
                'student_id' => 'SERVICE-ACCOUNT',
                'password' => 'password',
            ]
        );

        $this->call(MarketplaceServiceSeeder::class);
    }
}
