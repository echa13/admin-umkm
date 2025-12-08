<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // USER ASLI (TIDAK DIUBAH)
        User::create([
            'name'     => 'Admin',
            'email'    => 'echa@gmail.com',
            'password' => Hash::make('Admin123'),
            'role'     => 'admin',
        ]);

        // TAMBAHAN: 100 USER DUMMY INDONESIA
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'name'     => $faker->name(),
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make('Password123'),
                'role'     => 'user',
            ]);
        }
    }
}
