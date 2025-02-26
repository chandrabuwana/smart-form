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
                        <h6 class="text-white text-capitalize ps-3">FORM BSS-FRM-LOG-034 PENGELUARAN OIL, GREASE & COOLANT</h6>
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
                                            <td>No. Lube Station / Lube Truck</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control" id="iLube" name="iLube" placeholder="Input no lube station">
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
                                            <td>Site</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="iJobSite" name="iJobSite">
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
                                            <label for="iUnit">Unit</label>
                                            <input type="text" class="form-control" id="iUnit" name="iUnit">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iTime">Time</label>
                                            <input  type="time" class="input-text w-full" id="iTime" name="iTime">
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iHm">HM</label>
                                            <input type="text" class="form-control" id="iHm" name="iHm">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iJenis">Jenis</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iJenis" name="iJenis">
                                            <option value="" selected>-- Pilih Jenis --</option> 
                                            <option value="COOLANT">COOLANT</option>
                                            <option value="GREASE">GREASE</option>
                                            <option value="OIL">OIL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iMerk">Merk</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iMerk" name="iMerk">
                                            <option value="" selected>-- Pilih Merk --</option> 
                                            <option value="SEIKEN COOLANT 50%">SEIKEN COOLANT 50%</option>
                                            <option value="COOLANT MULTIROAD RECO COOL">COOLANT MULTIROAD RECO COOL</option>
                                            <option value="SYCG-AF-NACDMPZ">SYCG-AF-NACDMPZ</option>
                                            <option value="COOLANT MULTIROAD RECO COOL">COOLANT MULTIROAD RECO COOL</option>
                                            <option value="S2 V220-2">S2 V220-2</option>
                                            <option value="EPX-NL 2">EPX-NL 2</option>
                                            <option value="15W-40 DH-1">15W-40 DH-1</option>
                                            <option value="EO15W/40 KGO">EO15W/40 KGO</option>
                                            <option value="RIMULA R3 MV 15W-40">RIMULA R3 MV 15W-40</option>
                                            <option value="HTCGL490">HTCGL490</option>
                                            <option value="SPIRAX S2 A 85W-140">SPIRAX S2 A 85W-140</option>
                                            <option value="SAE 10">SAE 10</option>
                                            <option value="HTC46TP">HTC46TP</option>
                                            <option value="SHELL TELLUS 46">SHELL TELLUS 46</option>
                                            <option value="RIMULA R2 30W">RIMULA R2 30W</option>
                                            <option value="S6 ATF A295">S6 ATF A295</option>
                                            <option value="75W-80">75W-80</option>
                                            <option value="TO30 KGO">TO30 KGO</option>
                                            <option value="SAE 15W/40">SAE 15W/40</option>
                                            <option value="TO30 SAE 30">TO30 SAE 30</option>
                                            <option value="T010 SAE 10">T010 SAE 10</option>
                                            <option value="SPIRAX S2 A 80W-90">SPIRAX S2 A 80W-90</option>
                                            <option value="TELUS 68">TELUS 68</option>
                                            <option value="S2 M46">S2 M46</option>
                                            <option value="RIMULA R2 10W">RIMULA R2 10W</option>
                                            <option value="KG0-H046">KG0-H046</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iAwal">Awal</label>
                                            <input type="text" class="form-control" id="iAwal" name="iAwal">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iAkhir">Akhir</label>
                                            <input type="text" class="form-control" id="iAkhir" name="iAkhir">
                                        </div>
                                    </div>
                                                                       
                                    <div class="col-md-2 col-lg-2">
                                        <label >Qty :</label>
                                        <span id="totalQty">-</span>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iCompo">Component</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iCompo" name="iCompo">
                                            <option value="" selected>-- Pilih Component --</option> 
                                            <option value="ENGINE">ENGINE</option>
                                            <option value="TRANSMISSION">TRANSMISSION</option>
                                            <option value="FINAL DRIVE LH">FINAL DRIVE LH</option>
                                            <option value="FINAL DRIVE RH">FINAL DRIVE RH</option>
                                            <option value="HYDRAULIC">HYDRAULIC</option>
                                            <option value="PTO">PTO</option>
                                            <option value="SWING">SWING</option>
                                            <option value="RADIATOR">RADIATOR</option>
                                            <option value="DAMPER">DAMPER</option>
                                            <option value="DIFFERENTIAL FRONT">DIFFERENTIAL FRONT</option>
                                            <option value="DIFFERENTIAL CENTER">DIFFERENTIAL CENTER</option>
                                            <option value="DIFFERENTIAL REAR">DIFFERENTIAL REAR</option>
                                            <option value="DIFFERENTIAL">DIFFERENTIAL</option>
                                            <option value="TRANSFER">TRANSFER</option>
                                            <option value="BRAKE COOLING">BRAKE COOLING</option>
                                            <option value="GEAR BOX">GEAR BOX</option>
                                            <option value="TRANSFER CASE">TRANSFER CASE</option>
                                            <option value="DAMPER">DAMPER</option>
                                            <option value="TANDEM RH">TANDEM RH</option>
                                            <option value="TANDEM LH">TANDEM LH</option>
                                            <option value="FRONT HUB LH">FRONT HUB LH</option>
                                            <option value="FRONT HUB RH">FRONT HUB RH</option>
                                            <option value="LUBRICATION LINE">LUBRICATION LINE</option>
                                            <option value="BRAKE">BRAKE</option>
                                            <option value="PIVOT">PIVOT</option>
                                            <option value="SUSPENSION RR RH">SUSPENSION RR RH</option>
                                            <option value="SUSPENSION RR LH">SUSPENSION RR LH</option>
                                            <option value="SUSPENSION FR RH">SUSPENSION FR RH</option>
                                            <option value="SUSPENSION FR LH">SUSPENSION FR LH</option>
                                            <option value="TRACK ADJUSTER">TRACK ADJUSTER</option>
                                            <option value="CIRCLE">CIRCLE</option>
                                            <option value="ROTARY">ROTARY</option>
                                            <option value="FINAL DRIVE FR RH">FINAL DRIVE FR RH</option>
                                            <option value="FINAL DRIVE FR LH">FINAL DRIVE FR LH</option>
                                            <option value="FINAL DRIVE RR LH">FINAL DRIVE RR LH</option>
                                            <option value="FINAL DRIVE RR RH">FINAL DRIVE RR RH</option>
                                            <option value="SWING FRONT">SWING FRONT</option>
                                            <option value="SWING REAR">SWING REAR</option>
                                            <option value="SWING RH">SWING RH</option>
                                            <option value="SWING LH">SWING LH</option>
                                            <option value="RESERVOIR">RESERVOIR</option>
                                            <option value="COMPRESOR">COMPRESOR</option>
                                            <option value="TELESCOPIC">TELESCOPIC</option>
                                            <option value="STEERING">STEERING</option>
                                            <option value="BARE SHAFT">BARE SHAFT</option>
                                            <option value="TRAVEL REDUCTION GEAR RH">TRAVEL REDUCTION GEAR RH</option>
                                            <option value="TRAVEL REDUCTION GEAR LH">TRAVEL REDUCTION GEAR LH</option>
                                            <option value="TANDEM RH">TANDEM RH</option>
                                            <option value="TANDEM LH">TANDEM LH</option>
                                            <option value="MAIN PUMP">MAIN PUMP</option>
                                            <option value="SUBTANK">SUBTANK</option>
                                            <option value="TRANSFER CASE">TRANSFER CASE</option>
                                            <option value="FIBRASI DRUM">FIBRASI DRUM</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iRemark">Remark</label>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iRemark" name="iRemark">
                                                <option value="" selected>-- Pilih Remark --</option> 
                                                <option value="ADD">ADD</option>
                                                <option value="CHANGE">CHANGE</option>
                                                <option value="GREASING">GREASING</option>
                                                <option value="REKONDISI">REKONDISI</option>
                                                <option value="BREAKDOWN">BREAKDOWN</option>
                                            </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iPic">Pic / Nama</label>
                                            <input type="text" class="form-control" id="iPic" name="iPic">
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
                            <table id="item-pengeluaran" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="unit">Unit</th>
                                        <th data-field="time">Time</th>
                                        <th data-field="hm">HM</th>
                                        <th data-field="jenis">Jenis</th>
                                        <th data-field="merk">Merk</th>
                                        <th data-field="awal">Awal</th>
                                        <th data-field="akhir">Akhir</th>
                                        <th data-formatter="flowmeter">Qty</th>
                                        <th data-field="compo">Component</th>
                                        <th data-field="remark">Remark</th>
                                        <th data-field="pic">PIC / Nama</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitPengeluaranOli">
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

        var btnSubmitPengeluaranOli = $("#btnSubmitPengeluaranOli");
        var $table = $("#item-pengeluaran");
        var $buttonTambah = $("#btn-add-item")
        var totalQty = $("#totalQty")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var iForeman = $("#iForeman")
        var iJobSite = $("#iJobSite")
        var iLube = $("#iLube")
        var iShift = $("#iShift")
        
        // Variable items
        var iUnit = $("#iUnit")
        var iTime = $("#iTime")
        var iHm = $("#iHm")
        var iJenis = $("#iJenis")
        var iMerk = $("#iMerk")
        var iAwal = $("#iAwal")
        var iAkhir = $("#iAkhir")
        var iCompo = $("#iCompo")
        var iRemark = $("#iRemark")
        var iPic = $("#iPic")

        var dataPengeluaranOli = {
            formName: "Pengeluaran Oli",
            noDoc: "",
            tglDoc: "",
            foreman: "",
            jobSite: "",
            lube: "",
            shift: "",
            totalQty: "",
            
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

        function flowmeter(value, row, index) {
            return row.akhir - row.awal;
        }

        function generateNoDoc() {
            return "_/BSS-FRM-LOG-034/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
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
                url: "bss-form/log/add-pengeluaran-oli",
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
                // totalQty.text((parseInt(iAkhir.val())) - (parseInt(iAwal.val()))||9)
                item.no = index;
                items.push(item)
            })
            dataPengeluaranOli.item = items
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

            dataPengeluaranOli.foreman = iForeman.val()
            dataPengeluaranOli.lube = iLube.val()

            iAkhir.change(function(e) {
                totalQty.text((iAkhir.val()) - (iAwal.val() ))
            });

            function validateItem() {
                var errorValidate = []

                if(iUnit.val() == "") {
                    errorValidate.push({
                        field: "Kolom unit",
                        message: "tidak boleh kosong"
                    })
                }
                if(iTime.val() == "") {
                    errorValidate.push({
                        field: "Kolom time",
                        message: "tidak boleh kosong"
                    })
                }
                if(iHm.val() == "") {
                    errorValidate.push({
                        field: "Kolom HM",
                        message: "tidak boleh kosong"
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
                if(iLube.val() == ""){
                    errorValidate.push({
                        field: "Kolom Lube",
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
                        unit: iUnit.val(),
                        time: iTime.val(),
                        hm: iHm.val(),
                        jenis: iJenis.val(),
                        merk: iMerk.val(),
                        awal: iAwal.val(),
                        akhir: iAkhir.val(),
                        qty: totalQty.text(),
                        compo: iCompo.val(),
                        remark: iRemark.val(),
                        pic: iPic.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitPengeluaranOli.click(function(e) {
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
                        formName: dataPengeluaranOli.formName,
                        noDoc: noDoc.text(),
                        jobSite: iJobSite.val(),
                        shift: iShift.val(),
                        lube: iLube.text(),
                        tglDoc: formatTgl(),
                        foreman: iForeman.val(),
                        lube: iLube.val()
                    }
                    let formData = new FormData();
                    formData.append('item',JSON.stringify(dataPengeluaranOli.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    console.log(dataReq)
                    axios.post('/bss-form/log/add-pengeluaran-oli', formData, {
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
                                window.location.href = `/bss-form/log/pengeluaran-oli`;
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
