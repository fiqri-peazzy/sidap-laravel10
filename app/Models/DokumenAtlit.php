<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenAtlit extends Model
{
    use HasFactory;

    protected $table = 'dokumen_atlit';

    protected $fillable = [
        'atlit_id',
        'kategori_berkas',
        'nama_file',
        'file_path',
        'status_verifikasi',
        'keterangan',
        'alasan_ditolak',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'atlit_id' => 'integer',
        'verified_by' => 'integer',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Konstanta untuk kategori berkas
    public const KATEGORI_BERKAS = [
        'Ijazah' => 'Ijazah',
        'Akta Kelahiran' => 'Akta Kelahiran',
        'Kartu Pelajar' => 'Kartu Pelajar',
        'Dokumen Pendukung' => 'Dokumen Pendukung',
    ];

    // Konstanta untuk status verifikasi
    public const STATUS_VERIFIKASI = [
        'pending' => 'Menunggu',
        'verified' => 'Terverifikasi',
        'rejected' => 'Ditolak',
    ];

    // Relasi dengan Atlit
    public function atlit()
    {
        return $this->belongsTo(Atlit::class, 'atlit_id');
    }

    // Relasi dengan User (verifikator)
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Accessor untuk status verifikasi dalam bahasa Indonesia
    public function getStatusVerifikasiIndonesiaAttribute()
    {
        return self::STATUS_VERIFIKASI[$this->status_verifikasi] ?? $this->status_verifikasi;
    }

    // Accessor untuk badge class berdasarkan status
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status_verifikasi) {
            'pending' => 'badge-warning',
            'verified' => 'badge-success',
            'rejected' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_verifikasi', $status);
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori_berkas', $kategori);
    }

    // Method untuk cek apakah dokumen sudah terverifikasi
    public function isVerified()
    {
        return $this->status_verifikasi === 'verified';
    }

    // Method untuk cek apakah dokumen ditolak
    public function isRejected()
    {
        return $this->status_verifikasi === 'rejected';
    }

    // Method untuk cek apakah dokumen masih pending
    public function isPending()
    {
        return $this->status_verifikasi === 'pending';
    }
}