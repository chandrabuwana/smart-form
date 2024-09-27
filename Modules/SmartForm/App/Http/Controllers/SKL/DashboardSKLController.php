<?php

namespace Modules\SmartForm\App\Http\Controllers\SKL;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DashboardSKLController extends Controller
{
    private const T_FORM_MST = 'DB_SPL.dbo.TBL_FORM_MST';
    private const T_APPROVER = 'DB_SPL.dbo.TBL_T_APPROVER';
    private const T_FORM_PEKERJAAN = 'DB_SPL.dbo.TBL_FORM_PEKERJAAN';
    private const T_FORM_KARYAWAN = 'DB_SPL.dbo.TBL_FORM_KARYAWAN';
    private const T_MST_PEKERJAAN = 'DB_SPL.dbo.TBL_MST_PEKERJAAN';
    private const T_DEPARTEMENT = 'HRD.dbo.tdepartement';
    private const T_SITE = 'HRD.dbo.tsite';
    private const T_FORM_APPROVER = 'DB_SPL.dbo.TBL_FORM_APPROVER';

    public function dashboard()
    {
        return view('SmartForm::skl/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'created_at');
        $order   = $request->query('order', 'asc');
        $offset  = $request->query('offset', 0);
        $limit   = $request->query('limit', 10);

        try {
            $sklMasterNotFiltered = DB::table(self::T_FORM_MST)->select('id');

            $sklMaster = DB::table(self::T_FORM_MST)
                ->select(
                    self::T_FORM_MST . '.NoForm',
                    self::T_FORM_MST . '.TglPelaksanaan',
                    self::T_FORM_MST . '.Shift',
                    self::T_FORM_MST . '.Status',
                    self::T_FORM_MST . '.KodeDepartement',
                    self::T_FORM_MST . '.KodeST'
                );

            // if(!empty($search)) {
            //     $sklMaster->where('role_name', 'like', '%' . $search . '%');
            // }

            $data = $sklMaster->orderBy(self::T_FORM_MST . '.' . $sort, $order)->offset($offset)
                ->limit($limit);

            $rows = $data->get()->map( function($item) {
                $item->NamaDepartement = DB::table(self::T_DEPARTEMENT)
                    ->select('Nama')->where('KodeDP', $item->KodeDepartement)->first()->Nama;

                $approver = DB::table(self::T_FORM_APPROVER)->select('Status')
                    ->where('NoForm', $item->NoForm)->get();

                if($item->Status == 'Approved') {
                    $item->ApprovalProgress = $approver->count() . '/' . $approver->count();

                } else {
                    $approvedCount = 0;
                    foreach($approver as $appr) {
                        if($appr->Status == 'Approved') {
                            $approvedCount++;
                        }
                    }

                    $item->ApprovalProgress = $approvedCount . '/' . $approver->count();
                }

                return $item;
            });

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $sklMasterNotFiltered->count(),
                'data' => $rows
            ]);

        } catch (Exception $ex) {
            dd($ex);
            return response()->json([
                'total' => 0,
                'totalNotFiltered' => 0,
                'data' => []
            ]);
        }
    }
}
