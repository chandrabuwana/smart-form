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
                                    <table class="w-full was-validated">
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
                                            <td>Shift</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iShift" name="iShift" required>
                                                    <option value="" disabled selected>-- Pilih Shift --</option>    
                                                    <option value="DS">DS</option>
                                                    <option value="NS">NS</option>
                                                </select> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pilih Atasan Langsung</td>
                                            <td>:</td>
                                            <td>
                                                <select name="dApproved" id="dApproved" class="form-control text-center" required>
                                                <option selected value="" disabled>-- Pilih Atasan Langsung --</option>
                                                @foreach($approvalList as $user)
                                                    <option value="{{ $user->nama }}">{{ $user->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                                                <input type="text" class="form-control" id="iFuel" name="iFuel" placeholder="Input no fuel station" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Job Site</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iJobSite" name="iJobSite" required>
                                                    <option selected value="" disabled>-- Pilih site --</option>
                                                    @forelse($sites as $site)
                                                        <option value="{{ $site->KodeST ?? '' }}">
                                                            {{ $site->KodeST ?? 'Site tidak tersedia' }}
                                                        </option>
                                                    @empty
                                                        <option>Data site tidak ditemukan</option>
                                                    @endforelse
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
        $(document).ready(function() {
            $('#dApproved').select2();
            $('#iJobSite').select2();
        });
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
            var mdf = 0;
            var totalliter = 0;
            var items = [];
            data.sender.data.forEach(function (item, index, arr) {
                // console.log(item)
                mdf = mdf + parseInt(item.akhir) - item.awal
                item.totalliter = mdf
                item.no = index;
                items.push(item)
            })
            dataPemakaianSolar.item = items
            // tTotalPemakaian.text(iTotalLiter.text() + tTotalPemakaian.text())
            tTotals.text(( mdf)|| "-")
            tTotalPemakaian.text((parseInt(iTotalLiter.text()) * mdf)|| "-")
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

            dataPemakaianSolar.approval = dApproved.val()
            dataPemakaianSolar.lube = iFuel.val()

            iAkhir.change(function(e) {
                iTotalLiter.text((iAkhir.val()) - (iAwal.val() ))
            });

            tStokAwal.change(function(e) {
                tTotalAkhir.text((tStokAwal.val()) - (parseInt(tTotals.text())))
            });

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
                if(iAwal.val() == "") {
                    errorValidate.push({
                        field: "Kolom Flow Meter Awal",
                        message: "Harus Diisi"
                    })
                }
                if(iAkhir.val() == "") {
                    errorValidate.push({
                        field: "Kolom Flow Meter Akhir",
                        message: "Harus Diisi"
                    })
                }
                if(iNamaOperator.val() == "") {
                    errorValidate.push({
                        field: "Kolom Nama Operator",
                        message: "Harus Diisi"
                    })
                }
                if(iKm.val() == "") {
                    errorValidate.push({
                        field: "Kolom KM",
                        message: "Harus Diisi"
                    })
                }
                if(iHm.val() == "") {
                    errorValidate.push({
                        field: "Kolom HM",
                        message: "Harus Diisi"
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
                if(tStokAwal.val() == "") {
                    errorValidate.push({
                        field: "Kolom Stok Awal",
                        message: "Harus Diisi"
                    })
                }
                if(tMasuk.val() == "") {
                    errorValidate.push({
                        field: "Kolom Masuk",
                        message: "Harus Diisi"
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
                        totalLiter: iTotalLiter.text(),
                        namaOperator: iNamaOperator.val(),
                        km: iKm.val(),
                        hm: iHm.val(),
                        ket: iKet.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                    document.getElementById("iAwal").value = document.getElementById("iAkhir").value;
                    document.getElementById("iKodeUnit").value=''
                    document.getElementById("iJam").value=''
                    document.getElementById("iAkhir").value=''
                    document.getElementById("iNamaOperator").value=''
                    document.getElementById("iKm").value=''
                    document.getElementById("iHm").value=''
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
                        noDoc: noDoc.val(),
                        jobSite: iJobSite.val(),
                        tglDoc: formatTgl(),
                        approval: dApproved.val(),
                        shift: iShift.val(),
                        total_pemakaian: tTotals.text(),
                        stokAwal: tStokAwal.val(),
                        stokAkhir: tTotalAkhir.text(),
                        masuk: tMasuk.val(),
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
