<?php

namespace Modules\SmartForm\App\Http\Controllers\IC\PengajuanTraining;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HelperTraininingController extends Controller {
    private const DB_CONN_NAME = 'sqlsrv_training';
    const T_M_TRAINING = 'm_training';
    const T_TRAINING_KATEGORI = 'training_kategori';
    const T_STD_JAB = 'std_jab_training';
    const T_TRAINING_SYARAT = 'training_syarat';
    const T_PENGAJUAN_TRAINING = 'pengajuan_training';
    const T_PIVOT_SYARAT_TRAINING = 'syarat_m_training';
    const T_HRD_JABATAN = 'HRD.dbo.tjabatan';
    const T_OFF_ONLINE = 'm_offline_online';
    const T_MANDATORY = 'mandatory_type';
    const T_PENGAJUAN_TRAINING_DTL = 'pengajuan_training_detail';

    public function GetMTraining(Request $request) {
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];
        $isSuccess = false;
        $message = '';
        $errorMessage = '';

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10); 

        try {
            $sql_master_data = DB::connection(self::DB_CONN_NAME)->table(self::T_M_TRAINING . ' as mt')
                ->select(
                    'mt.id', 'mt.nama', 'mt.mandatory_type', 'mt.harga', 'mt.offline_online'
                )
                ->leftJoin(self::T_TRAINING_KATEGORI. ' as tk', 'mt.training_kategori_code', '=', 'tk.code');

            $jml = $sql_master_data->count();

            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_master_data->skip($offset);
            } else {
                $sql_master_data->skip($offset)->limit($limit);
            }
            $master_data = $sql_master_data->get();

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $master_data
            ];
            $message= "Ok";
            $isSuccess = true;

        }  catch (Exception $ex) {
            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';
            $errorMessage = [$message];

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function SelectMTraining(Request $request) {
        $data = [];
        $query = $request->get("query");

        try {
            $data = DB::connection(self::DB_CONN_NAME)->table(self::T_M_TRAINING . ' as mt')
                ->select(
                    'mt.id', 'mt.nama as text', 'mt.nama', 'mt.mandatory_type', 'md_tp.nama as mandatory', 'tr_kt.nama as kategori', 'ff.nama as offline_online_nama'
                )
                ->leftJoin(self::T_OFF_ONLINE . ' as ff', 'mt.offline_online', '=', 'ff.id')
                ->leftJoin(self::T_MANDATORY . ' as md_tp', 'mt.mandatory_type', '=', 'md_tp.id')
                ->leftJoin(self::T_TRAINING_KATEGORI . ' as tr_kt', 'mt.training_kategori_code', '=', 'tr_kt.code');

            if($query) $data->where('mt.nama', 'like', "%$query%");
            $data = $data->get();

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json(['data' => $data]);
    }

    public function SelectKaryawan(Request $request) {
        $search = $request->get('query', '');
        $KodeDP = $request->get('KodeDP', null); 
        $KodeST = $request->get('KodeST', null); 
        $karyawan = [];
        $isError = true;
        
        $response = [
            'data' => []
        ];
        Log::info($search);

        if($search != '') {
            // select ptd.id, ptd.NIK, ptd.matrix, ptd.pengajuan_training_id, mt.nama as nama_training
            //     from pengajuan_training_detail as ptd
            //     left join pengajuan_training as pt on pt.id = ptd.pengajuan_training_id
            //     left join m_training as mt on pt.m_training_id=mt.id
            //     where ptd.NIK='1020340' and pt.m_training_id=7
            try {
                Log::info(Str::of($KodeST)->trim()->isNotEmpty() ? "benar" : 'salah');
                $query_search = DB::connection('sqlsrv2')
                    ->table('tkaryawan as tk')
                    ->leftJoin('tdepartement as td', 'tk.KodeDP', '=', 'td.KodeDP')
                    ->leftJoin('tjabatan as tj', 'tk.KodeJB', '=', 'tj.KodeJB')
                    ->select('tk.NIK as id', 'tk.Nama as text', 'tk.NIK', 'tk.nama', 'tk.KodeDP' , 'td.Nama as department', 'tk.KodeJB', 'tj.Nama as jabatan', 'tk.KodeST as site', 'tk.Tgl_Masuk as tmk')
                    ->whereAny(
                        ['tk.nama', 'tk.nik'], 'LIKE', "%$search%"
                    )
                    ->when(Str::of($KodeDP)->trim()->isNotEmpty(), function ($query) use ($KodeDP) {
                        $query->where('tk.KodeDP', $KodeDP);
                    })
                    ->when(Str::of($KodeST)->trim()->isNotEmpty(), function ($query) use ($KodeST) {
                        $query->where('tk.KodeST', $KodeST);
                    })
                    ->where('tk.Aktif', 0);
                
                Log::info("SQL SelectKaryawan :" . $query_search->toRawSql());
                $response['data'] = $query_search->get()->toArray();
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());

                // $response['errorMessage'] = 'Terjadi kesalahan, coba beberapa saat lagi!';
            }
        }

        // Log::info(json_encode($response, JSON_PRETTY_PRINT));

        return response()->json($response);
    }

    public function SelectSyaratAndStd(Request $request) {
        // select smt.id, smt.m_training_id, mt.nama, smt.training_syarat_id, st.nama
        //     from syarat_m_training as smt 
        //     left join m_training as mt on smt.m_training_id=mt.id
        //     left join training_syarat as st on smt.training_syarat_id=st.id 
        //     where m_training_id=7

        // select sjt.m_training_id, mt.nama as training_nama, sjt.KodeJB, tj.Nama as jabatan
        //     from std_jab_training as sjt
        //     left join HRD.dbo.tjabatan as tj on sjt.KodeJB=tj.KodeJB
        //     left join m_training as mt on sjt.m_training_id=mt.id
        //     where sjt.m_training_id=7
        $idTraining = $request->query('trainingID');
        $syarat = [];
        $stdJabatan = [];

        try {
            if($idTraining) {
                $sqlSyarat = DB::connection(self::DB_CONN_NAME)->table(self::T_PIVOT_SYARAT_TRAINING . ' as smt')
                    ->select('smt.id', 'smt.m_training_id', 'mt.nama as training_nama', 'smt.training_syarat_id', 'st.nama as syarat_nama', 'st.nilai as syarat_nilai', 'st.operasi as syarat_operasi', 'st.uom as syarat_uom')
                    ->leftJoin(self::T_M_TRAINING . ' as mt', 'smt.m_training_id', '=', 'mt.id')
                    ->leftJoin(self::T_TRAINING_SYARAT. ' as st', 'smt.training_syarat_id', '=', 'st.id')
                    ->where('mt.id', $idTraining);
                $sqlStdJab = DB::connection(self::DB_CONN_NAME)->table(self::T_STD_JAB . ' as sjt')
                    ->select('sjt.m_training_id', 'mt.nama as training_nama', 'sjt.KodeJB', 'tj.Nama as jabatan')
                    ->leftJoin(self::T_HRD_JABATAN . ' as tj', 'sjt.KodeJB', '=', 'tj.KodeJB')
                    ->leftJoin(self::T_M_TRAINING . ' as mt', 'sjt.m_training_id', '=', 'mt.id')
                    ->where('mt.id', $idTraining);

                $syarat = $sqlSyarat->get();
                $stdJabatan = $sqlStdJab->get();
            }

        } catch (Exception $ex) {
            Log::error('Error SelectSyaratAndStd : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());   
        }

        return response()->json([
            'syarat' => $syarat,
            'std_jabatan' => $stdJabatan
        ]);
    }

    public function CheckNIkAndPelatihan(Request $request) {
        $NIK = $request->get('NIK', '');
        $trainingID = $request->get('trainingID', '');
        $alreadyTraining = true;
        Log::info(['NIk' => $NIK, 'trainingID' => $trainingID]);

        try {
            $alreadyTraining = DB::connection('sqlsrv_training')
                ->table(self::T_PENGAJUAN_TRAINING_DTL . ' as ptd')
                ->leftJoin(self::T_PENGAJUAN_TRAINING . ' as pt', 'ptd.pengajuan_training_id', '=', 'pt.id')
                ->leftJoin(self::T_M_TRAINING . ' as mt', 'pt.m_training_id', '=', 'mt.id')
                ->where('ptd.NIK', $NIK)
                ->where('pt.m_training_id', $trainingID)
                ->exists();
        } catch (Exception $ex) {
            Log::error('Error CheckNIkAndPelatihan : ' . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'alreadyTraining' => $alreadyTraining
        ]);

    }
}
