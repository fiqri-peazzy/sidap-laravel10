<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Atlit;
use App\Models\Cabor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestasi::with(['atlit', 'cabangOlahraga'])
            ->orderBy('tahun', 'desc')
            ->orderBy('tanggal_mulai', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->byTahun($request->tahun);
        }

        // Filter cabang olahraga
        if ($request->filled('cabor_id')) {
            $query->byCabor($request->cabor_id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter peringkat
        if ($request->filled('peringkat')) {
            $query->where('peringkat', $request->peringkat);
        }

        $prestasi = $query->paginate(15)->withQueryString();

        // Data untuk filter
        $years = Prestasi::getAvailableYears();
        $cabors = Cabor::aktif()->orderBy('nama_cabang')->get();
        $statistik = Prestasi::getStatistikPrestasi([
            'tahun' => $request->tahun,
            'cabor_id' => $request->cabor_id
        ]);

        return view('admin.prestasi.index', compact('prestasi', 'years', 'cabors', 'statistik'));
    }

    public function create()
    {
        $atlits = Atlit::aktif()->with('klub')->orderBy('nama_lengkap')->get();
        $cabors = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('admin.prestasi.create', compact('atlits', 'cabors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Prestasi::rules());

        // Set tahun dari tanggal mulai jika tidak diisi
        if (!$validated['tahun']) {
            $validated['tahun'] = date('Y', strtotime($validated['tanggal_mulai']));
        }

        // Set medali otomatis berdasarkan peringkat
        if (!$validated['medali']) {
            $medaliMap = [
                '1' => 'Emas',
                '2' => 'Perak',
                '3' => 'Perunggu'
            ];
            $validated['medali'] = $medaliMap[$validated['peringkat']] ?? null;
        }

        // Handle upload sertifikat
        if ($request->hasFile('sertifikat')) {
            $file = $request->file('sertifikat');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('prestasi/sertifikat', $filename, 'public');
            $validated['sertifikat'] = $filename;
        }

        Prestasi::create($validated);

        return redirect()->route('prestasi.index')
            ->with('success', 'Data prestasi berhasil ditambahkan.');
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['atlit.klub', 'cabangOlahraga']);

        return view('admin.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $atlits = Atlit::aktif()->with('klub')->orderBy('nama_lengkap')->get();
        $cabors = Cabor::aktif()->orderBy('nama_cabang')->get();

        return view('admin.prestasi.edit', compact('prestasi', 'atlits', 'cabors'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate(Prestasi::rules($prestasi->id));

        // Set tahun dari tanggal mulai jika tidak diisi
        if (!$validated['tahun']) {
            $validated['tahun'] = date('Y', strtotime($validated['tanggal_mulai']));
        }

        // Set medali otomatis berdasarkan peringkat
        if (!$validated['medali']) {
            $medaliMap = [
                '1' => 'Emas',
                '2' => 'Perak',
                '3' => 'Perunggu'
            ];
            $validated['medali'] = $medaliMap[$validated['peringkat']] ?? null;
        }

        // Handle upload sertifikat baru
        if ($request->hasFile('sertifikat')) {
            // Hapus file lama
            if ($prestasi->sertifikat && Storage::exists('public/prestasi/sertifikat/' . $prestasi->sertifikat)) {
                Storage::delete('public/prestasi/sertifikat/' . $prestasi->sertifikat);
            }

            $file = $request->file('sertifikat');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('prestasi/sertifikat', $filename, 'public');
            $validated['sertifikat'] = $filename;
        }

        $prestasi->update($validated);

        return redirect()->route('prestasi.index')
            ->with('success', 'Data prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        // Hapus file sertifikat jika ada
        if ($prestasi->sertifikat && Storage::exists('public/prestasi/sertifikat/' . $prestasi->sertifikat)) {
            Storage::delete('public/prestasi/sertifikat/' . $prestasi->sertifikat);
        }

        $prestasi->delete();

        return redirect()->route('prestasi.index')
            ->with('success', 'Data prestasi berhasil dihapus.');
    }

    public function verify(Prestasi $prestasi)
    {
        $prestasi->update(['status' => 'verified']);

        return redirect()->back()
            ->with('success', 'Prestasi berhasil diverifikasi.');
    }

    public function reject(Prestasi $prestasi)
    {
        $prestasi->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', 'Prestasi berhasil ditolak.');
    }

    public function downloadSertifikat(Prestasi $prestasi)
    {
        if (!$prestasi->sertifikat || !Storage::exists('public/prestasi/sertifikat/' . $prestasi->sertifikat)) {
            abort(404);
        }

        $filePath = 'public/prestasi/sertifikat/' . $prestasi->sertifikat;
        $fileName = 'Sertifikat_' . $prestasi->atlit->nama_lengkap . '_' . $prestasi->nama_kejuaraan . '.' . pathinfo($prestasi->sertifikat, PATHINFO_EXTENSION);

        return Storage::download($filePath, $fileName);
    }

    // API endpoint untuk get atlit berdasarkan cabor
    public function getAtlitByCabor(Request $request)
    {
        $caborId = $request->cabor_id;
        $atlits = Atlit::aktif()
            ->where('cabang_olahraga_id', $caborId)
            ->with('klub')
            ->orderBy('nama_lengkap')
            ->get();

        return response()->json($atlits);
    }

    // Laporan prestasi
    public function laporan(Request $request)
    {
        $query = Prestasi::verified()->with(['atlit', 'cabangOlahraga']);

        // Filter tahun
        if ($request->filled('tahun')) {
            $query->byTahun($request->tahun);
        }

        // Filter cabang olahraga
        if ($request->filled('cabor_id')) {
            $query->byCabor($request->cabor_id);
        }

        $prestasi = $query->orderBy('tahun', 'desc')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $years = Prestasi::getAvailableYears();
        $cabors = Cabor::aktif()->orderBy('nama_cabang')->get();
        $statistik = Prestasi::getStatistikPrestasi([
            'tahun' => $request->tahun,
            'cabor_id' => $request->cabor_id
        ]);

        // Statistik per cabor
        $statistikPerCabor = Prestasi::verified()
            ->when($request->tahun, fn($q) => $q->byTahun($request->tahun))
            ->when($request->cabor_id, fn($q) => $q->byCabor($request->cabor_id))
            ->with('cabangOlahraga')
            ->get()
            ->groupBy('cabang_olahraga_id')
            ->map(function ($items) {
                return [
                    'nama_cabang' => $items->first()->cabangOlahraga->nama_cabang,
                    'total' => $items->count(),
                    'emas' => $items->where('medali', 'Emas')->count(),
                    'perak' => $items->where('medali', 'Perak')->count(),
                    'perunggu' => $items->where('medali', 'Perunggu')->count(),
                    'juara_1' => $items->where('peringkat', '1')->count(),
                    'juara_2' => $items->where('peringkat', '2')->count(),
                    'juara_3' => $items->where('peringkat', '3')->count(),
                ];
            });

        return view('admin.prestasi.laporan', compact('prestasi', 'years', 'cabors', 'statistik', 'statistikPerCabor'));
    }
}