<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM PENGELUARAN OLI, GREASE & COOLANT</title>
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
.footer {
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
    <table class="atas">
         <tr>
            <th rowspan="4"><img src="{{ ('img/logo.png') }}" alt="Bina Sarana Sukses" width="100" /></th>
            <th style="background-color: #5858eb"  colspan="3">INTEGRATED BSS EXCELLENT SYSTEM</th>
         </tr>
         <tr>
            <td>No. Dok</td>
            <td colspan="2"> BSS-FRM-LOG-034</td>
         </tr>
         <tr>
            <td>Revisi</td>
            <td colspan="2"> 1</td>
         </tr>
         <tr>
            <td>Tanggal</td>
            <td colspan="2"> 7 Agustus 2024</td>
         </tr>
         <tr>
            <td style="text-align: center"> FROM PENGELUARAN OIL, GREASE & COOLANT</td>
            <td>Halaman</td>
            <td colspan="2"> 1 dari 1</td>
         </tr>
    </table>

    <div class="margin-top">
                    <table class="products">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>UNIT</th>
                                <th>TIME</th>
                                <th>HM</th>
                                <th>JENIS</th>
                                <th>MERK</th>
                                <th>AWAL</th>
                                <th>AKHIR</th>
                                <th>QTY</th>
                                <th>COMPONENT</th>
                                <th>REMARK</th>
                                <th>PIC(NAMA)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_detail as $item)
                            <tr>
                                <td>{{ $item->nomor }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->time }}</td>
                                <td>{{ $item->hm }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->awal }}</td>
                                <td>{{ $item->akhir }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->component }}</td>
                                <td>{{ $item->remark }}</td>
                                <td>{{ $item->pic }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <tr  class="approval">
                <td>
                    <div>Dilaporkan Oleh,</div>
                </td>
                <td>
                    <div>Diketahui Oleh,</div>
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
                    <div>(_______________)</div>
                    <div>{{ $data['pelapor'] }}</div>
                </td>
                <td>
                    <div>(__________)</div>
                    <div>{{ $data['mengetahui'] }}</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="footer">
        
    </div>
    </table>
</body>

</html>