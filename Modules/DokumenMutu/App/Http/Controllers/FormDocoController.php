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

class FormDocoController extends Controller
{
    protected const T_KARYAWAN = 'HRD.dbo.TKaryawan';
    protected const T_JABATAN = 'HRD.dbo.tjabatan';
    protected const T_DOCO = 'DB_Dokumen_Mutu.dbo.T_Dokumen_Mutu';
    protected const T_PENGAJUAN_DOCO = 'DB_Dokumen_Mutu.dbo.T_Pengajuan_Dokumen_Mutu';
    protected const T_VALIDASI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Validasi_Pengajuan';
    protected const T_VERSI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Versi_Dokumen';
    protected const T_FEEDBACK_VALIDASI = 'DB_Dokumen_Mutu.dbo.T_Feedback_Validasi';
    protected const T_SITE = 'HRD.dbo.tsite';
    protected const T_MASTER_VALIDATOR = 'DB_Dokumen_Mutu.dbo.T_Master_Validator';

    protected const THINTANK = [
        '1001384',
        '1003170',
        '1014583',
        '1001114',
        '1001117',
    ];

    public function formPengajuan()
    {
        return view('DokumenMutu::form-pengajuan');
    }

    public function storeFormPengajuan(Request $request)
    {
        $site = $request->input('site');
        $nikPemohon = session('user_id');
        $jenisDokumen = $request->input('jenisDokumen');
        $judulDokumen = $request->input('judulDokumen');
        $alasanPengajuan = $request->input('alasanPengajuan');

        $pemohon = DB::table(self::T_KARYAWAN)->select('KodeDP', self::T_JABATAN . '.Nama AS NamaJB', self::T_KARYAWAN . '.Telp', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
            ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
            ->where('KodeST', $site)
            ->where('NIK', $nikPemohon)
            ->where('AKTIF', '0')->first();
        if(!$pemohon) {
            return redirect()->back()->with('error', 'NIK pemohon tidak terdaftar');
        }

        // if($site == 'JKT') {
        //     if($jenisDokumen == 'SOP') {
        //         $isValidPemohon = preg_match('/kepala seksi/i', $pemohon->NamaJB) || preg_match('/kepala bagian/i', $pemohon->NamaJB) || preg_match('/kepala dept/i', $pemohon->NamaJB);
        //     } else if($jenisDokumen == 'STD' || $jenisDokumen == 'WI') {
        //         $isValidPemohon = preg_match('/kepala seksi/i', $pemohon->NamaJB) || preg_match('/kepala bagian/i', $pemohon->NamaJB);
        //     } else {
        //         $isValidPemohon = true;
        //     }

        // } else {
        //     if($jenisDokumen == 'SOP') {
        //         $isValidPemohon = preg_match('/kepala bagian/i', $pemohon->NamaJB);
        //     } else if($jenisDokumen == 'STD' || $jenisDokumen == 'WI') {
        //         $isValidPemohon = preg_match('/kepala seksi/i', $pemohon->NamaJB) || preg_match('/kepala bagian/i', $pemohon->NamaJB);
        //     } else {
        //         $isValidPemohon = true;
        //     }
        // }

        // if(!$isValidPemohon) {
        //     return redirect()->back()->with('error', 'Mohon maaf anda tidak dapat untuk membuat pengajuan dokumen mutu');
        // }

        $getCounting = DB::table(self::T_PENGAJUAN_DOCO)->select(self::T_PENGAJUAN_DOCO . '.no_dokumen', self::T_DOCO . '.status AS status_doco')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', '=', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
            ->leftJoin(self::T_DOCO, self::T_DOCO . '.no_dokumen', self::T_PENGAJUAN_DOCO . '.no_dokumen')
            ->where(self::T_PENGAJUAN_DOCO . '.kode_site', $site)
            ->where('KodeDP', $pemohon->KodeDP)
            ->where(self::T_PENGAJUAN_DOCO . '.status', '!=', 'Ditolak')
            ->orderBy(self::T_PENGAJUAN_DOCO . '.created_at', 'desc')
            ->get()->filter( function($item) {
                return $item->status_doco !== 'Kadaluarsa';
            });

        $lastRowCounting = $getCounting->last();
        $lastCounting = $lastRowCounting ? collect(explode('-', $lastRowCounting->no_dokumen))->last() : 0;

        if($lastCounting > $getCounting->count()) {
            for($i=0; $i < $getCounting->count(); $i++) {
                $no = $i + 1;
                $counting = collect(explode('-', $getCounting[ $i ]->no_dokumen))->last();
                if($counting != $no) {
                    $lastCounting = $no;
                }
            }
        }

        DB::beginTransaction();
        try {
            $noDokumen = ($site == 'JKT' ? 'BSS' : $site) . '-' . $jenisDokumen . '-' . $pemohon->KodeDP . '-' . str_pad($lastCounting + 1, 5, '0', STR_PAD_LEFT);

            if(!$request->file('dokumen')) {
                return redirect()->back()->with('error', 'File dokumen wajib di upload');
            }

            $path = 'dokumen_mutu/pengajuan/' . $pemohon->KodeDP;
            $filePath = Storage::disk('public')->put($path, $request->file('dokumen'));

            $pengajuan = DB::table(self::T_PENGAJUAN_DOCO)->insertGetId([
                'nik_pemohon' => $nikPemohon,
                'no_dokumen' => $noDokumen,
                'judul_dokumen' => $judulDokumen,
                'jenis_dokumen' => $jenisDokumen,
                'jenis_pengajuan' => 'Pembuatan',
                'alasan_pengajuan' => $alasanPengajuan,
                'status' => 'Belum Validasi',
                'kode_site' => $site,
                'created_at' => now(),
                'updated_at' => now(),
                'due_date' => date('Y-m-d', strtotime('+3 days'))
            ]);

            DB::table(self::T_VERSI_DOCO)->insert([
                'id_pengajuan_dokumen' => $pengajuan,
                'no_versi' => 1,
                'file_path' => $filePath,
            ]);

            $today = date('Y/m/d');
            $url = route('dokumen-mutu.validasi.index', ['id' => $pengajuan]);
            $message = "📢 Notifikasi Dokumen Mutu\n
Halo Bapak/Ibu,\n
Dokumen mutu baru telah dibuat dengan rincian:\n
Jenis Dokumen:  {$jenisDokumen}
Nama Dokumen: {$judulDokumen}
Nomor Dokumen: {$noDokumen}
Tanggal: {$today}
Dibuat oleh: {$pemohon->NamaKaryawan}
Silakan cek dokumen di sini: {$url}\n
Terima kasih.";

            $alarmService = new AlarmAPIService();
            $alarmService->sendMessage(env('DOCO_ALARM_OD'), $message);

            DB::commit();
            return redirect(route('dokumen-mutu.riwayat-pengajuan'))->with('success', 'Berhasil submit pengajuan dokumen mutu!');

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }

    public function formRevisi()
    {
        return view('DokumenMutu::form-revisi');
    }

    public function storeFormRevisi(Request $request)
    {
        $noDokumen = $request->input('noDokumen');
        $alasanPengajuan = $request->input('alasanPengajuan');
        $dokumen = $request->file('dokumen');

        try {
            $doco = DB::table(self::T_DOCO)->select(self::T_KARYAWAN . '.KodeDP', 'nik_pembuat', 'judul_dokumen', 'jenis_dokumen', 'kode_site', self::T_JABATAN . '.Nama AS NamaJB', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_DOCO . '.nik_pembuat')
                ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
                ->where('no_dokumen', $noDokumen)->first();

            if(!$doco) {
                return redirect()->back()->with('error', 'Nomor dokumen yang ada masukkan tidak ditemukan');
            }

            // if($doco->kode_site == 'JKT') {
            //     if($doco->jenis_dokumen == 'SOP') {
            //         $isValidPemohon = preg_match('/kepala seksi/i', $doco->NamaJB) || preg_match('/kepala bagian/i', $doco->NamaJB) || preg_match('/kepala dept/i', $doco->NamaJB);
            //     } else if($doco->jenis_dokumen == 'STD' || $doco->jenis_dokumen == 'WI') {
            //         $isValidPemohon = preg_match('/kepala seksi/i', $doco->NamaJB) || preg_match('/kepala bagian/i', $doco->NamaJB);
            //     } else {
            //         $isValidPemohon = true;
            //     }

            // } else {
            //     if($doco->jenis_dokumen == 'SOP') {
            //         $isValidPemohon = preg_match('/kepala bagian/i', $doco->NamaJB);
            //     } else if($doco->jenis_dokumen == 'STD' || $doco->jenis_dokumen == 'WI') {
            //         $isValidPemohon = preg_match('/kepala seksi/i', $doco->NamaJB) || preg_match('/kepala bagian/i', $doco->NamaJB);
            //     } else {
            //         $isValidPemohon = true;
            //     }
            // }

            // if(!$isValidPemohon) {
            //     return redirect()->back()->with('error', 'Mohon maaf anda tidak dapat untuk membuat pengajuan dokumen mutu');
            // }

            $path = 'dokumen_mutu/revisi/' . $doco->KodeDP;
            $filePath = Storage::disk('public')->put($path, $dokumen);

            $pengajuan = DB::table(self::T_PENGAJUAN_DOCO)->insertGetId([
                'nik_pemohon' => $doco->nik_pembuat,
                'no_dokumen' => $noDokumen,
                'judul_dokumen' => $doco->judul_dokumen,
                'jenis_dokumen' => $doco->jenis_dokumen,
                'jenis_pengajuan' => 'Revisi',
                'alasan_pengajuan' => $alasanPengajuan,
                'status' => 'Belum Validasi',
                'kode_site' => $doco->kode_site,
                'created_at' => now(),
                'updated_at' => now(),
                'due_date' => date('Y-m-d', strtotime('+3 days'))
            ]);

            DB::table(self::T_VERSI_DOCO)->insert([
                'id_pengajuan_dokumen' => $pengajuan,
                'no_versi' => 1,
                'file_path' => $filePath,
            ]);

            $today = date('Y/m/d');
            $url = route('dokumen-mutu.validasi.index', ['id' => $pengajuan]);
            $message = "📢 Notifikasi Dokumen Mutu\n
Halo Bapak/Ibu,\n
Pengajuan revisi Dokumen Mutu telah dibuat dengan rincian:\n
Jenis Dokumen:  {$doco->jenis_dokumen}
Nama Dokumen: {$doco->judul_dokumen}
Nomor Dokumen: {$doco->no_dokumen}
Tanggal: {$today}
Dibuat oleh: {$doco->NamaKaryawan}
Silakan cek dokumen di sini: {$url}\n
Terima kasih.";

            $alarmService = new AlarmAPIService();
            $alarmService->sendMessage(env('DOCO_ALARM_OD'), $message);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil submit revisi dokumen mutu!');

        } catch(\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }

    public function detailDoco(Request $request)
    {
        $noDokumen = $request->get('no_dokumen');
        $doco = DB::table(self::T_DOCO)->select(self::T_DOCO . '.*', self::T_SITE . '.Nama AS NamaSite')
            ->join(self::T_SITE, self::T_SITE . '.KodeST', self::T_DOCO . '.kode_site')
            ->where('no_dokumen', $noDokumen)->first();

        return response()->json($doco);
    }

    public function formPenghapusan()
    {
        return view('DokumenMutu::form-penghapusan');
    }

    public function storeFormPenghapusan(Request $request)
    {
        $noDokumen = $request->input('noDokumen');
        $alasanPengajuan = $request->input('alasanPengajuan');

        try {
            $doco = DB::table(self::T_DOCO)->select(self::T_KARYAWAN . '.KodeDP', 'nik_pembuat', 'judul_dokumen', 'jenis_dokumen', 'kode_site', self::T_JABATAN . '.Nama AS NamaJB')
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_DOCO . '.nik_pembuat')
                ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
                ->where('no_dokumen', $noDokumen)->first();

            if(!$doco) {
                return redirect()->back()->with('error', 'Nomor dokumen yang ada masukkan tidak ditemukan');
            }

            // if($doco->kode_site == 'JKT') {
            //     if($doco->jenis_dokumen == 'SOP') {
            //         $isValidPemohon = preg_match('/kepala seksi/i', $doco->NamaJB) || preg_match('/kepala bagian/i', $doco->NamaJB) || preg_match('/kepala dept/i', $doco->NamaJB);
            //     } else if($doco->jenis_dokumen == 'STD' || $doco->jenis_dokumen == 'WI') {
            //         $isValidPemohon = preg_match('/kepala seksi/i', $doco->NamaJB) || preg_match('/kepala bagian/i', $doco->NamaJB);
            //     } else {
            //         $isValidPemohon = true;
            //     }

            // } else {
            //     if($doco->jenis_dokumen == 'SOP') {
            //         $isValidPemohon = preg_match('/kepala bagian/i', $doco->NamaJB);
            //     } else if($doco->jenis_dokumen == 'STD' || $doco->jenis_dokumen == 'WI') {
            //         $isValidPemohon = preg_match('/kepala seksi/i', $doco->NamaJB) || preg_match('/kepala bagian/i', $doco->NamaJB);
            //     } else {
            //         $isValidPemohon = true;
            //     }
            // }

            // if(!$isValidPemohon) {
            //     return redirect()->back()->with('error', 'Mohon maaf anda tidak dapat untuk membuat pengajuan dokumen mutu');
            // }

            $pengajuan = DB::table(self::T_PENGAJUAN_DOCO)->insertGetId([
                'nik_pemohon' => $doco->nik_pembuat,
                'no_dokumen' => $noDokumen,
                'judul_dokumen' => $doco->judul_dokumen,
                'jenis_dokumen' => $doco->jenis_dokumen,
                'jenis_pengajuan' => 'Penghapusan',
                'alasan_pengajuan' => $alasanPengajuan,
                'status' => 'Belum Validasi',
                'kode_site' => $doco->kode_site,
                'created_at' => now(),
                'updated_at' => now(),
                'due_date' => date('Y-m-d', strtotime('+3 days'))
            ]);

            $today = date('Y/m/d');
            $url = route('dokumen-mutu.validasi.index', ['id' => $pengajuan]);
            $message = "📢 Notifikasi Dokumen Mutu\n
Halo Bapak/Ibu,\n
Pengajuan penghapusan Dokumen Mutu telah dibuat dengan rincian:\n
Jenis Dokumen:  {$doco->jenis_dokumen}
Nama Dokumen: {$doco->judul_dokumen}
Nomor Dokumen: {$doco->no_dokumen}
Tanggal: {$today}
Dibuat oleh: {$doco->NamaKaryawan}
Silakan cek dokumen di sini: {$url}\n
Terima kasih.";

            $alarmService = new AlarmAPIService();
            $alarmService->sendMessage(env('DOCO_ALARM_OD'), $message);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil submit penghapusan dokumen mutu!');

        } catch(\Throwable $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }

    public function submitRevisiPengajuan(Request $request)
    {
        $idPengajuan = $request->input('id_pengajuan');
        $idVersi = $request->input('id_versi');
        $dokumen = $request->file('dokumenTerbaru');

        DB::beginTransaction();
        try {
            $doco = DB::table(self::T_PENGAJUAN_DOCO)->select(self::T_PENGAJUAN_DOCO . '.*', self::T_KARYAWAN . '.KodeDP', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
                ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
                ->where('id', $idPengajuan)->first();

            $path = 'dokumen_mutu/' . strtolower($doco->jenis_pengajuan) . '/' . $doco->KodeDP;
            $filePath = Storage::disk('public')->put($path, $dokumen);

            $lastVersion = DB::table(self::T_VERSI_DOCO)->find($idVersi);
            if($lastVersion->no_versi > 1) {
                DB::table(self::T_FEEDBACK_VALIDASI)->where('id_versi', $idVersi)->delete();

                DB::table(self::T_VERSI_DOCO)->where('id', $idVersi)
                    ->update([
                        'no_versi' => $lastVersion->no_versi + 1,
                        'file_path' => $filePath
                    ]);

            } else {
                DB::table(self::T_VERSI_DOCO)->insert([
                    'id_pengajuan_dokumen' => $idPengajuan,
                    'no_versi' => $lastVersion->no_versi + 1,
                    'file_path' => $filePath,
                    'created_at' => now(),
                ]);
            }

            $alarmService = new AlarmAPIService();
            $validationCount = DB::table(self::T_VALIDASI_DOCO)
                ->where('id_pengajuan_dokumen', $idPengajuan)->count('id');

            if($validationCount > 1) {
                $validators = DB::table(self::T_MASTER_VALIDATOR)
                    ->where('jenis_validator', 'validasi')
                    ->where('jenis_dokumen', $doco->jenis_dokumen)
                    ->where('site', $doco->kode_site)
                    ->orderBy('id', 'ASC')->get();

                $thinktanks = DB::table(self::T_KARYAWAN)->whereIn('NIK', self::THINTANK)
                    ->get()->pluck('Telp');

                $phones = [];
                foreach($validators as $validator) {
                    switch($validator->validator) {
                        case 'thinktank':
                            $phones = array_merge($phones, $thinktanks);
                            break;

                        case 'kadept':
                            $kadepts = DB::table(self::T_KARYAWAN)->select('Telp')
                                ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
                                ->where('KodeDP', $doco->KodeDP)
                                ->get()->pluck('Telp');

                            $phones = array_merge($phones, $kadepts->all());
                            break;

                        default:
                            break;
                    }
                }

            } else {
                $phones = [ env('DOCO_ALARM_OD') ];
            }

            $date = date('Y/m/d');
            $dueDate = date('Y/m/d', strtotime($doco->due_date));
            $url = route('dokumen-mutu.validasi.index', ['id' => $doco->id]);

            $message = "📢 Notifikasi Dokumen Mutu\n
Halo Bapak/Ibu,\n
Kami menginformasikan bahwa dokumen berikut sudah mengirimkan revisi lanjutan dengan detail berikut:\n
Jenis Dokumen:  {$doco->jenis_dokumen}
Nama Dokumen: {$doco->judul_dokumen}
Nomor Dokumen: {$doco->no_dokumen}
Tanggal Dibuat: {$date}
Dibuat oleh: {$doco->NamaKaryawan}
Batas Waktu Pengecekan: {$dueDate}
Silakan cek dokumen di sini: {$url}\n
Mohon untuk segera melakukan pengecekan dan tindak lanjut sesuai prosedur yang berlaku.
Terima kasih atas perhatian dan kerjasamanya.";

            foreach($phones as $phone) {
                $phone = trim(trim($phone, "'"));

                if(!empty($phone)) {
                    $alarmService->sendMessage($phone, $message);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil submit revisi pengajuan dokumen!');

        } catch(\Throwable $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan, mohon coba beberapa saat lagi');
        }
    }
}
