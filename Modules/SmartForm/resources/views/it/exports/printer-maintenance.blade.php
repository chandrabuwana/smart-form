<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BSS-FORM-IT-013</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 30px;
            font-size: 12px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 30px;
        }
        .header-table td {
            padding: 0;
            vertical-align: top;
        }
        .title-cell {
            text-align: center;
            padding-bottom: 20px !important;
        }
        .form-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-number {
            font-size: 12px;
            font-weight: bold;
        }
        .doc-number {
            text-align: right;
        }
        .doc-number-box {
            border: 1px solid black;
            padding: 5px 15px;
            display: inline-block;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 0;
        }
        .info-label {
            width: 120px;
        }
        .info-colon {
            width: 20px;
            text-align: center;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table th, .main-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        .main-table th {
            background-color: #ffffff;
        }
        .warning-text {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            padding: 10px;
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
                <div style="font-size: 14px; font-weight: bold; border-bottom: 1px solid black;">BSS SHE Management System</div>
                <div style="font-size: 16px; font-weight: bold; margin: 10px 0;">FORM PEMERIKSAAN PRINTER</div>
            </td>
            <td width="30%" style="font-size: 10px; border: 1px solid #000;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : {{ $record->doc_number ?? '-' }}</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : {{ $record->created_at ? date('d F Y', strtotime($record->created_at)) : '-' }}</div>
                <div style="padding: 2px;">Halaman : 1 dari 1</div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama</td>
            <td class="info-colon">:</td>
            <td>{{ $record->nama }}</td>
            <td class="info-label">Merk</td>
            <td class="info-colon">:</td>
            <td>{{ $record->merk }}</td>
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
        <td class="info-label">Departemen</td>
            <td class="info-colon">:</td>
            <td>{{ $record->dept }}</td>
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
            <td style="width: 25%;">Case/Casing</td>
            <td style="width: 25%;">{{ ucfirst($record->case_casing_condition) }}</td>
            <td style="width: 25%;">Software Update</td>
            <td style="width: 25%;">{{ $record->software_update ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Adaptor</td>
            <td>{{ ucfirst($record->adaptor_condition) }}</td>
            <td>Print Test</td>
            <td>{{ $record->print_test ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Kabel Power</td>
            <td>{{ ucfirst($record->kabel_power_condition) }}</td>
            <td>Scan Test</td>
            <td>{{ $record->scan_test ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Paper Tray</td>
            <td>{{ ucfirst($record->paper_tray_condition) }}</td>
            <td>Network Test</td>
            <td>{{ $record->network_test ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Ink/Toner</td>
            <td>{{ ucfirst($record->ink_condition) }}</td>
            <td>Bluetooth Test</td>
            <td>{{ $record->bluetooth_test ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Cartridge</td>
            <td>{{ ucfirst($record->cartridge_condition) }}</td>
            <td>Cable Test</td>
            <td>{{ $record->cable_test ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Lamp Indicator</td>
            <td>{{ ucfirst($record->lamp_indicator_condition) }}</td>
            <td>Toner Level</td>
            <td>{{ $record->toner_level ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td>Touchscreen</td>
            <td>{{ ucfirst($record->touchscreen_condition) }}</td>
            <td colspan="2"></td>
        </tr>
    </table>

    <div class="warning-text">
        !!! PASTIKAN PRINTER DALAM KONDISI BAIK !!!
    </div>

    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td style="width: 50%; text-align: center;">Diperiksa Oleh,</td>
                <td style="width: 50%; text-align: center;">Diketahui Oleh,</td>
            </tr>
            <tr>
                <td style="text-align: center; padding-top: 60px;">
                    <div style="border-top: 1px solid black; display: inline-block; width: 200px;"></div>
                    <div>Teknisi IT</div>
                </td>
                <td style="text-align: center; padding-top: 60px;">
                    <div style="border-top: 1px solid black; display: inline-block; width: 200px;"></div>
                    <div>User</div>
                </td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 30px; font-size: 10px; font-style: italic;">
        Note: Form Mohon diprint menggunakan kertas carbonize 3 (tiga) rangkap<br>
        Peruntukkan rangkap putih (IT), rangkap merah (user) & rangkap kuning (admin data center)
    </div>
</body>
</html>
