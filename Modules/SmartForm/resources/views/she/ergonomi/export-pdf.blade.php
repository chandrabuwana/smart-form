<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Survei Ergonomi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            margin: 0;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .header-table td {
            padding: 5px;
            border: 1px solid #000;
        }
        .logo {
            width: 100px;
        }
        .title-section {
            border: 1px solid #000;
            margin-bottom: 20px;
        }
        .yellow-header {
            background-color: #FFEB3B;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #000;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .content-table th, .content-table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-primary {
            color: #2196F3;
        }
        .page-number {
            text-align: right;
            font-size: 10px;
            margin-top: 20px;
        }
        .checklist-section {
            background-color: #FFEB3B;
            padding: 5px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .image-cell {
            width: 100px;
            vertical-align: top;
            text-align: center;
        }
        .image-cell img {
            max-width: 100%;
            height: auto;
        }
        .check { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="15%" style="border-right: 1px solid #000;">
                <img src="{{ public_path('img/logo-ct-dark.png') }}" class="logo">
            </td>
            <td width="55%" style="text-align: center;">
                <div style="font-size: 14px; font-weight: bold;">BSS SHE Management System</div>
                <div style="font-size: 12px;">SURVEI EGONOMI / ERGONOMI SURVEY</div>
            </td>
            <td width="30%" style="font-size: 10px;">
                <div style="border-bottom: 1px solid #000; padding: 2px;">No Dok : BSS-FRM-SHE-016</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Revisi : 00</div>
                <div style="border-bottom: 1px solid #000; padding: 2px;">Tanggal : 23 November 2021</div>
                <div style="padding: 2px;">Halaman : 1 dari 5</div>
            </td>
        </tr>
    </table>

    <!-- Survey Info -->
    <div class="yellow-header">SURVEY ERGONOMI</div>
    <table class="content-table">
        <tr>
            <th>Posisi yang dievaluasi<br/><span class="text-primary">Job Position Evaluation</span></th>
            <th>Tanggal<br/><span class="text-primary">Date</span></th>
            <th>Jumlah Pekerja pada pekerjaan ini<br/><span class="text-primary">Total of Employee in These Job</span></th>
            <th>Nama Karyawan<br/><span class="text-primary">Employee Name</span></th>
            <th>Nama Peninjau<br/><span class="text-primary">Reviewer Name</span></th>
        </tr>
        <tr class="text-center">
            <td>{{ $data->job_position ?? '-' }}</td>
            <td>{{ isset($data->evaluation_date) ? Carbon\Carbon::parse($data->evaluation_date)->format('d F Y') : '-' }}</td>
            <td>{{ $data->total_employee ?? '-' }}</td>
            <td>{{ $data->employee_name ?? '-' }}<br/>{{ $data->employee_id ?? '-' }}</td>
            <td>{{ $data->reviewer_name ?? '-' }}<br/>{{ $data->reviewer_id ?? '-' }}</td>
        </tr>
    </table>

    <!-- Caution Zone Checklist -->
    <table class="content-table text-center">
        <tr>
            <td style="width: 5%; background-color: #FFEB3B; font-weight: bold;">A</td>
            <td colspan="4" style="background-color: #FFEB3B; font-weight: bold; text-align: left;">
                DAFTAR UJI ZONA PERHATIAN<br/>
                <span class="text-primary">CAUTION ZONE CHECKLIST</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 50%; text-align: left;">
                Setiap pergerakan atau posture yang dilakukan regular atau merupakan bagian dari pekerjaan, terjadi lebih dari sehari dalam seminggu dan seringkali lebih dari satu minggu dalam setahun
            </td>
            <td style="width: 20%; text-align: left;">Jika dikerjakan, beri pada kotak</td>
            <td style="width: 10%;" class="check">
                @if($data->item_1 || $data->item_2 || $data->item_3 || $data->item_4)
                    ✓
                @endif
            </td>
            <td style="width: 20%; text-align: left;">Gunakan 'tool' ini untuk satu posisi</td>
        </tr>
    </table>

    <!-- Awkward Posture Section -->
    <table class="content-table">
        <tr>
            <td colspan="2" class="yellow-header">
                Postur Tubuh Janggal / <span class="text-primary">Awkward Posture</span>
            </td>
            <td colspan="2" class="yellow-header">
                Komentar Observasi / <span class="text-primary">Comments Observation</span>
            </td>
        </tr>
        @for($i = 1; $i <= 4; $i++)
        <tr>
            <td class="text-center" style="width: 5%;">
              <div>{{ $i }}</div>
              <img src="{{ public_path('img/form-she-ergonomi/postur' . $i . '.png') }}" style="max-height: 80px;">
            </td>
            <td class="image-cell text-center" style="width: 35%;">
                <div>
                    @switch($i)
                        @case(1)
                            Bekerja dengan tangan diatas kepala, atau siku diatas bahu lebih dari 2 (dua) jam per hari
                            @break
                        @case(2)
                            Bekerja dengan leher atau punggung membungkuk lebih dari 30 derajat (tanpa bantuan atau kemampuan melakukan postur lain) lebih dari 2 (dua) jam perhari
                            @break
                        @case(3)
                            Berjongkok lebih dari 2 (dua) jam per hari
                            @break
                        @case(4)
                            Berlutut lebih dari 2 (dua) jam per hari
                            @break
                    @endswitch
                </div>
            </td>
            <td style="width: 5%;" class="text-center check"> {{ $data->{"item_$i"} ? '✓' : 'X' }}</td>
            <td class="text-center">{{ $data->{"item_{$i}_observation"} ?? '-' }}</td>
        </tr>
        @endfor
    </table>

    <!-- High End Force Section -->
    <table class="content-table">
        <tr>
            <td colspan="2" class="yellow-header">
                Tenaga Kuat dengan Tangan / <span class="text-primary">High End Force</span>
            </td>
            <td colspan="2" class="yellow-header">
                Komentar Observasi / <span class="text-primary">Comments Observation</span>
            </td>
        </tr>
        @for($i = 5; $i <= 8; $i++)
        <tr>
            <td class="text-center" style="width: 5%;">
              <div>{{ $i }}</div>
              <img src="{{ public_path('img/form-she-ergonomi/postur' . $i . '.png') }}" style="max-height: 80px;">
            </td>
            <td class="image-cell text-center" style="width: 35%;">
                <div>
                    @switch($i)
                        @case(5)
                            Menjepit objek tanpa bantuan dengan berat 1 (satu) kilogram pertangan, atau menjepit dengan tenaga 2 (dua) kilogram lebih dari 2 (dua) jam sehari (bandingkan dengan menjepit setengah rim kertas)
                            @break
                        @case(6)
                            Mencengkram objek tanpa bantuan dengan beban 5 kilogram, atau lebih per tangan atau menjepit dengan tenaga sebesar 5 kilogram per tangan, lebih dari 2 (dua) jam sehari
                            @break
                        @case(7)
                            Mengulang pergerakan yang sama pada leher, bahu, siku, pergelangan tangan, atau tangan (diluar kegiatan jari) tanpa istirahat atau sedikit variasi beberapa detik, lebih dari 2 (dua) jam total per hari
                            @break
                        @case(8)
                            Mengerjakan pengetikan secara intensif lebih dari 4 (empat) jam dalam sehari
                            @break
                    @endswitch
                </div>
            </td>
            <td style="width: 5%;" class="text-center check"> {{ $data->{"item_$i"} ? '✓' : 'X' }}</td>
            <td class="text-center">{{ $data->{"item_{$i}_observation"} ?? '-' }}</td>
        </tr>
        @endfor
    </table>

    <div class="page-number">Revisi 0</div>
</body>
</html>