<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        /* ===== KOP SURAT ===== */
        .kop {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .kop-inner {
            display: table;
            width: 100%;
        }
        .kop-logo {
            display: table-cell;
            width: 80px;
            vertical-align: middle;
            text-align: center;
        }
        .kop-logo img {
            width: 70px;
            height: 70px;
        }
        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }
        .kop-text .instansi {
            font-size: 11px;
            font-weight: normal;
            margin: 0;
            letter-spacing: 0.5px;
        }
        .kop-text .dinas {
            font-size: 18px;
            font-weight: bold;
            margin: 2px 0;
            letter-spacing: 1px;
        }
        .kop-text .unit {
            font-size: 13px;
            font-weight: bold;
            margin: 2px 0;
        }
        .kop-text .alamat {
            font-size: 10px;
            margin: 3px 0 0 0;
            font-style: italic;
        }

        /* ===== JUDUL LAPORAN ===== */
        .judul-laporan {
            text-align: center;
            margin-bottom: 8px;
        }
        .judul-laporan h2 {
            font-size: 13px;
            margin: 0 0 2px 0;
            text-transform: uppercase;
            text-decoration: underline;
        }

        /* ===== INFO FILTER + CETAK ===== */
        .info-wrapper {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        .info-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 2px 0;
            border: none;
        }
        .info .label {
            font-weight: bold;
            width: 150px;
        }
        .print-info {
            font-size: 10px;
            color: #444;
            line-height: 1.6;
        }
        .print-info span {
            font-weight: bold;
        }

        /* ===== TABLE DATA ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
            padding: 8px 4px;
            font-size: 10px;
        }
        td {
            padding: 5px 3px;
            text-align: left;
            font-size: 9px;
            vertical-align: top;
        }
        .text-center { text-align: center; }

        .badge {
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
            color: white;
        }
        .badge-danger    { background-color: #dc3545; }
        .badge-warning   { background-color: #ffc107; color: #000; }
        .badge-info      { background-color: #17a2b8; }
        .badge-secondary { background-color: #6c757d; }

        .medal-emas    { color: #c8910a; font-weight: bold; }
        .medal-perak   { color: #6c757d; font-weight: bold; }
        .medal-perunggu { color: #cd7f32; font-weight: bold; }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 80px;
            margin-bottom: 5px;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        @page {
            margin: 15mm;
        }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    <div class="kop">
        <div class="kop-inner">
            <div class="kop-logo">
                <img src="{{ public_path('images/logo-gorontalo.png') }}" alt="Logo Gorontalo">
            </div>
            <div class="kop-text">
                <p class="instansi">PEMERINTAH PROVINSI GORONTALO</p>
                <p class="dinas">DINAS PEMUDA DAN OLAHRAGA</p>
                <p class="unit">PUSAT PENDIDIKAN DAN LATIHAN OLAHRAGA PELAJAR</p>
                <p class="alamat">Jl. Madura Kel. Pulubala Kec. Kota Tengah Kota Gorontalo</p>
            </div>
        </div>
    </div>

    {{-- ===== JUDUL LAPORAN ===== --}}
    <div class="judul-laporan">
        <h2>{{ $title }}</h2>
    </div>

    {{-- ===== INFO FILTER + INFO CETAK ===== --}}
    <div class="info-wrapper">
        <div class="info-left">
            <div class="info">
                <table>
                    @if ($filter['klub_id'] ?? false)
                        <tr>
                            <td class="label">Klub</td>
                            <td>: {{ $atlit->first()?->klub->nama_klub ?? '-' }}</td>
                        </tr>
                    @endif
                    @if ($filter['cabang_olahraga_id'] ?? false)
                        <tr>
                            <td class="label">Cabang Olahraga</td>
                            <td>: {{ $atlit->first()?->cabangOlahraga->nama_cabang ?? '-' }}</td>
                        </tr>
                    @endif
                    @if ($filter['jenis_kelamin'] ?? false)
                        <tr>
                            <td class="label">Jenis Kelamin</td>
                            <td>: {{ $filter['jenis_kelamin'] }}</td>
                        </tr>
                    @endif
                    @if ($filter['status'] ?? false)
                        <tr>
                            <td class="label">Status</td>
                            <td>: {{ $filter['status'] }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="label">Total Data</td>
                        <td>: <strong>{{ count($atlit) }} atlit</strong></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="info-right">
            <div class="print-info">
                <div>Dicetak pada&nbsp;: <span>{{ $tanggal_cetak }}</span></div>
                <div>Pukul&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <span>{{ $waktu_cetak }} WITA</span></div>
                <div>Dicetak oleh&nbsp;: <span>{{ $user_cetak }}</span></div>
            </div>
        </div>
    </div>

    {{-- ===== TABLE DATA ===== --}}
    @if (count($atlit) > 0)
        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="18%">Nama Lengkap</th>
                    <th width="12%">Cabang Olahraga</th>
                    <th width="10%">Klub</th>
                    <th width="8%">Jenis Kelamin</th>
                    <th width="8%">Tgl. Lahir</th>
                    <th width="8%">Kategori</th>
                    <th width="8%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atlit as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                        <td>{{ $item->klub->nama_klub ?? '-' }}</td>
                        <td class="text-center">{{ $item->jenis_kelamin }}</td>
                        <td class="text-center">
                            {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-center">{{ $item->kategoriAtlit->nama_kategori ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status == 'Aktif' ? 'badge-info' : 'badge-secondary' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data atlit yang sesuai dengan filter yang dipilih.</p>
        </div>
    @endif

    {{-- ===== TANDA TANGAN ===== --}}
    <div class="signature">
        <div class="signature-box">
            <p>Gorontalo, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p>Kepala PPLP Provinsi Gorontalo</p>
            <div class="signature-line"></div>
            <p><strong>(.............................)</strong></p>
            <p>NIP. .............................</p>
        </div>
    </div>

    <div class="footer">
        <p>Halaman {PAGE_NUM} dari {PAGE_COUNT}</p>
    </div>

</body>
</html>