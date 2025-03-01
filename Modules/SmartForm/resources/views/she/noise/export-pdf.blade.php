<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Noise Survey Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
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
            width: 120px;
        }

        .main-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            border: 1px solid #000;
            background-color: #f0f0f0;
        }

        .risk-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .risk-table th,
        .risk-table td {
            padding: 5px;
            border: 1px solid #000;
            font-size: 11px;
        }

        .risk-table th {
            background-color: #4472c4;
            color: white;
            text-align: center;
        }

        .risk-critical {
            background-color: #ff0000;
            color: white;
        }

        .risk-high {
            background-color: #ffc000;
        }

        .risk-medium {
            background-color: #ffff00;
        }

        .risk-low {
            background-color: #92d050;
        }

        .measurement-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .measurement-table th,
        .measurement-table td {
            padding: 5px;
            border: 1px solid #000;
            font-size: 11px;
        }

        .measurement-table th {
            background-color: #ff9900;
            color: white;
            text-align: center;
        }

        .findings-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .findings-table td {
            padding: 5px;
            border: 1px solid #000;
            min-height: 50px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            padding: 5px;
            border: 1px solid #000;
        }

        .check {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <table class="header-table" style="border: 1px solid #000;">
        <tr>
            <td width="15%" style="border: 1px solid #000;">
                <img src="{{ public_path('img/logo-ct-dark.png') }}" class="logo">
            </td>
            <td width="55%" style="text-align: center;">
                <div style="font-size: 14px; font-weight: bold;">BSS SHE Management System</div>
                <div style="font-size: 16px; font-weight: bold; margin: 10px 0;">KEBISINGAN / NOISE SURVEY</div>
            </td>
            <td width="30%" style="font-size: 10px; border: 1px solid #000;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No.Dok : BSS-FRM-SHE-015</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 23 November 2021</div>
                <div style="padding: 2px;">Halaman : 1 dari 1</div>
            </td>
        </tr>
    </table>

    <!-- Basic Information -->
    <table class="info-table">
        <tr>
            <td width="20%">Nama Site</td>
            <td width="30%">AGM</td>
            <td width="20%">Lokasi Kerja</td>
            <td width="30%">WORKSHOP</td>
        </tr>
        <tr>
            <td>Dept./Section</td>
            <td>SHE</td>
            <td>Jumlah Inspektor</td>
            <td>{{ $record->inspector_count }}</td>
        </tr>
        <tr>
            <td>Shift</td>
            <td>DS</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <!-- Risk Level Table -->
    <table class="risk-table">
        <tr>
            <th width="20%">TINGKAT RISIKO</th>
            <th width="20%">POTENSI RISIKO</th>
            <th width="30%">Waktu Pemaparan</th>
            <th width="30%">TINDAKAN PERBAIKAN</th>
        </tr>
        <tr class="risk-critical">
            <td>Risiko Kritikal</td>
            <td>&gt; 110 dB</td>
            <td>Maksimal 28.12 Detik</td>
            <td>Gunakan EARMUFF, Jaga Jarak 10-30 Meter dari titik kebisingan</td>
        </tr>
        <tr class="risk-high">
            <td>Resiko Tinggi</td>
            <td>90-100 dB</td>
            <td>Maksimal 30 Menit</td>
            <td>Gunakan Earplug dan Jaga Jarak dari kebisingan 1- - 30 Meter</td>
        </tr>
        <tr class="risk-medium">
            <td>Resiko Sedang</td>
            <td>85-90 dB</td>
            <td>Maksimal 2 Jam</td>
            <td>Gunakan Earplug</td>
        </tr>
        <tr class="risk-low">
            <td>Resiko Rendah</td>
            <td>&lt; 85 dB</td>
            <td>Maksimal 8 Jam</td>
            <td>Identifikasi Kebisingan</td>
        </tr>
    </table>

    <!-- Measurement Table -->
    <table class="measurement-table">
        <thead>
            <tr>
                <th colspan="5" style="background-color: #4472c4; color: white;">PENGUKURAN KEBISINGAN/ NOISE SURVEY
                </th>
            </tr>
            <tr>
                <th width="5%" style="background-color: #d9d9d9; color: black;">No</th>
                <th width="55%" style="background-color: #d9d9d9; color: black;">HAL UNTUK DIPERIKSA</th>
                <th width="20%" style="background-color: #d9d9d9; color: black;">STD</th>
                <th width="10%" style="background-color: #d9d9d9; color: black;">ACTUAL</th>
                <th width="10%" style="background-color: #d9d9d9; color: black;">Keterangan*</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" style="background-color: #ff9900; color: white;">Aktifitas Pekerjaan</td>
            </tr>
            @foreach ($record->activities as $index => $activity)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $activity['name'] }}</td>
                    <td style="text-align: center;">&lt; 85-100</td>
                    <td style="text-align: center;">
                        {{ is_numeric($activity['actual']) && $activity['actual'] != 0 ? number_format($activity['actual'], 1) : '' }}
                    </td>
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                        @switch($activity['status'])
                            @case('below_nab')
                                &lt; NAB
                            @break

                            @case('above_nab')
                                &gt; NAB
                            @break

                            @default
                        @endswitch
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="5" style="background-color: #ff9900; color: white;">Area Kerja</td>
            </tr>
            @foreach ($record->work_areas as $index => $area)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $area['name'] }}</td>
                    <td style="text-align: center;">&lt; 85-100</td>
                    <td style="text-align: center;">
                        {{ is_numeric($area['actual']) && $area['actual'] != 0 ? number_format($area['actual'], 1) : '' }}
                    </td>
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                        @switch($area['status'])
                            @case('below_nab')
                                &lt; NAB
                            @break

                            @case('above_nab')
                                &gt; NAB
                            @break

                            @default
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Findings Description -->
    <table class="findings-table">
        <tr>
            <td style="background-color: #d9d9d9;">Deskripsi Temuan</td>
        </tr>
        <tr>
            <td style="min-height: 100px;">{{ $record->findings_description ?? '-' }}</td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td width="15%">Diinspeksi Oleh</td>
            <td width="25%">: {{ $record->inspected_by }}</td>
            <td width="15%">Tanda Tangan</td>
            <td width="20%">: {{ $record->inspected_signature ? 'Signed' : '' }}</td>
            <td width="10%">Tanggal</td>
            <td width="15%">: {{ $record->formatted_inspection_date }}</td>
        </tr>
        <tr>
            <td>Mengetahui</td>
            <td>: {{ $record->acknowledged_by }}</td>
            <td>Tanda Tangan</td>
            <td>: {{ $record->acknowledged_signature ? 'Signed' : '' }}</td>
            <td>Tanggal</td>
            <td>: {{ $record->formatted_acknowledgment_date }}</td>
        </tr>
    </table>
</body>

</html>
