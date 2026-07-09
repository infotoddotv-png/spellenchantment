<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class BootstrapAdminCommand extends Command
{
    protected $signature = 'app:bootstrap-admin {--name=Admin User} {--email=admin@spellenchantment.com} {--password=Admin@1234}';

    protected $description = 'Run migrations and create the first admin account';

    public function handle(): int
    {
        $this->call('migrate', ['--force' => true]);
        $this->info('Database migration completed successfully.');

        $user = User::where('email', $this->option('email'))->first();

        if (! $user) {
            User::create([
                'name' => $this->option('name'),
                'email' => $this->option('email'),
                'password' => Hash::make($this->option('password')),
                'role' => 'admin',
                'status' => 'active',
            ]);
        } else {
            $user->forceFill([
                'name' => $this->option('name'),
                'password' => Hash::make($this->option('password')),
                'role' => 'admin',
                'status' => 'active',
            ])->save();
        }

        $this->info('Admin account created successfully.');
        $this->info('Email: ' . $this->option('email'));
        $this->info('Password: ' . $this->option('password'));

        return self::SUCCESS;
    }
}
