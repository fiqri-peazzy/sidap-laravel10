<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'jenjang',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'kepala_sekolah',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELASI
    // ============================================

    public function atlit()
    {
        return $this->hasMany(Atlit::class, 'sekolah_id');
    }

    public function operator()
    {
        return $this->hasOne(User::class, 'sekolah_id');
    }

    // ============================================
    // SCOPE
    // ============================================

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
            $q->where('nama_sekolah', 'like', '%' . $term . '%')
                ->orWhere('npsn', 'like', '%' . $term . '%')
                ->orWhere('kota', 'like', '%' . $term . '%')
                ->orWhere('provinsi', 'like', '%' . $term . '%');
        });
    }

    // ============================================
    // ACCESSOR
    // ============================================

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

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'aktif'
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Nonaktif</span>';
    }

    // ============================================
    // METHOD UTILITY
    // ============================================

    /**
     * Buat akun operator untuk sekolah ini.
     */
    public function createUser(string $email, string $password)
    {
        if ($this->operator) {
            return $this->operator;
        }

        $user = User::create([
            'name' => $this->nama_sekolah,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'sekolah',
            'sekolah_id' => $this->id,
        ]);

        return $user;
    }

    // ============================================
    // VALIDATION RULES
    // ============================================

    public static function rules($id = null)
    {
        return [
            'npsn' => 'nullable|string|max:20|unique:sekolah,npsn,' . $id,
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK,Lainnya',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:sekolah,email,' . $id,
            'kepala_sekolah' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }
}
