<?php

namespace Modules\SmartForm\App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalFormController extends Controller
{
    public function approveForm(Request $request)
    {
        $request->validate([
            'master_id' => 'required',
            'form_pic_id' => 'required'
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            DB::table('FM_APPROVAL')->updateOrInsert(['ms_form_pic_id' => $requestData['form_pic_id']], [
                'ms_form_pic_id' => $requestData['form_pic_id'],
                'submission_form_id' => $requestData['master_id'],
                'status' => $requestData['status'],
                'reason' => $requestData['reason'] ?? null,
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_at' => null,
                'updated_by' => null
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Berhasil approve pengisian form berikut!',
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
}
