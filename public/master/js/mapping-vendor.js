var modalElementJadwal = $("#modalAddJadwal")
var filterParams = {
    query: null
}

$('#filterSite').on("select2:select", function (e) { 
    filterParams.query = e.params.data.id
});

function fetchVendorByLokasiAndWaktu(site, lokasi, cb=function(site) {}) {
    var qSite = site ? "site="+site : ""
    var qLokasi = lokasi ? "lokasi="+lokasi : ""
    // var qWaktuPemesanan = waktu_pemesanan ? "waktu_pemesanan="+waktu_pemesanan : ""
    var qURL = "/helper-vendor-waktu-lokasi?" + qSite + "&" + qLokasi

    axios.get("/bss-form/catering/vendor" + qURL, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .then(function(data) {
        // console.log(data)
        var optionLokasi = []
        // optionLokasi.push(new Option("--- Cari Site ---", "", true, true))
        optionLokasi.push({
            id: "",
            text: "--- Cari Vendor ---"
        })

        data.data.data.forEach(element => {
            optionLokasi.push({
                id: element.id,
                text: element.text
            })

            // optionLokasi.push(new Option(element.text, element.id))
        });
        
        cb(optionLokasi)
    })
    .catch(function(err) {
        console.log(err)
    })
    .finally( function(){

    });
}

$('#addJenisPemesanan1').select2({
    theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
    dropdownParent: $('#addJenisPemesanan1').closest('.input-group'),
    // placeholder: '--- Pilih Waktu Pemesanan ---',
    data: [
        {id: "", text: "--- Pilih Waktu Pemesanan ---"},
        {id: "pagi", text: "Pagi"},
        {id: "siang", text: "Siang"},
        {id: "malam", text: "Malam"}
    ]
});

$("#addSite1").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addSite1").closest(".input-group"),
    placeholder: "--- Cari Site ---",
});

$("#addLokasi1").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addLokasi1").closest(".input-group"),
    placeholder: "--- Cari Site ---",
});

$("#addSite1").on("select2:select", function (e) {
    fetchLokasi(e.params.data.id, function (data) {
        $("#addLokasi1").empty();

        data.forEach(function (mess) {
            $("#addLokasi1").append(new Option(mess.text, mess.id));
        });

        $("#addLokasi1").trigger("change");
    });
});

$("#addLokasi1").on("select2:select", function (e) {
    $('#addJenisPemesanan1').val("").trigger('change')
    fetchVendorByLokasiAndWaktu($("#addSite1").val(), $("#addLokasi1").val(), function (data) {
        $("#addHari1").empty()
        $("#addHari2").empty()
        $("#addHari3").empty()
        $("#addHari4").empty()
        $("#addHari5").empty()
        $("#addHari6").empty()
        $("#addHari7").empty()

        data.forEach(function (mess) {
            // $("#addLokasi1").append(new Option(mess.text, mess.id))
            $("#addHari1").append(new Option(mess.text, mess.id))
            $("#addHari2").append(new Option(mess.text, mess.id))
            $("#addHari3").append(new Option(mess.text, mess.id))
            $("#addHari4").append(new Option(mess.text, mess.id))
            $("#addHari5").append(new Option(mess.text, mess.id))
            $("#addHari6").append(new Option(mess.text, mess.id))
            $("#addHari7").append(new Option(mess.text, mess.id))
        });

        // $("#addLokasi1").trigger("change");
        $("#addHari1").trigger("change")
        $("#addHari2").trigger("change")
        $("#addHari3").trigger("change")
        $("#addHari4").trigger("change")
        $("#addHari5").trigger("change")
        $("#addHari6").trigger("change")
        $("#addHari7").trigger("change")
        
    })
})

$("#addLokasi1").on("select2:select", function (e) {
    
});

$("#addHari1").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari1").closest(".input-group"),
    placeholder: "--- Cari Vendor Senin ---",
    allowClear: true,
});

$("#addHari2").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari2").closest(".input-group"),
    placeholder: "--- Cari Vendor Selasa ---",
    allowClear: true,
});

$("#addHari3").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari3").closest(".input-group"),
    placeholder: "--- Cari Vendor Rabu ---",
    allowClear: true,
});

$("#addHari4").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari4").closest(".input-group"),
    placeholder: "--- Cari Vendor Kamis ---",
    allowClear: true,
});

$("#addHari5").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari5").closest(".input-group"),
    placeholder: "--- Cari Vendor Jumat ---",
    allowClear: true,
});

$("#addHari6").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari6").closest(".input-group"),
    placeholder: "--- Cari Vendor Sabtu ---",
    allowClear: true,
});

$("#addHari7").select2({
    theme: "bootstrap-5", // Menggunakan tema Bootstrap 5
    dropdownParent: $("#addHari7").closest(".input-group"),
    placeholder: "--- Cari Vendor Minggu ---",
    allowClear: true,
});

function openModalMapping(e) {
    modalElementJadwal.modal("show")
}

function validateAddMappingVendorDay() {
    var validationData = {
        valid: false,
        errors : [],
        data: {
            site: $('#addSite1').val(),
            lokasi: $('#addLokasi1').val(),
            jenisPemesanan: $('#addJenisPemesanan1').val(),
            vendorSenin: $("#addHari1").val(),
            vendorSelasa: $("#addHari2").val(),
            vendorRabu: $("#addHari3").val(),
            vendorKamis: $("#addHari4").val(),
            vendorJumat: $("#addHari5").val(),
            vendorSabtu: $("#addHari6").val(),
            vendorMinggu: $("#addHari7").val(),
        }  
    }

    // if(validationData.data.site == "" || validationData.data.site == null) validationData.errors.push("Site tidak boleh kosong")
    if(validationData.data.site == "" || validationData.data.site == null) validationData.errors.push("SITE tidak boleh kosong")
    if(validationData.data.lokasi == "" || validationData.data.lokasi == null) validationData.errors.push("Lokasi Vendor tidak boleh kosong")
    if(validationData.data.jenisPemesanan == "" || validationData.data.jenisPemesanan == null) validationData.errors.push("Waktu Makan tidak boleh kosong")

    validationData.errors.length > 0 ? validationData.valid = false : validationData.valid = true

    return validationData
}

function submitMappingVendorDay(e) {
    var _action = e.getAttribute('data-action')
    var _actionURL = _action == "edit" ? "/edit-mapping-vendor-day" : "/add-mapping-vendor-day"
    var _successMessage = _action == "edit" ? "Berhasil update mapping vendor" : "Berhasil menambahkan data mapping vendor"
    var _method = _action == "edit" ? "put" : "post"
    var submitURL = baseUrl + _actionURL
    
    var validateInputMapping = validateAddMappingVendorDay()
    var header = {
        "DATA-ACTION": _action
    }

    $('#addLokasi').select2({
        theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
        dropdownParent: $('#addLokasi').closest('.input-group'),
        placeholder: '--- Cari Kamar ---'
    });
    
    if(validateInputMapping.valid) {
        e.disabled = true
        if(_action == "edit") validateInputMapping.data.idMapping = $("#id_mapping_day").val()
        axios(
            {
                url: submitURL,
                method: _method,
                data: validateInputMapping.data,
                headers: {
                    "DATA-ACTION": _action,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        
            }
        )
        .then(function(resp) {
            var errorResp = [];
            var dataAlert = {};

            if(resp.data.isSuccess) {
                // clearModal()
                dataAlert = {
                    icon: 'success',
                    title: "Berhasil!",
                    text: _successMessage,
                }
                $("#table-dashboard-vendor-day").bootstrapTable('refresh')
            } else {
                resp.data.errorMessage.forEach(element => {
                    errorResp.push("<span>" + element + "</span>")
                });

                dataAlert = {
                    icon: 'error',
                    title: "Gagal!",
                    html: errorResp.join("<br>")
                }

            }

            Swal.fire(dataAlert)
        })
        .catch(function(err) {
            console.log(err)
            Swal.fire({
                icon: 'error',
                title: "Gagal!",
                text: 'Terjadi kesalahan, coba beberapa saat lagi',
            })
        })
        .finally(function() {
            e.disabled = false
        })
    } else {
        var errorList = []
        validateInputMapping.errors.forEach(function(data) {
            errorList.push("<span>" + data +"</span>")
        })

        Swal.fire({
            icon: 'error',
            title: 'Mandatory field kosong!',
            html: errorList.join("<br>"),
        })
    }
    
}

function getDataMappingVendorDay(params) {
    var listVendorMappingURL = "/bss-form/catering/vendor" + '/list-vendor-mapping-day'
    // console.log("halojuga")
    params.data.query = filterParams.query
    // params.data.mess = filter.mess

    // if(params.data.site != null || params.data.mess != null) {
        $.get(listVendorMappingURL + '?' + $.param(params.data)).then(function(res) {
            params.success(res.data)
        })
    // } else {
    //     params.success([])
    // }
}

function actionFormatterDay(value, row, index) {
    // console.log(row)

    var _id = ", '"+ row.id + "'"
    var _site = ", '"+ row.site + "'"
    var _lokasi = ", '"+ row.lokasi + "'"
    var _waktu_makan = ", '"+ row.waktu_makan + "'"
    var _senin = ", '"+ row.senin + "'"
    var _selasa = ", '"+ row.selasa + "'"
    var _rabu = ", '"+ row.rabu + "'"
    var _kamis = ", '"+ row.kamis + "'"
    var _jumat = ", '"+ row.jumat + "'"
    var _sabtu = ", '"+ row.sabtu + "'"
    var _minggu = ", '"+ row.minggu + "'"

    var _clickEvent = 'onclick="modalDetailDay(this'  + _id + _site + _lokasi + _waktu_makan + _senin + _selasa + _rabu + _kamis + _jumat + _sabtu + _minggu +')"'
    var _clickEventDelete = 'onclick="actionDeleteDay(this'  + _id +')"'

    var btnDetail = '<a href="#" '+ _clickEvent +' data-action="detail" data-show="false" data-url="" style="color: black;margin: 0px 4px;"><i class="fa fa-info-circle cursor-pointer"></i></a>';
    var btnEdit = '<a href="#" '+ _clickEvent +' data-caption="Simpan" data-action="edit" data-url="" data-show="true" style="color: grey;margin: 0px 4px;"><i class="fa fa-pen cursor-pointer"></i></a>';
    var btnHapus = '<a href="#" '+ _clickEventDelete +' data-caption="" data-url="" data-show="true" data-action="delete" style="color: red;margin: 0px 4px;"><i class="fa-solid fa-trash-can cursor-pointer"></i></a>';
    
    return btnDetail + btnEdit + btnHapus
}

function modalDetailDay(e, id, site, lokasi, waktu_makan, senin, selasa, rabu, kamis, jumat, sabtu, minggu) {
    console.log({
        id: id,
        site: site,
        lokasi: lokasi,
        waktu_makan: waktu_makan,
        senin: senin,
        selasa: selasa,
        rabu: rabu,
        kamis: kamis,
        jumat: jumat,
        sabtu: sabtu,
        minggu: minggu
    })

    $("#addSite1").val(site).trigger("change")
    $("#addSite1").trigger({
        type: "select2:select",
        params: {data: {id: site}}
    })
    fetchLokasi(site, function(data) {
        $('#addLokasi1').empty();

        data.forEach(function(mess) {
            $('#addLokasi1').append(new Option(mess.text, mess.id))
        })
        $('#addLokasi1').val(lokasi).trigger('change')
        $('#addLokasi1').trigger('change')
        
        fetchVendorByLokasiAndWaktu($("#addSite1").val(), $("#addLokasi1").val(), function (data) {
            $("#addHari1").empty()
            $("#addHari2").empty()
            $("#addHari3").empty()
            $("#addHari4").empty()
            $("#addHari5").empty()
            $("#addHari6").empty()
            $("#addHari7").empty()
            $("#addHari1").append(new Option("-- Cari Vendor --", ""))
    
            data.forEach(function (mess) {
                // $("#addLokasi1").append(new Option(mess.text, mess.id))
                $("#addHari1").append(new Option(mess.text, mess.id))
                $("#addHari2").append(new Option(mess.text, mess.id))
                $("#addHari3").append(new Option(mess.text, mess.id))
                $("#addHari4").append(new Option(mess.text, mess.id))
                $("#addHari5").append(new Option(mess.text, mess.id))
                $("#addHari6").append(new Option(mess.text, mess.id))
                $("#addHari7").append(new Option(mess.text, mess.id))
            });
    
            // $("#addLokasi1").trigger("change");
            $("#addHari1").val(senin).trigger("change")
            $("#addHari2").val(selasa).trigger("change")
            $("#addHari3").val(rabu).trigger("change")
            $("#addHari4").val(kamis).trigger("change")
            $("#addHari5").val(jumat).trigger("change")
            $("#addHari6").val(sabtu).trigger("change")
            $("#addHari7").val(minggu).trigger("change")
            
        })
    })

    $("#addJenisPemesanan1").val(waktu_makan).trigger("change")
    $("#btnSubmitMappingDay").attr("data-action", "edit")
    $("#id_mapping_day").val(id)
    modalElementJadwal.modal('show')
}

function clearModalDay() {
    $('#addSite1').val(null).trigger("change")
    $('#addLokasi1').val(null).trigger("change")
    $('#addJenisPemesanan1').val(null).trigger("change")
    $('#addHari1').val(null).trigger("change")
    $('#addHari2').val(null).trigger("change")
    $('#addHari3').val(null).trigger("change")
    $('#addHari4').val(null).trigger("change")
    $('#addHari5').val(null).trigger("change")
    $('#addHari6').val(null).trigger("change")
    $('#addHari7').val(null).trigger("change")
    // $('#exampleModalToggleLabel').text("Tambah mapping vendor")
}

modalElementJadwal.on('hide.bs.modal', function (e) {
    // console.log($("#btnSubmitMapping").attr("data-action"))
    if($("#btnSubmitMappingDay").attr("data-action") == "edit" ) clearModalDay()
    $("#btnSubmitMapping").attr("data-action", "add")
})

function actionDeleteDay(e, _id) {
    Swal.fire({
        icon: "warning",
        title: "Apakah yakin ingin menghapus?",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        cancelButtonColor: "#3085d6",
        confirmButtonColor: "#d33"
    }).then(function(result) {
        if (result.isConfirmed) {
            axios(
                {
                    url: baseUrl + "/delete-mapping-vendor-day",
                    method: "delete",
                    data: {
                        id: _id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
            )
            .then(function(resp) {
                var dataAlert = {};
                if(resp.data.isSuccess) {
                    clearModal()
                    dataAlert = {
                        icon: 'success',
                        title: "Berhasil!",
                        text: resp.data.message || "",
                    }
                    $("#table-dashboard-vendor-day").bootstrapTable('refresh')
                } else {
                    dataAlert = {
                        icon: 'error',
                        title: "Gagal!",
                        text: resp.data.message || "",
                    }
                }
                Swal.fire(dataAlert)
            })
            .catch(function(err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "Terjadi kesalahan, coba beberapa saat lagi"
                })
            })
        }
    })
    
}

function applyFilter(e) {
    $("#table-dashboard-vendor-day").bootstrapTable('refresh')
}

function resetFilter(e) {
    filterParams.query = null
    $("#table-dashboard-vendor-day").bootstrapTable('refresh')
}