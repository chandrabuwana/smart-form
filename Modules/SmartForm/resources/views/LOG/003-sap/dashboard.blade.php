@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .m-0 {
        margin: 0;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Dashboard PENGAJUAN PR 003 SAP</h6>
                    </div>
                </div>
                <div class="card-body my-1">

                    <div class="d-flex align-items-center ms-3">
                        <a href="{{ route('create-003-sap') }}">
                            <button class="btn btn-primary ms-auto uploadBtn">
                                New Form
                            </button>
                        </a>
                    </div>

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
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fas fa-calendar text-success fa-2x"></i>
                                        </div>
                                        <div class="text-end pt-1">
                                            <p class="text-sm mb-0 text-capitalize">This Month</p>
                                        <h4 class="mb-0">{{ $statistics->total_this_month }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stats-card">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fas fa-tram fa-2x" style="color: #B197FC;"></i>
                                        </div>
                                        <div class="text-end pt-1">
                                            <p class="text-sm mb-0 text-capitalize">Plant</p>
                                            <h4 class="mb-0">{{ $statistics->plant }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Doc Number</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PLANT</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Checker</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Creator</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $data)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $data->doc_num ?? '' }}</h6>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $data->plant ?? '' }}</p>
                                                </td>

                                                <td>
                                                    <span class="text-xs font-weight-bold">{{ $data->created_at ?? '' }}</span>
                                                </td>
                                                @php
                                                    $status = json_decode($data->status, true);
                                                @endphp
                                                <td>


                                                    @if ($status[0] === 'approved')
                                                        <span
                                                            class="badge bg-success">{{ optional(collect($user)->firstWhere('nama', $data->checked_by))->nama ?? '' }}</span>
                                                    @elseif ($status[0] === 'rejected')
                                                        <span
                                                            class="badge bg-danger">{{ optional(collect($user)->firstWhere('nama', $data->checked_by))->nama ?? '' }}</span>
                                                    @elseif ($status[0] === null)
                                                        <span
                                                            class="badge bg-info">{{ optional(collect($user)->firstWhere('nama', $data->checked_by))->nama ?? '' }}</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold">
                                                        @if ($status[1] === 'approved')
                                                            <span
                                                                class="badge bg-success">{{ optional(collect($user)->firstWhere('nama', $data->dibuat_oleh))->nama ?? '' }}</span>
                                                        @elseif ($status[1] === 'rejected')
                                                            <span
                                                                class="badge bg-danger">{{ optional(collect($user)->firstWhere('nama', $data->dibuat_oleh))->nama ?? '' }}</span>
                                                        @elseif ($status[1] == null)
                                                            <span
                                                                class="badge bg-info">{{ optional(collect($user)->firstWhere('nama', $data->dibuat_oleh))->nama ?? '' }}</span>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-xs font-weight-bold">
                                                        @if (collect($status)->every(fn($s) => $s === 'approved'))
                                                            <span class="badge bg-success">Approved</span>
                                                        @elseif (collect($status)->contains(fn($s) => $s === 'rejected'))
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @elseif (collect($status)->contains(fn($s) => $s === null))
                                                            <span class="badge bg-info">Draf</span>
                                                        @endif
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($session == $data->dibuat_oleh)
                                                        <a href="{{ route('003-sap-detail', ['id' => $data->id]) }}"
                                                            class="btn btn-warning btn-sm mt-3"
                                                            style="{{ $data->delete_status == 1 ? 'pointer-events: none; opacity: 0.6;' : '' }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm mt-3"
                                                            onclick="deleteXcmg900('{{ $data->id }}')"
                                                            {{ $data->delete_status == 1 ? 'disabled' : '' }}>
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif

                                                    <a href="{{ route('003-sap-show', ['id' => $data->id]) }}"
                                                        class="btn btn-info btn-sm mt-3"
                                                        style="{{ $data->delete_status == 1 ? 'pointer-events: none; opacity: 0.6;' : '' }}">
                                                        <i class="far fa-check-circle " style="font-size:12px;"></i>
                                                    </a>

                                                    @if (collect($status)->every(fn($s) => $s === 'approved'))
                                                        <a href="{{ route('export-003-sap', ['id' => $data->id]) }}"
                                                            class="btn btn-primary btn-sm mt-3"
                                                            style="{{ $data->delete_status == 1 ? 'pointer-events: none; opacity: 0.6;' : '' }}">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
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
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#approval').select2();
        });
        $(function() {
            // Clear filter button
            $('#btnClearFilter').click(function() {
                window.location.href = '{{ route('dashboard-wc') }}';
            });

        });

        function deleteXcmg900(id) {
            console.log('Delete ID:', id);
            if (confirm('Are you sure you want to delete this data?')) {
                axios.delete('{{ route('003-sap-delete', ['id' => 'ID']) }}'.replace('ID', id))
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
