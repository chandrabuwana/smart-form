<?php

namespace Modules\SmartForm\App\Http\Controllers\SM;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\SmartForm\helpers\HrdHelper;

class RegistrasiSupplierController extends Controller {

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function RegisSupplierDashboard(Request $req)
    {
        $nik_session = $req->session()->get('user_id', '');
        $name_session = $req->session()->get('username', '');
        return view('SmartForm::SM/registrasi-supplier/dashboard-registrasi-supplier', [
            'nik_session' => $nik_session,
            'name_session' => $name_session]);
    }

    function GetListRegistrasiSupplier(Request $request) {
        $TABLE_MASTER = "FM_SM_00X_REGISTRASI_SUPPLIER";
        $response = array(
            'message' => '',
            'isSuccess' => false
        );
        $filterTanggal = $request->query('tanggal', null);
        $filterSite = $request->query('site', null);
        $filterNik = $request->query('nama', null);
        $filterStatus = $request->query('status', null);
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'desc');
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null); // Default limit
        $filter = $request->query('filter', null); // Default limit
        try {
            $master = DB::table($TABLE_MASTER)
                ->select('id','nama_vendor','status','no_npwp','bidang_usaha','kota','diisi_oleh','is_active','disetujui_oleh');
            
            if($filterTanggal == null || $filterTanggal == 'null') {
            } else {
                $tgl = Carbon::createFromFormat('Y-m-d', $filterTanggal);
                $master->whereDate('tanggal', $tgl);
            }
            if($filterSite == null || $filterSite == 'null') {
            } else {
                $master->where('site', $filterSite);
            }
            if($filterNik == null || $filterNik == 'null') {
            } else {
                $master->where('nik', $filterNik);
            }
            if($filterStatus == null || $filterStatus == 'null') {
            } else {
                $master->where('status', $filterStatus);
            }
            $master->orderBy($sort, $order);
            // Log::debug("SQL : ".$master->toRawSql());
            $jml = $master->count();
            if($limit == null || $limit == 'null' || $limit == '') {
                $master->skip($offset);
            } else {
                $master->skip($offset)->limit($limit);
            }
            $document = $master->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $document
            ];

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    function FormRegistrasiSupplier() {
        return view('SmartForm::SM/registrasi-supplier/form-registrasi-supplier', [
                    'isShowDetail' => true,
                    'approvalList' => HrdHelper::getApprovalList()
                ]);
    }
    
    public function CreateRegisSupplier(Request $request)
    {    
        $requested_by = $request->session()->get('user_id');
        $files = [];
        if($request->hasfile('filenames'))

         {
            foreach($request->file('filenames') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('images/SM/registrasi_supplier'), $name);  
                $files[] = $name;  
            }
         }

            DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->insert([
                'nodok_form' => "BSS-FRM-SM-000",
                'revisi_form' => "0",
                'tanggal_form' => "04-Aug-24",
                'halaman_form' => "1 of 1",
                'nama_vendor' => $request->tVendorName,
                'status_pajak_pkp' => $request->rPkp,
                'no_npwp' => $request->tNoNpwp,
                'bidang_usaha' => $request->tBidang,
                'alamat_kantor' => $request->tAlamatKan,
                'kota' => $request->tKota,
                'telepon' => $request->tTlp,
                'kode_pos' => $request->tKodePos,
                'email' => $request->tEmail,
                'metode_pembayaran' => $request->rMetodePembayaran,
                'syarat_pembayaran' => $request->tSyaratPemb,
                'ppn' => $request->tPpn,
                'pph' => $request->tPph,
                'nama_rekening_1' => $request->tAccNm1,
                'nomor_rekening_1' => $request->tAccNo1,
                'nama_bank_1' => $request->tNamaBank1,
                'alamat_bank_1' => $request->tBankAdd1,
                'nama_rekening_2' => $request->tAccNm2,
                'nomor_rekening_2' => $request->tAccNo2,
                'nama_bank_2' => $request->tNamaBank2,
                'alamat_bank_2' => $request->tBankAdd2,
                'pj_1' => $request->tPic1,
                'tlp_1' => $request->tTlpPic1,
                'jabatan_1' => $request->tJabatPic1,
                'jabatan_1_email' => $request->tEmailPic1,
                'pj_2' => $request->tPic2,
                'tlp_2' => $request->tTlpPic2,
                'jabatan_2' => $request->tJabatPic2,
                'jabatan_2_email' => $request->tEmailPic2,
                'npwp' => $request->rNpwp1,
                // MUDOF
	    	    'file_npwp' => $files[0] ?? "Tidak ada",
	    	    'file_sppkp' => $files[1] ?? "Tidak ada",
	    	    'file_nib_siup' => $files[2] ?? "Tidak ada",
	    	    'file_akta_perusahaan' => $files[3] ?? "Tidak ada",
	    	    'file_pakta_integritas' => $files[4] ?? "Tidak ada",
	    	    'file_ident_direk' => $files[5] ?? "Tidak ada",
	    	    'file_struktur_org' => $files[6] ?? "Tidak ada",
	    	    'file_profile_per' => $files[7] ?? "Tidak ada",
	    	    'file_lain' => $files[8] ?? "Tidak ada",

	    	    'sppkp' => $request->rSppkp,
	    	    'nib_siup' => $request->rNib,
	    	    'akta_perusahaan' => $request->rAkta,
	    	    'pakta_integritas' => $request->rPakta,
	    	    'kartu_identitas_direktur' => $request->rKartu,
	    	    'struktur_organisasi' => $request->rStruktur,
	    	    'profile_perusahaan' => $request->rProfile,
	    	    'surat_lainnya' => $request->rSurat,
                'diisi_oleh' => $requested_by,
                'diterima_oleh' => $request->dDiterima,
                'status' => "3",
                'disetujui_oleh' => $request->dApproved

            ]);
            return redirect('/bss-form/sm/registrasi-supplier');
    }

    public function editRegisSupplier($id)
    {
        $editRequest = DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->find($id);
        return view('SmartForm::bss-form/sm/form-registrasi-supplier', [
            'formData' => $editRequest
        ]);
    }

    public function RubahRegisSupplier(Request $request)
    {
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $id, $nik_session);
        Log::debug("Data edit : ". json_encode($data, JSON_PRETTY_PRINT));
        if($data['data']['diisi_oleh'] != $nik_session) {
            return abort(401, 'Unauthoried Request!');
        } else {
            return view( 'SmartForm::SM/registrasi-supplier/edit-registrasi-supplier', 
                $data,
                ['approvalList' => HrdHelper::getApprovalList()] 
            );
        }
    }

    public function approveSupplier(Request $request)
    {
        $id = $request->query('id');
        $nik_session = $request->session()->get('user_id', '');
        $data = $this->getDetail($request, $id, $nik_session);
        Log::debug("Data edit : ". json_encode($data, JSON_PRETTY_PRINT));
        if($data['data']['diisi_oleh'] != $nik_session) {
            return abort(401, 'Unauthoried Request!');
        } else {
            return view( 'bss-form.sm.registrasi-supplier', compact('data')
            );
        }
    }

    private function getDetail(Request $request, $id, $nik) {
        $TABLE_MASTER = "FM_SM_00X_REGISTRASI_SUPPLIER";
        $isError = true;
        $errorMessage = '';
        // $this->user_sm = $this->getUserSM();
        $data_master = array(
            'id' => '',
            'nama_vendor' => '',
            'no_npwp' => '',
            'bidang_usaha' => '',
            'syarat_pembayaran' => '',
            'ppn' => '',
            'pph' => '',
            'nama_rekening_1' => '',
            'nomor_rekening_1' => '',
            'nama_bank_1' => '',
            'alamat_bank_1' => '',
            'nama_rekening_2' => '',
            'nomor_rekening_2' => '',
            'nama_bank_2' => '',
            'alamat_bank_2' => '',
            'alamat_kantor' => '',
            'kota' => '',
            'telepon' => '',
            'pj_1' => '',
            'pj_2' => '',
            'kode_pos' => '',
            'email' => '',
            'tlp_1' => '',
            'tlp_2' => '',
            'jabatan_1' => '',
            'jabatan_2' => '',
            'jabatan_1_email' => '',
            'jabatan_2_email' => '',
            'diterima_oleh' => '',
            'disetujui_oleh' => '',
            'file_npwp' => '',
            'status_pajak_pkp' => '',
            'metode_pembayaran' => '',
            'npwp' => '',
            'sppkp' => '',
            'nib_siup' => '',
            'akta_perusahaan' => '',
            'pakta_integritas' => '',
            'kartu_identitas_direktur' => '',
            'struktur_organisasi' => '',
            'profile_perusahaan' => '',
            'surat_lainnya' => '',
            'diisi_oleh' => ''
        );
        try {
            $data = DB::table($TABLE_MASTER)
                ->select(
                    'id','nama_vendor','diisi_oleh','no_npwp','bidang_usaha','syarat_pembayaran','ppn','pph',
                    'nama_rekening_1','nomor_rekening_1','nama_bank_1','alamat_bank_1','nama_rekening_2','nomor_rekening_2','nama_bank_2','alamat_bank_2',
                    'alamat_kantor','kota','telepon','pj_1','pj_2','kode_pos','email','tlp_1','tlp_2','jabatan_1','jabatan_2','jabatan_1_email',
                    'jabatan_2_email','diterima_oleh','disetujui_oleh','file_npwp','status_pajak_pkp','metode_pembayaran',
                    'npwp','sppkp','nib_siup','akta_perusahaan','pakta_integritas','kartu_identitas_direktur','struktur_organisasi','profile_perusahaan','surat_lainnya'
                )
                ->where('id', $id)
                ->first();
            if(!is_null($data)) {
                Log::info("id : ". json_encode($data));

                $data_user = DB::connection('sqlsrv2')
                    ->table("TKaryawan")
                    ->select('NIK as nik', 'Nama as nama')
                    ->where("nik", $data->diisi_oleh)
                    ->first();

                $data_master['diisi_oleh'] = $data_user->nik;
                $data_master['nama_vendor'] = $data->nama_vendor;
                $data_master['id'] = $data->id;
                $data_master['no_npwp'] = $data->no_npwp;
                $data_master['bidang_usaha'] = $data->bidang_usaha;
                $data_master['syarat_pembayaran'] = $data->syarat_pembayaran;
                $data_master['ppn'] = $data->ppn;
                $data_master['pph'] = $data->pph;
                $data_master['nama_rekening_1'] = $data->nama_rekening_1;
                $data_master['nomor_rekening_1'] = $data->nomor_rekening_1;
                $data_master['nama_bank_1'] = $data->nama_bank_1;
                $data_master['alamat_bank_1'] = $data->alamat_bank_1;
                $data_master['nama_rekening_2'] = $data->nama_rekening_2;
                $data_master['nomor_rekening_2'] = $data->nomor_rekening_2;
                $data_master['nama_bank_2'] = $data->nama_bank_2;
                $data_master['alamat_bank_2'] = $data->alamat_bank_2;
                $data_master['alamat_kantor'] = $data->alamat_kantor;
                $data_master['kota'] = $data->kota;
                $data_master['telepon'] = $data->telepon;
                $data_master['pj_1'] = $data->pj_1;
                $data_master['pj_2'] = $data->pj_2;
                $data_master['kode_pos'] = $data->kode_pos;
                $data_master['email'] = $data->email;
                $data_master['tlp_1'] = $data->tlp_1;
                $data_master['tlp_2'] = $data->tlp_2;
                $data_master['jabatan_1'] = $data->jabatan_1;
                $data_master['jabatan_2'] = $data->jabatan_2;
                $data_master['jabatan_1_email'] = $data->jabatan_1_email;
                $data_master['jabatan_2_email'] = $data->jabatan_2_email;
                $data_master['diterima_oleh'] = $data->diterima_oleh;
                $data_master['disetujui_oleh'] = $data->disetujui_oleh;
                $data_master['file_npwp'] = $data->file_npwp;
                $data_master['status_pajak_pkp'] = $data->status_pajak_pkp;
                $data_master['metode_pembayaran'] = $data->metode_pembayaran;
                $data_master['npwp'] = $data->npwp;
                $data_master['sppkp'] = $data->sppkp;
                $data_master['nib_siup'] = $data->nib_siup;
                $data_master['akta_perusahaan'] = $data->akta_perusahaan;
                $data_master['pakta_integritas'] = $data->pakta_integritas;
                $data_master['kartu_identitas_direktur'] = $data->kartu_identitas_direktur;
                $data_master['struktur_organisasi'] = $data->struktur_organisasi;
                $data_master['profile_perusahaan'] = $data->profile_perusahaan;
                $data_master['surat_lainnya'] = $data->surat_lainnya;

                $isError = false;
            } else {
                $isError = true;
                $errorMessage = "Data tidak ditemukan!";
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            $errorMessage = $ex->getMessage();
        }
        // $is_user_sm = in_array($request->session()->get('user_id', ''), $this->user_sm);

        return ['error' => $isError, 'errorMessage' => $errorMessage, 'data' => $data_master, 'nik_session' => $nik];
    }

    public function DeleteSupplier(Request $request)
    {
        $nik_session = $request->session()->get('user_id', '');
        $name_session = $request->session()->get('username', '');
        $TABLE_MASTER = "FM_SM_00X_REGISTRASI_SUPPLIER";
        $data = DB::table($TABLE_MASTER)
                    ->select('*')
                    ->where('id', $request->id)
                    ->update([
                            'is_active' => "2",
                            ]);
        return view('SmartForm::SM/registrasi-supplier/dashboard-registrasi-supplier', [
            'nik_session' => $nik_session,
            'name_session' => $name_session]);
    }

    public function PdfRegSupplier(Request $request)
    {
        $data = DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->where('id', $request->id)->first();
        $pdf = PDF::loadView('SmartForm::SM/registrasi-supplier/reg-supplier-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-SM-000.pdf');
    }

    public function updateRegisSupplier(Request $request)
    {
        $nik_session = $request->session()->get('user_id', '');
        $name_session = $request->session()->get('username', '');
        $TABLE_MASTER = "FM_SM_00X_REGISTRASI_SUPPLIER";
        $data = DB::table($TABLE_MASTER)
                    ->select('*')
                    ->where('id', $request->tId)
                    ->update([
                            'nama_vendor' => $request->tVendorName,
                            'no_npwp' => $request->tNoNpwp,
                            ]);

        return view('SmartForm::SM/registrasi-supplier/dashboard-registrasi-supplier', [
            'nik_session' => $nik_session,
            'name_session' => $name_session]);
    }

}
