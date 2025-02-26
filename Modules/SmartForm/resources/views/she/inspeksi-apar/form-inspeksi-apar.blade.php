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
                        <h6 class="text-white text-capitalize ps-3">FORM BSS HE 036 INSPEKSI APAR</h6>
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
                                    </table>
                                </div>
                                
                                <div class="card col-md-6">
                                    <table class="w-full">
                                        <tr>
                                            <td>Lokasi Inspeksi</td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-select form-select-sm input-text" id="dLok1" name="dLok1">
                                                    <option value="" selected>-- Pilih Lokasi Inspeksi --</option>
                                                    <option value="Maintank">Maintank</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                        </div>

                        <div class="my-3">
                            <div class="mb-1">
                                <label class="form-label">Detail APAR</label>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="dTgl">Tanggal</label>
                                            <input type="date" class="form-control" id="dTgl" name="dTgl">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="dLok2">Lokasi APAR</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dLok2" name="dLok2">
                                            <option value="" selected>-- Pilih Lokasi APAR --</option> 
                                            <option value="MT 01">MT 01</option>
                                            <option value="MT 02">MT 02</option>
                                            <option value="MT 03">MT 03</option>
                                            <option value="MT 04">MT 04</option>
                                            <option value="MT 05">MT 05</option>
                                            <option value="MT 06">MT 06</option>
                                            <option value="HYDRAND">HYDRAND</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="dJenis">Jenis APAR</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dJenis" name="dJenis">
                                            <option value="" selected>-- Pilih Jenis APAR --</option> 
                                            <option value="Powder">Powder</option>
                                            <option value="Foam">Foam</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="dTekanan">Tekanan Tabung</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dTekanan" name="dTekanan">
                                            <option value="" selected>-- Pilih Tekanan APAR --</option> 
                                            <option value="Green">Green</option>
                                            <option value="Red">Red</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tBerat">Berat APAR (kg)</label>
                                            <input type="number" onkeypress="return event.charCode >= 48" min="1" class="form-control" id="tBerat" name="tBerat">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tPic">PIC</label>
                                            <input type="text" class="form-control" id="tPic" name="tPic">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="dMetode">Metode Pemenuhan</label>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dMetode" name="dMetode">
                                                <option value="" selected>-- Pilih Metode --</option> 
                                                <option value="Isi Ulang">Isi Ulang</option>
                                                <option value="Ganti Baru">Ganti Baru</option>
                                                <option value="Tera Ulang">Tera Ulang</option>
                                            </select>
                                        </div>
                                    </div>
                                    <fieldset class="card" style="width: 15rem;">
                                      <legend class="col-form-label">Kondisi Luar Tabung :</legend>
                                      <div class="col-sm-10">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="1" id="cTabung1">
                                          <label class="form-check-label" for="flexCheckDefault">
                                            Tabung
                                          </label>
                                          <input class="form-check-input" type="checkbox" value="1" id="cHandle">
                                          <label class="form-check-label" for="flexCheckDefault">
                                            Handle
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="1" id="cSelang">
                                          <label class="form-check-label" for="flexCheckChecked">
                                            Selang&nbsp;
                                          </label>
                                          <input class="form-check-input" type="checkbox" value="1" id="cLabel">
                                          <label class="form-check-label" for="flexCheckChecked">
                                            Label
                                          </label>
                                        </div>
                                      </div>
                                    </fieldset>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="iKet">Kartu Bukti Pemeriksaan:</label>
                                            <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="cTabung2">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Tabung
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tBerlaku">Berlaku sampai</label>
                                            <input type="date" class="form-control" id="tBerlaku" name="tBerlaku">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tKet">Keterangan</label>
                                            <input type="text" class="form-control" id="tKet" name="tKet">
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
                            <table id="item-inspeksi" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="lok2">Lokasi APAR</th>
                                        <th data-field="jenis">Jenis APAR</th>
                                        <th data-field="tekananTab">Tekanan Tabung</th>
                                        <th data-field="berat">Berat Tabung</th>
                                        <th data-field="pic">PIC Name</th>
                                        <th data-field="metode">Metode Pemenuhan</th>
                                        <th data-field="tglBerlaku">Tgl Berlaku</th>
                                        <th data-field="ket">Ket.</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-md-4 col-lg-2">
                            <div class="input-group input-group-static mb-4">
                                <label for="tCatatan">Catatan Form:</label>
                                <input type="text" class="form-control" id="tCatatan" name="tCatatan">
                            </div>
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitInspeksiApar">
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

        var btnSubmitInspeksiApar = $("#btnSubmitInspeksiApar");
        var $table = $("#item-inspeksi");
        var $buttonTambah = $("#btn-add-item")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var dLok1 = $("#dLok1")
        var tCatatan = $("#tCatatan")
        
        // Variable items
        var dLok2 = $("#dLok2")
        var dJenis = $("#dJenis")
        var dTekanan = $("#dTekanan")
        var tBerat = $("#tBerat")
        var tPic = $("#tPic")
        var dMetode = $("#dMetode")
        var tBerlaku = $("#tBerlaku")
        var dTgl = $("#dTgl")
        var tKet = $("#tKet")

        var dataInspeksiApar = {
            formName: "Inspeksi Apar",
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
            return `${day}-${month}-${year}`;
        }
        
        tanggalSekarang.attr('min', getTodayDate())

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-FRM-SHE-036/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
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

        $table.on('post-body.bs.table', function(data) {
            var items = [];
            data.sender.data.forEach(function (item, index, arr) {
                // console.log(item)
                item.no = index;
                items.push(item)
            })
            dataInspeksiApar.item = items
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

            // dataInspeksiApar.foreman = iForeman.val()

            function validateItem() {
                var errorValidate = []

                if(dLok2.val() == "") {
                    errorValidate.push({
                        field: "Kolom Lokasi APAR",
                        message: "tidak boleh kosong"
                    })
                }
                return errorValidate
            }

            function validateForm() {
                var errorValidate = []
                
                if(dLok1.val() == ""){
                    errorValidate.push({
                        field: "Kolom Lokasi Inspeksi",
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
                        lok2: dLok2.val(),
                        jenis: dJenis.val(),
                        tekananTab: dTekanan.val(),
                        berat: tBerat.val(),
                        tabung1: cTabung1.checked,
                        handle: cHandle.checked,
                        selang: cSelang.checked,
                        label: cLabel.checked,
                        tabung2: cTabung1.checked,
                        metode: dMetode.val(),
                        tglBerlaku: tBerlaku.val(),
                        pic: tPic.val(),
                        tanggal: dTgl.val(),
                        ket: tKet.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitInspeksiApar.click(function(e) {
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
                        formName: dataInspeksiApar.formName,
                        noDoc: noDoc.text(),
                        lok1: dLok1.val(),
                        tglDoc: formatTgl(),
                        catatan: tCatatan.val()
                    }
                    let formData = new FormData();
                    formData.append('item',JSON.stringify(dataInspeksiApar.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    console.log(dataReq)
                    axios.post('/bss-form/she-019B/add-inspeksi-apar', formData, {
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
                                window.location.href = `/bss-form/she-019B/inspeksi-apar`;
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
