<?php

namespace Modules\API\App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderMobileController extends Controller
{
    private const DB_CONN = 'sqlsrv';
    private const TABLE_ORDER_MASTER = 'SCT_GS_CT_ORDER_VNDR';
    private const TABLE_ORDER_DETAIL = 'SCT_GS_CT_ORDER_DETAIL';
    private const TABLE_VENDOR_MASTER = 'SCT_GS_VENDOR_MST';
    private const TABLE_MAPPING_VENDOR_DAY = 'SCT_GS_VENDOR_MAPPING_DAY';
    private const TABLE_MESS_MASTER = 'SCT_GS_MESS_MST';

    public function index(Request $request)
    {
        $isSuccess = true;
        $message = 'Berhasil!';
        $errorMessage = [];
        $httpRespCode = 200;

        $filterStatus = $request->get('status');
        $filterText = $request->get('keyword');

        $emailFromToken = $request->get('email_from_token');
        $user = DB::connection(self::DB_CONN)->table(self::TABLE_VENDOR_MASTER)
            ->where('Email', $emailFromToken)->first();

        $data = DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_MASTER)
            ->select(['id', 'kode_pemesanan', 'jumlah', 'status', 'created_at', 'JenisPemesanan', 'KodeSite', 'TanggalOrder'])
            ->where('VendorID', $user->id)
            ->when($filterStatus, function($q) use($filterStatus) {
                $q->where('status', $filterStatus);
            })
            ->when($filterText, function($q) use($filterText) {
                $q->where( function($sq) use($filterText) {
                    $sq->where('kode_pemesanan', $filterText)
                        ->orWhere('KodeSite', $filterText);
                });
            })
            ->orderBy('created_at', 'DESC')->get()
            ->map( function($order) {
                $splitCreatedAt = explode(' ', $order->created_at);
                preg_match('/^[0-9]+:[0-9]+/', $splitCreatedAt[1], $matchCreated);

                $order->Jam = $matchCreated[0];
                return $order;
            });

        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message,
                'errorMessage' => $errorMessage,
                'data' => $data
            ],
            $httpRespCode,
            [
                'X-CSRF-TOKEN' => csrf_token()
            ]
        );
    }

    public function detail($id, Request $request)
    {
        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        $order = DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_MASTER)
            ->where('id', $id)->first();

        if(!$order) {
            $errorMessage[] = 'Data order tidak ditemukan';

        } else {
            $isSuccess = true;
            $httpRespCode = 200;
            $message = 'Berhasil!';

            $splitCreatedAt = explode(' ', $order->created_at);
                preg_match('/^[0-9]+:[0-9]+/', $splitCreatedAt[1], $matchCreated);

            $order->Jam = $matchCreated[0];
            $emailFromToken = $request->get('email_from_token');

            $user = DB::connection(self::DB_CONN)->table(self::TABLE_VENDOR_MASTER)
                ->where('Email', $emailFromToken)->first();

            $day = strtr( date('D', strtotime($order->TanggalOrder)), [
                'Mon' => 'senin',
                'Tue' => 'selasa',
                'Wed' => 'rabu',
                'Thu' => 'kamis',
                'Fri' => 'jumat',
                'Sat' => 'sabtu',
                'Sun' => 'minggu',
            ]);

            $order->details = DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_DETAIL)
                ->select(self::TABLE_ORDER_DETAIL . '.id', self::TABLE_MESS_MASTER . '.NamaMess AS lokasi', self::TABLE_ORDER_DETAIL . '.jumlah', self::TABLE_ORDER_DETAIL . '.status', 'file_evidence')
                // ->leftJoin(self::TABLE_MAPPING_VENDOR_DAY, self::TABLE_MAPPING_VENDOR_DAY . '.id', '=', self::TABLE_ORDER_DETAIL . '.id_mapping_vendor')
                ->leftJoin(self::TABLE_MESS_MASTER, self::TABLE_MESS_MASTER . '.NoDoc', '=', self::TABLE_ORDER_DETAIL . '.lokasi')
                ->where('id_order', $order->kode_pemesanan)
                ->where('id_vendor', $user->id)
                // ->where( function($sq) use($day, $user) {
                //     $sq->where($day, $user->id)
                //         ->orWhere(self::TABLE_ORDER_DETAIL . '.lokasi', 'working');
                // })
                ->orderBy(self::TABLE_ORDER_DETAIL . '.created_at', 'ASC')
                ->get()->map( function($item) {
                    if(empty($item->lokasi)) $item->lokasi = 'Lapangan';
                    $item->file_evidence = !empty($item->file_evidence) ? url('storage/' . $item->file_evidence) : null;

                    return $item;
                });

            $data = $order;
        }

        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message,
                'errorMessage' => $errorMessage,
                'data' => $data
            ],
            $httpRespCode,
            [
                'X-CSRF-TOKEN' => csrf_token()
            ]
        );
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:Pesanan Baru,Dalam Proses,Selesai',
            'file_evidence' => !empty($request->id_detail) && $request->status == 'Selesai' ? 'required|file|mimes:jpg,jpeg,png' : ''
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'in' => 'Nilai kolom :attribute tidak valid'
        ]);

        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        $order = DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_MASTER)
            ->where('id', $request->id)->first();

        if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();
        } else if(!$order) {
            $errorMessage[] = 'Data order tidak ditemukan';

        } else {
            try {
                $emailFromToken = $request->get('email_from_token');
                $user = DB::connection(self::DB_CONN)->table(self::TABLE_VENDOR_MASTER)
                    ->where('Email', $emailFromToken)->first();

                $day = strtr( date('D', strtotime($order->TanggalOrder)), [
                    'Mon' => 'senin',
                    'Tue' => 'selasa',
                    'Wed' => 'rabu',
                    'Thu' => 'kamis',
                    'Fri' => 'jumat',
                    'Sat' => 'sabtu',
                    'Sun' => 'minggu',
                ]);

                if(!empty($request->id_detail)) {
                    DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_DETAIL)->where('id', $request->id_detail)->update([
                        'status' => $request->status,
                    ]);

                    if($request->status == 'Selesai') {
                        $filePath = $request->file('file_evidence')->store('catering-evidence');

                        DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_DETAIL)
                            ->where('id', $request->id_detail)
                            ->where('id_order', $order->kode_pemesanan)
                            ->update([
                                'file_evidence' => $filePath,
                                'status' => $request->status
                            ]);

                        $progressItem = DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_DETAIL)
                            // ->join(self::TABLE_MAPPING_VENDOR_DAY, self::TABLE_MAPPING_VENDOR_DAY . '.id', '=', 'id_mapping_vendor')
                            ->where('id_order', $order->kode_pemesanan)
                            ->where('id_vendor', $user->id)
                            // ->where($day, $user->id)
                            ->where(self::TABLE_ORDER_DETAIL . '.id', '!=', $request->id_detail)
                            ->where('status', 'Dalam Proses')->count(self::TABLE_ORDER_DETAIL . '.id');

                        if($progressItem == 0) {
                            DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_MASTER)
                                ->where('id', $request->id)
                                ->update([
                                    'status' => 'Selesai'
                                ]);

                            $order->status = 'Selesai';
                        }
                    }

                } else {
                    DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_MASTER)
                        ->where('id', $request->id)
                        ->update([
                            'status' => $request->status
                        ]);

                    if($request->status == 'Dalam Proses') {
                        DB::connection(self::DB_CONN)->table(self::TABLE_ORDER_DETAIL)
                            // ->leftJoin(self::TABLE_MAPPING_VENDOR_DAY, self::TABLE_MAPPING_VENDOR_DAY . '.id', '=', 'id_mapping_vendor')
                            ->where('id_order', $order->kode_pemesanan)
                            ->where('id_vendor', $user->id)
                            // ->where( function($sq) use($day, $user) {
                            //     $sq->where($day, $user->id)
                            //         ->orWhere(self::TABLE_ORDER_DETAIL . '.lokasi', 'working');
                            // })
                            ->update(['status' => 'Dalam Proses']);
                    }

                    $order->status = $request->status;
                }

                DB::commit();
                $isSuccess = true;
                $httpRespCode = 200;
                $message = 'Berhasil!';
                $data = $order;

            } catch(Exception $e) {
                DB::rollBack();
            }
        }

        return response()->json(
            [
                'isSuccess' => $isSuccess,
                'message' => $message,
                'errorMessage' => $errorMessage,
                'data' => $data
            ],
            $httpRespCode,
            [
                'X-CSRF-TOKEN' => csrf_token()
            ]
        );
    }
}
