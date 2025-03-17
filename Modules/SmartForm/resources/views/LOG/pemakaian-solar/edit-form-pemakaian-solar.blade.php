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
                                            <td id="noDoc" hidden>No.Doc</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" id="tTglDibuat" name="tTglDibuat" value="{{ $data['tgl_dibuat'] }}"  class="form-control" disabled>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shift</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iShift" name="iShift" required>
                                                    <option value="" selected>-- Pilih Shift --</option>    
                                                    <option value="DS">DS</option>
                                                    <option value="NS">NS</option>
                                                </select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pilih Atasan Langsung</td>
                                            <td>:</td>
                                            <td>
                                                
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
                                                <input type="text" class="form-control" id="iFuel" name="iFuel" value="{{ $data['fuel'] }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Job Site</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iJobSite" name="iJobSite" required>
                                                    <option selected value="">-- Pilih Job Site --</option>
                                                    <option value="AGM">AGM</option>
                                                    <option value="MBL">MBL</option>
                                                    <option value="MME">MME</option>
                                                    <option value="MAS">MAS</option>
                                                    <option value="PMSS">PMSS</option>
                                                    <option value="TAJ">TAJ</option>
                                                    <option value="BSSR">BSSR</option>
                                                    <option value="TDM">TDM</option>
                                                    <option value="MSJ">MSJ</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </div>
                        </div>

                        <div class="my-3">
                            <div class="mb-1">
                                <label class="form-label">ITEM</label>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iKodeUnit">Kode Unit</label>
                                            <input type="text" class="form-control" id="iKodeUnit" name="iKodeUnit" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iJam">Jam</label>
                                        <input type="time" class="form-control" id="iJam" name="iJam" required>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iAwal">Flow Meter Awal</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iAwal" name="iAwal" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iAkhir">Flow Meter Akhir</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iAkhir" name="iAkhir" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iTotalLiter">Total Liter : </br></label>
                                            <span style="font-size: 14px" id="iTotalLiter">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iNamaOperator">Nama Operator</label>
                                            <input type="text" class="form-control" id="iNamaOperator" name="iNamaOperator" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iKm">KM</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iKm" name="iKm" required>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iHm">HM</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iHm" name="iHm" required>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iKet">Keterangan</label>
                                            <input type="text" class="form-control" id="iKet" name="iKet">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <button id="btn-add-item" class="btn btn-primary" onclick="ClearFields();">Tambah</button>                                            
                                        </div>
                                    </div>
                                </div>

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
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                            <table>
                              <tr>
                                <td style="width:10%">Stok Awal</td>
                                <td style="width:10%"><input type="number"  onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tStokAwal" name="tStokAwal" placeholder=": ................." required>
                                </td>
                                <td style="width:80%">Liter</td>
                              </tr>
                              <tr>
                                <td>Masuk :</td>
                                <td><input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tMasuk" placeholder=": ................." name="tMasuk" required>
                                </td>
                                <td>Liter</td>
                              </tr>
                              <tr>
                                <td>Keluar</td>
                                <td><span id="tTotals">
                                </td>
                                <td>Liter</td>
                              </tr>
                              <tr>
                                <td>Stok Akhir</td>
                                <td><span id="tTotalAkhir">
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
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
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
        var iKm = $("#iKm")
        var iHm = $("#iHm")
        var iKet = $("#iKet")

        var dataPemakaianSolar = {
            formName: "Pemakaian Solar",
            noDoc: "",
            tglDoc: "",
            approval: "",
            jobSite: "",
            fuel: "",
            shift: "",
            
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
                // console.log(item)
                if(item.currency == "IDR") {
                    idr = idr + parseInt(item.price) * item.qty
                }
                if(item.currency == "USD") {
                    usd = usd + parseInt(item.price) * item.qty
                }
                if(item.currency == "CNY") {
                    cny = cny + parseInt(item.price) * item.qty
                }
                item.no = index;
                items.push(item)
            })
            dataAssetRequest.item = items
            calculatedIdr.text(idr)
            calculatedUsd.text(usd)
            calculatedCny.text(cny)
            // console.log("estimatedIdr : ", estimatedIdr.val())
            totalPrice.text((parseInt(estimatedIdr.val()) * idr) + (parseInt(estimatedUsd.val()) * usd) + (parseInt(estimatedCny.val()) * cny) || "-")
            // console.log("IDR = ", idr)
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
                tTglDibuat.val({{ Illuminate\Support\Js::from( $data['tgl_dibuat']) }})

                dataPemakaianSolar.fuel = iFuel.val()

            }

            function validateItem() {
                var errorValidate = []

                if(inputType.val() == "") {
                    errorValidate.push({
                        field: "Type",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputCondition.val() == "") {
                    errorValidate.push({
                        field: "Condition",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputQty.val() == "") {
                    errorValidate.push({
                        field: "QTY",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputUom.val() == "") {
                    errorValidate.push({
                        field: "UOM",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputCurrency.val() == "") {
                    errorValidate.push({
                        field: "Currency",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputPrice.val() == "") {
                    errorValidate.push({
                        field: "Price",
                        message: "Tidak boleh kosong"
                    })
                }

                return errorValidate
            }

            function validateForm() {
                var errorValidate = []

                if(!checkAdditional.checked && !checkReplacement.checked){
                    errorValidate.push({
                        field: "Replacement / Additional",
                        message: "harus dipilih"
                    })
                }
                if(!checkBudgeted.checked && !checkNotBudgeted.checked){
                    errorValidate.push({
                        field: "Budgeted / Not Budgeted",
                        message: "harus dipilih"
                    })
                }
                if(checkNotBudgeted.checked && inputPendukungReason.files.length < 1) {
                    errorValidate.push({
                        field: "Dokumen Pendukung",
                        message: "tidak boleh kosong jika Not Budgeted"
                    })
                }
                if(inputDepartment.val() == ""){
                    errorValidate.push({
                        field: "Department Requestor",
                        message: "tidak boleh kosong"
                    })
                }
                if(inputProject.val() == ""){
                    errorValidate.push({
                        field: "Project/Site Requestor",
                        message: "tidak boleh kosong"
                    })
                }
                if(inputDepartmentAllocation.val() == ""){
                    errorValidate.push({
                        field: "Department Allocation",
                        message: "tidak boleh kosong"
                    })
                }
                if(inputProjectAllocation.val() == ""){
                    errorValidate.push({
                        field: "Project/Site Allocation",
                        message: "tidak boleh kosong"
                    })
                }
                if(reasonpurchase.val() == ""){
                    errorValidate.push({
                        field: "Reason for Purchase",
                        message: "tidak boleh kosong"
                    })
                }
                if(estimatedReadyAtSite.val() == ""){
                    errorValidate.push({
                        field: "Estimated ready",
                        message: "tidak boleh kosong"
                    })
                }
                if(estimatedReadyAtSite.val() < getTodayDate()){
                    errorValidate.push({
                        field: "Estimated ready at site",
                        message: "tidak boleh back date"
                    })
                }
                if($table.bootstrapTable('getData').length < 1) {
                    errorValidate.push({
                        field: "Item",
                        message: "minimal harus ada 1"
                    })
                }

                return errorValidate
            }

            $buttonTambah.click(function (e) {
                e.preventDefault()
                var errorValidate = validateItem()
                
                var msg = "";
                if(errorValidate.length > 0) {
                    for (var listErr of errorValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    }).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                } else {
                    $table.bootstrapTable('append', {
                        type: inputType.val(),
                        model: inputModel.val(),
                        brand: inputBrand.val(),
                        condition: inputCondition.val(),
                        qty: inputQty.val(),
                        uom: inputUom.val(),
                        currency: inputCurrency.val(),
                        price: inputPrice.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitAssetRequest.click(function(e) {
                e.preventDefault();
                var errValidate = validateForm()
                if(errValidate.length > 0) {
                    var msg = ""
                    for (var listErr of errValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    }).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                } else {
                    var dataReq = {
                        formName: dataAssetRequest.formName,
                        // area: inputArea.val(),
                        noDoc: noDoc.text(),
                        tglDoc: formatTgl(),
                        replacement: checkReplacement.checked,
                        additional: checkAdditional.checked,
                        budgeted: checkBudgeted.checked,
                        notBudgeted: checkNotBudgeted.checked,
                        department: inputDepartment.val(),
                        project: inputProject.val(),
                        departmentAllocation: inputDepartmentAllocation.val(),
                        projectAllocation: inputProjectAllocation.val(),
                        // area: inputArea.val(),
                        reasonPurchase: reasonpurchase.val(),
                        estimatedReadyAtSite: estimatedReadyAtSite.val(),
                        estimatedIdr: estimatedIdr.val(),
                        estimatedUsd: estimatedUsd.val(),
                        estimatedCny: estimatedCny.val(),
                        refDoc: refDoc.val(),
                        requestedBy: requestornik.text(),
                        // item: dataAssetRequest.item,
                        totalPrice: totalPrice.text(),
                        pendukungReason: []
                    }
                    let formData = new FormData();
    
                    for (let i = 0; i < inputPendukungReason.files.length; i++) {
                        formData.append('pendukungReason[]', inputPendukungReason.files[i]);
                    }
                    formData.append('item',JSON.stringify(dataAssetRequest.item));
                    for (const key in dataReq) {
                        if(key != "pendukungReason" || key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    // TODO
                    axios.post('/bss-form/sm/submit-edit-asset-request?no_doc='+noDoc.text(), formData, {
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
                                title: 'Berhasil!',
                                text: response.data.data.no_doc,
                            }).then((result) => {
                                window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function() {
                        stopLoading()
                    })
                }
                // submitAssetRequest(dataReq);
            })
        })
    </script>
@endsection
