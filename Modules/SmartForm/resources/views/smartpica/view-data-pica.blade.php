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
            width: 30em;
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
                                            <option value="">{{ $dataMaster->week }}</option>
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
                                <div class="col-md-9">
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
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="scrollable-div border" id="scrollableDiv">
                                    <div class="zoomable-content" id="zoomableContent">
                                        <div style="width: 100000px; height: 1500px;" id="dataWHYYYYY">
                                            <div class="" style="padding-top: 100px">
                                                <div id="treemain">
                                                    <div id="node_0" class="window hidden" data-id="0"
                                                        data-parent="" data-first-child="1" data-next-sibling="">
                                                        Root Problem
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
        function SubmitAllDataWhy() {
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
                    errorMessage += `Masalah for W1-${i} is .<br>`;
                }

                if (kategory === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${i} is .<br>`;
                }
            }

            let getAllDataWhy2 = listOFWhy2.map(item => {
                let w1 = item.w1;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-w2-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-w2-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${position} is .<br>`;
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
                    errorMessage += `Masalah for W1-${w1} W2-${w2} W3-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${w2} W3-${position} is .<br>`;
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
                    errorMessage += `Masalah for W1-${w1} W2-${w2} W3-${w3} W4-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${w2} W3-${w3} W4-${position} is .<br>`;
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
                        `Masalah for W1-${w1} W2-${w2} W3-${w3} W4-${w4} W5-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage +=
                        `Kategori for W1-${w1} W2-${w2} W3-${w3} W4-${w4} W5-${position} is .<br>`;
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
            let pc_aktual = $('#pc_aktual').val();
            let pc_target = $('#pc_target').val();
            let pc_ap_pica = $('select[name="pc_ap_pica"]').val();
            let pc_problem = $('#pc_problem').val();
            let pc_kp = $('#pc_kp').val();
            let pc_es = $('#pc_es').val();

            // Helper function to validate and highlight
            function validateField(field, fieldName, fieldLabel) {
                if (field === '') {
                    isValid = false;
                    errorMessage += `${fieldLabel} is .<br>`;
                }
            }

            validateField(pc_thn, 'pc_thn', 'Tahun');
            validateField(pc_bln, 'pc_bln', 'Bulan');
            validateField(pc_week, 'pc_week', 'Minggu');
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
                url: "/add-transaction",
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
                                            <label class="ms-0" for="input-why">Why 1 - 1</label>
                                            <textarea type="textarea" id="input-why" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-static my-4">
                                            <label for="input-kategori" class="ms-0 kategory-why">Kategori </label>
                                            <select class="form-control" name="input-kategori"  >
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
            $('#scrollableDiv').scrollTop(0).scrollLeft(0);
            let dataWhy1 = <?php echo json_encode($dataPicaW1); ?>;
            let dataWhy2 = <?php echo json_encode($dataPicaW2); ?>;
            let dataWhy3 = <?php echo json_encode($dataPicaW3); ?>;
            let dataWhy4 = <?php echo json_encode($dataPicaW4); ?>;
            let dataWhy5 = <?php echo json_encode($dataPicaW5); ?>;
            var solution = <?php echo json_encode($solution); ?>;
            // console.log(solution);
            var urutan_node = 1;
            var dataUrutanDivWhy1 = [];
            var dataUrutanDivWhy2 = [];
            var dataUrutanDivWhy3 = [];
            var dataUrutanDivWhy4 = [];
            var dataUrutanDivWhy5 = [];

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
                            <div class="row">
                                <div class="input-group input-group-static">
                                    <label for="input-why">-- WHY -- </label>
                                    <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy1[i].why }</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end" style="margin: 10px">
                        <div class="col-3">
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
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy2[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end" style="margin: 10px">
                            <div class="col-3">
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
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy3[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end" style="margin: 10px">
                            <div class="col-3">
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
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy4[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end" style="margin: 10px">
                            <div class="col-3">
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
                                <div class="row">
                                    <div class="input-group input-group-static">
                                        <label for="input-why">-- WHY -- </label>
                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">${ dataWhy5[i].why }</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end" style="margin: 10px">
                            <div class="col-3">
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
                    w5: dataWhy5[i].index_w5,
                    position: urutan_node
                }
                urutan_node += 1;
                dataUrutanDivWhy5.push(dataTMPDIVPosition);
                $('#treemain').append(dataDIVNode);
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
    </script>
    <script type="text/javascript">
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
                                                <input class="form-control" type="text" inputmode="decimal"
                                                    placeholder="Masukkan note untuk PIC" value="${e.note_step}" name="pc_aktual_${index}"
                                                    id="pc_aktual_${index}" disabled>
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
