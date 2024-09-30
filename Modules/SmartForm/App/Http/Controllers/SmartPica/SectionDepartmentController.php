<?php
namespace Modules\SmartForm\App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SectionDepartmentController extends Controller {

    private const TABLE_SECTION_DEPT = 'tsection';

    public function IndexSectionDepartment(Request $request) {
        return view('SmartForm::smartpica/dashboard-section-department');
    }

    public function GetListSectionDepartment(Request $request) {
        $isSucces = false;
        $message = '';
        $data = [
            'total' => 0,
            'totalnotFiltered' => 0,
            'rows' => []
        ];

        try {
            $offset = $request->query('offset', 0); // Default offset
            $limit = $request->query('limit', 10); // Default limit
            // $filterNIK = $request->query('filterNIK', null); // Default limit

            $query_level_user = DB::table(self::TABLE_SECTION_DEPT)
                ->select('KodeSection', 'Nama');

            // if($filterNIK == null || $filterNIK == "") {}
            // else $query_level_user = $query_level_user->where('Nik', $filterNIK);
            
            $jml = $query_level_user->count();

            if($limit == null || $limit == 'null' || $limit == '') {
                $query_level_user->skip($offset);
            } else {
                $query_level_user->skip($offset)->limit($limit);
            }

            Log::debug('SQL Level user : ' . $query_level_user->toRawSql());
            $result_level_user = $query_level_user->get();
            $data['rows'] = $result_level_user;
            $data['total'] = $data['totalnotFiltered'] = $jml;
            
            $isSucces = true;
            $message = "Ok";
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());

            $isSucces = false;
            $message = "Terjadi kesalahan, coba beberapa saat lagi";
        }

        return response()->json(
            [
                'isSuccess' => $isSucces,
                'message' => $message,
                'data' => $data
            ]
        );
    }

    public function AddSectionDept(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'kode' => ['required'],
            ],
            [
                'kode.required' => 'NIK tidak valid',
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            try {
                $kode = $request->input("kode");
                $nama = $request->input("nama");
                
                DB::beginTransaction();
                $new_section_dept = DB::table(self::TABLE_SECTION_DEPT)
                    ->insertGetId(['KodeSection' => $kode, 'Nama' => $nama]);
                DB::commit();
                $isSucces = true;
                $message = "Berhasil tambah data baru";
            } catch (Exception $ex) {
                DB::rollBack();
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $isSucces = false;

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json(
            [
                'isSuccess' => $isSucces,
                'message' => $message,
                'data' => $data
            ]
        );
    }

    public function DeleteSectionDept(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'kode' => ['required']
            ],
            [
                'kode.required' => 'Nomor tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            $kode_section = $request->input("kode");

            try {
                DB::beginTransaction();
                DB::table(self::TABLE_SECTION_DEPT)
                    ->where('KodeSection', $kode_section)
                    ->delete();
                DB::commit();

                $message = "Berhasil menghapus data level user";
                $isSucces = true;
            } catch (Exception $ex) {
                DB::rollBack();
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $isSucces = false;

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json(
            [
                'isSuccess' => $isSucces,
                'message' => $message,
                'data' => null
            ]
        );
    }

    public function EditSectionDept(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;

        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'kode' => ['required'],
            ],
            [
                'kode.required' => 'Kode Section tidak valid',
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            try {
                $id = $request->input('kode');
                $data_update = [
                    'Nama' => $request->input('nama')
                ];

                DB::beginTransaction();
                DB::table(self::TABLE_SECTION_DEPT)
                    ->where('kodeSection', $id)
                    ->update($data_update);

                DB::commit();
                $message = 'Berhasil update data!';
                $isSucces = true;
            } catch (Exception $ex) {
                DB::rollBack();
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $isSucces = false;

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json(
            [
                'isSuccess' => $isSucces,
                'message' => $message,
                'data' => null
            ]
        );
    }
}