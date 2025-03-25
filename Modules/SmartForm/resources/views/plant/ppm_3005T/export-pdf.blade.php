<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form PPM XCMG GR3005T Series</title>

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
        <p class="title">BSS-FRM-PLA-073 FORM PPM XCMG GR3005T SERIES</p>
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
            <th>FRM-PLA-04-073</th>

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
            <td rowspan="2" colspan="2" style="border: none; background-color:bisque; font-weight:bold;">XCMG
                GR3005T Series</td>
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
                        @if ($value['condition'] == 'T/C Stall')
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
                <td colspan="12" style="text-align: left;  font-weight:bold; font-size:6px;">TRANSMISSION</td>
            </tr>
            @php
                $k = 0;
            @endphp
            @foreach ($list['TRANSMISSION'] as $value)
                <tr>
                    <td class="align-middle">{!! $value['item'] !!}
                    </td>
                    <td class="align-middle">
                        {!! $value['condition0'] !!}</td>
                    <td class="align-middle">
                        {!! $value['condition1'] !!}</td>
                    <td class="align-middle">
                        {!! $value['unit'] !!}</td>
                    <td class="align-middle">
                        {!! $value['standard'] !!}</td>
                    <td>{{ $data->wo_actual[$k] ?? '' }}</td>
                    <td>{{ $data->wo_correction_made[$k] ?? '' }}</td>
                    <td>{{ $data->wo_result[$k] ?? '' }}
                    </td>
                    <td>{{ $data->wo_pr[$k] ?? '' }}
                    </td>
                    <td>{{ $data->wo_taggal[$k] ?? '' }}
                    </td>
                    <td colspan="2">{{ $data->wo_remark }}</td>
                </tr>
                @php
                    $k++;
                @endphp
            @endforeach

            <tr>
                <td colspan="12" style="text-align: left;  font-weight:bold; font-size:6px;">HYDRAULIC PRESSURE</td>
            </tr>
            @php
                $j = 0;
            @endphp
            @foreach ($list['HYDRAULIC'] as $value)
                <tr>
                    @if (isset($value['item']))
                        <td class="align-middle">
                            {!! $value['item'] !!}</td>
                    @endif
                    @if (isset($value['condition0']))
                        <td class="align-middle" rowspan="9">
                            {!! $value['condition0'] !!}</td>
                        <td class="align-middle" rowspan="9">
                            {!! $value['condition1'] !!}</td>
                    @endif

                    @if (isset($value['unit']))
                        @if ($value['unit'] == 'Kg/cm2')
                            <td class="align-middle" rowspan="8">
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
                    <td>{{ $data->hyd_pr[$j] ?? '' }}
                    </td>
                    <td>{{ $data->hyd_taggal[$j] ?? '' }}
                    </td>
                    @if ($j === 0)
                        <td colspan="2" rowspan="9">{{ $data->hyd_remark }}</td>
                    @endif
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach



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

            @php
                $l = 0;
            @endphp
            <tr>
                <td colspan="12" style="text-align: left; font-weight:bold; font-size:6px;">
                    FINAL DRIVE
                </td>
            </tr>
            <tr>
                <td class="align-middle">Drain Plug</td>
                <td colspan="2" rowspan="2" class="align-middle">Visual Check (Eng. Stop)
                </td>
                <td rowspan="2" class="align-middle"></td>
                <td class="align-middle">No Excressive, Metalic Powder</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[0] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[0] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[0] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[0] }}</td>
                <td>{{ $data->fin_taggal[0] }}</td>
                <td colspan="2" rowspan="2">
                    {{ $data->fin_remark[0] }}
                </td>
            </tr>
            <tr>
                <td class="align-middle">Oil Leak</td>
                <td class="align-middle">No Excressive, Metalic Powder</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[1] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[1] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[1] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[1] }}</td>
                <td>{{ $data->fin_taggal[1] }}</td>

            </tr>
            <tr>
                <td colspan="12" style="text-align: left; font-weight:bold; font-size:6px;">
                    TANDEM
                </td>
            </tr>
            <tr>
                <td rowspan="2" class="align-middle">Drain Plug</td>
                <td colspan="2" rowspan="4" class="align-middle">Visual Check (Eng. Stop)
                </td>
                <td class="align-middle">RH</td>
                <td rowspan="2" class="align-middle">No Excressive, Metalic
                    Powder</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[2] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[2] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[2] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[2] }}</td>
                <td>{{ $data->fin_taggal[2] }}</td>
                <td colspan="2" rowspan="2">
                    {{ $data->fin_remark[1] }}
                </td>
            </tr>
            <tr>

                <td>LH</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[3] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[3] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[3] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[3] }}</td>
                <td>{{ $data->fin_taggal[3] }}</td>
            </tr>
            <tr>
                <td rowspan="2" class="align-middle">Oil Leak</td>
                <td class="align-middle">RH</td>
                <td class="align-middle">No Oil Leak</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[4] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[4] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[4] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[4] }}</td>
                <td>{{ $data->fin_taggal[4] }}</td>
                <td colspan="2" rowspan="2">
                    {{ $data->fin_remark[2] }}
                </td>

            </tr>
            <tr>

                <td>LH</td>
                <td class="align-middle">No Oil Leak</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[5] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[5] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[5] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[5] }}</td>
                <td>{{ $data->fin_taggal[5] }}</td>

            </tr>
            <tr>
                <td colspan="12" style="text-align: left; font-weight:bold; font-size:6px;">
                    ELECTRICAL
                </td>
            </tr>
            <tr>
                <td class="align-middle">Electrical Function</td>
                <td colspan="2" class="align-middle">Function Check
                </td>
                <td class="align-middle"></td>
                <td class="align-middle">No DTC (Diagnostic Trouble Code) Detected
                </td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[6] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[6] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[6] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[6] }}</td>
                <td>{{ $data->fin_taggal[6] }}</td>
                <td colspan="2">
                    {{ $data->fin_remark[3] }}
                </td>
            </tr>
            <tr>
                <td colspan="12" style="text-align: left; font-weight:bold; font-size:6px;">
                    OPTIONAL
                </td>
            </tr>
            <tr>
                <td class="align-middle">Attacthment Frame</td>
                <td colspan="4" class="align-middle">Crack Detection
                </td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_actual[7] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_correction_made[7] === '1' ? '✓' : '' }}</td>
                <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                    {{ $data->fin_result[7] === '1' ? '✓' : '' }}</td>
                <td>{{ $data->fin_pr[7] }}</td>
                <td>{{ $data->fin_taggal[7] }}</td>
                <td colspan="2">
                    {{ $data->fin_remark[4] }}
                </td>
            </tr>
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
                <td colspan="2" style="border-top: none;">
                    {{ optional(collect($approvalList)->firstWhere('nik', $data->checked_by))->nama ?? '' }}</td>
                <td colspan="2" style="border-top: none;">
                    {{ optional(collect($approvalList)->firstWhere('nik', $data->validated_by))->nama ?? '' }}</td>
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
