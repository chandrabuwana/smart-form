<?php

namespace App\Console\Commands\Doco;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class ImportExisting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-existing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = 'LOGISTIK';
        $site = 'JKT';
        $kodeDP = 'MM';
        $NIK = '1016048';

        $tipeDocs = [ 'FRM', 'SOP', 'WI', 'STD' ];
        DB::beginTransaction();

        try {
            foreach($tipeDocs as $tipe) {
                $dirPath = storage_path('app/' . $folder . '/' . $tipe);
                if( !file_exists($dirPath) ) {
                    continue;
                }

                $files = scandir($dirPath);
                foreach($files as $fileName) {
                    if( $fileName == '.' || $fileName == '..' ) {
                        continue;
                    }

                    $expFileName = explode(' ', $fileName);
                    $noDoc = trim($expFileName[0]);
                    $title = str_replace('.pdf', '', trim( str_replace($noDoc, '', $fileName) ));
                    $filePath = 'dokumen_mutu/' . 'pembuatan/' . $kodeDP;

                    // check if PDF is using compression teknik
                    // $fileRawContent = file_get_contents($dirPath .'/'.$fileName);
                    // if( preg_match('/Filter\/DCTDecode/i', $fileRawContent) ) {
                    //     continue;
                    // }

                    copy( $dirPath .'/'.$fileName, storage_path('app/public/' . $filePath . '/' . $fileName) );
                    // $tempFilePath = $request->file('dokumenTervalidasi')->storeAs($path, $originalName);
                    $tempFilePath = storage_path('app/public/' . $filePath . '/' . $fileName);
                    $convertedFilePath = str_replace($fileName, 'converted_' . $fileName, $tempFilePath);

                    putenv('PATH=' . env('DOCO_GS_PATH'));
                    shell_exec('gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile="' . $convertedFilePath . '" "' . $tempFilePath . '"');

                    $mpdf = new Mpdf();
                    $pageCount = $mpdf->setSourceFile($convertedFilePath);

                    for($i=1; $i <= $pageCount; $i++) {
                        $tplIdx = $mpdf->ImportPage($i);

                        $mpdf->SetWatermarkText('Preview Only');
                        $mpdf->showWatermarkText = true;

                        $mpdf->AddPage();
                        $mpdf->useTemplate($tplIdx, 10, 10, 200);
                    }

                    $previewTempFilePath = str_replace($fileName, 'preview_' . $fileName, $tempFilePath);
                    $mpdf->OutputFile($previewTempFilePath);

                    $fileContent = file_get_contents($convertedFilePath);
                    Storage::disk('s3')->put($filePath .'/'. $fileName, $fileContent);

                    $previewFileContent = file_get_contents($previewTempFilePath);
                    Storage::disk('s3')->put($filePath .'/preview_'. $fileName, $previewFileContent);

                    @unlink($previewTempFilePath);
                    @unlink($tempFilePath);
                    @unlink($convertedFilePath);

                    DB::table('DB_Dokumen_Mutu.dbo.T_Dokumen_Mutu')->insert([
                        'nik_pembuat' => $NIK,
                        'no_dokumen' => $noDoc,
                        'judul_dokumen' => $title,
                        'jenis_dokumen' => $tipe,
                        'file_path' => $filePath . '/' . $fileName,
                        'status' => 'Aktif',
                        'kode_site' => $site,
                        'no_revisi' => 1,
                        'created_at' => now(),
                    ]);

                    echo "Dokumen #{$noDoc} berhasil di proses! \n";
                }
            }

            DB::commit();

        } catch(\Throwable $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
