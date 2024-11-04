@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

        /* Hide the datepicker button */
        .gj-datepicker button {
            display: none !important;
        }


        .select2-container--bootstrap-5 .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            /* Menyesuaikan dengan form-control di Bootstrap 5 */
        }

        /* Menyesuaikan tinggi baris teks dalam pilihan */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px);
        }

        #leading-kpi-group {
            position: relative;
        }

        #leading-kpi-group label {
            position: absolute;
            top: -10px;
            left: 10px;
            background-color: white;
            padding: 0 5px;
            font-size: 12px;
            transition: all 0.3s;
            z-index: 1;
            /* Ensure the label is above the select field */
        }

        #leading-kpi-group select {
            width: 100%;
            /* Ensure the select field takes full width */
            padding-top: 20px;
            /* Adjust padding to avoid overlap with label */
            padding-left: 10px;
            padding-right: 10px;
            background-color: white;
            font-size: 12px;
            transition: all 0.3s;
            margin-top: 10px;
            /* Add margin to push select field down */
            z-index: 0;
            /* Ensure the select field is below the label */
        }

        #leading-kpi-group .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            /* Adjust to match the height of a typical form-control */
            padding-top: 20px;
            /* Ensure padding for select2 */
        }

        #leading-kpi-group .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 6px;
        }

        #leading-kpi-group .select2-container {
            width: 100% !important;
        }

        #leading-kpi-group .select2-container--default .select2-selection--single {
            padding-top: 6px;
        }

        #leading-kpi-group .form-control,
        #leading-kpi-group .select2-container--default .select2-selection--single {
            padding-top: 20px;
        }

        /* Style to ensure label stays above the Select2 input */
        #leading-kpi-group .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">FORM STEP SOLUTION PICA</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Creator : {{ session('username') }}
                                    {{-- session()->get('name') . ' - ' . session()->get('dept') . ' - ' . session()->get('site') --}}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center"
                                            aria-selected="true">
                                            <i class="fas fa-key"> No Document : </i>
                                            <span class="ms-2">{{ $dataMaster[0]->nodocpica }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark my-sm-3">

                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Tahun</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ $dataMaster[0]->tahun }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Bulan</label>
                        @php
                            use Carbon\Carbon;
                            $namaBulan = Carbon::createFromDate(null, $dataMaster[0]->bulan, 1)->format('F');
                        @endphp

                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $namaBulan }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Week</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext"
                                value="Week {{ $dataMaster[0]->week }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Site</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ $dataMaster[0]->site }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Leading KPI</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext" value="{{ $dataMaster[0]->kpi }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Actual</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ $dataMaster[0]->actual_master }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Target</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ $dataMaster[0]->target_master }}">
                        </div>
                    </div>
                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">AP/PICA</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ isset($dataMaster[0]) && $dataMaster[0]->ap_pica === 'pc' ? 'PICA' : 'AP' }}">
                        </div>
                    </div>

                    <hr class="horizontal dark my-sm-3">

                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Problem</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ $dataMaster[0]->problem }}">
                        </div>
                    </div>

                    <div class="row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Kategory</label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control-plaintext"
                                value="{{ $dataMaster[0]->kp_name }}">
                        </div>
                    </div>
                    <br>


                    @foreach ($dataMasalahTerakhir as $key => $item)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Problem {{ $key + 1 }}</h5>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" value="asdad" id="floatingTextarea2"
                                                style="height: 150px" disabled>{{ $item->why }}</textarea>
                                            <label for="floatingTextarea2">Problem</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="exampleFormControlInput1"
                                                        class="form-label">Kategori</label>
                                                    <input type="email" class="form-control"
                                                        id="exampleFormControlInput1" value="{{ $item->kp_name }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button class="btn btn-primary ms-auto uploadBtn"
                                                    id="button_open_modal_solution_{{ $key }}"
                                                    onclick="OpenModal({{ json_encode($item) }},{{ $key }})">
                                                    <i class="fas fa-save"></i>
                                                    SOLUTION STEP</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach



                    <input type="hidden" name="pc_no" value="1">
                    <div class="card-body"></div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                onclick="SubmitAllDataAndBack()">
                                <i class="fas fa-save"></i>
                                Save All Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="stepSolution" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <input type="hidden" name="IdentityWhy" id="IdentityWhy" value="">
                <input type="hidden" name="idWhy" id="idWhy" value="">
                <input type="hidden" name="nodocWhy" id="nodocWhy" value="">
                <input type="hidden" name="idMaster" id="idMaster" value="">
                <input type="hidden" name="nikMaster" id="nikMaster" value="">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">FORM Step Solution</h5>
                            <p id="ProblemHeader"></p>

                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="" id="DataStepMasuk">
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="row" style="margin: 10px">
                            <input type="hidden" name="editID_{{ $i }}" id="editID_{{ $i }}"
                                value="">
                            <div class="col">
                                <div class="card border" style="">
                                    <div class="card-body">
                                        <h5 class="card-title">Solution {{ $i }}
                                            <p id="pic_exist_{{ $i }}"></p>
                                            <p id="atasan_exist_{{ $i }}"></p>
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="input-group input-group-static my-4">
                                                    <label for="pc_action_{{ $i }}"
                                                        class="ms-0">Action</label>
                                                    <select class="form-control" name="pc_action_{{ $i }}"
                                                        id="pc_action_{{ $i }}" required>
                                                        <option value="">-- Pilih Action --</option>
                                                        <option value="ca">Corrective</option>
                                                        <option value="pa">Preventive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group input-group-static my-4">
                                                    <label for="pc_aktual_{{ $i }}" class="ms-0">Note
                                                        Step</label>
                                                    <input class="form-control" type="text" inputmode="decimal"
                                                        placeholder="Masukkan note untuk PIC"
                                                        name="pc_aktual_{{ $i }}" required
                                                        id="pc_aktual_{{ $i }}">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="input-group input-group-static my-4">
                                                    <label class="ms-0"
                                                        for="pc_ap_pica_{{ $i }}">AP/TOD</label>
                                                    <select class="form-control" name="pc_ap_pica_{{ $i }}"
                                                        required>
                                                        <option value="ap">AP</option>
                                                        <option value="tod">TOD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4" style="">
                                                <div class="input-group input-group-static my-4">
                                                    <label for="dicID_{{ $i }}" class="">Department in
                                                        Charge (DIC)</label>
                                                    <select class="form-control DICDepartment"
                                                        name="dicID_{{ $i }}" id="dicID_{{ $i }}"
                                                        required>
                                                        @foreach ($dataDepartment as $q)
                                                            <option value="{{ $q->KodeDP }}">
                                                                {{ $q->Nama . ' - ' . $q->KodeDP }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="">
                                                <div class="input-group input-group-static my-4">
                                                    <input type="hidden" name="hiddenPIC_{{ $i }}"
                                                        id="hiddenPIC_{{ $i }}">
                                                    <label for="picID_{{ $i }}" class="">Person In
                                                        Charge
                                                        (PIC)</label>
                                                    <select class="form-control picIDHuman"
                                                        name="picID_{{ $i }}"
                                                        id="picID_{{ $i }}"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="hidden" name="hiddenAtasan_{{ $i }}"
                                                    id="hiddenAtasan_{{ $i }}">
                                                <label for="DueDate_{{ $i }}" class="">Due Date
                                                    (PIC)</label>
                                                <div class="input-group input-group-static d-flex">
                                                    <input class="form-control due-date-picker" type="text"
                                                        placeholder="DD/MM/YYYY" name="DueDate_{{ $i }}"
                                                        required id="DueDate_{{ $i }}">
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="horizontal dark my-sm-3">
                                        <div class="row">
                                            <div class="col-md-4" style="">
                                                <div class="input-group input-group-static my-4">
                                                    <label for="atasan_ID_{{ $i }}" class="">Atasan
                                                        (PIC)</label>
                                                    <select class="form-control picIDAtasan"
                                                        name="atasan_ID_{{ $i }}"
                                                        id="atasan_ID_{{ $i }}"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>


                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end" id="masukkanButtonSubmit">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        function resetFormStep() {
            for (let i = 1; i <= 5; i++) {
                // Reset select elements
                $(`#pc_action_${i}`).val("");
                $(`#pc_aktual_${i}`).val("");
                $(`#pc_ap_pica_${i}`).val('pc');
                $(`#dicID_${i}`).val(null).trigger('change');
                $(`#picID_${i}`).val(null).trigger('change');
                $(`#atasan_ID_${i}`).val(null).trigger('change');
                $(`#DueDate_${i}`).val("");
                $(`#hiddenPIC_${i}`).val("");
                $(`#hiddenAtasan_${i}`).val("");
                $(`#pic_exist_${i}`).html("");
                $(`#atasan_exist_${i}`).html("");
            }
        }

        $('.due-date-picker').each(function() {
            $(this).datepicker({
                uiLibrary: 'bootstrap5', // or 'bootstrap5' if you're using Bootstrap 5
                format: 'dd mmmm yyyy',
                weekStartDay: 0,
            })
        });

        function formatDate(dateString) {
            let dateParts = dateString.split('-');
            if (dateParts[2].length === 1) {
                dateParts[2] = '0' + dateParts[2];
            }
            let date = new Date(`${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`);
            let options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return date.toLocaleDateString('en-GB', options);
        }

        function OpenModal(obj, key) {
            resetFormStep();
            let objString = JSON.stringify(obj).replace(/"/g, '&quot;');
            let dataHtml = `<button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA_{{ $key }}"
                            onclick="submitDataStepSolution(${key})">
                            <i class="fas fa-save"></i>
                            Submit Data</button>`
            $('#ProblemHeader').html("Problem   : " + obj.why);
            $('#KategoriHeader').html("Kategori : " + obj.kp_name);
            $('#IdentityWhy').val(obj.identity);
            $('#idWhy').val(obj.id);
            $('#nikMaster').val(obj.nik_master);
            $('#idMaster').val(obj.id_master);
            $('#nodocWhy').val(obj.nodocpica);



            let dataKirim = {
                identity: obj.identity,
                id_why: obj.id,
                nik_master: obj.nik_master,
                id_master: obj.id_master,
                nodocWhy: obj.nodocpica
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/smart-pica/check-data-step",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        let datas = response.data;
                        for (let i = 1; i <= datas.length; i++) {
                            $(`#pc_action_${i}`).val(datas[i - 1].action);
                            $(`#pc_aktual_${i}`).val(datas[i - 1].note_step);
                            $(`select[name="pc_ap_pica_${i}"]`).val(datas[i - 1].ap_tod);
                            $(`#dicID_${i}`).val(datas[i - 1].dic).trigger('change');
                            $(`#picID_${i}`).val(datas[i - 1].pic).trigger('change');
                            $(`#atasan_ID_${i}`).val(datas[i - 1].approver).trigger('change');
                            $(`#editID_${i}`).val(datas[i - 1].id);
                            $(`#hiddenPIC_${i}`).val(datas[i - 1].pic);
                            $(`#hiddenAtasan_${i}`).val(datas[i - 1].approver);
                            initializeSelect2(`picID_${i}`, '--- Change PIC ---', "/helper/karyawan",
                                `dicID_${i}`);
                            initializeSelect2(`atasan_ID_${i}`, '--- Change PIC ---', "/helper/karyawan",
                                `dicID_${i}`);
                            $(`#DueDate_${i}`).val(formatDate(datas[i - 1].due_date));
                            $(`#pic_exist_${i}`).html("PIC exist : " + datas[i - 1].pic +
                                "<br> PIC Atasan exist : " + datas[i - 1].approver)
                        }
                    }
                    $('#masukkanButtonSubmit').html(dataHtml);
                    $('#stepSolution').modal("show");
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error 001',
                        html: message,
                        confirmButtonText: 'OK'
                    });
                }
            })

        }
    </script>

    <script type="text/javascript">
        function initializeSelect2(elementId, placeholderText, ajaxUrl, dataDepartmentId) {
            $('#' + elementId).select2({
                theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
                dropdownParent: $('#' + elementId).closest('.input-group'),
                placeholder: placeholderText,
                width: '100%',
                ajax: ajaxUrl ? {
                    url: ajaxUrl,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "post",
                    delay: 250,
                    dataType: 'json',
                    data: function(params) {
                        return {
                            query: params.term, // search term
                            dataDepartment: $('#' + dataDepartmentId).val()
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.data
                        };
                    },
                    cache: true
                } : null
            });
        }
        $(document).ready(function() {




            var targetString = "add-step-smart-pica";

            var currentUrl = window.location.href;
            if (currentUrl.includes(targetString)) {
                $("#progressPica").closest('.submenu').show();
            }



            // Inisialisasi Select2 untuk PIC
            initializeSelect2('picID_1', '--- Pilih PIC ---', "/helper/karyawan", 'dicID_1');
            initializeSelect2('picID_2', '--- Pilih PIC ---', "/helper/karyawan", 'dicID_2');
            initializeSelect2('picID_3', '--- Pilih PIC ---', "/helper/karyawan", 'dicID_3');
            initializeSelect2('picID_4', '--- Pilih PIC ---', "/helper/karyawan", 'dicID_4');
            initializeSelect2('picID_5', '--- Pilih PIC ---', "/helper/karyawan", 'dicID_5');

            // atasan
            initializeSelect2('atasan_ID_1', '--- Pilih Atasan PIC ---', "/helper/karyawan", 'dicID_1');
            initializeSelect2('atasan_ID_2', '--- Pilih Atasan PIC ---', "/helper/karyawan", 'dicID_2');
            initializeSelect2('atasan_ID_3', '--- Pilih Atasan PIC ---', "/helper/karyawan", 'dicID_3');
            initializeSelect2('atasan_ID_4', '--- Pilih Atasan PIC ---', "/helper/karyawan", 'dicID_4');
            initializeSelect2('atasan_ID_5', '--- Pilih Atasan PIC ---', "/helper/karyawan", 'dicID_5');

            // Inisialisasi Select2 untuk Department PIC
            initializeSelect2('dicID_1', '--- Pilih Department PIC ---');
            initializeSelect2('dicID_2', '--- Pilih Department PIC ---');
            initializeSelect2('dicID_3', '--- Pilih Department PIC ---');
            initializeSelect2('dicID_4', '--- Pilih Department PIC ---');
            initializeSelect2('dicID_5', '--- Pilih Department PIC ---');
        });
    </script>

    <script type="text/javascript">
        var dataFinalStep = [];

        function convertDateFormat(dateString) {
            const months = {
                January: '01',
                February: '02',
                March: '03',
                April: '04',
                May: '05',
                June: '06',
                July: '07',
                August: '08',
                September: '09',
                October: '10',
                November: '11',
                December: '12'
            };

            // Split the date string into components
            const parts = dateString.split(' ');
            const day = String(parts[0]).padStart(2, '0'); // Get the day and pad with 0
            const month = months[parts[1]]; // Get the month number
            const year = parts[2]; // Get the year

            // Return the formatted date
            return `${month}/${day}/${year}`;
        }

        function submitDataStepSolution(key) {
            let data = [];
            for (let i = 1; i <= 5; i++) {
                let action = $(`#pc_action_${i}`).val();
                if (i == 1 && action.trim() == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: `Action belum terisi atau Harus mengisikan 1 solution`
                    })
                    return false;
                }

                // Memeriksa apakah action diisi
                if (action.trim() != '') {
                    console.log($(`#picID_${i}`).val());
                    console.log($(`#hiddenPIC_${i}`).val())
                    let solution = {
                        action: action,
                        note: $(`#pc_aktual_${i}`).val(),
                        ap_tod: $(`select[name="pc_ap_pica_${i}"]`).val(),
                        dic: $(`#dicID_${i}`).val(),
                        pic: !$(`#picID_${i}`).val() ? ($(`#hiddenPIC_${i}`).val() == "" ? "" : $(
                            `#hiddenPIC_${i}`).val()) : $(`#picID_${i}`).val(),
                        atasan: !$(`#atasan_ID_${i}`).val() ? ($(`#hiddenAtasan_${i}`).val() == "" ? "" : $(
                            `#hiddenAtasan_${i}`).val()) : $(`#atasan_ID_${i}`).val(),
                        edit: $(`#editID_${i}`).val(),
                        dueDate: convertDateFormat($(`#DueDate_${i}`).val()),
                    };
                    console.log(solution)

                    if (solution.note.trim() == '' ||
                        solution.ap_tod == '' ||
                        solution.dic.trim() == '' ||
                        solution.pic.trim() == "" ||
                        solution.atasan.trim() == "" ||
                        solution.dueDate.trim() == '') {

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: `Semua field harus diisi untuk Solution ke - ${i}`
                        })
                        return;
                    }
                    data.push(solution);
                }
            }
            let dataKirim = {
                dataSolution: data,
                identityWhy: $(`#IdentityWhy`).val(),
                idWhy: $(`#idWhy`).val(),
                nodocWhy: $(`#nodocWhy`).val(),
                idMaster: $(`#idMaster`).val(),
                nikMaster: $(`#nikMaster`).val()
            }
            dataFinalStep.push(dataKirim);
            resetFormStep();
            $(`#button_open_modal_solution_${key}`).prop("disabled", true);
            $('#stepSolution').modal("hide");
        }

        function SubmitAllDataAndBack() {

            let dataKirim = {
                data: dataFinalStep
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/smart-pica/add-step-transaction",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            window.location.href = `/smart-pica/dashboard`
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: `Error 00003`,
                            html: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: `Error 00002`,
                        html: message,
                        confirmButtonText: 'OK'
                    });
                }
            })
        }
    </script>
@endsection
