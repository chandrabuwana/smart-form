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
            <form class="card my-4" method="POST" action="/inspeksi-toilet-mess-kantor/store-form" id="inspectionForm">
                @csrf
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Form Inspeksi Toilet Mess Kantor</h6>
                        </div>
                    </div>

                    <div class="card-body my-1">
                        <div class="row gx-4">
                            <div class="col-auto my-auto ms-3">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="w-full">
                                    <td>
                                        <input type="text" class="input-text w-full" id="iKupon" name="iKupon" hidden>
                                    </td>
                                    <tr>
                                        <!-- <td>Date</td> -->
                                        <td><input type="text" class="input-text w-full" id="tglDoc" name="tglDoc" hidden></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Site</td>
                                        <td><input type="text" class="input-text w-full" id="nama_site" name="nama_site"></td>
                                    </tr>
                                    <tr>
                                        <td>Departemen</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dept" name="dept">
                                            <option value="" selected>-- Pilih Departemen --</option>
                                                <option value="SHE">SHE</option>
                                                <option value="GS">GS</option>
                                        </select>
                                    </td>
                                    <tr>
                                        <td>Shift</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="shift" name="shift">
                                                <option value="" selected>-- Pilih Shift --</option>
                                                <option value="I">I</option>
                                                <option value="II">II</option>
                                                <option value="III">III</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td>NIK</td> -->
                                        <td hidden><input type="text" class="input-text w-full" id="i_nik" value="{{ session('user_id') }}" disabled></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <table class="w-full">
                                    <tr>
                                        <td>Lokasi Kerja</td>
                                        <td><input type="text" class="input-text w-full" id="loker" name="loker"></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Inspektor</td>
                                        <td><input type="number" onkeypress="return event.charCode >= 48" min="1" class="input-text w-half" id="jml_ins" name="jml_ins"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @foreach($questions as $category => $items)
                            <div class="mb-1" style="padding:1rem">
                                <label class="form-label">INSPEKSI {{ strtoupper($category) }} CHECKLIST</label>
                                <div style="background-color:orange;">
                                    <label class="form-label" style="color:white">HAL UNTUK DIPERIKSA - {{ strtoupper($category) }} (YA/TIDAK)</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                        <table class="w-full">
                                            @foreach($items as $index => $question)
                                                <tr>
                                                    <td style="width:2%">{{ $loop->iteration }}.</td>
                                                    <td style="width:50%; white-space: pre-line;">{{ $question->pertanyaan }}</td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="q{{ $question->ID }}_Ya" name="q{{ $question->ID }}" value="Ya" required>
                                                            <label class="form-check-label" for="q{{ $question->ID }}_Ya">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="q{{ $question->ID }}_Tidak" name="q{{ $question->ID }}" value="Tidak" required>
                                                            <label class="form-check-label" for="q{{ $question->ID }}_Tidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="q{{ $question->ID }}_resiko" name="q{{ $question->ID }}_resiko" placeholder="Tingkat Resiko">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="q{{ $question->ID }}_keterangan" name="q{{ $question->ID }}_keterangan" placeholder="Keterangan">
                                                    </td>
                                                    <input type="hidden" id="q{{ $question->ID }}_category" name="q{{ $question->ID }}_category" value="{{ $question->category }}">
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row mb-3">
                            @foreach ($dropdowns as $name => $label)
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <label class="form-label col-auto" style="width: 150px;">{{ $label }}</label>
                                        <select name="{{ $name }}" class="form-select form-select-sm flex-grow-1">
                                            <option value="">-- Pilih --</option>
                                            @foreach($approvalList as $user)
                                                <option value="{{ $user->nama }}">
                                                    {{ $user->nama }} ({{ $user->nik }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmit">
                                    <i class="fas fa-save"></i>
                                    Submit Form
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('custom-js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    $('#btnSubmit').on('click', function (e) {
        e.preventDefault();

        let formData = {
            nama_site: $('#nama_site').val(),
            dept: $('#dept').val(),
            shift: $('#shift').val(),
            loker: $('#loker').val(),
            jml_ins: $('#jml_ins').val(),
            diinspeksi_oleh: $('[name="Diinspeksi"]').val(),
            diinspeksi_ulang_oleh: $('[name="DiinspeksiUlang"]').val(),
            mengetahui: $('[name="Mengetahui"]').val(),
            pertanyaan_id: [],
            jawaban: [],
            resiko: [],
            keterangan: [],
            category: []
        };

        let tglDoc = $('#tglDoc').val();
        if (tglDoc) {
            formData.tgl_doc = tglDoc;
        }

        $("table tr").each(function () {
            let radioInput = $(this).find("input[type=radio]").first();
            if (!radioInput.length) return;

            let questionID = radioInput.attr("name")?.replace("q", "");
            let jawaban = $("input[name=q" + questionID + "]:checked").val() || null;
            let resiko = $("#q" + questionID + "_resiko").val() || null;
            let keterangan = $("#q" + questionID + "_keterangan").val() || null;
            let category = $("#q" + questionID + "_category").val() || null;

            if (questionID) {
                formData.pertanyaan_id.push(questionID);
                formData.jawaban.push(jawaban);
                formData.resiko.push(resiko);
                formData.keterangan.push(keterangan);
                formData.category.push(category);
            }
        });

        console.log(formData);

        $.ajax({
            url: "{{ route('store-wc') }}",
            type: "POST",
            data: JSON.stringify(formData),
            contentType: "application/json",
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $('#btnSubmit').prop('disabled', true).text('Menyimpan...');
            },
            success: function (response) {
                console.log('meta : ' + $('meta[name="csrf-token"]').attr('content'));
                // console.log(response)
                alert('Data berhasil disimpan!');
                // location.reload();
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "Terjadi kesalahan:\n";
                for (let field in errors) {
                    errorMessage += `- ${errors[field][0]}\n`;
                }
                alert(errorMessage);
            },
            complete: function () {
                $('#btnSubmit').prop('disabled', false).text('Submit Form');
            }
        });
    });
});
</script>
@endsection
