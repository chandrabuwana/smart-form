<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inspeksi P3K</title>
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
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .signature-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .warning-text {
            background-color: #FFA500;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            margin: 20px 0;
        }
        .page-number {
            text-align: right;
            font-size: 10px;
            margin-top: 20px;
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
                <div style="font-size: 16px; font-weight: bold; margin: 10px 0;">INSPEKSI ISI KOTAK P3K</div>
            </td>
            <td width="30%" style="font-size: 10px; border: 1px solid #000;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : BSS-FRM-SHE-035</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 23 November 2021</div>
                <div style="padding: 2px;">Halaman : 1 dari 1</div>
            </td>
        </tr>
    </table>

    <div class="main-title">PEMERIKSAAN ISI KOTAK P3K</div>

    <table style="width: 100%; margin: 10px 0;">
        <tr>
            <td width="15%">Tanggal :</td>
            <td width="35%">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $record->formatted_date)->format('d / m / Y') }}</td>
            <td width="15%">Lokasi P3K :</td>
            <td width="35%">{{ $record->location }}</td>
        </tr>
    </table>

    <table class="inspection-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Item P3K</th>
                <th>Qty</th>
                <th>Sisa</th>
                <th>Keterangan</th>
                <th colspan="2">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($p3kItems as $index => $item)
                @php
                    $itemData = $record->items_data[$item['id']] ?? null;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style="text-align: left;">{{ $item['name'] }}</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ $itemData ? $itemData['current_qty'] : $item['qty'] }}</td>
                    <td style="text-align: left;">{{ $itemData ? $itemData['notes'] : '-' }}</td>
                    <td colspan="2" style="font-family: DejaVu Sans, sans-serif;">{!! $itemData && $itemData['in_stock'] ? '√' : 'x' !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="warning-text">
        PASTIKAN SEMUA PERALATAN EMERGENCY TERPENUHI
    </div>

    <table class="signature-table">
        <tr>
            <td width="25%">Dibuat Oleh Pengawas</td>
            <td width="25%">: {{ $record->created_by }}</td>
            <td width="15%">Tanda Tangan</td>
            <td width="20%">: Signed</td>
            <td width="15%">Tanggal</td>
            <td>: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $record->formatted_date)->format('d F Y') }}</td>
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
            <td>: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $record->formatted_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Diperiksa Oleh SHE</td>
            <td>: {{ $record->she }}</td>
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
