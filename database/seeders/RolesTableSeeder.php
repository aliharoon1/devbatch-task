<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => ['manage_users' => true, 'delete_users' => true],
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'permissions' => ['manage_users' => true, 'delete_users' => true],
            ],
            [
                'name' => 'Regular User',
                'slug' => 'regular_user',
                'permissions' => ['update_profile' => true],
            ],
        ];


        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'permissions' => json_encode($role['permissions']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
