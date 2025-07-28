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
                overflow: hidden;
                /* Menghindari scroll pada halaman */
                margin: 0;
            }

            .print-container {
                transform: scale(0.8);
                /* Sesuaikan skala konten */
                transform-origin: top left;
                width: 100%;
                height: 100%;
            }

            table {
                table-layout: fixed;
                width: 100%;
            }

            .hide-onprint {
                display: none;
            }
        }

        @page {
            size: A4;
            margin: 10mm;
            /* Mengatur margin untuk mencetak */
        }

        body {
            font-family: Arial, sans-serif !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 6px;
        }

        th,
        td {
            border: 1px solid black;

            text-align: left;
        }

        .header {
            background-color: #b0c4de;
            text-align: center;
            font-weight: semibold;
            font-size: 14px
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
            padding: 5px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .signature-box .title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .signature-box .name {
            text-align: center;
            margin-top: 40px;
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
            <td rowspan="2" style="text-align: center">GENERAL INSPECTION DONGFENG</td>
            <td>
                <span>C / N</span>
            </td>
            <td>{{ $inspection['cn'] }}</td>
            <td>Revisi</td>
            <td>A-/00</td>
        </tr>
        <tr>

            <td><span>HM</span></td>
            <td>{{ $inspection['hm'] }}</td>
            <td>Inspection Date</td>
            <td>{{ $inspection['date_inspection'] }}</td>
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
            @foreach (array_slice($activityChecklistJson, 0, 7) as $category => $items)
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
                            @if ($activityKey == 'Check Clutch Limit')
                                <td colspan="2" style="text-align: center">{{ $inspectionData[$type] }}</td>
                            @else
                                <td style="text-align: center">{{ $isGood ? '✔' : '' }}</td>
                                <td style="text-align: center">{{ $isBroken ? '✔' : '' }}</td>
                            @endif
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
            @foreach (array_slice($activityChecklistJson, 7) as $category => $items)
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
                {{-- <td rowspan="2" style="text-align: center">REMARK</td> --}}
            </tr>
            <tr>
                <td style="text-align: center">BAGUS</td>
                <td style="text-align: center">CUKUP</td>
                <td style="text-align: center">KURANG</td>
            </tr>
            @foreach (array_slice($inspectionResultJson, 0, 5) as $category => $item)
                <tr>
                    <td>{{ $category }}</td>
                    <td style="text-align: center">
                        {{ ($inspection['performance'][$category] ?? '') == 'bagus' ? '✔' : '' }}</td>
                    <td style="text-align: center">
                        {{ ($inspection['performance'][$category] ?? '') == 'cukup' ? '✔' : '' }}</td>
                    <td style="text-align: center">
                        {{ ($inspection['performance'][$category] ?? '') == 'kurang' ? '✔' : '' }}</td>
                    {{-- <td style="text-align: center">{{ $inspection['remark'][$category] ?? '' }}</td> --}}
                </tr>
            @endforeach
            <tr>
                <td>Note/Catatan</td>
                <td colspan='4'>{{ $inspection['note'] }}</td>
            </tr>
        </table>

        <table style="margin-top: 12px">
            <tr>
                <td rowspan="2">COMPONENT</td>
                <td colspan="3" style="text-align: center">PERFORMANCE</td>
                {{-- <td rowspan="2" style="text-align: center">REMARK</td> --}}
            </tr>
            <tr>
                <td style="text-align: center">BAGUS</td>
                <td style="text-align: center">CUKUP</td>
                <td style="text-align: center">KURANG</td>
            </tr>
            @foreach (array_slice($inspectionResultJson, 5) as $category => $item)
                <tr>
                    <td>{{ $category }}</td>
                    <td style="text-align: center">
                        {{ ($inspection['performance'][$category] ?? '') == 'bagus' ? '✔' : '' }}</td>
                    <td style="text-align: center">
                        {{ ($inspection['performance'][$category] ?? '') == 'cukup' ? '✔' : '' }}</td>
                    <td style="text-align: center">
                        {{ ($inspection['performance'][$category] ?? '') == 'kurang' ? '✔' : '' }}</td>
                    {{-- <td style="text-align: center">{{ $inspection['remark'][$category] ?? '' }}</td> --}}
                </tr>
            @endforeach
            <tr>
                <td colspan="5"></td>

            </tr>
        </table>
    </div>

    @php
        use Carbon\Carbon;
    @endphp

    <div class="signature-wrapper">
        {{-- TANDA TANGAN DILAKUKAN OLEH --}}
        <div class="signature-box" style="width: 300px; font-size: 10px;">
            <div class="title">Date : {{ Carbon::parse($inspection['date_sign1'])->format('d M Y') }}</div>
            <div style="text-align: center;">
                <p>Dilakukan oleh:</p>
            </div>
            <div style="display: flex; justify-content: space-around;">
                <div class="name">
                    <img src="{{ asset('img/validated.png') }}" class="ttd" style="width: 40px" height="20px">
                    {{-- Mencari nama di $approvalList berdasarkan NIK --}}
                    <p>{{ $approvalList->firstWhere('nik', $inspection['dilakukan1'])->nama ?? $inspection['dilakukan1'] }}</p>
                    <p>(Mechanic)</p>
                </div>
                <div class="name">
                    <img src="{{ asset('img/validated.png') }}" class="ttd" style="width: 40px" height="20px">
                    {{-- Mencari nama di $approvalList berdasarkan NIK --}}
                    <p>{{ $approvalList->firstWhere('nik', $inspection['dilakukan2'])->nama ?? $inspection['dilakukan2'] }}</p>
                    <p>(Mechanic)</p>
                </div>
            </div>
        </div>

        @php
            $status = json_decode($inspection['status'], true);
        @endphp

        {{-- TANDA TANGAN DIPERIKSA OLEH --}}
        <div class="signature-box" style="width: 300px; font-size: 10px;">
            <div class="title">Date : {{ $inspection['date_sign2'] ? Carbon::parse($inspection['date_sign2'])->format('d M Y') : '' }}</div>
            <div style="text-align: center;">
                <p>Diperiksa oleh:</p>
            </div>
            <div class="name">
                @if ($status[0] == 'Approved')
                    <img src="{{ asset('img/checked.png') }}" class="ttd" style="width: 40px" height="20px">
                @elseif ($status[0] == 'Rejected')
                    <img src="{{ asset('img/rejected.png') }}" class="ttd" style="width: 40px" height="20px">
                @endif
                {{-- Mencari nama di $approvalList berdasarkan NIK --}}
                <p>{{ $approvalList->firstWhere('nik', $inspection['diperiksa'])->nama ?? $inspection['diperiksa'] }}</p>
                <p>(Plant Foreman)</p>
            </div>
        </div>

        {{-- TANDA TANGAN DIKETAHUI OLEH --}}
        <div class="signature-box" style="width: 300px; font-size: 10px;">
            <div class="title">Date : {{ $inspection['date_sign3'] ? Carbon::parse($inspection['date_sign3'])->format('d M Y') : '' }}</div>
            <div style="text-align: center;">
                <p>Diketahui oleh:</p>
            </div>
            <div class="name">
                @if ($status[1] == 'Approved')
                    <img src="{{ asset('img/checked.png') }}" class="ttd" style="width: 40px" height="20px">
                @elseif ($status[1] == 'Rejected')
                    <img src="{{ asset('img/rejected.png') }}" class="ttd" style="width: 40px" height="20px">
                @endif
                {{-- Mencari nama di $approvalList berdasarkan NIK --}}
                <p>{{ $approvalList->firstWhere('nik', $inspection['diketahui'])->nama ?? $inspection['diketahui'] }}</p>
                <p>(Kabag / Spv Plant)</p>
            </div>
        </div>
    </div>

    <a class="hide-onprint" href="{{ route('bss-form.plant.general-inspection.dongfeng.index') }}"
        style="text-decoration: none; position: fixed; bottom: 20px; right: 100px; padding: 10px 20px; background-color: #e8e8e8; color: rgb(56, 56, 56); border: none; border-radius: 5px; cursor: pointer; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">Kembali</a>
    <button class="hide-onprint" onclick="window.print()"
        style="position: fixed; bottom: 20px; right: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">Print</button>

</body>

</html>
