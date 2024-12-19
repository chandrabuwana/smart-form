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
    protected const T_MASTER_VALIDATOR = 'DB_Dokumen_Mutu.dbo.T_Master_Validator';
    protected const T_DOCO = 'DB_Dokumen_Mutu.dbo.T_Dokumen_Mutu';
    protected const T_PENGAJUAN_DOCO = 'DB_Dokumen_Mutu.dbo.T_Pengajuan_Dokumen_Mutu';
    protected const T_VALIDASI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Validasi_Pengajuan';
    protected const T_VERSI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Versi_Dokumen';
    protected const T_FEEDBACK_VALIDASI = 'DB_Dokumen_Mutu.dbo.T_Feedback_Validasi';
    protected const T_SITE = 'HRD.dbo.tsite';

    protected const THINTANK = [
        '1001384',
        '1003170',
        '1014583',
        '1001114',
        '1001117',
    ];

    public function riwayat(Request $request)
    {
        $departements = DB::table(self::T_DEPARTEMENT)->select('KodeDP', 'Nama')
            ->whereNotNull('Nama')->orderBy('KodeDP', 'ASC')->get();

        return view('DokumenMutu::riwayat-pengajuan.index', [
            'departements' => $departements
        ]);
    }

    public function fetchRiwayat(Request $request)
    {
        $departement    = $request->query('departement', '');
        $site           = $request->query('site', '');
        $status         = $request->query('status', '');
        $jenisDokumen   = $request->query('jenis_dokumen', '');
        $jenisPengajuan = $request->query('jenis_pengajuan', '');
        $tanggal        = $request->query('tanggal', '');
        $offset         = $request->query('offset', 0);
        $limit          = $request->query('limit', 10);

        try {
            $nikLoggedIn = session('user_id');
            $user = DB::table(self::T_KARYAWAN)->select('KodeDP')
                ->where('NIK', $nikLoggedIn)->first();

            $docoNotFiltered = DB::table(self::T_PENGAJUAN_DOCO)->select('id');

            $doco = DB::table(self::T_PENGAJUAN_DOCO)
                ->select(
                    self::T_PENGAJUAN_DOCO . '.id',
                    self::T_PENGAJUAN_DOCO . '.no_dokumen',
                    DB::raw('convert(date, ' . self::T_PENGAJUAN_DOCO . '.created_at) AS tgl_pengajuan'),
                    self::T_DEPARTEMENT . '.Nama AS NamaDepartement',
                    self::T_PENGAJUAN_DOCO . '.kode_site',
                    self::T_PENGAJUAN_DOCO . '.jenis_pengajuan',
                    self::T_PENGAJUAN_DOCO . '.status',
                    self::T_PENGAJUAN_DOCO . '.jenis_dokumen',
                    self::T_PENGAJUAN_DOCO . '.alasan_pengajuan',
                    self::T_KARYAWAN . '.KodeDP',
                    self::T_KARYAWAN . '.KodeST',
                    self::T_JABATAN . '.Nama AS NamaJB'
                )
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
                ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
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
                ->limit($limit)->get()
                ->map( function($item) use($nikLoggedIn, $user) {
                    $item->is_validate = false;

                    if($item->status == 'Belum Validasi' || $item->status == 'Sedang Validasi') {
                        if($item->jenis_pengajuan == 'Penghapusan') {
                            $item->is_validate = $user->KodeDP == 'OD';

                        } else {
                            $site = $item->kode_site == 'JKT' ? 'HO' : 'SITE';
                            $listValidator = DB::table(self::T_MASTER_VALIDATOR)->where('site', $site)
                                ->where('jenis_dokumen', $item->jenis_dokumen)
                                ->orderBy('id', 'ASC')->get();
                            foreach($listValidator as $itemVal) {
                                $validator = strtolower($itemVal->validator);

                                if($validator == 'thinktank' && in_array($nikLoggedIn, self::THINTANK)) {
                                    $item->is_validate = true;
                                } else if(
                                    $validator == 'kadept' &&
                                    $item->KodeDP == $user->KodeDP &&
                                    (preg_match('/kepala department/i', $item->NamaJB) == 1 || preg_match('/kepala departemen/i', $item->NamaJB) == 1)
                                ) {
                                    $item->is_validate = true;
                                } else if($validator == 'od' && $user->KodeDP == 'OD') {
                                    $item->is_validate = true;
                                }
                            }
                        }
                    }

                    if($item->jenis_pengajuan == 'Pembuatan') {
                        $filePath = DB::table(self::T_VERSI_DOCO)->select(self::T_VERSI_DOCO . '.file_path')
                            ->where('id_pengajuan_dokumen', $item->id)
                            ->orderBy('no_versi', 'desc')->first()
                                ->file_path ?? '';
                    }

                    $item->file_path = isset($filePath) ? url('storage/' . $filePath) : '';
                    return $item;
                });

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

    public function indexNomorInduk(Request $request)
    {
        $departements = DB::table(self::T_DEPARTEMENT)->select('KodeDP', 'Nama')
            ->whereNotNull('Nama')->orderBy('KodeDP', 'ASC')->get();

        return view('DokumenMutu::nomor-induk', [
            'departements' => $departements
        ]);
    }

    public function fetchNomorInduk(Request $request)
    {
        $departement    = $request->query('departement', '');
        $site           = $request->query('site', '');
        $status         = $request->query('status', 'Aktif');
        $jenisDokumen   = $request->query('jenis_dokumen', '');
        $keyword        = $request->query('keyword', '');
        $tanggal        = $request->query('tanggal', '');
        $offset         = $request->query('offset', 0);
        $limit          = $request->query('limit', 10);

        try {
            $docoNotFiltered = DB::table(self::T_DOCO)->select('id');

            $doco = DB::table(self::T_DOCO)
                ->select(
                    self::T_DOCO . '.id',
                    self::T_DOCO . '.no_dokumen',
                    DB::raw('convert(date, ' . self::T_DOCO . '.created_at) AS tgl_terbit'),
                    self::T_DEPARTEMENT . '.Nama AS NamaDepartement',
                    self::T_KARYAWAN . '.Nama AS NamaPembuat',
                    self::T_DOCO . '.kode_site',
                    self::T_DOCO . '.jenis_dokumen',
                    self::T_DOCO . '.status'
                )
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_DOCO . '.nik_pembuat')
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

            if(!empty($keyword)) {
                $doco->where( function($q) use($keyword) {
                    return $q->where(self::T_KARYAWAN . '.Nama', 'ilike', '%' . $keyword . '%')
                        ->where(self::T_KARYAWAN . '.NIK', 'ilike', '%' . $keyword . '%');
                });
            }

            if(!empty($tanggal)) {
                $doco->whereDate(self::T_DOCO . '.created_at', $tanggal);
            }

            $rows = $doco->orderBy(self::T_DOCO . '.created_at', 'desc')->offset($offset)
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

    public function detailNomorInduk(Request $request)
    {
        $id = $request->get('id');
        $doco = DB::table(self::T_DOCO)->select(self::T_DOCO . '.*', self::T_SITE . '.Nama AS NamaST', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
            ->join(self::T_SITE, self::T_SITE . '.KodeST', self::T_DOCO . '.kode_site')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_DOCO . '.nik_pembuat')
            ->where('id', $id)->first();

        if(!$doco) {
            return response()->json([]);
        }

        $doco->file_path = url('storage/' . $doco->file_path);
        return response()->json($doco);
    }

    public function detailRiwayat($id)
    {
        $doco = DB::table(self::T_PENGAJUAN_DOCO)->where('id', $id)->first();
        $lastVersion = DB::table(self::T_VERSI_DOCO)->where('id_pengajuan_dokumen', $doco->id)
            ->orderBy('no_versi', 'desc')->first();

        $doco->file_path = url('storage/' . $lastVersion->file_path);

        $validates = DB::table(self::T_VALIDASI_DOCO)
            ->where('id_pengajuan_dokumen', $doco->id)
            ->get('catatan')->pluck('catatan')->all();

        $feedbacks = DB::table(self::T_FEEDBACK_VALIDASI)->select(self::T_FEEDBACK_VALIDASI . '.*', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_FEEDBACK_VALIDASI . '.nik_validator')
            ->where('id_versi', $lastVersion->id)
            ->orderBy('id', 'desc')->get();

        $validateIndex = count($validates);

        return view('DokumenMutu::riwayat-pengajuan.detail', [
            'doco' => $doco,
            'validateIndex' => $validateIndex,
            'catatanValidates' => $validates,
            'feedbacks' => $feedbacks,
            'lastVersion' => $lastVersion
        ]);
    }
}
