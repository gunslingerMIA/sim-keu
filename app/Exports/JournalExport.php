<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class JournalExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'ID Jurnal',
            'Kode Rekening',
            'Uraian',
            'Debit',
            'Kredit',
            'No. Bukti',
        ];
    }

    public function map($t): array
    {
        return [
            [
                date('d-m-Y', strtotime($t->tanggal)),
                $t->pkjur,
                $t->debitAccount->kode_rekening ?? '',
                $t->debitAccount->nama_rekening.' - '.$t->subActivity->nama_sub_kegiatan ?? '',
                $t->jumlah,
                0,
                $t->nobukti
            ],
            [
                '',
                '',
                $t->kreditAccount->kode_rekening,
                '   ' . $t->kreditAccount->nama_rekening,
                0,
                $t->jumlah,
                ''
            ],
            [
                '',
                '',
                '',
                '(' . $t->keterangan . ')',
                0,
                0,
                ''
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
            'A1:G1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E2E3E5']]],
        ];
    }
}
