<?php
namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengaturan::create([
            'nama_aplikasi' => 'Sipkih',
            'deskripsi'     => 'Sistem Informasi pelayanan kartu ibu hamil',
            'logo'          => 'logo.png',
        ]);
    }
}
