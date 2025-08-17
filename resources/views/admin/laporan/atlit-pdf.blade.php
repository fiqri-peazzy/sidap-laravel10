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
            font-size: 11px;
        }

        td {
            padding: 6px 4px;
            text-align: left;
            font-size: 10px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-primary {
            background-color: #007bff;
        }

        .badge-info {
            background-color: #17a2b8;
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
            @if ($filter['klub_id'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Klub:</td>
                    <td style="border: none;">{{ $atlit->first()->klub->nama_klub ?? '-' }}</td>
                </tr>
            @endif
            @if ($filter['cabang_olahraga_id'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Cabang Olahraga:</td>
                    <td style="border: none;">{{ $atlit->first()->cabangOlahraga->nama_cabang ?? '-' }}</td>
                </tr>
            @endif
            @if ($filter['jenis_kelamin'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Jenis Kelamin:</td>
                    <td style="border: none;">{{ $filter['jenis_kelamin'] }}</td>
                </tr>
            @endif
            @if ($filter['status'] ?? false)
                <tr style="border: none;">
                    <td class="label" style="border: none;">Status:</td>
                    <td style="border: none;">{{ $filter['status'] }}</td>
                </tr>
            @endif
            <tr style="border: none;">
                <td class="label" style="border: none;">Total Data:</td>
                <td style="border: none;"><strong>{{ count($atlit) }} atlit</strong></td>
            </tr>
        </table>
    </div>

    @if (count($atlit) > 0)
        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="18%">Nama Lengkap</th>
                    <th width="12%">NIK</th>
                    <th width="8%">JK</th>
                    <th width="8%">Umur</th>
                    <th width="15%">Klub</th>
                    <th width="15%">Cabang Olahraga</th>
                    <th width="12%">Kategori</th>
                    <th width="8%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atlit as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->nik }}</td>
                        <td class="text-center">
                            @if ($item->jenis_kelamin == 'Laki-laki')
                                L
                            @else
                                P
                            @endif
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }}</td>
                        <td>{{ $item->klub->nama_klub ?? '-' }}</td>
                        <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                        <td>{{ $item->kategoriAtlit->nama_kategori ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
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
