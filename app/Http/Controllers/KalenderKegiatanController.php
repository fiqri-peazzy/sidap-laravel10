<?php

namespace App\Http\Controllers;

use App\Http\Controllers\JadwalLatihanController;
use App\Http\Controllers\JadwalEventController;
use App\Models\Cabor;
use Illuminate\Http\Request;

class KalenderKegiatanController extends Controller
{
    protected $jadwalLatihanController;
    protected $jadwalEventController;

    public function __construct()
    {
        $this->jadwalLatihanController = new JadwalLatihanController();
        $this->jadwalEventController = new JadwalEventController();
    }

    public function index()
    {
        $cabangOlahraga = Cabor::aktif()->get();
        return view('admin.kalender-kegiatan.index', compact('cabangOlahraga'));
    }

    public function getAllEvents(Request $request)
    {
        // Mengambil jadwal latihan
        $jadwalLatihan = $this->jadwalLatihanController->getJadwalForCalendar($request);
        $latihanEvents = json_decode($jadwalLatihan->getContent(), true);

        // Mengambil jadwal event
        $jadwalEvent = $this->jadwalEventController->getEventForCalendar($request);
        $eventEvents = json_decode($jadwalEvent->getContent(), true);

        // Menggabungkan semua events
        $allEvents = array_merge($latihanEvents, $eventEvents);

        return response()->json($allEvents);
    }

    public function filterEvents(Request $request)
    {
        $events = collect();

        // Filter berdasarkan jenis kegiatan
        if ($request->filled('show_latihan') && $request->show_latihan == 'true') {
            $jadwalLatihan = $this->jadwalLatihanController->getJadwalForCalendar($request);
            $latihanEvents = json_decode($jadwalLatihan->getContent(), true);
            $events = $events->merge($latihanEvents);
        }

        if ($request->filled('show_event') && $request->show_event == 'true') {
            $jadwalEvent = $this->jadwalEventController->getEventForCalendar($request);
            $eventEvents = json_decode($jadwalEvent->getContent(), true);
            $events = $events->merge($eventEvents);
        }

        if ($request->filled('cabang_olahraga_id')) {
            $events = $events->filter(function ($event) use ($request) {
                // Implementasi filter berdasarkan cabang olahraga
                // Perlu disesuaikan dengan struktur data
                return true; // Sementara return true
            });
        }

        return response()->json($events->values());
    }

    public function getEventDetail(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        if ($type === 'latihan') {
            $jadwal = \App\Models\JadwalLatihan::with(['cabangOlahraga', 'pelatih', 'klub'])
                ->find($id);

            if (!$jadwal) {
                return response()->json(['error' => 'Jadwal tidak ditemukan'], 404);
            }

            return response()->json([
                'title' => $jadwal->nama_kegiatan,
                'type' => 'Jadwal Latihan',
                'date' => $jadwal->tanggal->format('d/m/Y'),
                'time' => $jadwal->jam_latihan,
                'location' => $jadwal->lokasi,
                'cabang_olahraga' => $jadwal->cabangOlahraga->nama_cabang,
                'pelatih' => $jadwal->pelatih->nama,
                'klub' => $jadwal->klub ? $jadwal->klub->nama_klub : '-',
                'catatan' => $jadwal->catatan ?: '-',
                'status' => $jadwal->status,
                'duration' => $jadwal->durasi,
                'detail_url' => route('admin.jadwal-latihan.show', $jadwal->id)
            ]);
        } elseif ($type === 'event') {
            $event = \App\Models\JadwalEvent::with(['cabangOlahraga', 'atlit'])
                ->find($id);

            if (!$event) {
                return response()->json(['error' => 'Event tidak ditemukan'], 404);
            }

            return response()->json([
                'title' => $event->nama_event,
                'type' => 'Event/Pertandingan',
                'jenis_event' => $event->jenis_event,
                'start_date' => $event->tanggal_mulai->format('d/m/Y'),
                'end_date' => $event->tanggal_selesai->format('d/m/Y'),
                'location' => $event->lokasi,
                'organizer' => $event->penyelenggara,
                'cabang_olahraga' => $event->cabangOlahraga->nama_cabang,
                'description' => $event->deskripsi ?: '-',
                'status' => $event->status,
                'duration' => $event->durasi_event,
                'jumlah_atlet' => $event->jumlah_atlet,
                'detail_url' => route('admin.jadwal-event.show', $event->id)
            ]);
        }

        return response()->json(['error' => 'Tipe tidak valid'], 400);
    }

    public function exportCalendar(Request $request)
    {
        // Implementasi export kalender ke format iCal
        // Bisa ditambahkan nanti jika diperlukan
        return response()->json(['message' => 'Export calendar feature coming soon']);
    }

    public function indexAtlit()
    {
        // Mendapatkan data atlit yang sedang login
        $atlit = \App\Models\Atlit::where('user_id', auth()->id())
            ->with('cabangOlahraga')
            ->first();

        if (!$atlit) {
            abort(403, 'Data atlit tidak ditemukan');
        }

        return view('atlit.kalender-kegiatan-index', compact('atlit'));
    }

    /**
     * Mengambil semua events untuk atlit (jadwal latihan dan event)
     */
    public function getAllEventsAtlit(Request $request)
    {
        // Mendapatkan data atlit yang sedang login
        $atlit = \App\Models\Atlit::where('user_id', auth()->id())->first();

        if (!$atlit) {
            return response()->json(['error' => 'Data atlit tidak ditemukan'], 403);
        }

        $cabangOlahragaId = $atlit->cabang_olahraga_id;

        // Mengambil jadwal latihan sesuai cabor atlit
        $jadwalLatihan = \App\Models\JadwalLatihan::where('cabang_olahraga_id', $cabangOlahragaId)
            ->where('status', 'aktif')
            ->with(['cabangOlahraga', 'pelatih', 'klub'])
            ->get();

        // Mengambil jadwal event sesuai cabor atlit
        $jadwalEvent = \App\Models\JadwalEvent::where('cabang_olahraga_id', $cabangOlahragaId)
            ->where('status', 'aktif')
            ->with(['cabangOlahraga', 'atlit'])
            ->get();

        $events = collect();

        // Format jadwal latihan untuk kalender
        foreach ($jadwalLatihan as $latihan) {
            $events->push([
                'id' => $latihan->id,
                'title' => $latihan->nama_kegiatan,
                'start' => $latihan->tanggal->format('Y-m-d'),
                'backgroundColor' => '#28a745', // Hijau untuk latihan
                'borderColor' => '#28a745',
                'textColor' => '#ffffff',
                'type' => 'latihan',
                'extendedProps' => [
                    'type' => 'latihan',
                    'location' => $latihan->lokasi,
                    'jam_mulai' => $latihan->jam_mulai,
                    'jam_selesai' => $latihan->jam_selesai,
                    'pelatih' => $latihan->pelatih ? $latihan->pelatih->nama : '-',
                    'klub' => $latihan->klub ? $latihan->klub->nama_klub : '-'
                ]
            ]);
        }

        // Format jadwal event untuk kalender
        foreach ($jadwalEvent as $event) {
            $events->push([
                'id' => $event->id,
                'title' => $event->nama_event,
                'start' => $event->tanggal_mulai->format('Y-m-d'),
                'end' => $event->tanggal_selesai->addDay()->format('Y-m-d'), // +1 untuk FullCalendar
                'backgroundColor' => '#007bff', // Biru untuk event
                'borderColor' => '#007bff',
                'textColor' => '#ffffff',
                'type' => 'event',
                'extendedProps' => [
                    'type' => 'event',
                    'jenis_event' => $event->jenis_event,
                    'location' => $event->lokasi,
                    'penyelenggara' => $event->penyelenggara,
                    'tanggal_selesai' => $event->tanggal_selesai->format('Y-m-d')
                ]
            ]);
        }

        return response()->json($events->values());
    }

    /**
     * Mengambil detail event/latihan untuk modal
     */
    public function getEventDetailAtlit(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        // Mendapatkan data atlit yang sedang login
        $atlit = \App\Models\Atlit::where('user_id', auth()->id())->first();

        if (!$atlit) {
            return response()->json(['error' => 'Data atlit tidak ditemukan'], 403);
        }

        $cabangOlahragaId = $atlit->cabang_olahraga_id;

        if ($type === 'latihan') {
            $jadwal = \App\Models\JadwalLatihan::with(['cabangOlahraga', 'pelatih', 'klub'])
                ->where('cabang_olahraga_id', $cabangOlahragaId)
                ->find($id);

            if (!$jadwal) {
                return response()->json(['error' => 'Jadwal tidak ditemukan'], 404);
            }

            return response()->json([
                'title' => $jadwal->nama_kegiatan,
                'type' => 'Jadwal Latihan',
                'date' => $jadwal->tanggal->format('d F Y'),
                'jam_mulai' => $jadwal->jam_mulai ? $jadwal->jam_mulai->format('H:i') : '-',
                'jam_selesai' => $jadwal->jam_selesai ? $jadwal->jam_selesai->format('H:i') : '-',
                'location' => $jadwal->lokasi,
                'cabang_olahraga' => $jadwal->cabangOlahraga->nama_cabang,
                'pelatih' => $jadwal->pelatih ? $jadwal->pelatih->nama : '-',
                'klub' => $jadwal->klub ? $jadwal->klub->nama_klub : '-',
                'catatan' => $jadwal->catatan ?: '-',
                'status' => $jadwal->status,
                'color' => '#28a745'
            ]);
        } elseif ($type === 'event') {
            $event = \App\Models\JadwalEvent::with(['cabangOlahraga', 'atlit'])
                ->where('cabang_olahraga_id', $cabangOlahragaId)
                ->find($id);

            if (!$event) {
                return response()->json(['error' => 'Event tidak ditemukan'], 404);
            }

            return response()->json([
                'title' => $event->nama_event,
                'type' => 'Event/Pertandingan',
                'jenis_event' => $event->jenis_event,
                'start_date' => $event->tanggal_mulai->format('d F Y'),
                'end_date' => $event->tanggal_selesai->format('d F Y'),
                'location' => $event->lokasi,
                'organizer' => $event->penyelenggara,
                'cabang_olahraga' => $event->cabangOlahraga->nama_cabang,
                'description' => $event->deskripsi ?: '-',
                'status' => $event->status,
                'color' => '#007bff'
            ]);
        }

        return response()->json(['error' => 'Tipe tidak valid'], 400);
    }

    /**
     * Mengambil events berdasarkan bulan untuk atlit
     */
    public function getEventsByMonth(Request $request)
    {
        $atlit = \App\Models\Atlit::where('user_id', auth()->id())->first();

        if (!$atlit) {
            return response()->json(['error' => 'Data atlit tidak ditemukan'], 403);
        }

        $month = $request->month; // format: 2024-01
        $cabangOlahragaId = $atlit->cabang_olahraga_id;

        // Parse bulan dan tahun
        $date = \Carbon\Carbon::createFromFormat('Y-m', $month);
        $startOfMonth = $date->startOfMonth()->toDateString();
        $endOfMonth = $date->endOfMonth()->toDateString();

        // Hitung jadwal latihan dalam bulan ini
        $countLatihan = \App\Models\JadwalLatihan::where('cabang_olahraga_id', $cabangOlahragaId)
            ->where('status', 'aktif')
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->count();

        // Hitung jadwal event dalam bulan ini
        $countEvent = \App\Models\JadwalEvent::where('cabang_olahraga_id', $cabangOlahragaId)
            ->where('status', 'aktif')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
            })
            ->count();

        return response()->json([
            'month' => $date->format('F Y'),
            'total_latihan' => $countLatihan,
            'total_event' => $countEvent,
            'total_kegiatan' => $countLatihan + $countEvent
        ]);
    }
}