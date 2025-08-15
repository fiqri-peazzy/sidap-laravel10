@extends('layouts.app')

@section('title', 'Kelola Atlet Event')

@push('styles')
    <style>
        .athlete-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .athlete-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .athlete-card.selected {
            border-color: #4e73df;
            background-color: #f8f9ff;
        }

        .athlete-card .form-check-input {
            transform: scale(1.2);
        }

        .search-box {
            background: #f8f9fc;
            border-radius: 0.35rem;
            padding: 15px;
            margin-bottom: 20px;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0.75rem;
            padding: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Kelola Atlet Event</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('jadwal-event.index') }}">Jadwal Event</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('jadwal-event.show', $jadwalEvent) }}">{{ $jadwalEvent->nama_event }}</a></li>
                        <li class="breadcrumb-item active">Kelola Atlet</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('jadwal-event.show', $jadwalEvent) }}" class="btn btn-sm btn-info mr-2">
                    <i class="fas fa-eye"></i> Detail Event
                </a>
                <a href="{{ route('jadwal-event.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Event Info -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="font-weight-bold text-primary mb-1">{{ $jadwalEvent->nama_event }}</h5>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-running mr-1"></i> {{ $jadwalEvent->cabangOlahraga->nama_cabang }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-calendar mr-1"></i> {{ $jadwalEvent->tanggal_mulai->format('d/m/Y') }}
                                    - {{ $jadwalEvent->tanggal_selesai->format('d/m/Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-1"></i> {{ $jadwalEvent->lokasi }}
                                </p>
                            </div>
                            <div class="col-auto">
                                {!! $jadwalEvent->status_badge !!}
                                {!! $jadwalEvent->jenis_event_badge !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="stats-card">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1">
                                Atlet Terdaftar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-white" id="registered-count">
                                {{ $jadwalEvent->jumlah_atlet }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('jadwal-event.update-atlit', $jadwalEvent) }}" method="POST" id="athleteForm">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col-lg-8">
                    <!-- Search and Filter -->
                    <div class="search-box">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-0">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="searchAthlete" class="form-control"
                                            placeholder="Cari nama atlet...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-outline-primary mr-2" onclick="selectAll()">
                                        <i class="fas fa-check-double"></i> Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="deselectAll()">
                                        <i class="fas fa-times"></i> Batal Semua
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Athletes -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Atlet {{ $jadwalEvent->cabangOlahraga->nama_cabang }} Tersedia
                            </h6>
                        </div>
                        <div class="card-body">
                            @if ($availableAtlit->count() > 0)
                                <div class="row" id="athleteList">
                                    @foreach ($availableAtlit as $atlit)
                                        <div class="col-md-6 mb-3 athlete-item"
                                            data-name="{{ strtolower($atlit->nama_lengkap) }}">
                                            <div
                                                class="card athlete-card {{ $jadwalEvent->atlit->contains($atlit->id) ? 'selected' : '' }}">
                                                <div class="card-body py-3">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col-auto mr-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input athlete-checkbox"
                                                                    type="checkbox" name="atlit_ids[]"
                                                                    value="{{ $atlit->id }}"
                                                                    id="atlit_{{ $atlit->id }}"
                                                                    {{ $jadwalEvent->atlit->contains($atlit->id) ? 'checked' : '' }}
                                                                    onchange="toggleCard(this)">
                                                            </div>
                                                        </div>
                                                        <div class="col mr-2">
                                                            <label for="atlit_{{ $atlit->id }}"
                                                                class="mb-0 cursor-pointer w-100">
                                                                <div class="font-weight-bold text-primary">
                                                                    {{ $atlit->nama_lengkap }}
                                                                </div>
                                                                <div class="text-xs text-muted">
                                                                    <i
                                                                        class="fas fa-id-card mr-1"></i>{{ $atlit->nomor_induk ?? 'Belum ada nomor' }}
                                                                </div>
                                                                @if ($atlit->jenis_kelamin)
                                                                    <div class="text-xs text-muted">
                                                                        <i
                                                                            class="fas fa-{{ $atlit->jenis_kelamin == 'L' ? 'mars' : 'venus' }} mr-1"></i>
                                                                        {{ $atlit->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                                    </div>
                                                                @endif
                                                                @if ($atlit->tanggal_lahir)
                                                                    <div class="text-xs text-muted">
                                                                        <i class="fas fa-birthday-cake mr-1"></i>
                                                                        {{ \Carbon\Carbon::parse($atlit->tanggal_lahir)->age }}
                                                                        tahun
                                                                    </div>
                                                                @endif
                                                            </label>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-user-athlete fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div id="noResults" class="text-center py-4" style="display: none;">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak Ditemukan</h5>
                                    <p class="text-muted">Tidak ada atlet yang sesuai dengan pencarian.</p>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-users-slash fa-5x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak Ada Atlet Tersedia</h5>
                                    <p class="text-muted">Belum ada atlet aktif di cabang olahraga
                                        {{ $jadwalEvent->cabangOlahraga->nama_cabang }}.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Currently Selected -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Atlet Terpilih
                                <span class="badge badge-info float-right" id="selectedCount">
                                    {{ $jadwalEvent->jumlah_atlet }}
                                </span>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="selectedList" style="max-height: 300px; overflow-y: auto;">
                                @foreach ($jadwalEvent->atlit as $atlit)
                                    <div class="d-flex align-items-center mb-2 selected-item"
                                        data-id="{{ $atlit->id }}">
                                        <i class="fas fa-user-check text-success mr-2"></i>
                                        <span class="small">{{ $atlit->nama_lengkap }}</span>
                                    </div>
                                @endforeach
                                <div id="noSelected" class="text-center text-muted"
                                    style="{{ $jadwalEvent->jumlah_atlet > 0 ? 'display: none;' : '' }}">
                                    <i class="fas fa-info-circle"></i>
                                    Belum ada atlet dipilih
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('jadwal-event.show', $jadwalEvent) }}" class="btn btn-info btn-block">
                                    <i class="fas fa-eye"></i> Lihat Event
                                </a>
                                <a href="{{ route('jadwal-event.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchAthlete');
            const athleteItems = document.querySelectorAll('.athlete-item');
            const noResults = document.getElementById('noResults');
            const selectedList = document.getElementById('selectedList');
            const selectedCount = document.getElementById('selectedCount');
            const registeredCount = document.getElementById('registered-count');
            const noSelected = document.getElementById('noSelected');

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;

                athleteItems.forEach(item => {
                    const athleteName = item.getAttribute('data-name');
                    if (athleteName.includes(searchTerm)) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            });

            // Update selected list
            function updateSelectedList() {
                const checkboxes = document.querySelectorAll('.athlete-checkbox:checked');
                const count = checkboxes.length;

                selectedCount.textContent = count;
                registeredCount.textContent = count;

                // Clear current list
                const selectedItems = selectedList.querySelectorAll('.selected-item');
                selectedItems.forEach(item => item.remove());

                if (count > 0) {
                    noSelected.style.display = 'none';

                    checkboxes.forEach(checkbox => {
                        const card = checkbox.closest('.athlete-card');
                        const athleteName = card.querySelector('.font-weight-bold').textContent.trim();

                        const selectedItem = document.createElement('div');
                        selectedItem.className = 'd-flex align-items-center mb-2 selected-item';
                        selectedItem.setAttribute('data-id', checkbox.value);
                        selectedItem.innerHTML = `
                    <i class="fas fa-user-check text-success mr-2"></i>
                    <span class="small">${athleteName}</span>
                `;

                        selectedList.insertBefore(selectedItem, noSelected);
                    });
                } else {
                    noSelected.style.display = 'block';
                }
            }

            // Add event listeners to all checkboxes
            document.querySelectorAll('.athlete-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedList);
            });
        });

        function toggleCard(checkbox) {
            const card = checkbox.closest('.athlete-card');
            if (checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        }

        function selectAll() {
            const visibleCheckboxes = document.querySelectorAll(
                '.athlete-item:not([style*="display: none"]) .athlete-checkbox');
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
                toggleCard(checkbox);
            });
            updateSelectedList();
        }

        function deselectAll() {
            const checkboxes = document.querySelectorAll('.athlete-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
                toggleCard(checkbox);
            });
            updateSelectedList();
        }

        function updateSelectedList() {
            const checkboxes = document.querySelectorAll('.athlete-checkbox:checked');
            const count = checkboxes.length;

            document.getElementById('selectedCount').textContent = count;
            document.getElementById('registered-count').textContent = count;

            // Clear current list
            const selectedItems = document.getElementById('selectedList').querySelectorAll('.selected-item');
            selectedItems.forEach(item => item.remove());

            const noSelected = document.getElementById('noSelected');

            if (count > 0) {
                noSelected.style.display = 'none';

                checkboxes.forEach(checkbox => {
                    const card = checkbox.closest('.athlete-card');
                    const athleteName = card.querySelector('.font-weight-bold').textContent.trim();

                    const selectedItem = document.createElement('div');
                    selectedItem.className = 'd-flex align-items-center mb-2 selected-item';
                    selectedItem.setAttribute('data-id', checkbox.value);
                    selectedItem.innerHTML = `
                <i class="fas fa-user-check text-success mr-2"></i>
                <span class="small">${athleteName}</span>
            `;

                    document.getElementById('selectedList').insertBefore(selectedItem, noSelected);
                });
            } else {
                noSelected.style.display = 'block';
            }
        }
    </script>
@endpush
