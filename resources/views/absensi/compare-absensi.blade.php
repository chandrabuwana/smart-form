<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coba</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
    <style>
        p {
            margin: 0;
        }
        .center-container {
            display: none;
            align-items: center;
            justify-content: center;
            height: 8em;
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #0000001f
        }
    </style>
</head>
<body>
    <div class="text-center center-container" id="loading-animation">
        <div class="spinner-border" style="width: 10rem; height: 10rem; border-width: 1rem" role="status">
            <span class="sr-only"></span>
          </div>
    </div>
    <label for="">Pilih Tanggal</label>
    <input type="date" name="tgl_absen" id="tgl_absen">
    <table id="table"
        id="list-absensi" data-toggle="table"
        data-side-pagination="server" data-page-list="[10, 25, 50, 100, all]" 
        data-sortable="true" data-content-type="application/json" data-data-type="json" 
        data-pagination="true" data-row-style="rowStyle" data-height="800" data-show-export="true">

        <thead>
            <tr>
                <th data-field="absensi" data-formatter="absensiFormatter" data-cell-style="cellStyle">Absensi</th>
                <th data-field="fingerlog" data-cell-style="cellStyleFinger">Fingerlog</th>
            </tr>
        </thead>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/tableExport.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.29.0/libs/jsPDF/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.23.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script>
        var inputTanggal = document.getElementById("tgl_absen")
        var loadingAnimation = document.getElementById("loading-animation")
        var $table = $('#table')

        inputTanggal.addEventListener("change", function(e) {
            // console.log(e.target.value)
            fetchAbsensi(new Date(e.target.value), false)
        })

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function cellStyle(value, row, index) {
            var parsedAbsensi = {}
            // console.log(row)

            if (row.absensi != "") {
                parsedAbsensi = JSON.parse(row.absensi); 
                if(parsedAbsensi.jam != row.fingerlog) {
                    return {
                        css: {
                            "background-color": "red",
                            color: "white"
                        }
                    }
                }
            }
            return {}
        }
        function cellStyleFinger(value, row, index) {
            var parsedAbsensi = {}
            // console.log(row)

            if (row.absensi != "") {
                parsedAbsensi = JSON.parse(row.absensi); 
                if(parsedAbsensi.jam != row.fingerlog) {
                    return {
                        css: {
                            "background-color": "red",
                            color: "white",
                            "vertical-align": "top"
                        }
                    }
                }
            }
            return {
                css: {
                    "vertical-align": "top"
                }
            }
        }


        function rowStyle(row, index) {
            var parsedAbsensi = {}
            var style = {}
            // console.log(row.absensi == "")
            if(row.absensi != "") {
                // console.log(row.absensi)
                parsedAbsensi = JSON.parse(row.absensi); 
                if(parsedAbsensi.jam != row.fingerlog) {
                    style = {
                        color: "red"
                    }
                }
            }

            return style
        }
        
        function absensiFormatter(value) {
            // console.log(value)
            var parsedJson = {}
            if(value != "") {
                parsedJson = JSON.parse(value); 
                return '<p>Nik: ' + parsedJson.nik + '</p><br>' + '<p>Nama: ' + parsedJson.nama + '</p><br>' + '<p>tanggal: ' + parsedJson.tanggal + '</p><br>' + '<p>Jam: ' + parsedJson.jam + '</p>';
                // return '<p>Nik: ' + parsedJson.nik + '</p>' + '<p>Nama: ' + parsedJson.nama + '</p>' + '<p>tanggal: ' + parsedJson.tanggal + '</p>' + '<p>Jam: ' + parsedJson.jam + '</p>' + '<p>Dept: ' + parsedJson.kodedp + '</p>';
            } else {
                return value;
            }
        }

        function fetchAbsensi(tgl, isOnload) {
            // var tgl = new Date()
            loadingAnimation.style.display = "flex";
            if(!isOnload) {
                $table.bootstrapTable('removeAll')
            }
            var tahun = tgl.getFullYear();
            var bulan = new String(tgl.getMonth()+1).toString()
            bulan = bulan.length < 2 ? "0"+bulan : bulan;
            var hari = new String(tgl.getDate())
            hari = hari.length < 2 ? "0"+hari : hari;
            var tanggal = tahun + "-" + bulan + "-" + hari;

            axios.get('/compare-absensi?tanggalAbsensi='+tanggal, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            })
            .then(function (response) {
                // console.log(response.data.data.rows)
                
                if(!isOnload) {
                    Swal.fire({
                        icon: response.data.isSuccess ? "success" : "error",
                        title: response.data.isSuccess ? 'Berhasil!' : "Gagal!",
                        text: response.data.message,
                    }).then((result) => {
                        // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                    })
                }
                var data_tabel = []
                for (const absensi in response.data.data.rows) {
                    let jam = "";
                    if(response.data.data.rows[absensi].absensi.Jam) {
                        jam = response.data.data.rows[absensi].absensi.Jam.replace(".", ":")
                    }
                    
                    // console.log(response.data.data.rows[absensi])
                    var leftSide = ""
                    if(absensi < 1) {
                        leftSide = JSON.stringify({
                            nik: response.data.data.rows[absensi].nik,
                            nama: response.data.data.rows[absensi].nama,
                            tanggal: response.data.data.rows[absensi].absensi.tanggal,
                            jam: jam,
                            // kodedp: response.data.data.rows[absensi].finger.kodedp
                        })
                    } else {
                        if(response.data.data.rows[absensi].absensi.Jam != response.data.data.rows[absensi-1].absensi.Jam ) {
                            leftSide = JSON.stringify({
                                nik: response.data.data.rows[absensi].nik,
                                nama: response.data.data.rows[absensi].nama,
                                tanggal: response.data.data.rows[absensi].absensi.tanggal,
                                jam: jam,
                                // kodedp: response.data.data.rows[absensi].finger.kodedp
                            })
                        }
                    }
                    data_tabel.push({
                        absensi: leftSide,
                        fingerlog: response.data.data.rows[absensi].finger.jam
                    })
                }
                // console.log(data_tabel)
                $table.bootstrapTable('append', data_tabel)
            })
            .catch(function (error) {
                console.log(error)
                // Swal.fire({
                //     icon: 'errror',
                //     title: 'Gagal!',
                //     text: error.data.message,
                // }).then((result) => {
                //     // window.location.href = `/get-form-detail?no_doc=${response.data.data.no_doc}`;
                // })
            })
            .finally( function(){
                loadingAnimation.style.display = "none"
            });
        }
        
        inputTanggal.value = getTodayDate();
        
        fetchAbsensi(new Date(), true)
    </script>
</body>
</html>