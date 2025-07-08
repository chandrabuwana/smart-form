@extends('master.master_page')

@section('custom-css')
    <style>
        .table tbody tr:last-child td {
            border-width: 0 1px
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 25px;
            height: 13px;
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
            height: 15px;
            width: 15px;
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
            color: #1e1e1e;
            transitrgb(48, 48, 48)s;
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
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">General Inspection Dongfeng</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form method="POST" id="formData">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group input-group-static">
                                        <label>Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('site') !!}
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mt-4">
                                    <div class="input-group input-group-static">
                                        <label>C/N</label>
                                        <select name="cn" class="form-control" id="cn">
                                            <option value="" disabled selected>-- Select Unit C/N --</option>
                                            @foreach ($cn as $cn_unit)
                                                <option value="{{ $cn_unit->no_lambung }}">
                                                    {{ $cn_unit->no_lambung }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mt-4">
                                    <div class="input-group input-group-static">
                                        <label>Model Unit</label>
                                        <input type="text" name="model_unit" id="model_unit" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3 mt-4">
                                    <div class="input-group input-group-static">
                                        <label>HM</label>
                                        <input type="text" name="hm" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mt-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">Inspection Date</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
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
                                                            @foreach ($items as $index => $item)
                                                                <tr>
                                                                    <td>{{ $item['activity'] }}</td>
                                                                    <td>{{ $item['critical_point'] }}</td>
                                                                    @if ($item['activity'] == 'Check Clutch Limit')
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <input type="text"
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][pre_inspect]"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan hasil">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <input type="text" readonly
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan hasil"
                                                                                    value="">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">

                                                                                <input type="text" readonly
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][delivery_inspect]"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan hasil"
                                                                                    value="">
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <select
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][pre_inspect]"
                                                                                    class="form-control" role="button">
                                                                                    <option value="">N/A</option>
                                                                                    <option value="1">Good</option>
                                                                                    <option value="0">Broken</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <select disabled class="form-control"
                                                                                    role="button">
                                                                                    <option value="">N/A</option>
                                                                                    <option value="1">Good</option>
                                                                                    <option value="0">Broken</option>
                                                                                </select>
                                                                                <input type="hidden"
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][final_inspect]"
                                                                                    value="">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="input-group input-group-static">
                                                                                <select disabled class="form-control"
                                                                                    role="button">
                                                                                    <option value="">N/A</option>
                                                                                    <option value="1">Good</option>
                                                                                    <option value="0">Broken</option>
                                                                                </select>
                                                                                <input type="hidden"
                                                                                    name="inspection[{{ $category }}][{{ $item['activity'] }}][delivery_inspect]"
                                                                                    value="">
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
                                                                        value="bagus">
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio"
                                                                        name="performance[{{ $category }}]"
                                                                        value="cukup">
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <label class="radio-container">
                                                                    <input type="radio"
                                                                        name="performance[{{ $category }}]"
                                                                        value="kurang">
                                                                    <div class="radio-custom"></div>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="remark[{{ $category }}]"
                                                                    value="{{ old('remark.' . $category) }}"
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
                                        <textarea name="note" id="note" class="form-control" cols="12" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dilakukan1" class="ms-0">Dilakukan Oleh 1</label>
                                        <input type="text" name="dilakukan1" readonly class="form-control"
                                            value="{{ session('username') }}">

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dilakukan2" class="ms-0">Dilakukan Oleh</label>
                                        <select name="dilakukan2" id="dilakukan2" class="form-control" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Diperiksa Oleh</label>
                                        <select name="diperiksa" id="diperiksa" class="form-control" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diketahui" class="ms-0">Diketahui Oleh</label>
                                        <select name="diketahui" id="diketahui" class="form-control" required>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mt-3">Draft</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('#dilakukan2').select2({
                placeholder: '-- Pilih--',
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
                                    id: item
                                        .nama,
                                    text: item.nama + ' (' + item.nik + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    <script>
        $(function() {
            $('#diperiksa').select2({
                placeholder: '-- Pilih --',
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
                                    id: item
                                        .nama,
                                    text: item.nama + ' (' + item.nik + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
    <script>
        $(function() {
            $('#diketahui').select2({
                placeholder: '-- Pilih --',
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
                                    id: item
                                        .nama,
                                    text: item.nama + ' (' + item.nik + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
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
                        ".switch-label");
                    if (this.checked) {
                        label.textContent = "Good";
                    } else {
                        label.textContent = "Broken";
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
                        "{{ route('bss-form.plant.general-inspection.dongfeng.store') }}",
                        formData
                    )

                    await Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Form General Inspection Dongfeng berhasil disimpan',
                    })

                    window.location.href =
                        "{{ route('bss-form.plant.general-inspection.dongfeng.index') }}";

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
