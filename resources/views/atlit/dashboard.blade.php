@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if (isset($error))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $error }}
            </div>
        @elseif(isset($atlet) && $atlet)
            <!-- Page Heading dengan Profil -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img src="{{ $atlet->foto_url }}" alt="Foto Profil" class="rounded-circle"
                                        style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #4e73df;">
                                </div>
                                <div class="col">
                                    <h1 class="h3 mb-1 text-gray-800">Selamat Datang, {{ $atlet->nama_lengkap }}!</h1>
                                    <p class="mb-0 text-muted">
                                        <i class="fas fa-running mr-1"></i>{{ $atlet->cabangOlahraga->nama_cabang ?? '-' }}
                                        |
                                        <i class="fas fa-users ml-2 mr-1"></i>{{ $atlet->klub->nama_klub ?? '-' }} |
                                        <i
                                            class="fas fa-tag ml-2 mr-1"></i>{{ $atlet->kategoriAtlit->nama_kategori ?? '-' }}
                                    </p>
                                </div>
                                <div class="col-auto">
                                    {!! $atlet->status_verifikasi_badge !!}
                                    {!! $atlet->status_badge !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifikasi / Pengumuman -->
            @if (count($notifikasi) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        @foreach ($notifikasi as $notif)
                            <div class="alert alert-{{ $notif['type'] }} alert-dismissible fade show" role="alert">
                                <i class="fas {{ $notif['icon'] }} mr-2"></i>
                                <strong>{{ $notif['title'] }}:</strong> {{ $notif['message'] }}
                                @if ($notif['link'])
                                    <a href="{{ $notif['link'] }}" class="alert-link ml-2">{{ $notif['link_text'] }}</a>
                                @endif
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Statistik Cards -->
            <div class="row">
                <!-- Prestasi Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Prestasi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $statistikPrestasi['total'] }}
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        <i class="fas fa-medal text-warning"></i>
                                        Emas: {{ $statistikPrestasi['emas'] }} |
                                        Perak: {{ $statistikPrestasi['perak'] }} |
                                        Perunggu: {{ $statistikPrestasi['perunggu'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-trophy fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div
                        class="card border-left-{{ $persentaseDokumen == 100 ? 'success' : ($persentaseDokumen > 0 ? 'info' : 'danger') }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div
                                        class="text-xs font-weight-bold text-{{ $persentaseDokumen == 100 ? 'success' : ($persentaseDokumen > 0 ? 'info' : 'danger') }} text-uppercase mb-1">
                                        Kelengkapan Dokumen
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                {{ number_format($persentaseDokumen, 0) }}%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-{{ $persentaseDokumen == 100 ? 'success' : ($persentaseDokumen > 0 ? 'info' : 'danger') }}"
                                                    role="progressbar" style="width: {{ $persentaseDokumen }}%"
                                                    aria-valuenow="{{ $persentaseDokumen }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Terverifikasi: {{ $dokumenStats['verified'] }}/{{ $dokumenStats['total'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Latihan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Jadwal Hari Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $jadwalHariIni->count() }}
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Minggu ini: {{ $jadwalMingguIni->count() }} jadwal
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Mendatang Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Event Mendatang
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $jumlahEventMendatang }}
                                    </div>
                                    <div class="text-xs text-muted mt-1">
                                        Event aktif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Grafik Prestasi -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line mr-2"></i>Statistik Prestasi (5 Tahun Terakhir)
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="prestasiChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Statistik Medali -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-medal mr-2"></i>Perolehan Medali
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="medaliChart" style="height: 300px;"></canvas>
                            <div class="mt-3 text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fas fa-medal text-warning fa-2x"></i>
                                        <h5 class="mt-2 mb-0">{{ $statistikPrestasi['emas'] }}</h5>
                                        <small class="text-muted">Emas</small>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-medal text-secondary fa-2x"></i>
                                        <h5 class="mt-2 mb-0">{{ $statistikPrestasi['perak'] }}</h5>
                                        <small class="text-muted">Perak</small>
                                    </div>
                                    <div class="col-4">
                                        <i class="fas fa-medal text-danger fa-2x"></i>
                                        <h5 class="mt-2 mb-0">{{ $statistikPrestasi['perunggu'] }}</h5>
                                        <small class="text-muted">Perunggu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Quick Actions -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <a href="{{ route('atlit.profil') }}"
                                    class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-user text-success mr-2"></i> Update Profil
                                </a>
                                <a href="{{ route('atlit.dokumen.index') }}"
                                    class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-file-upload text-primary mr-2"></i> Kelola Dokumen
                                </a>
                                <a href="{{ route('atlit.jadwal-latihan.index') }}"
                                    class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-clock text-info mr-2"></i> Lihat Jadwal Latihan
                                </a>
                                <a href="{{ route('atlit.kalender') }}"
                                    class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-calendar text-primary mr-2"></i> Kalender Kegiatan
                                </a>
                                <a href="{{ route('atlit.prestasi.index') }}"
                                    class="list-group-item list-group-item-action border-0">
                                    <i class="fas fa-trophy text-warning mr-2"></i> Prestasi Saya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Latihan Minggu Ini -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-info">
                                <i class="fas fa-dumbbell mr-2"></i>Jadwal Latihan Minggu Ini
                            </h6>
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            @forelse($jadwalMingguIni as $jadwal)
                                <div
                                    class="mb-3 p-3 border rounded {{ $jadwal->tanggal->isToday() ? 'bg-light border-info' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 text-info">
                                                {{ $jadwal->nama_kegiatan }}
                                                @if ($jadwal->tanggal->isToday())
                                                    <span class="badge badge-info badge-sm">Hari Ini</span>
                                                @endif
                                            </h6>
                                            <p class="mb-1 text-sm">
                                                <i class="fas fa-calendar-day mr-1"></i>
                                                {{ $jadwal->tanggal->isoFormat('dddd, D MMMM Y') }}
                                            </p>
                                            <p class="mb-1 text-sm">
                                                <i class="fas fa-clock mr-1"></i>
                                                {{ $jadwal->jam_latihan }}
                                            </p>
                                            <p class="mb-0 text-sm text-muted">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $jadwal->lokasi }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Tidak ada jadwal latihan minggu ini
                                </p>
                            @endforelse
                            @if ($jadwalMingguIni->count() > 0)
                                <a href="{{ route('atlit.jadwal-latihan.index') }}"
                                    class="btn btn-info btn-sm btn-block mt-3">
                                    Lihat Semua Jadwal
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Prestasi Terbaru -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                <i class="fas fa-star mr-2"></i>Prestasi Terbaru
                            </h6>
                        </div>
                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                            @forelse($prestasiTerbaru as $prestasi)
                                <div class="mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="text-warning mb-1">{{ $prestasi->nama_event }}</h6>
                                            <p class="mb-1 text-sm">{{ $prestasi->nama_kejuaraan }}</p>
                                            <p class="mb-1 text-sm">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($prestasi->tanggal_event)->isoFormat('D MMMM Y') }}
                                            </p>
                                            @if ($prestasi->peringkat)
                                                <span class="badge badge-warning">
                                                    Peringkat {{ $prestasi->peringkat }}
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <span
                                                class="badge badge-{{ $prestasi->status == 'verified' ? 'success' : ($prestasi->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($prestasi->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center py-3">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Belum ada prestasi
                                </p>
                            @endforelse
                            @if ($prestasiTerbaru->count() > 0)
                                <a href="{{ route('atlit.prestasi.index') }}"
                                    class="btn btn-warning btn-sm btn-block mt-3">
                                    Lihat Semua Prestasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Mendatang -->
            @if ($eventMendatang->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-bullhorn mr-2"></i>Event Mendatang
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($eventMendatang as $event)
                                        <div class="col-lg-4 mb-3">
                                            <div class="card border-left-primary h-100">
                                                <div class="card-body">
                                                    <h6 class="text-primary mb-2">{{ $event->nama_event }}</h6>
                                                    <p class="mb-1 text-sm">
                                                        <i class="fas fa-calendar mr-1"></i>
                                                        {{ $event->tanggal_mulai->isoFormat('D MMM Y') }} -
                                                        {{ $event->tanggal_selesai->isoFormat('D MMM Y') }}
                                                    </p>
                                                    <p class="mb-1 text-sm">
                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                        {{ $event->lokasi }}
                                                    </p>
                                                    <p class="mb-2 text-sm text-muted">
                                                        <i class="fas fa-building mr-1"></i>
                                                        {{ $event->penyelenggara }}
                                                    </p>
                                                    {!! $event->jenis_event_badge !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('atlit.jadwal-event.index') }}" class="btn btn-primary btn-sm">
                                    Lihat Semua Event <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @endif {{-- End if $atlet --}}
    </div>



@endsection
@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            @if (isset($atlet) && $atlet)

                // ========================================
                // CHART PRESTASI PER TAHUN
                // ========================================
                var prestasiCtx = document.getElementById('prestasiChart');
                if (prestasiCtx) {
                    var prestasiData = @json($prestasiPerTahun);

                    var labels = prestasiData.map(item => item.tahun);
                    var data = prestasiData.map(item => item.jumlah);

                    new Chart(prestasiCtx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Prestasi',
                                data: data,
                                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                                borderColor: 'rgba(78, 115, 223, 1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    padding: 12,
                                    titleFont: {
                                        size: 14
                                    },
                                    bodyFont: {
                                        size: 13
                                    },
                                    callbacks: {
                                        label: function(context) {
                                            return 'Prestasi: ' + context.parsed.y;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        font: {
                                            size: 12
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: {
                                            size: 12
                                        }
                                    },
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // ========================================
                // CHART MEDALI (DOUGHNUT)
                // ========================================
                var medaliCtx = document.getElementById('medaliChart');
                if (medaliCtx) {
                    try {
                        var emas = {{ $statistikPrestasi['emas'] ?? 0 }};
                        var perak = {{ $statistikPrestasi['perak'] ?? 0 }};
                        var perunggu = {{ $statistikPrestasi['perunggu'] ?? 0 }};

                        var totalMedali = emas + perak + perunggu;

                        if (totalMedali > 0) {
                            new Chart(medaliCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['Emas', 'Perak', 'Perunggu'],
                                    datasets: [{
                                        data: [emas, perak, perunggu],
                                        backgroundColor: [
                                            'rgba(255, 193, 7, 0.8)',
                                            'rgba(108, 117, 125, 0.8)',
                                            'rgba(220, 53, 69, 0.8)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 193, 7, 1)',
                                            'rgba(108, 117, 125, 1)',
                                            'rgba(220, 53, 69, 1)'
                                        ],
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'bottom',
                                            labels: {
                                                padding: 15,
                                                font: {
                                                    size: 12
                                                }
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            padding: 12,
                                            callbacks: {
                                                label: function(context) {
                                                    var label = context.label || '';
                                                    var value = context.parsed || 0;
                                                    var total = context.dataset.data.reduce((a, b) =>
                                                        a + b, 0);
                                                    var percentage = total > 0 ? ((value / total) * 100)
                                                        .toFixed(1) : 0;
                                                    return label + ': ' + value + ' (' + percentage +
                                                        '%)';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        } else {
                            // Jika tidak ada medali, tampilkan pesan
                            medaliCtx.parentElement.innerHTML =
                                '<p class="text-muted text-center py-5">Belum ada perolehan medali</p>';
                        }
                    } catch (error) {
                        console.error('Error creating medali chart:', error);
                        medaliCtx.parentElement.innerHTML =
                            '<p class="text-danger text-center py-5">Gagal memuat grafik medali</p>';
                    }
                }
            @endif

            // ========================================
            // ANIMASI CARD SAAT HOVER
            // ========================================
            $('.card').hover(
                function() {
                    $(this).addClass('shadow-lg').css('transition', 'all 0.3s ease');
                },
                function() {
                    $(this).removeClass('shadow-lg');
                }
            );

            // ========================================
            // AUTO DISMISS ALERT SETELAH 10 DETIK
            // ========================================
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 10000);
        });
    </script>

    <style>
        /* Custom Styles */
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .list-group-item {
            transition: all 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fc;
            padding-left: 1.5rem;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .badge-sm {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        /* Scrollbar Styling */
        .card-body::-webkit-scrollbar {
            width: 6px;
        }

        .card-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .card-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .card-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Progress bar custom */
        .progress-sm {
            height: 0.5rem;
        }

        /* Alert custom */
        .alert {
            border-left: 4px solid;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Badge animation */
        .badge {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endpush
