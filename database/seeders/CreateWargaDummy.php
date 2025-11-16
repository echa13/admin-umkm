<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateWargaDummy extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // gunakan lokal Indonesia

        foreach (range(1, 20) as $index) {
            DB::table('warga')->insert([
                'no_ktp'        => $faker->unique()->numerify('############'), // 16 digit random
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan'     => $faker->randomElement(['Petani', 'Guru', 'Pegawai Negeri', 'Wiraswasta', 'Mahasiswa', 'Perawat', 'Nelayan', 'Sopir']),
                'telp'          => $faker->phoneNumber,
                'email'         => $faker->unique()->safeEmail,
            ]);
        }
    }
}
