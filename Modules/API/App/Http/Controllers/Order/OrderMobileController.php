<?php

namespace Modules\API\App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderMobileController extends Controller
{
    private const TABLE_ORDER_MASTER = 'PICA_BETA.dbo.SCT_GS_CT_ORDER_VNDR';
    private const TABLE_ORDER_DETAIL = 'PICA_BETA.dbo.SCT_GS_CT_ORDER_DETAIL';
    private const TABLE_VENDOR_MASTER = 'PICA_BETA.dbo.SCT_GS_VENDOR_MST';
    private const TABLE_MAPPING_VENDOR = 'PICA_BETA.dbo.SCT_GS_VENDOR_MAPPING';

    public function index(Request $request)
    {
        $isSuccess = true;
        $message = 'Berhasil!';
        $errorMessage = [];
        $httpRespCode = 200;

        $filterStatus = $request->get('status');
        $filterText = $request->get('keyword');

        $emailFromToken = $request->get('email_from_token');
        $user = DB::table(self::TABLE_VENDOR_MASTER)
            ->where('Email', $emailFromToken)->first();

        $data = DB::table(self::TABLE_ORDER_MASTER)
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

        $order = DB::table(self::TABLE_ORDER_MASTER)
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

            $user = DB::table(self::TABLE_VENDOR_MASTER)
                ->where('Email', $emailFromToken)->first();

            $order->details = DB::table(self::TABLE_ORDER_DETAIL)->select(self::TABLE_ORDER_DETAIL . '.lokasi', self::TABLE_ORDER_DETAIL . '.jumlah')
                ->join(self::TABLE_MAPPING_VENDOR, self::TABLE_MAPPING_VENDOR . '.id', '=', 'id_mapping_vendor')
                ->where('id_order', $order->kode_pemesanan)->where('VendorID', $user->id)
                ->orderBy(self::TABLE_ORDER_DETAIL . '.created_at', 'ASC')->get();

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
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'in' => 'Nilai kolom :attribute tidak valid'
        ]);

        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        $order = DB::table(self::TABLE_ORDER_MASTER)
            ->where('id', $request->id)->first();

        if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();
        } else if(!$order) {
            $errorMessage[] = 'Data order tidak ditemukan';

        } else {
            DB::table(self::TABLE_ORDER_MASTER)
                ->where('id', $request->id)
                ->update([
                    'status' => $request->status
                ]);

            $isSuccess = true;
            $httpRespCode = 200;
            $message = 'Berhasil!';
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
}
