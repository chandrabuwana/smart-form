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
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold">No. Doc</td>
                                                <td id="noDoc">No.Doc</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Date</td>
                                                <td id="tglDoc"></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Pilih Foreman/Spv</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iForeman" name="iForeman">
                                                        <option value="">-- Pilih Submition Foreman/Spv --</option>
                                                        @forelse($users as $user)
                                                            <option value="{{ $user->NIK ?? '' }}">
                                                                {{ $user->nama ?? 'Nama tidak tersedia' }}
                                                            </option>
                                                        @empty
                                                            <option>Data karyawan tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                               
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold">No. Lube Station / Lube Truck</td>
                                                <td>
                                                    <input type="text" class="form-control" id="iLube" name="iLube" placeholder="Input no lube station">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Shift</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="iShift" name="iShift">
                                                        <option value="">-- select shift --</option>
                                                        @forelse($shifts as $code => $value)
                                                            <option value="{{ $code }}">
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data shift tidak ditemukan</option>
                                                        @endforelse
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Site</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iJobSite" name="iJobSite">
                                                        <option value="">-- select site --</option>
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
                              
                            </div>
                               
                        </div>

                        <div class="my-3">
                            <div class="card my-4">
                                <div class="card-header p-3">
                                  <h5 class="mb-0">ITEM</h5>
                                </div>
                                <div class="card-body p-3">
                                  <div class="row">
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Unit</label>
                                        <input type="text" class="form-control" id="iUnit" name="iUnit">
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Time</label>
                                        <input type="time" class="form-control" id="iTime" name="iTime">
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>HM</label>
                                        <input type="text" class="form-control" id="iHm" name="iHm">
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Jenis</label>
                                        <select class="form-control" id="iJenis" name="iJenis">
                                           @forelse($jenis as $code => $value)
                                                <option value="{{ $code }}">
                                                    {{ $value }}
                                                </option>
                                            @empty
                                                <option>Data Jenis tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Merk</label>
                                        <select class="form-control" id="iMerk" name="iMerk">
                                            @forelse($merks as $code => $value)
                                                <option value="{{ $code }}">
                                                    {{ $value }}
                                                </option>
                                            @empty
                                                <option>Data Merk tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Awal</label>
                                            <input type="number" class="form-control" id="iAwal" name="iAwal">
                                            <small id="awalError" class="text-danger d-none"></small>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label>Akhir</label>
                                            <input type="number" class="form-control" id="iAkhir" name="iAkhir">
                                            <small id="akhirError" class="text-danger d-none"></small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 col-lg-2 d-flex align-items-center">
                                      <span class="text-sm font-weight-bold">Qty: </span>
                                      <span class="text-sm ms-2" id="totalQty">-</span>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Component</label>
                                        <select class="form-control" id="iCompo" name="iCompo">
                                            @forelse($components as $code => $value)
                                                <option value="{{ $code }}">
                                                    {{ $value }}
                                                </option>
                                            @empty
                                                <option>Data Component tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Remark</label>
                                        <select class="form-control" id="iRemark" name="iRemark">
                                          <option value="" selected>-- Pilih Remark --</option> 
                                           @forelse($remarks as $code => $value)
                                                <option value="{{ $code }}">
                                                    {{ $value }}
                                                </option>
                                            @empty
                                                <option>Data Component tidak ditemukan</option>
                                            @endforelse
                                        </select>
                                      </div>
                                    </div>
                                    
                                    <div class="col-2">
                                      <div class="input-group input-group-static mb-4">
                                        <label>Pic / Nama</label>
                                        <select class="form-control" id="iPic" name="iPic">
                                            @forelse($users as $user)
                                                <option value="{{ $user->NIK ?? '' }}">
                                                    {{ $user->nama ?? 'Nama tidak tersedia' }}
                                                </option>
                                            @empty
                                                <option>Data karyawan tidak ditemukan</option>
                                            @endforelse
                                         </select>
                                      </div>
                                    </div>
                                    
                                    <div class="col-2 d-flex align-items-center">
                                      <button id="btn-add-item" class="btn btn-primary mb-0">
                                        <i class="material-icons text-sm">add</i> &nbsp; Tambah
                                      </button>
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

        function validateRange() {
            const awal = parseFloat(iAwal.val()) || 0;
            const akhir = parseFloat(iAkhir.val()) || 0;
            const awalError = $('#awalError');
            const akhirError = $('#akhirError');
            
            // Clear previous errors
            iAwal.removeClass('is-invalid');
            iAkhir.removeClass('is-invalid');
            awalError.addClass('d-none');
            akhirError.addClass('d-none');
            
            // Validate only if both fields have values
            if (iAwal.val() && iAkhir.val()) {
                if (awal >= akhir) {
                    iAwal.addClass('is-invalid');
                    iAkhir.addClass('is-invalid');
                    awalError.removeClass('d-none').text('Awal harus lebih kecil dari Akhir');
                    akhirError.removeClass('d-none').text('Akhir harus lebih besar dari Awal');
                    return false;
                }
                
                // Update Qty display if valid
                totalQty.text(akhir - awal);
            }
            return true;
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

            // Update the validateItem function
            function validateItem() {
                let isValid = true;
    
                // Clear previous error states
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').addClass('d-none');
                
                // Validate Unit
                if(!iUnit.val()) {
                    iUnit.addClass('is-invalid');
                    $('#unitError').removeClass('d-none');
                    isValid = false;
                }
                
                // Validate Unit
                if(iUnit.val() == "") {
                    iUnit.addClass('is-invalid');
                    iUnit.after('<div class="invalid-feedback">Unit tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Time
                if(iTime.val() == "") {
                    iTime.addClass('is-invalid');
                    iTime.after('<div class="invalid-feedback">Time tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate HM
                if(iHm.val() == "") {
                    iHm.addClass('is-invalid');
                    iHm.after('<div class="invalid-feedback">HM tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Jenis
                if(iJenis.val() == "") {
                    iJenis.addClass('is-invalid');
                    iJenis.after('<div class="invalid-feedback">Jenis harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Merk
                if(iMerk.val() == "") {
                    iMerk.addClass('is-invalid');
                    iMerk.after('<div class="invalid-feedback">Merk harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Awal
                if(iAwal.val() == "") {
                    iAwal.addClass('is-invalid');
                    iAwal.after('<div class="invalid-feedback">Awal tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Awal and Akhir
                if(!iAwal.val()) {
                    iAwal.addClass('is-invalid');
                    $('#awalError').removeClass('d-none').text('Awal tidak boleh kosong');
                    isValid = false;
                }
                
                if(!iAkhir.val()) {
                    iAkhir.addClass('is-invalid');
                    $('#akhirError').removeClass('d-none').text('Akhir tidak boleh kosong');
                    isValid = false;
                }
                
                // Only validate range if both fields have values
                if(iAwal.val() && iAkhir.val()) {
                    isValid = validateRange() && isValid;
                }
                
                // Validate Component
                if(iCompo.val() == "") {
                    iCompo.addClass('is-invalid');
                    iCompo.after('<div class="invalid-feedback">Component harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Remark
                if(iRemark.val() == "") {
                    iRemark.addClass('is-invalid');
                    iRemark.after('<div class="invalid-feedback">Remark harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate PIC
                if(iPic.val() == "") {
                    iPic.addClass('is-invalid');
                    iPic.after('<div class="invalid-feedback">PIC/Nama tidak boleh kosong</div>');
                    isValid = false;
                }
                
                return isValid;
            }

            // Update the validateForm function
            function validateForm() {
                let isValid = true;
                
                // Clear previous error states
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                
                // Validate Foreman
                if(iForeman.val() == "") {
                    iForeman.addClass('is-invalid');
                    iForeman.after('<div class="invalid-feedback">Foreman/Spv harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Lube
                if(iLube.val() == "") {
                    iLube.addClass('is-invalid');
                    iLube.after('<div class="invalid-feedback">No. Lube Station tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Shift
                if(iShift.val() == "") {
                    iShift.addClass('is-invalid');
                    iShift.after('<div class="invalid-feedback">Shift harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Job Site
                if(iJobSite.val() == "") {
                    iJobSite.addClass('is-invalid');
                    iJobSite.after('<div class="invalid-feedback">Site harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate at least one item
                if($table.bootstrapTable('getData').length < 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Minimal harus ada 1 item',
                    });
                    isValid = false;
                }
                
                return isValid;
            }

            $buttonTambah.click(function (e) {
                e.preventDefault()
                var errorValidate = validateItem()

                if(validateItem()) {
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
                    });
                    
                    // Clear form after successful addition
                    // iUnit.val('');
                    // iTime.val('');
                    // iHm.val('');
                    // iJenis.val('');
                    // iMerk.val('');
                    // iAwal.val('');
                    // iAkhir.val('');
                    // iCompo.val('');
                    // iRemark.val('');
                    // iPic.val('');
                    // totalQty.text('-');
                    
                    $table.bootstrapTable('scrollTo', 'bottom');
                }
                
                // var msg = "";
                // if(errorValidate.length > 0) {
                //     for (var listErr of errorValidate) {
                //         msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                //     }
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Gagal!',
                //         html: msg,
                //     }).then((result) => {
                //     })
                // } else {
                //     $table.bootstrapTable('append', {
                //         unit: iUnit.val(),
                //         time: iTime.val(),
                //         hm: iHm.val(),
                //         jenis: iJenis.val(),
                //         merk: iMerk.val(),
                //         awal: iAwal.val(),
                //         akhir: iAkhir.val(),
                //         qty: totalQty.text(),
                //         compo: iCompo.val(),
                //         remark: iRemark.val(),
                //         pic: iPic.val()
                //     })
                //     $table.bootstrapTable('scrollTo', 'bottom')
                // }
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
