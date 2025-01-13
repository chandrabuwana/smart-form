<?php

namespace Modules\DokumenMutu\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\SmartForm\Service\AlarmAPIService;
use Mpdf\Mpdf;

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
    protected const T_OVERDUE_VALIDASI = 'DB_Dokumen_Mutu.dbo.T_Overdue_Validasi';

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

        if(in_array($doco->status, ['Belum Validasi', 'Sedang Validasi', 'Terdapat Feedback'])) {
            $user = DB::table(self::T_KARYAWAN)->select('KodeDP', self::T_JABATAN . '.Nama AS NamaJB')
                ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
                ->where('NIK', $nikLoggedIn)->first();

            $listValidator = DB::table(self::T_MASTER_VALIDATOR)->where('site', $site)
                ->where('jenis_dokumen', $doco->jenis_dokumen)
                ->orderBy('id', 'ASC')->get();

            $indexValidator = [];
            foreach($listValidator as $itemVal) {
                $validator = strtolower($itemVal->validator);

                if(!in_array($itemVal->validator, $indexValidator)) {
                    $indexValidator[] = $itemVal->validator;
                }

                if($validator == 'thinktank' && in_array($nikLoggedIn, self::THINTANK)) {
                    $result['validate'] = true;
                    $result['index'] = count($indexValidator);
                    $result['validator_type'] = $itemVal->jenis_validator;

                } else if(
                    $validator == 'kadept' &&
                    $doco->KodeDP == $user->KodeDP &&
                    (preg_match('/kepala department/i', $user->NamaJB) == 1 || preg_match('/kepala departemen/i', $user->NamaJB) == 1)
                ) {
                    $result['validate'] = true;
                    $result['index'] = count($indexValidator);
                    $result['validator_type'] = $itemVal->jenis_validator;

                } else if($validator == 'od' && $user->KodeDP == 'OD' && preg_match('/^staff/i', $user->NamaJB)) {
                    $result['validate'] = true;
                    $result['index'] = count($indexValidator);
                    $result['validator_type'] = $itemVal->jenis_validator;
                }
            }
        }

        return $result;
    }

    public function index($id, Request $request)
    {
        $doco = DB::table(self::T_PENGAJUAN_DOCO)->select(self::T_PENGAJUAN_DOCO . '.*', self::T_KARYAWAN . '.KodeDP')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
            ->where('id', $id)->first();
        if(!$doco) {
            return redirect(route('dokumen-mutu.riwayat-pengajuan'));
        }

        $versionNo = $request->get('v');
        $grant = $this->_isGrantValidate($doco);

        if( !$grant['validate'] ) {
            return redirect(route('dokumen-mutu.riwayat-pengajuan'))->with('error', 'Mohon maaf anda tidak memiliki akses untuk melakukan validasi');
        }

        $versions = DB::table(self::T_VERSI_DOCO)->where('id_pengajuan_dokumen', $doco->id)
            ->orderBy('no_versi', 'asc')->get();

        if(!empty($versionNo)) {
            $lastVersion = $versions->filter( fn($item) => $item->no_versi == $versionNo );
            if($lastVersion->count() == 0) {
                abort(404);
            }

            $lastVersion = $lastVersion->first();
        } else {
            $lastVersion = $versions->last();
        }

        $doco->file_path = url('storage/' . $lastVersion->file_path);
        $validateIndex = DB::table(self::T_VALIDASI_DOCO)
            ->where('id_pengajuan_dokumen', $doco->id)->count('id');

        $tKaryawan = DB::table(self::T_KARYAWAN)->select('Nama')
            ->where('NIK', session('user_id'))->first();

        $isValidate = ($grant['index'] - 1) == $validateIndex;
        $isOverdue = strtotime('now') > strtotime($doco->due_date);

        return view('DokumenMutu::validasi.index', [
            'doco' => $doco,
            'validateIndex' => $validateIndex,
            'isValidate' => $isValidate,
            'isOverdue' => $isOverdue,
            'lastVersion' => $lastVersion,
            'tKaryawan' => $tKaryawan,
            'validator_type' => $grant['validator_type'],
            'versions' => $versions
        ]);
    }

    public function approved($id, Request $request)
    {
        DB::beginTransaction();

        $documentValidated = $request->file('dokumenTervalidasi');
        $id = $request->input('id');
        $catatan = $request->input('catatan');
        $keteranganOverdue = $request->input('catatan_overdue');
        $validatorType = $request->input('validator_type');

        try {
            $doco = DB::table(self::T_PENGAJUAN_DOCO)->select(self::T_PENGAJUAN_DOCO . '.*', self::T_KARYAWAN . '.Nama AS NamaKaryawan', self::T_KARYAWAN . '.KodeDP')
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
                ->where(self::T_PENGAJUAN_DOCO . '.id', $id)->first();

            $lastVersion = DB::table(self::T_VERSI_DOCO)->where('id_pengajuan_dokumen', $doco->id)
                ->orderBy('no_versi', 'desc')->first();

            $prevFilePath = $lastVersion->file_path;
            $originalName = $documentValidated->getClientOriginalName();
            $path = 'dokumen_mutu/pembuatan/' . $doco->KodeDP;

            if(file_exists( storage_path('app/public/' . $prevFilePath) )) {
                @unlink(storage_path('app/public/' . $prevFilePath));
            }

            $filePath = $documentValidated->storeAs($path, $originalName);

            $validate = DB::table(self::T_VALIDASI_DOCO)
                ->distinct('jenis_validasi')
                ->where('id_pengajuan_dokumen', $doco->id)->get();

            $validateIndex = $validate->count() + 1;
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

            if(!empty($keteranganOverdue)) {
                DB::table(self::T_OVERDUE_VALIDASI)->insert([
                    'id_pengajuan_dokumen' => $id,
                    'jenis_validasi' => $validatorType,
                    'nik_validator' => session('user_id'),
                    'keterangan' => $keteranganOverdue,
                    'created_at' => now(),
                ]);
            }

            DB::table(self::T_VERSI_DOCO)->where('id', $lastVersion->id)->update([
                'file_path' => $filePath,
                'updated_at' => now()
            ]);

            if($validateIndex >= $validatorCountAll) {
                if($doco->jenis_pengajuan == 'Revisi') {
                    $docoInduk = DB::table(self::T_DOCO)
                        ->where('no_dokumen', $doco->no_dokumen)
                        ->where('status', 'Aktif')
                        ->first();

                    $noRevisi = empty($docoInduk->no_revisi) ? 1 : ($docoInduk->no_revisi + 1);

                    DB::table(self::T_DOCO)->where('id', $docoInduk->id)->update([
                        'status' => 'Kadaluarsa',
                        'keterangan_kadaluarsa' => 'Dokumen berikut telah di revisi ke nomor ' . $noRevisi . ' dengan keterangan : ' . $doco->alasan_pengajuan,
                        'updated_at' => now()
                    ]);

                    DB::table(self::T_DOCO)->insert([
                        'kode_site' => $doco->kode_site,
                        'nik_pembuat' => $doco->nik_pemohon,
                        'no_dokumen' => $doco->no_dokumen,
                        'judul_dokumen' => $doco->judul_dokumen,
                        'jenis_dokumen' => $doco->jenis_dokumen,
                        'file_path' => $filePath,
                        'status' => 'Aktif',
                        'no_revisi' => $noRevisi,
                        'created_at' => now(),
                    ]);

                } else {
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
                }

                DB::table(self::T_PENGAJUAN_DOCO)->where('id', $doco->id)->update([
                    'status' => 'Disetujui',
                    'updated_at' => now()
                ]);

                DB::commit();
                return redirect(route('dokumen-mutu.nomor-induk-dokumen'))->with('success', 'Pengajuan dokumen mutu berhasil terbit!');

            } else {
                DB::table(self::T_PENGAJUAN_DOCO)->where('id', $doco->id)->update([
                    'status' => 'Sedang Validasi'
                ]);

                $nextValidator = DB::table(self::T_MASTER_VALIDATOR)
                    ->where('site', $site)->where('jenis_dokumen', $doco->jenis_dokumen)
                    ->whereNotIn('jenis_validator', $validate->pluck('jenis_validasi')->all() )
                    ->orderBy('id', 'asc')->first();

                if($nextValidator) {
                    switch(strtolower($nextValidator->validator)) {
                        case 'thinktank':
                            $phones = DB::table(self::T_KARYAWAN)->select('Telp')
                                ->whereIn('NIK', self::THINTANK)->get()
                                ->pluck('Telp')->filter( fn($phone) => !empty($phone))->all();
                            break;

                        case 'kadept':
                            $phones = DB::table(self::T_KARYAWAN)->select('Telp')
                                ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
                                ->where( function($q) use($nextValidator) {
                                    if($nextValidator->responsibilitas == 'HO') {
                                        $q->where('KodeST', 'JKT');
                                    }
                                })
                                ->where('KodeDP', $doco->KodeDP)
                                ->where( function($q) {
                                    return $q->where(self::T_JABATAN . '.Nama', 'like', '%kepala department%')
                                        ->orWhere(self::T_JABATAN . '.Nama', 'like', '%kepala departemen%');
                                })
                                ->get()->pluck('Telp')
                                ->filter( fn($phone) => !empty($phone))->all();
                            break;

                        case 'od':
                            $phones = [ env('DOCO_ALARM_OD') ];
                            break;

                        default:
                            $phones = [];
                    }

                    if(count($phones) > 0) {
                        $date = date('Y-m-d', strtotime($doco->created_at));
                        $url = route('dokumen-mutu.validasi.index', ['id' => $doco->id]);
                        $phones = array_map( fn($phone) => preg_replace('/[^0-9+]/i', '', trim($phone)), $phones);

                        $message = "📢 Notifikasi Dokumen Mutu\n
    Halo Bapak/Ibu,\n
    Dokumen mutu baru telah dibuat dengan rincian:\n
    Jenis Dokumen:  {$doco->jenis_dokumen}
    Nama Dokumen: {$doco->judul_dokumen}
    Nomor Dokumen: {$doco->no_dokumen}
    Tanggal: {$date}
    Dibuat oleh: {$doco->NamaKaryawan}
    Silakan cek dokumen di sini: {$url}\n
    Terima kasih.";

                        $alarmService = new AlarmAPIService();
                        $alarmService->sendMessage($phones, $message);
                    }
                }
            }

            DB::commit();
            return redirect(route('dokumen-mutu.riwayat-pengajuan'))->with('success', 'Approval validasi pengajuan dokumen mutu berhasil!');

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }

    public function validPenghapusan(Request $request)
    {
        $id = $request->input('id_pengajuan_dokumen');
        $status = $request->input('statusValidasiPenghapusan');
        $keterangan = $request->input('keterangan');

        DB::beginTransaction();
        try {
            $pengajuanDoco = DB::table(self::T_PENGAJUAN_DOCO)->find($id, ['no_dokumen', 'alasan_pengajuan']);

            DB::table(self::T_PENGAJUAN_DOCO)->where('id', $id)->update([
                'status' => $status == '1' ? 'Disetujui' : 'Ditolak',
                'keterangan_status' => $keterangan,
                'updated_at' => now()
            ]);

            if($status == '1') {
                $lastVersion = DB::table(self::T_VERSI_DOCO)->select('file_path')
                    ->join(self::T_PENGAJUAN_DOCO, self::T_PENGAJUAN_DOCO . '.id', self::T_VERSI_DOCO . '.id_pengajuan_dokumen')
                    ->where(self::T_PENGAJUAN_DOCO . '.no_dokumen', $pengajuanDoco->no_dokumen)
                    ->where(self::T_PENGAJUAN_DOCO . '.status', 'Disetujui')
                    ->orderBy(self::T_PENGAJUAN_DOCO . '.id', 'desc')
                    ->orderBy('no_versi', 'desc')
                    ->first();

                $expFilename = explode('/', $lastVersion->file_path);
                $originalName = $expFilename[ count($expFilename) - 1 ];
                $pathName = str_replace($originalName, '', $lastVersion->file_path);

                DB::table(self::T_DOCO)->where('no_dokumen', $pengajuanDoco->no_dokumen)->update([
                    // 'file_path' => $pathName . 'expired_' . $originalName,
                    'status' => 'Kadaluarsa',
                    'keterangan_kadaluarsa' => $pengajuanDoco->alasan_pengajuan
                ]);

                $convertedName = str_replace('\\', '/', storage_path('app/public/' . $pathName . 'converted_' . $originalName));
                $originalName = str_replace('\\', '/', storage_path('app/public/' . $pathName . $originalName));

                if(file_exists($convertedName)) {
                    @unlink($convertedName);
                }

                // putenv('PATH=' . env('DOCO_GS_PATH'));
                // shell_exec('gswin64 -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=' . $convertedName . ' ' . $originalName . '');
                // @unlink($originalName);
                // rename($convertedName, $originalName);

                $mpdf = new Mpdf();
                $pageCount = $mpdf->setSourceFile($originalName);

                for($i=1; $i <= $pageCount; $i++) {
                    $tplIdx = $mpdf->ImportPage($i);

                    $mpdf->SetWatermarkImage( storage_path('app/public/cap-kadaluarsa.png') );
                    $mpdf->showWatermarkImage = true;

                    $mpdf->AddPage();
                    $mpdf->useTemplate($tplIdx, 10, 10, 200);
                }

                $mpdf->OutputFile($originalName);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil submit validasi penghapusan dokumen!');

        } catch(\Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }

    public function reject($id, Request $request)
    {
        DB::beginTransaction();

        try {
            DB::table(self::T_PENGAJUAN_DOCO)->where('id', $id)->update([
                'status' => 'Ditolak',
            ]);

            DB::commit();
            return redirect(route('dokumen-mutu.riwayat-pengajuan'))->with('success', 'Berhasil menolak pengajuan dokumen');

        } catch(\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }

    public function storeKomentar($id, Request $request)
    {
        $id = $request->input('id');
        $idVersi = $request->input('id_versi');
        $keteranganOverdue = $request->input('catatan_overdue');
        $jenisValidasi = $request->input('jenis_validasi');
        $komentars = $request->input('komentars');

        DB::beginTransaction();
        try {
            $nik = session('user_id');

            DB::table(self::T_PENGAJUAN_DOCO)->where('id', $id)->update([
                'status' => 'Terdapat Feedback',
                'updated_at' => now()
            ]);

            foreach($komentars as $item) {
                DB::table(self::T_FEEDBACK_VALIDASI)->insertGetId([
                    'id_versi' => $idVersi,
                    'keterangan' => $item['keterangan'],
                    'nik_validator' => $nik,
                    'vertical' => round($item['vertical'], 2),
                    'horizontal' => round($item['horizontal'], 2),
                    'created_at' => now()
                ]);
            }

            if(!empty($keteranganOverdue)) {
                DB::table(self::T_OVERDUE_VALIDASI)->insert([
                    'id_pengajuan_dokumen' => $id,
                    'jenis_validasi' => $jenisValidasi,
                    'nik_validator' => session('user_id'),
                    'keterangan' => $keteranganOverdue,
                    'created_at' => now(),
                ]);
            }

            $pemohon = DB::table(self::T_KARYAWAN)->select('Telp', 'Nama', self::T_PENGAJUAN_DOCO . '.no_dokumen')
                ->join(self::T_PENGAJUAN_DOCO, self::T_PENGAJUAN_DOCO . '.nik_pemohon', self::T_KARYAWAN . '.NIK')
                ->where(self::T_PENGAJUAN_DOCO . '.id', $id)
                ->first();

            $phoneNumber = trim(trim($pemohon->Telp, "'"));
            if(!empty($phoneNumber)) {
                $url = route('dokumen-mutu.detail-riwayat', ['id' => $id]);
                $message = "📢 Notifikasi Dokumen Mutu\n
Halo Bapak/Ibu {$pemohon->Nama},\n
Pengajuan Dokumen Mutu anda dengan No. Dokumen {$pemohon->no_dokumen} telah di berikan feedback.
Silakan cek dokumen di sini: {$url}\n
Terima kasih.";

                $alarmService = new AlarmAPIService();
                $alarmService->sendMessage($phoneNumber, $message);
            }

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Berhasil menyimpan komentar baru!',
            ]);

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan, mohon coba beberapa saat lagi'
            ]);
        }
    }

    public function getFeedback($id, Request $request)
    {
        $idVersi = $request->get('id_versi');

        $feedbacks = DB::table(self::T_FEEDBACK_VALIDASI)->select(self::T_FEEDBACK_VALIDASI . '.*', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_FEEDBACK_VALIDASI . '.nik_validator')
            ->where('id_versi', $idVersi)
            ->orderBy('id', 'desc')->get()
            ->map( function($item) {
                $item->created_at = date('Y/m/d H:i', strtotime($item->created_at));
                $item->keterangan = nl2br($item->keterangan);

                return $item;
            });

        return response()->json($feedbacks);
    }
}
