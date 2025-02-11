@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .w-full {
            width: 100%;
        }
        legend {
            display: block;
            width: auto;
            float: none;
        }
        fieldset {
            padding: 4px 10px 8px 10px;
            margin: 0;
            width: auto;
            border: 1px solid #cccccc;
        }
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            /* margin-bottom: 15px; */
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2.select2-container{
            width: 100%;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
        .select2-selection .select2-selection--single {
            margin-bottom: 0;
        }
        .search-input {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }
        .search-input:valid {
            border-radius: 0;
            border-bottom: 1px solid #e91e63;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
            margin-right: 12px;
        }

        .row>* {
            padding: 0;
        }
        
        .btn-action-format {
            margin: 0;
            padding: 10px 16px;
        }
        .btn-no-action:hover {
            cursor: default;
        }
        .filter-section {
            display: flex;
            width: 100%;
            justify-content: end;
            gap: 8px;
        }
        /* .page-item .page-link {
            color: #FFFFFF;
        } */
        /* .active > .page-link {
            color: #cccccc;
        } */
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
        }
        .select2-results {
            max-height: 200px; /* Batasi tinggi maksimum dropdown */
            overflow-y: auto;  /* Aktifkan scroll vertical */
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4 pb-5">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Form BA Unbudget</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <a href="{{ route('dc.unbudget.form')}}">
                    <button id="btn-add-item" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-title="Default tooltip"
                        style="border-top-left-radius: 0;border-bottom-left-radius: 0; padding-left: 16px;">
                        Buat BA Unbudget
                    </button>
                </a>

                <div class="table-responsive p-0">
                    <table id="table-data" data-toggle="table" data-side-pagination="server" data-ajax="getData"
                        data-content-type="application/json" data-data-type="json" data-pagination="true"
                        data-unique-id="id" data-header-style="headerStyle">
                        <thead>
                            <tr>
                                <th data-field="id" data-align="left" data-visible="false">ID</th>
                                <th data-field="NoDocument" data-align="left">No Document</th>
                                <th data-field="tanggal" data-align="left">Tanggal</th>
                                <th data-field="NIK" data-align="left">NIK</th>
                                <th data-field="department" data-align="left">Department</th>
                                <th data-field="status" data-align="left" data-formatter="statusFormatter">Status</th>
                                <th data-align="left" data-formatter="actionFormatter">Actions</th>
                        </thead>
                    </table>
                </div>
            </div>
            <a href=""></a>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script>
        const getDataURL = {{ Illuminate\Support\Js::from(route('dc.unbudget.form-list')) }}
        
        function getData(params) {

            $.get(getDataURL + '?' + $.param(params.data)).then(function(res) {
                console.log(res)
                if(!res.isSuccess) {
                    Swal.fire({
                        icon: "error",
                        title: 'Gagal!',
                        text: res.message
                    })
                    params.success([])

                    return 
                }
                params.success(res.data)
            })
        }

        function actionFormatter(value, row, index) {
            
            let btnInfo = `<button type="button" class="btn btn-secondary btn-action-format" onclick="aksiInfo(event, ${index})"><i class="bi bi-info-circle-fill"></i></button>`
            let btnEdit = `<button type="button" class="btn btn-info btn-action-format" onclick="aksiInfo(event, ${index})"><i class="bi bi-pencil-square"></i></button>`
            let linkAction = `<a href="/dc/unbudget/form-info?no_document=${row.NoDocument}" data-bs-toggle="tooltip" data-bs-title="Detail BA">${btnInfo}</a>`
            let linkEdit = `<a href="/dc/unbudget/form-edit?no_document=${row.NoDocument}" data-bs-toggle="tooltip" data-bs-title="Edit BA">${btnEdit}</a>`

            let action = '<div style="display: flex; gap:6px; justify-content: center;">' + linkAction + linkEdit + '</div>'
            
            return action
        }

        function statusFormatter(value, row, index) {
            if(value == 0) return `<button type="button" class="btn btn-secondary btn-action-format">On Progres Approval</button>`
            if(value == -1) return `<button type="button" class="btn btn-danger btn-action-format">Rejected</button>`
            if(value == 1) return `<button type="button" class="btn btn-success btn-action-format">Approved</button>`

            return value
        }

        function aksiInfo(event, index) {
            console.log({e: event, i: index})
        }

    </script>
@endsection