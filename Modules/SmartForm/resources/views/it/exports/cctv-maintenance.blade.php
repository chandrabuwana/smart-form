<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BSS-FORM-IT-014</title>
    <style>
        @page {
            margin: 30px;
            padding: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }
        .header-table {
            margin-bottom: 25px;
        }
        .header-table td {
            padding: 8px;
            vertical-align: middle;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        .system-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            display: block;
            border-bottom: 1px solid #000;
        }
        .form-title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        .info-table {
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 4px 8px;
            vertical-align: middle;
        }
        .info-label {
            width: 100px;
            font-weight: bold;
        }
        .info-colon {
            width: 20px;
            text-align: center;
        }
        .main-table {
            margin-bottom: 25px;
        }
        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }
        .main-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .warning-text {
            text-align: center;
            font-weight: bold;
            margin: 25px 0;
            text-transform: uppercase;
            border: 2px solid #000;
            padding: 10px;
            background-color: #f5f5f5;
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
                <div style="font-size: 16px; font-weight: bold; margin: 10px 0;">Checklist Maintenance Asset</div>
            </td>
            <td width="30%" style="font-size: 10px; border: 1px solid #000;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : BSS-FRM-IT-014</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 03 Mei 2024</div>
                <div style="padding: 2px;">Halaman : 1 dari 1</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama</td>
            <td class="info-colon">:</td>
            <td>{{ $record->nama }}</td>
            <td class="info-label">Departemen</td>
            <td class="info-colon">:</td>
            <td>{{ $record->dept }}</td>
        </tr>
        <tr>
            <td class="info-label">NIK</td>
            <td class="info-colon">:</td>
            <td>{{ $record->nik }}</td>
            <td class="info-label">No. Asset</td>
            <td class="info-colon">:</td>
            <td>{{ $record->no_asset }}</td>
        </tr>
        <tr>
            <td class="info-label">Site</td>
            <td class="info-colon">:</td>
            <td>{{ $record->site }}</td>
            <td class="info-label">Jenis Asset</td>
            <td class="info-colon">:</td>
            <td>{{ $record->jenis_aset }}</td>
        </tr>
        <tr>
            <td class="info-label">Area CCTV</td>
            <td class="info-colon">:</td>
            <td>{{ $record->area_cctv }}</td>
            <td class="info-label">Model</td>
            <td class="info-colon">:</td>
            <td>{{ $record->model }}</td>
        </tr>
    </table>

    <table class="main-table">
        <tr>
            <th colspan="2">Kondisi Hardware</th>
            <th colspan="2">Maintenance Task</th>
        </tr>
        <tr>
            <td style="width: 25%;">Fisik Kamera</td>
            <td style="width: 25%;">{{ ucfirst($record->camera_condition) }}</td>
            <td style="width: 25%;">Cover Area</td>
            <td style="width: 25%;">{{ $record->cover_area ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Lensa</td>
            <td>{{ ucfirst($record->lens_condition) }}</td>
            <td>Video Quality</td>
            <td>{{ $record->video_quality ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Kondisi Kabel</td>
            <td>{{ ucfirst($record->cable_condition) }}</td>
            <td>Kualitas Suara</td>
            <td>{{ $record->sound_quality ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Storage CCTV</td>
            <td>{{ ucfirst($record->storage_cctv_condition) }}</td>
            <td>Remote View NVR</td>
            <td>{{ $record->remote_view_nvr ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Remote Playback</td>
            <td>{{ $record->remote_playback ? 'Ya' : 'Tidak' }}</td>
        </tr>
    </table>

    <div class="warning-text">
        !!! PASTIKAN CCTV DALAM KONDISI BAIK !!!
    </div>
</body>
</html>
