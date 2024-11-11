@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    main {
        max-height: none !important;
    }
    .only-print {
        display: none;
    }
    .c-title {
        display: flex;
        width: 100%;
        justify-content: space-between;
    }


    @media print {
        table.table-print thead {
            background-color: rgb(231, 231, 217);
        }
        table.table-print, table.table-print tr, table.table-print td{
            border-style: solid;
            border-width: 1px;
        }
        .only-print {
            display: inline;
        }
        .fixed-plugin-button {
            display: none;
        }
        /* Sembunyikan elemen yang tidak diperlukan */
        .no-print {
            display: none !important;
        }
        nav {
            display: none !important;
        }
        aside {
            display: none !important;
        }
        
        /* Atur ukuran font khusus untuk print */
        body {
            font-size: 12pt;
            height: auto;
            overflow: visible;
        }
        main {
            max-height: none !important;
        }

        /* Atur margin agar lebih pas untuk print */
        

        /* Sesuaikan elemen layout untuk print */
        .print-specific {
            display: block;
        }
        .card {
            box-shadow: none;
        }
        .print-col-6 {
            flex: 0 0 auto;
            width: 50%;
        }
        .print-col {
            flex: 0 0 auto;
            width: 100%;
        }
        .print-nature {
            width: 100%;
            display: table;
        }
        .print-border {
            border: 1px solid black;
        }
        .print-w-full {
            width: 100%;
        }
        .print-mt-4 {
            margin-top: 16px;
        }
        .print-mt-2 {
            margin-top: 8px;
        }
        .print-flex {
            display: flex;
        }
        .table thead th {
            padding: 2px 4px;
        }
        .print-font-size {
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 print-card-header no-print">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Asset Request</h6>
                    </div>
                </div>
                <h3 class="text-capitalize ps-3 only-print">Form Asset Request</h3>
                <div class="card-body my-1">

                    <div class="row gx-4 mb-4">
                        <table class="small only-print">
                            <tr>
                                <td>No. Doc</td>
                                <td class="px-3">:</td>
                                <td>{{ $data['no_doc'] }}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td class="px-3">:</td>
                                <td>{{ implode('-', array_reverse(explode('-', $data['tgl_doc']))) }}</td>
                            </tr>
                            <tr>
                                <td>Requested By</td>
                                <td class="px-3">:</td>
                                <td>{{ $data['requested_by'] }} - {{ $data['requested_name']  }}</td>
                            </tr>
                        </table>
                        <div class="col-auto my-auto ms-3 no-print c-title">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Requested By : <span id="requestor">{{ $data['requested_by'] }}</span>
                                </p>
                            </div>
                            <div class="no-print">
                                <button class="btn btn-primary" onclick="cetak(event)"><i class="fa-solid fa-print"></i> cetak</button>
                            </div>
                        </div>
                    </div>

                    <form action="" class="no-print">
                        <div class="row gx-4 my-3">
                            <div class="col-12 col-md-4">
                                <h4>Nature</h4>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkReplacement" name="checkReplacement" disabled {{$data['replacement']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Replacement
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkAdditional" name="checkAdditional" disabled {{$data['additional']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Additional
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkBudgeted" name="checkBudgeted" disabled {{$data['budgeted']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Budgeted
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkNotBudgeted" name="checkNotBudgeted" disabled {{$data['not_budgeted']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Not Budgeted
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-4">
                            <div class="row">
                                <div class="no-print">
                                    <table class="small">
                                        <tr>
                                            <td>No. Doc</td>
                                            <td>:</td>
                                            <td id="noDoc">{{ $data['no_doc'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td id="tglDoc">{{ $data['tgl_doc'] }}</td>
                                        </tr>
                                        @foreach ($history as $riwayat)
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{ $riwayat->updated_at }}</td>
                                                </tr>
                                        @endforeach
                                    </table>
                                    <!-- <div>No. Doc : <span id="noDoc"></span></div>
                                    <div>Date : <span id="tglDoc"></span></div> -->
                                </div>
                                <div class="card col-md-6 print-col">
                                    <div class="card-body w-full">
                                        <h5 class="card-title">Requestor</h5>
                                        <div class="mb-1">
                                            <label class="form-label" for="inputDepartment">Department</label>
                                            <input type="text" class="form-control input-text"  placeholder="" id="inputDepartment" name="inputDepartment" disabled value="{{ $data['department'] }}">
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="inputProject">Project / Site</label>
                                            <input type="text" class="form-control input-text"  placeholder="" id="inputProject" name="inputProject" disabled value="{{ $data['project'] }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-6 print-col-6">
                                    <div class="card-body w-full">
                                        <h5 class="card-title">Asset Allocation</h5>
                                        <div class="mb-1">
                                            <label class="form-label" for="inputDepartmentAllocation">Department</label>
                                            <input type="text" class="form-control input-text"  placeholder="" id="inputDepartmentAllocation" name="inputDepartmentAllocation" disabled value="{{ $data['department_allocation'] }}">
                                        </div>
                                        <div class="mb-1">
                                            <label class="form-label" for="inputProjectAllocation">Project / Site</label>
                                            <input type="text" class="form-control input-text"  placeholder="" id="inputProjectAllocation" name="inputProjectAllocation" disabled value="{{ $data['project_allocation'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="my-3">
                            <div class="mb-1 row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="reasonpurchase">1. Reason Purchase</label>
                                        <input type="text" class="form-control input-text"  placeholder="" id="reasonpurchase" name="reasonpurchase" disabled value="{{ $data['reason_purchase'] }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td>Nama File</td>
                                                <td>Link</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendukung_reason as $dokumen_reason)
                                                <tr>
                                                    <td>{{ $dokumen_reason->file_name }}</td>
                                                    <td><a href="/bss-form/sm/asset-request-download/{{ $dokumen_reason->lokasi }}">Download</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-1">
                                <div class="input-group input-group-static mb-4">
                                    <label for="estimatedReadyAtSite">2. Estimated Ready at Site</label>
                                    <input type="text" class="form-control" id="estimatedReadyAtSite" name="estimatedReadyAtSite" disabled value="{{ $data['estimated_ready_at_site']  }}">
                                </div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">3. Item</label>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="item-asset" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="type">Type</th>
                                        <th data-field="model">Model</th>
                                        <th data-field="brand">Brand</th>
                                        <th data-field="condition">Condition</th>
                                        <th data-field="qty">Qty</th>
                                        <th data-field="uom">UOM</th>
                                        <th data-field="currency">Currency</th>
                                        <th data-field="price" data-formatter="priceFormatter">Price</th>
                                        <th data-formatter="totalHarga">Total Price</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="my-3 row">
                            <div class="mb-1 col-6">
                                <label class="form-label">4. Total Price (IDR)</label>
                                <span id="totalPrice">-</span>
                            </div>
                            <div class="col-4 offset-2">
                                <table>
                                    <tr>
                                        <td>IDR</td>
                                        <td> : </td>
                                        <td id="calculatedIdr"></td>
                                    </tr>
                                    <tr>
                                        <td>USD</td>
                                        <td> : </td>
                                        <td id="calculatedUsd"></td>
                                    </tr>
                                    <tr>
                                        <td>CNY</td>
                                        <td> : </td>
                                        <td id="calculatedCny"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="ml-16px">
                            <span>Estimated kurs (Budget)</span>
                            <table>
                                <tr>
                                    <td>IDR</td>
                                    <td class="reset-border">
                                        <div class="mb-1">
                                            <input type="text" class="form-control input-text"  placeholder="" id="estimatedIdr" name="estimatedIdr" value="{{ number_format( (int) $data['estimated_idr'] , 0, '', '.') }}" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>USD</td>
                                    <td>
                                        <div class="mb-1">
                                            <input type="text" class="form-control input-text"  placeholder="" id="estimatedUsd" name="estimatedUsd" value="{{ number_format( (int) $data['estimated_usd'] , 0, '', '.') }}" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CNY</td>
                                    <td>
                                        <div class="mb-1">
                                            <input type="text" class="form-control input-text"  placeholder="" id="estimatedCny" name="estimatedCny" value="{{ number_format( (int) $data['estimated_cny'] , 0, '', '.')}}" disabled>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="my-3 row">
                            <label class="form-label">5. Budget</label>
                            <div class="mb-1 col-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="inputPrice">Ref Doc</label>
                                    <input type="text" class="form-control" id="refDoc" name="refDoc" disabled value="{{ $data['ref_doc'] }}">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-1"></div>
                            <div class="col-2">
                                Requested By
                            </div>
                            <div class="col-4 text-center">
                                Acknowledge By
                            </div>
                            <div class="col-4 text-center">
                                Approved By
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-2">
                                Ka Si Dept
                            </div>
                            <div class="col-2 text-center">
                                Ka Dept
                            </div>
                            <div class="col-2 text-center">
                                Ka Dept SM
                            </div>
                            <div class="col-2 text-center">
                                Think Tank
                            </div>
                            <div class="col-2 text-center">
                                Direktur
                            </div>
                            <div class="col-1"></div>
                        </div> -->
                        <span style="display: none;" id="requestornik">{{ session('user_id') }}</span>
                    </form>
                    
                    <div>
                        <table class="only-print print-nature print-border">
                            <tbody>
                                <tr>
                                    <td rowspan="3" style="vertical-align: top"><h5>Nature</h5></td>
                                </tr>
                                <tr>
                                    <td><input class="" type="checkbox" disabled {{$data['replacement']}}> Replacement </td>
                                    <td><input class="" type="checkbox" disabled {{$data['budgeted']}}> Budgeted</td>
                                </tr>
                                <tr>
                                    <td><input class="" type="checkbox" disabled {{$data['additional']}}> Additonal</td>
                                    <td><input class="" type="checkbox" disabled {{$data['not_budgeted']}}> Not Budgeted</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="only-print print-nature print-border">
                            <tbody>
                                <tr>
                                    <td colspan="1"><h5>Requestor</h5></td>
                                    <td colspan="1"><h5>Asset Allocation</h5></td>
                                </tr>
                                <tr>
                                    <td>Department : {{$data['department']}}</td>
                                    <td>Department : {{$data['department_allocation']}}</td>
                                </tr>
                                <tr>
                                    <td>Project / Site : {{$data['project']}}</td>
                                    <td>Project / Site : {{$data['project_allocation']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="only-print print-w-full print-nature print-mt-2">
                            <tbody>
                                <tr>
                                    <td><h5>1. Reason Purchase</h5></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid black">{{$data['reason_purchase']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if(count($pendukung_reason) > 0)
                        <table class="only-print print-w-full print-nature print-mt-2">
                            <thead>
                                <tr style="border-bottom: 1px solid black">
                                    <td><h6>Nama File</h6></td>
                                    <td><h6>Link</h6></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendukung_reason as $dokumen_reason)
                                    <tr style="border-bottom: 1px solid black;">
                                        <td>{{ $dokumen_reason->file_name }}</td>
                                        <td class="dokumen_reason_file" style="color: rgb(31, 104, 187)">/bss-form/sm/asset-request-download/{{ $dokumen_reason->lokasi }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div class="only-print print-w-full print-nature print-mt-2">
                            <h5 style="display: inline;">2. Estimated Ready at Site : </h5>
                            <span id="estimated-print">{{ $data['estimated_ready_at_site'] }}</span>
                        </div>
                        <div class="only-print print-w-full print-nature print-mt-2">
                            <h5>3. Item</h5>
                            <table class="table-print" style="width:100%;font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="type">Type</th>
                                        <th data-field="model">Model</th>
                                        <th data-field="brand">Brand</th>
                                        <th data-field="condition">Condition</th>
                                        <th data-field="qty">Qty</th>
                                        <th data-field="uom">UOM</th>
                                        <th data-field="currency">Currency</th>
                                        <th data-field="price">Price</th>
                                        <th data-formatter="totalHarga">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $item)
                                        <tr>
                                            <td style="vertical-align: top">{{ $item->nomor }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->model }}</td>
                                            <td>{{ $item->brand }}</td>
                                            <td>{{ $item->condition }}</td>
                                            <td style="text-align: center">{{ $item->qty }}</td>
                                            <td>{{ $item->uom }}</td>
                                            <td style="text-align: center">{{ $item->currency }}</td>
                                            <td style="text-align: right">{{ number_format( $item->price , 0, '', '.') }}</td>
                                            <td style="text-align: right">{{ number_format( ((float) $item->qty * (float) $item->price) , 0, '', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            {{-- <table class="table table-bordered" style="font-size: 10px;">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="type">Type</th>
                                        <th data-field="model">Model</th>
                                        <th data-field="brand">Brand</th>
                                        <th data-field="condition">Condition</th>
                                        <th data-field="qty">Qty</th>
                                        <th data-field="uom">UOM</th>
                                        <th data-field="currency">Currency</th>
                                        <th data-field="price">Price</th>
                                        <th data-formatter="totalHarga">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $item)
                                        <tr>
                                            <td>{{ $item->nomor }}</td>
                                            <td>{{ $item->type }}</td>
                                            <td>{{ $item->model }}</td>
                                            <td>{{ $item->brand }}</td>
                                            <td>{{ $item->condition }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->uom }}</td>
                                            <td>{{ $item->currency }}</td>
                                            <td>{{ $item->price }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                        <div class="only-print print-w-full print-nature print-mt-2 print-flex">
                            <div class="mb-1 col-6">
                                <label class="form-label"><h5>4. Total Price (IDR) : </h5></label>
                                <span id="totalPricePrint">-</span>
                            </div>
                            <div class="col-4 offset-2">
                                <table style="font-size: 12px">
                                    <tr>
                                        <td>IDR</td>
                                        <td> : </td>
                                        <td id="calculatedIdrPrint"></td>
                                    </tr>
                                    <tr>
                                        <td>USD</td>
                                        <td> : </td>
                                        <td id="calculatedUsdPrint"></td>
                                    </tr>
                                    <tr>
                                        <td>CNY</td>
                                        <td> : </td>
                                        <td id="calculatedCnyPrint"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="only-print print-w-full print-nature print-mt-2">
                            <h5>5. Budget</h5>
                            <span>Ref Doc : {{ $data['ref_doc'] }}</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="table-responsive">
                            <table class="display print-font-size" style="width: 100%;text-align: center">
                                <thead>
                                    <tr>
                                        <th>Requested By</th>
                                        <th colspan="3">Acknowledge By</th>
                                        @if($approval_status->approved_by_1_nik != null || $approval_status->approved_by_2_nik != null)
                                            <th colspan="{{ $approval_status->approved_by_2_nik == null ? 1 : 2}}">Approved By</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$approval_status->requested_by}}</td>
                                        @if($approval_status->acknowledge_by_1_nik)
                                            <td>{{$approval_status->acknowledge_by_1_nik}}</td>
                                        @endif
                                        @if($approval_status->cost_control_nik)
                                            <td>{{$approval_status->cost_control_nik}}</td>
                                        @endif
                                        @if($approval_status->acknowledge_by_2_nik)
                                            <td>{{$approval_status->acknowledge_by_2_nik}}</td>
                                        @endif
                                        @if($approval_status->approved_by_1_nik)
                                            <td>{{$approval_status->approved_by_1_nik}}</td>
                                        @endif
                                        @if($approval_status->approved_by_2_nik)
                                            <td>{{$approval_status->approved_by_2_nik}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Done</td>
                                        @if($approval_status->acknowledge_by_1_nik)
                                            <td>{{$approval_status->acknowledge_1 == 1 ? "Done" : ($approval_status->acknowledge_1 == -1 ? "Rejected" : "Not Yet")}}</td>
                                        @endif
                                        @if($approval_status->cost_control_nik)
                                            <td>{{$approval_status->cost_control == 1 ? "Done" : ($approval_status->cost_control == -1 ? "Rejected" : "Not Yet")}}</td>
                                        @endif
                                        @if($approval_status->acknowledge_by_2_nik)
                                            <td>{{$approval_status->acknowledge_2 == 1 ? "Done" : ($approval_status->acknowledge_2 == -1 ? "Rejected" : "Not Yet")}}</td>
                                        @endif
                                        @if($approval_status->approved_by_1_nik)
                                            <td>{{$approval_status->approved_1 == 1 ? "Done" : ($approval_status->approved_1 == -1 ? "Rejected" : "Not Yet")}}</td>
                                        @endif
                                        @if($approval_status->approved_by_2_nik)
                                            <td>{{$approval_status->approved_2 == 1 ? "Done" : ($approval_status->approved_2 == -1 ? "Rejected" : "Not Yet")}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$approval_status->requested_by_nama}}</td>
                                        @if($approval_status->acknowledge_by_1_nik)
                                            <td>{{$approval_status->acknowledge_by_1_nama}}</td>
                                        @endif
                                        @if($approval_status->cost_control_nik)
                                            <td>{{$approval_status->cost_control_nama}}</td>
                                        @endif
                                        @if($approval_status->acknowledge_by_2_nik)
                                            <td>{{$approval_status->acknowledge_by_2_nama}}</td>
                                        @endif
                                        @if($approval_status->approved_by_1_nik)
                                            <td>{{$approval_status->approved_by_1_nama}}</td>
                                        @endif
                                        @if($approval_status->approved_by_2_nik)
                                            <td>{{$approval_status->approved_by_2_nama}}</td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <div>
                                @if($data['status'] == 0 || $data['status'] == null)
                                    {{-- hanya bisa di validasi ketika sudah acknowledge oleh kedua PIC --}}
                                    {{-- update status ke 1 setelah validated oleh kedua PIC --}}
                                    @if($data['acknowledge_1'] == 0 || $data['acknowledge_1'] == null)
                                        @if(session('user_id') == $data['acknowledge_by_1_nik'])
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="1" data-action="acknowledge1"
                                                data-alert-title="Acknowledge" data-alert-message="Konfirmasi acknowledge ?">
                                                <i class="fas fa-save"></i>
                                                Acknowledge
                                            </button>
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="-1" data-action="acknowledge1"
                                                data-alert-title="Reject" data-alert-message="Konfirmasi acknowledge ?">
                                                <i class="fas fa-circle-minus"></i>
                                                Reject
                                            </button>
                                        @endif
                                    @endif
                                    @if(($data['cost_control'] == 0 || $data['cost_control'] == null) && $data['acknowledge_1'] == 1)
                                        @if(session('user_id') == $data['cost_control_nik'])
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="1" data-action="cost_control"
                                                data-alert-title="Acknowledge" data-alert-message="Konfirmasi acknowledge ?">
                                                <i class="fas fa-circle-minus"></i>
                                                Acknowledge
                                            </button>
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="-1" data-action="cost_control"
                                                data-alert-title="Reject" data-alert-message="Konfirmasi acknowledge ?">
                                                <i class="fas fa-circle-minus"></i>
                                                Reject
                                            </button>
                                        @endif
                                    @endif
                                    @if(($data['acknowledge_2'] == 0 || $data['acknowledge_2'] == null) && $data['cost_control'] == 1)
                                        @if(session('user_id') == $data['acknowledge_by_2_nik'])
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="1" data-action="acknowledge2"
                                                data-alert-title="Acknowledge" data-alert-message="Konfirmasi acknowledge ?">
                                                <i class="fas fa-save"></i>
                                                Acknowledge
                                            </button>
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="-1" data-action="acknowledge2"
                                                data-alert-title="Reject" data-alert-message="Konfirmasi acknowledge ?">
                                                <i class="fas fa-circle-minus"></i>
                                                Reject
                                            </button>
                                        @endif
                                    @endif
                                    @if(($data['approved_1'] == 0 || $data['approved_1'] == null) && $data['acknowledge_2'] == 1)
                                        @if(session('user_id') == $data['approved_by_1_nik'])
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="1" data-action="approve1"
                                                data-alert-title="Approve" data-alert-message="Konfirmasi approve ?">
                                                <i class="fas fa-save"></i>
                                                Approve
                                            </button>
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="-1" data-action="approve1"
                                                data-alert-title="Reject" data-alert-message="Konfirmasi reject ?">
                                                <i class="fas fa-save fa-circle-minus"></i>
                                                Reject
                                            </button>
                                        @endif
                                    @endif
                                    @if(($data['approved_2'] == 0 || $data['approved_2'] == null) && $data['approved_1'] == 1)
                                        @if(session('user_id') == $data['approved_by_2_nik'])
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="1" data-action="approve2"
                                                data-alert-title="Approve" data-alert-message="Konfirmasi approve ?">
                                                <i class="fas fa-save"></i>
                                                Approve
                                            </button>
                                            <button onclick="actionValidation(this)" class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-nilai="-1" data-action="approve2"
                                                data-alert-title="Reject" data-alert-message="Konfirmasi Reject ?">
                                                <i class="fas fa-circle-minus"></i>
                                                Reject
                                            </button>
                                        @endif
                                    @endif
                                @endif
                                @if($data['status'] == 1 && $is_user_sm)
                                    {{-- TODO : hanya SM --}}
                                    <button onclick="actionValidation(this)" class="btn btn-primary uploadBtn" id="btnSubmitAssetRequest" data-nilai="2" data-action="proses"
                                        data-alert-title="Proses Request" data-alert-message="Konfirmasi approve request ?">
                                        <i class="fas fa-save"></i>
                                        Proses
                                    </button>
                                @endif
                                {{-- @if($data['status'] == 2 && $is_user_sm)
                                    <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest" data-action="selesai"
                                        data-alert-title="Selesai" data-alert-message="Request asset telah selesai ?">
                                        <i class="fas fa-save"></i>
                                        Selesai
                                    </button>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        function cetak(e) {
            window.print();
        }
        var tglNow = new Date()
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_romawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        var checkReplacement = $("#checkReplacement")[0];
        var checkAdditional = $("#checkAdditional")[0];
        var checkBudgeted = $("#checkBudgeted")[0];
        var checkNotBudgeted = $("#checkNotBudgeted")[0];
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var btnSubmitAssetRequest = $("#btnSubmitAssetRequest");
        var $table = $("#item-asset");
        var $buttonTambah = $("#btn-add-item")
        var inputType = $("#inputType")
        var inputArea = $("#inputArea")
        var inputProject = $("#inputProject")
        var inputDepartment = $("#inputDepartment")
        var reasonpurchase = $("#reasonpurchase")
        var estimatedReadyAtSite = $("#estimatedReadyAtSite")
        var inputModel = $("#inputModel")
        var inputBrand = $("#inputBrand")
        var inputCondition = $("#inputCondition")
        var inputQty = $("#inputQty")
        var inputUom = $("#inputUom")
        var inputCurrency = $("#inputCurrency")
        var inputPrice = $("#inputPrice")
        var calculatedIdr = $("#calculatedIdr")
        var calculatedUsd = $("#calculatedUsd")
        var calculatedCny = $("#calculatedCny")
        var estimatedIdr = $("#estimatedIdr")
        var estimatedUsd = $("#estimatedUsd")
        var estimatedCny = $("#estimatedCny")
        var totalPrice = $("#totalPrice")
        var refDoc = $("#refDoc")
        // var requestor = $("#requestor")
        var requestornik = $("#requestornik")
        var dataAssetRequest = {
            formName: "Asset Request",
            noDok: "BSS-FRM-SM-016",
            tglDok: "01-01-2023",
            noDoc: "",
            tglDoc: "",
            replacement: false,
            additional: false,
            budgeted: false,
            notBudgeted: false,
            department: "",
            project: "",
            area: "",
            reasonForPurchase: "",
            estimatedReadyAtSite: "",
            item: [{}],
            estimatedIDR: 0,
            estimatedUSD: 0,
            estimatedCNY: 0,
            refDoc: "",
            requestedBy: requestornik.text()
        }

        function formatRupiah(angka) {
            const rupiah = angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return rupiah;
        }

        function indexFormatter(value, row, index) {
            return index + 1;
        }
        
        function priceFormatter(value, row, index) {
            return formatRupiah(parseInt(value))
        }

        function totalHarga(value, row, index) {
            return formatRupiah(row.qty * row.price);
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-AR/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
        }

        function validateInput() {

        }

        function calculateTotalPrice(e) {
            var total = (estimatedIdr.val() * calculatedIdr.text()) + (estimatedUsd.val() * calculatedUsd.text()) + (estimatedCny.val() * calculatedCny.text());

            return total
        }

        $table.on('post-body.bs.table', function(data) {
            var idr = 0;
            var usd = 0;
            var cny = 0;
            var items = [];
            data.sender.data.forEach(function (item, index, arr) {
                // console.log(item)
                if(item.currency == "IDR") {
                    idr = idr + parseInt(item.price) * item.qty
                }
                if(item.currency == "USD") {
                    usd = usd + parseInt(item.price) * item.qty
                }
                if(item.currency == "CNY") {
                    cny = cny + parseInt(item.price) * item.qty
                }
                item.no = index;
                items.push(item)
            })
            dataAssetRequest.item = items
            calculatedIdr.text(formatRupiah(idr))
            calculatedUsd.text(formatRupiah(usd))
            calculatedCny.text(formatRupiah(cny))
            $("#calculatedIdrPrint").text(formatRupiah(idr))
            $("#calculatedUsdPrint").text(formatRupiah(usd))
            $("#calculatedCnyPrint").text(formatRupiah(cny))
            // console.log("estimatedIdr : ", estimatedIdr.val())
            totalPrice.text(formatRupiah((parseInt(estimatedIdr.val()) * idr) + (parseInt(estimatedUsd.val()) * usd) + (parseInt(estimatedCny.val())) * cny) || "-")
            $("#totalPricePrint").text(formatRupiah((parseInt(estimatedIdr.val()) * idr) + (parseInt(estimatedUsd.val()) * usd) + (parseInt(estimatedCny.val()) * cny))|| "-")
            // console.log("IDR = ", idr)
        })
        var detial = {{ Illuminate\Support\Js::from($detail) }}
        var isError = {
            error: {{ Illuminate\Support\Js::from($error) }},
            errorMessage: {{ Illuminate\Support\Js::from($errorMessage) }}
        }
        // document.getElementById("btnSubmitAssetRequest").addEventListener("click", function(e) {
        function actionValidation(e) {
            var validationValue = e.getAttribute('data-nilai')
            // console.log(e.getAttribute('data-alert-title'))
            Swal.fire({
                title: e.getAttribute('data-alert-title'),
                text: e.getAttribute('data-alert-message'),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, " + e.getAttribute('data-alert-title') + "!"
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/bss-form/sm/validasi-asset-request',
                        {
                            noDoc: noDoc.text(),
                            action: e.getAttribute('data-action'),
                            actionValue: validationValue
                        },
                    {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(function (response) {
                        // console.log(response.data)
                        var popMsg = {
                            icon: response.data.error ? "error" : "success",
                            title: response.data.error ? "Gagal!" : "Berhasil",
                            text: response.data.error ? response.data.errorMessage : response.data.message,
                        }
                        Swal.fire(popMsg).then((result) => {
                            // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                            window.location.reload()
                        })
                    })
                    .catch(function (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan, coba beberapa saat lagi"
                        }).then((result) => {})
                    });
                }
            });

        }
        // console.log({{ Illuminate\Support\Js::from($approval_status) }})
        $(function() {
            if(isError.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: isError.errorMessage,
                }).then((result) => {

                })
            } else {
                detial.forEach(element => {
                    $table.bootstrapTable('append', element)
                });
                dataAssetRequest.replacement = checkReplacement.checked
                dataAssetRequest.additional = checkAdditional.checked
                dataAssetRequest.budgeted = checkBudgeted.checked
                dataAssetRequest.notBudgeted = checkNotBudgeted.checked
                dataAssetRequest.area = $("#inputArea").val()
                dataAssetRequest.department = inputDepartment.val()
                dataAssetRequest.project = inputProject.val()
                dataAssetRequest.reasonForPurchase = reasonpurchase.val()

                estimatedIdr.change(function(e) {
                    totalPrice.text((estimatedIdr.val() * calculatedIdr.text()) + (estimatedUsd.val() * calculatedUsd.text()) + (estimatedCny.val() * calculatedCny.text()))
                });
                estimatedUsd.change(function(e) {

                    totalPrice.text((estimatedIdr.val() * calculatedIdr.text()) + (estimatedUsd.val() * calculatedUsd.text()) + (estimatedCny.val() * calculatedCny.text()))
                });
                estimatedCny.change(function(e) {
                    totalPrice.text((estimatedIdr.val() * calculatedIdr.text()) + (estimatedUsd.val() * calculatedUsd.text()) + (estimatedCny.val() * calculatedCny.text()))
                });
            }
        })

        function getTodayDate(tgl = new Date()) {
            const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            const year = tgl.getFullYear();
            const month = String(tgl.getMonth() + 1).padStart(2, '0');
            const day = String(tgl.getDate()).padStart(2, '0');

            return `${hari[tgl.getDay()]}, ${day} ${bulan[tgl.getMonth()]} ${year}`;
        }

        let dokumenReasonFile = document.getElementsByClassName("dokumen_reason_file")
        for (let i = 0; i < dokumenReasonFile.length; i++) {
            const element = dokumenReasonFile[i];
            element.innerText = document.location.origin + "/" + element.innerText
        }
        
        $("#estimated-print").text(getTodayDate(new Date($("#estimated-print").text())))


        // $table.bootstrapTable({
        //     data: [
        //         {
        //         id: 1,
        //         name: 'Item 1',
        //         _name_rowspan: 2,
        //         price: '$1'
        //         },
        //         {
        //         id: 2,
        //         price: '$2'
        //         }
        //     ]
        // })
    </script>
@endsection
