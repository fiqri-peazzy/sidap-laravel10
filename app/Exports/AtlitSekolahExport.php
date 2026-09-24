<?php

namespace App\Exports;

use App\Models\Atlit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AtlitSekolahExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected int $sekolahId;

    protected array $filters;

    public function __construct(int $sekolahId, array $filters = [])
    {
        $this->sekolahId = $sekolahId;
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = Atlit::with(['klub', 'cabangOlahraga', 'kategoriAtlit'])
            ->where('sekolah_id', $this->sekolahId);

        if (!empty($this->filters['cabang_olahraga_id'])) {
            $query->where('cabang_olahraga_id', $this->filters['cabang_olahraga_id']);
        }

        if (!empty($this->filters['kategori_atlit_id'])) {
            $query->where('kategori_atlit_id', $this->filters['kategori_atlit_id']);
        }

        if (!empty($this->filters['status_verifikasi'])) {
            $query->where('status_verifikasi', $this->filters['status_verifikasi']);
        }

        return $query->orderBy('nama_lengkap')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Klub',
            'Cabang Olahraga',
            'Kategori',
            'Status Atlet',
            'Status Verifikasi',
        ];
    }

    public function map($atlit): array
    {
        return [
            $atlit->nama_lengkap,
            $atlit->nik,
            $atlit->jenis_kelamin_lengkap,
            optional($atlit->tanggal_lahir)->format('d-m-Y'),
            $atlit->klub->nama_klub ?? '-',
            $atlit->cabangOlahraga->nama_cabang ?? '-',
            $atlit->kategoriAtlit->nama_kategori ?? '-',
            $atlit->status_indonesia,
            $atlit->status_verifikasi_indonesia,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
