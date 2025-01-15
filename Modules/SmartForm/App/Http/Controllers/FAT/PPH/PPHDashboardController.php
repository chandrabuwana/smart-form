<?php

namespace Modules\SmartForm\App\Http\Controllers\FAT\PPH;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ZipArchive;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PPHDashboardController extends Controller
{
    protected const T_PPH_MASTER = 'PICA.dbo.FM_FAT_PPH_MASTER';
    protected const V_NODOC_PPH = 'PICA.dbo.vw_master_nodocpph_FM_FAT_PPH';
    protected const T_PPH_DETAIL_DOC = 'PICA.dbo.FM_FAT_PPH_DETAIL_DOCUMENT';

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

        $nodocPPH = DB::select("SELECT * FROM " . self::V_NODOC_PPH . " where status = 0");
        $nodocPPH = collect($nodocPPH)->first();

        DB::beginTransaction();

        try {
            DB::table(self::T_PPH_MASTER)->insert([
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
                            $filecontent = $zip->getStreamIndex($i);
                            $filename = $nodocPPH->nodocpph . "_" . $parts[0] . "_" . $parts[1] .'.'. $parts[ count($parts) - 1 ];
                            $bucketPath = 'pph/' . $nodocPPH->nodocpph . '/' . $filename;
                            Storage::disk('s3')->put($bucketPath, $filecontent);

                            $pdfFiles[] = [
                                "nodocpph" => $nodocPPH->nodocpph,
                                "npwp" => $parts[1],
                                "potongan" => $parts[0],
                                "nama_file" => $filename,
                                "created_at" => now(),
                                "created_by" => session("user_id")
                            ];
                        }
                    }
                }
                $zip->close();

                db::table(self::T_PPH_DETAIL_DOC)->
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
            Log::error($th);
            return response()->json([
                'message' => 'Failed to insert records: ' . $th->getMessage(),
                'code' => 500
            ]);
        }
    }

    function indexViewDataDetailMasterPPh(string $nodocpph)
    {
        $dataMaster = DB::table(self::T_PPH_MASTER)->where("nodocpph", "=", $nodocpph)
        ->select("*")
        ->selectRaw("DATENAME(MONTH, DATEFROMPARTS(2024, bulan, 1)) AS nama_bulan")->get()->first();
        $dataDetail = DB::table(self::T_PPH_DETAIL_DOC)->where("nodocpph", "=", $nodocpph)->get();

        // dd($dataMaster);
        $dataKirim = [
            "dataMaster" => $dataMaster,
            "dataDetail" => $dataDetail
        ];
        return view("SmartForm::FAT/PPH/detail-master-pph-vendor", $dataKirim);
    }

    function indexViewDetailDocument($id, Request $r)
    {
        $dataMaster = DB::table(self::T_PPH_DETAIL_DOC)->select(self::T_PPH_MASTER . '.*', self::T_PPH_DETAIL_DOC . '.nama_file')
            ->selectRaw("DATENAME(MONTH, DATEFROMPARTS(2024, bulan, 1)) AS nama_bulan")
            ->join(self::T_PPH_MASTER, self::T_PPH_MASTER . '.nodocpph', self::T_PPH_DETAIL_DOC . '.nodocpph')
            ->where(self::T_PPH_DETAIL_DOC . '.id', $id)->first();

        $docBucketPath = 'pph/' . $dataMaster->nodocpph . '/' . $dataMaster->nama_file;
        $docUrl = Storage::disk('s3')->temporaryUrl($docBucketPath, Carbon::now()->addMinutes(5));

        return view("SmartForm::FAT/PPH/detail-document", [
            'dataMaster' => $dataMaster,
            'docUrl' => $docUrl
        ]);
    }

}

