<?php

namespace Modules\SmartForm\App\Http\Controllers\SKL;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SKLFormController extends Controller
{
    private const T_FORM_MST = 'DB_SPL.dbo.TBL_FORM_MST';
    private const T_APPROVER = 'DB_SPL.dbo.TBL_T_APPROVER';
    private const T_FORM_PEKERJAAN = 'DB_SPL.dbo.TBL_FORM_PEKERJAAN';
    private const T_FORM_KARYAWAN = 'DB_SPL.dbo.TBL_FORM_KARYAWAN';
    private const T_MST_PEKERJAAN = 'DB_SPL.dbo.TBL_MST_PEKERJAAN';
    private const T_DEPARTEMENT = 'HRD.dbo.tdepartement';
    private const T_SITE = 'HRD.dbo.tsite';
    private const T_KARYAWAN = 'HRD.dbo.TKaryawan';
    private const T_JABATAN = 'HRD.dbo.tjabatan';
    private const T_FORM_APPROVER = 'DB_SPL.dbo.TBL_FORM_APPROVER';
    private const T_ALARM = 'DB_SPL.dbo.TBL_ALARM_SPL';

    public function create()
    {
        $departements = DB::table(self::T_MST_PEKERJAAN)->distinct('KodeDepartement')
            ->select('KodeDP', self::T_DEPARTEMENT . '.Nama AS NamaDepartement')->join(self::T_DEPARTEMENT, self::T_DEPARTEMENT . '.KodeDP', '=', self::T_MST_PEKERJAAN . '.KodeDepartement')
            ->orderBy('KodeDP', 'ASC')->get();

        // $sites = DB::table(self::T_SITE)->select('KodeST', 'Nama')
        //     ->orderBy('Nama', 'asc')->get();

        return view('SmartForm::skl/form', [
            'departements' => $departements,
            // 'sites' => $sites
        ]);
    }

    public function getKaryawan(Request $request)
    {
        $kodeDP = $request->get('KodeDP');
        $kodeST = $request->get('KodeST');

        return DB::table(self::T_KARYAWAN)->select('NIK AS id', 'Panggilan AS text', self::T_JABATAN . '.Nama AS jabatan')
            ->distinct('NIK')
            ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', '=', self::T_KARYAWAN . '.KodeJB')
            ->when(!empty($kodeDP), fn($q) => $q->where('KodeDP', $kodeDP))
            ->when(!empty($kodeST), fn($q) => $q->where('KodeST', $kodeST))
            ->where('Panggilan', '!=', '')
            ->where('AKTIF', '0')
            ->orderBy('Panggilan', 'ASC')->get();
    }

    public function getKategoriPekerjaan(Request $request)
    {
        $kodeDP = $request->get('KodeDP');

        return DB::table(self::T_MST_PEKERJAAN)->select('ID as id', 'Nama AS text')
            ->where('KodeDepartement', $kodeDP)->orderBy('Nama', 'ASC')->get();
    }

    public function getApprover(Request $request)
    {
        $kodeDP = $request->get('KodeDP');
        $kodeST = $request->get('KodeST');

        return [
            [
                'subject' => 'Diketahui Oleh',
                'jabatan' => 'Kabag. Departemen',
                'option_atasan' => DB::table(self::T_APPROVER)
                    ->select('Nik', 'Nama')->distinct('Nik')
                    ->where('Site', $kodeST)->where('Departement', $kodeDP)
                    ->where('jabatan', 'like', '%Kepala Bagian%')
                    ->orderBy('Nama', 'asc')->get(),
                'option_backup' => DB::table(self::T_APPROVER)
                    ->select('Nik', 'Nama')->distinct('Nik')
                    ->where('Site', $kodeST)->where('Departement', $kodeDP)
                    ->where('jabatan', 'like', '%Kepala Seksi%')
                    ->orderBy('Nama', 'asc')->get()
            ],
            [
                'subject' => 'Diketahui Oleh',
                'jabatan' => 'Cost Controll',
                'option_atasan' => DB::table(self::T_APPROVER)
                    ->select('Nik', 'Nama')->distinct('Nik')
                    ->where('Site', $kodeST)
                    ->where('jabatan', 'like', '%Cost Control%')
                    ->orderBy('Nama', 'asc')->get(),
                'option_backup' => DB::table(self::T_APPROVER)
                    ->select('Nik', 'Nama')->distinct('Nik')
                    ->where('jabatan', 'like', '%Cost Control%')
                    ->orderBy('Nama', 'asc')->get()
            ],
            [
                'subject' => 'Disetujui Oleh',
                'jabatan' => 'Departemen IC',
                'option_atasan' => DB::table(self::T_APPROVER)
                    ->select('Nik', 'Nama')->distinct('Nik')
                    ->where('Site', $kodeST)->where('Departement', 'ICGS')
                    ->orderBy('Nama', 'asc')->get(),
                'option_backup' => DB::table(self::T_APPROVER)
                    ->select('Nik', 'Nama')->distinct('Nik')
                    ->where('Departement', 'ICGS')
                    ->orderBy('Nama', 'asc')->get(),
            ],
        ];
    }

    private function _genNoForm(Request $request)
    {
        $dataLength = DB::table(self::T_FORM_MST)->count('NoForm');
        $newNumbering = $dataLength + 1;
        $monthInRoman = Helper::numberToRomanRepresentation(date('n'));
        $year = date('Y');

        return str_pad($newNumbering, 5, '0', STR_PAD_LEFT) . "/IC/{$request->inputSite}/SKL/{$monthInRoman}/{$year}";
    }

    public function store(Request $request)
    {
        $now = now()->toDateTimeString();
        $userid = session('user_id');
        $requestAll = $request->all();
        $NoForm = $this->_genNoForm($request);

        try {
            DB::table(self::T_FORM_MST)->insert([
                'NoForm' => $NoForm,
                'NoDok' => $request->noDok,
                'Revisi' => $request->revisi,
                'KodeDepartement' => $request->inputDepartement,
                'KodeST' => $request->inputSite,
                'TglPelaksanaan' => $request->tglPelaksanaan,
                'Shift' => $request->inputShift,
                'Status' => 'Dalam Review',
                'HariKeTujuh' => $request->hariKeTujuh ? '1' : '0',
                'created_at' => $now,
                'created_by' => $userid,
            ]);

            foreach($request->nikKaryawan as $key => $nikKaryawan) {
                $jamMulai = $requestAll['jamMulai'][$key];
                $jamSelesai = $requestAll['jamSelesai'][$key];
                $totalJam = $requestAll['totalJam'][$key];

                DB::table(self::T_FORM_KARYAWAN)->insert([
                    'NoForm' => $NoForm,
                    'NIK' => $nikKaryawan,
                    'JamMulai' => $jamMulai,
                    'JamSelesai' => $jamSelesai,
                    'TotalJam' => $totalJam
                ]);
            }

            foreach($request->kategoriPekerjaan as $key => $kategoriPekerjaan) {
                $detailPekerjaan = $requestAll['detailPekerjaan'][$key];

                DB::table(self::T_FORM_PEKERJAAN)->insert([
                    'NoForm' => $NoForm,
                    'IDPekerjaan' => $kategoriPekerjaan,
                    'Detail' => $detailPekerjaan
                ]);
            }

            // atasan langsung
            DB::table(self::T_FORM_APPROVER)->insert([
                'NoForm' => $NoForm,
                'NIK' => session('user_id'),
                'Subject' => 'Dibuat Oleh',
                'Jabatan' => 'Atasan Langsung',
                'Status' => 'Approved'
            ]);

            foreach($request->inputAtasan as $key => $nikAtasan) {
                $subjectAtasan = $requestAll['subjectAtasan'][$key];
                $jabatanAtasan = $requestAll['jabatanAtasan'][$key];

                DB::table(self::T_FORM_APPROVER)->insert([
                    'NoForm' => $NoForm,
                    'NIK' => $nikAtasan,
                    'Subject' => $subjectAtasan,
                    'Jabatan' => $jabatanAtasan,
                    'Status' => 'Menunggu'
                ]);

                DB::table(self::T_ALARM)->insert([
                    'NIK' => $nikAtasan,
                    'Message' => "Pengajuan lembur baru dengan nomor : {$NoForm}",
                    'Status' => 'Pending'
                ]);
            }

            DB::commit();
            return redirect(route('bss-skl.dashboard'));

        } catch (Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            return redirect(route('bss-skl.create'))->with('err', 'Terjadi kesalahan pada sistem');
        }
    }
}
