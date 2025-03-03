@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .select2-dropdown {
            overflow: scroll;
            height: 300px;
        }


        .close-button-why {
            position: absolute;
            top: 0;
            right: 0;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background-color: black;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate(50%, -50%);
        }

        .close-button-why:hover {
            background-color: darkred;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            /* Menyesuaikan dengan form-control di Bootstrap 5 */
        }

        /* Menyesuaikan tinggi baris teks dalam pilihan */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px);
        }

        .scrollable-div {
            width: 100%;
            height: 400px;
            overflow: auto;
            position: relative;
        }

        fieldset {
            border: 2px solid #ddd;
            /* Border for the fieldset */
            padding: 1.5em;
            /* Padding inside the fieldset */
            margin-bottom: 1.5em;
            /* Margin below the fieldset */
            position: relative;
            /* Position relative to handle absolute positioned legend */
        }

        legend {
            font-size: 1.25em;
            /* Font size for the legend */
            font-weight: bold;
            /* Make the legend text bold */
            padding: 0 10px;
            /* Padding to give some space on left and right */
            background-color: white;
            /* Background color to match the page's background */
            position: absolute;
            /* Position the legend absolutely */
            top: -1em;
            /* Move it up above the border */
            left: 10px;
            /* Adjust left position */
        }

        .zoomable-content {
            transform-origin: 0 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form PICA</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Creator : {{ session('username') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center"
                                            aria-selected="true">
                                            <i class="fas fa-key"> </i> No Document :
                                            <span class="ms-2">BSS-FRM-SM-2024-06-11-?</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr class="horizontal dark my-sm-3">
                    <input type="hidden" name="pc_no" value="1">
                    <div class="card-body">
                        <div class="row" id="tabel_tambah">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_thn" class="ms-0">Tahun </label>
                                        <select class="form-control" name="pc_thn" id="pc_thn" required>
                                            <option value="">-- Pilih Tahun --</option>
                                            <?php
                                            $y = date('Y');
                                            for ($i = $y - 2; $i < $y + 4; $i++) {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_bln" class="ms-0">Bulan </label>
                                        <select class="form-control" name="pc_bln" id="pc_bln" required>
                                            <option value="">-- Pilih Bulan --</option>
                                            <?php
                                            for ($month = 1; $month <= 12; $month++) {
                                                $monthName = date('F', mktime(0, 0, 0, $month, 1));
                                                echo "<option value='$month'>$monthName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_week" class="ms-0">Week </label>
                                        <select class="form-control" name="pc_week" id="pc_week">
                                            <option value="">-- Pilih Week --</option>
                                            <option value="1">Week 1</option>
                                            <option value="2">Week 2</option>
                                            <option value="3">Week 3</option>
                                            <option value="4">Week 4</option>
                                            <option value="5">Week 5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_site" class="ms-0">Site </label>
                                        <select class="form-control site" name="pc_site" id="pc_site">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_dept" class="ms-0">Department </label>
                                        <select class="form-control dept" name="pc_dept" id="pc_dept">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group ayyyyy input-group-static my-4">
                                        <label for="pc_kpi" class="ms-0">Leading KPI </label>
                                        <select class="form-control s2lea" name="pc_kpi" id="pc_kpi" required></select>
                                        <small class="text-danger">Actual & Target hanya bisa diisi dengan angka dan titik
                                            (.)
                                            <i class="fas fa-arrow-right"></i></small>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_aktual" class="ms-0">Actual</label>
                                        <input class="form-control" type="text" inputmode="decimal" placeholder="0"
                                            onkeypress="return /[0-9.)]/i.test(event.key)" pattern="[0-9]*[.]?[0-9]*"
                                            name="pc_aktual" required id="pc_aktual">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="pc_target">Target</label>
                                        <input class="form-control" type="text" inputmode="decimal" id="pc_target"
                                            placeholder="0" onkeypress="return /[0-9.)]/i.test(event.key)"
                                            pattern="[0-9]*[.]?[0-9]*" name="pc_target" required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="pc_ap_pica">AP/PICA</label>
                                        <select class="form-control" name="pc_ap_pica" required>
                                            <option value="pc">PICA</option>
                                            <option value="ap">AP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_problem" class="ms-0">Problem Statement </label>
                                        <textarea class="form-control" name="pc_problem" placeholder="-- Masukkan Problem --" id="pc_problem"
                                            rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="pc_kp">Kategori Problem </label>
                                        <select class="form-control" name="pc_kp" id="pc_kp" required>
                                            <option value="">-- Pilih Kategori Problem --</option>
                                            @foreach ($dataKategory as $d)
                                                <option value="{{ $d['id'] }}">{{ $d['text'] }}</option>
                                            @endForeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="scrollable-div border" id="scrollableDiv">
                                    <div class="zoomable-content" id="zoomableContent">
                                        <!-- Add your large content here -->
                                        <div style="width: 5000px; height: 1500px;" id="dataWHYYYYY">
                                            @include('SmartForm::smartpica/input-why-dinamis')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-static my-4" style="display: none">
                                <label class="form-label">Pilih Jumlah Estimasi dari Solusi Step PICA
                                    diatas</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="pc_es" id="pc_es" required>
                                        <option value='5'>5</option>
                                        <?php for ($i = 1; $i < 11; $i++) {
                                            echo '<option value=' . $i . '>' . $i . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                onclick="SubmitAllDataWhy()">
                                <i class="fas fa-save"></i>
                                Save All Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script type="text/javascript">
        // $('#states').select2({
        //     dropdownParent: $('#parent')
        // });

        $('#pc_kpi').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#pc_kpi').closest('.ayyyyy'),
            placeholder: '--- Cari/Pilih KPI Leading ---',
            ajax: {
                url: "/helper/kpi-lead-datalist",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "post",
                delay: 250,
                dataType: 'json',
                data: function(params) {
                    return {
                        query: params.term, // search term
                        dept: $('#pc_dept').val()
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

        $('#pc_kpi').on('select2:open', function(e) {
            const evt = "scroll.select2";
            $(e.target).parents().off(evt);
            $(window).off(evt);
        });

        // $('#pc_thn, #pc_bln').change(function() {
        //     // Mendapatkan nilai tahun dan bulan yang dipilih
        //     var tahun = $('#pc_thn').val();
        //     var bulan = $('#pc_bln').val();

        //     // Jika tahun dan bulan telah dipilih
        //     if (tahun !== '' && bulan !== '') {
        //         // Aktifkan dropdown #pc_week
        //         $('#pc_week').prop('disabled', false);

        //         // Lakukan request Ajax untuk mendapatkan data week
        //         $.ajax({
        //             url: '/helper/week', // Ganti dengan URL yang sesuai untuk permintaan Ajax Anda
        //             type: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: {
        //                 tahun: tahun,
        //                 bulan: bulan
        //             },
        //             dataType: 'json',
        //             success: function(response) {
        //                 $('#pc_week').empty();

        //                 for (let i = 0; i < response.data.length; i++) {
        //                     $('#pc_week').append('<option value="' + response.data[i] + '">' + response
        //                         .data[i] + '</option>');
        //                 }
        //                 $('#pc_week').prop("disable", false);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('Terjadi kesalahan dalam melakukan request Ajax: ' + error);
        //                 // Optionally, handle errors here
        //             }
        //         });
        //     } else {
        //         // Jika tahun atau bulan belum dipilih, nonaktifkan dropdown #pc_week
        //         $('#pc_week').prop('disabled', true);
        //         // Kosongkan opsi dropdown
        //         $('#pc_week').empty().append('<option value="">-- Pilih Week --</option>');
        //     }
        // });

        $('#pc_site').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5.
            dropdownParent: $('#pc_site').closest('.input-group'),
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

        $('#pc_site').on('select2:open', function(e) {
            const evt = "scroll.select2";
            $(e.target).parents().off(evt);
            $(window).off(evt);
        });

        $('#pc_dept').select2({
            theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
            dropdownParent: $('#pc_dept').closest('.input-group'),
            placeholder: '--- Cari Department ---',
            ajax: {
                url: "/helper/department",
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

        $('#pc_dept').on('select2:open', function(e) {
            const evt = "scroll.select2";
            $(e.target).parents().off(evt);
            $(window).off(evt);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#scrollableDiv').scrollTop(0).scrollLeft(0);
        });
        document.addEventListener('DOMContentLoaded', (event) => {
            const scrollableDiv = document.getElementById('scrollableDiv');
            const zoomableContent = document.getElementById('zoomableContent');
            let scale = 1;
            const scaleStep = 0.1; // Incremental scale step

            scrollableDiv.addEventListener('wheel', (event) => {
                if (event.ctrlKey) {
                    event.preventDefault();

                    // Determine cursor position relative to zoomableContent
                    const rect = zoomableContent.getBoundingClientRect();
                    const mouseX = event.clientX - rect.left;
                    const mouseY = event.clientY - rect.top;

                    // Calculate current transformation origin
                    const currentOriginX = mouseX / rect.width;
                    const currentOriginY = mouseY / rect.height;

                    // Update scale based on scroll direction and incremental step
                    if (event.deltaY < 0) {
                        scale = Math.min(scale + scaleStep, 3); // Increase scale gradually
                    } else {
                        scale = Math.max(scale - scaleStep, 0.5); // Decrease scale gradually
                    }

                    // Calculate new transformation origin
                    const newOriginX = mouseX / rect.width;
                    const newOriginY = mouseY / rect.height;

                    // Adjust transformation origin and apply scale transform
                    zoomableContent.style.transformOrigin = `${newOriginX * 100}% ${newOriginY * 100}%`;
                    zoomableContent.style.transform = `scale(${scale})`;
                }
            });
        });
    </script>
    <script type="text/javascript">
        function SubmitAllDataWhy() {

            let actual = parseFloat($('#pc_aktual').val());
            let target = parseFloat($('#pc_target').val());

            // if (actual > target) {
            //     Swal.fire({
            //         icon: "error",
            //         title: "Validation Error",
            //         html: "Actual tidak boleh lebih dari Target",
            //         confirmButtonText: 'OK'
            //     });
            //     return false;
            // }

            let getAllDataWhy1 = [];
            let isValid = true;
            let errorMessage = '';

            for (let i = 1; i <= listOFWhy1.length; i++) {
                let masalah = $(`#input-m-w1-${i}`).val();
                let kategory = $(`#input-k-w1-${i}`).val();
                let data = {
                    w1: i,
                    masalah: masalah,
                    kategori: kategory
                }
                getAllDataWhy1.push(data);

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${i} is required.<br>`;
                }

                if (kategory === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${i} is required.<br>`;
                }
            }

            let getAllDataWhy2 = listOFWhy2.map(item => {
                let w1 = item.w1;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-w2-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-w2-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${position} is required.<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${position} is required.<br>`;
                }

                return {
                    w1: w1,
                    w2: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });

            let getAllDataWhy3 = listOFWhy3.map(item => {
                let w1 = item.w1;
                let w2 = item.w2;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-${w2}-w3-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-${w2}-w3-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${w2} W3-${position} is required.<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${w2} W3-${position} is required.<br>`;
                }

                return {
                    w1: w1,
                    w2: w2,
                    w3: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });

            let getAllDataWhy4 = listOFWhy4.map(item => {
                let w1 = item.w1;
                let w2 = item.w2;
                let w3 = item.w3;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-${w2}-${w3}-w4-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-${w2}-${w3}-w4-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${w2} W3-${w3} W4-${position} is required.<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${w2} W3-${w3} W4-${position} is required.<br>`;
                }

                return {
                    w1: w1,
                    w2: w2,
                    w3: w3,
                    w4: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });

            let getAllDataWhy5 = listOFWhy5.map(item => {
                let w1 = item.w1;
                let w2 = item.w2;
                let w3 = item.w3;
                let w4 = item.w4;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-${w2}-${w3}-${w4}-w5-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-${w2}-${w3}-${w4}-w5-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage +=
                        `Masalah for W1-${w1} W2-${w2} W3-${w3} W4-${w4} W5-${position} is required.<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage +=
                        `Kategori for W1-${w1} W2-${w2} W3-${w3} W4-${w4} W5-${position} is required.<br>`;
                }

                return {
                    w1: w1,
                    w2: w2,
                    w3: w3,
                    w4: w4,
                    w5: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });



            let pc_thn = $('#pc_thn').val();
            let pc_bln = $('#pc_bln').val();
            let pc_week = $('#pc_week').val();
            let pc_site = $('#pc_site').val();
            let pc_kpi = $('#pc_kpi').val();
            let pc_dept = $('#pc_dept').val();
            let pc_aktual = $('#pc_aktual').val();
            let pc_target = $('#pc_target').val();
            let pc_ap_pica = $('select[name="pc_ap_pica"]').val();
            let pc_problem = $('#pc_problem').val();
            let pc_kp = $('#pc_kp').val();
            let pc_es = $('#pc_es').val();



            // Helper function to validate and highlight
            function validateField(field, fieldName, fieldLabel) {
                if (field === '' || field == null) {
                    isValid = false;
                    errorMessage += `${fieldLabel} is required.<br>`;
                }
            }

            validateField(pc_thn, 'pc_thn', 'Tahun');
            validateField(pc_bln, 'pc_bln', 'Bulan');
            validateField(pc_week, 'pc_week', 'Minggu');
            validateField(pc_dept, 'pc_dept', 'Department');
            validateField(pc_site, 'pc_site', 'Site');
            validateField(pc_kpi, 'pc_kpi', 'KPI');
            validateField(pc_aktual, 'pc_aktual', 'Aktual');
            validateField(pc_target, 'pc_target', 'Target');
            validateField(pc_ap_pica, 'pc_ap_pica', 'AP PICA');
            validateField(pc_problem, 'pc_problem', 'Problem');
            validateField(pc_kp, 'pc_kp', 'Kategori Problem');
            validateField(pc_es, 'pc_es', 'Estimated Solution');

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessage,
                    confirmButtonText: 'OK'
                });
            }


            let dataKirim = {
                dataMaster: {
                    tahun: pc_thn,
                    bulan: pc_bln,
                    week: pc_week,
                    dept: pc_dept,
                    site: pc_site,
                    lead_kpi: pc_kpi,
                    actual: pc_aktual,
                    target: pc_target,
                    ap_pica: pc_ap_pica,
                    problem: pc_problem,
                    kategori: pc_kp,
                    estimasi_pica: pc_es,
                },
                dataWhy1: getAllDataWhy1,
                dataWhy2: getAllDataWhy2,
                dataWhy3: getAllDataWhy3,
                dataWhy4: getAllDataWhy4,
                dataWhy5: getAllDataWhy5,
            };

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "add-transaction",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            reset();
                            window.location.href = `/smart-pica/create-step/${response.nodoc}`;
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

        function reset() {
            $('#pc_thn').prop('selectedIndex', 0);

            $('#pc_bln').prop('selectedIndex', 0);

            $('#pc_week').prop('selectedIndex', 0);

            $('#pc_site').val(null).trigger('change');

            $('#pc_kpi').val(null).trigger('change');

            $('#pc_aktual').val('');

            $('#pc_target').val('');

            $('#pc_ap_pica').prop('selectedIndex', 0);

            $('#pc_problem').val('');

            $('#pc_kp').prop('selectedIndex', 0);

            let dataHTMLBaru = `
            <div class="row rw-1 " style="margin:3em; font-size:11px;">
                <div class="col cl-1 master" style="margin: 0px !important">
                    <div class="row row-cols-6 r1">
                        <div class="col-2">
                            <fieldset style="margin: 30px">
                                <legend style="width: auto">Why 1</legend>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group input-group-static my-4">
                                            <label class="ms-0" for="input-m-w1-1">Why 1 - 1</label>
                                            <textarea type="textarea" id="input-m-w1-1" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-static my-4">
                                            <label for="input-k-w1-1" class="ms-0 kategory-why">Kategori </label>
                                            <select class="form-control" name="input-k-w1-1" id="input-k-w1-1" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                ${optionsHtml}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex justify-content-center align-items-center">
                                        <button type="button" onclick="AddWhy2(1,1)" class="btn btn-primary">Why2</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row rw-1 " style="margin:3em; font-size:11px;">
                <div class="col-5 d-flex justify-content-start align-items-left">
                    <button type="button" class="btn btn-primary" onclick="AddWhy1()">Why1</button>
                </div>
            </div>`
            listOFWhy1 = [1];
            listOFWhy2 = [];
            listOFWhy3 = [];
            listOFWhy4 = [];
            listOFWhy5 = [];
            initialWhy1 = 1;
            rowCount = 1;

            $('#dataWHYYYYY').html(dataHTMLBaru);
        }
    </script>
    <script type="text/javascript">
        function checkDataWhy2(list, w1) {
            var maxPosition = null;
            var result = [];
            $.each(list, function(index, item) {
                if (item.w1 === w1) {
                    if (maxPosition === null || item.position > maxPosition) {
                        maxPosition = item.position;
                        result = [item]; // Reset result array with the new max position item
                    } else if (item.position === maxPosition) {
                        result.push(item); // Add to result array if position matches current max
                    }
                }
            });
            return result;
        }

        function checkDataWhy3(list, w1, w2) {
            let maxPosition = null;
            let result = [];
            $.each(list, function(index, item) {
                if (item.w1 === w1 && item.w2 === w2) {
                    if (maxPosition === null || item.position > maxPosition) {
                        maxPosition = item.position;
                        result = [item]; // Reset result array with the new max position item
                    } else if (item.position === maxPosition) {
                        result.push(item); // Add to result array if position matches current max
                    }
                }
            });
            return result;
        }

        function checkDataWhy4(list, w1, w2, w3) {
            let maxPosition = null;
            let result = [];
            $.each(list, function(index, item) {
                if (item.w1 === w1 && item.w2 === w2 && item.w3 === w3) {
                    if (maxPosition === null || item.position > maxPosition) {
                        maxPosition = item.position;
                        result = [item]; // Reset result array with the new max position item
                    } else if (item.position === maxPosition) {
                        result.push(item); // Add to result array if position matches current max
                    }
                }
            });
            return result;
        }

        function checkDataWhy5(list, w1, w2, w3, w4) {
            let maxPosition = null;
            let result = [];
            $.each(list, function(index, item) {
                if (item.w1 === w1 && item.w2 === w2 && item.w3 === w3 && item.w4 === w4) {
                    if (maxPosition === null || item.position > maxPosition) {
                        maxPosition = item.position;
                        result = [item]; // Reset result array with the new max position item
                    } else if (item.position === maxPosition) {
                        result.push(item); // Add to result array if position matches current max
                    }
                }
            });
            return result;
        }

        function UpdateRowW2(list, w1, position, newRow) {
            $.each(list, function(index, item) {
                if (item.w1 === w1 && item.position === position) {
                    item.row = newRow;
                }
            });
        }

        function UpdateRowW3(list, w1, w2, position, newRow) {
            $.each(list, function(index, item) {
                if (item.w1 === w1 && item.w2 === w2 && item.position === position) {
                    item.row = newRow;
                }
            });
        }

        function UpdateRowW4(list, w1, w2, w3, position, newRow) {
            $.each(list, function(index, item) {
                if (item.w1 === w1 && item.w2 === w2 && item.w3 === w3 && item.position === position) {
                    item.row = newRow;
                }
            });
        }

        function removeObjectFromLists(objectString, ...lists) {
            // var objectString = JSON.stringify(objectToRemove);
            lists.forEach(function(list, index) {
                lists.forEach(function(list) {
                    for (var i = list.length - 1; i >= 0; i--) {
                        var itemString = JSON.stringify(list[i]);
                        if (itemString === objectString) {
                            list.splice(i, 1); // Hapus objek dari array
                        }
                    }
                });
            });
        }

        function removeFieldset(idDiv, kordinatObj, why) {
            if (why == 1) {
                listOFWhy1.pop();
            } else {
                removeObjectFromLists(kordinatObj, listOFWhy2, listOFWhy3, listOFWhy4, listOFWhy5);
            }
            var divElement = $('#divWHY_' + idDiv);
            $(`#${idDiv}`).remove();


        }
    </script>
    <script type="text/javascript">
        var listOFWhy1 = [1];
        var listOFWhy2 = [];
        var listOFWhy3 = [];
        var listOFWhy4 = [];
        var listOFWhy5 = [];
        var initialWhy1 = 1;
        var rowCount = 1;
        var optionsHtml = '';
        var identityDIV = 2;
        <?php foreach ($dataKategory as $d): ?>
        optionsHtml += '<option value="<?php echo $d['id']; ?>"><?php echo $d['text']; ?></option>';
        <?php endforeach; ?>

        function AddWhy1() {
            rowCount += 1;
            initialWhy1 += 1;
            identityDIV += 1;
            listOFWhy1.push(initialWhy1);
            // Generate options HTML from PHP data
            let dataKirimJson = JSON.stringify(listOFWhy1)

            // Append new Why1 fieldset
            $(".master").append(`
                <div class="row row-cols-6 r${rowCount}">
                    <div class="col-2">
                        <fieldset style="margin: 30px" id="divWHY_${identityDIV}">
                            <legend style="width: auto">Why 1 - ${initialWhy1}</legend>
                            <button type="button" id="remove_w1-${initialWhy1}" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}', '${dataKirimJson}', '1')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-w1-${initialWhy1}">Why 1 - ${initialWhy1}</label>
                                        <textarea type="textarea" id="input-m-w1-${initialWhy1}" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-w1-${initialWhy1}" class="ms-0">Kategori</label>
                                        <select class="form-control" name="input-k-w1-${initialWhy1}" id="input-k-w1-${initialWhy1}" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary" onClick="AddWhy2(${rowCount}, ${initialWhy1}, 'remove_w1-${initialWhy1}')">Why2</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            `);
        }

        function AddWhy2(row, why1, removeID) {
            $(`#${removeID}`).addClass("d-none");
            identityDIV += 1;
            let dataTerakhiW2 = checkDataWhy2(listOFWhy2, why1);
            if (dataTerakhiW2.length != 0 && dataTerakhiW2[0].position == 5) {
                return false;
            }
            if (dataTerakhiW2.length == 0) {
                let dataObject2 = {
                    row: row,
                    w1: why1,
                    position: 1
                }
                listOFWhy2.push(dataObject2);
                $dataStringify = JSON.stringify(dataObject2).replace(/'/g, "&apos;").replace(/"/g, '&quot;');

                let dataDIV = `
                    <div class="col-2" id="divWHY_${identityDIV}">
                        <fieldset style="margin: 30px" >
                            <legend style="width: auto">Why 2</legend>
                            <button type="button" id="remove_${why1}-w2-1" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','2')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${why1}-w2-1">Why 2 - 1</label>
                                        <textarea type="textarea" id="input-m-${why1}-w2-1" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${why1}-w2-1" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${why1}-w2-1" id="input-k-${why1}-w2-1" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" onClick="AddWhy3(${row},${why1},1,'remove_${why1}-w2-1')" class="btn btn-primary">Why 3</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                `;
                $(`.r${row}`).append(dataDIV);
            } else {
                $(`#remove_${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position}`).addClass("d-none");
                rowCount += 1;
                let dataObject2 = {
                    row: rowCount,
                    w1: why1,
                    position: dataTerakhiW2[0].position + 1
                }
                listOFWhy2.push(dataObject2);
                $dataStringify = JSON.stringify(dataObject2).replace(/'/g, "&apos;").replace(/"/g, '&quot;');

                var newData = `
                <div class="row row-cols-6 r${rowCount}">
                    <div class="col-2">
                        <div class="line"></div>
                    </div>
                    <div class="col-2">
                        <fieldset style="margin: 30px" id="divWHY_${identityDIV}">
                            <legend style="width: auto">Why 2 - ${dataTerakhiW2[0].position + 1}</legend>
                            <button type="button" id="remove_${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','2')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}">Why 2 - ${dataTerakhiW2[0].position + 1}</label>
                                        <textarea type="textarea" id="input-m-${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}" id="input-k-${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" onClick="AddWhy3(${rowCount},${dataTerakhiW2[0].w1},${dataTerakhiW2[0].position + 1}, 'remove_${dataTerakhiW2[0].w1}-w2-${dataTerakhiW2[0].position + 1}')"  class="btn btn-primary">Why 3</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            `;

                $(`.r${dataTerakhiW2[0].row}`).after(newData);
                let $newElement = $(`.r${dataTerakhiW2[0].row}`).next(); // Selecting the newly added element

                // Scroll to the position of the new element
                if ($newElement.length) {
                    $('html, body').animate({
                        scrollTop: $newElement.offset().top - 100 // Adjust as needed for any offset
                    }, 10); // Adjust scroll speed as needed
                }
            }
        }

        function AddWhy3(row, why1, why2, removeID) {
            $(`#${removeID}`).addClass("d-none");
            let dataTerakhiW3 = checkDataWhy3(listOFWhy3, why1, why2);
            identityDIV += 1;
            if (dataTerakhiW3.length != 0 && dataTerakhiW3[0].position == 5) {
                return false;
            }

            if (dataTerakhiW3.length == 0) {
                let dataObject3 = {
                    row: row,
                    w1: why1,
                    w2: why2,
                    position: 1
                }

                listOFWhy3.push(dataObject3);
                $dataStringify = JSON.stringify(dataObject3).replace(/'/g, "&apos;").replace(/"/g, '&quot;');

                let dataDIV = `
                    <div class="col-2" id="divWHY_${identityDIV}">
                        <fieldset style="margin: 30px">
                            <legend style="width: auto">Why 3</legend>
                            <button type="button" id="remove_${why1}-${why2}-w3-1" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','3')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${why1}-${why2}-w3-1">Why 3 - 1</label>
                                        <textarea type="textarea" id="input-m-${why1}-${why2}-w3-1" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${why1}-${why2}-w3-1" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${why1}-${why2}-w3-1" id="input-k-${why1}-${why2}-w3-1" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" onClick="AddWhy4(${row},${why1}, ${why2}, 1, 'remove_${why1}-${why2}-w3-1')" class="btn btn-primary">Why 4</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                `;

                $(`.r${row}`).append(dataDIV);
            } else {
                $(`#remove_${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position}`).addClass(
                    "d-none");
                rowCount += 1;
                UpdateRowW2(listOFWhy2, why1, why2, rowCount);
                let dataObject3 = {
                    row: rowCount,
                    w1: why1,
                    w2: why2,
                    position: dataTerakhiW3[0].position + 1
                }
                listOFWhy3.push(dataObject3);

                $dataStringify = JSON.stringify(dataObject3).replace(/'/g, "&apos;").replace(/"/g, '&quot;');

                var newData = `
                <div class="row row-cols-6 r${rowCount}">
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2" id="divWHY_${identityDIV}">
                        <fieldset style="margin: 30px" >
                            <legend style="width: auto">Why 3</legend>
                            <button type="button" id="remove_${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position + 1}" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','3')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position + 1}">Why 3 - ${dataTerakhiW3[0].position + 1}</label>
                                        <textarea type="textarea" id="input-m-${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position + 1}" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w1}-w3-1" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position + 1}" id="input-k-${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position + 1}" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" onClick="AddWhy4(${rowCount},${dataTerakhiW3[0].w1}, ${dataTerakhiW3[0].w2}, ${dataTerakhiW3[0].position + 1}, 'remove_${dataTerakhiW3[0].w1}-${dataTerakhiW3[0].w2}-w3-${dataTerakhiW3[0].position + 1}')" class="btn btn-primary">Why 4</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            `;

                $(`.r${dataTerakhiW3[0].row}`).after(newData);
            }
        }

        function AddWhy4(row, why1, why2, why3, removeID) {
            $(`#${removeID}`).addClass("d-none");
            let dataTerakhiW4 = checkDataWhy4(listOFWhy4, why1, why2, why3);
            identityDIV += 1;
            if (dataTerakhiW4.length != 0 && dataTerakhiW4[0].position == 5) {
                return false;
            }

            if (dataTerakhiW4.length == 0) {
                let dataObject4 = {
                    row: row,
                    w1: why1,
                    w2: why2,
                    w3: why3,
                    position: 1
                }

                listOFWhy4.push(dataObject4);
                $dataStringify = JSON.stringify(dataObject4).replace(/'/g, "&apos;").replace(/"/g, '&quot;');


                let dataDIV = `
                    <div class="col-2" id="divWHY_${identityDIV}">
                        <fieldset style="margin: 30px">
                            <legend style="width: auto">Why 4</legend>
                            <button type="button" id="remove_${why1}-${why2}-${why3}-w4-1" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','4')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${why1}-${why2}-${why3}-w4-1">Why 4 - 1</label>
                                        <textarea type="textarea" id="input-m-${why1}-${why2}-${why3}-w4-1" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${why1}-${why2}-${why3}-w4-1" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${why1}-${why2}-${why3}-w4-1" id="input-k-${why1}-${why2}-${why3}-w4-1" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" onClick="AddWhy5(${row},${why1}, ${why2}, ${why3}, 1, 'remove_${why1}-${why2}-${why3}-w4-1')" class="btn btn-primary">Why 5</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                `;

                $(`.r${row}`).append(dataDIV);
            } else {
                $(`#remove_${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position}`)
                    .addClass("d-none");
                rowCount += 1;
                UpdateRowW2(listOFWhy2, why1, why2, rowCount);
                UpdateRowW3(listOFWhy3, why1, why2, why3, rowCount);

                let dataObject4 = {
                    row: rowCount,
                    w1: why1,
                    w2: why2,
                    w3: why3,
                    position: dataTerakhiW4[0].position + 1
                }
                listOFWhy4.push(dataObject4);
                $dataStringify = JSON.stringify(dataObject4).replace(/'/g, "&apos;").replace(/"/g, '&quot;');

                var newData = `
                <div class="row row-cols-6 r${rowCount}">
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2" id="divWHY_${identityDIV}">
                        <fieldset style="margin: 30px">
                            <legend style="width: auto">Why 4</legend>
                            <button type="button" id="remove_${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','4')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}">Why 4 - ${dataTerakhiW4[0].position + 1}</label>
                                        <textarea type="textarea" id="input-m-${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}" id="input-k-${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" onClick="AddWhy5(${rowCount},${dataTerakhiW4[0].w1}, ${dataTerakhiW4[0].w2},${dataTerakhiW4[0].w3}, ${dataTerakhiW4[0].position + 1},'remove_${dataTerakhiW4[0].w1}-${dataTerakhiW4[0].w2}-${dataTerakhiW4[0].w3}-w4-${dataTerakhiW4[0].position + 1}')" class="btn btn-primary">Why 5</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            `;
                $(`.r${dataTerakhiW4[0].row}`).after(newData);
            }
        }

        function AddWhy5(row, why1, why2, why3, why4, removeID) {
            $(`#${removeID}`).addClass("d-none");
            let dataTerakhiW5 = checkDataWhy5(listOFWhy5, why1, why2, why3, why4);
            identityDIV += 1;
            if (dataTerakhiW5.length != 0 && dataTerakhiW5[0].position == 5) {
                return false;
            }
            if (dataTerakhiW5.length == 0) {
                let dataObject5 = {
                    row: row,
                    w1: why1,
                    w2: why2,
                    w3: why3,
                    w4: why4,
                    position: 1
                }
                listOFWhy5.push(dataObject5);
                $dataStringify = JSON.stringify(dataObject5).replace(/'/g, "&apos;").replace(/"/g, '&quot;');
                let dataDIV = `
                    <div class="col-2" id="divWHY_${identityDIV}">
                        <fieldset style="margin: 30px">
                            <legend style="width: auto">Why 5</legend>
                            <button type="button" id="remove_${why1}-${why2}-${why3}-${why4}-w5-1" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','5')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${why1}-${why2}-${why3}-${why4}-w5-1">Why 5 - 1</label>
                                        <textarea type="textarea" id="input-m-${why1}-${why2}-${why3}-${why4}-w5-1" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${why1}-${why2}-${why3}-${why4}-w5-1" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${why1}-${why2}-${why3}-${why4}-w5-1" id="input-k-${why1}-${why2}-${why3}-${why4}-w5-1" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                `;
                $(`.r${row}`).append(dataDIV);
            } else {
                $(`#remove_${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w2}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position }`)
                    .addClass("d-none");
                rowCount += 1;
                UpdateRowW2(listOFWhy2, why1, why2, rowCount);
                UpdateRowW3(listOFWhy3, why1, why2, why3, rowCount);
                UpdateRowW4(listOFWhy4, why1, why2, why3, why4, rowCount);
                let dataObject5 = {
                    row: rowCount,
                    w1: why1,
                    w2: why2,
                    w3: why3,
                    w4: why4,
                    position: dataTerakhiW5[0].position + 1
                }
                listOFWhy5.push(dataObject5);
                $dataStringify = JSON.stringify(dataObject5).replace(/'/g, "&apos;").replace(/"/g, '&quot;');

                var newData = `
                <div class="row row-cols-6 r${rowCount}">
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                        <fieldset style="margin: 30px" id="divWHY_${identityDIV}">
                            <legend style="width: auto">Why 5</legend>
                            <button type="button" id="remove_${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w2}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position + 1}" class="close-button-why" onclick="removeFieldset('divWHY_${identityDIV}','${$dataStringify}','4')">X</button>
                            <div class="row">
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="input-m-${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w2}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position + 1}">Why 5 - ${dataTerakhiW5[0].position + 1}</label>
                                        <textarea type="textarea" id="input-m-${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w2}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position + 1}" rows="1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group input-group-static my-4">
                                        <label for="input-k-${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position + 1}" class="ms-0">Kategori </label>
                                        <select class="form-control" name="input-k-${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w2}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position + 1}" id="input-k-${dataTerakhiW5[0].w1}-${dataTerakhiW5[0].w2}-${dataTerakhiW5[0].w3}-${dataTerakhiW5[0].w4}-w5-${dataTerakhiW5[0].position + 1}" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            `;

                $(`.r${dataTerakhiW5[0].row}`).after(newData);
                // let $newElement = $(`.r${dataTerakhiW5[0].row}`).next(); // Selecting the newly added element

                // // Scroll to the position of the new element
                // if ($newElement.length) {
                //     $('html, body').animate({
                //         scrollTop: $newElement.offset().top - 100 // Adjust as needed for any offset
                //     }, 500); // Adjust scroll speed as needed
                // }
            }
        }
    </script>
@endsection
