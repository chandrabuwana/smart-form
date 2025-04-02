@extends('master.master_page')

@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.css">
<style>
    .text-right {
        text-align: right;
    }
    .approval-section {
        margin-top: 2rem;
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .approval-badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        margin-left: 0.5rem;
    }
    .approval-badge.approved {
        background-color: #4caf50;
        color: white;
    }
    .approval-badge.rejected {
        background-color: #f44336;
        color: white;
    }
    .approval-badge.pending {
        background-color: #ffc107;
        color: black;
    }
    .approval-user {
        font-weight: bold;
        margin-right: 0.5rem;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">FORM BSS SHE 036 INSPEKSI APAR</h6>
                        <div class="d-flex mx-3">
                            <a href="{{ route('bss-form.she-036.inspeksi-apar.dashboard') }}" class="btn btn-white btn-sm me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body my-1">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="font-weight-bold">Document Information</h5>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td>No. Document</td>
                                            <td>:</td>
                                            <td>{{ $data->no_dok }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td>{{ $data->tanggal }}</td>
                                        </tr>
                                        <tr>
                                            <td>Dibuat Oleh</td>
                                            <td>:</td>
                                            <td>{{ $data->dibuat_oleh }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="font-weight-bold">Location Information</h5>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td>Lokasi Inspeksi</td>
                                            <td>:</td>
                                            <td>{{ $data->lokasi_inspeksi }}</td>
                                        </tr>
                                        <tr>
                                            <td>Catatan</td>
                                            <td>:</td>
                                            <td>{{ $data->catatan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="approval-section">
                        <h5 class="font-weight-bold">Approval Status</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <p>
                                    <span class="approval-user">Diperiksa Oleh:</span> 
                                    {{ $data->diperiksa_oleh_name ?? ($data->diperiksa_oleh_name ?? 'Belum ditentukan') }}
                                    @php
                                        $diperiksa_status = isset($data->status) && is_array($data->status) ? $data->status[0] : null;
                                    @endphp
                                    
                                    @if($diperiksa_status === 'approved')
                                        <span class="approval-badge approved">Approved</span>
                                    @elseif($diperiksa_status === 'rejected')
                                        <span class="approval-badge rejected">Rejected</span>
                                    @else
                                        <span class="approval-badge pending">Pending</span>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-success btn-sm approve-btn"
                                                data-id="{{ $data->id }}"
                                                data-position="0"
                                                data-role="diperiksa">
                                            <i class="fas fa-check me-1"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                data-id="{{ $data->id }}"
                                                data-position="0"
                                                data-role="diperiksa">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </div>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    <span class="approval-user">Diketahui Oleh:</span> 
                                    {{ $data->diketahui_oleh_name ?? ($data->diketahui_oleh_name ?? 'Belum ditentukan') }}
                                    @php
                                        $diketahui_status = isset($data->status) && is_array($data->status) ? $data->status[1] : null;
                                    @endphp
                                    
                                    @if($diketahui_status === 'approved')
                                        <span class="approval-badge approved">Approved</span>
                                    @elseif($diketahui_status === 'rejected')
                                        <span class="approval-badge rejected">Rejected</span>
                                    @else
                                        <span class="approval-badge pending">Pending</span>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <!-- Only show Diketahui buttons if Diperiksa is approved -->
                                        @if($diperiksa_status === 'approved')
                                            <button type="button" class="btn btn-success btn-sm approve-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="1"
                                                    data-role="diketahui">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="1"
                                                    data-role="diketahui">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        @else
                                            <small class="text-muted">Waiting for previous approval</small>
                                        @endif
                                    </div>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    <span class="approval-user">Disetujui Oleh:</span> 
                                    {{ $data->disetujui_oleh_name ?? ($data->disetujui_oleh_name ?? 'Belum ditentukan') }}
                                    @php
                                        $disetujui_status = isset($data->status) && is_array($data->status) ? $data->status[2] : null;
                                    @endphp
                                    
                                    @if($disetujui_status === 'approved')
                                        <span class="approval-badge approved">Approved</span>
                                    @elseif($disetujui_status === 'rejected')
                                        <span class="approval-badge rejected">Rejected</span>
                                    @else
                                        <span class="approval-badge pending">Pending</span>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <!-- Only show Disetujui buttons if both Diperiksa and Diketahui are approved -->
                                        @if($diperiksa_status === 'approved' && $diketahui_status === 'approved')
                                            <button type="button" class="btn btn-success btn-sm approve-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="2"
                                                    data-role="disetujui">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="2"
                                                    data-role="disetujui">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        @else
                                            <small class="text-muted">Waiting for previous approval</small>
                                        @endif
                                    </div>
                                </p>
                            </div>
                        </div>
                        
                        @php
                            $hasRejection = isset($data->status) && in_array('rejected', $data->status);
                            $isCreatorOrAdmin = $data->dibuat_oleh == $nik || in_array($nik, ['1008491', '1008492', '1008493', '1008494', '1008526']);
                        @endphp
                        
                        @if($hasRejection && $isCreatorOrAdmin)
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary btn-sm reset-approval"
                                        data-id="{{ $data->id }}">
                                    <i class="fas fa-undo me-1"></i> Reset Approval Status
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <h5 class="font-weight-bold">Detail APAR</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Lokasi APAR</th>
                                        <th>Jenis APAR</th>
                                        <th>Tekanan Tabung</th>
                                        <th>Berat APAR</th>
                                        <th>Kondisi</th>
                                        <th>Berlaku Sampai</th>
                                        <th>PIC</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detail as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->lokasi_apar }}</td>
                                        <td>{{ $item->jenis_apar }}</td>
                                        <td>{{ $item->tekanan_tabung }}</td>
                                        <td>{{ $item->berat_apar }} kg</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li>Tabung: {!! $item->tabung ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</li>
                                                <li>Handle: {!! $item->handle ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</li>
                                                <li>Selang: {!! $item->selang ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</li>
                                                <li>Label: {!! $item->label_tabung ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</li>
                                                <li>Kartu: {!! $item->label_kartu ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' !!}</li>
                                            </ul>
                                        </td>
                                        <td>{{ $item->berlaku_sampai }}</td>
                                        <td>{{ $item->pic }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex align-items-center">

                            @php
                                $isFullyApproved = isset($data->status) && 
                                                is_array($data->status) && 
                                                count($data->status) >= 3 &&
                                                $data->status[0] === 'approved' && 
                                                $data->status[1] === 'approved' && 
                                                $data->status[2] === 'approved';
                            @endphp

                            @if($isFullyApproved)
                             <a href="{{ route('bss-form.she-036.pdf-inspeksi-apar', ['id' => $data->id]) }}" class="btn btn-primary ms-auto">
                                    <i class="fas fa-download me-1"></i> Export PDF
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.6/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.approve-btn').on('click', function() {
                const recordId = $(this).data('id');
                const position = $(this).data('position');
                const role = $(this).data('role');
                
                let approveData = {
                    id: recordId,
                    _token: '{{ csrf_token() }}'
                };
                
                if (position === 0) {
                    approveData.diperiksa = 'approved';
                } else if (position === 1) {
                    approveData.diketahui = 'approved';
                } else if (position === 2) {
                    approveData.disetujui = 'approved';
                }

                Swal.fire({
                    title: 'Approve Document',
                    text: "Apakah Anda yakin ingin menyetujui dokumen ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, setujui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("{{ route('bss-form.she-036.approve-inspeksi-apar') }}", approveData)
                            .then(function(response) {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Approved!',
                                        text: response.data.message || 'Dokumen telah disetujui.',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.data.message || 'Gagal menyetujui dokumen.',
                                    });
                                }
                            })
                            .catch(function(error) {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat proses persetujuan.',
                                });
                            });
                    }
                });
            });

            $('.reject-btn').on('click', function() {
                const recordId = $(this).data('id');
                const position = $(this).data('position');
                const role = $(this).data('role');
                
                let rejectData = {
                    id: recordId,
                    _token: '{{ csrf_token() }}'
                };
                
                if (position === 0) {
                    rejectData.diperiksa = 'rejected';
                } else if (position === 1) {
                    rejectData.diketahui = 'rejected';
                } else if (position === 2) {
                    rejectData.disetujui = 'rejected';
                }

                Swal.fire({
                    title: 'Reject Document',
                    text: "Apakah Anda yakin ingin menolak dokumen ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, tolak!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("{{ route('bss-form.she-036.reject-inspeksi-apar') }}", rejectData)
                            .then(function(response) {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Rejected!',
                                        text: response.data.message || 'Dokumen telah ditolak.',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.data.message || 'Gagal menolak dokumen.',
                                    });
                                }
                            })
                            .catch(function(error) {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat proses penolakan.',
                                });
                            });
                    }
                });
            });

            $('.reset-approval').on('click', function() {
                const recordId = $(this).data('id');

                Swal.fire({
                    title: 'Reset Approval Status',
                    text: "Apakah Anda yakin ingin mengatur ulang status persetujuan?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post(`/bss-form/she-036/reset-inspeksi-apar/${recordId}`)
                            .then(function(response) {
                                if (response.data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Reset!',
                                        text: response.data.message || 'Status persetujuan telah diatur ulang.',
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.data.message || 'Gagal mengatur ulang status persetujuan.',
                                    });
                                }
                            })
                            .catch(function(error) {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat mengatur ulang status persetujuan.',
                                });
                            });
                    }
                });
            });
        });
    </script>
@endsection