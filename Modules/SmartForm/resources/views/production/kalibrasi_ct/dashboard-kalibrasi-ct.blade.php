@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/extensions/filter-control/bootstrap-table-filter-control.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .stats-card {
        transition: all 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .filter-btn {
        display: inline;
        width: auto;
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Dashboard Kalibrasi CT</h6>
                </div>
            </div>
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stats-card">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas fa-file text-primary fa-2x"></i>
                                </div>
                                <div class="text-end pt-1">
                                    <p class="text-sm mb-0 text-capitalize">Total Records</p>
                                    <h4 class="mb-0">{{ $statistics->total_records }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="card-body px-0 pb-2">
                <div class="d-flex align-items-center mx-3">
                    <a href="{{ route('prod.kalibrasi-ct.form') }}">
                        <button class="btn btn-primary ms-auto uploadBtn">
                            New Form
                        </button>
                    </a>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Doc Number</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Operator Hauler</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Operator Loader</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Operator Dozer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($records as $record)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $record->doc_number }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->nama_operator_loader_hauler }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->nama_operator_loader }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->nama_operator_dozer }}</p>
                                    </td>

                                    <td>
                                        <span class="text-xs font-weight-bold">
                                            @if (
                                                $record->status_dibuat_hauler === 'Approve' && 
                                                $record->status_mengetahui_hauler === 'Approve' && 
                                                $record->status_dibuat_loader === 'Approve' && 
                                                $record->status_mengetahui_loader === 'Approve' && 
                                                $record->status_dibuat_dozer === 'Approve' && 
                                                $record->status_mengetahui_dozer === 'Approve'
                                            )
                                                Approved
                                            @elseif (
                                                $record->status_dibuat_hauler === 'Reject' && 
                                                $record->status_mengetahui_hauler === 'Reject' && 
                                                $record->status_dibuat_loader === 'Reject' && 
                                                $record->status_mengetahui_loader === 'Reject' && 
                                                $record->status_dibuat_dozer === 'Reject' && 
                                                $record->status_mengetahui_dozer === 'Reject'
                                            )
                                                Rejected
                                            @elseif (
                                                $record->status_dibuat_hauler === 'Pending' || 
                                                $record->status_mengetahui_hauler === 'Pending' || 
                                                $record->status_dibuat_loader === 'Pending' || 
                                                $record->status_mengetahui_loader === 'Pending' || 
                                                $record->status_dibuat_dozer === 'Pending' || 
                                                $record->status_mengetahui_dozer === 'Pending'
                                            )
                                                Pending
                                            @elseif (
                                                ($record->status_dibuat_hauler === 'Approve' && $record->status_mengetahui_hauler === 'Reject') || 
                                                ($record->status_dibuat_loader === 'Approve' && $record->status_mengetahui_loader === 'Reject') || 
                                                ($record->status_dibuat_dozer === 'Approve' && $record->status_mengetahui_dozer === 'Reject') || 
                                                ($record->status_dibuat_hauler === 'Reject' && $record->status_mengetahui_hauler === 'Approve') || 
                                                ($record->status_dibuat_loader === 'Reject' && $record->status_mengetahui_loader === 'Approve') || 
                                                ($record->status_dibuat_dozer === 'Reject' && $record->status_mengetahui_dozer === 'Approve')
                                            )
                                                Rejected
                                            @else
                                                Undefined
                                            @endif
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('prod.kalibrasi-ct.form', ['id' => $record->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('prod.kalibrasi-ct.export', ['id' => $record->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteKalibrasi('{{ $record->id }}')">
                                                <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="{{ route('prod.kalibrasi-ct.edit', ['id' => $record->id]) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('prod.kalibrasi-ct.approval', ['id' => $record->id]) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-user-check"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
<script>
$(function() {
    // Clear filter button
    $('#btnClearFilter').click(function() {
        window.location.href = '{{ route("prod.kalibrasi-ct.dashboard") }}';
    });

    // Date range picker initialization
    if($('#start_date').length && $('#end_date').length) {
        const startDate = $('#start_date');
        const endDate = $('#end_date');

        startDate.on('change', function() {
            endDate.attr('min', $(this).val());
        });

        endDate.on('change', function() {
            startDate.attr('max', $(this).val());
        });
    }
});

function deleteKalibrasi(id) {
            console.log('Delete ID:', id);
            if (confirm('Are you sure you want to delete this data?')) {
                axios.delete('{{ route('prod.kalibrasi-ct.delete', ['id' => 'ID']) }}'.replace('ID', id))
                    .then(function(response) {
                        console.log('Response:', response);
                        if (response.data.success) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then(() => {

                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete the compressor.'
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
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
            }
        }
</script>
@endsection