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
                                Compressor Pompa (Standard)</h6>
                        </div>
                    </div>

                    <form action="" id="compressorForm" method="POST">
                        @csrf
                        @if ($isShowDetail && $record)
                            <input type="hidden" name="id" value="{{ $record->id }}">
                        @endif
                        <div class="mx-4">
                            <!-- Basic Information -->
                            <div class="row mb-3">

                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit" class="ms-0">C/N Unit</label>
                                        <input type="text" class="form-control" id="unit" name="unit"
                                            value="{{ old('unit', $record->name ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="nama" class="ms-0">Nama Pengecheck</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama', $record->name ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="lokasi" class="ms-0">Lokasi</label>
                                        <select class="form-control" name="lokasi" id="lokasi" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option disabled selected>-- Select Location --</option>
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
                                        <label for="engine" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control" id="engine" name="engine" required
                                            value="{{ old('engine', $record->engine_model ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="generator" class="ms-0">Generator Model</label>
                                        <input type="text" class="form-control" id="generator" name="generator" required
                                            value="{{ old('generator', $record->generator_model ?? '') }}" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="site" class="ms-0">Site</label>
                                        <select class="form-control" name="site" id="site" required
                                            {{ $isShowDetail ? 'disabled' : '' }}>
                                            <option disabled selected>-- Select Site --</option>
                                            <option value="agm"
                                                {{ old('site', $record->site ?? '') == 'agm' ? 'selected' : '' }}>
                                                agm</option>
                                            <option value="mbl"
                                                {{ old('site', $record->site ?? '') == 'mbl' ? 'selected' : '' }}>
                                                mbl</option>
                                            <option value="mme"
                                                {{ old('site', $record->site ?? '') == 'mme' ? 'selected' : '' }}>
                                                mme</option>
                                            <option value="mas"
                                                {{ old('site', $record->site ?? '') == 'mas' ? 'selected' : '' }}>
                                                mas</option>
                                            <option value="pmss"
                                                {{ old('site', $record->site ?? '') == 'pmss' ? 'selected' : '' }}>
                                                pmss</option>
                                            <option value="taj"
                                                {{ old('site', $record->site ?? '') == 'taj' ? 'selected' : '' }}>
                                                taj</option>
                                            <option value="bssr"
                                                {{ old('site', $record->site ?? '') == 'bssr' ? 'selected' : '' }}>
                                                bssr</option>
                                            <option value="tdm"
                                                {{ old('site', $record->site ?? '') == 'tdm' ? 'selected' : '' }}>
                                                tdm</option>
                                            <option value="msj"
                                                {{ old('site', $record->site ?? '') == 'msj' ? 'selected' : '' }}>
                                                msj</option>
                                        </select>
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
                                                CHECK</th>
                                            <th class="fix"
                                                rowspan="2"style="text-align: center; vertical-align: middle;">CODE
                                                BAHAYA
                                            </th>


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
                                            <td colspan="3">CHECK SEBELUM MULAI</td>

                                        </tr>
                                        <tr>
                                            <td class="fix">1</td>
                                            <td class="fix" style="text-align: left;">Level Oil Mesin</td>
                                            <td class="fix">AA</td>
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
                                            <td style="text-align: left;">Level Air Radiator</td>
                                            <td>AA</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-2-{{ $i }}" value=1
                                                        {{ old('before-2-' . $i, isset($record->question2[$i - 1]) ? $record->question2[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td style="text-align: left;">Level Air Battery dan Cable Battery</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-3-{{ $i }}" value=1
                                                        {{ old('before-3-' . $i, isset($record->question3[$i - 1]) ? $record->question3[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td style="text-align: left;">Level Solar</td>
                                            <td>A</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-4-{{ $i }}" value=1
                                                        {{ old('before-4-' . $i, isset($record->question4[$i - 1]) ? $record->question4[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td style="text-align: left;">Rubber Coupling Mesin</td>
                                            <td>A</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-5-{{ $i }}" value=1
                                                        {{ old('before-5-' . $i, isset($record->question5[$i - 1]) ? $record->question5[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td style="text-align: left;">Kekencangan V-Belt</td>
                                            <td>A</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-6-{{ $i }}" value=1
                                                        {{ old('before-6-' . $i, isset($record->question6[$i - 1]) ? $record->question6[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td style="text-align: left;">Kondisi Guard Fan</td>
                                            <td>A</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-7-{{ $i }}" value=1
                                                        {{ old('before-7-' . $i, isset($record->question7[$i - 1]) ? $record->question7[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td style="text-align: left;">Rubber Mounting Mesin</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-8-{{ $i }}" value=1
                                                        {{ old('before-8-' . $i, isset($record->question8[$i - 1]) ? $record->question8[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td style="text-align: left;">Rubber Mounting Compresor</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-9-{{ $i }}" value=1
                                                        {{ old('before-9-' . $i, isset($record->question9[$i - 1]) ? $record->question9[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td style="text-align: left;">Radiator dan House Radiator</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-10-{{ $i }}" value=1
                                                        {{ old('before-10-' . $i, isset($record->question10[$i - 1]) ? $record->question10[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td style="text-align: left;">Air Cleaner dan Bracket</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-11-{{ $i }}" value=1
                                                        {{ old('before-11-' . $i, isset($record->question11[$i - 1]) ? $record->question11[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td style="text-align: left;">Muffler dan Bolt Mounting</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-12-{{ $i }}" value=1
                                                        {{ old('before-12-' . $i, isset($record->question12[$i - 1]) ? $record->question12[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>13</td>
                                            <td style="text-align: left;">Check Adhusment throtle Gad Engine</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-13-{{ $i }}" value=1
                                                        {{ old('before-13-' . $i, isset($record->question13[$i - 1]) ? $record->question13[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>14</td>
                                            <td style="text-align: left;">Kekencangan Bolt Nut</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-14-{{ $i }}" value=1
                                                        {{ old('before-14-' . $i, isset($record->question14[$i - 1]) ? $record->question14[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td style="text-align: left;">Main Circuit Breaker & Cable</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-15-{{ $i }}" value=1
                                                        {{ old('before-15-' . $i, isset($record->question15[$i - 1]) ? $record->question15[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>16</td>
                                            <td style="text-align: left;">Check Kebocoran Oil, Solar, & Air</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="before-16-{{ $i }}" value=1
                                                        {{ old('before-16-' . $i, isset($record->question16[$i - 1]) ? $record->question16[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="3">CHECK SETELAH MESIN HIDUP</td>

                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td style="text-align: left;">Noise / Suara Mesin</td>
                                            <td>AA</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-1-{{ $i }}" value=1
                                                        {{ old('after-1-' . $i, isset($record->question17[$i - 1]) ? $record->question17[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td style="text-align: left;">Noise / Suara Generator</td>
                                            <td>AA</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-2-{{ $i }}" value=1
                                                        {{ old('after-2-' . $i, isset($record->question18[$i - 1]) ? $record->question18[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td style="text-align: left;">Gauge Panel Oil Pressure</td>
                                            <td>A</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-3-{{ $i }}" value=1
                                                        {{ old('after-3-' . $i, isset($record->question19[$i - 1]) ? $record->question19[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td style="text-align: left;">Gauge Panel Water Temperatur</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-4-{{ $i }}" value=1
                                                        {{ old('after-4-' . $i, isset($record->question20[$i - 1]) ? $record->question20[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td style="text-align: left;">Kebocoran Oli, Air dan Solar</td>
                                            <td>AA</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-5-{{ $i }}" value=1
                                                        {{ old('after-5-' . $i, isset($record->question21[$i - 1]) ? $record->question21[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td style="text-align: left;">Charging System</td>
                                            <td>B</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="after-6-{{ $i }}" value=1
                                                        {{ old('after-6-' . $i, isset($record->question22[$i - 1]) ? $record->question22[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <td colspan="3">Paraf Pengecek</td>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <td> <input type="checkbox" class="custom-checkbox"
                                                        name="paraf-{{ $i }}" value=1
                                                        {{ old('paraf-' . $i, isset($record->paraf_item[$i - 1]) ? $record->paraf_item[$i - 1] : '') == 1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}></td>
                                            @endfor
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                            <div class="form-container">
                                <div class="input-group input-group-static mb-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label>Catatan</label>
                                        <textarea class="form-control" name="catatan" rows="4" {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $record->catatan : '' }}</textarea>
                                    </div>
                                </div>

                                @if ($isShowDetail)
                                    <div class="form-actions">
                                        <a href="{{ route('plant.compressor.dashboard') }}"
                                            class="btn btn-secondary">Cancel</a>
                                        <a href="{{ route('plant.compressor.export', ['id' => $record->id]) }}"
                                            class="btn btn-primary">Export</a>
                                    </div>
                                @else
                                    <div class="form-actions">
                                        <a href="{{ route('plant.compressor.dashboard') }}"
                                            class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                @endif
                            </div>

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
            var form = $("#compressorForm");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);

                axios.post('{{ route('plant.compressor.store') }}', formData)
                    .then(function(response) {
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('plant.compressor.dashboard') }}';
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
