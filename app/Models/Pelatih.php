<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatih extends Model
{
    use HasFactory;

    protected $table = 'pelatih';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'klub_id',
        'cabang_olahraga_id',
        'lisensi',
        'pengalaman_tahun',
        'status',
        'foto'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'pengalaman_tahun' => 'integer',
        'status' => 'string'
    ];

    public function klub()
    {
        return $this->belongsTo(Klub::class);
    }

    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'nonaktif' => '<span class="badge badge-secondary">Non Aktif</span>',
            'cuti' => '<span class="badge badge-warning">Cuti</span>',
            default => '<span class="badge badge-light">Unknown</span>',
        };
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeNonAktif($query)
    {
        return $query->where('status', 'nonaktif');
    }
}