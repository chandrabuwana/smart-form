<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN HARIAN PEMAKAIAN SOLAR (LOG SHEET)</title>
</head>
<style type="text/css">
body{
    font-family: 'Roboto Condensed', sans-serif;
}
h4 {
    margin: 0;
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
    width: 80%;
    text-align: center;
    border: 2px solid;
}
.w-seperempat {
    width: 20%;
    text-align: center;
    border: 2px solid;
}
.margin-top {
    margin-top: 1.25rem;
}
.footer{
    font-size: 0.875rem;
    padding: 1rem;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table.products {
    font-size: 0.7rem;
}
table.products tr {
    background-color: #ffff;
}
table.products th {
    color: #ffff;
    background-color: #5858eb;
    padding: 0.5rem;
    border: 1px solid;
    border-color:#000000;
}
table.products td {
    text-align: center;
    border: 1px solid;
}
table tr.items {
    background-color: #FFFF;
}
table tr.items td {
    padding: 0.3rem;
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
    font-size: 0.8rem;
}
.total {
    text-align: right;
    margin-top: 1rem;
    font-size: 0.875rem;
}
p.thick {
  font-weight: bold;
}
div.headerData {
    text-align: left;

}
table.atas th {
    color: #fff;
    border: 2px solid;
    border-color:#000000;
}
table.atas td {
    text-align: left;
    border: 2px solid;
}

</style>
<body>
    <table class="w-fullborder">
    <table class="atas">
         <tr>
            <th rowspan="4"><img src="{{ ('img/logo.png') }}" alt="Bina Sarana Sukses" width="100" /></th>
            <th style="background-color: #5858eb"  colspan="3">INTEGRATED BSS EXCELLENT SYSTEM</th>
         </tr>
         <tr>
            <td style="font-size: 0.8rem;">No. Dok</td>
            <td style="font-size: 0.8rem;" colspan="2">: {{ $data['no_dok'] }}</td>
         </tr>
         <tr>
            <td style="font-size: 0.8rem;">Revisi</td>
            <td style="font-size: 0.8rem;" colspan="2">: {{ $data['revisi'] }}</td>
         </tr>
         <tr>
            <td style="font-size: 0.8rem;">Tanggal</td>
            <td style="font-size: 0.8rem;" colspan="2">: {{ $data['tanggal'] }}</td>
         </tr>
         <tr>
            <td style="text-align: center"> LAPORAN HARIAN PEMAKAIAN SOLAR (LOG SHEET)</td>
            <td style="font-size: 0.8rem;">Halaman</td>
            <td style="font-size: 0.8rem;" colspan="2">: {{ $data['halaman'] }}</td>
         </tr>
    </table>

    <div class="margin-top">
        <table>
            <tr>
               <td style="font-size: 0.8rem; width:20%">Job Site</td>
               <td style="font-size: 0.8rem;">: {{ $data['jobsite'] }}</td>
               <td style="font-size: 0.8rem; width:25%">No Fuel Station / Fuel Truck</td>
               <td style="font-size: 0.8rem;">: {{ $data['noFuel'] }}</td>
            </tr>
            <tr>
               <td style="font-size: 0.8rem; width:20%">Hari</td>
               <td style="font-size: 0.8rem;">:</td>
               <td style="font-size: 0.8rem;">Shift</td>
               <td style="font-size: 0.8rem;">: {{ $data['shift'] }}</td>
            </tr>
            <tr>
               <td style="font-size: 0.8rem; width:20%">Tanggal</td>
               <td style="font-size: 0.8rem;">: {{ $data['tanggal'] }}</td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <thead>
                <tr>
                    <th>No</th>
                    <th>KODE UNIT</th>
                    <th>JAM</th>
                    <th>AWAL</th>
                    <th>AKHIR</th>
                    <th>TOTAL (LITER)</th>
                    <th>NAMA OPERATOR</th>
                    <th>KM</th>
                    <th>HM</th>
                    <th>KET</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_detail as $item)
                <tr>
                    <td>{{ $item->nomor }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->jam }}</td>
                    <td>{{ $item->awal }}</td>
                    <td>{{ $item->akhir }}</td>
                    <td>{{ $item->totalLiter }}</td>
                    <td>{{ $item->nama_operator }}</td>
                    <td>{{ $item->hm }}</td>
                    <td>{{ $item->hm }}</td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <table class="w-fullborder">
    <table>
            <thead>
                <tr>
                    <th style="font-size: 0.8rem; width:40%">Total Pemakaian</th>
                    <th style="font-size: 0.8rem;">:</th>
                    <th style="font-size: 0.8rem;">
                        {{ $item->totalLiter }}
                    </th>
                    <th style="font-size: 0.8rem;">L</th>
                    <th>
                        <div></div>
                    </th>
                    <th>
                        <div></div>
                    </th>
                    <th>
                        <div></div>
                    </th>
                    <th>
                        <div></div>
                    </th>
                </tr>
            </thead>
    </table>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr  class="approval">
                <td>
                    <div>Dibuat Oleh,</div>
                </td>
                <td>
                    <div>Disetujui Oleh,</div>
                </td>
                <td>
                    <div>Diketahui Oleh,</div>
                </td>
                <td>
                    <div style="text-align: left">Stock Awal</div>
                </td>
                <td>
                    <div style="text-align: left">: ..........</div>
                </td>
                <td>
                    <div style="text-align: left">Liter</div>
                </td>
            </tr>
            <tr class="approval">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <div style="text-align: left">Masuk</div>
                </td>
                <td>
                    <div style="text-align: left">: ..........</div>
                </td>
                <td>
                    <div style="text-align: left">Liter</div>
                </td>
            </tr>
            <tr class="approval">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <div style="text-align: left">Keluar</div>
                </td>
                <td>
                    <div style="text-align: left">: ..........</div>
                </td>
                <td>
                    <div style="text-align: left">Liter</div>
                </td>
            </tr>
            <tr class="approval">
                <td>
                    <div>( {{ $data['dibuat'] }} )</div>
                    <div>Fuelman</div>
                </td>
                <td>
                    <div>( {{ $data['mengetahui'] }} )</div>
                    <div>FOGC Officer</div>
                </td>
                <td>
                    <div>( {{ $data['mengetahui'] }} )</div>
                    <div>Kasi. FOGC</div>
                </td>
                <td>
                    <div style="text-align: left">Stock Akhir</div>
                </td>
                <td>
                    <div style="text-align: left">: ..........</div>
                </td>
                <td>
                    <div style="text-align: left">Liter</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="footer">
        <table>
         <tr>
            <td>Note:</td>
         </tr>
         <tr>
            <td>1. Mohon penulisan laporan ditulis dengan huruf dan angka yang jelas agar mudah dibaca.</td>
         </tr>
         <tr>
            <td>2. Form Mohon diprint menggunakan kertas carbonize 3 (tiga) rangkap2.</td>
         </tr>
         <tr>
            <td>Peruntukkan rangkap <span style="color:red">putih (logistik), rangkap merah (pengawas produksi) & rangkap kuning (admin data center)</span></td>
         </tr>
      </table>
    </div>
    </table>
</div>
</body>

</html>