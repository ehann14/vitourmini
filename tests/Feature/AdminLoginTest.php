<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_with_username(): void
    {
        $user = User::factory()->create([
            'username' => 'admin-test',
            'password' => 'secret-password',
        ]);

        $response = $this->post(route('admin.login.post'), [
            'username' => 'admin-test',
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }
}
