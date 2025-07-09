@extends('master.master_page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                        <span class="alert-icon align-middle"><i class="fas fa-check-circle"></i></span>
                        <span class="alert-text">{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                        <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                        <span class="alert-text">{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                <div class="card">
                    <!-- Card Header -->
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3"> Form Checker Production</h6>
                        </div>
                    </div>

                    <form id="formChecker" method="POST" style="margin-top: 2rem;">
                        @csrf
                        <div class="mx-3">
                            <input type="hidden" name="status" value="{{ $record->status }}">
                            <input type="text" name="doc_num" value="{{ $record->doc_num }}" hidden>
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">Tanggal</label>
                                        <input type="date" class="form-control" value="{{ $record->tanggal }}"
                                            id="date" name="date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="alat_pc" class="ms-0">Alat Muat PC:</label>
                                        <input type="text" class="form-control" id="alat_pc" name="alat_pc"
                                            value="{{ $record->alat_muat[0] }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="alat_x" class="ms-0">Alat Muat X:</label>
                                        <input type="text" class="form-control" id="alat_x" name="alat_x"
                                            value="{{ $record->alat_muat[1] }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="start_load" class="ms-0">Start Loading</label>
                                        <input type="time" class="form-control" value="{{ $record->start_loading }}"
                                            id="start_load" name="start_load">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="stop_load" class="ms-0">Stop Loading</label>
                                        <input type="time" class="form-control" id="stop_load"
                                            value="{{ $record->stop_loading }}" name="stop_load">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="shift" class="ms-0">Shift</label>
                                        <select class="form-control" name="shift" id="shiftSelector"
                                            onchange="onShiftChange()">
                                            <option disabled selected>-- Select Shift --</option>
                                            <option value="DS"
                                                {{ old('shift', $record->shift ?? '') == 'DS' ? 'selected' : '' }}>
                                                DS</option>
                                            <option value="NS"
                                                {{ old('shift', $record->shift ?? '') == 'NS' ? 'selected' : '' }}>
                                                NS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="operator_load" class="ms-0">Nama Operator Loader</label>
                                        <select class="form-control form-select" id="operator_load" name="operator_load"
                                            required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama_pic" class="ms-0">Nama PIC</label>

                                        <input type="text" id="nama_pic" readonly class="form-control"
                                            name="nama_pic" value="{{ $record->pic_area }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site" class="ms-0">Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site', strtolower($record->site)) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <select class="form-control form-select" id="multiple_angkut"
                                        name="multiple_angkut[]" multiple>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive mt-4" id="tablesContainer">

                                <table class="table table-bordered" id="mainTable">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Alat Angkut</th>
                                            <th>CN</th>
                                            <th colspan="4" class="text-center">
                                                <select class="form-control" name="alat_angkut" id="alat_angkut"
                                                    onchange="onAlatAngkutChange()"
                                                    style="background-color: #eee7e8; color: rgb(11, 10, 10);" required>
                                                    <option value="">-- Pilih Alat Angkut --</option>
                                                </select>

                                            <th rowspan="2" class="text-center align-middle">Material</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Operator</th>
                                            <th class="text-center">Jam 1</th>
                                            <th class="text-center">Jam 2</th>
                                            <th class="text-center">Jam 3</th>
                                            <th class="text-center">Jam 4</th>
                                            <th class="text-center">Jam 5</th>



                                        </tr>
                                    </thead>
                                    <tbody id="alatangkut-container">

                                    </tbody>
                                </table>
                                <input type="hidden" name="alat_angkut_all" id="alat_angkut_all">

                            </div>


                            <div class="row">
                                <div class="col-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Loading Point</label>
                                            <input type="text" class="form-control"
                                                value="{{ $record->loading_point }}" name="loading_point">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Jarak (M)</label>
                                            <input type="text" class="form-control" value="{{ $record->jarak }}"
                                                name="jarak">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Disposal</label>
                                            <input type="text" class="form-control" value="{{ $record->disposal }}"
                                                name="disposal">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Dibuat Oleh</label>

                                        <input type="text" readonly class="form-control" name="dibuat_oleh"
                                            value="{{ $record->checker }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa_oleh" id="validated" class="form-control" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('prod.form.checker.dashboard') }}"
                                                class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .table> :not(caption)>*>* {
            padding: 0.5rem;

        }

        .custom-text-color {
            color: #fff;

        }

        table {
            border: black 1px solid;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

        }



        .form-actions {
            justify-content: flex-end;
            display: flex;
            gap: 10px;
            margin-top: 10px;

        }

        .bg-success {
            background-color: #a6000b !important;
        }

        /* Center all content in tbody */
        .table tbody td {
            text-align: center;
            vertical-align: middle;
            height: 60px;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .table thead {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: #09090a;

        }

        .table tbody td.form-control {
            text-align: left;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            transform: scale(1.5);
            cursor: pointer;
        }
    </style>
@endsection

@section('custom-js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        $(function() {
            var form = $("#formChecker");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);

                axios.post('{{ route('prod.form.checker.update') }}', formData)
                    .then(function(response) {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('prod.form.checker.dashboard') }}';
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join(
                                    '\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    })
                    .finally(function() {
                        submitBtn.prop('disabled', false);
                    });

            });
        });
        document.getElementById('shiftSelector').addEventListener('change', function() {
            var selectedShift = this.value;


            var rows = document.querySelectorAll('.shift-row');
            rows.forEach(function(row) {
                row.style.display = 'none';
            });


            if (selectedShift === 'DS') {
                var dsRows = document.querySelectorAll('.shift-row.DS');
                dsRows.forEach(function(row) {
                    row.style.display = 'table-row';
                });
            } else if (selectedShift === 'NS') {
                var nsRows = document.querySelectorAll('.shift-row.NS');
                nsRows.forEach(function(row) {
                    row.style.display = 'table-row';
                });
            }
        });




        $(document).ready(function() {

            $('#site').select2();
            $('#operator_load').select2();
            $('#nama_operator').select2();
            $('#alat_angkut').select2({
                placeholder: "Pilih alat angkut",
                allowClear: true
            });
            $('#multiple_angkut').select2({
                placeholder: "Pilih kategori",
                allowClear: true,
                maximumSelectionLength: 6
            });

            $('#multiple_angkut').on('change', function() {
                let selectedValues = $(this).val() || [];
                let $alatDropdown = $('#alat_angkut');
                let $alatHiddenInput = $('#alat_angkut_all');

                $alatDropdown.empty();

                if (selectedValues.length > 0) {
                    $alatDropdown.append('<option value="">-- Pilih Alat Angkut --</option>');
                    selectedValues.forEach(function(val) {
                        $alatDropdown.append(`<option value="${val}">${val}</option>`);
                    });
                    renderAlatAngkutTable(JSON.stringify(selectedValues));
                    $alatHiddenInput.val(JSON.stringify(selectedValues));
                } else {
                    $alatDropdown.append('<option value="">-- Tidak ada pilihan --</option>');
                    $alatHiddenInput.val('');
                }
            });
        });
        $(document).ready(function() {

            function updateAlatAngkutDropdown() {
                let selectedValues = $('#multiple_angkut').val() || [];
                let $alatDropdown = $('#alat_angkut');
                let $alatHiddenInput = $('#alat_angkut_all');

                $alatDropdown.empty();

                if (selectedValues.length > 0) {
                    $alatDropdown.append('<option value="">-- Pilih Alat Angkut --</option>');
                    selectedValues.forEach(function(val) {
                        $alatDropdown.append(`<option value="${val}">${val}</option>`);
                    });
                    renderAlatAngkutTable(JSON.stringify(selectedValues));
                    $alatHiddenInput.val(JSON.stringify(selectedValues));
                } else {
                    $alatDropdown.append('<option value="">-- Tidak ada pilihan --</option>');
                    $alatHiddenInput.val('');
                }
            }


            $('#multiple_angkut').on('change', function() {
                updateAlatAngkutDropdown();
            });

            $('#site').on('change', function() {
                loadAlatBySite($(this).val());
            });


            var initialSite = $('#site').val();
            if (initialSite) {
                loadAlatBySite(initialSite);
            }


            function loadAlatBySite(selectedSite) {
                $.ajax({
                    url: '{{ route('get.alat.by.site') }}',
                    type: 'GET',
                    data: {
                        site: selectedSite
                    },
                    success: function(data) {
                        $('#multiple_angkut').empty();


                        var selectedValues = {!! json_encode($record->alat_angkut ?? []) !!};

                        if (data.length > 0) {
                            $.each(data, function(index, item) {

                                var isSelected = '';
                                if (selectedValues && selectedValues.includes(item
                                        .no_lambung)) {
                                    isSelected = ' selected';
                                }

                                $('#multiple_angkut').append(
                                    `<option value="${item.no_lambung}"${isSelected}>${item.no_lambung}</option>`
                                );
                            });
                        }

                        updateAlatAngkutDropdown();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }


            updateAlatAngkutDropdown();
        });
    </script>
    <script>
        let globalSavedValues = {};

        function renderAlatAngkutTable(selectedValuesJson) {
            let users = @json($users);
            let record = @json($record);
            let dataDS = @json($dataDS);
            let dataNS = @json($dataNS);
            let ritase = @json($nonNullCounts);
            console.log(record);
            let combinedData = [...dataDS, ...dataNS];

            const container = document.getElementById('alatangkut-container');


            const currentAlat = document.getElementById('alat_angkut')?.value;
            if (currentAlat) {
                const currentValues = saveCurrentValues();
                Object.assign(globalSavedValues, currentValues);
            }

            container.innerHTML = '';

            const shiftSelector = document.getElementById('shiftSelector');
            const selectedShift = shiftSelector ? shiftSelector.value : '';

            let alatangkut = JSON.parse(selectedValuesJson || '[]');


            if (record && typeof record === 'object' && !globalSavedValues.isRecordLoaded) {
                populateFromRecord(record);
                globalSavedValues.isRecordLoaded = true;
            }

            alatangkut.forEach((alat, alatIndex) => {
                let id = 1;
                let section = document.createElement('div');
                section.id = `section-${alat}`;
                section.className = 'alat-section';
                section.style.display = 'none';


                let operatorRow = document.createElement('tr');
                operatorRow.innerHTML = `
    <td colspan="2"><strong>Nama Operator</strong></td>
    <td colspan="5" class="text-center">
        <select class="form-control form-select nama-operator-select" name="nama_operator_${alat}" id="nama_operator_${alat}" required style="background-color: #eee7e8; color: rgb(11, 10, 10); width: 100%;">
            <option disabled selected>-- Select Nama Operator --</option>
        </select>
    </td>
    <td></td>
`;

                container.appendChild(operatorRow);
                operatorRow.classList.add('operator-row', `operator-${alat}`);
                operatorRow.style.display = 'none';

                
                const operatorSelect = operatorRow.querySelector(`#nama_operator_${alat}`);
                $(operatorSelect).select2({
                    placeholder: '-- Select Nama Operator --',
                    width: '100%',
                    ajax: {
                        url: '{{ route('checker.approval.list') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term || ''
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        id: item.nama,
                                        text: `${item.nama} (${item.nik})`
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });


                const savedValue = record?.nama_operator?.[alatIndex] || globalSavedValues[`operator_${alat}`];
                if (savedValue) {
                    $.ajax({
                        url: '{{ route('checker.approval.list') }}',
                        dataType: 'json',
                        success: function(data) {
                            const matched = data.find(item => item.nama === savedValue);
                            if (matched) {
                                const option = new Option(`${matched.nama} (${matched.nik})`, matched
                                    .nama, true, true);
                                $(operatorSelect).append(option).trigger('change');
                            }
                        }
                    });
                }


                let dataToShow = [];
                if (selectedShift === 'DS') {
                    dataToShow = dataDS;
                } else if (selectedShift === 'NS') {
                    dataToShow = dataNS;
                } else {
                    dataToShow = combinedData;
                }

                dataToShow.forEach((data, dataIndex) => {
                    let cn = 0;
                    let shift = dataDS.includes(data) ? 'DS' : 'NS';
                    let row = document.createElement('tr');
                    row.classList.add('shift-row', shift, `alat-row-${alat}`);
                    row.id = `row-${id}`;
                    row.style.display = 'none';

                    let timeInputs = '';
                    for (let i = 1; i <= 5; i++) {
                        const inputName = `time_${alat}_${id}_${i}`;


                        let timeValue = '';
                        if (record && record[`time_detail${id}`] &&
                            record[`time_detail${id}`][alatIndex] &&
                            record[`time_detail${id}`][alatIndex][i - 1] !== null) {
                            timeValue = record[`time_detail${id}`][alatIndex][i - 1];
                        } else if (globalSavedValues[`${alat}_time_${id}_${i}`]) {
                            timeValue = globalSavedValues[`${alat}_time_${id}_${i}`];
                        }

                        timeInputs +=
                            `<td><input type="time" class="form-control" name="${inputName}" value="${timeValue}"></td>`;
                    }


                    let materialValue = '';
                    if (record && record.material &&
                        record.material[alatIndex] &&
                        record.material[alatIndex][id - 1] !== null) {
                        materialValue = record.material[alatIndex][id - 1];
                    } else if (globalSavedValues[`${alat}_material_${alat}_${id}`]) {
                        materialValue = globalSavedValues[`${alat}_material_${alat}_${id}`];
                    }

                    const materialName = `material_${alat}_${id}`;

                    row.innerHTML = `
                <td>${data}</td>
                ${timeInputs}

                <td><textarea class="form-control" name="${materialName}" rows="1">${materialValue}</textarea></td>
            `;
                    container.appendChild(row);
                    id++;
                    cn++;
                });


                let additionalSection = document.createElement('tr');
                additionalSection.classList.add('additional-section', `alat-row-${alat}`);
                additionalSection.style.display = 'none';


                let kendalaValue = '';
                let waktuMulaiValue = '';
                let waktuSelesaiValue = '';
                let keteranganValue = '';

                if (record) {
                    if (record.kendala && record.kendala[alatIndex]) {
                        kendalaValue = record.kendala[alatIndex];
                    }
                    if (record.waktu_mulai && record.waktu_mulai[alatIndex]) {
                        waktuMulaiValue = record.waktu_mulai[alatIndex];
                    }
                    if (record.waktu_selesai && record.waktu_selesai[alatIndex]) {
                        waktuSelesaiValue = record.waktu_selesai[alatIndex];
                    }
                    if (record.keterangan && record.keterangan[alatIndex]) {
                        keteranganValue = record.keterangan[alatIndex];
                    }
                } else {
                    kendalaValue = globalSavedValues[`kendala_${alat}`] || '';
                    waktuMulaiValue = globalSavedValues[`waktu_mulai_${alat}`] || '';
                    waktuSelesaiValue = globalSavedValues[`waktu_selesai_${alat}`] || '';
                    keteranganValue = globalSavedValues[`keterangan_${alat}`] || '';
                }

                additionalSection.innerHTML = `
            <td colspan="8" style="padding: 10px;">
                <div class="bg-gradient-success rounded p-2">
                    <div id="row-container-${alat}">
                        <h6 class="custom-text-color">IDENTIFIKASI TINDAKAN YANG DILAKUKAN</h6>
                        <div class="row input-row">
                            <div class="col-3 mt-4">
                                <div class="input-group input-group-static mb-3">
                                    <label class="custom-text-color">Kendala / Lokasi</label>
                                    <input type="text" class="form-control" name="kendala_${alat}" value="${kendalaValue}">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <div class="input-group input-group-static mb-3">
                                    <label class="custom-text-color">Waktu Mulai</label>
                                    <input type="time" class="form-control" name="waktu_mulai_${alat}" value="${waktuMulaiValue}">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <div class="input-group input-group-static mb-3">
                                    <label class="custom-text-color">Waktu Selesai</label>
                                    <input type="time" class="form-control" name="waktu_selesai_${alat}" value="${waktuSelesaiValue}">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <div class="input-group input-group-static mb-3">
                                    <label class="custom-text-color">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan_${alat}" value="${keteranganValue}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        `;
                container.appendChild(additionalSection);
            });

            onAlatAngkutChange();
        }


        function populateFromRecord(record) {
            if (!record) return;


            if (record.alat_angkut && Array.isArray(record.alat_angkut)) {
                record.alat_angkut.forEach((alat, alatIndex) => {

                    if (record.nama_operator && record.nama_operator[alatIndex]) {
                        globalSavedValues[`operator_${alat}`] = record.nama_operator[alatIndex];
                    }

                    if (record.kendala && record.kendala[alatIndex]) {
                        globalSavedValues[`kendala_${alat}`] = record.kendala[alatIndex];
                    }

                    if (record.waktu_mulai && record.waktu_mulai[alatIndex]) {
                        globalSavedValues[`waktu_mulai_${alat}`] = record.waktu_mulai[alatIndex];
                    }

                    if (record.waktu_selesai && record.waktu_selesai[alatIndex]) {
                        globalSavedValues[`waktu_selesai_${alat}`] = record.waktu_selesai[alatIndex];
                    }

                    if (record.keterangan && record.keterangan[alatIndex]) {
                        globalSavedValues[`keterangan_${alat}`] = record.keterangan[alatIndex];
                    }


                    if (record.material && record.material[alatIndex]) {
                        for (let i = 0; i < record.material[alatIndex].length; i++) {
                            if (record.material[alatIndex][i] !== null) {
                                globalSavedValues[`${alat}_material_${alat}_${i+1}`] = record.material[alatIndex][
                                    i
                                ];
                            }
                        }
                    }


                    for (let i = 1; i <= 12; i++) {
                        const timeDetailKey = `time_detail${i}`;
                        if (record[timeDetailKey] && record[timeDetailKey][alatIndex]) {
                            for (let j = 0; j < record[timeDetailKey][alatIndex].length; j++) {
                                if (record[timeDetailKey][alatIndex][j] !== null) {
                                    globalSavedValues[`${alat}_time_${i}_${j+1}`] = record[timeDetailKey][alatIndex]
                                        [j];
                                }
                            }
                        }
                    }
                });
            }
        }

        function saveCurrentValues() {
            const values = {};

            const currentAlat = document.getElementById('alat_angkut')?.value;
            if (!currentAlat) return values;


            const operatorSelect = document.querySelector(
                `.operator-${currentAlat} select[name="nama_operator_${currentAlat}"]`);
            if (operatorSelect) {
                values[`operator_${currentAlat}`] = operatorSelect.value;
            }

            const timeInputs = document.querySelectorAll(`.alat-row-${currentAlat} input[type="time"]`);
            timeInputs.forEach(input => {
                if (input.name && input.value) {
                    values[`${currentAlat}_${input.name}`] = input.value;
                }
            });


            const materialTextareas = document.querySelectorAll(`.shift-row textarea[name^="material_"]`);
            materialTextareas.forEach(textarea => {
                if (textarea.name && textarea.value) {
                    values[`${currentAlat}_${textarea.name}`] = textarea.value;
                }
            });


            const kendalaInput = document.querySelector(`input[name="kendala_${currentAlat}"]`)?.value;
            if (kendalaInput !== undefined) {
                values[`kendala_${currentAlat}`] = kendalaInput;
            }

            const waktuMulaiInput = document.querySelector(`input[name="waktu_mulai_${currentAlat}"]`)?.value;
            if (waktuMulaiInput !== undefined) {
                values[`waktu_mulai_${currentAlat}`] = waktuMulaiInput;
            }

            const waktuSelesaiInput = document.querySelector(`input[name="waktu_selesai_${currentAlat}"]`)?.value;
            if (waktuSelesaiInput !== undefined) {
                values[`waktu_selesai_${currentAlat}`] = waktuSelesaiInput;
            }

            const keteranganInput = document.querySelector(`input[name="keterangan_${currentAlat}"]`)?.value;
            if (keteranganInput !== undefined) {
                values[`keterangan_${currentAlat}`] = keteranganInput;
            }

            return values;
        }

        function onAlatAngkutChange() {
            const selected = document.getElementById('alat_angkut').value;


            document.querySelectorAll('.operator-row').forEach(row => {
                row.style.display = 'none';
            });

            document.querySelectorAll('.shift-row, .additional-section').forEach(row => {
                row.style.display = 'none';
            });

            if (selected) {

                const operatorRow = document.querySelector(`.operator-${selected}`);
                if (operatorRow) {
                    operatorRow.style.display = 'table-row';
                }


                document.querySelectorAll(`.alat-row-${selected}`).forEach(row => {
                    row.style.display = 'table-row';
                });
            }
        }

        function onShiftChange() {

            const selected = document.getElementById('alat_angkut').value;
            if (selected) {
                renderAlatAngkutTable(JSON.stringify([selected]));
            }
        }


        function initializeFormWithRecord() {
            let record = @json($record);
            if (record && record.alat_angkut && Array.isArray(record.alat_angkut) && record.alat_angkut.length > 0) {

                const alatAngkutSelect = document.getElementById('alat_angkut');
                if (alatAngkutSelect) {
                    alatAngkutSelect.value = record.alat_angkut[0];

                    renderAlatAngkutTable(JSON.stringify([record.alat_angkut[0]]));
                }
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            initializeFormWithRecord();
        });
    </script>
    <script>
        $(function() {
            const selectedNik = '{{ $record->pengawas }}';

            $('#validated').select2({
                placeholder: '-- Select Creator --',
                width: '100%',
                ajax: {
                    url: '{{ route('checker.approval.list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term || ''
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.nama,
                                    text: item.nama + ' (' + item.nik +
                                        ')',
                                };
                            })
                        };
                    },
                    cache: true
                }
            });


            if (selectedNik) {
                $.ajax({
                    url: '{{ route('checker.approval.list') }}',
                    dataType: 'json',
                    success: function(data) {
                        const matched = data.find(item => item.nama === selectedNik);
                        if (matched) {
                            const option = new Option(matched.nama + ' (' + matched.nik + ')', matched
                                .nama, true, true);
                            $('#validated').append(option).trigger('change');
                        }
                    }
                });
            }
        });
    </script>
    <script>
        $(function() {
            const selectedNik = '{{ $record->operator_leader }}';

            $('#operator_load').select2({
                placeholder: '-- Select Operator --',
                width: '100%',
                ajax: {
                    url: '{{ route('checker.approval.list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term || ''
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.nama,
                                    text: item.nama + ' (' + item.nik +
                                        ')',
                                };
                            })
                        };
                    },
                    cache: true
                }
            });


            if (selectedNik) {
                $.ajax({
                    url: '{{ route('checker.approval.list') }}',
                    dataType: 'json',
                    success: function(data) {
                        const matched = data.find(item => item.nama === selectedNik);
                        if (matched) {
                            const option = new Option(matched.nama + ' (' + matched.nik + ')', matched
                                .nama, true, true);
                            $('#operator_load').append(option).trigger('change');
                        }
                    }
                });
            }
        });
    </script>
@endsection
