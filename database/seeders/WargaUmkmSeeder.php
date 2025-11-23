<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WargaUmkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Locale Indonesia

        // ----------------------
        // Generate 100 Warga
        // ----------------------
        $wargaIds = []; 

        for ($i = 1; $i <= 100; $i++) {
            $id = DB::table('warga')->insertGetId([
                'no_ktp'        => $faker->unique()->numerify('################'), // 16 digit
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
                'pekerjaan'     => $faker->randomElement(['Petani', 'Guru', 'Pegawai Negeri', 'Wiraswasta', 'Mahasiswa', 'Perawat', 'Nelayan', 'Sopir']),
                'telp'          => $faker->phoneNumber,
                'email'         => $faker->unique()->safeEmail,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            $wargaIds[] = $id;
        }

        // ----------------------
        // Generate 100 UMKM
        // ----------------------
        $kategori = ['Kuliner', 'Sembako', 'Jasa', 'Fashion', 'Kerajinan', 'Percetakan', 'Elektronik', 'Pertanian'];

        for ($i = 1; $i <= 100; $i++) {
            DB::table('umkm')->insert([
                'nama_usaha'       => $faker->company,
                'pemilik_warga_id' => $faker->randomElement($wargaIds), // ambil ID warga random
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
