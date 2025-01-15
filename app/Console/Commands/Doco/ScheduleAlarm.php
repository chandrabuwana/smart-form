<?php

namespace App\Console\Commands\Doco;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\SmartForm\Service\AlarmAPIService;

class ScheduleAlarm extends Command
{
    protected const T_VALIDASI_DOCO = 'DB_Dokumen_Mutu.dbo.T_Validasi_Pengajuan';
    protected const T_PENGAJUAN_DOCO = 'DB_Dokumen_Mutu.dbo.T_Pengajuan_Dokumen_Mutu';
    protected const T_MASTER_VALIDATOR = 'DB_Dokumen_Mutu.dbo.T_Master_Validator';
    protected const T_KARYAWAN = 'HRD.dbo.TKaryawan';
    protected const T_JABATAN = 'HRD.dbo.tjabatan';

    protected const THINTANK = [
        '1001384',
        '1003170',
        '1014583',
        '1001114',
        '1001117',
    ];

    protected $signature = 'app:schedule-alarm';

    protected $description = 'Command description';

    public function handle()
    {
        $validators = DB::table(self::T_MASTER_VALIDATOR)->orderBy('id', 'ASC')->get();

        $thinktanks = DB::table(self::T_KARYAWAN)->whereIn('NIK', self::THINTANK)
            ->get()->pluck('Telp');

        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $today = date('Y-m-d');

        $pengajuans = DB::table(self::T_PENGAJUAN_DOCO)->select(self::T_PENGAJUAN_DOCO . '.*', self::T_VALIDASI_DOCO . '.jenis_validasi', self::T_KARYAWAN . '.KodeDP', self::T_KARYAWAN . '.Nama AS NamaKaryawan')
            ->join(self::T_KARYAWAN, self::T_KARYAWAN . '.NIK', self::T_PENGAJUAN_DOCO . '.nik_pemohon')
            ->leftJoin(self::T_VALIDASI_DOCO, self::T_VALIDASI_DOCO . '.id_pengajuan_dokumen', self::T_PENGAJUAN_DOCO . '.id')
            ->where( function($q) {
                $q->where('status', 'Belum Validasi')
                    ->orWhere('status', 'Sedang Validasi');

            })->whereDate('due_date', '<=', $yesterday)
            // })
            ->orderBy('due_date', 'ASC')->get();

        DB::beginTransaction();
        try {
            $alarmService = new AlarmAPIService();

            foreach($pengajuans as $pengajuan) {
                if(!empty($pengajuan->jenis_validasi)) {
                    $phones = [];

                    $validatorPengajuan = $validators->filter( function($item) use($pengajuan) {
                        return $item->jenis_validator == 'validasi' && $item->jenis_dokumen == $pengajuan->jenis_dokumen && $item->site == $pengajuan->kode_site;
                    });

                    foreach($validatorPengajuan as $validator) {
                        switch($validator->validator) {
                            case 'thinktank':
                                $phones = array_merge($phones, $thinktanks);
                                break;

                            case 'kadept':
                                $kadepts = DB::table(self::T_KARYAWAN)->select('Telp')
                                    ->join(self::T_JABATAN, self::T_JABATAN . '.KodeJB', self::T_KARYAWAN . '.KodeJB')
                                    ->where('KodeDP', $pengajuan->KodeDP)
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

                $date = date('Y/m/d', strtotime($pengajuan->created_at));
                $dueDate = date('Y/m/d', strtotime($pengajuan->due_date));
                $url = route('dokumen-mutu.validasi.index', ['id' => $pengajuan->id]);

                if( strtotime($today) >= strtotime($pengajuan->due_date) ) {
                    $datediff = strtotime($today) - strtotime($pengajuan->due_date);
                    $diffDays = abs( round($datediff / (60 * 60 * 24)) );
                    $overdueMsg = "*DOKUMEN OVERDUE {$diffDays} HARI*";

                    if($diffDays > 7) {
                        DB::table(self::T_PENGAJUAN_DOCO)->where('id', $pengajuan->id)->update([
                            'status' => 'Dibatalkan Oleh Sistem'
                        ]);
                    }

                } else {
                    $overdueMsg = '';
                }

                $message = "⏰ Peringatan: Dokumen Belum Diperiksa\n
    Halo Bapak/Ibu,\n
    Kami mengingatkan bahwa dokumen berikut belum diperiksa dalam waktu yang telah ditentukan:\n
    {$overdueMsg}
    Jenis Dokumen:  {$pengajuan->jenis_dokumen}
    Nama Dokumen: {$pengajuan->judul_dokumen}
    Nomor Dokumen: {$pengajuan->no_dokumen}
    Tanggal Dibuat: {$date}
    Dibuat oleh: {$pengajuan->NamaKaryawan}
    Batas Waktu Pengecekan: {$dueDate}
    Silakan cek dokumen di sini: {$url}\n
    Mohon untuk segera melakukan pengecekan dan tindak lanjut sesuai prosedur yang berlaku.
    Terima kasih atas perhatian dan kerjasamanya.";

                foreach($phones as $phone) {
                    $phone = trim(trim($phone, "'"));

                    if(!empty($phone)) {
                        $alarmService->sendMessage($phone, $message);
                        echo "++== Alarm Sent to {$phone} ==++ \n<br>";
                    }
                }
            }

            DB::commit();

        } catch(\Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
