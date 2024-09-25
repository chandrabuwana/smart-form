@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link href="{{ asset('master/css/app-baf8d111.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <script src="{{ asset('master/js/app-e576488e.js') }}"></script> --}}
    {{-- @vite('resources/css/app.css') --}}
    <style>
        /* .form-control {
            border: 1px solid;
            padding: 4px;
        } */
        /* .form-control:focus {
            border: 1px solid;
        } */
        .ml-16px {
            margin-left: 16px;
        }
        .mb-8px {
            margin-bottom: 8px;
        }
        .display-block {
            display: block;
        }
        .m-0 {
            margin: 0;
        }
        .text-right {
            text-align: right;
        }
        .input-text {

            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .input-text:focus {
            border: 0;
            border-bottom: 1px solid;
            border-color: rgb(188, 188, 188);
            padding: 2px;
        }
        .reset-border {
            border: 0;
        }
        .w-full {
            width: 100%
        }
        .collapse {
            visibility: visible;
        }
        .mouse-click {
            cursor: pointer;
        }
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Form Surat Kesepakatan Lembur
                        </h6>
                    </div>
                </div>

                <div class="card-body my-1">
                    <div class="row gx-4 mb-4">
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <p class="mb-1">
                                    No. Dok : <span id="requestor" class="fw-bold ms-1">BSS-FRM-ICGS-034</span>
                                </p>
                                <p class="mb-1">
                                    Revisi : <span id="requestor" class="fw-bold ms-1">001</span>
                                </p>
                                <p class="mb-0">
                                    No : <span id="requestor" class="fw-bold ms-1">..../IC/Site/SKL/Bln_Romawi/20..</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Departement</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                        <option value="">-- Pilih Departement --</option>
                                        @foreach($departements as $item)
                                            <option value="{{ $item->KodeDP }}">{{ $item->NamaDepartement }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Site</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                        <option value="">-- Pilih Site --</option>
                                        @foreach($sites as $item)
                                            <option value="{{ $item->KodeST }}">{{ $item->Nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Tanggal Pelaksanaan</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                        <option value="">-- Pilih Site --</option>
                                        <option value="AGM">AGM</option>
                                        <option value="MBL">MBL</option>
                                        <option value="MME">MME</option>
                                        <option value="MAS">MAS</option>
                                        <option value="PMSS">PMSS</option>
                                        <option value="TAJ">TAJ</option>
                                        <option value="BSSR">BSSR</option>
                                        <option value="TDM">TDM</option>
                                        <option value="MSJ">MSJ</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="ms-0 fs-6">Shift</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-select input-text" aria-label="Default select example" id="inputSite" name="inputSite">
                                        <option value="">-- Pilih Site --</option>
                                        <option value="AGM">AGM</option>
                                        <option value="MBL">MBL</option>
                                        <option value="MME">MME</option>
                                        <option value="MAS">MAS</option>
                                        <option value="PMSS">PMSS</option>
                                        <option value="TAJ">TAJ</option>
                                        <option value="BSSR">BSSR</option>
                                        <option value="TDM">TDM</option>
                                        <option value="MSJ">MSJ</option>
                                    </select>
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    </script>
@endsection
