<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM P2H UNIT CMT - LGMG</title>
</head>
<style type="text/css">
    body{
    font-family: 'Roboto Condensed', sans-serif;
}
h4 {
    margin: 0;
}
.kotak {
    border: 1px solid;
    text-align: center;
    padding: 0.5rem;
}
.w-full {
    width: 100%;
    padding: 0.5rem;
    font-size: 0.875rem;
}
.w-fullborder {
    width: 100%;
    border: 1px solid;
}
.w-half {
    width: 50%;
    font-size: 0.875rem;
}
.w-header {
    width: 50%;
    text-align: center;
}
.w-seperempat {
    width: 20%;
    font-size: 0.575rem;
}
.margin-top {
    margin-top: 0.200rem;
    /* page-break-after: always; */
}
.footer {
    font-size: 0.875rem;
    padding: 1rem;
}
table {
    width: 100%;
    border-collapse: collapse;
    page-break-inside: avoid;
}
table.kop {
    font-size: 0.875rem;
    text-align: center;
}
table tr.itemKop td{
    border: 1px solid;
}
table tr.items {
    background-color: #FFFF;
}
table tr.items td {
    padding: 0.5rem;
    text-align: center;
    border: 1px solid;
}
table tr.itemsHead td {
    font-size: 0.875rem;
    font-weight: bold;
    text-align: center;
}
table tr.datanilaihead th{
    font-size: 0.875rem;
    font-weight: bold;
    text-align: center;
    border: 2px solid;
    padding:0.200rem;
}
table tr.datanilaiitem td {
    font-size: 0.875rem;
    text-align: center;
    border: 1px solid;
    padding:0.100rem;
}
table tr.approval td {
    padding: 0.5rem;
    font-size: 0.875rem;
    text-align: center;
}
p.thick {
  font-weight: bold;
}
.data {
  font-family: "monaco", "Courier New", monospace;
  /* font-weight: bold; */
}

.page-break {
    page-break-before: always;
}

.option-ya-tidak {
    font-family: 'DejaVu Sans', sans-serif;
}

.ttd {
    width: 60px;
}


</style>
<body>
    <table class="w-fullborder">

        <table class="kop" style="border-collapse: collapse; margin-top: 5px;">
            <tr class="itemKop">
                <td class="w-seperempat" style="border: none;"><img src="{{ ('img/logo.png') }}" alt="Bina Sarana Sukses" width="100" /></td>
                <td colspan="4" style="border: none;"><b><i>Pelaksanaan Pemeriksaan Harian (P2)</i></b></td>
            </tr>
            <tr class="itemKop">
                <td class="w-seperempat" style="border: none;"></td>
                <td colspan="4" style="text-align: center; border: none;"><b><i>HT LGMG CMT96 dan 106</i></b></td>
            </tr>
        </table>

        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <table class="w-full">
                        <tr>
                            <td class="w-seperempat">Nama Operator</td>
                            <div class="data">: {{ $data->nama_operator }}</div>
                        </tr>
                        <tr>
                            <td class="w-seperempat">Shift</td>
                            <div class="data">: {{ $data->shift }}</div>
                        </tr>
                        <tr>
                            <td class="w-seperempat">NRP</td>
                            <div class="data">: {{ $data->nrp }}</div>
                        </tr>
                        <tr>
                            <td class="w-seperempat">FUEL AWAL</td>
                            <div class="data">: {{ $data->fuel_awal }}</div>
                            <td class="w-seperempat">FUEL AKHIR</td>
                            <div class="data">: {{ $data->fuel_akhir }}</div>
                        </tr>
                    </table>
                    <td class="w-half">
                        <table class="w-full">
                            <tr>
                                <td class="w-seperempat">TANGGAL</td>
                                <div class="data">: {{ $data->nama_operator }}</div>
                            </tr>
                            <tr>
                                <td class="w-seperempat">NO UNIT</td>
                                <div class="data">: {{ $data->shift }}</div>
                            </tr>
                            <tr>
                                <td class="w-seperempat">KM STAR</td>
                                <div class="data">: {{ $data->km_star }}</div>
                                <td class="w-seperempat">KM AKHIR</td>
                                <div class="data">: {{ $data->km_akhir }}</div>
                            </tr>
                            <tr>
                                <td class="w-seperempat">HM STAR</td>
                                <div class="data">: {{ $data->hm_star }}</div>
                                <td class="w-seperempat">HM AKHIR</td>
                                <div class="data">: {{ $data->hm_akhir }}</div>
                            </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </div>
        {{-- @foreach($pertanyaan as $category => $items)
            <div class="margin-top"> --}}
                {{-- <table class="w-full">
                    <tr> --}}
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('KABIN')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['KABIN'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('SUSPENSION AND AXEL')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['SUSPENSION_AND_AXEL'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('ELECTRIK')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['ELECTRIK'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('HYDROLIK_SYSTEM_DUMP')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['HYDROLIK_SYSTEM_DUMP'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('ENGINE')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['ENGINE'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('WHEEL_AND_BREAK')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['WHEEL_AND_BREAK'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('SAFETY_TOOLS')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['SAFETY_TOOLS'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>
                                    <table class="w-full" border="1" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">NAMA KOMPONEN</th>
                                                <th colspan="2">PENGECEKAN</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th>AWAL</th>
                                                <th>AKHIR</th>
                                            </tr>
                                            <tr style="background-color: #a9a9a9; text-align: center;">
                                                <th colspan="4">{{ str_replace('_', ' ', strtoupper('ITEM_LAIN')) }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pertanyaan['ITEM_LAIN'] as $items)
                                            <tr>
                                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                                <td>{{ $items->pertanyaan }}</td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Ya' ? '✓' : '' }}
                                                </td>
                                                <td style="text-align: center; font-family: DejaVu Sans; font-size: 12px;">
                                                    {{ $items->jawaban == 'Tidak' ? '✓' : '' }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    {{-- </tr>
                </table> --}}
            {{-- </div>
        @endforeach --}}

        <div class="margin-top">
            <table style="width:100%; table-layout: fixed;" class="kop">
                <thead>
                    <tr class="itemKop">
                        <td colspan="2" style="text-align: center;"><b>KETERANGAN</b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomor = 1;
                    for ($i = 0; $i < 4; $i++) {
                        $keterangan = isset($keteranganArray[$i]) ? $keteranganArray[$i] : '';
                        ?>
                        <tr>
                            <td style="width: 5%; text-align: center; border: 1px solid black;"><?php echo $nomor; ?>.</td>
                            <td style="border: 1px solid black; text-align: left;"><?php echo $keterangan; ?></td>
                        </tr>
                        <?php
                        $nomor++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="margin-top">
            <table class="w-full">
                <table style="border: 1px solid;">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Diisi Oleh</th>
                            <th style="text-align: center;">Diperiksa Oleh</th>
                            <th style="text-align: center;">Catatan RM</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr> --}}
                        <tr>
                            <td colspan="1" style="height: 30px; border-bottom: none; text-align: center"> <img
                                    src="{{ public_path('img/checked.png') }}" class="ttd"></td>
                            <td colspan="1" style="height: 30px; border-bottom: none; text-align: center"> <img
                                    src="{{ public_path('img/checked.png') }}" class="ttd"></td>
                            @if ($data->status == 'approved')
                                <td colspan="1" style="height: 30px; border-bottom: none; text-align: center"> <img
                                        src="{{ public_path('img/validated.png') }}" class="ttd">
                                </td>
                            @else
                                <td colspan="1" style="height: 30px; border-bottom: none; text-align: center"></td>
                            @endif

                            {{-- <td colspan="5" style="border: none"></td> --}}
                        </tr>
                        <tr>
                            <td style="text-align: center;">{{ optional(collect($approvalList)->firstWhere('nama', $data->diisi_oleh))->nama ?? '' }}</td>
                            <td style="text-align: center;">{{ optional(collect($approvalList)->firstWhere('nama', $data->checked_by))->nama ?? '' }}</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Operator</td>
                            <td style="text-align: center;">Pengawas</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </table>
        </div>

        </div>
        <div class="footer"></div>
    </table>
</body>
