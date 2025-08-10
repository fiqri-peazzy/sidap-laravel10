<?php
// Model: App/Models/KategoriAtlit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAtlit extends Model
{
    use HasFactory;

    protected $table = 'kategori_atlit';

    protected $fillable = [
        'cabang_olahraga_id',
        'nama_kategori',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'cabang_olahraga_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class, 'cabang_olahraga_id');
    }

    public function atlit()
    {
        return $this->hasMany(Atlit::class, 'kategori_atlit_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'nonaktif');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_kategori', 'like', '%' . $term . '%')
                ->orWhere('deskripsi', 'like', '%' . $term . '%')
                ->orWhereHas('cabangOlahraga', function ($qq) use ($term) {
                    $qq->where('nama_cabang', 'like', '%' . $term . '%');
                });
        });
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'aktif'
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Nonaktif</span>';
    }

    public function getJumlahAtlitAttribute()
    {
        return $this->atlit()->count();
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }
}