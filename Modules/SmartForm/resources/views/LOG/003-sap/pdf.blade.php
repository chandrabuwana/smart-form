<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form BSS-FRM-BA-LOG-003 PENGAJUAN PR SAP</title>

    <style>
        body {
            font-family: Arial, "Segoe UI", sans-serif;
            margin
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
            font-size: 12px;
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
            font-size: 5px;
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
        <p class="title">BSS-FRM-BA-LOG-003 PENGAJUAN PR SAP</p>
    </div>
    <table class="container border-collapse: collapse;">
        <tr>
            <th colspan="2" rowspan="5" style="border-bottom: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </th>
            <th colspan="10" style="height:10px; background-color: #b1b1b191;">INTEGRATED BSS EXCELLENT SYSTEM</th>

        </tr>
        <tr>
            <th colspan="8" style=" text-align: center; font-weight: bold; font-size:8px;">FORM BERITA ACARA</th>
            <th>No.Doc</th>
            <th>: FRM-BA-PR-LOG-12-000</th>

        </tr>
        <tr>
            <th colspan="8" rowspan="3" style=" text-align: center;  font-size:8px;">
                PURCHASE REQUEST
            </th>

            <th>Plant</th>
            <th>Data Plant</th>


        </tr>
        <tr>

            <th>Tanggal</th>
            <th>3/24/2025</th>
        </tr>
        <tr>

            <th>Halaman</th>
            <th>1</th>
        </tr>
    </table>
    </br>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="bg-success text-white">
                <tr>
                    <th>Item of requisition</th>
                    <th>Partnumber</th>
                    <th>Material Code</th>
                    <th>Short Text</th>
                    <th>Quantity requested</th>
                    <th>Unit of Measure</th>
                    <th>Delivery Date</th>
                    <th>Plant</th>
                    <th>Storage</th>
                    <th>Requisitioner</th>
                    <th>Req. Tracking Number</th>
                    <th>Purchasing Group</th>
                    <th>Valuation Price</th>
                    <th>Release Date</th>
                    <th>Cost Center</th>
                    <th>GL ACCOUNT</th>
                </tr>
            </thead>

            <tbody>
                @if ($detailItems->count() > 0)
                    @foreach ($detailItems as $detail)
                        <tr>
                            <td>{{ $detail->item_of_requisition ?? '' }}</td>
                            <td>{{ $detail->part_number ?? '' }}</td>
                            <td>{{ $detail->material_code ?? '' }}</td>
                            <td>{{ $detail->short_text ?? '' }}</td>
                            <td>{{ $detail->qty_requested ?? '' }}</td>
                            <td>{{ $detail->uom ?? '' }}</td>
                            <td>{{ $detail->delivery_date ?? '' }}</td>
                            <td>{{ $detail->plant ?? '' }}</td>
                            <td>{{ $detail->storage ?? '' }}</td>
                            <td>{{ $detail->requisitioner ?? '' }}</td>
                            <td>{{ $detail->req_tracking_number ?? '' }}</td>
                            <td>{{ $detail->purchasing_group ?? '' }}</td>
                            <td>{{ $detail->valuation_price ?? '' }}</td>
                            <td>{{ $detail->release_date ?? '' }}</td>
                            <td>{{ $detail->cost_center ?? '' }}</td>
                            <td>{{ $detail->gl_account ?? '' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="16">Tidak ada detail item.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div style="margin-top: 10px;">
            <table style="width: 35%; border-collapse: collapse;">
                <tr>
                    <td colspan="2" style="border-top: none; border: 1px solid black;">Dibuat oleh,</td>
                    <td colspan="2" style="border-top: none; border: 1px solid black;">Disetujui oleh,</td>

                </tr>
                <tr>
                    <td colspan="2" style="height: 30px; border-bottom: none;"></td>
                    <td colspan="2" style="height: 30px; border-bottom: none;"></td>

                </tr>
                <tr>
                    <td colspan="2" style="border-top: none;">{{ $dataHeader->dibuat_oleh }}</td>
                    <td colspan="2" style="border-top: none;">{{ $dataHeader->diperiksa_oleh }}</td>

                </tr>
                <tr>
                    <td colspan="2" style="border-top: none;">Requester</td>
                    <td colspan="2" style="border-top: none;">Kabag. Dept</td>

                </tr>
            </table>

        </div>
    </div>
</body>

</html>
