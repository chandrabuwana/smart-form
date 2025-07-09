<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form PPU XE1250</title>


    <style>
        body {
            font-family: Arial, "Segoe UI", sans-serif;
        }

        .container {

            border: 1px solid black;

        }

        .ttd {
            width: 40px;
        }

        .custom-height {
            height: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 70px;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            font-size: 5px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-left {
            text-align: left;
        }

        .top {
            text-align: center;
            margin-bottom: 5px;
        }

        .detail {
            font-weight: bold;
            margin-bottom: -5px;
        }

        .bottom {
            margin-top: 20px;
            font-size: 10px;

        }

        .bottom li {
            list-style-type: none;
            margin-bottom: 5px;
        }

        .title {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="top">
        <p class="title">BSS-FRM-PLA-083 FORM PPU XE1250</p>
    </div>
    <div style="border: 2px solid black; padding: 5px;">
        <table class="container">
            <tr>
                <th colspan="4" rowspan="3" style="border-bottom: none; ">
                    <img src="{{ public_path('img/logo.png') }}" class="logo">
                </th>
                <th colspan="13" style="height:10px; background-color: #3cbeca91;"></th>
                <td>No Document</td>
                <td>FRM-PLA-083</td>

            </tr>
            <tr>
                <td colspan="13" rowspan="2" style=" text-align: center; font-weight: bold; font-size:8px;">
                    FORM<br>
                    FORM UNDERCARRIAGE INSPECTION REPORT</td>
                <td>Issued</td>
                <td>8/6/2024</td>

            </tr>
            <tr>
                <td>Revisi</td>
                <td>A/01</td>
            </tr>
            <tr>
                <td colspan="5" rowspan="3" style="border-bottom: none; ">
                    <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-1.png') }}" width="200" height="40">

                </td>
                <th colspan="2">Inspection Date :</th>
                <th colspan="2">UNIT MODAL</th>
                <th colspan="2">C/N Unit</th>
                <th colspan="2">SMR / Hm</th>
                <th colspan="2">Work Operation</th>
                <th colspan="2">Ground Condition</th>
                <th colspan="2">Condition Area Frame</th>
            </tr>
            <tr>
                <td colspan="2" style="height: 10px;">{{ $data->inspection_date }}</td>
                <td colspan="2" style="height: 10px;">{{ $data->unit_model }}</td>
                <td colspan="2" style="height: 10px;">{{ $data->cn_unit }}</td>
                <td colspan="2" style="height: 10px;">{{ $data->smr_hm }}</td>
                <td colspan="2" style="height: 10px;">{{ $data->work_operation }}</td>
                <td colspan="2" style="height: 10px;">{{ $data->ground_condition }}</td>
                <td colspan="2" style="height: 10px;">{{ $data->condition_area }}</td>
            </tr>
            <tr>
                <td colspan="14" rowspan="2" style="text-align: left; vertical-align: top;">Content And Summary :
                    {{ $data->content_summary }}
                </td>

            </tr>
            <tr>


            </tr>
            <tr>
                <td colspan="19"></td>
            </tr>
            <tr>
                <td> Picture <img style="text-align: right; vertical-align: top;"
                        src="{{ public_path('img/form-ppu-xe1250/ppu-125-12.png') }}" width="20" height="10">
                </td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-2.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-3.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-4.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-5.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-6.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-7.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-8.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-9.png') }}" width="100"
                        height="40"></td>
                <td colspan="2"> <img src="{{ public_path('img/form-ppu-xe1250/ppu-125-10.png') }}" width="100"
                        height="40"></td>

            </tr>
            <tr>
                <th>Component</th>
                <th colspan="2">Link Pitch</th>
                <th colspan="2">Link Height</th>
                <th colspan="2">Bushing O.D</th>
                <th colspan="2">Grouser Height</th>
                <th colspan="2">Idler</th>
                <th colspan="2">Sprocket</th>
                <th colspan="2">Carrier Roller 1</th>
                <th colspan="2">Carrier Roller 2</th>
                <th colspan="2">Carrier Roller 3</th>
            </tr>
            <tr>
                <th>Tools</th>
                <th colspan="2">Meteran, Penggaris Besi</th>
                <th colspan="2">Depth Gauge</th>
                <th colspan="2">Outside Caliper</th>
                <th colspan="2">Depth Gauge</th>
                <th colspan="2">Outside Caliper</th>
                <th colspan="2">Outside Caliper</th>
                <th colspan="2">Outside Caliper</th>
                <th colspan="2">Outside Caliper</th>
                <th colspan="2">Outside Caliper</th>
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
                <th>281.0</th>
                <th>284.0</th>
                <th>181.0</th>
                <th>168.0</th>
                <th>99.0</th>
                <th>94.0</th>
                <th>50.0</th>
                <th>25.0</th>
                <th>23.0</th>
                <th>29.0</th>
                <th>423.0</th>
                <th>411.0</th>
                <th>210.0</th>
                <th>185.0</th>
                <th>210.0</th>
                <th>185.0</th>
                <th>210.0</th>
                <th>185.0</th>
            </tr>
            <tr>
                <th>Right Side</th>
                <td class="custom-height" colspan="2">{{ $data->link_pitch[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->link_height[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->link_bushing[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->grouser_height[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->idler[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->sprocket[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->carrier_roller1[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->carrier_roller2[0] }}</td>
                <td class="custom-height" colspan="2">{{ $data->carrier_roller3[0] }}</td>
            </tr>
            <tr>
                <th>Left Side</th>
                <td class="custom-height" colspan="2">{{ $data->link_pitch[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->link_height[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->link_bushing[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->grouser_height[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->idler[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->sprocket[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->carrier_roller1[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->carrier_roller2[1] }}</td>
                <td class="custom-height" colspan="2">{{ $data->carrier_roller3[1] }}</td>
            </tr>
            <tr>
                <td> Picture <img style="text-align: right; vertical-align: top;"
                        src="{{ public_path('img/form-ppu-xe1250/ppu-125-12.png') }}" width="20" height="10">
                </td>
                <td colspan="18"><img style="text-align: center; vertical-align: top;"
                        src="{{ public_path('img/form-ppu-xe1250/ppu-125-11.png') }}" width="100" height="40">
                </td>
            </tr>
            <tr>
                <th>Component</th>
                <th colspan="18">Track Troller</th>

            </tr>
            <tr>
                <th>Tools</th>
                <th colspan="18">Depth Gauge</th>

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
                    <td colspan="2" class="custom-height">{{ $data->track_roller[$i] }}</td>
                @endfor

            </tr>
            <tr>
                <th>Left Side</th>
                @for ($i = 1; $i < 10; $i++)
                    <td colspan="2" class="custom-height">{{ $data->track_roller[8 + $i] }}</td>
                @endfor

            </tr>
            <tr>
                <td colspan="19" style="border: none; height: 10px;"></td>
            </tr>
            <tr>
                <th colspan="2">Component</th>
                <th colspan="5">Temuan</th>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">Model</th>
                <th colspan="8" style="align-items:middle;">Tabel Keausan Component
                </th>
            </tr>
            <tr>
                <td rowspan="2" colspan="2">Burshing Link</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right :
                    {{ $data->tem_link_bushing[0] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">XCMG 1250</th>
                <th>BUSHING LINK</th>
                <th>LINK HEIGHT</th>
                <th>LINK PITCH</th>
                <th>GROUSER HEIGHT</th>
                <th>IDLER LH</th>
                <th>CARRIER ROLLER</th>
                <th>SPROCKET</th>
                <th>TRACK ROLLER</th>
            </tr>
            <tr>
                <td colspan="5" style="text-align: left; padding-left:10px;">Left :
                    {{ $data->tem_link_bushing[1] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">0%</th>
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
                <td rowspan="2" colspan="2">Link Height</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right :
                    {{ $data->tem_link_height[0] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">10%</th>
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
                <td colspan="5" style="text-align: left; padding-left:10px;">Left :
                    {{ $data->tem_link_height[1] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">20%</th>
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
                <td rowspan="2" colspan="2">Link Pitch</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right :
                    {{ $data->tem_link_pitch[0] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">30%</th>
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
                <td colspan="5" style="text-align: left; padding-left:10px;">Left :
                    {{ $data->tem_link_pitch[1] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">40%</th>
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
                <td rowspan="2" colspan="2">Grouser Height</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right :
                    {{ $data->tem_grouser_height[0] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">50%</th>
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
                <td colspan="5" style="text-align: left; padding-left:10px;">Left :
                    {{ $data->tem_grouser_height[1] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">60%</th>
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
                <td rowspan="2" colspan="2">Idler</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right : {{ $data->tem_idler[0] }}
                </td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">70%</th>
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
                <td colspan="5" style="text-align: left; padding-left:10px;">Left : {{ $data->tem_idler[1] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">80%</th>
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
                <td rowspan="2" colspan="2">Carrier Roller</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right :
                    {{ $data->tem_carrier_roller[0] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">90%</th>
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
                <td colspan="5" style="text-align: left; padding-left:10px;">Left :
                    {{ $data->tem_carrier_roller[0] }}</td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">100%</th>
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
                <td rowspan="2" colspan="2">Segment / Sprocket</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right : {{ $data->tem_sprocket[0] }}
                </td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">110%</th>
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
                <td colspan="5" style="text-align: left; padding-left:10px;">Left : {{ $data->tem_sprocket[1] }}
                </td>
                <td colspan="2" style="border: none;"></td>
                <th colspan="2">120%</th>
                <th>93</th>
                <th>165.4</th>
                <th>284.6</th>
                <th>20</th>
                <th>30.2</th>
                <th>180</th>
                <th>408.6</th>
                <th>257.4</th>
            </tr>
            <tr>
                <td rowspan="2" colspan="2">Truck Roller</td>
                <td colspan="5" style="text-align: left; padding-left:10px;">Right :
                    {{ $data->tem_track_roller[0] }} </td>
                <td colspan="12" style="border: none;"></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: left; padding-left:10px;">Left :
                    {{ $data->tem_track_roller[1] }} </td>
                <td colspan="12" style="border: none;"></td>

            </tr>
            <tr>
                <td colspan="19" style="border: none; height: 10px;"></td>
            </tr>
            <tr>
                <td colspan="3">Checked By</td>
                <td colspan="3">Validated By</td>
                <td colspan="3">Checked By</td>
                <td colspan="10" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="3" style="height: 30px; border-bottom: none;"><img
                        src="{{ public_path('img/checked.png') }}" class="ttd"></td>
                </td>

                @if ($data->status == 'approved')
                    <td colspan="3" style="height: 30px; border-bottom: none; width: 20%;"> <img
                            src="{{ public_path('img/validated.png') }}" class="ttd">
                    </td>
                @else
                    <td colspan="3" style="height: 30px; border-bottom: none; width: 20%;"></td>
                @endif
                <td colspan="3" style="height: 30px; border-bottom: none;"><img
                        src="{{ public_path('img/checked.png') }}" class="ttd"></td>
                </td>
                <td colspan="10" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="3" style="border-top: none;">
                    {{ $data->checked_1 }}</td>
                <td colspan="3" style="border-top: none;">
                    {{ $data->validated }}</td>
                <td colspan="3"style="border-top: none;">
                    {{ $data->checked_2 }}</td>
                <td colspan="10" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="3">(Mechanic)</td>
                <td colspan="3">(Foreman)</td>
                <td colspan="3">(Mechanic)</td>
                <td colspan="10" style="border: none"></td>
            </tr>
            <tr>
                <td colspan="3"> {{ \Carbon\Carbon::parse($data->date_checked)->translatedFormat('d -m Y') }}
                </td>
                <td colspan="3">
                    {{ $data->date_validated ? \Carbon\Carbon::parse($data->date_validated)->translatedFormat('d - m - Y') : '-' }}
                </td>
                <td colspan="3">{{ \Carbon\Carbon::parse($data->date_checked)->translatedFormat('d -m Y') }}
                </td>

                <td colspan="10" style="border: none"></td>
            </tr>



        </table>

    </div>


</body>

</html>
