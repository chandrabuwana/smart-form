<?php

namespace Modules\SmartForm\App\Http\Controllers\OD\CPM;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CPMHelper extends Controller
{
    const T_M_OBJ = 'cpm_m_obj';
    const T_M_CPM_CATEGORY = 'cpm_m_obj_category';

    public function HelperObjective(Request $request)
    {
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
        $limit = $request->query('limit', 50); 
        $query = $request->get("query");

        try {
            $sql_master_data = DB::table(self::T_M_OBJ . ' as mo')
                ->select(
                    'mo.id', 'mo.nama as text', 'moc.nama as category'
                )
                ->leftJoin(self::T_M_CPM_CATEGORY . ' as moc', 'mo.id_obj_category', '=', 'moc.id');

            if($query) $sql_master_data->where('mo.nama', 'like', "%$query%")->orWhere('moc.nama', 'like', "%$query%");
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

    public function HelperObjectiveCategory(Request $request)
    {
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
        $limit = $request->query('limit', 50); 
        $query = $request->query('query');

        try {
            $sql_master_data = DB::table(self::T_M_CPM_CATEGORY)
                ->select(
                    'id', 'nama as text'
                );
            if($query) $sql_master_data->where('nama', 'like', "%$query%");
            
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
}