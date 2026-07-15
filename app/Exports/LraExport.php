<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LraExport implements FromCollection, WithStyles, WithColumnWidths, WithHeadings, WithCustomStartCell
{
    protected $processedData, $endDate, $jenisLra, $tahun, $grandTotal;

    // Headings ada di baris 5 (startCell A5), data mulai baris 6
    // rowTypes menyimpan tipe setiap baris data: ['skpd','program','kegiatan','sub_kegiatan','rekening','transaksi','total']
    protected $rowTypes = [];

    public function __construct($processedData, $endDate, $jenisLra, $tahun, $grandTotal)
    {
        $this->processedData = $processedData;
        $this->endDate       = date('d/m/Y', strtotime($endDate));
        $this->jenisLra      = $jenisLra;
        $this->tahun         = $tahun;
        $this->grandTotal    = $grandTotal;
    }

    public function collection()
    {
        $data       = collect();
        $currentRow = 6; // baris 5 = heading, data mulai baris 6

        // 0. LEVEL 0: SKPD / DINAS
        if ($this->processedData->isNotEmpty()) {
            $data->push([
                'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu',
                '',
                (float) $this->grandTotal['pagu'],
                (float) $this->grandTotal['realisasi'],
                (float) $this->grandTotal['sisa'],
                (float) $this->grandTotal['persen'] / 100,
            ]);
            $this->rowTypes[$currentRow++] = 'skpd';
        }

        // 1. Loop LEVEL 1: PROGRAM
        foreach ($this->processedData as $p) {
            $data->push([
                $p->kode_program,
                $p->nama_program,
                (float) $p->total_pagu,
                (float) $p->total_realisasi,
                (float) $p->total_sisa,
                (float) $p->total_persen / 100,
            ]);
            $this->rowTypes[$currentRow++] = 'program';

            // 2. Loop LEVEL 2: KEGIATAN
            foreach ($p->activities as $act) {
                $data->push([
                    $act->kode_kegiatan,
                    $act->nama_kegiatan,
                    (float) $act->total_pagu,
                    (float) $act->total_realisasi,
                    (float) $act->total_sisa,
                    (float) $act->total_persen / 100,
                ]);
                $this->rowTypes[$currentRow++] = 'kegiatan';

                // 3. Loop LEVEL 3: SUB-KEGIATAN
                foreach ($act->subActivities as $sub) {
                    $data->push([
                        $sub->kode_sub_kegiatan,
                        '  ' . $sub->nama_sub_kegiatan,
                        (float) $sub->total_pagu,
                        (float) $sub->total_realisasi,
                        (float) $sub->total_sisa,
                        (float) $sub->total_persen / 100,
                    ]);
                    $this->rowTypes[$currentRow++] = 'sub_kegiatan';

                    // 4. Loop LEVEL 4: REKENING BELANJA
                    foreach ($sub->budgets as $b) {
                        $data->push([
                            $b->account->kode_rekening,
                            '    ' . $b->account->nama_rekening,
                            (float) $b->pagu_murni,
                            (float) $b->realisasi,
                            (float) $b->sisa,
                            (float) $b->persen / 100,
                        ]);
                        $this->rowTypes[$currentRow++] = 'rekening';

                        // 5. Loop LEVEL 5: DETAIL TRANSAKSI (JIKA PILIH RINCI)
                        if ($this->jenisLra == 'rinci') {
                            foreach ($b->transactions as $t) {
                                $data->push([
                                    date('d/m/Y', strtotime($t->tanggal)),
                                    '      [' . $t->nobukti . '] - ' . $t->keterangan,
                                    0.0,
                                    (float) $t->jumlah,
                                    0.0,
                                    0.0,
                                ]);
                                $this->rowTypes[$currentRow++] = 'transaksi';
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
            (float) $this->grandTotal['pagu'],
            (float) $this->grandTotal['realisasi'],
            (float) $this->grandTotal['sisa'],
            (float) $this->grandTotal['persen'] / 100,
        ]);
        $this->rowTypes[$currentRow] = 'total';

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
            '%',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
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

        // Aktifkan summary di atas group (tombol collapse muncul di atas children)
        $sheet->setShowSummaryBelow(false);
        $sheet->setShowSummaryRight(false);

        // ── 1. KOP JUDUL (Baris 1-3) ─────────────────────────────────────────────
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

        // Baris 4 dikosongkan sebagai spacer

        // ── 2. HEADER TABEL (Baris 5) ─────────────────────────────────────────────
        $sheet->getRowDimension(5)->setRowHeight(30);
        $sheet->getStyle('A5:F5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:F5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2F4F4F');
        $sheet->getStyle('A5:F5')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        // ── 3. LOOP STYLING PER BARIS ─────────────────────────────────────────────
        for ($row = 6; $row <= $highestRow; $row++) {
            $type = $this->rowTypes[$row] ?? 'unknown';

            switch ($type) {

                case 'skpd':
                    // DINAS: background gelap tua, teks putih tebal
                    $sheet->mergeCells("A{$row}:B{$row}");
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(true)->setItalic(false)->getColor()->setRGB('FFFFFF');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2C3E50');
                    $sheet->getStyle("A{$row}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    $sheet->getRowDimension($row)->setOutlineLevel(0)->setCollapsed(false);
                    break;

                case 'program':
                    // PROGRAM: background biru muda, teks navy tebal
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(true)->setItalic(false)->getColor()->setRGB('002060');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
                    $sheet->getRowDimension($row)->setOutlineLevel(1)->setCollapsed(false);
                    break;

                case 'kegiatan':
                    // KEGIATAN: background abu-abu sedang, teks hitam tebal
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(true)->setItalic(false)->getColor()->setRGB('1F1F1F');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('EDEDED');
                    $sheet->getRowDimension($row)->setOutlineLevel(2)->setCollapsed(false);
                    break;

                case 'sub_kegiatan':
                    // SUB-KEGIATAN: background putih, teks hitam tebal
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(true)->setItalic(false)->getColor()->setRGB('1F1F1F');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
                    $sheet->getRowDimension($row)->setOutlineLevel(3)->setCollapsed(false);
                    break;

                case 'rekening':
                    // REKENING BELANJA: italic, teks biru standar keuangan
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(false)->setItalic(true)->getColor()->setRGB('1F1F1F');
                    $sheet->getStyle("B{$row}")
                        ->getFont()->getColor()->setRGB('0070C0');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FAFAFA');
                    $sheet->getRowDimension($row)->setOutlineLevel(4)->setCollapsed(false);
                    break;

                case 'transaksi':
                    // DETAIL TRANSAKSI: font kecil abu, background kuning gading
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(false)->setItalic(true)->setSize(9)->getColor()->setRGB('595959');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFDF0');
                    $sheet->getRowDimension($row)->setOutlineLevel(5)->setCollapsed(false);
                    break;

                case 'total':
                    // GRAND TOTAL: background biru gelap, teks putih tebal
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFont()->setBold(true)->setItalic(false)->getColor()->setRGB('FFFFFF');
                    $sheet->getStyle("A{$row}:F{$row}")
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('1A365D');
                    $sheet->getStyle("A{$row}:B{$row}")
                        ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getRowDimension($row)->setOutlineLevel(0)->setCollapsed(false);
                    break;

                default:
                    $sheet->getRowDimension($row)->setOutlineLevel(0)->setCollapsed(false);
                    break;
            }

            // Teks vertikal selalu rapi di atas sel
            $sheet->getStyle("A{$row}:F{$row}")
                ->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

            // Format angka: tanpa Rp, angka 0 tetap tampil 0 (bukan tanda hubung)
            $sheet->getStyle("C{$row}:E{$row}")
                ->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("F{$row}")
                ->getNumberFormat()->setFormatCode('0.00%');

            // FIX: Maatwebsite Excel skip nilai PHP 0/0.0 saat menulis collection
            // (karena empty(0) === true di PHP). Paksa tulis 0 ke sel yang kosong.
            foreach (['C', 'D', 'E'] as $numCol) {
                $cell = $sheet->getCell("{$numCol}{$row}");
                if ($cell->getValue() === null || $cell->getValue() === '') {
                    $cell->setValue(0);
                }
            }
            // Kolom F (%) hanya diisi 0 jika bukan baris transaksi rinci
            // (transaksi tidak punya persen, tapi 0 juga benar)
            $fCell = $sheet->getCell("F{$row}");
            if ($fCell->getValue() === null || $fCell->getValue() === '') {
                $fCell->setValue(0);
            }
        }

        // ── 4. BORDER SELURUH TABEL ───────────────────────────────────────────────
        $sheet->getStyle("A5:F{$highestRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Kolom A selalu rata kiri
        $sheet->getStyle("A6:A{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Kolom F (%) rata tengah
        $sheet->getStyle("F6:F{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Kolom C, D, E (angka) rata kanan
        $sheet->getStyle("C6:E{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }
}
