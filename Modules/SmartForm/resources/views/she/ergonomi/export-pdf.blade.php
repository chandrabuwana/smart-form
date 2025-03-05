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
        .check { font-family: DejaVu Sans, sans-serif; text-align: center;}
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
    <div style="background-color: #fcba03; padding: 8px; font-weight: bold; text-align: center;">SURVEY ERGONOMI</div>
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
            <td colspan="4" style="background-color: #fcba03; font-weight: bold; text-align: center;">
                DAFTAR UJI ZONA PERHATIAN<br/>
                <span class="text-primary">CAUTION ZONE CHECKLIST</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 50%; text-align: left;">
                Setiap pergerakan atau posture yang dilakukan regular atau merupakan bagian dari pekerjaan, terjadi lebih dari sehari dalam seminggu dan seringkali lebih dari satu minggu dalam setahun
            </td>
            <td style="width: 20%; text-align: left;">Jika dikerjakan, beri pada kotak</td>
            <td style="width: 10%;" class="check">✓</td>
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

    <!-- Repeated Impact Section -->
    <table class="content-table">
        <tr>
            <td colspan="2" class="yellow-header">
            Dampak Berulang / <span class="text-primary">Repeated Impact</span>
            </td>
            <td colspan="2" class="yellow-header">
                Komentar Observasi / <span class="text-primary">Comments Observation</span>
            </td>
        </tr>
        @for($i = 9; $i <= 12; $i++)
        <tr>
            <td class="text-center" style="width: 5%;">
              <div>{{ $i }}</div>
              <img src="{{ public_path('img/form-she-ergonomi/postur' . $i . '.png') }}" style="max-height: 80px;">
            </td>
            <td class="image-cell text-center" style="width: 35%;">
                <div>
                    @switch($i)
                        @case(9)
                        Menggunakan tangan (telapak tangan menyiku) untuk memukul atau lutut sebagar dasar untuk memukul selama lebih dari 10 kali per jam dengan toal 2 (dua) jam sehari
                            @break
                        @case(10)
                          Mengangkat benda lebih dari 35 (tiga puluh lima) kilogram per hari atau lebih dari 20 (dua puluh) kilogram leboh dari 10 (sepuluh) kali per hari
                            @break
                        @case(11)
                          Mengangkat objek lebih dari 5 (lima) kilogram jika dilakukan dalam dua kali per menit lebih dari total 2 (dua) jam sehari
                            @break
                        @case(12)
                          Mengangkat objek lebih dari 12 (duabelas) kilogram diatas bahu, dibawah siku lebih dari 25 (dua puluh lima) kali per hari
                            @break
                    @endswitch
                </div>
            </td>
            <td style="width: 5%;" class="text-center check"> {{ $data->{"item_$i"} ? '✓' : 'X' }}</td>
            <td class="text-center">{{ $data->{"item_{$i}_observation"} ?? '-' }}</td>
        </tr>
        @endfor
    </table>

     <!--Hand-Arm Vibration Section -->
     <table class="content-table">
        <tr>
            <td colspan="2" class="yellow-header">
            Getaran Sedang s.d. Tinggi pada Tangan-Lengan / <span class="text-primary">Moderate to High Hand-Arm Vibration</span>
            </td>
            <td colspan="2" class="yellow-header">
                Komentar Observasi / <span class="text-primary">Comments Observation</span>
            </td>
        </tr>
        @for($i = 13; $i <= 14; $i++)
        <tr>
            <td class="text-center" style="width: 5%;">
              <div>{{ $i }}</div>
              <img src="{{ public_path('img/form-she-ergonomi/postur' . $i . '.png') }}" style="max-height: 80px;">
            </td>
            <td class="image-cell text-center" style="width: 35%;">
                <div>
                    @switch($i)
                        @case(13)
                          Menggunakan Impact Wrenches, vibration impact, dan peralatan tangan lainnya yang memiliki getaran tinggi lebih dari 30 (tigapuluh) menit per hari
                          @break
                        @case(14)
                          Menggunakan gerinda (gerinda tangan atau stand), atau peralatan tangan lain yang biasasnya memiliki getaran sedang lebih dari 2 (dua) jam total dalam sehari
                          @break
                    @endswitch
                </div>
            </td>
            <td style="width: 5%;" class="text-center check"> {{ $data->{"item_$i"} ? '✓' : 'X' }}</td>
            <td class="text-center">{{ $data->{"item_{$i}_observation"} ?? '-' }}</td>
        </tr>
        @endfor
    </table>

    <!-- FAKTOR RESIKO FISIK Checklist -->
    <table class="content-table text-center">
        <tr>
            <td style="width: 5%; background-color: #FFEB3B; font-weight: bold;">B</td>
            <td colspan="4" style="background-color: #fcba03; font-weight: bold; text-align: center;">
                DAFTAR UJI TINDAK LANJUT FAKTOR RESIKO FISIK<br/>
                <span class="text-primary">FOLLOW-UP PHYSICAL RISK FACTOR CHECKLIST</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="width: 70%; text-align: left;">
                Untuk setiap 'Zona Perhatian' yang teridentifikasi, temukan setiap factor fisik menggunakan checklist berikut ini. Tentukan setiap kondisi yang ada di tempat kerja.
                Jika ada, bahaya WMSD harus direduksi sampai pada level aman atau pada derajat yang memungkinkan secara teknologi dan ekonomi
            </td>
            <td style="width: 20%; text-align: left;">Jika terdapat bahaya WMSD, beri pada kotak</td>
            <td class="check">✓</td>
        </tr>
    </table>

    <!-- WMSD Risk Factors Table -->
    <table class="content-table">
        <tr style="background-color: #E3F2FD;">
            <th style="width: 15%; text-align: center;">
                Organ Tubuh<br/>
                <span class="text-primary">Body Part</span>
            </th>
            <th style="width: 35%; text-align: center;">
                Faktor Resiko Fisik<br/>
                <span class="text-primary">Physical Risk Factor</span>
            </th>
            <th style="width: 20%; text-align: center;">
                Durasi<br/>
                <span class="text-primary">Duration</span>
            </th>
            <th style="width: 20%; text-align: center;">
                Visualisasi<br/>
                <span class="text-primary">Visualization</span>
            </th>
            <th style="width: 10%; text-align: center;">WMSD ?</th>
        </tr>

        <!-- Bahu/Shoulders Section -->
        <tr>
            <td rowspan="2" style="vertical-align: middle; text-align: center;">
                Bahu<br/>
                <span class="text-primary">Shoulders</span>
            </td>
            <td style="text-align: left;">Bekerja dengan menggunakan tangan diatas bahu atau siku diatas bahu</td>
            <td style="text-align: center;">Lebih dari 4 jam total per hari</td>
            <td style="text-align: center;">
                <img src="{{ public_path('img/form-she-ergonomi/organ1.png') }}" style="height: 80px;">
            </td>
            <td class="check">{{ $data->wmsd_bahu_1 ? '✓' : 'X' }}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Gerakan mengangkat tangan berulang diatas kepala atau siku diatas bahu lebih dari sekali per menit</td>
            <td style="text-align: center;">Lebih dari 4 jam total per hari</td>
            <td style="text-align: center;">
                <img src="{{ public_path('img/form-she-ergonomi/organ2.png') }}" style="height: 80px;">
            </td>
            <td class="check">{{ $data->wmsd_bahu_2 ? '✓' : 'X' }}</td>
        </tr>

        <!-- Leher/Neck Section -->
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                Leher<br/>
                <span class="text-primary">Neck</span>
            </td>
            <td style="text-align: left;">Bekerja dengan leher menekuk 45° derajat (tanpa penopang atau kemungkinan postur bervariasi)</td>
            <td style="text-align: center;">Lebih dari 4 jam total per hari</td>
            <td style="text-align: center;">
                <img src="{{ public_path('img/form-she-ergonomi/organ3.png') }}" style="height: 80px;">
            </td>
            <td class="check">{{ $data->wmsd_leher ? '✓' : 'X' }}</td>
        </tr>

        <!-- Punggung/Back Section -->
        <tr>
            <td rowspan="2" style="vertical-align: middle; text-align: center;">
                Punggung<br/>
                <span class="text-primary">Back</span>
            </td>
            <td style="text-align: left;">Bekerja dengan punggung lebih dari 30° (tanpa penopang atau kemampuan postur bervariasi)</td>
            <td style="text-align: center;">Lebih dari 4 jam total per hari</td>
            <td style="text-align: center;">
                <img src="{{ public_path('img/form-she-ergonomi/organ4.png') }}" style="height: 80px;">
            </td>
            <td class="check">{{ $data->wmsd_punggung_1 ? '✓' : 'X' }}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Bekerja dengan punggung lebih dari 45° (tanpa penopang atau kemampuan postur bervariasi)</td>
            <td style="text-align: center;">Lebih dari 2 Jam total per hari</td>
            <td style="text-align: center;">
                <img src="{{ public_path('img/form-she-ergonomi/organ5.png') }}" style="height: 80px;">
            </td>
            <td class="check">{{ $data->wmsd_punggung_2 ? '✓' : 'X' }}</td>
        </tr>
    </table>

    <!-- FAKTOR RESIKO FISIK Checklist -->
    <table class="content-table text-center">
        <tr>
            <td style="width: 5%; background-color: #FFEB3B; font-weight: bold;">B</td>
            <td colspan="4" style="background-color: #fcba03; font-weight: bold; text-align: center;">
                DAFTAR UJI TINDAK LANJUT FAKTOR RESIKO FISIK<br/>
                <span class="text-primary">FOLLOW-UP PHYSICAL RISK FACTOR CHECKLIST</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="yellow-header">
                Postur Tubuh Janggal / <span class="text-primary">Awkward Posture</span>
            </td>
            <td colspan="2" class="yellow-header">
                Komentar Observasi / <span class="text-primary">Comments Observation</span>
            </td>
        </tr>
    </table>

    <table class="content-table">
      <tr style="background-color: #E3F2FD;">
          <th style="width: 15%; text-align: center;">
              Organ Tubuh<br/>
              <span class="text-primary">Body Part</span>
          </th>
          <th style="width: 35%; text-align: center;">
              Faktor Resiko Fisik<br/>
              <span class="text-primary">Physical Risk Factor</span>
          </th>
          <th style="width: 20%; text-align: center;">
              Durasi<br/>
              <span class="text-primary">Duration</span>
          </th>
          <th style="width: 20%; text-align: center;">
              Visualisasi<br/>
              <span class="text-primary">Visualization</span>
          </th>
          <th style="width: 10%; text-align: center;">WMSD ?</th>
      </tr>
      <!-- Lutut/Knee Section -->
      <tr>
          <td rowspan="2" style="vertical-align: middle; text-align: center;">
              Lutut<br/>
              <span class="text-primary">Knee</span>
          </td>
          <td style="text-align: center;">Berjongkok</td>
          <td style="text-align: center;">Lebih dari 2 Jam total per hari</td>
          <td style="text-align: center;">
              <img src="{{ public_path('img/form-she-ergonomi/lutut1.png') }}" style="height: 80px;">
          </td>
          <td class="check">{{ $data->wmsd_berulang_1 ? '✓' : 'X' }}</td>
      </tr>
      <tr>
            <td style="text-align: center;">Berlutut</td>
            <td style="text-align: center;">Lebih dari 4 Jam total per hari</td>
            <td style="text-align: center;">
                <img src="{{ public_path('img/form-she-ergonomi/lutut2.png') }}" style="height: 80px;">
            </td>
            <td class="check">{{ $data->wmsd_berulang_2 ? '✓' : 'X' }}</td>
        </tr>
    </table>

    <table class="content-table text-center">
      <tr>
        <td colspan="2" class="yellow-header">
          Tenaga Kuat Pada Tangan / <span class="text-primary">High End Force</span>
        </td>
        <td colspan="3" class="yellow-header">
            Komentar Observasi / <span class="text-primary">Comments Observation</span>
        </td>
      </tr>
      <tr style="background-color: #E3F2FD;">
          <th style="width: 15%; text-align: center;">
              Organ Tubuh<br/>
              <span class="text-primary">Body Part</span>
          </th>
          <th style="width: 35%; text-align: center;">
              Faktor Resiko Fisik<br/>
              <span class="text-primary">Physical Risk Factor</span>
          </th>
          <th style="width: 35%; text-align: center;">
              Kombinasi Dengan<br/>
              <span class="text-primary">Combination With</span>
          </th>
          <th style="width: 20%; text-align: center;">
              Durasi<br/>
              <span class="text-primary">Duration</span>
          </th>
          <th style="width: 20%; text-align: center;">
              Visualisasi<br/>
              <span class="text-primary">Visualization</span>
          </th>
          <th style="width: 10%; text-align: center;">WMSD ?</th>
      </tr>
      <!-- Lutut/Knee Section -->
      <tr>
          <td rowspan="3" style="vertical-align: middle; text-align: center;">
            Lengan, Pergelangan, Tangan<br/>
              <span class="text-primary">Arm, Wrists, Hand</span>
          </td>
          <td style="text-align: center;" rowspan="3">Menjepit beban tanpa bantuan dengan berat 1 (satu) Kilogram atau lebih, atau menjepit dengan tenaga 1 (satu) Kilogram per tangan</td>
          <td>Gerakan Sering Berulang</td>
          <td style="text-align: center;">Lebih dari 3 Jam total per hari</td>
          <td style="text-align: center;">
              <img src="{{ public_path('img/form-she-ergonomi/lengan1.png') }}" style="height: 80px;">
          </td>
          <td class="check">{{ $data->wmsd_tangan_kuat_1 ? '✓' : 'X' }}</td>
      </tr>
      <tr>
          <td>Pergelangan tangan menekuk sebesar 30o atau lebih, atau sebesar 45o atau kelurusan tulang hasta sebesar 30o atau lebih</td>
          <td style="text-align: center;">Lebih dari 3 Jam total per hari</td>
          <td style="text-align: center;">
              <img src="{{ public_path('img/form-she-ergonomi/lengan2.png') }}" style="height: 80px;">
          </td>
          <td class="check">{{ $data->wmsd_tangan_kuat_2 ? '✓' : 'X' }}</td>
      </tr>
      <tr>
          <td>Tidak ada factor Risiko</td>
          <td style="text-align: center;">Lebih dari 4 Jam total per hari</td>
          <td style="text-align: center;">
              <img src="{{ public_path('img/form-she-ergonomi/lengan3.png') }}" style="height: 80px;">
          </td>
          <td class="check">{{ $data->wmsd_tangan_kuat_3 ? '✓' : 'X' }}</td>
      </tr>
    </table>

    <table class="content-table text-center">
      <tr>
        <td colspan="2" class="yellow-header">
          Gerakan Sering Berulang / <span class="text-primary">High Repititive Motion</span>
        </td>
        <td colspan="3" class="yellow-header">
            Komentar Observasi / <span class="text-primary">Comments Observation</span>
        </td>
      </tr>
      <tr style="background-color: #E3F2FD;">
          <th style="width: 15%; text-align: center;">
              Organ Tubuh<br/>
              <span class="text-primary">Body Part</span>
          </th>
          <th style="width: 35%; text-align: center;">
              Faktor Resiko Fisik<br/>
              <span class="text-primary">Physical Risk Factor</span>
          </th>
          <th style="width: 35%; text-align: center;">
              Kombinasi Dengan<br/>
              <span class="text-primary">Combination With</span>
          </th>
          <th style="width: 20%; text-align: center;">
              Durasi<br/>
              <span class="text-primary">Duration</span>
          </th>
          <th style="width: 10%; text-align: center;">WMSD ?</th>
      </tr>
      <!-- Lutut/Knee Section -->
      <tr>
          <td rowspan="2" style="vertical-align: middle; text-align: center;">
            Leher, Bahu, Siku, Pergelangan, Tangan<br/>
              <span class="text-primary">Neck, Shoulder, Elbow, Wrists, Hand</span>
          </td>
          <td style="text-align: center;">Menggunakan Gerakan yang sama dengan perbedaan variasi yang kecil atau tanpa variasi dalam beberapa detik (diluar mengetik)</td>
          <td>Tidak Ada Faktor Resiko</td>
          <td style="text-align: center;">Lebih dari 6 Jam total per hari</td>
          <td class="check">{{ $data->wmsd_tangan_kuat_1 ? '✓' : 'X' }}</td>
      </tr>
      <tr>
          <td style="text-align: center;">Pergelangan tangan menekuk sebesar 30o atau lebih, atau sebesar 45o atau kelurusan tulang hasta sebesar 30o atau lebih dan kuat, tenaga berlebihan pada tangan</td>
          <td>Tidak Ada Faktor Resiko</td>
          <td style="text-align: center;">Lebih dari 6 Jam total per hari</td>
          <td class="check">{{ $data->wmsd_tangan_kuat_2 ? '✓' : 'X' }}</td>
      </tr>
    </table>

    <table class="content-table">
      <tr>
        <td colspan="2" class="yellow-header" style="text-align: left;">
          KESIMPULAN PENILAI / <span class="text-primary">RESUME OF ASSESOR</span>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: left; padding: 15px; min-height: 100px; height: 100px; vertical-align: top;">
          {{ $data->kesimpulan_penilai ?? '-' }}
        </td>
      </tr>
    </table>

    <!-- Signature Section -->
    <div style="margin-top: 20px; margin-bottom: 20px;">
        <table style="width: 75%; border-collapse: collapse; float: left;">
            <tr>
                <td colspan="2" style="border: 1px solid #000; text-align: center; padding: 5px;">
                    Disusun Oleh / <span class="text-primary">Propose By</span>
                </td>
                <td rowspan="1" style="border: 1px solid #000; text-align: center; padding: 5px;">
                    Diperiksa Oleh / <span class="text-primary">Checked By</span>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">Paramedic</td>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">Doctor</td>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">Dept Head of SHE</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; height: 80px;"></td>
                <td style="border: 1px solid #000; height: 80px;"></td>
                <td style="border: 1px solid #000; height: 80px;"></td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">{{ $data->paramedic_name ?? 'Aspianor' }}</td>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">{{ $data->doctor_name ?? 'Dr. Ananda Dessy L' }}</td>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">{{ $data->dept_head_name ?? 'Arpan Panjaitan' }}</td>
            </tr>
        </table>

        <table style="width: 23%; border-collapse: collapse; float: right;">
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">
                    Tanggal<br/>
                    <span class="text-primary">Date</span>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 5px; height: 85px;">
                    {{ isset($data->evaluation_date) ? Carbon\Carbon::parse($data->evaluation_date)->format('d F Y') : '16 Juli 2024' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center; padding: 5px;">
                    Stamp of BSS
                </td>
            </tr>
        </table>
        <div style="clear: both;"></div>
    </div>

    <div style="page-break">
      <table class="content-table" style="margin-bottom: 10px; margin-top: 30px;">
        <tr>
            <td style="background-color: #ffff00; text-align: center; font-weight: bold; padding: 5px;">C</td>
            <td style="background-color: #ffff00; text-align: center; font-weight: bold; padding: 5px;">
                LAMPIRAN PEMERIKSAAN<br/>
                <span class="text-primary">APPENDIX OF EXAMINATION</span>
            </td>
        </tr>
      </table>

      <table class="content-table" style="margin-bottom: 5px;">
        <tr style="background-color: #E3F2FD;">
            <td style="text-align: center; padding: 10px;">
                Daftar Pemeriksaan Peta Tubuh<br/>
                <span class="text-primary">Body Mapping Checklist</span>
            </td>
        </tr>
      </table>
      <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
          <td style="width: 35%; padding-right: 10px; vertical-align: top;">
              <div style="text-align: center;">
                  <img src="{{ public_path('img/form-she-ergonomi/body-mapping.png') }}" style="width: 200px;">
              </div>
          </td>
          <td style="width: 65%; vertical-align: top;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="background-color: #E3F2FD;">
                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">No<br/>Nr</th>
                    <th style="border: 1px solid #000; padding: 5px; text-align: center;">Jenis Keluhan<br/><span class="text-primary">Sign Type</span></th>
                    <th colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center;">Keluhan / <span class="text-primary">Sign</span></th>
                </tr>
                @for($i = 0; $i <= 27; $i++)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: center;">{{ $i }}</td>
                        <td style="border: 1px solid #000; padding: 5px;">
                            @switch($i)
                                @case(0) Sakit/Kaku di leher bagian atas @break
                                @case(1) Sakit/Kaku di leher bagian bawah @break
                                @case(2) Sakit di bahu kiri @break
                                @case(3) Sakit di bahu kanan @break
                                @case(4) Sakit pada lengan atas kiri @break
                                @case(5) Sakit pada punggung @break
                                @case(6) Sakit pada lengan atas kanan @break
                                @case(7) Sakit pada pinggang @break
                                @case(8) Sakit pada bokong @break
                                @case(9) Sakit pada pantat @break
                                @case(10) Sakit pada siku kiri @break
                                @case(11) Sakit pada siku kanan @break
                                @case(12) Sakit pada lengan bawah kiri @break
                                @case(13) Sakit pada lengan bawah kanan @break
                                @case(14) Sakit pada pergelangan tangan kiri @break
                                @case(15) Sakit pada pergelangan tangan kanan @break
                                @case(16) Sakit pada telapak tangan kanan @break
                                @case(17) Sakit pada telapak tangan kiri @break
                                @case(18) Sakit pada paha kiri @break
                                @case(19) Sakit pada paha kanan @break
                                @case(20) Sakit pada lutut kiri @break
                                @case(21) Sakit pada lutut kanan @break
                                @case(22) Sakit pada betis kiri @break
                                @case(23) Sakit pada betis kanan @break
                                @case(24) Sakit pada pergelangan kaki kiri @break
                                @case(25) Sakit pada pergelangan kaki kanan @break
                                @case(26) Sakit pada telapak kaki kiri @break
                                @case(27) Sakit pada telapak kaki kanan @break
                            @endswitch
                        </td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: center;" class="check">✓</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: center;"></td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: center;"></td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: center;"></td>
                    </tr>
                @endfor
            </table>

            <div style="margin-top: 10px;">
                <p style="margin-bottom: 5px;">KETERANGAN :</p>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 30px;">A</td>
                        <td>: Tidak Sakit / <span class="text-primary">Painless</span></td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>: Agak Sakit / <span class="text-primary">Rather ill</span></td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>: Sakit / <span class="text-primary">Pain</span></td>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td>: Sangat Sakit / <span class="text-primary">Very ill</span></td>
                    </tr>
                </table>
            </div>

            <div style="margin-top: 10px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 150px;">Dibuat Oleh / <span class="text-primary">Propose By</span></td>
                        <td>: {{ $data->paramedic_name ?? 'Aspianor' }}</td>
                    </tr>
                    <tr>
                        <td>Tand Tangan / <span class="text-primary">Sign</span></td>
                        <td>: <span style="font-family: 'Dancing Script', cursive;">Signature</span></td>
                    </tr>
                </table>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div class="page-number">Revisi 0</div>
</body>
</html>