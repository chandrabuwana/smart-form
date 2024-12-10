<?php

namespace Modules\DokumenMutu\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DocoController extends Controller
{
    protected const T_KARYAWAN = 'HRD.dbo.TKaryawan';
    protected const T_JABATAN = 'HRD.dbo.tjabatan';
    protected const T_DEPARTEMENT = 'HRD.dbo.tdepartement';
    protected const T_DOCO = 'DB_Dokumen_Mutu.dbo.T_Dokumen_Mutu';
    protected const T_PENGAJUAN_DOCO = 'DB_Dokumen_Mutu.dbo.T_Pengajuan_Dokumen_Mutu';
    protected const T_VALIDASI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Validasi_Pengajuan';
    protected const T_VERSI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Versi_Dokumen';
    protected const T_FEEDBACK_VALIDASI = 'DB_Dokumen_Mutu.dbo.T_Feedback_Validasi';
    protected const T_SITE = 'HRD.dbo.tsite';

    public function riwayat(Request $request)
    {
        $departements = DB::table(self::T_DEPARTEMENT)->select('KodeDP', 'Nama')
            ->whereNotNull('Nama')->orderBy('KodeDP', 'ASC')->get();

        return view('DokumenMutu::riwayat-pengajuan', [
            'departements' => $departements
        ]);
    }

    public function fetchRiwayat(Request $request)
    {
        $departement    = $request->query('departement', '');
        $departement    = $request->query('departement', '');
        $site           = $request->query('site', '');
        $status         = $request->query('status', '');
        $jenisDokumen   = $request->query('jenis_dokumen', '');
        $jenisPengajuan = $request->query('jenis_pengajuan', '');
        $tanggal        = $request->query('tanggal', '');
        $offset         = $request->query('offset', 0);
        $limit          = $request->query('limit', 10);

        try {
            $docoNotFiltered = DB::table(self::T_PENGAJUAN_DOCO)->select('id');

            $doco = DB::table(self::T_PENGAJUAN_DOCO)
                ->select(
                    self::T_PENGAJUAN_DOCO . '.no_dokumen',
                    DB::raw('convert(date, ' . self::T_PENGAJUAN_DOCO . '.created_at) AS tgl_pengajuan'),
                    self::T_DEPARTEMENT . '.Nama AS NamaDepartement',
                    self::T_PENGAJUAN_DOCO . '.kode_site',
                    self::T_PENGAJUAN_DOCO . '.jenis_pengajuan',
                    self::T_PENGAJUAN_DOCO . '.status'
                )
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
                ->join(self::T_DEPARTEMENT, self::T_DEPARTEMENT . '.KodeDP', self::T_KARYAWAN . '.KodeDP');

            if(!empty($departement)) {
                $doco->where('KodeDP', $departement);
            }

            if(!empty($site)) {
                $doco->where('kode_site', $site);
            }

            if(!empty($status)) {
                $doco->where('Status', $status);
            }

            if(!empty($jenisDokumen)) {
                $doco->where('jenis_dokumen', $jenisDokumen);
            }

            if(!empty($jenisPengajuan)) {
                $doco->where('jenis_pengajuan', $jenisPengajuan);
            }

            if(!empty($tanggal)) {
                $doco->whereDate(self::T_PENGAJUAN_DOCO . '.created_at', $tanggal);
            }

            $rows = $doco->orderBy(self::T_PENGAJUAN_DOCO . '.created_at', 'desc')->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $rows->count(),
                'totalNotFiltered' => $docoNotFiltered->count(),
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
}
