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
                    <h6 class="text-white text-capitalize ps-3">Dashboard Form A2B Baru</h6>
                </div>
            </div>
            <!-- Statistics Cards -->
                <div class="row g-3 mb-4 ">
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
                        <a href="{{ route('prod.a2b-baru.form') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>
                    <h5 class="mx-4">Filter Data</h5>
                    <div class="mx-4 row">
                        <form action="{{ route('prod.a2b-baru.dashboard') }}" method="GET" id="filterForm">
                            <div class="row align-items-center">
                                <div class="col-md-2 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label>Search</label>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search by doc number or name"
                                            value="{{ $filters['search'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="operator" class="ms-0">Operator</label>

                                        <select class="form-control" id="operator" name="operator">
                                            <option value="" selected disabled>-- Select --</option>
                                            @foreach ($user as $usr)
                                                <option value="{{ $usr->nik }}" 
                                                    {{ isset($filters['operator']) && $filters['operator'] == $usr->nik ? 'selected' : '' }}>
                                                    {{ $usr->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="pengawas" class="ms-0">Pengawas</label>
                                        <select class="form-control" id="pengawas" name="pengawas">
                                            <option value="" selected disabled>-- Select --</option>
                                            @foreach ($user as $usr)
                                                <option value="{{ $usr->nik }}" 
                                                    {{ isset($filters['pengawas']) && $filters['pengawas'] == $usr->nik ? 'selected' : '' }}>
                                                    {{ $usr->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="input-group input-group-static mb-4 position-relative">
                                        <label for="status" class="ms-0">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="" selected disabled></option>
                                            <option value="Approved"
                                                {{ isset($filters['status']) && $filters['status'] == 'Approved' ? 'selected' : '' }}>
                                                Approved
                                            </option>
                                            <option value="Rejected"
                                                {{ isset($filters['status']) && $filters['status'] == 'Rejected' ? 'selected' : '' }}>
                                                Rejected
                                            </option>
                                            <option value="Pending"
                                                {{ isset($filters['status']) && $filters['status'] == 'Pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="col-md-12 mb-3 d-flex justify-content-start">
                                    <button type="submit" class="btn btn-primary filter-btn" id="btnFilterSubmit">
                                        Filter
                                    </button>
                                    <button type="button" class="btn btn-secondary filter-btn" id="btnClearFilter">
                                        Clear Filter
                                    </button>
                                </div>
                            </div>
                        </form>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Operator</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nrp</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Operator</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pengawas</th>
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
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->nama_operator }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $record->nrp }}</p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">{{ $record->tanggal }}</span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $record->operator }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $record->pengawas }}
                                        </p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold">
                                            @if ($record->status_operator === 'Approve' && $record->status_pengawas === 'Approve')
                                                Approved
                                            @elseif ($record->status_operator === 'Reject' && $record->status_pengawas === 'Reject')
                                                Rejected
                                            @elseif ($record->status_operator === 'Pending' && $record->status_pengawas === 'Pending')
                                                Pending
                                            @elseif ($record->status_operator === 'Pending' || $record->status_pengawas === 'Pending')
                                                Pending
                                            @elseif (
                                                ($record->status_operator === 'Approve' && $record->status_pengawas === 'Reject') || 
                                                ($record->status_operator === 'Reject' && $record->status_pengawas   === 'Approve')
                                            )
                                                Rejected
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('prod.a2b-baru.form', ['id' => $record->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('prod.a2b-baru.export', ['id' => $record->id]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="deleteA2bBaru('{{ $record->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <a href="{{ route('prod.a2b-baru.edit', ['id' => $record->id]) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('prod.a2b-baru.approval', ['id' => $record->id]) }}"
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
        window.location.href = '{{ route("prod.a2b-baru.dashboard") }}';
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
function deleteA2bBaru(id) {
            console.log('Delete ID:', id);
            if (confirm('Are you sure you want to delete this data?')) {
                axios.delete('{{ route('prod.a2b-baru.delete', ['id' => 'ID']) }}'.replace('ID', id))
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

<script>
    $(function() {
        $('#operator, #pengawas').select2({
            placeholder: '-- Pilih --',
            width: '100%',
            ajax: {
                url: '{{ route('prod.a2b.approval.list') }}',
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