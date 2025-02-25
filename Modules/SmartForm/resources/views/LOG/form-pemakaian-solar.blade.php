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
                        <h6 class="text-white text-capitalize ps-3">FORM BSS-FRM-LOG-037 PEMAKAIAN SOLAR (LOG SHEET)</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <form action="">
                        <div class="row gx-4">
                            <div class="row">
                                <div class="card col-md-6">
                                    <table class="w-full">
                                        <tr>
                                            <!-- <td>No. Doc</td>
                                            <td>:</td> -->
                                            <td id="noDoc" hidden>No.Doc</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td id="tglDoc"></td>
                                        </tr>
                                        <tr>
                                            <td>Pilih Foreman/Spv</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iForeman" name="iForeman">
                                                    <option value="" selected>-- Pilih Submition Foreman/Spv --</option>
                                                    <option value="Nama Foreman">13259</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="card col-md-6">
                                    <table class="w-full">
                                        <tr>
                                            <td>No. Fuel Station / Fuel Truck</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control" id="iFuel" name="iFuel" placeholder="Input no fuel station">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Shift</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iShift" name="iShift">
                                                    <option value="" selected>-- Pilih Shift --</option>    
                                                    <option value="I">I</option>
                                                    <option value="II">II</option>
                                                    <option value="III">III</option>
                                                </select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Job Site</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iJobSite" name="iJobSite">
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
                                            <input type="text" class="form-control" id="iKodeUnit" name="iKodeUnit">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iJam">Jam</label>
                                        <input type="time" class="form-control" id="iJam" name="iJam">
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iAwal">Awal</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iAwal" name="iAwal">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iAkhir">Akhir</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iAkhir" name="iAkhir">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iTotalLiter">Total Liter</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iTotalLiter" name="iTotalLiter">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iNamaOperator">Nama Operator</label>
                                            <input type="text" class="form-control" id="iNamaOperator" name="iNamaOperator">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iKm">KM</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iKm" name="iKm">
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iHm">HM</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="iHm" name="iHm">
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
                                            <button id="btn-add-item" class="btn btn-primary">Tambah</button>                                            
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
                                        <th data-field="kodeUnit">Kode Unit</th>
                                        <th data-field="jam">Jam</th>
                                        <th data-field="awal">Awal</th>
                                        <th data-field="akhir">Akhir</th>
                                        <th data-field="totalLiter">Total (Liter)</th>
                                        <th data-field="namaOperator">Nama Operator</th>
                                        <th data-field="km">KM</th>
                                        <th data-field="hm">HM</th>
                                        <th data-field="ket">KET</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitPemakaianSolar">
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
        var tglDoc = $("#tglDoc");
        var iForeman = $("#iForeman")
        var iJobSite = $("#iJobSite")
        var iFuel = $("#iFuel")
        var iShift = $("#iShift")
        
        // Variable items
        var iKodeUnit = $("#iKodeUnit")
        var iJam = $("#iJam")
        var iAwal = $("#iAwal")
        var iAkhir = $("#iAkhir")
        var iTotalLiter = $("#iTotalLiter")
        var iNamaOperator = $("#iNamaOperator")
        var iKm = $("#iKm")
        var iHm = $("#iHm")
        var iKet = $("#iKet")

        var dataPemakaianSolar = {
            formName: "Pemakaian Solar",
            noDoc: "",
            tglDoc: "",
            foreman: "",
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
        
        tanggalSekarang.attr('min', getTodayDate())

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-FRM-LOG-037/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
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
                url: "bss-form/log/add-pemakaian-solar",
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
                item.no = index;
                items.push(item)
            })
            dataPemakaianSolar.item = items
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

            dataPemakaianSolar.foreman = iForeman.val()
            dataPemakaianSolar.lube = iFuel.val()

            function validateItem() {
                var errorValidate = []

                if(iKodeUnit.val() == "") {
                    errorValidate.push({
                        field: "Kolom Kode unit",
                        message: "tidak boleh kosong"
                    })
                }
                if(iJam.val() == "") {
                    errorValidate.push({
                        field: "Kolom Jam",
                        message: "Harus dipilih"
                    })
                }
                return errorValidate
            }

            function validateForm() {
                var errorValidate = []
                
                if(iForeman.val() == ""){
                    errorValidate.push({
                        field: "Kolom Foreman",
                        message: "Harus dipilih"
                    })
                }
                if(iFuel.val() == ""){
                    errorValidate.push({
                        field: "Kolom Fuel",
                        message: "Harus diisi"
                    })
                }
                if(iShift.val() == ""){
                    errorValidate.push({
                        field: "Kolom Shift",
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
                        kodeUnit: iKodeUnit.val(),
                        jam: iJam.val(),
                        awal: iAwal.val(),
                        akhir: iAkhir.val(),
                        totalLiter: iTotalLiter.val(),
                        namaOperator: iNamaOperator.val(),
                        km: iKm.val(),
                        hm: iHm.val(),
                        ket: iKet.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitPemakaianSolar.click(function(e) {
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
                        formName: dataPemakaianSolar.formName,
                        noDoc: noDoc.text(),
                        jobSite: iJobSite.val(),
                        tglDoc: formatTgl(),
                        foreman: iForeman.val(),
                        shift: iShift.val(),
                        fuel: iFuel.val()
                    }
                    let formData = new FormData();
                    formData.append('item',JSON.stringify(dataPemakaianSolar.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    console.log(dataReq)
                    axios.post('/bss-form/log/add-pemakaian-solar', formData, {
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
                                title: 'Pemakaian Solar berhasil direkam',
                                text: response.data.data.no_doc,
                            }).then((result) => {
                                window.location.href = `/bss-form/log/pemakaian-solar`;
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
