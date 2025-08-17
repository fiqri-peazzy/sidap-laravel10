<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Cabor extends Model
{
    use HasFactory;

    protected $table = 'cabang_olahraga';

    protected $fillable = [
        'nama_cabang',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk status nonaktif
    public function scopeNonaktif($query)
    {
        return $query->where('status', 'nonaktif');
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'aktif'
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Nonaktif</span>';
    }
    public function atlit()
    {
        return $this->hasMany(Atlit::class, 'cabang_olahraga_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'cabang_olahraga_id');
    }

    // public function events()
    // {
    //     return $this->hasMany(Event::class, 'cabang_olahraga_id');
    // }

    // public function getJumlahAtlitAttribute()
    // {
    //     return $this->atlit()->count();
    // }
}
