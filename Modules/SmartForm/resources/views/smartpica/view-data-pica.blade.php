@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://unpkg.com/treeflex/dist/css/treeflex.css">
    <style>
        /* make the nodes round and change their background-color */
        .window {
            font-weight: bold;
            cursor: pointer;
            border: 1px solid #346789;
            box-shadow: 2px 2px 10px #aaa;
            -o-box-shadow: 2px 2px 10px #aaa;
            -webkit-box-shadow: 2px 2px 10px #aaa;
            -moz-box-shadow: 2px 2px 10px #aaa;
            -moz-border-radius: 0.5em;
            border-radius: 0.5em;
            width: 45em;
            height: auto;
            padding: 0.5em 0em;
            text-align: center;
            z-index: 20;
            position: absolute;
            background-color: #eeeeef;
            color: black;
            font-family: helvetica;
            font-size: 0.9em;
            word-wrap: break-word;
        }


        .window:hover {
            box-shadow: 2px 2px 10px #444;
            -o-box-shadow: 2px 2px 10px #444;
            -webkit-box-shadow: 2px 2px 10px #444;
            -moz-box-shadow: 2px 2px 10px #444;
        }


        .hidden {
            display: none;
        }

        .collapser {
            cursor: pointer;
            border: 1px dotted gray;
            z-index: 21;
        }

        .errorWindow {
            border: 2px solid red;
        }

        #treemain {
            height: 500000px;
            width: 100%;
            position: relative;
            overflow: auto;
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
                <input type="hidden" name="id_user_login" id="UserLoginNIK" value="{{ session('user_id') }}">
                <input type="hidden" name="id_user_creator" id="UserCreatorNIK" value="{{ $dataMaster->nik }}">
                <input type="hidden" name="status_edit" id="status_edit" value="{{ $dataMaster->approval }}">
                <input type="hidden" name="hiddenNodocPica" id="hiddenNodocPica" value="{{ $dataMaster->nodocpica }}">
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
                                    Creator : {{ $dataMaster->nama_karyawan }}
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
                                            <span class="ms-2">{{ $dataMaster->nodocpica }}</span>
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
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_thn" class="ms-0">Tahun </label>
                                        <select class="form-control" name="pc_thn" id="pc_thn" disabled>
                                            <option value="">{{ $dataMaster->tahun }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_bln" class="ms-0">Bulan </label>
                                        <select class="form-control" name="pc_bln" disabled id="pc_bln">
                                            <option value="">{{ $dataMaster->bulan }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_week" class="ms-0">Week </label>
                                        <select class="form-control" name="pc_week" disabled id="pc_week" disabled>
                                            <option value="">Week {{ $dataMaster->week + 1 }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_site" class="ms-0">Site </label>
                                        <select class="form-control dept" name="pc_site" id="pc_site">
                                            <option value="">{{ $dataMaster->nama_site }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_dept" class="ms-0">Department </label>
                                        <select class="form-control dept" name="pc_dept" id="pc_dept" disabled>
                                            <option value="">{{ $dataMaster->nama_department }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_kpi" class="ms-0">Leading KPI </label>
                                        <select class="form-control s2lea" name="pc_kpi" id="pc_kpi" disabled>
                                            <option value="">{{ $dataMaster->kpi }}</option>
                                        </select>
                                        <small class="text-danger">Actual & Target hanya bisa diisi dengan angka dan titik
                                            (.)
                                            <i class="fas fa-arrow-right"></i></small>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_aktual" class="ms-0">Actual</label>
                                        <input class="form-control" type="text" disabled
                                            inputmode="decimal"value="{{ $dataMaster->actual_master }}" name="pc_aktual"
                                            id="pc_aktual">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-2">
                                        <label class="ms-0" for="pc_target">Target</label>
                                        <input class="form-control" type="text" inputmode="decimal" id="pc_target"
                                            disabled value="{{ $dataMaster->target_master }}" name="pc_target">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-2">
                                        <label class="ms-0" for="pc_ap_pica">AP/PICA</label>
                                        <select class="form-control" name="pc_ap_pica" disabled>
                                            <option value="">{{ $dataMaster->ap_pica == 'pc' ? 'PICA' : 'AP' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group input-group-static my-2">
                                        <label for="pc_problem" class="ms-0">Problem Statement </label>
                                        <textarea class="form-control" name="pc_problem" id="pc_problem" rows="3" disabled>{{ $dataMaster->problem }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-2">
                                        <label class="ms-0" for="pc_kp">Kategori Problem </label>
                                        <select class="form-control" name="pc_kp" id="pc_kp" disabled>
                                            <option value="">{{ $dataMaster->kp_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            @if ($dataMaster->approval == 'rejected')
                                <div class="row justify-content-between">
                                    <div class="col-md-6">
                                        <button style="text-align: left !important"
                                            class="form-control-button btn-primary btn" type="button">Revision
                                            {{ $dataMaster->keterangan_reject }}</button>
                                    </div>
                                    @if (session('user_id') == $dataMaster->nik)
                                        <div class="col-md-3">
                                            <button class="btn btn-warning ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                                onclick="SubmitAllRevision()">
                                                <i class="fas fa-save"></i>
                                                Submit Revisi</button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <br>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="scrollable-div border" id="scrollableDiv">
                                    <div class="zoomable-content" id="zoomableContent">
                                        <div style="width: 100000px; height: 1500px;" id="dataWHYYYYY">
                                            <div class="" style="padding-top: 100px">
                                                <div id="treemain">
                                                    <div id="node_0" class="window hidden" data-id="0"
                                                        data-parent="" data-first-child="1" data-next-sibling=""
                                                        style="font-size: 1.5vw">
                                                        {{ $dataMaster->problem }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                <div id="content-modal-view-step">

                </div>
                <hr class="horizontal dark my-sm-3">

                <div class="row" style="margin:10px">
                    <div class="col text-end" id="masukkanButtonSubmit">

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalAddDataWhy" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Masukkan Why</h5>
                            <p id="ProblemHeader"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <input type="hidden" id="id">
                            <input type="hidden" id="identity">
                            <input type="hidden" id="master">
                            <input type="hidden" id="nodocpica">
                            <input type="hidden" id="nik">
                            <input type="hidden" id="w1">
                            <input type="hidden" id="w2">
                            <input type="hidden" id="w3">
                            <input type="hidden" id="w4">
                            <div class="card-body">
                                <h5 class="card-title">Penambahan WHY</h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group input-group-static my-4">
                                            <label for="pc_why" class="ms-0">Problem Statement </label>
                                            <textarea class="form-control" name="pc_why" placeholder="-- Masukkan Problem --" id="pc_why" rows="3"
                                                required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static my-4">
                                            <label class="ms-0" for="pc_kategori">Kategori Problem </label>
                                            <select class="form-control" name="pc_kategori" id="pc_kategori" required>
                                                <option value="">-- Pilih Kategori Problem --</option>
                                                @foreach ($dataKategory as $d)
                                                    <option value="{{ $d['id'] }}">{{ $d['text'] }}</option>
                                                @endForeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    style="margin : 20px" onclick="SaveDataAddWhy()">
                                    <i class="fas fa-save"></i>
                                    Save Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateWhy" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col">
                            <h5 class="modal-title center" id="exampleModalToggleLabel">Masukkan Why</h5>
                            <p id="ProblemHeaderUpdate"></p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="row" style="margin: 10px">
                    <div class="col">
                        <div class="card border" style="">
                            <input type="hidden" id="update_id">
                            <input type="hidden" id="update_identity">
                            <input type="hidden" id="update_master">
                            <input type="hidden" id="update_nodocpica">
                            <input type="hidden" id="update_nik">
                            <input type="hidden" id="update_w1">
                            <input type="hidden" id="update_w2">
                            <input type="hidden" id="update_w3">
                            <input type="hidden" id="update_w4">
                            <div class="card-body">
                                <h5 class="card-title">Edit WHY</h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="input-group input-group-static my-4">
                                            <label for="update_pc_why" class="ms-0">Problem Statement </label>
                                            <textarea class="form-control" name="update_pc_why" placeholder="-- Masukkan Problem --" id="update_pc_why"
                                                rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static my-4">
                                            <label class="ms-0" for="update_pc_kategori">Kategori Problem </label>
                                            <select class="form-control" name="update_pc_kategori"
                                                id="update_pc_kategori" required>
                                                <option value="">-- Pilih Kategori Problem --</option>
                                                @foreach ($dataKategory as $d)
                                                    <option value="{{ $d['id'] }}">{{ $d['text'] }}</option>
                                                @endForeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                    style="margin : 20px" onclick="SaveDataUpdateWhy()">
                                    <i class="fas fa-save"></i>
                                    Save Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('master/js/jquery.jsPlumb-1.4.1-all-min.js') }}"></script>
    <script src="{{ asset('master/js/jsplumb-tree.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script>
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
        function SubmitAllRevision() {
            let dataNodocPica = $("#hiddenNodocPica").val();

            let dataKirim = {
                nodocpica: dataNodocPica
            }
            Swal.fire({
                title: "Apakah semua revisi sudah diperbaiki ?",
                showCancelButton: true,
                confirmButtonText: "Ya",
            }).then((result) => {
                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/smart-pica/change-flag-revision",
                    data: dataKirim,
                    dataType: 'json',
                    success: function(response) {
                        if (response.code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                            })
                            window.location.href = '/';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error While Add Data',
                                html: message,
                                confirmButtonText: 'OK'
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
            })
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var targetString = "smart-pica/view-data-detail-pica";

            var currentUrl = window.location.href;
            if (currentUrl.includes(targetString)) {
                $("#progressPica").closest('.submenu').show();
            }

            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Replace this value with your actual numeric month value
            const numericMonth = {{ $dataMaster->bulan }};

            // Ensure the value is valid
            if (numericMonth >= 1 && numericMonth <= 12) {
                const $selectElement = $('#pc_bln');
                const $optionElement = $selectElement.find('option');
                $optionElement.text(monthNames[numericMonth - 1]);
                $optionElement.val(numericMonth); // Ensure the value attribute is set correctly
            } else {
                console.error("Invalid month value");
            }
        });
    </script>

    <script type="text/javascript">
        var urutan_node = 1;
        var dataUrutanDivWhy1 = [];
        var dataUrutanDivWhy2 = [];
        var dataUrutanDivWhy3 = [];
        var dataUrutanDivWhy4 = [];
        var dataUrutanDivWhy5 = [];

        function findPosition(params, ...dataSets) {
            for (let data of dataSets) {
                let result = data.find(item => {
                    let match = Object.keys(params).every(key => item[key] === params[key]);
                    return match;
                });
                if (result) {
                    return result.position;
                }
            }
            return 'Position not found';
        }

        function checkStep(id, identity, solution) {
            return solution.some(obj => obj.identity_why === identity && obj.position_why === id);
        }

        $(document).ready(function() {
            window.onload = function() {
                window.scrollTo(0, scrollPosition);
            };
            // $('#scrollableDiv').scrollTop(0).scrollLeft(0);
            let dataWhy1 = <?php echo json_encode($dataPicaW1); ?>;
            let dataWhy2 = <?php echo json_encode($dataPicaW2); ?>;
            let dataWhy3 = <?php echo json_encode($dataPicaW3); ?>;
            let dataWhy4 = <?php echo json_encode($dataPicaW4); ?>;
            let dataWhy5 = <?php echo json_encode($dataPicaW5); ?>;
            var solution = <?php echo json_encode($solution); ?>;


            for (let i = 0; i < dataWhy1.length; i++) {
                let dataDIVNode = `
                <div id="node_${urutan_node}" class="window hidden" data-id="${urutan_node}"
                    data-parent="0" data-first-child="" data-next-sibling="${(dataWhy1.length - 1) != i ? i+2 : ""}">
                    <div class="row" style="margin: 10px">
                        <div class="col-12 my-2">
                            <div class="row">
                                <div class="col-4">Kategori </div>
                                <div class="col">: ${ dataWhy1[i].kp_name }</div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin: 10px">
                        <div class="col-12">
                            <input type="hidden" id="identity_why${urutan_node}" value="${dataWhy1[i].identity}" />
                             <input type="hidden" id="id_why${urutan_node}" value="${dataWhy1[i].id}" />
                                <input type="hidden" id="idMaster_why${urutan_node}" value="${dataWhy1[i].id_master}" />
                            <div class="row">
                                <div class="input-group input-group-static">
                                    <label for="input-why">-- WHY -- </label>
                                    <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy1[i].why }</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <button class="hiddenButtonByCreated" id="button_delete_${urutan_node}" onclick="DeleteStep('${urutan_node}')" style="background-color:black; color:white;">Delete Child</button>
                            <button class="hiddenButtonByCreated" id="button_edit_${urutan_node}" onclick="UpdateStep(${dataWhy1[i].id},${dataWhy1[i].identity},'${dataWhy1[i].nodocpica}', '${ dataWhy1[i].id_kategory }', '${ dataWhy1[i].why }')" style="background-color:black; color:white;">Update</button>
                        </div>
                        <div class="col-sm-4">
                            <button class="hiddenButtonByCreated" onclick="addWhy(${dataWhy1[i].id},${dataWhy1[i].identity}, ${dataWhy1[i].id_master}, '${dataWhy1[i].nodocpica}', ${dataWhy1[i].nik_master}, ${dataWhy1[i].index_w1},0,0,0)" style="background-color:black; color:white;">Add Why 2</button>
                        </div>
                        <div class="col-sm-3">
                            <button id="button_${urutan_node}" onclick="modalViewStep(${dataWhy1[i].id},${dataWhy1[i].identity})" style="background-color:black; color:white;">Solution</button>
                        </div>
                    </div>
                </div>
                `;
                let dataTMPDIVPosition = {
                    w1: dataWhy1[i].index_w1,
                    position: urutan_node
                }
                urutan_node += 1;
                dataUrutanDivWhy1.push(dataTMPDIVPosition);
                $('#treemain').append(dataDIVNode);
            }

            var dataBaruW1 = 0;
            for (let i = 0; i < dataWhy2.length; i++) {
                let dataParams = {
                    w1: dataWhy2[i].index_w1
                }
                let dataPositionW1 = findPosition(dataParams, dataUrutanDivWhy1);
                if (dataBaruW1 != dataWhy2[i].index_w1) {
                    dataBaruW1 = dataWhy2[i].index_w1;
                    $(`#button_${dataPositionW1}`).addClass("d-none")
                    $(`#node_${dataPositionW1}`).attr('data-first-child', urutan_node);
                } else {
                    $(`#button_${urutan_node}`).addClass("d-none")
                    $(`#node_${urutan_node-1}`).attr('data-next-sibling', urutan_node);
                }
                let statusLast = checkStep(dataWhy2[i].id, dataWhy2[i].identity, solution);
                let dataDIVNode = `
                    <div id="node_${urutan_node}" class="window hidden" data-id="${urutan_node}"
                        data-parent="${dataPositionW1}" data-first-child="" data-next-sibling="">
                        <div class="row" style="margin: 10px">
                            <div class="col-12 my-2">
                                <div class="row">
                                    <div class="col-4">Kategori </div>
                                    <div class="col">: ${ dataWhy2[i].kp_name }</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px">
                            <div class="col-12">
                                <input type="hidden" id="identity_why${urutan_node}" value="${dataWhy2[i].identity}" />
                                 <input type="hidden" id="id_why${urutan_node}" value="${dataWhy2[i].id}" />
                                <input type="hidden" id="idMaster_why${urutan_node}" value="${dataWhy2[i].id_master}" />
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy2[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <button class="hiddenButtonByCreated" id="button_delete_${urutan_node}" onclick="DeleteStep('${urutan_node}')" style="background-color:black; color:white;">Delete Child</button>
                                <button class="hiddenButtonByCreated" id="button_edit_${urutan_node}" onclick="UpdateStep(${dataWhy2[i].id},${dataWhy2[i].identity},'${dataWhy2[i].nodocpica}', '${ dataWhy2[i].id_kategory }', '${ dataWhy2[i].why }')" style="background-color:black; color:white;">Update</button>
                            </div>
                            <div class="col-sm-4">
                                <button class="hiddenButtonByCreated" onclick="addWhy(${dataWhy2[i].id},${dataWhy2[i].identity}, ${dataWhy2[i].id_master}, '${dataWhy2[i].nodocpica}', ${dataWhy2[i].nik_master}, ${dataWhy2[i].index_w1}, ${dataWhy2[i].index_w2},0,0)" style="background-color:black; color:white;">Add Why 3</button>
                            </div>
                            <div class="col-sm-3">
                                <button id="button_${urutan_node}" class="${statusLast ? "" : "d-none"}" onclick="modalViewStep(${dataWhy2[i].id},${dataWhy2[i].identity})" style="background-color:black; color:white;">Solution</button>
                            </div>
                        </div>
                    </div>
                `;
                let dataTMPDIVPosition = {
                    w1: dataWhy2[i].index_w1,
                    w2: dataWhy2[i].index_w2,
                    position: urutan_node
                }
                urutan_node += 1;
                dataUrutanDivWhy2.push(dataTMPDIVPosition);
                $('#treemain').append(dataDIVNode);
            }

            var dataBaruW1 = 0;
            var dataBaruW2 = 0;
            for (let i = 0; i < dataWhy3.length; i++) {
                let statusLast = checkStep(dataWhy3[i].id, dataWhy3[i].identity, solution);
                let dataParams = {
                    w1: dataWhy3[i].index_w1,
                    w2: dataWhy3[i].index_w2
                }
                let dataPositionW2 = findPosition(dataParams, dataUrutanDivWhy2);
                if (dataBaruW1 != dataWhy3[i].index_w1 || dataBaruW2 != dataWhy3[i].index_w2) {
                    dataBaruW1 = dataWhy3[i].index_w1
                    dataBaruW2 = dataWhy3[i].index_w2
                    $(`#button_${dataPositionW2}`).addClass("d-none")
                    $(`#node_${dataPositionW2}`).attr('data-first-child', urutan_node);
                } else {
                    $(`#button_${urutan_node}`).addClass("d-none")
                    $(`#node_${urutan_node-1}`).attr('data-next-sibling', urutan_node);
                }
                let dataDIVNode = `
                    <div id="node_${urutan_node}" class="window hidden" data-id="${urutan_node}"
                        data-parent="${dataPositionW2}" data-first-child="" data-next-sibling="">
                        <div class="row" style="margin: 10px">
                            <div class="col-12 my-2">
                                <div class="row">
                                    <div class="col-4">Kategori </div>
                                    <div class="col">: ${ dataWhy3[i].kp_name }</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px">
                            <div class="col-12">
                                <input type="hidden" id="identity_why${urutan_node}" value="${dataWhy3[i].identity}" />
                                 <input type="hidden" id="id_why${urutan_node}" value="${dataWhy3[i].id}" />
                                <input type="hidden" id="idMaster_why${urutan_node}" value="${dataWhy3[i].id_master}" />
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy3[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <button class="hiddenButtonByCreated" id="button_delete_${urutan_node}" onclick="DeleteStep('${urutan_node}')" style="background-color:black; color:white;">Delete Child</button>
                                <button class="hiddenButtonByCreated" id="button_edit_${urutan_node}" onclick="UpdateStep(${dataWhy3[i].id},${dataWhy3[i].identity},'${dataWhy3[i].nodocpica}', '${ dataWhy3[i].id_kategory }', '${ dataWhy3[i].why }')" style="background-color:black; color:white;">Update</button>
                            </div>
                            <div class="col-sm-4">
                                <button class="hiddenButtonByCreated" onclick="addWhy(${dataWhy3[i].id},${dataWhy3[i].identity}, ${dataWhy3[i].id_master}, '${dataWhy3[i].nodocpica}', ${dataWhy3[i].nik_master}, ${dataWhy3[i].index_w1}, ${dataWhy3[i].index_w2},${dataWhy3[i].index_w3}, 0)" style="background-color:black; color:white;">Add Why 4</button>
                            </div>
                            <div class="col-sm-3">
                                <button id="button_${urutan_node}" class="${statusLast ? "" : "d-none"}" onclick="modalViewStep(${dataWhy3[i].id},${dataWhy3[i].identity})" style="background-color:black; color:white;">Solution</button>
                            </div>
                        </div>
                    </div>
                `;

                let dataTMPDIVPosition = {
                    w1: dataWhy3[i].index_w1,
                    w2: dataWhy3[i].index_w2,
                    w3: dataWhy3[i].index_w3,
                    position: urutan_node
                }
                urutan_node += 1;
                dataUrutanDivWhy3.push(dataTMPDIVPosition);
                $('#treemain').append(dataDIVNode);
            }

            var dataBaruW1 = 0;
            var dataBaruW2 = 0;
            var dataBaruW3 = 0;
            for (let i = 0; i < dataWhy4.length; i++) {
                let dataParams = {
                    w1: dataWhy4[i].index_w1,
                    w2: dataWhy4[i].index_w2,
                    w3: dataWhy4[i].index_w3
                }
                let statusLast = checkStep(dataWhy4[i].id, dataWhy4[i].identity, solution);
                let dataPositionW3 = findPosition(dataParams, dataUrutanDivWhy3);
                if (dataBaruW1 != dataWhy4[i].index_w1 || dataBaruW2 != dataWhy4[i].index_w2 || dataBaruW3 !=
                    dataWhy4[i].index_w3) {
                    dataBaruW1 = dataWhy4[i].index_w1
                    dataBaruW2 = dataWhy4[i].index_w2
                    dataBaruW3 = dataWhy4[i].index_w3
                    $(`#button_${dataPositionW3}`).addClass("d-none")
                    $(`#node_${dataPositionW3}`).attr('data-first-child', urutan_node);
                } else {
                    $(`#button_${urutan_node}`).addClass("d-none")
                    $(`#node_${urutan_node-1}`).attr('data-next-sibling', urutan_node);
                }
                let dataDIVNode = `
                    <div id="node_${urutan_node}" class="window hidden" data-id="${urutan_node}"
                        data-parent="${dataPositionW3}" data-first-child="" data-next-sibling="">
                        <div class="row" style="margin: 10px">
                            <div class="col-12 my-2">
                                <div class="row">
                                    <div class="col-4">Kategori </div>
                                    <div class="col">: ${ dataWhy4[i].kp_name }</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px">
                            <div class="col-12">
                                <input type="hidden" id="identity_why${urutan_node}" value="${dataWhy4[i].identity}" />
                                <input type="hidden" id="id_why${urutan_node}" value="${dataWhy4[i].id}" />
                                <input type="hidden" id="idMaster_why${urutan_node}" value="${dataWhy4[i].id_master}" />
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy4[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <button id="button_delete_${urutan_node}" class="hiddenButtonByCreated" onclick="DeleteStep('${urutan_node}')" style="background-color:black; color:white;">Delete Child</button>
                                <button id="button_edit_${urutan_node}" class="hiddenButtonByCreated" onclick="UpdateStep(${dataWhy4[i].id},${dataWhy4[i].identity},'${dataWhy4[i].nodocpica}', '${ dataWhy4[i].id_kategory }', '${ dataWhy4[i].why }')" style="background-color:black; color:white;">Update</button>
                            </div>
                            <div class="col-sm-4">
                                <button class="hiddenButtonByCreated" onclick="addWhy(${dataWhy4[i].id},${dataWhy4[i].identity}, ${dataWhy4[i].id_master}, '${dataWhy4[i].nodocpica}', ${dataWhy4[i].nik_master}, ${dataWhy4[i].index_w1}, ${dataWhy4[i].index_w2},${dataWhy4[i].index_w3}, ${dataWhy4[i].index_w4})" style="background-color:black; color:white;">Add Why 5</button>
                            </div>
                            <div class="col-sm-3">
                                <button id="button_${urutan_node}" class="${statusLast ? "" : "d-none"}" onclick="modalViewStep(${dataWhy4[i].id},${dataWhy4[i].identity})" style="background-color:black; color:white;">Solution</button>
                            </div>
                        </div>
                    </div>
                `;

                let dataTMPDIVPosition = {
                    w1: dataWhy4[i].index_w1,
                    w2: dataWhy4[i].index_w2,
                    w3: dataWhy4[i].index_w3,
                    w4: dataWhy4[i].index_w4,
                    position: urutan_node
                }
                urutan_node += 1;
                dataUrutanDivWhy4.push(dataTMPDIVPosition);
                $('#treemain').append(dataDIVNode);
            }

            var dataBaruW1 = 0;
            var dataBaruW2 = 0;
            var dataBaruW3 = 0;
            var dataBaruW4 = 0;
            for (let i = 0; i < dataWhy5.length; i++) {
                let dataParams = {
                    w1: dataWhy5[i].index_w1,
                    w2: dataWhy5[i].index_w2,
                    w3: dataWhy5[i].index_w3,
                    w4: dataWhy5[i].index_w4,
                }
                let dataPositionW4 = findPosition(dataParams, dataUrutanDivWhy4);
                let statusLast = checkStep(dataWhy5[i].id, dataWhy5[i].identity, solution);
                if (dataBaruW1 != dataWhy5[i].index_w1 || dataBaruW2 != dataWhy5[i].index_w2 || dataBaruW3 !=
                    dataWhy5[i].index_w3 || dataBaruW4 != dataWhy5[i].index_w4) {
                    dataBaruW1 = dataWhy5[i].index_w1
                    dataBaruW2 = dataWhy5[i].index_w2
                    dataBaruW3 = dataWhy5[i].index_w3
                    dataBaruW4 = dataWhy5[i].index_w4
                    $(`#button_${dataPositionW4}`).addClass("d-none")
                    $(`#node_${dataPositionW4}`).attr('data-first-child', urutan_node);
                } else {
                    $(`#button_${urutan_node}`).addClass("d-none")
                    $(`#node_${urutan_node-1}`).attr('data-next-sibling', urutan_node);
                }

                let dataDIVNode = `
                    <div id="node_${urutan_node}" class="window hidden" data-id="${urutan_node}"
                        data-parent="${dataPositionW4}" data-first-child="" data-next-sibling="">
                        <div class="row" style="margin: 10px">
                            <div class="col-12 my-2">
                                <div class="row">
                                    <div class="col-4">Kategori </div>
                                    <div class="col">: ${ dataWhy5[i].kp_name }</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin: 10px">
                            <div class="col-12">
                                <input type="hidden" id="identity_why${urutan_node}" value="${dataWhy5[i].identity}" />
                                <input type="hidden" id="id_why${urutan_node}" value="${dataWhy5[i].id}" />
                                <input type="hidden" id="idMaster_why${urutan_node}" value="${dataWhy5[i].id_master}" />
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy5[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5 ">
                                <button class="hiddenButtonByCreated" id="button_edit_${urutan_node}" onclick="UpdateStep(${dataWhy5[i].id},${dataWhy5[i].identity},'${dataWhy5[i].nodocpica}', '${ dataWhy5[i].id_kategory }', '${ dataWhy5[i].why }')" style="background-color:black; color:white;">Update</button>
                            </div>
                            <div class="col-sm-3">
                                <button id="button_${urutan_node}" class="${statusLast ? "" : "d-none"}" onclick="modalViewStep(${dataWhy5[i].id},${dataWhy5[i].identity})" style="background-color:black; color:white;">Solution</button>
                            </div>
                        </div>
                    </div>
                `;

                let dataTMPDIVPosition = {
                    w1: dataWhy5[i].index_w1,
                    w2: dataWhy5[i].index_w2,
                    w3: dataWhy5[i].index_w3,
                    w4: dataWhy5[i].index_w4,
                    w5: dataWhy5[i].index_w5,
                    position: urutan_node
                }
                urutan_node += 1;
                dataUrutanDivWhy5.push(dataTMPDIVPosition);
                $('#treemain').append(dataDIVNode);
            }

            if ($("#UserLoginNIK").val() != $("#UserCreatorNIK").val() || $("#status_edit").val() == "approved") {
                $(".hiddenButtonByCreated").addClass("d-none")
            } else {
                $(".hiddenButtonByCreated").removeClass("d-none")
            }

            var connectorPaintStyle = {
                lineWidth: 2,
                strokeStyle: "#4F81BE",
                joinstyle: "round"
            };
            var pdef = {
                // disable dragging
                DragOptions: null,
                // the tree container
                Container: "treemain"
            };
            var plumb = jsPlumb.getInstance(pdef);

            // all sizes are in pixels
            var opts = {
                prefix: 'node_',
                baseLeft: 24,
                baseTop: 24,
                nodeWidth: 100,
                hSpace: 50,
                vSpace: 20,
                imgPlus: "{{ asset('master/js/tree_expand.png') }}",
                imgMinus: "{{ asset('master/js/tree_collapse.png') }}",
                sourceAnchor: [1, 0.5, 1, 0, 10, 0],
                targetAnchor: "LeftMiddle",
                sourceEndpoint: {
                    endpoint: ["Image", {
                        url: "{{ asset('master/js/tree_collapse.png') }}"
                    }],
                    cssClass: "collapser",
                    isSource: true,
                    connector: ["Flowchart", {
                        stub: [40, 60],
                        gap: [10, 0],
                        cornerRadius: 10,
                        alwaysRespectStubs: false
                    }],
                    connectorStyle: connectorPaintStyle,
                    enabled: false,
                    maxConnections: -1,
                    dragOptions: null
                },
                targetEndpoint: {
                    endpoint: "Blank",
                    maxConnections: -1,
                    dropOptions: null,
                    enabled: false,
                    isTarget: true
                },
                connectFunc: function(tree, node) {
                    var cid = node.data('id');
                    console.log('Connecting node ' + cid);
                }
            };
            var tree = jQuery.jsPlumbTree(plumb, opts);
            tree.init();
            window.treemain = tree;
        })


        function getChildNodeIdsWithValues(parentNodeId) {
            let nodesData = [];
            let parentNode = $(`#node_${parentNodeId}`);
            // nodesData.push({
            //     id: parentNodeId,
            //     id_why: $(`#id_why${parentNodeId}`).val() || null,
            //     idMaster_why: $(`#idMaster_why${parentNodeId}`).val() || null
            // });
            let firstChildId = parentNode.data('first-child');

            while (firstChildId) {
                let childNode = $(`#node_${firstChildId}`);
                if (!nodesData.some(node => node.id === firstChildId)) {
                    nodesData.push({
                        id: firstChildId,
                        identity_why: $(`#identity_why${firstChildId}`).val() || null,
                        id_why: $(`#id_why${firstChildId}`).val() || null,
                        idMaster_why: $(`#idMaster_why${firstChildId}`).val() || null
                    });
                }
                nodesData = nodesData.concat(getChildNodeIdsWithValues(firstChildId));
                firstChildId = childNode.data('next-sibling');
            }

            return nodesData;
        }
    </script>
    <script type="text/javascript">
        function UpdateStep(id, identity, nodocpica, kp, why) {
            $("#update_id").val(id);
            $("#update_identity").val(identity);
            $("#update_nodocpica").val(nodocpica);
            $("#update_pc_why").val(why);
            $("#update_pc_kategori").val(kp);
            $("#ModalUpdateWhy").modal("show");
        }
        let scrollPosition = window.scrollY || document.documentElement.scrollTop;

        function DeleteStep(node) {
            Swal.fire({
                title: "Apakah yakin menghapus semua child?",
                showCancelButton: true,
                confirmButtonText: "Hapus Data",
            }).then((result) => {
                if (result.isConfirmed) {
                    let allNode1ChildrenData = getChildNodeIdsWithValues(node);
                    dataKirim = {
                        dataHapus: allNode1ChildrenData
                    }
                    $.ajax({
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/smart-pica/update-master-pica",
                        data: dataKirim,
                        dataType: 'json',
                        success: function(response) {
                            if (response.code == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error While Add Data',
                                    html: message,
                                    confirmButtonText: 'OK'
                                });
                            }
                            location.reload();
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

        function addWhy(id, identity, master, nodocpica, nik, w1, w2, w3, w4) {
            $("#id").val(id);
            $("#identity").val(identity);
            $("#master").val(master);
            $("#nodocpica").val(nodocpica);
            $("#nik").val(nik);
            $("#w1").val(w1);
            $("#w2").val(w2);
            $("#w3").val(w3);
            $("#w4").val(w4);
            $("#ModalAddDataWhy").modal("show")

        }

        function SaveDataAddWhy() {
            let id = $("#id").val();
            let identity = $("#identity").val();
            let master = $("#master").val();
            let nodocpica = $("#nodocpica").val();
            let nik = $("#nik").val();
            let w1 = $("#w1").val();
            let w2 = $("#w2").val();
            let w3 = $("#w3").val();
            let w4 = $("#w4").val();
            let why = $("#pc_why").val();

            let kategori = $("#pc_kategori").val();
            if (!why) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan isi alasan (why) terlebih dahulu!',
                });
                return false;
            } else if (!kategori) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan isi kategori terlebih dahulu!',
                });
                return false;
            }
            let dataKirim = {
                id: id,
                identity: identity,
                master: master,
                nodocpica: nodocpica,
                nik: nik,
                w1: w1,
                w2: w2,
                w3: w3,
                w4: w4,
                why: why,
                kategory: kategori
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/smart-pica/add-why-spesific-data",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        })
                        $("#id").val("");
                        $("#identity").val("");
                        $("#master").val("");
                        $("#nodocpica").val("");
                        $("#nik").val("");
                        $("#w1").val("");
                        $("#w2").val("");
                        $("#w3").val("");
                        $("#w4").val("");
                        $("#pc_why").val("");
                        $("#pc_kategori").val("");
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error While Add Data',
                            html: message,
                            confirmButtonText: 'OK'
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

        function SaveDataUpdateWhy() {
            let id = $("#update_id").val();
            let identity = $("#update_identity").val();
            let nodocpica = $("#update_nodocpica").val();
            let why = $("#update_pc_why").val();
            let kategori = $("#update_pc_kategori").val();
            if (!why) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan isi alasan (why) terlebih dahulu!',
                });
                return false;
            } else if (!kategori) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Silakan isi kategori terlebih dahulu!',
                });
                return false;
            }
            let dataKirim = {
                id: id,
                identity: identity,
                nodocpica: nodocpica,
                why: why,
                kategori: kategori
            }

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/smart-pica/edit-why-spesific-data",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        })
                        $("#id").val("");
                        $("#identity").val("");
                        $("#master").val("");
                        $("#nodocpica").val("");
                        $("#nik").val("");
                        $("#w1").val("");
                        $("#w2").val("");
                        $("#w3").val("");
                        $("#w4").val("");
                        $("#pc_why").val("");
                        $("#pc_kategori").val("");
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error While Add Data',
                            html: message,
                            confirmButtonText: 'OK'
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

        var solution = <?php echo json_encode($solution); ?>;

        function modalViewStep(id, identity) {
            let dataStep = solution.filter(obj => obj.identity_why == identity && obj.position_why == id);
            $('#content-modal-view-step').empty(); // Bersihkan konten modal sebelum menambahkan konten baru
            dataStep.forEach((e, index) => {
                console.log(e);
                let dataView = `
                    <div class="row" style="margin: 10px">
                        <div class="col">
                            <div class="card border" style="">
                                <div class="card-body">
                                    <h5 class="card-title">Solution</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="pc_action_${index}" class="ms-0">Action</label>
                                                <select class="form-control" name="pc_action_${index}" id="pc_action_${index}" disabled>
                                                    <option value="">-- ${e.action} --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="pc_aktual_${index}" class="ms-0">Note Step</label>
                                                <textarea class="form-control" name="pc_problem" value="${e.note_step}" id="pc_aktual_${index}" disabled
                                                    rows="2" required>${e.note_step}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="input-group input-group-static  my-1">
                                                <label class="ms-0" for="pc_ap_pica_${index}">AP/TOD</label>
                                                <select class="form-control" name="pc_ap_pica_${index}" id="pc_ap_pica_${index}" disabled>
                                                    <option value="">-- ${e.ap_tod} --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="dicID_${index}" class="">Department in Charge (DIC)</label>
                                                <select class="form-control DICDepartment" name="dicID_${index}" id="dicID_${index}" disabled>
                                                    <option value="">-- ${e.dic} --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="picID_${index}" class="">Person In Charge (PIC)</label>
                                                <select class="form-control picIDHuman" name="picID_${index}" id="picID_${index}" disabled>
                                                    <option value="">-- ${e.nama_pic} --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static  my-1">
                                                <label for="DueDate_${index}" class="">Person In Charge (PIC)</label>
                                                <select class="form-control picIDHuman" name="DueDate_${index}" id="DueDate_${index}" disabled>
                                                    <option value="">-- ${e.due_date} --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark my-sm-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="tensi">Status</label>
                                                <button class="form-control-button 
                                                ${ 
                                                    (e.status_reject == 1 || e.acceptance == 2) ? 'btn-primary' :
                                                    (e.status_approve == 1) ? 'btn-success' :
                                                    (e.acceptance == 0) ? 'btn-warning' :
                                                    (e.acceptance == 1 || e.acceptance == 9) ? 'btn-info' :
                                                    'btn-secondary' 
                                                } 
                                                btn"
                                                    type="button">${e.status_solution}</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="tensi">Progress</label>
                                                <button class="form-control-button 
                                                ${ 
                                                    (e.status_reject == 1 || e.acceptance == 2) ? 'btn-primary' :
                                                    (e.status_approve == 1) ? 'btn-success' :
                                                    (e.acceptance == 0) ? 'btn-warning' :
                                                    (e.acceptance == 1 || e.acceptance == 9) ? 'btn-info' :
                                                    'btn-secondary' 
                                                }  btn"
                                                    type="button">${e.progress}</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="tensi">Persentase Progress</label>
                                                <button class="form-control-button ${ 
                                                    (e.status_reject == 1 || e.acceptance == 2) ? 'btn-primary' :
                                                    (e.status_approve == 1) ? 'btn-success' :
                                                    (e.acceptance == 0) ? 'btn-warning' :
                                                    (e.acceptance == 1 || e.acceptance == 9) ? 'btn-info' :
                                                    'btn-secondary' 
                                                }  btn"
                                                    type="button">${e.progress_percentage}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                console.log(e)
                $('#content-modal-view-step').append(dataView);
            });

            $('#stepSolution').modal("show");
        }
    </script>
@endsection
