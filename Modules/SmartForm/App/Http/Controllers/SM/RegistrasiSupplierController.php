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
        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->insert([
                // 'nama' => session("username"),
                'nama_vendor' => $requestData['tVendorName'],
                'no_npwp' => $requestData['tNoNpwp']
                // 'nik' => session("user_id"),

            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data form Registrasi Supplier!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function editRegisSupplier($id)
    {
        $editRequest = DB::table('FM_SM_00X_REGISTRASI_SUPPLIER')->find($id);
        return view('SmartForm::bss-form/sm/form-registrasi-supplier', [
            'formData' => $editRequest
        ]);
    }

    public function DeleteReqFuel($id)
    {
        DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $id)->delete();
        return view('SmartForm::LOG/request-fuel');
    }

    public function PdfReqFuel($id)
    {
        $data = DB::table('FM_LOG_022_PERMINTAAN_PENGISIAN_FUEL')->where('id', $id)->first();
        $pdf = PDF::loadView('SmartForm::LOG/req-fuel-pdf',  compact('data'));

        return $pdf->download('BSS-FRM-LOG-022.pdf');
    }

}
