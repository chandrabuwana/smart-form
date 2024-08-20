<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller {

    function index() {
        $count_parent = DB::table('MasterMenu')
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

        return view('admin/dashboard-menu', ['total' => count($count_parent), 'data' => $data_urutan]);
    }

    function GetAllMenu(Request $request) {
        $search = $request->query('search', '');
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', 10);
        
        $data = DB::table('MasterMenu as a')
            ->select('a.id', 'a.nama', 'a.link', 'a.urutan as order', 'a.status', 'a.parent', 'b.nama as parent_nama')
            ->leftJoin('MasterMenu as b', 'a.parent', '=', 'b.id')
            ->where('a.status', 1)
            ->orderBy('a.parent')
            ->orderBy('a.urutan')
            ->skip($offset)->take($limit)
            ->get();

        $totalNotFiltered = DB::table('MasterMenu as a')->count();

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
            $insert_menu = DB::table('MasterMenu')
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
}