@php
$formatDate = function($date) {
    if (empty($date)) return '';
    if (strpos($date, '-') !== false) return $date; // Already in YYYY-MM-DD format
    
    try {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    } catch (\Exception $e) {
        return '';
    }
};
@endphp

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
    .img-app {
        max-width: 100px;
        height: auto;
        margin: 10px 0;
    }
    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
        justify-content: flex-end;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">EDIT FORM BSS SHE 036 INSPEKSI APAR</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <form id="formInspeksiApar">
                        <div class="row gx-4">
                            <div class="row">
                                <div class="card col-md-6">
                                    <table class="w-full">
                                        <tr>
                                            <td>No. Doc</td>
                                            <td>:</td>
                                            <td id="noDoc">{{ $data->no_dok }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td id="tglDoc">{{ $data->tanggal }}</td>
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
                                                    <option value="" {{ empty($data->lokasi_inspeksi) ? 'selected' : '' }}>-- Pilih Lokasi Inspeksi --</option>
                                                    <option value="Maintank" {{ $data->lokasi_inspeksi == 'Maintank' ? 'selected' : '' }}>Maintank</option>
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
                                        <label for="dMetode">Metode Pemenuhan</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dMetode" name="dMetode">
                                            <option value="" selected>-- Pilih Metode --</option> 
                                            <option value="Isi Ulang">Isi Ulang</option>
                                            <option value="Ganti Baru">Ganti Baru</option>
                                            <option value="Tera Ulang">Tera Ulang</option>
                                        </select> 
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="dMetode">Kondisi Luar Tabung</label>
                                        <fieldset class="card" style="width: 13rem;">
                                          <div class="col-sm-12">
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" value="1" id="cTabung1">
                                              <label class="form-check-label me-3" for="cTabung1">
                                                Tabung
                                              </label>
                                              <input class="form-check-input" type="checkbox" value="1" id="cHandle">
                                              <label class="form-check-label" for="cHandle">
                                                Handle
                                              </label>
                                            </div>
                                            <div class="form-check">
                                              <input class="form-check-input" type="checkbox" value="1" id="cSelang">
                                              <label class="form-check-label me-3" for="cSelang">
                                                Selang&nbsp;
                                              </label>
                                              <input class="form-check-input" type="checkbox" value="1" id="cLabel">
                                              <label class="form-check-label" for="cLabel">
                                                Label
                                              </label>
                                            </div>
                                          </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4 col-lg-2">
                                        <label for="iKet">Kartu Bukti Pemeriksaan:</label>
                                        <fieldset class="card" style="width: 13rem;">
                                            <div class="input-group input-group-static mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="cTabung2">
                                                    <label class="form-check-label" for="cTabung2">
                                                        Tabung
                                                    </label>
                                                </div>
                                            </div>
                                        </fieldset>
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
                                            <button type="button" id="btn-add-item" class="btn btn-primary">Tambah</button>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="item-inspeksi" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="lok2">Lokasi APAR</th>
                                        <th data-field="jenis">Jenis APAR</th>
                                        <th data-field="tekananTab">Tekanan Tabung</th>
                                        <th data-field="berat">Berat APAR</th>
                                        <th data-formatter="kondisiFormatter">Kondisi</th>
                                        <th data-field="tglBerlaku">Berlaku Sampai</th>
                                        <th data-field="pic">PIC</th>
                                        <th data-field="ket">Keterangan</th>
                                        <th data-formatter="actionFormatter">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-md-4 col-lg-2">
                            <div class="input-group input-group-static mb-4">
                                <label for="tCatatan">Catatan Form:</label>
                                <input type="text" class="form-control" id="tCatatan" name="tCatatan" value="{{ $data->catatan }}">
                            </div>
                        </div>                        
                    </form>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto" id="btnSubmitUpdate">
                                <i class="fas fa-save"></i>
                                Update Form
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        var tglNow = new Date()
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_romawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

        function indexFormatter(value, row, index) {
            return index + 1;
        }
        
        function dateFormatter(value, row) {
            if (!value) return '';
            
            if (typeof value === 'string' && value.match(/^\d{4}-\d{2}-\d{2}$/)) {
                return value;
            }
            
            try {
                const date = new Date(value);
                if (isNaN(date.getTime())) return value;
                
                return date.toISOString().split('T')[0];
            } catch (e) {
                console.error('Error formatting date:', e);
                return value || '';
            }
        }

        function actionFormatter(value, row, index) {
            return `
                <button class="btn btn-danger btn-sm" onclick="deleteRow(${index})">Delete</button>
            `;
        }

        function kondisiFormatter(value, row) {
            return `
                <ul class="list-unstyled">
                    <li>Tabung: ${row.tabung1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</li>
                    <li>Handle: ${row.handle ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</li>
                    <li>Selang: ${row.selang ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</li>
                    <li>Label: ${row.label ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</li>
                    <li>Kartu: ${row.tabung2 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'}</li>
                </ul>
            `;
        }

        $(document).ready(function() {
            var $table = $("#item-inspeksi");
            var btnSubmitUpdate = $("#btnSubmitUpdate");
            var $buttonTambah = $("#btn-add-item");
            
            var dLok1 = $("#dLok1");
            var tCatatan = $("#tCatatan");
            
            var dLok2 = $("#dLok2");
            var dJenis = $("#dJenis");
            var dTekanan = $("#dTekanan");
            var tBerat = $("#tBerat");
            var tPic = $("#tPic");
            var dMetode = $("#dMetode");
            var tBerlaku = $("#tBerlaku");
            var dTgl = $("#dTgl");
            var tKet = $("#tKet");
            
            var cTabung1 = $("#cTabung1");
            var cHandle = $("#cHandle");
            var cSelang = $("#cSelang");
            var cLabel = $("#cLabel");
            var cTabung2 = $("#cTabung2");
            
            window.deleteRow = function(id) {
                $table.bootstrapTable('remove', {
                    field: '$index',
                    values: [id]
                });
            };

            function formatDateForDisplay(dateString) {
                if (!dateString) return '';
                
                try {
                    const date = new Date(dateString);
                    if (isNaN(date.getTime())) return dateString;
                    
                    return date.toISOString().split('T')[0];
                } catch(e) {
                    return dateString;
                }
            }
            
            $table.bootstrapTable({
                data: [],
                formatNoMatches: function() {
                    return 'No data available';
                }
            });
            
            var detailData = [];
            
            @if(isset($detail) && count($detail) > 0)
                @foreach($detail as $item)
                    detailData.push({
                        lok2: "{{ addslashes($item->lokasi_apar) }}",
                        jenis: "{{ addslashes($item->jenis_apar) }}",
                        tekananTab: "{{ addslashes($item->tekanan_tabung) }}",
                        berat: "{{ $item->berat_apar }}",
                        tabung1: {{ $item->tabung ? 'true' : 'false' }},
                        handle: {{ $item->handle ? 'true' : 'false' }},
                        selang: {{ $item->selang ? 'true' : 'false' }},
                        label: {{ $item->label_tabung ? 'true' : 'false' }},
                        tabung2: {{ $item->label_kartu ? 'true' : 'false' }},
                        metode: "{{ addslashes($item->metode_pemenuhan) }}",
                        tglBerlaku: "{{ $item->berlaku_sampai }}",
                        pic: "{{ addslashes($item->pic) }}",
                        tanggal: "{{ $item->tanggal }}",
                        ket: "{{ addslashes($item->keterangan) }}"
                    });
                @endforeach
                
                console.log("Loading detail data:", detailData);
            @else
                console.log("No existing data found");
            @endif
            
            $table.bootstrapTable('load', detailData);
            
            function validateItem() {
                var errorValidate = [];

                if(dLok2.val() == "") {
                    errorValidate.push({
                        field: "Kolom Lokasi APAR",
                        message: "tidak boleh kosong"
                    });
                }
                return errorValidate;
            }

            function validateForm() {
                var errorValidate = [];
                
                if(dLok1.val() == ""){
                    errorValidate.push({
                        field: "Kolom Lokasi Inspeksi",
                        message: "Harus dipilih"
                    });
                }
                if($table.bootstrapTable('getData').length < 1) {
                    errorValidate.push({
                        field: "Item",
                        message: "minimal harus ada 1"
                    });
                }

                return errorValidate;
            }            

            function showLoading() {
                $("body").css("overflow-y", "hidden");
                if ($("#loading-animation").length > 0) {
                    $("#loading-animation").css("display", "flex");
                }
            }

            function stopLoading() {
                $("body").css("overflow-y", "auto");
                if ($("#loading-animation").length > 0) {
                    $("#loading-animation").css("display", "none");
                }
            }

            $buttonTambah.click(function (e) {
                e.preventDefault();
                var errorValidate = validateItem();
                
                var msg = "";
                if(errorValidate.length > 0) {
                    for (var listErr of errorValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    });
                } else {
                    $table.bootstrapTable('append', {
                    lok2: dLok2.val(),
                    jenis: dJenis.val(),
                    tekananTab: dTekanan.val(),
                    berat: tBerat.val(),
                    tabung1: cTabung1.prop('checked'),
                    handle: cHandle.prop('checked'),
                    selang: cSelang.prop('checked'),
                    label: cLabel.prop('checked'),
                    tabung2: cTabung2.prop('checked'),
                    kondisi: {},
                    metode: dMetode.val(),
                    tglBerlaku: tBerlaku.val(),
                    pic: tPic.val(),
                    tanggal: dTgl.val(),
                    ket: tKet.val()
                });
                    
                    dLok2.val('');
                    dJenis.val('');
                    dTekanan.val('');
                    tBerat.val('');
                    tPic.val('');
                    dMetode.val('');
                    tBerlaku.val('');
                    dTgl.val('');
                    tKet.val('');
                    cTabung1.prop('checked', false);
                    cHandle.prop('checked', false);
                    cSelang.prop('checked', false);
                    cLabel.prop('checked', false);
                    cTabung2.prop('checked', false);
                    
                    $table.bootstrapTable('scrollTo', 'bottom');
                }
            });

            btnSubmitUpdate.click(function(e) {
                e.preventDefault();
                var errValidate = validateForm();
                
                if(errValidate.length > 0) {
                    var msg = "";
                    for (var listErr of errValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>";
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    });
                } else {
                    showLoading();
                    
                    var formData = new FormData();
                    formData.append('id', {{ $data->id }});
                    formData.append('lok1', $('#dLok1').val());
                    formData.append('catatan', $('#tCatatan').val());
                    formData.append('diperiksa', $('#diperiksa').val());
                    formData.append('diketahui', $('#diketahui').val());
                    formData.append('disetujui', $('#disetujui').val());
                    formData.append('item', JSON.stringify($table.bootstrapTable('getData')));
                    formData.append('_token', '{{ csrf_token() }}');
                    
                    axios.post('/bss-form/she-036/update-inspeksi-apar', formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        stopLoading();
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message || 'Data berhasil diupdate'
                            }).then(() => {
                                window.location.href = '/bss-form/she-036/inspeksi-apar';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.data.message || 'Terjadi kesalahan'
                            });
                        }
                    })
                    .catch(function (error) {
                        stopLoading();
                        console.error('Error:', error);
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join('\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const btnAparApprove = document.getElementById("btnAparApprove");
            const btnAparReject = document.getElementById("btnAparReject");
            
            if (btnAparApprove) {
                btnAparApprove.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    let status = JSON.parse(this.getAttribute('data-status') || '[]');
                    let nik = this.getAttribute("data-nik");
                    
                    while (status.length < 3) {
                        status.push(null);
                    }
                    
                    axios.post("{{ route('bss-form.she-036.approve-inspeksi-apar') }}", {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        diperiksa: nik == "{{ $data->diperiksa_oleh ?? '' }}" ? 'approved' : status[0],
                        diketahui: nik == "{{ $data->diketahui_oleh ?? '' }}" ? 'approved' : status[1],
                        disetujui: nik == "{{ $data->disetujui_oleh ?? '' }}" ? 'approved' : status[2],
                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    })
                    .catch(error => {
                        let errorMessage = 'Error in system';
                        console.error("Error response:", error.response);
                        
                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join('\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
                });
            }
            
            if (btnAparReject) {
                btnAparReject.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");
                    let status = JSON.parse(this.getAttribute('data-status') || '[]');
                    let nik = this.getAttribute("data-nik");
                    
                    while (status.length < 3) {
                        status.push(null);
                    }
                    
                    axios.post("{{ route('bss-form.she-036.reject-inspeksi-apar') }}", {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        diperiksa: nik == "{{ $data->diperiksa_oleh ?? '' }}" ? 'rejected' : status[0],
                        diketahui: nik == "{{ $data->diketahui_oleh ?? '' }}" ? 'rejected' : status[1],
                        disetujui: nik == "{{ $data->disetujui_oleh ?? '' }}" ? 'rejected' : status[2],
                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                    })
                    .catch(error => {
                        let errorMessage = 'Error in system';
                        console.error("Error response:", error.response);
                        
                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join('\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
                });
            }
        });
    </script>
@endsection