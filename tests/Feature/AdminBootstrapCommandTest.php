<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBootstrapCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_bootstrap_admin_command_creates_admin_account(): void
    {
        $this->artisan('app:bootstrap-admin', [
            '--name' => 'Admin User',
            '--email' => 'admin@spellenchantment.com',
            '--password' => 'Admin@1234',
        ])
            ->expectsOutputToContain('Admin account created successfully')
            ->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'email' => 'admin@spellenchantment.com',
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
