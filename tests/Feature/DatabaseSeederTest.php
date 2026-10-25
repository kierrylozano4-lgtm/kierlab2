<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_running_the_database_seeder_repeatedly_creates_fifty_demo_services_without_duplicates(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'full_name' => 'Test User',
        ]);
        $this->assertDatabaseCount('services', 50);
        $this->assertDatabaseHas('services', [
            'title' => 'Calculus tutoring',
            'category' => 'Academic',
            'status' => 'Active',
            'visible_in_dashboard' => true,
        ]);
    }
}
