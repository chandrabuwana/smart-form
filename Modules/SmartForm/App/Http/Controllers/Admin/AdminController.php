<?php

namespace Modules\SmartForm\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {
    private const TABLE_MASTER_MENU = 'MasterMenu';

    function index() {
        $count_parent = DB::table(self::TABLE_MASTER_MENU)
            ->select('urutan as order')
            ->where('status', 1)
            ->where('parent', null)
            ->orderBy('parent')
            ->orderBy('urutan')
            ->get();

        $data_urutan = [];
        foreach ($count_parent as $value) {
            array_push($data_urutan, $value->order);
        }

        return view('SmartForm::admin/dashboard-menu', ['total' => count($count_parent), 'data' => $data_urutan]);
    }

    function GetAllMenu(Request $request) {
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10);

        $data = DB::table(self::TABLE_MASTER_MENU . ' as a')
            ->select('a.id', 'a.nama', 'a.link', 'a.urutan as order', 'a.status', 'a.parent', 'b.nama as parent_nama')
            ->leftJoin('MasterMenu as b', 'a.parent', '=', 'b.id')
            ->where('a.status', 1)
            ->orderBy('a.parent')
            ->orderBy('a.urutan')
            ->skip($offset)->take($limit)
            ->get();

        $totalNotFiltered = DB::table(self::TABLE_MASTER_MENU . ' as a')->count();

        return response()->json(['total'=> $totalNotFiltered, 'totalNotFiltered'=> $totalNotFiltered,'rows' => $data]);
    }

    function AddNewMenu(Request $request) {
        $request_body = $request->input();
        $response = array(
            'isSuccess' => false,
            'message' => "",
            'data' => null
        );

        Log::info("Request Body : ". json_encode($request->input()));
        try {
            $body_value = array(
                'nama' => $request_body['nama'],
                'link' => $request_body['link'],
                'parent' => $request_body['parent'],
                'status' => (int) $request_body['status']
            );

            DB::beginTransaction();
            $insert_menu = DB::table(self::TABLE_MASTER_MENU)
                ->insertGetId($body_value);
            DB::commit();

            $response['isSuccess'] = true;
            $response['message'] = 'Berhasil Tambah Menu!';
            $response['data'] = array('menu_id' => $insert_menu);
        } catch (Exception $ex) {
            DB::rollBack();
            $response['isSuccess'] = false;
            $response['message'] = $ex->getMessage();
        }

        return response()->json($response);
    }

    public function EditMenu(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;

        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'idMenu' => ['required'],
            ],
            [
                'idMenu.required' => 'Kode Section tidak valid',
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            try {
                $id = $request->input('idMenu');
                $data_update = [
                    'nama' => $request->input('nama'),
                    'link' => $request->input('link'),
                    'urutan' => $request->input('urutan'),
                    'parent' => $request->input('parent'),
                    'status' => $request->input('status'),
                ];
                Log::info(json_encode($data_update, JSON_PRETTY_PRINT));

                DB::beginTransaction();
                DB::table(self::TABLE_MASTER_MENU)
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

    public function DeleteMenu(Request $request) {
        $isSucces = false;
        $message = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'idMenu' => ['required']
            ],
            [
                'idMenu.required' => 'Nomor tidak valid'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {
            $id = $request->input("idMenu");

            try {
                DB::beginTransaction();
                DB::table(self::TABLE_MASTER_MENU)
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

}
