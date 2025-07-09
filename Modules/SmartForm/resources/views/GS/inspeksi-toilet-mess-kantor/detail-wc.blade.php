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
        .select2-container {
            box-sizing: border-box;
            display: block;
            margin: 0;
            position: relative;
            width: 500px !important;
        }

        .select2-selection {
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px;
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 32px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-selection__rendered {
            line-height: 30px;
        }

        .select2-results__option {
            padding: 6px 12px;
        }

        .select2-results__option--highlighted {
            background-color: #3875d7;
            color: white;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form class="card my-4" method="POST" id="inspectionForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="inspeksi_id" value="{{ $data->id }}">
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
                                        <td>{!! \Modules\SmartForm\helpers\SiteHelper::renderSiteSelect('job_site', $data->nama_site ?? null, false, true, 'job_site', 'form-control') !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Departemen</td>
                                        <td>
                                            <select class="form-select form-select-sm input-text" aria-label="Default select example" id="dept" name="dept">
                                            <option value="" selected>-- Pilih Departemen --</option>
                                            <option value="SHE" {{ $data->dept == 'SHE' ? 'selected' : '' }}>SHE</option>
                                            <option value="GS" {{ $data->dept == 'GS' ? 'selected' : '' }}>GS</option>
                                        </select>
                                    </td>
                                    <tr>
                                        <td>Shift</td>
                                        <td>
                                            {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', $data->shift ?? null, false, true, 'shift', 'form-select form-select-sm input-text') !!}
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
                                        <td><input type="text" class="input-text w-full" value="{{ $data->loker }}" id="loker" name="loker"></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Inspektor</td>
                                        <td><input type="number" onkeypress="return event.charCode >= 48" value="{{ $data->jml_ins }}" min="1" class="input-text w-half" id="jml_ins" name="jml_ins"></td>
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
                                                            <input class="form-check-input" type="radio" id="q{{ $question->ID }}_Ya" name="q{{ $question->ID }}" value="Ya"
                                                                {{ $question->jawaban == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="q{{ $question->ID }}_Ya">Ya</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="q{{ $question->ID }}_Tidak" name="q{{ $question->ID }}" value="Tidak"
                                                                {{ $question->jawaban == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="q{{ $question->ID }}_Tidak">Tidak</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="q{{ $question->ID }}_resiko" name="q{{ $question->ID }}_resiko"
                                                            value="{{ $question->resiko ?? '' }}" placeholder="Tingkat Resiko">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="q{{ $question->ID }}_keterangan" name="q{{ $question->ID }}_keterangan"
                                                            value="{{ $question->keterangan ?? '' }}" placeholder="Keterangan">
                                                    </td>
                                                    <input type="hidden" id="q{{ $question->ID }}_category" name="q{{ $question->ID }}_category" value="{{ $question->category }}">
                                                    <input type="hidden" id="q{{ $question->ID }}_pertanyaan" name="q{{ $question->ID }}_pertanyaan" value="{{ $question->ID }}">
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="row mt-5">
                            <div class="col-6 ">
                                <div class="input-group input-group-static mb-3">
                                    <label for="dibuat" class="ms-0" style="width: 150px;">Diperiksa oleh</label>
                                    <select name="checked_by" id="checked_by" class="form-control" required>
                                        <option disabled selected>-- Select Checked --</option>
                                        @foreach ($approvalList as $user)
                                            <option value="{{ $user->nik }}"
                                                {{ old('checked', $data->checked_by ?? '') == $user->nik ? 'selected' : '' }}>
                                                {{ $user->nama }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static mb-3">
                                    <label for="diperiksa" class="ms-0" style="width: 150px;">Diperiksa ulang oleh</label>
                                    <select name="validated_by" id="validated_by" class="form-control" required>
                                        <option disabled selected>-- Select Approval --</option>
                                        @foreach ($approvalList as $user)
                                            <option value="{{ $user->nik }}"
                                                {{ old('validated', $data->validated_by ?? '') == $user->nik ? 'selected' : '' }}>
                                                {{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-static mb-3">
                                    <label for="diperiksa" class="ms-0" style="width: 150px;">Mengetahui</label>
                                    <select name="mengetahui" id="mengetahui" class="form-control" required>
                                        <option disabled selected>-- Select Approval --</option>
                                        @foreach ($approvalList as $user)
                                            <option value="{{ $user->nik }}"
                                                {{ old('mengetahui', $data->mengetahui ?? '') == $user->nik ? 'selected' : '' }}>
                                                {{ $user->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-actions">
                                        <a href="{{ route('dashboard-wc') }}"
                                            class="btn btn-secondary">Cancel</a>
                                        <button type="button" class="btn btn-primary" id="btnSubmit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#job_site').select2({width: '100%'});
        $('#shift').select2({width: '100%'});
        $('#dept').select2({width: '100%'});
        $('#checked_by').select2({width: '100%'});
        $('#validated_by').select2({width: '100%'});
        $('#mengetahui').select2({width: '100%'});
        $('#btnSubmit').on('click', function (e) {
            e.preventDefault();

            let inspeksiId = $('#inspeksi_id').val(); // Ambil ID inspeksi
            let formData = {
                inspeksi_id: inspeksiId,
                nama_site: $('#job_site').val(),
                dept: $('#dept').val(),
                shift: $('#shift').val(),
                loker: $('#loker').val(),
                jml_ins: $('#jml_ins').val(),
                checked_by: $('#checked_by').val(),
                validated_by: $('#validated_by').val(),
                mengetahui: $('#mengetahui').val(),
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

                console.log('Question ID:', questionID);

                if (questionID) {
                    formData.pertanyaan_id.push(questionID);
                    formData.jawaban.push(jawaban);
                    formData.resiko.push(resiko);
                    formData.keterangan.push(keterangan);
                    formData.category.push(category);
                }
            });

            console.log('Form Data:', formData);
            // process.exit(0);


            $.ajax({
                url: "{{ route('wc-update', ['id' => '__id__']) }}".replace('__id__', inspeksiId),
                type: "PUT",
                data: JSON.stringify(formData),
                contentType: "application/json",
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#btnSubmit').prop('disabled', true).text('Menyimpan...');
                    console.log('AJAX request is being sent...');
                },
                success: function (response) {
                    console.log('Success Response:', response);
                    alert('Data berhasil diperbarui!');
                    // window.location.href = response.redirect;
                    window.location.href = "{{ route('dashboard-wc') }}";
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    });
                },
                error: function (xhr) {
                    console.log('Error Response:', xhr.responseJSON);
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Terjadi kesalahan:\n";
                    for (let field in errors) {
                        errorMessage += `- ${errors[field][0]}\n`;
                    }
                    alert(errorMessage);
                },
                complete: function () {
                    $('#btnSubmit').prop('disabled', false).text('Submit Form');
                    console.log('AJAX request completed');
                }
            });
        });
    });
</script>

@endsection
