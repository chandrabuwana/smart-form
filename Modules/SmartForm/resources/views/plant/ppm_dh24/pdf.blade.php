<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form PPM SHANTUI D24 Series</title>

    <style>
        body {
            font-family: Arial, "Segoe UI", sans-serif;
            margin
        }

        .container {

            border: 1px solid black;

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
        <p class="title">BSS-FRM-PLA-075 FORM PPM SHANTUI D24 SERIES</p>
    </div>
    <table class="container border-collapse: collapse;">
        <tr>
            <th colspan="2" rowspan="4" style="border-bottom: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </th>
            <th colspan="10" style="height:10px; background-color: #3cbeca91;"></th>

        </tr>
        <tr>
            <th colspan="8" style=" text-align: center; font-weight: bold; font-size:8px;">Form</th>
            <th>No Document</th>
            <th>FRM-PLA-04-075</th>

        </tr>
        <tr>
            <th colspan="8" rowspan="2" style=" text-align: center;  font-size:8px;">
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
            <td colspan="2">ATTACHMENT
            </td>
            <td colspan="5" style="border: none">
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
                Model
            </td>
            <td>
                S/N
            </td>
            <td>
                Front
            </td>
            <td>
                Rear
            </td>
            <td colspan="5" style="border: none"></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">
                {{ $data->unit_model }}
            </td>
            <td>{{ $data->unit_sn }}</td>
            <td>{{ $data->unit_cn }}</td>
            <td>{{ $data->engine_model }}</td>
            <td>{{ $data->engine_sn }}</td>
            <td>{{ $data->att_front }}</td>
            <td>{{ $data->att_rear }}</td>
            <td colspan="5" style="border: none; padding:4px;"></td>
        </tr>
        <tr>
            <td colspan="12" style="border:none;"></td>
        </tr>
        <tr>
            <td colspan="4">PT BINA SARANA SUKSES</td>
            <td style="border:none;"></td>
            <td colspan="2">SMR / HM</td>
            <td colspan="3" style="border:none;"></td>
            <td rowspan="2" colspan="2" style="border: none; background-color:bisque; font-weight:bold;">SHANTUI DH24 Series</td>
        </tr>
        <tr>
            <td>Job Site : </td>
            <td colspan="3">{{ $data->job_site }}</td>
            <td style="border:none;"></td>
            <td>At Inspection</td>
            <td>Date</td>
            <td colspan="5" style="border:none;"></td>

        </tr>
        <tr>
            <td>Location : </td>
            <td colspan="3">{{ $data->job_location }}</td>
            <td style="border:none;"></td>
            <td>{{ $data->at_inspection }}</td>
            <td>{{ $data->date }}</td>
            <td colspan="5" style="border:none;"></td>
        </tr>
        <tr>
            <td style="border:none;" colspan="12"></td>
        </tr>

        <tr style=" font-weight:bold; font-size:6px;">
            <th rowspan="2">ITEM</th>
            <th rowspan="2" colspan="2">CONDITION</th>
            <th rowspan="2">UNIT</th>
            <th rowspan="2">STANDARD STD / PMS</th>
            <th rowspan="2">ACTUAL</th>
            <th rowspan="2">CORRECTION MADE</th>
            <th rowspan="2">RESULT</th>
            <th colspan="2">RECOMMENDED PARTS</th>
            <th colspan="2" rowspan="2">REMARKS</th>
        </tr>
        <tr>
            <td>PR. NO</td>
            <td>Tanggal</td>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="12" style="text-align: left; font-weight:bold; font-size:6px;">ENGINE</td>
            </tr>
            @php
                $i = 0;
            @endphp
            @foreach ($list['ENGINE'] as $value)
                <tr>
                    @if (isset($value['item']))
                        @if ($value['item'] == 'Engine Speed' || $value['item'] == 'Lub Oil Press.')
                            <td class="align-middle" rowspan="2">
                                {!! $value['item'] !!}</td>
                        @else
                            <td class="align-middle">
                                {!! $value['item'] !!}</td>
                        @endif
                    @endif
                    @if (isset($value['condition']))
                        @if ($value['condition'] == 'Rated Output (1800 rpm)' && ($value['unit'] == 'C'))
                            <td class="align-middle" colspan="2" rowspan="6">
                                {!! $value['condition'] !!}</td>
                        @else
                            <td class="align-middle" colspan="2">{!! $value['condition'] !!}
                            </td>
                        @endif
                    @endif
                    @if (isset($value['unit']))
                        @if ($value['unit'] == 'Rpm' || $value['unit'] == 'Kg/cm2')
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
                    <td>{{ $data->eng_pr[$i] ?? '' }}
                    </td>
                    <td>{{ $data->eng_taggal[$i] ?? '' }}
                    </td>
                    @if ($i === 0)
                        <td colspan="2" rowspan="13">{{ $data->eng_remark }}</td>
                    @endif
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach

            <tr>
                <td colspan="12" style="text-align: left;  font-weight:bold; font-size:6px;">WORK EQUIPMENT HYDRAULIC OIL PRESSURE</td>
            </tr>
            @php
                $j = 0;
            @endphp
            @foreach ($list['WORK_EQUIPMENT_HYDRAULIC_OIL_PRESSURE'] as $value)
                <tr>
                    @if (($value['item'] ?? '') == 'Blade Left Tilt Pressure' || ($value['item'] ?? '') == 'Blade Right Tilt Pressure')
                        <td class="align-middle" rowspan="2">{!! $value['item'] !!}</td>
                    @elseif (isset($value['item']))
                        <td class="align-middle" rowspan="1">{!! $value['item'] !!}</td>
                    @endif
                    @if (!empty($value['condition0']) && ($value['item'] ?? '') == 'Blade Left Tilt Pressure')
                        <td class="align-middle" rowspan="4">{!! $value['condition0'] !!}</td>
                        <td class="align-middle" rowspan="1">{!! $value['condition1'] ?? '' !!}</td>
                    @elseif (!empty($value['condition0']) && ($value['item'] ?? '') == 'Pilot Pressure')
                        <td class="align-middle" rowspan="1">{!! $value['condition0'] !!}</td>
                        <td class="align-middle">{!! $value['condition1'] ?? '' !!}</td>
                    @else
                        <td class="align-middle">{!! $value['condition1'] ?? '' !!}</td>
                    @endif

                    @if (isset($value['unit']))
                        @if ($value['unit'] == 'Kg/cm2')
                            <td class="align-middle" rowspan="5">
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
                    <td>{{ $data->hyd_actual[$j] ?? 'test' }}</td>
                    <td>{{ $data->hyd_correction_made[$j] ?? 'test' }}</td>
                    <td>{{ $data->hyd_result[$j] ?? 'test' }}
                    </td>
                    <td>{{ $data->hyd_pr[$j] ?? 'test' }}
                    </td>
                    <td>{{ $data->hyd_taggal[$j] ?? 'test' }}
                    </td>
                    @if ($j === 0)
                        <td colspan="2" rowspan="5">{{ $data->hyd_remark }}</td>
                    @endif
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach

            <tr>
                <td colspan="12" style="text-align: left;  font-weight:bold; font-size:6px;">WORK TRAVEL SYSTEM</td>
            </tr>
            @php
                $j = 0;
            @endphp
            @foreach ($list['WORK_TRAVEL_SYSTEM'] as $value)
                <tr>
                    @if (!empty($value['item']))
                        <td class="align-middle" rowspan="2">{!! $value['item'] !!}</td>
                    @endif
                    @if (!empty($value['condition0']))
                        <td class="align-middle" rowspan="10">{!! $value['condition0'] !!}</td>
                        <td class="align-middle" rowspan="1">{!! $value['condition1'] ?? '' !!}</td>
                    @else
                        <td class="align-middle">{!! $value['condition1'] ?? '' !!}</td>
                    @endif

                    @if (isset($value['unit']))
                        <td class="align-middle" rowspan="10">
                            {!! $value['unit'] !!}</td>
                    @endif
                    @if (isset($value['standard']))
                        <td class="align-middle">{!! $value['standard'] !!}
                        </td>
                    @endif
                    <td>{{ $data->hyd_actual[$j] ?? 'test' }}</td>
                    <td>{{ $data->hyd_correction_made[$j] ?? 'test' }}</td>
                    <td>{{ $data->hyd_result[$j] ?? 'test' }}
                    </td>
                    <td>{{ $data->hyd_pr[$j] ?? 'test' }}
                    </td>
                    <td>{{ $data->hyd_taggal[$j] ?? 'test' }}
                    </td>
                    <td colspan="2">{{ $data->hyd_remark ?? '' }}</td>
                    {{-- @if ($j === 0)
                        <td colspan="2" rowspan="10">{{ $data->hyd_remark ?? '' }}</td>
                    @endif --}}
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 10px;">
        <table style="width: 80%; border-collapse: collapse;">
            <tr>
                <td colspan="2" style="border-top: none; border: 1px solid black;">Checked By</td>
                <td colspan="2" style="border-top: none; border: 1px solid black;">Validated By</td>
                <td style="border-top: none; border: 1px solid black; width: 20%;">Date</td>
                <td colspan="8" style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" style="height: 30px; border-bottom: none;"></td>
                <td colspan="2" style="height: 30px; border-bottom: none;"></td>
                <td style="height: 30px; border-bottom: none;">{{ $data->created_at }}</td>
                <td colspan="8" style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none;">{{ $data->checked_by }}</td>
                <td colspan="2" style="border-top: none;">{{ $data->validated_by }}</td>
                <td style="border-top: none;"></td>
                <td colspan="8" style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none;">Mechanic</td>
                <td colspan="2" style="border-top: none;">Foreman</td>
                <td style="border-top: none;">Date</td>
                <td colspan="8" style="border: none;"></td>
            </tr>
        </table>

    </div>
</body>

</html>
