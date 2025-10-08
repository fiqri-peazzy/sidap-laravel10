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
        'status_verifikasi',
        'user_id',
        'verified_by',
        'verified_at',
        'catatan_verifikasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'klub_id' => 'integer',
        'cabang_olahraga_id' => 'integer',
        'kategori_atlit_id' => 'integer',
        'user_id' => 'integer',
        'verified_by' => 'integer',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ============================================
    // RELASI
    // ============================================

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenAtlit::class, 'atlit_id');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'atlit_id');
    }

    // ============================================
    // KONSTANTA STATUS VERIFIKASI
    // ============================================

    public const STATUS_VERIFIKASI_PENDING = 'pending';
    public const STATUS_VERIFIKASI_VERIFIED = 'diverifikasi';
    public const STATUS_VERIFIKASI_REJECTED = 'ditolak';

    public const STATUS_VERIFIKASI_OPTIONS = [
        self::STATUS_VERIFIKASI_PENDING => 'Menunggu Verifikasi',
        self::STATUS_VERIFIKASI_VERIFIED => 'Terverifikasi',
        self::STATUS_VERIFIKASI_REJECTED => 'Ditolak',
    ];

    // ============================================
    // KONSTANTA STATUS ATLET (Aktif/Nonaktif)
    // ============================================

    public const STATUS_AKTIF = 'aktif';
    public const STATUS_NONAKTIF = 'nonaktif';
    public const STATUS_PENSIUN = 'pensiun';

    public const STATUS_OPTIONS = [
        self::STATUS_AKTIF => 'Aktif',
        self::STATUS_NONAKTIF => 'Nonaktif',
        self::STATUS_PENSIUN => 'Pensiun',
    ];

    // ============================================
    // ACCESSOR - STATUS VERIFIKASI
    // ============================================

    public function getStatusVerifikasiIndonesiaAttribute()
    {
        return self::STATUS_VERIFIKASI_OPTIONS[$this->status_verifikasi] ?? $this->status_verifikasi;
    }

    public function getStatusVerifikasiBadgeClassAttribute()
    {
        return match ($this->status_verifikasi) {
            self::STATUS_VERIFIKASI_PENDING => 'badge-warning',
            self::STATUS_VERIFIKASI_VERIFIED => 'badge-success',
            self::STATUS_VERIFIKASI_REJECTED => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    public function getStatusVerifikasiBadgeAttribute()
    {
        $class = $this->status_verifikasi_badge_class;
        $text = $this->status_verifikasi_indonesia;
        return "<span class='badge {$class}'>{$text}</span>";
    }

    // ============================================
    // ACCESSOR - STATUS ATLET
    // ============================================

    public function getStatusIndonesiaAttribute()
    {
        return self::STATUS_OPTIONS[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'nonaktif' => '<span class="badge badge-secondary">Nonaktif</span>',
            'pensiun' => '<span class="badge badge-warning">Pensiun</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    // ============================================
    // SCOPE - STATUS VERIFIKASI
    // ============================================

    public function scopeByStatusVerifikasi($query, $status)
    {
        return $query->where('status_verifikasi', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status_verifikasi', self::STATUS_VERIFIKASI_PENDING);
    }

    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', self::STATUS_VERIFIKASI_VERIFIED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status_verifikasi', self::STATUS_VERIFIKASI_REJECTED);
    }

    // ============================================
    // SCOPE - STATUS ATLET
    // ============================================

    public function scopeAktif($query)
    {
        return $query->where('status', self::STATUS_AKTIF);
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', self::STATUS_NONAKTIF);
    }

    public function scopePensiun($query)
    {
        return $query->where('status', self::STATUS_PENSIUN);
    }

    // ============================================
    // METHOD CHECKER - STATUS VERIFIKASI
    // ============================================

    public function isVerified()
    {
        return $this->status_verifikasi === self::STATUS_VERIFIKASI_VERIFIED;
    }

    public function isRejected()
    {
        return $this->status_verifikasi === self::STATUS_VERIFIKASI_REJECTED;
    }

    public function isPending()
    {
        return $this->status_verifikasi === self::STATUS_VERIFIKASI_PENDING;
    }

    // ============================================
    // METHOD - DOKUMEN VERIFIKASI
    // ============================================

    public function getDocumentVerificationPercentage()
    {
        $totalDocuments = $this->dokumen->count();
        if ($totalDocuments === 0) {
            return 0;
        }
        $verifiedDocuments = $this->dokumen->where('status_verifikasi', 'verified')->count();
        return round(($verifiedDocuments / $totalDocuments) * 100, 2);
    }

    public function hasAllDocumentsVerified()
    {
        return $this->dokumen->count() > 0 &&
            $this->dokumen->where('status_verifikasi', 'verified')->count() === $this->dokumen->count();
    }

    public function hasRejectedDocuments()
    {
        return $this->dokumen->where('status_verifikasi', 'rejected')->count() > 0;
    }

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

    // ============================================
    // SCOPE - PENCARIAN
    // ============================================

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_lengkap', 'like', '%' . $term . '%')
                ->orWhere('nik', 'like', '%' . $term . '%')
                ->orWhere('email', 'like', '%' . $term . '%')
                ->orWhereHas('klub', function ($qq) use ($term) {
                    $qq->where('nama_klub', 'like', '%' . $term . '%');
                })
                ->orWhereHas('cabangOlahraga', function ($qq) use ($term) {
                    $qq->where('nama_cabang', 'like', '%' . $term . '%');
                });
        });
    }

    // ============================================
    // ACCESSOR - DATA ATLET
    // ============================================

    public function getJenisKelaminLengkapAttribute()
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return $this->tanggal_lahir->diffInYears(now());
        }
        return null;
    }

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

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/atlit/foto/' . $this->foto);
        }
        return asset('template/img/default-avatar.png');
    }

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

    // ============================================
    // ACCESSOR - PRESTASI
    // ============================================

    public function getJumlahPrestasiAttribute()
    {
        return $this->prestasi()->verified()->count();
    }

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

    // ============================================
    // METHOD UTILITY
    // ============================================

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

    // ============================================
    // VALIDATION RULES
    // ============================================

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
}
