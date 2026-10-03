<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 3 Role utama Stockify
        $adminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manajer Gudang']);
        $staffRole = Role::create(['name' => 'Staff Gudang']);

        // 2. Akun Admin
        $admin = User::create([
            'name' => 'Admin Stockify',
            'email' => 'admin@stockify.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole($adminRole);

        // 3. Akun Manajer Gudang
        $manager = User::create([
            'name' => 'Manajer Gudang',
            'email' => 'manager@stockify.com',
            'password' => Hash::make('password123'),
        ]);
        $manager->assignRole($managerRole);

        // 4. Akun Staff Gudang
        $staff = User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@stockify.com',
            'password' => Hash::make('password123'),
        ]);
        $staff->assignRole($staffRole);
    }
}
