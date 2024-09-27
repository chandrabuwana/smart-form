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

    public function dashboard()
    {
        return view('SmartForm::skl/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'id');
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
                    DB::raw('COUNT(' . self::T_FORM_KARYAWAN . '.ID) AS TotalKaryawan'),
                    DB::raw('COUNT(' . self::T_FORM_PEKERJAAN . '.ID) AS TotalPekerjaan')
                )
                ->join(self::T_FORM_KARYAWAN, self::T_FORM_KARYAWAN . '.NoForm', '=', self::T_FORM_MST . '.NoForm')
                ->join(self::T_FORM_PEKERJAAN, self::T_FORM_PEKERJAAN . '.NoForm', '=', self::T_FORM_MST . '.NoForm')
                ->groupBy(['NoForm', 'TglPelaksanaan', 'Shift', 'Status']);

            // if(!empty($search)) {
            //     $sklMaster->where('role_name', 'like', '%' . $search . '%');
            // }

            $data = $sklMaster->orderBy(self::T_FORM_MST . '.' . $sort, $order)->offset($offset)
                ->limit($limit);

            $rows = $data->get()->map( function($item) {
                $item->NamaDepartement = DB::table(self::T_DEPARTEMENT)
                    ->select('Nama')->where('KodeDP', $item->KodeDepartement)->first()->Nama;

                $item->NamaSite = DB::table(self::T_SITE)
                    ->select('Nama')->where('KodeST', $item->KodeST)->first()->Nama;

                return $item;
            });

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $sklMasterNotFiltered->count(),
                'rows' => $rows
            ]);

        } catch (Exception $ex) {
            return response()->json([
                'total' => 0,
                'totalNotFiltered' => 0,
                'rows' => []
            ]);
        }
    }
}
