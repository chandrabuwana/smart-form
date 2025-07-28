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



                    <div class="mx-3">


                        <div class="row mt-3 mb-2">
                            <div class="col-md-12 d-flex justify-content-end">

                                <div class="status me-2">
                                    <span class="box red"></span> Rejected
                                </div>
                                <div class="status me-2">
                                    <span class="box green"></span> Approved
                                </div>
                                <div class="status me-2">
                                    <span class="box blue"></span> Draft
                                </div>
                            </div>
                            <table class="top-table mt-3">
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
                                            <td>
                                                @php
                                                    $checkerName = $records->validator;
                                                    $status = is_string($records->status)
                                                        ? json_decode($records->status, true)
                                                        : $records->status;
                                                @endphp

                                                @if ($status[1] === 'rejected')
                                                    <span class="badge red">{{ $checkerName }}</span>
                                                @elseif ($status[1] === 'approved')
                                                    <span class="badge green">{{ $checkerName }}</span>
                                                @else
                                                    <span class="badge blue">{{ $checkerName }}</span>
                                                @endif
                                                @if ($nik == $records->validator)
                                                    <div class="mt-2 d-flex justify-content-center gap-2">
                                                        <button class="btn btn-success btn-sm btnOGCApprove"
                                                            data-doc="{{ $data->doc_num }}" data-week="{{ $records->week }}"
                                                            data-status="{{ $records->status }}"
                                                            data-cek='{{ $records->checker }}'
                                                            data-val='{{ $records->validator }}'
                                                            data-nik="{{ $nik }}">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>

                                                        <button class="btn btn-warning btn-sm btnOGCReject"
                                                            data-doc="{{ $data->doc_num }}"
                                                            data-week="{{ $records->week }}"
                                                            data-status="{{ $records->status }}"
                                                            data-cek='{{ $records->checker }}'
                                                            data-val='{{ $records->validator }}'
                                                            data-nik="{{ $nik }}">
                                                            <i class="fas fa-close"></i> Reject
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                @php
                                                    $checkerName = $records->checker;
                                                    $status = is_string($records->status)
                                                        ? json_decode($records->status, true)
                                                        : $records->status;
                                                @endphp



                                                @if ($status[0] === 'rejected')
                                                    <span class="badge red">{{ $checkerName }}</span>
                                                @elseif ($status[0] === 'approved')
                                                    <span class="badge green">{{ $checkerName }}</span>
                                                @else
                                                    <span class="badge blue">{{ $checkerName }}</span>
                                                @endif

                                                @if ($nik == $records->checker)
                                                    <div class="mt-2 d-flex justify-content-center gap-2">
                                                        @if ($status[0] === 'rejected')
                                                        @else
                                                            <button class="btn btn-success btn-sm btnOGCApprove"
                                                                data-doc="{{ $data->doc_num }}"data-week="{{ $records->week }}"
                                                                data-status="{{ $records->status }}"
                                                                data-cek='{{ $records->checker }}'
                                                                data-val='{{ $records->validator }}'
                                                                data-nik="{{ $nik }}">
                                                                <i class="fas fa-check"></i> Approve
                                                            </button>

                                                            <button class="btn btn-warning btn-sm btnOGCReject"
                                                                data-doc="{{ $data->doc_num }}"
                                                                data-week="{{ $records->week }}"
                                                                data-status="{{ $records->status }}"
                                                                data-cek='{{ $records->checker }}'
                                                                data-val='{{ $records->validator }}'
                                                                data-nik="{{ $nik }}">
                                                                <i class="fas fa-close"></i> Reject
                                                            </button>
                                                        @endif

                                                    </div>
                                                @endif
                                            </td>

                                            <td>
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


                        <div class="row">
                            <div class="col-12">
                                <div class="form-actions">
                                    <a href="{{ route('log.ogc.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="resetApproval('{{ $data->doc_num }}')">
                                        <i class="fas fa-undo"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>


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
            .status {
                display: flex;
                gap: 10px;
                align-items: center;
                font-family: Arial, sans-serif;
            }

            .box {
                width: 20px;
                height: 20px;
                display: inline-block;
                border-radius: 4px;
            }

            .red {
                background-color: #F44335;
            }

            .green {
                background-color: #4CAF50;
            }

            .blue {
                background-color: #0000FF;
            }

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

                $('#week').select2();
            });

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

            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".btnOGCApprove").forEach(button => {
                    button.addEventListener("click", function() {
                        let docNumber = this.getAttribute("data-doc");
                        let status = JSON.parse(this.getAttribute('data-status'));
                        let week = this.getAttribute("data-week");
                        let nik = this.getAttribute("data-nik");
                        let cek = this.getAttribute("data-cek");
                        let val = this.getAttribute("data-val");

                        axios.post("{{ route('log.ogc.approve') }}", {
                                _token: "{{ csrf_token() }}",
                                doc_num: docNumber,
                                week: week,
                                checked: nik == cek ? 'approved' : status[0],
                                validated: nik == val ? 'approved' : status[1],


                            })
                            .then(response => {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.data.message
                                    }).then((result) => {
                                        window.location.reload();
                                    });
                                }
                            })
                            .catch(error => {
                                let errorMessage = 'Terjadi kesalahan pada sistem';
                                console.log("Error respons:", error.response);

                                if (error.response) {
                                    if (error.response.data.errors) {
                                        errorMessage = Object.values(error.response.data.errors)
                                            .flat().join(
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
                            });
                    });
                });

                document.querySelectorAll(".btnOGCReject").forEach(button => {
                    button.addEventListener("click", function() {
                        let docNumber = this.getAttribute("data-doc");
                        let status = JSON.parse(this.getAttribute('data-status'));
                        let nik = this.getAttribute("data-nik");
                        let week = this.getAttribute("data-week");
                        let cek = this.getAttribute("data-cek");
                        let val = this.getAttribute("data-val");

                        axios.post("{{ route('log.ogc.reject') }}", {
                                _token: "{{ csrf_token() }}",
                                doc_num: docNumber,
                                week: week,
                                checked: nik == cek ? 'rejected' : status[0],
                                validated: nik == val ? 'rejected' : status[1],
                            })
                            .then(response => {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.data.message
                                    }).then((result) => {
                                        window.location.reload();
                                    });
                                }
                            })
                            .catch(error => {
                                let errorMessage = 'Terjadi kesalahan pada sistem';
                                console.log("Error respons:", error.response);

                                if (error.response) {
                                    if (error.response.data.errors) {
                                        errorMessage = Object.values(error.response.data.errors)
                                            .flat().join(
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
                            });
                    });
                });


            });

            function resetApproval(id) {
                if (confirm('Are you sure you want to reset this Approval?')) {
                    axios.post('{{ route('log.ogc.reset', ['id' => 'ID']) }}'.replace('ID', id))
                        .then(function(response) {
                            console.log('Response:', response);
                            if (response.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.data.message
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to reset the approval.'
                                });
                            }
                        })
                        .catch(function(error) {
                            console.error('Error:', error);
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
                        });
                }
            }
        </script>
    @endsection
