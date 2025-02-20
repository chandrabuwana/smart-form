<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Air Minum Inspection Form</title>
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
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .checklist-table th,
        .checklist-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .checklist-table th {
            background-color: #4472c4;
            color: white;
            text-align: center;
        }
        .score-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .score-table td {
            padding: 5px;
            border: 1px solid #000;
            text-align: center;
        }
        .conclusion-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid black;
        }
        .conclusion-table td {
            padding: 5px;
            border: 1px solid #000;
            text-align: center;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .very-poor { background-color: #ff0000; color: white; }
        .poor { background-color: #ffc000; }
        .good { background-color: #92d050; }
        .excellent { background-color: #00b0f0; }
        .check { font-family: DejaVu Sans, sans-serif; }
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
                <div style="font-size: 16px; font-weight: bold; margin: 10px 0;">INSPEKSI AIR MINUM</div>
            </td>
            <td width="30%" style="font-size: 10px; border: 1px solid #000;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : BSS-FRM-SHE-049</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 26 November 2022</div>
                <div style="padding: 2px;">Halaman : 1 dari 1</div>
            </td>
        </tr>
    </table>

    <!-- Basic Information -->
    <table class="info-table">
        <tr>
            <td width="20%">Nama Site</td>
            <td width="30%">{{ strtoupper($record->site_name) }}</td>
            <td width="20%">Lokasi Kerja</td>
            <td width="30%">{{ $record->work_location }}</td>
        </tr>
        <tr>
            <td>Dept./Section</td>
            <td>{{ $record->department }}</td>
            <td>Jumlah Inspektor</td>
            <td>{{ $record->inspector_count }}</td>
        </tr>
        <tr>
            <td>Shift</td>
            <td>{{ $record->shift }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <!-- Checklist -->
    <table class="checklist-table">
        <thead>
            <tr>
                <th colspan="4">INSPEKSI CATERING CHECKLIST</th>
            </tr>
            <tr>
                <th width="5%">No</th>
                <th width="65%">HAL UNTUK DIPERIKSA</th>
                <th width="15%">Y</th>
                <th width="15%">N</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Apakah area kerja kebersihannya terjaga?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->is_work_area_clean ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->is_work_area_clean ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Apakah banyak barang yang berserakan?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->has_scattered_items ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->has_scattered_items ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Apakah ada tempat sampah?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->has_trash_bin ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->has_trash_bin ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Apakah ada sampah berserakan?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->has_scattered_trash ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->has_scattered_trash ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Apakah ada gudang penyimpanan barang?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->has_storage_warehouse ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->has_storage_warehouse ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Apakah filtrasi pengolahan air minum/air bersih rutin diganti?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->is_water_filter_regularly_changed ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->is_water_filter_regularly_changed ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>7</td>
                <td>Apakah tempat tampungan air rutin dikuras?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->is_water_reservoir_cleaned ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->is_water_reservoir_cleaned ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>8</td>
                <td>Apakah tempat packing distribusi air terjaga kebersihan dan kerapiannya?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->is_distribution_packing_clean ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->is_distribution_packing_clean ? '✓' : '' !!}</td>
            </tr>
            <tr>
                <td>9</td>
                <td>Apakah pengecekan kualitas air minum/air bersih rutin dilakukan setiap per 3 bulan sekali?</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! $record->is_water_quality_checked_quarterly ? '✓' : '' !!}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! !$record->is_water_quality_checked_quarterly ? '✓' : '' !!}</td>
            </tr>
        </tbody>
    </table>

    <!-- Score -->
    <table class="score-table">
        <tr>
            <td colspan="10" style="font-weight: bold;">SCORE PENERIMAAN</td>
        </tr>
        <tr>
            <td colspan="2">Very Poor</td>
            <td colspan="3">Poor</td>
            <td colspan="3">Good</td>
            <td colspan="2">Excellent</td>
        </tr>
        <tr>
            <td class="very-poor">1</td>
            <td class="very-poor">2</td>
            <td class="poor">3</td>
            <td class="poor">4</td>
            <td class="poor">5</td>
            <td class="good">6</td>
            <td class="good">7</td>
            <td class="good">8</td>
            <td class="excellent">9</td>
            <td class="excellent">10</td>
        </tr>
        <tr>
            <td colspan="10" style="font-weight: bold;">NILAI: {{ $record->score }}</td>
        </tr>
    </table>

    <!-- Conclusion -->
    <table class="conclusion-table">
        <tr>
            <td width="20%" style="font-weight: bold; text-align: center; padding: 15px; background-color: #f5f5f5; vertical-align: middle;">
                CONCLUSION INSPEKSI
            </td>
            <td width="20%" class="very-poor" style="
                text-align: center; 
                padding: 10px;
                {{ $record->conclusion == 'Very Poor' ? 'border: 3px solid black;' : 'border: 1px solid #ddd;' }}">
                Very Poor
            </td>
            <td width="20%" class="poor" style="
                text-align: center; 
                padding: 10px;
                {{ $record->conclusion == 'Poor' ? 'border: 3px solid black;' : 'border: 1px solid #ddd;' }}">
                Poor
            </td>
            <td width="20%" class="good" style="
                text-align: center; 
                padding: 10px;
                {{ $record->conclusion == 'Good' ? 'border: 3px solid black;' : 'border: 1px solid #ddd;' }}">
                Good
            </td>
            <td width="20%" class="excellent" style="
                text-align: center; 
                padding: 10px;
                {{ $record->conclusion == 'Excellent' ? 'border: 3px solid black;' : 'border: 1px solid #ddd;' }}">
                Excellent
            </td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $record->inspector_1 ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $record->inspector_1_signature ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $record->inspection_date ? \Carbon\Carbon::parse($record->inspection_date)->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $record->inspector_2 ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $record->inspector_2_signature ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $record->inspection_date ? \Carbon\Carbon::parse($record->inspection_date)->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $record->inspector_3 ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $record->inspector_3_signature ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $record->inspection_date ? \Carbon\Carbon::parse($record->inspection_date)->format('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Mengetahui</td>
            <td style="padding: 10px;">{{ $record->acknowledged_by ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $record->acknowledged_by_signature ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $record->acknowledged_date ? \Carbon\Carbon::parse($record->acknowledged_date)->format('d F Y') : '-' }}</td>
        </tr>
    </table>
</body>
</html>