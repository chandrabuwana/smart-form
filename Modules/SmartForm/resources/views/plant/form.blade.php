@extends('master.master_page')

@section('custom-css')
<style>
    .tab-content>.tab-pane.show {
        display: block;
    }

    .w-fit-content {
        width: fit-content;
    }

    input:not([type="checkbox"]):read-only, textarea:read-only {
        opacity: .85;
        cursor: default !important;
        background-color: rgba(0, 0, 0, 0.02) !important;
    }

    input:read-only:focus, , textarea:read-only:focus {
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
                        <h6 class="text-white text-capitalize ps-3">Form Transmission Test</h6>
                    </div>
                </div>
                <div class="card-body my-1">
                    @if(!empty($referenceNo))
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <div class="input-group input-group-static">
                                    <label for="reference_no">No Referensi</label>
                                    <input type="text" class="form-control" id="reference_no" name="reference_no"
                                        value="{{ $referenceNo }}" readonly>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form Master --}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group input-group-static">
                                <label for="machine_number">Machine Number</label>
                                <input type="text" class="form-control" id="machine_number" name="machine_number"
                                    value="<?= isset($plantMaster) ? $plantMaster->machine_number : '' ?>" <?= isset($plantMaster) ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-static">
                                <label for="machine_model">Machine Model</label>
                                <input type="text" class="form-control" id="machine_model" name="machine_model"
                                    value="<?= isset($plantMaster) ? $plantMaster->machine_model : '' ?>" <?= isset($plantMaster) ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-static">
                                <label for="machine_serial_no">Machine Serial No</label>
                                <input type="text" class="form-control" id="machine_serial_no" name="machine_serial_no"
                                    value="<?= isset($plantMaster) ? $plantMaster->machine_serial_no : '' ?>" <?= isset($plantMaster) ? 'disabled' : '' ?>>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-5">
                            <div class="input-group input-group-static">
                                <label for="machine_smr">Machine SMR / HM</label>
                                <input type="text" class="form-control" id="machine_smr" name="machine_smr"
                                    value="<?= isset($plantMaster) ? $plantMaster->machine_smr : '' ?>" <?= isset($plantMaster) ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-static">
                                <label for="jobsite">JobSite</label>
                                <input type="text" class="form-control" id="jobsite" name="jobsite"
                                    value="<?= isset($plantMaster) ? $plantMaster->jobsite : '' ?>" <?= isset($plantMaster) ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-static">
                                <label for="checkdate">Check Date</label>
                                <input type="date" class="form-control" id="checkdate" name="checkdate"
                                    value="<?= isset($plantMaster) ? $plantMaster->checkdate : '' ?>" <?= isset($plantMaster) ? 'disabled' : '' ?>>
                            </div>
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="col-md-10 mt-4">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#testing-procedure" role="tab" aria-controls="testing-procedure" aria-selected="true">
                                        Testing Procedure
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#adjusting-procedure" role="tab" aria-controls="adjusting-procedure" aria-selected="false">
                                        Adjusting Procedure
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#plug-tap" role="tab" aria-controls="dashboard-tabs-simple" aria-selected="false">
                                        Plug tap point Locations
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content mt-3">
                            <div id="testing-procedure" class="tab-pane fade show" role="tabpanel">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <img src="<?= url('img/form-plant-transmission/testing-procedure.png') ?>" class="w-100" alt="Testing Procedure">
                                    </div>
                                    <div class="col-md-7">
                                        <ol>
                                            <li>Pasang pressure gauge pada bagian nomor 1</li>
                                            <li>Hidupkan mesin. Biarkan mesin tetap hidup dan tunggu sampai oli transmisi mencapai suhu 47°C</li>
                                            <li>Operasikan mesin di low idle. Amati hasil "relief pressure for the transmission hydraulic control" pada pressure gauge.</li>
                                            <li>Operasikan mesin di high idle. Amati hasil relief pressure for the transmission hydraulic control pada pressure gauge.</li>
                                            <li>jika hasil pressure sudah sesuai dengan standardnya maka lanjutkan ke langkah - 6. Jika pressure belum sesuai dengan standardnya maka lakukan adjusting sesuai dengan adjusting procedure</li>
                                            <li>Matikan mesin dan remove pressure gauge pada bagian nomor 1</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div id="adjusting-procedure" class="tab-pane fade" role="tabpanel">
                                <div class="row align-items-center">
                                    <div class="col-md-5">
                                        <img src="<?= url('img/form-plant-transmission/adjusting-procedure.png') ?>" class="w-100" alt="Adjusting Procedure">
                                    </div>
                                    <div class="col-md-7">
                                        <p class="font-weight-bold"></p>
                                        <ol>
                                            <li>Remove cap (3) dari ujung transmission hydraulic control relief valve</li>
                                            <li>
                                                Putar Adjustment screw (4) ke arah yang sesuai <br>
                                                Putar adjustment screw searah jarum jam untuk meningkatkan pressure <br>
                                                Putar adjustment screw berlawan arah jarum jam untuk menurunkan pressure
                                            </li>
                                            <li>Cek kembali pressure pada relief pressure for the transmission hydraulic control (No. 1 pada gambar di atas)</li>
                                            <li>Kencangkan locknut (5) dan pasang kembali cap (3)</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div id="plug-tap" class="tab-pane fade" role="tabpanel">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <img src="<?= url('img/form-plant-transmission/plug-tab-1.png') ?>" class="w-100" alt="Plug Tab Point">
                                    </div>
                                    <div class="col-md-6">
                                        <img src="<?= url('img/form-plant-transmission/plug-tab-2.png') ?>" class="w-100" alt="Plug Tab Point">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Harness Test --}}
                    <div class="card border mt-5">
                        <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                            data-bs-toggle="collapse" data-bs-target="#collapse-harness-test" aria-expanded="true" aria-controls="collapse-harness-test">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize mb-0">Harness Test</h6>
                                <i class="fa fa-circle-arrow-up text-white fa-lg"></i>
                            </div>
                        </a>
                        <div class="card-body collapse show" id="collapse-harness-test">
                            <div class="bg-light p-2 rounded w-fit-content">
                                <table class="w-100 font-weight-bold">
                                    <tbody>
                                        <tr>
                                            <td class="text-start">Tool Required</td>
                                            <td> : </td>
                                            <td>Multi Tester / AVO Meter</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="solenoid-position">Solenoid Position</label>
                                        <input type="text" class="form-control" id="solenoid-position" name="solenoid_position[]" value="Solenoid 1" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="std">STD</label>
                                        <input type="text" class="form-control" id="std" value="< 5 Ohm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="actual">Actual</label>
                                        <input type="text" class="form-control input-number-only" id="actual" name="solenoid_actual[]"
                                            value="<?= isset($detailHarness) ? ($detailHarness[0]->actual ?? '-') : '' ?>" <?= isset($detailHarness) ? 'disabled' : 'required' ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="solenoid-position">Solenoid Position</label>
                                        <input type="text" class="form-control" id="solenoid-position" name="solenoid_position[]" value="Solenoid 2" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="std">STD</label>
                                        <input type="text" class="form-control" id="std" value="< 5 Ohm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="actual">Actual</label>
                                        <input type="text" class="form-control input-number-only" id="actual" name="solenoid_actual[]"
                                            value="<?= isset($detailHarness) ? ($detailHarness[1]->actual ?? '-') : '' ?>" <?= isset($detailHarness) ? 'disabled' : 'required' ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="solenoid-position">Solenoid Position</label>
                                        <input type="text" class="form-control" id="solenoid-position" name="solenoid_position[]" value="Solenoid 3" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="std">STD</label>
                                        <input type="text" class="form-control" id="std" value="< 5 Ohm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="actual">Actual</label>
                                        <input type="text" class="form-control input-number-only" id="actual" name="solenoid_actual[]"
                                            value="<?= isset($detailHarness) ? ($detailHarness[2]->actual ?? '-') : '' ?>" <?= isset($detailHarness) ? 'disabled' : 'required' ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="solenoid-position">Solenoid Position</label>
                                        <input type="text" class="form-control" id="solenoid-position" name="solenoid_position[]" value="Solenoid 4" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="std">STD</label>
                                        <input type="text" class="form-control" id="std" value="< 5 Ohm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="actual">Actual</label>
                                        <input type="text" class="form-control input-number-only" id="actual" name="solenoid_actual[]"
                                            value="<?= isset($detailHarness) ? ($detailHarness[3]->actual ?? '-') : '' ?>" <?= isset($detailHarness) ? 'disabled' : 'required' ?>>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="solenoid-position">Solenoid Position</label>
                                        <input type="text" class="form-control" id="solenoid-position" name="solenoid_position[]" value="Solenoid 5" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="std">STD</label>
                                        <input type="text" class="form-control" id="std" value="< 5 Ohm" disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static">
                                        <label for="actual">Actual</label>
                                        <input type="text" class="form-control input-number-only" id="actual" name="solenoid_actual[]"
                                            value="<?= isset($detailHarness) ? ($detailHarness[4]->actual ?? '-') : '' ?>" <?= isset($detailHarness) ? 'disabled' : 'required' ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Speed Sensor Test --}}
                    <div class="card border mt-5">
                        <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                            data-bs-toggle="collapse" data-bs-target="#collapse-speed-sensor-test" aria-expanded="false" aria-controls="collapse-speed-sensor-test">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize mb-0">Speed Sensor Test</h6>
                                <i class="fa fa-circle-arrow-down text-white fa-lg"></i>
                            </div>
                        </a>
                        <div class="card-body collapse" id="collapse-speed-sensor-test">
                            <div class="bg-light p-2 rounded w-fit-content">
                                <table class="w-100 font-weight-bold">
                                    <tbody>
                                        <tr>
                                            <td class="text-start">Tool Required</td>
                                            <td> : </td>
                                            <td>Multi Tester / AVO Meter</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Note</td>
                                            <td> : </td>
                                            <td>Propeller Shaft depan harus dilepas - Low Idle (600 ± 20 Rpm); High Idle (2100± 20 Rpm)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3 align-items-center">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="speed_sensor">Speed Sensor</label>
                                        <input type="text" class="form-control" id="speed_sensor" name="speed_sensor[]" value="Output Speed 1" readonly>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="115 Hz" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label for="speed_sensor_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control" id="speed_sensor_low_iddle_actual" name="speed_sensor_low_iddle_actual[]"
                                                    value="<?= isset($detailSpeedSensor) ? ($detailSpeedSensor[0]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailSpeedSensor) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="375 Hz" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label for="speed_sensor_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control" id="speed_sensor_high_iddle_actual" name="speed_sensor_high_iddle_actual[]"
                                                    value="<?= isset($detailSpeedSensor) ? ($detailSpeedSensor[0]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailSpeedSensor) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="speed_sensor">Speed Sensor</label>
                                        <input type="text" class="form-control" id="speed_sensor" name="speed_sensor[]" value="Output Speed 2" readonly>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="115 Hz" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label for="speed_sensor_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control" id="speed_sensor_low_iddle_actual" name="speed_sensor_low_iddle_actual[]"
                                                    value="<?= isset($detailSpeedSensor) ? ($detailSpeedSensor[1]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailSpeedSensor) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="375 Hz" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label for="speed_sensor_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control" id="speed_sensor_high_iddle_actual" name="speed_sensor_high_iddle_actual[]"
                                                    value="<?= isset($detailSpeedSensor) ? ($detailSpeedSensor[1]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailSpeedSensor) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center">
                                <div class="col-md-5">
                                    <div class="input-group input-group-static">
                                        <label for="speed_sensor">Speed Sensor</label>
                                        <input type="text" class="form-control" id="speed_sensor" name="speed_sensor[]" value="Tourqe converter output speed" readonly>
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="464 Hz" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label for="speed_sensor_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control" id="speed_sensor_low_iddle_actual" name="speed_sensor_low_iddle_actual[]"
                                                    value="<?= isset($detailSpeedSensor) ? ($detailSpeedSensor[2]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailSpeedSensor) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="1608 Hz" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-static">
                                                <label for="speed_sensor_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control" id="speed_sensor_high_iddle_actual" name="speed_sensor_high_iddle_actual[]"
                                                    value="<?= isset($detailSpeedSensor) ? ($detailSpeedSensor[2]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailSpeedSensor) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Power Train Pressures --}}
                    <div class="card border mt-5">
                        <a href="#" class="card-header p-0 position-relative mt-n4 mx-3 z-index-2"
                            data-bs-toggle="collapse" data-bs-target="#collapse-power-train" aria-expanded="false" aria-controls="collapse-power-train">
                            <div class="bg-gradient-warning shadow-warning border-radius-lg py-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">Power Train Pressures</h6>
                                <i class="fa fa-circle-arrow-down text-white fa-lg"></i>
                            </div>
                        </a>
                        <div class="card-body collapse" id="collapse-power-train">
                            <div class="bg-light p-2 rounded w-fit-content">
                                <table class="w-100 font-weight-bold">
                                    <tbody>
                                        <tr>
                                            <td class="text-start">Tool Required</td>
                                            <td> : </td>
                                            <td>Tetra gauge</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Note</td>
                                            <td> : </td>
                                            <td>Propeller Shaft depan harus dilepas - Low Idle (600 ± 20 Rpm); High Idle (2100± 20 Rpm)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Retarder Outlet Pressure" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="4,5 ± 2 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[0]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[0]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="30 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[0]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[0]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Lube Pressure" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="min 4 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[1]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[1]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="min 30 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[1]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[1]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Transmission outlet pressure" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="30 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[2]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[2]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="35 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[2]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[2]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Relief pressure for the Tourqe Converter outlet" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="30 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[3]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[3]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="35 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[3]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[3]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Retarder actuation pressure" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[4]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[4]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="100 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[4]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[4]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Pressure for the tourqe converter lockup up clutch" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[5]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[5]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="310 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[5]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[5]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Clutch #1 (C1) pressure coupler" readonly>

                                        <input type="hidden" name="power_train_description[]" value="Clutch #1 (C1) pressure coupler">
                                        <input type="hidden" name="power_train_description[]" value="Clutch #1 (C1) pressure coupler">
                                        <input type="hidden" name="power_train_description[]" value="Clutch #1 (C1) pressure coupler">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="1" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[6]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[6]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[6]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[6]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="2" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[7]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[7]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[7]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[7]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="3" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[8]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[8]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[8]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[8]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="4" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[9]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[9]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[9]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[9]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Clutch #2 (C2) pressure coupler" readonly>
                                        <input type="hidden" name="power_train_description[]" value="Clutch #2 (C2) pressure coupler">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="4" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[10]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[10]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="300 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[10]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[10]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="5" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[11]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[11]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="300 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[11]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[11]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Clutch #3 (C3) pressure coupler" readonly>

                                        <input type="hidden" name="power_train_description[]" value="Clutch #3 (C3) pressure coupler">
                                        <input type="hidden" name="power_train_description[]" value="Clutch #3 (C3) pressure coupler">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="3" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[12]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[12]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[12]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[12]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="5" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[13]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[13]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[13]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[13]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Reverse" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[14]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[14]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[14]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[14]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Clutch #4 (C4) pressure coupler" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="2" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[15]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[15]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[15]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[15]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Clutch #5 (C5) pressure coupler" readonly>

                                        <input type="hidden" name="power_train_description[]" value="Clutch #5 (C5) pressure coupler">
                                        <input type="hidden" name="power_train_description[]" value="Clutch #5 (C5) pressure coupler">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[16]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[16]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[16]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[16]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="1" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[17]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[17]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[17]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[17]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="lever_position">Lever Position</label>
                                                <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Reverse" readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="275 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[18]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[18]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="engine_speed">Engine Speed</label>
                                                        <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="std">STD</label>
                                                        <input type="text" class="form-control" id="std" value="320 ± 10 psi" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_actual">Actual</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[18]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group input-group-static">
                                                        <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                        <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                            value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[18]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Pressure for the pump transmission pump outlet" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="310 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[19]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[19]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="350 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[19]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[19]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Relief Pressure for the Transmission Hydraulic Control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="280 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[20]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[20]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="350 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[20]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[20]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center border-bottom border-secondary pb-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Relief Pressure for the Torque Converter Inlet" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="150 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[21]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[21]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="150 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[21]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[21]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static">
                                        <label for="power_train_description">Description</label>
                                        <input type="text" class="form-control" id="power_train_description" name="power_train_description[]" value="Normal Operating Pressure for the Torque Converter Inlet" readonly>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="input-group input-group-static">
                                        <label for="lever_position">Lever Position</label>
                                        <input type="text" class="form-control" id="lever_position" name="lever_position[]" value="Neutral" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="Low Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="30 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_actual" name="power_train_low_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[22]->actual_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_low_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_low_iddle_after_adjustment" name="power_train_low_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[22]->after_adjust_low_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="engine_speed">Engine Speed</label>
                                                <input type="text" class="form-control" id="engine_speed" value="High Idle" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="std">STD</label>
                                                <input type="text" class="form-control" id="std" value="90 ± 10 psi" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_actual">Actual</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_actual" name="power_train_high_iddle_actual[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[22]->actual_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : 'required' ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group input-group-static">
                                                <label for="power_train_high_iddle_after_adjustment">After Adjustment</label>
                                                <input type="text" class="form-control input-number-only" id="power_train_high_iddle_after_adjustment" name="power_train_high_iddle_after_adjustment[]"
                                                    value="<?= isset($detailPowerTrain) ? ($detailPowerTrain[22]->after_adjust_high_iddle ?? '-') : '' ?>" <?= isset($detailPowerTrain) ? 'disabled' : '' ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!isset($plantMaster))
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary ms-auto uploadBtn" id="btnSubmitPlant">
                                <i class="fas fa-save"></i>
                                Submit Form
                            </button>
                        </div>
                    </div>
                @endif
            </form>

            @if(isset($plantMaster) && isset($approvalPIC) && $approvalPIC->count() > 0)
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
                                <a class="btn btn-icon btn-2 bg-gradient-success mb-0 btn-sm" href="{{ route('bss-form.plant-transmission.form') }}?reference_no={{ $plantMaster->ID }}"
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
                                                data-bs-toggle="tooltip" title="Reject Pengisian Form" onclick="rejectForm('{{ $plantMaster->ID }}', '{{ $pic->id }}')">
                                                <i class="fas fa-times"></i>
                                            </button>

                                            <button type="button" class="btn btn-success btn-xs text-center px-3 py-2"
                                                data-bs-toggle="tooltip" title="Approve Pengisian Form" onclick="approveForm('{{ $plantMaster->ID }}', '{{ $pic->id }}')">
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

        $('#btnSubmitPlant').click( function(e) {
            const fields = [
                { id: "#machine_number", name: "Machine Number" },
                { id: "#machine_model", name: "Machine Model" },
                { id: "#machine_serial_no", name: "Machine Serial No" },
                { id: "#machine_smr", name: "Machine SMR / HM" },
                { id: "#jobsite", name: "JobSite" },
                { id: "#checkdate", name: "Check Date" }
            ];

            for (const field of fields) {
                const value = $(field.id).val();
                if (!value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Field',
                        text: `Please enter ${field.name}.`,
                        confirmButtonText: 'OK'
                    });
                    return false; // Stop the function if a field is missing
                }
            }

            if( !$('#formPlant')[0].checkValidity() ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Terdapat isian form yang kosong'
                });
                return;
            }

            e.preventDefault();
            const formData = $('#formPlant').serialize();

            axios.post('/bss-form/plant-transmission/form/store', formData, {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
            .then(function (response) {
                console.log(response.data)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Form Transmission Test Berhasil di Simpan!',

                }).then((result) => {
                    window.location.href = `{{ route('bss-form.plant-transmission.dashboard') }}`;
                });
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Gagal menyimpan Form Transmission Test'
                });
            });
        });
    </script>
@endsection
