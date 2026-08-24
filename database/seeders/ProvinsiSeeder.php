<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provinsi;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $provinsi = [
            // Sumatera
            ['nama' => 'Aceh', 'ibu_kota' => 'Banda Aceh', 'pulau' => 'Sumatera', 'urutan' => 1],
            ['nama' => 'Sumatera Utara', 'ibu_kota' => 'Medan', 'pulau' => 'Sumatera', 'urutan' => 2],
            ['nama' => 'Sumatera Barat', 'ibu_kota' => 'Padang', 'pulau' => 'Sumatera', 'urutan' => 3],
            ['nama' => 'Riau', 'ibu_kota' => 'Pekanbaru', 'pulau' => 'Sumatera', 'urutan' => 4],
            ['nama' => 'Kepulauan Riau', 'ibu_kota' => 'Tanjung Pinang', 'pulau' => 'Sumatera', 'urutan' => 5],
            ['nama' => 'Jambi', 'ibu_kota' => 'Jambi', 'pulau' => 'Sumatera', 'urutan' => 6],
            ['nama' => 'Bengkulu', 'ibu_kota' => 'Bengkulu', 'pulau' => 'Sumatera', 'urutan' => 7],
            ['nama' => 'Sumatera Selatan', 'ibu_kota' => 'Palembang', 'pulau' => 'Sumatera', 'urutan' => 8],
            ['nama' => 'Kepulauan Bangka Belitung', 'ibu_kota' => 'Pangkal Pinang', 'pulau' => 'Sumatera', 'urutan' => 9],
            ['nama' => 'Lampung', 'ibu_kota' => 'Bandar Lampung', 'pulau' => 'Sumatera', 'urutan' => 10],
            // Jawa
            ['nama' => 'DKI Jakarta', 'ibu_kota' => 'Jakarta', 'pulau' => 'Jawa', 'urutan' => 11],
            ['nama' => 'Jawa Barat', 'ibu_kota' => 'Bandung', 'pulau' => 'Jawa', 'urutan' => 12],
            ['nama' => 'Banten', 'ibu_kota' => 'Serang', 'pulau' => 'Jawa', 'urutan' => 13],
            ['nama' => 'Jawa Tengah', 'ibu_kota' => 'Semarang', 'pulau' => 'Jawa', 'urutan' => 14],
            ['nama' => 'DI Yogyakarta', 'ibu_kota' => 'Yogyakarta', 'pulau' => 'Jawa', 'urutan' => 15],
            ['nama' => 'Jawa Timur', 'ibu_kota' => 'Surabaya', 'pulau' => 'Jawa', 'urutan' => 16],
            // Bali & Nusa Tenggara
            ['nama' => 'Bali', 'ibu_kota' => 'Denpasar', 'pulau' => 'Bali', 'urutan' => 17],
            ['nama' => 'Nusa Tenggara Barat', 'ibu_kota' => 'Mataram', 'pulau' => 'Nusa Tenggara', 'urutan' => 18],
            ['nama' => 'Nusa Tenggara Timur', 'ibu_kota' => 'Kupang', 'pulau' => 'Nusa Tenggara', 'urutan' => 19],
            // Kalimantan
            ['nama' => 'Kalimantan Barat', 'ibu_kota' => 'Pontianak', 'pulau' => 'Kalimantan', 'urutan' => 20],
            ['nama' => 'Kalimantan Tengah', 'ibu_kota' => 'Palangka Raya', 'pulau' => 'Kalimantan', 'urutan' => 21],
            ['nama' => 'Kalimantan Selatan', 'ibu_kota' => 'Banjarbaru', 'pulau' => 'Kalimantan', 'urutan' => 22],
            ['nama' => 'Kalimantan Timur', 'ibu_kota' => 'Samarinda', 'pulau' => 'Kalimantan', 'urutan' => 23],
            ['nama' => 'Kalimantan Utara', 'ibu_kota' => 'Tanjung Selor', 'pulau' => 'Kalimantan', 'urutan' => 24],
            // Sulawesi
            ['nama' => 'Sulawesi Utara', 'ibu_kota' => 'Manado', 'pulau' => 'Sulawesi', 'urutan' => 25],
            ['nama' => 'Gorontalo', 'ibu_kota' => 'Gorontalo', 'pulau' => 'Sulawesi', 'urutan' => 26],
            ['nama' => 'Sulawesi Tengah', 'ibu_kota' => 'Palu', 'pulau' => 'Sulawesi', 'urutan' => 27],
            ['nama' => 'Sulawesi Barat', 'ibu_kota' => 'Mamuju', 'pulau' => 'Sulawesi', 'urutan' => 28],
            ['nama' => 'Sulawesi Selatan', 'ibu_kota' => 'Makassar', 'pulau' => 'Sulawesi', 'urutan' => 29],
            ['nama' => 'Sulawesi Tenggara', 'ibu_kota' => 'Kendari', 'pulau' => 'Sulawesi', 'urutan' => 30],
            // Maluku
            ['nama' => 'Maluku', 'ibu_kota' => 'Ambon', 'pulau' => 'Maluku', 'urutan' => 31],
            ['nama' => 'Maluku Utara', 'ibu_kota' => 'Sofifi', 'pulau' => 'Maluku', 'urutan' => 32],
            // Papua
            ['nama' => 'Papua Barat Daya', 'ibu_kota' => 'Sorong', 'pulau' => 'Papua', 'urutan' => 33],
            ['nama' => 'Papua Barat', 'ibu_kota' => 'Manokwari', 'pulau' => 'Papua', 'urutan' => 34],
            ['nama' => 'Papua Tengah', 'ibu_kota' => 'Nabire', 'pulau' => 'Papua', 'urutan' => 35],
            ['nama' => 'Papua Pegunungan', 'ibu_kota' => 'Jayawijaya', 'pulau' => 'Papua', 'urutan' => 36],
            ['nama' => 'Papua Selatan', 'ibu_kota' => 'Merauke', 'pulau' => 'Papua', 'urutan' => 37],
            ['nama' => 'Papua', 'ibu_kota' => 'Jayapura', 'pulau' => 'Papua', 'urutan' => 38],
        ];

        foreach ($provinsi as $data) {
            Provinsi::updateOrCreate(['nama' => $data['nama']], $data);
        }
    }
}
