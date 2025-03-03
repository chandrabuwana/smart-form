<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM INSPEKSI CATERING</title>
</head>
<style type="text/css">
body{
    font-family: 'Roboto Condensed', sans-serif;
}
h4 {
    margin: 0;
}
.kotak {
    border: 1px solid;
    text-align: center;
    padding: 0.5rem;
}
.w-full {
    width: 100%;
    padding: 0.5rem;
    font-size: 0.875rem;
}
.w-fullborder {
    width: 100%;
    border: 1px solid;
}
.w-half {
    width: 50%;
    font-size: 0.875rem;
}
.w-header {
    width: 50%;
    text-align: center;
}
.w-seperempat {
    width: 20%;
    font-size: 0.875rem;
}
.margin-top {
    margin-top: 0.200rem;
}
.footer {
    font-size: 0.875rem;
    padding: 1rem;
}
table {
    width: 100%;
    border-collapse: collapse;
}
table.kop {
    font-size: 0.875rem;
    text-align: center;
}
table tr.itemKop td{
    border: 1px solid;
}
table tr.items {
    background-color: #FFFF;
}
table tr.items td {
    padding: 0.5rem;
    text-align: center;
    border: 1px solid;
}
table tr.itemsHead td {
    font-size: 0.875rem;
    font-weight: bold;
    text-align: center;
}
table tr.datanilaihead th{
    font-size: 0.875rem;
    font-weight: bold;
    text-align: center;
    border: 2px solid;
    padding:0.200rem;
}
table tr.datanilaiitem td {
    font-size: 0.875rem;
    text-align: center;
    border: 1px solid;
    padding:0.100rem;
}
table tr.approval td {
    padding: 0.5rem;
    font-size: 0.875rem;
    text-align: center;
}
p.thick {
  font-weight: bold;
}
.data {
  font-family: "monaco", "Courier New", monospace;
  font-weight: bold;
}
</style>
<body>
    <table class="w-fullborder">

    <table class="kop">
        <tr class="itemKop">
            <td class="w-seperempat" rowspan="5"><img src="{{ ('img/logo.png') }}" alt="Bina Sarana Sukses" width="100" /></td>
            <td colspan="4">INTEGRATED BSS EXCELLENT SYSTEM</td>
        </tr>
        <tr class="itemKop">
            <td colspan="2" rowspan="2" style="width:60">FORM</td>
            <td style="width:35;font-size:0.650rem;text-align:left">No. Dok</td>
            <td style="width:90;text-align:left;font-size:0.650rem">: {{$data->no_dok_form}}</td>
        </tr>
        <tr class="itemKop">
            <td style="font-size:0.650rem;text-align:left">Revisi</td>
            <td style="text-align:left;font-size:0.650rem">: {{$data->revisi_form}}</td>
        </tr>
        <tr class="itemKop">
            <td colspan="2" rowspan="2" style="width:60">INSPEKSI CATERING</td>
            <td style="font-size:0.650rem;text-align:left">Tanggal</td>
            <td style="text-align:left;font-size:0.650rem">: {{$data->tanggal_form}}</td>
        </tr>
        <tr class="itemKop">
            <td style="font-size:0.650rem;text-align:left">Halaman</td>
            <td style="text-align:left;font-size:0.650rem">: {{$data->halaman_form}}</td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr> 
                <table class="w-full">
                    <tr>
                        <td class="w-seperempat">Nama</td>
                        <div class="data">: {{$data->nama_site}}</div>
                    </tr>
                    <tr>
                        <td class="w-seperempat">Depart./Section</td>
                        <div class="data">: {{$data->department}}</div>
                    </tr>
                    <tr>
                        <td class="w-seperempat">Shift</td>
                        <div class="data">: {{$data->shift}}</div>
                    </tr>
                </table>
                <td class="w-half">
                    <table class="w-full">
                    <tr>
                        <td class="w-half">Lokasi Kerja</td>
                        <div class="data">: {{$data->lokasi_kerja}}</div>
                    </tr>
                    <tr>
                        <td>Jumlah Inspektor</td>
                        <div class="data">: {{$data->jumlah_inspektor}}</div>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <div style="font-size:1rem;padding:0.200rem;">
                <lable>Hasil Pemeriksaan Inspeksi Catering :</lable>
            </div>
            <div style="font-size:1rem;padding:0.200rem;background-color:orange">
                <lable>(A) Penerimaan</lable>
            </div>
            <tr> 
                <table>
                    <tr class="datanilaihead">
                        <th>
                            NO.
                        </th>
                        <th>
                            HAL YANG SUDAH DIPERIKSA
                        </th>
                        <th>
                            NILAI
                        </th>
                        <th>
                            KETERANGAN
                        </th>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>1.</td>
                        <td style="text-align:left">Apakah karyawan penerimaan / gudang dalam keadaan sehat</td>
                        <td class="data">{{$data->q_penerimaan_1}}</td>
                        <td class="data">{{$data->q_keterangan_penerimaan_1}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>2.</td>
                        <td style="text-align:left">Apakah karyawan bagian gudang / penerima sudah menggunakan alat yang aman</td>
                        <td class="data">{{$data->q_penerimaan_2}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>3.</td>
                        <td style="text-align:left">Apakah bahan mentah yang di terima sudah di check</td>
                        <td class="data">{{$data->q_penerimaan_3}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>4.</td>
                        <td style="text-align:left">Apakah bahan mentah yang diterima sesuai spesifikasi</td>
                        <td class="data">{{$data->q_penerimaan_4}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>5.</td>
                        <td style="text-align:left">Apakah bahan yang tidak layak di kembalikan pada supleyernya</td>
                        <td class="data">{{$data->q_penerimaan_5}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>6.</td>
                        <td style="text-align:left">Apakah bahan yang tidak layak di pakai sudah dimintakan penggantinya</td>
                        <td class="data">{{$data->q_penerimaan_6}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>7.</td>
                        <td style="text-align:left">Apakah kemasan bahan yang diterima sudah sudah memenuhi syarat kemasan bahan makanan</td>
                        <td class="data">{{$data->q_penerimaan_7}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>8.</td>
                        <td style="text-align:left">Apakah alat yang digunakan dalam penerimaan sudah higienis dan aman</td>
                        <td class="data">{{$data->q_penerimaan_8}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>9.</td>
                        <td style="text-align:left">Apakah tempat penerimaan sudah disiapkan bersih dan aman</td>
                        <td class="data">{{$data->q_penerimaan_9}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>10.</td>
                        <td style="text-align:left">Apakah sudah dilakukan breafing sebelum dilakukan penerimaan matrial</td>
                        <td class="data">{{$data->q_penerimaan_10}}</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <div style="font-size:1rem;padding:0.200rem;background-color:orange">
                <lable>(B) Penyimpanan</lable>
            </div>
            <tr> 
                <table>
                    <tr class="datanilaihead">
                        <th>
                            NO.
                        </th>
                        <th>
                            HAL YANG SUDAH DIPERIKSA
                        </th>
                        <th>
                            NILAI
                        </th>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>1.</td>
                        <td style="text-align:left">Apakah tempat penyimpanan telah dibersihkan sebelum menyimpan barang</td>
                        <td class="data">{{$data->q_penyimpanan_1}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>2.</td>
                        <td style="text-align:left">Apakah stock card sudah sudah disiapkan untuk stock yang baru</td>
                        <td class="data">{{$data->q_penyimpanan_2}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>3.</td>
                        <td style="text-align:left">Apakah suhu ruang penyimpanan sudah di antisipasi</td>
                        <td class="data">{{$data->q_penyimpanan_3}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>4.</td>
                        <td style="text-align:left">Apakah sebelum disimpan barang sudah dilakukan pensortiran terhadap stok lama</td>
                        <td class="data">{{$data->q_penyimpanan_4}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>5.</td>
                        <td style="text-align:left">Apakah penempatan barang sudah memenuhi standar</td>
                        <td class="data">{{$data->q_penyimpanan_5}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>6.</td>
                        <td style="text-align:left">Apakah suhu ruang penyimpanan sudah diperiksa kembali setelah penyimpanan</td>
                        <td class="data">{{$data->q_penyimpanan_6}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>7.</td>
                        <td style="text-align:left">Apakah penyimpanan barang sudah dipisahkan secara baik</td>
                        <td class="data">{{$data->q_penyimpanan_7}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>8.</td>
                        <td style="text-align:left">Apakah penyimpanan barang menggunakan penutup yang baik</td>
                        <td class="data">{{$data->q_penyimpanan_8}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>9.</td>
                        <td style="text-align:left">Apakah kondisi ruangan/alat sudah di chek sebelumnya</td>
                        <td class="data">{{$data->q_penyimpanan_9}}</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <div style="font-size:1rem;padding:0.200rem;background-color:orange">
                <lable>(C) Persiapan</lable>
            </div>
            <tr> 
                <table>
                    <tr class="datanilaihead">
                        <th>
                            NO.
                        </th>
                        <th>
                            HAL YANG SUDAH DIPERIKSA
                        </th>
                        <th>
                            NILAI
                        </th>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>1.</td>
                        <td style="text-align:left">Apakah karyawan bagian produksi makanan dalam keadaan sehat</td>
                        <td class="data">{{$data->q_persiapan_1}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>2.</td>
                        <td style="text-align:left">Apakah karyawan sudah menggunakan alat yang aman</td>
                        <td class="data">{{$data->q_persiapan_2}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>3.</td>
                        <td style="text-align:left">Apakah sudah dilakukan breafing sistim produksi makanan terhadap karyawan produksi</td>
                        <td class="data">{{$data->q_persiapan_3}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>4.</td>
                        <td style="text-align:left">Apakah bahan mentah yang diterima sudah di chek jumlah dan spesifikasinya</td>
                        <td class="data">{{$data->q_persiapan_4}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>5.</td>
                        <td style="text-align:left">Apakah bahan yang tidak layak sudah di musnahkan</td>
                        <td class="data">{{$data->q_persiapan_5}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>6.</td>
                        <td style="text-align:left">Apakah pelaksanan pencairan sudah dilakukan dengan baik dan benar</td>
                        <td class="data">{{$data->q_persiapan_6}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>7.</td>
                        <td style="text-align:left">Apakah sistim persiapan sudah dilakukan dengan baik ( pembersihan, pengupasan, pemotongan )</td>
                        <td class="data">{{$data->q_persiapan_7}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>8.</td>
                        <td style="text-align:left">Apakah penyimpanan barang sudah menggunakan penutup yang baik</td>
                        <td class="data">{{$data->q_persiapan_8}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>9.</td>
                        <td style="text-align:left">Apakah menu sudah di chek sesuai dengan kebutuhan karyawan</td>
                        <td class="data">{{$data->q_persiapan_9}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>10.</td>
                        <td style="text-align:left">Apakah tempat selalu di bersihkan setelah dan sebelum digunakan</td>
                        <td class="data">{{$data->q_persiapan_10}}</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <div style="font-size:1rem;padding:0.200rem;background-color:orange">
                <lable>(D) Pengolahan</lable>
            </div>
            <tr> 
                <table>
                    <tr class="datanilaihead">
                        <th>
                            NO.
                        </th>
                        <th>
                            HAL YANG SUDAH DIPERIKSA
                        </th>
                        <th>
                            NILAI
                        </th>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>1.</td>
                        <td style="text-align:left">Apakah karyawan yang mengolah dalam keadaan sehat</td>
                        <td class="data">{{$data->q_pengolahan_1}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>2.</td>
                        <td style="text-align:left">Apakah karyawan pengolahan dilakukan mcu berkala</td>
                        <td class="data">{{$data->q_pengolahan_2}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>3.</td>
                        <td style="text-align:left">Apakah alat sudah dalam keadaan siap pakai</td>
                        <td class="data">{{$data->q_pengolahan_3}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>4.</td>
                        <td style="text-align:left">Apakah pengolahan makanan sudah dilakukan dengan baik</td>
                        <td class="data">{{$data->q_pengolahan_4}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>5.</td>
                        <td style="text-align:left">Apakah hasil pengolahan makan sudah dilakukan uji kematangan</td>
                        <td class="data">{{$data->q_pengolahan_5}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>6.</td>
                        <td style="text-align:left">Apakah hasil makanan sudah dilakukan uji cita rasa</td>
                        <td class="data">{{$data->q_pengolahan_6}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>7.</td>
                        <td style="text-align:left">Apakah setiap yang disajikan sudah di buatkan food sample untuk disimpan</td>
                        <td class="data">{{$data->q_pengolahan_7}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>8.</td>
                        <td style="text-align:left">Apakah setiap karyawan bekerja dengan higine dan menggunakan peralatan standart</td>
                        <td class="data">{{$data->q_pengolahan_8}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>9.</td>
                        <td style="text-align:left">Apakah barang yang tidak layak untuk di olah sudah di buang</td>
                        <td class="data">{{$data->q_pengolahan_9}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>10.</td>
                        <td style="text-align:left">Apakah tempat pengolahan selalu di bersihkan setiap setelah dan sebelum pengolahan</td>
                        <td class="data">{{$data->q_pengolahan_10}}</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <div style="font-size:1rem;padding:0.200rem;background-color:orange">
                <lable>(E) Penggolongan Sampah</lable>
            </div>
            <tr> 
                <table>
                    <tr class="datanilaihead">
                        <th>
                            NO.
                        </th>
                        <th>
                            HAL YANG SUDAH DIPERIKSA
                        </th>
                        <th>
                            NILAI
                        </th>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>1.</td>
                        <td style="text-align:left">Apakah karyawan yang bertugas menangani sampah dalam keadaan sehat</td>
                        <td class="data">{{$data->q_penggolongan_sampah_1}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>2.</td>
                        <td style="text-align:left">Apakah karyawan yang membuang sampah menggunakan pelindung dengan benar</td>
                        <td class="data">{{$data->q_penggolongan_sampah_2}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>3.</td>
                        <td style="text-align:left">Apakah sampah disetiap tempat dibuang ke tempat penampungan sementara</td>
                        <td class="data">{{$data->q_penggolongan_sampah_3}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>4.</td>
                        <td style="text-align:left">Apakah tempat sampah dicuci dan di bersihkan setiap setelah membuang sampah</td>
                        <td class="data">{{$data->q_penggolongan_sampah_4}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>5.</td>
                        <td style="text-align:left">Apakah plastik sampah di ikat kuat dan terhindar dari kebocoran</td>
                        <td class="data">{{$data->q_penggolongan_sampah_5}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>6.</td>
                        <td style="text-align:left">Apakah bahan limbah di pisahkan dari penampungan sampah umum</td>
                        <td class="data">{{$data->q_penggolongan_sampah_6}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>7.</td>
                        <td style="text-align:left">Apakah kemasan bahan yang diterima sudah memenuhi syarat kemasan bahan makanan</td>
                        <td class="data">{{$data->q_penggolongan_sampah_7}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>8.</td>
                        <td style="text-align:left">Apakah bekas minyak goreng sudah di tandai dan tidak boleh digunakan lagi</td>
                        <td class="data">{{$data->q_penggolongan_sampah_8}}</td>
                    </tr>
                    <tr class="datanilaiitem">
                        <td>9.</td>
                        <td style="text-align:left">Apakah tempat penerimaan sudah disiapkan bersih dan aman</td>
                        <td class="data">{{$data->q_penggolongan_sampah_9}}</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <tr  class="approval">
                <td>
                    <div>Diisi Oleh/</div>
                    <div>Filled by,</div>
                </td>
                <td>
                    <div>Diterima Oleh/</div>
                    <div>Received by,</div>
                </td>
                <td>
                    <div>Disetujui Oleh/</div>
                    <div>Approved by,</div>
                </td>
            </tr>
            <tr class="approval">
                <td></td>
            </tr>
            <tr class="approval">
                <td></td>
            </tr>
            <tr class="approval">
                <td>
                    <div>______________________</div>
                    <div>Vendor/ Representative</div>
                </td>
                <td>
                    <div>_______________________</div>
                    <div>Staff Supply Management</div>
                </td>
                <td>
                    <div>_______________________</div>
                    <div>Kadep Supply Management</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="footer">
        
    </div>
    </table>
</body>
</html>