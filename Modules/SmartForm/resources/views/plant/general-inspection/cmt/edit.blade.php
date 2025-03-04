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
                            <h6 class="text-white text-capitalize my-auto">Edit General Inspection CMT</h6>
                            <button class="btn btn-light my-auto" id="btn-print"><i class="fa fa-print me-2"></i> Print</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form method="POST" id="formData"
                            action="{{ route('bss-form.plant.general-inspection.cmt.update', $inspection['id']) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body border rounded">
                                <h5>Informasi Unit</h5>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="input-group input-group-static">
                                            <label>Site</label>
                                            <select name="site" class="form-control">
                                                @foreach ($sites as $site)
                                                    <option value="{{ $site }}"
                                                        {{ $site == $inspection['site'] ? 'selected' : '' }}>{{ $site }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>Model Unit</label>
                                            <input type="text" name="model_unit" class="form-control"
                                                value="{{ old('model_unit', $inspection['model_unit']) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>C/N</label>
                                            <input type="text" name="cn" class="form-control"
                                                value="{{ old('cn', $inspection['cn']) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-4">
                                        <div class="input-group input-group-static">
                                            <label>HM</label>
                                            <input type="text" name="hm" class="form-control"
                                                value="{{ old('hm', $inspection['hm']) }}">
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
                                                <div class="accordion-body">
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
                                                                            <select
                                                                                name="inspection[{{ $category }}][{{ $item['activity'] }}][pre_inspect]"
                                                                                class="form-control" role="button">
                                                                                <option value=""
                                                                                    {{ $preInspect === null ? 'selected' : null }}>
                                                                                    N/A</option>
                                                                                <option value="1"
                                                                                    {{ $preInspect === 1 ? 'selected' : null }}>
                                                                                    Good</option>
                                                                                <option value="0"
                                                                                    {{ $preInspect === 0 ? 'selected' : null }}>
                                                                                    Broken</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static">
                                                                            <select
                                                                                name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                class="form-control" role="button">
                                                                                <option value=""
                                                                                    {{ $finalInspect === null ? 'selected' : null }}>
                                                                                    N/A</option>
                                                                                <option value="1"
                                                                                    {{ $finalInspect === 1 ? 'selected' : null }}>
                                                                                    Good</option>
                                                                                <option value="0"
                                                                                    {{ $finalInspect === 0 ? 'selected' : null }}>
                                                                                    Broken</option>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group input-group-static">
                                                                            <select
                                                                                name="inspection[{{ $category }}][{{ $item['activity'] }}][delivery_inspect]"
                                                                                class="form-control" role="button">
                                                                                <option value=""
                                                                                    {{ $deliveryInspect === null ? 'selected' : null }}>
                                                                                    N/A</option>
                                                                                <option value="1"
                                                                                    {{ $deliveryInspect === 1 ? 'selected' : null }}>
                                                                                    Good</option>
                                                                                <option value="0"
                                                                                    {{ $deliveryInspect === 0 ? 'selected' : null }}>
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
                                        <div class="card-body shadow border-radius-lg" id="{{ 'analisa-hasil-inspeksi' }}">
                                            <table class="table table-bordered">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th class="align-middle" rowspan="2">COMPONENT</th>
                                                        <th class="align-middle" colspan="3">PERFORMANCE
                                                        </th>
                                                        <th class="align-middle" rowspan="2">REMARK</th>
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
                                                                    <input type="radio" name="performance[{{ $category }}]"
                                                                        value="bagus"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'bagus' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio" name="performance[{{ $category }}]"
                                                                        value="cukup"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'cukup' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio" name="performance[{{ $category }}]"
                                                                        value="kurang"
                                                                        {{ old("performance.$category", $inspection['performance'][$category] ?? '') == 'kurang' ? 'checked' : '' }}>
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="remark[{{ $category }}]"
                                                                    value="{{ old("remark.$category", $inspection['remark'][$category] ?? '') }}"
                                                                    class="input-remark" placeholder="Masukkan remark (opsional)">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mt-3">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
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

        $('#btn-print').on('click', function(e) {
            window.open("{{ route('bss-form.plant.general-inspection.cmt.print', $inspection['id']) }}", "_blank");
        })

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
                        "{{ route('bss-form.plant.general-inspection.cmt.update', $inspection['id']) }}",
                        formData
                    );

                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Form General Inspection CMT berhasil diubah!',
                    })

                    window.location.href =
                    `{{ route('bss-form.plant.general-inspection.cmt.index') }}`;

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
