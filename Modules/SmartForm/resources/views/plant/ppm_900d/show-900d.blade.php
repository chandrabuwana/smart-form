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
                            <input type="hidden" name="doc_num" value="{{ $data->doc_num }}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <select name="unit_cn" class="form-control" id="unit_cn" required>
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
                                        <input type="text" class="form-control uppercase" id="unit_model"
                                            name="unit_model" value="{{ $data->unit_model }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">Unit S/N</label>
                                        <input type="text" class="form-control uppercase" id="unit_sn" name="unit_sn"
                                            value="{{ $data->unit_sn }}" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control uppercase" id="engine_model"
                                            name="engine_model" value="{{ $data->engine_model }}" required>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_sn" class="ms-0">Engine S/N</label>
                                        <input type="text" class="form-control uppercase" id="engine_sn" name="engine_sn"
                                            value="{{ $data->engine_sn }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="brand" class="ms-0">Brand</label>
                                        <input type="text" class="form-control uppercase" id="brand"
                                            value="{{ $data->brand }}" name="brand" required>
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
                                        <select class="form-control uppercase" name="location" id="location" required>
                                            <option value="Workshop"
                                                {{ old('location', $data->job_location ?? '') == 'Workshop' ? 'selected' : '' }}>
                                                Workshop</option>
                                            <option value="Pitstop"
                                                {{ old('location', $data->job_location ?? '') == 'Pitstop' ? 'selected' : '' }}>
                                                Pitstop</option>
                                            <option value="Service Pad Area"
                                                {{ old('location', $data->job_location ?? '') == 'Service Pad Area' ? 'selected' : '' }}>
                                                Service</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="at_inspec" class="ms-0">SMR / HM At Inspection</label>
                                        <input type="number" class="form-control uppercase" id="at_inspec"
                                            name="at_inspec" step="0.0001" value="{{ $data->at_inspection }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">SMR / HM Date</label>
                                        <input type="date" class="form-control uppercase" id="date"
                                            name="date" value="{{ $data->date }}" required>
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
                                                        $h = 0;
                                                    @endphp
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
                                                                    value="{{ $data->eng_actual[$h] ?? '' }}"
                                                                    step="0.0001"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_actual[]">
                                                            </td>
                                                            <td><input type="text"
                                                                    value="{{ $data->eng_correction_made[$h] ?? '' }}"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_correct[]">
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    value="{{ $data->eng_result[$h] ?? '' }}"
                                                                    name="eng_result[]"></td>
                                                            <td><input value="{{ $data->eng_remark[$h] ?? '' }}"
                                                                    type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="eng_remarks[]"></td>
                                                        </tr>
                                                        @php
                                                            $h++;
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
                                                        $i = 0;
                                                    @endphp
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
                                                                    name="hyd_actual[]" step="0.0001"
                                                                    value="{{ $data->hyd_actual[$i] ?? '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="hyd_correct[]"
                                                                    value="{{ $data->hyd_correction_made[$i] ?? '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="hyd_result[]"
                                                                    value="{{ $data->hyd_result[$i] ?? '' }}">
                                                            </td>

                                                            <td><input type="text"
                                                                    class="form-control text-center uppercase"
                                                                    value="{{ $data->hyd_remark[$i] ?? '' }}"
                                                                    name="hyd_remarks[]"></td>

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
                                                    @php
                                                        $j = 0;
                                                    @endphp
                                                    @foreach ($list['WORKING SPEED'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                <td class="align-middle">{!! $value['item'] !!}
                                                                </td>
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == '1800 rpm (10th gear)')
                                                                    <td class="align-middle" rowspan="10">
                                                                        {!! $value['condition'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['condition'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['unit']))
                                                                @if ($value['unit'] == 'Sec')
                                                                    <td class="align-middle" rowspan="10">
                                                                        {!! $value['unit'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['unit'] !!}</td>
                                                                @endif
                                                            @endif
                                                            @if (isset($value['standard']))
                                                                @if ($value['standard'] == '28 ± 4 (3 round calculated after 1 round not calculated)')
                                                                    <td class="align-middle" rowspan="2">
                                                                        {!! $value['standard'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['standard'] !!}</td>
                                                                @endif
                                                            @endif


                                                            <td><input type="number"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_actual[]" step="0.0001"
                                                                    value="{{ $data->wo_actual[$j] ?? '' }}">
                                                            </td>
                                                            <td><input type="text"
                                                                    value="{{ $data->wo_correction_made[$j] ?? '' }}"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_correct[]">
                                                            </td>
                                                            <td><input value="{{ $data->wo_result[$j] ?? '' }}"
                                                                    type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_result[]"></td>
                                                            <td><input value="{{ $data->wo_remark[$j] ?? '' }}"
                                                                    type="text"
                                                                    class="form-control text-center uppercase"
                                                                    name="wo_remarks[]"></td>
                                                        </tr>
                                                        @php
                                                            $j++;
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
                                                    @php
                                                        $k = 0;
                                                    @endphp
                                                    @foreach ($list['Final'] as $value)
                                                        <tr>
                                                            @if (isset($value['item']))
                                                                <td class="align-middle">{!! $value['item'] !!}
                                                                </td>
                                                            @endif
                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                                                                    <td class="align-middle" rowspan="2">
                                                                        {!! $value['condition'] !!}</td>
                                                                @else
                                                                    <td class="align-middle">
                                                                        {!! $value['condition'] !!}</td>
                                                                @endif
                                                            @endif
                                                            <td></td>
                                                            @if (isset($value['standard']))
                                                                <td class="align-middle">{!! $value['standard'] !!}
                                                                </td>
                                                            @else
                                                                <td></td>
                                                            @endif

                                                            @if ($value['item'] == 'Drain Plug')
                                                                <td
                                                                    style="width: 10%; text-align: center; vertical-align: middle;">
                                                                    <div style="display: inline-block; width: 100%;"
                                                                        class="form-control uppercase">
                                                                        <select name="final_actual{{ $k }}"
                                                                            style="width: 100%;"
                                                                            class="form-control text-center uppercase">
                                                                            <option value="">--select--</option>
                                                                            <option value="A"
                                                                                {{ old('fin_actual' . $k, $data->fin_actual[$k] ?? '') == 'A' ? 'selected' : '' }}>
                                                                                A
                                                                            </option>
                                                                            <option value="B"
                                                                                {{ old('fin_actual' . $k, $data->fin_actual[$k] ?? '') == 'B' ? 'selected' : '' }}>
                                                                                B
                                                                            </option>
                                                                            <option value="C"
                                                                                {{ old('fin_actual' . $k, $data->fin_actual[$k] ?? '') == 'C' ? 'selected' : '' }}>
                                                                                C
                                                                            </option>
                                                                            <option value="X"
                                                                                {{ old('fin_actual' . $k, $data->fin_actual[$k] ?? '') == 'X' ? 'selected' : '' }}>
                                                                                X
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            @elseif ($value['item'] == 'Oil Leak')
                                                                <td
                                                                    style="width: 10%; text-align: center; vertical-align: middle;">
                                                                    <div style="display: inline-block; width: 100%;">
                                                                        <select name="final_actual{{ $k }}"
                                                                            style="width: 100%;"
                                                                            class="form-control text-center uppercase">
                                                                            <option value="">--select--</option>
                                                                            <option value="Leak"
                                                                                {{ old('fin_actual' . $k, $data->fin_actual[$k] ?? '') == 'Leak' ? 'selected' : '' }}>
                                                                                Leak
                                                                            </option>
                                                                            <option value="No Leak"
                                                                                {{ old('fin_actual' . $k, $data->fin_actual[$k] ?? '') == 'No Leak' ? 'selected' : '' }}>
                                                                                No Leak
                                                                            </option>

                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td><input type="text"
                                                                        class="form-control text-center uppercase"
                                                                        name="final_actual{{ $k }}"
                                                                        value="{{ $data->fin_actual[$k] }}">
                                                                </td>
                                                            @endif
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="final_correct{{ $k }}"
                                                                    value="{{ $data->fin_correction_made[$k] }}">
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="final_result{{ $k }}"
                                                                    value="{{ $data->fin_result[$k] }}">
                                                            </td>

                                                            @if (isset($value['condition']))
                                                                @if ($value['condition'] == 'Visual Check (Eng. Stop)')
                                                                    <td rowspan="2"><input type="text"
                                                                            value="{{ $data->fin_remark[0] ?? '' }}"
                                                                            class="form-control text-center uppercase"
                                                                            name="final_remarks[]">
                                                                    </td>
                                                                @elseif ($value['condition'] == 'Function Check')
                                                                    <td rowspan="2"><input type="text"
                                                                            value="{{ $data->fin_remark[1] ?? '' }}"
                                                                            class="form-control text-center uppercase"
                                                                            name="final_remarks[]">
                                                                    </td>
                                                                @else
                                                                    <td rowspan="2"><input type="text"
                                                                            value="{{ $data->fin_remark[2] ?? '' }}"
                                                                            class="form-control text-center uppercase"
                                                                            name="final_remarks[]">
                                                                    </td>
                                                                @endif
                                                            @endif

                                                        </tr>
                                                        @php
                                                            $k++;
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
                                        <textarea name="note" id="note" class="form-control uppercase" cols="30" rows="1">{{ $data->note }}</textarea>
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By1</label>
                                        <input type="text" name="checked1" class="form-control"
                                            value="{{ $data->creator }}" readonly>

                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By2</label>
                                        <select name="checked2" id="checked2" class="form-control uppercase" required>


                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Validated By</label>
                                        <select name="validated" id="validated" class="form-control uppercase" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('plant.ppm.900d.dashboard') }}"
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {


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
        $(function() {
            var form = $("#formXCMG900");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);
                console.log("Form data yang dikirim:", formData);

                axios.post('{{ route('plant.ppm.900d.update') }}', formData)
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
    </script>
    <script>
        $(function() {
            const selectedNama = '{{ $data->checked_by }}';

            $('#checked2').select2({
                placeholder: '-- Select Creator --',
                width: '100%',
                ajax: {
                    url: '{{ route('900d.approval.list') }}',
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
                                    id: item.nama,
                                    text: item.nama + ' (' + item.nik + ')',
                                    nama: item.nama
                                };
                            })
                        };
                    },
                    cache: true
                }
            });


            if (selectedNama) {
                $.ajax({
                    url: '{{ route('900d.approval.list') }}',
                    dataType: 'json',
                    success: function(data) {
                        const matched = data.find(item => item.nama ===
                            selectedNama);
                        if (matched) {
                            const option = new Option(matched.nama + ' (' + matched.nik + ')', matched
                                .nama, true, true);
                            $('#checked2').append(option).trigger('change');
                        }
                    }
                });
            }
        });


        $(function() {
            const selectedNik = '{{ $data->validated_by }}';

            $('#validated').select2({
                placeholder: '-- Select Creator --',
                width: '100%',
                ajax: {
                    url: '{{ route('900d.approval.list') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term || ''
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.nama,
                                    text: item.nama + ' (' + item.nik +
                                        ')',
                                };
                            })
                        };
                    },
                    cache: true
                }
            });


            if (selectedNik) {
                $.ajax({
                    url: '{{ route('900d.approval.list') }}',
                    dataType: 'json',
                    success: function(data) {
                        const matched = data.find(item => item.nama === selectedNik);
                        if (matched) {
                            const option = new Option(matched.nama + ' (' + matched.nik + ')', matched
                                .nama, true, true);
                            $('#validated').append(option).trigger('change');
                        }
                    }
                });
            }
        });
    </script>
@endsection
