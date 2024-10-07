<?php

namespace Modules\SmartForm\App\Http\Controllers\MasterData;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterFormPICController extends Controller
{
    public function dashboard()
    {
        return view('SmartForm::master-form-pic/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $formName     = $request->query('form_name', '');
        $picUsername  = $request->query('pic_username', '');
        $sort         = $request->query('sort', 'id');
        $order        = $request->query('order', 'asc');
        $offset       = $request->query('offset', 0);
        $limit        = $request->query('limit', 10);

        try {
            $formPICNotFiltered = DB::table('MS_FORM_PIC')->select('id');

            $formPIC = DB::table('MS_FORM_PIC')
                ->select('id', 'form_name', 'form_slug', 'pic_username');

            if(!empty($formName)) {
                $formPIC->where('form_name', 'like', '%' . $formName . '%')
                    ->orWhere('form_slug', 'like', '%' . $formName . '%');
            }

            if(!empty($picUsername)) {
                $formPIC->where('pic_username', 'like', '%' . $picUsername . '%');
            }

            $data = $formPIC->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $formPICNotFiltered->count(),
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

    public function create()
    {
        return view('SmartForm::master-form-pic/form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_name' => 'required|string|max:255',
            'pic_username' => 'required'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('MS_FORM_PIC')->insert([
                'form_name' => $requestData['form_name'],
                'form_slug' => Str::slug($requestData['form_name']),
                'pic_username' => $requestData['pic_username'],
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_at' => null,
                'updated_by' => null
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data form PIC!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function edit($id)
    {
        $formPIC = DB::table('MS_FORM_PIC')->find($id);
        return view('SmartForm::master-form-pic/form', [
            'formPIC' => $formPIC
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'form_name' => 'required|string|max:255',
            'pic_username' => 'required'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('MS_FORM_PIC')->where('id', $id)->update([
                'form_name' => $requestData['form_name'],
                'form_slug' => Str::slug($requestData['form_name']),
                'pic_username' => $requestData['pic_username'],
                'updated_at' => now(),
                'updated_by' => session("user_id"),
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan perubahan data form PIC!',
                'code' => 200
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong: ' . $e->getMessage(),
                'code' => 500
            ]);
        }
    }

    public function destroy($id)
    {
        DB::table('MS_FORM_PIC')->where('id', $id)->delete();
        return redirect(route('dashboard-master-form-pic'));
    }
}
