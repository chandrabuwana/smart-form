<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Kuisioner</title>
    <style>
        body {
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: separate;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        .logo {
            text-align: center;
            vertical-align: middle;
            background-color: #ffffff;
        }

        .title {
            background-color: #00e6e6;
            color: white;
            text-align: center;
            vertical-align: middle;
        }

        .form {
            background-color: white;
            text-align: center;
            vertical-align: middle;
        }

        .form-top {
            text-align: left;
            vertical-align: top;
            padding-bottom: 20px;
        }

        .form-soal {
            text-align: center;
            vertical-align: top;
        }

        .doc-details,
        .doc-details th,
        .doc-details td {
            text-align: left;
            vertical-align: middle;
        }

        .check {
            text-align: center;
            vertical-align: middle;
        }

        .hide-border,
        .hide-border th,
        .hide-border td {
            border: none;
            padding-bottom: 20px;
        }

        .header-table-color {
            background-color: #00cccc;
            border-color: #004d4d;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>

    <!-- Header -->
    <table>
        <tr>
            <td class="logo" rowspan="4" colspan="1"><img
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/logo.png'))) }}"
                    width="150" alt="Logo"></td>
            <td class="title" rowspan="1" colspan="6">INTEGRATED BSS EXCELLENT SYSTEM</td>
        </tr>
        <tr>
            <td class="form" rowspan="3" colspan="4" style="width:10px">FORM</td>
            <td style="width:10vw">NOMOR DOKUMEN</td>
            <td style="width:20vw">BSS-FRM-ICGS-005</td>
        </tr>
        <tr class="doc-details">
            <td>REVISI</td>
            <td>1</td>
        </tr>
        <tr class="doc-details">
            <td>TANGGAL</td>
            <td><?php
            // Contoh tanggal dari database
            $from_date = $date_now; // Format yyyy-mm-dd
            
            // Ubah format tanggal
            $date = new DateTime($from_date);
            
            // Array bulan dalam bahasa Indonesia
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];
            
            // Ganti nama bulan dalam bahasa Inggris menjadi bahasa Indonesia
            $bulan_eng = $date->format('F');
            $bulan_indo = $bulan[$bulan_eng];
            $formatted_date = $date->format('d') . ' ' . $bulan_indo . ' ' . $date->format('Y');
            
            echo $formatted_date;
            ?></td>
        </tr>
        <tr>
            <td class="check" colspan="5" rowspan="1">INDUKSI KARYAWAN</td>
            <td class="doc-details">HALAMAN</td>
            <td class="doc-details">1 of 2</td>
        </tr>
        <tr></tr>
    </table>

    <br><br>
    <!-- Penerima Induksi -->
    <table>
        <tr>
            <td class="header-table-color" rowan="1" colspan="3">PENERIMA INDUKSI</td>
        </tr>
        <tr></tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:100">Nama</td>
            <td class="form hide-border" style="width:2">:</td>
            <td class="form hide-border" style="width:83vw">{{ $karyawan->Nama }}
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NIK</td>
            <td class="form hide-border">:</td>
            <td class="form hide-border" style="width:83vw">{{ $karyawan->nik }}
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Jabatan</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">{{ $karyawan->Jabatan }}
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Devisi / Dept</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">{{ $karyawan->Department }}
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Nama Instansi </td>
            <td class="form hide-border" style="width:1vw">:</td>
            <td class="form hide-border" style="width:17vw">{{ $karyawan->Instansi }}
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Jenis Induksi</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">{{ $karyawan->jenis_karyawan }}
            </td>
        </tr>
    </table>

    <br>

    <!-- ICGS -->
    <table>
        <tr>
            <td class="header-table-color" colspan="7">INDUKSI ICGS</td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Nama Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">ABIYOGA HENDRA
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NIK Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">1020125
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Tanggal Induksi</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">12 OKtober 1992
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw" colspan="3">Daftar materi yang telah selesai disampaikan
            </td>
        </tr>
        <?php
        $counter = 1;
        foreach ($detail as $key => $d) {
            if ($d->QuestionaireGroup == 'ICGS') {
                // dd($d);
                echo '<tr class="doc-details">
                                                    <td class="form hide-border" style="width:15vw" colspan="7">' .
                    $counter .
                    ' - ' .
                    $d->Questionaire .
                    '
                                                    </td>
                                                </tr>';
                $counter += 1;
            }
        }
        ?>

    </table>

    <br><br>

    <!-- SHE -->
    <table>
        <tr>
            <td class="header-table-color" colspan="7">INDUKSI SHE</td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Nama Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">ABIYOGA HENDRA
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NIK Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">1020125
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Tanggal Induksi</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">12 OKtober 1992
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw" colspan="3">Daftar materi yang telah selesai
                disampaikan
            </td>
        </tr>
        <?php
        
        $counter = 1;
        foreach ($detail as $key => $d) {
            if ($d->QuestionaireGroup == 'SHE') {
                // dd($d);
                echo '<tr class="doc-details">
                                                    <td class="form hide-border" style="width:15vw" colspan="7">' .
                    $counter .
                    ' - ' .
                    $d->Questionaire .
                    '
                                        </td>
                                    </tr>';
                $counter += 1;
            }
        }
        ?>
    </table>



    <br>
    <br>

    {{-- OD --}}
    <table>
        <tr>
            <td class="header-table-color" colspan="7">INDUKSI OD</td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Nama Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">ABIYOGA HENDRA
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NIK Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">1020125
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Tanggal Induksi</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">12 OKtober 1992
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw" colspan="3">Daftar materi yang telah selesai
                disampaikan
            </td>
        </tr>
        <?php
        $counter = 1;
        foreach ($detail as $key => $d) {
            if ($d->QuestionaireGroup == 'OD') {
                // dd($d);
                echo '<tr class="doc-details">
                                            <td class="form hide-border" style="width:15vw" colspan="7">' .
                    $counter .
                    ' - ' .
                    $d->Questionaire .
                    '
                                </td>
                            </tr>';
                $counter += 1;
            }
        }
        ?>
        ?>

    </table>
    <br>
    <br>

    {{-- DEPT Terkait --}}
    <table>
        <tr>
            <td class="header-table-color" colspan="7">INDUKSI DEPARTMENT TERKAIT</td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Nama Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">ABIYOGA HENDRA
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NIK Mentor</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">1020125
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">Tanggal Induksi</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">12 OKtober 1992
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw" colspan="3">Daftar materi yang telah selesai
                disampaikan
            </td>
        </tr>
        <?php
        
        $counter = 1;
        foreach ($detail as $key => $d) {
            if ($d->QuestionaireGroup == 'DEPT') {
                // dd($d);
                echo '<tr class="doc-details">
                        <td class="form hide-border" style="width:15vw" colspan="7">' .
                    $counter .
                    ' - ' .
                    $d->Questionaire .
                    '
                    </td>
                    </tr>';
                $counter += 1;
            }
        }
        ?>



    </table>
    <br>
    <br>

    <div class="row" style="padding: 20px">
        <table style="border:none">
            <tr class="hide-border">
                <td style="width: 70vw">
                    <table class="densoTableHeader" style=" align-content: center; border : none">
                        <tbody class="hide-border">
                            <tr class="hide-border">
                                <td style="width: 100px" class="hide-border">
                                    <div class="row">
                                        <div class="col center">
                                            ......................................................
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col center">Dibuat Oleh,</div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col center">
                                            (Asset Procurement Officer)
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <div class="row">
                        <div class="col center">Disetujui Oleh,</div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col center">
                            (Kasi Asset Procurement)
                        </div>
                    </div>
                </td>
            </tr>
        </table>


    </div>

    <script></script>
</body>

</html>
