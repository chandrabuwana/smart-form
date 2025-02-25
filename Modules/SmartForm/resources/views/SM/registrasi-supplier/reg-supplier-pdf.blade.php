<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FORM REGISTRASI SUPPLIER</title>
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
table tr.approval td {
    padding: 0.5rem;
    font-size: 0.875rem;
    text-align: center;
}
p.thick {
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
            <td style="width:90;text-align:left;font-size:0.650rem">: {{$data->nodok_form}}</td>
        </tr>
        <tr class="itemKop">
            <td style="font-size:0.650rem;text-align:left">Revisi</td>
            <td style="text-align:left;font-size:0.650rem">: {{$data->revisi_form}}</td>
        </tr>
        <tr class="itemKop">
            <td colspan="2" rowspan="2" style="width:60">REGISTRASI SUPPLIER (Supplier Registration)</td>
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
            <lable style="font-size:0.700rem;padding:0.300rem">Informasi Umum Vendor / Vendor's Information :</lable>
            <tr> 
                <table class="w-full">
                    <tr>
                        <td style="width:150;font-size: 0.875rem;">Nama Vendor (CV/PT)</td>
                        <td class="w-half">: {{$data->nama_vendor}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Vendors Name</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Status Pajak</td>
                        <td class="w-half">: {{$data->status_pajak_pkp}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">(only for domestic Vendor)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">No NPWP</td>
                        <td class="w-half">: {{$data->no_npwp}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">(only for domestic Vendor)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Bidang Usaha</td>
                        <td class="w-half">: {{$data->bidang_usaha}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Business Field</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <lable style="font-size:0.700rem;padding:0.300rem">Informasi Alamat dan Kontak / Address and Contact Information :</lable>
            <tr> 
                <table class="w-full">
                    <tr>
                        <td style="width:150;font-size: 0.875rem;">Alamat Kantor</td>
                        <td class="w-half">: {{$data->alamat_kantor}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Company Address</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Kota</td>
                        <td class="w-half">: {{$data->kota}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">City</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Telepon</td>
                        <td class="w-half">: {{$data->telepon}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Telephone</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Email</td>
                        <td class="w-half">: {{$data->email}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Email</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Kode Pos</td>
                        <td class="w-half">: {{$data->kode_pos}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Postal Code</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Penanggung Jawab 1</td>
                        <td class="w-half">: {{$data->pj_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Person In Charge</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Telepon</td>
                        <td class="w-half">: {{$data->tlp_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Telephone</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Jabatan</td>
                        <td class="w-half">: {{$data->jabatan_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Position</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Email</td>
                        <td class="w-half">: {{$data->jabatan_1_email}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Email</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Penanggung Jawab 2</td>
                        <td class="w-half">: {{$data->pj_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Person In Charge</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Telepon</td>
                        <td class="w-half">: {{$data->tlp_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Telephone</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Jabatan</td>
                        <td class="w-half">: {{$data->jabatan_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Position</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Email</td>
                        <td class="w-half">: {{$data->jabatan_2_email}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Email</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <lable style="font-size:0.700rem;padding:0.300rem">Informasi Referensi Transaksi Pembayaran/ Payment Reference :</lable>
            <tr> 
                <table class="w-full">
                    <tr>
                        <td style="width:150;font-size: 0.875rem;">Metode Pembayaran</td>
                        <td class="w-half">: {{$data->metode_pembayaran}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Payment Method</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Syarat Pembayaran</td>
                        <td class="w-half">: {{$data->syarat_pembayaran}} hari</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Terms of Payment (day)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">PPN</td>
                        <td class="w-half">: {{$data->pph}} %</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">PPH</td>
                        <td class="w-half">: {{$data->pph}} %</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Nama Rekening 1</td>
                        <td class="w-half">: {{$data->nama_rekening_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Account Name</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Nomor Rekening 1</td>
                        <td class="w-half">: {{$data->nomor_rekening_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Account Number</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Nama Bank 1</td>
                        <td class="w-half">: {{$data->nama_bank_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Bank Name</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Alamat Bank 1</td>
                        <td class="w-half">: {{$data->alamat_bank_1}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Bank Address</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Nama Rekening 2</td>
                        <td class="w-half">: {{$data->nama_rekening_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Account Name</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Nomor Rekening 2</td>
                        <td class="w-half">: {{$data->nomor_rekening_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Account Number</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Nama Bank 2</td>
                        <td class="w-half">: {{$data->nama_bank_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Bank Name</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Alamat Bank 2</td>
                        <td class="w-half">: {{$data->alamat_bank_2}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Bank Address</td>
                    </tr>
                </table>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="w-full">
            <lable style="font-size:0.700rem;padding:0.300rem">Lampiran Dokumen /Attached Documents :</lable>
            <tr> 
                <table class="w-full">
                    <tr>
                        <td style="width:150;font-size: 0.875rem;">NPWP</td>
                        <td class="w-half">: {{$data->npwp}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">(only for local Vendor)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">SPPKP</td>
                        <td class="w-half">: {{$data->sppkp}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">(only for local Vendor)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">NIB / SIUP</td>
                        <td class="w-half">: {{$data->nib_siup}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">(sesuaikan KBLI dengan bidang bisnis):(only for local Vendor)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Akta Perusahaan</td>
                        <td class="w-half">: {{$data->akta_perusahaan}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">(only for local Vendor)</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Pakta Integritas</td>
                        <td class="w-half">: {{$data->pakta_integritas}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Integrity Pact</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Kartu Identitas Direktur</td>
                        <td class="w-half">: {{$data->kartu_identitas_direktur}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Identity Card</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Struktur Organisasi</td>
                        <td class="w-half">: {{$data->struktur_organisasi}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Organisation Structure</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Profile Perusahaan</td>
                        <td class="w-half">: {{$data->profile_perusahaan}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Company's Profile</td>
                    </tr>
                    <tr>
                        <td style="font-size:0.875rem;">Surat Lainnya</td>
                        <td class="w-half">: {{$data->surat_lainnya}}</td>
                    </tr>
                    <tr>
                        <td style="width:150;font-size:0.700rem;font-style: italic;">Other Certificate</td>
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