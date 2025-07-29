@extends('master.master_page')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                        <span class="alert-icon align-middle"><i class="fas fa-check-circle"></i></span>
                        <span class="alert-text">{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible text-white fade show" role="alert">
                        <span class="alert-icon align-middle"><i class="fas fa-exclamation-circle"></i></span>
                        <span class="alert-text">{{ session('error') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                <div class="card">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Form P2H UNIT CMT - LGMG</h6>
                        </div>
                    </div>

                    <form id="formXCMG900" method="POST">
                        @csrf
                        <div class="mx-3">

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama_operator" class="ms-0">Nama Operator</label>
                                        <input type="text" class="form-control" id="nama_operator" name="nama_operator" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <tr>
                                        <td>Shift</td>
                                        <td>
                                            {!! \Modules\SmartForm\helpers\ShiftHelper::renderShiftSelect('shift', null, false, true, 'shift', 'form-control select2') !!}
                                        </td>
                                    </tr>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nrp" class="ms-0">NRP</label>
                                        <input type="text" class="form-control" id="nrp" name="nrp"
                                            >
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="fuel_awal" class="ms-0">FUEL AWAL</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="fuel_awal" name="fuel_awal" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="fuel_akhir" class="ms-0">FUEL AKHIR</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="fuel_akhir" name="fuel_akhir" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="tanggal" class="ms-0">TANGGAL</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="no_unit" class="ms-0">NO UNIT</label>
                                        <input type="text" class="form-control" id="no_unit" name="no_unit">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="km_star" class="ms-0">KM STAR</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="km_star" name="km_star" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="km_akhir" class="ms-0">KM AKHIR</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="km_akhir" name="km_akhir" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hm_star" class="ms-0">HM STAR</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="hm_star" name="hm_star" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="hm_akhir" class="ms-0">HM AKHIR</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="hm_akhir" name="hm_akhir" pattern="\d+(\.\d{1,2})?" title="Format: 0.00 (maksimal 2 angka desimal)">
                                    </div>
                                </div>
                            </div>

                            @foreach($pertanyaan as $category => $items)
                                <div class="mb-1" style="padding:1rem">
                                    <div style="background-color:orange;">
                                        <label class="form-label" style="color:white">{{ str_replace('_', ' ', strtoupper($category)) }}</label>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="card col-md-12 was-validated">
                                            <table class="w-full">
                                                <tbody>
                                                    @foreach($items as $index => $question)
                                                        <tr>
                                                            <td style="width:2%">{{ $loop->iteration }}.</td>
                                                            <td style="width:50%; white-space: pre-line;">{{ $question->pertanyaan }}</td>
                                                            <td>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="q{{ $question->id }}_Ya" name="q{{ $question->id }}" value="Ya">
                                                                    <label class="form-check-label" for="q{{ $question->id }}_Ya">Awal</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" id="q{{ $question->id }}_Tidak" name="q{{ $question->id }}" value="Tidak">
                                                                    <label class="form-check-label" for="q{{ $question->id }}_Tidak">Akhir</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <input type="hidden" name="pertanyaan_id[]" value="{{ $question->id }}">
                                                        <input type="hidden" name="q{{ $question->id }}_category" id="q{{ $question->id }}_category" value="{{ $question->category }}">
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mb-1" style="padding:1rem">
                                <div style="background-color:orange;">
                                    <label class="form-label" style="color:white">KETERANGAN</label>
                                </div>
                                <div class="row mb-2">
                                    <div class="card col-md-12 was-validated">
                                        <table class="w-full">
                                            <tbody>
                                                @for ($i = 1; $i <= 4; $i++)
                                                    <tr>
                                                        <td>
                                                            <div class="input-group input-group-static mb-3">
                                                                <label for="keterangan{{ $i }}" class="ms-0">Keterangan {{ $i }}</label>
                                                                <input type="text" class="form-control" id="keterangan{{ $i }}" name="keterangan{{ $i }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                                <div class="row mt-5">
                                    <div class="col-6 ">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="diisi_oleh" class="ms-0">Diisi Oleh</label>
                                            <select name="diisi_oleh" id="diisi_oleh" class="form-control select2" required>
                                                <option disabled selected>-- Pilih --</option>
                                                @foreach ($approvalList as $user)
                                                    <option value="{{ $user->nik }}" {{ $user->nik == $session ? 'selected' : '' }}>{{ $user->nama }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-static mb-3">
                                            <label for="checked_by" class="ms-0">Diperiksa Oleh</label>
                                            <select name="checked_by" id="checked_by" class="form-control select2" required>
                                                <option disabled selected>-- Select Checker --</option>
                                                @foreach ($approvalList as $user)
                                                    <option value="{{ $user->nik }}">{{ $user->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="input-group input-group-static mb-3">
                                                <label for="catatan_rm" class="ms-0">Catatan RM</label>
                                                <textarea name="catatan_rm" id="catatan_rm" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-actions">
                                                <a href="{{ route('lgmg.dashboard') }}"
                                                    class="btn btn-secondary">Cancel</a>
                                                <button type="submit" class="btn btn-primary" id="btnSubmit">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .accordion {
            width: 100%;

            margin: auto;
        }

        .accordion-item {
            border: 1px solid #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion-header {
            background: #E91E63;
            color: white;
            padding: 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border: none;
            text-align: left;
            width: 100%;
            outline: none;
        }

        .accordion-content {
            display: none;
            padding: 15px;
            background: #f1f1f1;
        }

        .active {
            display: block;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

        }

        th,
        td {
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
        }

        td[rowspan] {
            vertical-align: middle !important;
            text-align: center;

        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid black !important;
        }

        .form-actions {
            justify-content: flex-end;
            display: flex;
            gap: 10px;
            margin-top: 10px;

        }

        .bg-success {
            background-color: #a6000b !important;
        }



        .custom-checkbox {
            width: 20px;
            height: 20px;
            transform: scale(1.5);
            cursor: pointer;
        }
    </style>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $('input[type="radio"]').change(function() {
            let id = $(this).attr('name').replace('q', '');
            $('#jawaban_' + id).val($(this).val());
        });

        $(document).ready(function () {
        // $('#shift').select2();
        $('.select2').select2();
        $('#btnSubmit').on('click', function (e) {
            e.preventDefault();

            let formData = {
                nama_operator: $('#nama_operator').val(),
                nrp: $('#nrp').val(),
                shift: $('#shift').val(),
                fuel_awal: $('#fuel_awal').val(),
                fuel_akhir: $('#fuel_akhir').val(),
                tanggal: $('#tanggal').val(),
                no_unit: $('#no_unit').val(),
                km_star: $('#km_star').val(),
                km_akhir: $('#km_akhir').val(),
                hm_star: $('#hm_star').val(),
                hm_akhir: $('#hm_akhir').val(),
                diisi_oleh: $('#diisi_oleh').val(),
                checked_by: $('#checked_by').val(),
                catatan_rm: $('#catatan_rm').val(),
                pertanyaan_id: [],
                jawaban: [],
                category: [],
                keterangan: []
            };

            $("table tr").each(function () {
                let radioInput = $(this).find("input[type=radio]").first();
                if (!radioInput.length) return;

                let questionID = radioInput.attr("name")?.replace("q", "");
                let jawaban = $("input[name=q" + questionID + "]:checked").val() || null;
                let category = $("#q" + questionID + "_category").val() || null;

                if (questionID) {
                    formData.pertanyaan_id.push(questionID);
                    formData.jawaban.push(jawaban);
                    formData.category.push(category);
                }
            });

            for (let i = 1; i <= 4; i++) {
                formData.keterangan.push($("#keterangan" + i).val());
            }

            $.ajax({
                url: "{{ route('lgmg.store') }}",
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
                    window.location.href = response.redirect;
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

    $(function() {
        $('#diisi_oleh  , #checked_by').select2({
            placeholder: '-- Pilih --',
            width: '50%',
            ajax: {
                url: '{{ route('lgmg.approval.list') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.nama,
                                text: item.nama + ' (' + item.nik + ')',
                                nik: item.nik
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });
    </script>
@endsection
