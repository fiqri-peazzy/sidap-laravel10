<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Klub extends Model
{
    use HasFactory;

    protected $table = 'klub';

    protected $fillable = [
        'nama_klub',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'tahun_berdiri',
        'ketua_klub',
        'sekretaris',
        'bendahara',
        'website',
        'deskripsi',
        'logo',
        'status',
    ];

    protected $casts = [
        'tahun_berdiri' => 'integer',
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

    // Scope untuk pencarian
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_klub', 'like', '%' . $term . '%')
                ->orWhere('kota', 'like', '%' . $term . '%')
                ->orWhere('provinsi', 'like', '%' . $term . '%')
                ->orWhere('ketua_klub', 'like', '%' . $term . '%');
        });
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'aktif'
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Nonaktif</span>';
    }

    // Accessor untuk alamat lengkap
    public function getAlamatLengkapAttribute()
    {
        $alamat = $this->alamat;
        if ($this->kota) {
            $alamat .= ', ' . $this->kota;
        }
        if ($this->provinsi) {
            $alamat .= ', ' . $this->provinsi;
        }
        if ($this->kode_pos) {
            $alamat .= ' ' . $this->kode_pos;
        }
        return $alamat;
    }

    // Accessor untuk umur klub
    public function getUmurKlubAttribute()
    {
        if ($this->tahun_berdiri) {
            return date('Y') - $this->tahun_berdiri;
        }
        return null;
    }

    // Accessor untuk logo URL
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/klub/logo/' . $this->logo);
        }
        return asset('template/img/default-club.png');
    }

    public function atlit()
    {
        return $this->hasMany(Atlit::class, 'klub_id');
    }

    public function pelatih()
    {
        return $this->hasMany(Pelatih::class, 'klub_id');
    }

    // Relasi many-to-many dengan CabangOlahraga
    public function cabangOlahraga()
    {
        return $this->belongsToMany(Cabor::class, 'klub_cabang_olahraga', 'klub_id', 'cabang_olahraga_id');
    }

    // Method untuk menghitung jumlah atlit
    // public function getJumlahAtlitAttribute()
    // {
    //     return $this->atlit()->count();
    // }

    // // Method untuk menghitung jumlah pelatih
    // public function getJumlahPelatihAttribute()
    // {
    //     return $this->pelatih()->count();
    // }

    // Method untuk validasi email unik
    public static function rules($id = null)
    {
        return [
            'nama_klub' => 'required|string|max:255|unique:klub,nama_klub,' . $id,
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:klub,email,' . $id,
            'tahun_berdiri' => 'nullable|integer|min:1900|max:' . date('Y'),
            'ketua_klub' => 'nullable|string|max:255',
            'sekretaris' => 'nullable|string|max:255',
            'bendahara' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }
}
