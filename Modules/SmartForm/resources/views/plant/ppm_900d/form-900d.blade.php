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
                            <h6 class="text-white text-capitalize ps-3"> Form PPM XCMG 900D</h6>
                        </div>
                    </div>

                    <form id="formXCMG900" method="POST">
                        @csrf
                        <div class="mx-3">

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <select name="unit_cn" class="form-control" id="unit_cn" required>
                                            <option value="" disabled selected>-- Select Unit C/N --</option>
                                            @foreach ($cn as $cn_unit)
                                                <option value="{{ $cn_unit->no_lambung }}">
                                                    {{ $cn_unit->no_lambung }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_model" class="ms-0">Unit Model</label>
                                        <input type="text" class="form-control uppercase" id="unit_model" name="unit_model"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">Unit S/N</label>
                                        <input type="text" class="form-control uppercase" id="unit_sn" name="unit_sn"
                                            required>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control uppercase" id="engine_model"
                                            name="engine_model" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_sn" class="ms-0">Engine S/N</label>
                                        <input type="text" class="form-control uppercase" id="engine_sn" name="engine_sn"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="brand" class="ms-0">Brand</label>
                                        <input type="text" class="form-control uppercase" id="brand"
                                            style="text-transform: uppercase;" name="brand" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="job_site" class="ms-0">Job Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('job_site') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="location" class="ms-0">Location</label>
                                        <select class="form-control uppercase" name="location" id="location" required>
                                            <option disabled selected>-- Select Location --</option>
                                            <option value="Workshop">Workshop</option>
                                            <option value="Pitstop">Pitstop</option>
                                            <option value="Service Pad Area">Service Pad Area</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="at_inspec" class="ms-0">SMR / HM At Inspection</label>
                                        <input type="number" step="0.0001" class="form-control uppercase"
                                            id="at_inspec" name="at_inspec" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">SMR / HM Date</label>
                                        <input type="date" class="form-control uppercase" id="date"
                                            name="date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion">
                                <div class="accordion-item">
                                    <button type="button" class="accordion-header">ENGINE</button>
                                    <div class="accordion-content">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle;">
                                                            ITEM</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CONDITION</th>
                                                        <th style="vertical-align: middle;" rowspan="2">UNIT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            STANDARD STD/PMS</th>
                                                        <th style="vertical-align: middle;"rowspan="2">ACTUAL</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CORRECTION MADE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    @foreach ($list['ENGINE'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                @if ($value['item'] == 'Engine Speed')
                                                                    <td class="align-middle" rowspan="8">
                                                                        {!! $value['item'] !!}</td>
                                                                @elseif ($value['item'] == 'Lub Oil Pressure')
                                                                    <td class="align-middle" rowspan="2">
                                                                        {!! $value['item'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['item'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                <td class="align-middle">{!! $value['condition'] !!}
                                                                </td>
                                                            @endif
                                                            @if (isset($value['unit']))
                                                                @if ($value['unit'] == 'Rpm')
                                                                    <td class="align-middle" rowspan="8">
                                                                        {!! $value['unit'] !!}</td>
                                                                @elseif ($value['unit'] == 'Kg/cm2')
                                                                    <td class="align-middle" rowspan="2">
                                                                        {!! $value['unit'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['unit'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['standard']))
                                                                <td class="align-middle">{!! $value['standard'] !!}
                                                                </td>
                                                            @endif
                                                            <td><input type="number"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_actual[]" step="0.0001"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_correct[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_result[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_remarks[]"></td>
                                                        </tr>
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <button type="button" class="accordion-header">HYDRAULIC PRESSURE</button>
                                    <div class="accordion-content">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle;">
                                                            ITEM</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CONDITION</th>
                                                        <th style="vertical-align: middle;" rowspan="2">UNIT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            STANDARD STD/PMS</th>
                                                        <th style="vertical-align: middle;"rowspan="2">ACTUAL</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CORRECTION MADE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    @foreach ($list['HYDRAULIC'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                @if ($value['item'] == 'Engine Speed')
                                                                    <td class="align-middle" rowspan="8">
                                                                        {!! $value['item'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['item'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == '1800 rpm (10th gear)')
                                                                    <td class="align-middle" rowspan="8">
                                                                        {!! $value['condition'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['unit'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['unit']))
                                                                @if ($value['unit'] == 'kg/cm³')
                                                                    <td class="align-middle" rowspan="8">
                                                                        {!! $value['unit'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['unit'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['standard']))
                                                                <td class="align-middle">{!! $value['standard'] !!}
                                                                </td>
                                                            @endif
                                                            <td><input type="number"
                                                                    class="form-control text-center uppercase"
                                                                    name="hyd_actual[]" step="0.0001"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="hyd_correct[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="hyd_result[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="hyd_remarks[]"></td>
                                                        </tr>
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <button type="button" class="accordion-header">WORKING SPEED</button>
                                    <div class="accordion-content">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle;">
                                                            ITEM</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CONDITION</th>
                                                        <th style="vertical-align: middle;" rowspan="2">UNIT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            STANDARD STD/PMS</th>
                                                        <th style="vertical-align: middle;"rowspan="2">ACTUAL</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CORRECTION MADE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($list['WORKING SPEED'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                <td class="align-middle uppercase">{!! $value['item'] !!}
                                                                </td>
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == '1800 rpm (10th gear)')
                                                                    <td class="align-middle uppercase" rowspan="10">
                                                                        {!! $value['condition'] !!}</td>
                                                                @else
                                                                    <td class="align-middle uppercase">
                                                                        {!! $value['condition'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['unit']))
                                                                @if ($value['unit'] == 'Sec')
                                                                    <td class="align-middle uppercase" rowspan="10">
                                                                        {!! $value['unit'] !!}</td>
                                                                @else
                                                                    <td class="align-middle uppercase">
                                                                        {!! $value['unit'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['standard']))
                                                                @if ($value['standard'] == '28 ± 4 (3 round calculated after 1 round not calculated)')
                                                                    <td class="align-middle uppercase" rowspan="2">
                                                                        {!! $value['standard'] !!}</td>
                                                                @else
                                                                    <td class="align-middle uppercase">
                                                                        {!! $value['standard'] !!}</td>
                                                                @endif
                                                            @endif


                                                            <td><input type="number"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_actual[]" step="0.0001"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_correct[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_result[]"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_remarks[]"></td>
                                                        </tr>
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <button type="button" class="btn-primary accordion-header">FINAL
                                        DRIVE</button>
                                    <div class="accordion-content">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle;">
                                                            ITEM</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CONDITION</th>
                                                        <th style="vertical-align: middle;" rowspan="2">UNIT
                                                        </th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            STANDARD STD/PMS</th>
                                                        <th style="vertical-align: middle;"rowspan="2">ACTUAL</th>
                                                        <th style="vertical-align: middle;" rowspan="2">
                                                            CORRECTION MADE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>

                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    @php
                                                        $inc = 0;
                                                    @endphp
                                                    @foreach ($list['Final'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                <td class="align-middle uppercase">{!! $value['item'] !!}
                                                                </td>
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                                                                    <td class="align-middle uppercase" rowspan="2">
                                                                        {!! $value['condition'] !!}</td>
                                                                @else
                                                                    <td class="align-middle uppercase">
                                                                        {!! $value['condition'] !!}</td>
                                                                @endif
                                                            @endif
                                                            <td></td>
                                                            @if (isset($value['standard']))
                                                                <td class="align-middle uppercase">{!! $value['standard'] !!}
                                                                </td>
                                                            @else
                                                                <td></td>
                                                            @endif

                                                            @if ($value['item'] == 'Drain Plug')
                                                                <td
                                                                    style="width: 10%; text-align: center; vertical-align: middle;">
                                                                    <div style="display: inline-block; width: 100%;"
                                                                        class="form-control uppercase">
                                                                        <select name="final_actual{{ $inc }}"
                                                                            style="width: 100%;"
                                                                            class="form-control text-center uppercase">
                                                                            <option value="">--select--</option>
                                                                            <option value="A">A</option>
                                                                            <option value="B">B</option>
                                                                            <option value="C">C</option>
                                                                            <option value="X">X</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            @elseif ($value['item'] == 'Oil Leak')
                                                                <td
                                                                    style="width: 10%; text-align: center; vertical-align: middle;">
                                                                    <div style="display: inline-block; width: 100%;">
                                                                        <select name="final_actual{{ $inc }}"
                                                                            style="width: 100%;"
                                                                            class="form-control text-center uppercase">
                                                                            <option value="">--select--</option>
                                                                            <option value="Leak">Leak</option>
                                                                            <option value="No Leak">No Leak</option>

                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td><input type="text"
                                                                        class="form-control text-center uppercase"
                                                                        name="final_actual{{ $inc }}">
                                                                </td>
                                                            @endif
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="final_correct{{ $inc }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="final_result{{ $inc }}"></td>
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                                                                    <td rowspan="2"> <input type="text"
                                                                            class="form-control text-center uppercase"
                                                                            name="final_remarks[]">
                                                                    </td>
                                                                @else
                                                                    <td> <input type="text"
                                                                            class="form-control text-center uppercase"
                                                                            name="final_remarks[]"></td>
                                                                @endif
                                                            @endif

                                                        </tr>
                                                        @php
                                                            $inc++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="note" class="ms-0">Note/Catatan</label>
                                        <textarea name="note" id="note" class="form-control uppercase" cols="30" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By1</label>
                                        <select name="checked1_display" class="form-control uppercase" disabled>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}"
                                                    {{ old('checked1', $nik ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="checked1" value="{{ old('checked1', $nik ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By2</label>
                                        <select name="checked2" id="dibuat_oleh2" class="form-control uppercase"
                                            required>
                                            <option disabled selected>-- Select checker --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}">{{ $user->nama }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Validated By</label>
                                        <select name="validated" id="diperiksa" class="form-control uppercase" required>
                                            <option disabled selected>-- Select Approval --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}">{{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('plant.ppm.900d.dashboard') }}"
                                                class="btn btn-secondary">Cancel</a>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .uppercase {
            text-transform: uppercase;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }


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
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dibuat_oleh1').select2();
            $('#dibuat_oleh2').select2();
            $('#diperiksa').select2();
            $('#job_site').select2();
            $('#unit_cn').select2();
            $('#checked1_display').select2();
        });
        $(function() {
            var form = $("#formXCMG900");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);
                console.log("Form data yang dikirim:", formData);

                axios.post('{{ route('plant.ppm.900d.store') }}', formData)
                    .then(function(response) {
                        console.log("Respons dari server:", response.data);
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('plant.ppm.900d.dashboard') }}';
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



        $(document).ready(function() {

            const engineModelMap = {
                @foreach ($cn as $cn_unit)
                    "{{ $cn_unit->no_lambung }}": {
                        "engineModel": "{{ $cn_unit->model_engine }}",
                        "unitSn": "{{ $cn_unit->sn_unit }}",
                        "unitModel": "{{ $cn_unit->model }}",
                        "engineSn": "{{ $cn_unit->sn_engine }}"
                    },
                @endforeach
            };

            $('#unit_cn').change(function() {
                const selectedCn = $(this).val();
                if (engineModelMap[selectedCn]) {
                    const unitData = engineModelMap[selectedCn];
                    $('#engine_model').val(unitData.engineModel);
                    $('#unit_model').val(unitData.unitModel);
                    $('#unit_sn').val(unitData.unitSn);
                    $('#engine_sn').val(unitData.engineSn);
                } else {
                    $('#engine_model').val('');
                    $('#unit_model').val('');
                    $('#unit_sn').val('');
                    $('#engine_sn').val('');
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            const headers = document.querySelectorAll(".accordion-header");

            headers.forEach(header => {
                header.addEventListener("click", function() {
                    const content = this.nextElementSibling;


                    document.querySelectorAll(".accordion-content").forEach(item => {
                        if (item !== content) {
                            item.classList.remove("active");
                            item.style.display = "none";
                        }
                    });


                    if (content.classList.contains("active")) {
                        content.classList.remove("active");
                        content.style.display = "none";
                    } else {
                        content.classList.add("active");
                        content.style.display = "block";
                    }
                });
            });
        });
    </script>
@endsection
