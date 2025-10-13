<div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-pie text-primary"></i> Statistik Verifikasi
        </h1>
        <button wire:click="refresh" class="btn btn-primary btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-sync-alt"></i>
            </span>
            <span class="text">Refresh Data</span>
        </button>
    </div>

    <!-- Alert Success -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Summary Cards Row 1 - ATLIT -->
    <div class="row mb-4">
        <div class="col-12 mb-2">
            <h5 class="text-dark font-weight-bold">
                <i class="fas fa-users text-info"></i> Statistik Verifikasi Atlet
            </h5>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Atlet Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikAtlit['pending']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Atlet Terverifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikAtlit['verified']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Atlet Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikAtlit['rejected']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Atlet
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikAtlit['total']) }}
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-check"></i> {{ $statistikAtlit['persentase_verified'] }}%
                                    Terverifikasi
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards Row 2 - PRESTASI -->
    <div class="row mb-4">
        <div class="col-12 mb-2">
            <h5 class="text-dark font-weight-bold">
                <i class="fas fa-trophy text-warning"></i> Statistik Verifikasi Prestasi
            </h5>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Prestasi Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikPrestasi['pending']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-warning"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Prestasi Terverifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikPrestasi['verified']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-medal fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Prestasi Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikPrestasi['rejected']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ban fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Prestasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikPrestasi['total']) }}
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-check"></i> {{ $statistikPrestasi['persentase_verified'] }}%
                                    Terverifikasi
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards Row 3 - DOKUMEN -->
    <div class="row mb-4">
        <div class="col-12 mb-2">
            <h5 class="text-dark font-weight-bold">
                <i class="fas fa-file-alt text-success"></i> Statistik Verifikasi Dokumen
            </h5>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Dokumen Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikDokumen['pending']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-warning"></i>
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
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Dokumen Terverifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikDokumen['verified']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-check fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Dokumen Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikDokumen['rejected']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-times fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Dokumen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($statistikDokumen['total']) }}
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-check"></i> {{ $statistikDokumen['persentase_verified'] }}%
                                    Terverifikasi
                                </small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-files fa-2x text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Trend Verifikasi Chart -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line"></i> Tren Verifikasi 6 Bulan Terakhir
                    </h6>
                </div>
                <div class="card-body">
                    @if ($chartDataReady)
                        <div id="trendChart"></div>
                    @else
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat data chart...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Distribution Donut Chart -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie"></i> Distribusi Status
                    </h6>
                </div>
                <div class="card-body">
                    @if ($chartDataReady)
                        <div id="statusChart"></div>
                    @else
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat data chart...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Per Cabang Olahraga -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-running"></i> Statistik Verifikasi Per Cabang Olahraga (Top 10)
                    </h6>
                </div>
                <div class="card-body">
                    @if ($chartDataReady)
                        <div id="caborChart"></div>
                    @else
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat data chart...</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- ApexCharts CDN -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if ($chartDataReady)
                    // ========================================
                    // 1. TREND VERIFIKASI CHART (Line Chart)
                    // ========================================
                    var trendOptions = {
                        series: [{
                            name: 'Atlet',
                            data: @json($trendVerifikasi['atlit'])
                        }, {
                            name: 'Prestasi',
                            data: @json($trendVerifikasi['prestasi'])
                        }, {
                            name: 'Dokumen',
                            data: @json($trendVerifikasi['dokumen'])
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            toolbar: {
                                show: true
                            },
                            zoom: {
                                enabled: false
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                            }
                        },
                        colors: ['#4e73df', '#1cc88a', '#36b9cc'],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth'
                        },
                        grid: {
                            borderColor: '#e7e7e7',
                            row: {
                                colors: ['#f3f3f3', 'transparent'],
                                opacity: 0.5
                            },
                        },
                        markers: {
                            size: 5,
                            hover: {
                                size: 7
                            }
                        },
                        xaxis: {
                            categories: @json($trendVerifikasi['categories']),
                            title: {
                                text: 'Bulan'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Jumlah Verifikasi'
                            },
                            min: 0
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -10,
                            offsetX: 0
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            y: {
                                formatter: function(val) {
                                    return val + " verifikasi"
                                }
                            }
                        }
                    };

                    var trendChart = new ApexCharts(document.querySelector("#trendChart"), trendOptions);
                    trendChart.render();

                    // ========================================
                    // 2. STATUS DISTRIBUTION CHART (Donut)
                    // ========================================
                    var totalPending =
                        {{ $statistikAtlit['pending'] + $statistikPrestasi['pending'] + $statistikDokumen['pending'] }};
                    var totalVerified =
                        {{ $statistikAtlit['verified'] + $statistikPrestasi['verified'] + $statistikDokumen['verified'] }};
                    var totalRejected =
                        {{ $statistikAtlit['rejected'] + $statistikPrestasi['rejected'] + $statistikDokumen['rejected'] }};

                    var statusOptions = {
                        series: [totalPending, totalVerified, totalRejected],
                        chart: {
                            type: 'donut',
                            height: 350,
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                            }
                        },
                        labels: ['Pending', 'Terverifikasi', 'Ditolak'],
                        colors: ['#f6c23e', '#1cc88a', '#e74a3b'],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '65%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            fontSize: '16px',
                                            fontWeight: 600,
                                            formatter: function(w) {
                                                return w.globals.seriesTotals.reduce((a, b) => {
                                                    return a + b
                                                }, 0)
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '14px'
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val, opts) {
                                return opts.w.config.series[opts.seriesIndex]
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " data"
                                }
                            }
                        }
                    };

                    var statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
                    statusChart.render();

                    // ========================================
                    // 3. CABANG OLAHRAGA CHART (Bar Chart)
                    // ========================================
                    var caborOptions = {
                        series: [{
                            name: 'Atlet Terverifikasi',
                            data: @json($statistikPerCabor['atlit_verified'])
                        }, {
                            name: 'Prestasi Terverifikasi',
                            data: @json($statistikPerCabor['prestasi_verified'])
                        }],
                        chart: {
                            type: 'bar',
                            height: 400,
                            toolbar: {
                                show: true
                            },
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded',
                                dataLabels: {
                                    position: 'top',
                                },
                            },
                        },
                        dataLabels: {
                            enabled: true,
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },
                        colors: ['#4e73df', '#1cc88a'],
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: @json($statistikPerCabor['nama_cabor']),
                            labels: {
                                rotate: -45,
                                style: {
                                    fontSize: '11px'
                                }
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Jumlah Data Terverifikasi'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " data"
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -10,
                        },
                        grid: {
                            borderColor: '#e7e7e7',
                        }
                    };

                    var caborChart = new ApexCharts(document.querySelector("#caborChart"), caborOptions);
                    caborChart.render();

                    // ========================================
                    // Livewire Listener untuk Refresh
                    // ========================================
                    Livewire.on('refreshCharts', () => {
                        trendChart.updateSeries([{
                            name: 'Atlet',
                            data: @json($trendVerifikasi['atlit'])
                        }, {
                            name: 'Prestasi',
                            data: @json($trendVerifikasi['prestasi'])
                        }, {
                            name: 'Dokumen',
                            data: @json($trendVerifikasi['dokumen'])
                        }]);

                        statusChart.updateSeries([totalPending, totalVerified, totalRejected]);

                        caborChart.updateSeries([{
                            name: 'Atlet Terverifikasi',
                            data: @json($statistikPerCabor['atlit_verified'])
                        }, {
                            name: 'Prestasi Terverifikasi',
                            data: @json($statistikPerCabor['prestasi_verified'])
                        }]);
                    });
                @endif
            });
        </script>
    @endpush
</div>
