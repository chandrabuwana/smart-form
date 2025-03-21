@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">FORM BSS-FRM-LOG-037 PEMAKAIAN SOLAR (LOG SHEET)</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Dibuat Oleh : <span id="requestor">{{$data['dibuat_oleh']}}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="">
                        <div class="row gx-4">
                            <div class="row">
                                <div class="card col-md-6">
                                    <table class="w-full was-validated">
                                        <tr>
                                            <!-- <td>No. Doc</td>
                                            <td>:</td> -->
                                            <td id="noDoc" hidden>{{$data['no_doc']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>
                                                {{ $data['tgl_dibuat'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shift</td>
                                            <td>:</td>
                                            <td>
                                                {{ $data['shift'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pilih Atasan Langsung</td>
                                            <td>:</td>
                                            <td>
                                                {{ $data['disetujui_oleh'] }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="card col-md-6">
                                    <table class="w-full was-validated">
                                        <tr>
                                            <td>No. Fuel Station / Fuel Truck</td>
                                            <td>:</td>
                                            <td>
                                                {{ $data['fuel'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Job Site</td>
                                            <td>:</td>
                                            <td>
                                                {{ $data['site'] }}
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                        </div>

                        <div class="table-responsive">
                            <table id="item-pemakaian" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="kode_unit">Kode Unit</th>
                                        <th data-field="jam">Jam</th>
                                        <th data-field="awal">Awal</th>
                                        <th data-field="akhir">Akhir</th>
                                        <th data-field="total_liter">Total (Liter)</th>
                                        <th data-field="nama_operator">Nama Operator</th>
                                        <th data-field="km">KM</th>
                                        <th data-field="hm">HM</th>
                                        <th data-field="keterangan">KET</th>
                                    </tr>
                                </thead>
                            </table>
                            <table>
                              <tr>
                                <td style="width:10%">Stok Awal</td>
                                <td style="width:10%">
                                    {{ $data['stok_awal'] }}
                                </td>
                                <td style="width:80%">Liter</td>
                              </tr>
                              <tr>
                                <td>Masuk :</td>
                                <td>
                                    {{ $data['masuk'] }}
                                </td>
                                <td>Liter</td>
                              </tr>
                              <tr>
                                <td>Keluar</td>
                                <td>
                                    {{ $data['total_pakai'] }}
                                </td>
                                <td>Liter</td>
                              </tr>
                              <tr>
                                <td>Stok Akhir</td>
                                <td>
                                    {{ $data['stok_akhir'] }}
                                </td>
                                <td>Liter</td>
                              </tr>
                            </table>
                            <!-- <div class="col-md-4 col-lg-2">
                                <div class="input-group input-group-static mb-4">
                                    <label for="tTotals">Keluar : </label>
                                    <span id="tTotals">Liter
                                </div>
                            </div> -->
                            <!-- <div class="col-md-4 col-lg-2">
                                <div class="input-group input-group-static mb-4">
                                    <label for="tTotalPemakaian">Total Pemakaian : </label>
                                    <span id="tTotalPemakaian">
                                </div>
                            </div> -->
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" style="margin:5px" id="btnApprove">
                                <i class="fas fa-check"></i>
                                Approve
                            </button>
                            <button class="btn btn-warning ms-auto uploadBtn" style="margin:5px" id="btnReject">
                                <i class="fas fa-close"></i>
                                Reject
                            </button>
                            <a href="{{url()->previous()}}" class="btn btn-success" style="margin:5px"><i class="fas fa-cancel"></i> Cancel</a>
                        </div>
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
        var tglNow = new Date()
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_romawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

        var btnSubmitPemakaianSolar = $("#btnSubmitPemakaianSolar");
        var $table = $("#item-pemakaian");
        var $buttonTambah = $("#btn-add-item")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tTglDibuat = $("#tTglDibuat");
        var iForeman = $("#iForeman")
        var dApproved = $("#dApproved")
        var iJobSite = $("#iJobSite")
        var iFuel = $("#iFuel")
        var iShift = $("#iShift")
        
        // Variable items
        var iKodeUnit = $("#iKodeUnit")
        var iJam = $("#iJam")
        var iAwal = $("#iAwal")
        var tStokAwal = $("#tStokAwal")
        var tMasuk = $("#tMasuk")
        var iAkhir = $("#iAkhir")
        var iTotalLiter = $("#iTotalLiter")
        var tTotalPemakaian = $("#tTotalPemakaian")
        var tTotals = $("#tTotals")
        var tTotalAkhir = $("#tTotalAkhir")
        var iNamaOperator = $("#iNamaOperator")
        var btnApprove = $("#btnApprove");
        var btnCancel = $("#btnCancel");
        var iKm = $("#iKm")
        var iHm = $("#iHm")
        var iKet = $("#iKet")

        var dataPemakaianSolar = {
            formName: "Pemakaian Solar",
            jobSite: "",
            noDoc: "",
            status: "",
            approval: "",
            shift: "",
            total_pemakaian: "",
            stokAwal: "",
            stokAkhir: "",
            masuk: "",
            fuel: "",
            
            item: [{}]
        }

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function totalHarga(value, row, index) {
            return row.qty * row.price;
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-AR/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
        }

        function validateInput() {

        }

        function calculateTotalPrice(e) {
            var total = (estimatedIdr.val() * calculatedIdr.text()) + (estimatedUsd.val() * calculatedUsd.text()) + (estimatedCny.val() * calculatedCny.text());

            return total
        }

        function actionFormatter(value, row, index) {
            return `
                <a class="btn btn-danger btn-sm" onclick="deleteRow(${index})">Delete</a>
            `;
        }

        function deleteRow(id) {
            $table.bootstrapTable('remove', {
                field: '$index',
                values: [id]
            })
        }

        $table.on('post-body.bs.table', function(data) {
            var idr = 0;
            var usd = 0;
            var cny = 0;
            var items = [];
            data.sender.data.forEach(function (item, index, arr) {
                console.log(item)
                item.no = index;
                items.push(item)
            })
            dataPemakaianSolar.item = items
        })
        var isError = {
            error: {{ Illuminate\Support\Js::from($error) }},
            errorMessage: {{ Illuminate\Support\Js::from($errorMessage) }}
        }

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        $(function() {

            iAkhir.change(function(e) {
                iTotalLiter.text((iAkhir.val()) - (iAwal.val() ))
            });

            tStokAwal.change(function(e) {
                tTotalAkhir.text((tStokAwal.val()) - (parseInt(tTotals.text())))
            });
            
            if(isError.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: isError.errorMessage,
                }).then((result) => {

                })
            } else {
                var detial = {{ Illuminate\Support\Js::from($detail) }}
                console.log({{ Illuminate\Support\Js::from($data) }})
                detial.forEach(element => {
                    $table.bootstrapTable('append', element)
                });
                
                iFuel.val({{ Illuminate\Support\Js::from( $data['fuel']) }})

                dataPemakaianSolar.fuel = iFuel.val()

            }

            btnApprove.click(function(e) {
                e.preventDefault();
                
                    var dataReq = {
                        noDoc: noDoc.text(),
                        status: "Approved"
                    }
                    let formData = new FormData();

                    formData.append('item',JSON.stringify(dataPemakaianSolar.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    // TODO
                    axios.post('/bss-form/log/submit-approve-pemakaian-solar?no_doc='+noDoc.text(), formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        console.log(response.data)
                        showLoading()
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil diApprove!',
                                // text: response.data.data,
                            }).then((result) => {
                                window.location.href = `/bss-form/log/pemakaian-solar`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function() {
                        stopLoading()
                    })
                // submitAssetRequest(dataReq);
            })
        })
    </script>
@endsection
