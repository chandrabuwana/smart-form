<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM REQUEST MASTER</title>
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
    font-size: 0.5rem;
}
table.products tr {
    background-color: #ffff;
}
table.products th {
    color: #ffff;
    background-color: #00008B;
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
div.headerFormInfo {
    text-align: center;
    color: #ffff;
    background-color: #00008B;
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
            <th style="background-color: #00008B"  colspan="3">INTEGRATED BSS EXCELLENT SYSTEM</th>
         </tr>
         <tr>
            <td>No. Dok</td>
            <td colspan="2">: BSS-FRM-LOG-002</td>
         </tr>
         <tr>
            <td>Site</td>
            <td colspan="2">: </td>
            <!-- <td colspan="2">: {{ $data['site'] }}</td> -->
         </tr>
         <tr>
            <td>Tanggal</td>
            <td colspan="2">: </td>
            <!-- <td colspan="2">: {{ $data['dibuat_tgl'] }}</td> -->
         </tr>
         <tr>
            <td style="text-align: center"> FROM REQUEST CODE MATERIAL</td>
            <td>Halaman</td>
            <td colspan="2">: </td>
            <!-- <td colspan="2">: 1 dari 1</td> -->
         </tr>
    </table>

    <div class="margin-top">
                    <table class="products">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Master</th>
                                <th>Part Name</th>
                                <th>UoM</th>
                                <th>Part Number</th>
                                <th>Brand</th>
                                <th>GEN/ITC</th>
                                <!-- <th>Model</th> -->
                                <th>Compar tement</th>
                                <th>FFF Class</th>
                                <th>Plant Material Status</th>
                                <th>MRP Type</th>
                                <th>Scrap</th>
                                <th>Material Type</th>
                                <th>Material Group</th>
                                <th>Valuation Class</th>
                                <th style="background-color:#5858eb">Material Type</th>
                                <th style="background-color:#5858eb">SCRAP (Y/N)</th>
                                <th style="background-color:#FF8C00">Material Type</th>
                                <th style="background-color:#FF8C00">Material Group</th>
                                <th style="background-color:#FF8C00">Valuation Class</th>
                                <th style="background-color:#228B22">REQ</th>
                                <th style="background-color:#228B22">DATE</th>
                                <th style="background-color:#228B22">SITE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_detail as $item)
                            <tr>
                                <td>{{ $item->nomor }}</td>
                                <td>{{ $item->kodeMaster }}</td>
                                <td>{{ $item->partName }}</td>
                                <td>{{ $item->uom }}</td>
                                <td>{{ $item->partNumber }}</td>
                                <td>{{ $item->brand }}</td>
                                <td>{{ $item->gen }}</td>
                                <!-- <td>{{ $item->model }}</td> -->
                                <td>{{ $item->cmp }}</td>
                                <td>{{ $item->fC }}</td>
                                <td>{{ $item->pms }}</td>
                                <td>{{ $item->mrpT }}</td>
                                <td>{{ $item->scrap }}</td>
                                <td>{{ $item->matType }}</td>
                                <td>{{ $item->matGroup }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                                <td>{{ $item->vC }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    </div>

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
                    <div>Diproses Oleh,</div>
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
                    <div>_______________</div>
                    <div>{{ $data['dibuat_oleh'] }}</div>
                </td>
                <td>
                    <div>__________</div>
                    <div>{{ $data['disetujui_oleh'] }}</div>
                </td>
                <td>
                    <div>__________</div>
                    <div>Cataloging</div>
                </td>
                <td>
                    <div>____________</div>
                    <div>Cost Control</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="footer">
        <table>
             <tr>
                <td style="background-color: #00008B"></td>
                <td style="color:#000000">Diisi oleh Requester</td>
             </tr>
             <tr>
                <td style="background-color:#5858eb"></td>
                <td>Diisi oleh Logistik Site</td>
             </tr>
             <tr>
                <td style="background-color:#FF8C00"></td>
                <td>Diisi oleh Akunting</td>
             </tr>
          </table>
    </div>
    </table>
</body>

</html>