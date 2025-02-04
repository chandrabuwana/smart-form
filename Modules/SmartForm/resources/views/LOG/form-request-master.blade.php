@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">FORM BSS-FRM-LOG-002 REQUEST MASTER</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <form action="">
                        <div class="row gx-4">
                            <div class="row">
                                <div class="card col-md-6">
                                    <table class="w-full">
                                        <tr>
                                            <td>No. Doc</td>
                                            <td>:</td>
                                            <td id="noDoc">No.Doc</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td id="tglDoc"></td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="card col-md-6">
                                    <table class="w-full">
                                        <tr>
                                            <td>Pilih Approval</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iApproval" name="iApproval">
                                                    <option value="" selected>-- Pilih Approval --</option>
                                                    <option value="Planner HO">Planner HO</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Site</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iSite" name="iSite">
                                                    <option selected value="">-- Pilih Site --</option>
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
                                            <label for="iKodeMaster">Kode Master</label>
                                            <input type="text" class="form-control" id="iKodeMaster" name="iKodeMaster">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPartName">Part Name</label>
                                            <input type="text" class="form-control" id="iPartName" name="iPartName">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iUom">UoM</label>
                                            <input type="text" class="form-control" id="iUom" name="iUom">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPartNumber">Part Number</label>
                                            <input type="text" class="form-control" id="iPartNumber" name="iPartNumber">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iBrand">Brand</label>
                                            <input type="text" class="form-control" id="iBrand" name="iBrand">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iGen">Gen/ITC</label>
                                            <input type="text" class="form-control" id="iGen" name="iGen">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iModel">Model</label>
                                            <input type="text" class="form-control" id="iModel" name="iModel">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iCompartemen">Compartemen</label>
                                            <input type="text" class="form-control" id="iCompartemen" name="iCompartemen">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iFff">FFF Class</label>
                                            <input type="text" class="form-control" id="iFff" name="iFff">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPlanMat">Plan Material Status</label>
                                            <input type="text" class="form-control" id="iPlanMat" name="iPlanMat">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iMrp">MRP Type</label>
                                            <input type="text" class="form-control" id="iMrp" name="iMrp">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iScrap">SCRAP</label>
                                            <input type="text" class="form-control" id="iScrap" name="iScrap">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iMatType">Material Type</label>
                                            <input type="text" class="form-control" id="iMatType" name="iMatType">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iMatGroup">Material Group</label>
                                            <input type="text" class="form-control" id="iMatGroup" name="iMatGroup">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iVal">Valuation Class</label>
                                            <input type="text" class="form-control" id="iVal" name="iVal">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <button id="btn-add-item" class="btn btn-primary">Tambah</button>                                            
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="item-master" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="kodeMaster">Kode Master</th>
                                        <th data-field="partName">Part Name</th>
                                        <th data-field="uom">UoM</th>
                                        <th data-field="partNumber">Part Number</th>
                                        <th data-field="brand">Brand</th>
                                        <th data-field="gen">Gen/ITC</th>
                                        <th data-field="model">Model</th>
                                        <th data-field="compartement">Compartement</th>
                                        <th data-field="fffC">FFF Class</th>
                                        <th data-field="planMatStatus">Plan Material Status</th>
                                        <th data-field="mrpType">MRP TYPE</th>
                                        <th data-field="scrap">SCRAP</th>
                                        <th data-field="matType">Material Type</th>
                                        <th data-field="matGroup">Material Group</th>
                                        <th data-field="valuationStatus">Valuation Status</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitRequestMaster">
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

        var btnSubmitRequestMaster = $("#btnSubmitRequestMaster");
        var $table = $("#item-master");
        var $buttonTambah = $("#btn-add-item")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var iApproval = $("#iApproval")
        var iSite = $("#iSite")
        
        // Variable items
        var iKodeMaster = $("#iKodeMaster")
        var iPartName = $("#iPartName")
        var iUom = $("#iUom")
        var iPartNumber = $("#iPartNumber")
        var iBrand = $("#iBrand")
        var iGen = $("#iGen")
        var iModel = $("#iModel")
        var iCompartemen = $("#iCompartemen")
        var iFff = $("#iFff")
        var iPlanMat = $("#iPlanMat")
        var iMrp = $("#iMrp")
        var iScrap = $("#iScrap")
        var iMatType = $("#iMatType")
        var iMatGroup = $("#iMatGroup")
        var iVal = $("#iVal")

        var dataRequestMaster = {
            formName: "Request Master",
            noDoc: "",
            tglDoc: "",
            site: "",
            approval: "",
            
            item: [{}]
        }

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        tanggalSekarang.attr('min', getTodayDate())

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-FRM-LOG-002/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
        }

        function validateInput() {

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

        function submitRequestMaster(data) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                url: "bss-form/log/add-request-master",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {

                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                    console.log()
                }
            })
        }

        $table.on('post-body.bs.table', function(data) {
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
            dataRequestMaster.item = items
        })

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        $(function() {
            noDoc.text(generateNoDoc())
            tglDoc.text(formatTgl() || "-")

            dataRequestMaster.approval = iApproval.val()
            dataRequestMaster.site = iSite.val()

            function validateItem() {
                var errorValidate = []

                if(iKodeMaster.val() == "") {
                    errorValidate.push({
                        field: "Kode Master",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPartName.val() == "") {
                    errorValidate.push({
                        field: "Part Name",
                        message: "tidak boleh kosong"
                    })
                }
                if(iUom.val() == "") {
                    errorValidate.push({
                        field: "UoM",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPartNumber.val() == "") {
                    errorValidate.push({
                        field: "Part Number",
                        message: "tidak boleh kosong"
                    })
                }
                if(iBrand.val() == "") {
                    errorValidate.push({
                        field: "Brand",
                        message: "tidak boleh kosong"
                    })
                }
                if(iGen.val() == "") {
                    errorValidate.push({
                        field: "Gen",
                        message: "tidak boleh kosong"
                    })
                }
                if(iModel.val() == "") {
                    errorValidate.push({
                        field: "Model",
                        message: "tidak boleh kosong"
                    })
                }
                if(iCompartemen.val() == "") {
                    errorValidate.push({
                        field: "Compartement",
                        message: "tidak boleh kosong"
                    })
                }
                if(iFff.val() == "") {
                    errorValidate.push({
                        field: "FFF Class",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPlanMat.val() == "") {
                    errorValidate.push({
                        field: "Plan material",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMrp.val() == "") {
                    errorValidate.push({
                        field: "MRP",
                        message: "tidak boleh kosong"
                    })
                }
                if(iScrap.val() == "") {
                    errorValidate.push({
                        field: "Scrap",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMatType.val() == "") {
                    errorValidate.push({
                        field: "Material type",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMatType.val() == "") {
                    errorValidate.push({
                        field: "Material Type",
                        message: "tidak boleh kosong"
                    })
                }
                if(iVal.val() == "") {
                    errorValidate.push({
                        field: "Valuation status",
                        message: "tidak boleh kosong"
                    })
                }
                return errorValidate
            }

            function validateForm() {
                var errorValidate = []
                
                if(iApproval.val() == ""){
                    errorValidate.push({
                        field: "Request approval",
                        message: "Harus dipilih"
                    })
                }
                if(iSite.val() == ""){
                    errorValidate.push({
                        field: "Site",
                        message: "Harus dipilih"
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
                    })
                } else {
                    $table.bootstrapTable('append', {
                        kodeMaster: iKodeMaster.val(),
                        partName: iPartName.val(),
                        uom: iUom.val(),
                        partNumber: iPartNumber.val(),
                        brand: iBrand.val(),
                        gen: iGen.val(),
                        model: iModel.val(),
                        compartement: iCompartemen.val(),
                        fffC: iFff.val(),
                        planMatStatus: iPlanMat.val(),
                        mrpType: iMrp.val(),
                        scrap: iScrap.val(),
                        matType: iMatType.val(),
                        matGroup: iMatGroup.val(),
                        valuationStatus: iVal.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitRequestMaster.click(function(e) {
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
                    })
                } else {
                    var dataReq = {
                        formName: dataRequestMaster.formName,
                        noDoc: noDoc.text(),
                        tglDoc: formatTgl(),
                        site: iSite.val(),
                        disetujuiOleh: iApproval.val()
                    }
                    let formData = new FormData();
                    formData.append('item',JSON.stringify(dataRequestMaster.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    console.log(dataReq)
                    axios.post('/bss-form/log/add-request-master', formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        showLoading()
                        console.log(response.data)
                        Swal.fire({
                                icon: 'success',
                                title: 'Request sukses direkam dgn no dokumen:',
                                text: response.data.data.no_doc,
                            }).then((result) => {
                                window.location.href = `/bss-form/log/request-master`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                        stopLoading()
                    })
                    .finally(function() {
                        stopLoading()
                    });
                }
                
            })
        })
    </script>
@endsection
