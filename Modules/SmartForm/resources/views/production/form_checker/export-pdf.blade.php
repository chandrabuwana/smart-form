<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Lembar Laporan Harian Checker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            border: 1px solid black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .border-bottom {
            border: none;
        }

        .border-top {
            border-top: none;
        }

        th,
        td {
            border: 1px solid black;
            font-size: 8px;
            padding: 4px;
            text-align: left;
        }

        .logo-container {
            justify-content: center;
            align-items: center;
        }

        .logo {
            width: 50px;
            height: 50px;

        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th rowspan="3" class="text-center" style="border: none;">
                        <img src="{{ public_path('img/logo.png') }}" class="logo" />
                    </th>
                    <th colspan="2">Tanggal:</th>
                    <th colspan="8">{{ $record->tanggal }}</th>
                    <th colspan="4">Shift:</th>
                    <th colspan="8">{{ $record->shift }}</th>
                    <th style="border: none;"></th>
                    <th colspan="19" rowspan="3" class="title">
                        LEMBAR LAPORAN HARIAN CHECKER
                    </th>
                </tr>
                <tr>
                    <th colspan="2">Alat Muat</th>
                    <th colspan="5">PC:{{ $record->alat_muat[0] }}</th>
                    <th colspan="3">X: {{ $record->alat_muat[1] }}</th>
                    <th colspan="4">Nama Operator Leader</th>
                    <th colspan="8">{{ $record->operator_leader }}</th>
                    <th style="border: none;"></th>

                </tr>
                <tr>
                    <th colspan="2">Start Loading</td>
                    <th colspan="3">{{ $record->start_loading }}</th>
                    <th colspan="2">Stop Loading</th>
                    <th colspan="3">{{ $record->stop_loading }}</th>
                    <th colspan="4">PIC Area</th>
                    <th colspan="8">
                        {{ optional(collect($approvalList)->firstWhere('nik', $record->pic_area))->nama ?? '' }}</th>
                    <th style="border: none;"></th>
                </tr>
                <tr>
                    <th style="border: none;"></th>
                    <th style="border: none;" colspan="42"></th>
                </tr>
                <tr>
                    <th class="center">Alat Angkut</th>
                    @for ($i = 0; $i < 6; $i++)
                        <th class="center">CN</th>
                        @if (isset($record->alat_angkut[$i]))
                            <th colspan="4">{{ $record->alat_angkut[$i] }}</th>
                        @else
                            <th colspan="4"></th>
                        @endif
                        <th class="center" style="text-align: center; font-family: DejaVu Sans, sans-serif;">Σ</th>
                        <th rowspan="2" class="center">Material</th>
                    @endfor

                </tr>
                <tr>
                    <th class="center">Nama Operator</th>
                    @for ($i = 0; $i < 6; $i++)
                        @if (isset($record->nama_operator[$i]))
                            <th colspan="5" class="center">
                                {{ optional(collect($approvalList)->firstWhere('nik', $record->nama_operator[$i]))->nama ?? '' }}
                            </th>
                        @else
                            <th colspan="5"></th>
                        @endif
                        <th>Rit</th>
                    @endfor


                </tr>

            </thead>
            <tbody>
                @php

                    $timelabel = $record->shift == 'DS' ? $dataDS : $dataNS;
                    $counts = 1;
                @endphp
                @foreach ($timelabel as $id => $alat)
                    <tr>
                        <td>{{ $alat }}</td>
                        @for ($i = 0; $i < 6; $i++)
                            @for ($j = 0; $j < 5; $j++)
                                @if (isset($time_details[$counts][$i][$j]))
                                    <td>{{ $time_details[$counts][$i][$j] }}</td>
                                @else
                                    <td></td>
                                @endif
                            @endfor
                            @if (isset($nonNullCounts[$counts][$i]))
                                <td>{{ $nonNullCounts[$counts][$i] }}</td>
                            @else
                                <td></td>
                            @endif

                            @if (isset($record->material[$i][$id]))
                                <td>{{ $record->material[$i][$id] }}</td>
                            @else
                                <td></td>
                            @endif
                        @endfor
                        @php
                            $counts++;
                        @endphp

                    </tr>
                @endforeach




                <tr>
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">∑ Ritasi / ∑ BCM,ton</td>
                    <td colspan="42"></td>
                </tr>
                <tr>
                    <td>Jumlah Total</td>
                    <td colspan="6">RITASI</td>
                    <td class="center">{{ $sumRitasi }}</td>
                    <td colspan="35"> </td>
                </tr>
                <tr>
                    <th colspan="43" style="border: none;">
                        Identifikasi dan Tindakan yang Dilakukan
                    </th>
                </tr>
                <tr>
                    <th colspan="12" rowspan="2" class="center">Kendala / Lokasi</th>
                    <th colspan="2" class="center">Waktu</th>
                    <th colspan="13" rowspan="2" class="center">Keterangan</th>
                    <th style="border: none;" colspan="2"></th>
                    <td>Loading Point (Block)</td>
                    <td class="center" colspan="6">{{ $record->loading_point }}</td>
                    <td colspan="7" style="border: none;"></td>
                </tr>
                <tr>
                    <td>Mulai</td>
                    <td>akhir</td>
                    <td style="border: none;" colspan="2">
                    </td>
                    <td>Jarak</td>
                    <td class="center" colspan="6">{{ $record->jarak }}</td>
                    <td colspan="7" style="border: none;"></td>
                </tr>
                @for ($i = 0; $i < 9; $i++)
                    <tr>
                        @if (isset($record->kendala[$i]))
                            <td colspan="12" class="center">{{ $record->kendala[$i] }}</td>
                            <td class="center">{{ $record->waktu_mulai[$i] }}</td>
                            <td class="center">{{ $record->waktu_selesai[$i] }}</td>
                            <td colspan="13" class="center">{{ $record->keterangan[$i] }}</td>
                            <td style="border: none;" colspan="2"></td>
                        @else
                            <td colspan="12" class="center"></td>
                            <td class="center"></td>
                            <td class="center"></td>
                            <td colspan="13" class="center"></td>
                            <td style="border: none;" colspan="2"></td>
                        @endif

                        @if ($i == 0)
                            <td>Disposal</td>
                            <td class="center" colspan="6">{{ $record->disposal }}</td>
                        @elseif ($i == 1)
                            <td style="border: none;">Dibuat Oleh</td>
                            <td style="border: none;" class="center" colspan="6">Diperiksa Oleh</td>
                        @elseif ($i == 7)
                            <td style="border: none;"> (
                                {{ optional(collect($approvalList)->firstWhere('nik', $record->checker))->nama ?? '' }})
                            </td>
                            <td style="border: none;" class="center" colspan="6">
                                (
                                {{ optional(collect($approvalList)->firstWhere('nik', $record->pengawas))->nama ?? '' }})
                            </td>
                        @elseif ($i == 8)
                            <td style="border: none;">Checker</td>
                            <td style="border: none;" class="center" colspan="6">Pengawas</td>
                        @else
                            <td style="border: none;"></td>
                            <td style="border: none;" colspan="6"></td>
                        @endif

                        <td colspan="7" style="border: none;"></td>
                    </tr>
                @endfor



            </tbody>
        </table>
    </div>
</body>

</html>
