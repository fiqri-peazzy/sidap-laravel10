@extends('layouts.app')

@section('title', 'Kalender Kegiatan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar text-primary"></i> Kalender Kegiatan
            </h1>
            <div class="d-flex align-items-center">
                <span class="badge badge-info mr-2">
                    <i class="fas fa-running"></i> {{ $atlit->cabangOlahraga->nama_cabang }}
                </span>
            </div>
        </div>

        <!-- Calendar Card -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-calendar-alt"></i> Kalender Kegiatan -
                            {{ $atlit->cabangOlahraga->nama_cabang }}
                        </h6>
                        <div class="d-flex align-items-center">
                            <div class="legend mr-3">
                                <span class="badge" style="background-color: #28a745;">
                                    <i class="fas fa-dumbbell"></i> Latihan
                                </span>
                                <span class="badge ml-2" style="background-color: #007bff;">
                                    <i class="fas fa-trophy"></i> Event
                                </span>
                            </div>
                            <button class="btn btn-primary btn-sm" id="todayBtn">
                                <i class="fas fa-calendar-day"></i> Hari Ini
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jadwal Latihan Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="monthlyTraining">
                                    <i class="fas fa-spinner fa-spin"></i>
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
                                    Event/Pertandingan Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="monthlyEvents">
                                    <i class="fas fa-spinner fa-spin"></i>
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
                                    Total Kegiatan Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalActivities">
                                    <i class="fas fa-spinner fa-spin"></i>
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
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailModalLabel">
                        <i class="fas fa-info-circle"></i> Detail Kegiatan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="eventDetailContent">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2">Memuat detail...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <style>
        .fc-toolbar-title {
            color: #5a5c69 !important;
            font-weight: bold;
        }

        .fc-button-primary {
            background-color: #4e73df !important;
            border-color: #4e73df !important;
        }

        .fc-button-primary:hover {
            background-color: #2e59d9 !important;
            border-color: #2e59d9 !important;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 4px;
        }

        .fc-event:hover {
            opacity: 0.8;
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        .legend .badge {
            color: white;
            padding: 5px 10px;
            font-size: 12px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2) !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('{{ route('atlit.kalender.events') }}')
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    showEventDetail(info.event.extendedProps.type, info.event.id);
                },
                eventMouseEnter: function(info) {
                    info.el.style.transform = 'scale(1.05)';
                    info.el.style.zIndex = '1000';
                },
                eventMouseLeave: function(info) {
                    info.el.style.transform = 'scale(1)';
                    info.el.style.zIndex = 'auto';
                },
                datesSet: function(dateInfo) {
                    // Update statistik ketika bulan berubah
                    const currentMonth = dateInfo.start.getFullYear() + '-' + String(dateInfo.start
                        .getMonth() + 1).padStart(2, '0');
                    updateMonthlyStats(currentMonth);
                }
            });

            calendar.render();

            // Event listener untuk tombol "Hari Ini"
            document.getElementById('todayBtn').addEventListener('click', function() {
                calendar.today();
            });

            // Update statistik bulan ini saat halaman dimuat
            const currentMonth = new Date().getFullYear() + '-' + String(new Date().getMonth() + 1).padStart(2,
                '0');
            updateMonthlyStats(currentMonth);
        });

        function showEventDetail(type, id) {
            $('#eventDetailModal').modal('show');
            document.getElementById('eventDetailContent').innerHTML = `
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
            <p class="mt-2">Memuat detail...</p>
        </div>
    `;

            fetch(`{{ route('atlit.kalender.event-detail') }}?type=${type}&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    let content = '';
                    if (type === 'latihan') {
                        content = `
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <h5 class="text-success mb-3">
                                        <i class="fas fa-dumbbell"></i> ${data.title}
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong><i class="fas fa-calendar"></i> Tanggal:</strong><br>${data.date}</p>
                                            <p><strong><i class="fas fa-clock"></i> Waktu:</strong><br>${data.jam_mulai} - ${data.jam_selesai}</p>
                                            <p><strong><i class="fas fa-map-marker-alt"></i> Lokasi:</strong><br>${data.location}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong><i class="fas fa-running"></i> Cabang Olahraga:</strong><br>${data.cabang_olahraga}</p>
                                            <p><strong><i class="fas fa-user-tie"></i> Pelatih:</strong><br>${data.pelatih}</p>
                                            <p><strong><i class="fas fa-users"></i> Klub:</strong><br>${data.klub}</p>
                                        </div>
                                    </div>
                                    ${data.catatan !== '-' ? `<p><strong><i class="fas fa-sticky-note"></i> Catatan:</strong><br>${data.catatan}</p>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    } else {
                        content = `
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-left-info">
                                <div class="card-body">
                                    <h5 class="text-info mb-3">
                                        <i class="fas fa-trophy"></i> ${data.title}
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong><i class="fas fa-tag"></i> Jenis Event:</strong><br>${data.jenis_event}</p>
                                            <p><strong><i class="fas fa-calendar"></i> Tanggal Mulai:</strong><br>${data.start_date}</p>
                                            <p><strong><i class="fas fa-calendar-check"></i> Tanggal Selesai:</strong><br>${data.end_date}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong><i class="fas fa-map-marker-alt"></i> Lokasi:</strong><br>${data.location}</p>
                                            <p><strong><i class="fas fa-building"></i> Penyelenggara:</strong><br>${data.organizer}</p>
                                            <p><strong><i class="fas fa-running"></i> Cabang Olahraga:</strong><br>${data.cabang_olahraga}</p>
                                        </div>
                                    </div>
                                    ${data.description !== '-' ? `<p><strong><i class="fas fa-info-circle"></i> Deskripsi:</strong><br>${data.description}</p>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    }

                    document.getElementById('eventDetailContent').innerHTML = content;
                })
                .catch(error => {
                    document.getElementById('eventDetailContent').innerHTML = `
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Error!</strong> ${error.message}
                </div>
            `;
                });
        }

        function updateMonthlyStats(month) {
            fetch(`{{ route('atlit.kalender.events-by-month') }}?month=${month}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('monthlyTraining').innerHTML = data.total_latihan + ' Jadwal';
                    document.getElementById('monthlyEvents').innerHTML = data.total_event + ' Event';
                    document.getElementById('totalActivities').innerHTML = data.total_kegiatan + ' Kegiatan';
                })
                .catch(error => {
                    console.error('Error fetching monthly stats:', error);
                    document.getElementById('monthlyTraining').innerHTML = '- Jadwal';
                    document.getElementById('monthlyEvents').innerHTML = '- Event';
                    document.getElementById('totalActivities').innerHTML = '- Kegiatan';
                });
        }
    </script>
@endpush
