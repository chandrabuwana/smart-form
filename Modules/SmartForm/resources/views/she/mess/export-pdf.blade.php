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
        <tr>
            <td class="risk-critical">Risiko Kritikal</td>
            <td class="text-center" style="font-weight: bold;">75 - 125</td>
            <td class="small-text">
                > Rp 100 Juta dan Sakit akut/ meninggal<br>
                Tidak sesuai baku mutu/peraturan perundangan, penghentian permanen perusahaan atau berdampak ke masyarakat nasional
            </td>
            <td class="small-text">
                <span class="risk-critical">TIDAK DAPAT DITERIMA (STOP).</span> Pekerjaan tidak boleh dilakukan sampai tingkat risiko diturunkan. Jika tidak dapat diturunkan sekaligus dengan sumberdaya yang lebih terbatas, pekerjaan dihentikan dan tidak boleh dilakukan
            </td>
        </tr>
        <tr>
            <td class="risk-high">Risiko Tinggi</td>
            <td class="text-center" style="font-weight: bold;">32 - 75</td>
            <td class="small-text">
                Rp 50 Juta – Rp 100 Juta dan Sakit dan rawat inap /kronis/PAK<br>
                Tidak sesuai baku mutu/peraturan perundangan dan mendapatkan peringatan keras dari pemerintah, penghentian operasional perusahaan sementara atau berdampak ke masyarakat yg lebih luas
            </td>
            <td class="small-text">
                Pekerjaan dapat dilakukan. Tindakan pengendalian segera dilakukan untuk menurunkan tingkat resiko. Keterlibatan Pimpinan diperlukan untuk pengendalian resiko tersebut
            </td>
        </tr>
        <tr>
            <td class="risk-medium">Risiko Sedang</td>
            <td class="text-center" style="font-weight: bold;">18 - 32</td>
            <td class="small-text">
                Rp 10 Juta – Rp 50 Juta, Ada gangguan tidak dapat masuk kerja<br>
                Sesuai dengan baku mutu/peraturan perundangan atau berdampak ke masyarakat di sekitar area perusahaan
            </td>
            <td class="small-text">
                Harus dilakukan pengendalian tambahan untuk menurunkan tingkat resiko. Pengendalian tambahan harus diterapkan dalam periode waktu tertentu
            </td>
        </tr>
        <tr>
            <td class="risk-low">Risiko Rendah</td>
            <td class="text-center" style="font-weight: bold;">2 - 18</td>
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
            <td colspan="6" class="checklist-header">CHECKLIST INSPEKSI MESS</td>
        </tr>
        <tr class="gray-bg">
            <td width="5%">No</td>
            <td width="45%">HAL UNTUK DIPERIKSA</td>
            <td colspan="2" width="20%" class="text-center">Kondisi Actual</td>
            <td class="gray-bg">Tingkat Resiko</td>
            <td class="gray-bg">Keterangan</td>
        </tr>
        <tr class="gray-bg">
            <td></td>
            <td></td>
            <td width="10%" class="text-center">Ya</td>
            <td width="10%" class="text-center">Tidak</td>
            <td></td>
            <td></td>
        </tr>
        
        @php
        $checklistItems = [
                                            'Bangunan, Atap, dinding, pintu, jendela, aman dan bersih.',
                                            'Permukaan tempat jalan, lantai dalam kondis bersih dan didisinfeksi',
                                            'Pencahayaan / Penerangan kamar / ruangan memadai',
                                            'Ventilasi kamar, segala ruangan Memadai',
                                            'Kebersihan dan housekeeping yang baik di dalam rumah dan sekitarnya',
                                            'Tempat sampah mencukupi / dikosongkan secara berkala',
                                            'Tempat tidur / kamar bersih, rapi dan tidak bau lembab, ada kipas / ACnya',
                                            'Kamar mandi bersih, mnim 3 X seminggu dikuras baknya .',
                                            'Ada tempat jemuran yang bersih, sinar cukup dan aman',
                                            'Toilet bersih dan Didisinfeksi, ketersediaan air cukup dan kran air berfungsi baik, ada peralatan kebersihannya.',
                                            'Atap tidak bocor',
                                            'Tempat penyiapan makanan yang mencukupi, bersih dan bebas serangga,',
                                            'Instalasi Gas terkompresi Aman',
                                            'Kunci pintu - jendela dalam kondisi bagus dan bisa digunakan - ada teralis',
                                            'Kotak listrik / saklar penggerak / sambungan kabel aman',
                                            'Furnitur rumah dan Ergonomi',
                                            'Rak sepatu, tempat air minum, dan peralatan lain bersih dan keadaan baik',
                                            'Rambu tanda – tanda dan kode warna',
                                            'Tersedia Kotak P3K dan selalu di cek terkait isinya.',
                                            'Tersedia APAR, atau alat pencegah dan perlindungan dari kebakaran',
                                            'Tersedia air bersih yang cukup, dan adanya profiltank / tandon'
                                        ];
        @endphp
        @foreach($checklistItems as $index => $item)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $item }}</td>
            <td class="text-center check">{!! isset($data->checklist_items[$index]) && $data->checklist_items[$index] === 'OK' ? '✓' : '' !!}</td>
            <td class="text-center check">{!! isset($data->checklist_items[$index]) && $data->checklist_items[$index] === 'NOT OK' ? '✓' : '' !!}</td>
            @if($index === 0)
                <td rowspan="{{ count($checklistItems) }}" style="background-color: yellow;">Resiko Sedang</td>
                <td rowspan="{{ count($checklistItems) }}" class="text-center">{{ $data->keterangan ?? '-' }}</td>
            @endif
        </tr>
        @endforeach
    </table>

    <style>
        .checklist-header {
            background-color: #4472c4;
            color: white;
            text-align: center;
            font-weight: bold;
            padding: 5px;
        }
        .gray-bg {
            background-color: #f0f0f0;
        }
        .text-center {
            text-align: center;
        }
        .check {
            font-family: DejaVu Sans, sans-serif;
        }
        td {
            padding: 5px;
            border: 1px solid #000;
            vertical-align: middle;
        }
    </style>

    <!-- Rincian Bahaya & Perbaikan -->
    <table>
        <tr>
            <td width="40%" class="gray-bg">Rincian Bahaya</td>
            <td width="40%" class="gray-bg">Perbaikan Langsung</td>
            <td width="20%" class="gray-bg">Dilakukan Oleh</td>
        </tr>
        <tr>
            <td>{{ $data->risk_description ?? '-' }}</td>
            <td>{{ $data->improvement_action ?? '-' }}</td>
            <td>{{ $data->done_by ?? '-' }}</td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="signature-table">
        <tr>
            <td width="25%" style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td width="25%" style="padding: 10px;">{{ $data->inspected_by ?? '-' }}</td>
            <td width="15%" style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td width="10%" style="padding: 10px; text-align: center;">{!! $data->inspected_signature ? '✓' : '' !!}</td>
            <td width="10%" style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td width="15%" style="padding: 10px;">{{ $data->inspection_date ? date('d/m/Y', strtotime($data->inspection_date)) : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $data->inspected_by2 ?? '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px; text-align: center;">{!! $data->inspected_signature2 ? '✓' : '' !!}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->inspection_date2 ? date('d/m/Y', strtotime($data->inspection_date2)) : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Diinspeksi Oleh</td>
            <td style="padding: 10px;">{{ $data->inspected_by3 ?? '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px; text-align: center;">{!! $data->inspected_signature3 ? '✓' : '' !!}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->inspection_date3 ? date('d/m/Y', strtotime($data->inspection_date3)) : '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; background-color: #f5f5f5;">Disetujui Oleh</td>
            <td style="padding: 10px;">{{ $data->acknowledged_by ?? '-' }}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanda Tangan</td>
            <td style="padding: 10px; text-align: center;">{!! $data->acknowledged_signature ? '✓' : '' !!}</td>
            <td style="padding: 10px; background-color: #f5f5f5;">Tanggal</td>
            <td style="padding: 10px;">{{ $data->acknowledgment_date ? date('d/m/Y', strtotime($data->acknowledgment_date)) : '-' }}</td>
        </tr>
    </table>
</body>
</html>