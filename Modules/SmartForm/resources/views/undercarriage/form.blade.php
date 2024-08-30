@extends('master.master_page')

@section('custom-css')
<style>
    .tab-content>.tab-pane.show {
        display: block;
    }

    .w-fit-content {
        width: fit-content;
    }

    input:read-only {
        opacity: .85;
        cursor: default !important;
        background-color: rgba(0, 0, 0, 0.02) !important;
    }

    input:read-only:focus {
        background-image: linear-gradient(0deg, #e91e63 2px, rgba(156, 39, 176, 0) 0), linear-gradient(0deg, #d2d2d2 1px, rgba(209, 209, 209, 0) 0) !important;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form class="card my-4" method="POST" id="formPlant">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Form Under Carriage Inspection</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    {{-- Form Master --}}
                    <div class="row align-items-center justify-content-center mb-4">
                        <div class="col-md-4 pe-3">
                            <img src="<?= url('img/form-undercarriage-inspection/master.png') ?>" class="w-100" alt="Under Carriage Inspection">
                        </div>
                        <div class="col-md-7">
                            @if(!empty($referenceNo))
                                <div class="input-group input-group-static mb-2 row align-items-center justify-content-between">
                                    <div class="col-md-3">
                                        <label for="reference_no">No Referensi</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="reference_no" name="reference_no" value="{{ $referenceNo }}" readonly>
                                    </div>
                                </div>
                            @endif

                            <div class="input-group input-group-static mb-2 row align-items-center justify-content-between">
                                <div class="col-md-3">
                                    <label for="document_no">No. Dokumen</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="document_no" name="document_no" value="BSS-FRM-PLA-084" readonly>
                                </div>
                            </div>

                            <div class="input-group input-group-static mb-2 row align-items-center justify-content-between">
                                <div class="col-md-3">
                                    <label for="issued">Issued</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="issued" name="issued" value="06/08/2024" readonly>
                                </div>
                            </div>

                            <div class="input-group input-group-static row align-items-center justify-content-between">
                                <div class="col-md-3">
                                    <label for="revisi">Revisi</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="revisi" name="revisi" value="A/01" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-static">
                                <label for="unit_mode">Unit Model</label>
                                <input type="text" class="form-control" id="unit_mode" name="unit_model"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->unit_model : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-static">
                                <label for="unit_sn">S/N Unit</label>
                                <input type="text" class="form-control" id="unit_sn" name="unit_sn"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->unit_sn : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-static">
                                <label for="unit_smr_hm">SMR / Hm</label>
                                <input type="text" class="form-control" id="unit_smr_hm" name="unit_smr_hm"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->unit_smr_hm : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-static">
                                <label for="work_operation">Work operation</label>
                                <input type="text" class="form-control" id="work_operation" name="work_operation"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->work_operation : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-static">
                                <label for="ground_condition">Ground condition</label>
                                <input type="text" class="form-control" id="ground_condition" name="ground_condition"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->ground_condition : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group input-group-static">
                                <label for="condition_area">Condition Area Frame</label>
                                <input type="text" class="form-control" id="condition_area" name="condition_area"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->condition_area_frame : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-static">
                                <label for="inspection_date">Inspection Date</label>
                                <input type="date" class="form-control" id="inspection_date" name="inspection_date"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->inspection_date : date('Y-m-d') }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="input-group input-group-static">
                                <label for="comment">Comment and Summary</label>
                                <input type="text" class="form-control" id="comment" name="comment"
                                    value="{{ isset($underCarriageMaster) ? $underCarriageMaster->comment : '' }}" {{ isset($underCarriageMaster) ? 'readonly' : 'required' }}>
                            </div>
                        </div>
                    </div>

                    {{-- Table Kehausan Component --}}
                    <div class="card border mt-5">
                        <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                            data-bs-toggle="collapse" data-bs-target="#collapse-keausan-component" aria-expanded="true" aria-controls="collapse-keausan-component">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize mb-0">Tabel Keausan Component</h6>
                                <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                            </div>
                        </a>
                        <div class="card-body collapse show" id="collapse-keausan-component">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="text-secondary text-center">
                                                Model
                                            </th>
                                            <th class="text-secondary text-center" colspan="<?= count($componentLabels) ?>">
                                                Tabel keausan Component
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary text-center text-xs">
                                                DH24
                                            </th>
                                            @foreach($componentLabels as $item)
                                                <th class="text-secondary text-center text-xs">
                                                    <?= $item ?>
                                                </th>
                                            @endforeach
                                        </tr>
                                        @foreach($componentThirsts as $percentage => $thirstValues)
                                            <tr>
                                                <th class="text-secondary text-center text-xs">
                                                    <?= $percentage ?>%
                                                </th>
                                                @foreach($thirstValues as $value)
                                                    <td class="text-center text-xs">
                                                        <?= str_replace('.', ',', $value) ?>
                                                    </th>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Form Inspection --}}
                    <div class="card border mt-5">
                        <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                            data-bs-toggle="collapse" data-bs-target="#collapse-form-inspection" aria-expanded="true" aria-controls="collapse-form-inspection">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize mb-0">Form Inspection</h6>
                                <i class="fa fa-circle-arrow-down text-white fa-lg"></i>
                            </div>
                        </a>
                        <div class="card-body collapse pb-1" id="collapse-form-inspection">
                            <div class="row col-md-10 mx-auto">
                                @foreach($componentInspections as $inspection)
                                    <div class="col-md-6 mb-3">
                                        <div class="row mb-3 align-items-end">
                                            <div class="col-md-12 text-center mb-2">
                                                <img class="h-100" src="<?= url('img/form-undercarriage-inspection/' . $inspection->component_image) ?>">
                                            </div>
                                            <div class="col-md-5 mb-1">
                                                <p class="mb-0 font-weight-bold">Component</p>
                                            </div>
                                            <div class="col-md-7 mb-1">
                                                <p class="mb-0"><?= $inspection->component_name ?></p>
                                            </div>

                                            <div class="col-md-5 mb-1">
                                                <p class="mb-0 font-weight-bold">Tools</p>
                                            </div>
                                            <div class="col-md-7 mb-1">
                                                <p class="mb-0"><?= $inspection->tools ?></p>
                                            </div>

                                            <div class="col-md-5 mb-1">
                                                <p class="mb-0 font-weight-bold">Standart Unit (mm)</p>
                                            </div>
                                            <div class="col-md-7 mb-1">
                                                <p class="mb-0"><?= $inspection->standart_value ?></p>
                                            </div>

                                            <div class="col-md-5 mb-1">
                                                <p class="mb-0 font-weight-bold">Limit Unit (mm)</p>
                                            </div>
                                            <div class="col-md-7 mb-1">
                                                <p class="mb-0"><?= $inspection->limit_value ?></p>
                                            </div>

                                            <div class="col-md-5">
                                                <p class="mb-0 font-weight-bold">Right Side</p>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group input-group-static">
                                                    <input type="text" name="inspection_right_side[{{ $inspection->id }}]" class="form-control input-number-only w-100"
                                                        value="{{ isset($inspection->right_side) ? ($inspection->right_side ?? '-') : '' }}" {{ isset($inspection->right_side) ? 'readonly' : 'required' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <p class="mb-0 font-weight-bold">Left Side</p>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group input-group-static">
                                                    <input type="text" name="inspection_left_side[{{ $inspection->id }}]" class="form-control input-number-only w-100"
                                                        value="{{ isset($inspection->left_side) ? ($inspection->left_side ?? '-') : '' }}" {{ isset($inspection->left_side) ? 'readonly' : 'required' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($subComponentInspections->count() > 0)
                                @foreach($subComponentInspections as $component)
                                    <div class="row col-md-10 mx-auto">
                                        <div class="col-md-6 mb-3">
                                            <div class="row mb-3 align-items-end">
                                                <div class="col-md-12 text-center mb-2">
                                                    <img class="h-100" src="<?= url('img/form-undercarriage-inspection/' . $component->component_image) ?>">
                                                </div>
                                                <div class="col-md-5 mb-1">
                                                    <p class="mb-0 font-weight-bold">Component</p>
                                                </div>
                                                <div class="col-md-7 mb-1">
                                                    <p class="mb-0">: <?= $component->component_name ?></p>
                                                </div>

                                                <div class="col-md-5 mb-1">
                                                    <p class="mb-0 font-weight-bold">Tools</p>
                                                </div>
                                                <div class="col-md-7 mb-1">
                                                    <p class="mb-0">: <?= $component->tools ?></p>
                                                </div>

                                                <div class="col-md-5 mb-1">
                                                    <p class="mb-0 font-weight-bold">Standart Unit (mm)</p>
                                                </div>
                                                <div class="col-md-7 mb-1">
                                                    <p class="mb-0">: <?= $component->standart_value ?></p>
                                                </div>

                                                <div class="col-md-5 mb-1">
                                                    <p class="mb-0 font-weight-bold">Limit Unit (mm)</p>
                                                </div>
                                                <div class="col-md-7 mb-1">
                                                    <p class="mb-0">: <?= $component->limit_value ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row col-md-10 mx-auto">
                                        @foreach($component->sub_components as $subComponent)
                                            <div class="col-md-6 mb-3">
                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-md-5 mb-1">
                                                        <p class="mb-0 font-weight-bold">{{ $subComponent->sub_name }}</p>
                                                    </div>
                                                    <div class="col-md-7 mb-1">
                                                        <p class="mb-0">: {{ $subComponent->sub_component_name }}</p>
                                                    </div>

                                                    <div class="col-md-5 mb-1">
                                                        <p class="mb-0 font-weight-bold">Right Side</p>
                                                    </div>
                                                    <div class="col-md-7 mb-1">
                                                        <div class="input-group input-group-static">
                                                            <input type="text" name="inspection_right_side[{{ $component->id }}][{{ $subComponent->id }}]" class="form-control input-number-only w-100"
                                                                value="{{ isset($subComponent->right_side) ? ($subComponent->right_side ?? '-') : '' }}" {{ isset($subComponent->right_side) ? 'readonly' : 'required' }}>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <p class="mb-0 font-weight-bold">Left Side</p>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="input-group input-group-static">
                                                            <input type="text" name="inspection_left_side[{{ $component->id }}][{{ $subComponent->id }}]" class="form-control input-number-only w-100"
                                                                value="{{ isset($subComponent->left_side) ? ($subComponent->left_side ?? '-') : '' }}" {{ isset($subComponent->left_side) ? 'readonly' : 'required' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Form Temuan --}}
                    <div class="card border mt-5">
                        <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                            data-bs-toggle="collapse" data-bs-target="#collapse-form-temuan" aria-expanded="true" aria-controls="collapse-form-temuan">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize mb-0">Form Temuan Component</h6>
                                <i class="fa fa-circle-arrow-down text-white fa-lg"></i>
                            </div>
                        </a>
                        <div class="card-body collapse pb-1" id="collapse-form-temuan">
                            <div class="row col-md-10 mx-auto">
                                @foreach($components as $component)
                                    <div class="col-md-6 mb-3">
                                        <div class="row mb-3 align-items-end">
                                            <div class="col-md-5">
                                                <p class="mb-0 font-weight-bold">Component</p>
                                            </div>
                                            <div class="col-md-7">
                                                <p class="mb-0">{{ $component->component_name }}</p>
                                            </div>

                                            <div class="col-md-5">
                                                <p class="mb-0 font-weight-bold">Right Side</p>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group input-group-static">
                                                    <input type="text" name="issue_right_side[{{ $component->id }}]" class="form-control w-100"
                                                        value="{{ isset($component->right_side) ? $component->right_side : '' }}" {{ isset($component->right_side) ? 'readonly' : 'required' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <p class="mb-0 font-weight-bold">Left Side</p>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group input-group-static">
                                                    <input type="text" name="issue_left_side[{{ $component->id }}]" class="form-control w-100"
                                                        value="{{ isset($component->left_side) ? $component->left_side : '' }}" {{ isset($component->left_side) ? 'readonly' : 'required' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @if(!isset($underCarriageMaster))
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitUnderCarriage">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
                        </div>
                    </div>
                @endif

                @if(isset($underCarriageMaster) && isset($approvalPIC) && $approvalPIC->count() > 0)
                    <div class="card mt-6">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Approval Pihak Terkait</h6>
                            </div>
                        </div>
                        <div class="card-body my-1">
                            <div class="d-flex mb-4 align-items-center">
                                <h5 class="mb-0 me-3">
                                    Status Approval Form :

                                    @if($statusOverallApproval == 'Approved')
                                        <span class="text-success fw-bolder">{{ $statusOverallApproval }}</span>
                                    @elseif($statusOverallApproval == 'Ditolak')
                                        <span class="text-danger fw-bolder">{{ $statusOverallApproval }}</span>
                                    @elseif($statusOverallApproval)
                                        <span class="text-warning fw-bolder">{{ $statusOverallApproval }}</span>
                                    @endif
                                </h5>

                                @if($statusOverallApproval == 'Ditolak')
                                    <a class="btn btn-icon btn-2 bg-gradient-success mb-0 btn-sm" href="{{ route('bss-form.undercarriage.form') }}?reference_no={{ $underCarriageMaster->id }}"
                                        data-bs-toggle="tooltip" title="Buat form baru dengan referensi form ini">
                                        <span class="btn-inner--icon"><i class="fas fa-reply"></i></span>
                                    </a>
                                @endif
                            </div>

                            <div class="row">
                                @foreach($approvalPIC as $pic)
                                    <div class="col-md-6 col-lg-3 text-center">
                                        <p class="fw-bold mb-0">Dept. {{ $pic->nama_departement }}</p>
                                        <p class="mb-2">{{ $pic->nama_karyawan }}</p>

                                        @if($pic->status == 'Approved')
                                            <img src="{{ url('img/paraf.jpg') }}" height="35px" alt="Paraf">

                                        @elseif($pic->status == 'Rejected')
                                            <p class="mb-0 text-danger fw-bold d-flex align-items-center justify-content-center">
                                                Ditolak
                                                <a href="javascript:detailRejectModal('{{ $pic->reason }}');" class="badge bg-primary badge-circle text-white ms-2"
                                                    data-bs-toggle="tooltip" title="Lihat Catatan Review">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                            </p>

                                        @else
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button type="button" class="btn btn-danger btn-xs text-center px-3 py-2 me-2"
                                                    data-bs-toggle="tooltip" title="Reject Pengisian Form" onclick="rejectForm('{{ $underCarriageMaster->id }}', '{{ $pic->id }}')">
                                                    <i class="fas fa-times"></i>
                                                </button>

                                                <button type="button" class="btn btn-success btn-xs text-center px-3 py-2"
                                                    data-bs-toggle="tooltip" title="Approve Pengisian Form" onclick="approveForm('{{ $underCarriageMaster->id }}', '{{ $pic->id }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        @endif

                                        <small class="mt-2 d-block"><i>({{ $pic->nama_jabatan }})</i></small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-reject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRejectLabel">Reject Pengisian Form</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="modal-body" id="formReject">
                    <input type="hidden" name="master_id">
                    <input type="hidden" name="form_pic_id">

                    <div class="input-group input-group-static mb-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="Rejected" selected>Rejected</option>
                        </select>
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="reason">Alasan</label>
                        <input type="text" class="form-control" id="reason" name="reason" />
                    </div>

                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitReject">
                            <i class="fas fa-save"></i>
                            Submit Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-reason-reject" tabindex="-1" role="dialog" aria-labelledby="modalReasonReject" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalReasonReject">Catatan Review Approval</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="input-group input-group-static mb-3">
                        <label for="status">Status</label>
                        <input type="text" class="form-control" id="status-reject" value="Rejected" readonly />
                    </div>

                    <div class="input-group input-group-static mb-4">
                        <label for="reason">Alasan</label>
                        <textarea rows="4" class="form-control" id="reason-reject" readonly></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $('[data-bs-toggle=collapse]').click( function() {
            const $el = $(this);
            const isExpanded = $el.attr('aria-expanded');

            if(isExpanded == 'true') {
                $el.find('i').removeClass('fa-circle-arrow-down').addClass('fa-circle-arrow-up');
            } else {
                $el.find('i').removeClass('fa-circle-arrow-up').addClass('fa-circle-arrow-down');
            }
        });

        $('.input-number-only:required').keyup( function() {
            $(this).val( this.value.replace(/[^0-9\-\.]+/g, '') );
        });

        function approveForm(masterId, formPICId) {
            const formData = `master_id=${masterId}&form_pic_id=${formPICId}&status=Approved`;
            axios.post(`{{ route('bss-approval-form') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Berhasil approve pengisian form berikut!',

                }).then((result) => {
                    window.location.reload();
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal melakukan approve pengisian form berikut'
                });
            });
        }

        function rejectForm(masterId, formPICId) {
            $('#formReject').trigger('reset');
            $('#formReject [name=master_id]').val(masterId);
            $('#formReject [name=form_pic_id]').val(formPICId);
            $('#modal-reject').modal('show');
        }

        function detailRejectModal(reasonReject) {
            $('#reason-reject').val(reasonReject);
            $('#modal-reason-reject').modal('show');
        }

        $('#btnSubmitReject').click( function(e) {
            e.preventDefault();

            const formData = $('#formReject').serialize();
            axios.post(`{{ route('bss-approval-form') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Berhasil reject pengisian form berikut!',

                }).then((result) => {
                    window.location.reload();
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal melakukan reject pengisian form berikut'
                });
            });
        });

        $('#btnSubmitUnderCarriage').click( function(e) {
            e.preventDefault();
            const formData = $('#formPlant').serialize();

            axios.post(`{{ route('bss-form.undercarriage.store') }}`, formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Under Carriage Inspection Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('bss-form.undercarriage.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Under Carriage Inspection'
                });
            });
        });
    </script>
@endsection
