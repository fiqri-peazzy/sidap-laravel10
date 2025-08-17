@section('title', 'Statistik')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-pie"></i> Statistik Data PPLP Provinsi Gorontalo
        </h1>
    </div>

    <!-- Statistik Umum -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Atlit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalAtlit) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Prestasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPrestasi) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Klub</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalKlub) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Cabor</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalCabor) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter untuk Prestasi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter"></i> Filter Statistik Prestasi
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tahun</label>
                        <select wire:model.live="tahunPilihan" class="form-control">
                            <option value="">Semua Tahun</option>
                            @foreach ($tahunList as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cabang Olahraga</label>
                        <select wire:model.live="cabangOlahragaPilihan" class="form-control">
                            <option value="">Semua Cabang Olahraga</option>
                            @foreach ($cabangOlahraga as $cabor)
                                <option value="{{ $cabor->id }}">{{ $cabor->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button wire:click="resetFilter" class="btn btn-secondary">
                                <i class="fas fa-refresh"></i> Reset Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 - Distribusi Atlit -->
    <div class="row mb-4">
        <!-- Pie Chart - Jenis Kelamin -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Atlit berdasarkan Jenis Kelamin</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 320px;">
                        <canvas id="chartJenisKelamin"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Pria ({{ $atlitPria }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Wanita ({{ $atlitWanita }})
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart - Status Atlit -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Atlit</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 320px;">
                        <canvas id="chartStatusAtlit"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Aktif ({{ $atlitAktif }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Tidak Aktif ({{ $atlitTidakAktif }})
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doughnut Chart - Kelompok Umur -->
        <div class="col-xl-4 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Atlit berdasarkan Umur</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2" style="height: 320px;">
                        <canvas id="chartKelompokUmur"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> ≤17 tahun ({{ $umur17Kebawah }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> 18-25 tahun ({{ $umur18_25 }})
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> ≥26 tahun ({{ $umur26Keatas }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 - Prestasi -->
    <div class="row mb-4">
        <!-- Bar Chart - Prestasi berdasarkan Medali -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Prestasi berdasarkan Medali
                        @if ($tahunPilihan)
                            - Tahun {{ $tahunPilihan }}
                        @endif
                        @if ($cabangOlahragaPilihan)
                            - {{ $cabangOlahraga->where('id', $cabangOlahragaPilihan)->first()->nama_cabang ?? '' }}
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar" style="height: 320px;">
                        <canvas id="chartMedali"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart - Prestasi berdasarkan Tingkat -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Prestasi berdasarkan Tingkat Kejuaraan
                        @if ($tahunPilihan)
                            - Tahun {{ $tahunPilihan }}
                        @endif
                        @if ($cabangOlahragaPilihan)
                            - {{ $cabangOlahraga->where('id', $cabangOlahragaPilihan)->first()->nama_cabang ?? '' }}
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar" style="height: 320px;">
                        <canvas id="chartTingkatKejuaraan"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Line Chart - Tren Prestasi 5 Tahun Terakhir -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Prestasi 5 Tahun Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="chartTrenPrestasi"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar Chart - Prestasi per Cabang Olahraga -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        @if ($cabangOlahragaPilihan)
                            Prestasi
                            {{ $cabangOlahraga->where('id', $cabangOlahragaPilihan)->first()->nama_cabang ?? '' }}
                            @if ($tahunPilihan)
                                Tahun {{ $tahunPilihan }}
                            @endif
                        @else
                            Top 10 Prestasi per Cabang Olahraga
                            @if ($tahunPilihan)
                                Tahun {{ $tahunPilihan }}
                            @endif
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    @if ($prestasiPerCabor->count() > 0)
                        <div class="chart-bar" style="height: 400px;">
                            <canvas id="chartPrestasiCabor"></canvas>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h6>Tidak ada data prestasi untuk filter yang dipilih</h6>
                            <p class="text-sm">Silakan ubah filter atau pilih "Semua Tahun" dan "Semua Cabang Olahraga"
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Top Rankings -->
    <div class="row mb-4">
        <!-- Top 5 Cabang Olahraga -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Cabang Olahraga (Jumlah Atlit)</h6>
                </div>
                <div class="card-body">
                    @forelse ($topCaborAtlit as $index => $cabor)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <span class="badge badge-primary rounded-circle"
                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ $cabor->nama_cabang }}</div>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-success">{{ $cabor->atlit_count }} atlit</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle"></i> Belum ada data
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top 5 Klub -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Klub (Jumlah Atlit)</h6>
                </div>
                <div class="card-body">
                    @forelse ($topKlubAtlit as $index => $klub)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <span class="badge badge-info rounded-circle"
                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ Str::limit($klub->nama_klub, 25) }}</div>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-success">{{ $klub->atlit_count }} atlit</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle"></i> Belum ada data
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top 5 Atlit Berprestasi -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top 5 Atlit Berprestasi</h6>
                </div>
                <div class="card-body">
                    @forelse ($topAtlitPrestasi as $index => $atlit)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <div class="mr-3">
                                    <span class="badge badge-warning rounded-circle"
                                        style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-weight-bold">{{ Str::limit($atlit->nama_lengkap, 25) }}</div>
                                    <small class="text-muted">{{ $atlit->cabangOlahraga->nama_cabang ?? '-' }}</small>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-success">{{ $atlit->prestasi_count }} prestasi</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle"></i> Belum ada data
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        // Listen untuk Livewire updates
        document.addEventListener('livewire:navigated', function() {
            setTimeout(initializeCharts, 100);
        });

        // Custom event listener untuk update charts
        window.addEventListener('chartUpdated', function() {
            setTimeout(initializeCharts, 100);
        });

        function initializeCharts() {
            // Prepare data untuk charts
            const chartData = {
                atlitPria: {{ $atlitPria ?? 0 }},
                atlitWanita: {{ $atlitWanita ?? 0 }},
                atlitAktif: {{ $atlitAktif ?? 0 }},
                atlitTidakAktif: {{ $atlitTidakAktif ?? 0 }},
                umur17Kebawah: {{ $umur17Kebawah ?? 0 }},
                umur18_25: {{ $umur18_25 ?? 0 }},
                umur26Keatas: {{ $umur26Keatas ?? 0 }},
                prestasiEmas: {{ $prestasiEmas ?? 0 }},
                prestasiPerak: {{ $prestasiPerak ?? 0 }},
                prestasiPerunggu: {{ $prestasiPerunggu ?? 0 }},
                prestasiInternasional: {{ $prestasiInternasional ?? 0 }},
                prestasiNasional: {{ $prestasiNasional ?? 0 }},
                prestasiProvinsi: {{ $prestasiProvinsi ?? 0 }},
                prestasiRegional: {{ $prestasiRegional ?? 0 }},
                prestasiDaerah: {{ $prestasiDaerah ?? 0 }},
                prestasiPerTahun: [
                    @foreach ($prestasiPerTahun as $data)
                        {
                            tahun: '{{ $data['tahun'] ?? '' }}',
                            jumlah: {{ $data['jumlah'] ?? 0 }}
                        },
                    @endforeach
                ],
                prestasiPerCabor: [
                    @foreach ($prestasiPerCabor as $data)
                        {
                            nama: '{{ Str::limit($data['nama'] ?? '', 20) }}',
                            jumlah: {{ $data['jumlah'] ?? 0 }}
                        },
                    @endforeach
                ]
            };

            // Initialize charts menggunakan Chart Manager
            if (typeof window.chartManager !== 'undefined') {
                window.chartManager.initAllCharts(chartData);
            } else {
                // Fallback ke basic implementation jika Chart Manager tidak tersedia
                initBasicCharts(chartData);
            }
        }

        // Fallback basic chart implementation
        function initBasicCharts(data) {
            Chart.defaults.font.family = 'Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
            Chart.defaults.color = '#858796';

            // Simple chart creation untuk fallback
            createChart('chartJenisKelamin', 'pie',
                ['Pria', 'Wanita'],
                [data.atlitPria, data.atlitWanita],
                ['#4e73df', '#1cc88a']
            );

            createChart('chartStatusAtlit', 'pie',
                ['Aktif', 'Tidak Aktif'],
                [data.atlitAktif, data.atlitTidakAktif],
                ['#1cc88a', '#e74a3b']
            );

            createChart('chartKelompokUmur', 'doughnut',
                ['≤17 tahun', '18-25 tahun', '≥26 tahun'],
                [data.umur17Kebawah, data.umur18_25, data.umur26Keatas],
                ['#f6c23e', '#1cc88a', '#36b9cc']
            );

            createChart('chartMedali', 'bar',
                ['Emas', 'Perak', 'Perunggu'],
                [data.prestasiEmas, data.prestasiPerak, data.prestasiPerunggu],
                ['#f6c23e', '#858796', '#36b9cc']
            );

            createChart('chartTingkatKejuaraan', 'bar',
                ['Internasional', 'Nasional', 'Provinsi', 'Regional', 'Daerah'],
                [data.prestasiInternasional, data.prestasiNasional, data.prestasiProvinsi, data.prestasiRegional, data
                    .prestasiDaerah
                ],
                ['#e74a3b', '#f6c23e', '#36b9cc', '#858796', '#6c757d']
            );

            // Tren Prestasi Chart
            if (data.prestasiPerTahun.length > 0) {
                const trenLabels = data.prestasiPerTahun.map(item => item.tahun);
                const trenData = data.prestasiPerTahun.map(item => item.jumlah);
                createChart('chartTrenPrestasi', 'line', trenLabels, trenData, '#4e73df');
            }

            // Prestasi per Cabor Chart
            if (data.prestasiPerCabor.length > 0) {
                const caborLabels = data.prestasiPerCabor.map(item => item.nama);
                const caborData = data.prestasiPerCabor.map(item => item.jumlah);

                if (caborData.some(val => val > 0)) {
                    createChart('chartPrestasiCabor', 'bar', caborLabels, caborData, 'rgba(78, 115, 223, 0.8)', true);
                }
            }
        }

        function createChart(id, type, labels, data, colors, horizontal = false) {
            const element = document.getElementById(id);
            if (!element) return;

            // Destroy existing chart
            if (window.chartInstances && window.chartInstances[id]) {
                window.chartInstances[id].destroy();
            }
            if (!window.chartInstances) window.chartInstances = {};

            const config = {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: type === 'line' ? 3 : 2,
                        borderColor: type === 'line' ? colors : '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            };

            if (type === 'doughnut') {
                config.options.cutout = '70%';
            }

            if (type === 'bar') {
                config.options.scales = {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    }
                };

                if (horizontal) {
                    config.options.indexAxis = 'y';
                    config.options.scales = {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                }
                            }
                        }
                    };
                }
            }

            if (type === 'line') {
                config.data.datasets[0].tension = 0.3;
                config.data.datasets[0].fill = true;
                config.data.datasets[0].backgroundColor = 'rgba(78, 115, 223, 0.05)';
                config.options.scales = {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    }
                };
            }

            window.chartInstances[id] = new Chart(element, config);
        }
    </script>
@endpush
