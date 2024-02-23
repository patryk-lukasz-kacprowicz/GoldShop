<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = User::factory()->create([
            'email' => 'admin@e-commerce.pl',
        ]);
        $administrator->assignRole(UserRoleEnum::Administrator);

        $client = User::factory()->create([
            'email' => 'client@e-commerce.pl',
        ]);
        $client->assignRole(UserRoleEnum::Client);
    }
}
