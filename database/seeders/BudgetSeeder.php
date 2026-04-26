<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Activity;
use App\Models\SubActivity;
use Illuminate\Support\Facades\Schema;

class BudgetSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        SubActivity::truncate();
        Activity::truncate();
        Program::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            // PROGRAM 2.18.01
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.01', 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah', '2.18.01.2.01.0001', 'Penyusunan Dokumen Perencanaan Perangkat Daerah'],
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.01', 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah', '2.18.01.2.01.0002', 'Koordinasi dan Penyusunan Dokumen RKA-SKPD'],
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.01', 'Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah', '2.18.01.2.01.0007', 'Evaluasi Kinerja Perangkat Daerah'],
            
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.02', 'Administrasi Keuangan Perangkat Daerah', '2.18.01.2.02.0001', 'Penyediaan Gaji dan Tunjangan ASN'],
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.02', 'Administrasi Keuangan Perangkat Daerah', '2.18.01.2.02.0003', 'Pelaksanaan Penatausahaan dan Pengujian/Verifikasi Keuangan SKPD'],
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.02', 'Administrasi Keuangan Perangkat Daerah', '2.18.01.2.02.0005', 'Koordinasi dan Penyusunan Laporan Keuangan Akhir Tahun SKPD'],
            
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.05', 'Administrasi Kepegawaian Perangkat Daerah', '2.18.01.2.05.0002', 'Pengadaan Pakaian Dinas beserta Atribut Kelengkapannya'],
            
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0001', 'Penyediaan Komponen Instalasi Listrik/Penerangan Bangunan Kantor'],
            ['2026', '2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0002', 'Penyediaan Peralatan dan Perlengkapan Kantor'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0003', 'Penyediaan Peralatan Rumah Tangga'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0004', 'Penyediaan Bahan Logistik Kantor'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0005', 'Penyediaan Barang Cetakan dan Penggandaan'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0006', 'Penyediaan Bahan Bacaan dan Peraturan Perundang-undangan'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN Pemerintahan DAERAH KABUPATEN/KOTA', '2.18.01.2.06', 'Administrasi Umum Perangkat Daerah', '2.18.01.2.06.0009', 'Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD'],
            
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.08', 'Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah', '2.18.01.2.08.0001', 'Penyediaan Jasa Surat Menyurat'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.08', 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik', '2.18.01.2.08.0002', 'Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.08', 'Penyediaan Jasa Pelayanan Umum Kantor', '2.18.01.2.08.0004', 'Penyediaan Jasa Pelayanan Umum Kantor'],
            
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.09', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah', '2.18.01.2.09.0001', 'Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, dan Pajak Kendaraan'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.09', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah', '2.18.01.2.09.0009', 'Pemeliharaan/Rehabilitasi Gedung Kantor'],
            ['2026','2.18.01', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '2.18.01.2.09', 'Pemeliharaan Barang Milik Daerah Penunjang Urusan Pemerintahan Daerah', '2.18.01.2.09.0010', 'Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung'],

            // PROGRAM 2.18.02
            ['2026','2.18.02', 'PROGRAM PENGEMBANGAN IKLIM PENANAMAN MODAL', '2.18.02.2.01', 'Penetapan Pemberian Fasilitas/Insentif', '2.18.02.2.01.0004', 'Rekomendasi kebijakan sektor usaha'],
            ['2026','2.18.02', 'PROGRAM PENGEMBANGAN IKLIM PENANAMAN MODAL', '2.18.02.2.02', 'Pembuatan Peta Potensi Investasi', '2.18.02.2.02.0004', 'Penyusunan Peta Potensi Investasi'],

            // PROGRAM 2.18.03 
            ['2026','2.18.03', 'PROGRAM PROMOSI PENANAMAN MODAL', '2.18.03.2.01', 'Penyelenggaraan Promosi Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2.18.03.2.01.0002', 'Pelaksanaan Kegiatan Promosi Penanaman Modal Daerah Kabupaten/Kota'],
            

            //PROGRAM 2.18.04
            ['2026','2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2.18.04.2.01.0005', 'Koordinasi dan Sinkronisasi Penetapan Pemberian Fasilitas/Insentif Daerah'], 
            ['2026','2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2.18.04.2.01.0006', 'KPenyediaan Pelayanan Perizinan Berusaha melalui Sistem Perizinan Berusaha Berbasis Risiko Terintegrasi secara Elektronik'], 
            ['2026','2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2.18.04.2.01.0007', 'Penyediaan dan pengelolaan Layanan konsultasi perizinan berusaha berbasis risiko'], 
            ['2026','2.18.04', 'PROGRAM PELAYANAN PENANAMAN MODAL', '2.18.04.2.01', 'Pelayanan Perizinan dan Non Perizinan Secara Terpadu Satu Pintu dibidang Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/ Kota', '2.18.04.2.01.0008', 'Pemantauan, analisis, evaluasi, dan pelaporan di bidang perizinan berusaha berbasis risiko'], 

            // PROGRAM 2.18.05
            ['2026','2.18.05', 'PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL', '2.18.05.2.01', 'Pengendalian Pelaksanaan Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2.18.05.2.01.0004', 'Penyelesaian Permasalahan dan Hambatan yang dihadapi Pelaku Usaha dalam merealisasikan Kegiatan Usahanya'],
            ['2026','2.18.05', 'PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL', '2.18.05.2.01', 'Pengendalian Pelaksanaan Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2.18.05.2.01.0005', 'Bimbingan Teknis kepada Pelaku Usaha'],
            ['2026','2.18.05', 'PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL', '2.18.05.2.01', 'Pengendalian Pelaksanaan Penanaman Modal yang Menjadi Kewenangan Daerah Kabupaten/Kota', '2.18.05.2.01.0006', 'Pengawasan Penanaman Modal'],
       
            // PROGRAM 2.18.06
            ['2026','2.18.06', 'PROGRAM PENGELOLAAN DATA DAN SISTEM INFORMASI PENANAMAN MODAL', '2.18.06.2.01', 'Pengelolaan Data dan Informasi Perizinan dan Non Perizinan yang Terintegrasi pada Tingkat Daerah Kabupaten/Kota', '2.18.06.2.01.0002', 'Pengolahan, Penyajian dan Pemanfaatan Data dan Informasi Perizinan Berbasis Sistem Pelayanan Perizinan Berusaha Terintegrasi secara Elektronik']

        ];

        foreach ($data as $item) {
            $program = Program::firstOrCreate(
                ['tahun' => $item[0], 'kode_program' => $item[1]],
                ['nama_program' => $item[2]]
            );

            $activity = Activity::firstOrCreate(
                ['tahun' => $item[0], 'kode_kegiatan' => $item[3], 'program_id' => $program->id],
                ['nama_kegiatan' => $item[4]]
               
            );

            SubActivity::create([
                'tahun' => $item[0],
                'kode_sub_kegiatan' => $item[5],
                'nama_sub_kegiatan' => $item[6],
                'activity_id' => $activity->id
            ]);
        }
    }
}