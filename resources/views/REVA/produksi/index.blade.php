<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.css">
    <style>
        .btn-submit-layout {
            position: relative;
            display: flex;
            align-items: end;
            justify-content: end;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="inputJenisReport">Jenis Report</label>
                <select name="jenis" id="inputJenisReport" class="form-select">
                    <option value="" selected>Pilih Jenis Report</option>
                    <option value="OB">OB</option>
                    <option value="CONST">Constraint</option>
                    <option value="EVENT">Event</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="inputSite">Site</label>
                <select name="jenis" id="inputSite" class="form-select">
                    <option value="" selected>Pilih Site</option>
                    @foreach ($listSite as $key => $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="inputStartDate">Start Date</label>
                <input type="date" class="form-control" id="inputStartDate">
            
            </div>
            <div class="form-group col-md-3">
                <label for="inputEndDate">End Date</label>
                <input type="date" class="form-control" id="inputEndDate">
            </div>
            <div class="btn-submit-layout">
                <button type="button" class="btn btn-primary mt-3" onclick="fetchReport(this)">Submit</button>
            </div>
            <table id="table-data" class="table"></table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.5/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script>
        function validateDates(startDate, endDate) {
            var start = new Date(startDate);
            var end = new Date(endDate);
            
            if (end < start) {
                alert("End date cannot be earlier than start date.");
                return false; // Invalid
            }
            return true; // Valid
        }

        function validateInput() {
            var validationData = {
                valid: false,
                errors : [],
                data: {
                    jenisReport: $('#inputJenisReport').val(),
                    site: $('#inputSite').val(),
                    startDate: $('#inputStartDate').val(),
                    endDate: $('#inputEndDate').val(),
                }  
            }

            if(validationData.data.jenisReport == "" || validationData.data.jenisReport == null) validationData.errors.push("Jenis Report tidak boleh kosong")
            if(validationData.data.site == "" || validationData.data.site == null) validationData.errors.push("SITE tidak boleh kosong")
            if(validationData.data.startDate == "" || validationData.data.startDate == null) validationData.errors.push("Tanggal Mulai tidak boleh kosong")
            if(validationData.data.endDate == "" || validationData.data.endDate == null) validationData.errors.push("Tanggal Akhir tidak boleh kosong")
            if(!validateDates(validationData.data.startDate, validationData.data.endDate)) validationData.errors.push("Tanggal Akhir sebelum Tanggal Awal")

            validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

            return validationData
        }

        function fetchReport(e) {
            e.disabled = true
            var inputJenisReport = $("#inputJenisReport").val()
            var inputSite = $("#inputSite").val()
            var inputStartDate = $("#inputStartDate").val()
            var inputEndDate = $("#inputEndDate").val()
            var validationInput = validateInput();

            var baseURL = "/reva";
            if(inputJenisReport == "OB") baseURL = baseURL + "/api/ob"
            if(inputJenisReport == "CONST") baseURL = baseURL + "/api/const"
            if(inputJenisReport == "EVENT") baseURL = baseURL + "/api/event"
            baseURL = baseURL + "?site=" + inputSite + "&startDate=" + inputStartDate + "&endDate=" + inputEndDate 

            var reqBody = {
                'site': inputSite,
                'startDate': inputStartDate,
                'endDate': inputEndDate
            }

            if(validationInput.valid) {
                // console.log(reqBody)
                axios(
                    {
                        url: baseURL,
                        method: 'get',
                        data: reqBody
                    }
                )
                    .then(function(resp) {
                        let dataPopUp = {
                            title: '',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        }

                        if(resp.data.isSuccess) {
                            $('#table-data').bootstrapTable("destroy")
                            var dataColumn = []
                            resp.data.column.forEach(element => {
                                dataColumn.push({
                                    field: element,
                                    title: element
                                })
                            });

                            $('#table-data').bootstrapTable({
                                columns: dataColumn, // Kolom dinamis
                                data: resp.data.data,
                                showExport: true, // Aktifkan fitur ekspor
                                exportTypes: ['csv', 'excel', 'json'], // Format ekspor yang tersedia
                                exportDataType: 'all',
                                exportOptions: {
                                    fileName: inputJenisReport + "_from_" + inputStartDate + "_to_" + inputEndDate
                                }
                            })
                            dataPopUp.icon='success'
                            dataPopUp.title='Berhasil!'
                            dataPopUp.text = resp.data.message
                        } else {
                            dataPopUp.icon='error'
                            dataPopUp.title='Gagal!'
                            dataPopUp.html= resp.data.errors.join("<br>")
                        }

                        Swal.fire(dataPopUp)
                    })
                    .catch(function(err) {
                        // console.log(err)
                        Swal.fire({
                            title: 'Error!',
                            html: 'Terjadi kesalahan, coba beberapa saat lagi',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    })
                    .finally(function() {
                        e.disabled = false
                    })
            } else {
                Swal.fire({
                    title: 'Error!',
                    html: validationInput.errors.join("<br>"),
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        }
        
    </script>
</body>
</html>