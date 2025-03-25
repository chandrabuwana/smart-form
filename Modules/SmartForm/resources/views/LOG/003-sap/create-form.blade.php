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

                    <form id="form003Sap" method="POST" action="{{ route('store-003-sap') }}">
                        @csrf
                        <div class="mx-3">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="job_site" class="ms-0">PLANT</label>
                                        <select class="form-control" name="job_site" id="job_site" required>
                                            <option disabled selected>-- Select Site --</option>
                                            <option value="agm">agm</option>
                                            <option value="mbl">mbl</option>
                                            <option value="mme">mme</option>
                                            <option value="mas">mas</option>
                                            <option value="pmss">pmss</option>
                                            <option value="taj">taj</option>
                                            <option value="bssr">bssr</option>
                                            <option value="tdm">tdm</option>
                                            <option value="msj">msj</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">TANGGAL</label>
                                        <input type="date" class="form-control" id="date" name="date"
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
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-success btn-add">+</button>
                                                <button type="button" class="btn btn-danger btn-remove" style="display: none;">-</button>
                                            </td>
                                            <td>
                                                <input type="number" name="item_of_requisition_[]" id="item_of_requisition_[]" readonly>
                                            </td>
                                            <td>
                                                <input type="text" name="part_number_[]" id="part_number_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="material_code_[]" id="material_code_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="short_text_[]" id="short_text_[]">
                                            </td>
                                            <td>
                                                <input type="number" name="qty_requested_[]" id="qty_requested_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="uom_[]" id="uom_[]">
                                            </td>
                                            <td>
                                                <input type="date" name="delivery_date_[]" id="delivery_date_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="plant_[]" id="plant_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="storage_[]" id="storage_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="requisitioner_[]" id="requisitioner_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="req_tracking_number_[]" id="req_tracking_number_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="purchasing_group_[]" id="purchasing_group_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="valuation_price_[]" id="valuation_price_[]">
                                            </td>
                                            <td>
                                                <input type="date" name="release_date_[]" id="release_date_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="cost_center_[]" id="cost_center_[]">
                                            </td>
                                            <td>
                                                <input type="text" name="gl_account_[]" id="gl_account_[]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-5">
                                <div class="col-6 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Dibuat Oleh</label>
                                        <select name="checked" id="dibuat_oleh" class="form-control" required>
                                            <option disabled selected>-- Select Creator --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nama }}">{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Disetujui Oleh</label>
                                        <select name="validated" id="diperiksa" class="form-control" required>
                                            <option disabled selected>-- Select Approval --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nama }}">{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('dashboard-003-sap') }}"
                                                class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
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

                    if (index === 0) {
                        addBtn.style.display = "inline-block";
                        if (removeBtn) removeBtn.style.display = "none";
                    } else {
                        addBtn.style.display = "inline-block";
                        removeBtn.style.display = "inline-block";
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

            // Pastikan baris awal memiliki nomor 1 (atau penomoran dimulai dari 1)
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
    </script>
@endsection
