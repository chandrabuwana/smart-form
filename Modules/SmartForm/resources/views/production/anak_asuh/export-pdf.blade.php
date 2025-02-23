<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Monitoring Control Disiplin, Skill & Attitude Anak Asuh</title>
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
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table th,
        .main-table td {
            padding: 5px;
            border: 1px solid #000;
            text-align: center;
        }
        .main-table th {
            background-color: #00a65a;
            color: white;
        }
        .main-table th.kehadiran {
            text-align: center;
        }
        .main-table th.kategori {
            text-align: center;
        }
        .legend-table {
            width: 50%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .legend-table td {
            padding: 3px;
        }
        .kurang { background-color: #ff0000; color: white; }
        .cukup { background-color: #ffff00; }
        .baik { background-color: #92d050; }
        .sangat-baik { background-color: #00b0f0; }
    </style>
</head>
<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('img/logo-ct-dark.png') }}" class="logo">
            </td>
            <td width="85%" style="text-align: center;">
                <div style="font-size: 16px; font-weight: bold;">FORM MONITORING CONTROL DISIPLIN, SKILL & ATTITUDE ANAK ASUH</div>
            </td>
        </tr>
    </table>

    <!-- Basic Information -->
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td width="10%">NAMA</td>
            <td width="1%">:</td>
            <td width="39%">{{ $record->name }}</td>
            <td width="15%">DEPARTEMEN</td>
            <td width="1%">:</td>
            <td width="34%">{{ $record->departemen }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $record->nik }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>JABATAN</td>
            <td>:</td>
            <td>{{ $record->jabatan }}</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <!-- Main Table -->
    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">SHIFT</th>
                <th rowspan="2">NO</th>
                <th rowspan="2">NAMA ANAK ASUH</th>
                <th colspan="4" class="kehadiran">KEHADIRAN</th>
                <th rowspan="2">REVIEW / TEMUAN</th>
                <th colspan="3" class="kategori">KATEGORI</th>
            </tr>
            <tr>
                <th>HADIR</th>
                <th>IZIN</th>
                <th>SAKIT</th>
                <th>ALFA</th>
                <th>DISIPLIN</th>
                <th>SKILL</th>
                <th>ATTITUDE</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Values are already decoded in the controller, no need to decode again
                $tanggal_items = $record->tanggal_items ?? [];
                $shift_items = $record->shift_items ?? [];
                $nama_anak_asuh_items = $record->nama_anak_asuh_items ?? [];
                $attendance_items = $record->attendance_items ?? [];
                $review_temuan_items = $record->review_temuan_items ?? [];
                $disiplin_score_items = $record->disiplin_score_items ?? [];
                $skill_score_items = $record->skill_score_items ?? [];
                $attitude_score_items = $record->attitude_score_items ?? [];
            @endphp

            @for($i = 0; $i < 10; $i++)
                <tr>
                    <td>{{ $tanggal_items[$i] ?? '' }}</td>
                    <td>{{ $shift_items[$i] ?? '' }}</td>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $nama_anak_asuh_items[$i] ?? '' }}</td>
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($attendance_items[$i]) && $attendance_items[$i] === 'hadir' ? '✓' : '' !!}</td>
                    <td>{!! isset($attendance_items[$i]) && $attendance_items[$i] === 'izin' ? '✓' : '' !!}</td>
                    <td>{!! isset($attendance_items[$i]) && $attendance_items[$i] === 'sakit' ? '✓' : '' !!}</td>
                    <td>{!! isset($attendance_items[$i]) && $attendance_items[$i] === 'alfa' ? '✓' : '' !!}</td>
                    <td style="text-align: left;">{{ $review_temuan_items[$i] ?? '' }}</td>
                    <td>{{ $disiplin_score_items[$i] ?? '' }}</td>
                    <td>{{ $skill_score_items[$i] ?? '' }}</td>
                    <td>{{ $attitude_score_items[$i] ?? '' }}</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <!-- Legend -->
    <div style="margin-top: 20px;">
        <div style="font-weight: bold; margin-bottom: 5px;">Keterangan:</div>
        <div style="margin-bottom: 5px;">Penilaian Kategori (Disiplin/Skill/Attitude)</div>
        <div style="margin-bottom: 5px;">Range Penilaian (1 (Min) - 4 (Max))</div>
        <table class="legend-table">
            <tr>
                <td width="30" class="kurang">&nbsp;</td>
                <td>1. Kurang</td>
            </tr>
            <tr>
                <td width="30" class="cukup">&nbsp;</td>
                <td>2. Cukup</td>
            </tr>
            <tr>
                <td width="30" class="baik">&nbsp;</td>
                <td>3. Baik</td>
            </tr>
            <tr>
                <td width="30" class="sangat-baik">&nbsp;</td>
                <td>4. Sangat Baik</td>
            </tr>
        </table>
    </div>

    <!-- Signatures -->
    <table style="width: 100%; margin-top: 50px;">
        <tr>
            <td width="40%" style="text-align: center;">
                Dibuat Oleh,<br><br><br><br>
                ( {{ $record->created_by }} )
            </td>
            <td width="20%"></td>
            <td width="40%" style="text-align: center;">
                Diketahui Oleh,<br><br><br><br>
                ( {{ $record->acknowledged_by }} )
            </td>
        </tr>
    </table>
</body>
</html>