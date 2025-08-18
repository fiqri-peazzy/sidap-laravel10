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
                'detail_url' => route('jadwal-latihan.show', $jadwal->id)
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
                'detail_url' => route('jadwal-event.show', $event->id)
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
}
