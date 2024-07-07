<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Kuisioner</title>
    <style>
        body {
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: separate;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        .logo {
            text-align: center;
            vertical-align: middle;
            background-color: #ffffff;
        }

        .title {
            background-color: #00e6e6;
            color: white;
            text-align: center;
            vertical-align: middle;
        }

        .form {
            background-color: white;
            text-align: center;
            vertical-align: middle;
        }

        .form-top {
            text-align: left;
            vertical-align: top;
            padding-bottom: 20px;
        }

        .form-soal {
            text-align: center;
            vertical-align: top;
        }

        .doc-details,
        .doc-details th,
        .doc-details td {
            text-align: left;
            vertical-align: middle;
        }

        .check {
            text-align: center;
            vertical-align: middle;
        }

        .hide-border,
        .hide-border th,
        .hide-border td {
            border: none;
            padding-bottom: 20px;
        }

        .header-table-color {
            background-color: #00cccc;
            border-color: #004d4d;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>

<body>

    <!-- Header -->
    <table>
        <tr>
            <td class="logo" rowspan="4" colspan="1"><img
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/img/logo.png'))) }}"
                    width="150" alt="Logo"></td>
            <td class="title" rowspan="1" colspan="6">INTEGRATED BSS EXCELLENT SYSTEM</td>
        </tr>
        <tr>
            <td class="form" rowspan="3" colspan="4" style="width:10px">FORM</td>
            <td style="width:10vw">NOMOR DOKUMEN</td>
            <td style="width:20vw">
                <?= $master->nodocfm ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td>REVISI</td>
            <td>1</td>
        </tr>
        <tr class="doc-details">
            <td>TANGGAL</td>
            <td><?php
            // Contoh tanggal dari database
            $from_date = $master->start_date; // Format yyyy-mm-dd
            
            // Ubah format tanggal
            $date = new DateTime($from_date);
            
            // Array bulan dalam bahasa Indonesia
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];
            
            // Ganti nama bulan dalam bahasa Inggris menjadi bahasa Indonesia
            $bulan_eng = $date->format('F');
            $bulan_indo = $bulan[$bulan_eng];
            $formatted_date = $date->format('d') . ' ' . $bulan_indo . ' ' . $date->format('Y');
            
            echo $formatted_date;
            ?></td>
        </tr>
        <tr>
            <td class="check" colspan="5" rowspan="1">CHECKLIST MOBILISASI</td>
            <td class="doc-details">HALAMAN</td>
            <td class="doc-details">1 of 2</td>
        </tr>
        <tr></tr>
    </table>

    <!-- identifikasi masalah -->
    <table>
        <tr>
            <td class="header-table-color" rowan="1" colspan="3">A. IDENTIFIKASI UNIT</td>
        </tr>
        <tr></tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:100">EQUIPMENT MODEL</td>
            <td class="form hide-border" style="width:2">:</td>
            <td class="form hide-border" style="width:83vw">
                <?= $master->eqmodel ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">BRAND</td>
            <td class="form hide-border">:</td>
            <td class="form hide-border" style="width:83vw">
                <?= $master->brand ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">TYPE</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">
                <?= $master->type ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NOMOR LAMBUNG</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">
                <?= $master->nolambung ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">NOMOR EQUIPMENT</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">
                <?= $master->noeq ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">QUANTITY</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">
                <?= $master->qty ?>
            </td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">FROM</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">{{ $master->site_from }}</td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">TO</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw">{{ $master->site_to }}</td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">START DATE</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw"><?php
            // Contoh tanggal dari database
            $from_date = $master->start_date; // Format yyyy-mm-dd
            
            // Ubah format tanggal
            $date = new DateTime($from_date);
            
            // Array bulan dalam bahasa Indonesia
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];
            
            // Ganti nama bulan dalam bahasa Inggris menjadi bahasa Indonesia
            $bulan_eng = $date->format('F');
            $bulan_indo = $bulan[$bulan_eng];
            $formatted_date = $date->format('d') . ' ' . $bulan_indo . ' ' . $date->format('Y');
            
            echo $formatted_date;
            ?></td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">FINISH DATE</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw"><?php
            // Contoh tanggal dari database
            $from_date = $master->finish_date; // Format yyyy-mm-dd
            
            // Ubah format tanggal
            $date = new DateTime($from_date);
            
            // Array bulan dalam bahasa Indonesia
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];
            
            // Ganti nama bulan dalam bahasa Inggris menjadi bahasa Indonesia
            $bulan_eng = $date->format('F');
            $bulan_indo = $bulan[$bulan_eng];
            $formatted_date = $date->format('d') . ' ' . $bulan_indo . ' ' . $date->format('Y');
            
            echo $formatted_date;
            ?></td>
        </tr>
        <tr class="doc-details">
            <td class="form hide-border" style="width:15vw">RELEASE DATE</td>
            <td class="form hide-border" style="width:2vw">:</td>
            <td class="form hide-border" style="width:83vw"><?php
            // Contoh tanggal dari database
            $from_date = $master->created_at; // Format yyyy-mm-dd
            
            // Ubah format tanggal
            $date = new DateTime($from_date);
            
            // Array bulan dalam bahasa Indonesia
            $bulan = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];
            
            // Ganti nama bulan dalam bahasa Inggris menjadi bahasa Indonesia
            $bulan_eng = $date->format('F');
            $bulan_indo = $bulan[$bulan_eng];
            $formatted_date = $date->format('d') . ' ' . $bulan_indo . ' ' . $date->format('Y');
            
            echo $formatted_date;
            ?></td>
        </tr>
    </table>

    <br>

    <!-- Pra mobilisasi -->
    <table>
        <tr>
            <td class="header-table-color" colspan="7">B. PRA MOBILISASI</td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw">Soal 1</td>
            <td class="form-top hide-border" style="width:30vw">Apakah unit yang akan
                dimobilisasi sudah masuk dalam Jadwal Mobilisasi dalam Bulan Berjalan?</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                
                if (!empty($pra->soal_1)) {
                    // Decode data dari JSON
                    $data = json_decode($pra->soal_1, true); // `true` untuk mengembalikan array asosiatif
                
                    // Pastikan data ada sebelum mengakses
                    if (isset($data['select'])) {
                        $dataFinal = $data['select'];
                        echo $dataFinal;
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw">Soal 2</td>
            <td class="form-top hide-border" style="width:30vw">Apakah unit yang akan
                dimobilisasi sudah masuk dalam Pengajuan Cash Flow Operasional Mobilisasi Unit?</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                
                if (!empty($pra->soal_2)) {
                    // Decode data dari JSON
                    $data = json_decode($pra->soal_2, true); // `true` untuk mengembalikan array asosiatif
                
                    // Pastikan data ada sebelum mengakses
                    if (isset($data['select'])) {
                        $dataFinal = $data['select'];
                        echo $dataFinal;
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw">Soal 3</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Surat Izin Keluar dari
                Site Pengirim sudah disetujui?</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?= strtoupper($pra->soal_3) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 4</td>
            <td class="form-top hide-border" style="width:30vw">Apa Jalur Mobilisasi yang akan
                digunakan</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?= strtoupper($pra->soal_4) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 5</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Rute Mobilisasi yang akan
                digunakan sudah pernah dilalui pada kegiatan Mobilisasi sebelumnya dalam kurun waktu 6 (enam) bulan
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?= strtoupper($pra->soal_5) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 6</td>
            <td class="form-top hide-border" style="width:30vw">Bagaimana Metode Mobilisasi yang
                akan digunakan</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($pra->soal_6)) {
                $data = json_decode($pra->soal_6, true); // `true` untuk mengembalikan array asosiatif
                if (isset($data['select'])) {
                    $dataFinal = $data['select'];
                    if ($dataFinal == 'INTERNALANDVENDOR') {
                        echo 'INTERNAL DAN VENDOR';
                    } else {
                        echo $dataFinal;
                    }
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            ?></td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 7</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Unit yang akan
                dimobilisasi memerlukan Alat Angkat?</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($pra->soal_7)) {
                $data = json_decode($pra->soal_7, true); // `true` untuk mengembalikan array asosiatif
                if (isset($data['select'])) {
                    $dataFinal = $data['select'];
                    echo $dataFinal;
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            ?></td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 8</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Unit yang akan
                dimobilisasi memerlukan Alat Angkut?</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($pra->soal_8)) {
                // Decode data JSON
                $data = json_decode($pra->soal_8, true);
            
                // Periksa apakah nilai 'select' adalah 'NO' (baik huruf besar maupun kecil)
                if (isset($data['select']) && strtolower($data['select']) === 'no') {
                    echo strtoupper($data['select']);
                } else {
                    if (isset($data['select'])) {
                        echo strtoupper($data['select']) . ',<br>';
                    } else {
                        echo 'N/A,<br>';
                    }
            
                    if (!empty($data['data'])) {
                        $json_data = json_decode($data['data'], true);
                        if (is_array($json_data)) {
                            $output = '';
                            foreach ($json_data as $item) {
                                $output .= 'Tipe: ' . $item['type'] . ' - Qty : ' . $item['quantity'] . '<br>';
                            }
                            $output = rtrim($output, '<br>');
                            echo $output;
                        } else {
                            echo 'N/A';
                        }
                    } else {
                        echo 'N/A';
                    }
                }
            } else {
                echo 'N/A';
            }
            ?></td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 9</td>
            <td class="form-top hide-border" style="width:30vw">Jika pelaksanaan Mobilisasi
                menggunakan Kapal Roll Off Roll On (RoRo), maka lengkapi Dokumen berikut : (guidence di sheet Kamus
                Kapal)</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($pra->soal_9)) {
                // Decode data JSON
                $data = json_decode($pra->soal_9, true);
            
                if (isset($data['select'])) {
                    $select_value = strtoupper($data['select']);
                    if ($select_value === 'NO') {
                        echo $select_value;
                    } else {
                        echo $select_value . ',<br>';
                        if (!empty($data['data'])) {
                            $json_data = json_decode($data['data'], true);
                            if (!empty($json_data)) {
                                $output = '';
                                foreach ($json_data as $key => $value) {
                                    $output .= ucfirst(strtolower(str_replace('_', ' ', $key))) . ': ' . $value . '<br>';
                                }
                                $output = rtrim($output, '<br>');
                                echo $output;
                            } else {
                                echo 'N/A';
                            }
                        } else {
                            echo 'N/A';
                        }
                    }
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 10</td>
            <td class="form-top hide-border" style="width:30vw">Jika pelaksanaan Mobilisasi
                menggunakan Landing Craft Tank (LCT), maka lengkapi Dokumen berikut : (centang dokumen yang lengkap)
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                if (!empty($pra->soal_10)) {
                    // Decode data JSON
                    $data = json_decode($pra->soal_10, true);
                
                    if (isset($data['select'])) {
                        echo strtoupper($data['select']) . ',<br>';
                
                        if (!empty($data['data'])) {
                            $datasaem = explode(',', $data['data']); // Decode data JSON dalam 'data'
                            if ($datasaem) {
                                // Pastikan data berhasil di-decode
                                foreach ($datasaem as $item) {
                                    $item = str_replace(['[', ']', '"'], '', $item);
                                    echo $item . '<br>';
                                }
                            } else {
                                echo '';
                            }
                        } else {
                            echo '';
                        }
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 11</td>
            <td class="form-top hide-border" style="width:30vw">Jika pelaksanaan Mobilisasi
                menggunakan Landing Craft Tank (LCT), maka lengkapi Dokumen Perizinan Sandar berikut :
                (centang dokumen yang lengkap)
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                if (!empty($pra->soal_11)) {
                    // Decode data JSON
                    $data = json_decode($pra->soal_11, true);
                
                    if (isset($data['select'])) {
                        $select_value = strtoupper($data['select']);
                        echo $select_value . ',<br>';
                
                        if (!empty($data['data'])) {
                            $json_data = json_decode($data['data'], true);
                            if (is_array($json_data)) {
                                $output = '';
                                foreach ($json_data as $item) {
                                    $output .= $item . '<br>';
                                }
                                $output = rtrim($output, '<br>');
                                echo $output;
                            } else {
                                echo '';
                            }
                        } else {
                            echo '';
                        }
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 12</td>
            <td class="form-top hide-border" style="width:30vw">Jika pelaksanaan Mobilisasi
                menggunakan Alat Angkut, maka lengkapi Dokumen Perizinan berikut : (centang dokumen yang lengkap)</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                if (!empty($pra->soal_12)) {
                    // Decode data JSON
                    $data = json_decode($pra->soal_12, true);
                
                    if (isset($data['select'])) {
                        echo strtoupper($data['select']) . ',<br>';
                
                        if (!empty($data['data'])) {
                            $data_items = $data['data'];
                            $output = '';
                            foreach ($data_items as $item) {
                                $output .= $item . '<br>';
                            }
                            $output = rtrim($output, '<br>');
                            echo str_replace(['[', ']', '"'], '', $output);
                        } else {
                            echo '';
                        }
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 13</td>
            <td class="form-top hide-border" style="width:30vw">Melampirkan Nomor Polis / Cover
                Note Asuransi Alat Berat untuk Asuransi Unit yang akan dimobilisasi
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                if (!empty($pra->soal_13)) {
                    // Decode data JSON
                    $data = json_decode($pra->soal_13, true);
                
                    if (isset($data['select'])) {
                        echo strtoupper($data['select']) . ',<br>';
                
                        if (!empty($data['data'])) {
                            $data_items = $data['data'];
                            echo $data_items;
                        } else {
                            echo '';
                        }
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw;">Soal 14</td>
            <td class="form-top hide-border" style="width:30vw">Melakukan Pendaftaran Asuransi
                Pengiriman dan lengkapi Dokumen berikut :</td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                if (!empty($pra->soal_14)) {
                    // Decode data JSON
                    $json_data = json_decode(json_decode($pra->soal_14, true), true);
                    if (!empty($json_data) && is_array($json_data)) {
                        // Loop melalui setiap item dalam array
                        foreach ($json_data as $key => $value) {
                            // Cetak nilai
                            echo $value . '<br>';
                        }
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>

    </table>

    <br>

    <!-- KEsiapan unit -->
    <table>
        <tr>
            <td class="header-table-color" colspan="7">C. KESIAPAN UNIT</td>
        </tr>
        <tr></tr>
        <tr>
            <td class="form-soal hide-border">Soal 1</td>
            <td class="form-top hide-border" style="width:30vw">Apakah unit yang akan
                dimobilisasi sudah dilakukan Final Inspection dengan hasil Lulus?</td>
            <td class="form-top hide-border"style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?php
                if (!empty($unit->soal_1)) {
                    // Decode data JSON
                    $data = json_decode($unit->soal_1, true);
                
                    if (isset($data['select'])) {
                        echo strtoupper($data['select']) . ',<br>';
                
                        if (!empty($data['ALASAN'])) {
                            echo $data['ALASAN'];
                        } else {
                            echo '';
                        }
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border">Soal 2</td>
            <td class="form-top hide-border" style="width:30vw">Apakah unit yang akan
                dimobilisasi memiliki muatan?</td>
            <td class="form-top hide-border"style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($unit->soal_2)) {
                // Decode data JSON
                $data = json_decode($unit->soal_2, true);
            
                if (isset($data['select'])) {
                    $select_value = strtoupper($data['select']);
                    echo $select_value . ',<br>';
            
                    // Membandingkan nilai dengan 'NO' dalam huruf besar
                    if ($select_value !== 'NO' && !empty($data['data'])) {
                        echo $data['data'] . '<br>';
                    } else {
                        echo '';
                    }
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border">Soal 3</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Unit yang akan
                dimobilisasi dilakukan Dismantle terlebih dahulu?
            </td>
            <td class="form-top hide-border"style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($unit->soal_3)) {
                // Decode data JSON
                $data = json_decode($unit->soal_2, true);
            
                if (isset($data['select'])) {
                    $select_value = strtoupper($data['select']);
                    echo $select_value . ',<br>';
            
                    // Membandingkan nilai dengan 'NO' dalam huruf besar
                    if ($select_value !== 'NO' && !empty($data['data'])) {
                        echo $data['data'] . '<br>';
                    } else {
                        echo '';
                    }
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            
            ?></td>
        </tr>
        <tr>
            <td class="form-soal hide-border">Soal 4</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Fuel Gauge sudah
                didokumentasikan?
            </td>
            <td class="form-top hide-border"style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($unit->soal_4)) {
                // Decode data JSON
                $data = json_decode($unit->soal_4, true);
            
                if (isset($data['select'])) {
                    // Konversi nilai $data['select'] menjadi huruf besar
                    $select_value = strtoupper($data['select']);
            
                    // Menampilkan hasil
                    // if ($select_value !== 'NO') {
                    echo $select_value . ',<br>';
                    // echo !empty($data['data']) ? 'Posisi Fuel Gouge : ' . $data['data'] . '<br>' : 'N/A';
                    // } else {
                    //     echo 'N/A';
                    // }
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            
            ?></td>
        </tr>

    </table>

    <br>

    <!-- kesiapan transportasi mobilisasi  -->
    <table>
        <tr>
            <td class="header-table-color" rowan="1" colspan="7">D. KESIAPAN TRANSPORTASI MOBILISASI</td>
        </tr>
        <tr></tr>
        <tr>
            <td class="form-soal hide-border" rowspan="1" colspan="1" style="width:5vw">Soal 1</td>
            <td class="form-top hide-border" rowspan="1" colspan="2" style="width:30vw">Apakah Alat Angkut
                yang
                digunakan sudah pernah dilakukan Inspeksi dalam kurun waktu 6 (enam) bulan terakhir?
            </td>
            <td class="form-top hide-border" rowspan="1" colspan="1" style="width:2vw">:</td>
            <td class="form-top hide-border" rowspan="1" colspan="4" style="width:70vw">
                <?= strtoupper($transport->soal_1) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" rowspan="1" colspan="1" style="width:5vw">Soal 2</td>
            <td class="form-top hide-border" rowspan="1" colspan="2" style="width:30vw">Apakah Alat Angkat
                yang
                digunakan sudah pernah dilakukan Inspeksi dalam kurun waktu 6 (enam) bulan terakhir?</td>
            <td class="form-top hide-border" rowspan="1" colspan="1" style="width:2vw">:</td>
            <td class="form-top hide-border" rowspan="1" colspan="4" style="width:70vw">
                <?= strtoupper($transport->soal_2) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" rowspan="1" colspan="1" style="width:5vw">Soal 3</td>
            <td class="form-top hide-border" rowspan="1" colspan="2" style="width:30vw">Apakah data Nama dan
                Nomor
                Telepon Penanggungjawab Mobilisasi sudah diterima oleh Logistik Site Penerima?</td>
            <td class="form-top hide-border" rowspan="1" colspan="1" style="width:2vw">:</td>
            <td class="form-top hide-border" rowspan="1" colspan="4" style="width:70vw">
                <?= strtoupper($transport->soal_3) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" rowspan="1" colspan="1" style="width:5vw">Soal 4</td>
            <td class="form-top hide-border" rowspan="1" colspan="2" style="width:30vw">Apakah terdapat
                Petugas
                Pengawalan dari Kepolisian dalam pelaksanaan Mobilisasi?</td>
            <td class="form-top hide-border" rowspan="1" colspan="1" style="width:2vw">:</td>
            <td class="form-top hide-border" rowspan="1" colspan="4" style="width:70vw">
                <?= strtoupper($transport->soal_4) ?>
            </td>
        </tr>


    </table>

    <br>

    <!-- pengendalian keselamatan resiko -->
    <table>
        <tr>
            <td class="header-table-color" rowan="1" colspan="7">E. PENGENDALIAN KESELAMATAN DAN RESIKO</td>
        </tr>
        <tr></tr>
        <tr>
            <td class="form-soal hide-border" rowspan="1" colspan="1" style="width:5vw">Soal 1</td>
            <td class="form-top hide-border" rowspan="1" colspan="2" style="width:30vw">Apakah Unit yang
                dimuat dalam
                Alat Angkut sudah dilakukan Lashing dengan benar?
            </td>
            <td class="form-top hide-border" rowspan="1" colspan="1" style="width:2vw">:</td>
            <td class="form-top hide-border" rowspan="1" colspan="4" style="width:70vw">
                <?php
                if (!empty($keselamatan->soal_1)) {
                    // Decode data JSON
                    $data = json_decode($keselamatan->soal_1, true);
                
                    if (isset($data['select']) && isset($data['data'])) {
                        // Menampilkan hasil
                        $output = $data['select'] . ',<br>';
                        // $output .= $data['data'] . '<br>';
                
                        echo $output;
                    } else {
                        echo 'N/A';
                    }
                } else {
                    echo 'N/A';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" rowspan="1" colspan="1" style="width:5vw">Soal 2</td>
            <td class="form-top hide-border" rowspan="1" colspan="2" style="width:30vw">Apakah Pengemudi
                sebagai
                pelaksana Mobilisasi sudah memiliki Surat Izin Mengemudi yang masih aktif sesuai dengan regulasi dari
                Kepolisian Republik Indonesia ?
            </td>
            <td class="form-top hide-border" rowspan="1" colspan="1" style="width:2vw">:</td>
            <td class="form-top hide-border" rowspan="1" colspan="4" style="width:70vw">
                <?= strtoupper($keselamatan->soal_2) ?>
            </td>
        </tr>


    </table>

    <br>
    <!-- post mobilisasi -->
    <table>
        <tr>
            <td class="header-table-color" colspan="7">F. POST MOBILISASI</td>
        </tr>
        <tr></tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw">Soal 1</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Kondisi Unit yang
                diterima sesuai dengan Hasil Final Inspection pada saat Pengiriman?
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?= strtoupper($post->soal_1) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw">Soal 2</td>
            <td class="form-top hide-border" style="width:30vw">Jika Kondisi Unit yang diterima
                sesuai dengan Kondisi pada saat Pengiriman, maka :
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw">
                <?= strtoupper($post->soal_1) ?>
            </td>
        </tr>
        <tr>
            <td class="form-soal hide-border" style="width:5vw">Soal 3</td>
            <td class="form-top hide-border" style="width:30vw">Apakah Kondisi Fuel Gauge sesuai
                dengan Kondisi Sebelum Pengiriman Unit
            </td>
            <td class="form-top hide-border" style="width:2vw">:</td>
            <td class="form-top hide-border" style="width:70vw"><?php
            if (!empty($post->soal_3)) {
                // Decode data JSON
                $data = json_decode($post->soal_3, true);
            
                if (isset($data['select']) && isset($data['data'])) {
                    // Menampilkan hasil
                    $output = $data['select'] . ',<br>';
                    $output .= $data['data'] . '<br>';
            
                    echo $output;
                } else {
                    echo 'N/A';
                }
            } else {
                echo 'N/A';
            }
            
            ?></td>
        </tr>

    </table>
    <br>
    <br>
    <br>
    <br>

    <div class="row" style="padding: 20px">
        <table style="border:none">
            <tr class="hide-border">
                <td style="width: 70vw">
                    <table class="densoTableHeader" style=" align-content: center; border : none">
                        <tbody class="hide-border">
                            <tr class="hide-border">
                                <td style="width: 100px" class="hide-border">
                                    <div class="row">
                                        <div class="col center">
                                            ......................................................
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col center">Dibuat Oleh,</div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col center">
                                            (Asset Procurement Officer)
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <div class="row">
                        <div class="col center">Disetujui Oleh,</div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col center">
                            (Kasi Asset Procurement)
                        </div>
                    </div>
                </td>
            </tr>
        </table>


    </div>

    <script></script>
</body>

</html>
