<?php

namespace Modules\SmartForm\App\Http\Controllers\SmartPica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class TransactionPicaController extends Controller
{
    //

    function AddDataTransactionPica(Request $d)
    {
        $dataInputer = $d;

        $dataMasterTahun = $dataInputer->dataMaster['tahun'];
        $dataMasterBulan = $dataInputer->dataMaster['bulan'];
        $dataMasterWeek = $dataInputer->dataMaster['week'];
        $dataMasterSite = $dataInputer->dataMaster['site'];
        $dataMasterDept = $dataInputer->dataMaster['dept'];
        $dataMasterLeadKpi = $dataInputer->dataMaster['lead_kpi'];
        $dataMasterActual = $dataInputer->dataMaster['actual'];
        $dataMasterTarget = $dataInputer->dataMaster['target'];
        $dataMasterApPica = $dataInputer->dataMaster['ap_pica'];
        $dataMasterProblem = $dataInputer->dataMaster['problem'];
        $dataMasterKategori = $dataInputer->dataMaster['kategori'];
        $dataMasterEstimasiPica = $dataInputer->dataMaster['estimasi_pica'];


        $dataWhy1 = $dataInputer->dataWhy1;
        $dataWhy2 = $dataInputer->dataWhy2;
        $dataWhy3 = $dataInputer->dataWhy3;
        $dataWhy4 = $dataInputer->dataWhy4;
        $dataWhy5 = $dataInputer->dataWhy5;


        $inputs = [
            $dataMasterTahun,
            $dataMasterBulan,
            $dataMasterWeek,
            $dataMasterDept,
            $dataMasterSite,
            $dataMasterLeadKpi,
            $dataMasterActual,
            $dataMasterTarget,
            $dataMasterApPica,
            $dataMasterProblem,
            $dataMasterKategori,
            $dataMasterEstimasiPica
        ];

        foreach ($inputs as $input) {
            if (!$this->validateInput($input)) {
                return [
                    'message' => "Error Input Data Master",
                    'code' => 500
                ];
            }
        }

        $dataWhyArrays = [$dataWhy1, $dataWhy2, $dataWhy3, $dataWhy4, $dataWhy5];

        foreach ($dataWhyArrays as $dataWhyArray) {
            if (is_array($dataWhyArray) || is_object($dataWhyArray)) {
                foreach ($dataWhyArray as $object) {
                    if ($object === null) {
                        continue;
                    }

                    if (!$this->validateObject($object)) {
                        return [
                            'message' => "Error Input Data",
                            'code' => 500
                        ];
                    }
                }
            }
        }
        $getData = DB::select('select * from vw_master_nodoc where statusx = 0');

        $dataDocumentNumeber = $getData[0]->nodoc;

        $dataNIK = session("user_id");
        DB::beginTransaction();

        try {
            $idMaster = DB::table('master_pica')->insertGetId([
                'nik' => $dataNIK,
                'nodocpica' => $dataDocumentNumeber,
                'tahun' => $dataMasterTahun,
                'bulan' => $dataMasterBulan,
                'week' => $dataMasterWeek,
                'dept' => $dataMasterDept,
                'site' => $dataMasterSite,
                'id_kpi' => $dataMasterLeadKpi,
                'problem' => $dataMasterProblem,
                'id_kategory' => $dataMasterKategori,
                'ap_pica' => $dataMasterApPica,
                'actual_master' => $dataMasterActual,
                'target_master' => $dataMasterTarget,
                'solution_estimation' => $dataMasterEstimasiPica,
                'created_at' => now(),
                'updated_at' => now(),
                'updated_by' => session("user_id"),
                'created_by' => session("user_id"),
                'approval' => 'pending',
                'status' => 1
            ]);



            if ($idMaster) {
                $dataWhy1 = $dataInputer->dataWhy1 ?? [];
                if (is_array($dataWhy1) && !empty($dataWhy1)) {
                    foreach ($dataWhy1 as $data) {

                        DB::table('pica_why1')->insert([
                            'id_master' => $idMaster, // Adjust as per your application logic
                            'nik_master' => $dataNIK, // Adjust as per your application logic
                            'nodocpica' => $dataDocumentNumeber, // Adjust as per your application logic
                            'index_w1' => $data['w1'],
                            'why' => $data['masalah'],
                            'id_kategory' => $data['kategori'],
                            'created_at' => now(),
                            'updated_at' => now(),
                            'updated_by' => session("user_id"), // Example value, replace with actual value
                            'created_by' => session("user_id"), // Example value, replace with actual value
                        ]);
                    }
                }

                $dataWhy2 = $dataInputer->dataWhy2 ?? [];
                if (is_array($dataWhy2) && !empty($dataWhy2)) {
                    foreach ($dataWhy2 as $data) {

                        DB::table('pica_why2')->insert([
                            'id_master' => $idMaster, // Adjust as per your application logic
                            'nik_master' => $dataNIK, // Adjust as per your application logic
                            'nodocpica' => $dataDocumentNumeber, // Adjust as per your application logic
                            'index_w1' => $data['w1'],
                            'index_w2' => $data['w2'],
                            'why' => $data['masalah'],
                            'id_kategory' => $data['kategori'],
                            'created_at' => now(),
                            'updated_at' => now(),
                            'updated_by' => session("user_id"), // Example value, replace with actual value
                            'created_by' => session("user_id"), // Example value, replace with actual value
                        ]);
                    }
                }

                $dataWhy3 = $dataInputer->dataWhy3 ?? [];
                if (is_array($dataWhy3) && !empty($dataWhy3)) {
                    foreach ($dataWhy3 as $data) {

                        DB::table('pica_why3')->insert([
                            'id_master' => $idMaster, // Adjust as per your application logic
                            'nik_master' => $dataNIK, // Adjust as per your application logic
                            'nodocpica' => $dataDocumentNumeber, // Adjust as per your application logic
                            'index_w1' => $data['w1'],
                            'index_w2' => $data['w2'],
                            'index_w3' => $data['w3'],
                            'why' => $data['masalah'],
                            'id_kategory' => $data['kategori'],
                            'created_at' => now(),
                            'updated_at' => now(),
                            'updated_by' => session("user_id"), // Example value, replace with actual value
                            'created_by' => session("user_id"), // Example value, replace with actual value
                        ]);
                    }
                }

                $dataWhy4 = $dataInputer->dataWhy4 ?? [];
                if (is_array($dataWhy4) && !empty($dataWhy4)) {
                    foreach ($dataWhy4 as $data) {

                        DB::table('pica_why4')->insert([
                            'id_master' => $idMaster, // Adjust as per your application logic
                            'nik_master' => $dataNIK, // Adjust as per your application logic
                            'nodocpica' => $dataDocumentNumeber, // Adjust as per your application logic
                            'index_w1' => $data['w1'],
                            'index_w2' => $data['w2'],
                            'index_w3' => $data['w3'],
                            'index_w4' => $data['w4'],
                            'why' => $data['masalah'],
                            'id_kategory' => $data['kategori'],
                            'created_at' => now(),
                            'updated_at' => now(),
                            'updated_by' => session("user_id"), // Example value, replace with actual value
                            'created_by' => session("user_id"), // Example value, replace with actual value
                        ]);
                    }
                }

                $dataWhy5 = $dataInputer->dataWhy5 ?? [];
                if (is_array($dataWhy5) && !empty($dataWhy5)) {
                    foreach ($dataWhy5 as $data) {

                        DB::table('pica_why5')->insert([
                            'id_master' => $idMaster, // Adjust as per your application logic
                            'nik_master' => $dataNIK, // Adjust as per your application logic
                            'nodocpica' => $dataDocumentNumeber, // Adjust as per your application logic
                            'index_w1' => $data['w1'],
                            'index_w2' => $data['w2'],
                            'index_w3' => $data['w3'],
                            'index_w4' => $data['w4'],
                            'index_w5' => $data['w5'],
                            'why' => $data['masalah'],
                            'id_kategory' => $data['kategori'],
                            'created_at' => now(),
                            'updated_at' => now(),
                            'updated_by' => session("user_id"), // Example value, replace with actual value
                            'created_by' => session("user_id"), // Example value, replace with actual value
                        ]);
                    }
                }
            }

            DB::commit();

            return [
                'message' => "Data Tersimpan",
                'code' => 200,
                'nodoc' => $dataDocumentNumeber
            ];

        } catch (QueryException $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return [
                'message' => 'Failed to insert records' . $e->getMessage(),
                'code' => 500
            ];
        }



    }

    function validateObject($object)
    {
        foreach ($object as $key => $value) {
            if (!$this->validateInput($value)) {
                return false;
            }
        }
        return true;
    }

    function validateInput($input)
    {
        $queryPattern = "/select|insert|update|delete|drop|alter|truncate|exec|union|sql/i";
        if (preg_match($queryPattern, $input)) {
            return false;
        }
        return true;
    }

    function addDataStepTransactionPica(Request $q)
    {
        $nodocpica = "";
        $nik_master = "";
        DB::beginTransaction();
        try {
            foreach ($q->data as $d) {
                $dataObject = $d['dataSolution'];
                if ($this->isValidData($dataObject)) {
                    foreach ($dataObject as $item) {
                        if ($nodocpica == "") {
                            $nodocpica = $d['nodocWhy'];
                            $nik_master = $d['nikMaster'];
                        }
                        if ($item['edit']) {
                            DB::table("new_pica_step")
                                ->where([
                                    "id" => $item['edit'],
                                    'id_master' => $d['idMaster'],
                                    'nik_master' => $d['nikMaster'],
                                    'nodocpica' => $d['nodocWhy'],
                                    'position_why' => $d['idWhy']
                                ])
                                ->update([
                                    'action' => $item['action'],
                                    'note_step' => $item['note'],
                                    'ap_tod' => $item['ap_tod'],
                                    'dic' => $item['dic'],
                                    'pic' => $item['pic'],
                                    'due_date' => $item['dueDate'],
                                    'approver' => $item['atasan'],
                                    'updated_at' => now(),
                                    'updated_by' => session("user_id"),
                                ]);
                        } else {
                            DB::table('new_pica_step')->insert([
                                'id_master' => $d['idMaster'],
                                'nik_master' => $d['nikMaster'],
                                'nodocpica' => $d['nodocWhy'],
                                'position_why' => $d['idWhy'],
                                'identity_why' => $d['identityWhy'],
                                'action' => $item['action'],
                                'note_step' => $item['note'],
                                'ap_tod' => $item['ap_tod'],
                                'dic' => $item['dic'],
                                'pic' => $item['pic'],
                                'due_date' => $item['dueDate'],
                                'approver' => $item['atasan'],
                                'created_at' => now(),
                                'created_by' => session("user_id"), // Example value, replace with actual value
                            ]);
                        }

                    }
                } else {
                    return [
                        'message' => 'Failed to insert records - mohon hilangi spesial character',
                        'code' => 500
                    ];
                }
            }


            DB::table('master_pica')
                ->where('nodocpica', $nodocpica)
                ->where('nik', $nik_master)
                ->update(['status' => 2]);


        } catch (QueryException $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return [
                'message' => 'Failed to insert records' . $e->getMessage(),
                'code' => 500
            ];
        }

        DB::commit();

        return [
            'message' => "Solution Tersimpan",
            'code' => 200
        ];
    }

    function changeSolutionPIC(Request $r)
    {
        // dd($r);
        try {
            DB::table("new_pica_step")
                ->where([
                    "id" => $r->id,
                    "id_master" => $r->id_master,
                    "nodocpica" => $r->nodocpica,
                    "nik_master" => $r->nikMaster
                ])
                ->update([
                    'action' => $r->action,
                    'note_step' => $r->note,
                    'ap_tod' => $r->ap_pica,
                    'dic' => $r->dic,
                    'pic' => $r->pic,
                    'due_date' => $r->duedate,
                    'approver' => $r->atasan,
                    'updated_at' => now(),
                    'updated_by' => session("user_id"),
                ]);

            DB::commit();
            return [
                'message' => "Solution Tersimpan",
                'code' => 200
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'message' => 'Failed to insert records',
                'code' => 500
            ];
        }
    }

    function isValidData($data)
    {
        // Define a pattern that allows only alphanumeric characters and some special characters like spaces, hyphens, underscores, etc.
        $pattern = '/<script.*?>|<\/script>|--|;|#|\/\*|\*\/|UNION|SELECT|INSERT|DELETE|UPDATE|DROP|;|\bOR\b|\bAND\b/i';

        foreach ($data as $item) {
            foreach ($item as $key => $value) {
                // Skip validation for date fields
                if (stripos($key, 'date') !== false) {
                    continue;
                }
                if (preg_match($pattern, $value)) {
                    return false;
                }
            }
        }
        return true;
    }


    function addTransactionProgressStepSolutionPica(Request $d)
    {
        $params = $d->only(['noteProgress', 'ccpLink', 'progress']);


        $checkDataExisting = DB::table('history_progress_solution')
            ->where([
                ['nodocpica', '=', $d->nodocpica],
                ['id_solution', '=', $d->idSolution],
                ['created_by', '=', session('user_id')]
            ])->select("max progress")
            ->max('progress');

        if (isset($checkDataExisting) && $checkDataExisting > $d->progress) {
            return [
                'message' => 'Tidak boleh mengisikan progress lebih kecil',
                'code' => 500
            ];
        }

        DB::beginTransaction();

        try {
            DB::table('history_progress_solution')->insert([
                'id_master' => $d->idMaster,
                'id_solution' => $d->idSolution,
                'nik_master' => $d->nikMaster,
                'nodocpica' => $d->nodocpica,
                'position_why' => $d->positionWhy,
                'identity_why' => $d->identityWhy,
                'note_progress' => $d->noteProgress,
                'ccp' => $d->ccpLink,
                'progress' => $d->progress,
                'created_at' => now(),
                'created_by' => session("user_id")
            ]);

            if ($d->last == "true") {
                DB::table("new_pica_step")
                    ->where("id", $d->idSolution)
                    ->update(["acceptance" => 9]);
            }

            DB::table('master_pica')
                ->where('nodocpica', $d->nodocpica)
                ->where('nik', $d->nikMaster)
                ->update(['status' => 3]);

            DB::commit();

            return [
                'message' => "Progress Tersimpan",
                'code' => 200
            ];


        } catch (QueryException $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return [
                'message' => 'Failed to insert records' . $e->getMessage(),
                'code' => 500
            ];
        }

    }

    function deleteTransactionProgressStepSolutionPica(Request $d)
    {

        DB::beginTransaction();

        try {
            DB::table('history_progress_solution')
                ->where('id', $d->id)
                ->delete();
            DB::commit();

            return [
                'message' => "Progress Terhapus",
                'code' => 200
            ];


        } catch (QueryException $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return [
                'message' => 'Failed to insert records' . $e->getMessage(),
                'code' => 500
            ];
        }

    }

    function changeAcceptanceStepSolutionPica(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
            DB::table("new_pica_step")
                ->where('id', $request->id)
                ->update(['acceptance' => $request->hasil]);

            if ($request->hasil == 2) {
                DB::table("new_pica_step")
                    ->where('id', $request->id)
                    ->update(['acceptance_reason' => $request->reason]);
            }
            DB::commit();
            return [
                'message' => "Data Tersimpan",
                'code' => 200
            ];
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return [
                'message' => 'Failed to insert records',
                'code' => 500
            ];
        }
    }

    function ApproveClosingTask(Request $request)
    {

        $dataDetail = DB::table("new_pica_step")->where("id", $request->id)->first();

        DB::beginTransaction();
        try {
            if ($dataDetail->approver == session("user_id")) {
                if ($request->hasil == "true") {
                    DB::table("new_pica_step")->where("id", $request->id)->
                        update(["status_approve" => 1]);
                } else {
                    $maxProgress = DB::table('history_progress_solution')
                        ->where('id_solution', $request->id)
                        ->where('status_reject', 0)
                        ->max('progress');

                    DB::table('history_progress_solution')
                        ->where('id_solution', $request->id)
                        ->where('status_reject', 0)
                        ->where('progress', $maxProgress)
                        ->update([
                            "status_reject" => 1,
                            "keterangan_reject" => "By ATASAN - " . $request->keterangan
                        ]);
                    DB::table("new_pica_step")->where("id", $request->id)->
                        update(["acceptance" => 1]);
                }
                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];



            } else {
                return [
                    'message' => 'Kamu tidak punya akses',
                    'code' => 500
                ];
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'message' => 'Failed to insert records',
                'code' => 500
            ];
        }
    }
    function ApproveMasterPica(Request $request)
    {

        DB::beginTransaction();
        try {
            if ($request->hasil == "true") {
                DB::table("master_pica")->where("nodocpica", $request->id)
                    ->update([
                        "approval" => "approved"
                    ]);
            } else {
                DB::table("master_pica")->where("nodocpica", $request->id)
                    ->update([
                        "approval" => "rejected",
                        "keterangan_reject" => "BY " . session("username") . " : " . $request->keterangan
                    ]);
            }
            DB::commit();
            return [
                'message' => "Data Tersimpan",
                'code' => 200
            ];

        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'message' => 'Failed to insert records',
                'code' => 500
            ];
        }
    }

    function UpdateMasterPica(Request $r)
    {
        DB::beginTransaction();
        try {
            foreach ($r->dataHapus as $key => $d) {
                DB::table("pica_why" . $d['identity_why'])->where([
                    "id_master" => $d['idMaster_why'], // akses elemen array dengan tanda kurung
                    "id" => $d['id_why']
                ])->delete();

                DB::table("new_pica_step")
                    ->where([
                        "id_master" => $d['idMaster_why'],
                        "position_why" => $d['id_why'],
                        "identity_why" => $d['identity_why']
                    ])
                    ->delete();
            }
            DB::commit();
            return [
                'message' => "Data Telah Terhapus",
                'code' => 200
            ];

        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'message' => 'Failed to insert records',
                'code' => 500
            ];
        }
    }

    function AddWhySpesificData(Request $r)
    {

        DB::beginTransaction();

        DB::table("new_pica_step")
            ->where([
                "nodocpica" => $r->nodocpica,
                "position_why" => $r->id,
                "identity_why" => $r->identity,
                "id_master" => $r->master
            ])->delete();

        if ($r->identity == 0) {
            try {
                $dataTerakhirWhy = DB::table("pica_why1")->where([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                ])->orderBy("index_w1", "desc")->first();

                DB::table("pica_why1")->insert([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => ($dataTerakhirWhy ? $dataTerakhirWhy->index_w1 + 1 : 1),
                    "why" => $r->why,
                    "id_kategory" => $r->kategory,
                    "created_at" => now(),
                    "created_by" => session("user_id"),
                    "updated_at" => now(),
                    "updated_by" => session("user_id"),
                    "identity" => 1
                ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 1) {
            try {
                $dataTerakhirWhy = DB::table("pica_why2")->where([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                ])->orderBy("index_w2", "desc")->first();
                if ($dataTerakhirWhy && $dataTerakhirWhy->index_w2 == 5) {
                    return [
                        'message' => 'Sudah melebihi quota',
                        'code' => 500
                    ];
                }
                DB::table("pica_why2")->insert([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => ($dataTerakhirWhy ? $dataTerakhirWhy->index_w2 + 1 : 1),
                    "why" => $r->why,
                    "id_kategory" => $r->kategory,
                    "created_at" => now(),
                    "created_by" => session("user_id"),
                    "updated_at" => now(),
                    "updated_by" => session("user_id"),
                    "identity" => 2
                ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 2) {
            try {

                $dataTerakhirWhy = DB::table("pica_why3")->where([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => $r->w2,
                ])->orderBy("index_w3", "desc")->first();
                if ($dataTerakhirWhy && $dataTerakhirWhy->index_w3 == 5) {
                    return [
                        'message' => 'Sudah melebihi quota',
                        'code' => 500
                    ];
                }

                DB::table("pica_why3")->insert([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => $r->w2,
                    "index_w3" => ($dataTerakhirWhy ? $dataTerakhirWhy->index_w3 + 1 : 1),
                    "why" => $r->why,
                    "id_kategory" => $r->kategory,
                    "created_at" => now(),
                    "created_by" => session("user_id"),
                    "updated_at" => now(),
                    "updated_by" => session("user_id"),
                    "identity" => 3
                ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 3) {
            try {
                $dataTerakhirWhy = DB::table("pica_why4")->where([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => $r->w2,
                    "index_w3" => $r->w3,
                ])->orderBy("index_w4", "desc")->first();
                if ($dataTerakhirWhy && $dataTerakhirWhy->index_w4 == 5) {
                    return [
                        'message' => 'Sudah melebihi quota',
                        'code' => 500
                    ];
                }
                DB::table("pica_why4")->insert([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => $r->w2,
                    "index_w3" => $r->w3,
                    "index_w4" => ($dataTerakhirWhy ? $dataTerakhirWhy->index_w4 + 1 : 1),
                    "why" => $r->why,
                    "id_kategory" => $r->kategory,
                    "created_at" => now(),
                    "created_by" => session("user_id"),
                    "updated_at" => now(),
                    "updated_by" => session("user_id"),
                    "identity" => 4
                ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 4) {
            try {
                $dataTerakhirWhy = DB::table("pica_why5")->where([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => $r->w2,
                    "index_w3" => $r->w3,
                    "index_w4" => $r->w4,
                ])->orderBy("index_w5", "desc")->first();
                if ($dataTerakhirWhy && $dataTerakhirWhy->index_w5 == 5) {
                    return [
                        'message' => 'Sudah melebihi quota',
                        'code' => 500
                    ];
                }
                DB::table("pica_why5")->insert([
                    "id_master" => $r->master,
                    "nik_master" => $r->nik,
                    "nodocpica" => $r->nodocpica,
                    "index_w1" => $r->w1,
                    "index_w2" => $r->w2,
                    "index_w3" => $r->w3,
                    "index_w4" => $r->w4,
                    "index_w5" => ($dataTerakhirWhy ? $dataTerakhirWhy->index_w5 + 1 : 1),
                    "why" => $r->why,
                    "id_kategory" => $r->kategory,
                    "created_at" => now(),
                    "created_by" => session("user_id"),
                    "updated_at" => now(),
                    "updated_by" => session("user_id"),
                    "identity" => 5
                ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }

        } else {
            return [
                'message' => 'Failed Please Contact Admin',
                'code' => 500
            ];
        }
    }

    function EditWhySpesificData(Request $r)
    {
        DB::beginTransaction();
        if ($r->identity == 1) {
            try {
                DB::table("pica_why1")->where([
                    "id" => $r->id,
                    "identity" => $r->identity,
                    "nodocpica" => $r->nodocpica,
                ])->update([
                            "why" => $r->why,
                            "id_kategory" => $r->kategori,
                        ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 2) {
            try {
                $dataTerakhirWhy = DB::table("pica_why2")->where([
                    "id" => $r->id,
                    "identity" => $r->identity,
                    "nodocpica" => $r->nodocpica,
                ])->update([
                            "why" => $r->why,
                            "id_kategory" => $r->kategori,
                        ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 3) {
            try {
                $dataTerakhirWhy = DB::table("pica_why3")->where([
                    "id" => $r->id,
                    "identity" => $r->identity,
                    "nodocpica" => $r->nodocpica,
                ])->update([
                            "why" => $r->why,
                            "id_kategory" => $r->kategori,
                        ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 4) {
            try {
                // dd($r);
                $dataTerakhirWhy = DB::table("pica_why4")->where([
                    "id" => $r->id,
                    "identity" => $r->identity,
                    "nodocpica" => $r->nodocpica,
                ])->update([
                            "why" => $r->why,
                            "id_kategory" => $r->kategori,
                        ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }
        } else if ($r->identity == 5) {
            try {
                $dataTerakhirWhy = DB::table("pica_why5")->where([
                    "id" => $r->id,
                    "identity" => $r->identity,
                    "nodocpica" => $r->nodocpica,
                ])->update([
                            "why" => $r->why,
                            "id_kategory" => $r->kategori,
                        ]);

                DB::commit();
                return [
                    'message' => "Data Tersimpan",
                    'code' => 200
                ];

            } catch (\Throwable $th) {
                DB::rollBack();
                return [
                    'message' => 'Failed to insert records',
                    'code' => 500
                ];
            }

        } else {
            return [
                'message' => 'Failed Please Contact Admin',
                'code' => 500
            ];
        }
    }

    function checkDataStep(Request $r)
    {
        try {
            $dataList = DB::table("new_pica_step")
                ->where([
                    "id_master" => $r->id_master,
                    "nik_master" => $r->nik_master,
                    "nodocpica" => $r->nodocWhy,
                    "position_why" => $r->id_why,
                    "identity_why" => $r->identity
                ])->select()->get();

            return [
                "data" => $dataList,
                "code" => 200
            ];
        } catch (\Throwable $th) {
            return [
                'message' => 'Failed Please Contact Admin',
                'code' => 500
            ];
        }

    }

    function ChangeFlagRevision(Request $r)
    {
        DB::beginTransaction();
        try {
            DB::table("master_pica")->
                where("nodocpica", "=", $r->nodocpica)
                ->update([
                    "approval" => "pending",
                    "updated_by" => session("user_id"),
                    "updated_at" => now()
                ]);
            DB::commit();
            return [
                'message' => "Data Tersimpan",
                'code' => 200
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return [
                'message' => 'Failed to insert records',
                'code' => 500
            ];
        }
    }
}

