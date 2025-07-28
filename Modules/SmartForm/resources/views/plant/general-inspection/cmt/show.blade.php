@extends('master.master_page')

@section('custom-css')
    <style>
        .table tbody tr:last-child td {
            border-width: 0 1px
        }

        .ty {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .img-app {
            width: 100px;
            height: 40px;
            align-items: center;
        }


        .switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 18px;
            margin-top: 6px
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #d9534f;
            /* Warna merah (Broken) */
            transition: .2s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            bottom: -1.5px;
            background-color: white;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5);
            transition: .2s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #5cb85c;
            /* Warna hijau (Good) */
        }

        input:checked+.slider:before {
            transform: translateX(12px);
        }

        .switch-label {
            margin-left: 40px;
            font-weight: bold;
            color: #d9534f;
            transition: .4s;
        }

        input:checked+.slider+.switch-label {
            color: #5cb85c;
        }
    </style>

    <style>
        .radio-container {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            margin: auto
        }

        .radio-container input {
            display: none;
        }

        .radio-custom {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid gray;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease-in-out;
        }

        .radio-container input:checked+.radio-custom {
            border-color: #007bff;
            background-color: #007bff;
        }

        .radio-container input[value="cukup"]:checked+.radio-custom {
            border-color: #ffc107;
            background-color: #ffc107;
        }

        .radio-container input[value="kurang"]:checked+.radio-custom {
            border-color: #dc3545;
            background-color: #dc3545;
        }

        .input-remark {
            width: 100%;
            padding: 8px;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
            transition: border 0.2s ease-in-out;
        }

        .input-remark:focus {
            border-color: #007bff;
            outline: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h6 class="text-white text-capitalize my-auto">Approval General Inspection CMT</h6>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form>
                            @csrf
                            <div class="card-body border rounded">
                                <h5>Informasi Unit</h5>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="input-group input-group-static">
                                            <label>Site</label>
                                            {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site', strtolower($inspection['site'])) !!}
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>C/N</label>
                                            <input type="text" name="cn" class="form-control"
                                                value="{{ old('cn', $inspection['cn']) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>Model Unit</label>
                                            <input type="text" name="model_unit" class="form-control" disabled
                                                value="{{ old('model_unit', $inspection['model_unit']) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>HM</label>
                                            <input type="text" name="hm" class="form-control"
                                                value="{{ old('hm', $inspection['hm']) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="date" class="ms-0">Inspection Date</label>
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ old('date', $inspection['date_inspection']) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body border mt-4 rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Inspection Activity</h5>
                                    <button class="btn btn-light btn-sm" id="btn-inspection-act-accordion">Collapse
                                        all</button>
                                </div>
                                <div class="accordion mt-4" id="checklistAccordion">
                                    @foreach ($activityChecklistJson as $category => $items)
                                        <div class="card my-3">
                                            <a href="#" class="card-header p-0 position-relative z-index-2"
                                                data-bs-toggle="collapse" data-bs-target="#{{ 'category-' . $loop->index }}"
                                                aria-expanded="true" aria-controls="{{ 'category-' . $loop->index }}">
                                                <div
                                                    class="bg-light border-radius-md d-flex justify-content-between align-items-center p-2">
                                                    <h6 class="text-capitalize mb-0 text-sm">{{ $category }}</h6>
                                                    <i class="fa fa-circle-arrow-up fa-lg"></i>
                                                </div>
                                            </a>
                                            <div class="card-body pt-2 collapse show" id="{{ 'category-' . $loop->index }}">
                                                <div class="accordion-body table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Critical Point</th>
                                                                <th>Pre-Inspect</th>
                                                                <th>Final Inspect</th>
                                                                <th>Delivery Inspect</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($items as $item)
                                                                @php
                                                                    $preInspect =
                                                                        $inspection['activity'][$category][
                                                                            $item['activity']
                                                                        ]['pre_inspect'];
                                                                    $finalInspect =
                                                                        $inspection['activity'][$category][
                                                                            $item['activity']
                                                                        ]['final_inspect'];
                                                                    $deliveryInspect =
                                                                        $inspection['activity'][$category][
                                                                            $item['activity']
                                                                        ]['delivery_inspect'];
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $item['activity'] }}</td>
                                                                    <td>{{ $item['critical_point'] }}</td>
                                                                    <td>
                                                                        <div class="input-group input-group-static">
                                                                            <select disabled
                                                                                name="inspection[{{ $category }}][{{ $item['activity'] }}][pre_inspect]"
                                                                                class="form-control" role="button">
                                                                                <option value=""
                                                                                    {{ $preInspect == null ? 'selected' : null }}>
                                                                                    N/A</option>
                                                                                <option value="1"
                                                                                    {{ $preInspect == '1' ? 'selected' : null }}>
                                                                                    Good</option>
                                                                                <option value="0"
                                                                                    {{ $preInspect == '0' ? 'selected' : null }}>
                                                                                    Broken</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static">
                                                                            <select disabled
                                                                                name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                class="form-control" role="button">
                                                                                <option value=""
                                                                                    {{ $finalInspect == null ? 'selected' : null }}>
                                                                                    N/A</option>
                                                                                <option value="1"
                                                                                    {{ $finalInspect == '1' ? 'selected' : null }}>
                                                                                    Good</option>
                                                                                <option value="0"
                                                                                    {{ $finalInspect == '0' ? 'selected' : null }}>
                                                                                    Broken</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static">
                                                                            <select disabled
                                                                                name="inspection[{{ $category }}][{{ $item['activity'] }}][delivery_inspect]"
                                                                                class="form-control" role="button">
                                                                                <option value=""
                                                                                    {{ $deliveryInspect == null ? 'selected' : null }}>
                                                                                    N/A</option>
                                                                                <option value="1"
                                                                                    {{ $deliveryInspect == '1' ? 'selected' : null }}>
                                                                                    Good</option>
                                                                                <option value="0"
                                                                                    {{ $deliveryInspect == '0' ? 'selected' : null }}>
                                                                                    Broken</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-body border mt-4 rounded">
                                <h5>Analisa Hasil Inspeksi</h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card-body table-responsive shadow border-radius-lg"
                                            id="{{ 'analisa-hasil-inspeksi' }}">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th class="align-middle" rowspan="2">COMPONENT</th>
                                                        <th class="align-middle" colspan="3">PERFORMANCE
                                                        </th>
                                                        {{-- <th class="align-middle" rowspan="2">REMARK</th> --}}
                                                    </tr>
                                                    <tr>
                                                        <th>BAGUS</th>
                                                        <th>CUKUP</th>
                                                        <th>KURANG</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($inspectionResultJson as $category => $data)
                                                        <tr>
                                                            <td>{{ $category }}</td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio" disabled
                                                                        name="performance[{{ $category }}]"
                                                                        value="bagus"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'bagus' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio" disabled
                                                                        name="performance[{{ $category }}]"
                                                                        value="cukup"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'cukup' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio" disabled
                                                                        name="performance[{{ $category }}]"
                                                                        value="kurang"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'kurang' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="remark[{{ $category }}]"
                                                                    disabled
                                                                    value="{{ old("remark.$category", $inspection['remark'][$category] ?? '') }}"
                                                                    class="input-remark"
                                                                    placeholder="Masukkan remark (opsional)">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <label for="note">Note/Catatan</label>
                                        <textarea name="note" id="note" class="form-control" cols="12" rows="2" readonly>{{ $inspection['note'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Dilakukan Oleh 1</label>
                                        <select name="dilakukan1" id="dilakukan1" class="form-control" disabled required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Dilakukan Oleh 2</label>
                                        <select name="dilakukan2" id="dilakukan2" class="form-control" disabled>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa" id="diperiksa" class="form-control" disabled required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diketahui" class="ms-0">Diketahui Oleh</label>
                                        <select name="diketahui" id="diketahui" class="form-control" disabled required>

                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                @for ($i = 0; $i < 2; $i++)
                                    @if ($i == 0)
                                        @if ($status[$i] == 'Rejected')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/rejected.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($status[$i] == 'Approved')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/checked.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($status[$i] == 'Draft')
                                            <div class="col-6 ty">

                                            </div>
                                        @endif
                                    @else
                                        @if ($status[$i] == 'Rejected')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/rejected.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($status[$i] == 'Approved')
                                            <div class="col-6 ty">
                                                <img src="{{ asset('img/validated.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($status[$i] == 'Draft')
                                            <div class="col-6 ty">

                                            </div>
                                        @endif
                                    @endif
                                @endfor

                            </div>
                            @php
                                $statusJson = json_encode($status); // Konversi ke JSON string
                            @endphp
                            <div class="d-flex justify-content-end mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            @if ($nik == $inspection['diketahui'] || $nik == $inspection['diperiksa'])
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="approved('{{ $inspection['id'] }}', '{{ $statusJson }}', '{{ $nik }}')">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick="rejected('{{ $inspection['id'] }}', '{{ $statusJson }}', '{{ $nik }}')">
                                                    <i class="fas fa-close"></i> Reject
                                                </button>
                                            @endif

                                            @if (collect($status)->contains(fn($s) => $s === 'Rejected'))
                                                @if ($nik == $inspection['creator'])
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="resetApproval('{{ $inspection['id'] }}')">
                                                        <i class="fas fa-undo"></i> Reset
                                                    </button>
                                                @endif
                                            @endif

                                            <a href="{{ route('bss-form.plant.general-inspection.cmt.dashboard') }}"
                                                class="btn btn-secondary btn-sm" id="btn-back">
                                                Cancel</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(function() {
            function setupApprovalDropdown(selector, initialNik) {
                const selectElement = $(selector);

                selectElement.select2({
                    placeholder: '-- Pilih Pengguna --',
                    width: '100%',
                    ajax: {
                        url: '{{ route('cmt.approval.list') }}',
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
                                        // FIX: 'id' (value yang akan disubmit) diisi dengan NIK
                                        id: item.nik,
                                        text: item.nama + ' (' + item.nik + ')'
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                });

                // Jika ada NIK awal dari database, tampilkan sebagai nilai terpilih
                if (initialNik) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('cmt.approval.list') }}',
                        dataType: 'json',
                    }).then(function(data) {
                        // FIX: Mencari data berdasarkan NIK, bukan nama
                        const matched = data.find(item => item.nik === initialNik);
                        if (matched) {
                            // FIX: Buat <option> baru dengan NIK sebagai value
                            const option = new Option(matched.nama + ' (' + matched.nik + ')', matched.nik, true, true);
                            selectElement.append(option).trigger('change');
                        }
                    });
                }
            }

            // Panggil fungsi untuk setiap dropdown approval
            setupApprovalDropdown('#dilakukan1', "{{ $inspection['dilakukan1'] ?? '' }}");
            setupApprovalDropdown('#dilakukan2', "{{ $inspection['dilakukan2'] ?? '' }}");
            setupApprovalDropdown('#diperiksa', "{{ $inspection['diperiksa'] ?? '' }}");
            setupApprovalDropdown('#diketahui', "{{ $inspection['diketahui'] ?? '' }}");
        })

    </script>
    <script>
        $(document).ready(function() {

            $('#site').select2();
        });
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-switch").forEach(function(toggle) {
                toggle.addEventListener("change", function() {
                    let label = this.closest("label").querySelector(
                        ".switch-label"); // Correct way to get label
                    if (this.checked) {
                        label.textContent = "Good";
                        label.classList.remove("text-danger");
                        label.classList.add("text-success");
                    } else {
                        label.textContent = "Broken";
                        label.classList.remove("text-success");
                        label.classList.add("text-danger");
                    }
                });
            });
        });

        function rejected(id, status, nik) {
            let date3 = nik == "{{ $inspection['diketahui'] }}";
            let date2 = nik == "{{ $inspection['diperiksa'] }}";
            axios.post('{{ route('bss-form.plant.general-inspection.cmt.reject') }}', {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    date2: date2,
                    date3: date3,
                    datesign2: "{{ $inspection['date_sign2'] }}",
                    datesign3: "{{ $inspection['date_sign3'] }}",
                    diketahui: nik == "{{ $inspection['diketahui'] }}" ? 'Rejected' : "{{ $status[1] }}",
                    diperiksa: nik == "{{ $inspection['diperiksa'] }}" ? 'Rejected' : "{{ $status[0] }}",
                })
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
                .catch(error => {
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
                });
        }

        function approved(id, status, nik) {
            let date3 = nik == "{{ $inspection['diketahui'] }}";
            let date2 = nik == "{{ $inspection['diperiksa'] }}";

            axios.post('{{ route('bss-form.plant.general-inspection.cmt.approve') }}', {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    date2: date2,
                    date3: date3,
                    datesign2: "{{ $inspection['date_sign2'] }}",
                    datesign3: "{{ $inspection['date_sign3'] }}",
                    diketahui: nik == "{{ $inspection['diketahui'] }}" ? 'Approved' : "{{ $status[1] }}",
                    diperiksa: nik == "{{ $inspection['diperiksa'] }}" ? 'Approved' : "{{ $status[0] }}",
                })
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
                .catch(error => {
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
                });
        }

        function resetApproval(id) {
            if (confirm('Are you sure you want to reset this Approval?')) {
                axios.post('{{ route('bss-form.plant.general-inspection.cmt.reset', ['id' => 'ID']) }}'.replace('ID', id))
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


        $('#btn-inspection-act-accordion').on('click', function(e) {
            e.preventDefault();
            let btnText = $(this).text();
            if (btnText === 'Expand all') {
                $(this).text('Collapse all');
                $('#checklistAccordion .card-body').collapse('show');
            } else {
                $(this).text('Expand all');
                $('#checklistAccordion .card-body').collapse('hide');
            }
        });
    </script>
@endsection
