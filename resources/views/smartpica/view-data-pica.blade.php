@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://unpkg.com/treeflex/dist/css/treeflex.css">
    <style>
        .scrollable-div {
            width: 100%;
            height: 400px;
            overflow: auto;
            position: relative;
        }

        fieldset {
            border: 2px solid #ddd;
            /* Border for the fieldset */
            padding: 1.5em;
            /* Padding inside the fieldset */
            margin-bottom: 1.5em;
            /* Margin below the fieldset */
            position: relative;
            /* Position relative to handle absolute positioned legend */
        }

        legend {
            font-size: 1.25em;
            /* Font size for the legend */
            font-weight: bold;
            /* Make the legend text bold */
            padding: 0 10px;
            /* Padding to give some space on left and right */
            background-color: white;
            /* Background color to match the page's background */
            position: absolute;
            /* Position the legend absolutely */
            top: -1em;
            /* Move it up above the border */
            left: 10px;
            /* Adjust left position */
        }

        .zoomable-content {
            transform-origin: 0 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form PICA</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Creator : {{ $dataMaster->nama_karyawan }}
                                    {{-- session()->get('name') . ' - ' . session()->get('dept') . ' - ' . session()->get('site') --}}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center"
                                            aria-selected="true">
                                            <i class="fas fa-key"> No Document : </i>
                                            <span class="ms-2">{{ $dataMaster->nodocpica }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr class="horizontal dark my-sm-3">
                    <input type="hidden" name="pc_no" value="1">
                    <div class="card-body">
                        <div class="row" id="tabel_tambah">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_thn" class="ms-0">Tahun </label>
                                        <select class="form-control" name="pc_thn" id="pc_thn" disabled>
                                            <option value="">{{ $dataMaster->tahun }}</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_bln" class="ms-0">Bulan </label>
                                        <select class="form-control" name="pc_bln" disabled id="pc_bln">
                                            <option value="">{{ $dataMaster->bulan }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_week" class="ms-0">Week </label>
                                        <select class="form-control" name="pc_week" disabled id="pc_week" disabled>
                                            <option value="">{{ $dataMaster->week }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_site" class="ms-0">Site </label>
                                        <select class="form-control dept" name="pc_site" id="pc_site">
                                            <option value="">{{ $dataMaster->nama_site }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_kpi" class="ms-0">Leading KPI </label>
                                        <select class="form-control s2lea" name="pc_kpi" id="pc_kpi" disabled>
                                            <option value="">{{ $dataMaster->lea_name }}</option>
                                        </select>
                                        <small class="text-danger">Actual & Target hanya bisa diisi dengan angka dan titik
                                            (.)
                                            <i class="fas fa-arrow-right"></i></small>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_aktual" class="ms-0">Actual</label>
                                        <input class="form-control" type="text" disabled
                                            inputmode="decimal"value="{{ $dataMaster->actual_master }}" name="pc_aktual"
                                            id="pc_aktual">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="pc_target">Target</label>
                                        <input class="form-control" type="text" inputmode="decimal" id="pc_target"
                                            disabled value="{{ $dataMaster->target_master }}" name="pc_target">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="pc_ap_pica">AP/PICA</label>
                                        <select class="form-control" name="pc_ap_pica" disabled>
                                            <option value="">{{ $dataMaster->ap_pica == 'pc' ? 'PICA' : 'AP' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group input-group-static my-4">
                                        <label for="pc_problem" class="ms-0">Problem Statement </label>
                                        <textarea class="form-control" name="pc_problem" id="pc_problem" rows="3" disabled>{{ $dataMaster->problem }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static my-4">
                                        <label class="ms-0" for="pc_kp">Kategori Problem </label>
                                        <select class="form-control" name="pc_kp" id="pc_kp" disabled>
                                            <option value="">{{ $dataMaster->id_kategory }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="container-fluid">
                                <div class="scrollable-div border" id="scrollableDiv">
                                    <div class="zoomable-content" id="zoomableContent">
                                        <!-- Add your large content here -->
                                        <div style="width: 100000px; height: 1500px;" id="dataWHYYYYY">
                                            <div class="tf-tree tf-gap-lg" style="padding-top: 100px">
                                                <ul id="tree-container" style="margin: 20px">
                                                    @foreach ($dataPicaW1 as $key => $w1)
                                                        <li>
                                                            <span class="tf-nc" style="width:20vw">
                                                                <legend style="width: auto">Why 1 - {{$key+1}}</legend>
                                                                <div class="row">
                                                                    <div class="col-12 my-2">
                                                                        <div class="row">
                                                                            <div class="col-4">Kategori </div>
                                                                            <div class="col">: {{$w1->kp_name}}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div
                                                                            class="input-group input-group-static">
                                                                            <label
                                                                                for="input-why">-- WHY -- </label>
                                                                            <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $w1->why }}</textarea>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </span>
                                                            @if (count($dataPicaW2) > 0)
                                                                <ul>
                                                                    @foreach ($dataPicaW2 as $i=>$w2)
                                                                        @if ($w1->index_w1 == $w2->index_w1)
                                                                            <li>
                                                                                <span class="tf-nc">
                                                                                    <legend style="width: auto">Why 2 - {{$i + 1}}</legend>
                                                                                        <div class="row">
                                                                                            <div class="col-12 my-2">
                                                                                                <div class="row">
                                                                                                    <div class="col-4">Kategori </div>
                                                                                                    <div class="col">: {{$w2->kp_name}}</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <div class="row">
                                                                                                    <div
                                                                                                    class="input-group input-group-static">
                                                                                                    <label
                                                                                                        for="input-why">-- WHY -- </label>
                                                                                                    <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $w2->why }}</textarea>
                                                                                                </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                </span>
                                                                                @if (count($dataPicaW3) > 0)
                                                                                    <ul>
                                                                                        @foreach ($dataPicaW3 as $j=>$w3)
                                                                                            @if ($w2->index_w1 == $w3->index_w1 && $w2->index_w2 == $w3->index_w2)
                                                                                                <li>
                                                                                                    <span class="tf-nc">
                                                                                                        <legend style="width: auto">Why 3 - {{$j+1}}</legend>
                                                                                                        <div class="row">
                                                                                                            <div class="col-12 my-2">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-4">Kategori </div>
                                                                                                                    <div class="col">: {{$w3->kp_name}}</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-12">
                                                                                                                <div class="row">
                                                                                                                    <div
                                                                                                                    class="input-group input-group-static">
                                                                                                                    <label
                                                                                                                        for="input-why">-- WHY -- </label>
                                                                                                                    <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $w3->why }}</textarea>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </span>
                                                                                                    @if (count($dataPicaW4) > 0)
                                                                                                        <ul>
                                                                                                            @foreach ($dataPicaW4 as $k=>$w4)
                                                                                                                @if ($w3->index_w1 == $w4->index_w1 && $w3->index_w2 == $w4->index_w2 && $w3->index_w3 == $w4->index_w3)
                                                                                                                    <li>
                                                                                                                        <span
                                                                                                                            class="tf-nc">
                                                                                                                            <legend style="width: auto">Why 4 - {{$k +1}}</legend>
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-12 my-2">
                                                                                                                                    <div class="row">
                                                                                                                                        <div class="col-4">Kategori </div>
                                                                                                                                        <div class="col">: {{$w4->kp_name}}</div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="row">
                                                                                                                                <div class="col-12">
                                                                                                                                    <div class="row">
                                                                                                                                        <div
                                                                                                                                        class="input-group input-group-static">
                                                                                                                                        <label
                                                                                                                                            for="input-why">-- WHY -- </label>
                                                                                                                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $w4->why }}</textarea>
                                                                                                                                    </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </span>
                                                                                                                        @if (count($dataPicaW5) > 0)
                                                                                                                            <ul>
                                                                                                                                @foreach ($dataPicaW5 as $l=>$w5)
                                                                                                                                    @if (
                                                                                                                                        $w4->index_w1 == $w5->index_w1 &&
                                                                                                                                            $w4->index_w2 == $w5->index_w2 &&
                                                                                                                                            $w4->index_w3 == $w5->index_w3 &&
                                                                                                                                            $w4->index_w4 == $w5->index_w4)
                                                                                                                                        <li>
                                                                                                                                            <span
                                                                                                                                                class="tf-nc">
                                                                                                                                                <legend style="width: auto">Why 5 - {{$l+1}}</legend>
                                                                                                                                                <div class="row">
                                                                                                                                                    <div class="col-12 my-2">
                                                                                                                                                        <div class="row">
                                                                                                                                                            <div class="col-4">Kategori </div>
                                                                                                                                                            <div class="col">: {{$w5->kp_name}}</div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <div class="row">
                                                                                                                                                    <div class="col-12">
                                                                                                                                                        <div class="row">
                                                                                                                                                            <div
                                                                                                                                                            class="input-group input-group-static">
                                                                                                                                                            <label
                                                                                                                                                                for="input-why">-- WHY -- </label>
                                                                                                                                                            <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $w5->why }}</textarea>
                                                                                                                                                        </div>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </span>
                                                                                                                                            <ul>
                                                                                                                                                @foreach ($solution as $item)
                                                                                                                                                    @if ($item->identity_why == $w5->identity && $item->position_why == $w5->id)
                                                                                                                                                        <li>
                                                                                                                                                            <span class="tf-nc" style="width: 20vw">
                                                                                                                                                                <legend
                                                                                                                                                                    style="width: auto">
                                                                                                                                                                    Solution : {{$item->action}}
                                                                                                                                                                </legend>
                                                                                                                                                                <div class="row">
                                                                                                                                                                    <div class="col-12">
                                                                                                                                                                        <div class="row">
                                                                                                                                                                            <div class="col-4">Nama</div>
                                                                                                                                                                            <div class="col">: {{$item->nama_pic}}</div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="row">
                                                                                                                                                                    <div class="col-12">
                                                                                                                                                                        <div class="row">
                                                                                                                                                                            <div class="col-4">Department</div>
                                                                                                                                                                            <div class="col">: {{$item->dic}}</div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="row">
                                                                                                                                                                    <div class="col-12">
                                                                                                                                                                        <div class="row">
                                                                                                                                                                            <div class="col-4">Due Date</div>
                                                                                                                                                                            <div class="col">: {{$item->due_date}}</div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                                <div class="row">
                                                                                                                                                                    <div class="col-12">
                                                                                                                                                                        <div class="row" style="margin-top: 10px">
                                                                                                                                                                            <div
                                                                                                                                                                            class="input-group input-group-static">
                                                                                                                                                                            <label
                                                                                                                                                                                for="input-why">-- Note -- </label>
                                                                                                                                                                            <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $item->note_step }}</textarea>
                                                                                                                                                                        </div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>
                                                                                                                                                            </span>
                                                                                                                                                        </li>
                                                                                                                                                    @endif
                                                                                                                                                @endforeach
                                                                                                                                            </ul>
                                                                                                                                        </li>
                                                                                                                                    @endif
                                                                                                                                @endforeach
                                                                                                                                @foreach ($solution as $item)
                                                                                                                                @if ($item->identity_why == $w4->identity && $item->position_why == $w4->id)
                                                                                                                                    <li>
                                                                                                                                        <span class="tf-nc" style="width: 20vw">
                                                                                                                                            <legend
                                                                                                                                                style="width: auto">
                                                                                                                                                Solution : {{$item->action}}
                                                                                                                                            </legend>
                                                                                                                                            <div class="row">
                                                                                                                                                <div class="col-12">
                                                                                                                                                    <div class="row">
                                                                                                                                                        <div class="col-4">Nama</div>
                                                                                                                                                        <div class="col">: {{$item->nama_pic}}</div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="row">
                                                                                                                                                <div class="col-12">
                                                                                                                                                    <div class="row">
                                                                                                                                                        <div class="col-4">Department</div>
                                                                                                                                                        <div class="col">: {{$item->dic}}</div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="row">
                                                                                                                                                <div class="col-12">
                                                                                                                                                    <div class="row">
                                                                                                                                                        <div class="col-4">Due Date</div>
                                                                                                                                                        <div class="col">: {{$item->due_date}}</div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                            <div class="row">
                                                                                                                                                <div class="col-12">
                                                                                                                                                    <div class="row" style="margin-top: 10px">
                                                                                                                                                        <div
                                                                                                                                                        class="input-group input-group-static">
                                                                                                                                                        <label
                                                                                                                                                            for="input-why">-- Note -- </label>
                                                                                                                                                        <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $item->note_step }}</textarea>
                                                                                                                                                    </div>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                            </div>
                                                                                                                                        </span>
                                                                                                                                    </li>
                                                                                                                                @endif
                                                                                                                                @endforeach
                                                                                                                            </ul>
                                                                                                                        @endif
                                                                                                                    </li>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                            @foreach ($solution as $item)
                                                                                                            @if ($item->identity_why == $w3->identity && $item->position_why == $w3->id)
                                                                                                                <li>
                                                                                                                    <span class="tf-nc" style="width: 20vw">
                                                                                                                        <legend
                                                                                                                            style="width: auto">
                                                                                                                            Solution : {{$item->action}}
                                                                                                                        </legend>
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-12">
                                                                                                                                <div class="row">
                                                                                                                                    <div class="col-4">Nama</div>
                                                                                                                                    <div class="col">: {{$item->nama_pic}}</div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-12">
                                                                                                                                <div class="row">
                                                                                                                                    <div class="col-4">Department</div>
                                                                                                                                    <div class="col">: {{$item->dic}}</div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-12">
                                                                                                                                <div class="row">
                                                                                                                                    <div class="col-4">Due Date</div>
                                                                                                                                    <div class="col">: {{$item->due_date}}</div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-12">
                                                                                                                                <div class="row" style="margin-top: 10px">
                                                                                                                                    <div
                                                                                                                                    class="input-group input-group-static">
                                                                                                                                    <label
                                                                                                                                        for="input-why">-- Note -- </label>
                                                                                                                                    <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $item->note_step }}</textarea>
                                                                                                                                </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </span>
                                                                                                                </li>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                        </ul>
                                                                                                    @endif
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @else
                                                                                    <ul>
                                                                                        @foreach ($solution as $item)
                                                                                            @if ($item->identity_why == $w2->identity && $item->position_why == $w2->id)
                                                                                                <li>
                                                                                                    <span class="tf-nc" style="width: 20vw">
                                                                                                        <legend
                                                                                                            style="width: auto">
                                                                                                            Solution : {{$item->action}}
                                                                                                        </legend>
                                                                                                        <div class="row">
                                                                                                            <div class="col-12">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-4">Nama</div>
                                                                                                                    <div class="col">: {{$item->nama_pic}}</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-12">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-4">Department</div>
                                                                                                                    <div class="col">: {{$item->dic}}</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-12">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-4">Due Date</div>
                                                                                                                    <div class="col">: {{$item->due_date}}</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-12">
                                                                                                                <div class="row" style="margin-top: 10px">
                                                                                                                    <div
                                                                                                                    class="input-group input-group-static">
                                                                                                                    <label
                                                                                                                        for="input-why">-- Note -- </label>
                                                                                                                    <textarea type="textarea" id="input-why" rows="2" disabled class="form-control">{{ $item->note_step }}</textarea>
                                                                                                                </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </span>
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach

                                                                                    </ul>
                                                                                @endif

                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-static my-4">
                                <label class="form-label">Pilih Jumlah Estimasi dari Solusi Step PICA
                                    diatas</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="pc_es" id="pc_es">
                                        <option value='5'>5</option>
                                        <?php for ($i = 1; $i < 11; $i++) {
                                            echo '<option value=' . $i . '>' . $i . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary ms-auto uploadBtn" id="buttonSubmitDataPICA"
                                onclick="SubmitAllDataWhy()">
                                <i class="fas fa-save"></i>
                                Save All Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const scrollableDiv = document.getElementById('scrollableDiv');
            const zoomableContent = document.getElementById('zoomableContent');
            let scale = 1;
            const scaleStep = 0.1; // Incremental scale step

            scrollableDiv.addEventListener('wheel', (event) => {
                if (event.ctrlKey) {
                    event.preventDefault();

                    // Determine cursor position relative to zoomableContent
                    const rect = zoomableContent.getBoundingClientRect();
                    const mouseX = event.clientX - rect.left;
                    const mouseY = event.clientY - rect.top;

                    // Calculate current transformation origin
                    const currentOriginX = mouseX / rect.width;
                    const currentOriginY = mouseY / rect.height;

                    // Update scale based on scroll direction and incremental step
                    if (event.deltaY < 0) {
                        scale = Math.min(scale + scaleStep, 3); // Increase scale gradually
                    } else {
                        scale = Math.max(scale - scaleStep, 0.5); // Decrease scale gradually
                    }

                    // Calculate new transformation origin
                    const newOriginX = mouseX / rect.width;
                    const newOriginY = mouseY / rect.height;

                    // Adjust transformation origin and apply scale transform
                    zoomableContent.style.transformOrigin = `${newOriginX * 100}% ${newOriginY * 100}%`;
                    zoomableContent.style.transform = `scale(${scale})`;
                }
            });
        });
    </script>
    <script type="text/javascript">
        function SubmitAllDataWhy() {
            let getAllDataWhy1 = [];
            let isValid = true;
            let errorMessage = '';

            for (let i = 1; i <= listOFWhy1.length; i++) {
                let masalah = $(`#input-m-w1-${i}`).val();
                let kategory = $(`#input-k-w1-${i}`).val();
                let data = {
                    w1: i,
                    masalah: masalah,
                    kategori: kategory
                }
                getAllDataWhy1.push(data);

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${i} is .<br>`;
                }

                if (kategory === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${i} is .<br>`;
                }
            }

            let getAllDataWhy2 = listOFWhy2.map(item => {
                let w1 = item.w1;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-w2-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-w2-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${position} is .<br>`;
                }

                return {
                    w1: w1,
                    w2: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });

            let getAllDataWhy3 = listOFWhy3.map(item => {
                let w1 = item.w1;
                let w2 = item.w2;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-${w2}-w3-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-${w2}-w3-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${w2} W3-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${w2} W3-${position} is .<br>`;
                }

                return {
                    w1: w1,
                    w2: w2,
                    w3: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });

            let getAllDataWhy4 = listOFWhy4.map(item => {
                let w1 = item.w1;
                let w2 = item.w2;
                let w3 = item.w3;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-${w2}-${w3}-w4-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-${w2}-${w3}-w4-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage += `Masalah for W1-${w1} W2-${w2} W3-${w3} W4-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage += `Kategori for W1-${w1} W2-${w2} W3-${w3} W4-${position} is .<br>`;
                }

                return {
                    w1: w1,
                    w2: w2,
                    w3: w3,
                    w4: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });

            let getAllDataWhy5 = listOFWhy5.map(item => {
                let w1 = item.w1;
                let w2 = item.w2;
                let w3 = item.w3;
                let w4 = item.w4;
                let position = item.position;
                let masalah = $(`#input-m-${w1}-${w2}-${w3}-${w4}-w5-${position}`).val().trim();
                let kategori = $(`#input-k-${w1}-${w2}-${w3}-${w4}-w5-${position}`).val().trim();

                if (masalah === '') {
                    isValid = false;
                    errorMessage +=
                        `Masalah for W1-${w1} W2-${w2} W3-${w3} W4-${w4} W5-${position} is .<br>`;
                }

                if (kategori === '') {
                    isValid = false;
                    errorMessage +=
                        `Kategori for W1-${w1} W2-${w2} W3-${w3} W4-${w4} W5-${position} is .<br>`;
                }

                return {
                    w1: w1,
                    w2: w2,
                    w3: w3,
                    w4: w4,
                    w5: position,
                    masalah: masalah,
                    kategori: kategori
                };
            });



            let pc_thn = $('#pc_thn').val();
            let pc_bln = $('#pc_bln').val();
            let pc_week = $('#pc_week').val();
            let pc_site = $('#pc_site').val();
            let pc_kpi = $('#pc_kpi').val();
            let pc_aktual = $('#pc_aktual').val();
            let pc_target = $('#pc_target').val();
            let pc_ap_pica = $('select[name="pc_ap_pica"]').val();
            let pc_problem = $('#pc_problem').val();
            let pc_kp = $('#pc_kp').val();
            let pc_es = $('#pc_es').val();

            // Helper function to validate and highlight
            function validateField(field, fieldName, fieldLabel) {
                if (field === '') {
                    isValid = false;
                    errorMessage += `${fieldLabel} is .<br>`;
                }
            }

            validateField(pc_thn, 'pc_thn', 'Tahun');
            validateField(pc_bln, 'pc_bln', 'Bulan');
            validateField(pc_week, 'pc_week', 'Minggu');
            validateField(pc_site, 'pc_site', 'Site');
            validateField(pc_kpi, 'pc_kpi', 'KPI');
            validateField(pc_aktual, 'pc_aktual', 'Aktual');
            validateField(pc_target, 'pc_target', 'Target');
            validateField(pc_ap_pica, 'pc_ap_pica', 'AP PICA');
            validateField(pc_problem, 'pc_problem', 'Problem');
            validateField(pc_kp, 'pc_kp', 'Kategori Problem');
            validateField(pc_es, 'pc_es', 'Estimated Solution');

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessage,
                    confirmButtonText: 'OK'
                });
            }


            let dataKirim = {
                dataMaster: {
                    tahun: pc_thn,
                    bulan: pc_bln,
                    week: pc_week,
                    site: pc_site,
                    lead_kpi: pc_kpi,
                    actual: pc_aktual,
                    target: pc_target,
                    ap_pica: pc_ap_pica,
                    problem: pc_problem,
                    kategori: pc_kp,
                    estimasi_pica: pc_es,
                },
                dataWhy1: getAllDataWhy1,
                dataWhy2: getAllDataWhy2,
                dataWhy3: getAllDataWhy3,
                dataWhy4: getAllDataWhy4,
                dataWhy5: getAllDataWhy5,
            };

            $.ajax({
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/add-transaction",
                data: dataKirim,
                dataType: 'json',
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            reset();
                            window.location.href = `/add-step-smart-pica/${response.nodoc}`;
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: errorMessage,
                        confirmButtonText: 'OK'
                    });
                    console.log()
                }
            })


        }

        function reset() {
            $('#pc_thn').prop('selectedIndex', 0);

            $('#pc_bln').prop('selectedIndex', 0);

            $('#pc_week').prop('selectedIndex', 0);

            $('#pc_site').val(null).trigger('change');

            $('#pc_kpi').val(null).trigger('change');

            $('#pc_aktual').val('');

            $('#pc_target').val('');

            $('#pc_ap_pica').prop('selectedIndex', 0);

            $('#pc_problem').val('');

            $('#pc_kp').prop('selectedIndex', 0);

            let dataHTMLBaru = `
            <div class="row rw-1 " style="margin:3em; font-size:11px;">
                <div class="col cl-1 master" style="margin: 0px !important">
                    <div class="row row-cols-6 r1">
                        <div class="col-2">
                            <fieldset style="margin: 30px">
                                <legend style="width: auto">Why 1</legend>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group input-group-static my-4">
                                            <label class="ms-0" for="input-why">Why 1 - 1</label>
                                            <textarea type="textarea" id="input-why" rows="1" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group input-group-static my-4">
                                            <label for="input-kategori" class="ms-0 kategory-why">Kategori </label>
                                            <select class="form-control" name="input-kategori"  >
                                                <option value="">-- Pilih Kategori --</option>
                                                ${optionsHtml}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex justify-content-center align-items-center">
                                        <button type="button" onclick="AddWhy2(1,1)" class="btn btn-primary">Why2</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row rw-1 " style="margin:3em; font-size:11px;">
                <div class="col-5 d-flex justify-content-start align-items-left">
                    <button type="button" class="btn btn-primary" onclick="AddWhy1()">Why1</button>
                </div>
            </div>`
            listOFWhy1 = [1];
            listOFWhy2 = [];
            listOFWhy3 = [];
            listOFWhy4 = [];
            listOFWhy5 = [];
            initialWhy1 = 1;
            rowCount = 1;

            $('#dataWHYYYYY').html(dataHTMLBaru);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var targetString = "view-data-detail-pica";

            var currentUrl = window.location.href;
            if (currentUrl.includes(targetString)) {
                $("#progressPica").closest('.submenu').show();
            }

            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Replace this value with your actual numeric month value
            const numericMonth = {{ $dataMaster->bulan }};

            // Ensure the value is valid
            if (numericMonth >= 1 && numericMonth <= 12) {
                const $selectElement = $('#pc_bln');
                const $optionElement = $selectElement.find('option');
                $optionElement.text(monthNames[numericMonth - 1]);
                $optionElement.val(numericMonth); // Ensure the value attribute is set correctly
            } else {
                console.error("Invalid month value");
            }
        });
    </script>
@endsection
