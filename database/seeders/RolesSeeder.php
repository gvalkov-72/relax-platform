<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        $admin = User::updateOrCreate(
            ['email' => 'gvalkov72@gmail.com'],
            [
                'name' => 'Georgi Valkov',
                'password' => Hash::make('881632')
            ]
        );

        $admin->assignRole($adminRole);
    }
}