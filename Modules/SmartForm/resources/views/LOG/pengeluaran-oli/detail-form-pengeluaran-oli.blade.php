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
    .approval-section {
        margin-top: 2rem;
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .approval-badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        margin-left: 0.5rem;
    }
    .approval-badge.approved {
        color: #fff;
        background-color: #28a745;
    }
    .approval-badge.rejected {
        color: #fff;
        background-color: #dc3545;
    }
    .approval-badge.pending {
        color: #212529;
        background-color: #ffc107;
    }
</style>
@endsection

@php

$master = $data['master'];
$detail = $data['detail'];
$sites = $data['sites'];
$users = $data['users'];
$shifts = $data['shifts'];
$jenis = $data['jenis'];
$merks = $data['merks'];
$components = $data['components'];
$remarks = $data['remarks'];

@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">EDIT FORM BSS-FRM-LOG-034 PENGELUARAN OIL, GREASE & COOLANT</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    <form action="">
                        <div class="row gx-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
                                                <td class="fw-bold" style="width: 10rem">No. Doc</td>
                                                <td >: {{$master->no_dok ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created By</td>
                                                <td id="requestor">: {{$master->created_by ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Created  Date</td>
                                                <td>: {{$master->created_at ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated By</td>
                                                <td id="requestor">: {{$master->updated_by ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Updated Date</td>
                                                <td id="requestor">: {{$master->updated_at ?? '-'}}</td>
                                            </tr>
                                            <!-- <tr>
                                                <td class="fw-bold">Approve/Reject Reason</td>
                                                <td id="requestor">{{$master->remark ?? '-'}}</td>
                                            </tr> -->
                                            
                                        </table>
                                    </div>
                                </div>
                               
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="w-100">
                                            <tr>
<<<<<<< HEAD
                                                <td class="fw-bold">Foreman/Spv</td>
                                                <td>
                                                    <select class="form-select form-select-sm input-text" id="iForeman" name="iForeman" disabled>
                                                        <option value="{{ $master->diketahui_oleh ?? '-' }}">{{ $master->diketahui_oleh ?? '-' }}</option>
                                                    </select>
=======
                                                <td class="fw-bold" style="width: 10rem">Approval Status</td>
                                                <td id="requestor">: {{$master->diketahui_oleh ?? '-'}}
                                                @if($master->status_req == 'approved')
                                                    <span class="approval-badge approved">Approved</span>
                                                @elseif($master->status_req == 'rejected')
                                                    <span class="approval-badge rejected">Rejected</span>
                                                @else
                                                    <span class="approval-badge pending">Need Approval</span>
                                                @endif
>>>>>>> 5999876069c0c9ceb27dda4a7ebc342aed69fc41
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">No. Lube Station / Lube Truck </td>
                                                <td>: {{ $master->lube }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Shift</td>
                                                <td>: {{$master->shift ?? '-'}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Site</td>
                                                <td>: {{$master->site ?? '-'}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                              
                            </div>
                               
                        </div>


                        <div class="table-responsive mt-4">
                            <table id="item-pengeluaran" class="display" data-toggle="table">
                                <thead>
                                    <tr>
                                        <th data-formatter="indexFormatter" data-field="no">No</th>
                                        <th data-field="unit">Unit</th>
                                        <th data-field="time">Time</th>
                                        <th data-field="hm">HM</th>
                                        <th data-field="jenis">Jenis</th>
                                        <th data-field="merk">Merk</th>
                                        <th data-field="awal">Awal</th>
                                        <th data-field="akhir">Akhir</th>
                                        <th data-formatter="flowmeter">Qty</th>
                                        <th data-field="compo">Component</th>
                                        <th data-field="remark">Remark</th>
                                        <th data-field="pic">PIC / Nama</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </form>

                    <div class="card-footer">
                        <div class="d align-items-center">
                            @if ( session('user_id') == $master->diketahui_oleh && ($master->status_req == 'NEED APPROVAL') )
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

        var btnUpdatePengeluaranOli = $("#btnUpdatePengeluaranOli");
        var $table = $("#item-pengeluaran");
        var $buttonTambah = $("#btn-add-item")
        var totalQty = $("#totalQty")
        var $btnDeletedData = $('#btnDeletedData');

        var $btnApprove = $("#btnApprove")
        var $btnReject = $("#btnReject")
        
        // Variable form
        var tanggalSekarang = $("#tanggalSekarang")
        var noDoc = $("#noDoc");
        var tglDoc = $("#tglDoc");
        var iForeman = $("#iForeman")
        var iJobSite = $("#iJobSite")
        var iLube = $("#iLube")
        var iShift = $("#iShift")
        
        // Variable items
        var iUnit = $("#iUnit")
        var iTime = $("#iTime")
        var iHm = $("#iHm")
        var iJenis = $("#iJenis")
        var iMerk = $("#iMerk")
        var iAwal = $("#iAwal")
        var iAkhir = $("#iAkhir")
        var iCompo = $("#iCompo")
        var iRemark = $("#iRemark")
        var iPic = $("#iPic")

        var dataPengeluaranOli = {
            formName: "Pengeluaran Oli",
            noDoc: "",
            tglDoc: "",
            foreman: "",
            jobSite: "",
            lube: "",
            shift: "",
            totalQty: "",
            
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

        function flowmeter(value, row, index) {
            return row.akhir - row.awal;
        }

        function generateNoDoc() {
            return "_/BSS-FRM-LOG-034/" + months_romawi[tglNow.getMonth()] + "/" + tglNow.getFullYear();
        }

        function validateRange() {
            const awal = parseFloat(iAwal.val()) || 0;
            const akhir = parseFloat(iAkhir.val()) || 0;
            const awalError = $('#awalError');
            const akhirError = $('#akhirError');
            
            // Clear previous errors
            iAwal.removeClass('is-invalid');
            iAkhir.removeClass('is-invalid');
            awalError.addClass('d-none');
            akhirError.addClass('d-none');
            
            // Validate only if both fields have values
            if (iAwal.val() && iAkhir.val()) {
                if (awal >= akhir) {
                    iAwal.addClass('is-invalid');
                    iAkhir.addClass('is-invalid');
                    awalError.removeClass('d-none').text('Awal harus lebih kecil dari Akhir');
                    akhirError.removeClass('d-none').text('Akhir harus lebih besar dari Awal');
                    return false;
                }
                
                // Update Qty display if valid
                totalQty.text(akhir - awal);
            }
            return true;
        }

        function validateInput() {

        }

        function actionFormatter(value, row, index) {
            return `
                <a class="btn btn-warning btn-sm edit-item" data-index="${index}" href="javascript:void(0)">Edit</a>
                <a class="btn btn-danger btn-sm" onclick="deleteRow(${index})" href="javascript:void(0)">Delete</a>
            `;
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
                // totalQty.text((parseInt(iAkhir.val())) - (parseInt(iAwal.val()))||9)
                item.no = index;
                items.push(item)
            })
            dataPengeluaranOli.item = items
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

            dataPengeluaranOli.foreman = iForeman.val()
            dataPengeluaranOli.lube = iLube.val()


            var detial = {{ Illuminate\Support\Js::from($detail) }}
                console.log({{ Illuminate\Support\Js::from($data) }})
                detial.forEach(element => {
                    $table.bootstrapTable('append', element)
                });



            // Edit item functionality
            $(document).on('click', '.edit-item', function() {
                var index = $(this).data('index');
                var rowData = $table.bootstrapTable('getData')[index];

                // Populate the modal with row data
                $('#editIndex').val(index);
                $('#editUnit').val(rowData.unit);
                $('#editTime').val(rowData.time);
                $('#editHm').val(rowData.hm);
                $('#editJenis').val(rowData.jenis);
                $('#editMerk').val(rowData.merk);
                $('#editAwal').val(rowData.awal);
                $('#editAkhir').val(rowData.akhir);
                $('#editCompo').val(rowData.compo);
                $('#editRemark').val(rowData.remark);
                $('#editPic').val(rowData.pic);
                
                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('editItemModal'));
                editModal.show();
            });

            // Function to validate edit form
            function validateEditForm() {
                let isValid = true;
                const requiredFields = [
                    'editUnit', 'editTime', 'editHm', 'editJenis', 'editMerk',
                    'editAwal', 'editAkhir', 'editCompo', 'editRemark', 'editPic'
                ];

                // Clear previous validation errors
                $('#editItemForm').find('.is-invalid').removeClass('is-invalid');
                $('#editItemForm').find('.invalid-feedback').remove();

                // Validate each required field
                requiredFields.forEach(fieldId => {
                    const field = $(`#${fieldId}`);
                    if (!field.val()) {
                        field.addClass('is-invalid');
                        field.after(`<div class="invalid-feedback">Tidak boleh kosong</div>`);
                        isValid = false;
                    }
                });

                // Validate awal and akhir
                const awal = parseFloat($('#editAwal').val()) || 0;
                const akhir = parseFloat($('#editAkhir').val()) || 0;
                
                if (awal >= akhir) {
                    $('#editAwal').addClass('is-invalid');
                    $('#editAkhir').addClass('is-invalid');
                    $('#editAwal').after(`<div class="invalid-feedback">Awal harus lebih kecil dari Akhir</div>`);
                    $('#editAkhir').after(`<div class="invalid-feedback">Akhir harus lebih besar dari Awal</div>`);
                    isValid = false;
                }

                return isValid;
            }

            // Save edited item
            $('#saveEditItem').click(function() {
                if (!validateEditForm()) {
                    return; // Don't proceed if validation fails
                }

                var index = $('#editIndex').val();
                var updatedRow = {
                    unit: $('#editUnit').val(),
                    time: $('#editTime').val(),
                    hm: $('#editHm').val(),
                    jenis: $('#editJenis').val(),
                    merk: $('#editMerk').val(),
                    awal: $('#editAwal').val(),
                    akhir: $('#editAkhir').val(),
                    qty: $('#editAkhir').val() - $('#editAwal').val(),
                    compo: $('#editCompo').val(),
                    remark: $('#editRemark').val(),
                    pic: $('#editPic').val()
                };
                
                // Update the table row
                $table.bootstrapTable('updateRow', {
                    index: index,
                    row: updatedRow
                });
                
                // Close the modal
                var editModal = bootstrap.Modal.getInstance(document.getElementById('editItemModal'));
                editModal.hide();
            });

            iAkhir.change(function(e) {
                totalQty.text((iAkhir.val()) - (iAwal.val() ))
            });

            // Update the validateItem function
            function validateItem() {
                let isValid = true;
    
                // Clear previous error states
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').addClass('d-none');
                
                // Validate Unit
                if(!iUnit.val()) {
                    iUnit.addClass('is-invalid');
                    $('#unitError').removeClass('d-none');
                    isValid = false;
                }
                
                // Validate Unit
                if(iUnit.val() == "") {
                    iUnit.addClass('is-invalid');
                    iUnit.after('<div class="invalid-feedback">Unit tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Time
                if(iTime.val() == "") {
                    iTime.addClass('is-invalid');
                    iTime.after('<div class="invalid-feedback">Time tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate HM
                if(iHm.val() == "") {
                    iHm.addClass('is-invalid');
                    iHm.after('<div class="invalid-feedback">HM tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Jenis
                if(iJenis.val() == "") {
                    iJenis.addClass('is-invalid');
                    iJenis.after('<div class="invalid-feedback">Jenis harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Merk
                if(iMerk.val() == "") {
                    iMerk.addClass('is-invalid');
                    iMerk.after('<div class="invalid-feedback">Merk harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Awal
                if(iAwal.val() == "") {
                    iAwal.addClass('is-invalid');
                    iAwal.after('<div class="invalid-feedback">Awal tidak boleh kosong</div>');
                    isValid = false;
                }
                
                // Validate Awal and Akhir
                if(!iAwal.val()) {
                    iAwal.addClass('is-invalid');
                    $('#awalError').removeClass('d-none').text('Awal tidak boleh kosong');
                    isValid = false;
                }
                
                if(!iAkhir.val()) {
                    iAkhir.addClass('is-invalid');
                    $('#akhirError').removeClass('d-none').text('Akhir tidak boleh kosong');
                    isValid = false;
                }
                
                // Only validate range if both fields have values
                if(iAwal.val() && iAkhir.val()) {
                    isValid = validateRange() && isValid;
                }
                
                // Validate Component
                if(iCompo.val() == "") {
                    iCompo.addClass('is-invalid');
                    iCompo.after('<div class="invalid-feedback">Component harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate Remark
                if(iRemark.val() == "") {
                    iRemark.addClass('is-invalid');
                    iRemark.after('<div class="invalid-feedback">Remark harus dipilih</div>');
                    isValid = false;
                }
                
                // Validate PIC
                if(iPic.val() == "") {
                    iPic.addClass('is-invalid');
                    iPic.after('<div class="invalid-feedback">PIC/Nama tidak boleh kosong</div>');
                    isValid = false;
                }
                
                return isValid;
            }

            // Update the validateForm function
            function validateForm() {
                var errorValidate = []
                
                if(iForeman.val() == ""){
                    errorValidate.push({
                        field: "Kolom Foreman",
                        message: "Harus dipilih"
                    })
                }
                if(iLube.val() == ""){
                    errorValidate.push({
                        field: "Kolom Lube",
                        message: "Harus diisi"
                    })
                }
                if(iShift.val() == ""){
                    errorValidate.push({
                        field: "Kolom Shift",
                        message: "Harus dipilih"
                    })
                }

                if(iJobSite.val() == ""){
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

            $buttonTambah.click(function (e) {
                e.preventDefault()
                var errorValidate = validateItem()

                if(validateItem()) {
                    $table.bootstrapTable('append', {
                        unit: iUnit.val(),
                        time: iTime.val(),
                        hm: iHm.val(),
                        jenis: iJenis.val(),
                        merk: iMerk.val(),
                        awal: iAwal.val(),
                        akhir: iAkhir.val(),
                        qty: totalQty.text(),
                        compo: iCompo.val(),
                        remark: iRemark.val(),
                        pic: iPic.val()
                    });
                    
                    // Clear form after successful addition
                    iUnit.val('');
                    iTime.val('');
                    iHm.val('');
                    iJenis.val('');
                    iMerk.val('');
                    iAwal.val('');
                    iAkhir.val('');
                    iCompo.val('');
                    iRemark.val('');
                    iPic.val('');
                    totalQty.text('-');
                    
                    $table.bootstrapTable('scrollTo', 'bottom');
                }
                
            })

            btnUpdatePengeluaranOli.click(function(e) {
                
                e.preventDefault();

                var errValidate = validateForm()
                if(errValidate.length > 0) {
                    var msg = ""
                    for (var listErr of errValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    }).then((result) => {
                    })
                } else {
                    var dataReq = {
                        id: "{{$master->id}}",
                        formName: dataPengeluaranOli.formName,
                        noDoc: "{{ $master->no_dok }}",
                        jobSite: iJobSite.val(),
                        shift: iShift.val(),
                        lube: iLube.text(),
                        tglDoc: formatTgl(),
                        foreman: iForeman.val(),
                        lube: iLube.val()
                    }
                    let formData = new FormData();
                    formData.append('item',JSON.stringify(dataPengeluaranOli.item));
                    for (const key in dataReq) {
                        if(key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    showLoading();
                    axios.post('/bss-form/log/update-pengeluaran-oli', formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        showLoading()
                        console.log(response.data)
                        Swal.fire({
                                icon: 'success',
                                title: 'Form update',
                                text: 'Document '+ response.data.data.no_doc +' sukses di update',
                            }).then((result) => {
                                window.location.href = `/bss-form/log/pengeluaran-oli`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                        stopLoading()
                    })
                    .finally(function() {
                        stopLoading()
                    });
                }
                
            })
       
            $btnDeletedData.click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin hapus dokument ini?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e91e63',
                    cancelButtonColor: '#7b809a',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading()
                        axios.post('/bss-form/log/delete-pengeluaran-oli', {
                            id: "{{$master->id}}"
                        })
                        .then(function (response) {
                            console.log(response.data)
                            Swal.fire({
                                icon: 'success',
                                title: 'Delete Form',
                                text: 'Document {{$master->no_dok}} sukses di hapus',
                            }).then((result) => {
                                window.location.href = `/bss-form/log/pengeluaran-oli`;
                            })
                        })
                        .catch(function (error) {
                            console.log(error);
                            stopLoading()
                        })
                        .finally(function() {
                            stopLoading()
                        });
                    }
                })
            })
            
            $btnApprove.click(function(e) {
                e.preventDefault();
                showApprovalDialog('approve');
            })

            $btnReject.click(function(e) {
                e.preventDefault();
                showApprovalDialog('reject');
            })

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
                for (const key in dataReq) {
                    if(key != "item") {
                        formData.append(key, dataReq[key]);
                    }
                }

                axios.post('/bss-form/log/approve-reject-pengeluaran-oli', formData, {
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
                        window.location.href = `/bss-form/log/pengeluaran-oli`;
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
