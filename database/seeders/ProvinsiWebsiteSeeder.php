<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinsiWebsiteSeeder extends Seeder
{
    /**
     * Mengisi kolom website dengan URL resmi pemerintah provinsi.
     * Sumber: portal resmi masing-masing provinsi.
     */
    public function run(): void
    {
        $websites = [
            'Aceh'                   => 'https://www.acehprov.go.id',
            'Sumatera Utara'         => 'https://www.sumutprov.go.id',
            'Sumatera Barat'         => 'https://www.sumbarprov.go.id',
            'Riau'                   => 'https://www.riau.go.id',
            'Kepulauan Riau'         => 'https://www.kepriprov.go.id',
            'Jambi'                  => 'https://www.jambiprov.go.id',
            'Bengkulu'               => 'https://www.bengkuluprov.go.id',
            'Sumatera Selatan'       => 'https://www.sumselprov.go.id',
            'Bangka Belitung'        => 'https://www.babelprov.go.id',
            'Lampung'                => 'https://www.lampungprov.go.id',
            'Banten'                 => 'https://www.bantenprov.go.id',
            'DKI Jakarta'            => 'https://www.jakarta.go.id',
            'Jawa Barat'             => 'https://www.jabarprov.go.id',
            'Jawa Tengah'            => 'https://www.jatengprov.go.id',
            'DI Yogyakarta'          => 'https://www.jogjaprov.go.id',
            'Jawa Timur'             => 'https://www.jatimprov.go.id',
            'Bali'                   => 'https://www.baliprov.go.id',
            'Nusa Tenggara Barat'    => 'https://www.ntbprov.go.id',
            'Nusa Tenggara Timur'    => 'https://www.nttprov.go.id',
            'Kalimantan Barat'       => 'https://www.kalbarprov.go.id',
            'Kalimantan Tengah'      => 'https://www.kaltengprov.go.id',
            'Kalimantan Selatan'     => 'https://www.kalselprov.go.id',
            'Kalimantan Timur'       => 'https://www.kaltimprov.go.id',
            'Kalimantan Utara'       => 'https://www.kaltaraprov.go.id',
            'Sulawesi Utara'         => 'https://www.sulutprov.go.id',
            'Gorontalo'              => 'https://www.gorontaloprov.go.id',
            'Sulawesi Tengah'        => 'https://www.sultengprov.go.id',
            'Sulawesi Barat'         => 'https://www.sulbarprov.go.id',
            'Sulawesi Selatan'       => 'https://www.sulselprov.go.id',
            'Sulawesi Tenggara'      => 'https://www.sultraprov.go.id',
            'Maluku'                 => 'https://www.malukuprov.go.id',
            'Maluku Utara'           => 'https://www.malutprov.go.id',
            'Papua Barat'            => 'https://www.papuabaratprov.go.id',
            'Papua Barat Daya'       => 'https://www.papuabaratdayaprov.go.id',
            'Papua Tengah'           => 'https://www.papuatengahprov.go.id',
            'Papua Pegunungan'       => 'https://www.papuapegununganprov.go.id',
            'Papua Selatan'          => 'https://www.papuaselatanprov.go.id',
            'Papua'                  => 'https://www.papuaprov.go.id',
        ];

        foreach ($websites as $nama => $url) {
            DB::table('provinsi')
                ->where('nama', $nama)
                ->update(['website' => $url]);
        }

        $this->command->info('Website URL provinsi berhasil diisi: ' . count($websites) . ' provinsi.');
    }
}
