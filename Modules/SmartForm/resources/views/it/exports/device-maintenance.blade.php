<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Form Pemeriksaan Device</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            padding: 0;
        }
        .header h2 {
            font-size: 16px;
            margin: 5px 0;
            padding: 0;
        }
        .header p {
            font-size: 14px;
            margin: 5px 0;
            padding: 0;
        }
        .form-number {
            position: absolute;
            top: 20px;
            right: 20px;
            border: 1px solid #000;
            padding: 5px 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.info {
            margin-bottom: 20px;
        }
        table.info td {
            padding: 3px 0;
        }
        table.info td:first-child {
            width: 120px;
        }
        table.info td:nth-child(2) {
            width: 10px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .main-table th {
            text-align: center;
        }
        .checklist {
            border: 1px solid #000;
        }
        .checklist th,
        .checklist td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .checklist th {
            background-color: #f0f0f0;
        }
        .warning {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 10px;
        }
        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            width: 45%;
            text-align: center;
        }
        .signature p {
            margin: 5px 0;
        }
        .signature .line {
            border-bottom: 1px solid #000;
            margin: 50px 0 10px 0;
        }
        .note {
            margin-top: 30px;
            font-style: italic;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="form-number">No. Form: {{ $record->doc_number ?? '001' }}</div>

    <div class="header">
        <h1>FORM PEMERIKSAAN DEVICE</h1>
        <h2>PT BINA SARANA SUKSES</h2>
        <p>NO: BSS-FORM-IT-012</p>
    </div>

    <table class="info">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $record->nama }}</td>
            <td style="width: 100px;">Departemen</td>
            <td>:</td>
            <td>{{ $record->dept }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>TEKNISI</td>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $record->doc_date ? date('Y-m-d', strtotime($record->doc_date)) : date('Y-m-d') }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $record->nik }}</td>
            <td>No. Asset</td>
            <td>:</td>
            <td>{{ $record->user_no_asset }}</td>
        </tr>
        <tr>
            <td>Site</td>
            <td>:</td>
            <td>{{ strtoupper($record->site) }}</td>
            <td>Jenis Asset</td>
            <td>:</td>
            <td>{{ $record->jenis_aset }}</td>
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
                    <td>{{ $record->$taskField ? 'Ya' : 'Tidak' }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
            </tr>
        @endfor
    </table>

    <div class="warning">
        !!! PASTIKAN DEVICE DALAM KONDISI BAIK !!!
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
