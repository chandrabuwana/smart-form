<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Coal Getting Checklist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table.bordered {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            border: 1px solid black;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .indent {
            padding-left: 20px;
        }
        .mt-5 {
            margin-top: 50px;
        }
        .signature-space {
            height: 80px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <table class="bordered">
        <tr>
            <td width="15%" style="border-right: 1px solid black;">
                <img src="{{ public_path('img/logo-ct-dark.png') }}" class="logo">
            </td>
            <td width="55%" class="text-center" style="border-right: 1px solid black;">
                <div class="font-bold" style="font-size: 14px;">INTEGRATED BSS EXCELLENT SYSTEM</div>
                <div class="font-bold" style="font-size: 14px; margin-top: 10px;">CHECKLIST COAL GETTING (ZERO CONTAMINATION)</div>
            </td>
            <td width="30%" style="font-size: 10px;">
                <div style="border-bottom: 1px solid black; padding: 2px;">No.Dok : BSS-FRM-PRO-001</div>
                <div style="border-bottom: 1px solid black; padding: 2px;">Revisi : 1</div>
                <div style="border-bottom: 1px solid black; padding: 2px;">Tanggal : 6 Des 2021</div>
                <div style="padding: 2px;">Halaman : 1 of 1</div>
            </td>
        </tr>
    </table>

    <!-- Basic Information -->
    <div style="margin: 20px 0;">
        <table style="border: none;">
            <tr>
                <td style="border: none; width: 150px;">Tanggal</td>
                <td style="border: none; width: 10px;">:</td>
                <td style="border: none;">{{ date('d F Y', strtotime($record->created_at)) }}</td>
            </tr>
            <tr>
                <td style="border: none;">Lokasi</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ $record->location }}</td>
            </tr>
            <tr>
                <td style="border: none;">Penanggung jawab area</td>
                <td style="border: none;">:</td>
                <td style="border: none;">{{ $record->area_pic }}</td>
            </tr>
        </table>
    </div>

    <!-- Checklist Table -->
    <table class="bordered">
        <thead>
            <tr>
                <th style="width: 5%;" rowspan="2">No</th>
                <th style="width: 50%;" rowspan="2">Pemeriksaan</th>
                <th style="width: 25%;" colspan="2">Kondisi</th>
                <th style="width: 20%;" rowspan="2">Tindakan</th>
            </tr>
            <tr>
                <th class="text-center">Ya</th>
                <th class="text-center">Tidak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checklistItems as $index => $item)
                @if(is_array($item))
                    <!-- Parent item (Kebersihan Front Loading) -->
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item['title'] }}</td>
                        <td colspan="2"></td>
                        <td></td>
                    </tr>
                    @foreach($item['subitems'] as $subIndex => $subitem)
                        <tr>
                            <td></td>
                            <td class="indent">{{ $subitem }}</td>
                            <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                                @if(isset($record->checklist_items[$index][$subIndex]['value']) && $record->checklist_items[$index][$subIndex]['value'] == '1')
                                    ✓
                                @endif
                            </td>
                            <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                                @if(isset($record->checklist_items[$index][$subIndex]['value']) && $record->checklist_items[$index][$subIndex]['value'] == '0')
                                    ✓
                                @endif
                            </td>
                            <td>{{ $record->checklist_items[$index][$subIndex]['notes'] ?? '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item }}</td>
                        <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                            @if(isset($record->checklist_items[$index]['value']) && $record->checklist_items[$index]['value'] == '1')
                                ✓
                            @endif
                        </td>
                        <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                            @if(isset($record->checklist_items[$index]['value']) && $record->checklist_items[$index]['value'] == '0')
                                ✓
                            @endif
                        </td>
                        <td>{{ $record->checklist_items[$index]['notes'] ?? '' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Signature Section -->
    <table style="border: none; margin-top: 5px;">
        <tr>
            <td style="border: none; width: 50%;" class="text-center">Dibuat oleh,</td>
            <td style="border: none; width: 50%;" class="text-center">Diketahui oleh</td>
        </tr>
        <tr style="padding: 10px 0;">
            <td style="border: none; text-align: center; font-weight: bold;">{{ $record->created_by }}</td>
            <td style="border: none; text-align: center; font-weight: bold;">{{ $record->acknowledged_by }}</td>
        </tr>
        <tr>
            <td style="border: none;" class="text-center">Production Foreman</td>
            <td style="border: none;" class="text-center">Production Supervisor</td>
        </tr>
    </table>
</body>
</html>