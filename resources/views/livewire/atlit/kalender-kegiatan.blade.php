<div>
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jadwal Latihan {{ $monthlyStats['month_name'] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $monthlyStats['total_latihan'] }} Jadwal
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dumbbell fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Event/Pertandingan {{ $monthlyStats['month_name'] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $monthlyStats['total_event'] }} Event
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kegiatan {{ $monthlyStats['month_name'] }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $monthlyStats['total_kegiatan'] }} Kegiatan
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Controls -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-alt"></i> Kalender Kegiatan -
                        {{ $atlit->cabangOlahraga->nama_cabang }}
                    </h6>
                    <div class="d-flex align-items-center">
                        <div class="legend mr-3">
                            <span class="badge badge-success">
                                <i class="fas fa-dumbbell"></i> Latihan
                            </span>
                            <span class="badge badge-primary ml-2">
                                <i class="fas fa-trophy"></i> Event
                            </span>
                        </div>
                        <button class="btn btn-primary btn-sm" wire:click="goToToday">
                            <i class="fas fa-calendar-day"></i> Hari Ini
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Calendar Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button class="btn btn-outline-primary btn-sm" wire:click="previousMonth">
                            <i class="fas fa-chevron-left"></i> Sebelumnya
                        </button>
                        <h4 class="mb-0 text-primary font-weight-bold">
                            {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}
                        </h4>
                        <button class="btn btn-outline-primary btn-sm" wire:click="nextMonth">
                            Selanjutnya <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="calendar-grid">
                        <!-- Day Headers -->
                        <div class="row calendar-header mb-2">
                            <div class="col text-center font-weight-bold text-muted">Min</div>
                            <div class="col text-center font-weight-bold text-muted">Sen</div>
                            <div class="col text-center font-weight-bold text-muted">Sel</div>
                            <div class="col text-center font-weight-bold text-muted">Rab</div>
                            <div class="col text-center font-weight-bold text-muted">Kam</div>
                            <div class="col text-center font-weight-bold text-muted">Jum</div>
                            <div class="col text-center font-weight-bold text-muted">Sab</div>
                        </div>

                        <!-- Calendar Days -->
                        @php $weekCounter = 0; @endphp
                        @foreach ($days->chunk(7) as $week)
                            <div class="row calendar-week mb-2">
                                @foreach ($week as $day)
                                    <div class="col calendar-day p-1">
                                        @if ($day)
                                            <div class="day-cell position-relative p-2 border rounded {{ $day['isToday'] ? 'bg-light border-primary' : '' }} {{ $day['isSelected'] ? 'bg-primary text-white' : '' }}"
                                                wire:click="selectDate('{{ $day['date'] }}')"
                                                style="cursor: pointer; min-height: 80px;">
                                                <div
                                                    class="day-number font-weight-bold {{ $day['isSelected'] ? 'text-white' : ($day['isToday'] ? 'text-primary' : 'text-gray-800') }}">
                                                    {{ $day['day'] }}
                                                </div>

                                                <!-- Events for this day -->
                                                @if ($day['events']->count() > 0)
                                                    <div class="events-container mt-1">
                                                        @foreach ($day['events']->take(2) as $event)
                                                            <div class="event-item badge badge-{{ $event['color'] }} d-block mb-1 text-truncate"
                                                                style="font-size: 9px; max-width: 100%;"
                                                                data-toggle="tooltip"
                                                                title="{{ $event['title'] }} - {{ $event['location'] }}">
                                                                <i class="{{ $event['icon'] }}"
                                                                    style="font-size: 8px;"></i>
                                                                {{ \Str::limit($event['title'], 8) }}
                                                            </div>
                                                        @endforeach

                                                        @if ($day['events']->count() > 2)
                                                            <div class="badge badge-secondary d-block"
                                                                style="font-size: 8px;">
                                                                +{{ $day['events']->count() - 2 }} lainnya
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="day-cell p-2" style="min-height: 80px;"></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Selected Date Events -->
    @if ($selectedDateEvents->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list"></i> Kegiatan pada
                            {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($selectedDateEvents as $event)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-{{ $event['color'] }} h-100">
                                        <div class="card-body">
                                            <h6 class="text-{{ $event['color'] }} mb-2">
                                                <i class="{{ $event['icon'] }}"></i> {{ $event['title'] }}
                                            </h6>
                                            <p class="text-sm mb-1">
                                                <i class="fas fa-map-marker-alt text-muted"></i>
                                                {{ $event['location'] }}
                                            </p>
                                            @if (isset($event['time']))
                                                <p class="text-sm mb-1">
                                                    <i class="fas fa-clock text-muted"></i> {{ $event['time'] }}
                                                </p>
                                            @endif

                                            @if ($event['type'] === 'latihan')
                                                <small class="text-muted">
                                                    Pelatih: {{ $event['details']['pelatih'] }}<br>
                                                    Klub: {{ $event['details']['klub'] }}
                                                </small>
                                            @else
                                                <small class="text-muted">
                                                    {{ $event['details']['jenis_event'] }}<br>
                                                    Penyelenggara: {{ $event['details']['penyelenggara'] }}
                                                </small>
                                            @endif

                                            @if ($event['type'] === 'event' && isset($event['end_date']) && $event['end_date'] !== $event['date'])
                                                <div class="mt-2">
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-calendar"></i> Multi-hari
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list"></i> Kegiatan pada
                            {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
                        </h6>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Tidak ada kegiatan pada tanggal ini.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <style>
        .calendar-day .day-cell {
            transition: all 0.2s ease;
        }

        .calendar-day .day-cell:hover {
            background-color: #f8f9fc !important;
            border-color: #4e73df !important;
            transform: translateY(-1px);
        }

        .event-item {
            font-weight: 500;
            line-height: 1.2;
        }

        .calendar-week:last-child .day-cell {
            margin-bottom: 0;
        }

        .day-number {
            font-size: 14px;
        }

        .events-container {
            max-height: 45px;
            overflow: hidden;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2) !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        @media (max-width: 768px) {
            .calendar-day {
                padding: 1px;
            }

            .day-cell {
                min-height: 60px !important;
            }

            .day-number {
                font-size: 12px;
            }

            .event-item {
                font-size: 8px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });

        document.addEventListener('livewire:update', function() {
            // Re-initialize tooltips after Livewire updates
            $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
        });
    </script>
@endpush
