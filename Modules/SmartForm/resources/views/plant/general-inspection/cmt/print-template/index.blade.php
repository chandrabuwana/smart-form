<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Table</title>
    <style>
        @media print {
            body {
                width: 100%;
                height: 100vh;
                /* Use full height of the page */
                overflow: hidden;
                /* Prevent page breaks */
            }

            .print-container {
                transform: scale(0.9);
                /* Scale down content */
                transform-origin: top left;
            }

            .hide-onprint {
                display: none
            }
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .header {
            background-color: #b0c4de;
            text-align: center;
            font-weight: semibold;
            font-size: 24px
        }

        .logo {
            width: 100%;
        }

        .bold {
            font-weight: bold;
        }

        .table-nested td {
            border: 0
        }

        .signature-wrapper {
            margin-top: 12px;
            display: flex;
            justify-content: space-around;
            gap: 3;
        }

        .signature-box {
            width: 350px;
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .signature-box .title {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .signature-box .name {
            text-align: center;
            margin-top: 100px;
            !important
        }
    </style>
</head>

<body>

    <table>
        <tr>
            <td rowspan="2" style="width: 30%;">
                <img src="{{ asset('img/bss-logo.png') }}" class="logo" alt="BSS Logo">
            </td>
            <td rowspan="2" class="header" style="width: 40%;">FORM</td>
            <td rowspan="2" colspan="2" style="width: 15%;">MODEL UNIT : {{ $inspection['model_unit'] }}</td>
            <td>No. Dok</td>
            <td>BSS-PRU-PLA-061</td>
        </tr>
        <tr>
            <td>Issued</td>
            <td>21/06/2020</td>
        </tr>
        <tr>
            <td rowspan="2">
                <table class="table-nested">
                    <tr>
                        <td>
                            <span class="bold">PLANT DEPARTMENT</span><br>
                            REPAIR MAINTENANCE
                        </td>
                        <td style="width: 60%">Site: {{ $inspection['site'] }}</td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center">GENERAL INSPECTION</td>
            <td>
                <span>C / N</span>
            </td>
            <td>{{ $inspection['cn'] }}</td>
            <td>Revisi</td>
            <td>A-/00</td>
        </tr>
        <tr>
            <td style="text-align: center">CENTER MINE TRUCK (C M T)</td>
            <td><span>HM</span></td>
            <td>{{ $inspection['hm'] }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div style="display:flex; margin-top: 12px; gap: 3px">
        <table>
            <tr>
                <td colspan="3" style="text-align: center; height: 14px">DESCRIPTION</td>
                <td colspan="2" style="text-align: center">PRE <br> INSPECT</td>
                <td colspan="2" style="text-align: center">FINAL <br> INSPECT</td>
                <td colspan="2" style="text-align: center">DELIVERY <br> INSPECT</td>
            </tr>
            <tr>
                <td colspan="2" style="height: 20px">ACTIVITY</td>
                <td>CRITICAL POINT</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">GOOD</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">BROKEN</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">GOOD</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">BROKEN</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">GOOD</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">BROKEN</td>
            </tr>
            @foreach (array_slice($activityChecklistJson, 0, 4) as $category => $items)
                <tr>
                    <td colspan="9" style="height: 14px">
                        <strong>{{ $category }}</strong>
                    </td>
                </tr>
                @foreach ($items as $index => $item)
                    @php
                        $activityKey = $item['activity'];
                        $inspectionData = $inspection['activity'][$category][$activityKey] ?? [];
                        $inspectionTypes = ['pre_inspect', 'final_inspect', 'delivery_inspect'];
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $activityKey }}</td>
                        <td>{{ $item['critical_point'] }}</td>
                        @foreach ($inspectionTypes as $type)
                            @php
                                $status = $inspectionData[$type] ?? null;
                                $isGood = !empty($status);
                                $isBroken = $status !== null && !$status;
                            @endphp
                            <td style="text-align: center">{{ $isGood ? '✔' : '' }}</td>
                            <td style="text-align: center">{{ $isBroken ? '✔' : '' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach

        </table>
        <table>
            <tr>
                <td colspan="3" style="text-align: center; height: 14px">DESCRIPTION</td>
                <td colspan="2" style="text-align: center">PRE <br> INSPECT</td>
                <td colspan="2" style="text-align: center">FINAL <br> INSPECT</td>
                <td colspan="2" style="text-align: center">DELIVERY <br> INSPECT</td>
            </tr>
            <tr>
                <td colspan="2" style="height: 20px">ACTIVITY</td>
                <td>CRITICAL POINT</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">GOOD</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">BROKEN</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">GOOD</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">BROKEN</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">GOOD</td>
                <td style="writing-mode: vertical-lr; transform: rotate(180deg); text-align:center">BROKEN</td>
            </tr>
            @foreach (array_slice($activityChecklistJson, 4) as $category => $items)
                <tr>
                    <td colspan="9" style="height: 14px"><span style="font-weight: bold;">{{ $category }}</span>
                    </td>
                </tr>
                @foreach ($items as $index => $item)
                    @php
                        $activityKey = $item['activity'];
                        $inspectionData = $inspection['activity'][$category][$activityKey] ?? [];
                        $inspectionTypes = ['pre_inspect', 'final_inspect', 'delivery_inspect'];
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $activityKey }}</td>
                        <td>{{ $item['critical_point'] }}</td>
                        @foreach ($inspectionTypes as $type)
                            @php
                                $status = $inspectionData[$type] ?? null;
                                $isGood = !empty($status);
                                $isBroken = $status !== null && !$status;
                            @endphp
                            <td style="text-align: center">{{ $isGood ? '✔' : '' }}</td>
                            <td style="text-align: center">{{ $isBroken ? '✔' : '' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>

    <h3 style="text-align: center; font-family: arial; margin-bottom: 0">ANALISA HASIL INSPEKSI (Di isi oleh Foreman)
    </h3>
    <div style="display:flex; gap: 3px">
        <table style="margin-top: 12px">
            <tr>
                <td rowspan="2">COMPONENT</td>
                <td colspan="3" style="text-align: center">PERFORMANCE</td>
                <td rowspan="2">REMARK</td>
            </tr>
            <tr>
                <td style="text-align: center">BAGUS</td>
                <td style="text-align: center">CUKUP</td>
                <td style="text-align: center">KURANG</td>
            </tr>
            @foreach (array_slice($inspectionResultJson, 0, 5) as $category => $item)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ ($inspection['performance'][$category] ?? '') == 'bagus' ? '✔' : '' }}</td>
                    <td>{{ ($inspection['performance'][$category] ?? '') == 'cukup' ? '✔' : '' }}</td>
                    <td>{{ ($inspection['performance'][$category] ?? '') == 'kurang' ? '✔' : '' }}</td>
                    <td>{{ $inspection['remark'][$category] ?? '' }}</td>
                </tr>
            @endforeach
        </table>

        <table style="margin-top: 12px">
            <tr>
                <td rowspan="2">COMPONENT</td>
                <td colspan="3" style="text-align: center">PERFORMANCE</td>
                <td rowspan="2">REMARK</td>
            </tr>
            <tr>
                <td style="text-align: center">BAGUS</td>
                <td style="text-align: center">CUKUP</td>
                <td style="text-align: center">KURANG</td>
            </tr>
            @foreach (array_slice($inspectionResultJson, 5) as $category => $item)
                <tr>
                    <td>{{ $category }}</td>
                    <td>{{ ($inspection['performance'][$category] ?? '') == 'bagus' ? '✔' : '' }}</td>
                    <td>{{ ($inspection['performance'][$category] ?? '') == 'cukup' ? '✔' : '' }}</td>
                    <td>{{ ($inspection['performance'][$category] ?? '') == 'kurang' ? '✔' : '' }}</td>
                    <td>{{ $inspection['remark'][$category] ?? ''}}</td>
                </tr>
            @endforeach
        </table>
    </div>

    @php
        use Carbon\Carbon;
    @endphp

    <div class="signature-wrapper">
        <div class="signature-box" style="width: 500px">
            <div class="title">Date : {{ Carbon::parse($inspection['created_at'])->format('d M Y') }}</div>
            <div style="text-align: center">Dilakukan oleh :</div>
            <div style="display: flex; justify-content:space-around">

                <div class="name">( Mechanic )</div>
                <div class="name">( Mechanic )</div>
            </div>
        </div>

        <div class="signature-box">
            <div class="title">Date : {{ Carbon::parse($inspection['created_at'])->format('d M Y') }}</div>
            <div style="text-align: center">Diperiksa oleh :</div>
            <div class="name">( Plant Foreman )</div>
        </div>

        <div class="signature-box">
            <div class="title">Date : {{ Carbon::parse($inspection['created_at'])->format('d M Y') }}</div>
            <div style="text-align: center">Diketahui oleh :</div>
            <div class="name">( Kabag / Spv Plant )</div>
        </div>
    </div>

    <a class="hide-onprint" href="{{route('bss-form.plant.general-inspection.cmt.index')}}" style="text-decoration: none; position: fixed; bottom: 20px; right: 100px; padding: 10px 20px; background-color: #e8e8e8; color: rgb(56, 56, 56); border: none; border-radius: 5px; cursor: pointer; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">Kembali</a>
    <button class="hide-onprint" onclick="window.print()" style="position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">Print</button>

</body>

</html>
