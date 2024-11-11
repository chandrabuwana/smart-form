<?php

namespace Modules\SmartForm\App\Http\Controllers\GS;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Lcobucci\JWT\Validation\ConstraintViolation;
use Illuminate\Support\Str;

class VendorController extends Controller {
    private const DB_CONN_NAME = 'sqlsrv';
    private const BASE_DB  = "PICA_BETA.dbo.";
    private const TABLE_MASTER = 'SCT_GS_VENDOR_MST';
    private const TABLE_MAPPING_MAKAN_VENDOR = 'SCT_GS_VENDOR_MAPPING';
    private const TABLE_MAPPING_MAKAN_VENDOR_DAY = 'SCT_GS_VENDOR_MAPPING_DAY';
    private const TABLE_LOKASI = "SCT_GS_MESS_MST";

    public function DashboardVendor(Request $request) {
        return view('SmartForm::GS/vendor/dashboard-vendor');
    }

    public function ListVendor(Request $request) {
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];
        $isSuccess = false;
        $message = '';
        $errorMessage = '';

        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);
        $filterSite = $request->query('site', null); 

        try {
            $sql_master_data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER)
                ->select(
                    'id', 'Nama as nama', 'Status as status', 'Alamat as alamat', 
                    'Kelurahan as kelurahan', 'Kecamatan as kecamatan', 'Kota as kota', 'Telepon as telepon', 
                    'Website as website', 'Email as email', 'Kontak as kontak', 'Keterangan as keterangan',
                    'KodeSite as site'
                );

                if($filterSite == null || $filterSite == 'null') {
                } else {
                    $sql_master_data->where('KodeSite', $filterSite);
                }

            $jml = $sql_master_data->count();

            // if($limit == null || $limit == 'null' || $limit == '') {
            //     $sql_master_data->skip($offset);
            // } else {
            //     $sql_master_data->skip($offset)->limit($limit);
            // }
            $master_data = $sql_master_data->get();
            // foreach($master_data as $data) {
            //     $data->email = $this->maskEmail($data->email);
            // }

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $master_data
            ];
            $message= "Ok";
            $isSuccess = true;
        }  catch (Exception $ex) {
            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';
            $errorMessage = [$message];

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function AddVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'email' => ['required', 'email'], 
                'site' => ['required'], 
                'nama' => ['required'], 
                // 'id' => ['required']
            ],
            [
                'email.email' => 'Email tidak valid',
                'email.required' => 'Email wajib diisi',
                'site.required' => 'Site wajib diisi',
                'nama.required' => 'Nama wajib diisi',
                // 'id.required' => 'ID Vendor Mess wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();
        
        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            $data_input = [
                'KodeSite' => $request->input('site'),
                // 'id' => $request->input('id'),
                'Nama' => $request->input('nama'),
                'Alamat' => $request->input('alamat'),
                'Kelurahan' => $request->input('kelurahan'),
                'Kecamatan' => $request->input('kecamatan'),
                'Kota' => $request->input('kota'),
                'Telepon' => $request->input('telepon'),
                'Website' => $request->input('website'),
                'Email' => $request->input('email'),
                'Kontak' => $request->input('kontak'),
                'Status' => '1',
                'Keterangan' => $request->input('keterangan'),
                'created_at' => now(),
                'created_by' => $nik_session,
                'pwd' => Hash::make('password')
            ];

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();

                $sql_insert_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER)
                    ->insert($data_input);

                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Ok";
                $isSuccess = true;
            } catch (Exception $ex) {
                if ($ex instanceof QueryException) {
                    if($ex->getCode() == 23000) {
                        $message = "ID Vendor sudah ada";
                        $errorMessage = [$message];
                    } else {
                        $message = "Terjadi kesalahan, coba beberapa saat lagi";
                        $errorMessage = [$message];
                    }
                } else {
                    $message = "Terjadi kesalahan, coba beberapa saat lagi";
                    $errorMessage = [$message];

                }

                DB::connection(self::DB_CONN_NAME)->rollBack();


                Log::error(get_class($ex). " | ". $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }

        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function EditVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'email' => ['required', 'email'], 
                // 'site' => ['required'], 
                'nama' => ['required'], 
                'id' => ['required']
            ],
            [
                'email.email' => 'Email tidak valid',
                'email.required' => 'Email wajib diisi',
                // 'site.required' => 'Site wajib diisi',
                'nama.required' => 'Nama wajib diisi',
                'id.required' => 'ID Vendor Mess wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            $data_input = [
                // 'KodeSite' => $request->input('site'),
                'id' => $request->input('id'),
                'Nama' => $request->input('nama'),
                'Alamat' => $request->input('alamat'),
                'Kelurahan' => $request->input('kelurahan'),
                'Kecamatan' => $request->input('kecamatan'),
                'Kota' => $request->input('kota'),
                'Telepon' => $request->input('telepon'),
                'Website' => $request->input('website'),
                'Email' => $request->input('email'),
                'Kontak' => $request->input('kontak'),
                'Status' => '0',
                'Keterangan' => $request->input('keterangan'),
                'updated_at' => now(),
                'updated_by' => $nik_session
            ];

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id = $request->input('id');
                unset($data_input['id']);

                $sql_insert_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER)
                    ->where('id', $id)
                    ->update($data_input);

                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Ok";
                $isSuccess = true;
            } catch (Exception $ex) {

                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::connection(self::DB_CONN_NAME)->rollBack();


                Log::error(get_class($ex). " | ". $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);

    }

    private function checkMappingVendorExist($id_vendor, $site, $jenis_pemesanan, $lokasi) {
        $isSuccess = false;
        $isExists = true;
        $data = null;

        try{
            $data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR)
                ->where([
                    ['KodeSite', '=', $site],
                    // ['JenisPemesanan', '=', $jenis_pemesanan],
                    ['lokasi', '=', $lokasi]
                ]);
            
            Log::info("SQL check mapping exist  : " . $data->toRawSql());

            $data = $data->first();
            if(!$data) $isExists = false;
            // Log::info("exist : " .json_encode($data));
            // if($data) $isExists = false;

        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        
        return [
            'isSuccess' => $isSuccess, 
            'isExists' => $isExists,
            'data' => $data
        ];
    }

    public function AddMappingVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        // {
        //     "site": "AGM",
        //     "lokasi": "MSS/AGM/000003",
        //     "vendor": "002",
        //     "jenisPemesanan": "siang",
        //     "idMapping": "3"
        // }
        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'lokasi' => ['required'], 
                'vendor' => ['required'], 
                // 'jenisPemesanan' => ['required']
            ],
            [
                'site.required' => 'Site wajib diisi',
                'lokasi.required' => 'Lokasi wajib diisi',
                'vendor.required' => 'Vendro wajib diisi',
                // 'jenisPemesanan.required' => 'Waktu Makan wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        $checkMappingExist = $this->checkMappingVendorExist(
            $request->input('vendor'),
            $request->input('site'),
            $request->input('jenisPemesanan'),
            $request->input('lokasi')
        );

        // Log::debug(json_encode($checkMappingExist));

        // if($checkMappingExist['isExists']) {
        //     $message = "Mapping sudah ada";
        //     $errorMessage = $errorList;
        // } else {
            if(count($errorList) > 0) {
                
                $message = "Error mandatory field";
                $errorMessage = $errorList;
    
            } else {
                $data_input = [
                    'KodeSite' => $request->input('site'),
                    'VendorID' => $request->input('vendor'),
                    // 'JenisPemesanan' => $request->input('jenisPemesanan'),
                    'lokasi' => $request->input('lokasi'),
                ];
    
                try {
                    DB::connection(self::DB_CONN_NAME)->beginTransaction();
    
                    $sql_insert_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR)
                        ->insert($data_input);
    
                    DB::connection(self::DB_CONN_NAME)->commit();
                    $message = "Ok";
                    $isSuccess = true;
                } catch (Exception $ex) {

                    $message = "Terjadi kesalahan, coba beberapa saat lagi";
                    $errorMessage = [$message];
    
                    DB::connection(self::DB_CONN_NAME)->rollBack();
    
                    Log::error(get_class($ex). " | ". $ex->getMessage());
                    Log::error($ex->getTraceAsString());
                }
    
            }

        // }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function AddMappingVendorDay(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $tgl = now();
        // {
        //     "site": "AGM",
        //     "lokasi": "MSS/AGM/000003",
        //     "vendor": "002",
        //     "jenisPemesanan": "siang",
        //     "idMapping": "3"
        // }
        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'lokasi' => ['required'], 
                // 'vendor' => ['required'], 
                'jenisPemesanan' => ['required']
            ],
            [
                'site.required' => 'Site wajib diisi',
                'lokasi.required' => 'Lokasi wajib diisi',
                // 'vendor.required' => 'Vendro wajib diisi',
                'jenisPemesanan.required' => 'Waktu Makan wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        // $checkMappingExist = $this->checkMappingVendorExist(
        //     $request->input('vendor'),
        //     $request->input('site'),
        //     $request->input('jenisPemesanan'),
        //     $request->input('lokasi')
        // );

        // Log::debug(json_encode($checkMappingExist));

        // if($checkMappingExist['isExists']) {
        //     $message = "Mapping sudah ada";
        //     $errorMessage = $errorList;
        // } else {
            if(count($errorList) > 0) {
                
                $message = "Error mandatory field";
                $errorMessage = $errorList;
    
            } else {
                $data_input = [
                    'KodeSite' => $request->input('site'),
                    'JenisPemesanan' => $request->input('jenisPemesanan'),
                    'lokasi' => $request->input('lokasi'),
                    'senin' => $request->input('vendorSenin'),
                    'selasa' => $request->input('vendorSelasa'),
                    'rabu' => $request->input('vendorRabu'),
                    'kamis' => $request->input('vendorKamis'),
                    'jumat' => $request->input('vendorJumat'),
                    'sabtu' => $request->input('vendorSabtu'),
                    'minggu' => $request->input('vendorMinggu'),
                    'created_at' => $tgl,
                    'created_by' => $nik_session
                ];
    
                try {
                    DB::connection(self::DB_CONN_NAME)->beginTransaction();
    
                    $sql_insert_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR_DAY)
                        ->insert($data_input);
    
                    DB::connection(self::DB_CONN_NAME)->commit();
                    $message = "Ok";
                    $isSuccess = true;
                } catch (Exception $ex) {

                    $message = "Terjadi kesalahan, coba beberapa saat lagi";
                    $errorMessage = [$message];
    
                    DB::connection(self::DB_CONN_NAME)->rollBack();
    
                    Log::error(get_class($ex). " | ". $ex->getMessage());
                    Log::error($ex->getTraceAsString());
                }
    
            }

        // }
        
        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function EditMappingVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'lokasi' => ['required'], 
                'vendor' => ['required'], 
                'jenisPemesanan' => ['required'],
                'idMapping' => ['required'],
            ],
            [
                'site.required' => 'Site wajib diisi',
                'lokasi.required' => 'Lokasi wajib diisi',
                'vendor.required' => 'Vendro wajib diisi',
                'jenisPemesanan.required' => 'Waktu Makan wajib diisi.',
                'idMapping.required' => 'ID Mapping tidak sesuai wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {

            $data_input = [
                'KodeSite' => $request->input('site'),
                'VendorID' => $request->input('vendor'),
                'JenisPemesanan' => $request->input('jenisPemesanan'),
                'lokasi' => $request->input('lokasi'),
                'updated_at' => now(),
                'updated_by' => $nik_session
            ];

            $checkMappingExist = $this->checkMappingVendorExist(
                $data_input['VendorID'],
                $data_input['KodeSite'],
                $data_input['JenisPemesanan'],
                $data_input['lokasi']
            );

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id_mapping = $request->input('idMapping');

                $sql_insert_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR)
                    ->where('id', $id_mapping)
                    ->update($data_input);

                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Ok";
                $isSuccess = true;
            } catch (Exception $ex) {

                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::connection(self::DB_CONN_NAME)->rollBack();


                Log::error(get_class($ex). " | ". $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);

    }

    public function DeleteMappingVendorDay(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [ 
                'id' => ['required']
            ],
            [
                'id.required' => 'ID Mapping wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id = $request->input("id");

                $sql_delete_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR_DAY)
                    ->where('id', $id)
                    ->delete();
                
                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Berhasil menghapus mapping vendor " . $id;
                $isSuccess = true;

            } catch (Exception $ex) {
                DB::connection(self::DB_CONN_NAME)->rollBack();
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }
    public function DeleteMappingVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [ 
                'id' => ['required']
            ],
            [
                'id.required' => 'ID Mapping wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id = $request->input("id");

                $sql_delete_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR)
                    ->where('id', $id)
                    ->delete();
                
                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Berhasil menghapus mapping vendor " . $id;
                $isSuccess = true;

            } catch (Exception $ex) {
                DB::connection(self::DB_CONN_NAME)->rollBack();
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function DeleteVendor(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = '';
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [ 
                'id' => ['required']
            ],
            [
                'id.required' => 'ID wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;

        } else {
            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id = $request->input("id");

                $sql_delete_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER)
                    ->where('id', $id)
                    ->delete();
                
                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Berhasil menghapus vendor " . $id;
                $isSuccess = true;

            } catch (Exception $ex) {
                DB::connection(self::DB_CONN_NAME)->rollBack();
                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    private function maskEmail($email) {
        // Validasi format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
    
        // Pisahkan bagian lokal dan domain dari email
        list($localPart, $domainPart) = explode('@', $email);
        
        // Masking bagian lokal (tampilkan 3 karakter pertama, sisanya *)
        $maskedLocalPart = substr($localPart, 0, 3) . str_repeat('*', strlen($localPart) - 3);
        
        // Masking bagian domain (tampilkan 2 karakter pertama dan 2 karakter terakhir, sisanya *)
        $domainParts = explode('.', $domainPart);
        $maskedDomain = substr($domainParts[0], 0, 2) . str_repeat('*', strlen($domainParts[0]) - 2);
        
        // Gabungkan kembali domain dan top-level domain (TLD)
        $maskedEmail = $maskedLocalPart . '@' . $maskedDomain . '.' . $domainParts[1];
        
        return $maskedEmail;
    }

    public function DashboardVendorMappingCatering(Request $request) {
        return view('SmartForm::GS/vendor/dashboard-vendor-mapping');
    }
    

    public function ListVendorMappingCatering(Request $request) {
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];
        $isSuccess = false;
        $message = '';
        $errorMessage = '';

        $site = $request->query('query', null); 
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        try {
            $sql_master_data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR . ' as a')
                ->select('a.id', 'b.id as id_vendor', 'a.KodeSite as site', 'a.lokasi', 'b.Nama as nama_vendor', 'c.NamaMess as nama_lokasi')
                ->leftJoin(self::TABLE_MASTER. ' as b' ,'a.VendorID', '=', 'b.id')
                ->leftJoin(self::TABLE_LOKASI. ' as c', 'a.lokasi', '=', 'c.NoDoc');

            if($site) $sql_master_data = $sql_master_data->where('a.KodeSite', $site);

            Log::debug('SQL Vendor Mapping : '. $sql_master_data->toRawSql());

            $jml = $sql_master_data->count();

            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_master_data->skip($offset);
            } else {
                $sql_master_data->skip($offset)->limit($limit);
            }
            $master_data = $sql_master_data->get();
            // foreach($master_data as $data) {
            //     $data->email = $this->maskEmail($data->email);
            // }

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $master_data
            ];

            $message= "Ok";
            $isSuccess = true;
        }  catch (Exception $ex) {
            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';
            $errorMessage = [$message];

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function HelperVendor(Request $request) {
        $vendor = $request->query("query", "");
        $specific_id = $request->query("id", "");
        $filterSite = $request->query("id", "");

        $data = [];

        if(strlen($vendor) > 0) {
            try {
                $data_kamar = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MASTER . ' as a')
                    ->select('a.id', 'a.nama as text')
                    ->leftJoin(self::TABLE_MAPPING_MAKAN_VENDOR . ' as b', 'a.id', '=', 'b.VendorID')
                    ->whereAny([
                        'a.id',
                        'a.nama'
                    ], 'like', '%'. $vendor .'%');
    
                if($filterSite == null || $filterSite == 'null') {
                } else {
                    $data_kamar->where('b.KodeSite', $filterSite);
                }
                Log::debug('SQL : '. $data_kamar->toRawSql());
                $data = $data_kamar->get()->toArray(); 
    
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json(['data' => $data]);
    }

    public function HelperVendorByLokasiAndWaktu(Request $request) {
        $site = $request->query("site", "");
        $lokasi = $request->query("lokasi", "");
        $waktu_pemesanan = $request->query("waktu_pemesanan", "");
        $specific_id = $request->query("id", "");

        $data = [];

        // if(strlen($vendor) > 0) {
            try {
                $data_vendor_by_lokasi_waktu = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR . ' as a')
                    ->select('VendorID as id', 'b.Nama as text')
                    ->leftJoin(self::TABLE_MASTER . ' as b', 'a.VendorID', '=', 'b.id')
                    ->where('a.KodeSite', $site)
                    ->where('a.lokasi', $lokasi);
                    // ->where('a.JenisPemesanan', $waktu_pemesanan);
    
                Log::debug('SQL : '. $data_vendor_by_lokasi_waktu->toRawSql());
                $data = $data_vendor_by_lokasi_waktu->get()->toArray(); 
    
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        // }

        return response()->json(['data' => $data]);
    }

    public function HelperLokasi(Request $request) {
        $query = $request->query("query", "");

        $data = [];
        $new_data = [];
        if(strlen($query) > 2) {
            try {
                $data_kamar = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_LOKASI)
                    ->select('KodeSite as site', 'NoDoc as id', 'NamaMess as text')
                    ->where('KodeSite', $query);
                    // ->whereAny([
                    //     'NoDoc',
                    //     'NamaMess',
                    //     'KodeSite'
                    // ], 'like', '%'. $query .'%');
    
                Log::debug('SQL : '. $data_kamar->toRawSql());
                $data = $data_kamar->get()->toArray(); 

                array_push($new_data, [
                    'id' => 'working',
                    'text' => 'Lapangan / Working'
                ]);
                foreach ($data as $nilai) {
                    array_push($new_data, [
                        'id' => $nilai->id,
                        'text' => $nilai->site . " - " . $nilai->text
                    ]);
                }
    
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json(['data' => $new_data]);
    }

    public function ListVendorMappingCateringDay(Request $request) {
        $data = [
            'total' => 0,
            'totalNotFiltered' => 0,
            'rows' => []
        ];
        $isSuccess = false;
        $message = '';
        $errorMessage = '';

        $site = $request->query('query', null); // Default sort by id
        $sort = $request->query('sort', 'id'); // Default sort by id
        $order = $request->query('order', 'asc'); // Default order is ascending
        $offset = $request->query('offset', 0); // Default offset
        $limit = $request->query('limit', null);

        try {
            $sql_master_data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR_DAY . ' as a')
                ->select('a.id', 'a.KodeSite as site', 'a.JenisPemesanan as waktu_makan', 'a.status',
                        'a.senin', 'b.Nama as senin_nama', 'a.selasa', 'c.Nama as selasa_nama', 
                        'a.rabu', 'd.Nama as rabu_nama', 'a.kamis', 'e.Nama as kamis_nama', 'a.jumat', 'f.Nama as jumat_nama', 
                        'a.sabtu', 'g.Nama as sabtu_nama', 'a.minggu', 'h.Nama as minggu_nama', 'a.lokasi', 'i.NamaMess as nama_lokasi')
                ->leftJoin(self::TABLE_MASTER. ' as b' ,'a.senin', '=', 'b.id')
                ->leftJoin(self::TABLE_MASTER. ' as c' ,'a.selasa', '=', 'c.id')
                ->leftJoin(self::TABLE_MASTER. ' as d' ,'a.rabu', '=', 'd.id')
                ->leftJoin(self::TABLE_MASTER. ' as e' ,'a.kamis', '=', 'e.id')
                ->leftJoin(self::TABLE_MASTER. ' as f' ,'a.jumat', '=', 'f.id')
                ->leftJoin(self::TABLE_MASTER. ' as g' ,'a.sabtu', '=', 'g.id')
                ->leftJoin(self::TABLE_MASTER. ' as h' ,'a.minggu', '=', 'h.id')
                ->leftJoin(self::TABLE_LOKASI. ' as i', 'a.lokasi', '=', 'i.NoDoc');
            if($site) $sql_master_data = $sql_master_data->where('a.KodeSite', $site);

            $jml = $sql_master_data->count();

            if($limit == null || $limit == 'null' || $limit == '') {
                $sql_master_data->skip($offset);
            } else {
                $sql_master_data->skip($offset)->limit($limit);
            }
            Log::debug('SQL Vendor mapping day : ' . $site . '  ' . $sql_master_data->toRawSql());

            $master_data = $sql_master_data->get();
            // foreach($master_data as $data) {
            //     $data->email = $this->maskEmail($data->email);
            // }

            $data = [
                'total' => $jml,
                'totalNotFiltered' => $jml,
                'rows' => $master_data
            ];

            $message= "Ok";
            $isSuccess = true;
        }  catch (Exception $ex) {
            $message = 'Terjadi kesalahan, coba beberapa saat lagi!';
            $errorMessage = [$message];

            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);
    }

    public function EditMappingVendorDay(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'site' => ['required'], 
                'lokasi' => ['required'], 
                'jenisPemesanan' => ['required'],
                'idMapping' => ['required'],
            ],
            [
                'site.required' => 'Site wajib diisi',
                'lokasi.required' => 'Lokasi wajib diisi',
                'jenisPemesanan.required' => 'Waktu Makan wajib diisi.',
                'idMapping.required' => 'ID Mapping tidak sesuai wajib diisi.'
            ]
        );

        $data = $request->input();
        $errorList = $validator->errors()->all();

        if(count($errorList) > 0) {
            
            $message = "Error mandatory field";
            $errorMessage = $errorList;
        
        } else {

            $data_input = [
                'KodeSite' => $request->input('site'),
                'lokasi' => $request->input('lokasi'),
                'JenisPemesanan' => $request->input('jenisPemesanan'),
                'senin' => $request->input('vendorSenin'),
                'selasa' => $request->input('vendorSelasa'),
                'rabu' => $request->input('vendorRabu'),
                'kamis' => $request->input('vendorKamis'),
                'jumat' => $request->input('vendorJumat'),
                'sabtu' => $request->input('vendorSabtu'),
                'minggu' => $request->input('vendorMinggu'),
                'updated_at' => now(),
                'updated_by' => $nik_session
            ];

            // $checkMappingExist = $this->checkMappingVendorExist(
            //     $data_input['VendorID'],
            //     $data_input['KodeSite'],
            //     $data_input['JenisPemesanan'],
            //     $data_input['lokasi']
            // );

            try {
                DB::connection(self::DB_CONN_NAME)->beginTransaction();
                $id_mapping = $request->input('idMapping');

                $sql_insert_vendor = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR_DAY)
                    ->where('id', $id_mapping)
                    ->update($data_input);

                DB::connection(self::DB_CONN_NAME)->commit();
                $message = "Ok";
                $isSuccess = true;
            } catch (Exception $ex) {

                $message = "Terjadi kesalahan, coba beberapa saat lagi";
                $errorMessage = [$message];

                DB::connection(self::DB_CONN_NAME)->rollBack();


                Log::error(get_class($ex). " | ". $ex->getMessage());
                Log::error($ex->getTraceAsString());
            }
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'errorMessage' => $errorMessage,
            'data' => $data
        ]);

    }

    public function toggleMappingDayStatus(Request $request) {
        $isSuccess = false;
        $message = '';
        $errorMessage = [];
        $data = null;
        $traceID = '';
        $nik_session = $request->session()->get('user_id', '');
        $validator = Validator::make(
            $request->all(), 
            [
                'data' => ['required'], 
            ],
            [
                'data.required' => 'Data wajib diisi',
            ]
        );

        try {
            $dataToggled = $request->input('data');
            DB::connection(self::DB_CONN_NAME)->beginTransaction();

            Log::info(json_encode($dataToggled));
            foreach ($dataToggled as $value) {
                DB::connection(self::DB_CONN_NAME)->table(self::TABLE_MAPPING_MAKAN_VENDOR_DAY)
                    ->where('id', $value['id'])
                    ->update(['status' => $value['status']]);
            }

            $isSuccess = true;
            $message = 'Ok';
            DB::connection(self::DB_CONN_NAME)->commit();
        } catch (Exception $ex) {
            $traceID = Str::uuid();
            $message = 'Terjadi kesalahan,coba beberapa saat lagi';
            $errorList[] = $message;
            DB::connection(self::DB_CONN_NAME)->rollBack();
            Log::error('Trace ID ' . $traceID . $ex->getMessage());
            Log::error($ex->getTraceAsString());
        }

        return response()->json([
            'isSuccess' => $isSuccess,
            'message' => $message,
            'error' => [
                'traceID' => $traceID,
                'messages' => $errorMessage
            ],
            'data' => $data
        ]);
    }
}