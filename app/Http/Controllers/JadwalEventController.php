<?php

namespace App\Http\Controllers;

use App\Models\JadwalEvent;
use App\Models\Cabor;
use App\Models\Atlit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalEventController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalEvent::with(['cabangOlahraga']);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter berdasarkan cabang olahraga
        if ($request->filled('cabang_olahraga_id')) {
            $query->where('cabang_olahraga_id', $request->cabang_olahraga_id);
        }

        // Filter berdasarkan jenis event
        if ($request->filled('jenis_event')) {
            $query->where('jenis_event', $request->jenis_event);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jadwalEvent = $query->orderBy('tanggal_mulai', 'desc')
            ->paginate(10);

        $cabangOlahraga = Cabor::aktif()->get();

        return view('admin.jadwal-event.index', compact('jadwalEvent', 'cabangOlahraga'));
    }

    public function create()
    {
        $cabangOlahraga = Cabor::aktif()->get();
        return view('admin.jadwal-event.create', compact('cabangOlahraga'));
    }

    public function store(Request $request)
    {
        $request->validate(JadwalEvent::rules());

        try {
            DB::beginTransaction();

            $event = JadwalEvent::create($request->all());

            // Jika ada atlet yang dipilih untuk event
            if ($request->filled('atlit_ids')) {
                $event->atlit()->sync($request->atlit_ids);
            }

            DB::commit();

            return redirect()->route('jadwal-event.index')
                ->with('success', 'Jadwal event berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan jadwal event: ' . $e->getMessage());
        }
    }

    public function show(JadwalEvent $jadwalEvent)
    {
        $jadwalEvent->load(['cabangOlahraga', 'atlit']);
        return view('admin.jadwal-event.show', compact('jadwalEvent'));
    }

    public function edit(JadwalEvent $jadwalEvent)
    {
        $cabangOlahraga = Cabor::aktif()->get();
        $jadwalEvent->load(['atlit']);

        return view('admin.jadwal-event.edit', compact('jadwalEvent', 'cabangOlahraga'));
    }

    public function update(Request $request, JadwalEvent $jadwalEvent)
    {
        $request->validate(JadwalEvent::rules($jadwalEvent->id));

        try {
            DB::beginTransaction();

            $jadwalEvent->update($request->all());

            // Update atlet yang terlibat
            if ($request->has('atlit_ids')) {
                $jadwalEvent->atlit()->sync($request->atlit_ids ?? []);
            }

            DB::commit();

            return redirect()->route('jadwal-event.index')
                ->with('success', 'Jadwal event berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate jadwal event: ' . $e->getMessage());
        }
    }

    public function destroy(JadwalEvent $jadwalEvent)
    {
        try {
            DB::beginTransaction();

            // Hapus relasi dengan atlet terlebih dahulu
            $jadwalEvent->atlit()->detach();
            $jadwalEvent->delete();

            DB::commit();

            return redirect()->route('jadwal-event.index')
                ->with('success', 'Jadwal event berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menghapus jadwal event: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, JadwalEvent $jadwalEvent)
    {
        $request->validate([
            'status' => 'required|in:aktif,selesai,dibatalkan'
        ]);

        try {
            $jadwalEvent->update(['status' => $request->status]);

            return redirect()->back()
                ->with('success', 'Status jadwal event berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    // Halaman untuk mengelola atlet yang terlibat dalam event
    public function manageAtlit(JadwalEvent $jadwalEvent)
    {
        $jadwalEvent->load(['cabangOlahraga', 'atlit']);
        $availableAtlit = Atlit::where('cabang_olahraga_id', $jadwalEvent->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->get();

        return view('admin.jadwal-event.manage-atlit', compact('jadwalEvent', 'availableAtlit'));
    }

    // Update atlet yang terlibat dalam event
    public function updateAtlit(Request $request, JadwalEvent $jadwalEvent)
    {
        $request->validate([
            'atlit_ids' => 'nullable|array',
            'atlit_ids.*' => 'exists:atlit,id'
        ]);

        try {
            $jadwalEvent->atlit()->sync($request->atlit_ids ?? []);

            return redirect()->route('jadwal-event.show', $jadwalEvent)
                ->with('success', 'Daftar atlet berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate daftar atlet: ' . $e->getMessage());
        }
    }

    // API untuk mendapatkan atlet berdasarkan cabang olahraga
    public function getAtlitByCabor($caborId)
    {
        $atlit = Atlit::where('cabang_olahraga_id', $caborId)
            ->where('status', 'aktif')
            ->get(['id', 'nama_lengkap']);

        return response()->json($atlit);
    }

    // API untuk kalender
    public function getEventForCalendar(Request $request)
    {
        $events = JadwalEvent::with(['cabangOlahraga'])
            ->where('status', 'aktif');

        if ($request->filled('start') && $request->filled('end')) {
            $events->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->start, $request->end])
                    ->orWhereBetween('tanggal_selesai', [$request->start, $request->end])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tanggal_mulai', '<=', $request->start)
                            ->where('tanggal_selesai', '>=', $request->end);
                    });
            });
        }

        $eventData = $events->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->nama_event,
                'start' => $item->tanggal_mulai->format('Y-m-d'),
                'end' => $item->tanggal_selesai->addDay()->format('Y-m-d'), // FullCalendar end date is exclusive
                'backgroundColor' => $this->getEventColor($item->jenis_event),
                'borderColor' => $this->getEventColor($item->jenis_event),
                'extendedProps' => [
                    'type' => 'event',
                    'jenis_event' => $item->jenis_event,
                    'lokasi' => $item->lokasi,
                    'penyelenggara' => $item->penyelenggara,
                    'cabang_olahraga' => $item->cabangOlahraga->nama_cabang,
                    'deskripsi' => $item->deskripsi
                ]
            ];
        });

        return response()->json($eventData);
    }

    private function getEventColor($jenisEvent)
    {
        $colors = [
            'pertandingan' => '#dc3545', // Red
            'seleksi' => '#ffc107',      // Yellow
            'uji_coba' => '#17a2b8',     // Cyan
            'kejuaraan' => '#28a745',    // Green
        ];

        return $colors[$jenisEvent] ?? '#6c757d'; // Gray as default
    }
}