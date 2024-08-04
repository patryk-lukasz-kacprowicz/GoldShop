<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::query()
            ->create([
                'name' => 'Administrator'
            ]);

        $permission = Permission::query()
            ->create([
                'name' => 'administrator'
            ]);

        $role->givePermissionTo($permission);

        $user = User::query()
            ->create([
                'name' => 'Administrator',
                'email' => 'admin@goldshop.com',
                'password' => Hash::make('password'),
            ]);
        $user->assignRole($role);
    }
}
