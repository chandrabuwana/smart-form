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
                            <h6 class="text-white text-capitalize ps-3"> Form PPM XCMG GR3005T SERIES</h6>
                        </div>
                    </div>

                    <form id="formXCMG3005" method="POST">
                        @csrf
                        <div class="mx-3">
                            <input type="hidden" name="doc_num" value="{{ $data->doc_num }}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <select name="unit_cn" class="form-control uppercase " id="unit_cn" required>
                                            <option value="" disabled selected>-- Select Unit C/N --</option>
                                            @foreach ($cn as $cn_unit)
                                                <option value="{{ $cn_unit->no_lambung }}"
                                                    {{ old('unit_cn', $data->unit_cn ?? '') == $cn_unit->no_lambung ? 'selected' : '' }}>
                                                    {{ $cn_unit->no_lambung }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_model" class="ms-0">Unit Model</label>
                                        <input type="text" class="form-control uppercase " id="unit_model"
                                            name="unit_model" value="{{ $data->unit_model }}"required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">Unit S/N</label>
                                        <input type="text" class="form-control uppercase " id="unit_sn" name="unit_sn"
                                            value="{{ $data->unit_sn }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control uppercase " id="engine_model"
                                            name="engine_model" value="{{ $data->engine_model }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_sn" class="ms-0">Engine S/N</label>
                                        <input type="text" class="form-control uppercase " id="engine_sn"
                                            name="engine_sn" value="{{ $data->engine_sn }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="att_front" class="ms-0">Brand</label>
                                        <input type="text" class="form-control uppercase " id="brand" name="brand"
                                            value="{{ $data->brand }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="job_site" class="ms-0">Job Site</label>
                                        {!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('job_site', strtolower($data->job_site)) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">


                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="location" class="ms-0">Location</label>
                                        <select class="form-control uppercase " name="location" id="location" required>
                                            <option value="Workshop"
                                                {{ old('location', $data->job_location ?? '') == 'Workshop' ? 'selected' : '' }}>
                                                Workshop</option>
                                            <option value="Pitstop"
                                                {{ old('location', $data->job_location ?? '') == 'Pitstop' ? 'selected' : '' }}>
                                                Pitstop</option>
                                            <option value="Service Pad Area"
                                                {{ old('location', $data->job_location ?? '') == 'Service Pad Area' ? 'selected' : '' }}>
                                                Service Pad Area</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="at_inspec" class="ms-0">SMR / HM At Inspection</label>
                                        <input type="number" step="0.0001" class="form-control uppercase "
                                            id="at_inspec" name="at_inspec" value="{{ $data->at_inspection }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">SMR / HM Date</label>
                                        <input type="date" class="form-control uppercase" id="date"
                                            name="date" value="{{ $data->date }}">
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
                                                    @php
                                                        $index = 0;
                                                    @endphp
                                                    @foreach ($list['ENGINE'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                @if ($value['item'] == 'Engine Speed' || $value['item'] == 'Lub Oil Press.')
                                                                    <td class="align-middle" rowspan="2">
                                                                        {!! $value['item'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['item'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == 'T/C Stall')
                                                                    <td class="align-middle" rowspan="6">
                                                                        {!! $value['condition'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">{!! $value['condition'] !!}
                                                                    </td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['unit']))
                                                                @if ($value['unit'] == 'Rpm' || $value['unit'] == 'Kg/cm2')
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
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="eng_actual[]"
                                                                    value="{{ $data->eng_actual[$index] }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="eng_correct[]"value="{{ $data->eng_correction_made[$index] }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="eng_result[]"value="{{ $data->eng_result[$index] }}">
                                                            </td>

                                                            @if ($index === 0)
                                                                <td rowspan="13">
                                                                    <textarea class="form-control uppercase text-center" rows="30" name="eng_remarks">{{ $data->eng_remark }}</textarea>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @php
                                                            $index++;
                                                        @endphp
                                                    @endforeach



                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <button type="button" class="accordion-header">TRANSMISSION</button>
                                    <div class="accordion-content">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="vertical-align: middle;">
                                                            ITEM</th>
                                                        <th colspan="2" style="vertical-align: middle;"
                                                            rowspan="2">
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
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($list['TRANSMISSION'] as $value)
                                                        <tr>
                                                            <td class="align-middle">{!! $value['item'] !!}
                                                            </td>
                                                            <td class="align-middle">
                                                                {!! $value['condition0'] !!}</td>
                                                            <td class="align-middle">
                                                                {!! $value['condition1'] !!}</td>
                                                            <td class="align-middle">
                                                                {!! $value['unit'] !!}</td>
                                                            <td class="align-middle">
                                                                {!! $value['standard'] !!}</td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="wo_actual[]"
                                                                    value="{{ $data->wo_actual[$i] }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="wo_correct[]"value="{{ $data->wo_correction_made[$i] }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="wo_result[]"value="{{ $data->wo_result[$i] }}">
                                                            </td>

                                                            @if ($i === 0)
                                                                <td>
                                                                    <textarea class="form-control uppercase text-center" rows="1" name="wo_remarks">{{ $data->wo_remark }}</textarea>
                                                                </td>
                                                            @endif

                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
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
                                                        <th colspan="2" style="vertical-align: middle;"
                                                            rowspan="2">
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
                                                        $p = 0;
                                                    @endphp
                                                    @foreach ($list['HYDRAULIC'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                <td class="align-middle">
                                                                    {!! $value['item'] !!}</td>
                                                            @endif
                                                            @if (isset($value['condition0']))
                                                                <td class="align-middle" rowspan="9">
                                                                    {!! $value['condition0'] !!}</td>
                                                                <td class="align-middle" rowspan="9">
                                                                    {!! $value['condition1'] !!}</td>
                                                            @endif

                                                            @if (isset($value['unit']))
                                                                @if ($value['unit'] == 'Kg/cm2')
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
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="hyd_actual[]"
                                                                    value="{{ $data->hyd_actual[$p] }}"></td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="hyd_correct[]"value="{{ $data->hyd_correction_made[$p] }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="hyd_result[]"value="{{ $data->hyd_result[$p] }}">
                                                            </td>

                                                            @if ($p === 0)
                                                                <td rowspan="9">
                                                                    <textarea class="form-control uppercase text-center" rows="20" name="hyd_remarks">{{ $data->hyd_remark }}</textarea>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @php
                                                            $p++;
                                                        @endphp
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

                                                    <tr>
                                                        <td colspan="12"
                                                            style="text-align: left; font-weight:bold; font-size:15px;">
                                                            FINAL DRIVE
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Drain Plug</td>
                                                        <td rowspan="2" class="align-middle">Visual Check (Eng. Stop)
                                                        </td>
                                                        <td rowspan="2" class="align-middle"></td>
                                                        <td class="align-middle">No Excressive, Metalic Powder</td>

                                                        <td
                                                            style="width: 10%; text-align: center; vertical-align: middle;">
                                                            <div style="display: inline-block; width: 100%;"
                                                                class="form-control uppercase">
                                                                <select name="final_actual0" style="width: 100%;"
                                                                    class="form-control text-center uppercase">
                                                                    <option value="">--select--</option>
                                                                    <option value="A"
                                                                        {{ old('fin_actual', $data->fin_actual[0] ?? '') == 'A' ? 'selected' : '' }}>
                                                                        A
                                                                    </option>
                                                                    <option value="B"
                                                                        {{ old('fin_actual', $data->fin_actual[0] ?? '') == 'B' ? 'selected' : '' }}>
                                                                        B
                                                                    </option>
                                                                    <option value="C"
                                                                        {{ old('fin_actual', $data->fin_actual[0] ?? '') == 'C' ? 'selected' : '' }}>
                                                                        C
                                                                    </option>
                                                                    <option value="X"
                                                                        {{ old('fin_actual', $data->fin_actual[0] ?? '') == 'X' ? 'selected' : '' }}>
                                                                        X
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="final_correct0"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_correction_made[0] }}>

                                                        </td>
                                                        <td><input type="text" name="final_result0"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[0] }}>

                                                        </td>

                                                        <td rowspan="2">
                                                            <textarea type="text" rows="2" name="final_remarks[]" class="form-control uppercase text-center">{{ $data->fin_remark[0] }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Oil Leak</td>


                                                        <td class="align-middle">No Excressive, Metalic Powder</td>

                                                        <td
                                                            style="width: 10%; text-align: center; vertical-align: middle;">
                                                            <div style="display: inline-block; width: 100%;">
                                                                <select name="final_actual1" style="width: 100%;"
                                                                    class="form-control text-center uppercase">
                                                                    <option value="">--select--</option>
                                                                    <option value="Leak"
                                                                        {{ old('fin_actual', $data->fin_actual[1] ?? '') == 'Leak' ? 'selected' : '' }}>
                                                                        Leak
                                                                    </option>
                                                                    <option value="No Leak"
                                                                        {{ old('fin_actual', $data->fin_actual[1] ?? '') == 'No Leak' ? 'selected' : '' }}>
                                                                        No Leak
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td><input type="text" name="final_correct1"
                                                                class="form-control uppercase text-center"
                                                                value='{{ $data->fin_correction_made[1] }}'>

                                                        </td>
                                                        <td><input type="text" name="final_result1"
                                                                class="form-control uppercase text-center"
                                                                value='{{ $data->fin_result[1] }}'>

                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td colspan="12"
                                                            style="text-align: left; font-weight:bold; font-size:15px;">
                                                            TANDEM
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="align-middle">Drain Plug</td>
                                                        <td rowspan="4" class="align-middle">Visual Check (Eng. Stop)
                                                        </td>
                                                        <td class="align-middle">RH</td>
                                                        <td rowspan="2" class="align-middle">No Excressive, Metalic
                                                            Powder</td>

                                                        <td
                                                            style="width: 10%; text-align: center; vertical-align: middle;">
                                                            <div style="display: inline-block; width: 100%;"
                                                                class="form-control uppercase">
                                                                <select name="final_actual2" style="width: 100%;"
                                                                    class="form-control text-center uppercase">
                                                                    <option value="">--select--</option>
                                                                    <option value="A"
                                                                        {{ old('fin_actual', $data->fin_actual[2] ?? '') == 'A' ? 'selected' : '' }}>
                                                                        A
                                                                    </option>
                                                                    <option value="B"
                                                                        {{ old('fin_actual', $data->fin_actual[2] ?? '') == 'B' ? 'selected' : '' }}>
                                                                        B
                                                                    </option>
                                                                    <option value="C"
                                                                        {{ old('fin_actual', $data->fin_actual[2] ?? '') == 'C' ? 'selected' : '' }}>
                                                                        C
                                                                    </option>
                                                                    <option value="X"
                                                                        {{ old('fin_actual', $data->fin_actual[2] ?? '') == 'X' ? 'selected' : '' }}>
                                                                        X
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td><input type="text" name="final_correct2"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_correction_made[2] }}">

                                                        </td>

                                                        <td><input type="text"name="final_result2"
                                                                class="form-control uppercase text-center"
                                                                value="$data->fin_result[2]">

                                                        </td>

                                                        <td rowspan="2">
                                                            <textarea type="text" rows="2" name="final_remarks[]" class="form-control text-center uppercase">{{ $data->fin_remark[1] }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>LH</td>

                                                        <td
                                                            style="width: 10%; text-align: center; vertical-align: middle;">
                                                            <div style="display: inline-block; width: 100%;"
                                                                class="form-control uppercase">
                                                                <select name="final_actual3" style="width: 100%;"
                                                                    class="form-control text-center uppercase">
                                                                    <option value="">--select--</option>
                                                                    <option value="A"
                                                                        {{ old('fin_actual', $data->fin_actual[3] ?? '') == 'A' ? 'selected' : '' }}>
                                                                        A
                                                                    </option>
                                                                    <option value="B"
                                                                        {{ old('fin_actual', $data->fin_actual[3] ?? '') == 'B' ? 'selected' : '' }}>
                                                                        B
                                                                    </option>
                                                                    <option value="C"
                                                                        {{ old('fin_actual', $data->fin_actual[3] ?? '') == 'C' ? 'selected' : '' }}>
                                                                        C
                                                                    </option>
                                                                    <option value="X"
                                                                        {{ old('fin_actual', $data->fin_actual[3] ?? '') == 'X' ? 'selected' : '' }}>
                                                                        X
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="final_correct3"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_correction_made[3] }}">

                                                        </td>
                                                        <td><input type="text" name="final_result3"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_result[3] }}">

                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="align-middle">Oil Leak</td>
                                                        <td class="align-middle">RH</td>
                                                        <td class="align-middle">No Oil Leak</td>

                                                        <td
                                                            style="width: 10%; text-align: center; vertical-align: middle;">
                                                            <div style="display: inline-block; width: 100%;">
                                                                <select name="final_actual4" style="width: 100%;"
                                                                    class="form-control text-center uppercase">
                                                                    <option value="">--select--</option>
                                                                    <option value="Leak"
                                                                        {{ old('fin_actual', $data->fin_actual[4] ?? '') == 'Leak' ? 'selected' : '' }}>
                                                                        Leak
                                                                    </option>
                                                                    <option value="No Leak"
                                                                        {{ old('fin_actual', $data->fin_actual[4] ?? '') == 'No Leak' ? 'selected' : '' }}>
                                                                        No Leak
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </td>

                                                        <td><input type="text" name="final_correct4"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_correction_made[4] }}">

                                                        </td>
                                                        <td><input type="text" name="final_result4"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_result[4] }}">

                                                        </td>

                                                        <td rowspan="2">
                                                            <textarea type="text" rows="2" name="final_remarks[]" class="form-control uppercase text-center">{{ $data->fin_remark[2] }}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>

                                                        <td>LH</td>
                                                        <td class="align-middle">No Oil Leak</td>

                                                        <td
                                                            style="width: 10%; text-align: center; vertical-align: middle;">
                                                            <div style="display: inline-block; width: 100%;">
                                                                <select name="final_actual5" style="width: 100%;"
                                                                    class="form-control text-center uppercase">
                                                                    <option value="">--select--</option>
                                                                    <option value="Leak"
                                                                        {{ old('fin_actual', $data->fin_actual[5] ?? '') == 'Leak' ? 'selected' : '' }}>
                                                                        Leak
                                                                    </option>
                                                                    <option value="No Leak"
                                                                        {{ old('fin_actual', $data->fin_actual[5] ?? '') == 'No Leak' ? 'selected' : '' }}>
                                                                        No Leak
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td><input type="text" name="final_correct5"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_correction_made[5] }}">

                                                        </td>
                                                        <td><input type="text" name="final_result5"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_result[5] }}">
                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td colspan="12"
                                                            style="text-align: left; font-weight:bold; font-size:15px;">
                                                            ELECTRICAL
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Error Code</td>
                                                        <td class="align-middle">Function Check
                                                        </td>
                                                        <td class="align-middle"></td>
                                                        <td class="align-middle">No DTC (Diagnostic Trouble Code) Detected
                                                        </td>
                                                        <td>
                                                            <input type="text" name="final_actual6"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_actual[6] }}">

                                                        </td>

                                                        <td><input type="text" name="final_correct6"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_correction_made[6] }}">

                                                        </td>
                                                        <td><input type="text" name="final_result6"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_result[6] }}">

                                                        </td>

                                                        <td>
                                                            <textarea type="text" rows="1" name="final_remarks[]" class="form-control uppercase text-center ">{{ $data->fin_remark[3] }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12"
                                                            style="text-align: left; font-weight:bold; font-size:15px;">
                                                            OPTIONAL
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Attacthment Frame</td>
                                                        <td colspan="3" class="align-middle">Crack Detection
                                                        </td>
                                                        <td>
                                                            <input type="text" name="final_actual7"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_actual[7] }}">

                                                        </td>

                                                        <td><input type="text" name="final_correct7"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_correction_made[7] }}">
                                                        </td>
                                                        <td><input type="text" name="final_result7"
                                                                class="form-control uppercase text-center"
                                                                value="{{ $data->fin_result[7] }}">

                                                        </td>

                                                        <td>
                                                            <textarea type="text" name="final_remarks[]" class="form-control uppercase text-center">{{ $data->fin_remark[4] }}</textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By1</label>
                                        <input type="hidden" name="checked1" value="{{ $data->creator }}">
                                        <input type="text" name="view_checked1" class="form-control"
                                            value="{{ optional(collect($approvalList)->firstWhere('nik', $data->creator))->nama ?? '' }}"
                                            readonly>

                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By</label>
                                        <select name="checked2" id="dibuat_oleh" class="form-control" required>
                                            <option disabled selected>-- Select Creator --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}"
                                                    {{ old('checked', $data->checked_by ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Validated By</label>
                                        <select name="validated" id="diperiksa" class="form-control" required>
                                            <option disabled selected>-- Select Approval --</option>
                                            @foreach ($approvalList as $user)
                                                <option value="{{ $user->nik }}"
                                                    {{ old('validated', $data->validated_by ?? '') == $user->nik ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('plant.ppm.3005.dashboard') }}"
                                                class="btn btn-secondary">Cancel</a>
                                            <button type='submit' class="btn btn-primary">Update</button>
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
            $('#dibuat_oleh').select2();
            $('#diperiksa').select2();
            $('#job_site').select2();
            $('#unit_cn').select2();

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
        $(function() {
            var form = $("#formXCMG3005");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);
                console.log("Form data yang dikirim:", formData);

                axios.post('{{ route('plant.ppm.3005.update') }}', formData)
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
                                        '{{ route('plant.ppm.3005.dashboard') }}';
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
