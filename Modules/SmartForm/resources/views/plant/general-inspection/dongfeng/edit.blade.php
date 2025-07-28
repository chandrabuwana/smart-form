@extends('master.master_page')

@section('custom-css')
    <style>
        .table tbody tr:last-child td {
            border-width: 0 1px
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
                            <h6 class="text-white text-capitalize my-auto">Edit General Inspection Dongfeng</h6>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form method="POST" id="formData"
                            action="{{ route('bss-form.plant.general-inspection.dongfeng.update', $inspection['id']) }}">
                            @csrf
                            @method('PUT')

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
                                            <select name="cn" class="form-control uppercase " id="cn">
                                                <option value="" disabled selected>-- Select Unit C/N --</option>
                                                @foreach ($cn as $cn_unit)
                                                    <option value="{{ $cn_unit->no_lambung }}"
                                                        {{ old('cn', $inspection['cn'] ?? '') == $cn_unit->no_lambung ? 'selected' : '' }}>
                                                        {{ $cn_unit->no_lambung }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>Model Unit</label>
                                            <input type="text" name="model_unit" id="model_unit" class="form-control"
                                                value="{{ old('model_unit', $inspection['model_unit']) }}">
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>HM</label>
                                            <input type="text" name="hm" class="form-control"
                                                value="{{ old('hm', $inspection['hm']) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3 mt-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="date" class="ms-0">Inspection Date</label>
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ old('date', $inspection['date_inspection']) }}" required>
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
                                            <div class="card-body pt-2 collapse show"
                                                id="{{ 'category-' . $loop->index }}">
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
                                                                    @if ($item['activity'] == 'Check Clutch Limit')
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <input type="text"
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][pre_inspect]"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan hasil"
                                                                                    value="{{ $preInspect }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <input type="text"
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan hasil"
                                                                                    value="{{ $finalInspect }}">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">

                                                                                <input type="text"
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][delivery_inspect]"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan hasil"
                                                                                    value="{{ $deliveryInspect }}">
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <select
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
                                                                            @if ($finalInspect == null)
                                                                                <input type="hidden" name="status_form"
                                                                                    value="Final Inspeksi">
                                                                                @if ($preInspect == '0')
                                                                                    <div
                                                                                        class="input-group input-group-static">
                                                                                        <select
                                                                                            name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                            class="form-control"
                                                                                            role="button">
                                                                                            <option value=""
                                                                                                {{ $preInspect == null ? 'selected' : '' }}>
                                                                                                N/A</option>
                                                                                            <option value="1"
                                                                                                {{ $preInspect == '1' ? 'selected' : '' }}>
                                                                                                Good</option>
                                                                                            <option value="0"
                                                                                                {{ $preInspect == '0' ? 'selected' : '' }}>
                                                                                                Broken</option>
                                                                                        </select>


                                                                                    </div>
                                                                                @else
                                                                                    <div
                                                                                        class="input-group input-group-static">
                                                                                        <select class="form-control"
                                                                                            role="button" disabled>
                                                                                            <option value=""
                                                                                                {{ $preInspect == null ? 'selected' : '' }}>
                                                                                                N/A</option>
                                                                                            <option value="1"
                                                                                                {{ $preInspect == '1' ? 'selected' : '' }}>
                                                                                                Good</option>
                                                                                            <option value="0"
                                                                                                {{ $preInspect == '0' ? 'selected' : '' }}>
                                                                                                Broken</option>
                                                                                        </select>

                                                                                        <input type="hidden"
                                                                                            name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                            value="{{ $preInspect }}">
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <input type="hidden" name="status_form"
                                                                                    value="Delivery inspeksi">
                                                                                @if ($finalInspect == '0')
                                                                                    <div
                                                                                        class="input-group input-group-static">
                                                                                        <select
                                                                                            name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                            class="form-control"
                                                                                            role="button">
                                                                                            <option value=""
                                                                                                {{ $finalInspect == null ? 'selected' : '' }}>
                                                                                                N/A</option>
                                                                                            <option value="1"
                                                                                                {{ $finalInspect == '1' ? 'selected' : '' }}>
                                                                                                Good</option>
                                                                                            <option value="0"
                                                                                                {{ $finalInspect == '0' ? 'selected' : '' }}>
                                                                                                Broken</option>
                                                                                        </select>

                                                                                    </div>
                                                                                @else
                                                                                    <div
                                                                                        class="input-group input-group-static">
                                                                                        <select class="form-control"
                                                                                            role="button" disabled>
                                                                                            <option value=""
                                                                                                {{ $finalInspect == null ? 'selected' : '' }}>
                                                                                                N/A</option>
                                                                                            <option value="1"
                                                                                                {{ $finalInspect == '1' ? 'selected' : '' }}>
                                                                                                Good</option>
                                                                                            <option value="0"
                                                                                                {{ $finalInspect == '0' ? 'selected' : '' }}>
                                                                                                Broken</option>
                                                                                        </select>

                                                                                        <input type="hidden"
                                                                                            name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                            value="{{ $finalInspect }}">
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <select
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
                                                                    @endif
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
                                                                    <input type="radio"
                                                                        name="performance[{{ $category }}]"
                                                                        value="bagus"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'bagus' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio"
                                                                        name="performance[{{ $category }}]"
                                                                        value="cukup"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'cukup' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio"
                                                                        name="performance[{{ $category }}]"
                                                                        value="kurang"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'kurang' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="remark[{{ $category }}]"
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
                                        <textarea name="note" id="note" class="form-control" cols="12" rows="2">{{ $inspection['note'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="dibuat" class="ms-0">Dilakukan Oleh 1</label>

                                    <select name="dilakukan1_display" class="form-control uppercase" disabled>
                                        @foreach ($approvalList as $user)
                                            <option value="{{ $user->nik }}" {{ old('dilakukan1', $inspection['dilakukan1'] ?? '') == $user->nik ? 'selected' : '' }}>
                                                {{ $user->nama }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="hidden" name="dilakukan1" value="{{ old('dilakukan1', $inspection['dilakukan1'] ?? '') }}">
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dilakukan2" class="ms-0">Dilakukan Oleh 2</label>
                                        <select name="dilakukan2" id="dilakukan2" class="form-control select2" required>
                                            <option value="" disabled selected>-- Pilih Pengguna --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}" {{ old('dilakukan2', $inspection['dilakukan2'] ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa" id="diperiksa" class="form-control select2" required>
                                            <option value="" disabled selected>-- Pilih Pengguna --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}" {{ old('diperiksa', $inspection['diperiksa'] ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diketahui" class="ms-0">Diketahui Oleh</label>
                                        <select name="diketahui" id="diketahui" class="form-control select2" required>
                                            <option value="" disabled selected>-- Pilih Pengguna --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}" {{ old('diketahui', $inspection['diketahui'] ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if ($finalInspect == null)
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary mt-3">draft</button>
                                </div>
                            @else
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            function setupApprovalDropdown(selector, initialNik) {
                const selectElement = $(selector);

                selectElement.select2({
                    placeholder: '-- Pilih Pengguna --',
                    width: '100%',
                    ajax: {
                        url: '{{ route('bss-form.plant.general-inspection.dongfeng.approval.list') }}',
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
                        url: '{{ route('bss-form.plant.general-inspection.dongfeng.approval.list') }}',
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
            setupApprovalDropdown('#dilakukan2', "{{ $inspection['dilakukan2'] ?? '' }}");
            setupApprovalDropdown('#diperiksa', "{{ $inspection['diperiksa'] ?? '' }}");
            setupApprovalDropdown('#diketahui', "{{ $inspection['diketahui'] ?? '' }}");
        })


    </script>
    <script>
        $(document).ready(function() {

            $('#site').select2();
            $('#cn').select2();
        });
        $(document).ready(function() {

            const engineModelMap = {
                @foreach ($cn as $cn_unit)
                    "{{ $cn_unit->no_lambung }}": {
                        "unitModel": "{{ $cn_unit->model }}",
                    },
                @endforeach
            };

            $('#cn').change(function() {
                const selectedCn = $(this).val();
                if (engineModelMap[selectedCn]) {
                    const unitData = engineModelMap[selectedCn];
                    $('#model_unit').val(unitData.unitModel);
                } else {
                    $('#model_unit').val('');
                }
            });
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

        $(document).ready(function() {
            $('#formData').on('submit', async function(e) {
                e.preventDefault();
                try {
                    let formData = new FormData(this)

                    const response = await axios.post(
                        "{{ route('bss-form.plant.general-inspection.dongfeng.update', $inspection['id']) }}",
                        formData
                    );

                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Form General Inspection Dongfeng berhasil diubah!',
                    })

                    window.location.href =
                        `{{ route('bss-form.plant.general-inspection.dongfeng.index') }}`;

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Occured',
                        text: error.response.data.message,
                        confirmButtonText: 'OK'
                    });
                }

            });
        });
    </script>
@endsection
