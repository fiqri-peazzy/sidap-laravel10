@extends('layouts.app')

@section('title', 'Preview ID Card')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-id-card text-primary"></i> Preview ID Card
            </h1>
            <div class="d-flex">
                <a href="{{ route('atlit.profil') }}" class="btn btn-secondary btn-sm mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('atlit.profil.id-card.cetak') }}" class="btn btn-primary btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak PDF
                </a>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 text-center">
                        <h6 class="m-0 font-weight-bold text-primary">Preview ID Card Atlit</h6>
                    </div>
                    <div class="card-body text-center">
                        <!-- ID Card Preview Container -->
                        <div class="id-card-preview-wrapper">
                            <div class="id-card-container-preview">
                                <div class="decorative-elements"></div>
                                <div class="security-pattern"></div>

                                <!-- Status Badge -->
                                <div class="status-badge">{{ strtoupper($atlit->status) }}</div>

                                <!-- Header -->
                                <div class="id-card-header">
                                    <div class="logo-section">
                                        <div class="logo">PP</div>
                                        <div>
                                            <div class="header-text">PPLP SULAWESI UTARA</div>
                                            <div class="header-subtext">PUSAT PEMBINAAN & LATIHAN PELAJAR</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Photo Section -->
                                <div class="photo-section">
                                    <div class="photo-frame">
                                        @if ($atlit->foto)
                                            <img src="{{ Storage::url('atlit/foto/' . $atlit->foto) }}"
                                                alt="Foto {{ $atlit->nama_lengkap }}">
                                        @else
                                            <div class="photo-placeholder">
                                                <i class="fas fa-user fa-3x text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="athlete-name">{{ $atlit->nama_lengkap }}</div>
                                    <div class="athlete-id">ID: {{ str_pad($atlit->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </div>

                                <!-- Info Section -->
                                <div class="info-section">
                                    <div class="info-row">
                                        <span class="info-label">NIK</span>
                                        <span class="info-value">{{ $atlit->nik }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Lahir</span>
                                        <span class="info-value">{{ $atlit->tempat_lahir }},
                                            {{ $atlit->tanggal_lahir->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">JK</span>
                                        <span
                                            class="info-value">{{ $atlit->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Cabor</span>
                                        <span class="info-value">{{ $atlit->cabangOlahraga->nama_cabang ?? '-' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Klub</span>
                                        <span
                                            class="info-value">{{ \Str::limit($atlit->klub->nama_klub ?? '-', 20) }}</span>
                                    </div>
                                    <div class="info-row">
                                        <span class="info-label">Kategori</span>
                                        <span class="info-value">{{ $atlit->kategoriAtlit->nama_kategori ?? '-' }}</span>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="footer-section">
                                    <div class="qr-code">
                                        <i class="fas fa-qrcode fa-2x"></i>
                                    </div>
                                    <div class="validity">
                                        <div>Diterbitkan: {{ $generated_date }}</div>
                                        <div>Valid s/d: {{ now()->addYear()->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-4">
                            <a href="{{ route('atlit.profil.id-card.cetak') }}" class="btn btn-success btn-lg"
                                target="_blank">
                                <i class="fas fa-download mr-2"></i> Cetak ID Card
                            </a>
                        </div>

                        <!-- Info -->
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                ID Card akan dicetak dalam format PDF dengan ukuran standar 10cm x 15cm
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .id-card-preview-wrapper {
            perspective: 1000px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }

        .id-card-container-preview {
            width: 300px;
            height: 450px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transform: rotateY(-10deg) rotateX(5deg);
            transition: transform 0.3s ease;
        }

        .id-card-container-preview:hover {
            transform: rotateY(0deg) rotateX(0deg) scale(1.02);
        }

        .decorative-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .decorative-elements::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .decorative-elements::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 60%);
            border-radius: 50%;
        }

        .security-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                repeating-linear-gradient(45deg,
                    transparent,
                    transparent 2px,
                    rgba(255, 255, 255, 0.02) 2px,
                    rgba(255, 255, 255, 0.02) 4px);
            pointer-events: none;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #28a745;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .id-card-header {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            text-align: center;
            color: white;
            backdrop-filter: blur(10px);
        }

        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 35px;
            height: 35px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            color: #667eea;
            font-size: 14px;
        }

        .header-text {
            font-size: 12px;
            font-weight: bold;
            line-height: 1.2;
        }

        .header-subtext {
            font-size: 9px;
            opacity: 0.9;
            margin-top: 2px;
        }

        .photo-section {
            text-align: center;
            padding: 20px 15px 15px;
        }

        .photo-frame {
            width: 80px;
            height: 100px;
            margin: 0 auto 15px;
            border: 3px solid white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            color: #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .athlete-name {
            color: white;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        .athlete-id {
            color: rgba(255, 255, 255, 0.9);
            font-size: 10px;
            margin-top: 3px;
            font-family: 'Courier New', monospace;
        }

        .info-section {
            background: rgba(255, 255, 255, 0.95);
            margin: 0 15px 15px;
            border-radius: 10px;
            padding: 12px;
            backdrop-filter: blur(10px);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 9px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
            width: 35%;
        }

        .info-value {
            color: #666;
            width: 60%;
            text-align: right;
            word-wrap: break-word;
            font-size: 8px;
        }

        .footer-section {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-code {
            width: 35px;
            height: 35px;
            background: white;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .validity {
            color: rgba(255, 255, 255, 0.8);
            font-size: 7px;
            text-align: right;
            line-height: 1.2;
        }
    </style>
@endpush
