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

class RegistrasiSupplierController extends Controller {

    public function download() {
        $pdf = Pdf::loadView('pdf');
 
        return $pdf->download();
    }

    public function RegisSupplierDashboard()
    {
        return view('SmartForm::SM/registrasi-supplier/registrasi-supplier');
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
                ->select('id','nama_vendor','no_npwp');
            
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
        return view("SmartForm::sm/registrasi-supplier/form-registrasi-supplier");
    }
    
    public function CreateRegisSupplier(Request $request)
    {    
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
	    	    'file_npwp' => $files[0],
	    	    'file_sppkp' => $files[1],
	    	    'file_nib_siup' => $files[2],
	    	    'file_akta_perusahaan' => $files[3],
	    	    'file_pakta_integritas' => $files[4],
	    	    'file_ident_direk' => $files[5],
	    	    'file_struktur_org' => $files[6],
	    	    'file_profile_per' => $files[7],
	    	    'file_lain' => $files[8],

	    	    'sppkp' => $request->rSppkp,
	    	    'nib_siup' => $request->rNib,
	    	    'akta_perusahaan' => $request->rAkta,
	    	    'pakta_integritas' => $request->rPakta,
	    	    'kartu_identitas_direktur' => $request->rKartu,
	    	    'struktur_organisasi' => $request->rStruktur,
	    	    'profile_perusahaan' => $request->rProfile,
	    	    'surat_lainnya' => $request->rSurat

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

    public function DeleteSupplier($id)
    {
        DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->where('id', $id)->delete();
        return view('SmartForm::SM/registrasi-supplier/registrasi-supplier');
    }

    public function PdfRegSupplier($id)
    {
        $data = DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::SM/registrasi-supplier/reg-supplier-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-SM-000.pdf');
    }

}
