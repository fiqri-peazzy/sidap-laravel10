<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Atlit extends Model
{
    use HasFactory;

    protected $table = 'atlit';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',

        'telepon',
        'email',

        'klub_id',
        'cabang_olahraga_id',
        'kategori_atlit_id',

        'foto',
        'prestasi',
        'status',
        'user_id',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',

        'klub_id' => 'integer',
        'cabang_olahraga_id' => 'integer',
        'kategori_atlit_id' => 'integer',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan Klub
    public function klub()
    {
        return $this->belongsTo(Klub::class, 'klub_id');
    }

    // Relasi dengan CabangOlahraga
    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class, 'cabang_olahraga_id');
    }

    // Relasi dengan KategoriAtlit
    public function kategoriAtlit()
    {
        return $this->belongsTo(KategoriAtlit::class, 'kategori_atlit_id');
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relasi dengan DokumenAtlit
    public function dokumen()
    {
        return $this->hasMany(DokumenAtlit::class, 'atlit_id');
    }


    // Konstanta status
    public const STATUS_PENDING = 'pending';
    public const STATUS_VERIFIED = 'diverifikasi';
    public const STATUS_REJECTED = 'ditolak';

    public const STATUS_OPTIONS = [
        self::STATUS_PENDING => 'Menunggu Verifikasi',
        self::STATUS_VERIFIED => 'Terverifikasi',
        self::STATUS_REJECTED => 'Ditolak',
    ];

    // Accessor untuk status dalam bahasa Indonesia
    public function getStatusIndonesiaAttribute()
    {
        return self::STATUS_OPTIONS[$this->status] ?? $this->status;
    }

    // Accessor untuk badge class berdasarkan status
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'badge-warning',
            self::STATUS_VERIFIED => 'badge-success',
            self::STATUS_REJECTED => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_verifikasi', $status);
    }

    // Scope untuk atlet yang menunggu verifikasi
    public function scopePending($query)
    {
        return $query->where('status_verifikasi', self::STATUS_PENDING);
    }

    // Scope untuk atlet yang sudah terverifikasi
    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', self::STATUS_VERIFIED);
    }

    // Scope untuk atlet yang ditolak
    public function scopeRejected($query)
    {
        return $query->where('status_verifikasi', self::STATUS_REJECTED);
    }

    // Method untuk cek apakah atlet sudah terverifikasi
    public function isVerified()
    {
        return $this->status_verifikasi === self::STATUS_VERIFIED;
    }

    // Method untuk cek apakah atlet ditolak
    public function isRejected()
    {
        return $this->status_verifikasi === self::STATUS_REJECTED;
    }

    // Method untuk cek apakah atlet masih pending
    public function isPending()
    {
        return $this->status_verifikasi === self::STATUS_PENDING;
    }

    // Method untuk menghitung persentase dokumen terverifikasi
    public function getDocumentVerificationPercentage()
    {
        $totalDocuments = $this->dokumen->count();

        if ($totalDocuments === 0) {
            return 0;
        }

        $verifiedDocuments = $this->dokumen->where('status_verifikasi', 'verified')->count();

        return round(($verifiedDocuments / $totalDocuments) * 100, 2);
    }

    // Method untuk cek apakah semua dokumen sudah terverifikasi
    public function hasAllDocumentsVerified()
    {
        return $this->dokumen->count() > 0 &&
            $this->dokumen->where('status_verifikasi', 'verified')->count() === $this->dokumen->count();
    }

    // Method untuk cek apakah ada dokumen yang ditolak
    public function hasRejectedDocuments()
    {
        return $this->dokumen->where('status_verifikasi', 'rejected')->count() > 0;
    }

    // Method untuk mendapatkan statistik dokumen
    public function getDocumentStats()
    {
        $dokumens = $this->dokumen;

        return [
            'total' => $dokumens->count(),
            'verified' => $dokumens->where('status_verifikasi', 'verified')->count(),
            'pending' => $dokumens->where('status_verifikasi', 'pending')->count(),
            'rejected' => $dokumens->where('status_verifikasi', 'rejected')->count(),
        ];
    }


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

    // Scope untuk status pensiun
    public function scopePensiun($query)
    {
        return $query->where('status', 'pensiun');
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_lengkap', 'like', '%' . $term . '%')
                ->orWhere('nik', 'like', '%' . $term . '%')
                ->orWhere('email', 'like', '%' . $term . '%')
                // ->orWhere('nomor_lisensi', 'like', '%' . $term . '%')
                ->orWhereHas('klub', function ($qq) use ($term) {
                    $qq->where('nama_klub', 'like', '%' . $term . '%');
                })
                ->orWhereHas('cabangOlahraga', function ($qq) use ($term) {
                    $qq->where('nama_cabang', 'like', '%' . $term . '%');
                });
        });
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'nonaktif' => '<span class="badge badge-secondary">Nonaktif</span>',
            'pensiun' => '<span class="badge badge-warning">Pensiun</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    // Accessor untuk jenis kelamin
    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    // Accessor untuk umur
    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return $this->tanggal_lahir->diffInYears(now());
        }
        return null;
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

    // Accessor untuk foto URL
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/atlit/foto/' . $this->foto);
        }
        return asset('template/img/default-avatar.png');
    }

    // Accessor untuk status lisensi
    public function getStatusLisensiAttribute()
    {
        if (!$this->tanggal_expired_lisensi) {
            return '<span class="badge badge-secondary">Tidak Ada</span>';
        }

        $today = now();
        $expired = $this->tanggal_expired_lisensi;

        if ($expired < $today) {
            return '<span class="badge badge-danger">Expired</span>';
        } elseif ($expired->diffInDays($today) <= 30) {
            return '<span class="badge badge-warning">Akan Expired</span>';
        } else {
            return '<span class="badge badge-success">Aktif</span>';
        }
    }

    // Method untuk membuat user otomatis
    public function createUser()
    {
        if (!$this->user_id && $this->email) {
            $user = User::create([
                'name' => $this->nama_lengkap,
                'email' => $this->email,
                'password' => Hash::make('password123'),
            ]);

            $this->update(['user_id' => $user->id]);
            return $user;
        }
        return null;
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:atlit,nik,' . $id,
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',

            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:atlit,email,' . $id,

            'klub_id' => 'required|exists:klub,id',
            'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
            'kategori_atlit_id' => 'required|exists:kategori_atlit,id',

            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'prestasi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif,pensiun',
        ];
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'atlit_id');
    }

    // Accessor untuk jumlah prestasi
    public function getJumlahPrestasiAttribute()
    {
        return $this->prestasi()->verified()->count();
    }

    // Accessor untuk prestasi terbaik
    public function getPrestasiBaikAttribute()
    {
        return $this->prestasi()
            ->verified()
            ->orderByRaw("CASE 
                WHEN peringkat = '1' THEN 1
                WHEN peringkat = '2' THEN 2
                WHEN peringkat = '3' THEN 3
                ELSE 4
            END")
            ->orderBy('tahun', 'desc')
            ->first();
    }

    // Method untuk mendapatkan statistik prestasi atlet
    public function getStatistikPrestasi()
    {
        $prestasi = $this->prestasi()->verified();

        return [
            'total' => $prestasi->count(),
            'juara_1' => (clone $prestasi)->where('peringkat', '1')->count(),
            'juara_2' => (clone $prestasi)->where('peringkat', '2')->count(),
            'juara_3' => (clone $prestasi)->where('peringkat', '3')->count(),
            'emas' => (clone $prestasi)->where('medali', 'Emas')->count(),
            'perak' => (clone $prestasi)->where('medali', 'Perak')->count(),
            'perunggu' => (clone $prestasi)->where('medali', 'Perunggu')->count(),
            'nasional' => (clone $prestasi)->where('jenis_kejuaraan', 'Nasional')->count(),
            'internasional' => (clone $prestasi)->where('jenis_kejuaraan', 'Internasional')->count(),
        ];
    }
}
