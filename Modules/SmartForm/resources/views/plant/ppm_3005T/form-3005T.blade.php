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
                            <h6 class="text-white text-capitalize ps-3"> Form PPM XCMG GT3005T SERIES</h6>
                        </div>
                    </div>

                    <form id="formXCMG3005" method="POST">
                        @csrf
                        <div class="mx-3">

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">Unit S/N</label>
                                        <input type="text" class="form-control" id="unit_sn" name="unit_sn" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <input type="text" class="form-control" id="unit_cn" name="unit_cn" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control" id="engine_model" name="engine_model"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_sn" class="ms-0">Engine S/N</label>
                                        <input type="text" class="form-control" id="engine_sn" name="engine_sn" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="att_front" class="ms-0">Attachment Front</label>
                                        <input type="text" class="form-control" id="att_front" name="att_front" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="att_rear" class="ms-0">Attachment Rear</label>
                                        <input type="text" class="form-control" id="att_rear" name="att_rear" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="job_site" class="ms-0">Job Site</label>
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
                                        <label for="location" class="ms-0">Location</label>
                                        <select class="form-control" name="location" id="location" required>
                                            <option disabled selected>-- Select Location --</option>
                                            <option value="Workshop">Workshop</option>
                                            <option value="Pitstop">Pitstop</option>
                                            <option value="Service">Service</option>
                                            <option value="Truck">Truck</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="at_inspec" class="ms-0">SMR / HM At Inspection</label>
                                        <input type="text" class="form-control" id="at_inspec" name="at_inspec"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="date" class="ms-0">SMR / HM Date</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                            required>
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
                                                            CORRECTION MODE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>
                                                        <th style="vertical-align: middle;" colspan="2">
                                                            RECOMENDED PARTS</th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>PR.NO</th>
                                                        <th>TANGGAL</th>
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
                                                            <td><input type="text" class="form-control"
                                                                    name="eng_actual[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="eng_correct[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="eng_result[]"></td>
                                                            <td><input type="text" class="form-control"
                                                                    name="eng_pr_no[]"></td>
                                                            <td><input type="date" class="form-control"
                                                                    name="eng_tanggal[]"></td>
                                                            @if ($index === 0)
                                                                <td rowspan="13">
                                                                    <textarea class="form-control" rows="30" name="eng_remarks"></textarea>
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
                                                            CORRECTION MODE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>
                                                        <th style="vertical-align: middle;" colspan="2">
                                                            RECOMENDED PARTS</th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>PR.NO</th>
                                                        <th>TANGGAL</th>
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
                                                            <td><input type="text" class="form-control"
                                                                    name="wo_actual[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="wo_correct[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="wo_result[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="wo_pr_no[]">
                                                            </td>
                                                            <td><input type="date" class="form-control"
                                                                    name="wo_tanggal[]">
                                                            </td>
                                                            @if ($i === 0)
                                                                <td>
                                                                    <textarea class="form-control" rows="2" name="wo_remarks"></textarea>
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
                                                            CORRECTION MODE</th>
                                                        <th style="vertical-align: middle;" rowspan="2">RESULT
                                                        </th>
                                                        <th style="vertical-align: middle;" colspan="2">
                                                            RECOMENDED PARTS</th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>PR.NO</th>
                                                        <th>TANGGAL</th>
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
                                                            <td><input type="text" class="form-control"
                                                                    name="hyd_actual[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="hyd_correct[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="hyd_result[]">
                                                            </td>
                                                            <td><input type="text" class="form-control"
                                                                    name="hyd_pr_no[]">
                                                            </td>
                                                            <td><input type="date" class="form-control"
                                                                    name="hyd_tanggal[]">
                                                            </td>
                                                            @if ($p === 0)
                                                                <td rowspan="9">
                                                                    <textarea class="form-control" rows="20" name="hyd_remarks"></textarea>
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
                                                        <th style="vertical-align: middle;" colspan="2">
                                                            RECOMENDED PARTS</th>
                                                        <th style="vertical-align: middle;" rowspan="2">REMARKS
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>PR.NO</th>
                                                        <th>TANGGAL</th>
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
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual0" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct0" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result0" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                        <td rowspan="2">
                                                            <textarea type="text" rows="4" class="form-control" name="final_remarks[]"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Oil Leak</td>


                                                        <td class="align-middle">No Excressive, Metalic Powder</td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual1" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct1" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result1" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>

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
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual2" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct2" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result2" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                        <td rowspan="2">
                                                            <textarea type="text" rows="4" class="form-control" name="final_remarks[]"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>

                                                        <td>LH</td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual3" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct3" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result3" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="align-middle">Oil Leak</td>
                                                        <td class="align-middle">RH</td>
                                                        <td class="align-middle">No Oil Leak</td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual4" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct4" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result4" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                        <td rowspan="2">
                                                            <textarea type="text" rows="4" class="form-control" name="final_remarks[]"></textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>

                                                        <td>LH</td>
                                                        <td class="align-middle">No Oil Leak</td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual5" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct5" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result5" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="12"
                                                            style="text-align: left; font-weight:bold; font-size:15px;">
                                                            ELECTRICAL
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle">Electrical Function</td>
                                                        <td class="align-middle">Function Check
                                                        </td>
                                                        <td class="align-middle"></td>
                                                        <td class="align-middle">No DTC (Diagnostic Trouble Code) Detected
                                                        </td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual6" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct6" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result6" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                        <td>
                                                            <textarea type="text" rows="1" class="form-control" name="final_remarks[]"></textarea>
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
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_actual7" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_correct7" value=1></td>
                                                        <td><input type="checkbox" class="custom-checkbox"
                                                                name="final_result7" value=1></td>
                                                        <td><input type="text" class="form-control"
                                                                name="final_pr_no[]"></td>
                                                        <td><input type="date" class="form-control"
                                                                name="final_tanggal[]"></td>
                                                        <td>
                                                            <textarea type="text" rows="1" class="form-control" name="final_remarks[]"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-6 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By</label>
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
                                        <label for="diperiksa" class="ms-0">Validated By</label>
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
                                            <a href="{{ route('plant.ppm.3005.dashboard') }}"
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
        });
        $(function() {
            var form = $("#formXCMG3005");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);
                console.log("Form data yang dikirim:", formData);

                axios.post('{{ route('plant.ppm.3005.store') }}', formData)
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
