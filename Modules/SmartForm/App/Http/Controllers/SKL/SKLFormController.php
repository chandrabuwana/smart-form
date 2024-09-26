<?php

namespace Modules\SmartForm\App\Http\Controllers\SKL;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
            ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', '=', self::T_KARYAWAN . '.KodeJB')
            ->when(!empty($kodeDP), fn($q) => $q->where('KodeDP', $kodeDP))
            ->when(!empty($kodeST), fn($q) => $q->where('KodeST', $kodeST))
            ->where('Panggilan', '!=', '')
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
        $response = [
            [
                'subject' => 'Diketahui Oleh',
                'jabatan' => 'Kabag. Departemen',
                'option_atasan' => [],
            ],
            [
                'subject' => 'Diketahui Oleh',
                'jabatan' => 'Cost Controll',
                'option_atasan' => [],
            ],
            [
                'subject' => 'Diketahui Oleh',
                'jabatan' => 'Departemen IC',
                'option_atasan' => [],
            ],
        ];

        return array_map(function($item) {
            $jabatan = strtr($item['jabatan'], [
                'Kabag. Departemen' => 'Kepala Bagian',
                'Cost Controll' => 'Cost Control',
                'Departemen IC' => 'ICGS',
            ]);

            $item['option_atasan'] = DB::table(self::T_APPROVER)->select('Nik', 'Nama')
                ->where('');

            return $item;
        }, $response);
    }
}
