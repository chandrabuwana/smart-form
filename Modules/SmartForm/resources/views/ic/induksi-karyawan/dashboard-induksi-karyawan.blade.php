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
                        <h6 class="text-white text-capitalize ps-3">Induksi Karyawan</h6>
                    </div>
                </div>
                <div class="card-header"
                    style="margin : 10px;border-radius: 10px; background-color: rgba(209, 209, 209, 0.301);">
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
                                        <label for="FILTERNIKMENTOR">NIK Mentor</label>
                                        <input type="text" class="form-control" id="FILTERNIKMENTOR"
                                            name="FILTERNIKMENTOR" maxlength="7" placeholder=" -- Masukkan NIK Mentor -- ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="FILTERNAMA">Nama</label>
                                        <input type="text" class="form-control" id="FILTERNAMA" name="FILTERNAMA"
                                            maxlength="7" placeholder="-- Masukkan Nama Karyawan Induksi -- ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group select-div input-group-static my-2">
                                        <label for="FILTERSITE" class="ms-0">Site </label>
                                        <select class="form-control site" name="FILTERSITE" id="FILTERSITE">
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
                                        onclick="dataListFormICInduksiKaryawanSearchGenerate();">
                                        <i class="fa fa-filter"> Search</i> </button></a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="d-flex align-items-center" style="margin:10px">
                        <div class="col-md-2">
                            <a href="{{ route('bss-form-ic-induksi-karyawan') }}"><button
                                    class="btn btn-primary ms-auto uploadBtn">
                                    Mulai Induksi</button></a>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary ms-auto uploadBtn" onclick="TiggerBukaModalUntukDownlaodPDF()">
                                Export PDF</button>
                        </div>
                    </div>
                    <div class="table-responsive p-0">
                        <table id="dataListFormICInduksiKaryawan" data-toggle="table"
                            data-ajax="dataListFormICInduksiKaryawanGenerateData"
                            data-query-params="dataListFormICInduksiKaryawanParamsGenerate" data-side-pagination="server"
                            data-page-list="[10, 25, 50, 100, all]" data-sortable="true"
                            data-content-type="application/json" data-data-type="json" data-pagination="true"
                            data-unique-id="id">
                            <thead>
                                <tr>
                                    <th data-field="code" data-align="center" data-halign="center">Code</th>
                                    {{-- <th data-field="expired" data-align="center" data-formatter="dataTableDateFormater"
                                        data-halign="center">Expired</th> --}}
                                    <th data-field="mentor_names" data-align="center" data-halign="center">Mentor</th>
                                    <th data-field="site" data-align="center" data-halign="center">Site</th>
                                    <th data-field="created_at" data-align="center" data-halign="center"
                                        data-formatter="dataTableDateFormater">Dibuat Tanggal</th>
                                    <th data-field="jml_karyawan" data-align="center" data-halign="center">Karyawan</th>
                                    <th data-field="pertanyaan" data-align="center" data-halign="center">Jenis</th>
                                    <th data-halign="center" data-align="center"
                                        data-formatter="dataListFormICInduksiKaryawanActionFormater">Action
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
    <div class="modal fade" id="ModalUntukDownload" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Masukkan NIK</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <div class="card-body">
                                <h5 class="card-title">Progress Pembenahan</h5>
                                <span id="solutionSpan"></span>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static my-4">
                                            <label for="note_progress">Masukkan NIK</label>
                                            <input class="form-control" type="text" placeholder="-- Masukkan NIK -- "
                                                name="pdfNIK" required id="pdfNIK">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static my-4">
                                            <label for="CCPLink" class="ms-0">Nama</label>
                                            <input class="form-control" type="text"
                                                placeholder="-- Akan Generate By Click Check" name="pdfName" disabled
                                                id="pdfName">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    style="margin : 20px" onclick="CheckDataBeforeDownloadPDF()">
                                    <i class="fas fa-save"></i>
                                    Check Data</button>
                            </div>
                        </div>
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
        let dataUser = <?php echo json_encode(session('user_id')); ?>;
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


        function RedirectToDetail(obj) {
            let indexDt = $(obj).closest('tr').data('index');
            let d = $('#dataListFormICInduksiKaryawan').bootstrapTable('getData')[indexDt];
            window.location.href = "/bss-form/induksi-karyawan/form-edit-view-IC-form-induksi/" + d.code + "=" + d
                .created_at;
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

        function dataListFormICInduksiKaryawanActionFormater(value, row, index) {

            let data = `
                    <button onclick="RedirectToDetail(this)"><a class="like"  title="Like">
                        <i class="fa fa-pen"></i> Edit
                    </a></button> 
                    
                `
            if (dataUser == '1006104') {
                data += `<button onclick="DeletedData(this)"><a class="like"  title="Like">
                        <i class="fa fa-trash"></i> Delete
                    </a></button>'`
            }
            console.log(dataUser);
            return data;
        }

        function DeletedData(obj) {
            Swal.fire({
                title: "Apakah yakin dihapus?",
                showCancelButton: true,
                confirmButtonText: "Hapus Data",
            }).then((result) => {
                if (result.isConfirmed) {
                    let indexDt = $(obj).closest('tr').data('index');
                    let d = $('#dataListFormICInduksiKaryawan').bootstrapTable('getData')[indexDt];

                    let dataHapus = {
                        code: d.code
                    }

                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/bss-form/induksi-karyawan/delete-induksi",
                        data: dataHapus,
                        dataType: 'json',
                        success: function(response) {
                            if (response.code == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                }).then((result) => {
                                    dataListFormICInduksiKaryawanSearchGenerate()
                                });
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
            });


        }

        function dataListFormICInduksiKaryawanParamsGenerate(params) {

            params.search = {
                'FILTERNIK': $('#FILTERNIK').val(),
                'FILTERNAMA': $('#FILTERNAMA').val(),
                'FILTERTANGGAL': $('#FILTERTANGGAL').val(),
                'FILTERNIKMENTOR': $('#FILTERNIKMENTOR').val(),
                'FILTERSITE': $('#FILTERSITE').val(),
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

        function dataListFormICInduksiKaryawanSearchGenerate() {
            $('#dataListFormICInduksiKaryawan').bootstrapTable('refresh');
            $("#dataListFormICInduksiKaryawan").bootstrapTable("uncheckAll");
        }

        function dataListFormICInduksiKaryawanGenerateData(params) {
            var url = '/bss-form/induksi-karyawan/lst-IC-form-induksi'
            $.get(url + '?' + $.param(params.data)).then(function(res) {
                params.success(res)
            })
        }
    </script>
    <script type="text/javascript">
        function CheckDataBeforeDownloadPDF() {
            let nnik = $('#pdfNIK').val();
            if (nnik == "") {
                Swal.fire({
                    icon: 'error',
                    title: 'NIK Empty',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            let dataKirim = {
                nik: nnik
            }
            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/bss-form/induksi-karyawan/check-nik-pdf",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "/bss-form/induksi-karyawan/download-pdf/" + nnik
                            }
                        });
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


        function TiggerBukaModalUntukDownlaodPDF() {
            $('#ModalUntukDownload').modal("show");
        }
    </script>
    <script type="text/javascript">
        function initializeSelect2Site(elementId) {
            $(elementId).select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                dropdownParent: $(elementId).closest('.input-group'),
                placeholder: '--- Cari Site ---',
                ajax: {
                    url: "/helper/site",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            _token: "{{ csrf_token() }}",
                            query: params.term, // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                }
            });
        }
        initializeSelect2Site('#FILTERSITE');
    </script>
@endsection
