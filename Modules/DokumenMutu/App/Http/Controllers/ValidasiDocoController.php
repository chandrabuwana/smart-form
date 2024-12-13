<?php

namespace Modules\DokumenMutu\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ValidasiDocoController extends Controller
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

    protected function _isGrantValidate($doco)
    {
        $nikLoggedIn = session('user_id');
        $site = $doco->kode_site == 'JKT' ? 'HO' : 'SITE';
        $result = [
            'validate' => false,
            'index' => -1,
            'validator_type' => ''
        ];

        if($doco->status == 'Belum Validasi' || $doco->status == 'Sedang Validasi') {
            $user = DB::table(self::T_KARYAWAN)->select('KodeDP')
                ->where('NIK', $nikLoggedIn)->first();

            $listValidator = DB::table(self::T_MASTER_VALIDATOR)->where('site', $site)
                ->where('jenis_dokumen', $doco->jenis_dokumen)
                ->orderBy('id', 'ASC')->get();

            $index = 1;
            foreach($listValidator as $itemVal) {
                $validator = strtolower($itemVal->validator);

                if($validator == 'thinktank' && in_array($nikLoggedIn, self::THINTANK)) {
                    $result['validate'] = true;
                    $result['index'] = $index;
                    $result['validator_type'] = $itemVal->jenis_validator;

                } else if(
                    $validator == 'kadept' &&
                    $itemVal->KodeDP == $user->KodeDP &&
                    (preg_match('/kepala department/i', $itemVal->NamaJB) == 1 || preg_match('/kepala departemen/i', $itemVal->NamaJB) == 1)
                ) {
                    $result['validate'] = true;
                    $result['index'] = $index;
                    $result['validator_type'] = $itemVal->jenis_validator;

                } else if($validator == 'od' && $user->KodeDP == 'OD') {
                    $result['validate'] = true;
                    $result['index'] = $index;
                    $result['validator_type'] = $itemVal->jenis_validator;
                }

                $index++;
            }
        }

        return $result;
    }

    public function index($id)
    {
        $doco = DB::table(self::T_PENGAJUAN_DOCO)->find($id);
        if(!$doco) {
            return redirect(route('dokumen-mutu.riwayat-pengajuan'));
        }

        $grant = $this->_isGrantValidate($doco);
        if( !$grant['validate'] ) {
            return redirect(route('dokumen-mutu.riwayat-pengajuan'))->with('error', 'Mohon maaf anda tidak memiliki akses untuk melakukan validasi');
        }

        $lastVersion = DB::table(self::T_VERSI_DOCO)->where('id_pengajuan_dokumen', $doco->id)
            ->orderBy('no_versi', 'desc')->first();

        $doco->file_path = url('storage/' . $lastVersion->file_path);

        $validateIndex = DB::table(self::T_VALIDASI_DOCO)
            ->where('id_pengajuan_dokumen', $doco->id)->count('id');

        $feedbacks = DB::table(self::T_FEEDBACK_VALIDASI)->select(self::T_FEEDBACK_VALIDASI . '.*', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_FEEDBACK_VALIDASI . '.nik_validator')
            ->where('id_versi', $lastVersion->id)
            ->orderBy('id', 'desc')->get();

        $isValidate = ($grant['index'] - 1) == $validateIndex;
        return view('DokumenMutu::validasi.index', [
            'doco' => $doco,
            'validateIndex' => $validateIndex,
            'isValidate' => $isValidate,
            'feedbacks' => $feedbacks,
            'lastVersion' => $lastVersion,
            'validator_type' => $grant['validator_type']
        ]);
    }

    public function approved($id, Request $request)
    {
        DB::beginTransaction();

        $documentValidated = $request->file('dokumenTervalidasi');
        $id = $request->input('id');
        $catatan = $request->input('catatan');
        $validatorType = $request->input('validator_type');

        try {
            $doco = DB::table(self::T_PENGAJUAN_DOCO)->select(self::T_PENGAJUAN_DOCO . '.*', self::T_KARYAWAN . '.KodeDP')
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
                ->where(self::T_PENGAJUAN_DOCO . '.id', $id)->first();

            $lastVersion = DB::table(self::T_VERSI_DOCO)->where('id_pengajuan_dokumen', $doco->id)
                ->orderBy('no_versi', 'desc')->first();

            $prevFilePath = $lastVersion->file_path;
            $path = 'dokumen_mutu/pengajuan/' . $doco->KodeDP;
            $filePath = Storage::disk('public')->put($path, $documentValidated);

            if(file_exists( storage_path('app/public/' . $prevFilePath) )) {
                @unlink(storage_path('app/public/' . $prevFilePath));
            }

            $validateIndex = DB::table(self::T_VALIDASI_DOCO)
                ->where('id_pengajuan_dokumen', $doco->id)->count('id') + 1;

            $site = $doco->kode_site == 'JKT' ? 'HO' : 'SITE';
            $validatorCountAll = DB::table(self::T_MASTER_VALIDATOR)->distinct('jenis_validator')
                ->where('site', $site)
                ->where('jenis_dokumen', $doco->jenis_dokumen)->count('id');

            DB::table(self::T_VALIDASI_DOCO)->insert([
                'id_pengajuan_dokumen' => $doco->id,
                'nik_validator' => session('user_id'),
                'jenis_validasi' => $validatorType,
                'catatan' => $catatan,
                'created_at' => now()
            ]);

            DB::table(self::T_VERSI_DOCO)->where('id', $lastVersion->id)->update([
                'file_path' => $filePath,
                'updated_at' => now()
            ]);

            if($validateIndex >= $validatorCountAll) {
                DB::table(self::T_DOCO)->insert([
                    'kode_site' => $doco->kode_site,
                    'nik_pembuat' => $doco->nik_pemohon,
                    'no_dokumen' => $doco->no_dokumen,
                    'judul_dokumen' => $doco->judul_dokumen,
                    'jenis_dokumen' => $doco->jenis_dokumen,
                    'file_path' => $filePath,
                    'status' => 'Aktif',
                    'created_at' => now(),
                ]);

                DB::table(self::T_PENGAJUAN_DOCO)->where('id', $doco->id)->update([
                    'status' => 'Disetujui'
                ]);

                DB::commit();
                return redirect(route('dokumen-mutu.nomor-induk-dokumen'))->with('success', 'Pengajuan dokumen mutu berhasil terbit!');

            } else if($doco->status == 'Belum Validasi') {
                DB::table(self::T_PENGAJUAN_DOCO)->where('id', $doco->id)->update([
                    'status' => 'Sedang Validasi'
                ]);
            }

            DB::commit();
            return redirect(route('dokumen-mutu.riwayat-pengajuan'))->with('success', 'Approval validasi pengajuan dokumen mutu berhasil!');

        } catch(\Throwable $e) {
            DB::rollBack();
            dd($e);
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }
}
