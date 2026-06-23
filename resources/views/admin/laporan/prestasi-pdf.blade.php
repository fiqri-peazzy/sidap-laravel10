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
            line-height: 1.8;
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

        .medal-emas     { color: #c8910a; font-weight: bold; }
        .medal-perak    { color: #6c757d; font-weight: bold; }
        .medal-perunggu { color: #cd7f32; font-weight: bold; }

        /* ===== RINGKASAN ===== */
        .ringkasan {
            margin-top: 25px;
            border-top: 1px solid #ddd;
            padding-top: 12px;
        }
        .ringkasan h4 {
            margin: 0 0 8px 0;
            font-size: 11px;
        }
        .ringkasan table {
            width: 45%;
            margin-top: 5px;
        }
        .ringkasan td {
            border: none;
            padding: 3px 8px;
            font-size: 10px;
        }

        /* ===== FOOTER & TTD ===== */
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 11px;
        }
        .signature {
            margin-top: 40px;
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
                    @if ($filter['atlit_id'] ?? false)
                        <tr>
                            <td class="label">Atlit</td>
                            <td>: {{ $prestasi->first()?->atlit->nama_lengkap ?? '-' }}</td>
                        </tr>
                    @endif
                    @if ($filter['cabang_olahraga_id'] ?? false)
                        <tr>
                            <td class="label">Cabang Olahraga</td>
                            <td>: {{ $prestasi->first()?->cabangOlahraga->nama_cabang ?? '-' }}</td>
                        </tr>
                    @endif
                    @if ($filter['tingkat_kejuaraan'] ?? false)
                        <tr>
                            <td class="label">Tingkat Kejuaraan</td>
                            <td>: {{ $filter['tingkat_kejuaraan'] }}</td>
                        </tr>
                    @endif
                    @if ($filter['tahun'] ?? false)
                        <tr>
                            <td class="label">Tahun</td>
                            <td>: {{ $filter['tahun'] }}</td>
                        </tr>
                    @endif
                    @if ($filter['medali'] ?? false)
                        <tr>
                            <td class="label">Medali</td>
                            <td>: {{ $filter['medali'] }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td class="label">Total Data</td>
                        <td>: <strong>{{ count($prestasi) }} prestasi</strong></td>
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
    @if (count($prestasi) > 0)
        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="15%">Nama Atlit</th>
                    <th width="20%">Nama Kejuaraan</th>
                    <th width="12%">Cabang Olahraga</th>
                    <th width="8%">Tingkat</th>
                    <th width="5%">Tahun</th>
                    <th width="14%">Tempat</th>
                    <th width="10%">Tanggal</th>
                    <th width="5%">Peringkat</th>
                    <th width="8%">Medali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prestasi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->atlit->nama_lengkap ?? '-' }}</td>
                        <td>{{ $item->nama_kejuaraan }}</td>
                        <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge
                                @if ($item->tingkat_kejuaraan == 'Internasional') badge-danger
                                @elseif($item->tingkat_kejuaraan == 'Nasional') badge-warning
                                @elseif($item->tingkat_kejuaraan == 'Provinsi') badge-info
                                @else badge-secondary @endif">
                                {{ $item->tingkat_kejuaraan }}
                            </span>
                        </td>
                        <td class="text-center">{{ $item->tahun }}</td>
                        <td>{{ $item->tempat_kejuaraan }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}
                            @if ($item->tanggal_selesai && $item->tanggal_selesai != $item->tanggal_mulai)
                                - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td class="text-center">{{ $item->peringkat }}</td>
                        <td class="text-center">
                            @if ($item->medali)
                                <span class="
                                    @if ($item->medali == 'Emas') medal-emas
                                    @elseif($item->medali == 'Perak') medal-perak
                                    @elseif($item->medali == 'Perunggu') medal-perunggu @endif">
                                    {{ $item->medali }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ===== RINGKASAN ===== --}}
        <div class="ringkasan">
            <h4>Ringkasan Prestasi:</h4>
            <table>
                <tr>
                    <td><strong>Medali Emas</strong></td>
                    <td>: {{ $prestasi->where('medali', 'Emas')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Medali Perak</strong></td>
                    <td>: {{ $prestasi->where('medali', 'Perak')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Medali Perunggu</strong></td>
                    <td>: {{ $prestasi->where('medali', 'Perunggu')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Prestasi Internasional</strong></td>
                    <td>: {{ $prestasi->where('tingkat_kejuaraan', 'Internasional')->count() }}</td>
                </tr>
                <tr>
                    <td><strong>Prestasi Nasional</strong></td>
                    <td>: {{ $prestasi->where('tingkat_kejuaraan', 'Nasional')->count() }}</td>
                </tr>
            </table>
        </div>

    @else
        <div class="no-data">
            <p>Tidak ada data prestasi yang sesuai dengan filter yang dipilih.</p>
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