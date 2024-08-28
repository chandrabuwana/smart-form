@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Fatigue Check / Pengukuran Kelelahan</h6>
                    </div>
                </div>
                <div class="card-header"
                    style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301); color:white !important;">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-title">Filter</h6>
                            <hr class="horizontal dark my-sm-1">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERNIK">NIK</label>
                                        <input type="text" class="form-control" id="FILTERNIK" name="FILTERNIK"
                                            maxlength="7" placeholder=" -- Masukkan NIK -- ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERLOKASI">LOKASI</label>
                                        <input type="text" class="form-control" id="FILTERLOKASI" name="FILTERLOKASI"
                                            maxlength="7" placeholder="-- Masukkan Lokasi -- ">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERSHIFT">SHIFT</label>
                                        <select class="form-control" name="FILTERSHIFT" id="FILTERSHIFT" required>
                                            <option value=""> -- Pilih Shift -- </option>
                                            <option value="DS">PAGI</option>
                                            <option value="NS">MALAM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERTANGGAL" class="">Tanggal</label>
                                        <div class="input-group input-group-static my-2">
                                            <input class="form-control due-date-picker" type="text"
                                                placeholder="DD/MM/YYYY" name="FILTERTANGGAL" required id="FILTERTANGGAL">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-sm-2">
                                    <button class="btn btn-primary ms-auto uploadBtn"
                                        onclick="dataListFormSHE019BSearchGenerate(this);">
                                        <i class="fa fa-filter"> Search</i> </button></a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('add-bss-form-she-019B') }}"><button class="btn btn-primary ms-auto uploadBtn">
                                Fatigue Check</button></a>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="dataListFormSHE019B" data-toggle="table" data-ajax="dataListFormSHE019BGenerateData"
                            data-query-params="dataListFormSHE019BParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    {{-- <th data-field="id" data-align="left" data-halign="text-center" data-sortable="true">No. --}}
                                    {{-- </th> --}}
                                    <th data-field="nik" data-align="center" data-halign="center">NIK</th>
                                    <th data-field="nama" data-align="center" data-halign="center">Nama</th>
                                    <th data-field="lokasi" data-align="center" data-halign="center">Lokasi</th>
                                    <th data-field="no_unit" data-align="center" data-halign="center">No Unit</th>
                                    <th data-field="shift" data-align="center" data-halign="center">shift</th>
                                    <th data-field="jam" data-align="center" data-formatter="JamFormater"
                                        data-halign="center">Jam</th>
                                    <th data-field="jml_tdr" data-align="center" data-formatter="jmlJamTidurFormater"
                                        data-halign="center">Jam Tidur</th>
                                    <th data-field="status_by_petugas" data-formatter="statusFormater" data-align="center"
                                        data-halign="center" data-sortable="true">Status
                                    </th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListFormSHE019BActionFormater">Action
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="modalFormMedis" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="nik" id="nik" value="">
                <input type="hidden" name="created_at" id="created_at" value="">
                <input type="hidden" name="nfieldMengantuk" id="nfieldMengantuk" value="">
                <input type="hidden" name="nfieldSakit" id="nfieldSakit" value="">
                <input type="hidden" name="nfieldObat" id="nfieldObat" value="">
                <input type="hidden" name="nfieldMasalah" id="nfieldMasalah" value="">

                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">FORM Step Solution</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="card-title">Biodata Karyawan</h6>
                                        <hr class="horizontal dark my-sm-1">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="namaNik">Nama / NIK</label>
                                                    <input type="text" class="form-control" id="namaNik"
                                                        name="namaNik" maxlength="7" placeholder="Abiyoga Hendra"
                                                        disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="fumur">Umur</label>
                                                    <input type="text" class="form-control" id="fumur"
                                                        name="fumur" maxlength="7" placeholder="25" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="flocation">Lokasi</label>
                                                    <input type="text" class="form-control" id="flocation"
                                                        name="flocation" maxlength="7" placeholder="23123" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="fnUnit">Nomor Unit</label>
                                                    <input type="text" class="form-control" id="fnUnit"
                                                        name="fnUnit" maxlength="7" placeholder="23123" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="fjTIdur">Jam Tidur</label>
                                                    <input type="text" class="form-control" id="fjTIdur"
                                                        name="fjTIdur" maxlength="7" placeholder="23123" disabled>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="tensi">Mengantuk</label>
                                                    <button class="form-control-button btn" id="fieldMengantuk"
                                                        type="button"></button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="tensi">Sakit</label>
                                                    <button class="form-control-button btn" id="fieldSakit"
                                                        type="button"></button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="tensi">Minum Obat</label>
                                                    <button class="form-control-button btn" id="fieldObat"
                                                        type="button"></button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="tensi">Ada Masalah</label>
                                                    <button class="form-control-button btn" id="fieldMasalah"
                                                        type="button"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-sm-2">
                                <h6 class="card-title">FORM Check Up</h6>
                                <hr class="horizontal dark my-sm-1">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="tensi">Tensi (mmHg)</label>
                                            <input type="text" class="form-control" id="tensi" name="tensi"
                                                maxlength="7" placeholder="XXX/XXX">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="nadi">Nadi ( x/Mnt )</label>
                                            <input type="text" class="form-control" id="nadi" name="nadi"
                                                maxlength="3" placeholder="-----">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="spo2">SpO2 ( % )</label>
                                            <input type="text" class="form-control" id="spo2" name="spo2"
                                                maxlength="2" placeholder="-----">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="suhu">Suhu Tubuh ( C )</label>
                                            <input type="text" class="form-control" id="suhu" name="suhu"
                                                maxlength="2" placeholder="-----">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static my-4">
                                            <label class="ms-0" for="statusByPetugas">Sakit</label>
                                            <select class="form-control" name="statusByPetugas" id="statusByPetugas"
                                                required>
                                                <option value="" selected> -- Status Pekerja --</option>
                                                <option value="1">Bekerja</option>
                                                <option value="2">Bekerja Dengan Pengawasan</option>
                                                <option value="3">Istirahat</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end" id="masukkanButtonSubmit">
                        <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPIC"
                            onclick="SubmittAllDataModal()">
                            <i class="fas fa-save"></i>
                            Submit Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script type="text/javascript">
        $('#FILTERTANGGAL').datepicker({
            dateFormat: 'd MM yy',
            monthNames: [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ],
            dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']
        });


        function dataTableDateFormater(value, row, index) {
            var monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            var t = new Date(value);
            return t.getDate() + '-' + monthNames[t.getMonth()] + '-' + t.getFullYear();

        }

        $('#tensi').on('input', function() {
            let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
            if (value.length > 3) {
                value = value.substring(0, 3) + '/' + value.substring(3, 6);
            }
            $(this).val(value);
        });

        function formatTime(timeString) {
            // Membagi string berdasarkan tanda titik untuk menghilangkan bagian yang tidak perlu
            var timePart = timeString.split('.')[0];
            // Mengambil jam dan menit dari bagian waktu
            var parts = timePart.split(':');
            var hours = parts[0];
            var minutes = parts[1];
            // Mengembalikan waktu dalam format 'HH:mm'
            return hours + ':' + minutes;
        }

        function JamFormater(value, row, index) {
            return formatTime(value)
        }

        function jmlJamTidurFormater(value, row, index) {
            return value + " Jam"
        }

        function statusFormater(value, row, index) {
            if (value == 0) {
                return `<div style="display: flex; justify-content: center;">
                            <button type="button" class="btn btn-primary btn-sm">Pra Check</button>
                        </div>`
            } else if (value == 1) {
                return `<button type="button" class="btn btn-success btn-sm">Bekerja</button>`
            } else if (value == 2) {
                return `<button type="button" class="btn btn-danger btn-sm">Bekerja Dalam Pengawasan</button>`
            } else if (value == 3) {
                return `<button type="button" class="btn btn-warning btn-sm">Istirahat</button>`
            } else {
                return `<button type="button" class="btn btn-secondary btn-sm">?</button>`
            }
        }

        function openModalCheckUp(obj) {
            let indexDt = $(obj).closest('tr').data('index');
            let d = $('#dataListFormSHE019B').bootstrapTable('getData')[indexDt];
            $('#id').val(d.id);
            $('#namaNik').val(d.nama + " - " + d.nik);
            $('#created_at').val(d.created_at);
            $('#nik').val(d.nik);
            $('#fumur').val(d.Umur + " Tahun");
            $('#flocation').val(d.lokasi);
            $('#fnUnit').val(d.no_unit);
            $('#fjTIdur').val(d.jml_tdr + " Jam");
            $('#nfieldMengantuk').val(d.fm_1);
            $('#nfieldSakit').val(d.fm_2);
            $('#nfieldObat').val(d.fm_3);
            $('#nfieldMasalah').val(d.fm_4);

            if (d.fm_1 == "Y") {
                $('#fieldMengantuk').addClass("btn-primary").html("YES");
            } else {
                $('#fieldMengantuk').addClass("btn-success").html("NO");
            }
            if (d.fm_2 == "Y") {
                $('#fieldSakit').addClass("btn-primary").html("YES");
            } else {
                $('#fieldSakit').addClass("btn-success").html("NO");
            }
            if (d.fm_3 == "Y") {
                $('#fieldObat').addClass("btn-primary").html("YES");
            } else {
                $('#fieldObat').addClass("btn-success").html("NO");
            }
            if (d.fm_4 == "Y") {
                $('#fieldMasalah').addClass("btn-primary").html("YES");
            } else {
                $('#fieldMasalah').addClass("btn-success").html("NO");
            }

            $('#modalFormMedis').modal("show");
        }

        function SubmittAllDataModal() {
            const tensi = $('#tensi').val();
            const nadi = $('#nadi').val();
            const spo2 = $('#spo2').val();
            const suhu = $('#suhu').val();
            const tdr = $('#fjTIdur').val().replace(/Jam/g, '').trim();
            const statusByPetugas = $('#statusByPetugas').val();
            const i = $('#id').val();
            const j = $('#nik').val();
            const k = $('#created_at').val();
            const mengantuk = $('#nfieldMengantuk').val();
            const sakit = $('#nfieldSakit').val();
            const obat = $('#nfieldObat').val();
            const masalah = $('#nfieldMasalah').val();

            // Validasi data
            if (!tensi || !nadi || !spo2 || !suhu || !statusByPetugas) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Semua field harus diisi!',
                });
                return;
            }

            // Jika validasi lolos, lakukan sesuatu dengan data
            // Misalnya, mengirim data ke server
            const formData = {
                tensi: tensi,
                nadi: nadi,
                spo2: spo2,
                suhu: suhu,
                tdr: tdr,
                statusByPetugas: statusByPetugas,
                i: i,
                j: j,
                k: k,
                mengantuk: mengantuk,
                obat: obat,
                masalah: masalah,
                sakit: sakit
            };


            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/she-019B/store-petugas-checker",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            $('#location').val('');
                            $('#no_unit').val('');
                            $('#jml_tdr').val('');
                            $('#fm_1').val('');
                            $('#fm_2').val('');
                            $('#fm_3').val('');
                            $('#fm_4').val('');
                            window.location.href = `/bss-form/she-019B/dashboard`;
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
                }
            })

        }

        function dataListFormSHE019BActionFormater(value, row, index) {
            console.log(row);
            let data = `
                    <button onclick="openModalCheckUp(this)"><a class="like"  title="Like">
                        <i class="fa fa-pen"></i> Check UP
                    </a></button>
                `
            return data;
        }

        function redirectToAddStepPica(obj) {
            var indexDt = $(obj).closest('tr').data('index');
            window.location.href = "/smart-pica/create-step/" + $('#dataListFormSHE019B').bootstrapTable('getData')[indexDt]
                .nodocpica;
        }

        function dataListFormSHE019BParamsGenerate(params) {

            params.search = {
                'FILTERNIK': $('#FILTERNIK').val(),
                'FILTERLOKASI': $('#FILTERLOKASI').val(),
                'FILTERSHIFT': $('#FILTERSHIFT').val(),
                'FILTERTANGGAL': $('#FILTERTANGGAL').val(),
            };

            if (params.sort == undefined) {
                return {
                    limit: params.limit,
                    offset: params.offset,
                    search: params.search
                }
            }
            return params;
        }

        function dataListFormSHE019BSearchGenerate(obj) {
            $('#dataListFormSHE019B').bootstrapTable('refresh');
            $("#dataListFormSHE019B").bootstrapTable("uncheckAll");
        }

        function dataListFormSHE019BGenerateData(params) {
            var url = '/bss-form/she-019B/get-dashboard-data'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
@endsection
