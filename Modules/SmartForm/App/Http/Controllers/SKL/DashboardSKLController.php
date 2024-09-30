<?php

namespace Modules\SmartForm\App\Http\Controllers\SKL;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
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
    private const T_KARYAWAN = 'HRD.dbo.TKaryawan';
    private const T_JABATAN = 'HRD.dbo.tjabatan';

    public function dashboard()
    {
        $departements = DB::table(self::T_MST_PEKERJAAN)->distinct('KodeDepartement')
            ->select('KodeDP', self::T_DEPARTEMENT . '.Nama AS NamaDepartement')->join(self::T_DEPARTEMENT, self::T_DEPARTEMENT . '.KodeDP', '=', self::T_MST_PEKERJAAN . '.KodeDepartement')
            ->orderBy('KodeDP', 'ASC')->get();

        return view('SmartForm::skl/dashboard', [
            'departements' => $departements
        ]);
    }

    public function getDashboardData(Request $request)
    {
        $departement  = $request->query('departement', '');
        $site    = $request->query('site', '');
        $status   = $request->query('status', '');
        $tanggal   = $request->query('tanggal', '');
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

            if(!empty($departement)) {
                $sklMaster->where('KodeDepartement', $departement);
            }

            if(!empty($site)) {
                $sklMaster->where('KodeST', $site);
            }

            if(!empty($status)) {
                $sklMaster->where('Status', $status);
            }

            if(!empty($tanggal)) {
                $sklMaster->whereDate('TglPelaksanaan', $tanggal);
            }

            $data = $sklMaster->orderBy(self::T_FORM_MST . '.created_at', 'desc')->offset($offset)
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
            return response()->json([
                'total' => 0,
                'totalNotFiltered' => 0,
                'data' => []
            ]);
        }
    }

    public function detail(Request $request)
    {
        $NoForm = $request->query('NoForm');

        $formMasterData = DB::table(self::T_FORM_MST)->where('NoForm', $NoForm)->first();
        if(!$formMasterData) abort(404);

        $formMasterData->karyawans = DB::table(self::T_FORM_KARYAWAN)
            ->select(self::T_FORM_KARYAWAN . '.NIK', self::T_KARYAWAN . '.Panggilan', 'JamMulai', 'JamSelesai', 'TotalJam', self::T_JABATAN . '.Nama AS NamaJabatan')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', '=', self::T_FORM_KARYAWAN . '.NIK')
            ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', '=', self::T_KARYAWAN . '.KodeJB')
            ->where('NoForm', $NoForm)->get();

        $formMasterData->pekerjaans = DB::table(self::T_FORM_PEKERJAAN)
            ->select(self::T_MST_PEKERJAAN . '.Nama AS KategoriPekerjaan', self::T_FORM_PEKERJAAN . '.Detail')
            ->join(self::T_MST_PEKERJAAN, self::T_MST_PEKERJAAN . '.ID', '=', self::T_FORM_PEKERJAAN . '.IDPekerjaan')
            ->where('NoForm', $NoForm)->get();

        $formMasterData->approvers = DB::table(self::T_FORM_APPROVER)
            ->select('Subject', self::T_FORM_APPROVER . '.*', self::T_KARYAWAN . '.Panggilan AS NamaAtasan', 'Status')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', '=', self::T_FORM_APPROVER . '.NIK')
            ->where('NoForm', $NoForm)->get();

        $lastProgressApproval = 0;
        foreach($formMasterData->approvers as $key => $approver) {
            if($approver->Status == 'Approved') {
                $lastProgressApproval = $key;
            }
        }

        return view('SmartForm::skl/detail', [
            'formMaster' => $formMasterData,
            'lastProgressApproval' => $lastProgressApproval
        ]);
    }

    public function storeApproval(Request $request)
    {
        $request->validate([
            'NoForm' => 'required',
            'NIKAtasan' => 'required',
            'Status' => 'required',
        ]);

        DB::beginTransaction();

        try {
            DB::table(self::T_FORM_APPROVER)->where('NoForm', $request->NoForm)->where('NIK', $request->NIKAtasan)->update([
                'Status' => $request->Status,
                'DetailStatus' => $request->Reason ?? null
            ]);

            $approverCount = DB::table(self::T_FORM_APPROVER)->where('NoForm', $request->NoForm)->count();
            $approvedCount = DB::table(self::T_FORM_APPROVER)->where('NoForm', $request->NoForm)
                ->where('Status', 'Approved')->count();

            if($request->Status == 'Approved' && $approvedCount == $approverCount) {
                DB::table(self::T_FORM_MST)->where('NoForm', $request->NoForm)->update([
                    'Status' => 'Approved'
                ]);

            } else if($request->Status == 'Rejected') {
                DB::table(self::T_FORM_MST)->where('NoForm', $request->NoForm)->update([
                    'Status' => 'Rejected'
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil approve pengajuan lembur!',
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
}
