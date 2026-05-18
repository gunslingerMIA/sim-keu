<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LedgerExport implements FromCollection, WithStyles, WithHeadings, WithColumnWidths
{
    protected $mutations, $saldoAwal, $start, $end, $accountName;

    public function __construct($mutations, $saldoAwal, $start, $end, $accountName)
    {
        $this->mutations = $mutations;
        $this->saldoAwal = $saldoAwal;
        $this->start = date('d/m/Y', strtotime($start));
        $this->end = date('d/m/Y', strtotime($end));
        $this->accountName = $accountName;
    }

    public function collection()
    {
        $data = collect();

        // Baris Kosong Kompensasi Judul Atas
        $data->push(['', '', '', '', '', '']);
        $data->push(['', '', '', '', '', '']);
        $data->push(['', '', '', '', '', '']);

        // Baris 4: Saldo Awal Sebelum Periode
        $data->push([
            '-',
            'SALDO AWAL SEBELUM PERIODE',
            '-',
            '-',
            '-',
            $this->saldoAwal
        ]);

        // Baris 5 dan seterusnya: Loop Data Mutasi Jurnal
        $currentSaldoRow = 4; // Baris saldo awal di excel nanti ada di baris ke-4 (karena offset judul)
        foreach ($this->mutations as $m) {
            $currentSaldoRow++;
            $isDebit = $m->account_debit == $m->selected_account_id; // Dilempar dari controller
            $debit = $isDebit ? $m->jumlah : 0;
            $kredit = !$isDebit ? $m->jumlah : 0;
            
            // Formula matematika Excel otomatis: Saldo Sebelumnya + Debit - Kredit
            $formulaSaldo = "=F" . ($currentSaldoRow - 1) . "+D" . $currentSaldoRow . "-E" . $currentSaldoRow;

            $data->push([
                date('d/m/Y', strtotime($m->tanggal)) . " (" . $m->pkjur . ")",
                $m->keterangan . " [Lawan: " . ($isDebit ? $m->kreditAccount->nama_rekening : $m->debitAccount->nama_rekening) . "]",
                $m->nobukti,
                $debit > 0 ? $debit : 0,
                $kredit > 0 ? $kredit : 0,
                $formulaSaldo
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'TANGGAL / ID',
            'URAIAN REKENING & KETERANGAN',
            'NO BUKTI',
            'DEBIT',
            'KREDIT',
            'SALDO'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16,
            'B' => 55,
            'C' => 15,
            'D' => 18,
            'E' => 18,
            'F' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. Ambil Baris Terakhir Data
        $highestRow = $sheet->getHighestRow();

        // 2. Tulis KOP JUDUL LAPORAN langsung di posisi baris yang benar (Baris 1, 2, 3)
        $sheet->setCellValue('A1', 'BUKU BESAR AKUN');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', strtoupper($this->accountName));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setSize(11)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', "Periode: {$this->start} s.d {$this->end}");
        $sheet->mergeCells('A3:F3');
        $sheet->getStyle('A3')->getFont()->setSize(10)->setItalic(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // --- HAPUS BARIS $sheet->moveRow(1, 5); YANG ERROR TADI ---

        // 3. Desain Table Head yang sekarang otomatis berada di Baris 5
        $sheet->getStyle('A5:F5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:F5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2F4F4F');
        $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // 4. Atur Format Desain Angka Mata Uang & Border untuk Semua Baris Data
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle("A5:F{$highestRow}")->applyFromArray($styleArray);
        $sheet->getStyle("A6:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("C6:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Format Angka Rupiah Akuntansi Tanpa Desimal untuk Kolom D, E, F
        $sheet->getStyle("D6:F{$highestRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0;[Red]("-Rp "#,##0);"-"');

        return [];
    }
}