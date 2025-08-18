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
                            <h6 class="text-white text-capitalize ps-3"> Form PENGAJUAN PR 003 SAP</h6>
                        </div>
                    </div>

                    <form id="form003Sap" method="POST">
                        @csrf
                        <div class="mx-3">
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="job_site" class="ms-0">Job Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('job_site', $data->plant ?? null, false, true, 'job_site', 'form-control') !!}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">TANGGAL</label>
                                        <input type="date" disabled class="form-control" id="date" name="date" value="{{ $data->tanggal }}"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead class="bg-success text-white">
                                        <tr>
                                            <th>Action</th>
                                            <th>Item of requisition</th>
                                            <th>Partnumber</th>
                                            <th>Material Code</th>
                                            <th>Short Text</th>
                                            <th>Quantity requested</th>
                                            <th>Unit of Measure</th>
                                            <th>Delivery Date</th>
                                            <th>Plant</th>
                                            <th>Storage</th>
                                            <th>Requisitioner</th>
                                            <th>Req. Tracking Number</th>
                                            <th>Purchasing Group</th>
                                            <th>Valuation Price</th>
                                            <th>Release Date</th>
                                            <th>Cost Center</th>
                                            <th>GL ACCOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($detail && count($detail) > 0)
                                            @foreach ($detail as $item)
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-add">+</button>
                                                        <button type="button" class="btn btn-danger btn-remove">-</button>
                                                    </td>
                                                    <td><input disabled type="number" name="item_of_requisition_[]" value="{{ $item->item_of_requisition }}" readonly></td>
                                                    <td><input disabled type="text" name="part_number_[]" value="{{ $item->part_number }}"></td>
                                                    <td><input disabled type="text" name="material_code_[]" value="{{ $item->material_code }}"></td>
                                                    <td><input disabled type="text" name="short_text_[]" value="{{ $item->short_text }}"></td>
                                                    <td><input disabled type="number" name="qty_requested_[]" value="{{ $item->qty_requested }}"></td>
                                                    <td><input disabled type="text" name="uom_[]" value="{{ $item->uom }}"></td>
                                                    <td><input disabled type="date" name="delivery_date_[]" value="{{ $item->delivery_date }}"></td>
                                                    <td><input disabled type="text" name="plant_[]" value="{{ $item->plant }}"></td>
                                                    <td><input disabled type="text" name="storage_[]" value="{{ $item->storage }}"></td>
                                                    <td><input disabled type="text" name="requisitioner_[]" value="{{ $item->requisitioner }}"></td>
                                                    <td><input disabled type="text" name="req_tracking_number_[]" value="{{ $item->req_tracking_number }}"></td>
                                                    <td><input disabled type="text" name="purchasing_group_[]" value="{{ $item->purchasing_group }}"></td>
                                                    <td><input disabled type="text" name="valuation_price_[]" value="{{ $item->valuation_price }}"></td>
                                                    <td><input disabled type="date" name="release_date_[]" value="{{ $item->release_date }}"></td>
                                                    <td><input disabled type="text" name="cost_center_[]" value="{{ $item->cost_center }}"></td>
                                                    <td><input disabled type="text" name="gl_account_[]" value="{{ $item->gl_account }}"></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <button disabled type="button" class="btn btn-success btn-add">+</button>
                                                    <button disabled type="button" class="btn btn-danger btn-remove" style="display: none;">-</button>
                                                </td>
                                                <td><input disabled type="number" name="item_of_requisition_[]" readonly value="1"></td>
                                                <td><input disabled type="text" name="part_number_[]"></td>
                                                <td><input disabled type="text" name="material_code_[]"></td>
                                                <td><input disabled type="text" name="short_text_[]"></td>
                                                <td><input disabled type="number" name="qty_requested_[]"></td>
                                                <td><input disabled type="text" name="uom_[]"></td>
                                                <td><input disabled type="date" name="delivery_date_[]"></td>
                                                <td><input disabled type="text" name="plant_[]"></td>
                                                <td><input disabled type="text" name="storage_[]"></td>
                                                <td><input disabled type="text" name="requisitioner_[]"></td>
                                                <td><input disabled type="text" name="req_tracking_number_[]"></td>
                                                <td><input disabled type="text" name="purchasing_group_[]"></td>
                                                <td><input disabled type="text" name="valuation_price_[]"></td>
                                                <td><input disabled type="date" name="release_date_[]"></td>
                                                <td><input disabled type="text" name="cost_center_[]"></td>
                                                <td><input disabled type="text" name="gl_account_[]"></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-actions">
                                        @if ($nik == $data->dibuat_oleh || $nik == $data->checked_by)
                                            <button class="btn btn-primary btn-sm" id="btn900Approve"
                                                data-doc="{{ $data->doc_num }}"
                                                data-status='@json($data->status)'
                                                data-nik="{{ $nik }}">
                                                <i class="fas fa-check"></i> Approve
                                            </button>

                                            <button class="btn btn-warning btn-sm" id="btn900Reject"
                                                data-doc="{{ $data->doc_num }}"
                                                data-status='@json($data->status)'
                                                data-nik="{{ $nik }}">
                                                <i class="fas fa-close"></i> Reject
                                            </button>
                                        @endif

                                        @if (collect($data->status)->contains(fn($s) => $s === 'rejected'))
                                            @if ($nik == $data->creator)
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="resetApproval('{{ $data->doc_num }}')">
                                                    <i class="fas fa-undo"></i> Reset
                                                </button>
                                            @endif
                                        @endif

                                        <a href="{{ route('dashboard-003-sap') }}"
                                            class="btn btn-secondary btn-sm">Cancel</a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </form>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .accordion {
            width: 100%;

            margin: auto;
        }

        .accordion-item {
            border: 1px solid #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion-header {
            background: #E91E63;
            color: white;
            padding: 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border: none;
            text-align: left;
            width: 100%;
            outline: none;
        }

        .accordion-content {
            display: none;
            padding: 15px;
            background: #f1f1f1;
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
    <script>
        $(document).ready(function() {
            $('#job_site').select2({
                disabled: true
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const tableBody = document.querySelector("tbody");

            function getNextItemNumber() {
                const rows = tableBody.querySelectorAll('tr');
                let lastNumber = 0;
                rows.forEach(row => {
                    const itemInput = row.querySelector('input[name="item_of_requisition_[]"]');
                    if (itemInput && parseInt(itemInput.value)) {
                        lastNumber = Math.max(lastNumber, parseInt(itemInput.value));
                    }
                });
                return lastNumber + 1;
            }

            function addRow() {
                const newRow = document.createElement("tr");
                const nextItemNumber = getNextItemNumber();
                newRow.innerHTML = `
                    <td>
                        <button type="button" class="btn btn-success btn-add">+</button>
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </td>
                    <td><input type="number" name="item_of_requisition_[]" readonly value="${nextItemNumber}"></td>
                    <td><input type="text" name="part_number_[]"></td>
                    <td><input type="text" name="material_code_[]"></td>
                    <td><input type="text" name="short_text_[]"></td>
                    <td><input type="number" name="qty_requested_[]"></td>
                    <td><input type="text" name="uom_[]"></td>
                    <td><input type="date" name="delivery_date_[]"></td>
                    <td><input type="text" name="plant_[]"></td>
                    <td><input type="text" name="storage_[]"></td>
                    <td><input type="text" name="requisitioner_[]"></td>
                    <td><input type="text" name="req_tracking_number_[]"></td>
                    <td><input type="text" name="purchasing_group_[]"></td>
                    <td><input type="text" name="valuation_price_[]"></td>
                    <td><input type="date" name="release_date_[]"></td>
                    <td><input type="text" name="cost_center_[]"></td>
                    <td><input type="text" name="gl_account_[]"></td>
                `;
                tableBody.appendChild(newRow);
                updateButtons();
            }

            function updateButtons() {
                const rows = tableBody.querySelectorAll("tr");
                rows.forEach((row, index) => {
                    const addBtn = row.querySelector(".btn-add");
                    const removeBtn = row.querySelector(".btn-remove");

                    if (index <= rows.length - 1) {
                        addBtn.disabled = true;
                        if (removeBtn) removeBtn.disabled = true;
                    }
                });
            }

            tableBody.addEventListener("click", function (event) {
                if (event.target.classList.contains("btn-add")) {
                    addRow();
                } else if (event.target.classList.contains("btn-remove")) {
                    event.target.closest("tr").remove();
                    updateButtons();
                }
            });

            const initialRow = tableBody.querySelector('tr');
            if (initialRow) {
                const itemInput = initialRow.querySelector('input[name="item_of_requisition_[]"]');
                if (itemInput) {
                    itemInput.value = 1;
                }
            } else {
                const firstRow = document.createElement("tr");
                firstRow.innerHTML = `
                    <td>
                        <button type="button" class="btn btn-success btn-add">+</button>
                        <button type="button" class="btn btn-danger btn-remove" style="display: none;">-</button>
                    </td>
                    <td><input type="number" name="item_of_requisition_[]" readonly value="1"></td>
                    <td><input type="text" name="part_number_[]"></td>
                    <td><input type="text" name="material_code_[]"></td>
                    <td><input type="text" name="short_text_[]"></td>
                    <td><input type="number" name="qty_requested_[]"></td>
                    <td><input type="text" name="uom_[]"></td>
                    <td><input type="date" name="delivery_date_[]"></td>
                    <td><input type="text" name="plant_[]"></td>
                    <td><input type="text" name="storage_[]"></td>
                    <td><input type="text" name="requisitioner_[]"></td>
                    <td><input type="text" name="req_tracking_number_[]"></td>
                    <td><input type="text" name="purchasing_group_[]"></td>
                    <td><input type="text" name="valuation_price_[]"></td>
                    <td><input type="date" name="release_date_[]"></td>
                    <td><input type="text" name="cost_center_[]"></td>
                    <td><input type="text" name="gl_account_[]"></td>
                `;
                tableBody.appendChild(firstRow);
            }

            updateButtons();
        });

        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById("btn900Approve").addEventListener("click", function() {
                let docNumber = this.getAttribute("data-doc");
                let status = JSON.parse(this.getAttribute('data-status'));
                let nik = this.getAttribute("data-nik");

                fetch("{{ route('003-sap-approve') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        doc_num: docNumber,
                        dibuat_oleh: nik == "{{ $data->dibuat_oleh }}" ? 'approved' : status[0],
                        checked_by: nik == "{{ $data->checked_by }}" ? 'approved' : status[1],
                        nik: nik,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('dashboard-003-sap') }}";
                    } else {
                        alert('Gagal Approve data.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
            });


            document.getElementById('btn900Reject').addEventListener('click', function() {
                const docNum = this.getAttribute('data-doc');
                const nik = this.getAttribute('data-nik');
                const status = JSON.parse(this.getAttribute('data-status'));

                fetch('{{ route('003-sap-reject') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        doc_num: docNum,
                        dibuat_oleh: 'rejected',
                        checked_by: status,
                        nik: nik
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = "{{ route('dashboard-003-sap') }}";
                    } else {
                        alert('Gagal Reject data.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan.');
                });
            });

        });

        function resetApproval(id) {
        if (confirm('Are you sure you want to reset this Approval?')) {
            axios.post('{{ route('003-sap-reset', ['id' => 'ID']) }}'.replace('ID', id))
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

    $(function() {
        $('#dibuat_oleh, #diperiksa').select2({
            placeholder: '-- Pilih --',
            width: '100%',
            ajax: {
                url: '{{ route('003-sap.approval.list') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.nama,
                                text: item.nama + ' (' + item.nik + ')',
                                nik: item.nik
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
