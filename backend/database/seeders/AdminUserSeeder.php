<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@tagumtourism.test';

        if (User::where('email', $email)->exists()) {
            $this->command->info('Admin already exists, nothing changed.');
            return;
        }

        $password = Str::random(16);

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->command->warn("Admin email: {$email}");
        $this->command->warn("Admin password: {$password}");
    }
}