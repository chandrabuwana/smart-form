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
                                        <select class="form-control" name="shift" id="shiftSelector">
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
                                        {{-- <input type="text" class="form-control" id="operator_load"
                                            value="{{ $record->operator_leader }}" name="operator_load"> --}}
                                        <select class="form-control form-select" id="operator_load" name="operator_load" required>
                                            <option disabled>-- Select Nama Operator --</option>
                                            @forelse($users as $user)
                                                <option value="{{ $user->nik ?? '' }}" {{ $record->operator_leader == $user->nik ? 'selected' : '' }}>
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
                                        <input type="text" class="form-control" id="nama-pic"
                                            value="{{ optional(collect($approvalList)->firstWhere('nik', $record->pic_area))->nama ?? '' }}"
                                            readonly>
                                        <input type="hidden" name="nama_pic" value="{{ $record->pic_area }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site" class="ms-0">Site</label>
                                        <select class="form-control form-select" id="site" name="site" required>
                                            <option disabled>-- Select Site --</option>
                                            @forelse($sites as $site)
                                                <option value="{{ $site->KodeST ?? '' }}" {{ $record->site == $site->KodeST ? 'selected' : '' }}>
                                                    {{ $site->KodeST ?? 'Site tidak tersedia' }}
                                                </option>
                                            @empty
                                                <option>Data site tidak ditemukan</option>
                                            @endforelse
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-4" id="tablesContainer">
                                @foreach ($record->alat_angkut as $index => $alat)
                                    <table class="table table-bordered" id="mainTable">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>Alat Angkut</th>
                                                <th>CN</th>
                                                <th colspan="4" class="text-center">
                                                    <input class="form-control" type="text" name="alat_angkut"
                                                        placeholder="Input Alat Angkut" value="{{ $alat }}"
                                                        style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);">
                                                </th>
                                                <th>∑</th>
                                                <th rowspan="2" class="text-center align-middle">Material</th>
                                            </tr>
                                            <tr>
                                                <th>Nama Operator</th>
                                                <th colspan="5" class="text-center">
                                                    {{-- <input class="form-control" type="text" name="nama_operator"
                                                        style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);"
                                                        placeholder="Input Nama Operator"
                                                        value="{{ $record->nama_operator[$index] }}"> --}}
                                                        <select class="form-control form-select" name="nama_operator" required
                                                            style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);">
                                                            <option disabled>-- Select Nama Operator --</option>
                                                            @forelse($users as $user)
                                                                <option value="{{ $user->nik ?? '' }}" {{ $record->nama_operator[$index] == $user->nik ? 'selected' : '' }}>
                                                                    {{ $user->nama ?? 'User tidak tersedia' }}
                                                                </option>
                                                            @empty
                                                                <option>Data karyawan tidak ditemukan</option>
                                                            @endforelse
                                                        </select>
                                                </th>
                                                <th>RITASI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php

                                                $alatAngkut = $record->shift == 'DS' ? $dataDS : $dataNS;
                                                $counts = 1;
                                            @endphp

                                            @foreach ($alatAngkut as $id => $alat)
                                                <tr>
                                                    <td>{{ $alat }}</td>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <td>
                                                            <input type="time" class="time-input form-control"
                                                                name="time[{{ $counts }}][{{ $i }}]"
                                                                value="{{ $time_details[$counts][$index]->{$i} }}">
                                                        </td>
                                                    @endfor
                                                    <td>
                                                        <input type="text" class="form-control text-center"
                                                            value="{{ $nonNullCounts[$counts][$index] }}">
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control" name="material[]" cols="5">{{ $record->material[$index][$id] }}</textarea>
                                                    </td>
                                                </tr>
                                                @php
                                                    $counts++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endforeach

                            </div>




                            <div class="bg-gradient-success rounded p-2 mt-2">
                                <div id="row-container">
                                    <h6 class="custom-text-color">IDENTIFIKASI TINDAKAN YANG DILAKUKAN</h6>
                                    @foreach ($record->kendala as $index => $kendala)
                                        <div class="row input-row">
                                            <div class="col-3 mt-4">
                                                <div class="input-group input-group-static mb-3">
                                                    <label class="custom-text-color">Kendala / Lokasi</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $kendala }}" name="kendala[]">
                                                </div>
                                            </div>
                                            <div class="col-3 mt-4">
                                                <div class="input-group input-group-static mb-3">
                                                    <label class="custom-text-color">Waktu Mulai</label>
                                                    <input type="time" class="form-control"
                                                        value="{{ $record->waktu_mulai[$index] }}" name="waktu_mulai[]">
                                                </div>
                                            </div>
                                            <div class="col-3 mt-4">
                                                <div class="input-group input-group-static mb-3">
                                                    <label class="custom-text-color">Waktu Selesai</label>
                                                    <input type="time" class="form-control"
                                                        value="{{ $record->waktu_selesai[$index] }}"
                                                        name="waktu_selesai[]">
                                                </div>
                                            </div>
                                            <div class="col-3 mt-4">
                                                <div class="input-group input-group-static mb-3">
                                                    <label class="custom-text-color">Keterangan</label>
                                                    <input type="text" value="{{ $record->keterangan[$index] }}"
                                                        class="form-control" name="keterangan[]">
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>

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
                                        <input type="text" class="form-control" id="dibuat"
                                            value="{{ optional(collect($approvalList)->firstWhere('nik', $record->checker))->nama ?? '' }}"
                                            readonly>
                                        <input type="hidden" name="dibuat_oleh" value="{{ $record->checker }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa_oleh" id="diperiksa" class="form-control" required>
                                            <option disabled selected>-- Select Validator --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}"
                                                    {{ old('validated', $record->pengawas ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                            @endforeach
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
