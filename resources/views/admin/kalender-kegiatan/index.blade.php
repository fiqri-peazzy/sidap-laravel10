@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                Kalender Kegiatan
            </h1>
            <p class="mb-0 text-gray-600 small mt-1">Sistem Informasi Data Atlit PPLP Provinsi Gorontalo</p>
        </div>
        <div class="btn-group shadow-sm">
            <a href="{{ route('jadwal-latihan.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus fa-sm mr-1"></i> Jadwal Latihan
            </a>
            <a href="{{ route('jadwal-event.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus fa-sm mr-1"></i> Jadwal Event
            </a>
        </div>
    </div>

    <!-- Filter Card - Fixed -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-filter mr-2"></i>Filter Kalender
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="text-dark font-weight-bold mb-2">Cabang Olahraga</label>
                    <select id="filter_cabang_olahraga" class="form-control">
                        <option value="">Semua Cabang Olahraga</option>
                        @foreach ($cabangOlahraga as $cabor)
                            <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="text-dark font-weight-bold mb-2">Jenis Kegiatan</label>
                    <div class="p-3 bg-light rounded">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="show_latihan" checked>
                            <label class="form-check-label" for="show_latihan">
                                <span class="badge badge-primary">Jadwal Latihan</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="show_event" checked>
                            <label class="form-check-label" for="show_event">
                                <span class="badge badge-success">Event/Pertandingan</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="text-dark font-weight-bold mb-2">Tampilan</label>
                    <div class="btn-group d-block" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" id="btn-month"
                            onclick="changeView('dayGridMonth')">
                            <i class="fas fa-calendar mr-1"></i>Bulan
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-week"
                            onclick="changeView('timeGridWeek')">
                            <i class="fas fa-calendar-week mr-1"></i>Minggu
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="btn-day"
                            onclick="changeView('timeGridDay')">
                            <i class="fas fa-calendar-day mr-1"></i>Hari
                        </button>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-info btn-sm" onclick="refreshCalendar()">
                            <i class="fas fa-sync-alt mr-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Card - Fixed -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-gradient-success text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-calendar-check mr-2"></i>Kalender Kegiatan PPLP Gorontalo
            </h6>
        </div>
        <div class="card-body p-3">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Legend Card - Fixed -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-gradient-info text-white py-3">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-palette mr-2"></i>Keterangan Warna
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary font-weight-bold mb-3">
                        <i class="fas fa-dumbbell mr-1"></i>Jadwal Latihan:
                    </h6>
                    <div class="legend-item mb-2 d-flex align-items-center">
                        <div class="legend-color mr-2"
                            style="width: 20px; height: 20px; background-color: #4e73df; border-radius: 4px;"></div>
                        <span class="text-dark">Jadwal Latihan Rutin</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-success font-weight-bold mb-3">
                        <i class="fas fa-trophy mr-1"></i>Event/Pertandingan:
                    </h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="legend-item mb-2 d-flex align-items-center">
                                <div class="legend-color mr-2"
                                    style="width: 20px; height: 20px; background-color: #dc3545; border-radius: 4px;"></div>
                                <small class="text-dark">Pertandingan</small>
                            </div>
                            <div class="legend-item mb-2 d-flex align-items-center">
                                <div class="legend-color mr-2"
                                    style="width: 20px; height: 20px; background-color: #ffc107; border-radius: 4px;"></div>
                                <small class="text-dark">Seleksi</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="legend-item mb-2 d-flex align-items-center">
                                <div class="legend-color mr-2"
                                    style="width: 20px; height: 20px; background-color: #17a2b8; border-radius: 4px;"></div>
                                <small class="text-dark">Uji Coba</small>
                            </div>
                            <div class="legend-item mb-2 d-flex align-items-center">
                                <div class="legend-color mr-2"
                                    style="width: 20px; height: 20px; background-color: #28a745; border-radius: 4px;">
                                </div>
                                <small class="text-dark">Kejuaraan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal - Enhanced -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="eventTitle">
                        <i class="fas fa-info-circle mr-2"></i>Detail Kegiatan
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4" id="eventDetails">
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2">Memuat detail kegiatan...</p>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Tutup
                    </button>
                    <a href="#" id="eventDetailLink" class="btn btn-primary" style="display: none;">
                        <i class="fas fa-eye mr-1"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <link href="{{ asset('template/css/kalender-custom.css') }}" rel="stylesheet">
    <style>
        /* Modern improvements while keeping SB Admin 2 style */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        }

        .card {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        /* FullCalendar styling improvements */
        #calendar {
            background: white;
            border-radius: 8px;
            padding: 15px;
            border: 1px solid #e3e6f0;
        }

        .fc-header-toolbar {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: #f8f9fc;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }

        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #5a5c69;
        }

        .fc-button {
            background: #4e73df !important;
            border-color: #4e73df !important;
            border-radius: 6px !important;
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            transition: all 0.15s ease-in-out;
        }

        .fc-button:hover {
            background: #2e59d9 !important;
            border-color: #2e59d9 !important;
            transform: translateY(-1px);
        }

        .fc-button:disabled {
            background: #858796 !important;
            border-color: #858796 !important;
        }

        .fc-button-primary:not(:disabled).fc-button-active {
            background: #224abe !important;
            border-color: #224abe !important;
        }

        .fc-daygrid-day-number {
            color: #5a5c69;
            font-weight: 500;
        }

        .fc-daygrid-day:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .fc-daygrid-day.fc-day-today {
            background-color: rgba(28, 200, 138, 0.1) !important;
        }

        .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background: #1cc88a;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 5px auto;
        }

        /* Event styling improvements */
        .fc-event {
            border: none !important;
            border-radius: 4px !important;
            font-weight: 500 !important;
            padding: 2px 6px !important;
            margin: 1px !important;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 0.75rem !important;
        }

        .fc-event:hover {
            transform: scale(1.02);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        .fc-event-title {
            font-weight: 600 !important;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Event colors based on type */
        .fc-event.event-latihan {
            background-color: #4e73df !important;
        }

        .fc-event.event-pertandingan {
            background-color: #dc3545 !important;
        }

        .fc-event.event-seleksi {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .fc-event.event-ujicoba {
            background-color: #17a2b8 !important;
        }

        .fc-event.event-kejuaraan {
            background-color: #28a745 !important;
        }

        /* View toggle buttons */
        .btn-outline-primary.active {
            background-color: #4e73df !important;
            border-color: #4e73df !important;
            color: white !important;
        }

        /* Legend improvements */
        .legend-item {
            transition: all 0.2s ease;
        }

        .legend-item:hover {
            transform: translateX(3px);
        }

        .legend-color {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Modal improvements */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            border-radius: 10px 10px 0 0;
        }

        .info-item {
            background: #f8f9fc;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #4e73df;
        }

        .info-item strong {
            display: block;
            margin-bottom: 5px;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .fc-header-toolbar {
                flex-direction: column;
            }

            .fc-toolbar-chunk {
                margin: 5px 0;
            }

            .fc-event-title {
                font-size: 0.7rem !important;
            }

            .btn-group .btn {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }
        }

        /* Loading state */
        .calendar-loading {
            position: relative;
        }

        .calendar-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            border-radius: 8px;
        }

        .calendar-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            margin: -20px 0 0 -20px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4e73df;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 1001;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales/id.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                height: 'auto',
                eventDisplay: 'block',
                dayMaxEvents: 3,
                moreLinkClick: 'popover',
                events: function(fetchInfo, successCallback, failureCallback) {
                    loadCalendarEvents(fetchInfo, successCallback, failureCallback);
                },
                eventClick: function(info) {
                    showEventDetail(info.event);
                },
                eventDidMount: function(info) {
                    // Add tooltip
                    info.el.setAttribute('title',
                        info.event.title +
                        (info.event.extendedProps.lokasi ? '\nLokasi: ' + info.event.extendedProps
                            .lokasi : '') +
                        (info.event.extendedProps.cabang_olahraga ? '\nCabang: ' + info.event
                            .extendedProps.cabang_olahraga : '')
                    );

                    // Add custom classes based on event type
                    var eventType = info.event.extendedProps.type;
                    var jenisEvent = info.event.extendedProps.jenis_event;

                    // Remove default FC styling
                    info.el.style.border = 'none';
                    info.el.style.borderRadius = '4px';

                    if (eventType === 'latihan') {
                        info.el.classList.add('event-latihan');
                        info.el.style.backgroundColor = '#4e73df';
                        info.el.style.color = 'white';
                    } else if (jenisEvent) {
                        var jenisLower = jenisEvent.toLowerCase();
                        if (jenisLower.includes('pertandingan')) {
                            info.el.classList.add('event-pertandingan');
                            info.el.style.backgroundColor = '#dc3545';
                            info.el.style.color = 'white';
                        } else if (jenisLower.includes('seleksi')) {
                            info.el.classList.add('event-seleksi');
                            info.el.style.backgroundColor = '#ffc107';
                            info.el.style.color = '#212529';
                        } else if (jenisLower.includes('uji coba') || jenisLower.includes('ujicoba')) {
                            info.el.classList.add('event-ujicoba');
                            info.el.style.backgroundColor = '#17a2b8';
                            info.el.style.color = 'white';
                        } else if (jenisLower.includes('kejuaraan')) {
                            info.el.classList.add('event-kejuaraan');
                            info.el.style.backgroundColor = '#28a745';
                            info.el.style.color = 'white';
                        } else {
                            // Default untuk event yang tidak terkategorikan
                            info.el.style.backgroundColor = '#6c757d';
                            info.el.style.color = 'white';
                        }
                    } else {
                        // Default styling
                        info.el.style.backgroundColor = '#6c757d';
                        info.el.style.color = 'white';
                    }

                    // Add consistent styling
                    info.el.style.fontSize = '0.75rem';
                    info.el.style.fontWeight = '500';
                    info.el.style.padding = '2px 6px';
                    info.el.style.margin = '1px';
                    info.el.style.boxShadow = '0 1px 2px rgba(0,0,0,0.1)';
                    info.el.style.cursor = 'pointer';
                },
                loading: function(isLoading) {
                    if (isLoading) {
                        calendarEl.classList.add('calendar-loading');
                    } else {
                        calendarEl.classList.remove('calendar-loading');
                    }
                }
            });

            calendar.render();

            // Filter events with improved functionality
            $('#filter_cabang_olahraga, #show_latihan, #show_event').change(function() {
                calendar.refetchEvents();
            });

            function loadCalendarEvents(fetchInfo, successCallback, failureCallback) {
                var showLatihan = $('#show_latihan').is(':checked');
                var showEvent = $('#show_event').is(':checked');
                var caborId = $('#filter_cabang_olahraga').val();

                $.ajax({
                    url: '{{ route('kalender-kegiatan.filter') }}',
                    type: 'GET',
                    data: {
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr,
                        show_latihan: showLatihan,
                        show_event: showEvent,
                        cabang_olahraga_id: caborId
                    },
                    success: function(data) {
                        successCallback(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading events:', error);
                        failureCallback();
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Gagal memuat data kalender');
                        } else {
                            alert('Gagal memuat data kalender');
                        }
                    }
                });
            }

            function showEventDetail(event) {
                var eventData = event.extendedProps;

                // Show modal with loading state
                $('#eventDetailModal').modal('show');
                $('#eventDetails').html(`
                    <div class="text-center p-4">
                        <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
                        <p class="mt-2">Memuat detail kegiatan...</p>
                    </div>
                `);
                $('#eventDetailLink').hide();

                $.ajax({
                    url: '{{ route('kalender-kegiatan.detail') }}',
                    type: 'GET',
                    data: {
                        type: eventData.type,
                        id: event.id
                    },
                    success: function(data) {
                        $('#eventTitle').html('<i class="fas fa-info-circle mr-2"></i>' + data.title);

                        var html = '<div class="row">';

                        if (eventData.type === 'latihan') {
                            html += `
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-tag mr-1"></i>Jenis:</strong>
                                        <span class="badge badge-primary">${data.type}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-calendar mr-1"></i>Tanggal:</strong>
                                        <span>${data.date}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-clock mr-1"></i>Waktu:</strong>
                                        <span>${data.time}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-hourglass-half mr-1"></i>Durasi:</strong>
                                        <span>${data.duration}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-map-marker-alt mr-1"></i>Lokasi:</strong>
                                        <span>${data.location}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-running mr-1"></i>Cabang Olahraga:</strong>
                                        <span>${data.cabang_olahraga}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-user-tie mr-1"></i>Pelatih:</strong>
                                        <span>${data.pelatih}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-users mr-1"></i>Klub:</strong>
                                        <span>${data.klub}</span>
                                    </div>
                                </div>
                            `;
                            if (data.catatan && data.catatan !== '-') {
                                html += `
                                    <div class="col-12 mt-3">
                                        <div class="alert alert-info">
                                            <strong><i class="fas fa-sticky-note mr-1"></i>Catatan:</strong><br>
                                            <span>${data.catatan}</span>
                                        </div>
                                    </div>
                                `;
                            }
                        } else {
                            html += `
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-trophy mr-1"></i>Jenis:</strong>
                                        <span class="badge badge-success">${data.type}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-star mr-1"></i>Kategori:</strong>
                                        <span class="badge badge-warning">${data.jenis_event}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-calendar-plus mr-1"></i>Tanggal Mulai:</strong>
                                        <span>${data.start_date}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-calendar-minus mr-1"></i>Tanggal Selesai:</strong>
                                        <span>${data.end_date}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-primary"><i class="fas fa-hourglass-half mr-1"></i>Durasi:</strong>
                                        <span>${data.duration}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-map-marker-alt mr-1"></i>Lokasi:</strong>
                                        <span>${data.location}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-building mr-1"></i>Penyelenggara:</strong>
                                        <span>${data.organizer}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-running mr-1"></i>Cabang Olahraga:</strong>
                                        <span>${data.cabang_olahraga}</span>
                                    </div>
                                    <div class="info-item mb-3">
                                        <strong class="text-success"><i class="fas fa-users mr-1"></i>Jumlah Atlet:</strong>
                                        <span class="badge badge-info">${data.jumlah_atlet} orang</span>
                                    </div>
                                </div>
                            `;
                            if (data.description && data.description !== '-') {
                                html += `
                                    <div class="col-12 mt-3">
                                        <div class="alert alert-info">
                                            <strong><i class="fas fa-info-circle mr-1"></i>Deskripsi:</strong><br>
                                            <span>${data.description}</span>
                                        </div>
                                    </div>
                                `;
                            }
                        }
                        html += '</div>';

                        $('#eventDetails').html(html);
                        $('#eventDetailLink').attr('href', data.detail_url).show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading event details:', error);
                        $('#eventDetails').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Error loading event details
                            </div>
                        `);
                    }
                });
            }

            // Global functions
            window.changeView = function(viewName) {
                calendar.changeView(viewName);

                // Update active button
                $('.btn-outline-primary').removeClass('active');
                if (viewName === 'dayGridMonth') {
                    $('#btn-month').addClass('active');
                } else if (viewName === 'timeGridWeek') {
                    $('#btn-week').addClass('active');
                } else if (viewName === 'timeGridDay') {
                    $('#btn-day').addClass('active');
                }
            }

            window.refreshCalendar = function() {
                calendar.refetchEvents();
                if (typeof toastr !== 'undefined') {
                    toastr.success('Kalender berhasil diperbarui');
                } else {
                    alert('Kalender berhasil diperbarui');
                }
            }
        });
    </script>
@endpush
