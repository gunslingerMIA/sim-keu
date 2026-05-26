<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LedgerExport implements FromCollection, WithStyles, WithHeadings, WithColumnWidths, WithCustomStartCell
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

    public function startCell(): string
    {
        return 'A5';
    }

    public function collection()
    {
        $data = collect();

        // 1. Berikan 4 baris kosong untuk area penulisan Judul (A1 s.d A4)
        // Headings bawaan Laravel Excel nantinya otomatis menempati Baris ke-5
       

        // 2. Baris ke-6: Menampilkan Data Saldo Awal Sebelum Periode
        $data->push([
            '-',
            'SALDO AWAL SEBELUM PERIODE',
            '-',
            0,
            0,
            $this->saldoAwal
        ]);

        // 3. Baris ke-7 dan seterusnya: Mengisi Baris Mutasi Transaksi
        // Karena Saldo Awal berada di baris 6, posisi indeks awal disetel tepat ke angka 6
        $currentSaldoRow = 6; 
        
        foreach ($this->mutations as $m) {
            $currentSaldoRow++;
            $isDebit = $m->account_debit == $m->selected_account_id;
            $debit = $isDebit ? $m->jumlah : 0;
            $kredit = !$isDebit ? $m->jumlah : 0;
            
            // Formula matematika Excel: Saldo Baris Sebelumnya + Debit Saat Ini - Kredit Saat Ini
            $formulaSaldo = "=F" . ($currentSaldoRow - 1) . "+D" . $currentSaldoRow . "-E" . $currentSaldoRow;

            $data->push([
                date('d/m/Y', strtotime($m->tanggal)),
                $m->keterangan . " [Lawan: " . ($isDebit ? ($m->kreditAccount->nama_rekening ?? 'N/A') : ($m->debitAccount->nama_rekening ?? 'N/A')) . "]",
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
            'A' => 18,
            'B' => 55,
            'C' => 15,
            'D' => 18,
            'E' => 18,
            'F' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        // Tulis Teks Judul Utama di Baris 1-3 yang dikompensasi kosong tadi
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

        // // Desain Table Head (Baris 5)
        $sheet->getStyle('A5:F5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:F5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2F4F4F');
        $sheet->getStyle('A5:F5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Desain Baris Khusus Saldo Awal (Baris 6) agar terlihat menonjol
        $sheet->getStyle('A6:F6')->getFont()->setBold(true);
        $sheet->getStyle('A6:F6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');

        // Atur Garis Kotak Border & Penyelarasan Posisi Teks Kolom
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle("A5:F{$highestRow}")->applyFromArray($styleArray);
        
        // Perataan teks kolom tengah dan atas agar rapi jika uraiannya panjang (wrap)
        $sheet->getStyle("A5:F{$highestRow}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle("A6:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("C6:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B6:B{$highestRow}")->getAlignment()->setWrapText(true);

        // Penerapan Format Rupiah Akuntansi Tanpa Desimal (Kolom D=Debit, E=Kredit, F=Saldo)
        $sheet->getStyle("D6:F{$highestRow}")->getNumberFormat()->setFormatCode('"Rp "#,##0;[Red]("-Rp "#,##0);"-"');

        return [];
    }
}