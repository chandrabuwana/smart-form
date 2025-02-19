<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BSS-FORM-IT-016</title>
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
            margin-bottom: 15px;
        }
        .header-table td {
            padding: 6px;
            vertical-align: middle;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        .title-section {
            text-align: center;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
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
            margin-bottom: 15px;
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
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : BSS-FRM-IT-016</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 27 Februari 2024</div>
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
            <td>{{ $record->user_no_asset }}</td>
        </tr>
        <tr>
            <td class="info-label">Site</td>
            <td class="info-colon">:</td>
            <td>{{ strtoupper($record->site) }}</td>
            <td class="info-label">Jenis Asset</td>
            <td class="info-colon">:</td>
            <td>{{ $record->jenis_aset }}</td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td colspan="6" style="font-weight: bold; padding: 10px 8px; background-color: #f5f5f5; border: 1px solid #000;">Spesifikasi Asset</td>
        </tr>
        <tr>
            <td class="info-label">Jenis Asset</td>
            <td class="info-colon">:</td>
            <td>{{ $record->jenis_aset }}</td>
            <td class="info-label">Tipe Asset</td>
            <td class="info-colon">:</td>
            <td>{{ $record->tipe_aset }}</td>
        </tr>
        <tr>
            <td class="info-label">Merk</td>
            <td class="info-colon">:</td>
            <td>{{ $record->merk }}</td>
            <td class="info-label">Model</td>
            <td class="info-colon">:</td>
            <td>{{ $record->model }}</td>
        </tr>
        <tr>
            <td class="info-label">Processor</td>
            <td class="info-colon">:</td>
            <td>{{ $record->processor }}</td>
            <td class="info-label">RAM</td>
            <td class="info-colon">:</td>
            <td>{{ $record->ram }}</td>
        </tr>
        <tr>
            <td class="info-label">HDD</td>
            <td class="info-colon">:</td>
            <td>{{ $record->hdd }}</td>
            <td class="info-label">VGA</td>
            <td class="info-colon">:</td>
            <td>{{ $record->vga }}</td>
        </tr>
        <tr>
            <td class="info-label">OS</td>
            <td class="info-colon">:</td>
            <td colspan="4">{{ $record->os }}</td>
        </tr>
    </table>

    <table class="main-table">
        <tr style="background-color: #f0f0f0;">
            <th colspan="2">Kondisi Hardware</th>
            <th colspan="2">Maintenance Task</th>
            <th colspan="2">Software Terinstall</th>
        </tr>
        @php
            $hardware_conditions = [
                'case_casing_condition' => 'Case/Casing',
                'touchscreen_condition' => 'Touchscreen',
                'mouse_condition' => 'Mouse',
                'adaptor_condition' => 'Adaptor',
                'monitor_condition' => 'Monitor',
                'keyboard_condition' => 'Keyboard',
                'port_usb_condition' => 'Port USB',
                'webcam_condition' => 'Webcam',
                'display_condition' => 'Display',
                'speaker_condition' => 'Speaker',
                'fan_processor_condition' => 'Fan Processor',
                'wireless_condition' => 'Wireless',
                'mic_condition' => 'Mic',
                'battery_condition' => 'Battery',
            ];

            $software_installed = [
                'has_ccleaner' => 'CCleaner',
                'has_zoom' => 'Zoom',
                'has_sap' => 'SAP',
                'has_microsoft_office' => 'Microsoft Office',
                'has_anydesk' => 'Anydesk',
                'has_sisoft' => 'SiSoft Sandra',
                'has_erp' => 'ERP',
                'has_vnc_remote' => 'VNC Remote',
                'has_minning_software' => 'Minning Software',
                'has_pdf_viewer' => 'PDF Viewer',
                'has_wepresent' => 'WePresent',
            ];

            $maintenance_tasks = [
                'disk_defragment' => 'Disk Defragment',
                'driver_printer' => 'Driver Printer',
                'clean_temp_file' => 'Clean Temporary File',
                'unused_app' => 'Cek Aplikasi Tidak Digunakan',
                'scan_antivirus' => 'Quick Scan Antivirus',
                'cleaning_fan_internal' => 'Pembersihan Fan Internal',
                'clean_junk_file' => 'Pembersihan File Junk',
                'brightness_level' => 'Test Brightness Display',
                'speaker' => 'Test Speaker',
                'wifi_connection' => 'Test Connection WiFi',
                'hdmi' => 'Test HDMI',
            ];

            $maxRows = max(count($hardware_conditions), count($maintenance_tasks), count($software_installed));
        @endphp

        @for($i = 0; $i < $maxRows; $i++)
            <tr>
                @if(isset(array_values($hardware_conditions)[$i]))
                    @php
                        $hardwareField = array_keys($hardware_conditions)[$i];
                        $hardwareLabel = array_values($hardware_conditions)[$i];
                    @endphp
                    <td>{{ $hardwareLabel }}</td>
                    <td>{{ ucfirst($record->$hardwareField) }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif

                @if(isset(array_values($maintenance_tasks)[$i]))
                    @php
                        $taskField = array_keys($maintenance_tasks)[$i];
                        $taskLabel = array_values($maintenance_tasks)[$i];
                    @endphp
                    <td>{{ $taskLabel }}</td>
                    <td>{{ $record->$taskField ? 'Ya' : 'Tidak' }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
                @if(isset(array_values($software_installed)[$i]))
                    @php
                        $taskField = array_keys($software_installed)[$i];
                        $taskLabel = array_values($software_installed)[$i];
                    @endphp
                    <td>{{ $taskLabel }}</td>
                    <td>{{ ucfirst($record->$taskField) }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
            </tr>
        @endfor
    </table>

    <div class="warning-text">
        !!! PASTIKAN DEVICE DALAM KONDISI BAIK !!!
    </div>
</body>
</html>
