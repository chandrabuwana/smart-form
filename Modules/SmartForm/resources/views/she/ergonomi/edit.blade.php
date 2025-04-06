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
                        <h6 class="text-white text-capitalize ps-3">Edit Ergonomi Survey</h6>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('she.ergonomi.update') }}" method="POST" id="editForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">
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
                                        <td>
                                            <input type="text" class="form-control" name="job_position" value="{{ $data->job_position }}" required>
                                        </td>
                                        <td class="text-center">
                                            <strong>Tanggal Evaluasi</strong><br/>
                                            <span class="text-xs">Evaluation Date</span>
                                        </td>
                                        <td colspan="2">
                                            <input type="date" class="form-control" name="evaluation_date" value="{{ $data->evaluation_date }}" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <strong>Nama Karyawan</strong><br/>
                                            <span class="text-xs">Employee Name</span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="employee_name" value="{{ $data->employee_name }}" required>
                                        </td>
                                        <td class="text-center">
                                            <strong>ID Karyawan</strong><br/>
                                            <span class="text-xs">Employee ID</span>
                                        </td>
                                        <td colspan="2">
                                            <input type="text" class="form-control" name="employee_id" value="{{ $data->employee_id }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <strong>Jumlah Karyawan</strong><br/>
                                            <span class="text-xs">Total Employee</span>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="total_employee" value="{{ $data->total_employee }}" required>
                                        </td>
                                        <td class="text-center">
                                            <strong>Nama Peninjau</strong><br/>
                                            <span class="text-xs">Reviewer Name</span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="reviewer_name" value="{{ $data->reviewer_name }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="reviewer_id" value="{{ $data->reviewer_id }}" placeholder="ID Peninjau">
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Checklist Section -->
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <tr class="text-center">
                                        <td style="width: 5%" class="bg-warning fw-bold text-black">A</td>
                                        <td colspan="4" class="bg-warning">
                                            <strong>IDENTIFIKASI FAKTOR RISIKO ERGONOMI / IDENTIFICATION OF ERGONOMIC RISK FACTORS</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="p-3">
                                            <p>Centang kotak di bawah ini jika faktor risiko ergonomi teridentifikasi pada pekerjaan yang dievaluasi. Jika ada faktor risiko, lengkapi informasi tambahan yang diminta.</p>
                                            <p>Check the box below if the ergonomic risk factor is identified in the job being evaluated. If there is a risk factor, complete the additional information requested.</p>
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
                                    </tr>
                                    <tr class="text-center bg-light">
                                        <td style="width: 5%">#</td>
                                        <td style="width: 15%">Gambar / Image</td>
                                        <td>Deskripsi / Description</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center border">1</td>
                                        <td style="width: 15%" class="border">
                                            <img src="{{ asset('img/form-she-ergonomi/postur1.png') }}" class="img-fluid">
                                        </td>
                                        <td class="border">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="item_1" {{ $data->item_1 ? 'checked' : '' }}>
                                                    <label class="form-check-label">Bekerja dengan tangan diatas kepala atau siku diatas bahu</label>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Organ Tubuh</label>
                                                    <input type="text" class="form-control" name="organ_tubuh_1" value="{{ $data->organ_tubuh_1 }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Faktor Risiko</label>
                                                    <input type="text" class="form-control" name="faktor_resiko_1" value="{{ $data->faktor_resiko_1 }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Kombinasi Dengan</label>
                                                    <input type="text" class="form-control" name="kombinasi_dengan_1" value="{{ $data->kombinasi_dengan_1 }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Durasi</label>
                                                    <input type="text" class="form-control" name="durasi_1" value="{{ $data->durasi_1 }}">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label">Visualisasi</label>
                                                    <input type="text" class="form-control" name="visualisasi_1" value="{{ $data->visualisasi_1 }}">
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Observasi</label>
                                                    <textarea class="form-control" name="item_1_observation" rows="2">{{ $data->item_1_observation }}</textarea>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Additional items would be listed here -->
                                </table>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('she.ergonomi.dashboard') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
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
        width: 1.2em;
        height: 1.2em;
    }
    .form-check-label {
        margin-left: 0.5em;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form submission
        document.getElementById('submitBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Validate form
            const form = document.getElementById('editForm');
            if (form.checkValidity()) {
                form.submit();
            } else {
                // Trigger browser's native validation
                form.reportValidity();
            }
        });
    });
</script>
@endsection
