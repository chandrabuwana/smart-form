<?php

namespace Modules\SmartForm\App\Http\Controllers\UnderCarriage;

use App\Helper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UnderCarriageInspectionController extends Controller
{
    public function form(Request $request)
    {
        $getComponentThirsts = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST')
            ->select('component_name', 'percentage', 'thirst_value')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', '=', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST.component_id')
            ->orderBy('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', 'ASC')->get();

        $componentThirsts = [];
        $componentLabels = $getComponentThirsts->pluck('component_name')->unique();

        foreach($getComponentThirsts as $item) {
            $componentThirsts[ $item->percentage ][] = $item->thirst_value;
        }

        $componentInspections = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT')
            ->orderBy('id', 'ASC')->get();
        $subComponentInspections = collect([]);

        $componentInspections->each( function($component, $keyComponent) use(&$subComponentInspections, $componentInspections) {
            $getSubComponents = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT')
                ->where('inspection_component_id', $component->id);

            if($getSubComponents->count() > 0) {
                $component->sub_components = $getSubComponents->orderBy('id', 'ASC')->get();
                $subComponentInspections->push($component);
                $componentInspections->forget($keyComponent);
            }
        });

        $components = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT')
            ->orderBy('id', 'ASC')->get();

        $referenceNo = $request->query('reference_no');
        return view('SmartForm::undercarriage/form', [
            'referenceNo' => $referenceNo,
            'components' => $components,
            'componentThirsts' => $componentThirsts,
            'componentLabels' => $componentLabels,
            'componentInspections' => $componentInspections,
            'subComponentInspections' => $subComponentInspections
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_no' => 'required|string|max:255',
            'unit_model' => 'required|string|max:255',
            'unit_sn' => 'required|string|max:255',
            'unit_smr_hm' => 'required|string|max:255',
            'work_operation' => 'required|string|max:255',
            'ground_condition' => 'required|string|max:255',
            'condition_area' => 'required|string|max:255',
            'inspection_date' => 'required|date_format:Y-m-d',
            'comment' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        $requestData = $request->all();

        try {
            $masterId = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')->insertGetId([
                'reference_no' => $requestData['reference_no'] ?? null,
                'document_no' => $requestData['document_no'],
                'unit_model' => $requestData['unit_model'],
                'unit_sn' => $requestData['unit_sn'],
                'unit_smr_hm' => $requestData['unit_smr_hm'],
                'work_operation' => $requestData['work_operation'],
                'ground_condition' => $requestData['ground_condition'],
                'condition_area_frame' => $requestData['condition_area'],
                'inspection_date' => $requestData['inspection_date'],
                'comment' => $requestData['comment'],
                'created_at' => now(),
                'created_by' => session("user_id"),
                'updated_at' => null,
                'updated_by' => null
            ]);

            // Form Inspection
            foreach($requestData['inspection_right_side'] as $componentId => $valueRightSide) {
                if(is_array($valueRightSide)) {
                    foreach($valueRightSide as $subComponentId => $inspectionRightSide) {
                        $inspectionLeftSide = $requestData['inspection_left_side'][$componentId][$subComponentId];

                        DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')->insert([
                            'inspection_id' => $masterId,
                            'inspection_component_id' => $componentId,
                            'inspection_sub_component_id' => $subComponentId,
                            'right_side' => $inspectionRightSide ?? 0,
                            'left_side' => $inspectionLeftSide ?? 0,
                            'created_at' => now(),
                            'created_by' => session("user_id"),
                            'updated_at' => null,
                            'updated_by' => null
                        ]);
                    }

                } else {
                    $inspectionRightSide = $valueRightSide;
                    $inspectionLeftSide = $requestData['inspection_left_side'][$componentId];

                    DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')->insert([
                        'inspection_id' => $masterId,
                        'inspection_component_id' => $componentId,
                        'inspection_sub_component_id' => null,
                        'right_side' => $inspectionRightSide ?? 0,
                        'left_side' => $inspectionLeftSide ?? 0,
                        'created_at' => now(),
                        'created_by' => session("user_id"),
                        'updated_at' => null,
                        'updated_by' => null
                    ]);
                }
            }

            // Form Temuan
            foreach($requestData['issue_right_side'] as $componentId => $issueRightSide) {
                $issueLeftSide = $requestData['issue_left_side'][$componentId];

                DB::table('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE')->insert([
                    'inspection_id' => $masterId,
                    'component_id' => $componentId,
                    'right_side' => $issueRightSide ?? '',
                    'left_side' => $issueLeftSide ?? '',
                    'created_at' => now(),
                    'created_by' => session("user_id"),
                    'updated_at' => null,
                    'updated_by' => null
                ]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Berhasil menyimpan data plant under carriage inspection!',
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

    public function dashboard(Request $request)
    {
        return view('SmartForm::undercarriage/dashboard');
    }

    public function getDashboardData(Request $request)
    {
        $sn               = $request->query('sn', '');
        $workOperation    = $request->query('work_operation', '');
        $inspectionDate   = $request->query('inspection_date', '');
        $sort             = $request->query('sort', 'id');
        $order            = $request->query('order', 'desc');
        $offset           = $request->query('offset', 0);
        $limit            = $request->query('limit', 10);

        try {
            $underCarriageMasterNotFiltered = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')->select('id');

            $underCarriageMaster = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')
                ->select('id', 'document_no', 'unit_model', 'unit_sn', 'unit_smr_hm', 'work_operation', 'ground_condition', 'condition_area_frame', 'inspection_date');

            if(!empty($sn)) {
                $underCarriageMaster->where('unit_sn', 'like', '%' . $sn . '%');
            }

            if(!empty($workOperation)) {
                $underCarriageMaster->where('work_operation', 'like', '%' . $workOperation . '%');
            }

            if(!empty($inspectionDate)) {
                $underCarriageMaster->where('inspection_date', $inspectionDate);
            }

            $data = $underCarriageMaster->orderBy($sort, $order)->offset($offset)
                ->limit($limit)->get();

            return response()->json([
                'total' => $data->count(),
                'totalNotFiltered' => $underCarriageMasterNotFiltered->count(),
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

    public function detail($id)
    {
        $underCarriageMasterData = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')->find($id);
        if(!$underCarriageMasterData) abort(404);

        $getComponentThirsts = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST')
            ->select('component_name', 'percentage', 'thirst_value')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', '=', 'FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT_THIRST.component_id')
            ->orderBy('FM_REFF_PLANT_UNDERCARRIAGE_COMPONENT.id', 'ASC')->get();

        $componentThirsts = [];
        $componentLabels = $getComponentThirsts->pluck('component_name')->unique();

        foreach($getComponentThirsts as $item) {
            $componentThirsts[ $item->percentage ][] = $item->thirst_value;
        }

        $components = DB::table('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE.component_id')
            ->orderBy('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE.id', 'ASC')->get();

        $componentInspections = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.inspection_component_id')
            ->whereNull('inspection_sub_component_id')->where('inspection_id', $id)
            ->orderBy('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.id', 'ASC')->get();

        $getSubComponentInspections = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')
            ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.inspection_sub_component_id')
            ->whereNotNull('inspection_sub_component_id')->where('inspection_id', $id)
            ->orderBy('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.id', 'ASC')->get()->groupBy('inspection_component_id');

        $subComponentInspections = collect([]);
        foreach($getSubComponentInspections as $componentId => $subComponents) {
            $component = DB::table('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT')
                ->where('id', $componentId)->first();

            $component->sub_components = $subComponents;
            $subComponentInspections->push($component);
        }

        $approvalPIC = DB::table('MS_FORM_PIC')->select('MS_FORM_PIC.id', 'pic_username')
            ->where('form_slug', 'plant-under-carriage-inspection')
            ->get()->map( function($pic) use($id) {
                $detailPIC = DB::connection('sqlsrv2')->table('TKaryawan')
                    ->select('TKaryawan.Nama AS nama_karyawan', 'tdepartement.Nama as nama_departement', 'tjabatan.Nama AS nama_jabatan')
                    ->join('tdepartement', 'tdepartement.KodeDP', '=', 'TKaryawan.KodeDP')
                    ->join('tjabatan', 'tjabatan.KodeJB', '=', 'TKaryawan.KodeJB')
                    ->where('TKaryawan.NIK', $pic->pic_username)->first();

                $submissionApproval = DB::table('FM_APPROVAL')->select('status', 'reason')
                    ->where('ms_form_pic_id', $pic->id)
                    ->where('submission_form_id', $id)
                    ->first();

                $pic->nama_karyawan = $detailPIC->nama_karyawan;
                $pic->nama_departement = $detailPIC->nama_departement;
                $pic->nama_jabatan = $detailPIC->nama_jabatan;
                $pic->status = $submissionApproval->status ?? null;
                $pic->reason = $submissionApproval->reason ?? null;

                return $pic;
            });

        $statusOverallApproval = 'Dalam Review';
        $approvalPIC->pluck('status')->each( function($status) use(&$statusOverallApproval) {
            if($status == 'Rejected') {
                $statusOverallApproval = 'Ditolak';
            } else if(is_null($status)) {
                $statusOverallApproval = 'Dalam Review';
            } else {
                $statusOverallApproval = 'Approved';
            }
        });

        return view('SmartForm::undercarriage/form', [
            'underCarriageMaster' => $underCarriageMasterData,
            'componentInspections' => $componentInspections,
            'subComponentInspections' => $subComponentInspections,
            'components' => $components,
            'componentThirsts' => $componentThirsts,
            'componentLabels' => $componentLabels,
            'approvalPIC' => $approvalPIC,
            'statusOverallApproval' => $statusOverallApproval
        ]);
    }

    public function downloadReport(Request $request)
    {
        $sn             = $request->query('sn', '');
        $workOperation  = $request->query('work_operation', '');
        $inspectionDate = $request->query('inspection_date', '');

        $underCarriageMaster = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_MASTER')
            ->select('id', 'document_no', 'unit_model', 'unit_sn', 'unit_smr_hm', 'work_operation', 'ground_condition', 'condition_area_frame', 'inspection_date', 'comment');

        if(!empty($sn)) {
            $underCarriageMaster->where('unit_sn', 'like', '%' . $sn . '%');
        }
        if(!empty($workOperation)) {
            $underCarriageMaster->where('work_operation', 'like', '%' . $workOperation . '%');
        }
        if(!empty($inspectionDate)) {
            $underCarriageMaster->where('inspection_date', $inspectionDate);
        }

        $spreadsheet = new Spreadsheet();
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getDefaultRowDimension()->setRowHeight(20);
        $offset = 0;

        foreach(range('B', 'M') as $column) {
            $worksheet->getColumnDimension($column)->setAutoSize(false)->setWidth(30);
        }

        $underCarriageMaster->orderBy('id', 'desc')->get()->map( function($item) use($spreadsheet, $worksheet, &$offset) {
            $indexHeader = $offset + 3;
            $worksheet->getStyle("B{$indexHeader}:M{$indexHeader}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('fec024');
            $worksheet->getCell("B{$indexHeader}")->getStyle()->getFont()->setBold(true)->setSize(16);
            $worksheet->getCell("B{$indexHeader}")->setValue("Form ID : #{$item->id}");

            $indexHead = $offset + 4;
            $indexBody = $offset + 5;

            $worksheet->getStyle("B{$indexHead}:I{$indexHead}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHead}")->setValue('Unit Model');
            $worksheet->getCell('B' . $indexBody)->setValue($item->unit_model);

            $worksheet->getCell("C{$indexHead}")->setValue('S/N Unit');
            $worksheet->getCell("C{$indexBody}")->setValue($item->unit_sn);

            $worksheet->getCell("D{$indexHead}")->setValue('SMR / Hm');
            $worksheet->getCell("D{$indexBody}")->setValue($item->unit_smr_hm);

            $worksheet->getCell("E{$indexHead}")->setValue('Work operation');
            $worksheet->getCell("E{$indexBody}")->setValue($item->work_operation);

            $worksheet->getCell("F{$indexHead}")->setValue('Ground condition');
            $worksheet->getCell("F{$indexBody}")->setValue($item->ground_condition);

            $worksheet->getCell("G{$indexHead}")->setValue('Condition Area Frame');
            $worksheet->getCell("G{$indexBody}")->setValue($item->condition_area_frame);

            $worksheet->getCell("H{$indexHead}")->setValue('Inspection Date');
            $worksheet->getCell("H{$indexBody}")->setValue($item->inspection_date);

            $worksheet->getCell("I{$indexHead}")->setValue('Comment and Summary');
            $worksheet->getCell("I{$indexBody}")->setValue($item->comment);

            $indexInspection = $offset + 7;
            $worksheet->getCell("B{$indexInspection}")->getStyle()->getFont()->setSize(14)->setBold(true);
            $worksheet->getCell("B{$indexInspection}")->setValue('Detail Form Inspection');

            $detailInspection = DB::table('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL')
                ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.inspection_component_id')
                ->leftJoin('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_SUB_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.inspection_sub_component_id')
                ->where('inspection_id', $item->id)
                ->orderBy('FM_PLANT_UNDERCARRIAGE_INSPECTION_DETAIL.id', 'asc')->get();

            $indexHeadInspection = $offset + 8;
            $worksheet->getStyle("B{$indexHeadInspection}:D{$indexHeadInspection}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHeadInspection}")->setValue('Component');
            $worksheet->getCell("C{$indexHeadInspection}")->setValue('Left Side');
            $worksheet->getCell("D{$indexHeadInspection}")->setValue('Right Side');

            $indexBodyInspection = $offset + 9;
            foreach($detailInspection as $itemInspection) {
                $worksheet->getCell("B{$indexBodyInspection}")->setValue($itemInspection->component_name . (!empty($itemInspection->sub_name) ? " - {$itemInspection->sub_name} ({$itemInspection->sub_component_name})" : ''));
                $worksheet->getCell("C{$indexBodyInspection}")->setValue($itemInspection->left_side);
                $worksheet->getCell("D{$indexBodyInspection}")->setValue($itemInspection->right_side);

                $indexBodyInspection++;

            }


            $indexTemuan = $indexBodyInspection + 1;
            $worksheet->getCell("B{$indexTemuan}")->getStyle()->getFont()->setSize(14)->setBold(true);
            $worksheet->getCell("B{$indexTemuan}")->setValue('Detail Temuan Component');

            $detailTemuan = DB::table('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE')
                ->join('FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT', 'FM_REFF_PLANT_UNDERCARRIAGE_INSPECTION_COMPONENT.id', '=', 'FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE.component_id')
                ->where('inspection_id', $item->id)
                ->orderBy('FM_PLANT_UNDERCARRIAGE_COMPONENT_ISSUE.id', 'asc')->get();

            $indexHeadTemuan = $indexBodyInspection + 2;
            $worksheet->getStyle("B{$indexHeadTemuan}:D{$indexHeadTemuan}")->applyFromArray([ 'font' => ['bold' => true] ])
                ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('f1f1f1');

            $worksheet->getCell("B{$indexHeadTemuan}")->setValue('Component');
            $worksheet->getCell("C{$indexHeadTemuan}")->setValue('Left Side');
            $worksheet->getCell("D{$indexHeadTemuan}")->setValue('Right Side');

            $indexBodyTemuan = $indexBodyInspection + 3;
            foreach($detailTemuan as $itemTemuan) {
                $worksheet->getCell("B{$indexBodyTemuan}")->setValue($itemTemuan->component_name);
                $worksheet->getCell("C{$indexBodyTemuan}")->setValue($itemTemuan->left_side);
                $worksheet->getCell("D{$indexBodyTemuan}")->setValue($itemTemuan->right_side);

                $indexBodyTemuan++;
            }

            $offset += $indexBodyTemuan + 2;
        });

        $writer = new Xlsx($spreadsheet);
        $fileName = 'report_plant_undercarriage_inspection.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
}
