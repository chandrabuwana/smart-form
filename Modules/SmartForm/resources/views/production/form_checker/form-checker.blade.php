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
                    {{-- id="postForm" --}}
                    <form id="postForm" method="POST" style="margin-top: 2rem;">
                        @csrf
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">Tanggal</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="alat_pc" class="ms-0">Alat Muat PC:</label>
                                        <input type="text" class="form-control" id="alat_pc" name="alat_pc" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="alat_x" class="ms-0">Alat Muat X:</label>
                                        <input type="text" class="form-control" id="alat_x" name="alat_x" required>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="start_load" class="ms-0">Start Loading</label>
                                        <input type="time" class="form-control" id="start_load" name="start_load"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="stop_load" class="ms-0">Stop Loading</label>
                                        <input type="time" class="form-control" id="stop_load" name="stop_load" required
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="shift" class="ms-0">Shift</label>
                                        <select class="form-control" name="shift" id="shiftSelector" required
                                            onchange="onShiftChange()">
                                            <option disabled selected>-- Select Shift --</option>
                                            <option value="DS">DS</option>
                                            <option value="NS">NS</option>
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
                                            <option disabled selected>-- Select Nama Operator --</option>
                                            @forelse($users as $user)
                                                <option value="{{ $user->nama ?? '' }}">
                                                    {{ $user->nama ?? 'User tidak tersedia' }}
                                                </option>
                                            @empty
                                                <option>Data karyawan tidak ditemukan</option>
                                            @endforelse
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama_pic" class="ms-0">Nama PIC</label>

                                        <input type="text" class="form-control" name="nama_pic" value="{{session('username')}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site" class="ms-0">Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site') !!}

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

                            <div class="table-responsive mt-4">



                                <table class="table table-bordered">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Alat Angkut</th>
                                            <th>CN</th>
                                            <th colspan="5" class="text-center">
                                                <select class="form-control" name="alat_angkut" id="alat_angkut"
                                                    style="background-color: #eee7e8; color: rgb(11, 10, 10);" required
                                                    onchange="onAlatAngkutChange()">
                                                    <option value="">-- Pilih Alat Angkut --</option>
                                                </select>
                                            </th>
                                            <th rowspan="2" class="text-center align-middle">Material</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Nama Operator</th>
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
                                <!-- Letakkan input hidden di luar table -->
                                <input type="hidden" name="alat_angkut_all" id="alat_angkut_all">





                            </div>


                            <div class="row">
                                <div class="col-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Loading Point</label>
                                            <input type="text" class="form-control" name="loading_point" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Jarak (M)</label>
                                            <input type="text" class="form-control" name="jarak" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Disposal</label>
                                            <input type="text" class="form-control" name="disposal" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Dibuat Oleh</label>

                                        <input type="text" class="form-control" name="dibuat_oleh" readonly
                                            value="{{ session('username') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa_oleh" id="validated" class="form-control form-select"
                                            required>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('prod.form.checker.dashboard') }}"
                                                class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
            var form = $("#postForm");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);
                console.log('submit');
                var formData = new FormData(this);

                axios.post('{{ route('prod.checker.submit') }}', formData)
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
        $(document).ready(function() {
            $('#site').on('change', function() {
                var selectedSite = $(this).val();

                $.ajax({
                    url: '{{ route('get.alat.by.site') }}',
                    data: {
                        site: selectedSite
                    },
                    success: function(data) {
                        $('#multiple_angkut').empty();

                        if (data.length > 0) {
                            $.each(data, function(index, item) {
                                $('#multiple_angkut').append(
                                    `<option value="${item.no_lambung}">${item.no_lambung}</option>`
                                );
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#dibuat_oleh').select2();
            $('#diperiksa').select2();
            $('#site').select2();
            $('#alat_angkut').select2();
            $('#operator_load').select2();
            $('#nama_operator').select2();
            $('#multiple_angkut').select2({
                placeholder: "Pilih kategori",
                allowClear: true,
                maximumSelectionLength: 5
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
    </script>
    <script>
        let globalSavedValues = {};

        function renderAlatAngkutTable(selectedValuesJson) {
            let users = @json($users);
            let dataDS = @json($dataDS);
            let dataNS = @json($dataNS);
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

            alatangkut.forEach((alat, index) => {
                let id = 1;


                let section = document.createElement('div');
                section.id = `section-${alat}`;
                section.className = 'alat-section';
                section.style.display = 'none';



                let operatorRow = document.createElement('tr');
                operatorRow.innerHTML = `
                    <td colspan="2"><strong>Nama Operator</strong></td>
                    <td colspan="5" class="text-center">
                        <select class="form-control form-select" name="nama_operator_${alat}" id="nama_operator_${alat}" required style="background-color: #eee7e8; color: rgb(11, 10, 10); width: 100%;">
                            <option disabled selected>-- Select Nama Operator --</option>
                            ${
                                users.length > 0
                                ? users.map(user => `<option value="${user.nik ?? ''}">${user.nama ?? 'User tidak tersedia'}</option>`).join('')
                                : '<option>Data karyawan tidak ditemukan</option>'
                            }
                        </select>
                    </td>
                    <td></td>
                `;
                container.appendChild(operatorRow);
                operatorRow.classList.add('operator-row', `operator-${alat}`);
                operatorRow.style.display = 'none';
                $(`#nama_operator_${alat}`).select2();

                setTimeout(() => {
                    const operatorSelect = operatorRow.querySelector(
                        `select[name="nama_operator_${alat}"]`);
                    if (operatorSelect && globalSavedValues[`operator_${alat}`]) {
                        operatorSelect.value = globalSavedValues[`operator_${alat}`];

                    }
                }, 0);

                let dataToShow = [];
                if (selectedShift === 'DS') {
                    dataToShow = dataDS;
                } else if (selectedShift === 'NS') {
                    dataToShow = dataNS;
                } else {
                    dataToShow = combinedData;
                }

                dataToShow.forEach(data => {
                    let shift = dataDS.includes(data) ? 'DS' : 'NS';
                    let row = document.createElement('tr');
                    row.classList.add('shift-row', shift, `alat-row-${alat}`);
                    row.id = `row-${id}`;
                    row.style.display = 'none';

                    let timeInputs = '';
                    for (let i = 1; i <= 5; i++) {
                        const inputName = `time_${alat}_${id}_${i}`;
                        const savedValue = globalSavedValues[`${alat}_time_${id}_${i}`] || '';
                        timeInputs +=
                            `<td><input type="time" class="form-control" name="${inputName}" value="${savedValue}"></td>`;
                    }

                    const materialName = `material_${alat}_${id}`;
                    const savedMaterial = globalSavedValues[`${alat}_${materialName}`] || '';

                    row.innerHTML = `
                        <td colspan="2">${data}</td>
                        ${timeInputs}
                        <td><textarea class="form-control" name="${materialName}" rows="1">${savedMaterial}</textarea></td>
                    `;
                    container.appendChild(row);
                    id++;
                });


                let additionalSection = document.createElement('tr');
                additionalSection.classList.add('additional-section', `alat-row-${alat}`);
                additionalSection.style.display = 'none';
                additionalSection.innerHTML = `
                    <td colspan="8" style="padding: 10px;">
                        <div class="bg-gradient-success rounded p-2">
                            <div id="row-container-${alat}">
                                <h6 class="custom-text-color">IDENTIFIKASI TINDAKAN YANG DILAKUKAN</h6>
                                <div class="row input-row">
                                    <div class="col-3 mt-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label class="custom-text-color">Kendala / Lokasi</label>
                                            <input type="text" class="form-control" name="kendala_${alat}" value="${globalSavedValues[`kendala_${alat}`] || ''}" >
                                        </div>
                                    </div>
                                    <div class="col-3 mt-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label class="custom-text-color">Waktu Mulai</label>
                                            <input type="time" class="form-control" name="waktu_mulai_${alat}" value="${globalSavedValues[`waktu_mulai_${alat}`] || ''}" >
                                        </div>
                                    </div>
                                    <div class="col-3 mt-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label class="custom-text-color">Waktu Selesai</label>
                                            <input type="time" class="form-control" name="waktu_selesai_${alat}" value="${globalSavedValues[`waktu_selesai_${alat}`] || ''}" >
                                        </div>
                                    </div>
                                    <div class="col-3 mt-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label class="custom-text-color">Keterangan</label>
                                            <input type="text" class="form-control" name="keterangan_${alat}" value="${globalSavedValues[`keterangan_${alat}`] || ''}">
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
    </script>
    <script>
        $(function() {
            $('#validated').select2({
                placeholder: '-- Pilih validated --',
                width: '100%',
                ajax: {
                    url: '{{ route('checker.approval.list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item
                                        .nama,
                                    text: item.nama + ' (' + item.nik + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
