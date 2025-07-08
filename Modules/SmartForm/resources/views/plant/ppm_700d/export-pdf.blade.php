<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form PPM XCMG XE700D</title>

    <style>
        body {
            font-family: Arial, "Segoe UI", sans-serif;
        }

        .container {

            border: 1px solid black;

        }

        .ttd {
            width: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 70px;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 12px;
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
            font-size: 5px;
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
        <p class="title">BSS-FRM-PLA-071 FORM PPM XCMG XE700D</p>
    </div>
    <table class="container">
        <tr>
            <th colspan="2" rowspan="4" style="border-bottom: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </th>
            <th colspan="7" style="height:10px; background-color: #3cbeca91;"></th>

        </tr>
        <tr>
            <th colspan="5" style=" text-align: center; font-weight: bold; font-size:8px;">Form</th>
            <th>No Document</th>
            <th>FRM-PLA-04-072</th>

        </tr>
        <tr>
            <th colspan="5" rowspan="2" style=" text-align: center;  font-size:8px;">
                PPM (Program Pengecekan Mesin)
            </th>

            <th>Issued</th>
            <th>11/9/2023</th>


        </tr>
        <tr>
            <th>Revisi</th>
            <th>A/00</th>
        </tr>
        <tr>
            <td colspan="3">
                UNIT
            </td>
            <td colspan="2">
                ENGINE
            </td>
            <td colspan="2">Brand
            </td>
            <td colspan="2" style="border: none">
            </td>
        </tr>
        <tr>
            <td>MODEL
            </td>
            <td>S/N
            </td>
            <td>
                C/N
            </td>
            <td>
                MODEL
            </td>
            <td>
                S/N
            </td>
            <td colspan="2" rowspan="2">
                {{ $data->brand }}
            </td>
            <td colspan="2" style="border: none"></td>
        </tr>
        <tr>
            <td>
                {{ $data->unit_model }}
            </td>
            <td>{{ $data->unit_sn }}</td>
            <td>{{ $data->unit_cn }}</td>
            <td>{{ $data->engine_model }}</td>
            <td>{{ $data->engine_sn }}</td>


            <td colspan="2" style="border: none; padding:4px;"></td>
        </tr>
        <tr>
            <td colspan="9" style="border:none;"></td>
        </tr>
        <tr>
            <td colspan="3">PT BINA SARANA SUKSES</td>
            <td colspan="2" style="border:none;"></td>
            <td colspan="2">SMR / HM</td>
            <td style="border:none;"></td>
            <td rowspan="2" style="border: none; font-weight: bold;  background-color:bisque;">XCMG XE700D</td>
        </tr>
        <tr>
            <td>Job Site : </td>
            <td colspan="2">{{ $data->job_site }}</td>
            <td colspan="2" style="border:none;"></td>
            <td>At Inspection</td>
            <td>Date</td>
            <td colspan="2" style="border:none;"></td>

        </tr>
        <tr>
            <td>Location : </td>
            <td colspan="2">{{ $data->job_location }}</td>
            <td colspan="2" style="border:none;"></td>
            <td>{{ $data->at_inspection }}</td>
            <td>{{ $data->date }}</td>
            <td colspan="2" style="border:none;"></td>
        </tr>
        <tr>
            <td style="border:none;" colspan="9"></td>
        </tr>

        <tr style=" font-weight:bold; font-size:6px;">
            <th>ITEM</th>
            <th colspan="2">CONDITION</th>
            <th>UNIT</th>
            <th>STANDARD STD / PMS</th>
            <th>ACTUAL</th>
            <th>CORRECTION MADE</th>
            <th>RESULT</th>
            <th>REMARKS</th>
        </tr>

        </thead>
        <tbody>
            <tr>
                <td colspan="9" style="text-align: left; font-weight:bold; font-size:6px;">ENGINE</td>
            </tr>
            @php
                $i = 0;
            @endphp
            @foreach ($list['ENGINE'] as $value)
                <tr>
                    @if (isset($value['item']))
                        @if ($value['item'] == 'Engine Speed')
                            <td class="align-middle" rowspan="8">
                                {!! $value['item'] !!}</td>
                        @elseif ($value['item'] == 'Lub Oil Pressure')
                            <td class="align-middle" rowspan="2">
                                {!! $value['item'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['item'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['condition']))
                        <td colspan="2" class="align-middle">{!! $value['condition'] !!}
                        </td>
                    @endif
                    @if (isset($value['unit']))
                        @if ($value['unit'] == 'Rpm')
                            <td class="align-middle" rowspan="8">
                                {!! $value['unit'] !!}</td>
                        @elseif ($value['unit'] == 'Kg/cm2')
                            <td class="align-middle" rowspan="2">
                                {!! $value['unit'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['unit'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['standard']))
                        <td class="align-middle">{!! $value['standard'] !!}
                        </td>
                    @endif
                    <td>{{ $data->eng_actual[$i] ?? '' }}</td>
                    <td>{{ $data->eng_correction_made[$i] ?? '' }}</td>
                    <td>{{ $data->eng_result[$i] ?? '' }}
                    </td>

                    <td>{{ $data->eng_remark[$i] ?? '' }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <td colspan="9" style="text-align: left;  font-weight:bold; font-size:6px;">HYDRAULIC PRESSURE</td>
            </tr>
            @php
                $j = 0;
            @endphp
            @foreach ($list['HYDRAULIC'] as $value)
                <tr>
                    @if (isset($value['item']))
                        @if ($value['item'] == 'Engine Speed')
                            <td class="align-middle" rowspan="4">
                                {!! $value['item'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['item'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['condition']))
                        @if ($value['condition'] == '1800 rpm (10th gear)')
                            <td colspan="2" class="align-middle" rowspan="4">
                                {!! $value['condition'] !!}</td>
                        @else
                            <td colspan="2" class="align-middle">
                                {!! $value['unit'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['unit']))
                        @if ($value['unit'] == 'kg/cm³')
                            <td class="align-middle" rowspan="4">
                                {!! $value['unit'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['unit'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['standard']))
                        <td class="align-middle">{!! $value['standard'] !!}
                        </td>
                    @endif
                    <td>{{ $data->hyd_actual[$j] ?? '' }}</td>
                    <td>{{ $data->hyd_correction_made[$j] ?? '' }}</td>
                    <td>{{ $data->hyd_result[$j] ?? '' }}
                    </td>


                    <td>{{ $data->hyd_remark[$j] ?? '' }}</td>
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach

            <tr>
                <td colspan="9" style="text-align: left;  font-weight:bold; font-size:6px;">WORKING SPEED</td>
            </tr>
            @php
                $k = 0;
            @endphp
            @foreach ($list['WORKING SPEED'] as $value)
                <tr>
                    @if (isset($value['item']))
                        <td class="align-middle">{!! $value['item'] !!}
                        </td>
                    @endif
                    @if (isset($value['condition']))
                        @if ($value['condition'] == '1800 rpm (10th gear)')
                            <td colspan="2" class="align-middle" rowspan="10">
                                {!! $value['condition'] !!}</td>
                        @else
                            <td colspan="2" class="align-middle">
                                {!! $value['condition'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['unit']))
                        @if ($value['unit'] == 'Sec')
                            <td class="align-middle" rowspan="10">
                                {!! $value['unit'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['unit'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['standard']))
                        @if ($value['standard'] == '28 ± 4 (3 round calculated after 1 round not calculated)')
                            <td class="align-middle" rowspan="2">
                                {!! $value['standard'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['standard'] !!}</td>
                        @endif
                    @endif
                    <td>{{ $data->wo_actual[$k] ?? '' }}</td>
                    <td>{{ $data->wo_correction_made[$k] ?? '' }}</td>
                    <td>{{ $data->wo_result[$k] ?? '' }}
                    </td>

                    <td>{{ $data->wo_remark[$k] ?? '' }}</td>
                </tr>
                @php
                    $k++;
                @endphp
            @endforeach

            <tr style=" font-weight:bold; font-size:6px;">
                <th>ITEM</th>
                <th colspan="2">CONDITION</th>
                <th>UNIT</th>
                <th>STANDARD STD / PMS</th>
                <th>ACTUAL</th>
                <th>CORRECTION MADE</th>
                <th>RESULT</th>

                <th>REMARKS</th>
            </tr>

            @php
                $l = 0;
            @endphp
            @foreach ($list['Final'] as $value)
                @if (isset($value['condition']))
                    @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                        <tr>
                            <td colspan="9" style="text-align: left; font-weight:bold; font-size:6px;">FINAL DRIVE
                            </td>
                        </tr>
                    @elseif ($value['condition'] == 'Function Check')
                        <tr>
                            <td colspan="9" style="text-align: left;  font-weight:bold; font-size:6px;">ELECTRICAL
                            </td>
                        </tr>
                    @else
                        <tr>

                        </tr>
                    @endif
                @else
                @endif

                <tr>
                    @if (isset($value['item']))
                        <td class="align-middle">{!! $value['item'] !!}
                        </td>
                    @endif
                    @if (isset($value['condition']))
                        @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                            <td colspan="2" class="align-middle" rowspan="2">
                                {!! $value['condition'] !!}</td>
                        @else
                            <td colspan="2" class="align-middle">
                                {!! $value['condition'] !!}</td>
                        @endif
                    @endif
                    <td></td>
                    @if (isset($value['standard']))
                        <td class="align-middle">{!! $value['standard'] !!}
                        </td>
                    @else
                        <td></td>
                    @endif

                    <td style="text-align: center; ">
                        {{ $data->fin_actual[$l] }}</td>
                    <td style="text-align: center; ">
                        {{ $data->fin_correction_made[$l] }}</td>
                    <td style="text-align: center;">
                        {{ $data->fin_result[$l] }}</td>

                    @if (isset($value['condition']))
                        @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                            <td rowspan="2">{{ $data->fin_remark[0] ?? '' }}</td>
                        @elseif ($value['condition'] == 'Function Check')
                            <td>{{ $data->fin_remark[1] ?? '' }}</td>
                        @else
                            <td>{{ $data->fin_remark[2] ?? '' }}</td>
                        @endif
                    @endif
                </tr>

                @php
                    $l++;
                @endphp
            @endforeach
            <tr>
                <td style="text-align: left; font-weight: bold; font-size: 6px;">Note</td>
                <td colspan="8" style="text-align: center; font-weight: bold; font-size: 6px;">

                    {{ $data->note }}

                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 10px;">
        <table style="width: 80%; border-collapse: collapse;">
            <tr>
                <td colspan="2">Checked By1</td>
                <td colspan="2">Checked By2</td>
                <td colspan="2">Validated By</td>
                <td colspan="5" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="2" style="height: 30px; border-bottom: none;"> <img
                        src="{{ public_path('img/checked.png') }}" class="ttd"></td>
                <td colspan="2" style="height: 30px; border-bottom: none;"> <img
                        src="{{ public_path('img/checked.png') }}" class="ttd"></td>
                @if ($data->status == 'approved')
                    <td colspan="2" style="height: 30px; border-bottom: none; width: 20%;"> <img
                            src="{{ public_path('img/validated.png') }}" class="ttd">
                    </td>
                @else
                    <td colspan="2" style="height: 30px; border-bottom: none; width: 20%;"></td>
                @endif

                <td colspan="5" style="border: none"></td>
            </tr>
            <tr>

                <td colspan="2"style="border-top: none;">
                    {{ $data->creator }}</td>
                <td colspan="2" style="border-top: none;">
                    {{ $data->checked_by }}
                </td>
                <td colspan="2" style="border-top: none;">
                    {{ $data->validated_by }}</td>
                <td colspan="5" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="2">Mechanic</td>
                <td colspan="2">Mechanic</td>
                <td colspan="2">Foreman</td>
                <td colspan="5" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="2"> {{ \Carbon\Carbon::parse($data->date_created)->translatedFormat('d -m Y') }}
                </td>
                <td colspan="2">{{ \Carbon\Carbon::parse($data->date_created)->translatedFormat('d -m Y') }}
                </td>
                </td>
                <td colspan="2">
                    {{ $data->date_validated ? \Carbon\Carbon::parse($data->date_validated)->translatedFormat('d - m - Y') : '-' }}
                </td>
                </td>
                <td colspan="5" style="border: none"></td>
            </tr>
        </table>
    </div>
</body>

</html>
