<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Locale Indonesia

        $kategori = [
            'Kuliner',
            'Sembako',
            'Jasa',
            'Fashion',
            'Kerajinan',
            'Percetakan',
            'Elektronik',
            'Pertanian',
        ];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('umkm')->insert([
                'nama_usaha'       => $faker->company,
                'pemilik_warga_id' => $faker->numberBetween(1, 10), // pastikan sudah ada di tabel warga
                'alamat'           => $faker->address,
                'rt'               => str_pad($faker->numberBetween(1, 9), 2, '0', STR_PAD_LEFT),
                'rw'               => str_pad($faker->numberBetween(1, 9), 2, '0', STR_PAD_LEFT),
                'kategori'         => $kategori[array_rand($kategori)],
                'kontak'           => "08" . $faker->randomNumber(9, true),
                'deskripsi'        => $faker->sentence(10),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
