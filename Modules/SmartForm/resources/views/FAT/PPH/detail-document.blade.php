@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .display-block {
            display: contents !important;
        }

        .select2-dropdown {
            overflow: scroll;
            height: 300px;
        }

        .custom-width-1 {
            width: 90%;
            /* Example width, adjust as needed */
        }


        .close-button-why {
            position: absolute;
            top: 0;
            right: 0;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background-color: black;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: translate(50%, -50%);
        }

        .close-button-why:hover {
            background-color: darkred;
        }

        .select2-container--bootstrap-5 .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            /* Menyesuaikan dengan form-control di Bootstrap 5 */
        }

        /* Menyesuaikan tinggi baris teks dalam pilihan */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px);
        }

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
                        <h6 class="text-white text-capitalize ps-3">Detail Dokumen PPH</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group input-group-static my-3">
                                <label for="pc_thn" class="ms-0">Nomor Document </label>
                                <select class="form-control" name="pc_thn" id="pc_thn" disabled required>
                                    <option value="">-- {{ $dataMaster->nodocpph }} --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-static my-3">
                                <label for="pc_nama_file" class="ms-0">Nama File </label>
                                <select class="form-control nama_file" name="pc_nama_file" id="pc_nama_file" disabled>
                                    <option value="">-- {{ $dataMaster->nama_file }} --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-static my-3">
                                <label for="pc_thn" class="ms-0">Tahun </label>
                                <select class="form-control" name="pc_thn" id="pc_thn" disabled required>
                                    <option value="">-- {{ $dataMaster->tahun }} --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-static my-3">
                                <label for="pc_bln" class="ms-0">Bulan </label>
                                <select class="form-control" name="pc_bln" id="pc_bln" disabled required>
                                    <option value="">-- {{ $dataMaster->nama_bulan }} --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group input-group-static my-3">
                                <label for="pc_site" class="ms-0">Site </label>
                                <select class="form-control site" name="pc_site" id="pc_site" disabled>
                                    <option value="">-- {{ $dataMaster->tsite }} --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <iframe src="{{ $docUrl }}" frameborder="0" width="100%" height="800px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
