<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - {{ $atlit->nama_lengkap }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            padding: 0;
            margin: 0;
        }

        .id-card-container {
            width: 10cm;
            height: 15cm;
            margin: 0 auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 10px;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            color: #667eea;
            font-size: 16px;
        }

        .header-text {
            font-size: 12px;
            font-weight: bold;
            line-height: 1.2;
        }

        .header-subtext {
            font-size: 8px;
            opacity: 0.9;
            margin-top: 2px;
        }

        .photo-section {
            text-align: center;
            padding: 20px 15px 15px;
        }

        .photo-frame {
            width: 90px;
            height: 120px;
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
            font-size: 40px;
        }

        .athlete-name {
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
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
            padding: 15px;
            backdrop-filter: blur(10px);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
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
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #666;
            text-align: center;
            line-height: 1;
        }

        .validity {
            color: rgba(255, 255, 255, 0.8);
            font-size: 7px;
            text-align: right;
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

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #28a745;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
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
    </style>
</head>

<body>
    <div class="id-card-container">
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
                    <img src="{{ public_path('storage/atlit/foto/' . $atlit->foto) }}"
                        alt="Foto {{ $atlit->nama_lengkap }}">
                @else
                    <div class="photo-placeholder">👤</div>
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
                <span class="info-value">{{ $atlit->tempat_lahir }}, {{ $atlit->tanggal_lahir->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">JK</span>
                <span class="info-value">{{ $atlit->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Cabor</span>
                <span class="info-value">{{ $atlit->cabangOlahraga->nama_cabang ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Klub</span>
                <span class="info-value">{{ \Str::limit($atlit->klub->nama_klub ?? '-', 20) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kategori</span>
                <span class="info-value">{{ $atlit->kategoriAtlit->nama_kategori ?? '-' }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-section">
            <div class="qr-code">
                QR<br>CODE
            </div>
            <div class="validity">
                <div>Diterbitkan: {{ $generated_date }}</div>
                <div>Valid s/d: {{ now()->addYear()->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>
</body>

</html>
