@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Smart PICA</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="row px-3 mb-3">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Step Not Yet</p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['Step Not Yet']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                                        <i class="fas fa-calendar-alt text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Not Any Progres</p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['Not Any Progres']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                                        <i class="fas fa-times-circle text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">On Progress</p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['On Progress']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                                        <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Closed</p>
                                                    <h2 class="fw-bolder">{{ $dataCharts['Closed']['count'] }}</h2>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                                        <i class="fas fa-check-circle text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card shadow border">
                                <div class="card-header px-2 py-3">
                                    <h6 class="text-capitalize ps-3">Perbandingan Status</h6>
                                </div>
                                <div class="card-body p-3">
                                    <canvas id="chart-status" class="chart-canvas" height="300px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <a href="{{ route('add-smart-pica') }}"><button class="btn btn-primary ms-auto uploadBtn">
                                Add PICA</button></a>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="dataListFormPica" data-toggle="table" data-ajax="dataListFormPicaGenerateData"
                            data-query-params="dataListFormPicaParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="nodocpica">
                            <thead>
                                <tr>
                                    <th data-field="nodocpica" data-align="left" data-halign="text-center"
                                        data-sortable="true">No. Document
                                    </th>
                                    <th data-field="status" data-formatter="statusFormater" data-align="center"
                                        data-halign="center" data-sortable="true">Status
                                    </th>
                                    <th data-field="tahun_bulan" data-align="center" data-halign="center">Date</th>
                                    <th data-field="site" data-align="center" data-halign="center">Site</th>
                                    <th data-field="kp_name" data-align="left" data-halign="center">Kategori</th>
                                    <th data-field="problem" data-align="left" data-halign="center">Problem</th>
                                    {{-- <th data-field="lea_name" data-align="left" data-halign="center">KPI</th> --}}
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListFormPicaActionFormater">Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script type="text/javascript">
        var elChartStatus = document.getElementById("chart-status").getContext("2d");
        new Chart(elChartStatus, {
            type: "pie",
            data: {
                labels: ['Step Not Yet', 'Not Any Progres', 'On Progress', 'Closed'],
                datasets: [{
                    label: "Projects",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 2,
                    hoverOffset: 4,
                    backgroundColor: ['#49a3f1', '#EF5350', '#FFA726', '#66BB6A'],
                    data: [
                        {{ $dataCharts['Step Not Yet']['percentage'] }},
                        {{ $dataCharts['Not Any Progres']['percentage'] }},
                        {{ $dataCharts['On Progress']['percentage'] }},
                        {{ $dataCharts['Closed']['percentage'] }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(item) {
                                return item.label + ' : ' + item.parsed + '%';
                            }
                        }
                    }
                },
            },
        });

        function dataTableDateFormater(value, row, index) {
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var t = new Date(value);
            return t.getDate() + '-' + monthNames[t.getMonth()] + '-' + t.getFullYear();

        }

        function statusFormater(value, row, index) {
            if (value == 1) {
                return `<button type="button" class="btn btn-primary btn-sm">Step Not Yet</button>`
            } else if (value == 2) {
                return `<button type="button" class="btn btn-danger btn-sm">Not Any Progress</button>`
            } else if (value == 3) {
                return `<button type="button" class="btn btn-warning btn-sm">On Progress</button>`
            } else if (value == 4) {
                return `<button type="button" class="btn btn-success btn-sm">Closed</button>`
            } else {
                return `<button type="button" class="btn btn-secondary btn-sm">?</button>`
            }
        }

        function dataListFormPicaActionFormater(value, row, index) {
            console.log(row);
            let data = `
                    <button onclick="RedirectViewPica(this)"><a class="like"  title="Like">
                        <i class="fa fa-eye"></i> View
                    </a></button>
                `
            if (row.status == 1) {
                data += `<button onclick="redirectToAddStepPica(this)"><a class="like" title="Like">
                        <i class="fa fa-plus"></i> Step
                    </a></button>`
            }
            return data;
        }

        function redirectToAddStepPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/smart-pica/create-step/" + $('#dataListFormPica').bootstrapTable('getData')[indexDt]
                .nodocpica;
        }

        function dataListFormPicaParamsGenerate(params) {

            params.search = {
                'CARNAME': "",
            };

            if (params.sort == undefined) {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search
                }
            }
            return params;
        }

        function RedirectViewPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/smart-pica/view-data-detail-pica/" + $('#dataListFormPica').bootstrapTable('getData')[indexDt]
                .nodocpica
        }

        function dataListFormPicaSearchGenerate(obj) {
            $('#dataListFormPica').bootstrapTable('refresh');
            $("#dataListFormPica").bootstrapTable("uncheckAll");
        }

        function dataListFormPicaGenerateData(params) {
            var url = '/helper/data-pica'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
@endsection
