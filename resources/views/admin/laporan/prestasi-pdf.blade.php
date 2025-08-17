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

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 3px 0;
        }

        .info .label {
            font-weight: bold;
            width: 150px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
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

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .medal-emas {
            color: #ffc107;
            font-weight: bold;
        }

        .medal-perak {
            color: #6c757d;
            font-weight: bold;
        }

        .medal-perunggu {
            color: #17a2b8;
            font-weight: bold;
        }

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
            margin-left: 50px;
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
    <div class="header">
        <h1>{{ $title }}</h1>
        <h2>PUSAT PENDIDIKAN DAN LATIHAN PELAJAR (PPLP)</h2>
    </div>

    <div class="info">
        <table style="border: none;">
            <tr style="border: none;">
                <td class="label" style="border: none;">Tanggal Cetak:</td>
                <td style="border: none;">{{ $tanggal_cetak }}</td>
            </tr>
            @if ($filter['atlit_id'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Atlit:</td>
                    <td style="border: none;">{{ $prestasi->first()->atlit->nama_lengkap ?? '-' }}</td>
                </tr>
            @endif
            @if ($filter['cabang_olahraga_id'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Cabang Olahraga:</td>
                    <td style="border: none;">{{ $prestasi->first()->cabangOlahraga->nama_cabang ?? '-' }}</td>
                </tr>
            @endif
            @if ($filter['tingkat_kejuaraan'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Tingkat Kejuaraan:</td>
                    <td style="border: none;">{{ $filter['tingkat_kejuaraan'] }}</td>
                </tr>
            @endif
            @if ($filter['tahun'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Tahun:</td>
                    <td style="border: none;">{{ $filter['tahun'] }}</td>
                </tr>
            @endif
            @if ($filter['medali'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Medali:</td>
                    <td style="border: none;">{{ $filter['medali'] }}</td>
                </tr>
            @endif
            <tr style="border: none;">
                <td class="label" style="border: none;">Total Data:</td>
                <td style="border: none;"><strong>{{ count($prestasi) }} prestasi</strong></td>
            </tr>
        </table>
    </div>

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
                    <th width="15%">Tempat</th>
                    <th width="10%">Tanggal</th>
                    <th width="5%">Peringkat</th>
                    <th width="7%">Medali</th>
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
                            <span
                                class="badge 
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
                                <span
                                    class="
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

        <!-- Summary -->
        <div style="margin-top: 30px; border-top: 1px solid #ddd; padding-top: 15px;">
            <h4>Ringkasan Prestasi:</h4>
            <table style="width: 50%; margin-top: 10px;">
                <tr>
                    <td style="border: none; padding: 3px 10px;"><strong>Medali Emas:</strong></td>
                    <td style="border: none; padding: 3px 10px;">{{ $prestasi->where('medali', 'Emas')->count() }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 3px 10px;"><strong>Medali Perak:</strong></td>
                    <td style="border: none; padding: 3px 10px;">{{ $prestasi->where('medali', 'Perak')->count() }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 3px 10px;"><strong>Medali Perunggu:</strong></td>
                    <td style="border: none; padding: 3px 10px;">{{ $prestasi->where('medali', 'Perunggu')->count() }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none; padding: 3px 10px;"><strong>Prestasi Internasional:</strong></td>
                    <td style="border: none; padding: 3px 10px;">
                        {{ $prestasi->where('tingkat_kejuaraan', 'Internasional')->count() }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 3px 10px;"><strong>Prestasi Nasional:</strong></td>
                    <td style="border: none; padding: 3px 10px;">
                        {{ $prestasi->where('tingkat_kejuaraan', 'Nasional')->count() }}</td>
                </tr>
            </table>
        </div>
    @else
        <div class="no-data">
            <p>Tidak ada data prestasi yang sesuai dengan filter yang dipilih.</p>
        </div>
    @endif

    <div class="footer">
        <p>Halaman {PAGE_NUM} dari {PAGE_COUNT}</p>
    </div>

    <div class="signature">
        <div class="signature-box">
            <p>Gorontalo, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
            <p>Kepala PPLP Provinsi Gorontalo</p>
            <div class="signature-line"></div>
            <p><strong>(.............................)</strong></p>
            <p>NIP. .............................</p>
        </div>
    </div>
</body>

</html>
