<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form P2H Unit Compressor</title>

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
        <p class="title">BSS-FRM-PLA-040 P2H COMPRESOR POMPA (STANDARD)</p>
        <P class="title" style="margin-top: 10px;">Site : {{ $record->site }}</P>
    </div>

    <div class="detail">
        <p class="title">Detail Pengisian</p>
    </div>
    <table class="container">
        <tr>
            <td colspan="3" rowspan="3" style="border-bottom: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </td>
            <td colspan="31" style=" background-color: #3cbeca91;"></td>

        </tr>
        <tr>
            <td colspan="31" style=" text-align: center; font-weight: bold; font-size:15px;">Form</td>

        </tr>
        <tr>
            <th colspan="31" style=" text-align: center;">
                <h1>FORM P2H UNIT COMPRESOR</h1>
            </th>
        </tr>
        <tr>
            <td colspan="3" class="text-left" style="border: none; ">
                <p style="margin-left: 4px;">C/N UNIT: {{ $record->unit_name }}</p>
            </td>
            <td colspan="16" class="text-left" style="border: none; ">
                <p>LOKASI: {{ $record->location }}</p>
            </td>
            <td colspan="15" class="text-left" style="border: none;">
                <p>BULAN: {{ \Carbon\Carbon::parse($record->month)->format('F') }}</p>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-left" style="border: none;;">
                <p style="margin-left: 4px;">NAMA PENGECEK :{{ $record->name }}</p>
            </td>
            <td colspan="16" class="text-left" style="border: none; ">
                <p>ENGINE MODEL: {{ $record->engine_model }}</p>
            </td>
            <td colspan="15" class="text-left" style="border: none; ">
                <p>GENERATOR MODEL: {{ $record->generator_model }}</p>
            </td>
        </tr>

        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2" class="text-center">ITEM YANG DI CHECK</th>
            <th rowspan="2">CODE BAHAYA</th>
            <th colspan="31">TANGGAL</th>
        </tr>
        @for ($i = 1; $i <= 31; $i++)
            <th>{{ $i }}</th>
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
                $question21 = $record->question21 ?? [];
                $question22 = $record->question22 ?? [];
                $paraf = $record->paraf_item ?? [];
            @endphp
            <tr>
                <td colspan="3" style="font-weight: bold;" class="text-center">CHECK SEBELUM START</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td></td>
                @endfor
            </tr>
            <tr>
                <td>1</td>
                <td class="text-left">Level Oli Mesin</td>
                <td>AA</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question1[$i - 1]) && $question1[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">Level Air Radiator</td>
                <td>AA</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question2[$i - 1]) && $question2[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">Level Air Battery dan Cable Battery</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question3[$i - 1]) && $question3[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>4</td>
                <td class="text-left">Level Solar</td>
                <td>A</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question4[$i - 1]) && $question4[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>5</td>
                <td class="text-left">Rubber Coupling Mesin</td>
                <td>A</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question5[$i - 1]) && $question5[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>6</td>
                <td class="text-left">Kekencangan V-Belt</td>
                <td>A</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question6[$i - 1]) && $question6[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>7</td>
                <td class="text-left">Kondisi Guard Fan</td>
                <td>A</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question7[$i - 1]) && $question7[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>8</td>
                <td class="text-left">Rubber Mountin Mesin</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question8[$i - 1]) && $question8[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>9</td>
                <td class="text-left">Rubber Mounting Compresor</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question9[$i - 1]) && $question9[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>10</td>
                <td class="text-left">Radiator dan House Radiator</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question10[$i - 1]) && $question10[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>11</td>
                <td class="text-left">Air Cleaner dan Bracket</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question11[$i - 1]) && $question11[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>12</td>
                <td class="text-left">Muffler dan Bolt Mounting</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question12[$i - 1]) && $question12[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>13</td>
                <td class="text-left">Check Adhusment throtle Gad Engine</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question13[$i - 1]) && $question13[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>14</td>
                <td class="text-left">Kekencangan Bolt Nut</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question14[$i - 1]) && $question14[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>15</td>
                <td class="text-left">Main Circuit Breaker & Cable</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question15[$i - 1]) && $question15[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>16</td>
                <td class="text-left">Check Kebocoran Oil, Solar, & Air</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question16[$i - 1]) && $question16[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold;" class="text-center">CHECK SESUDAH START</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;"></td>
                @endfor
            </tr>
            <tr>
                <td>1</td>
                <td class="text-left">Noise / Suara Mesin</td>
                <td>AA</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question17[$i - 1]) && $question17[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>2</td>
                <td class="text-left">Noise / Suara Generator</td>
                <td>AA</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question18[$i - 1]) && $question18[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>3</td>
                <td class="text-left">Gauge Panel Oil Pressure</td>
                <td>A</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question19[$i - 1]) && $question19[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>4</td>
                <td class="text-left">Gauge Panel Water Temperatur</td>
                <td>B</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">{!! isset($question20[$i - 1]) && $question20[$i - 1] === '1' ? '✓' : '' !!}</td>
                @endfor
            </tr>
            <tr>
                <td>5</td>
                <td class="text-left">Kebocoran Oli, Air dan Solar</td>
                <td>A</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                        {{ $question21[$i - 1] === '1' ? '✓' : '' }}</td>
                @endfor
            </tr>
            <tr>
                <td>6</td>
                <td class="text-left">Charging System</td>
                <td>AA</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                        {{ $question22[$i - 1] === '1' ? '✓' : '' }}</td>
                @endfor
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold;" class="text-center">PARAF PENGECEK</td>
                @for ($i = 1; $i <= 31; $i++)
                    <td style="text-align: center; font-family: DejaVu Sans, sans-serif;">
                        {{ $paraf[$i - 1] === '1' ? '✓' : '' }}</td>
                @endfor
            </tr>
            <tr>
                <td colspan="34" class="text-left"> <span style="font-weight: bold;">Catatan : </span>
                    {{ $record->catatan }}</td>
            </tr>
        </tbody>
    </table>
    <div class="bottom">
        <strong>Master Data :</strong>
        <ul>
            <li>1. <strong>Site:</strong> All Site</li>
            <li>2. <strong>C/N Unit:</strong> Free Text</li>
            <li>3. <strong>Nama Pengecek:</strong> Free Text</li>
            <li>4. <strong>Lokasi:</strong> Workshop, Pitstop, Service Truck</li>
            <li>5. <strong>Bulan:</strong> Januari – Desember</li>
        </ul>
    </div>

</body>

</html>
