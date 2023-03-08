<?php

namespace App\Exports;

use App\Models\Absen;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsenExport implements FromCollection, WithHeadings
{
    protected $absens;

    public function __construct($absens)
    {
        $this->absens = $absens;
    }

    public function headings(): array
    {
        // Add 'No' to the beginning of the headings array
        return array_merge(['No'], [
            'Tanggal',
            'Nama',
            'NIS',
            'Keterangan',
        ]);
    }

    public function collection()
    {
        // Use map to add number to each row
        return $this->absens->map(function ($absen, $index) {
            return [
                $index + 1,
                $absen->date,
                $absen->nama,
                $absen->nis,
                $absen->keterangan,
            ];
        });
    }
}

