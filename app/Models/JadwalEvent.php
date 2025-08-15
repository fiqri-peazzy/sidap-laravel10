<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalEvent extends Model
{
    use HasFactory;

    protected $table = 'jadwal_event';

    protected $fillable = [
        'nama_event',
        'jenis_event',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'penyelenggara',
        'cabang_olahraga_id',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'cabang_olahraga_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi dengan CabangOlahraga
    public function cabangOlahraga()
    {
        return $this->belongsTo(Cabor::class, 'cabang_olahraga_id');
    }

    // Relasi many-to-many dengan Atlet
    public function atlit()
    {
        return $this->belongsToMany(Atlit::class, 'event_atlit', 'jadwal_event_id', 'atlit_id')
            ->withTimestamps();
    }

    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk event mendatang
    public function scopeMendatang($query)
    {
        return $query->where('tanggal_mulai', '>=', now()->toDateString());
    }

    // Scope untuk event berlangsung
    public function scopeBerlangsung($query)
    {
        return $query->where('tanggal_mulai', '<=', now()->toDateString())
            ->where('tanggal_selesai', '>=', now()->toDateString());
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_event', 'like', '%' . $term . '%')
                ->orWhere('lokasi', 'like', '%' . $term . '%')
                ->orWhere('penyelenggara', 'like', '%' . $term . '%')
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
            'selesai' => '<span class="badge badge-primary">Selesai</span>',
            'dibatalkan' => '<span class="badge badge-danger">Dibatalkan</span>',
        ];
        return $badges[$this->status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    // Accessor untuk badge jenis event
    public function getJenisEventBadgeAttribute()
    {
        $badges = [
            'pertandingan' => '<span class="badge badge-primary">Pertandingan</span>',
            'seleksi' => '<span class="badge badge-warning">Seleksi</span>',
            'uji_coba' => '<span class="badge badge-info">Uji Coba</span>',
            'kejuaraan' => '<span class="badge badge-success">Kejuaraan</span>',
        ];
        return $badges[$this->jenis_event] ?? '<span class="badge badge-secondary">Lainnya</span>';
    }

    // Accessor untuk durasi event
    public function getDurasiEventAttribute()
    {
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            $durasi = $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
            return $durasi . ' hari';
        }
        return '-';
    }

    // Method untuk cek status event
    public function getStatusEventAttribute()
    {
        $today = now()->toDateString();

        if ($this->tanggal_selesai < $today) {
            return 'selesai';
        } elseif ($this->tanggal_mulai <= $today && $this->tanggal_selesai >= $today) {
            return 'berlangsung';
        } else {
            return 'mendatang';
        }
    }

    // Method untuk menghitung jumlah atlet terdaftar
    public function getJumlahAtletAttribute()
    {
        return $this->atlit()->count();
    }

    // Validation rules
    public static function rules($id = null)
    {
        return [
            'nama_event' => 'required|string|max:255',
            'jenis_event' => 'required|in:pertandingan,seleksi,uji_coba,kejuaraan',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'cabang_olahraga_id' => 'required|exists:cabang_olahraga,id',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ];
    }
}