<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use Illuminate\Support\Facades\Schema;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        Account::truncate();
        Schema::enableForeignKeyConstraints();

        $accounts = [
            ['5.1.01.01.01.0001', 'Belanja Gaji Pokok PNS'],
            ['5.1.01.01.01.0002', 'Belanja Gaji Pokok PPPK'],
            ['5.1.01.01.02.0001', 'Belanja Tunjangan Keluarga PNS'],
            ['5.1.01.01.02.0002', 'Belanja Tunjangan Keluarga PPPK'],
            ['5.1.01.01.03.0001', 'Belanja Tunjangan Jabatan PNS'],
            ['5.1.01.01.04.0001', 'Belanja Tunjangan Fungsional PNS'],
            ['5.1.01.01.04.0002', 'Belanja Tunjangan Fungsional PPPK'],
            ['5.1.01.01.05.0001', 'Belanja Tunjangan Fungsional Umum PNS'],
            ['5.1.01.01.05.0002', 'Belanja Tunjangan Fungsional Umum PPPK'],
            ['5.1.01.01.06.0001', 'Belanja Tunjangan Beras PNS'],
            ['5.1.01.01.06.0002', 'Belanja Tunjangan Beras PPPK'],
            ['5.1.01.01.07.0001', 'Belanja Tunjangan PPh/Tunjangan Khusus PNS'],
            ['5.1.01.01.08.0001', 'Belanja Pembulatan Gaji PNS'],
            ['5.1.01.01.08.0002', 'Belanja Pembulatan Gaji PPPK'],
            ['5.1.01.01.09.0001', 'Belanja Iuran Jaminan Kesehatan PNS'],
            ['5.1.01.01.09.0002', 'Belanja Iuran Jaminan Kesehatan PPPK'],
            ['5.1.01.01.10.0001', 'Belanja Iuran Jaminan Kecelakaan Kerja PNS'],
            ['5.1.01.01.10.0002', 'Belanja Iuran Jaminan Kecelakaan Kerja PPPK'],
            ['5.1.01.01.11.0001', 'Belanja Iuran Jaminan Kematian PNS'],
            ['5.1.01.01.11.0002', 'Belanja Iuran Jaminan Kematian PPPK'],
            ['5.1.01.01.12.0001', 'Belanja Iuran Simpanan Peserta Tabungan Perumahan Rakyat PNS'],
            ['5.1.01.01.12.0002', 'Belanja Iuran Simpanan Peserta Tabungan Perumahan Rakyat PPPK'],
            ['5.1.01.02.01.0001', 'Tambahan Penghasilan berdasarkan Beban Kerja PNS'],
            ['5.1.01.02.01.0002', 'Tambahan Penghasilan berdasarkan Beban Kerja PPPK'],
            ['5.1.01.02.05.0001', 'Tambahan Penghasilan berdasarkan Prestasi Kerja PNS'],
            ['5.1.01.02.05.0002', 'Tambahan Penghasilan berdasarkan Prestasi Kerja PPPK'],
            ['5.1.01.03.07.0002', 'Belanja Honorarium Pengadaan Barang/Jasa'],
            ['5.1.02.01.01.0001', 'Belanja Bahan-Bahan Bangunan dan Konstruksi'],
            ['5.1.02.01.01.0004', 'Belanja Bahan-Bahan Bakar dan Pelumas'],
            ['5.1.02.01.01.0005', 'Belanja Bahan - Bahan Baku'],
            ['5.1.02.01.01.0009', 'Belanja Bahan Isi Tabung Pemadam Kebakaran'],
            ['5.1.02.01.01.0013', 'Belanja Suku Cadang-Suku Cadang Alat Angkutan'],
            ['5.1.02.01.01.0024', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor'],
            ['5.1.02.01.01.0025', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover'],
            ['5.1.02.01.01.0026', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Bahan Cetak'],
            ['5.1.02.01.01.0027', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Benda Pos'],
            ['5.1.02.01.01.0028', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Persediaan Dokumen/Administrasi Tender'],
            ['5.1.02.01.01.0029', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer'],
            ['5.1.02.01.01.0030', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perabot Kantor'],
            ['5.1.02.01.01.0031', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Listrik'],
            ['5.1.02.01.01.0043', 'Belanja Natura dan Pakan-Natura'],
            ['5.1.02.01.01.0052', 'Belanja Makanan dan Minuman Rapat'],
            ['5.1.02.02.01.0003', 'Honorarium Narasumber atau Pembahas, Moderator, Pembawa Acara, dan Panitia'],
            ['5.1.02.02.01.0004', 'Honorarium Tim Pelaksana Kegiatan dan Sekretariat Tim Pelaksana Kegiatan'],
            ['5.1.02.02.01.0016', 'Belanja Jasa Tenaga Penanganan Prasarana dan Sarana Umum'],
            ['5.1.02.02.01.0028', 'Belanja Jasa Tenaga Pelayanan Umum'],
            ['5.1.02.02.01.0032', 'Belanja Jasa Tenaga Caraka'],
            ['5.1.02.02.01.0036', 'Belanja Jasa Audit/Surveillance ISO'],
            ['5.1.02.02.01.0039', 'Belanja Jasa Tenaga Informasi dan Teknologi'],
            ['5.1.02.02.01.0041', 'Belanja Jasa Pemasangan Instalasi Telepon, Air dan Listrik'],
            ['5.1.02.02.01.0047', 'Belanja Jasa Penyelenggaraan Acara'],
            ['5.1.02.02.01.0051', 'Belanja Jasa Pengolahan Sampah'],
            ['5.1.02.02.01.0055', 'Belanja Jasa Iklan/Reklame, Film, dan Pemotretan'],
            ['5.1.02.02.01.0059', 'Belanja Tagihan Telepon'],
            ['5.1.02.02.01.0060', 'Belanja Tagihan Air'],
            ['5.1.02.02.01.0061', 'Belanja Tagihan Listrik'],
            ['5.1.02.02.01.0062', 'Belanja Langganan Jurnal/Surat Kabar/Majalah'],
            ['5.1.02.02.01.0063', 'Belanja Kawat/Faksimili/Internet/TV Berlangganan'],
            ['5.1.02.02.01.0064', 'Belanja Paket/Pengiriman'],
            ['5.1.02.02.01.0067', 'Belanja Pembayaran Pajak, Bea, dan Perizinan'],
            ['5.1.02.02.01.0080', 'Belanja Honorarium Penanggungjawaban Pengelola Keuangan'],
            ['5.1.02.02.01.0081', 'Belanja Honorarium Pengadaan Barang/Jasa'],
            ['5.1.02.02.01.0087', 'Belanja Jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada Jabatan Pengelola Umum Operasional'],
            ['5.1.02.02.01.0088', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan operator layanan operasional'],
            ['5.1.02.02.01.0089', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan pengelola layanan operasional'],
            ['5.1.02.02.01.0090', 'Belanja jasa Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) Paruh Waktu pada jabatan penata layanan operasional'],
            ['5.1.02.02.02.0005', 'Belanja Iuran Jaminan Kesehatan bagi Non ASN'],
            ['5.1.02.02.02.0006', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi Non ASN'],
            ['5.1.02.02.02.0007', 'Belanja Iuran Jaminan Kematian bagi Non ASN'],
            ['5.1.02.02.02.0010', 'Belanja Iuran Jaminan Hari Tua bagi Non ASN'],
            ['5.1.02.02.02.0018', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional'],
            ['5.1.02.02.02.0019', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional'],
            ['5.1.02.02.02.0020', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional'],
            ['5.1.02.02.02.0021', 'Belanja Iuran Jaminan Kesehatan bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional'],
            ['5.1.02.02.02.0026', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional'],
            ['5.1.02.02.02.0027', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional'],
            ['5.1.02.02.02.0028', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional'],
            ['5.1.02.02.02.0029', 'Belanja Iuran Jaminan Kecelakaan Kerja bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional'],
            ['5.1.02.02.02.0034', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Pengelola Umum Operasional'],
            ['5.1.02.02.02.0035', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Operator Layanan Operasional'],
            ['5.1.02.02.02.0036', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Pengelola Layanan Operasional'],
            ['5.1.02.02.02.0037', 'Belanja Iuran Jaminan Kematian bagi PPPK Paruh Waktu pada Jabatan Penata Layanan Operasional'],
            ['5.1.02.02.02.0081', 'Belanja Honorarium Pengadaan Barang/Jasa'],
            ['5.1.02.02.09.0013', 'Belanja Jasa Konsultansi Berorientasi Layanan-Jasa Konsultansi Manajemen'],
            ['5.1.02.02.12.0002', 'Belanja Sosialisasi'],
            ['5.1.02.02.12.0003', 'Belanja Bimbingan Teknis'],
            ['5.1.02.03.02.0022', 'Belanja Pemeliharaan Alat Besar-Alat Bantu-Electric Generating Set'],
            ['5.1.02.03.02.0038', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Beroda Dua'],
            ['5.1.02.03.02.0040', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Khusus'],
            ['5.1.02.03.02.0121', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pendingin'],
            ['5.1.02.03.02.0123', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Rumah Tangga Lainnya (Home Use)'],
            ['5.1.02.03.02.0405', 'Belanja Pemeliharaan Komputer-Komputer Unit-Personal Computer'],
            ['5.1.02.03.02.0410', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Jaringan'],
            ['5.1.02.03.02.0411', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Komputer Lainnya'],
            ['5.1.02.03.03.0001', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Kantor'],
            ['5.1.02.04.01.0001', 'Belanja Perjalanan Dinas Biasa'],
            ['5.1.02.04.01.0003', 'Belanja Perjalanan Dinas Dalam Kota'],
            ['5.1.02.04.01.0004', 'Belanja Perjalanan Dinas Paket Meeting Dalam Kota'],
            ['5.2.02.05.01.0005', 'Belanja Modal Alat Kantor Lainnya'],
            ['5.2.02.05.02.0001', 'Belanja Modal Mebel'],
            ['5.2.02.05.02.0004', 'Belanja Modal Alat Pendingin'],
            ['5.2.02.05.02.0005', 'Belanja Modal Alat Dapur'],
            ['5.2.02.05.02.0006', 'Belanja Modal Alat Rumah Tangga Lainnya (Home Use)'],
            ['5.2.02.05.02.0007', 'Belanja Modal Alat Pemadam Kebakaran'],
            ['5.2.02.10.01.0002', 'Belanja Modal Personal Computer'],
            ['5.2.02.10.01.0003', 'Belanja Modal Komputer Unit Lainnya'],
            ['5.2.02.10.02.0004', 'Belanja Modal Peralatan Jaringan'],
        ];

        foreach ($accounts as $account) {
            Account::create([
                'tahun' => session('tahun_anggaran', date('Y')),
                'kode_rekening' => $account[0],
                'nama_rekening' => $account[1],
                'kelompok' => 'belanja'
            ]);
        }

    }
}
