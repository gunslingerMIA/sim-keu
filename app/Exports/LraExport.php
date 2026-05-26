<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LraExport implements FromCollection, WithStyles, WithColumnWidths
{
    protected $processedData, $endDate, $jenisLra, $tahun, $grandTotal;

    public function __construct($processedData, $endDate, $jenisLra, $tahun, $grandTotal)
    {
        $this->processedData = $processedData;
        $this->endDate = date('d/m/Y', strtotime($endDate));
        $this->jenisLra = $jenisLra;
        $this->tahun = $tahun;
        $this->grandTotal = $grandTotal;
    }

    public function collection()
    {
        $data = collect();

        // 1. Loop LEVEL 1: PROGRAM
        foreach ($this->processedData as $p) {
            $data->push([
                $p->kode_program,
                $p->nama_program,
                $p->total_pagu,
                $p->total_realisasi,
                $p->total_sisa,
                $p->total_persen / 100
            ]);

            // 2. Loop LEVEL 2: KEGIATAN
            foreach ($p->activities as $act) {
                $data->push([
                    $act->kode_kegiatan,
                    "  " . $act->nama_kegiatan,
                    $act->total_pagu,
                    $act->total_realisasi,
                    $act->total_sisa,
                    $act->total_persen / 100
                ]);

                // 3. Loop LEVEL 3: SUB-KEGIATAN
                foreach ($act->subActivities as $sub) {
                    $data->push([
                        $sub->kode_sub_kegiatan,
                        "    " . $sub->nama_sub_kegiatan,
                        $sub->total_pagu,
                        $sub->total_realisasi,
                        $sub->total_sisa,
                        $sub->total_persen / 100
                    ]);

                    // 4. Loop LEVEL 4: REKENING BELANJA
                    foreach ($sub->budgets as $b) {
                        $data->push([
                            $b->account->kode_rekening,
                            "      " . $b->account->nama_rekening,
                            $b->pagu_murni,
                            $b->realisasi,
                            $b->sisa,
                            $b->persen / 100
                        ]);

                        // 5. Loop LEVEL 5: DETAIL TRANSAKSI (JIKA PILIH RINCI)
                        if ($this->jenisLra == 'rinci') {
                            foreach ($b->transactions as $t) {
                                $data->push([
                                    date('d/m/Y', strtotime($t->tanggal)),
                                    "        [" . $t->nobukti . "] - " . $t->keterangan,
                                    0,
                                    $t->jumlah,
                                    0,
                                    0
                                ]);
                            }
                        }
                    }
                }
            }
        }

        // 6. Baris Akhir: GRAND TOTAL SKPD
        $data->push([
            '',
            'TOTAL',
            $this->grandTotal['pagu'],
            $this->grandTotal['realisasi'],
            $this->grandTotal['sisa'],
            $this->grandTotal['persen'] / 100
        ]);

        return $data;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        return [
            'KODE',
            'URAIAN PROGRAM / KEGIATAN / SUB-KEGIATAN / REKENING',
            'PAGU ANGGARAN',
            'REALISASI (DEBIT)',
            'SISA ANGGARAN',
            '%'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18,
            'B' => 60,
            'C' => 18,
            'D' => 18,
            'E' => 18,
            'F' => 10,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // 1. TULIS KOP JUDUL LAPORAN MANUAL DI BARIS 1 - 3
        $sheet->setCellValue('A1', 'LAPORAN REALISASI ANGGARAN BELANJA');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'DPMPTSP KOTA PEKALONGAN');
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setSize(12)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', "Tahun Anggaran: {$this->tahun} | Posisi s.d Tanggal: {$this->endDate}");
        $sheet->mergeCells('A3:F3');
        $sheet->getStyle('A3')->getFont()->setSize(10)->setItalic(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Baris 4 dikosongkan untuk jarak/spacer antara KOP dan Tabel

        // 2. PENGUNCIAN WRAP TEXT & STYLING HEADER TABEL (BARIS 5)
        $sheet->getRowDimension(5)->setRowHeight(30);
        $sheet->getStyle('A5:F5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:F5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2F4F4F');
        $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A5:F5')->getAlignment()->setWrapText(true);

        // 3. LOOP UNTUK MEMBEDAKAN STYLE PROGRAM, KEGIATAN, SUB-KEGIATAN, & REKENING
        for ($row = 6; $row <= $highestRow; $row++) {
            $kode = trim($sheet->getCell("A{$row}")->getValue());
            $uraian = $sheet->getCell("B{$row}")->getValue();

            // Hitung jumlah titik untuk mendeteksi tingkatan kode rekening
            $dotsCount = substr_count($kode, '.');

            if ($kode === 'TOTAL') {
                // BARIS GRAND TOTAL: Biru gelap, teks putih tebal
                $sheet->getStyle("A{$row}:F{$row}")->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
                $sheet->getStyle("A{$row}:F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1A365D');
                $sheet->getStyle("A{$row}:B{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            } elseif ($dotsCount === 2) {
                // LEVEL 1: PROGRAM (Bold, Warna Biru Navy Tua, Background Abu-abu Sedang)
                $sheet->getStyle("A{$row}:F{$row}")->getFont()->setBold(true)->getColor()->setRGB('002060');
                $sheet->getStyle("A{$row}:F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
            } elseif ($dotsCount === 3) {
                // LEVEL 2: KEGIATAN (Bold, Warna Hitam, Background Abu-abu Terang)
                $sheet->getStyle("A{$row}:F{$row}")->getFont()->setBold(true);
                $sheet->getStyle("A{$row}:F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F2F2F2');
            } elseif ($dotsCount === 5) {
                // LEVEL 3: SUB-KEGIATAN (Cetak Miring Lembut/Italic Bold, Tanpa Background)
                $sheet->getStyle("A{$row}:F{$row}")->getFont()->setBold(true)->setItalic(true);
            } elseif (str_starts_with(trim($uraian), '[')) {
                // LEVEL 5: DETAIL TRANSAKSI LRA RINCI (Teks Kecil Abu, Background Kuning Gading)
                $sheet->getStyle("A{$row}:F{$row}")->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('595959');
                $sheet->getStyle("A{$row}:F{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFDF0');
            } else {
                // LEVEL 4: REKENING BELANJA MURNI (Normal, Teks Biru Standar Keuangan)
                // KODE YANG BENAR DAN AMAN
                $sheet->getStyle("B{$row}")->getFont()->getColor()->setRGB('0070C0');
            }

            // Atur posisi teks vertikal agar selalu rapi di atas sel jika uraian wrap memanjang
            $sheet->getStyle("A{$row}:F{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

            // Format nomor rupiah dan persentase untuk baris kuantitas
            $sheet->getStyle("C{$row}:E{$row}")->getNumberFormat()->setFormatCode('"Rp "#,##0;[Red]("-Rp "#,##0");"Rp 0"');
            $sheet->getStyle("F{$row}")->getNumberFormat()->setFormatCode('0.00%');
        }

        // 4. ATUR BORDER DAN ALIGNMENT KOLOM SECARA KESELURUHAN
        $sheet->getStyle("A5:F{$highestRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // POIN PERBAIKAN: Kolom Kode Rekening (Kolom A) dipaksa rata kiri (LEFT) semua, bukan center
        $sheet->getStyle("A6:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Kolom khusus persen tetap di tengah agar seimbang
        $sheet->getStyle("F6:F{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
