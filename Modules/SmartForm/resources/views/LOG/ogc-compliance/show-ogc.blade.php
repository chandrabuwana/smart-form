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

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3"> Form Checklist Lube Compliance</h6>
                        </div>
                    </div>

                    <form id="formOGC" method="POST">
                        @csrf

                        <input type="hidden" name="doc_num_id" value="{{ $data->doc_num }}">

                        <div class="mx-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="week" class="ms-0">Week</label>
                                        <select name="week" id="week" class="form-control" required>
                                            <option disabled selected>-- Select week --</option>
                                            <option value="week 1"> Week 1</option>
                                            <option value="week 2"> Week 2</option>
                                            <option value="week 3"> Week 3</option>
                                            <option value="week 4"> Week 4</option>
                                            <option value="week 5"> Week 5</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="validator" class="ms-0">Validator</label>
                                        <select name="validator" id="validator" class="form-control" required>
                                            <option disabled selected>-- Select validator --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}">{{ $user->nama }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="known" class="ms-0">Known By</label>
                                        <select name="known" id="known" class="form-control" required>
                                            <option disabled selected>-- Select Known By--</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}">{{ $user->nama }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 mb-2">
                                <table class="top-table">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Validator</th>
                                            <th>Known By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($detail as $records)
                                            <tr>
                                                <td>{{ $records->week }}</td>
                                                <td> {{ optional(collect($approvalList)->firstWhere('nik', $records->validator))->nama ?? '' }}
                                                </td>
                                                <td>{{ optional(collect($approvalList)->firstWhere('nik', $records->checker))->nama ?? '' }}
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm mt-3"
                                                        onclick="deleteweek('{{ $records->week }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <a class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal"
                                                        data-bs-target="#ogcModal" data-id="{{ $records->week }}"
                                                        data-doc-num="{{ $records->doc_num_id }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle;">No</th>
                                            <th style="vertical-align: middle;">
                                                Lube Station</th>
                                            <th style="vertical-align: middle;">
                                                Week</th>
                                            </th>
                                            <th style="vertical-align: middle;">
                                                Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($list['Lube Station'] as $value)
                                            <tr>
                                                <th>{{ $i }}</th>
                                                <td style=" text-align: left; font-size: 8px;">
                                                    {!! $value['question'] !!}</td>
                                                <td><input type="text" class="form-control" name="lube_station[]">
                                                </td>
                                                <td><input type="text" class="form-control" name="station_comment[]">
                                                </td>
                                            </tr>

                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle;">No</th>
                                            <th style="vertical-align: middle;">
                                                Lube Truck</th>
                                            <th style="vertical-align: middle;">
                                                Week</th>
                                            </th>
                                            <th style="vertical-align: middle;">
                                                Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($list['Lube Truck'] as $value)
                                            <tr>
                                                <th>{{ $i }}</th>
                                                <td style=" text-align: left; font-size: 8px;">
                                                    {!! $value['question'] !!}</td>
                                                <td><input type="text" class="form-control" name="lube_truck[]"></td>
                                                <td><input type="text" class="form-control" name="truck_comment[]">
                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach


                                    </tbody>
                                </table>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-actions">
                                        <a href="{{ route('log.ogc.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}

    <div class="modal fade" id="ogcModal" tabindex="-1" aria-labelledby="ogcModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ogcModalLabel">Detail OGC Compliance</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="16" height="16" fill="black" viewBox="0 0 16 16">
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </button>

                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .top-table {

            border-collapse: collapse;
            text-align: left;
        }

        .top-table th,
        .top-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }

        .top-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .top-table tbody tr:hover {
            background-color: #f1f1f1;
        }


        .active {
            display: block;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

        }

        th,
        td {
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
        }

        td[rowspan] {
            vertical-align: middle !important;
            text-align: center;

        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid black !important;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#validator').select2();
            $('#known').select2();
            $('#week').select2();
        });
        $(function() {
            var form = $("#formOGC");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);
                console.log("Form data yang dikirim:", formData);

                axios.post('{{ route('log.ogc.store') }}', formData)
                    .then(function(response) {
                        console.log("Respons dari server:", response.data);
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }


                            });
                        }
                    })
                    .catch(function(error) {
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        console.log("Error respons:", error.response);

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

        function deleteweek(id) {
            console.log('Delete ID:', id);
            if (confirm('Are you sure you want to delete this data?')) {
                axios.delete('{{ route('log.ogc.deleteWeek', ['id' => 'ID']) }}'.replace('ID', id))
                    .then(function(response) {
                        console.log('Response:', response);
                        if (response.data.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete the compressor.'
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        if (error.response) {

                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join('\n');
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
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            var modal = document.getElementById("ogcModal");

            modal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute("data-id");
                var docNum = button.getAttribute("data-doc-num");
                var modalBody = modal.querySelector(".modal-body");

                fetch(`/bss-form/ogc-compliance/modal/${id}/${docNum}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.list) {
                            let list = data.list;
                            let record = data.record || {};
                            let tableHTML = "";

                            if (list["Lube Station"] && list["Lube Station"].length > 0) {
                                tableHTML += `
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lube Station</th>
                                        <th>Week</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                list["Lube Station"].forEach((item, index) => {
                                    let lubeValue = record.lube_station?.[index] || "";
                                    let commentValue = record.station_comment?.[index] || "";
                                    tableHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td style="text-align: left; font-size: 8px;">${item.question}</td>
                                    <td>${lubeValue}</td>
                                    <td>${commentValue}</td>
                                </tr>`;
                                });

                                tableHTML += `</tbody></table></div>`;
                            }

                            if (list["Lube Truck"] && list["Lube Truck"].length > 0) {
                                tableHTML += `
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lube Truck</th>
                                        <th>Week</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                                list["Lube Truck"].forEach((item, index) => {
                                    let truckValue = record.lube_truck?.[index] || "";
                                    let truckComment = record.truck_comment?.[index] || "";
                                    tableHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td style="text-align: left; font-size: 8px;">${item.question}</td>
                                    <td>${truckValue}</td>
                                    <td>${truckComment}</td>
                                </tr>`;
                                });

                                tableHTML += `</tbody></table></div>`;
                            }

                            modalBody.innerHTML = tableHTML;
                        } else {
                            modalBody.innerHTML = "<p class='text-danger'>Data tidak ditemukan.</p>";
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                        modalBody.innerHTML = "<p class='text-danger'>Gagal mengambil data.</p>";
                    });
            });
        });
    </script>
@endsection
