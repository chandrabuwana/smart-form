<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM INSPEKSI CATERING</title>
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
    font-size: 0.875rem;
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
  font-weight: bold;
}

.page-break {
    page-break-before: always; /* Memaksa elemen ini dimulai di halaman baru */
}

.option-ya-tidak {
    font-family: 'DejaVu Sans', sans-serif;
}

</style>
<body>
    @foreach ($pertanyaan as $category => $items)
    <table class="w-fullborder">

        <table class="kop">
            <tr class="itemKop">
                <td class="w-seperempat" rowspan="5"><img src="{{ ('img/logo.png') }}" alt="Bina Sarana Sukses" width="100" /></td>
                <td colspan="4" style="background-color: rgb(225, 230, 235)">BSS SHE Management System</td>
            </tr>
            <tr class="itemKop">
                <td colspan="2" rowspan="2" style="width:60">FORM</td>
                <td style="width:35;font-size:0.650rem;text-align:left">No. Dok</td>
                <td style="width:90;text-align:left;font-size:0.650rem">: BSS-FRM-SHE-034</td>
            </tr>
            <tr class="itemKop">
                <td style="font-size:0.650rem;text-align:left">Revisi</td>
                <td style="text-align:left;font-size:0.650rem">: 00</td>
            </tr>
            <tr class="itemKop">
                <td colspan="2" rowspan="2" style="width:60">INSPEKSI CATERING</td>
                <td style="font-size:0.650rem;text-align:left">Tanggal</td>
                <td style="text-align:left;font-size:0.650rem">: 23 November 2021</td>
            </tr>
            <tr class="itemKop">
                <td style="font-size:0.650rem;text-align:left">Halaman</td>
                <td style="text-align:left;font-size:0.650rem">: {{$loop->iteration}} dari {{ count($pertanyaan) }}</td>
            </tr>
        </table>

        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <table class="w-full">
                        <tr>
                            <td class="w-seperempat">Nama</td>
                            <div class="data">: {{ $data->nama_site }}</div>
                        </tr>
                        <tr>
                            <td class="w-seperempat">Depart./Section</td>
                            <div class="data">: {{ $data->dept }}</div>
                        </tr>
                        <tr>
                            <td class="w-seperempat">Shift</td>
                            <div class="data">: {{ $data->shift }}</div>
                        </tr>
                    </table>
                    <td class="w-half">
                        <table class="w-full">
                        <tr>
                            <td class="w-half">Lokasi Kerja</td>
                            <div class="data">: {{ $data->loker }}</div>
                        </tr>
                        <tr>
                            <td>Jumlah Inspektor</td>
                            <div class="data">: {{ $data->jml_ins }}</div>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </div>


            <div class="margin-top">
                <table class="w-full">
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: rgb(49, 115, 201); color: white; text-align: center;">
                                <th>TINGKAT RESIKO</th>
                                <th>POTENSI RESIKO</th>
                                <th>KEMUNGKINAN AKIBAT</th>
                                <th>TINDAKAN PERBAIKAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center; background-color: red; color: white">Risiko Kritikal</td>
                                <td style="text-align: center"><b>75 - 125</b></td>
                                <td>> Rp 100 Juta dan Sakit akut/ meninggal
                                    Tidak sesuai baku mutu/peraturan perundangan dan
                                    mendapatkan ancaman denda atau pidana, penutupan
                                    permanen perushaan atau berdampak ke masyarakat
                                    nasional</td>
                                <td><a style="background-color: red; color:white">TIDAK DAPAT DITERIMA(STOP)</a> Pekerjaan tidak boleh
                                    dilakukan sampai tingkat risiko diturunkan. Jika risiko
                                    tidak mungkin diturunkan sekalipun dengan sumberdaya
                                    yang tidak terbatas, pekerjaan dihentikan dan tidak
                                    boleh dilakukan</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; background-color: orange; color: black">Risiko Kritikal</td>
                                <td style="text-align: center"><b>32 - 75</b></td>
                                <td>Rp 50 Juta – Rp 100 Juta dan Sakit dan rawat inap
                                    /kronis/PAK. Tidak sesuai baku mutu/peraturan
                                    perundangan dan mendapatkan peringatan keras dari
                                    pemerintah, penghentian operasional perusahaan
                                    sementara atau berdampak ke masyarakat yg lebih luas</td>
                                <td>Pekerjaan dapat dilakukan Tindakan pengendalian
                                    segera dilakukan untuk menurunkan tingkat resiko.
                                    Keterlibatan Pimpinan diperlukan untuk pengendalian
                                    tersebut.</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; background-color: yellow; color: black">Risiko Kritikal</td>
                                <td style="text-align: center"><b>18 - 32</b></td>
                                <td>Rp 10 Juta – Rp 50 Juta, Ada gangguan tidak dapat
                                    masuk kerja Sesuai dengan baku mutu/peraturan
                                    perundangan atau berdampak ke masyarakat di sekitar
                                    area kerja perusahaan</td>
                                <td>Harus dilakukan pengendalian tambahan untuk
                                    menurunkan tingkat resiko. Pengendalian tambahan
                                    harus diterapkan dalam periode waktu tertentu.</td>
                            </tr>
                            <tr>
                                <td style="text-align: center; background-color: rgb(26, 207, 32); color: black">Risiko Kritikal</td>
                                <td style="text-align: center"><b>2 - 18</b></td>
                                <td>Ada Kerusakan dan Rp 0 - Rp 10 Juta
                                    Tidak ada peraturan yg berlaku atau berdampak
                                    kelingkungan perusahaan</td>
                                <td>Tidak diperlukan pengendalian tambahan. Diperlukan
                                    pemantauan untuk memastikan pengendalian yang ada
                                    dipelihara dan dilaksanakan.</td>
                            </tr>
                        </tbody>
                    </table>
                </table>
                <table class="w-full">
                    <div style="font-size:1rem;padding:0.200rem;background-color: #3059c1; color: rgb(255, 255, 255); text-align: center;">
                        <label style="text-align:center">CHECKLIST INSPEKSI {{ strtoupper($category) }}</label>
                    </div>
                    <tr>
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #a9a9a9; color: rgb(0, 0, 0); text-align: center;">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">HAL UNTUK DIPERIKSA</th>
                                    <th colspan="2">Kondisi Aktual</th>
                                    <th rowspan="2">Tingkat Risiko</th>
                                    <th rowspan="2">Keterangan</th>
                                </tr>
                                <tr style="background-color: #a9a9a9; color: rgb(0, 0, 0); text-align: center;">
                                    <th>Ya</th>
                                    <th>Tidak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr>
                                        <td>{{ (int) $index + 1 }}</td>
                                        <td>{{ $item->pertanyaan }}</td>
                                        <td style="text-align: center;" class="option-ya-tidak">{{ $item->jawaban == 'Ya' ? '✓' : '' }}</td>
                                        <td style="text-align: center;" class="option-ya-tidak">{{ $item->jawaban == 'Tidak' ? '✓' : '' }}</td>
                                        <td>{{ $item->resiko }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </tr>
                </table>
                <div class="margin-top">
                    <table class="w-full">
                        <table border="1" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #a9a9a9; color: rgb(0, 0, 0);">
                                    <th>Rincian Bahaya</th>
                                    <th>Perbaikan Langsung</th>
                                    <th>Dilakukan Oleh</th>
                                    <th>Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </table>

                </div>
                <div class="margin-bottom">
                    <table style="width:100%; table-layout: fixed;" class="kop">
                        <colgroup>
                            <col style="width: 20%;">
                            <col style="width: 5%;">
                            <col style="width: 25%;">
                            <col style="width: 10%;">
                            <col style="width: 15%;">
                            <col style="width: 25%;">
                        </colgroup>
                        <tr class="itemKop">
                            <td style="text-align:left;">Diinspeksi Oleh</td>
                            <td style="text-align:left; word-wrap: break-word; overflow-wrap: break-word;">: {{ $data->diinspeksi_oleh }}</td>
                            <td style="text-align:left;">Tanda Tangan</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:left;">Tanggal</td>
                            <td style="text-align:left;">:</td>
                        </tr>
                        <tr class="itemKop">
                            <td style="text-align:left;">Diinspeksi Ulang Oleh</td>
                            <td style="text-align:left; word-wrap: break-word; overflow-wrap: break-word;">: {{ $data->diinspeksi_ulang_oleh }}</td>
                            <td style="text-align:left;">Tanda Tangan</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:left;">Tanggal</td>
                            <td style="text-align:left;">:</td>
                        </tr>
                        <tr class="itemKop">
                            <td style="text-align:left;">Mengetahui</td>
                            <td style="text-align:left; word-wrap: break-word; overflow-wrap: break-word;">: {{ $data->mengetahui }}</td>
                            <td style="text-align:left;">Tanda Tangan</td>
                            <td style="text-align:left;">:</td>
                            <td style="text-align:left;">Tanggal</td>
                            <td style="text-align:left;">:</td>
                        </tr>
                    </table>
                </div>
            </div>
        <div class="footer"></div>
    </table>

    @endforeach
</body>
</html>
