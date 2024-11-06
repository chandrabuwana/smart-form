@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Asset Request</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="row gx-4">
                        <div class="col-auto my-auto ms-3">
                            <div class="h-100">
                                <p class="mb-0 fw-bold text-sm">
                                    Requested By : <span id="requestor">{{$data['requested_by']}}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="">
                        <div class="row gx-4 my-3">
                            <div class="col-12 col-md-4">
                                <h4>Nature</h4>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkReplacement" name="checkReplacement" {{$data['replacement']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Replacement
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkAdditional" name="checkAdditional" {{$data['additional']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Additional
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkBudgeted" name="checkBudgeted" {{$data['budgeted']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Budgeted
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkNotBudgeted" name="checkNotBudgeted" {{$data['not_budgeted']}}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Not Budgeted
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-4">
                            <div class="row">
                                <div>
                                    <table class="small">
                                        <tr>
                                            <td>No. Doc</td>
                                            <td>:</td>
                                            <td id="noDoc">{{$data['no_doc']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td id="tglDoc">{{$data['tgl_doc']}}</td>
                                        </tr>
                                    </table>
                                    <!-- <div>No. Doc : <span id="noDoc"></span></div>
                                    <div>Date : <span id="tglDoc"></span></div> -->
                                </div>
                                <div class="card col-md-6">
                                    <div class="card-body w-full">
                                        <h5 class="card-title">Requestor</h5>
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputDepartment">Department</label>
                                            <select class="form-control form-select-sm" name="inputDepartment" id="inputDepartment" required>
                                                @foreach ($list_dept as $key => $item)
                                                    <option value="{{$key}}">{{ $item }}</option>
                                                @endforeach
                                                {{-- <option selected value="">-- Pilih Department --</option>
                                                <option value="ENG">ENGINEERING</option>
                                                <option value="SHE">SHE</option>
                                                <option value="PRD">PRODUKSI</option>
                                                <option value="SM">SM</option>
                                                <option value="IC">IC</option>
                                                <option value="GS">GS</option>
                                                <option value="RM">PLANT</option>
                                                <option value="BDV">BUSDEV</option>
                                                <option value="FIN">FINANCE</option>
                                                <option value="ATA">Accounting & Tax</option>
                                                <option value="DTC">DATA CENTER</option>
                                                <option value="MM">LOGISTIK</option>
                                                <option value="OPR">OPERATION</option>
                                                <option value="LEG">LEGAL</option>
                                                <option value="OD">ORGANIZATION DEVELOPMENT</option>
                                                <option value="CIVIL">CIVIL</option> --}}
                                                {{-- <option value="IT">IT</option> --}}
                                                {{-- <option value="DIR">DIRECTORS</option> --}}
                                                {{-- <option value="SI">SINERGY INSTITUTE</option>
                                                <option value="Z001">ASSESSMENT CENTER</option>
                                                <option value="Z002">LABOR SUPPLY</option>
                                                <option value="Z003">MANAGEMENT CONSULTANT</option>
                                                <option value="Z004">SERTIFIKASI</option>
                                                <option value="TC">TRAINING CENTER</option> --}}
                                            </select>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputProject">Project / Site</label>
                                            <select class="form-control form-select-sm" name="inputProject" id="inputProject" required>
                                                <option value="JKT">JKT</option>
                                                <option value="TDM">TDM</option>
                                                <option value="AGM">AGM</option>
                                                <option value="PMSS">PMSS</option>
                                                <option value="MAS">MAS</option>
                                                <option value="COMEX MSJ">COMEX MSJ</option>
                                                <option value="COMEX PALARAN">COMEX PALARAN</option>
                                                <option value="COMEX AGM">COMEX AGM</option>
                                                <option value="BSSR 2">BSSR 2</option>
                                                <option value="PKM">PKM</option>
                                                <option value="SMD">SMD</option>
                                                <option value="KUP">KUP</option>
                                                <option value="TAJ">TAJ</option>
                                                <option value="MME">MME</option>
                                                <option value="MBL">MBL</option>
                                                <option value="COMEX-MAS">COMEX-MAS</option>
                                                <option value="COMEX CILEGON">COMEX CILEGON</option>
                                                <option value="SAS">SAS</option>
                                                <option value="BSEE">BSEE</option>
                                                <option value="BRN">BRN</option>
                                                <option value="KUD">KUD</option>
                                                <option value="BYN">BYN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card col-md-6">
                                    <div class="card-body">
                                        <h5 class="card-title">Asset Allocation</h5>
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputDepartmentAllocation">Department</label>
                                            <select class="form-control form-select-sm" name="inputDepartmentAllocation" id="inputDepartmentAllocation" required>
                                                @foreach ($list_dept as $key => $item)
                                                    <option value="{{$key}}">{{ $item }}</option>
                                                @endforeach
                                                {{-- <option selected value="">-- Pilih Department --</option>
                                                <option value="ENG">ENGINEERING</option>
                                                <option value="SHE">SHE</option>
                                                <option value="PRD">PRODUKSI</option>
                                                <option value="SM">SM</option>
                                                <option value="IC">IC</option>
                                                <option value="GS">GS</option>
                                                <option value="RM">PLANT</option>
                                                <option value="BDV">BUSDEV</option>
                                                <option value="FIN">FINANCE</option>
                                                <option value="ATA">Accounting & Tax</option>
                                                <option value="DTC">DATA CENTER</option>
                                                <option value="MM">LOGISTIK</option>
                                                <option value="OPR">OPERATION</option>
                                                <option value="LEG">LEGAL</option>
                                                <option value="OD">ORGANIZATION DEVELOPMENT</option>
                                                <option value="CIVIL">CIVIL</option> --}}
                                                {{-- <option value="IT">IT</option> --}}
                                                {{-- <option value="DIR">DIRECTORS</option> --}}
                                                {{-- <option value="SI">SINERGY INSTITUTE</option>
                                                <option value="Z001">ASSESSMENT CENTER</option>
                                                <option value="Z002">LABOR SUPPLY</option>
                                                <option value="Z003">MANAGEMENT CONSULTANT</option>
                                                <option value="Z004">SERTIFIKASI</option>
                                                <option value="TC">TRAINING CENTER</option> --}}
                                            </select>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputProjectAllocation">Project / Site</label>
                                            <select class="form-control form-select-sm" name="inputProjectAllocation" id="inputProjectAllocation" required>
                                                <option value="JKT">JKT</option>
                                                <option value="TDM">TDM</option>
                                                <option value="AGM">AGM</option>
                                                <option value="PMSS">PMSS</option>
                                                <option value="MAS">MAS</option>
                                                <option value="COMEX MSJ">COMEX MSJ</option>
                                                <option value="COMEX PALARAN">COMEX PALARAN</option>
                                                <option value="COMEX AGM">COMEX AGM</option>
                                                <option value="BSSR 2">BSSR 2</option>
                                                <option value="PKM">PKM</option>
                                                <option value="SMD">SMD</option>
                                                <option value="KUP">KUP</option>
                                                <option value="TAJ">TAJ</option>
                                                <option value="MME">MME</option>
                                                <option value="MBL">MBL</option>
                                                <option value="COMEX-MAS">COMEX-MAS</option>
                                                <option value="COMEX CILEGON">COMEX CILEGON</option>
                                                <option value="SAS">SAS</option>
                                                <option value="BSEE">BSEE</option>
                                                <option value="BRN">BRN</option>
                                                <option value="KUD">KUD</option>
                                                <option value="BYN">BYN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="my-3">
                            <div class="mb-1 row">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="reasonpurchase">1. Reason For Purchase</label>
                                        <input type="text" class="form-control" id="reasonpurchase"
                                            name="reasonpurchase">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-4">
                                        <label for="inputPendukungReason">Dokumen Pendukung</label>
                                        <input type="file" multiple class="form-control" id="inputPendukungReason" name="inputPendukungReason">
                                        <span class="text-xs"><i>max file size: 2mb</i></span>
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
                                <label class="form-label">2. Estimated Ready at Site </label>
                                <input type="date" class="input-text"  placeholder="" id="estimatedReadyAtSite" name="estimatedReadyAtSite">
                            </div>
                            <div class="mb-1">
                                <label class="form-label">3. Item</label>
                                <div class="row mb-2">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputType">Type</label>
                                            <input type="text" class="form-control" id="inputType" name="inputType">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputModel">Model</label>
                                            <input type="text" class="form-control" id="inputModel" name="inputModel">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputBrand">Brand</label>
                                            <input type="text" class="form-control" id="inputBrand" name="inputBrand">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputCondition">Condition</label>
                                            <select class="form-control form-select-sm" name="inputCondition" id="inputCondition" required>
                                                <option selected value="">-- Pilih Condition --</option>
                                                <option value="new">New</option>
                                                <option value="used">Used</option>
                                                <option value="refurbished">Refurbished</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputQty">QTY</label>
                                            <input type="text" class="form-control" id="inputQty" name="inputQty">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputUom">UOM</label>
                                            <input type="text" class="form-control" id="inputUom" name="inputUom">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputCurrency">Currency</label>
                                            <select class="form-control form-select" name="inputCurrency" id="inputCurrency" required>
                                                <option value="IDR">IDR</option>
                                                <option value="USD">USD</option>
                                                <option value="CNY">CNY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputPrice">Price</label>
                                            <input type="text" class="form-control" id="inputPrice" name="inputPrice">
                                        </div>
                                    </div>
                                    <!--<div class="col-md-4 col-lg-3">
                                        <div class="input-group input-group-static mb-4">
                                            <label for="inputLampiran">Lampiran</label>
                                            <input type="file" class="form-control" id="inputLampiran" name="inputLampiran">
                                        </div>
                                    </div>-->
                                </div>

                                <button id="btn-add-item" class="btn btn-primary">Tambah</button>
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
                                        <th data-field="price">Price</th>
                                        <th data-formatter="totalHarga">Total Price</th>
                                        <th data-formatter="actionFormatter">Actions</th>
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
                                        <div class="input-group input-group-static mb-4">
                                            <input type="text" class="form-control text-right" id="estimatedIdr" name="estimatedIdr" value="{{ $data['estimated_idr'] }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>USD</td>
                                    <td>
                                        <div class="input-group input-group-static mb-4">
                                            <input type="text" class="form-control text-right" id="estimatedUsd" name="estimatedUsd" value="{{ $data['estimated_usd'] }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CNY</td>
                                    <td>
                                        <div class="input-group input-group-static mb-4">
                                            <input type="text" class="form-control text-right" id="estimatedCny" name="estimatedCny" value="{{ $data['estimated_cny'] }}">
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
                                    <input type="text" class="form-control" id="refDoc" name="refDoc" value="{{ $data['ref_doc'] }}">
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

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitAssetRequest">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
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
        // var inputArea = $("#inputArea")
        var inputProject = $("#inputProject")
        var inputDepartment = $("#inputDepartment")
        var inputProjectAllocation = $("#inputProjectAllocation")
        var inputDepartmentAllocation = $("#inputDepartmentAllocation")
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
        var inputPendukungReason = document.getElementById("inputPendukungReason")
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
            departmentAllocation: "",
            projectAllocation: "",

            // area: "",
            reasonForPurchase: "",
            estimatedReadyAtSite: "",
            item: [{}],
            estimatedIDR: 0,
            estimatedUSD: 0,
            estimatedCNY: 0,
            refDoc: "",
            requestedBy: requestornik.text()
        }

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        function totalHarga(value, row, index) {
            return row.qty * row.price;
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

        function actionFormatter(value, row, index) {
            return `
                <a class="btn btn-danger btn-sm" onclick="deleteRow(${index})">Delete</a>
            `;
        }

        function deleteRow(id) {
            $table.bootstrapTable('remove', {
                field: '$index',
                values: [id]
            })
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
            calculatedIdr.text(idr)
            calculatedUsd.text(usd)
            calculatedCny.text(cny)
            // console.log("estimatedIdr : ", estimatedIdr.val())
            totalPrice.text((parseInt(estimatedIdr.val()) * idr) + (parseInt(estimatedUsd.val()) * usd) + (parseInt(estimatedCny.val()) * cny) || "-")
            // console.log("IDR = ", idr)
        })
        var isError = {
            error: {{ Illuminate\Support\Js::from($error) }},
            errorMessage: {{ Illuminate\Support\Js::from($errorMessage) }}
        }

        checkNotBudgeted.addEventListener("change",(e) => {
            if(e.target.checked) {
                checkBudgeted.checked=false
            }
        })
        checkBudgeted.addEventListener("change",(e) => {
            if(e.target.checked) {
                checkNotBudgeted.checked=false
            }
        })
        checkReplacement.addEventListener("change",(e) => {
            if(e.target.checked) {
                checkAdditional.checked=false
            }
        })
        checkAdditional.addEventListener("change",(e) => {
            if(e.target.checked) {
                checkReplacement.checked=false
            }
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
            if(isError.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: isError.errorMessage,
                }).then((result) => {

                })
            } else {
                var detial = {{ Illuminate\Support\Js::from($detail) }}
                console.log({{ Illuminate\Support\Js::from($data) }})
                detial.forEach(element => {
                    $table.bootstrapTable('append', element)
                });
                inputDepartment.val({{ Illuminate\Support\Js::from( $data['department']) }})
                inputProject.val({{ Illuminate\Support\Js::from( $data['project']) }})
                inputDepartmentAllocation.val({{ Illuminate\Support\Js::from( $data['department_allocation']) }})
                inputProjectAllocation.val({{ Illuminate\Support\Js::from( $data['project_allocation']) }})
                estimatedReadyAtSite.val({{ Illuminate\Support\Js::from( $data['estimated_ready_at_site']) }})
                reasonpurchase.val({{ Illuminate\Support\Js::from( $data['reason_purchase']) }})
                refDoc.val({{ Illuminate\Support\Js::from( $data['ref_doc']) }})

                dataAssetRequest.replacement = checkReplacement.checked
                dataAssetRequest.additional = checkAdditional.checked
                dataAssetRequest.budgeted = checkBudgeted.checked
                dataAssetRequest.notBudgeted = checkNotBudgeted.checked
                // dataAssetRequest.area = $("#inputArea").val()
                dataAssetRequest.department = inputDepartment.val()
                dataAssetRequest.project = inputProject.val()
                dataAssetRequest.departmentAllocation = inputDepartmentAllocation.val()
                dataAssetRequest.projectAllocation = inputProjectAllocation.val()
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

            function validateItem() {
                var errorValidate = []

                if(inputType.val() == "") {
                    errorValidate.push({
                        field: "Type",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputCondition.val() == "") {
                    errorValidate.push({
                        field: "Condition",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputQty.val() == "") {
                    errorValidate.push({
                        field: "QTY",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputUom.val() == "") {
                    errorValidate.push({
                        field: "UOM",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputCurrency.val() == "") {
                    errorValidate.push({
                        field: "Currency",
                        message: "Tidak boleh kosong"
                    })
                }
                if(inputPrice.val() == "") {
                    errorValidate.push({
                        field: "Price",
                        message: "Tidak boleh kosong"
                    })
                }

                return errorValidate
            }

            function validateForm() {
                var errorValidate = []

                if(!checkAdditional.checked && !checkReplacement.checked){
                    errorValidate.push({
                        field: "Replacement / Additional",
                        message: "harus dipilih"
                    })
                }
                if(!checkBudgeted.checked && !checkNotBudgeted.checked){
                    errorValidate.push({
                        field: "Budgeted / Not Budgeted",
                        message: "harus dipilih"
                    })
                }
                if(checkNotBudgeted.checked && inputPendukungReason.files.length < 1) {
                    errorValidate.push({
                        field: "Dokumen Pendukung",
                        message: "tidak boleh kosong jika Not Budgeted"
                    })
                }
                if(inputDepartment.val() == ""){
                    errorValidate.push({
                        field: "Department Requestor",
                        message: "tidak boleh kosong"
                    })
                }
                if(inputProject.val() == ""){
                    errorValidate.push({
                        field: "Project/Site Requestor",
                        message: "tidak boleh kosong"
                    })
                }
                if(inputDepartmentAllocation.val() == ""){
                    errorValidate.push({
                        field: "Department Allocation",
                        message: "tidak boleh kosong"
                    })
                }
                if(inputProjectAllocation.val() == ""){
                    errorValidate.push({
                        field: "Project/Site Allocation",
                        message: "tidak boleh kosong"
                    })
                }
                if(reasonpurchase.val() == ""){
                    errorValidate.push({
                        field: "Reason for Purchase",
                        message: "tidak boleh kosong"
                    })
                }
                if(estimatedReadyAtSite.val() == ""){
                    errorValidate.push({
                        field: "Estimated ready",
                        message: "tidak boleh kosong"
                    })
                }
                if(estimatedReadyAtSite.val() < getTodayDate()){
                    errorValidate.push({
                        field: "Estimated ready at site",
                        message: "tidak boleh back date"
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
                
                var msg = "";
                if(errorValidate.length > 0) {
                    for (var listErr of errorValidate) {
                        msg = msg + "<p class='m-0'>" + listErr.field + " " + listErr.message +  "</p>"
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        html: msg,
                    }).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                } else {
                    $table.bootstrapTable('append', {
                        type: inputType.val(),
                        model: inputModel.val(),
                        brand: inputBrand.val(),
                        condition: inputCondition.val(),
                        qty: inputQty.val(),
                        uom: inputUom.val(),
                        currency: inputCurrency.val(),
                        price: inputPrice.val()
                    })
                    $table.bootstrapTable('scrollTo', 'bottom')
                }
            })

            btnSubmitAssetRequest.click(function(e) {
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
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                } else {
                    var dataReq = {
                        formName: dataAssetRequest.formName,
                        // area: inputArea.val(),
                        noDoc: noDoc.text(),
                        tglDoc: formatTgl(),
                        replacement: checkReplacement.checked,
                        additional: checkAdditional.checked,
                        budgeted: checkBudgeted.checked,
                        notBudgeted: checkNotBudgeted.checked,
                        department: inputDepartment.val(),
                        project: inputProject.val(),
                        departmentAllocation: inputDepartmentAllocation.val(),
                        projectAllocation: inputProjectAllocation.val(),
                        // area: inputArea.val(),
                        reasonPurchase: reasonpurchase.val(),
                        estimatedReadyAtSite: estimatedReadyAtSite.val(),
                        estimatedIdr: estimatedIdr.val(),
                        estimatedUsd: estimatedUsd.val(),
                        estimatedCny: estimatedCny.val(),
                        refDoc: refDoc.val(),
                        requestedBy: requestornik.text(),
                        // item: dataAssetRequest.item,
                        totalPrice: totalPrice.text(),
                        pendukungReason: []
                    }
                    let formData = new FormData();
    
                    for (let i = 0; i < inputPendukungReason.files.length; i++) {
                        formData.append('pendukungReason[]', inputPendukungReason.files[i]);
                    }
                    formData.append('item',JSON.stringify(dataAssetRequest.item));
                    for (const key in dataReq) {
                        if(key != "pendukungReason" || key != "item") {
                            formData.append(key, dataReq[key])
                        }
                    }
                    // TODO
                    axios.post('/bss-form/sm/submit-edit-asset-request?no_doc='+noDoc.text(), formData, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (response) {
                        console.log(response.data)
                        showLoading()
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.data.data.no_doc,
                            }).then((result) => {
                                window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                            })
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(function() {
                        stopLoading()
                    })
                }
                // submitAssetRequest(dataReq);
            })
        })
    </script>
@endsection
