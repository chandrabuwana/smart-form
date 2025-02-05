<?php

namespace Modules\SmartForm\App\Http\Controllers\FAT\PPH;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserVendorController extends Controller
{
    protected const T_PPH_VENDOR = 'PICA.dbo.FM_FAT_PPH_VENDOR';

    public function index(Request $request)
    {
        return view('SmartForm::FAT/PPH/vendor/dashboard');
    }

    public function fetchData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'id');
        $order   = $request->query('order', 'desc');
        $offset  = $request->query('offset', 0);
        $limit   = $request->query('limit', 10);

        try {
            $vendorMasterNotFiltered = DB::table(self::T_PPH_VENDOR)->select('id');

            $vendorMaster = DB::table(self::T_PPH_VENDOR)
                ->select('npwp', 'Email', 'Nama', 'Status');

            if(!empty($search)) {
                $vendorMaster->where('role_name', 'like', '%' . $search . '%');
            }

            $data = $vendorMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $vendorMasterNotFiltered->count(),
                'rows' => $data
            ]);

        } catch (Exception $ex) {
            return response()->json([
                'total' => 0,
                'totalNotFiltered' => 0,
                'rows' => []
            ]);
        }
    }

    public function create(Request $request)
    {
        return view('SmartForm::FAT/PPH/vendor/form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'npwp' => 'required|string|min:15|max:18',
            'nama' => 'required|string|min:15|max:18',
            'email' => 'required|email',
            'password' => 'required|min:5|max:10'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table(self::T_PPH_VENDOR)->insert([
                'npwp' => $requestData['npwp'],
                'Email' => $requestData['email'],
                'Password' => Hash::make($requestData['password']),
                'Status' => '1',
                'Nama' => $requestData['nama'],
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data user vendor!',
                'code' => 200
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    public function edit($id, Request $request)
    {
        $vendor = DB::table(self::T_PPH_VENDOR)->find($id);
        

        return view('SmartForm::FAT/PPH/vendor/form');
    }
}
