<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $managerRole = Role::where('slug', 'manager')->first();
        $regularUserRole = Role::where('slug', 'regular_user')->first();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager1@example.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
        ]);

        User::create([
            'name' => 'Regular User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'role_id' => $regularUserRole->id,
        ]);

        User::create([
            'name' => 'Regular User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'role_id' => $regularUserRole->id,
        ]);

        User::create([
            'name' => 'Regular User 3',
            'email' => 'user3@example.com',
            'password' => Hash::make('password'),
            'role_id' => $regularUserRole->id,
        ]);
    }
}
