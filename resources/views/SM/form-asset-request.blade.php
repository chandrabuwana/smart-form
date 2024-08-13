@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <style>
        .form-control {
            border: 1px solid;
            padding: 4px;
        }
        .form-control:focus {
            border: 1px solid;
        }
        .ml-16px {
            margin-left: 16px;
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
                                    Requested By : <span id="requestor">{{ session('username') }}</span>
                                    {{-- session()->get('name') . ' - ' . session()->get('dept') . ' - ' . session()->get('site') --}}
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                    <li class="nav-item">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td class="text-start">No Document</td>
                                                <td> : </td>
                                                <td>BSS-FRM-SM-016</td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">Revisi</td>
                                                <td> : </td>
                                                <td>00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-start">Tanggal</td>
                                                <td> : </td>
                                                <td>01-Jan-2023</td>
                                            </tr>
                                        </table>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <form action="">
                        <div class="row gx-4 my-3">
                            <div class="col-1">
                                <h4>Nature</h4>
                            </div>
                            <div class="col-5">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkReplacement" name="checkReplacement" >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Replacement
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkAdditional" name="checkAdditional">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Additional
                                    </label>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkBudgeted" name="checkBudgeted">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Budgeted
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="checkNotBudgeted" name="checkNotBudgeted">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Not Budgeted
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row gx-4">
                            <div class="col-6">
                                <div>
                                    <table class="small">
                                        <tr>
                                            <td>No. Doc</td>
                                            <td>:</td>
                                            <td id="noDoc">No.Doc</td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>:</td>
                                            <td id="tglDoc"></td>
                                        </tr>
                                    </table>
                                    <!-- <div>No. Doc : <span id="noDoc"></span></div>
                                    <div>Date : <span id="tglDoc"></span></div> -->
                                    <span>Department</span>
                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputDepartment" name="inputDepartment">
                                        <option selected>Pilih Department</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="SHE">SHE</option>
                                        <option value="Produksi">Produksi</option>
                                        <option value="SM">SM</option>
                                        <option value="GS">GS</option>
                                        <option value="OD">OD</option>
                                        <option value="IT">IT</option>
                                        <option value="IC">IC</option>
                                        <option value="PLANT">PLANT</option>
                                    </select>
                                </div>
                                <div>
                                    <span>Project</span>
                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputProject" name="inputProject">
                                        <option value="1">SM</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div>
                                    <span>Area</span>
                                    <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputArea" name="inputArea">
                                        <option value="JKT">JKT</option>
                                        <option value="BSSR">BSSR</option>
                                        <option value="SMD">SMD</option>
                                        <option value="AGM">AGM</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Todo: otomatis ambil sesuai urutan di DB -->
                            <!-- <div class="col-6">
                                <div>No. Doc : 1/BSS-AR/VII/2024</div>
                                <div>Date : </div>
                            </div> -->
                        </div>

                        <div class="my-3">
                            <div class="mb-1">
                                <label class="form-label">1. Reason For Purchase</label>
                                <input type="text" class="form-control input-text"  placeholder="" id="reasonpurchase" name="reasonpurchase">
                            </div>

                            <div class="mb-1">
                                <label class="form-label">2. Estimated Ready at Site </label>
                                <input type="date" class="input-text"  placeholder="" id="estimatedReadyAtSite" name="estimatedReadyAtSite">
                            </div>
                            <div class="mb-1">
                                <label class="form-label">3. Item</label>
                                <div class="row mb-2">
                                    <div class="col-2">
                                        <label class="display-block m-0">Type : </label>
                                        <input type="text" placeholder="Type" id="inputType" class="input-text">
                                    </div>
                                    <div class="col-2">
                                        <label class="display-block m-0">Model : </label>
                                        <input type="text" placeholder="Model"id="inputModel" class="input-text">
                                    </div>
                                    <div class="col-2">
                                        <label class="display-block m-0">Brand : </label>
                                        <input type="text" placeholder="Brand" id="inputBrand" class="input-text">
                                    </div>
                                    <div class="col-2">
                                        <label class="display-block m-0">Condition : </label>
                                        <input type="text" placeholder="Condition" id="inputCondition" class="input-text">
                                    </div>
                                    <div class="col-2">
                                        <label class="display-block m-0">Qty : </label>
                                        <input type="text" placeholder="Qty" id="inputQty" class="input-text" value="1">
                                    </div>
                                    <div class="col-2">
                                        <label class="display-block m-0">UOM : </label>
                                        <input type="text" placeholder="UOM" id="inputUom" class="input-text">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-2">
                                        <label class="display-block m-0">Currency</label>
                                        <select class="form-select form-select-sm input-text" aria-label="Default select example" id="inputCurrency">
                                            <option value="IDR">IDR</option>
                                            <option value="USD">USD</option>
                                            <option value="CNY">CNY</option>
                                        </select>
                                        <!-- <input type="text" placeholder="Currency" id="inputCurrency"> -->
                                    </div>
                                    <div class="col-2">
                                        <label class="display-block m-0">Price</label>
                                        <input type="text" placeholder="Price" id="inputPrice" class="input-text">
                                    </div>
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
                                        <input type="text" class="text-right input-text" name="estimatedIdr" id="estimatedIdr" value="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td>USD</td>
                                    <td>
                                        <input type="text" class="text-right input-text" name="estimatedUsd" id="estimatedUsd" value="15000">
                                    </td>
                                </tr>
                                <tr>
                                    <td>CNY</td>
                                    <td>
                                        <input type="text" class="text-right input-text" name="estimatedCny" id="estimatedCny" value="2300">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="my-3 row">
                            <div class="mb-1 col-6">
                                <label class="form-label">5. Budget</label>
                                <input type="text" class="input-text" id="refDoc" name="refDoc" placeholder="Ref Doc" value="-">
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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

        function submitAssetRequest(data) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "post",
                url: "/add-asset-request",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {

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

        $(function() {
            noDoc.text(generateNoDoc())
            tglDoc.text(formatTgl() || "-")
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

            $buttonTambah.click(function (e) {
                e.preventDefault()
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
            })

            btnSubmitAssetRequest.click(function(e) {
                e.preventDefault();


                // console.log(inputArea.val())
                // formName: "Asset Request",
                // noDok: "BSS-FRM-SM-016",
                // tglDok: "01-01-2023",
                // noDoc: "",
                // tglDoc: "",
                // replacement: false,
                // additional: false,
                // budgeted: false,
                // notBudgeted: false,
                // department: "",
                // project: "",
                // area: "",
                // reasonForPurchase: "",
                // estimatedReadyAtSite: "",
                // item: [],
                // estimatedIDR: 0,
                // estimatedUSD: 0,
                // estimatedCNY: 0,
                // refDoc: "",
                // requestedBy: requestornik.text()
                var dataReq = {
                    formName: dataAssetRequest.formName,
                    noDok: "BSS-FRM-SM-016",
                    tglDok: "01-01-2023",
                    area: inputArea.val(),
                    noDoc: noDoc.text(),
                    tglDoc: formatTgl(),
                    replacement: checkReplacement.checked,
                    additional: checkAdditional.checked,
                    budgeted: checkBudgeted.checked,
                    notBudgeted: checkNotBudgeted.checked,
                    department: inputDepartment.val(),
                    project: inputProject.val(),
                    area: inputArea.val(),
                    reasonPurchase: reasonpurchase.val(),
                    estimatedReadyAtSite: estimatedReadyAtSite.val(),
                    item: dataAssetRequest.item,
                    estimatedIdr: estimatedIdr.val(),
                    estimatedUsd: estimatedUsd.val(),
                    estimatedCny: estimatedCny.val(),
                    refDoc: refDoc.val(),
                    requestedBy: requestornik.text(),
                    item: dataAssetRequest.item,
                    totalPrice: totalPrice.text()
                }
                axios.post('/add-asset-request', dataReq, {
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                })
                .then(function (response) {
                    console.log(response.data)
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
                });
                // submitAssetRequest(dataReq);
            })
        })
    </script>
@endsection
