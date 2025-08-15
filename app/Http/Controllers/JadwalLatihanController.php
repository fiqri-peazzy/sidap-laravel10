<?php

namespace App\Http\Controllers;

use App\Models\JadwalLatihan;
use App\Models\Cabor;
use App\Models\Pelatih;
use App\Models\Klub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalLatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalLatihan::with(['cabangOlahraga', 'pelatih', 'klub']);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter berdasarkan cabang olahraga
        if ($request->filled('cabang_olahraga_id')) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $jadwalLatihan = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->paginate(10);

        $cabangOlahraga = Cabor::aktif()->get();

        return view('admin.jadwal-latihan.index', compact('jadwalLatihan', 'cabangOlahraga'));
    }

    public function create()
    {
        $cabangOlahraga = Cabor::aktif()->get();
        $pelatih = Pelatih::aktif()->get();
        $klub = Klub::aktif()->get();

        return view('admin.jadwal-latihan.create', compact('cabangOlahraga', 'pelatih', 'klub'));
    }

    public function store(Request $request)
    {
        $request->validate(JadwalLatihan::rules());

        try {
            DB::beginTransaction();

            JadwalLatihan::create($request->all());

            DB::commit();

            return redirect()->route('jadwal-latihan.index')
                ->with('success', 'Jadwal latihan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan jadwal latihan: ' . $e->getMessage());
        }
    }

    public function show(JadwalLatihan $jadwalLatihan)
    {
        $jadwalLatihan->load(['cabangOlahraga', 'pelatih', 'klub']);
        return view('admin.jadwal-latihan.show', compact('jadwalLatihan'));
    }

    public function edit(JadwalLatihan $jadwalLatihan)
    {
        $cabangOlahraga = Cabor::aktif()->get();
        $pelatih = Pelatih::aktif()->get();
        $klub = Klub::aktif()->get();

        return view('admin.jadwal-latihan.edit', compact('jadwalLatihan', 'cabangOlahraga', 'pelatih', 'klub'));
    }

    public function update(Request $request, JadwalLatihan $jadwalLatihan)
    {
        $request->validate(JadwalLatihan::rules($jadwalLatihan->id));

        try {
            DB::beginTransaction();

            $jadwalLatihan->update($request->all());

            DB::commit();

            return redirect()->route('jadwal-latihan.index')
                ->with('success', 'Jadwal latihan berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate jadwal latihan: ' . $e->getMessage());
        }
    }

    public function destroy(JadwalLatihan $jadwalLatihan)
    {
        try {
            $jadwalLatihan->delete();

            return redirect()->route('jadwal-latihan.index')
                ->with('success', 'Jadwal latihan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus jadwal latihan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, JadwalLatihan $jadwalLatihan)
    {
        $request->validate([
            'status' => 'required|in:aktif,selesai,dibatalkan'
        ]);

        try {
            $jadwalLatihan->update(['status' => $request->status]);

            return redirect()->back()
                ->with('success', 'Status jadwal latihan berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    // API untuk mendapatkan pelatih berdasarkan cabang olahraga
    public function getPelatihByCabor($caborId)
    {
        $pelatih = Pelatih::where('cabang_olahraga_id', $caborId)
            ->where('status', 'aktif')
            ->get(['id', 'nama']);

        return response()->json($pelatih);
    }

    // API untuk kalender
    public function getJadwalForCalendar(Request $request)
    {
        $jadwal = JadwalLatihan::with(['cabangOlahraga', 'pelatih'])
            ->where('status', 'aktif');

        if ($request->filled('start') && $request->filled('end')) {
            $jadwal->whereBetween('tanggal', [$request->start, $request->end]);
        }

        $events = $jadwal->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->nama_kegiatan,
                'start' => $item->tanggal->format('Y-m-d') . 'T' . Carbon::parse($item->jam_mulai)->format('H:i:s'),
                'end' => $item->tanggal->format('Y-m-d') . 'T' . Carbon::parse($item->jam_selesai)->format('H:i:s'),
                'backgroundColor' => '#007bff',
                'borderColor' => '#007bff',
                'extendedProps' => [
                    'type' => 'latihan',
                    'lokasi' => $item->lokasi,
                    'cabang_olahraga' => $item->cabangOlahraga->nama_cabang,
                    'pelatih' => $item->pelatih->nama,
                    'catatan' => $item->catatan
                ]
            ];
        });

        return response()->json($events);
    }
}