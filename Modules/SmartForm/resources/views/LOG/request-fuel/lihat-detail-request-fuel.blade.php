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
            <form method="POST" action="{{route('bss-form.log.update-fuel')}}">
                @csrf
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">DETAIL REQUEST FUEL</h6>
                        </div>
                    </div>

                    <div class="card-body my-1">
                        <div class="row gx-4">
                            <div class="col-auto my-auto ms-3">
                            </div>
                        </div>

                        <div class="row">
                            <div class="card col-md-6">
                                <table class="w-full">
                                    <input type="text" class="input-text w-full" name="idDoc" value="{{$data['id']}}" hidden>
                                    <tr>
                                        <td>Date</td>
                                        <td>:</td>
                                        <td>{{$data['tanggal']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>:</td>
                                        <td>{{$data['jabatan']}}</td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>:</td>
                                        <td>{{$data['dibuat_oleh']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Site</td>
                                        <td>:</td>
                                        <td>{{ $data['site'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card col-md-6">
                                <table>
                                    <tr>
                                        <td style="width:40%">Departemen</td>
                                        <td>:</td>
                                        <td>{{ $data['departemen'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td>{{ $data['nama'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>No Lambung</td>
                                        <td>:</td>
                                        <td>{{ $data['no_lambung'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kendaraan</td>
                                        <td>:</td>
                                        <td>{{ $data['jenis_kendaraan'] }}</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- ====================================== -->
                            <div class="margin-top">
                                <table class="products">
                                    <tr>
                                        <th style="width:15%;text-align: center;" rowspan="2">Jam</th>
                                        <th style="width:15%;text-align: center;" rowspan="2">Shift</th>
                                        <th style="width:15%;text-align: center;" rowspan="2">HM</th>
                                        <th style="width:15%;text-align: center;" rowspan="2">KM</th>
                                        <th style="width:15%;text-align: center;" colspan="2">Flowmeter</th>
                                        <th style="width:15%;text-align: center;" rowspan="2">Total Liter</th>
                                    </tr>
                                    <tr class="itemsHead">
                                        <th style="width:20%;text-align: center;">AWAL</th>
                                        <th style="width:20%;text-align: center;">AKHIR</th>
                                    </tr>
                                    <tr class="items">
                                        <td style="text-align: center;">{{$data['jam']}}</td>
                                        <td style="text-align: center;">{{$data['shift']}}</td>
                                        <td style="text-align: center;">{{$data['hm']}}</td>
                                        <td style="text-align: center;">{{$data['km']}}</td>
                                        <td style="text-align: center;">{{$data['awal']}}</td>
                                        <td style="text-align: center;">{{$data['akhir']}}</td>
                                        <td style="text-align: center;">{{$data['total_liter']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    <table style="width:100%" >
                          <tr>
                            <td>Diisi Oleh/Filled by,</td>
                            <td>: {{ session('username') }} {{ session('user_id') }}
                            </td>
                            <td>Diserahkan Oleh, :</td>
                            <td>
                                <select name="dDiserahkan" class="form-control text-center">
                                    <option value="{{$data['diserahkan_oleh']}}">{{$data['diserahkan_oleh']}}</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>Diterima Oleh, :</td>
                            <td>
                                <select name="dDiterima" class="form-control text-center">
                                    <option value="{{$data['diterima_oleh']}}">{{$data['diterima_oleh']}}</option>
                                    @foreach($approvalList as $user)
                                        <option value="{{ $user->nama }}">
                                            {{ $user->nama }} ({{ $user->nik }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                          </tr>
                    </table>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <a href="{{url()->previous()}}" class="btn btn-success">
                                <i class="fas fa fa-chevron-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        var $table = $("#item-pemakaian");
        function indexFormatter(value, row, index) {
            return index + 1;
        }

        $('#site').select2();
        $('#i_departemen').select2();
        $('#i_no_lambung').select2();
        $('#i_jenis_kendaraan').select2();

        $(document).ready(function() {

        function populateNoLambung(siteId, selectedNoLambung = null) {
            if (siteId) {
                $.ajax({
                    url: '{{ route('fuel-get.alat.by.site') }}',
                    data: {
                        site: siteId
                    },
                    success: function(data) {
                        $('#i_no_lambung').empty().append('<option value="">-- Pilih No Lambung --</option>').trigger('change');

                        if (data && data.length > 0) {
                            $.each(data, function(index, item) {
                                $('#i_no_lambung').append(
                                    `<option value="${item.no_lambung}">${item.no_lambung}</option>`
                                );
                            });
                            if (selectedNoLambung) {
                                $('#i_no_lambung').val(selectedNoLambung).trigger('change');
                            }
                        } else {
                            $('#i_no_lambung').append('<option value="">-- Data Tidak Ada --</option>').trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#i_no_lambung').empty().append('<option value="">-- Error --</option>').trigger('change');
                    }
                });
            } else {
                $('#i_no_lambung').empty().append('<option value="">-- Pilih No Lambung --</option>').trigger('change');
            }
        }

        // Fungsi untuk mengisi dropdown Jenis Kendaraan berdasarkan No Lambung
        function populateJenisKendaraan(noLambung, selectedJenisKendaraan = null) {
            if (noLambung) {
                $.ajax({
                    url: '{{ route('fuel-get.model.by.site') }}',
                    data: {
                        no_lambung: noLambung
                    },
                    success: function(data) {
                        $('#i_jenis_kendaraan').empty().append('<option value="">-- Pilih Jenis Kendaraan --</option>').trigger('change');

                        if (data && data.length > 0) {
                            $.each(data, function(index, item) {
                                $('#i_jenis_kendaraan').append(
                                    `<option value="${item.model}">${item.model}</option>`
                                );
                            });
                            if (selectedJenisKendaraan) {
                                $('#i_jenis_kendaraan').val(selectedJenisKendaraan).trigger('change');
                            }
                        } else {
                            $('#i_jenis_kendaraan').append('<option value="">-- Data Tidak Ada --</option>').trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#i_jenis_kendaraan').empty().append('<option value="">-- Error --</option>').trigger('change');
                    }
                });
            } else {
                $('#i_jenis_kendaraan').empty().append('<option value="">-- Pilih Jenis Kendaraan --</option>').trigger('change();');
            }
        }

        // Saat halaman edit dimuat, jika ada nilai site, no_lambung, dan jenis_kendaraan, isi dropdown
        @if(isset($data['site']))
            var initialSite = '{{ $data['site'] }}';
            $('#site').val(initialSite).trigger('change');

            @if(isset($data['no_lambung']))
                var initialNoLambung = '{{ $data['no_lambung'] }}';
                // Tunggu sebentar agar dropdown No Lambung terisi sebelum memilih
                setTimeout(function() {
                    populateNoLambung(initialSite, initialNoLambung);
                    @if(isset($data['jenis_kendaraan']))
                        var initialJenisKendaraan = '{{ $data['jenis_kendaraan'] }}';
                        // Tunggu sebentar agar dropdown Jenis Kendaraan terisi sebelum memilih
                        setTimeout(function() {
                            populateJenisKendaraan(initialNoLambung, initialJenisKendaraan);
                        }, 500); // Tambah delay jika perlu
                    @endif
                }, 500); // Tambah delay jika perlu
            @endif
        @endif

        // Event handler untuk perubahan pada dropdown Site
        $('#site').on('change', function() {
            var selectedSite = $(this).val();
            populateNoLambung(selectedSite);
            $('#i_jenis_kendaraan').empty().append('<option value="">-- Pilih Jenis Kendaraan --</option>').trigger('change'); // Reset jenis kendaraan saat site berubah
        });

        // Event handler untuk perubahan pada dropdown No Lambung
        $('#i_no_lambung').on('change', function() {
            var selectedNoLambung = $(this).val();

            $.ajax({
                url: '{{ route('fuel-get.model.by.site') }}',
                data: {
                    no_lambung: selectedNoLambung
                },
                success: function(data) {
                    $('#i_jenis_kendaraan').empty().append('<option value="">-- Pilih Jenis Kendaraan --</option>').trigger('change');

                    if (data && data.length === 1) { // Jika hanya ada satu data yang kembali
                        $('#i_jenis_kendaraan').append(
                            `<option value="${data[0].model}" selected>${data[0].model}</option>`
                        ).trigger('change'); // Langsung pilih dan trigger change
                    } else if (data && data.length > 1) { // Jika ada lebih dari satu data (kemungkinan error di asumsi 1:1)
                        $.each(data, function(index, item) {
                            $('#i_jenis_kendaraan').append(
                                `<option value="${item.model}">${item.model}</option>`
                            );
                        });
                        // Jika ada data jenis kendaraan yang sudah tersimpan, coba pilih
                        @if(isset($data['jenis_kendaraan']))
                            $('#i_jenis_kendaraan').val('{{ $data['jenis_kendaraan'] }}').trigger('change');
                        @endif
                    } else {
                        $('#i_jenis_kendaraan').append('<option value="">-- Data Tidak Ada --</option>').trigger('change');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#i_jenis_kendaraan').empty().append('<option value="">-- Error --</option>').trigger('change');
                }
            });
        });
    });

    </script>
@endsection
