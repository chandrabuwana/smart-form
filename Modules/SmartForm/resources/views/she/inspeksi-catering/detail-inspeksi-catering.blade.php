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
        color: #fff;
        background-color: #28a745;
    }
    .approval-badge.rejected {
        color: #fff;
        background-color: #dc3545;
    }
    .approval-badge.pending {
        color: #212529;
        background-color: #ffc107;
    }
    .approval-user {
        font-weight: bold;
    }
    .catering-data-section {
        margin-bottom: 2rem;
    }
    .section-heading {
        background-color: #f8f9fa;
        padding: 0.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    .data-row {
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">FORM BSS SHE 048 INSPEKSI CATERING</h6>
                        <div class="d-flex mx-3">
                            <a href="{{ route('bss-form.she-048.inspeksi-catering.dashboard') }}" class="btn btn-white btn-sm me-2">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                            
                            @php
                                // Check if all approvals are complete (all three positions are 'approved')
                                $isFullyApproved = isset($data->status) && 
                                                  is_array($data->status) && 
                                                  count($data->status) >= 3 &&
                                                  $data->status[0] === 'approved' && 
                                                  $data->status[1] === 'approved' && 
                                                  $data->status[2] === 'approved';
                            @endphp
                            
                            @if($isFullyApproved)
                                <a href="{{ route('bss-form.she-048.pdf-inspeksi-catering', ['id' => $data->id]) }}" class="btn btn-white btn-sm">
                                    <i class="fas fa-download me-1"></i> Export PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body my-1">
                    <div class="catering-data-section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="data-row">
                                    <strong>Nama Site:</strong> {{ $data->nama_site }}
                                </div>
                                <div class="data-row">
                                    <strong>Departemen:</strong> {{ $data->department }}
                                </div>
                                <div class="data-row">
                                    <strong>Shift:</strong> {{ $data->shift }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="data-row">
                                    <strong>Lokasi Kerja:</strong> {{ $data->lokasi_kerja }}
                                </div>
                                <div class="data-row">
                                    <strong>Jumlah Inspektor:</strong> {{ $data->jumlah_inspektor }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <<!-- Replace the inspection-data section with this complete code -->
                    <div class="inspection-data">
                        <!-- Section A: Penerimaan -->
                        <div class="section-heading bg-warning text-white">
                            (A) Penerimaan NILAI (ACT/STD*10)
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="60%">Pertanyaan</th>
                                        <th width="15%">Nilai</th>
                                        <th width="20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Apakah karyawan penerimaan / gudang dalam keadaan sehat</td>
                                        <td>{{ $data->q_penerimaan_1 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Apakah karyawan penerimaan / gudang menggunakan seragam lengkap dan bersih</td>
                                        <td>{{ $data->q_penerimaan_2 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Apakah ada proses penimbangan sebelum penerimaan</td>
                                        <td>{{ $data->q_penerimaan_3 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Apakah timbangan terkalibrasi</td>
                                        <td>{{ $data->q_penerimaan_4 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_4 }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Apakah ada proses pengkajian surat jalan dari supplier</td>
                                        <td>{{ $data->q_penerimaan_5 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_5 }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Apakah ada proses pengecekan organoleptik saat penerimaan</td>
                                        <td>{{ $data->q_penerimaan_6 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_6 }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Apakah ada produk / bahan makanan yang ditolak</td>
                                        <td>{{ $data->q_penerimaan_7 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_7 }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Apakah kemasan makanan masih dalam keadaan utuh / tidak rusak</td>
                                        <td>{{ $data->q_penerimaan_8 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_8 }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Apakah bahan makanan masih dalam keadaan baik</td>
                                        <td>{{ $data->q_penerimaan_9 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_9 }}</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Apakah dilakukan pembersihan area bahan makanan</td>
                                        <td>{{ $data->q_penerimaan_10 }}</td>
                                        <td>{{ $data->q_keterangan_penerimaan_10 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Section B: Penyimpanan -->
                        <div class="section-heading bg-warning text-white mt-4">
                            (B) Penyimpanan NILAI (ACT/STD*10)
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="60%">Pertanyaan</th>
                                        <th width="15%">Nilai</th>
                                        <th width="20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Apakah tempat penyimpanan dalam keadaan bersih</td>
                                        <td>{{ $data->q_penyimpanan_1 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Apakah makanan dalam keadaan tertutup</td>
                                        <td>{{ $data->q_penyimpanan_2 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Apakah suhu chiller / freezer normal sesuai fungsinya</td>
                                        <td>{{ $data->q_penyimpanan_3 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Apakah ada monitoring suhu secara rutin</td>
                                        <td>{{ $data->q_penyimpanan_4 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_4 }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Apakah logistik yang disimpan diberi label identifikasi</td>
                                        <td>{{ $data->q_penyimpanan_5 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_5 }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Apakah ada pemisahan antara bahan-bahan makanan dengan makanan jadi</td>
                                        <td>{{ $data->q_penyimpanan_6 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_6 }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Apakah ada pemisahan antara bahan makanan kering dengan bahan makanan basah</td>
                                        <td>{{ $data->q_penyimpanan_7 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_7 }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Apakah dalam penyimpanan bahan makanan menggunakan sistem FIFO</td>
                                        <td>{{ $data->q_penyimpanan_8 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_8 }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Apakah di dalam tempat penyimpanan ditemukan makanan yang kadaluarsa</td>
                                        <td>{{ $data->q_penyimpanan_9 }}</td>
                                        <td>{{ $data->q_keterangan_penyimpanan_9 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Section C: Persiapan -->
                        <div class="section-heading bg-warning text-white mt-4">
                            (C) Persiapan NILAI (ACT/STD*10)
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="60%">Pertanyaan</th>
                                        <th width="15%">Nilai</th>
                                        <th width="20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Apakah karyawan dapur dalam keadaan sehat</td>
                                        <td>{{ $data->q_persiapan_1 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Apakah karyawan dapur menggunakan seragam lengkap dan bersih</td>
                                        <td>{{ $data->q_persiapan_2 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Apakah karyawan dapur mencuci tangan sebelum bekerja</td>
                                        <td>{{ $data->q_persiapan_3 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Apakah area persiapan dalam keadaan bersih</td>
                                        <td>{{ $data->q_persiapan_4 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_4 }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Apakah peralatan yang digunakan dalam keadaan bersih</td>
                                        <td>{{ $data->q_persiapan_5 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_5 }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Apakah bahan-bahan makanan dalam keadaan baik</td>
                                        <td>{{ $data->q_persiapan_6 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_6 }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Apakah bahan-bahan makanan dicuci sebelum dimasak</td>
                                        <td>{{ $data->q_persiapan_7 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_7 }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Apakah ada pemisahan antara cutting board untuk sayuran, daging ayam, dan daging sapi</td>
                                        <td>{{ $data->q_persiapan_8 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_8 }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Apakah ada pemisahan antara knife untuk sayuran, daging ayam, dan daging sapi</td>
                                        <td>{{ $data->q_persiapan_9 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_9 }}</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Apakah daging-dagingan sudah di thawing dengan suhu 5°C</td>
                                        <td>{{ $data->q_persiapan_10 }}</td>
                                        <td>{{ $data->q_keterangan_persiapan_10 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Section D: Pengolahan -->
                        <div class="section-heading bg-warning text-white mt-4">
                            (D) Pengolahan NILAI (ACT/STD*10)
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="60%">Pertanyaan</th>
                                        <th width="15%">Nilai</th>
                                        <th width="20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Apakah area pengolahan dalam keadaan bersih</td>
                                        <td>{{ $data->q_pengolahan_1 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Apakah peralatan yang digunakan dalam keadaan bersih</td>
                                        <td>{{ $data->q_pengolahan_2 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Apakah karyawan mengolah makanan dengan benar</td>
                                        <td>{{ $data->q_pengolahan_3 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Apakah suhu pemasakan mencapai 70°C</td>
                                        <td>{{ $data->q_pengolahan_4 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_4 }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Apakah ada pemisahan peletakan makanan yang sudah masak</td>
                                        <td>{{ $data->q_pengolahan_5 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_5 }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Apakah ada pemisahan peralatan / wadah untuk makanan yang sudah matang</td>
                                        <td>{{ $data->q_pengolahan_6 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_6 }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Apakah makanan disimpan dengan suhu yang benar</td>
                                        <td>{{ $data->q_pengolahan_7 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_7 }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Apakah makanan yang akan disajikan dalam keadaan tertutup</td>
                                        <td>{{ $data->q_pengolahan_8 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_8 }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Apakah dilakukan pengujian organoleptik dan dicatat di form</td>
                                        <td>{{ $data->q_pengolahan_9 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_9 }}</td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>Apakah kesehatan dan kebersihan pramusaji dalam keadaan baik</td>
                                        <td>{{ $data->q_pengolahan_10 }}</td>
                                        <td>{{ $data->q_keterangan_pengolahan_10 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Section E: Penggolongan Sampah -->
                        <div class="section-heading bg-warning text-white mt-4">
                            (E) Penggolongan Sampah NILAI (ACT/STD*10)
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="60%">Pertanyaan</th>
                                        <th width="15%">Nilai</th>
                                        <th width="20%">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Apakah ada tempat sampah yang terpisah antara sampah organic dan anorganik</td>
                                        <td>{{ $data->q_penggolongan_sampah_1 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Apakah sampah dalam keadaan ditutup</td>
                                        <td>{{ $data->q_penggolongan_sampah_2 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Apakah ada peletakan tempat sampah sementara di dapur</td>
                                        <td>{{ $data->q_penggolongan_sampah_3 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_3 }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Apakah ada peletakan tempat sampah induk di catering</td>
                                        <td>{{ $data->q_penggolongan_sampah_4 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_4 }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Apakah volume sampah sesuai dengan ukuran tempat sampah</td>
                                        <td>{{ $data->q_penggolongan_sampah_5 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_5 }}</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Apakah tempat sampah dibersihkan setelah dikosongkan</td>
                                        <td>{{ $data->q_penggolongan_sampah_6 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_6 }}</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Apakah ada jadwal pembuangan sampah yang rutin</td>
                                        <td>{{ $data->q_penggolongan_sampah_7 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_7 }}</td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Apakah area pembuangan sampah jauh dari area pengolahan</td>
                                        <td>{{ $data->q_penggolongan_sampah_8 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_8 }}</td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>Apakah area pembuangan sampah dalam keadaan bersih</td>
                                        <td>{{ $data->q_penggolongan_sampah_9 }}</td>
                                        <td>{{ $data->q_keterangan_penggolongan_sampah_9 }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Total Score Section -->
                        <div class="card mt-4">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0 text-white">Hasil Penilaian</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Total Score: <span class="text-primary">{{ $data->total_score }}</span></h4>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Kesimpulan: <span class="badge bg-{{ 
                                            $data->conclusion == 'Sangat Baik' ? 'success' : 
                                            ($data->conclusion == 'Baik' ? 'info' : 
                                            ($data->conclusion == 'Cukup' ? 'warning' : 'danger')) 
                                        }}">{{ $data->conclusion }}</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="approval-section">
                        <h5 class="font-weight-bold">Approval Status</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <p>
                                    <span class="approval-user">Diinspeksi Oleh 1:</span> 
                                    {{ $data->diinspeksi_oleh_1 ?? 'Belum ditentukan' }}
                                    @php
                                        // Helper function to parse JSON status safely
                                        function parseStatus($statusJson) {
                                            if (empty($statusJson)) return [null, null, null];
                                            
                                            try {
                                                $status = json_decode($statusJson, true);
                                                if (is_array($status)) {
                                                    return $status;
                                                }
                                            } catch (\Exception $e) {
                                                // Failed to parse JSON
                                            }
                                            
                                            return [null, null, null];
                                        }
                                        
                                        // Parse status once
                                        $statusArray = parseStatus($data->status);
                                        
                                        // Get individual approval statuses
                                        $diperiksa_status = $statusArray[0] ?? null;
                                        $diketahui_status = $statusArray[1] ?? null;
                                        $disetujui_status = $statusArray[2] ?? null;
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
                                                data-position="0">
                                            <i class="fas fa-check me-1"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                data-id="{{ $data->id }}"
                                                data-position="0">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </div>
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    <span class="approval-user">Diinspeksi Oleh 2:</span> 
                                    {{ $data->diinspeksi_oleh_2 ?? 'Belum ditentukan' }}
                                    
                                    @if($diketahui_status === 'approved')
                                        <span class="approval-badge approved">Approved</span>
                                    @elseif($diketahui_status === 'rejected')
                                        <span class="approval-badge rejected">Rejected</span>
                                    @else
                                        <span class="approval-badge pending">Pending</span>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <!-- Only show Diinspeksi 2 buttons if Diinspeksi 1 is approved -->
                                        @if($diperiksa_status === 'approved')
                                            <button type="button" class="btn btn-success btn-sm approve-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="1">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="1">
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
                                    <span class="approval-user">Diinspeksi Oleh 3:</span> 
                                    {{ $data->diinspeksi_oleh_3 ?? 'Belum ditentukan' }}
                                    
                                    @if($disetujui_status === 'approved')
                                        <span class="approval-badge approved">Approved</span>
                                    @elseif($disetujui_status === 'rejected')
                                        <span class="approval-badge rejected">Rejected</span>
                                    @else
                                        <span class="approval-badge pending">Pending</span>
                                    @endif
                                    
                                    <div class="mt-2">
                                        <!-- Only show Diinspeksi 3 buttons if both Diinspeksi 1 and 2 are approved -->
                                        @if($diperiksa_status === 'approved' && $diketahui_status === 'approved')
                                            <button type="button" class="btn btn-success btn-sm approve-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="2"">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm reject-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-position="2">
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
                            $hasRejection = isset($data->status) && in_array('rejected', json_decode($data->status, true));
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

                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            @php
                                $isFullyApproved = 
                                    isset($statusArray[0]) && $statusArray[0] === 'approved' && 
                                    isset($statusArray[1]) && $statusArray[1] === 'approved' && 
                                    isset($statusArray[2]) && $statusArray[2] === 'approved';
                            @endphp

                            @if($isFullyApproved)
                                <a href="{{ route('bss-form.she-048.pdf-inspeksi-catering', ['id' => $data->id]) }}" class="btn btn-primary ms-auto">
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
    
    Swal.fire({
        title: 'Approve Document',
        text: "Apakah Anda yakin ingin menyetujui dokumen ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, setuju!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Processing...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            axios.post("{{ route('bss-form.she-048.approve-inspeksi-catering') }}", {
                _token: "{{ csrf_token() }}",
                id: recordId,
                position: position
            })
            .then(function(response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Dokumen berhasil disetujui',
                    }).then(() => {
                        // Reload the page to reflect changes
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.data.message || 'Terjadi kesalahan',
                    });
                }
            })
            .catch(function(error) {
                console.error('Error data:', error);
                let errorMessage = 'Terjadi kesalahan dalam memproses permintaan';
                
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                });
            });
        }
    });
});
            
            $('.reject-btn').on('click', function() {
                const recordId = $(this).data('id');
                const position = $(this).data('position');
                
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
                        axios.post("{{ route('bss-form.she-048.reject-inspeksi-catering') }}", {
                            _token: "{{ csrf_token() }}",
                            id: recordId,
                            position: position
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Dokumen berhasil ditolak',
                                }).then(() => {
                                    // Reload the page to reflect changes
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.data.message || 'Terjadi kesalahan',
                                });
                            }
                        })
                        .catch(function(error) {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan dalam memproses permintaan',
                            });
                        });
                    }
                });
            });
            
            $('.reset-approval').on('click', function() {
    const recordId = $(this).data('id');
    
    Swal.fire({
        title: 'Reset Approval Status',
        text: "Apakah Anda yakin ingin mereset status persetujuan dokumen ini?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, reset!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Note: Use post method to match the route definition
            axios.post("{{ route('bss-form.she-048.reset-inspeksi-catering', ['id' => ':id']) }}".replace(':id', recordId), {
                _token: "{{ csrf_token() }}"
            })
            .then(function(response) {
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Status persetujuan berhasil direset',
                    }).then(() => {
                        // Reload the page to reflect changes
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.data.message || 'Terjadi kesalahan',
                    });
                }
            })
            .catch(function(error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan dalam memproses permintaan',
                });
            });
        }
    });
});
            
            $('.delete-btn').on('click', function() {
                const recordId = $(this).data('id');
                
                Swal.fire({
                    title: 'Delete Record',
                    text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("{{ route('bss-form.she-048.delete-inspeksi-catering') }}", {
                            _token: "{{ csrf_token() }}",
                            id: recordId
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil dihapus',
                                }).then(() => {
                                    // Redirect to dashboard
                                    window.location.href = "{{ route('bss-form.she-048.inspeksi-catering.dashboard') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.data.message || 'Terjadi kesalahan',
                                });
                            }
                        })
                        .catch(function(error) {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan dalam memproses permintaan',
                            });
                        });
                    }
                });
            });
        });
    </script>
@endsection