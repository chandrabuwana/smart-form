
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Form KALIBRASI CT</title>


    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .container {

            border: 1px solid black;

        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .logo {
            width: 70px;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            font-size: 24px;
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
            font-size: 8px;
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
        .image-floating {
            position: absolute;
            right: 1.4px; /* Atur posisi ke kanan */
            top: 52%; /* Tengah-tengah */
            transform: translateY(-50%); 
            width: 200px; /* Ukuran dibatasi biar nggak penuh */
            height: auto;
            z-index: -1; /* Supaya ada di belakang */
            opacity: 1; /* Transparan biar nggak terlalu ganggu */
        }

    </style>
</head>

<body>
    
    <table class="container" style="page-break-after: always;">
        <tr>
            <td colspan="12" style=" background-color: #8d8d8d; color: white; border-bottom: 1px solid transparent;"><h1>HAULER CONTROL</h1></td>
        </tr>
        <tr>
            <td colspan="1" rowspan="2" style="border-bottom: 1px solid transparent; border-right: 1px solid transparent; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </td>
            <td colspan="9" style="border-bottom: 1px solid transparent;">
                <h1> KALIBRASI CYCLE TIME</h1>
            </td>
            <td>
                    Equip :
            </td>
            <td>
                    Cap Vesel :
            </td>

        </tr>
        <tr>
            <td colspan="9" style="border-bottom: 1px solid transparent;"></td>
            <td>HD785</td>
            <td>40 BCM atau 50 Ton</td>
        </tr>
        <tr>
            <td colspan="10" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
            <td>HD465</td>
            <td>24 BCM atau 30 Ton</td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Nama Operator Loader</td>
            <td colspan="3" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{  $record->nama_operator_loader_hauler}}</td>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Hari & Tanggal</td>
            <td colspan="5" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{  $record->tanggal_loader}}</td>
            <td>CMT106</td>
            <td>28 BCM atau 35 Ton</td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Nomor Exca & Lokasi Pit</td>
            <td colspan="3" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{  $record->nomor_exca_hauler}}</td>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Shift</td>
            <td colspan="5" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{  $record->shift_loader}}</td>
            <td>CMT96</td>
            <td>24 BCM atau 30 Ton</td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Jarak dan Nama Disposal</td>
            <td colspan="3" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{  $record->jarak_hauling_loader}}</td>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Alat Support</td>
            <td colspan="5" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{  $record->alat_support_hauler}}</td>
            <td>BEIBEN</td>
            <td>12 BCM atau 15 Ton</td>
        </tr>
            <td style="border-bottom: 1px solid transparent; border-right: 1px solid transparent; border-top: 1px solid transparent; text-align: left;">Jumlah Hauler Digunakan</td>
            <td colspan="3" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{$record->jumlah_hauler_digunakan_loader}}</td>
            <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">Material</td>
            <td colspan="5" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">: {{$record->material_hauler}}</td>
            <td>ACTROS 4043</td>
            <td>12 BCM atau 15 Ton</td>
        </tr>
        <tr>
            <td colspan="10" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
            <td>FM320</td>
            <td>12 BCM atau 22 Ton</td>
        </tr>
        <tr>
            <td colspan="10" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
            <td>ACTROS 3939</td>
            <td>12 BCM atau 23 Ton</td>
        </tr>
        <tr>
            <td rowspan="2">No.</td>
            <td rowspan="2">Jenis Unit</td>
            <td rowspan="2">Nomor DT/ HD</td>
            <td rowspan="2">Nama Operator</td>
            <td rowspan="2">Jarak Hauling</td>
            <td colspan="2">Waktu yang diperlukan untuk (Menit) :</td>
            <td colspan="2">Cycle Time Hauler</td>
            <td rowspan="2">Jumlah Isian Bucket</td>
            <td rowspan="2" colspan="2">Keterangan/Kondisi</td>
        </tr>
        <tr>
            <td>Antri + Manuver + siaga (1) + Pengisian Vessel</td>
            <td>Meninggalkan Front</td>
            <td>00:00:00</td>
            <td>0,00</td>
        </tr>

        <tbody>
            @php
                    // Values are already decoded in the controller, no need to decode again

                    $no_loader_hauler = $record->{'no_loader_hauler'} ?? [];
                    $nomor_dtht_hauler = $record->{'nomor_dtht_hauler'} ?? [];
                    $nama_operator_hauler = $record->{'nama_operator_hauler'} ?? [];
                    $jarak_hauling_hauler = $record->{'jarak_hauling_hauler'} ?? [];
                    $waktu_antri_hauler = $record->{'waktu_antri_hauler'} ?? [];
                    $meninggalkan_front_hauler = $record->{'meninggalkan_front_hauler'} ?? [];
                    $cycle_timer_hauler = $record->{'cycle_timer_hauler'} ?? [];
                    $jumlah_bucket_hauler = $record->{'jumlah_bucket_hauler'} ?? [];
                    $ket_front_hauler = $record->{'ket_front_hauler'} ?? [];
                    $ket_grade_hauler = $record->{'ket_grade_hauler'} ?? [];
                    $ket_disposal_hauler = $record->{'ket_disposal_hauler'} ?? [];
                    $ket_jalan_hauler = $record->{'ket_jalan_hauler'} ?? [];
                @endphp
                
                {{-- baris 1 --}}
                <tr>
                    <td rowspan="5">Loader : {{ $no_loader_hauler[0]?? ''}}</td>
                    <td rowspan="5">Hauler</td>
                    <td>{{ $nomor_dtht_hauler[0] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[0] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[0] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[0] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[0] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[0] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[0] ?? '' }}</td>
                    <td>Front :</td>
                    <td>{{ $ket_front_hauler[0] ?? '' }}</td>
                </tr>
                
                {{-- baris 2 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[1] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[1] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[1] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[1] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[1] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[1] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[1] ?? '' }}</td>
                    <td>Jalan :</td>
                    <td>{{ $ket_jalan_hauler [0] ?? '' }}</td>
                </tr>

                {{-- baris 3 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[2] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[2] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[2] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[2] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[2] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[2] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[2] ?? '' }}</td>
                    <td>Grade Jalan :</td>
                    <td>{{ $ket_grade_hauler[0] ?? '' }}</td>
                </tr>

                {{-- baris 4 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[3] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[3] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[3] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[3] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[3] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[3] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[3] ?? '' }}</td>
                    <td>Disposal :</td>
                    <td>{{ $ket_disposal_hauler[0] ?? '' }}</td>
                </tr>

                {{-- baris 5 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[4] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[4] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[4] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[4] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[4] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[4] ?? '' }}</td>
                    <td>&nbsp;</td>
                    <td>{{ $jumlah_bucket_hauler[4] ?? '' }}</td>
                    <td colspan="2"></td>
                </tr>

                {{-- baris 6 --}}
                <tr>
                    <td rowspan="5">Loader : {{ $no_loader_hauler[1]?? ''}}</td>
                    <td rowspan="5">Hauler</td>
                    <td>{{ $nomor_dtht_hauler[5] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[5] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[5] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[5] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[5] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[5] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[5] ?? '' }}</td>
                    <td>Front :</td>
                    <td>{{ $ket_front_hauler[1] ?? '' }}</td>
                </tr>
                
                {{-- baris 7 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[6] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[6] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[6] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[6] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[6] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[6] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[6] ?? '' }}</td>
                    <td>Jalan :</td>
                    <td>{{ $ket_jalan_hauler[1] ?? '' }}</td>
                </tr>

                {{-- baris 8 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[7] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[7] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[7] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[7] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[7] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[7] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[7] ?? '' }}</td>
                    <td>Grade Jalan :</td>
                    <td>{{ $ket_grade_hauler[1] ?? '' }}</td>
                </tr>

                {{-- baris 9 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[8] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[8] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[8] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[8] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[8] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[8] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[8] ?? '' }}</td>
                    <td>Disposal :</td>
                    <td>{{ $ket_disposal_hauler[1] ?? '' }}</td>
                </tr>

                {{-- baris 10 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[9] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[9] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[9] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[9] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[9] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[9] ?? '' }}</td>
                    <td>&nbsp;</td>
                    <td>{{ $jumlah_bucket_hauler[9] ?? '' }}</td>
                    <td colspan="2"></td>
                </tr>

                {{-- baris 11 --}}
                <tr>
                    <td rowspan="5">Loader : {{ $no_loader_hauler[2]?? ''}}</td>
                    <td rowspan="5">Hauler</td>
                    <td>{{ $nomor_dtht_hauler[10] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[10] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[10] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[10] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[10] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[10] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[10] ?? '' }}</td>
                    <td>Front :</td>
                    <td>{{ $ket_front_hauler[2] ?? '' }}</td>
                </tr>
                
                {{-- baris 12 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[11] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[11] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[11] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[11] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[1] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[11] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[11] ?? '' }}</td>
                    <td>Jalan :</td>
                    <td>{{ $ket_jalan_hauler [2] ?? '' }}</td>
                </tr>

                {{-- baris 13 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[12] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[12] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[12] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[12] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[12] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[12] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[12] ?? '' }}</td>
                    <td>Grade Jalan :</td>
                    <td>{{ $ket_grade_hauler[2] ?? '' }}</td>
                </tr>

                {{-- baris 14 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[13] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[13] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[13] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[13] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[13] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[13] ?? '' }}</td>
                    <td></td>
                    <td>{{ $jumlah_bucket_hauler[13] ?? '' }}</td>
                    <td>Disposal :</td>
                    <td>{{ $ket_disposal_hauler[2] ?? '' }}</td>
                </tr>

                {{-- baris 15 --}}
                <tr>
                    <td>{{ $nomor_dtht_hauler[14] ?? '' }}</td>
                    <td>{{ $nama_operator_hauler[14] ?? '' }}</td>
                    <td>{{ $jarak_hauling_hauler[14] ?? '' }}</td>
                    <td>{{ $waktu_antri_hauler[14] ?? '' }}</td>
                    <td>{{ $meninggalkan_front_hauler[14] ?? '' }}</td>
                    <td>{{ $cycle_timer_hauler[14] ?? '' }}</td>
                    <td>&nbsp;</td>
                    <td>{{ $jumlah_bucket_hauler[2] ?? '' }}</td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td rowspan="7" colspan="2" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">Keterangan :</td>
                    <td colspan="8" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td colspan="2" style=" background-color: #b2b2b2;">RUMUS :</td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;">Dibuat,</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">Mengetahui,</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td colspan="2" style="border-bottom: none;">60</td>
                </tr>
                <tr>
                    <td colspan="8" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td style="border-top: none; border-bottom: none; border-right: none;">Rit/Unit/Jam</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;"><hr></td>
                </tr>
                <tr>
                    <td colspan="8" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-right: none;">CT Hauler</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">{{$record->dibuat_hauler}}</td>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">{{$record->mengetahui_hauler}}</td>
                    <td colspan="4" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td style="border-top: none; border-bottom: none; border-right: none;">PDTY Fleet/Jam =</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none;">Rit/Unit/Jam x Cap. Vessel x Eff x Jumlah Hauler</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">({{ $record->jabatan_dibuat_hauler}})</td>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">({{ $record->jabatan_mengetahui_hauler}})</td>
                    <td colspan="4" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td colspan="2" style="border-top: none; border-bottom: none; border-right: none;"></td>
                </tr>
                    <td colspan="8" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                    <td colspan="2" style="border-top: none; border-right: none;"></td>
                </tr>
                <tr>
                    <td colspan="12" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left;">
                        <p style="font-size: 7px;">1. WAKTU ANTRI DAN MANUVER adalah Waktu yang digunakan untuk antri pertama (jika ada) kemudian manuver dan menunggu siap untuk mundur, cara menghitungnya adalah "dimulai saat unit sudah sampai di front dan akan melakukan manuver dan (jika ada) antri,
                        dan berakhir saat meninggalkan front <br> 2. WAKTU MENINGGALKAN FRONT adalah Waktu yang diperlukan untuk hauling mengangkut muatan dari front menuju disposal-dumping-kembali lagi ke front, cara menghitungnya adalah "dimulai dari unit meninggalkan front, dan berakhir saat unit sampai di front
                        sebelum mengambil posisi manuver, atau (jika ada) antri sebelum manuver</p>
                    </td>
                </tr>

        </tbody>
    </table>
    


        <table class="container" style="page-break-after: always;">
            <tr>
                <td colspan="13" style=" background-color: #8d8d8d; color: white; border-bottom: 1px solid transparent;"><h1>EXCAVATOR CONTROL</h1></td>
            </tr>

            <tr>
                <td colspan="1" rowspan="2" style="border-top: none; border-bottom: none; border-right: none;">
                    <img src="{{ public_path('img/logo.png') }}" class="logo">
                </td>
                <td colspan="9" style="border-top: none; border-bottom: none; border-left: none; border-right: none;">
                    <h1> KALIBRASI CYCLE TIME LOADER</h1>
                </td>
                <td>Type :</td>
                <td colspan="2">Kapasitas Bucket :</td>
            </tr>
            <tr>
                <td colspan="9" style="border-top: none; border-bottom: none; border-left: none; border-right: none;"></td>
                <td>PC2000</td>
                <td>9.4 BCM</td>
                <td>7.8 Ton</td>
            </tr>
            <tr>
                <td colspan="10" style="border-top: none; border-bottom: none; border-right: none;"></td>
                <td>XE1250</td>
                <td>5.2 BCM</td>
                <td>7.8 Ton</td>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none; border-right: none; text-align: left">Hari & Tanggal</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->tanggal_loader}}</td>
                <td style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">Jumlah Hauler Digunakan</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->jumlah_hauler_digunakan_loader}}</td>
                <td colspan="4" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left"></td>
                <td>XE900D</td>
                <td>4.5 BCM</td>
                <td>3.8 Ton</td>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none; border-right: none; text-align: left">Shift Kerja</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->shift_loader}}</td>
                <td style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">Jarak Hauling/Disposal (meter)</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->jarak_hauling_loader}}</td>
                <td colspan="4" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left"></td>
                <td>ZX-870</td>
                <td>4.2 BCM</td>
                <td>3.5 Ton</td>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none; border-right: none; text-align: left">Nama Operator Loader</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->nama_operator_loader}}</td>
                <td style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">Kondisi Front</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->kondisi_front_loader}}</td>
                <td colspan="4" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left"></td>
                <td>E6550F</td>
                <td>2.3 BCM</td>
                <td>1.9 Ton</td>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none; border-right: none; text-align: left">Nomor Excavator</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->nomor_exca_loader}}</td>
                <td style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">Alat Support</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->alat_support_loader}}</td>
                <td colspan="4" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left"></td>
                <td>ZX-470</td>
                <td>2.1 BCM</td>
                <td>1.8 Ton</td>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none; border-right: none; text-align: left">Lokasi Loading</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->lokasi_loader}}</td>
                <td style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">Cuaca</td>
                <td colspan="2" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left">: {{  $record->cuaca_loader}}</td>
                <td colspan="4" style="border-top: none; border-bottom: none; border-right: none; border-left: none; text-align: left"></td>
                <td>ZX350</td>
                <td>1.6 BCM</td>
                <td>1.4 Ton</td>
            </tr>
            <tr>
                <td colspan="10" style="border-top: none; border-bottom: none; border-right: none; text-align: left"></td>
                <td>PC-200</td>
                <td>1.1 BCM</td>
                <td>0.9 Ton</td>
            </tr>
            <tr>
                <td colspan="10" style="border-top: none; border-bottom: none; border-right: none; text-align: left"></td>
                <td colspan="3" rowspan="21" style="max-width: 115px; border-top: none; border-bottom: none; border-right: none; border-left: none;">
                    <img src="{{ public_path('img/rumus.png') }}" style="width: 100px; height: auto;" class="image-floating">
                </td>
            </tr>
            <tr>
                <td rowspan="2">No.</td>
                <td rowspan="2">Jenis Material</td>
                <td rowspan="2">Nomor CMT/DT</td>
                <td colspan="4">Waktu Pengisian Vessel Primary Activity (detik)</td>
                <td rowspan="2">Total Waktu Pengisian (detik)</td>
                <td colspan="2">Keterangan "Waste" Secondary Activity (detik)</td>
            </tr>
            <tr>
                <td>Digging</td>
                <td>Swing Isi</td>
                <td>Load</td>
                <td>Swing Kosong</td>
                <td>Durasi</td>
                <td>Reason</td>
            </tr>

            <tbody>

                @php
                    // Values are already decoded in the controller, no need to decode again
                    $jenis_material_loader = $record->{'jenis_material_loader'} ?? [];
                    $nomor_cmtdt_loader = $record->{'nomor_cmtdt_loader'} ?? [];
                    $digging_loader = $record->{'digging_loader'} ?? [];
                    $swing_isi_loader = $record->{'swing_isi_loader'} ?? [];
                    $load_loader = $record->{'load_loader'} ?? [];
                    $swing_kosong_loader = $record->{'swing_kosong_loader'} ?? [];
                    $total_pengisian_loader = $record->{'total_pengisian_loader'} ?? [];
                    $durasi_loader = $record->{'durasi_loader'} ?? [];
                    $reason_loader = $record->{'reason_loader'} ?? [];
                @endphp

                @for ($i = 0; $i < 18; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $jenis_material_loader[$i] ?? '' }}</td>
                    <td>{{ $nomor_cmtdt_loader[$i] ?? '' }}</td>
                    <td>{{ $digging_loader[$i] ?? '' }}</td>
                    <td>{{ $swing_isi_loader[$i] ?? '' }}</td>
                    <td>{{ $load_loader[$i] ?? '' }}</td>
                    <td>{{ $swing_kosong_loader[$i] ?? '' }}</td>
                    <td>{{ !empty($total_pengisian_loader[$i]) ? $total_pengisian_loader[$i] : '' }}</td>
                    <td>{{ $durasi_loader[$i] ?? '' }}</td>
                    <td>{{ $reason_loader[$i] ?? '' }}</td>
                </tr>
                @endfor

                <tr>
                    <td colspan="7" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">&nbsp;</td>
                    <td style="text-align: left">Rata Rata : {{ number_format($total, 2) }}</td>
                    <td colspan="5" style="border-top: none; border-bottom: none; border-right: none; text-align: left"></td>
                </tr>
                <tr>
                    <td colspan="13" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">Dibuat oleh:</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">Diketahui oleh:</td>
                    <td colspan="3" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td colspan="3" rowspan="4" style="text-align: left; vertical-align: top;">Productivity :</td>
                    <td colspan="3" rowspan="4" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                </tr>
                <tr>
                    <td colspan="7" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">{{$record->dibuat_loader}}</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">{{$record->mengetahui_loader}}</td>
                    <td colspan="9" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">({{ $record->jabatan_dibuat_dozer}})</td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">({{ $record->jabatan_mengetahui_dozer}})</td>
                    <td colspan="9" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                </tr>
                <tr>
                    <td colspan="13" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left"></td>
                    <td colspan="3" style="border-bottom: none; text-align: left">Note :</td>
                    <td colspan="9" style="border-top: none; border-bottom: none; border-right: none; text-align: left"></td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">Ket :</td>
                    <td colspan="3" style="border-bottom: none; border-top: none;"></td>
                    <td colspan="9" style="border-top: none; border-bottom: none; border-left:none; border-right: none; text-align: left"></td>
                </tr>
                <tr>
                    <td style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align: left">Waste = Kegiatan Exca diluar Loading OB & COAL</td>
                    <td colspan="3" style="border-top: none;"></td>
                    <td colspan="9" style="border-top: none; border-bottom: none; border-left:none; border-right: none; text-align: left"></td>
                </tr>
            </tbody>
        </table>

        <table>

                @php
                    // Values are already decoded in the controller, no need to decode again
                    $dozing_dozer = $record->{'dozing_dozer'} ?? [];
                    $reverse_dozer = $record->{'reverse_dozer'} ?? [];
                    $gear_shifting_dozer = $record->{'gear_shifting_dozer'} ?? [];
                    $total_dozer = $record->{'total_dozer'} ?? [];
                    $cm_dozer = $record->{'cm_dozer'} ?? [];
                    $jarak_dozer = $record->{'jarak_dozer'} ?? [];
                    $durasi_dozer = $record->{'durasi_dozer'} ?? [];
                    $reason_dozer = $record->{'reason_dozer'} ?? [];
                @endphp


            <tr>
                <td colspan="9" style=" background-color: #8d8d8d; color: white;"><h1>DOZER CONTROL</h1></td>
            </tr>

            <tr>
                <td colspan="1" rowspan="1" style="border-top: none; border-left: none; border-right: none; border-bottom: none;">
                    <img src="{{ public_path('img/logo.png') }}" class="logo">
                </td>
                <td colspan="8" style="border-top: none; border-left: none; border-right: none; border-bottom: none;">
                    <h1> KALIBRASI CYCLE TIME DOZER</h1>
                </td>
            </tr>

            <tr>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Hari & Tanggal</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->tanggal_dozer}}</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Material</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->material_dozer}}</td>
                <td colspan="3" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>

            <tr>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Shift Kerja</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->shift_dozer}}</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Jarak Dozing (meter)</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->jarak_dozing_dozer}}</td>
                <td colspan="3" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Nama Operator Dozer</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->nama_operator_dozer}}</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Kondisi Area Kerja</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->kondisi_area_kerja_dozer}}</td>
                <td colspan="3" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Nomor Lambung</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->nomor_lambung_dozer}}</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Alat Support</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->alat_support_dozer}}</td>
                <td colspan="3" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Lokasi Dozing</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->lokasi_dozing_dozer}}</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Cuaca</td>
                <td colspan="2" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">: {{$record->cuaca_dozer}}</td>
                <td colspan="3" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>

            <tr>
                <td rowspan="2">No.</td>
                <td rowspan="2">Dozing (Detik)</td>
                <td rowspan="2">Reverse (Detik)</td>
                <td rowspan="2">Gear Shifting (Detik)</td>
                <td rowspan="2">Total (Detik)</td>
                <td rowspan="2">CM (Menit)</td>
                <td rowspan="2">Jarak (M)</td>
                <td colspan="2">Keterangan "Waste" Secondary Activity (detik)</td>
            </tr>

            <tr>
                <td>Durasi</td>
                <td>Reason</td>
            </tr>

            @for ($i = 0; $i < 22; $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $dozing_dozer[$i] ?? '' }}</td>
                <td>{{ $reverse_dozer[$i] ?? '' }}</td>
                <td>{{ $gear_shifting_dozer[$i] ?? '' }}</td>
                <td>{{ $total_dozer[$i] ?? '' }}</td>
                <td>{{ $cm_dozer[$i] ?? '' }}</td>
                <td>{{ $jarak_dozer[$i] ?? '' }}</td>
                <td>{{ $durasi_dozer[$i] ?? '' }}</td>
                <td>{{ $reason_dozer[$i] ?? '' }}</td>
            </tr>
            @endfor
            
            <tr>
                <td colspan="9" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2" style="border-bottom: none; text-align: left">Perhitungan PDTY (Wajib):</td>
                <td style="border-bottom: none; text-align: left">Notes (Perbaikan Pengawas):</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Dibuat,</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">Mengetahui,</td>
                <td colspan="4" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none; text-align: left">&nbsp;</td>
                <td style="border-top: none; border-bottom: none; text-align: left"></td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
                <td colspan="4" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none; text-align: left">&nbsp;</td>
                <td style="border-top: none; text-align: left"></td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
                <td colspan="4" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none; text-align: left">&nbsp;</td>
                <td style="border-bottom: none; text-align: left">Rekomendasi Follow Up Spv.:</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">{{$record->dibuat_dozer}}</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">{{$record->mengetahui_dozer}}</td>
                <td colspan="4" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; border-bottom: none; text-align: left">&nbsp;</td>
                <td style="border-top: none; border-bottom: none; text-align: left"></td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">({{ $record->jabatan_dibuat_dozer}})</td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;">({{ $record->jabatan_mengetahui_dozer}})</td>
                <td colspan="4" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; text-align: left">&nbsp;</td>
                <td style="border-top: none; border-left: none; border-right: none; text-align: left;"></td>
                <td style="border-top: none; border-right: none; border-bottom: none; text-align: left;"></td>
                <td style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
                <td colspan="4" style="border-top: none; border-left: none; border-right: none; border-bottom: none; text-align: left;"></td>
            </tr>
        </table>
</body>

</html>
