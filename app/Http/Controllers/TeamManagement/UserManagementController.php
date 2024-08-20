<?php

namespace App\Http\Controllers\TeamManagement;

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
        if(!Helper::isGrantPermission('dashboard-user-management')) {
            return redirect('/');
        }

        return view('user-management/dashboard-user');
    }

    public function getDashboardData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'userid');
        $order   = $request->query('order', 'desc');
        $offset  = $request->query('offset', 0);
        $limit   = $request->query('limit', 10);

        try {
            $roleMaster = DB::table('users')->select('userid', 'username', 'last_login', 'last_logout', 'device', 'role_name')
                ->join('MS_ROLE', 'MS_ROLE.role_code', '=', 'users.role');

            if(!empty($search)) {
                $roleMaster->where('role_name', 'like', '%' . $search . '%');
            }

            $data = $roleMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            $response['message'] = "Ok";
            $response['isSuccess'] = true;
            $response['data'] = $data;

        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['isSuccess'] = false;
        }

        return response()->json($response);
    }

    public function create()
    {
        if(!Helper::isGrantPermission('create-user-management')) {
            return redirect('/');
        }

        $roleMaster = DB::table('MS_ROLE')->select('id', 'role_name')
            ->orderBy('id', 'ASC')->get();

        return view('user-management/user-form', [
            'roleMaster' => $roleMaster
        ]);
    }

    public function store(Request $request)
    {
        if(!Helper::isGrantPermission('create-user-management')) {
            return redirect('/');
        }

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
        if(!Helper::isGrantPermission('update-user-management')) {
            return redirect('/');
        }

        $roleMaster = DB::table('MS_ROLE')->select('id', 'role_name')
            ->orderBy('id', 'ASC')->get();

        $userMaster = DB::table('users')->find($id);

        return view('user-management/user-form', [
            'userMaster' => $userMaster,
            'roleMaster' => $roleMaster,
        ]);
    }

    public function update($id, Request $request)
    {
        if(!Helper::isGrantPermission('update-user-management')) {
            return redirect('/');
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|max:255',
            'role_id' => 'required|exists:MS_ROLE'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            $user = DB::table('users')->find($id);

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
        if(!Helper::isGrantPermission('delete-user-management')) {
            return redirect('/');
        }

        DB::table('users')->where('id', $id)->delete();
        return redirect(route('dashboard-user-management'));
    }
}
