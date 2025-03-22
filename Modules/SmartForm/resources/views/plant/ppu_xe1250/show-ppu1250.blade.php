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

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3"> Form PPU XE 1250</h6>
                        </div>
                    </div>

                    <form id="formXE1250" method="POST">
                        @csrf
                        <div class="mx-3">
                            <input type="hidden" name="doc_number" value="{{ $data->doc_number }}">
                            <div class="row mb-3">
                                <div class="col-md-6 mt-1">
                                    <img src="{{ asset('img/form-ppu-xe1250/ppu-125-1.png') }}"
                                        style="width: 100%; height: auto;" alt="ppu-1250">
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-static mb-3 mt-1">
                                        <label for="summary" class="ms-0">Content And Summary</label>
                                        <textarea name="summary" id="summary" class="form-control" rows="8">{{ $data->content_summary }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_model" class="ms-0">Engine Model</label>
                                        <input type="text" class="form-control" id="unit_model" name="unit_model"
                                            value="{{ $data->unit_model }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="ins_date" class="ms-0">Inspection Date</label>
                                        <input type="Date" class="form-control" id="ins_date" name="ins_date"
                                            value="{{ $data->inspection_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="unit_sn" class="ms-0">S/N Unit</label>
                                        <input type="text" class="form-control" id="unit_sn" name="unit_sn"
                                            value="{{ $data->sn_unit }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="smr" class="ms-0">SMR HM</label>
                                        <input type="text" class="form-control" id="smr"
                                            value="{{ $data->smr_hm }}" name="smr" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="work_op" class="ms-0">Work Operation</label>
                                        <input type="text" class="form-control" id="work_op" name="work_op"
                                            value="{{ $data->work_operation }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="ground_condition" class="ms-0">Ground Condition</label>
                                        <input type="text" class="form-control" id="ground_condition"
                                            name="ground_condition" value="{{ $data->ground_condition }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="condition_area" class="ms-0">Condition Area Frame</label>
                                        <input type="text" class="form-control" id="condition_area"
                                            value="{{ $data->condition_area }}" name="condition_area" required>
                                    </div>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Picture</th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-2.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-3.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-4.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                    </tr>
                                    <tr>
                                        <th>Component</th>
                                        <th colspan="2">Link Pitch</th>
                                        <th colspan="2">Link Height</th>
                                        <th colspan="2">Bushing O.D</th>
                                    </tr>
                                    <tr>
                                        <th>Tools</th>
                                        <th colspan="2">Meteran, Penggaris Besi</th>
                                        <th colspan="2">Depth Gauge</th>
                                        <th colspan="2">Outside Caliper</th>
                                    </tr>
                                    <tr>
                                        <th>STD-LIMIT</th>
                                        @for ($i = 0; $i < 3; $i++)
                                            <th>Standart</th>
                                            <th>Limit</th>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th>Units (mm)</th>
                                        <th>281.0</th>
                                        <th>284.0</th>
                                        <th>181.0</th>
                                        <th>168.0</th>
                                        <th>99.0</th>
                                        <th>94.0</th>
                                    </tr>
                                    <tr>
                                        <th>Right Side</th>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="link_pitch[]" value="{{ $data->link_pitch[0] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="link_Height[]" value="{{ $data->link_height[0] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="link_bushing[]" value="{{ $data->link_bushing[0] }}"></td>
                                    </tr>
                                    <tr>
                                        <th>Left Side</th>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="link_pitch[]" value="{{ $data->link_pitch[1] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="link_Height[]" value="{{ $data->link_height[1] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="link_bushing[]" value="{{ $data->link_bushing[1] }}"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Picture</th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-5.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-6.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-7.png') }}"
                                                style="width: 200px; height: auto;"z alt=""></th>
                                    </tr>
                                    <tr>
                                        <th>Component</th>
                                        <th colspan="2">Grouser Height</th>
                                        <th colspan="2">Idler</th>
                                        <th colspan="2">Sprocket</th>
                                    </tr>
                                    <tr>
                                        <th>Tools</th>
                                        <th colspan="2">Depth Gauge</th>
                                        <th colspan="2">Outside Caliper</th>
                                        <th colspan="2">Outside Caliper</th>
                                    </tr>
                                    <tr>
                                        <th>STD-LIMIT</th>
                                        @for ($i = 0; $i < 3; $i++)
                                            <th>Standart</th>
                                            <th>Limit</th>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th>Units (mm)</th>
                                        <th>50.0</th>
                                        <th>25.0</th>
                                        <th>23.0</th>
                                        <th>29.0</th>
                                        <th>423.0</th>
                                        <th>411.0</th>
                                    </tr>
                                    <tr>
                                        <th>Right Side</th>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="grouser_height[]" value="{{ $data->grouser_height[0] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="idler[]" value="{{ $data->idler[0] }}">
                                        </td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="sprocket[]" value="{{ $data->sprocket[0] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Left Side</th>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="grouser_height[]" value="{{ $data->grouser_height[1] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="idler[]" value="{{ $data->idler[1] }}">
                                        </td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="sprocket[]" value="{{ $data->sprocket[1] }}">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Picture</th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-8.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-9.png') }}"
                                                style="width: 200px; height: auto;" alt=""></th>
                                        <th colspan="2"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-10.png') }}"
                                                style="width: 200px; height: auto;"z alt=""></th>
                                    </tr>
                                    <tr>
                                        <th>Component</th>
                                        <th colspan="2">Carrier Roller 1</th>
                                        <th colspan="2">Carrier Roller 2</th>
                                        <th colspan="2">Carrier Roller 3</th>
                                    </tr>
                                    <tr>
                                        <th>Tools</th>
                                        <th colspan="2">Outside Caliper</th>
                                        <th colspan="2">Outside Caliper</th>
                                        <th colspan="2">Outside Caliper</th>
                                    </tr>
                                    <tr>
                                        <th>STD-LIMIT</th>
                                        @for ($i = 0; $i < 3; $i++)
                                            <th>Standart</th>
                                            <th>Limit</th>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th>Units (mm)</th>
                                        <th>210.0</th>
                                        <th>185.0</th>
                                        <th>210.0</th>
                                        <th>185.0</th>
                                        <th>210.0</th>
                                        <th>185.0</th>
                                    </tr>
                                    <tr>
                                        <th>Right Side</th>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="carrier_roller1[]" value="{{ $data->carrier_roller1[0] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="carrier_roller2[]" value="{{ $data->carrier_roller2[0] }}">
                                        </td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="carrier_roller3[]"value="{{ $data->carrier_roller3[0] }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Left Side</th>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="carrier_roller1[]" value="{{ $data->carrier_roller1[1] }}"></td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="carrier_roller2[]" value="{{ $data->carrier_roller2[1] }}">
                                        </td>
                                        <td colspan="2"><input type="text"
                                                style="background-color: #c3bdbf;text-align: center;" class="form-control"
                                                name="carrier_roller3[]" value="{{ $data->carrier_roller3[1] }}">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Picture</th>
                                        <th colspan="19"><img src="{{ asset('img/form-ppu-xe1250/ppu-125-11.png') }}"
                                                style="width: 200px; height: auto; align-item:middle;" alt="">
                                        </th>

                                    </tr>
                                    <tr>
                                        <th>Component</th>
                                        <th colspan="19">Track Troller</th>
                                    </tr>
                                    <tr>
                                        <th>Tools</th>
                                        <th colspan="19">Depth Gauge</th>
                                    </tr>
                                    <tr>
                                        <th>STD-LIMIT</th>
                                        @for ($i = 0; $i < 9; $i++)
                                            <th>Standart</th>
                                            <th>Limit</th>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th>Units (mm)</th>
                                        @for ($i = 0; $i < 9; $i++)
                                            <th>291</th>
                                            <th>263</th>
                                        @endfor

                                    </tr>
                                    <tr>
                                        <th>No Roller</th>
                                        @for ($i = 1; $i < 10; $i++)
                                            <td colspan="2">{{ $i }}</td>
                                        @endfor
                                    </tr>
                                    <tr>
                                        <th>Right Side</th>
                                        @for ($i = 0; $i < 9; $i++)
                                            <td colspan="2"><input type="text"
                                                    style="background-color: #c3bdbf;text-align: center;"
                                                    class="form-control" name="track_roller[]"
                                                    value="{{ $data->track_roller[$i] }}"></td>
                                        @endfor

                                    </tr>
                                    <tr>
                                        <th>Left Side</th>
                                        @for ($i = 1; $i < 10; $i++)
                                            <td colspan="2"><input type="text"
                                                    style="background-color: #c3bdbf;text-align: center;"
                                                    class="form-control" name="track_roller[]"
                                                    value="{{ $data->track_roller[8 + $i] }}"></td>
                                        @endfor

                                    </tr>
                                </table>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Component</th>
                                                <th colspan="2">Temuan</th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">Burshing Link</th>
                                                <td colspan="2">
                                                    <textarea name="tem_link_bushing[]" class="form-control" placeholder="Right:" id="tem_link_bushing" rows="1">{{ $data->tem_link_bushing[0] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_link_bushing[]" class="form-control" placeholder="Left:" id="tem_link_bushing" rows="1">{{ $data->tem_link_bushing[1] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th rowspan="2">Link Height</th>
                                                <td colspan="2">
                                                    <textarea name="tem_link_height[]" class="form-control" placeholder="Right:" id="tem_link_height" rows="1">{{ $data->tem_link_height[0] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_link_height[]" class="form-control" placeholder="Left:" id="tem_link_height" rows="1">{{ $data->tem_link_height[1] }}</textarea>
                                                </td>

                                            </tr>

                                            <tr>
                                                <th rowspan="2">Link Pitch</th>
                                                <td colspan="2">
                                                    <textarea name="tem_link_pitch[]" class="form-control" placeholder="Right:" id="tem_link_pitch" rows="1">{{ $data->tem_link_pitch[0] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_link_pitch[]" class="form-control" placeholder="Left:" id="tem_link_pitch" rows="1">{{ $data->tem_link_pitch[1] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th rowspan="2">Grouser Height</th>
                                                <td colspan="2">
                                                    <textarea name="tem_grouser_height[]" class="form-control" placeholder="Right:" id="tem_grouser_height"
                                                        rows="1">{{ $data->tem_grouser_height[0] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_grouser_height[]" class="form-control" placeholder="Left:" id="tem_grouser_height"
                                                        rows="1">{{ $data->tem_grouser_height[1] }}</textarea>
                                                </td>

                                            </tr>

                                            <tr>
                                                <th rowspan="2">Idler</th>
                                                <td colspan="2">
                                                    <textarea name="tem_idler[]" class="form-control" placeholder="Right:" id="tem_idler" rows="1">{{ $data->tem_idler[0] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_idler[]" class="form-control" placeholder="Left:" id="tem_idler" rows="1">{{ $data->tem_idler[1] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th rowspan="2">Carrier Roller</th>
                                                <td colspan="2">
                                                    <textarea name="tem_carrier_roller[]" class="form-control" placeholder="Right:" id="tem_carrier_roller"
                                                        rows="1">{{ $data->tem_carrier_roller[0] }}</textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_carrier_roller[]" class="form-control" placeholder="Left:" id="tem_carrier_roller"
                                                        rows="1">{{ $data->tem_carrier_roller[1] }}</textarea>
                                                </td>

                                            </tr>

                                            <tr>
                                                <th rowspan="2">Segment / Sprocket</th>
                                                <td colspan="2">
                                                    <textarea name="tem_sprocket[]" class="form-control" placeholder="Right:" id="tem_sprocket" rows="1">{{ $data->tem_sprocket[0] }} </textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_sprocket[]" class="form-control" placeholder="Left:" id="tem_sprocket" rows="1">{{ $data->tem_sprocket[1] }} </textarea>
                                                </td>

                                            </tr>

                                            <tr>
                                                <th rowspan="2">Truck Roller</th>
                                                <td colspan="2">
                                                    <textarea name="tem_track_roller[]" class="form-control" placeholder="Right:" id="tem_track_roller" rows="1">{{ $data->tem_track_roller[0] }} </textarea>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <textarea name="tem_track_roller[]" class="form-control" placeholder="Left:" id="tem_track_roller" rows="1">{{ $data->tem_track_roller[1] }}</textarea>
                                                </td>

                                            </tr>



                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Model</th>
                                                <th colspan="8" style="align-items:middle;">Tabel Keausan Component
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>XCMG 1250</th>
                                                <th>BUSHING LINK</th>
                                                <th>LINK HEIGHT</th>
                                                <th>LINK PITCH</th>
                                                <th>GROUSER HEIGHT</th>
                                                <th>IDLERS LH</th>
                                                <th>CARRIER ROLLER</th>
                                                <th>SPROCKET</th>
                                                <th>TRACK ROLLER</th>
                                            </tr>
                                            <tr>
                                                <th>0%</th>
                                                <th>99</th>
                                                <th>181</th>
                                                <th>281</th>
                                                <th>50</th>
                                                <th>23</th>
                                                <th>210</th>
                                                <th>423</th>
                                                <th>291</th>
                                            </tr>
                                            <tr>
                                                <th>10%</th>
                                                <th>98.5</th>
                                                <th>179.5</th>
                                                <th>281.3</th>
                                                <th>47.5</th>
                                                <th>23.6</th>
                                                <th>207.5</th>
                                                <th>421.8</th>
                                                <th>288.2</th>
                                            </tr>
                                            <tr>
                                                <th>20%</th>
                                                <th>98</th>
                                                <th>178.4</th>
                                                <th>281.6</th>
                                                <th>45</th>
                                                <th>24.2</th>
                                                <th>205</th>
                                                <th>420.6</th>
                                                <th>285.4</th>
                                            </tr>
                                            <tr>
                                                <th>30%</th>
                                                <th>97.5</th>
                                                <th>177.1</th>
                                                <th>281.9</th>
                                                <th>42.5</th>
                                                <th>24.8</th>
                                                <th>202.5</th>
                                                <th>419.4</th>
                                                <th>282.6</th>
                                            </tr>
                                            <tr>
                                                <th>40%</th>
                                                <th>97</th>
                                                <th>175.8</th>
                                                <th>282.2</th>
                                                <th>40</th>
                                                <th>25.4</th>
                                                <th>200</th>
                                                <th>418.2</th>
                                                <th>279.8</th>
                                            </tr>
                                            <tr>
                                                <th>50%</th>
                                                <th>96.5</th>
                                                <th>174.5</th>
                                                <th>282.5</th>
                                                <th>37.5</th>
                                                <th>26</th>
                                                <th>197.5</th>
                                                <th>417</th>
                                                <th>277</th>
                                            </tr>
                                            <tr>
                                                <th>60%</th>
                                                <th>96</th>
                                                <th>173.2</th>
                                                <th>283.8</th>
                                                <th>35</th>
                                                <th>26.6</th>
                                                <th>195</th>
                                                <th>415.8</th>
                                                <th>274.2</th>
                                            </tr>
                                            <tr>
                                                <th>70%</th>
                                                <th>95.5</th>
                                                <th>171.9</th>
                                                <th>283.1</th>
                                                <th>32.5</th>
                                                <th>27.2</th>
                                                <th>192.5</th>
                                                <th>414.6</th>
                                                <th>271.4</th>
                                            </tr>
                                            <tr>
                                                <th>80%</th>
                                                <th>95</th>
                                                <th>170.6</th>
                                                <th>283.4</th>
                                                <th>30</th>
                                                <th>27.8</th>
                                                <th>190</th>
                                                <th>413.4</th>
                                                <th>268.6</th>
                                            </tr>
                                            <tr>
                                                <th>90%</th>
                                                <th>94.5</th>
                                                <th>169.3</th>
                                                <th>283.7</th>
                                                <th>27.5</th>
                                                <th>28.4</th>
                                                <th>187.5</th>
                                                <th>412.2</th>
                                                <th>265.8</th>
                                            </tr>
                                            <tr>
                                                <th>100%</th>
                                                <th>94</th>
                                                <th>168</th>
                                                <th>284</th>
                                                <th>25</th>
                                                <th>29</th>
                                                <th>185</th>
                                                <th>411</th>
                                                <th>263</th>
                                            </tr>
                                            <tr>
                                                <th>110%</th>
                                                <th>93.5</th>
                                                <th>166.7</th>
                                                <th>284.3</th>
                                                <th>22.5</th>
                                                <th>29.6</th>
                                                <th>182.5</th>
                                                <th>409.8</th>
                                                <th>260.2</th>
                                            </tr>
                                            <tr>
                                                <th>120%</th>
                                                <th>93</th>
                                                <th>165.4</th>
                                                <th>284.6</th>
                                                <th>20</th>
                                                <th>30.2</th>
                                                <th>180</th>
                                                <th>408.6</th>
                                                <th>257.4</th>
                                            </tr>


                                        </table>
                                    </div>


                                </div>
                            </div>


                            <div class="row mt-5">
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By</label>
                                        <select name="checked1" id="dibuat_oleh" class="form-control" required>
                                            <option disabled selected>-- Select Creator --</option>
                                            @foreach ($approvalList as $user)
                                                <option
                                                    {{ old('checked1', $data->checked_1 ?? '') == $user->nama ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="diperiksa" class="ms-0">Validated By</label>
                                        <select name="validated" id="diperiksa" class="form-control" required>
                                            <option disabled selected>-- Select Approval --</option>
                                            @foreach ($approvalList as $user)
                                                <option
                                                    {{ old('validated', $data->validated ?? '') == $user->nama ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 ">
                                    <div class="input-group input-group-static mb-3">
                                        <label for="dibuat" class="ms-0">Checked By</label>
                                        <select name="checked2" id="dibuat_oleh2" class="form-control" required>
                                            <option disabled selected>-- Select Creator --</option>
                                            @foreach ($approvalList as $user)
                                                <option
                                                    {{ old('checked2', $data->checked_2 ?? '') == $user->nama ? 'selected' : '' }}>
                                                    {{ $user->nama }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-actions">
                                            <a href="{{ route('plant.ppu.xe1250.dashboard') }}"
                                                class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .accordion {
            width: 100%;

            margin: auto;
        }

        .accordion-item {
            border: 1px solid #ddd;
            margin-bottom: 5px;
            border-radius: 5px;
            overflow: hidden;
        }

        .accordion-header {
            background: #E91E63;
            color: white;
            padding: 15px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            border: none;
            text-align: left;
            width: 100%;
            outline: none;
        }

        .accordion-content {
            display: none;
            padding: 15px;
            background: #f1f1f1;
        }

        .active {
            display: block;
        }

        .form-container {
            display: flex;
            align-items: center;
            margin: 10px;
            gap: 120px;

        }

        th,
        td {
            vertical-align: middle;
            text-align: center;
            font-size: 12px;
        }

        td[rowspan] {
            vertical-align: middle !important;
            text-align: center;

        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid black !important;
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



        .custom-checkbox {
            width: 20px;
            height: 20px;
            transform: scale(1.5);
            cursor: pointer;
        }
    </style>
@endsection

@section('custom-js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.7.7/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dibuat_oleh').select2();
            $('#dibuat_oleh2').select2();
            $('#diperiksa').select2();
        });
        document.addEventListener("DOMContentLoaded", function() {
            const headers = document.querySelectorAll(".accordion-header");

            headers.forEach(header => {
                header.addEventListener("click", function() {
                    const content = this.nextElementSibling;


                    document.querySelectorAll(".accordion-content").forEach(item => {
                        if (item !== content) {
                            item.classList.remove("active");
                            item.style.display = "none";
                        }
                    });


                    if (content.classList.contains("active")) {
                        content.classList.remove("active");
                        content.style.display = "none";
                    } else {
                        content.classList.add("active");
                        content.style.display = "block";
                    }
                });
            });
        });
        $(function() {
            var form = $("#formXE1250");
            var submitBtn = form.find('button[type="submit"]');

            form.submit(function(e) {
                e.preventDefault();
                submitBtn.prop('disabled', true);

                var formData = new FormData(this);
                console.log("Form data yang dikirim:", formData);

                axios.post('{{ route('plant.ppu.xe1250.update') }}', formData)
                    .then(function(response) {
                        console.log("Respons dari server:", response.data);
                        if (response.data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        '{{ route('plant.ppu.xe1250.dashboard') }}';
                                }
                            });
                        }
                    })
                    .catch(function(error) {
                        let errorMessage = 'Terjadi kesalahan pada sistem';
                        console.log("Error respons:", error.response);

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
