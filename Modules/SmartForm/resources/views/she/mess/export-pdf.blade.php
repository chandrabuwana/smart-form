<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inspeksi Toilet, Mess, dan Kantor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td, th {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }
        .header-table {
            margin-bottom: 10px;
            border: 1px solid #000;
        }
        .logo {
            width: 100px;
            height: auto;
        }
        .header-right td {
            font-size: 11px;
            padding: 2px 5px;
            border: none;
        }
        .risk-table th {
            background-color: #3498db;
            color: white;
            text-align: center;
            font-size: 11px;
        }
        .risk-critical { background-color: #ff0000; color: white; }
        .risk-high { background-color: #ffa500; }
        .risk-medium { background-color: #ffff00; }
        .risk-low { background-color: #90EE90; }
        .text-center { text-align: center; }
        .small-text { font-size: 10px; }
        .check { font-family: DejaVu Sans, sans-serif; }
        .checklist-header {
            background-color: #4472c4;
            color: white;
            text-align: center;
            font-weight: bold;
        }
        .gray-bg {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="15%" style="border-right: 1px solid #000;">
                <img src="{{ public_path('img/logo-ct-dark.png') }}" class="logo">
            </td>
            <td width="55%" style="text-align: center; border-right: 1px solid #000;">
                <div style="font-size: 14px; font-weight: bold;">BSS SHE Management System</div>
                <div style="font-size: 14px; font-weight: bold;">Inspeksi Toilet, Mess, dan Kantor</div>
            </td>
            <td width="30%" style="padding: 0;">
                <table style="margin: 0; border: none;">
                    <tr><td style="border: none;">No.Dok : BSS-FRM-SHE-034</td></tr>
                    <tr><td style="border: none;">Revisi : 00</td></tr>
                    <tr><td style="border: none;">Tanggal : 23 November 2021</td></tr>
                    <tr><td style="border: none;">Halaman : 1 dari 1</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Basic Information -->
    <table>
        <tr>
            <td width="15%" class="gray-bg">Nama Site</td>
            <td width="35%">{{ $data->site_name }}</td>
            <td width="15%" class="gray-bg">Lokasi Kerja</td>
            <td width="35%">{{ $data->work_location }}</td>
        </tr>
        <tr>
            <td class="gray-bg">Dept./Section</td>
            <td>{{ $data->department }}</td>
            <td class="gray-bg">Jumlah Inspektor</td>
            <td>{{ $data->inspector_count }}</td>
        </tr>
        <tr>
            <td class="gray-bg">Shift</td>
            <td colspan="3">{{ $data->shift }}</td>
        </tr>
    </table>

    <!-- Risk Level Table -->
    <table>
        <tr>
            <th width="15%" class="risk-table">TINGKAT RISIKO</th>
            <th width="15%" class="risk-table">POTENSI RISIKO</th>
            <th width="35%" class="risk-table">KEMUNGKINAN AKIBAT</th>
            <th width="35%" class="risk-table">TINDAKAN PERBAIKAN</th>
        </tr>
        <tr class="risk-critical">
            <td>Risiko Kritikal</td>
            <td class="text-center">75 - 125</td>
            <td class="small-text">
                > Rp 100 Juta dan Sakit akut/ meninggal<br>
                Tidak sesuai baku mutu/peraturan perundangan, penghentian permanen perusahaan atau berdampak ke masyarakat nasional
            </td>
            <td class="small-text">
                TIDAK DAPAT DITERIMA (STOP). Pekerjaan tidak boleh dilakukan sampai tingkat risiko diturunkan. Jika tidak dapat diturunkan sekaligus dengan sumberdaya yang lebih terbatas, pekerjaan dihentikan dan tidak boleh dilakukan
            </td>
        </tr>
        <tr class="risk-high">
            <td>Risiko Tinggi</td>
            <td class="text-center">32 - 75</td>
            <td class="small-text">
                Rp 50 Juta – Rp 100 Juta dan Sakit dan rawat inap /kronis/PAK<br>
                Tidak sesuai baku mutu/peraturan perundangan dan mendapatkan peringatan keras dari pemerintah, penghentian operasional perusahaan sementara atau berdampak ke masyarakat yg lebih luas
            </td>
            <td class="small-text">
                Pekerjaan dapat dilakukan. Tindakan pengendalian segera dilakukan untuk menurunkan tingkat resiko. Keterlibatan Pimpinan diperlukan untuk pengendalian resiko tersebut
            </td>
        </tr>
        <tr class="risk-medium">
            <td>Risiko Sedang</td>
            <td class="text-center">18 - 32</td>
            <td class="small-text">
                Rp 10 Juta – Rp 50 Juta, Ada gangguan tidak dapat masuk kerja<br>
                Sesuai dengan baku mutu/peraturan perundangan atau berdampak ke masyarakat di sekitar area perusahaan
            </td>
            <td class="small-text">
                Harus dilakukan pengendalian tambahan untuk menurunkan tingkat resiko. Pengendalian tambahan harus diterapkan dalam periode waktu tertentu
            </td>
        </tr>
        <tr class="risk-low">
            <td>Risiko Rendah</td>
            <td class="text-center">2 - 18</td>
            <td class="small-text">
                Ada Kerusakan dan Rp 0 - Rp 10 Juta<br>
                Tidak ada peraturan yg berlaku atau berdampak kelingkungan perusahaan
            </td>
            <td class="small-text">
                Tidak diperlukan pengendalian tambahan. Diperlukan pemantauan untuk memastikan pengendalian yang ada dipelihara dan dilaksanakan
            </td>
        </tr>
    </table>

    <!-- Checklist Table -->
    <table>
        <tr>
            <td colspan="5" class="checklist-header">CHECKLIST INSPEKSI MESS</td>
        </tr>
        <tr class="gray-bg">
            <td width="5%">No</td>
            <td width="45%">HAL UNTUK DIPERIKSA</td>
            <td width="12%" class="text-center">Ya</td>
            <td width="12%" class="text-center">Tidak</td>
            <td width="26%">Keterangan</td>
        </tr>
        @php
            $checklistItems = [
                'Bangunan, Atap, dinding, pintu, jendela, aman dan bersih.',
                'Permukaan tempat jalan, lantai dalam kondis bersih dan didisinfeksi',
                'Pencahayaan / Penerangan kamar / ruangan memadai',
                'Ventilasi kamar, segala ruangan Memadai',
                'Kebersihan dan housekeeping yang baik di dalam rumah dan sekitarnya',
                'Tempat tidur dan kasur dalam kondisi bersih dan rapi',
                'Kamar mandi dan toilet bersih dan berfungsi dengan baik',
                'Tempat sampah tersedia dan dikelola dengan baik',
                'Peralatan P3K tersedia dan lengkap',
                'APAR tersedia dan dalam kondisi baik',
                'Instalasi listrik aman dan rapi',
                'Area dapur bersih dan tertata rapi',
                'Peralatan dapur bersih dan tersimpan dengan baik',
                'Area makan bersih dan nyaman',
                'Sistem drainase berfungsi dengan baik'
            ];
        @endphp
        @foreach($checklistItems as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item }}</td>
            <td class="text-center check">{!! isset($data->checklist_items[$index]['condition']) && $data->checklist_items[$index]['condition'] === 'OK' ? '✓' : '' !!}</td>
            <td class="text-center check">{!! isset($data->checklist_items[$index]['condition']) && $data->checklist_items[$index]['condition'] === 'NOT OK' ? '✓' : '' !!}</td>
            <td>{{ isset($data->checklist_items[$index]['notes']) ? $data->checklist_items[$index]['notes'] : '' }}</td>
        </tr>
        @endforeach
    </table>

    <!-- Rincian Bahaya & Perbaikan -->
    <table>
        <tr>
            <td width="40%" class="gray-bg">Rincian Bahaya</td>
            <td width="40%" class="gray-bg">Perbaikan Langsung</td>
            <td width="20%" class="gray-bg">Dilakukan Oleh</td>
        </tr>
        <tr>
            <td>{{ $data->hazard_details ?? '-' }}</td>
            <td>{{ $data->immediate_repair ?? '-' }}</td>
            <td>{{ $data->repaired_by ?? '-' }}</td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $data->inspected_by ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $data->inspected_signature ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->inspection_date ? date('d F Y', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $data->inspection_date)))) : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $data->inspected_by2 ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $data->inspected_signature2 ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->inspection_date2 ? date('d F Y', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $data->inspection_date2)))) : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $data->inspected_by3 ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $data->inspected_signature3 ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->inspection_date3 ? date('d F Y', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $data->inspection_date3)))) : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Mengetahui</td>
            <td style="padding: 10px;">{{ $data->acknowledged_by ?? '-'}}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px;">{{ $data->acknowledged_signature ? 'Signed' : '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->acknowledgment_date ? date('d F Y', strtotime(str_replace(':AM', ' AM', str_replace(':PM', ' PM', $data->acknowledgment_date)))) : '-' }}</td>
        </tr>
    </table>
</body>
</html>