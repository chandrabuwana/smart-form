<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Kuisioner</title>
    <style>
        body {
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            padding: 0px;
            margin: 0px;
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
            margin : 5px;
            border: none;
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
            <td>{{ $karyawan->created_at }}</td>
        </tr>
        <tr>
            <td class="check" colspan="5" rowspan="1">INDUKSI KARYAWAN</td>
            <td class="doc-details">HALAMAN</td>
            <td class="doc-details">1 of 2</td>
        </tr>
        <tr>
            <td colspan="7">
                <br>
                <h2 style="margin : 10px !important">PENERIMA INDUKSI</h2>
                <div>
                    <table style="border : none !important; margin : 10px">
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
                </div>
                <table style="margin : 0 auto; width: 90% !important">
                    <tr>
                        <td class="header-table-color" colspan="4">INDUKSI ICGS</td>
                    </tr>

                    @php
                        $counter = 1;
                    @endphp

                    @foreach ($detail as $d)
                        @if ($d->QuestionaireGroup == 'ICGS' && $counter == 1)
                            <tr class="doc-details">
                                <td class="hide-border" style="width:1vw">Nama Mentor &emsp;&emsp;: {{ $d->Nama }}  </td>
                                <td class="hide-border" style="width:1px"></td>
                                <td class="hide-border" style="width:3vw"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">NIK Mentor &emsp;&emsp; &nbsp;: {{ $d->mentor }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Tanggal Induksi&emsp; &nbsp;: {{ $d->created_at }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Daftar materi yang telah selesai disampaikan
                                </td>
                            </tr>
                        @endif

                        @if ($d->QuestionaireGroup == 'ICGS')
                            <tr class="doc-details">
                                <td class="hide-border">{{ $counter }} -
                                    {{ $d->Questionaire }}</td>
                            </tr>
                            @php
                                $counter += 1;
                            @endphp
                        @endif
                    @endforeach

                </table>
                <br>
                <table style="margin : 0 auto; width: 90% !important">
                    <tr>
                        <td class="header-table-color" colspan="4">INDUKSI SHE</td>
                    </tr>

                    @php
                        $counter = 1;
                    @endphp

                    @foreach ($detail as $d)
                        @if ($d->QuestionaireGroup == 'SHE' && $counter == 1)
                            <tr class="doc-details">
                                <td class="hide-border" style="width:1vw">Nama Mentor &emsp;&emsp;: {{ $d->Nama }}  </td>
                                <td class="hide-border" style="width:1px"></td>
                                <td class="hide-border" style="width:3vw"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">NIK Mentor &emsp;&emsp;: {{ $d->mentor }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Tanggal Induksi &emsp;&emsp;: {{ $d->created_at }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Daftar materi yang telah selesai disampaikan
                                </td>
                            </tr>
                        @endif

                        @if ($d->QuestionaireGroup == 'SHE')
                            <tr class="doc-details">
                                <td class="hide-border">{{ $counter }} -
                                    {{ $d->Questionaire }}</td>
                            </tr>
                            @php
                                $counter += 1;
                            @endphp
                        @endif
                    @endforeach

                </table>

                <br>

                <table style="margin : 0 auto; width: 90% !important">
                    <tr>
                        <td class="header-table-color" colspan="4">INDUKSI OD</td>
                    </tr>

                    @php
                        $counter = 1;
                    @endphp

                    @foreach ($detail as $d)
                        @if ($d->QuestionaireGroup == 'OD' && $counter == 1)
                            <tr class="doc-details">
                                <td class="hide-border" style="width:1vw">Nama Mentor &emsp;&emsp;: {{ $d->Nama }}  </td>
                                <td class="hide-border" style="width:1px"></td>
                                <td class="hide-border" style="width:3vw"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">NIK Mentorv &emsp;&emsp; &nbsp;: {{ $d->mentor }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Tanggal Induksi &emsp;&emsp;: {{ $d->created_at }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Daftar materi yang telah selesai disampaikan
                                </td>
                            </tr>
                        @endif

                        @if ($d->QuestionaireGroup == 'OD')
                            <tr class="doc-details">
                                <td class="hide-border">{{ $counter }} -
                                    {{ $d->Questionaire }}</td>
                            </tr>
                            @php
                                $counter += 1;
                            @endphp
                        @endif
                    @endforeach

                </table>

                <br>

                <table style="margin : 0 auto; width: 90% !important">
                    <tr>
                        <td class="header-table-color" colspan="4">INDUKSI DEPT. Terkait</td>
                    </tr>

                    @php
                        $counter = 1;
                    @endphp

                    @foreach ($detail as $d)
                        @if ($d->QuestionaireGroup == 'DEPT' && $counter == 1)
                            <tr class="doc-details">
                                <td class="hide-border" style="width:1vw">Nama Mentor  &emsp;&emsp;: {{ $d->Nama }}  </td>
                                <td class="hide-border" style="width:1px"></td>
                                <td class="hide-border" style="width:3vw"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">NIK Mentor  &emsp;&emsp;: {{ $d->mentor }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Tanggal Induksi &emsp;&emsp;: {{ $d->created_at }}  </td>
                                <td class="hide-border"></td>
                                <td class="hide-border"></td>
                            </tr>
                            <tr class="doc-details">
                                <td class="hide-border">Daftar materi yang telah selesai disampaikan
                                </td>
                            </tr>
                        @endif

                        @if ($d->QuestionaireGroup == 'DEPT')
                            <tr class="doc-details">
                                <td class="hide-border">{{ $counter }} -
                                    {{ $d->Questionaire }}</td>
                            </tr>
                            @php
                                $counter += 1;
                            @endphp
                        @endif
                    @endforeach

                </table>

                <br>

            </td>
        </tr>
      
    </table>

    <br>
    <br>

    <script></script>
</body>

</html>
