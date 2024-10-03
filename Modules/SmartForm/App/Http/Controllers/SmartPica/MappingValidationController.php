<?php

namespace Modules\SmartForm\App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MappingValidationController extends Controller {
    private const DB_HRD = 'HRD.dbo.';
    private const TABLE_USER_LEVEL = 'USR_LVL';
    private const TABLE_MAPPING_LEVEL = 'SMF_LVL_MAPPING_MASTER';
    private const TABLE_SECTION_DEPT = 'tsection';
    private const TABLE_HRD_DEPT = self:: DB_HRD . 'tdepartement';

    public function IndexLevelMapping(Request $request) {
        $data_section = [];
        $data_department = [];

        try {
            $data_section = DB::table(self::TABLE_SECTION_DEPT . ' as a')
                ->select('a.KodeSection', 'a.Nama')
                ->get()->toArray();
            
            $data_department = DB::table(self::TABLE_HRD_DEPT)->select('KodeDP', 'Nama');
            Log::debug('SQL dept : '. $data_department->toRawSql());

            $data_department = $data_department->get()->toArray();

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return view('SmartForm::smartpica/dashboard-level-mapping', ['data_section' => $data_section, 'data_department' => $data_department]);
    }

    public function IndexLevelUser(Request $request) {
        $data_section = [];
        try {
            $data_section = DB::table(self::TABLE_SECTION_DEPT . ' as a')
                ->select('a.KodeSection', 'a.Nama')
                ->get()->toArray();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return view('SmartForm::smartpica/dashboard-level-user', ['data_section' => $data_section]);
    }

    public function GetListLevelUser(Request $request) {
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
            $filterNIK = $request->query('filterNIK', null); // Default limit

            $query_level_user = DB::table(self::TABLE_USER_LEVEL)
                ->select('id as nomor', 'Nik as nik', 'lvl as level', 'kode_section as section');
            if($filterNIK == null || $filterNIK == "") {}
            else $query_level_user = $query_level_user->where('Nik', $filterNIK);
            
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

    public function GetListLevelMapping(Request $request) {
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
            $filterNIK = $request->query('filterNIK', null); // Default limit

            $query_level_user = DB::table(self::TABLE_MAPPING_LEVEL . ' as a')
                ->select('a.id as nomor', 'a.Dept as dept', 'a.Section as section', 'b.Nama as section_name', 'a.level1', 'a.level2', 'a.level2', 'a.level3', 'a.level4', 'a.level5')
                ->leftJoin(self::TABLE_SECTION_DEPT . ' as b', 'a.Section', '=', 'b.KodeSection');
            if($filterNIK == null || $filterNIK == "") {}
            else $query_level_user = $query_level_user->whereAny([
                'level1',
                'level2',
                'level3',
                'level4',
                'level5',
            ], 'like', '%'. $filterNIK. '%');
            
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

    public function AddLevelUser(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'nik' => ['required'],
                'level' => ['required', Rule::in(0,1,2,3,4,5)],
                'section' => ['required'],
            ],
            [
                'nik.required' => 'NIK tidak valid',
                'level.required' => 'Level tidak valid',
                'level.in' => 'Level tidak sesuai',
                'section.required' => 'Section tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            try {
                $nik = $request->input("nik");
                $level = $request->input("level");
                $section = $request->input("section");
                
                DB::beginTransaction();
                $new_level_user = DB::table(self::TABLE_USER_LEVEL)
                    ->insertGetId(['nik' => $nik, 'lvl' => $level, 'section' => $section]);
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

    public function AddLevelMapping(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'department' => ['required'],
                'section' => ['required'],
            ],
            [
                'department.required' => 'Department tidak valid',
                'section.required' => 'Section tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            $checkMappingExists = $this->checkMappingExist($request->input("department"), $request->input("section"));
            
            if($checkMappingExists) {
                $message = "Error Duplicate Mapping " . $request->input("department") . ' - ' . $request->input("section");
                $errorMessage = $errorList;
            } else {
                try {
                    $department = $request->input("department");
                    $section = $request->input("section");
                    $level1 = $request->input("level1");
                    $level2 = $request->input("level2");
                    $level3 = $request->input("level3");
                    $level4 = $request->input("level4");
                    $level5 = $request->input("level5");
                    
                    DB::beginTransaction();
                    $new_level_user = DB::table(self::TABLE_MAPPING_LEVEL)
                        ->insertGetId([
                            'Dept' => $department, 'section' => $section, 'level1' => $level1,
                            'level2' => $level2, 'level3' => $level3, 'level4' => $level4, 'level5' => $level4
                        ]);
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
        }

        return response()->json(
            [
                'isSuccess' => $isSucces,
                'message' => $message,
                'data' => $data
            ]
        );
    }

    public function EditLevelUser(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;

        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'nomor' => ['required'],
                'nik' => ['required'],
                'level' => ['required', Rule::in(0, 1, 2, 3, 4, 5)],
                'section' => ['required'],
            ],
            [
                'nomor.required' => 'Nomor tidak valid',
                'nik.required' => 'NIK tidak valid',
                'level.required' => 'Level tidak valid',
                'level.in' => 'Level tidak valid',
                'section.required' => 'Section tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            try {
                $id =$request->input('nomor');
                $data_update = [
                    'lvl' => $request->input('level'),
                    'kode_section' => $request->input('section')
                ];

                DB::beginTransaction();
                DB::table(self::TABLE_USER_LEVEL)
                    ->where('id', $id)
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

    public function EditLevelMapping(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;

        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'nomor' => ['required'],
                'department' => ['required'],
                'section' => ['required'],
            ],
            [
                'nomor.required' => 'Nomor tidak valid',
                'department.required' => 'Department tidak valid',
                'section.required' => 'Section tidak valid',
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            try {
                $id =$request->input('nomor');
                $data_update = [
                    'Dept' => $request->input('department'),
                    'section' => $request->input('section'),
                    'level1' => $request->input('level1'),
                    'level2' => $request->input('level2'),
                    'level3' => $request->input('level3'),
                    'level4' => $request->input('level4'),
                    'level5' => $request->input('level5'),
                    'updated_by' => $nik_session,
                    'updated_at' => now()
                ];

                DB::beginTransaction();
                DB::table(self::TABLE_MAPPING_LEVEL)
                    ->where('id', $id)
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

    public function DeleteLevelUser(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'nomor' => ['required']
            ],
            [
                'nomor.required' => 'Nomor tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            $id = $request->input("nomor");

            try {
                DB::beginTransaction();
                DB::table(self::TABLE_USER_LEVEL)
                    ->where('id', $id)
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

    public function DeleteLevelMapping(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'nomor' => ['required']
            ],
            [
                'nomor.required' => 'Nomor tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            $id = $request->input("nomor");

            try {
                DB::beginTransaction();
                DB::table(self::TABLE_MAPPING_LEVEL)
                    ->where('id', $id)
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

    private function checkMappingExist($dept, $section) {
        $isExist = true;

        try {
            $isExist = DB::table(self::TABLE_MAPPING_LEVEL)->where('Dept', $dept)->where('section', $section)->exists();
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return $isExist;
    }
}