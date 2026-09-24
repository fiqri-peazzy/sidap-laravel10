<?php

namespace App\Imports;

use App\Models\Atlit;
use App\Models\Cabor;
use App\Models\KategoriAtlit;
use App\Models\Klub;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class AtlitImport implements OnEachRow, WithHeadingRow
{
    protected int $sekolahId;

    protected int $importedCount = 0;

    protected array $errors = [];

    protected array $nikSeenInFile = [];

    public function __construct(int $sekolahId)
    {
        $this->sekolahId = $sekolahId;
    }

    public function onRow(Row $row)
    {
        // getIndex() sudah mengembalikan nomor baris asli di sheet Excel (1-based, header = baris 1)
        $rowNumber = $row->getIndex();
        $data = $row->toArray();

        // Lewati baris yang benar-benar kosong
        if (empty(array_filter($data, fn ($v) => $v !== null && $v !== ''))) {
            return;
        }

        $nik = trim((string) ($data['nik'] ?? ''));

        $validator = Validator::make($data, [
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:atlit,nik',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'nama_klub' => 'required|string',
            'nama_cabang_olahraga' => 'required|string',
            'nama_kategori' => 'required|string',
            'status' => 'nullable|in:aktif,nonaktif,pensiun',
        ]);

        if ($validator->fails()) {
            $this->addError($rowNumber, $data['nama_lengkap'] ?? '-', $validator->errors()->all());
            return;
        }

        if (in_array($nik, $this->nikSeenInFile, true)) {
            $this->addError($rowNumber, $data['nama_lengkap'], ['NIK duplikat dengan baris lain di file yang sama.']);
            return;
        }

        $klub = Klub::where('nama_klub', trim($data['nama_klub']))->first();
        if (!$klub) {
            $this->addError($rowNumber, $data['nama_lengkap'], ["Klub '{$data['nama_klub']}' tidak ditemukan."]);
            return;
        }

        $cabor = Cabor::where('nama_cabang', trim($data['nama_cabang_olahraga']))->first();
        if (!$cabor) {
            $this->addError($rowNumber, $data['nama_lengkap'], ["Cabang olahraga '{$data['nama_cabang_olahraga']}' tidak ditemukan."]);
            return;
        }

        $kategori = KategoriAtlit::where('cabang_olahraga_id', $cabor->id)
            ->where('nama_kategori', trim($data['nama_kategori']))
            ->first();
        if (!$kategori) {
            $this->addError($rowNumber, $data['nama_lengkap'], ["Kategori '{$data['nama_kategori']}' tidak ditemukan untuk cabang olahraga '{$cabor->nama_cabang}'."]);
            return;
        }

        $atlit = Atlit::create([
            'nama_lengkap' => $data['nama_lengkap'],
            'nik' => $nik,
            'tempat_lahir' => $data['tempat_lahir'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'alamat' => $data['alamat'],
            'telepon' => $data['telepon'] ?? null,
            'email' => $data['email'] ?? null,
            'klub_id' => $klub->id,
            'sekolah_id' => $this->sekolahId,
            'cabang_olahraga_id' => $cabor->id,
            'kategori_atlit_id' => $kategori->id,
            'status' => $data['status'] ?? 'aktif',
            'status_verifikasi' => Atlit::STATUS_VERIFIKASI_PENDING,
        ]);

        $atlit->riwayat()->create([
            'tahun' => date('Y'),
            'klub_id' => $klub->id,
            'cabang_olahraga_id' => $cabor->id,
            'kategori_atlit_id' => $kategori->id,
            'status' => $atlit->status,
        ]);

        if ($atlit->email) {
            $atlit->createUser();
        }

        $this->nikSeenInFile[] = $nik;
        $this->importedCount++;
    }

    protected function addError(int $rowNumber, string $nama, array $messages): void
    {
        $this->errors[] = [
            'row' => $rowNumber,
            'nama' => $nama ?: '(tanpa nama)',
            'messages' => $messages,
        ];
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
