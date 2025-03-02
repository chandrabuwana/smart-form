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

                    <form action="{{ route('prod.form.checker.store') }}" method="POST">
                        @csrf
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">Tanggl</label>
                                        <input type="date" class="form-control" id="date" name="date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="alat-pc" class="ms-0">Alat Muat PC:</label>
                                        <input type="text" class="form-control" id="alat-pc" name="alat-pc">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="alat-x" class="ms-0">Alat Muat X:</label>
                                        <input type="text" class="form-control" id="alat-x" name="alat-x">
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="start-load" class="ms-0">Start Loading</label>
                                        <input type="time" class="form-control" id="start-load" name="start-load">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="stop-load" class="ms-0">Stop Loading</label>
                                        <input type="time" class="form-control" id="stop-load" name="stop-load" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="shift" class="ms-0">Shift</label>
                                        <select class="form-control" name="shift" id="shiftSelector">
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
                                        <label for="nama-operator-load" class="ms-0">Nama Operator Loader</label>
                                        <input type="text" class="form-control" id="nama-operator-load"
                                            name="operator-load" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama-pic" class="ms-0">Nama PIC</label>
                                        <input type="text" class="form-control" id="nama-pic" name="nama-pic"required>
                                    </div>
                                </div>
                            </div>
                            <h5>Alat Angkut 1</h5>
                            <a class="btn btn-primary" id="addNewAlatAngkut">+ New Alat Angkut</a>
                            <div class="table-responsive mt-4" id="tablesContainer">
                                <table class="table table-bordered" id="mainTable">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Alat Angkut</th>
                                            <th>CN</th>
                                            <th colspan="4" style="text-align: center;">
                                                <input class="form-control" type="text"
                                                    placeholder="Input Alat Angkut"
                                                    style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);">
                                            </th>
                                            <th class="text-center">Σ</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle;">
                                                Material
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Nama Operator</th>
                                            <th colspan="5" style="text-align: center;">
                                                <input class="form-control" type="text"
                                                    style="text-align: center; background-color: #eee7e8; color: rgb(11, 10, 10);"
                                                    placeholder="Input Nama Operator">
                                            </th>
                                            <th class="text-center">RIT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $id = 1;
                                        @endphp
                                        @foreach ($dataDS as $data)
                                            <tr class="shift-row DS" style="display: none;" id="row{{ $id }}">
                                                <td>{{ $data }}</td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <td><input type="time" class="time-input form-control"
                                                            oninput="countFilled({{ $id }})"
                                                            name="time[{{ $id }}][{{ $i }}]">
                                                    </td>
                                                @endfor
                                                <td><input type="text" class="form-control text-center"
                                                        id="filledCount{{ $id }}" readonly></td>
                                                <td>
                                                    <textarea class="form-control" name="material{{ $id }}" cols="5"></textarea>
                                                </td>
                                            </tr>
                                            @php
                                                $id++;
                                            @endphp
                                        @endforeach

                                        <!-- Baris data untuk NS -->
                                        @foreach ($dataNS as $data)
                                            <tr class="shift-row NS" style="display: none;" id="row{{ $id }}">
                                                <td>{{ $data }}</td>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <td><input type="time" class="time-input form-control"
                                                            oninput="countFilled({{ $id }})"
                                                            name="time[{{ $id }}][{{ $i }}]">
                                                    </td>
                                                @endfor
                                                <td><input type="text" class="form-control text-center"
                                                        id="filledCount{{ $id }}" readonly></td>
                                                <td>
                                                    <textarea class="form-control" name="material{{ $id }}" cols="5"></textarea>
                                                </td>
                                            </tr>
                                            @php
                                                $id++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <div class="input-group input-group-static mb-3">
                                            <label>Catatan</label>
                                            <textarea class="form-control" name="catatan" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-actions">
                                        <a href="" class="btn btn-secondary">Cancel</a>
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
    <style>
        .table> :not(caption)>*>* {
            padding: 0.5rem;

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

                axios.post('{{ route('prod.form.checker.store') }}', formData)
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

        function countFilled(row) {
            let filledCount = 0;


            const timeInputs = document.querySelectorAll(`#row${row} .time-input`);


            timeInputs.forEach(function(input) {
                if (input.value !== "") {
                    filledCount++;
                }
            });

            document.getElementById(`filledCount${row}`).value = filledCount;
        }

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

        document.getElementById('addNewAlatAngkut').addEventListener('click', function() {

            var mainTable = document.getElementById('mainTable');
            var newTable = mainTable.cloneNode(true);
            newTable.id = 'newTable' + Date.now();


            document.getElementById('tablesContainer').appendChild(newTable);


            var inputs = newTable.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });

            var textareas = newTable.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.value = '';
            });


            var removeButton = document.createElement('button');
            removeButton.innerText = 'Remove Table';
            removeButton.classList.add('removeButton', 'btn', 'btn-danger', 'mt-3');


            removeButton.addEventListener('click', function() {
                newTable.remove();
            });

            newTable.appendChild(removeButton);
        });
    </script>
@endsection
