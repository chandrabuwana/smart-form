<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inspeksi Eyewash</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td {
            padding: 5px;
        }
        .logo {
            width: 100px;
        }
        .main-title {
            background-color: #2a83db;
            text-align: center;
            padding: 5px;
            color: white;
        }
        .inspection-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .inspection-table th, .inspection-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .inspection-table th {
            background-color: #D9D9D9;
        }
        .notes {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .page-number {
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <table class="header-table" style="border: 1px solid #000;">
        <tr>
            <td width="15%" style="border: 1px solid #000;">
                <img src="{{ public_path('img/logo-ct-dark.png') }}" class="logo">
            </td>
            <td width="55%" style="text-align: center;">
                <div style="font-size: 14px; font-weight: bold;">BSS SHE Management System</div>
                <div style="font-size: 16px; font-weight: bold; margin: 10px 0;">INSPEKSI EYEWASH</div>
            </td>
            <td width="30%" style="font-size: 10px; border: 1px solid #000;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : BSS-FRM-SHE-037</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 23 November 2021</div>
                <div style="padding: 2px;">Halaman : 1 dari 1</div>
            </td>
        </tr>
    </table>

    <div class="main-title">PEMERIKSAAN EYEWASH</div>

    <table style="width: 100%; margin: 10px 0;">
        <tr>
            <td width="10%">Tanggal :</td>
            <td width="40%">{{ Carbon\Carbon::parse($record->inspection_date)->format('d / m / Y') }}</td>
            <td width="10%">Lokasi :</td>
            <td width="40%">{{ $record->location }}</td>
        </tr>
    </table>

    <table class="inspection-table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Bulan</th>
                <th colspan="7">Item Pemeriksaan</th>
                <th rowspan="2">Paraf</th>
            </tr>
            <tr>
                <th>Kondisi Tangki</th>
                <th>Penutup Tangki</th>
                <th>Warna Air</th>
                <th>Bau Air</th>
                <th>Volume Air</th>
                <th>Kebersihan Tangki</th>
                <th>Fungsi EyeWash</th>
            </tr>
        </thead>
        <tbody>
            @php
                $months = [
                    'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
                    'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
                ];
            @endphp
            @foreach($months as $index => $month)
                @php
                    $monthData = $record->monthly_data[$month] ?? null;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $month }}</td>
                    <td>{{ $monthData['kondisi_tangki'] ?? '' }}</td>
                    <td>{{ $monthData['penutup_tangki'] ?? '' }}</td>
                    <td>{{ $monthData['warna_air'] ?? '' }}</td>
                    <td>{{ $monthData['bau_air'] ?? '' }}</td>
                    <td>{{ $monthData['volume_air'] ?? '' }}</td>
                    <td>{{ $monthData['kebersihan_tangki'] ?? '' }}</td>
                    <td>{{ $monthData['fungsi_eyewash'] ?? '' }}</td>
                    <td>{{ isset($monthData['paraf']) && $monthData['paraf'] ? 'Signed' : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="notes">
        <strong>Catatan:</strong><br>
        {{ $record->notes ?? 'Lakukan rutin setiap minggu inspeksi eye wash dan isikan eye wash apabila level air kurang dan kosong' }}
    </div>

    <table class="signature-table">
        <tr>
            <td width="25%">Dibuat Oleh Tim Hygiene</td>
            <td width="25%">: {{ $record->created_by }}</td>
            <td width="15%">Tanda Tangan</td>
            <td width="20%">: Signed</td>
            <td width="15%">Tanggal</td>
            <td>: {{ Carbon\Carbon::parse($record->inspection_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Diperiksa Oleh Supervisor</td>
            <td>: {{ $record->supervisor }}</td>
            <td>Tanda Tangan</td>
            <td>:</td>
            <td>Tanggal</td>
            <td>:</td>
        </tr>
        <tr>
            <td>Disampaikan kepada DH</td>
            <td>: {{ $record->dh }}</td>
            <td>Tanda Tangan</td>
            <td>: Signed</td>
            <td>Tanggal</td>
            <td>: {{ Carbon\Carbon::parse($record->inspection_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Disampaikan kepada DH Terkait</td>
            <td>:</td>
            <td>Tanda Tangan</td>
            <td>:</td>
            <td>Tanggal</td>
            <td>:</td>
        </tr>
    </table>

    <div style="margin-top: 10px;">*) Dicentang</div>
    <div class="page-number">Revisi 0</div>
</body>
</html>
