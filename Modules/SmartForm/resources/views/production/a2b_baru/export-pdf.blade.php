
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Form A2B Baru</title>


    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1;
            transform: scale(1); /* Kecilkan keseluruhan */
            transform-origin: top left; /* Pastikan titik awal skala */
            
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
            right: 360px; /* Atur posisi ke kanan */
            top: 22%; /* Tengah-tengah */
            transform: translateY(-50%); 
            width: 500px; /* Ukuran dibatasi biar nggak penuh */
            height: auto;
            z-index: -1; /* Supaya ada di belakang */
            opacity: 1; /* Transparan biar nggak terlalu ganggu */
        }

        /* Style umum untuk container */
        .shape-container {
            position: relative;
            width: 50px;
            height: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Kotak outline */
        .square {
            width: 40px;
            height: 40px;
            border: 2px solid #000;
            background-color: transparent;
        }
        
        /* Segitiga dengan outline */
        .triangle {
            position: relative;
            width: 50px;
            height: 50px;
        }
        
        .triangle::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-bottom: 35px solid #000;
        }
        
        .triangle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            border-left: 18px solid transparent;
            border-right: 18px solid transparent;
            border-bottom: 31px solid white;
            z-index: 1;
        }
        
        /* Lingkaran outline */
        .circle {
            width: 40px;
            height: 40px;
            border: 2px solid #000;
            border-radius: 50%;
            background-color: transparent;
        }
        
        /* Tanda checklist */
        .checkmark {
            position: absolute;
            color: #000;
            font-size: 24px;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        /* Tanda checklist untuk segitiga - disesuaikan posisinya */
        .triangle .checkmark {
            transform: translateY(5px);
        }
        
        /* Menampilkan tanda checklist saat dicentang */
        input[type="checkbox"]:checked + .shape-container .checkmark {
            opacity: 1;
        }

    </style>
</head>

<body>
    
<table>
        <tr>
            <td colspan="3" style="border-bottom: none; border-right: none; ">
                <img src="{{ public_path('img/logo.png') }}" class="logo">
            </td>
            <td colspan="29" style="border-left: none; border-bottom: none;">
                <h1>PELAKSANAAN PEMERIKSAAN HARIAN ALL UNIT A2B</h1>
                <img src="{{ public_path('img/arrow.jpg') }}" style="width: 250px; height: auto;" class="image-floating">
            </td>
        <tr>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td colspan="3" style="text-align: left; border-bottom: none; border-right: none;">NAMA OPERATOR</td>
            <td colspan="3" style="text-align: left; border-bottom: none; border-left: none;">: {{ $record->nama_operator }}</td>
            <td colspan="3" style="text-align: left; border-top: none; border-bottom: none;"></td>
            <td colspan="2" style="text-align: left; border-right: none; border-bottom: none;">LOKASI</td>
            <td colspan="18" style="text-align: left; border-left: none; border-bottom: none;">: {{ $record->lokasi }}</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td colspan="3" style="text-align: left; border-top: none; border-right: none; border-bottom: none;">NRP</td>
            <td colspan="3" style="text-align: left; border-top: none; border-left: none; border-bottom: none;">: {{ $record->nrp }}</td>
            <td colspan="3" style="text-align: left; border-top: none; border-bottom: none;"></td>
            <td colspan="2" style="text-align: left; border-top: none; border-right: none; border-bottom: none;">TYPE/NO UNIT</td>
            <td colspan="18" style="text-align: left; border-top: none; border-left: none; border-bottom: none;">: {{ $record->type_nounit }}</td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td colspan="3" style="text-align: left; border-top: none; border-right: none; border-bottom: none;">HARI / TGL</td>
            <td colspan="3" style="text-align: left; border-top: none; border-left: none; border-bottom: none;">: {{ $record->tanggal }}</td>
            <td colspan="3" style="text-align: left; border-top: none; border-bottom: none;"></td>
            <td style="text-align: left; border-top: none; border-right: none; border-bottom: none;">HM AWAL</td>
            <td colspan="3" style="text-align: left; border-top: none; border-left: none; border-bottom: none; border-right: none;">: {{ $record->hmawal1 }}</td>
            <td style="text-align: left; border-top: none; border-right: none; border-bottom: none; border-left: none;">HM AKHIR</td>
            <td colspan="15" style="text-align: left; border-top: none; border-left: none; border-bottom: none;">: {{ $record->hmakhir1 }}</td>
        </tr>
        <tr>
            <td colspan="3" style="border-top: none; text-align: left; border-bottom: none;"></td>
            <td colspan="3" style="text-align: left; border-top: none; border-right: none;">SHIFT I / II</td>
            <td colspan="3" style="text-align: left; border-top: none; border-left: none;">: {{ $record->shift }}</td>
            <td colspan="3" style="text-align: left; border-top: none; border-bottom: none;"></td>
            <td style="text-align: left; border-top: none; border-right: none; border-left: none;">HM AWAL</td>
            <td colspan="3" style="text-align: left; border-top: none; border-left: none; border-right: none;">: {{ $record->hmawal2 }}</td>
            <td style="text-align: left; border-top: none; border-right: none; border-left: none;  border-left: none;">HM AKHIR</td>
            <td colspan="15" style="text-align: left; border-top: none; border-left: none;">: {{ $record->hmawal2 }}</td>
        </tr>
        <tr>
            <td colspan="32" style="border-top: none; border-bottom: none;">&nbsp;</td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none;"></td>
            <td colspan="5"><b>PERNYATAAN OPERATOR ( WAJIB DIISI )</b></td>
            <td colspan="9" style="border-top: none;border-bottom: none;"></td>
            <td colspan="17"><b>KETERANGAN</b></td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none;"></td>
            <td colspan="5"><b>Kondisi Saat Ini:</b></td>
            <td colspan="9" style="border-top: none;border-bottom: none;"></td>
            <td colspan="2">All body luar</td>
            <td colspan="15" style="text-align: left">Kondisi unit yang terlihat dari luar</td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none;"></td>
            <td colspan="4">FIT DAN SIAP BEKERJA</td>
            <td>{{ $record->kondisi_tubuh == 'Siap' ? '✓' : '' }}</td>
            <td colspan="9" style="border-top: none;border-bottom: none;"></td>
            <td colspan="2">Attachment</td>
            <td colspan="15" style="text-align: left">Bucket,arm,boom,vecel</td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none;"></td>
            <td colspan="4">UNFIT DAN SIAP BEKERJA</td>
            <td>{{ $record->kondisi_tubuh == 'Tidak' ? '✓' : '' }}</td>
            <td colspan="9" style="border-top: none;border-bottom: none;"></td>
            <td colspan="2">Power train</td>
            <td colspan="15" style="text-align: left">Transmisi,differential,final drive</td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none; border-right: none;"></td>
            <td colspan="4" style="border-left: none; border-right: none; border-top: none; border-bottom: none;"></td>
            <td style="border-left: none; border-right: none; border-top: none; border-bottom: none;"></td>
            <td colspan="9" style="border-top: none;border-bottom: none; border-left: none; border-right: none;"></td>
            <td colspan="2">Brake</td>
            <td colspan="15" style="text-align: left">Retarder,parking,emergency & foot</td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none; border-right: none"></td>
            <td colspan="4" style="border-top: none; border-bottom: none; border-left: none; border-right: none; text-align:left;"><b>TANDA :</b></td>
            <td style="border-top: none;border-bottom: none; border-left: none; border-right: none;"></td>
            <td colspan="9" style="border-top: none;border-bottom: none; border-left: none;"></td>
            <td colspan="2">Swing mach</td>
            <td colspan="15" style="text-align: left">Swing machinery</td>
        </tr>
        <tr>
            <td style="border-top: none;border-bottom: none;; border-right: none"></td>
            <td colspan="4" style="text-align: left; border-top: none;border-bottom: none; border-left: none; border-right: none;" >X : UNIT BERMASALAH</td>
            <td style="border-top: none;border-bottom: none; border-left: none; border-right: none;"></td>
            <td colspan="9" style="border-top: none;border-bottom: none; border-left: none;"></td>
            <td colspan="2">Alkes</td>
            <td colspan="15" style="text-align: left">Alat Kesehatan</td>
        </tr>
        <tr>
            <td style="border-top: none; border-bottom: none; border-right: none;"></td>
            <td colspan="4" style="text-align: left; border-top: none; border-bottom: none; border-left: none; border-right: none;">V : KONDISI UNIT BAIK</td>
            <td style="border-top: none;border-bottom: none; border-left: none; border-right: none; border-left: none;"></td>
            <td colspan="9" style="border-top: none;border-bottom: none; border-left: none;"></td>
            <td colspan="2">Kondisi</td>
            <td colspan="15" style="text-align: left">Retak,rusak,tidak lengkap,patah,kendor</td>
        </tr>
        <tr>
            <td colspan="32" style="border-top: none;">&nbsp;</td>
        </tr>
    <tbody>
            @php
                // Values are already decoded in the controller, no need to decode again
                $question1 = $record->{'question1'} ?? [];
                $question2 = $record->{'question2'} ?? [];
                $question3 = $record->{'question3'} ?? [];
                $question4 = $record->{'question4'} ?? [];
                $question5 = $record->{'question5'} ?? [];
                $question6 = $record->{'question6'} ?? [];
                $question7 = $record->{'question7'} ?? [];
                $question8 = $record->{'question8'} ?? [];
                $question9 = $record->{'question9'} ?? [];
                $question10 = $record->{'question10'} ?? [];
                $question11 = $record->{'question11'} ?? [];
                $question12 = $record->{'question12'} ?? [];
                $deskripsi = $record->{'deskripsi'} ?? [];
                    
            @endphp
        <tr>
            <td colspan="3"></td>
            <td>TANDA KONDISI UNIT</td>
            <td>Fungsi dari kelengkapan SKAT</td>
            <td>All Body Luar</td>
            <td>Attachment kerja unit</td>
            <td>Hydrolic cyl & hose</td>
            <td>Engine's comp</td>
            <td>Power train & transmisi</td>
            <td>Undercarriage</td>
            <td>Wheel (roda ban) & nut</td>
            <td>Suspension</td>
            <td>Brake (rem)</td>
            <td>Steering system</td>
            <td>Swing mach,circle</td>
            <td>Electric's comp</td>
            <td>Insrumen panel</td>
            <td></td>
            <td colspan="13"></td>
        </tr>
        <tr>
            <td colspan="3"><b>ITEM YANG HARUS DIPERIKSA</b></td>
            <td></td>
            <td></td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td>13</td>
            <td><b>KODE BAHAYA</b></td>
            <td colspan="13">Deskripsi</td>
        </tr>
        <tr>
            <td colspan="3"><b>Sebelum Operasi</b></td>
            <td colspan="29"></td>
        </tr>
        <tr>
            <td>1</td>
            <td colspan="2">Keliling unit periksa kondisi abnormal</td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 3, isset($record->question1[2]) ? $record->question1[2] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 4, isset($record->question1[3]) ? $record->question1[3] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 5, isset($record->question1[4]) ? $record->question1[4] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 6, isset($record->question1[5]) ? $record->question1[5] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 8, isset($record->question1[7]) ? $record->question1[7] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 9, isset($record->question1[8]) ? $record->question1[8] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 10, isset($record->question1[9]) ? $record->question1[9] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 14, isset($record->question1[13]) ? $record->question1[13] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question1_' . 15, isset($record->question1[14]) ? $record->question1[14] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td>MODERAT</td>
            <td colspan="13">
                {{ old('deskripsi_' . 1, isset($record->deskripsi[0]) ? $record->deskripsi[0] : '') }}
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td colspan="2">Periksa kebocoran oli, air, udara, bahan bakar</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 5, isset($record->question2[4]) ? $record->question2[4] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 6, isset($record->question2[5]) ? $record->question2[5] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 7, isset($record->question2[6]) ? $record->question2[6] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 8, isset($record->question2[7]) ? $record->question2[7] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 9, isset($record->question2[8]) ? $record->question2[8] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 11, isset($record->question2[10]) ? $record->question2[10] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 12, isset($record->question2[11]) ? $record->question2[11] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question2_' . 13, isset($record->question2[12]) ? $record->question2[12] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 2, isset($record->deskripsi[1]) ? $record->deskripsi[1] : '') }}
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td colspan="2">Check permukaan oli</td>
            <td>    </td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question3_' . 5, isset($record->question3[4]) ? $record->question3[4] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question3_' . 6, isset($record->question3[5]) ? $record->question3[5] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question3_' . 7, isset($record->question3[6]) ? $record->question3[6] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question3_' . 12, isset($record->question3[11]) ? $record->question3[11] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 3, isset($record->deskripsi[2]) ? $record->deskripsi[2] : '') }}
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td colspan="2">Check permukaan air subtank dan wifer</td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question4_' . 3, isset($record->question4[2]) ? $record->question4[2] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question4_' . 6, isset($record->question4[5]) ? $record->question4[5] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 4, isset($record->deskripsi[3]) ? $record->deskripsi[3] : '') }}
            </td>
        </tr>
        <tr>
            <td>5</td>
            <td colspan="2">Check tekanan udara</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question5_' . 9, isset($record->question5[8]) ? $record->question5[8] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question5_' . 11, isset($record->question5[10]) ? $record->question5[10] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 5, isset($record->deskripsi[4]) ? $record->deskripsi[4] : '') }}
            </td>
        </tr>
        <tr>
            <td>6</td>
            <td colspan="2">Test fungsi</td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 4, isset($record->question6[3]) ? $record->question6[3] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 5, isset($record->question6[4]) ? $record->question6[4] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 8, isset($record->question6[7]) ? $record->question6[7] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 11, isset($record->question6[10]) ? $record->question6[10] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 12, isset($record->question6[11]) ? $record->question6[11] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 13, isset($record->question6[12]) ? $record->question6[12] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 14, isset($record->question6[13]) ? $record->question6[13] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question6_' . 15, isset($record->question6[14]) ? $record->question6[14] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 6, isset($record->deskripsi[5]) ? $record->deskripsi[5] : '') }}
            </td>
        </tr>
        <tr>
            <td>7</td>
            <td colspan="2">Radio Komunikasi, Apar, Rotary, Traficone, Seatbelt, Alarm mundur dan semua lampu kerja</td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question7_' . 2, isset($record->question7[1]) ? $record->question7[1] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>MODERAT</td>
            <td colspan="13">
                {{ old('deskripsi_' . 7, isset($record->deskripsi[6]) ? $record->deskripsi[6] : '') }}
            </td>
        </tr>
        <tr>
            <td colspan="3"><b>Selama Operasi</b></td>
            <td colspan="29"></td>
        </tr>
        <tr>
            <td>8</td>
            <td colspan="2">Kondisi dan fungsi</td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 3, isset($record->question8[2]) ? $record->question8[2] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 4, isset($record->question8[3]) ? $record->question8[3] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 5, isset($record->question8[4]) ? $record->question8[4] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 6, isset($record->question8[5]) ? $record->question8[5] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 7, isset($record->question8[6]) ? $record->question8[6] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 8, isset($record->question8[7]) ? $record->question8[7] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 9, isset($record->question8[8]) ? $record->question8[8] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 10, isset($record->question8[9]) ? $record->question8[9] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 11, isset($record->question8[10]) ? $record->question8[10] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 12, isset($record->question8[11]) ? $record->question8[11] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 13, isset($record->question8[12]) ? $record->question8[12] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 14, isset($record->question8[13]) ? $record->question8[13] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question8_' . 15, isset($record->question8[14]) ? $record->question8[14] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 8, isset($record->deskripsi[7]) ? $record->deskripsi[7] : '') }}
            </td>
        </tr>
        <tr>
            <td>9</td>
            <td colspan="2">Lain - lain yang dianggap bahaya</td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question9_' . 1, isset($record->question9[0]) ? $record->question9[0] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>MODERAT</td>
            <td colspan="13">
                {{ old('deskripsi_' . 9, isset($record->deskripsi[8]) ? $record->deskripsi[8] : '') }}
            </td>
        </tr>
        <tr>
            <td colspan="3"><b>Selesai Operasi</b></td>
            <td colspan="29"></td>
        </tr>
        <tr>
            <td>10</td>
            <td colspan="2">Kondisi unit pasca operasi baik</td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 3, isset($record->question10[2]) ? $record->question10[2] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 4, isset($record->question10[3]) ? $record->question10[3] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 7, isset($record->question10[6]) ? $record->question10[6] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 8, isset($record->question10[7]) ? $record->question10[7] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/triangle-ck.jpg') : public_path('img/a2b_baru/triangle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 9, isset($record->question10[8]) ? $record->question10[8] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 10, isset($record->question10[9]) ? $record->question10[9] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/square-ck.jpg') : public_path('img/a2b_baru/square.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 14, isset($record->question10[13]) ? $record->question10[13] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question10_' . 15, isset($record->question10[14]) ? $record->question10[14] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td>MODERAT</td>
            <td colspan="13">
                {{ old('deskripsi_' . 10, isset($record->deskripsi[9]) ? $record->deskripsi[9] : '') }}
            </td>
        </tr>
        <tr>
            <td>11</td>
            <td colspan="2">Posisi, tempat parkir dan kebersihan</td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question11_' . 1, isset($record->question11[0]) ? $record->question11[0] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>LOW</td>
            <td colspan="13">
                {{ old('deskripsi_' . 11, isset($record->deskripsi[10]) ? $record->deskripsi[10] : '') }}
            </td>
        </tr>
        <tr>
            <td>12</td>
            <td colspan="2">Radio Komunikasi, Apar, Rotary, Traficone, Seatbelt, Alarm mundur dan semua lampu kerja</td>
            <td></td>
            <td style="text-align: center;">
                @php
                    $isChecked = old('question12_' . 2, isset($record->question12[1]) ? $record->question12[1] : '') == 1;
                    $imagePath = $isChecked ? public_path('img/a2b_baru/circle-ck.jpg') : public_path('img/a2b_baru/circle.jpg');
                @endphp
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($imagePath)) }}" style="width: 15px; height: 15px;">
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>EKSTREM</td>
            <td colspan="13">
                {{ old('deskripsi_' . 12, isset($record->deskripsi[11]) ? $record->deskripsi[11] : '') }}
            </td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="32"style="border-bottom: none; border-top: none; border-left: none; border-right: none;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">KONDISI ANDROID SISTEM</td>
            <td>BAIK</td>
            <td>TIDAK</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5">NOTE</td>
            <td colspan="3">Tanda Tangan</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="10">Laporan Kondisi Unit</td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td colspan="5">Aplikasi Aktifitas Hauler</td>
            <td>{{ $record->kondisi1 == 'Baik' ? '✓' : '' }}</td>
            <td>{{ $record->kondisi1 == 'Tidak' ? '✓' : '' }}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td style="text-align: right; border-right: none;"><img src="{{ public_path('img/a2b_baru/circle.jpg') }}" style="width: 10px; height: 10px;"></td>
            <td colspan="4" style="text-align: left; border-left: none; border-right: none;">ALL ( TYPE UNIT )</td>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="10">Siap Di Operasikan</td>
            <td colspan="5">{{ $record->kondisi_unit == 'Siap' ? '✓' : '' }}</td>
        </tr>
        <tr>
            <td colspan="5">Tablet 7"</td>
            <td>{{ $record->kondisi2 == 'Baik' ? '✓' : '' }}</td>
            <td>{{ $record->kondisi2 == 'Tidak' ? '✓' : '' }}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td style="text-align: right; border-right: none;"><img src="{{ public_path('img/a2b_baru/triangle.jpg') }}" style="width: 10px; height: 10px;"></td>
            <td colspan="4" style="text-align: left; border-left: none; border-right: none;">A2B ( ALAT BERAT )</td>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="10">Perlu Repair Sebelum operasi</td>
            <td colspan="5">{{ $record->kondisi_unit == 'Tidak' ? '✓' : '' }}</td>
        </tr>
        <tr>
            <td colspan="5">Bracker</td>
            <td>{{ $record->kondisi3 == 'Baik' ? '✓' : '' }}</td>
            <td>{{ $record->kondisi3 == 'Tidak' ? '✓' : '' }}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td style="text-align: right; border-right: none;"><img src="{{ public_path('img/a2b_baru/square.jpg') }}" style="width: 10px; height: 10px;"></td>
            <td colspan="4" style="text-align: left; border-left: none; border-right: none;">HD ( OFF HIGHWAY DUMPTRUCK)</td>
            <td colspan="3" style="border-bottom: none; border-top: none;">{{$record->operator}}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="10" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
        </tr>
        <tr>
            <td colspan="5">Charger / Cas Tablet</td>
            <td>{{ $record->kondisi4 == 'Baik' ? '✓' : '' }}</td>
            <td>{{ $record->kondisi4 == 'Tidak' ? '✓' : '' }}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5"></td>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="10" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
        </tr>
        <tr>
            <td colspan="7"><b>CATATAN KONDISI UNIT</b></td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5" style="text-align: left">1. AA / EKSTREM : STOP UNTUK PENGENDALIAN</td>
            <td colspan="3">Operator</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="15"><b>CATATAN RM / PENGAWAS</b></td>
        </tr>
        <tr>
            <td colspan="7" rowspan="2">{{$record->catatan_unit}}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5" style="text-align: left">2. A / HIGH : PEKERJAAN BISA DILAKUKAN TAPI PERLU SEGERA PENGENDALIAN</td>
            <td colspan="3" style="border-bottom: none; border-top: none;"></td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="15" rowspan="2">{{$record->catatan_pengawas}}</td>
        </tr>
        <tr>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5" style="text-align: left">3. B / LOW : PEKERJAAN BISA DILAKUKAN DENGAN PENGENDALIAN LEBIH LANJUT</td>
            <td colspan="3" style="border-bottom: none; border-top: none;">{{$record->pengawas}}</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
        </tr>
        <tr>
            <td colspan="7" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="5" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="3" >Pengawas</td>
            <td style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
            <td colspan="15" style="border-bottom: none; border-top: none; border-left: none; border-right: none;"></td>
        </tr>
    </tbody>
</table>
    
</body>

</html>
