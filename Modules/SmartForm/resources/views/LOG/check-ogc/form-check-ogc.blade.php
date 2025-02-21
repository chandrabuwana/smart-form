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
                        <h6 class="text-white text-capitalize ps-3">FORM BSS-FRM-LOG-031 CHECKLIST OGC COMPLIANCE</h6>
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
                        </div>

                        {{-- CHECK LIST OGC QUESTION --}}
                        {{-- W1 --}}
                        <div class="card border mt-5">
                            <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                                data-bs-toggle="collapse" data-bs-target="#collapse-w1" aria-expanded="true" aria-controls="collapse-w1">
                                <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">WEEK 1</h6>
                                    <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                                </div>
                            </a>
                            <div class="card-body collapse pb-1" id="collapse-w1">
                                <div class="table-responsive">
                                    <table data-toggle="table">
                                        <tr>
                                            <th colspan="3">LUBE STATION</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td><input class="form-check-input" type="checkbox" value="1" id="cTabung2"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>j</td>
                                            <td>Apakah Flow Meter tersedia dan sudah dilakukan kalibrasi rutin sesuai jadwal periodik?</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>j</td>
                                            <td>Apakah asesoris perlengkapan K3LH sudah terpenuhi semua seperti apar 15 kg, hiydrant,
                                                safety cone, kotak P3K, spill kit, kabel grounding dan eye Wash?</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>j</td>
                                            <td>Apakah assesoris perlengkapan penerimaan Lube seperti Gelas ukur, hose Lube in, tabel tera
                                                tangki, Stik Sonding dan area pembongkaran sudah tersedia?</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>j</td>
                                            <td>Apakah tersedia kelengkapan media informasi seperti alat komunikasi (Radio), rambu larangan
                                                merokok, Papan Informasi dan Dokumen SOP?td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td>j</td>
                                            <td>Apakah sudah tersedia Instalasi Lube filtration ?</td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td>j</td>
                                            <td>Apakah Area Bandwall Maintank dalam kondisi layak pakai dan memenuhi standart ?</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>j</td>
                                            <td>Apakah tersedia komputer sebagai alat pendataan transaksi penerimaan maupun pemakaian
                                                Lube?</td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td>j</td>
                                            <td>Apakah tersedia kelengkapan keamanan terhadap tindakan pencurian seperti Cctv dan pagar
                                                pembatas maintank diarea Lube station ?</td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td>j</td>
                                            <td>Apakah Instalasi pipa dan maintank Lube station dalam kondisi baik tidak ada retakan atau
                                                berkarat ?</td>
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td>j</td>
                                            <td>Apakah tersedia lembar log sheet sebagai pencatatan ketika proses penerimaan, pemakaian
                                                dan transfer Lube ?</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3">LUBE TRUCK</th>
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>13</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>14</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>16</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>17</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>18</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>19</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                        <tr>
                                            <td>20</td>
                                            <td>j</td>
                                            <td>???</td>
                                        </tr>
                                    </table>
                                
                                </div>
                            </div>
                        </div>

                        <div class="card border mt-5">
                            <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                                data-bs-toggle="collapse" data-bs-target="#collapse-w2" aria-expanded="true" aria-controls="collapse-w2">
                                <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">WEEK 2</h6>
                                    <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                                </div>
                            </a>
                            <div class="card-body collapse pb-1" id="collapse-w2">
                                <div class="table-responsive">
                                    
                                
                                </div>
                            </div>
                        </div>                        
                        
                        <div class="card border mt-5">
                            <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                                data-bs-toggle="collapse" data-bs-target="#collapse-w3" aria-expanded="true" aria-controls="collapse-w3">
                                <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">WEEK 3</h6>
                                    <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                                </div>
                            </a>
                            <div class="card-body collapse pb-1" id="collapse-w3">
                                <div class="table-responsive">
                                    
                                
                                </div>
                            </div>
                        </div>   
                        
                        <div class="card border mt-5">
                            <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                                data-bs-toggle="collapse" data-bs-target="#collapse-w4" aria-expanded="true" aria-controls="collapse-w4">
                                <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">WEEK 4</h6>
                                    <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                                </div>
                            </a>
                            <div class="card-body collapse pb-1" id="collapse-w4">
                                <div class="table-responsive">
                                    
                                
                                </div>
                            </div>
                        </div>

                        <div class="card border mt-5">
                            <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                                data-bs-toggle="collapse" data-bs-target="#collapse-w5" aria-expanded="true" aria-controls="collapse-w5">
                                <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                    <h6 class="text-white text-capitalize mb-0">WEEK 5</h6>
                                    <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                                </div>
                            </a>
                            <div class="card-body collapse pb-1" id="collapse-w5">
                                <div class="table-responsive">
                                    
                                
                                </div>
                            </div>
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
            return "_/BSS-FRM-LOG-031/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
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
                                title: 'Request sukses direkam dgn no dokumen:',
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
