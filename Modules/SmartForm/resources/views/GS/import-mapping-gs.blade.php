@extends('master.master_page')

@section('custom-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .select2.select2-container .select2-selection {
            border-bottom: 1px solid #ccc;
            height: 40px;
            margin-bottom: 15px;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .select2.select2-container .select2-selection .select2-selection__rendered {
            line-height: 32px;
            padding: 8px 0px;
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
    </style>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 my-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Import Mapping GS</h6>
                    </div>
                </div>
                <div class="card-body pb-2">
                    <p>
                        Download Template Excel <a href="{{ url('Format Import Mapping GS.xlsx') }}" target="_blank" class="text-primary">klik disini</a>
                    </p>

                    <form method="POST" enctype="multipart/form-data" id="form-import-gs">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">Site</label>
                            </div>
                            <div class="col-md-8">
                                {{-- <input type="text" class="input-text w-100" name="site" onfocus="focused(this)" onfocusout="defocused(this)" required> --}}
                                <select class="form-select input-text" aria-label="Default select example" id="site" name="site">
                                    <option value="">-- Pilih Site --</option>
                                    <option value="AGM">AGM</option>
                                    <option value="TAJ">TAJ</option>
                                    <option value="MBL-MINING">MBL MINING</option>
                                    <option value="MBL-HAULING">MBL HAULING</option>
                                    <option value="BSSR">BSSR</option>
                                    <option value="MSJ">MSJ</option>
                                    <option value="TDM">TDM</option>
                                    <option value="MAS">MAS</option>
                                    <option value="PMSS">PMSS</option>
                                    <option value="BRAM">BRAM</option>
                                    <option value="MME">MME</option>
                                    <option value="CDI">CDI</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="ms-0 fs-6">File Excel</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" class="form-control border w-full" name="file_excel" onfocus="focused(this)" onfocusout="defocused(this)"
                                    accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary ms-auto d-flex align-items-center">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="loader-btn"></span>
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $('#form-import-gs').on('submit', function(e) {
            e.preventDefault();
            $('#loader-btn').removeClass('d-none').attr('disabled', true);

            const formData = new FormData();
            formData.append('site', $('[name=site]').val());
            formData.append('file_excel', $('[name=file_excel]')[0].files[0]);

            $.ajax({
                url: `{{ route('import-mapping-gs-catering') }}`,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'thrownError',
                        html: 'Terjadi kesalahan tidak terduga',
                        confirmButtonText: 'OK'
                    });
                },
                success: function(response) {
                    if(response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then( function() {
                            location.reload();
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: response.message,
                            confirmButtonText: 'OK'

                        });
                    }
                },
                finally: function() {
                    $('#loader-btn').addClass('d-none').removeAttr('disabled');
                }
            });
        });
    </script>
@endsection
