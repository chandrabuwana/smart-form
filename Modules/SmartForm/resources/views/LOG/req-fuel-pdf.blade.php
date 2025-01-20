<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM PERMINTAAN FUEL</title>
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
    margin-top: 1.25rem;
}
.footer {
    font-size: 0.875rem;
    padding: 1rem;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table.products {
    font-size: 0.875rem;
}
table.products tr {
    background-color: #ffff;
}
table.products th {
    color: #000;
    padding: 0.5rem;
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
table tr.approval td {
    padding: 0.5rem;
    text-align: center;
}
.total {
    text-align: right;
    margin-top: 1rem;
    font-size: 0.875rem;
}
p.thick {
  font-weight: bold;
}
div.header {
  font-size: 105%;
  font-weight: bold;
}
div.nodok {
  font-size: 75%;
}
</style>
<body>
    <table class="w-fullborder">
    <table class="w-full">
        <tr>
            <td class="w-seperempat">
                <img src="{{ ('img/logo.png') }}" alt="Bina Sarana Sukses" width="100" />
            </td>
            <td class="w-header">
                <div class="header">FORM PERMINTAAAN PENGISIAN FUEL</div>
                <div class="header">PT BINA SARANA SUKSES</div>
                <div class="nodok">NO: BSS-FRM-LOG-022</div>
            </td>
            <td>
                <h3 class="kotak">No. Kupon : {{$data->no}}</h3>
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr> 
                <table class="w-full">
                    <tr>
                        <td class="w-seperempat">Nama</td>
                        <div>: {{$data->nama}}</div>
                    </tr>
                    <tr>
                        <td class="w-seperempat">Jabatan</td>
                        <div>: {{$data->jabatan}}</div>
                    </tr>
                    <tr>
                        <td class="w-seperempat">NIK</td>
                        <div>: {{$data->nik}}</div>
                    </tr>
                </table>
                <td class="w-half">
                    <table class="w-full">
                    <tr>
                        <td class="w-half">Departemen</td>
                        <div>: {{$data->departemen}}</div>
                    </tr>
                    <tr>
                        <td class="w-half">Tanggal</td>
                        <div>: {{$data->tanggal}}</div>
                    </tr>
                    <tr>
                        <td class="w-half">No. Lambung</td>
                        <div>: {{$data->no_lambung}}</div>
                    </tr>
                    <tr>
                        <td class="w-half">Jenis Kendaraan</td>
                        <div>: {{$data->jenis_kendaraan}}</div>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th rowspan="2">Jam</th>
                <th rowspan="2">Shift</th>
                <th rowspan="2">HM</th>
                <th rowspan="2">KM</th>
                <th colspan="2">Flowmeter</th>
                <th rowspan="2">Total Liter</th>
            </tr>
            <tr class="itemsHead">
                <th>AWAL</th>
                <th>AKHIR</th>
            </tr>
            <tr class="items">
                <td>{{$data->jam}}</td>
                <td>{{$data->shift}}</td>
                <td>{{$data->hm}}</td>
                <td>{{$data->km}}</td>
                <td>{{$data->awal}}</td>
                <td>{{$data->akhir}}</td>
                <td>{{$data->total_liter}}</td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <tr  class="approval">
                <td>
                    <div>Diserahkan Oleh,</div>
                </td>
                <td>
                    <div>Diterima Oleh,</div>
                </td>
            </tr>
            <tr class="approval">
                <td></td>
            </tr>
            <tr class="approval">
                <td></td>
            </tr>
            <tr class="approval">
                <td>
                    <div>_______________</div>
                    <div>Operator/Driver</div>
                </td>
                <td>
                    <div>_________________</div>
                    <div>Fuelman/Driver FT</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="footer">
        <p class="thick">__________________________ !!! Matikan Mesin Saat Pengisian FUEL !!! _______________________ </p>
        <div>Note: Form Mohon diprint menggunakan kertas carbonize 3 (tiga) rangkap</div>
        <div>Peruntukkan rangkap putih (logistik), rangkap merah (pengawas produksi) & rangkap kuning (admin data center)</div>
    </div>
    </table>
</body>
</html>