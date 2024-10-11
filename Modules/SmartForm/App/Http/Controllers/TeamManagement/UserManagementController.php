<?php

namespace Modules\SmartForm\App\Http\Controllers\TeamManagement;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function dashboard()
    {
        return view('SmartForm::user-management/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $username  = $request->query('username', '');
        $role      = $request->query('role', '');
        $sort      = $request->query('sort', 'userid');
        $order     = $request->query('order', 'desc');
        $offset    = $request->query('offset', 0);
        $limit     = $request->query('limit', 10);

        try {
            $userMasterNotFiltered = DB::table('users')->select('id');

            $userMaster = DB::table('users')->select('userid', 'username', 'last_login', 'last_logout', 'device', 'role_name')
                ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role');

            if(!empty($username)) {
                $userMaster->where('username', 'like', '%' . $username . '%');
            }

            if(!empty($role)) {
                $userMaster->where('role', 'like', '%' . $role . '%');
            }

            $data = $userMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $userMasterNotFiltered->count(),
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
        $roleMaster = DB::table('MS_ROLE')->select('id', 'role_name')
            ->orderBy('id', 'ASC')->get();

        return view('SmartForm::user-management/form', [
            'roleMaster' => $roleMaster
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'role_id' => 'required|exists:MS_ROLE,id'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('users')->insert([
                'username' => $requestData['username'],
                'password' => Hash::make($requestData['password']),
                'role_id' => $requestData['role_id'],
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data user management!',
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

    public function edit($id)
    {
        $roleMaster = DB::table('MS_ROLE')->select('id', 'role_name')
            ->orderBy('id', 'ASC')->get();

        $userMaster = DB::table('users')->where("userid",$id)->first();

        return view('SmartForm::user-management/form', [
            'userMaster' => $userMaster,
            'roleMaster' => $roleMaster,
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'role_id' => 'required|exists:MS_ROLE'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            // $user = DB::table('users')->find($id);
            $user = DB::table('users')->where("userid", $id)->first();

            DB::table('users')->where('id', $id)->update([
                'username' => $requestData['username'],
                'password' => !empty($requestData['password']) ? Hash::make($requestData['password']) : $user->password,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan perubahan data user management!',
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
        DB::table('users')->where('id', $id)->delete();
        return redirect(route('dashboard-user-management'));
    }
}
