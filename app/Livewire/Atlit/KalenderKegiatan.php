<?php

namespace App\Livewire\Atlit;

use Livewire\Component;
use App\Models\Atlit;
use App\Models\JadwalLatihan;
use App\Models\JadwalEvent;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;

class KalenderKegiatan extends Component
{
    public ?Atlit $atlit = null;
    public int $currentMonth;
    public int $currentYear;
    public ?string $selectedDate = null;

    /** @var Collection<int, array> */
    public Collection $events;

    /** @var array<string, mixed> */
    public array $monthlyStats = [];

    /** @var string */
    public string $viewMode = 'month'; // month, week, day

    public function mount(): void
    {
        $this->atlit = Atlit::where('user_id', auth()->id())
            ->with('cabangOlahraga')
            ->first();

        if (!$this->atlit) {
            abort(403, 'Data atlit tidak ditemukan');
        }

        $this->currentMonth = (int) now()->month;
        $this->currentYear  = (int) now()->year;
        $this->selectedDate = now()->format('Y-m-d');

        $this->events = collect();

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function loadEvents(): void
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate   = $startDate->copy()->endOfMonth();

        $jadwalLatihan = JadwalLatihan::where('cabang_olahraga_id', $this->atlit->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->with(['cabangOlahraga', 'pelatih', 'klub'])
            ->get();

        $jadwalEvent = JadwalEvent::where('cabang_olahraga_id', $this->atlit->cabang_olahraga_id)
            ->where('status', 'aktif')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_mulai', [$startDate, $endDate])
                    ->orWhereBetween('tanggal_selesai', [$startDate, $endDate]);
            })
            ->with(['cabangOlahraga'])
            ->get();

        $this->events = collect();

        foreach ($jadwalLatihan as $latihan) {
            $this->events->push([
                'id'    => $latihan->id,
                'title' => $latihan->nama_kegiatan,
                'date'  => $latihan->tanggal->format('Y-m-d'),
                'type'  => 'latihan',
                'color' => 'success',
                'icon'  => 'fas fa-dumbbell',
                'time'  => $latihan->jam_mulai ? $latihan->jam_mulai->format('H:i') : null,
                'location' => $latihan->lokasi,
                'details'  => [
                    'pelatih' => $latihan->pelatih?->nama ?? '-',
                    'klub'    => $latihan->klub?->nama_klub ?? '-',
                    'catatan' => $latihan->catatan ?: '-',
                ],
            ]);
        }

        foreach ($jadwalEvent as $event) {
            $this->events->push([
                'id'       => $event->id,
                'title'    => $event->nama_event,
                'date'     => $event->tanggal_mulai->format('Y-m-d'),
                'end_date' => $event->tanggal_selesai->format('Y-m-d'),
                'type'     => 'event',
                'color'    => 'primary',
                'icon'     => 'fas fa-trophy',
                'location' => $event->lokasi,
                'details'  => [
                    'jenis_event'   => $event->jenis_event,
                    'penyelenggara' => $event->penyelenggara,
                    'deskripsi'     => $event->deskripsi ?: '-',
                ],
            ]);
        }
    }

    public function loadMonthlyStats(): void
    {
        $startDate = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $endDate   = $startDate->copy()->endOfMonth();

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
            'total_latihan'   => $totalLatihan,
            'total_event'     => $totalEvent,
            'total_kegiatan'  => $totalLatihan + $totalEvent,
            'month_name'      => Carbon::create($this->currentYear, $this->currentMonth, 1)->format('F Y'),
        ];
    }

    public function previousMonth(): void
    {
        if ($this->currentMonth === 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function nextMonth(): void
    {
        if ($this->currentMonth === 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function goToToday(): void
    {
        $this->currentMonth = (int) now()->month;
        $this->currentYear  = (int) now()->year;
        $this->selectedDate = now()->format('Y-m-d');

        $this->loadEvents();
        $this->loadMonthlyStats();
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
    }

    public function changeViewMode(string $mode): void
    {
        $this->viewMode = $mode;
    }

    /** @return Collection<int, array> */
    public function getEventsForDate(string $date): Collection
    {
        return $this->events->filter(function (array $event) use ($date) {
            if ($event['type'] === 'event' && isset($event['end_date'])) {
                return $date >= $event['date'] && $date <= $event['end_date'];
            }
            return $event['date'] === $date;
        });
    }

    /** @return Collection<int, array|null> */
    public function getDaysInMonth(): Collection
    {
        $startOfMonth   = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth    = $startOfMonth->daysInMonth;
        $firstDayOfWeek = $startOfMonth->dayOfWeek; // 0 = Sunday

        $days = collect();

        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $days->push(null);
        }

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $days->push([
                'date'       => $date->format('Y-m-d'),
                'day'        => $day,
                'isToday'    => $date->isToday(),
                'isSelected' => $date->format('Y-m-d') === $this->selectedDate,
                'events'     => $this->getEventsForDate($date->format('Y-m-d')),
            ]);
        }

        return $days;
    }

    public function render(): View
    {
        return view('livewire.atlit.kalender-kegiatan', [
            'days'              => $this->getDaysInMonth(),
            'selectedDateEvents' => $this->getEventsForDate($this->selectedDate ?? now()->format('Y-m-d')),
        ]);
    }
}
