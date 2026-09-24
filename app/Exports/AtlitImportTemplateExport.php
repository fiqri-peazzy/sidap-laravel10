<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AtlitImportTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'nama_lengkap',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'telepon',
            'email',
            'nama_klub',
            'nama_cabang_olahraga',
            'nama_kategori',
            'status',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Contoh Nama Atlet',
                '7371012345670001',
                'Gorontalo',
                '2008-05-17',
                'L',
                'Jl. Contoh Alamat No. 1',
                '081234567890',
                'contoh@email.com',
                'Klub Sepak Takraw Gorontalo',
                'Sepak Takraw',
                'Team, Regu & Double',
                'aktif',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
