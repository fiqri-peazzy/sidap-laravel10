<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Prestasi extends Model
{
    use HasFactory;

    protected $table = 'prestasi';

    protected $fillable = [
        'atlit_id',
        'cabang_olahraga_id',
        'nama_kejuaraan',
        'jenis_kejuaraan',
        'tingkat_kejuaraan',
        'tempat_kejuaraan',
        'tanggal_mulai',
        'tanggal_selesai',
        'tahun',
        'nomor_pertandingan',
        'peringkat',
        'medali',
        'keterangan',
        'sertifikat',
        'status',

    ];

    protected $casts = [
        'atlit_id' => 'integer',
        'cabang_olahraga_id' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan Atlit
    public function atlit()
    {
        return $this->belongsTo(Atlit::class, 'atlit_id');
    }

    // Relasi dengan CabangOlahraga
    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class, 'cabang_olahraga_id');
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeByTahun($query, $tahun)
    {
        if ($tahun) {
            return $query->where('tahun', $tahun);
        }
        return $query;
    }

    // Scope untuk filter berdasarkan cabang olahraga
    public function scopeByCabor($query, $caborId)
    {
        if ($caborId) {
            return $query->where('cabang_olahraga_id', $caborId);
        }
        return $query;
    }

    // Scope untuk filter berdasarkan status
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_kejuaraan', 'like', '%' . $term . '%')
                ->orWhere('jenis_kejuaraan', 'like', '%' . $term . '%')
                ->orWhere('tingkat_kejuaraan', 'like', '%' . $term . '%')
                ->orWhere('tempat_kejuaraan', 'like', '%' . $term . '%')
                ->orWhere('nomor_pertandingan', 'like', '%' . $term . '%')
                ->orWhereHas('atlit', function ($qq) use ($term) {
                    $qq->where('nama_lengkap', 'like', '%' . $term . '%');
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
            'verified' => '<span class="badge badge-success">Terverifikasi</span>',
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'rejected' => '<span class="badge badge-danger">Ditolak</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    // Accessor untuk badge peringkat
    public function getPeringkatBadgeAttribute()
    {
        $badges = [
            '1' => '<span class="badge badge-warning text-dark"><i class="fas fa-medal"></i> Juara 1</span>',
            '2' => '<span class="badge badge-secondary"><i class="fas fa-medal"></i> Juara 2</span>',
            '3' => '<span class="badge badge-danger"><i class="fas fa-medal"></i> Juara 3</span>',
            'partisipasi' => '<span class="badge badge-info">Partisipasi</span>',
        ];

        if (in_array($this->peringkat, ['4', '5', '6', '7', '8'])) {
            return '<span class="badge badge-light text-dark">Peringkat ' . $this->peringkat . '</span>';
        }

        return $badges[$this->peringkat] ?? '<span class="badge badge-light text-dark">Peringkat ' . $this->peringkat . '</span>';
    }

    // Accessor untuk medali
    public function getMedaliBadgeAttribute()
    {
        $badges = [
            'Emas' => '<span class="badge" style="background-color: #ffd700; color: #000;"><i class="fas fa-medal"></i> Emas</span>',
            'Perak' => '<span class="badge" style="background-color: #c0c0c0; color: #000;"><i class="fas fa-medal"></i> Perak</span>',
            'Perunggu' => '<span class="badge" style="background-color: #cd7f32; color: #fff;"><i class="fas fa-medal"></i> Perunggu</span>',
        ];
        return $badges[$this->medali] ?? '';
    }

    // Accessor untuk sertifikat URL
    public function getSertifikatUrlAttribute()
    {
        if ($this->sertifikat) {
            return asset('storage/prestasi/sertifikat/' . $this->sertifikat);
        }
        return null;
    }

    // Accessor untuk format tanggal
    public function getTanggalKejuaraanAttribute()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            if ($this->tanggal_mulai->format('Y-m-d') === $this->tanggal_selesai->format('Y-m-d')) {
                return $this->tanggal_mulai->format('d F Y');
            } else {
                return $this->tanggal_mulai->format('d F Y') . ' - ' . $this->tanggal_selesai->format('d F Y');
            }
        }
        return $this->tanggal_mulai ? $this->tanggal_mulai->format('d F Y') : '-';
    }

    // Method untuk mendapatkan daftar tahun yang tersedia
    public static function getAvailableYears()
    {
        return self::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    // Method untuk statistik prestasi
    public static function getStatistikPrestasi($filters = [])
    {
        $query = self::verified();

        if (isset($filters['tahun'])) {
            $query->byTahun($filters['tahun']);
        }

        if (isset($filters['cabor_id'])) {
            $query->byCabor($filters['cabor_id']);
        }

        return [
            'total' => $query->count(),
            'juara_1' => (clone $query)->where('peringkat', '1')->count(),
            'juara_2' => (clone $query)->where('peringkat', '2')->count(),
            'juara_3' => (clone $query)->where('peringkat', '3')->count(),
            'emas' => (clone $query)->where('medali', 'Emas')->count(),
            'perak' => (clone $query)->where('medali', 'Perak')->count(),
            'perunggu' => (clone $query)->where('medali', 'Perunggu')->count(),
        ];
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'atlit_id' => 'required|exists:atlit,id',
            'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
            'nama_kejuaraan' => 'required|string|max:255',
            'jenis_kejuaraan' => 'required|string|max:100',
            'tingkat_kejuaraan' => 'required|string|max:100',
            'tempat_kejuaraan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'nomor_pertandingan' => 'nullable|string|max:100',
            'peringkat' => 'required|in:1,2,3,4,5,6,7,8,partisipasi',
            'medali' => 'nullable|in:Emas,Perak,Perunggu',
            'keterangan' => 'nullable|string',
            'sertifikat' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
            'status' => 'required|in:verified,pending,rejected',
        ];
    }
}
