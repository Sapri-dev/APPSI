<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengurus;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dewan Pengurus APPSI Masa Bakti 2025–2029
        $pengurus = [
            ['nama' => "Dr. H. Rudy Mas'ud, SE., ME.", 'jabatan' => 'Ketua Umum', 'jenis' => 'pengurus', 'provinsi' => 'Kalimantan Timur', 'foto' => 'pengurus/kaltim.jpg', 'urutan' => 1],
            ['nama' => 'Hj. Khofifah Indar Parawansa, M.Si', 'jabatan' => 'Wakil Ketua Umum', 'jenis' => 'pengurus', 'provinsi' => 'Jawa Timur', 'foto' => 'pengurus/khofifah-1.jpg', 'urutan' => 2],
            ['nama' => 'Hendrik Lewerissa, SH., LL.M', 'jabatan' => 'Sekretaris Jenderal', 'jenis' => 'pengurus', 'provinsi' => 'Maluku', 'foto' => 'pengurus/gub-maluku-681x1024-1.jpg', 'urutan' => 3],
            ['nama' => 'Mayjen TNI (Purn) Yulius Selvanus', 'jabatan' => 'Ketua I', 'jenis' => 'pengurus', 'provinsi' => 'Sulawesi Utara', 'foto' => 'pengurus/gub_sulut_8ae464daeb.jpg', 'urutan' => 4],
            ['nama' => 'Rahmat Mirzani Djausal, ST., MM.', 'jabatan' => 'Ketua II', 'jenis' => 'pengurus', 'provinsi' => 'Lampung', 'foto' => 'pengurus/Rahmat_Mirzani_Djausal_Gubernur_Lampung_2025-1.jpg', 'urutan' => 5],
            ['nama' => 'H. Ansar Ahmad, SE., MM.', 'jabatan' => 'Ketua III', 'jenis' => 'pengurus', 'provinsi' => 'Kepulauan Riau', 'foto' => 'pengurus/kepri.jpg', 'urutan' => 6],
            ['nama' => 'Sherly Tjoanda', 'jabatan' => 'Bendahara', 'jenis' => 'pengurus', 'provinsi' => 'Maluku Utara', 'foto' => 'pengurus/sherly.jpg', 'urutan' => 7],
            ['nama' => 'Dr. Hj. Ria Norsan, M.M., M.H.', 'jabatan' => 'Wakil Bendahara', 'jenis' => 'pengurus', 'provinsi' => 'Kalimantan Barat', 'foto' => 'pengurus/ria.jpg', 'urutan' => 8],
            ['nama' => 'Dr. H. Herman Deru', 'jabatan' => 'Koordinator Wilayah Sumatera', 'jenis' => 'pengurus', 'provinsi' => 'Sumatera Selatan', 'foto' => 'pengurus/herman_deru.jpg', 'urutan' => 9],
            ['nama' => 'H. Dedi Mulyadi, SH.', 'jabatan' => 'Koordinator Wilayah Jawa', 'jenis' => 'pengurus', 'provinsi' => 'Jawa Barat', 'foto' => 'pengurus/dedi.jpg', 'urutan' => 10],
            ['nama' => 'Dr. H. Lalu Muhamad Iqbal, S.IP., M.Hub.Int.', 'jabatan' => 'Koordinator Wilayah Bali, NTB, dan NTT', 'jenis' => 'pengurus', 'provinsi' => 'Nusa Tenggara Barat', 'foto' => 'pengurus/lalu.jpg', 'urutan' => 11],
            ['nama' => 'Brigjen Pol (Purn) Drs. Zainal Arifin Paliwang, SH., M.Hum', 'jabatan' => 'Koordinator Wilayah Kalimantan', 'jenis' => 'pengurus', 'provinsi' => 'Kalimantan Utara', 'foto' => 'pengurus/Gubernur_Kaltara_Zainal_Arifin_Paliwang.jpg', 'urutan' => 12],
            ['nama' => 'Dr. H. Anwar Hafid, M.Si', 'jabatan' => 'Koordinator Wilayah Sulawesi', 'jenis' => 'pengurus', 'provinsi' => 'Sulawesi Tengah', 'foto' => 'pengurus/Anwar_Hafid_Portrait_Governor_of_Central_Sulawesi.jpg', 'urutan' => 13],
            ['nama' => 'Meki Fritz Nawifa, SH.', 'jabatan' => 'Koordinator Wilayah Indonesia Timur', 'jenis' => 'pengurus', 'provinsi' => 'Papua Tengah', 'foto' => 'pengurus/meki_nawipa.jpg', 'urutan' => 14],
        ];

        // 2. Dewan Penasehat APPSI Masa Bakti 2025–2029
        $penasehat = [
            ['nama' => 'Sri Sultan Hamengku Buwono X', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Daerah Istimewa Yogyakarta', 'foto' => 'pengurus/penasehat_sri-sultan-hamengkubuwono-x.jpg', 'urutan' => 1],
            ['nama' => 'Dr. Ir. Pramono Anung, MM.', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Daerah Khusus Jakarta', 'foto' => 'pengurus/penasehat_pramono-anung.jpg', 'urutan' => 2],
            ['nama' => 'H. Mahyeldi Ansharullah, S.P', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Sumatera Barat', 'foto' => 'pengurus/penasehat_mahyeldi-ansharullah.jpg', 'urutan' => 3],
            ['nama' => 'H. Muzakir Manaf', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Aceh', 'foto' => 'pengurus/penasehat_muzakir-manaf.jpg', 'urutan' => 4],
            ['nama' => 'Dr. John Tabo, SE., MBA.', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Papua Pegunungan', 'foto' => 'pengurus/penasehat_john-tabo.jpg', 'urutan' => 5],
            ['nama' => 'E. Melkiades Laka Lena, S.Si', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Nusa Tenggara Timur', 'foto' => 'pengurus/Gubernur_Melki_Laka_Lena.jpg', 'urutan' => 6],
            ['nama' => 'Ahmad Luthfi, SH., S.St., M.K.', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Jawa Tengah', 'foto' => 'pengurus/penasehat_ahmad-luthfi.jpg', 'urutan' => 7],
            ['nama' => 'M. Bobby Afif Nasution, SE., MM.', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Sumatera Utara', 'foto' => 'pengurus/penasehat_bobby-nasution.jpg', 'urutan' => 8],
            ['nama' => 'Andra Soni, S.M., M.AP', 'jabatan' => 'Anggota Dewan Penasehat', 'jenis' => 'penasehat', 'provinsi' => 'Banten', 'foto' => 'pengurus/penasehat_andra-soni.jpg', 'urutan' => 9],
        ];

        // 3. Dewan Pakar APPSI Masa Bakti 2025–2029
        $pakar = [
            ['nama' => 'Prof. M. Ryaas Rasyid, MA, Ph.D', 'jabatan' => 'Ketua Dewan Pakar', 'jenis' => 'pakar', 'provinsi' => null, 'foto' => 'pengurus/pakar_prof-m-ryaas-rasyid-ma-phd.jpg', 'urutan' => 1],
            ['nama' => 'Prof. Muchlis Hamdi, MPA, Ph.D', 'jabatan' => 'Anggota Dewan Pakar', 'jenis' => 'pakar', 'provinsi' => null, 'foto' => 'pengurus/pakar_prof-muchlis-hamdi-mpa-phd.jpg', 'urutan' => 2],
            ['nama' => 'Dr. Aviliani', 'jabatan' => 'Anggota Dewan Pakar', 'jenis' => 'pakar', 'provinsi' => null, 'foto' => 'pengurus/pakar_dr-aviliani.jpg', 'urutan' => 3],
            ['nama' => 'Dr. Rudi Rohi', 'jabatan' => 'Anggota Dewan Pakar', 'jenis' => 'pakar', 'provinsi' => null, 'foto' => 'pengurus/pakar_dr-rudi-rohi.jpg', 'urutan' => 4],
            ['nama' => 'Dr. Megandaru W. Kawuryan, S.IP., M.Si.', 'jabatan' => 'Anggota Dewan Pakar', 'jenis' => 'pakar', 'provinsi' => null, 'foto' => 'pengurus/megandaru.jpg', 'urutan' => 5],
        ];

        // 4. Sekretariat APPSI
        $sekretariat = [
            ['nama' => 'Dr. Hj. Ismiati, M.Si', 'jabatan' => 'Direktur Eksekutif', 'jenis' => 'sekretariat', 'provinsi' => null, 'foto' => 'pengurus/sekretariat_dr-hj-ismiati-msi.jpg', 'urutan' => 1],
            ['nama' => 'Cecep M. A. Hidayat', 'jabatan' => 'Kepala Bagian Program & Kerjasama', 'jenis' => 'sekretariat', 'provinsi' => null, 'foto' => 'pengurus/sekretariat_cecep-m-a-hidayat.jpg', 'urutan' => 2],
            ['nama' => 'Sumiati', 'jabatan' => 'Kepala Bagian Keuangan & Administrasi', 'jenis' => 'sekretariat', 'provinsi' => null, 'foto' => 'pengurus/sekretariat_sumiati.jpg', 'urutan' => 3],
            ['nama' => 'Agra Pramaditha', 'jabatan' => 'Staf Divisi Hubungan Masyarakat & Publikasi', 'jenis' => 'sekretariat', 'provinsi' => null, 'foto' => 'pengurus/sekretariat_agra-pramaditha.jpg', 'urutan' => 4],
            ['nama' => 'Nila', 'jabatan' => 'Staf Administrasi & Logistik', 'jenis' => 'sekretariat', 'provinsi' => null, 'foto' => 'pengurus/sekretariat_nila.jpg', 'urutan' => 5],
        ];

        $semua = array_merge($pengurus, $penasehat, $pakar, $sekretariat);

        // Hapus data lama agar sinkron
        Pengurus::truncate();

        foreach ($semua as $data) {
            Pengurus::create(
                array_merge($data, ['periode' => '2025-2029', 'is_active' => true])
            );
        }
    }
}
