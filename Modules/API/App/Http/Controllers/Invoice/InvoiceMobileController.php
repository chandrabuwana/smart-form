<?php

namespace Modules\API\App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InvoiceMobileController extends Controller
{
    private const TABLE_VENDOR_MASTER = 'SCT_GS_VENDOR_MST';
    private const TABLE_INVOICE_MASTER = 'SCT_GS_INVOICE_MST';
    private const TABLE_INVOICE_DOCS = 'SCT_GS_INVOICE_DOCS';
    private const DB_CONN_NAME = 'sqlsrv';

    public function index(Request $request) {
        $isSuccess = true;
        $message = 'Berhasil!';
        $errorMessage = [];
        $httpRespCode = 200;

        $filterStatus = $request->get('status');
        $filterText = $request->get('keyword');

        $data = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_MASTER)
            ->select(['invoice_code', 'invoice_name', 'service_type', 'total_price', 'status', 'invoice_date', 'payment_due'])
            ->when($filterStatus, function($q) use($filterStatus) {
                $q->where('status', $filterStatus);
            })
            ->when($filterText, function($q) use($filterText) {
                $q->where( function($sq) use($filterText) {
                    $sq->where('invoice_code', $filterText)
                        ->orWhere('invoice_name', $filterText);
                });
            })
            ->orderBy('created_at', 'DESC')->get();

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

    public function statistics()
    {
        $isSuccess = true;
        $message = 'Berhasil!';
        $errorMessage = [];
        $httpRespCode = 200;

        $data = [
            [
                'status' => 'Menunggu Konfirmasi',
                'count_invoice' => 0
            ],
            [
                'status' => 'Menunggu Pembayaran',
                'count_invoice' => 0
            ],
            [
                'status' => 'Sudah Dibayar',
                'count_invoice' => 0
            ],
            [
                'status' => 'Pembayaran Dihold',
                'count_invoice' => 0
            ],
        ];

        DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_MASTER)
            ->selectRaw('status, COUNT(invoice_code) AS count_invoice')
            ->groupBy('status')->get()->each( function($item) use(&$data) {
                $data = array_map(function($value) use($item) {
                    if($value['status'] == $item->status) {
                        $value['count_invoice'] = $item->count_invoice;
                    }

                    return $value;
                }, $data);
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

    private function _getInvoiceCode() {
        $lastInvoice = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_MASTER)
            ->select('invoice_code')->orderBy('created_at', 'DESC')->first();
        if(!is_null($lastInvoice)) {
            $lastCount = substr($lastInvoice->invoice_code, 5);
            $nextCount = (int) $lastCount;
        } else {
            $nextCount = 1;
        }

        return 'INV/' . date('Ym') . str_pad($nextCount, 5, '0', STR_PAD_LEFT);
    }

    public function store(Request $request) {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'invoice_name' => 'required',
            'service_type' => 'required',
            'total_price' => 'required',
            'invoice_date' => 'required',
            // 'payment_due' => 'required',
            'file_pendukung' => 'required|array',
            'file_pendukung.*' => 'file|mimes:jpg,jpeg,png'
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();

        } else {
            $httpRespCode = 200;
            DB::beginTransaction();

            try {
                $emailFromToken = $request->get('email_from_token');
                $user = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_VENDOR_MASTER)
                    ->where('Email', $emailFromToken)->first();

                $invoiceCode = $this->_getInvoiceCode();

                $payload = [
                    'invoice_code' => $invoiceCode,
                    'invoice_name' => $request->input('invoice_name'),
                    'service_type' => $request->input('service_type'),
                    'total_price' => $request->input('total_price'),
                    'status' => 'Menunggu Konfirmasi',
                    'invoice_date' => $request->input('invoice_date'),
                    // 'payment_due' => $request->input('payment_due'),
                    'created_at' => now(),
                    'created_by' => $user->id
                ];

                DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_MASTER)->insert($payload);

                foreach($request->file_pendukung as $docs) {
                    $filePath = $docs->store('invoice-file-pendukung');
                    $fileName = $docs->getClientOriginalName();

                    $payloadDocs = [
                        'invoice_code' => $invoiceCode,
                        'file_name' => $fileName,
                        'file_size' => $docs->getSize(),
                        'file_url' => $filePath,
                        'created_at' => now(),
                        'created_by' => $user->id
                    ];

                    DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_DOCS)->insert($payloadDocs);
                }

                DB::commit();
                $data = $payload;
                $isSuccess = true;
                $message = 'Berhasil!';

            } catch (Exception $ex) {
                Log::error($ex->getMessage());
                Log::error($ex->getTraceAsString());

                $errorMessage = [
                    'Terjadi Kesalahan, coba beberapa saat lagi'
                ];
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

    public function detail(Request $request) {

        $validator = Validator::make($request->all(), [
            'invoice_code' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        $httpRespCode = 401;
        $isSuccess = false;
        $message = "";
        $errorMessage = [];
        $data = null;

        $invoice = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_MASTER)
            ->where('invoice_code', $request->invoice_code)->first();

        if(count($validator->errors()) > 0) {
            $errorMessage = $validator->errors()->all();
        } else if(!$invoice) {
            $errorMessage[] = 'Data invoice tidak ditemukan';

        } else {
            $isSuccess = true;
            $httpRespCode = 200;
            $message = 'Berhasil!';

            $invoice->documents = DB::connection(self::DB_CONN_NAME)->table(self::TABLE_INVOICE_DOCS)
                ->where('invoice_code', $request->invoice_code)->get()->map( function($item) {
                    $item->file_url = url('storage/' . $item->file_url);
                    return $item;
                });

            $data = $invoice;
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
