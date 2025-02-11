<?php

namespace Modules\SmartForm\App\Http\Controllers\SKL;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Helper;

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
    private const T_FORM_BA_PEKERJAAN = 'DB_SPL.dbo.TBL_FORM_BA_PEKERJAAN';
    private const V_JAM_KONVERSI = 'DB_SPL.dbo.VW_Jam_Konversi_SPL';

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
                'total' => $rows->count(),
                'totalNotFiltered' => $sklMasterNotFiltered->count(),
                'rows' => $rows
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
            ->where('NoForm', $NoForm)
            ->get()->map( function($item) use($NoForm) {
                $viewSklData = DB::table(self::V_JAM_KONVERSI)->where('NoForm', $NoForm)
                    ->where('NIK', $item->NIK)->first();

                $item->JamAbsensi = $viewSklData->JamAbsensi ?? '';
                $item->TotalKonversi = ($viewSklData->total_konversi_jam ?? '') . ' jam';

                return $item;
            });

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

        $formMasterData->baPekerjaan = DB::table(self::T_FORM_BA_PEKERJAAN)
            ->where('NoForm', $NoForm)->first();

        return view('SmartForm::skl/detail', [
            'formMaster' => $formMasterData,
            'lastProgressApproval' => $lastProgressApproval,
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

    public function downloadExcel(Request $request)
    {
        $userid = session('user_id');
        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();

        $departement  = $request->query('departement', '');
        $site    = $request->query('site', '');
        $status   = $request->query('status', '');
        $tanggal   = $request->query('tanggal', '');

        $headers = [
            'No. Form',
            'Departement',
            'Site',
            'Shift',
            'Nama',
            'NIK',
            'Jabatan',
            'Kategori Pekerjaan',
            'Detail Pekerjaan',
            'Jam Mulai',
            'Jam Selesai',
            'Total Konversi',
            'Tanggal',
        ];

        foreach(range('A', 'M') as $key => $column) {
            $worksheet->getColumnDimension($column)->setAutoSize(true);

            $cellStyle = $worksheet->getStyle($column . '1');
            $cellStyle->getFont()->setBold(true);
            $cellStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

            $worksheet->getCell($column . '1')->setValue( $headers[$key] );
        }

        $qExport = DB::table(self::T_FORM_KARYAWAN)->select(
                self::T_FORM_MST . '.NoForm',
                DB::raw('CONVERT(DATE, ' . self::T_FORM_MST . '.created_at) AS created_date'),
                self::T_DEPARTEMENT . '.Nama AS NamaDP',
                self::T_SITE . '.Nama AS NamaSite',
                self::T_FORM_MST . '.Shift',
                self::T_KARYAWAN . '.Nama AS NamaKaryawan',
                self::T_KARYAWAN . '.NIK',
                self::T_JABATAN . '.Nama AS NamaJabatan',
                // self::T_MST_PEKERJAAN . '.Nama AS NamaPekerjaan',
                // self::T_FORM_PEKERJAAN . '.Detail AS DetailPekerjaan',
                self::V_JAM_KONVERSI . '.JamMulai',
                self::V_JAM_KONVERSI . '.fix_absen_out AS JamSelesai',
                self::V_JAM_KONVERSI . '.total_konversi_jam AS TotalKonversi',
                self::T_KARYAWAN . '.KodeDP'
            )
            // ->distinct(self::V_JAM_KONVERSI . '.NoForm', self::V_JAM_KONVERSI . '.NIK')
            ->join(self::V_JAM_KONVERSI, function($q) {
                $q->on(self::V_JAM_KONVERSI . '.NIK', '=', self::T_FORM_KARYAWAN . '.NIK')
                    ->on(self::V_JAM_KONVERSI . '.NoForm', '=', self::T_FORM_KARYAWAN . '.NoForm');
            })
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', '=', self::T_FORM_KARYAWAN . '.NIK')
            ->join(self::T_FORM_MST, self::T_FORM_MST . '.NoForm', '=', self::T_FORM_KARYAWAN . '.NoForm')
            ->join(self::T_SITE, self::T_SITE . '.KodeST', '=', self::T_KARYAWAN . '.KodeST')
            ->join(self::T_DEPARTEMENT, self::T_DEPARTEMENT . '.KodeDP', '=', self::T_KARYAWAN . '.KodeDP')
            ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', '=', self::T_KARYAWAN . '.KodeJB');
            // ->join(self::T_MST_PEKERJAAN, self::T_MST_PEKERJAAN . '.KodeDepartement', '=', self::T_KARYAWAN . '.KodeDP')
            // ->join(self::T_FORM_PEKERJAAN, function($q) {
            //     $q->on(self::T_FORM_PEKERJAAN . '.NoForm', '=', self::T_FORM_MST . '.NoForm')
            //         ->on(self::T_FORM_PEKERJAAN . '.IDPekerjaan', '=', self::T_MST_PEKERJAAN . '.ID');
            // });

        if(!empty($departement)) {
            $qExport->where(self::T_FORM_MST . '.KodeDepartement', $departement);
        }

        if(!empty($site)) {
            $qExport->where(self::T_FORM_MST . '.KodeST', $site);
        }

        if(!empty($status)) {
            $qExport->where(self::T_FORM_MST . '.Status', $status);
        }

        if(!empty($tanggal) && Helper::validateDateFormat('Y-m-d', $tanggal)) {
            $qExport->whereDate(self::T_FORM_MST . '.TglPelaksanaan', $tanggal);
        }

        $dataExport = $qExport->orderBy(self::T_FORM_MST . '.created_at', 'DESC')->get();
        // dd($dataExport);
        $i = 2;

        foreach($dataExport as $item) {
            $isApprovedForm = DB::table(self::T_FORM_APPROVER)->where('NoForm', $item->NoForm)
                ->where('status', 'Approved')->count('ID');
            if($isApprovedForm < 4) {
                continue;
            }

            $pekerjaan = DB::table(self::T_FORM_PEKERJAAN)->select(self::T_MST_PEKERJAAN . '.Nama', self::T_FORM_PEKERJAAN . '.Detail')
                ->join(self::T_MST_PEKERJAAN, self::T_MST_PEKERJAAN . '.ID', '=', self::T_FORM_PEKERJAAN . '.IDPekerjaan')
                ->where('NoForm', $item->NoForm)->where('KodeDepartement', $item->KodeDP)->get();

            $worksheet->getCell('A' . $i)->setValue($item->NoForm);
            $worksheet->getCell('B' . $i)->setValue($item->NamaDP);
            $worksheet->getCell('C' . $i)->setValue($item->NamaSite);
            $worksheet->getCell('D' . $i)->setValue($item->Shift);
            $worksheet->getCell('E' . $i)->setValue($item->NamaKaryawan);
            $worksheet->getCell('F' . $i)->setValue($item->NIK);
            $worksheet->getCell('G' . $i)->setValue($item->NamaJabatan);
            $worksheet->getCell('H' . $i)->setValue( implode("\n", $pekerjaan->pluck('Nama')->all()) );
            $worksheet->getCell('I' . $i)->setValue( implode("\n", $pekerjaan->pluck('Detail')->all()) );
            $worksheet->getCell('J' . $i)->setValue($item->JamMulai);
            $worksheet->getCell('K' . $i)->setValue($item->JamSelesai);
            $worksheet->getCell('L' . $i)->setValue($item->TotalKonversi);
            $worksheet->getCell('M' . $i)->setValue($item->created_date);

            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Report SKL.xlsx"');
        $writer->save('php://output');
    }
}
