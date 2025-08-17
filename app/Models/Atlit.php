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
