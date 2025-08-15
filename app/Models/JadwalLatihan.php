<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalLatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_latihan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'cabang_olahraga_id',
        'pelatih_id',
        'klub_id',
        'catatan',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
        'cabang_olahraga_id' => 'integer',
        'pelatih_id' => 'integer',
        'klub_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan CabangOlahraga
    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class, 'cabang_olahraga_id');
    }

    // Relasi dengan Pelatih
    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class, 'pelatih_id');
    }

    // Relasi dengan Klub
    public function klub()
    {
        return $this->belongsTo(Klub::class, 'klub_id');
    }

    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', now()->toDateString());
    }

    // Scope untuk bulan ini
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_kegiatan', 'like', '%' . $term . '%')
                ->orWhere('lokasi', 'like', '%' . $term . '%')
                ->orWhereHas('cabangOlahraga', function ($qq) use ($term) {
                    $qq->where('nama_cabang', 'like', '%' . $term . '%');
                })
                ->orWhereHas('pelatih', function ($qq) use ($term) {
                    $qq->where('nama', 'like', '%' . $term . '%');
                });
        });
    }

    // Accessor untuk badge status
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'selesai' => '<span class="badge badge-primary">Selesai</span>',
            'dibatalkan' => '<span class="badge badge-danger">Dibatalkan</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    // Accessor untuk jam latihan
    public function getJamLatihanAttribute()
    {
        return Carbon::parse($this->jam_mulai)->format('H:i') . ' - ' . Carbon::parse($this->jam_selesai)->format('H:i');
    }

    // Accessor untuk durasi latihan
    public function getDurasiAttribute()
    {
        $mulai = Carbon::parse($this->jam_mulai);
        $selesai = Carbon::parse($this->jam_selesai);
        return $mulai->diffInMinutes($selesai) . ' menit';
    }

    // Method untuk cek apakah jadwal sudah lewat
    public function isExpired()
    {
        $jadwalDateTime = Carbon::parse(
            $this->tanggal->format('Y-m-d') . ' ' . Carbon::parse($this->jam_selesai)->format('H:i:s')
        );

        return $jadwalDateTime->isPast();
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi' => 'required|string|max:255',
            'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
            'pelatih_id' => 'required|exists:pelatih,id',
            'klub_id' => 'nullable|exists:klub,id',
            'catatan' => 'nullable|string',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ];
    }
}
