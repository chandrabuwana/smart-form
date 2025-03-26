<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>FORM CHECKLIST OGC COMPLIANCE</title>

    <style>
        body {
            font-family: Arial, "Segoe UI", sans-serif;
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

    <table class="container">
        <tr>
            <th rowspan="3" colspan="2" style="border-bottom: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </th>
            <th colspan="12" style="height:10px; background-color: #3cbeca91;">INTEGRATED BSS EXCELLENT SYSTEM</th>

        </tr>
        <tr>
            <th colspan="8" rowspan="2" style=" text-align: center; font-weight: bold; font-size:8px;">Form</th>
            <th>No Document</th>
            <th colspan="3">FRM-PLA-04-071</th>

        </tr>
        <tr>
            <th>Revis1</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th colspan="10" rowspan="2" style=" text-align: center;  font-size:8px;">
                CHECKLIST LUBE COMPLIANCE
            </th>

            <th>Tanggal</th>
            <th colspan="3">11/9/2023</th>


        </tr>
        <tr>

            <th>Halaman</th>
            <th colspan="3">1 dari 1</th>
        </tr>

        <tr>
            <td rowspan="4" colspan="2"></td>
            <td colspan="2">Nama & Validasi</td>
            <td colspan="2">Nama & Validasi</td>
            <td colspan="2">Nama & Validasi</td>
            <td colspan="2">Nama & Validasi</td>
            <td colspan="2">Nama & Validasi</td>
            <td colspan="2" style="border-bottom: none;"></td>
        </tr>
        <tr>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td style="border-bottom: none;"></td>
            <td colspan="2" style="border-top: none; border-bottom: none;">Definisi Lube Compliance : Kepatuhan terhadap standart
                kelayakan penggunaan alat kerja maupun
                perlengkapan agar operasional Lube meliputi : Oil, Grease, dan
                Coolant dapat berjalan lancar dan sesuai dengan kaedah keselamatan kerja.</td>

        </tr>
        <tr>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 1']) && $detail['week 1']->isNotEmpty() ? $detail['week 1']->first()->validator : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 1']) && $detail['week 1']->isNotEmpty() ? $detail['week 1']->first()->checker : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 2']) && $detail['week 2']->isNotEmpty() ? $detail['week 2']->first()->validator : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 2']) && $detail['week 2']->isNotEmpty() ? $detail['week 2']->first()->checker : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 3']) && $detail['week 3']->isNotEmpty() ? $detail['week 3']->first()->validator : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 3']) && $detail['week 3']->isNotEmpty() ? $detail['week 3']->first()->checker : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 4']) && $detail['week 4']->isNotEmpty() ? $detail['week 4']->first()->validator : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 4']) && $detail['week 4']->isNotEmpty() ? $detail['week 4']->first()->checker : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 5']) && $detail['week 5']->isNotEmpty() ? $detail['week 5']->first()->validator : ''))->nama ?? '' }}
            </td>
            <td style="border-top: none;">
                {{ optional(collect($approvalList)->firstWhere('nik', isset($detail['week 5']) && $detail['week 5']->isNotEmpty() ? $detail['week 5']->first()->checker : ''))->nama ?? '' }}
            </td>

            <td colspan="2" style="border-top: none; border-bottom: none;"> Berikanlah informasi yang valid sesuai kondisi actual,
                apabila terdapat peralatan / perlengkapan yang
                tidak memenuhi standart atau tidak tersedia berikan catatan di
                kolom Coment.</td>
        </tr>
        <tr>
            <td>FOGC</td>
            <td>Kabag</td>
            <td>FOGC</td>
            <td>Kabag</td>
            <td>FOGC</td>
            <td>Kabag</td>
            <td>FOGC</td>
            <td>Kabag</td>
            <td>FOGC</td>
            <td>Kabag</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td class="text-left" colspan="2">Date:
                {{ isset($detail['week 1']) && $detail['week 1']->isNotEmpty() ? \Carbon\Carbon::parse($detail['week 1']->first()->date)->format('d m Y') : '' }}
            </td>
            <td class="text-left" colspan="2">Date:
                {{ isset($detail['week 2']) && $detail['week 2']->isNotEmpty() ? \Carbon\Carbon::parse($detail['week 2']->first()->date)->format('d m Y') : '' }}
            </td>
            <td class="text-left" colspan="2">Date:
                {{ isset($detail['week 3']) && $detail['week 3']->isNotEmpty() ? \Carbon\Carbon::parse($detail['week 3']->first()->date)->format('d m Y') : '' }}
            </td>
            <td class="text-left" colspan="2">Date:
                {{ isset($detail['week 4']) && $detail['week 4']->isNotEmpty() ? \Carbon\Carbon::parse($detail['week 4']->first()->date)->format('d m Y') : '' }}
            </td>
            <td class="text-left" colspan="2">Date:
                {{ isset($detail['week 5']) && $detail['week 5']->isNotEmpty() ? \Carbon\Carbon::parse($detail['week 5']->first()->date)->format('d m Y') : '' }}
            </td>
            <td colspan="2" style="text-align:left; font-family: DejaVu Sans, sans-serif;">NOTE ✓(YES) X (NO) </td>
            </td>

        </tr>
        <tr>

            <th colspan="2" style="vertical-align: middle;">
                Lube Station</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 1</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 2</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 3</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 4</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 5</th>
            </th>
            <th colspan="2" style="vertical-align: middle;">
                Comment</th>
        </tr>
        @php
            $i = 1;
            $p = 0;
        @endphp

        @foreach ($list['Lube Station'] as $value)
            <tr>
                <th>{{ $i }}</th>
                <td style="text-align: left; font-size: 8px;">
                    {!! $value['question'] !!}
                </td>

                <td colspan="2">
                    {{ isset($detail['week 1']) && $detail['week 1']->isNotEmpty() ? $detail['week 1']->first()->lube_station[$p] : '' }}
                </td>
                </td>
                <td colspan="2">
                    {{ isset($detail['week 2']) && $detail['week 2']->isNotEmpty() ? $detail['week 2']->first()->lube_station[$p] : '' }}
                </td>
                <td colspan="2">
                    {{ isset($detail['week 3']) && $detail['week 3']->isNotEmpty() ? $detail['week 3']->first()->lube_station[$p] : '' }}
                </td>
                <td colspan="2">
                    {{ isset($detail['week 4']) && $detail['week 4']->isNotEmpty() ? $detail['week 4']->first()->lube_station[$p] : '' }}
                </td>

                <td colspan="2">
                    {{ isset($detail['week 5']) && $detail['week 5']->isNotEmpty() ? $detail['week 5']->first()->lube_station[$p] : '' }}
                </td>

                <td class="ms-2 text-left" colspan="2">
                    @for ($k = 1; $k < 6; $k++)
                        @php $weekKey = "week {$k}"; @endphp
                        {{ isset($detail[$weekKey]) &&
                        $detail[$weekKey]->isNotEmpty() &&
                        isset($detail[$weekKey]->first()->station_comment[$p])
                            ? $detail[$weekKey]->first()->station_comment[$p]
                            : '' }}
                    @endfor
                </td>

            </tr>
            @php
                $i++;
                $p++;
            @endphp
        @endforeach


        <tr>

            <th colspan="2" style="vertical-align: middle;">
                Lube Truck</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 1</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 2</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 3</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 4</th>
            <th colspan="2" style="vertical-align: middle;">
                Week 5</th>
            </th>
            <th colspan="2" style="vertical-align: middle;">
                Comment</th>
        </tr>
        <tr>
            @php
                $u = 0;
            @endphp

            @foreach ($list['Lube Truck'] as $value)
        <tr>
            <th>{{ $i }}</th>
            <td style="text-align: left; font-size: 8px;">
                {!! $value['question'] !!}
            </td>

            <td colspan="2">
                {{ isset($detail['week 1']) && $detail['week 1']->isNotEmpty() ? $detail['week 1']->first()->lube_station[$u] : '' }}
            </td>
            </td>
            <td colspan="2">
                {{ isset($detail['week 2']) && $detail['week 2']->isNotEmpty() ? $detail['week 2']->first()->lube_station[$u] : '' }}
            </td>
            <td colspan="2">
                {{ isset($detail['week 3']) && $detail['week 3']->isNotEmpty() ? $detail['week 3']->first()->lube_station[$u] : '' }}
            </td>
            <td colspan="2">
                {{ isset($detail['week 4']) && $detail['week 4']->isNotEmpty() ? $detail['week 4']->first()->lube_station[$u] : '' }}
            </td>

            <td colspan="2">
                {{ isset($detail['week 5']) && $detail['week 5']->isNotEmpty() ? $detail['week 5']->first()->lube_station[$u] : '' }}
            </td>

            <td class="ms-2 text-left" colspan="2">
                @for ($k = 1; $k < 6; $k++)
                    @php $weekKey = "week {$k}"; @endphp
                    {{ isset($detail[$weekKey]) &&
                    $detail[$weekKey]->isNotEmpty() &&
                    isset($detail[$weekKey]->first()->station_comment[$u])
                        ? $detail[$weekKey]->first()->station_comment[$u]
                        : '' }}
                @endfor
            </td>

        </tr>

        @php
            $u++;
            $i++;
        @endphp
        @endforeach


    </table>

    </div>
</body>

</html>
