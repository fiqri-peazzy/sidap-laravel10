@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kalender Kegiatan</h1>
        <div class="btn-group">
            <a href="{{ route('jadwal-latihan.create') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Jadwal Latihan
            </a>
            <a href="{{ route('jadwal-event.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Jadwal Event
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Kalender</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cabang Olahraga</label>
                        <select id="filter_cabang_olahraga" class="form-control form-control-sm">
                            <option value="">Semua Cabang Olahraga</option>
                            @foreach ($cabangOlahraga as $cabor)
                                <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Jenis Kegiatan</label>
                        <div class="form-check">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tampilan</label>
                        <div class="btn-group d-block" role="group">
                            <button type="button" class="btn btn-sm btn-outline-primary active"
                                onclick="changeView('dayGridMonth')">
                                <i class="fas fa-calendar"></i> Bulan
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="changeView('timeGridWeek')">
                                <i class="fas fa-calendar-week"></i> Minggu
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="changeView('timeGridDay')">
                                <i class="fas fa-calendar-day"></i> Hari
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kalender Kegiatan PPLP Gorontalo</h6>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Legend Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keterangan Warna</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Jadwal Latihan:</h6>
                    <div class="mb-2">
                        <span class="badge" style="background-color: #007bff; color: white;">■</span>
                        Jadwal Latihan Rutin
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Event/Pertandingan:</h6>
                    <div class="mb-2">
                        <span class="badge" style="background-color: #dc3545; color: white;">■</span>
                        Pertandingan
                    </div>
                    <div class="mb-2">
                        <span class="badge" style="background-color: #ffc107; color: black;">■</span>
                        Seleksi
                    </div>
                    <div class="mb-2">
                        <span class="badge" style="background-color: #17a2b8; color: white;">■</span>
                        Uji Coba
                    </div>
                    <div class="mb-2">
                        <span class="badge" style="background-color: #28a745; color: white;">■</span>
                        Kejuaraan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventTitle">Detail Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="eventDetails">
                    <!-- Content will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <a href="#" id="eventDetailLink" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event-title {
            font-weight: bold;
        }

        .fc-daygrid-event {
            border-radius: 3px;
        }

        .fc-timegrid-event {
            border-radius: 3px;
        }

        .legend-item {
            display: inline-block;
            margin: 5px 10px 5px 0;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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
                events: function(fetchInfo, successCallback, failureCallback) {
                    loadCalendarEvents(fetchInfo, successCallback, failureCallback);
                },
                eventClick: function(info) {
                    showEventDetail(info.event);
                },
                eventMouseEnter: function(info) {
                    $(info.el).tooltip({
                        title: info.event.title + '\n' +
                            (info.event.extendedProps.lokasi || '') + '\n' +
                            (info.event.extendedProps.cabang_olahraga || ''),
                        placement: 'top',
                        trigger: 'hover'
                    });
                }
            });

            calendar.render();

            // Filter events
            $('#filter_cabang_olahraga, #show_latihan, #show_event').change(function() {
                calendar.refetchEvents();
            });

            function loadCalendarEvents(fetchInfo, successCallback, failureCallback) {
                var showLatihan = $('#show_latihan').is(':checked');
                var showEvent = $('#show_event').is(':checked');
                var caborId = $('#filter_cabang_olahraga').val();

                $.ajax({
                    url: '{{ route('api.kalender.events') }}',
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
                    error: function() {
                        failureCallback();
                    }
                });
            }

            function showEventDetail(event) {
                var eventData = event.extendedProps;

                $.ajax({
                    url: '{{ route('api.kalender.event-detail') }}',
                    type: 'GET',
                    data: {
                        type: eventData.type,
                        id: event.id
                    },
                    success: function(data) {
                        $('#eventTitle').text(data.title);

                        var html = '<div class="row">';

                        if (eventData.type === 'latihan') {
                            html += '<div class="col-md-6">' +
                                '<strong>Jenis:</strong> ' + data.type + '<br>' +
                                '<strong>Tanggal:</strong> ' + data.date + '<br>' +
                                '<strong>Waktu:</strong> ' + data.time + '<br>' +
                                '<strong>Durasi:</strong> ' + data.duration + '<br>' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<strong>Lokasi:</strong> ' + data.location + '<br>' +
                                '<strong>Cabang Olahraga:</strong> ' + data.cabang_olahraga + '<br>' +
                                '<strong>Pelatih:</strong> ' + data.pelatih + '<br>' +
                                '<strong>Klub:</strong> ' + data.klub + '<br>' +
                                '</div>' +
                                '<div class="col-12 mt-3">' +
                                '<strong>Catatan:</strong><br>' + data.catatan +
                                '</div>';
                        } else {
                            html += '<div class="col-md-6">' +
                                '<strong>Jenis:</strong> ' + data.type + '<br>' +
                                '<strong>Kategori:</strong> ' + data.jenis_event + '<br>' +
                                '<strong>Tanggal Mulai:</strong> ' + data.start_date + '<br>' +
                                '<strong>Tanggal Selesai:</strong> ' + data.end_date + '<br>' +
                                '<strong>Durasi:</strong> ' + data.duration + '<br>' +
                                '</div>' +
                                '<div class="col-md-6">' +
                                '<strong>Lokasi:</strong> ' + data.location + '<br>' +
                                '<strong>Penyelenggara:</strong> ' + data.organizer + '<br>' +
                                '<strong>Cabang Olahraga:</strong> ' + data.cabang_olahraga + '<br>' +
                                '<strong>Jumlah Atlet:</strong> ' + data.jumlah_atlet + ' orang<br>' +
                                '</div>' +
                                '<div class="col-12 mt-3">' +
                                '<strong>Deskripsi:</strong><br>' + data.description +
                                '</div>';
                        }

                        html += '</div>';

                        $('#eventDetails').html(html);
                        $('#eventDetailLink').attr('href', data.detail_url);
                        $('#eventDetailModal').modal('show');
                    },
                    error: function() {
                        alert('Error loading event details');
                    }
                });
            }

            window.changeView = function(viewName) {
                calendar.changeView(viewName);
                $('.btn-group button').removeClass('active');
                event.target.classList.add('active');
            }
        });
    </script>
@endpush
