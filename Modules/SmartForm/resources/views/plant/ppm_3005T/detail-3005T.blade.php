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
                        <div
                            class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 px-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize m-0">Form PPM XCMG GR3005T SERIES</h6>
                            <h6 class="text-white text-capitalize m-0">
                                Creator :
                                {{ optional(collect($approvalList)->firstWhere('nik', $data->creator))->nama ?? '' }}
                            </h6>
                        </div>
                    </div>

                    <form>
                        @csrf
                        <div class="mx-3">
                            <input type="hidden" name="doc_num" value="{{ $data->doc_num }}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <input type="text" class="form-control uppercase" id="unit_cn" name="unit_cn"
                                            value="{{ $data->unit_cn }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_model" class="ms-0">Unit Model</label>
                                        <input type="text" class="form-control uppercase" id="unit_model"
                                            name="unit_model" value="{{ $data->unit_model }}" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">Unit S/N</label>
                                        <input type="text" class="form-control uppercase" id="unit_sn" name="unit_sn"
                                            value="{{ $data->unit_sn }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control uppercase" id="engine_model"
                                            name="engine_model" value="{{ $data->engine_model }}" disabled>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_sn" class="ms-0">Engine S/N</label>
                                        <input type="text" class="form-control uppercase" id="engine_sn" name="engine_sn"
                                            value="{{ $data->engine_sn }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="att_front" class="ms-0">Brand</label>
                                        <input type="text" class="form-control uppercase" id="att_front" name="att_front"
                                            value="{{ $data->brand }}" disabled>
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
                                        <select class="form-control uppercase" name="location" id="location" disabled
                                            required>
                                            <option value="Workshop"
                                                {{ old('location', $data->job_location ?? '') == 'Workshop' ? 'selected' : '' }}>
                                                Workshop</option>
                                            <option value="Pitstop"
                                                {{ old('location', $data->job_location ?? '') == 'Pitstop' ? 'selected' : '' }}>
                                                Pitstop</option>
                                            <option value="Service"
                                                {{ old('location', $data->job_location ?? '') == 'Service' ? 'selected' : '' }}>
                                                Service</option>
                                            <option value="Truck"
                                                {{ old('location', $data->job_location ?? '') == 'Truck' ? 'selected' : '' }}>
                                                Truck</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="at_inspec" class="ms-0">SMR / HM At Inspection</label>
                                        <input type="text" class="form-control uppercase" id="at_inspec"
                                            name="at_inspec" value="{{ $data->at_inspection }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">SMR / HM Date</label>
                                        <input type="date" class="form-control uppercase" id="date"
                                            name="date" value="{{ $data->date }}" disabled>
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
                                                                    value="{{ $data->eng_actual[$index] }}" disabled></td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="eng_correct[]"value="{{ $data->eng_correction_made[$index] }}"
                                                                    disabled>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="eng_result[]"value="{{ $data->eng_result[$index] }}"
                                                                    disabled>
                                                            </td>

                                                            @if ($index === 0)
                                                                <td rowspan="13">
                                                                    <textarea class="form-control uppercase text-center" rows="30" name="eng_remarks" disabled>{{ $data->eng_remark }}</textarea>
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
                                                                    name="wo_correct[]"value="{{ $data->wo_correction_made[$i] }}"
                                                                    disabled>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="wo_result[]"value="{{ $data->wo_result[$i] }}"
                                                                    disabled>
                                                            </td>

                                                            @if ($i === 0)
                                                                <td>
                                                                    <textarea class="form-control uppercase text-center" rows="1" name="wo_remarks" disabled>{{ $data->wo_remark }}</textarea>
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
                                                                    value="{{ $data->hyd_actual[$p] }}" disabled></td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="hyd_correct[]"value="{{ $data->hyd_correction_made[$p] }}"
                                                                    disabled>
                                                            </td>
                                                            <td><input type="text"
                                                                    class="form-control uppercase text-center"
                                                                    name="hyd_result[]"value="{{ $data->hyd_result[$p] }}"
                                                                    disabled>
                                                            </td>

                                                            @if ($p === 0)
                                                                <td rowspan="9">
                                                                    <textarea class="form-control uppercase text-center" rows="20" name="hyd_remarks" disabled>{{ $data->hyd_remark }}</textarea>
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
                                                            CORRECTION MODE</th>
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
                                                        <td>
                                                            <input type="text" name="final_actual0"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_actual[0] }}" disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct0"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_correction_made[0] }}" disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result0"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_result[0] }}" disabled>
                                                        </td>

                                                        <td rowspan="2">
                                                            <textarea type="text" rows="2" name="final_remarks[]" class="form-control uppercase text-center" disabled>{{ $data->fin_remark[0] }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Oil Leak</td>


                                                        <td class="align-middle">No Excressive, Metalic Powder</td>
                                                        <td>
                                                            <input type="text" name="final_actual1"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_actual[1] }}" disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct1"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_correction_made[1] }}" disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result1"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[1] }} disabled>
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
                                                        <td>
                                                            <input type="text" name="final_actual2"
                                                                class="form-control uppercase text-center"
                                                                value={{ $data->fin_actual[2] }} disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct2"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_correction_made[2] }}" disabled>
                                                        </td>
                                                        <td><input type="text"name="final_result2"
                                                                class="form-control text-center uppercase"
                                                                value="{{ $data->fin_result[2] }}" disabled>
                                                        </td>

                                                        <td rowspan="2">
                                                            <textarea type="text" rows="2" name="final_remarks[]" class="form-control text-center uppercase" disabled>{{ $data->fin_remark[1] }}</textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>LH</td>
                                                        <td>
                                                            <input type="text" name="final_actual3"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_actual[3] }} disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct3"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_correction_made[3] }} disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result3"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[3] }} disabled>
                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="align-middle">Oil Leak</td>
                                                        <td class="align-middle">RH</td>
                                                        <td class="align-middle">No Oil Leak</td>
                                                        <td>
                                                            <input type="text" name="final_actual4"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_actual[4] }} disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct4"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_correction_made[4] }} disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result4"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[4] }} disabled>
                                                        </td>

                                                        <td rowspan="2">
                                                            <textarea type="text" rows="2" name="final_remarks[]" class="form-control text-center uppercase" disabled>{{ $data->fin_remark[2] }}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>

                                                        <td>LH</td>
                                                        <td class="align-middle">No Oil Leak</td>
                                                        <td>
                                                            <input type="text" name="final_actual5"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_actual[5] }} disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct5"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_correction_made[5] }} disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result5"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[5] }} disabled>
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
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_actual[6] }} disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct6"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_correction_made[6] }} disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result6"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[6] }} disabled>
                                                        </td>

                                                        <td>
                                                            <textarea type="text" rows="1" name="final_remarks[]" class="form-control text-center uppercase" disabled>{{ $data->fin_remark[3] }}</textarea>
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
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_actual[7] }} disabled>
                                                        </td>

                                                        <td><input type="text" name="final_correct7"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_correction_made[7] }} disabled>
                                                        </td>
                                                        <td><input type="text" name="final_result7"
                                                                class="form-control text-center uppercase"
                                                                value={{ $data->fin_result[7] }} disabled>
                                                        </td>

                                                        <td>
                                                            <textarea type="text" name="final_remarks[]" class="form-control text-center uppercase" disabled>{{ $data->fin_remark[4] }}</textarea>
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
                                        <input type="text" class="form-control" value="{{ $data->creator }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By</label>
                                        <select name="checked2" id="checked2" class="form-control" disabled required>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Validated By</label>
                                        <select name="validated" id="validated" class="form-control" disabled required>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    @for ($i = 0; $i < 3; $i++)
                                        @if ($i == 0)
                                            <div class="col-4 ty">
                                                <img src="{{ asset('img/checked.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($i == 1)
                                            <div class="col-4 ty">
                                                <img src="{{ asset('img/checked.png') }}" class="img-app"
                                                    alt="">
                                            </div>
                                        @elseif ($i == 2)
                                            @if ($data->status == 'rejected')
                                                <div class="col-4 ty">
                                                    <img src="{{ asset('img/rejected.png') }}" class="img-app"
                                                        alt="">
                                                </div>
                                            @elseif ($data->status == 'approved')
                                                <div class="col-4 ty">
                                                    <img src="{{ asset('img/validated.png') }}" class="img-app"
                                                        alt="">
                                                </div>
                                            @elseif ($data->status == 'draft')
                                                <div class="col-4 ty">
                                                    <p class="badge bg-danger mt-3">Menunggu validasi Foreman</p>
                                                </div>
                                            @endif
                                        @endif
                                    @endfor

                                </div>
                                <div class="row">
                                    <div class="col-4 mt-2">
                                        <p class="text-center">
                                            {{ \Carbon\Carbon::parse($data->date_checked)->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <p class="text-center">
                                            {{ \Carbon\Carbon::parse($data->date_checked)->translatedFormat('l, d F Y') }}
                                        </p>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <p class="text-center">
                                            @if ($data->date_validated)
                                                {{ \Carbon\Carbon::parse($data->date_validated)->translatedFormat('l, d F Y') }}
                                            @else
                                                --
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            @if ($nik == $data->validated_by)
                                                <button class="btn btn-success btn-sm" id="btn3005Approve"
                                                    data-doc="{{ $data->doc_num }}"
                                                    data-status='@json($data->status)'
                                                    data-nik="{{ $nik }}">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>

                                                <button class="btn btn-warning btn-sm" id="btn3005Reject"
                                                    data-doc="{{ $data->doc_num }}"
                                                    data-status='@json($data->status)'
                                                    data-nik="{{ $nik }}">
                                                    <i class="fas fa-close"></i> Reject
                                                </button>
                                            @endif

                                            @if ($data->status === 'rejected')
                                                @if ($nik == $data->creator)
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="resetApproval('{{ $data->doc_num }}')">
                                                        <i class="fas fa-undo"></i> Reset
                                                    </button>
                                                @endif
                                            @endif

                                            <a href="{{ route('plant.ppm.3005.dashboard') }}"
                                                class="btn btn-secondary btn-sm">Cancel</a>
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
        $(function() {
            const selectedNik = '{{ $data->checked_by }}';

            $('#checked2').select2({
                placeholder: '-- Select Creator --',
                width: '100%',
                ajax: {
                    url: '{{ route('3005.approval.list') }}',
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
                    url: '{{ route('3005.approval.list') }}',
                    dataType: 'json',
                    success: function(data) {
                        const matched = data.find(item => item.nama === selectedNik);
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
                    url: '{{ route('3005.approval.list') }}',
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
                    url: '{{ route('3005.approval.list') }}',
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

    <script>
        $(document).ready(function() {

            $('#diperiksa').select2();
            $('#job_site').select2();
        });

        document.addEventListener("DOMContentLoaded", function() {

            document.getElementById("btn3005Approve").addEventListener("click", function() {
                let docNumber = this.getAttribute("data-doc");
                let status = JSON.parse(this.getAttribute('data-status'));

                let nik = this.getAttribute("data-nik");

                axios.post("{{ route('plant.ppm.3005.approve') }}", {
                        _token: "{{ csrf_token() }}",
                        doc_num: docNumber,


                        validated: nik == "{{ $data->validated_by }}" ? 'approved' : status,

                    })
                    .then(response => {
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
            });


            document.getElementById("btn3005Reject").addEventListener("click", function() {
                let docNumber = this.getAttribute("data-doc");
                let status = JSON.parse(this.getAttribute('data-status'));
                let nik = this.getAttribute("data-nik");

                axios.post("{{ route('plant.ppm.3005.reject') }}", {
                        _token: "{{ csrf_token() }}",
                        doc_num: docNumber,

                        validated: nik == "{{ $data->validated_by }}" ? 'rejected' : status,
                    })
                    .then(response => {
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
            });


        });

        function resetApproval(id) {
            if (confirm('Are you sure you want to reset this Approval?')) {
                axios.post('{{ route('plant.ppm.3005.reset', ['id' => 'ID']) }}'.replace('ID', id))
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
