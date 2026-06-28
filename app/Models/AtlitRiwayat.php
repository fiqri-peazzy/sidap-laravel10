<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtlitRiwayat extends Model
{
    use HasFactory;
    protected $fillable = [
        'atlit_id',
        'tahun',
        'klub_id',
        'cabang_olahraga_id',
        'kategori_atlit_id',
        'status',
    ];

    public function atlit()
    {
        return $this->belongsTo(Atlit::class, 'atlit_id');
    }

    public function klub()
    {
        return $this->belongsTo(Klub::class, 'klub_id');
    }

    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class, 'cabang_olahraga_id');
    }

    public function kategoriAtlit()
    {
        return $this->belongsTo(KategoriAtlit::class, 'kategori_atlit_id');
    }
}
