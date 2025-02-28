@extends('master.master_page')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible text-white fade show" role="alert">
                <span class="alert-icon align-middle"><i class="fas fa-check-circle"></i></span>
                <span class="alert-text">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
            </div>
            @endif

            @if(session('error'))
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
                        <h6 class="text-white text-capitalize ps-3">{{$isShowDetail ? 'Detail' : 'New'}} Ergonomi Survey</h6>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('she.ergonomi.store') }}" method="POST">
                        @csrf
                        <div class="mx-3">
                            <!-- Header Information -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="5" class="text-center bg-warning">
                                            <h5 class="mb-0">SURVEY ERGONOMI</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <strong>Posisi yang dievaluasi</strong><br/>
                                            <span class="text-xs">Job Position</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>Tanggal</strong><br/>
                                            <span class="text-xs">Date</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>Jumlah Pekerja pada pekerjaan ini</strong><br/>
                                            <span class="text-xs">Total of Employee in These Job</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>Nama Karyawan</strong><br/>
                                            <span class="text-xs">Employee Name</span>
                                        </td>
                                        <td class="text-center">
                                            <strong>Nama Peninjau</strong><br/>
                                            <span class="text-xs">Reviewer Name</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">
                                            <input type="text" name="job_position" class="form-control" required
                                                value="{{ $isShowDetail ? $data->job_position : old('job_position') }}"
                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                        </td>
                                        <td class="border">
                                            <input type="date" name="evaluation_date" class="form-control" required
                                                value="{{ $isShowDetail ? $data->evaluation_date : old('evaluation_date') }}"
                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                        </td>
                                        <td class="border">
                                            <input type="number" name="total_employee" class="form-control" required
                                                value="{{ $isShowDetail ? $data->total_employee : old('total_employee') }}"
                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                        </td>
                                        <td class="border">
                                            <input type="text" name="employee_name" class="form-control" required
                                                value="{{ $isShowDetail ? $data->employee_name : old('employee_name') }}"
                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                        </td>
                                        <td class="border">
                                            <input type="text" name="reviewer_name" class="form-control" required
                                                value="{{ $isShowDetail ? $data->reviewer_name : old('reviewer_name') }}"
                                                {{ $isShowDetail ? 'disabled' : '' }}>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Caution Zone Checklist -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center">
                                        <td style="width: 5%" class="bg-warning fw-bold text-black">A</td>
                                        <td colspan="4" class="bg-warning">
                                            <strong>DAFTAR UJI ZONA PERHATIAN</strong><br/>
                                            <span class="text-xs">CAUTION ZONE CHECKLIST</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-wrap text-center border">Setiap pergerakan atau posture yang dilakukan regular atau merupakan bagian dari pekerjaan, terjadi lebih dari sehari dalam seminggu dan semingkat lebih dari satu minggu dalam setahun</td>
                                        
                                        <td class="border text-center">Jika dikerjakan, beri tanda pada kotak</td>
                                        <td style="width: 15%" class="border text-center">
                                            <input type="checkbox" class="form-check-input" checked disabled>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Postur Tubuh Janggal -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center" style="background-color: #FACC15;">
                                        <td colspan="3">
                                            <strong>Postur Tubuh Janggal / Awkward Posture</strong>
                                        </td>
                                        <td>
                                            <strong>Komentar Observasi / Comments Observation</strong>
                                        </td>
                                    </tr>
                                    <!-- Item 1 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center border">1</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur1.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Bekerja dengan tangan diatas kepala, atau siku diatas bahu lebih dari 2 (dua) jam per hari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_1"
                                                    {{ $isShowDetail && $data->item_1 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_1_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_1_observation : old('item_1_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Item 2 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center border">2</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur2.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Bekerja dengan tangan diatas kepala, atau siku diatas bahu lebih dari 2 (dua) jam per hari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_2"
                                                    {{ $isShowDetail && $data->item_2 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_2_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_2_observation : old('item_2_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Item 3 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center border">3</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur3.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Bekerja dengan tangan diatas kepala, atau siku diatas bahu lebih dari 2 (dua) jam per hari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_3"
                                                    {{ $isShowDetail && $data->item_3 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_3_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_3_observation : old('item_3_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Item 4 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center border">4</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur4.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Bekerja dengan tangan diatas kepala, atau siku diatas bahu lebih dari 2 (dua) jam per hari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_4"
                                                    {{ $isShowDetail && $data->item_4 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_4_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_4_observation : old('item_4_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>


                            <!-- Tenaga Kuat dengan Tangan -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center" style="background-color: #FACC15;">
                                        <td colspan="3">
                                            <strong>Tenaga Kuat dengan Tangan / High End Force</strong>
                                        </td>
                                        <td>
                                            <strong>Komentar Observasi / Comments Observation</strong>
                                        </td>
                                    </tr>
                                    <!-- Item 5 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center">5</td>
                                        <td style="width: 15%">
                                            <img src="{{ asset('img/form-she-ergonomi/postur5.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center">Menjepit objek tanpa bantuan dengan berat 1 (satu) kilogram pertangan, atau menjepit dengan tenaga 2 (dua) kilogram lebih dari 2 (dua) jam sehari (bandingkan dengan menjepit setengah rim kertas)</td>
                                        <td>
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_5"
                                                    {{ $isShowDetail && $data->item_5 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_5_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_5_observation : old('item_5_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Item 6 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center border">6</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur5.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Mencengkram objek tanpa bantuan dengan beban 5 kilogram atau lebih per tangan atau menjepit dengan tenaga sebesar 5 kilogram per tangan, lebih dari 2 (dua) jam sehari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_6"
                                                    {{ $isShowDetail && $data->item_6 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_6_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_6_observation : old('item_6_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">7</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur6.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Mengulang pergerakan yang sama pada leher, bahu, siku, pergelangan tangan, atau tangan (diluar kegiatan jari) tanpa variasi atau sedikit variasi beberapa detik, lebih dari 2 (dua) jam total per hari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_7"
                                                    {{ $isShowDetail && $data->item_7 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_7_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_7_observation : old('item_7_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">8</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur8.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Mengerjakan pengetikan secara intensif lebih dari 4 (empat) jam dalam sehari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_8"
                                                    {{ $isShowDetail && $data->item_8 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_8_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_8_observation : old('item_8_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Dampak Berulang -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center" style="background-color: #FACC15;">
                                        <td colspan="3">
                                            <strong>Dampak Berulang / Repeated Impact</strong>
                                        </td>
                                        <td>
                                            <strong>Komentar Observasi / Comments Observation</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">9</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur9.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Menggunakan tangan (telapak tangan menyiku) untuk memukul atau lutut sebagai dasar untuk memukul selama lebih dari 10 kali per jam dengan toal 2 (dua) jam sehari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_9"
                                                    {{ $isShowDetail && $data->item_9 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_9_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_9_observation : old('item_9_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">10</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur10.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Mengangkat benda lebih dari 35 (tiga puluh lima) kilogram per hari atau lebih dari 20 (dua puluh) kilogram leboh dari 10 (sepuluh) kali per hari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_10"
                                                    {{ $isShowDetail && $data->item_10 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_10_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_10_observation : old('item_9_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">11</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur11.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Mengangkat objek lebih dari 5 (lima) kilogram jika dilakukan dalam dua kali per menit lebih dari total 2 (dua) jam sehari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_12"
                                                    {{ $isShowDetail && $data->item_11 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_11_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_11_observation : old('item_11_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">12</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur12.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Mengangkat objek lebih dari 5 (lima) kilogram jika dilakukan dalam dua kali per menit lebih dari total 2 (dua) jam sehari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_12"
                                                    {{ $isShowDetail && $data->item_12 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_12_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_12_observation : old('item_12_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Getaran -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center" style="background-color: #FACC15;">
                                        <td colspan="3">
                                            <strong>Getaran Sedang s.d. Tinggi pada Tangan-Lengan / Moderate to High Hand-Arm Vibration</strong>
                                        </td>
                                        <td>
                                            <strong>Komentar Observasi / Comments Observation</strong>
                                        </td>
                                    </tr>
                                    <!-- Items 13-14 -->
                                    <tr>
                                        <td style="width: 5%" class="text-center">13</td>
                                        <td style="width: 15%">
                                            <img src="{{ asset('img/form-she-ergonomi/postur9.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center">Menggunakan Impact Wrenches, vibration impact, dan peralatan tangan lainnya yang memiliki getaran tinggi lebih dari 30 (tigapuluh) menit per hari</td>
                                        <td>
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_13"
                                                    {{ $isShowDetail && $data->item_13 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_13_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_13_observation : old('item_13_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">14</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur14.png') }}" class="img-fluid">
                                        </td>
                                        <td style="width: 40%" class="text-wrap text-center border">Menggunakan gerinda (gerinda tangan atau stand), atau peralatan tangan lain yang biasasnya memiliki getaran sedang lebih dari 2 (dua) jam total dalam sehari</td>
                                        <td class="border">
                                            <div class="form-check d-flex align-items-center mb-2">
                                                <input type="checkbox" class="form-check-input" name="item_14"
                                                    {{ $isShowDetail && $data->item_14 ? 'checked' : '' }}
                                                    {{ $isShowDetail ? 'disabled' : '' }}>
                                                <label class="form-check-label ms-2">Status</label>
                                            </div>
                                            <div class="input-group input-group-static">
                                                <textarea name="item_14_observation" class="form-control" rows="2"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->item_14_observation : old('item_14_observation') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Faktor Resiko Tindak Lanjut Title -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center">
                                        <td style="width: 5%" class="bg-warning fw-bold text-black">B</td>
                                        <td colspan="3" class="bg-warning">
                                            <strong>DAFTAR UJI TINDAK LANJUT FAKTOR RESIKO FISIK</strong><br/>
                                            <span class="text-xs">FOLLOW-UP PHYSICAL RISK FACTOR CHECKLIST</span>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="2" class="text-wrap text-center border">Untuk setiap ‘Zona Perhatian’ yang teridentifikasi, temuan setiap factor fisik
                                            menggunakan checklist berikut ini. Tentukan setiap kondisi yang ada di tempat kerja.
                                            Jika ada, bahaya WMSD harus direduksi sampai pada level aman atau pada</td>
                                        <td style="width: 15%" class="border">
                                        Jika terdapat bahaya WMSD,
                                        beri tanda pada kotak
                                        </td>
                                        <td style="width: 15%" class="border text-center">
                                            <input type="checkbox" class="form-check-input" checked disabled>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Faktor Resiko Tindak Lanjut Checklist -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-info text-white text-center">
                                            <th style="width: 15%">
                                                Organ Tubuh<br/>
                                                <span class="text-xs">Body Part</span>
                                            </th>
                                            <th style="width: 25%">
                                                Faktor Resiko Fisik<br/>
                                                <span class="text-xs">Physical Risk Factor</span>
                                            </th>
                                            <th style="width: 20%">
                                                Durasi<br/>
                                                <span class="text-xs">Duration</span>
                                            </th>
                                            <th style="width: 20%">
                                                Visualisasi<br/>
                                                <span class="text-xs">Visualization</span>
                                            </th>
                                            <th style="width: 10%">WMSD ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Bahu (Shoulders) -->
                                        <tr class="text-center">
                                            <td rowspan="2">
                                                Bahu<br/>
                                                <span class="text-primary">Shoulders</span>
                                            </td>
                                            <td class="text-wrap px-2">Bekerja dengan menggunakan tangan diatas bahu atau siku diatas bahu</td>
                                            <td class="text-wrap px-2">Lebih dari 4 jam total per hari</td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/ergonomi/bahu1.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_bahu_1"
                                                        {{ $isShowDetail && $data->wmsd_bahu_1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-wrap px-2 border">Gerakan mengangkat tangan berulang diatas kepala atau siku diatas bahu lebih dari sekali per menit</td>
                                            <td class="text-wrap px-2 border">Lebih dari 4 jam total per hari</td>
                                            <td class="text-center border">
                                                <img src="{{ asset('images/ergonomi/bahu2.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center border">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_bahu_2"
                                                        {{ $isShowDetail && $data->wmsd_bahu_2 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Leher (Neck) -->
                                        <tr class="text-center">
                                            <td>
                                                Leher<br/>
                                                <span class="text-primary">Neck</span>
                                            </td>
                                            <td>Bekerja dengan leher menekuk 45° derajat (tanpa penopang atau kemungkinan postur bervariasi)</td>
                                            <td>Lebih dari 4 jam total per hari</td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/ergonomi/leher.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_leher"
                                                        {{ $isShowDetail && $data->wmsd_leher ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Punggung (Back) -->
                                        <tr class="text-center">
                                            <td rowspan="2">
                                                Punggung<br/>
                                                <span class="text-primary">Back</span>
                                            </td>
                                            <td>Bekerja dengan punggung lebih dari 30° (tanpa penopang atau kemampuan postur bervariasi)</td>
                                            <td>Lebih dari 4 jam total per hari</td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/ergonomi/punggung1.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_punggung_1"
                                                        {{ $isShowDetail && $data->wmsd_punggung_1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-wrap px-2">Bekerja dengan punggung lebih dari 45° (tanpa penopang atau kemampuan postur bervariasi)</td>
                                            <td class="text-wrap px-2">Lebih dari 2 Jam total per hari</td>
                                            <td class="text-center">
                                                <img src="{{ asset('images/ergonomi/punggung2.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_punggung_2"
                                                        {{ $isShowDetail && $data->wmsd_punggung_2 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Lutut (Knee) -->
                                        <tr class="text-center">
                                            <td rowspan="2" class="border">
                                                Lutut<br/>
                                                <span class="text-primary">Knee</span>
                                            </td>
                                            <td class="border">Berjongkok</td>
                                            <td class="border">Lebih dari 2 Jam total per hari</td>
                                            <td class="text-center border">
                                                <img src="{{ asset('images/ergonomi/punggung1.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center border">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_punggung_1"
                                                        {{ $isShowDetail && $data->wmsd_punggung_1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="border">Berlutut</td>
                                            <td class="border">Lebih dari 4 Jam total per hari</td>
                                            <td class="text-center border">
                                                <img src="{{ asset('images/ergonomi/punggung2.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td class="text-center border">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_punggung_2"
                                                        {{ $isShowDetail && $data->wmsd_punggung_2 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tenaga Kuat Pada Tangan Section -->
                             <div class="table-responsive mb-4">
                                <div class="bg-warning p-2 mb-2">
                                    <h6 class="mb-0">Tenaga Kuat Pada Tangan / <span class="text-primary">High End Force</span></h6>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-info text-white text-center">
                                            <th style="width: 15%">
                                                Organ Tubuh<br/>
                                                <span class="text-xs">Body Part</span>
                                            </th>
                                            <th style="width: 30%">
                                                Faktor Resiko Fisik<br/>
                                                <span class="text-xs">Physical Risk Factor</span>
                                            </th>
                                            <th style="width: 25%">
                                                Kombinasi Dengan<br/>
                                                <span class="text-xs">Combination With</span>
                                            </th>
                                            <th style="width: 10%">
                                                Durasi<br/>
                                                <span class="text-xs">Duration</span>
                                            </th>
                                            <th style="width: 10%">
                                                Visualisasi<br/>
                                                <span class="text-xs">Visualization</span>
                                            </th>
                                            <th style="width: 10%">WMSD ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td rowspan="3" class="text-wrap px-2">
                                                Lengan, Pergelangan, Tangan<br/>
                                                <span class="text-primary">Arm, Wrists, Hand</span>
                                            </td>
                                            <td rowspan="3" class="text-wrap px-2">Menjepit beban tanpa bantuan dengan berat 1 (satu) Kilogram atau lebih, atau menjepit dengan tenaga 1 (satu) Kilogram per tangan</td>
                                            <td class="text-wrap px-2">Gerakan Sering Berulang</td>
                                            <td class="text-wrap px-2">Lebih dari 3 Jam total per hari</td>
                                            <td rowspan="3" class="text-center border">
                                                <img src="{{ asset('images/ergonomi/tangan_kuat1.png') }}" class="img-fluid" style="max-height: 100px"><br/>
                                                <img src="{{ asset('images/ergonomi/tangan_kuat2.png') }}" class="img-fluid" style="max-height: 100px"><br/>
                                                <img src="{{ asset('images/ergonomi/tangan_kuat3.png') }}" class="img-fluid" style="max-height: 100px">
                                            </td>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_tangan_kuat_1"
                                                        {{ $isShowDetail && $data->wmsd_tangan_kuat_1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-wrap px-2 border">Pergelangan tangan menekuk sebesar 30° atau lebih, atau sebesar 45° atau kelurusan tulang hasta sebesar 30° atau lebih</td>
                                            <td class="text-wrap px-2 border">Lebih dari 3 Jam total per hari</td>
                                            <td class="text-center border">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_tangan_kuat_2"
                                                        {{ $isShowDetail && $data->wmsd_tangan_kuat_2 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="border">Tidak ada factor Risiko</td>
                                            <td class="border">Lebih dari 4 Jam total per hari</td>
                                            <td class="text-center border">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_tangan_kuat_3"
                                                        {{ $isShowDetail && $data->wmsd_tangan_kuat_3 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Gerakan Sering Berulang Section -->
                            <div class="table-responsive mb-4">
                                <div class="bg-warning p-2 mb-2">
                                    <h6 class="mb-0">Gerakan Sering Berulang / <span class="text-primary">High Repititive Motion</span></h6>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="bg-info text-white text-center">
                                            <th style="width: 15%">
                                                Organ Tubuh<br/>
                                                <span class="text-xs">Body Part</span>
                                            </th>
                                            <th style="width: 30%">
                                                Faktor Resiko Fisik<br/>
                                                <span class="text-xs">Physical Risk Factor</span>
                                            </th>
                                            <th style="width: 25%">
                                                Kombinasi Dengan<br/>
                                                <span class="text-xs">Combination With</span>
                                            </th>
                                            <th style="width: 20%">
                                                Durasi<br/>
                                                <span class="text-xs">Duration</span>
                                            </th>
                                            <th style="width: 10%">WMSD ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td rowspan="2" class="text-wrap px-2">
                                                Leher, Bahu, Siku, Pergelangan, Tanga<br/>
                                                <span class="text-primary">Neck, Shoulders, Elbow, Wrists, Hand</span>
                                            </td>
                                            <td class="text-wrap px-2">Menggunakan Gerakan yang sama dengan perbedaan variasi yang kecil atau tanpa variasi dalam beberapa detik (diluar mengetik)</td>
                                            <td class="text-wrap px-2">Tidak Ada Faktor Resiko</td>
                                            <td class="text-wrap px-2">Lebih dari 6 Jam total per hari</td>
                                            <td>
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_berulang_1"
                                                        {{ $isShowDetail && $data->wmsd_berulang_1 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td class="text-wrap px-2 border">Pergelangan tangan menekuk sebesar 30° atau lebih, atau sebesar 45° atau kelurusan tulang hasta sebesar 30° atau lebih</td>
                                            <td class="text-wrap px-2 border">Pergelangan tangan menekuk sebesar 30° atau lebih, atau sebesar 45° atau kelurusan tulang hasta sebesar 30° atau lebih dan kuat, tenaga berlebihan pada tangan</td>
                                            <td class="text-wrap px-2 border">Lebih dari 2 Jam total per hari</td>
                                            <td class="text-center border">
                                                <div class="form-check d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="wmsd_berulang_2"
                                                        {{ $isShowDetail && $data->wmsd_berulang_2 ? 'checked' : '' }}
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Kesimpulan Penilai -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center" style="background-color: #FACC15;">
                                        <td>
                                            <strong>KESIMPULAN PENILAI / RESUME OF ASSESSOR</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">
                                            <div class="input-group input-group-static">
                                                <textarea name="kesimpulan_penilai" class="form-control" rows="4"
                                                    {{ $isShowDetail ? 'disabled' : '' }}>{{ $isShowDetail ? $data->kesimpulan_penilai : old('kesimpulan_penilai') }}</textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Signatures -->
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td colspan="2" class="text-center border">
                                                    <strong>Disusun Oleh / <span class="text-primary">Propose By</span></strong>
                                                </td>
                                                <td class="text-center border">
                                                    <strong>Diperiksa Oleh / <span class="text-primary">Checked By</span></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 25%" class="text-center border">Paramedic</td>
                                                <td style="width: 25%" class="text-center border">Doctor</td>
                                                <td style="width: 50%" class="text-center border">Dept Head of SHE</td>
                                            </tr>
                                            <tr style="height: 100px">
                                                <td class="align-bottom text-center border">
                                                    <input type="text" name="paramedic_name" class="form-control text-center" required
                                                        value="{{ $isShowDetail ? $data->paramedic_name : old('paramedic_name') }}"
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td class="align-bottom text-center border">
                                                    <input type="text" name="doctor_name" class="form-control text-center" required
                                                        value="{{ $isShowDetail ? $data->doctor_name : old('doctor_name') }}"
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                                <td class="align-bottom text-center border">
                                                    <input type="text" name="dept_head_name" class="form-control text-center" required
                                                        value="{{ $isShowDetail ? $data->dept_head_name : old('dept_head_name') }}"
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="text-center border">
                                                    <div class="py-2">
                                                        <strong>Tanggal<br/><span class="text-primary">Date</span></strong>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                            <tr style="height: 100px">
                                                <td class="align-bottom text-center border">
                                                    <input type="date" name="review_date" class="form-control text-center mb-2" required
                                                        value="{{ $isShowDetail ? $data->review_date : old('review_date') }}"
                                                        {{ $isShowDetail ? 'disabled' : '' }}>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    @if($isShowDetail)
                                        <a href="{{ route('she.ergonomi.dashboard') }}" class="btn btn-secondary">Back</a>
                                        <a href="{{ route('she.ergonomi.export', $data->id) }}" class="btn btn-primary">
                                            <i class="material-icons">download</i> Export PDF
                                        </a>
                                    @else
                                        <a href="{{ route('she.ergonomi.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-css')
<style>
    .form-check-input {
        margin-top: 0.25rem;
    }
    .form-check-label {
        margin-left: 0.5rem;
    }
</style>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
    $(function() {
        var form = $("form");
        var submitBtn = form.find('button[type="submit"]');

        // Function to validate required fields
        function validateForm() {
            var isValid = true;
            var requiredFields = [
                { name: 'job_position', label: 'Job Position' },
                { name: 'evaluation_date', label: 'Evaluation Date' },
                { name: 'total_employee', label: 'Total Employee' },
                { name: 'employee_name', label: 'Employee Name' },
                { name: 'reviewer_name', label: 'Reviewer Name' },
                { name: 'paramedic_name', label: 'Paramedic Name' },
                { name: 'doctor_name', label: 'Doctor Name' },
                { name: 'dept_head_name', label: 'Department Head Name' }
            ];

            var missingFields = [];
            requiredFields.forEach(function(field) {
                var value = $('[name="' + field.name + '"]').val();
                if (!value || value.trim() === '') {
                    isValid = false;
                    missingFields.push(field.label);
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required Fields Missing',
                    text: 'Please fill in the following fields:\n' + missingFields.join('\n')
                });
            }

            return isValid;
        }

        form.submit(function(e) {
            e.preventDefault();

            // Validate form before submission
            if (!validateForm()) {
                return false;
            }

            submitBtn.prop('disabled', true);
            var formData = new FormData(this);
            
            axios.post('{{ route("she.ergonomi.store") }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route("she.ergonomi.dashboard") }}';
                            }
                        });
                    }
                })
                .catch(function(error) {
                    let errorMessage = 'Terjadi kesalahan pada sistem';
                    
                    if (error.response) {
                        if (error.response.data.errors) {
                            errorMessage = Object.values(error.response.data.errors).flat().join('\n');
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