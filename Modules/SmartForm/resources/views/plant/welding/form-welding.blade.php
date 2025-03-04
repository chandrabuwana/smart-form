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
                    <!-- Card Header -->
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">{{ $isShowDetail ? 'Detail' : 'New' }} Form P2H
                                Welding (Standard)</h6>
                        </div>
                    </div>

                    <form action="" id="weldingForm" method="POST">
                        @csrf
                        @if ($isShowDetail && $record)
                            <input type="hidden" name="id" value="{{ $record->id }}">
                        @endif
                        <div class="mx-3">
                            <!-- Basic Information -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site_name" class="ms-0">Site Name</label>
                                        <select class="form-control" name="site_name" id="site_name" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option value="agm"
                                                {{ old('site_name', $record->site ?? '') == 'agm' ? 'selected' : '' }}>
                                                Agm</option>
                                            <option value="mbl"
                                                {{ old('site_name', $record->site ?? '') == 'mbl' ? 'selected' : '' }}>
                                                Mbl</option>
                                            <option value="mme"
                                                {{ old('site_name', $record->site ?? '') == 'mme' ? 'selected' : '' }}>
                                                Mme</option>
                                            <option value="mas"
                                                {{ old('site_name', $record->site ?? '') == 'mas' ? 'selected' : '' }}>
                                                Mas</option>
                                            <option value="pmss"
                                                {{ old('site_name', $record->site ?? '') == 'pmss' ? 'selected' : '' }}>
                                                Pmss</option>
                                            <option value="taj"
                                                {{ old('site_name', $record->site ?? '') == 'taj' ? 'selected' : '' }}>
                                                Taj</option>
                                            <option value="bssr"
                                                {{ old('site_name', $record->site ?? '') == 'bssr' ? 'selected' : '' }}>
                                                Bssr</option>
                                            <option value="tdm"
                                                {{ old('site_name', $record->site ?? '') == 'tdm' ? 'selected' : '' }}>
                                                Tdm</option>
                                            <option value="msj"
                                                {{ old('site_name', $record->site ?? '') == 'msj' ? 'selected' : '' }}>
                                                Msj</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="input-group input-group-static mb-3">
                                        <label for="jenis_instalasi" class="ms-0">Jenis Instalasi</label>
                                        <select class="form-control" name="jenis_instalasi" id="jenis_instalasi" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option value="Instalasi Tetap"
                                                {{ old('jenis_instalasi', $record->jenis_instalasi ?? '') == 'Instalasi Tetap' ? 'selected' : '' }}>
                                                Instalasi Tetap</option>
                                            <option value="Troli Portable"
                                                {{ old('jenis_instalasi', $record->jenis_instalasi ?? '') == 'Troli Portable' ? 'selected' : '' }}>
                                                Troli Portable</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="lokasi" class="ms-0">Lokasi</label>
                                        <select class="form-control" name="lokasi" id="lokasi" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>

                                            <option value="Workshop"
                                                {{ old('lokasi', $record->lokasi ?? '') == 'Workshop' ? 'selected' : '' }}>
                                                Workshop</option>
                                            <option value="Pitstop"
                                                {{ old('lokasi', $record->lokasi ?? '') == 'Pitstop' ? 'selected' : '' }}>
                                                Pitstop</option>
                                            <option value="Service"
                                                {{ old('lokasi', $record->lokasi ?? '') == 'Service' ? 'selected' : '' }}>
                                                Service</option>
                                            <option value="Truck"
                                                {{ old('lokasi', $record->lokasi ?? '') == 'Truck' ? 'selected' : '' }}>
                                                Truck</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="month" class="ms-0">Bulan</label>
                                        <input type="month" class="form-control" id="month" name="month" required
                                            value="{{ old('month', $record->month ?? '') }}"
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="pemeriksa" class="ms-0">Nama Pemeriksa</label>
                                        <input type="text" class="form-control" id="pemeriksa" name="pemeriksa" required
                                            value="{{ old('pemeriksa', $record->pemeriksa ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="jabatan" class="ms-0">Jabatan</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" required
                                            value="{{ old('jabatan', $record->jabatan ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nrp" class="ms-0">NRP</label>
                                        <input type="number" class="form-control" id="nrp" name="nrp" required
                                            value="{{ old('nrp', $record->nrp ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="atasan" class="ms-0">Nama Atasan Langsung</label>
                                        <input type="text" class="form-control" id="atasan" name="atasan" required
                                            value="{{ old('atasan', $record->atasan ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead class="bg-success text-white">
                                        <tr>

                                            <th class="fix " style="text-align: center; vertical-align: middle; "
                                                rowspan="2">NO</th>
                                            <th class="fix" rowspan="2"
                                                style="text-align: center; vertical-align: middle; ">ITEM YANG
                                                DI
                                                PERIKSA</th>


                                            <th colspan="31" class="text-center">TANGGAL</th>

                                        </tr>
                                        <tr>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <th style="text-align: center;">{{ $i }}</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3"><b>A.CUTTING BLANDER DARI OKSIGEN & ACTILIN</b></td>

                                        </tr>
                                        <tr>
                                            <td class="fix">1</td>
                                            <td class="fix" style="text-align: left;">Ulir regulator tabung dalam kondisi baik</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-1-{{ $i }}" value=1
                                                        {{ old('before-1-' . $i, isset($record->question1[$i - 1]) ? $record->question1[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td style="text-align: left;">Regulator berfungsi baik</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-2-{{ $i }}" value=1
                                                        {{ old('before-2-' . $i, isset($record->question2[$i - 1]) ? $record->question2[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td style="text-align: left;">Semua flash back arestor berfungsi</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-3-{{ $i }}" value=1
                                                        {{ old('before-3-' . $i, isset($record->question3[$i - 1]) ? $record->question3[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td style="text-align: left;">Tabung & perlengkapan bersih dan tidak</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-4-{{ $i }}" value=1
                                                        {{ old('before-4-' . $i, isset($record->question4[$i - 1]) ? $record->question4[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td style="text-align: left;">Tabung di rantai secara individual </td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-5-{{ $i }}" value=1
                                                        {{ old('before-5-' . $i, isset($record->question5[$i - 1]) ? $record->question5[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td style="text-align: left;">Clamp hose standart (bukan kawat, selotip atau klem silang) </td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-6-{{ $i }}" value=1
                                                        {{ old('before-6-' . $i, isset($record->question6[$i - 1]) ? $record->question6[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td style="text-align: left;">Tabung Posisi tegak pada kerangka / rak / troli</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-7-{{ $i }}" value=1
                                                        {{ old('before-7-' . $i, isset($record->question7[$i - 1]) ? $record->question7[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td style="text-align: left;">Troli mempunyai pemadam api sendiri</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-8-{{ $i }}" value=1
                                                        {{ old('before-8-' . $i, isset($record->question8[$i - 1]) ? $record->question8[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td style="text-align: left;">Tabung / perlengkapan tidak korosi </td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-9-{{ $i }}" value=1
                                                        {{ old('before-9-' . $i, isset($record->question9[$i - 1]) ? $record->question9[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td style="text-align: left;">Tabung / selang / hose tidak bocor</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-10-{{ $i }}" value=1
                                                        {{ old('before-10-' . $i, isset($record->question10[$i - 1]) ? $record->question10[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td style="text-align: left;">Semua menggunakan flash back arrestor</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-11-{{ $i }}" value=1
                                                        {{ old('before-11-' . $i, isset($record->question11[$i - 1]) ? $record->question11[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td style="text-align: left;">Pemantik tersedia dan baik</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-12-{{ $i }}" value=1
                                                        {{ old('before-12-' . $i, isset($record->question12[$i - 1]) ? $record->question12[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>13</td>
                                            <td style="text-align: left;">Semua torch dalam kondisi balk </td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-13-{{ $i }}" value=1
                                                        {{ old('before-13-' . $i, isset($record->question13[$i - 1]) ? $record->question13[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>

                                        <tr>
                                        <td colspan="10">
                                            <div class="form-container">
                                            <div class="input-group input-group-static mb-3">
                                                <div class="input-group input-group-static mb-3">
                                                    <label>Catatan</label>
                                                    <textarea class="form-control" name="catatan1" rows="4" {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $record->catatan1 : '' }}</textarea>
                                            </div>
                                        </div>
                                        </td>    
                                        
                                        </tr>    


                                        <tr>
                                            <td colspan="3"><b>MESIN LAS & ALAT PELINDUNG DIRI</b></td>

                                        </tr>  


                                        <tr>
                                            <td>14</td>
                                            <td style="text-align: left;">Kabel/scone positif (+) & negatif (-)</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-14-{{ $i }}" value=1
                                                        {{ old('before-14-' . $i, isset($record->question14[$i - 1]) ? $record->question14[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td style="text-align: left;">Periksa isolasi semua kabel </td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-15-{{ $i }}" value=1
                                                        {{ old('before-15-' . $i, isset($record->question15[$i - 1]) ? $record->question15[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>16</td>
                                            <td style="text-align: left;">Cek kabel ground & holder</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-16-{{ $i }}" value=1
                                                        {{ old('before-16-' . $i, isset($record->question16[$i - 1]) ? $record->question16[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>

                                        <tr>
                                            <td>17</td>
                                            <td style="text-align: left;">Cek olie engine</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-1-{{ $i }}" value=1
                                                        {{ old('after-1-' . $i, isset($record->question17[$i - 1]) ? $record->question17[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>18</td>
                                            <td style="text-align: left;">Cek air radiator</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-2-{{ $i }}" value=1
                                                        {{ old('after-2-' . $i, isset($record->question18[$i - 1]) ? $record->question18[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>19</td>
                                            <td style="text-align: left;">Cek air battery</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-3-{{ $i }}" value=1
                                                        {{ old('after-3-' . $i, isset($record->question19[$i - 1]) ? $record->question19[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>20</td>
                                            <td style="text-align: left;">Cek kondisi Alat Pelindung</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-4-{{ $i }}" value=1
                                                        {{ old('after-4-' . $i, isset($record->question20[$i - 1]) ? $record->question20[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>

                                        <tr>
                                            <td colspan="10">
                                            <div class="form-container">
                                                <div class="input-group input-group-static mb-3">
                                                    <div class="input-group input-group-static mb-3">
                                                        <label>Catatan 2</label>
                                                        <textarea class="form-control" name="catatan2" rows="4" {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $record->catatan2 : '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            </td>

                                        </tr>


                                    </tbody>
                                </table>

                            


                            </div>
                                @if ($isShowDetail)
                                    <div class="form-actions">
                                        <a href="{{ route('plant.welding.dashboard') }}"
                                            class="btn btn-secondary">Cancel</a>
                                        <a href="{{ route('plant.welding.export', ['id' => $record->id]) }}"
                                            class="btn btn-primary">Export</a>
                                    </div>
                                @else
                                    <div class="form-actions">
                                        <a href="{{ route('plant.welding.dashboard') }}"
                                            class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                @endif
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <style>
        .table> :not(caption)>*>* {
            padding: 0.5rem;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

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

        /* Center all content in tbody */
        .table tbody td {
            text-align: center;
            vertical-align: middle;
            height: 60px;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .table thead {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: #f8f9fa;

        }

        .table tbody td.form-control {
            text-align: left;
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
    <script>
        $(function() {
            var form = $("#weldingForm");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);

                axios.post('{{ route('plant.welding.store') }}', formData)
                    .then(function(response) {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('plant.welding.dashboard') }}';
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        let errorMessage = 'Terjadi kesalahan pada sistem';

                        if (error.response) {
                            if (error.response.data.errors) {
                                errorMessage = Object.values(error.response.data.errors).flat().join(
                                    '\n');
                            } else if (error.response.data.message) {
                                errorMessage = error.response.data.message;
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    })
                    .finally(function() {
                        submitBtn.prop('disabled', false);
                    });
            });
        });
    </script>
@endsection
