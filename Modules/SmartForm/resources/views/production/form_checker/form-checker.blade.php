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

                    <form id="formChecker" method="POST">
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
                                        <select class="form-control" name="shift" id="shiftSelector" required>
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
                                        <input type="text" class="form-control" id="operator_load" name="operator_load"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama_pic" class="ms-0">Nama PIC</label>
                                        <input type="text" class="form-control" id="nama-pic" name="nama_pic"required>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary" id="addNewAlatAngkut">+ New Alat Angkut</a>
                            <div class="table-responsive mt-4" id="tablesContainer">
                                <table class="table table-bordered" id="mainTable">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Alat Angkut</th>
                                            <th>CN</th>
                                            <th colspan="4" style="text-align: center;">
                                                <input class="form-control" type="text" name="alat_angkut" required
                                                    placeholder="Input Alat Angkut"
                                                    style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);">
                                            </th>

                                            <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                Material
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Nama Operator</th>
                                            <th colspan="5" style="text-align: center;">
                                                <input class="form-control" type="text" name="nama_operator" required
                                                    style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);"
                                                    placeholder="Input Nama Operator">
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $id = 1;
                                            $combinedData = collect($dataDS)->merge(collect($dataNS));
                                        @endphp
                                        @foreach ($combinedData as $data)
                                            @php

                                                $shift = in_array($data, $dataDS) ? 'DS' : 'NS';
                                            @endphp
                                            <tr class="shift-row {{ $shift }}" style="display: none;"
                                                id="row{{ $id }}">
                                                <td>{{ $data }}</td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <td><input type="time" class=" form-control"
                                                            name="time[{{ $id }}][{{ $i }}]">
                                                    </td>
                                                @endfor

                                                <td>
                                                    <textarea class="form-control" name="material[]" cols="5"></textarea>
                                                </td>
                                            </tr>
                                            @php
                                                $id++;
                                            @endphp
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>

                            <div class="bg-gradient-success rounded p-2">
                                <div id="row-container">
                                    <h6 class="custom-text-color">IDENTIFIKASI TINDAKAN YANG DILAKUKAN</h6>
                                    <div class="row input-row">
                                        <div class="col-3 mt-4">
                                            <div class="input-group input-group-static mb-3">
                                                <label class="custom-text-color">Kendala / Lokasi</label>
                                                <input type="text" class="form-control" name="kendala[]" required>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-4">
                                            <div class="input-group input-group-static mb-3">
                                                <label class="custom-text-color">Waktu Mulai</label>
                                                <input type="time" class="form-control" name="waktu_mulai[]" required>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-4">
                                            <div class="input-group input-group-static mb-3">
                                                <label class="custom-text-color">Waktu Selesai</label>
                                                <input type="time" class="form-control" name="waktu_selesai[]"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-4">
                                            <div class="input-group input-group-static mb-3">
                                                <label class="custom-text-color">Keterangan</label>
                                                <input type="text" class="form-control" name="keterangan[]" required>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-primary" id="addRowButton">Add Row</a>
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
                                        <select name="dibuat_oleh" id="dibuat_oleh" class="form-control" required>
                                            <option disabled selected>-- Select Creator --</option>
                                            @foreach ($approvalList as $data)
                                                <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa_oleh" id="diperiksa" class="form-control" required>
                                            <option disabled selected>-- Select Approval --</option>
                                            @foreach ($approvalList as $data)
                                                <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                            @endforeach
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dibuat_oleh').select2();
            $('#diperiksa').select2();
        });
        $(function() {
            var form = $("#formChecker");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

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

        idcounter = 1;


        document.getElementById('addNewAlatAngkut').addEventListener('click', function() {
            var mainTable = document.getElementById('mainTable');
            var newTable = mainTable.cloneNode(true);
            newTable.id = 'newTable' + idcounter;


            var inputs = newTable.querySelectorAll('input');
            inputs.forEach((input) => {

                input.value = '';
                input.name = idcounter + input.name;
            });

            var textareas = newTable.querySelectorAll('textarea');
            textareas.forEach((textarea) => {
                textarea.value = '';
                textarea.name = idcounter + textarea.name;
            });


            document.getElementById('tablesContainer').appendChild(newTable);


            idcounter++;



            var removeButton = document.createElement('button');
            removeButton.innerText = 'Remove Table';
            removeButton.classList.add('removeButton', 'btn', 'btn-danger', 'mt-3');

            removeButton.addEventListener('click', function() {
                newTable.remove();
            });

            newTable.appendChild(removeButton);
        });



        document.getElementById('addRowButton').addEventListener('click', function() {
            const rowContainer = document.getElementById('row-container');
            const row = document.querySelector('.input-row');
            const newRow = row.cloneNode(true);


            const inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => input.value = '');


            const removeButton = document.createElement('a');
            removeButton.href = "#";
            removeButton.innerHTML = '<i class="fas fa-trash-alt fa-2x text-primary"></i>';
            removeButton.classList.add('removeRowButton');


            const colRemove = document.createElement('div');
            colRemove.classList.add('col-3', 'mb-1');
            colRemove.appendChild(removeButton);

            newRow.appendChild(colRemove);

            removeButton.addEventListener('click', function(event) {
                event.preventDefault();
                newRow.remove();
            });


            rowContainer.appendChild(newRow);
        });
    </script>
@endsection
