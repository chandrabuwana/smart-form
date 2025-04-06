@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
</style>
@endsection

@php

$master = $data['master'];
$detail = $data['detail'];
$sites = $data['sites'];
$users = $data['users'];
$plants = $data['plants'];
$uoms = $data['uoms'];
$materialTypes = $data['materialTypes'];
$materialGroups = $data['materialGroups'];
$vulationClass = $data['vulationClass'];
$purchasingGroups = $data['purchasingGroups'];
$serialNumbers = $data['serialNumbers'];

@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">DETAIL FORM BSS-FRM-LOG-002 REQUEST MASTER</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card"  style="height: 100%;">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold" style="width: 10rem">No. Doc</td>
                                                <td >{{$master->no_dok ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created By</td>
                                                <td id="requestor">{{$master->created_by ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created  Date</td>
                                                <td>{{$master->created_at ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated By</td>
                                                <td id="requestor">{{$master->updated_by ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated Date</td>
                                                <td id="requestor">{{$master->updated_at ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status</td>
                                                <td id="requestor">{{$master->status_req ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Approve/Reject Reason</td>
                                                <td id="requestor">{{$master->remark ?? '-'}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="card" style="height: 100%;">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold">Request Cataloging</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="idCataloging" name="idCataloging" disabled>
                                                        
                                                        <option value="">-- select user --</option>
                                                        @forelse($users as $catalog)
                                                            <option value="{{ $catalog->NIK ?? '' }}" {{ $master->cataloging_id == $catalog->NIK ? 'selected' : '' }}>
                                                                {{ $catalog->nama ?? 'Nama tidak tersedia' }}
                                                            </option>
                                                        @empty
                                                            <option>Data karyawan tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="fw-bold">Request Approval</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iApproval" name="iApproval" disabled>
                                                        
                                                        <option value="">-- select user --</option>
                                                        @forelse($users as $approved)
                                                            <option value="{{ $approved->NIK ?? '' }}" {{ $master->disetujui_oleh == $approved->NIK ? 'selected' : '' }}>
                                                                {{ $approved->nama ?? 'Nama tidak tersedia' }}
                                                            </option>
                                                        @empty
                                                            <option>Data karyawan tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  class="fw-bold">Site</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iSite" name="iSite" disabled>
                                                      
                                                        <option value="">-- select site --</option>
                                                        @forelse($sites as $site)
                                                            <option value="{{ $site->KodeST ?? '' }}" {{ $master->site == $site->KodeST ? 'selected' : '' }}>
                                                                {{ $site->KodeST ?? 'Site tidak tersedia' }}
                                                            </option>
                                                        @empty
                                                            <option>Data site tidak ditemukan</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Kode Plant</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iPlant" name="iPlant" disabled>
                                                        <option value="">-- select kode plant --</option>
                                                        @forelse($plants as $code => $value)
                                                            <option value="{{ $code }}" {{ $master->kode_plant == $code ? 'selected' : '' }}>
                                                                {{ $value }}
                                                            </option>
                                                        @empty
                                                            <option>Data kode plan tidak ditemukan</option>
                                                        @endforelse
        
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive mt-4">
                            <table id="item-master" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="kodeMaster">Kode Master</th>
                                        <th data-field="partName">Part Name</th>
                                        <th data-field="uom">UoM</th>
                                        <th data-field="partNumber">Part Number</th>
                                        <th data-field="brand">Brand</th>
                                        <th data-field="gen">Gen/ITC</th>
                                        <th data-field="model">Model</th>
                                        <th data-field="compartement">Compartement</th>
                                        <th data-field="fffC">FFF Class</th>
                                        <th data-field="planMatStatus">Plan Material Status</th>
                                        <th data-field="mrpType">MRP TYPE</th>
                                        <th data-field="scrap">SCRAP</th>
                                        <th data-field="matType">Material Type</th>
                                        <th data-field="matGroup">Material Group</th>
                                        <th data-field="valuationStatus">Valuation Status</th>
                                        <th data-field="purchasingGroup">Purchasing Group</th>
                                        <th data-field="serialNumber">Serial Number</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d align-items-center">
                            @if ( session('user_id') == $master->disetujui_oleh && ($master->status_req == 'OPEN' || $master->status_req == 'CLOSE') )
                                <button class="btn btn-primary ms-auto uploadBtn" style="margin:5px" id="btnApprove">
                                    <i class="fas fa-check"></i> &nbsp;
                                    Approve
                                </button>
                                <button class="btn btn-warning ms-auto uploadBtn" style="margin:5px" id="btnReject">
                                    <i class="fas fa-close"></i> &nbsp;
                                    Reject
                                </button>
                                <a href="{{url()->previous()}}" class="btn btn-secondary" style="margin:5px"><i class="fas fa-cancel"></i> &nbsp; Cancel</a>
                            @else
                                <a href="{{url()->previous()}}" class="btn btn-secondary" style="margin:5px"><i class="fas fa-cancel"></i> &nbsp; Cancel</a>
                            @endif
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
        var tglNow = new Date()
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var months_romawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

        var btnUpdateRequestMaster = $("#btnUpdateRequestMaster");
        var $table = $("#item-master");
        var $btnApprove = $("#btnApprove")
        var $btnReject = $("#btnReject")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var iApproval = $("#iApproval")
        var iSite = $("#iSite")
        var idCataloging = $("#idCataloging")
        var iPlant = $("#iPlant")
        
        // Variable items
        var iKodeMaster = $("#iKodeMaster")
        var iPartName = $("#iPartName")
        var iUom = $("#iUom")
        var iPartNumber = $("#iPartNumber")
        var iBrand = $("#iBrand")
        var iGen = $("#iGen")
        var iModel = $("#iModel")
        var iCompartemen = $("#iCompartemen")
        var iFff = $("#iFff")
        var iPlanMat = $("#iPlanMat")
        var iMrp = $("#iMrp")
        var iScrap = $("#iScrap")
        var iMatType = $("#iMatType")
        var iMatGroup = $("#iMatGroup")
        var iVal = $("#iVal")
        var iPG = $("#iPG")
        var iSerialNum = $("#iSerialNum")

        var dataRequestMaster = {
            formName: "Request Master",
            noDoc: "",
            tglDoc: "",
            site: "",
            approval: "",
            cataloging: "",
            kodePlant: "",
            item: [{}]
        }

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        tanggalSekarang.attr('min', getTodayDate())

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function formatTgl() {
            return tglNow.getDate() + "-" + months[tglNow.getMonth()] + "-" + tglNow.getFullYear();
        }

        function generateNoDoc() {
            return "_/BSS-FRM-LOG-002/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
        }

        function validateInput() {

        }

        function actionFormatter(value, row, index) {
            if (row.kodeMaster != "") {
                // return `
                //     <a class="btn btn-danger btn-sm disabled">Delete</a>
                // `;
                return '';
            } else {
                return `
                    <a class="btn btn-danger btn-sm" onclick="deleteRow(${index})">Delete</a>
                `;
                
            }
        }

        function deleteRow(id) {
            $table.bootstrapTable('remove', {
                field: '$index',
                values: [id]
            })
        }

       
        $table.on('post-body.bs.table', function(data) {
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
            dataRequestMaster.item = items
        })

        function showLoading() {
            $("body").css("overflow-y", "hidden")
            $("#loading-animation").css("display", "flex")
        }

        function stopLoading() {
            $("body").css("overflow-y", "auto")
            $("#loading-animation").css("display", "none")
        }

        $(function() {
            noDoc.text(generateNoDoc())
            tglDoc.text(formatTgl() || "-")

            dataRequestMaster.approval = iApproval.val()
            dataRequestMaster.site = iSite.val()

            var detial = {{ Illuminate\Support\Js::from($detail) }}
                console.log({{ Illuminate\Support\Js::from($data) }})
                detial.forEach(element => {
                    $table.bootstrapTable('append', element)
                });

            function validateItem() {
                var errorValidate = []

                if(iPartName.val() == "") {
                    errorValidate.push({
                        field: "Part Name",
                        message: "tidak boleh kosong"
                    })
                }
                if(iUom.val() == "") {
                    errorValidate.push({
                        field: "UoM",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPartNumber.val() == "") {
                    errorValidate.push({
                        field: "Part Number",
                        message: "tidak boleh kosong"
                    })
                }
                if(iBrand.val() == "") {
                    errorValidate.push({
                        field: "Brand",
                        message: "tidak boleh kosong"
                    })
                }
                if(iGen.val() == "") {
                    errorValidate.push({
                        field: "Gen",
                        message: "tidak boleh kosong"
                    })
                }
                if(iModel.val() == "") {
                    errorValidate.push({
                        field: "Model",
                        message: "tidak boleh kosong"
                    })
                }
                if(iCompartemen.val() == "") {
                    errorValidate.push({
                        field: "Compartement",
                        message: "tidak boleh kosong"
                    })
                }
                if(iFff.val() == "") {
                    errorValidate.push({
                        field: "FFF Class",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPlanMat.val() == "") {
                    errorValidate.push({
                        field: "Plan material",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMrp.val() == "") {
                    errorValidate.push({
                        field: "MRP",
                        message: "tidak boleh kosong"
                    })
                }
                if(iScrap.val() == "") {
                    errorValidate.push({
                        field: "Scrap",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMatType.val() == "") {
                    errorValidate.push({
                        field: "Material type",
                        message: "tidak boleh kosong"
                    })
                }
                if(iMatType.val() == "") {
                    errorValidate.push({
                        field: "Material Type",
                        message: "tidak boleh kosong"
                    })
                }
                if(iVal.val() == "") {
                    errorValidate.push({
                        field: "Valuation status",
                        message: "tidak boleh kosong"
                    })
                }
                if(iPG.val() == "") {
                    errorValidate.push({
                        field: "Purchasing Group",
                        message: "tidak boleh kosong"
                    })
                }
                if(iSerialNum.val() == "") {
                    errorValidate.push({
                        field: "Serial Number",
                        message: "tidak boleh kosong"
                    })
                }
                return errorValidate
            }

            function validateForm() {
                var errorValidate = []
                
                if(iApproval.val() == ""){
                    errorValidate.push({
                        field: "Request approval",
                        message: "Harus dipilih"
                    })
                }
                if(iSite.val() == ""){
                    errorValidate.push({
                        field: "Site",
                        message: "Harus dipilih"
                    })
                }
                if($table.bootstrapTable('getData').length < 1) {
                    errorValidate.push({
                        field: "Item",
                        message: "minimal harus ada 1"
                    })
                }

                return errorValidate
            }

            
            $btnApprove.click(function(e) {
                e.preventDefault();
                showApprovalDialog('approve');
            })

            $btnReject.click(function(e) {
                e.preventDefault();
                showApprovalDialog('reject');
            })
        
            // function showApprovalDialog(action) {
            //     const isApprove = action === 'approve';
            //     const title = isApprove ? 'Approve Document' : 'Reject Document';
            //     const confirmButtonColor = isApprove ? '#e91e63' : '#fb8c00';
            //     const confirmButtonText = isApprove ? 'Approve' : 'Reject';
                
            //     Swal.fire({
            //         title: title,
            //         html: `
            //             <div class="form-group">
            //                 <label for="swal-remark">${isApprove ? 'Optional remarks' : 'Reason for rejection (required)'}</label>
            //                 <textarea id="swal-remark" class=" form-control" style="height: 8rem !important;"
            //                     placeholder="${isApprove ? 'Add any comments...' : 'Please specify the reason...'}"
            //                     ${!isApprove ? 'required' : ''}></textarea>
            //             </div>
            //         `,
            //         icon: 'question',
            //         showCancelButton: true,
            //         confirmButtonColor: confirmButtonColor,
            //         cancelButtonColor: '#6c757d',
            //         confirmButtonText: confirmButtonText,
            //         cancelButtonText: 'Cancel',
            //         focusConfirm: false,
            //         preConfirm: () => {
            //             const remark = document.getElementById('swal-remark').value;
            //             if (!isApprove && !remark.trim()) {
            //                 Swal.showValidationMessage('Please provide a reason for rejection');
            //                 return false;
            //             }
            //             return remark;
            //         }
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             submitApprovalAction(action, result.value);
            //         }
            //     });
            // }

            function showApprovalDialog(action) {
                const isApprove = action === 'approve';
                const title = isApprove ? 'Are you sure you want to approve this document?' : 'Are you sure you want to reject this document?';
                const confirmButtonColor = isApprove ? '#e91e63' : '#fb8c00';
                const confirmButtonText = isApprove ? 'Yes, approve' : 'Yes, reject';
                
                Swal.fire({
                    title: title,
                    html: `
                        <div class="form-group">
                            <label for="swal-remark">${isApprove ? 'Optional remarks' : 'Reason for rejection (required)'}</label>
                            <textarea id="swal-remark" class="form-control" style="height: 8rem !important;"
                                placeholder="${isApprove ? 'Catatan ...' : 'Catatan ...'}"
                                ${!isApprove ? 'required' : ''}></textarea>
                            <small id="swal-remark-counter" style="font-size:small" class="text-muted float-right">0/500</small>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: confirmButtonColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Cancel',
                    focusConfirm: false,
                    didOpen: () => {
                        const remarkInput = document.getElementById('swal-remark');
                        const counter = document.getElementById('swal-remark-counter');
                        
                        remarkInput.addEventListener('input', (e) => {
                            if (e.target.value.length > 500) {
                                e.target.value = e.target.value.substring(0, 500);
                            }
                            counter.textContent = `${e.target.value.length}/500`;
                        });
                        
                        // Initialize counter
                        counter.textContent = `${remarkInput.value.length}/500`;
                    },
                    preConfirm: () => {
                        const remark = document.getElementById('swal-remark').value.trim();
                        
                        if (!isApprove && !remark) {
                            Swal.showValidationMessage('Please provide a reason for rejection');
                            return false;
                        }
                        
                        return remark;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitApprovalAction(action, result.value);
                    }
                });
            }
            
            
            function submitApprovalAction(action, remark) {
                showLoading();
                
                var dataReq = {
                    id: "{{$master->id}}",
                    noDoc: "{{ $master->no_dok }}",
                    disetujuiOleh: "{{ session('user_id') }}",
                    action: action,
                    remark: remark || null
                };

                let formData = new FormData();
                formData.append('item', JSON.stringify(dataRequestMaster.item));
                for (const key in dataReq) {
                    if(key != "item") {
                        formData.append(key, dataReq[key]);
                    }
                }

                axios.post('/bss-form/log/approve-reject-request-master', formData, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    }).then((result) => {
                        window.location.href = `/bss-form/log/request-master`;
                    });
                })
                .catch(function(error) {
                    console.error(error);
                    let errorMessage = error.response?.data?.message || 'An error occurred';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                    });
                })
                .finally(function() {
                    stopLoading();
                });
            }
        })
    </script>
@endsection