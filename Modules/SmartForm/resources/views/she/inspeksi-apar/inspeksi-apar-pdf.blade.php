<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INSPEKSI APAR</title>
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
table.approval td {
    padding: 0.3rem;
    font-size: 0.8rem;
    font-weight: bold;
    border: 1px solid;
}
table tr.cat td {
    padding: 0.5rem;
    border: 1px solid;
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
            <th style="background-color: #5858eb"  colspan="3">BSS SHE Management System</th>
         </tr>
         <tr>
            <td style="font-size: 0.8rem;">No. Dok</td>
            <td style="font-size: 0.8rem;" colspan="2">: BSS-FRM-SHE-036</td>
         </tr>
         <tr>
            <td style="font-size: 0.8rem;">Revisi</td>
            <td style="font-size: 0.8rem;" colspan="2">: 01</td>
         </tr>
         <tr>
            <td style="font-size: 0.8rem;">Tanggal</td>
            <td style="font-size: 0.8rem;" colspan="2">: 26 November 2022</td>
         </tr>
         <tr>
            <td style="text-align: center; font-weight: bold;"> INSPEKSI APAR</td>
            <td style="font-size: 0.8rem;">Halaman</td>
            <td style="font-size: 0.8rem;" colspan="2">: 1 dari 2</td>
         </tr>
    </table>

    <div class="margin-top">
        <table>
            <tr>
               <td style="font-size: 1rem; width:10%">Tanggal</td>
               <td style="font-size: 1rem; width:15%">: {{ $data['tgl'] }}</td>
               <td style="font-size: 1rem; width:15%">Lokasi Inspeksi</td>
               <td style="font-size: 1rem;">: {{ $data['lok1'] }}</td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <thead>
                <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Lokasi APAR</th>
            <th rowspan="2">Jenis APAR</th>
            <th rowspan="2">Berat APAR</th>
            <th rowspan="2">Tekanan Tabung</th>
            <th colspan="4">Kondisi Luar Tabung</th>
            <th colspan="2">Kartu Bukti Pemeriksaan</th>
            <th rowspan="2">Metode Pemenuhan</th>
            <th rowspan="2">PIC</th>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Keterangan</th>
         </tr>
         <tr>
            <th>Tabung</th>
            <th>Handle</th>
            <th>Label</th>
            <th>Selang</th>
            <th>Label</th>
            <th>Berlaku Sampai</th>
         </tr>
            </thead>
            <tbody>
                @foreach ($data_detail as $item)
                <tr>
                    <td>{{ $item->nomor }}</td>
                    <td>{{ $item->lok2 }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->berat }} kg</td>
                    <td>{{ $item->tekanan }}</td>

                    <td>
                        @if($item->tabung === '1')
                            <h4>OK</h4>
                        @else
                            <h4>BADE</h4>

                        @endif 
                    </td>

                    <td>
                        @if($item->handle === '1')
                            <h4>OK</h4>
                        @else
                            <h4>BADE</h4>

                        @endif 
                    </td>
                    
                    <td>
                        @if($item->label === '1')
                            <h4>OK</h4>
                        @else
                            <h4>BADE</h4>

                        @endif 
                    </td>

                    <td>
                        @if($item->selang === '1')
                            <h4>OK</h4>
                        @else
                            <h4>BADE</h4>

                        @endif 
                    </td>

                    <td>
                        @if($item->label_kartu === '1')
                            <h4>OK</h4>
                        @else
                            <h4>BADE</h4>

                        @endif 
                    </td>
                    <td>{{ $item->berlaku }}</td>
                    <td>{{ $item->metode }}</td>
                    <td>{{ $item->pic }}</td>
                    <td>{{ $item->tanggal }}</td>
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
                <th style="font-size: 0.8rem; width:40%;text-align: left;">Catatan:</th>
            </tr>
        </thead>
    </table>
    </table>

    <table class="w-full">
        <tr  class="cat">
            <td>
                <div>{{ $data['catatan'] }}</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <table class="approval">
         <tr>
            <td style="font-size: 0.8rem; width:20%">Dibuat Oleh</td>
            <td>: {{ $data['dibuat'] }}</td>
            <td>NIK :</td>
            <td>TTD :</td>
            <td>TGL :</td>
         </tr>
         <tr>
            <td>Diperiksa Oleh</td>
            <td>: {{ $data['dibuat'] }}</td>
            <td>NIK :</td>
            <td>TTD :</td>
            <td>TGL :</td>
         </tr>
         <tr>
            <td>Diketahui Oleh</td>
            <td>: {{ $data['mengetahui'] }}</td>
            <td>NIK :</td>
            <td>TTD :</td>
            <td>TGL :</td>
         </tr>
        </table>
    </div>
    </table>
</div>
</body>

</html>