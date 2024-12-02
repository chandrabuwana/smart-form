<?php

namespace Modules\SmartForm\App\Http\Controllers\FAT\PPH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;
use DB;

class PPHDashboardController extends Controller
{
    //

    function DashboardIndex()
    {
        return view("SmartForm::FAT/PPH/dashboard-pph-vendor");
    }
    function AddDatadIndex()
    {
        return view("SmartForm::FAT/PPH/upload-data-pph");
    }

    function ProcessZIPUpload(Request $r)
    {
        $r->validate([
            'zip' => 'required|file|mimes:zip',  // max size 10MB
        ]);

        $nodocPPH = DB::select("SELECT * FROM vw_master_nodocpph_FM_FAT_PPH where status = 0");
        $nodocPPH = collect($nodocPPH)->first();

        DB::beginTransaction();

        try {
            DB::table("FM_FAT_PPH_MASTER")->insert([
                "nodocpph" => $nodocPPH->nodocpph,
                "tsite" => $r->site,
                "tahun" => $r->tahun,
                "bulan" => $r->bulan,
                "created_at" => now(),
                "created_by" => session("user_id")
            ]);

            $uploadedFile = $r->file('zip');

            $zipPath = $uploadedFile->getRealPath();

            $zip = new ZipArchive();
            $pdfFiles = [];

            if ($zip->open($zipPath) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $fileName = $zip->getNameIndex($i);
                    if (pathinfo($fileName, PATHINFO_EXTENSION) === 'pdf') {
                        $parts = explode('_', $fileName);
                        // Check if the second part (NPWP) exists
                        if (isset($parts[1])) {
                            $pdfFiles[] = [
                                "nodocpph" => $nodocPPH->nodocpph,
                                "npwp" => $parts[1],
                                "potongan" => $parts[0],
                                "nama_file" => $nodocPPH->nodocpph . "_" . $parts[0] . "_" . $parts[1],
                                "created_at" => now(),
                                "created_by" => session("user_id")
                            ];
                        }
                    }
                }
                $zip->close();

                db::table("FM_FAT_PPH_DETAIL_DOCUMENT")->
                    insert($pdfFiles);
                DB::commit();

                return response()->json([
                    'message' => 'Done Induksi Tersimpan',
                    'code' => 200,
                    "codepph" => $nodocPPH->nodocpph
                ]);
            } else {
                DB::rollBack();
                return response()->json(['error' => 'Failed to open ZIP file'], 500);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to insert records: ' . $th->getMessage(),
                'code' => 500
            ]);
        }
    }

    function indexViewDataDetailMasterPPh(string $nodocpph)
    {
        $dataMaster = DB::table("FM_FAT_PPH_MASTER")->where("nodocpph", "=", $nodocpph)
        ->select("*")
        ->selectRaw("DATENAME(MONTH, DATEFROMPARTS(2024, bulan, 1)) AS nama_bulan")->get()->first();
        $dataDetail = DB::table("FM_FAT_PPH_DETAIL_DOCUMENT")->where("nodocpph", "=", $nodocpph)->get();

        // dd($dataMaster);
        $dataKirim = [
            "dataMaster" => $dataMaster,
            "dataDetail" => $dataDetail
        ];
        return view("SmartForm::FAT/PPH/detail-master-pph-vendor", $dataKirim);
    }

}

