<?php

namespace App\Livewire\Atlit;

use Livewire\Component;
use App\Models\Atlit;
use App\Models\JadwalLatihan;
use App\Models\JadwalEvent;
use Carbon\Carbon;

class KalenderKegiatan extends Component
{
    public $atlit;
    public $currentMonth;
    public $currentYear;
    public $selectedDate;
    public $events = [];
    public $monthlyStats = [];
    public $viewMode = 'month'; // month, week, day

    public function mount()
    {
        $this->atlit = Atlit::where('user_id', auth()->id())
            ->with('cabangOlahraga')
            ->first();

        if (!$this->atlit) {
            abort(403, 'Data atlit tidak ditemukan');
        }

        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = now()->format('Y-m-d');

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function loadEvents()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Load jadwal latihan
        $jadwalLatihan = JadwalLatihan::where('cabang_olahraga_id', $this->atlit->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->with(['cabangOlahraga', 'pelatih', 'klub'])
            ->get();

        // Load jadwal event
        $jadwalEvent = JadwalEvent::where('cabang_olahraga_id', $this->atlit->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate]);
            })
            ->with(['cabangOlahraga'])
            ->get();

        $this->events = collect();

        // Format jadwal latihan
        foreach ($jadwalLatihan as $latihan) {
            $this->events->push([
                'id' => $latihan->id,
                'title' => $latihan->nama_kegiatan,
                'date' => $latihan->tanggal->format('Y-m-d'),
                'type' => 'latihan',
                'color' => 'success',
                'icon' => 'fas fa-dumbbell',
                'time' => $latihan->jam_mulai ? $latihan->jam_mulai->format('H:i') : null,
                'location' => $latihan->lokasi,
                'details' => [
                    'pelatih' => $latihan->pelatih ? $latihan->pelatih->nama : '-',
                    'klub' => $latihan->klub ? $latihan->klub->nama_klub : '-',
                    'catatan' => $latihan->catatan ?: '-'
                ]
            ]);
        }

        // Format jadwal event
        foreach ($jadwalEvent as $event) {
            $this->events->push([
                'id' => $event->id,
                'title' => $event->nama_event,
                'date' => $event->tanggal_mulai->format('Y-m-d'),
                'end_date' => $event->tanggal_selesai->format('Y-m-d'),
                'type' => 'event',
                'color' => 'primary',
                'icon' => 'fas fa-trophy',
                'location' => $event->lokasi,
                'details' => [
                    'jenis_event' => $event->jenis_event,
                    'penyelenggara' => $event->penyelenggara,
                    'deskripsi' => $event->deskripsi ?: '-'
                ]
            ]);
        }
    }

    public function loadMonthlyStats()
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $totalLatihan = JadwalLatihan::where('cabang_olahraga_id', $this->atlit->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->count();

        $totalEvent = JadwalEvent::where('cabang_olahraga_id', $this->atlit->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate]);
            })
            ->count();

        $this->monthlyStats = [
            'total_latihan' => $totalLatihan,
            'total_event' => $totalEvent,
            'total_kegiatan' => $totalLatihan + $totalEvent,
            'month_name' => Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F Y')
        ];
    }

    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function goToToday()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = now()->format('Y-m-d');

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function changeViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function getEventsForDate($date)
    {
        return $this->events->filter(function ($event) use ($date) {
            if ($event['type'] === 'event' && isset($event['end_date'])) {
                return $date >= $event['date'] && $date <= $event['end_date'];
            }
            return $event['date'] === $date;
        });
    }

    public function getDaysInMonth()
    {
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $firstDayOfWeek = $startOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.

        $days = collect();

        // Add empty days for the first week
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $days->push(null);
        }

        // Add actual days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $days->push([
                'date' => $date->format('Y-m-d'),
                'day' => $day,
                'isToday' => $date->isToday(),
                'isSelected' => $date->format('Y-m-d') === $this->selectedDate,
                'events' => $this->getEventsForDate($date->format('Y-m-d'))
            ]);
        }

        return $days;
    }

    public function render()
    {
        return view('livewire.atlit.kalender-kegiatan', [
            'days' => $this->getDaysInMonth(),
            'selectedDateEvents' => $this->getEventsForDate($this->selectedDate)
        ]);
    }
}
