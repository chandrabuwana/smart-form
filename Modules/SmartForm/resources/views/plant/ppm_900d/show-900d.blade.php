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

                    <form action="" method="POST">
                        @csrf
                        <div class="mx-3">

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_model" class="ms-0">Unit Model</label>
                                        <input type="text" class="form-control" id="unit_model" name="unit_model"
                                            value="{{ $data->unit_model }}" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">Unit S/N</label>
                                        <input type="text" class="form-control" id="unit_sn" name="unit_sn"
                                            value="{{ $data->unit_sn }}" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_cn" class="ms-0">Unit C/N</label>
                                        <input type="text" class="form-control" id="unit_cn"
                                            value="{{ $data->unit_cn }}" name="unit_cn" disabled required>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control" id="engine_model" name="engine_model"
                                            value="{{ $data->engine_model }}" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="engine_sn" class="ms-0">Engine S/N</label>
                                        <input type="text" class="form-control" id="engine_sn" name="engine_sn"
                                            value="{{ $data->engine_sn }}" disabled required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="att_front" class="ms-0">Attachment Front</label>
                                        <input type="text" class="form-control" id="att_front" name="att_front" disabled
                                            value="{{ $data->att_front }}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="att_rear" class="ms-0">Attachment Rear</label>
                                            <input type="text" class="form-control" id="att_rear" name="att_rear"
                                                value="{{ $data->att_rear }}" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="job_site" class="ms-0">Job Site</label>
                                            <input type="text" class="form-control" id="job_site" name="job_site"
                                                value="{{ $data->job_site }}" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="location" class="ms-0">Location</label>
                                            <input type="text" class="form-control" id="location" name="location"
                                                value="{{ $data->job_location }}" disabled required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="at_inspec" class="ms-0">SMR / HM At Inspection</label>
                                            <input type="text" class="form-control" id="at_inspec" name="at_inspec"
                                                value="{{ $data->at_inspection }}" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="date" class="ms-0">SMR / HM Date</label>
                                            <input type="date" class="form-control" id="date" name="date"
                                                value="{{ $data->date }}" disabled required>
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
                                                            $h = 0;
                                                        @endphp
                                                        @foreach ($list['ENGINE'] as $value)
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
                                                                    <td class="align-middle">{!! $value['condition'] !!}
                                                                    </td>
                                                                @endif
                                                                @if (isset($value['unit']))
                                                                    @if ($value['unit'] == 'Rpm')
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
                                                                        value="{{ $data->eng_actual[$h] ?? '' }}" disabled
                                                                        class="form-control" name="eng_actual[]"></td>
                                                                <td><input type="text"
                                                                        value="{{ $data->eng_correction_made[$h] ?? '' }}"
                                                                        disabled class="form-control"
                                                                        name="eng_correct[]"></td>
                                                                <td><input type="text" class="form-control"
                                                                        value="{{ $data->eng_result[$h] ?? '' }}" disabled
                                                                        name="eng_result[]"></td>
                                                                <td><input type="text"
                                                                        value="{{ $data->eng_pr[$h] ?? '' }}" disabled
                                                                        class="form-control" name="eng_pr_no[]"></td>
                                                                <td><input type="date"
                                                                        value="{{ $data->eng_taggal[$h] ?? '' }}" disabled
                                                                        class="form-control" name="eng_tanggal[]"></td>
                                                                <td><input value="{{ $data->eng_remark[$h] ?? '' }}"
                                                                        disabled type="text" class="form-control"
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


                                                                <td><input type="text" class="form-control"
                                                                        name="hyd_actual[]"
                                                                        value="{{ $data->hyd_actual[$i] ?? '' }}"
                                                                        disabled>
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        name="hyd_correct[]"
                                                                        value="{{ $data->hyd_correction_made[$i] ?? '' }}"
                                                                        disabled></td>
                                                                <td><input type="text" class="form-control"
                                                                        name="hyd_result[]"
                                                                        value="{{ $data->hyd_result[$i] ?? '' }}"
                                                                        disabled>
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        name="hyd_pr_no[]"
                                                                        value="{{ $data->hyd_pr[$i] ?? '' }}" disabled>
                                                                </td>
                                                                <td><input type="date" class="form-control"
                                                                        name="hyd_tanggal[]"
                                                                        value="{{ $data->hyd_taggal[$i] ?? '' }}"
                                                                        disabled>
                                                                </td>
                                                                <td><input type="text" class="form-control"
                                                                        value="{{ $data->hyd_remark[$i] ?? '' }}"
                                                                        name="hyd_remarks[]" disabled></td>

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


                                                                <td><input type="text" class="form-control"
                                                                        name="wo_actual[]"
                                                                        value="{{ $data->wo_actual[$j] ?? '' }}" disabled>
                                                                </td>
                                                                <td><input type="text"
                                                                        value="{{ $data->wo_correction_made[$j] ?? '' }}"
                                                                        disabled class="form-control" name="wo_correct[]">
                                                                </td>
                                                                <td><input value="{{ $data->wo_result[$j] ?? '' }}"
                                                                        disabled type="text" class="form-control"
                                                                        name="wo_result[]"></td>
                                                                <td><input value="{{ $data->wo_pr[$j] ?? '' }}" disabled
                                                                        type="text" class="form-control"
                                                                        name="wo_pr_no[]"></td>
                                                                <td><input value="{{ $data->wo_taggal[$j] ?? '' }}"
                                                                        disabled type="date" class="form-control"
                                                                        name="wo_tanggal[]"></td>
                                                                <td><input value="{{ $data->wo_remark[$j] ?? '' }}"
                                                                        disabled type="text" class="form-control"
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

                                                                <td><input type="text"
                                                                        value="{{ $data->fin_actual[$k] ?? '' }}" disabled
                                                                        class="form-control" name="final_actual[]"></td>
                                                                <td><input type="text"
                                                                        value="{{ $data->fin_correction_made[$k] ?? '' }}"
                                                                        disabled class="form-control"
                                                                        name="final_correct[]"></td>
                                                                <td><input type="text"
                                                                        value="{{ $data->fin_result[$k] ?? '' }}" disabled
                                                                        class="form-control" name="final_result[]"></td>
                                                                <td><input type="text"
                                                                        value="{{ $data->fin_pr[$k] ?? '' }}" disabled
                                                                        class="form-control" name="final_pr_no[]"></td>
                                                                <td><input type="date"
                                                                        value="{{ $data->fin_taggal[$k] ?? '' }}" disabled
                                                                        class="form-control" name="final_tanggal[]"></td>
                                                                <td><input type="text"
                                                                        value="{{ $data->fin_remark[$k] ?? '' }}" disabled
                                                                        class="form-control" name="final_remarks[]"></td>
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
                                    <div class="col-6 ">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="dibuat" class="ms-0">Checked By</label>
                                            <input type="text" class="form-control" id="diperiksa" name="diperiksa"
                                                value="{{ $data->checked_by }}" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="diperiksa" class="ms-0">Validated By</label>
                                            <input type="text" class="form-control" id="diperiksa" name="diperiksa"
                                                value="{{ $data->validated_by }}" disabled required>
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


    <script>
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
