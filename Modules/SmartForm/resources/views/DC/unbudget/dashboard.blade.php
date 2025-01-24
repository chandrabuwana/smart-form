@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .w-full {
            width: 100%;
        }
        legend {
            display: block;
            width: auto;
            float: none;
        }
        fieldset {
            padding: 4px 10px 8px 10px;
            margin: 0;
            width: auto;
            border: 1px solid #cccccc;
        }
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            /* margin-bottom: 15px; */
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2.select2-container{
            width: 100%;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
        .select2-selection .select2-selection--single {
            margin-bottom: 0;
        }
        .search-input {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }
        .search-input:valid {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }

        .row>* {
            padding: 0;
        }
        
        .btn-action-format {
            margin: 0;
            padding: 10px 16px;
        }
        .btn-no-action:hover {
            cursor: default;
        }
        .filter-section {
            display: flex;
            width: 100%;
            justify-content: end;
            gap: 8px;
        }
        /* .page-item .page-link {
            color: #FFFFFF;
        } */
        /* .active > .page-link {
            color: #cccccc;
        } */
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4 pb-5">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Form BA Unbudget</h6>
                </div>
            </div>
            <div class="col-6">
                <canvas id="pieChart" style="height: 400px;"></canvas>
            </div>
            <div class="col-6 mt-4">
                <h5>Total Nominal : <span id="totalNominal"></span></h5>
                <h5>Total BA : <span id="totalBA"></span></h5>
            </div>
            <div class="card-body px-0">

                <div class="table-responsive p-0 px-3">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Department</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($finalResult['bySite']); $i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $finalResult['bySite'][$i]['KodeST'] }}</td>
                                <td>{{ $finalResult['bySite'][$i]['Jumlah'] }}</td>
                                <td>{{ $finalResult['bySite'][$i]['Total'] }}</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive p-0 px-3">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Department</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < count($finalResult['byDept']); $i++)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $finalResult['byDept'][$i]['KodeDP'] }}</td>
                                <td>{{ $finalResult['byDept'][$i]['Jumlah'] }}</td>
                                <td>{{ $finalResult['byDept'][$i]['Total'] }}</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        const dataFromLaravel = {{ Illuminate\Support\Js::from($finalResult) }}
        const totalBA = dataFromLaravel.byDept.reduce((sum, item) => sum + parseFloat(item.Jumlah), 0)
        const totalNominal = dataFromLaravel.byDept.reduce((sum, item) => sum + parseFloat(item.Total), 0)
        const labels = dataFromLaravel.byDept.map(item => item.KodeDP); // ["ENG", "IT"]
        const totals = dataFromLaravel.byDept.map(item => parseFloat(item.Jumlah / totalBA * 100).toFixed(2));

        function formatRupiah(angka) {
            angka = angka.toString().replace(".", ",")
            const rupiah = angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            
            return rupiah;
        }

        function generateRandomColors(count) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(`hsl(${Math.floor(Math.random() * 360)}, 70%, 70%)`);
            }
            return colors;
        }

        const ctx = document.getElementById('pieChart').getContext('2d');
        const backgroundColors = generateRandomColors(labels.length);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels, // Label untuk setiap slice
                datasets: [{
                    label: 'Total',
                    data: totals, // Nilai total yang akan divisualisasikan
                    backgroundColor: backgroundColors,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const value = totals[tooltipItem.dataIndex];
                                return `${labels[tooltipItem.dataIndex]}: ${value}%`;
                            }
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                }
            }
        })

        $("#totalNominal").text("Rp. " + formatRupiah(totalNominal))
        $("#totalBA").text(totalBA)
    </script>
@endsection