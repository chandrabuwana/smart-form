<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Form P2H Welding</title>


    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            padding: 3px;
        }

        .container {

            border: 1px solid black;

        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 70px;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            font-size: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-left {
            text-align: left;
        }

        .top {
            text-align: center;
            margin-bottom: 5px;
        }

        .detail {
            font-weight: bold;
            margin-bottom: -5px;
        }

        .bottom {
            margin-top: 20px;
            font-size: 10px;

        }

        .bottom li {
            list-style-type: none;
            margin-bottom: 5px;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="top">
        <p class="title">BSS-FRM-PLA-040 P2H WELDING (STANDARD)</p>
    </div>

    <div class="detail">
        <p class="title">Detail Pengisian</p>
    </div>
    <table class="container">
        <tr>
            <td colspan="3" rowspan="4" style="border-bottom: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </td>
            <td colspan="31" style=" background-color: #3cbeca91;"></td>

        </tr>
        <tr>
            <td colspan="29">Form</td>
            <td>No. Dok</td>
            <td>BSS-FRM-PLA-045</td>
        </tr>
        <tr>
            <td colspan="29" rowspan="2"><b><h3>INSPEKSI HARIAN TABUNG GAS <br>& PERLENGKAPAN</h3></b></td>
            <td>Issued</td>
            <td>1/1/2017</td>
        </tr>
        <tr>
            <td>Revisi</td>
            <td>A/00</td>
        </tr>
        <tr>
            <td colspan="34">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">BULAN</td>
            <td style="text-align: left" colspan="29">{{ \Carbon\Carbon::createFromFormat('Y-m', $record->month)->translatedFormat('F') }}</td>
        </tr>
        <tr>
            <td colspan="5">LOKASI</td>
            <td style="text-align: left" colspan="29">{{ $record->location }}</td>
        </tr>
                <tr>
            <td colspan="34">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">Instalasi Tetap</td>
            <td> @if($record->jenis_instalasi == 'Instalasi Tetap') ✓ @endif</td>
            <td colspan="8">Troli Portabel</td>
            <td>@if($record->jenis_instalasi == 'Troli Portable') ✓ @endif</td>
            <td colspan="20"></td>
        </tr>
        <tr>
            <td colspan="34">&nbsp;</td>
        </tr>
        <tr>
            <td rowspan="2">NO</td>
            <th rowspan="2" class="text-center" style="width: 120px">ITEM YANG DI PERIKSA</th>
            <th colspan="31">TANGGAL</th>
            <th rowspan="2">CATATAN & LAPORAN SETIAP ADA KERUSAKAN</th>
        </tr>
        @for ($i = 1; $i <= 31; $i++)
            <th style="width: 10px">{{ $i }}</th>
        @endfor

        </thead>


        <tbody>
            @php
                // Values are already decoded in the controller, no need to decode again
                $question1 = $record->question1 ?? [];
                $question2 = $record->question2 ?? [];
                $question3 = $record->question3 ?? [];
                $question4 = $record->question4 ?? [];
                $question5 = $record->question5 ?? [];
                $question6 = $record->question6 ?? [];
                $question7 = $record->question7 ?? [];
                $question8 = $record->question8 ?? [];
                $question9 = $record->question9 ?? [];
                $question10 = $record->question10 ?? [];
                $question11 = $record->question11 ?? [];
                $question12 = $record->question12 ?? [];
                $question13 = $record->question13 ?? [];
                $question14 = $record->question14 ?? [];
                $question15 = $record->question15 ?? [];
                $question16 = $record->question16 ?? [];
                $question17 = $record->question17 ?? [];
                $question18 = $record->question18 ?? [];
                $question19 = $record->question19 ?? [];
                $question20 = $record->question20 ?? [];
            @endphp
            <tr>
                <td colspan="34" style="font-weight: bold;">A. CUTTING BLANDER DARI OKSIGEN & ACTILIN</td>
            </tr>
            <tr>
                <td>1</td>
                <td class="text-left">Ulir regulator tabung dalam kondisi baik</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>
                        {!! isset($question1[$i - 1]) && $question1[$i - 1] === '1' ? '✓' : '' !!}
                    </td>
                @endfor
                <td rowspan="13">
                    {{ $record->catatan1 }}
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">Regulator berfungsi baik</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>
                        {!! isset($question1[$i - 1]) && $question1[$i - 1] === '1' ? '✓' : '' !!}
                    </td>
                @endfor
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">Semua flash back arestor berfungsi</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question3[$i - 1]) && $question3[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>4</td>
                <td class="text-left">Tabung & perlengkapan bersih dan tidak</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question4[$i - 1]) && $question4[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>5</td>
                <td class="text-left">Tabung di rantai secara individual</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question5[$i - 1]) && $question5[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>6</td>
                <td class="text-left">Clamp hose standart (bukan kawat, selotip atau klem silang)</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question6[$i - 1]) && $question6[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>7</td>
                <td class="text-left">Tabung Posisi tegak pada kerangka / rak / troli</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question7[$i - 1]) && $question7[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>8</td>
                <td class="text-left">Troli mempunyai pemadam api sendiri</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question8[$i - 1]) && $question8[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>9</td>
                <td class="text-left">Tabung / perlengkapan tidak korosi</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question9[$i - 1]) && $question9[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>10</td>
                <td class="text-left">Tabung / selang / hose tidak bocor</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question10[$i - 1]) && $question10[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>11</td>
                <td class="text-left">Semua menggunakan flash back arrestor</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question11[$i - 1]) && $question11[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>12</td>
                <td class="text-left">Pemantik tersedia dan baik</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question12[$i - 1]) && $question12[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>13</td>
                <td class="text-left">Semua torch dalam kondisi balk</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question13[$i - 1]) && $question13[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td colspan="34" style="font-weight: bold;">B. MESIN LAS & ALAT PELINDUNG DIRI</td>
            </tr>
            <tr>
                <td>14</td>
                <td class="text-left">Kabel/scone positif (+) & negatif (-)</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question14[$i - 1]) && $question14[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
                <td rowspan="7">
                    {{ $record->catatan2 }}
                </td>
            </tr>
            <tr>
                <td>15</td>
                <td class="text-left">Periksa isolasi semua kabel</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question15[$i - 1]) && $question15[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>16</td>
                <td class="text-left">Cek kabel ground & holder</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question16[$i - 1]) && $question16[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>17</td>
                <td class="text-left">Cek olie engine</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question17[$i - 1]) && $question17[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>18</td>
                <td class="text-left">Cek air radiator</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question18[$i - 1]) && $question18[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>19</td>
                <td class="text-left">Cek air battery</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question19[$i - 1]) && $question19[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>20</td>
                <td class="text-left">Cek kondisi Alat Pelindung</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td>{!! isset($question20[$i - 1]) && $question20[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td colspan="34">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">Nama Pemeriksa/Pengecek</td>
                <td colspan="32" style="text-align: left">{{ $record->pemeriksa }}</td>
            </tr>
            <tr>
                <td colspan="2">Jabatan</td>
                <td colspan="32" style="text-align: left">{{ $record->jabatan }}</td>
            </tr>
            <tr>
                <td colspan="2">NRP</td>
                <td colspan="32" style="text-align: left">{{ $record->nrp }}</td>
            </tr>
            <tr>
                <td colspan="2">Nama Atasan Langsung</td>
                <td colspan="32" style="text-align: left">{{ $record->atasan }}</td>
            </tr>
            <tr>
                <td colspan="34">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
