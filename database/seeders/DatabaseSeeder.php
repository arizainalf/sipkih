<?php
namespace Database\Seeders;

use App\Models\Pengaturan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama'     => 'Ari Zainal Fauziah',
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('123123123'),
        ]);
        Pengaturan::create([
            'nama_aplikasi' => 'Sipkih',
            'deskripsi'     => 'Sistem Informasi pelayanan kartu ibu hamil',
            'logo'          => 'logo.png',
        ]);
    }
}
