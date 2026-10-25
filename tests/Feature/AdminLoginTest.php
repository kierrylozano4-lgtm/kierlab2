<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_and_open_the_dashboard(): void
    {
        $password = 'campus-test-password';
        $admin = User::factory()->create([
            'email' => 'admin@example.test',
            'password' => $password,
            'is_admin' => true,
        ]);

        $this->get(route('login'))
            ->assertOk();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => $password,
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);

        $this->get(route('dashboard'))
            ->assertOk();
    }

    public function test_invalid_admin_credentials_are_rejected(): void
    {
        $password = 'campus-test-password';

        User::factory()->create([
            'email' => 'admin@example.test',
            'password' => $password,
            'is_admin' => true,
        ]);

        $this->from(route('login'))
            ->post('/login', [
                'email' => 'admin@example.test',
                'password' => 'incorrect-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
