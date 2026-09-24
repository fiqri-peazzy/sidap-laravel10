<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Atlet - {{ $sekolah->nama_sekolah }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 5px 8px;
            font-size: 11px;
        }

        th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Data Atlet</h2>
        <p>{{ $sekolah->nama_sekolah }}</p>
        <p>{{ $sekolah->jenjang }} — {{ $sekolah->kota }}, {{ $sekolah->provinsi }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>JK</th>
                <th>Klub</th>
                <th>Cabang Olahraga</th>
                <th>Kategori</th>
                <th>Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($atlit as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->klub->nama_klub ?? '-' }}</td>
                    <td>{{ $item->cabangOlahraga->nama_cabang ?? '-' }}</td>
                    <td>{{ $item->kategoriAtlit->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->status_verifikasi_indonesia }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Belum ada data atlet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh {{ $user_cetak }} pada {{ $tanggal_cetak }} — Total {{ count($atlit) }} atlet
    </div>
</body>

</html>
