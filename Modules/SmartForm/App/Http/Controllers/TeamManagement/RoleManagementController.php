<?php

namespace Modules\SmartForm\App\Http\Controllers\TeamManagement;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleManagementController extends Controller
{
    public function dashboard()
    {
        return view('SmartForm::role-management/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $search  = $request->query('search', '');
        $sort    = $request->query('sort', 'id');
        $order   = $request->query('order', 'asc');
        $offset  = $request->query('offset', 0);
        $limit   = $request->query('limit', 10);

        try {
            $roleMasterNotFiltered = DB::table('MS_ROLE')->select('id');

            $roleMaster = DB::table('MS_ROLE')
                ->select('MS_ROLE.id', 'role_name', 'role_code', DB::raw('COUNT(MS_ROLE_PERMISSION.id) AS role_permission'))
                ->leftJoin('MS_ROLE_PERMISSION', 'MS_ROLE_PERMISSION.role_id', '=', 'MS_ROLE.id')
                ->groupBy(['MS_ROLE.id', 'role_name', 'role_code']);

            if(!empty($search)) {
                $roleMaster->where('role_name', 'like', '%' . $search . '%');
            }

            $data = $roleMaster->orderBy('MS_ROLE.' . $sort, $order)->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $roleMasterNotFiltered->count(),
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
        $modulePermissions = DB::table('MasterMenu')->select('id', 'nama')
            ->whereNull('parent')
            ->orderBy('id', 'ASC')->get();

        return view('SmartForm::role-management/form', [
            'modulePermissions' => $modulePermissions
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'role_code' => 'required|string|max:255',
            'module_permission' => 'required'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            $roleId = DB::table('MS_ROLE')->insertGetId([
                'role_name' => $requestData['role_name'],
                'role_code' => $requestData['role_code'],
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_at' => null,
                'updated_by' => null
            ]);

            foreach($requestData['module_permission'] as $moduleId) {
                DB::table('MS_ROLE_PERMISSION')->insert([
                    'role_id' => $roleId,
                    'master_menu_id' => $moduleId,
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_at' => null,
                    'updated_by' => null
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data role management!',
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
        $modulePermissions = DB::table('MasterMenu')->select('id', 'nama')
            ->orderBy('id', 'ASC')->get();

        $roleMaster = DB::table('MS_ROLE')->find($id);
        $rolePermission = DB::table('MS_ROLE_PERMISSION')->where('role_id', $id)->get();

        return view('SmartForm::role-management/form', [
            'modulePermissions' => $modulePermissions,
            'roleMaster' => $roleMaster,
            'rolePermission' => $rolePermission
        ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'role_code' => 'required|string|max:255',
            'module_permission' => 'required'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('MS_ROLE')->where('id', $id)->update([
                'role_name' => $requestData['role_name'],
                'role_code' => $requestData['role_code'],
                'updated_at' => now(),
                'updated_by' => session("user_id")
            ]);

            // delete first..
            DB::table('MS_ROLE_PERMISSION')->where('role_id', $id)
                ->whereNotIn('master_menu_id', $requestData['module_permission'])->delete();

            foreach($requestData['module_permission'] as $moduleId) {
                DB::table('MS_ROLE_PERMISSION')->updateOrInsert(
                    ['role_id' => $id, 'master_menu_id' => $moduleId],
                    [
                        'role_id' => $id,
                        'master_menu_id' => $moduleId,
                        'created_at' => now(),
                        'created_by' => session("user_id"),
                        'updated_at' => now(),
                        'updated_by' => session("user_id")
                    ]
                );
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan perubahan data role management!',
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

    public function destroy($id)
    {
        DB::table('MS_ROLE_PERMISSION')->where('role_id', $id)->delete();
        DB::table('MS_ROLE')->where('id', $id)->delete();
        return redirect(route('role-management.dashboard'));
    }
}
